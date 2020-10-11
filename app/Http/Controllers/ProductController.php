<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $categories = Category::all();
        if ($request->ajax()) {
            $product = Product::with('category')->get();
            return Datatables::of($product)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="productdelete(\'' . $data->id . '\')"><i class="icon-trash"></i></a>&nbsp;&nbsp;<a class="btn btn-outline-warning btn-round waves-effect waves-light name="edit" href="' . route('product.edit', $data->id) . '" id="' . $data->id . '" ><i class="ti-pencil"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // dd($categories);
        return view('admin.product.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            # code...
            $rules = [
                'category_id' => 'required',
                'product' => 'required',
                'description' => 'required',
                // 'price' => 'required',
                'main_image' => 'required|mimes:jpeg,png,jpg|max:4048',
                'gallery' => 'required',

            ];

            $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
                return response(['errors' => $error->errors()->all(),
                ], Response::HTTP_OK);
            }

            $imgdestination = '/Macrolan_Products';
            $gallerarray = [];
            if ($request->hasfile('main_image')) {
                $productimages = $request->file('main_image');
                $imgname = $this->generateUniqueFileName($productimages, $imgdestination);
            }

            if ($request->hasfile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $galleryname = $this->generateUniqueFileName($image, $imgdestination);
                    $gallerarray[] = $galleryname;
                }
            }
            $product = new Product();
            $product->category_id = $request->category_id;
            $product->product = $request->product;
            // $product->price = $request->price;
            $product->description = $request->description;
            if ($product->save()) {

                $product_id = $product->id;
                $product_image = new ProductPhoto();
                $product_image->product_id = $product_id;
                $product_image->image_path = $imgname;
                $product_image->type = "main_image";
                $product_image->save();

                foreach ($gallerarray as $img) {
                    $product_image = new ProductPhoto();
                    $product_image->product_id = $product_id;
                    $product_image->image_path = $img;
                    $product_image->type = "gallery";
                    $product_image->save();
                }
                return response(['success' => 'Product  created Succesfully',
                ], Response::HTTP_OK);
            }
    }
    public function generateUniqueFileName($image, $destinationPath)
    {
        $initial = "Macrolan";
        $random = Str::random();
        $name = $initial . $random . time() . '.' . $image->getClientOriginalExtension();
        if ($image->move(public_path() . $destinationPath, $name)) {
            return $name;
        } else {
            return null;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $categories = Category::all();
        $products = Product::where('id', $id)->get();
        $photos = ProductPhoto::where('product_id', $id)->get();

        return view('admin.product.edit', compact('categories', 'products', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->price);
        $rules = [
            'category_id' => 'required',
            'product' => 'required',
            'description' => 'required',
            // 'price' => 'required',
            // 'main_image' => 'mimes:jpeg,png,jpg|max:4048',
            // 'gallery' => 'mimes:jpeg,png,jpg|max:4048',

        ];

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response(['errors' => $error->errors()->all()], Response::HTTP_OK);
        }

        $imgdestination = '/Macrolan_Products';
        $gallerarray = [];

        if ($request->hasfile('main_image')) {
            $productimages = $request->file('main_image');
                $imgname = $this->generateUniqueFileName($productimages, $imgdestination);
                $main_image=ProductPhoto::where('product_id',$id)->pluck('main_image')->count();

                $product_image = new ProductPhoto();
                $product_image->product_id = $id;
                if ($main_image<=0) {
                    $product_image->image_path = $imgname;
                    $product_image->type = "main_image";
                    $product_image->save();
                }else {
                    ProductPhoto::where('product_id',$id)
                    ->where('type','main_image')->update([
                        'type'=>'main_image',
                        'image_path'=>$imgname
                    ]);
                }
               
        }

        if ($request->hasfile('gallery')) {

            foreach ($request->file('gallery') as $image) {
                $galleryname = $this->generateUniqueFileName($image, $imgdestination);
                $gallerarray[] = $galleryname;
            }

            foreach ($gallerarray as $img) {
                $product_image = new ProductPhoto();
                $product_image->product_id = $id;
                $product_image->image_path = $img;
                $product_image->type = "gallery";
                $product_image->save();
                // ProductPhoto::where('product_id', $id)
                //     ->where('type', '=', 'gallery')
                //     ->update([
                //         'image_path' => $img,
                //     ]);
            }
        }
        $product= Product::find($id);
        $product->category_id = $request->category_id;
        $product->product = $request->product;
        // $product->price = $request->price;
        $product->description = $request->description;
        if ($product->update()) {
            return response(['success' => 'Product Updated Succesfully',
                 ], Response::HTTP_OK);
        } else {
            return response(['warning' => 'Product not Updated!',
                ], Response::HTTP_OK);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->product_id;
            $product = Product::find($product_id);
            if ($product) {
                $product->delete();
                return response([
                    'success' => 'Product  deleted Succesfully',
                ], Response::HTTP_OK);
            } else {
                return response(['warning' => 'Product  not deleted',
                ], Response::HTTP_OK);
            }
        }
    }
    public function photoDestroy(Request $request)
    {
        $photo_id = $request->photo_id;
        if (ProductPhoto::where('id', $photo_id)->delete()) {
            return response(['success' => 'Photo  deleted Succesfully',
            ], Response::HTTP_OK);
        } else {
            return response(['warning' => 'Photo not deleted ',
            ], Response::HTTP_OK);
        }
    }
}
