<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
use App\Product;
use Auth;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }
    public function cartUpdate(Request $request)
    {
        $product_id = $request->product_id;

        $product = Product::find($product_id);

        // $cart_id = session()->get('cart');
        // $product_quantities = session()->get('product_quantities');
        $status = Cart::where('user_id',Auth::user()->id)->where('status',1)->count();
       

        if ($status <= 0) {

            $cart = new Cart();
            $cart->user_id = Auth::user()->id;
            $cart->status = 1;
            if ($cart->save()) {
                $cart_id = $cart->id;
                // dd($cart_id);
                $product_quantities = CartProduct::where('cart_id',$cart_id)->sum('quantity');
                $cart_products = new CartProduct();
                $cart_products->cart_id = $cart_id;
                $cart_products->product_id = $product_id;
                $cart_products->status = 1;
                if ($cart_products->save()) {
                    $product_quantities = CartProduct::where(
                        'cart_id',
                        $cart_id
                    )->where('status', '=', 1)
                        ->pluck('quantity')->sum();
                    // dd($product_quantities);

                    session()->put('cart', $cart_id);
                    session()->put('product_quantities', $product_quantities);
                    return response([
                        'success' => false,
                        'message' => 'Cart Updated Succesfully',
                        'cart' => $cart_id,
                        'product_quantities' => $product_quantities,
                    ], Response::HTTP_OK);
                }
            }
        } else {
            // dd($product_id);
            $cart_id = Cart::where('user_id',Auth::user()->id)->where('status',1)->pluck('id')->first();
            $product_quantities = CartProduct::where('cart_id',$cart_id)->sum('quantity');
            $count = CartProduct::where('product_id', $product_id)
                ->where('cart_id', $cart_id)
                ->where('status', 1)
                ->count();
            // // dd($count);
            // // product does not exist in this
            if ($count <= 0) {
                $cart_products = new CartProduct();
                $cart_products->cart_id = $cart_id;
                $cart_products->product_id = $product_id;
                $cart_products->status = 1;
                if ($cart_products->save()) {

                    $product_quantities = CartProduct::where(
                        'cart_id',
                        $cart_id
                    )->where('status', '=', 1)
                        ->pluck('quantity')->sum();
                    session()->put('cart', $cart_id);
                    session()->put('product_quantities', $product_quantities);
                    return response([
                        'success' => false,
                        'message' => 'cart updated Succesfully',
                        'cart' => $cart_id,
                        'product_quantities' => $product_quantities,
                    ], Response::HTTP_OK);
                }
            } else {
                $quantity = CartProduct::where('product_id', $product_id)
                    ->where('status', '=', 1)
                    ->pluck('quantity')
                    ->first();

                $newquanity = $quantity + 1;
                CartProduct::where('product_id', $product_id)
                    ->where('cart_id', $cart_id)
                    ->where('status', 1)
                    ->update([
                        'quantity' => $newquanity,
                    ]);

                $product_quantities = CartProduct::where(
                    'cart_id',
                    $cart_id
                )->where('status', '=', 1)
                    ->pluck('quantity')->sum();

                session()->put('product_quantities', $product_quantities);
                return response([
                    'success' => false,
                    'message' => 'Cart Updated Succesfully',
                    'cart' => $cart_id,
                    'product_quantities' => $product_quantities,
                ], Response::HTTP_OK);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
    public function cartDelete(Request $request)
    {
        $cartproduct_id = $request->cartproduct_id;

        $cart_product = CartProduct::find($cartproduct_id);
        if ($cart_product->delete()) {

            $cart_id = session()->get('cart');
            // $product_quantities = CartProduct::where('cart_id', $cart_id)->pluck('quantity')->sum();
            $cart_id = Cart::where('user_id',Auth::user()->id)->where('status',1)->pluck('id')->first();
            $product_quantities = CartProduct::where('cart_id',$cart_id)->sum('quantity');
            // $product_quantities = CartProduct::where(
            //     [
            //         'user_id' => Auth::user()->id,
            //         'status' => 1
            //     ]
            // )->pluck('quantity')->sum();

            session()->put('product_quantities', $product_quantities);

            return response([
                'success' => true,
                'message' => 'Product  Deleted Successfully',
                'product_quantities' => $product_quantities,
            ], Response::HTTP_OK);
            # code...
        } else {

            return response([
                'success' => false,
                'message' => 'Product not Deleted!Please try again',
            ], Response::HTTP_OK);
        }
    }
}
