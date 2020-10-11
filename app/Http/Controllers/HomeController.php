<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
use App\Category;
use App\Inquiry;
use App\Jobs\SendEmailJob;
use App\Order;
use App\Product;
use App\Service;
use App\Slider;
use Validator;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class HomeController extends Controller
{
    public function index()
    {

        $services = Service::orderBy('created_at','desc')->get();
        // $products = new Collection();
        $categories = Category::orderBy('created_at','asc')->get();
        // foreach ($categories as $category) {
        //     $item = Product::where('category_id', $category->id)->first();
        //     if ($item != null) {
        //         $products->push($item);
        //     }
        // }

        $sliders = Slider::all();
        return view('frontend.index', compact('services', 'categories', 'sliders'));
    }

    public function singleService($id)
    {
        $services = Service::all();
        $singleService = Service::find($id);
        $serviceProducts = Product::where('service_id', $id)->get();
        // dd($singleService);
        return view('frontend.single-service', compact('services', 'singleService', 'serviceProducts'));
    }

    public function Contact()
    {
        return view('frontend.contact');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function enquiry()
    {
        $services = Service::all();
        return view('frontend.enquiry', compact('services'));
    }

    public function submitEnquiry(Request $request)
    {
        $rules = [
            'contact_person' => 'required',
            // 'business_name' => 'required',
            'street_address' => 'required',
            // 'street_address2' => 'required',
            'country' => 'required',
            'city' => 'required',
            // 'zip_code' => 'required',
            'tel' => 'required',
            // 'fax' => 'required',
            // 'website' => 'required',
            'email' => 'required',
            // 'service' => 'required',

        ];

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response(['errors' => $error->errors()->all(),], Response::HTTP_OK);
        }

        $Inquiry = new Inquiry();
        $Inquiry->request_service = $request->service;
        $Inquiry->contact_person = $request->contact_person;
        $Inquiry->business_name = $request->business_name;
        $Inquiry->street_address1 = $request->street_address;
        $Inquiry->street_address2 = $request->street_address2;
        $Inquiry->country = $request->country;
        $Inquiry->City = $request->city;
        $Inquiry->Zip_code = $request->zip_code;
        $Inquiry->tel = $request->tel;
        $Inquiry->fax = $request->fax;
        $Inquiry->website = $request->website;
        $Inquiry->email = $request->email;
        $Inquiry->is_current_customer = $request->current_customer;
        $Inquiry->referral = $request->referral;
        $Inquiry->message = $request->message;
        if ($request->hasFile('attachment')) {
            $destination = '/EnquiryFiles';
            $Inquiry->attachment = $this->generateUniqueFileName($request->attachment, $destination);
        }




        if ($Inquiry->save()) {
            //sendmail to user
            $details = [
                'email' => $request->email,
                'from' => 'macrolanltd@gmail.com',
                'subject' => 'Macrolan Enquiry',
                'message' => 'It was a pleasure to receive your enquiry about the products of our company. We will get back to you soon.',
                'type' => 'user'
            ];

            //user send email to admin
            $details1 = [
                'email' => 'macrolanltd@gmail.com',
                'from' => 'enquiries@macrolankenya.co.ke',
                'subject' => 'New Enquiry',
                'message' => 'New Enquiry from ' . $request->email,
                'type' => 'admin',
            ];

            dispatch(new SendEmailJob($details));

            dispatch(new SendEmailJob($details1));
            return response(['success' => "Enquiry submited successful",], Response::HTTP_OK);
        } else {
            return response(['errors' => "Failed! Please try again later!",], Response::HTTP_OK);
        }
    }

    public function shop()
    {
        // $allProducts = Product::orderBy('id', 'asc')
        //     ->paginate(20);
        $categories = Category::with('products')->has('products')->orderBy('created_at','asc')->get();
        return view('frontend.shop', compact('categories'));
    }

    public function productCategory($category_id)
    {

        $allProducts = Product::orderBy('id', 'asc')
            ->where('category_id', $category_id)
            ->paginate(20);
        $category = Category::where('id', $category_id)->pluck('category')->first();
        return view('frontend.category', compact('allProducts', 'category'));
    }

    public function singleProduct($id)
    {
        $single_products = Product::with('category')->where('id', $id)->get();
        $category_id = Product::where('id', $id)->pluck('category_id')->first();
        $related_products = Product::where('category_id', $category_id)->get();
        return view('frontend.single-product', compact('single_products', 'related_products'));
    }

    public function cart(Request $request)
    {

        if (!Auth::check()) {
            // return view('frontend.index', compact('totalamount')); 
            return back();
        } else {

            $totalamount = 0;

            $user_id = Auth::user()->id;
            $cart_id = session()->get('cart');
            $newCartId = Cart::where(
                [
                    'user_id' => $user_id,
                    'status' => 1,
                    // 'id' => $cart_id,
                ]
            )->pluck('id')->first();
            // return $newCartId;
            $cart_products = CartProduct::join('products', 'cart_products.product_id', '=', 'products.id')
                ->join('product_photos', 'products.id', '=', 'product_photos.product_id')
                ->where('cart_id', $newCartId)
                ->where('product_photos.type', '=', 'main_image')
                ->select([
                    'product as product',
                    'quantity as quantity',
                    'cart_products.id as id',
                    'image_path as image_path',
                ])->get();
            // return $cart_products;


            if ($request->ajax()) {

                return Datatables::of($cart_products)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '<a class="btn btn-danger deleteme"   data-id="' . $data->id . '"><i class="fa fa-trash"></i></a>';
                    })
                    // ->addColumn('total', function ($data) {
                    //     return $data->price * $data->cartproducts['0']->quantity;
                    // })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            // return $newproductarray;
            // return view('frontend.cart', compact('totalamount'));
            return view('frontend.cart');
        }
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function singleOrder($id)
    {
        $totalamount = 0;
        $user_id = Auth::user()->id;
        $cart_id = Order::where(
            'user_id',
            $user_id
        )
            ->where('id', $id)
            ->pluck('cart_id')->first();
        $cart_products = CartProduct::where('cart_id', $cart_id)->get();
        // dd($cart_products);

        // $productsarray = [];
        // foreach ($product_ids as $product_id) {
        //     //    $products = DB::table('products')->where('id',$product_id)->get();
        //     $products = Product::with('cartproducts', 'productphotos')->where('id', $product_id)->get();
        //     $productsarray[] = $products;
        // }

        // // dd($product_ids);
        // $products = [];
        // foreach ($productsarray as $products) {
        //     foreach ($products as $product) {
        //         $newproductarray[] = $product;
        //         $totalamount += $product->price * $product->cartproducts['0']->quantity;
        //     }
        // }

        // dd($newproductarray);

        return view('frontend.orders', compact('cart_products'));
    }
    public function allorders()
    {
        $totalamount = 0;
        $user_id = Auth::user()->id;
        $cart_ids = [];
        $orders = Order::with('cart')->where([
            'user_id' => $user_id,
        ])->get();

        // dd($orders);
        // foreach ($orders as $order) {
        //     $cart_id= $order->cart->id;
        // }
        // $cart_ids = $cart_id;
        // $product_ids = [];
        // foreach ($cart_ids as $cart_id) {

        //     $product_id = DB::table('cart_products')->where('cart_id', $cart_id)->pluck('product_id');
        //     $product_ids[] = $product_id;
        // }

        // $productsarray = [];
        // foreach ($product_ids as $product_id) {
        //     //    $products = DB::table('products')->where('id',$product_id)->get();
        //     $products = Product::with('cartproducts', 'productphotos')->where('id', $product_id)->get();
        //     $productsarray[] = $products;
        // }

        // dd($productsarray);
        // $newproductarray = [];
        // foreach ($productsarray as $products) {
        //     foreach ($products as $product) {
        //         $newproductarray[] = $product;
        //         $totalamount += $product->price * $product->cartproducts['0']->quantity;
        //     }
        // }

        return view('frontend.all_orders', compact('orders'));
    }

    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    public function getProducts(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $products = Product::orderby('product', 'asc')
                ->select("id", "product")
                ->limit(15)
                ->get();
        } else {
            $products = Product::orderby('product', 'asc')
                ->select("id", "product")
                ->where('product', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search%")
                ->limit(15)
                ->get();
        }
        $response = [];
        foreach ($products as $product) {
            $response[] = [
                "id" => $product->id,
                "text" => $product->product,
            ];
        }
        return response($response, Response::HTTP_OK);
    }

    public function generateUniqueFileName($file, $destinationPath)
    {
        $initial = "macrolan_";
        $name = $initial . bin2hex(random_bytes(8)) . time() . '.' . $file->getClientOriginalExtension();
        if ($file->move(public_path() . $destinationPath, $name)) {
            return $name;
        } else {
            return null;
        }
    }
}
