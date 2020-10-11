<?php

namespace App\Http\Controllers;

use App\ServiceProduct;
use Illuminate\Http\Request;
use App\Service;
use App\ServiceProductPhoto;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Yajra\Datatables\Datatables;

class ServiceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $services = Service::all();
        if ($request->ajax()) {
            $product = ServiceProduct::with('service')->get();
            return Datatables::of($product)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="productdelete(\'' . $data->id . '\')"><i class="icon-trash"></i></a>&nbsp;&nbsp;<a class="btn btn-outline-warning btn-round waves-effect waves-light name="edit" href="' . route('serviceProduct.edit', $data->id) . '" id="' . $data->id . '" ><i class="ti-pencil"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // dd($services);
        return view('admin.serviceproducts.index', compact('services'));
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
                'service_id' => 'required',
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
            $product = new ServiceProduct();
            $product->service_id = $request->service_id;
            $product->product = $request->product;
            // $product->price = $request->price;
            $product->description = $request->description;
            if ($product->save()) {

                $service_product_id = $product->id;
                $product_image = new ServiceProductPhoto();
                $product_image->service_product_id = $service_product_id;
                $product_image->image_path = $imgname;
                $product_image->type = "main_image";
                $product_image->save();

                foreach ($gallerarray as $img) {
                    $product_image = new ServiceProductPhoto();
                    $product_image->service_product_id = $service_product_id;
                    $product_image->image_path = $img;
                    $product_image->type = "gallery";
                    $product_image->save();
                }
                return response(['success' => 'ServiceProduct  created Succesfully',
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
     * @param  \App\ServiceProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceProduct $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $services = Service::all();
        $products = ServiceProduct::where('id', $id)->get();
        $photos = ServiceProductPhoto::where('service_product_id', $id)->get();

        return view('admin.serviceproducts.edit', compact('services', 'products', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->price);
        $rules = [
            'service_id' => 'required',
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
                $product_image = new ServiceProductPhoto();
                $product_image->service_product_id = $id;
                $product_image->image_path = $imgname;
                $product_image->type = "main_image";
                $product_image->save();
        }

        if ($request->hasfile('gallery')) {

            foreach ($request->file('gallery') as $image) {
                $galleryname = $this->generateUniqueFileName($image, $imgdestination);
                $gallerarray[] = $galleryname;
            }

            foreach ($gallerarray as $img) {
                $product_image = new ServiceProductPhoto();
                $product_image->service_product_id = $id;
                $product_image->image_path = $img;
                $product_image->type = "gallery";
                $product_image->save();
                // ServiceProductPhoto::where('service_product_id', $id)
                //     ->where('type', '=', 'gallery')
                //     ->update([
                //         'image_path' => $img,
                //     ]);
            }
        }
        $product= ServiceProduct::find($id);
        $product->service_id = $request->service_id;
        $product->product = $request->product;
        // $product->price = $request->price;
        $product->description = $request->description;
        if ($product->update()) {
            return response(['success' => 'ServiceProduct Updated Succesfully',
                 ], Response::HTTP_OK);
        } else {
            return response(['warning' => 'ServiceProduct not Updated!',
                ], Response::HTTP_OK);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceProduct  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $service_product_id = $request->service_product_id;
            $product = ServiceProduct::find($service_product_id);
            if ($product) {
                $product->delete();
                return response([
                    'success' => 'ServiceProduct  deleted Succesfully',
                ], Response::HTTP_OK);
            } else {
                return response(['warning' => 'ServiceProduct  not deleted',
                ], Response::HTTP_OK);
            }
        }
    }
    public function photoDestroy(Request $request)
    {
        $photo_id = $request->photo_id;
        if (ServiceProductPhoto::where('id', $photo_id)->delete()) {
            return response(['success' => 'Photo  deleted Succesfully',
            ], Response::HTTP_OK);
        } else {
            return response(['warning' => 'Photo not deleted ',
            ], Response::HTTP_OK);
        }
    }
}
