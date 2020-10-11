<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\CartProduct;
use App\Jobs\SendEmailJob;
use App\ShippingAdress;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::with('cart')->with('user')->with('shippingadress')->get();
        // dd($orders);
        if ($request->ajax()) {


            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-outline-danger btn-round waves-effect waves-light name="delete" id="' . $data->id . '" onclick="servicedelete(\'' . $data->id . '\')"><i class="icon-trash"></i></a>&nbsp;&nbsp;<a class="btn btn-outline-warning btn-round waves-effect waves-light name="edit" href="' . route('singleBackendkOrder', $data->id) . '" id="' . $data->id . '" ><i class="ti-pencil"></i></a>';
                })
                ->addColumn('orderstatus', function ($data) {
                    if ($data->status == '1') {
                        return '<a class="btn btn-outline-success btn-round waves-effect waves-light dropdown-toggle"        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Completed </a><div class="dropdown-menu"><a class="dropdown-item" data-id="" onclick="Completed(\'' . $data->id . '\')">Activate </a><a class="dropdown-item" onclick="Inprogress(\'' . $data->id . '\')">Pending</a>    </div>';
                    } elseif ($data->status == '0') {

                        return '<a class="btn btn-outline-danger btn-round waves-effect waves-light dropdown-toggle"        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pending </a><div class="dropdown-menu"><a class="dropdown-item" data-id="" onclick="Completed(\'' . $data->id . '\')">Activate </a><a class="dropdown-item" onclick="Inprogress(\'' . $data->id . '\')">Completed</a>  </div>';
                    }
                })

                ->rawColumns(['action', 'orderstatus'])
                ->make(true);
        }



        return view('admin.order.index');
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

    public function singleBackendkOrder($id)
    {
        $totalamount = 0;
        // $user_id = Auth::user()->id;
        $cart_id = Order::where('id', $id)
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

        return view('admin.order.singleOrder', compact('cart_products'));
    }

    public function placeOrder(Request $request)
    {

        $cart_id = session()->get('cart');
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->cart_id = $cart_id;
        $order->amount = $request->amount;
        $order->status = 1;
        if ($order->save()) {
            $order_id = $order->id;
            $shipping = new ShippingAdress;
            $shipping->order_id = $order_id;
            $shipping->country = $request->country;
            $shipping->city = $request->city;
            $shipping->description = $request->description;
            $shipping->phone = $request->phone;
            if ($shipping->save()) {
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
                Cart::where('id', $cart_id)->update([
                    'status' => 2
                ]);
                $request->session()->forget('cart');
                $request->session()->forget('product_quantities');
                return back()->with('success', 'Your request is successfully sent.');
            }
        }
    }

    public function changeStatus(Request $request)
    {
        $rules = [
            'order_id' => 'required',
            'status' => 'required',

        ];

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response([
                'errors' =>  $error->errors()->all()
            ], Response::HTTP_OK);
        }

        $order_id = $request->order_id;
        $status = $request->status;

        Order::where('id', '=', $order_id)->update([
            'status' => $status,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
