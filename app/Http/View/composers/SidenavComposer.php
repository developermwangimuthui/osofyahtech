<?php

namespace App\Http\View\Composers;

use App\Cart;
use App\CartProduct;
use Illuminate\View\View;
use App\Service;
use App\Category;
use Illuminate\Support\Facades\Auth;

class SidenavComposer
{

    /**
     * Create a CountingComposer .
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $services = Service::orderBy('created_at','asc')->get();
        $categories =Category::withCount('products')->get();
        if(Auth::check()){
          $cart = Cart::where('user_id',Auth::user()->id)->where('status',1)->count();
          if ($cart != null) {
            $cart_id = Cart::where('user_id',Auth::user()->id)->where('status',1)->pluck('id')->first();
            $cartItemCount = CartProduct::where('cart_id',$cart_id)->sum('quantity');
          } else {
            $cartItemCount = 0;
          }
          
          
        }else {
          $cartItemCount = 0;
        }
       
      $data = [
        'global_services' => $services,
        'global_categories' => $categories,
        'cartItemCount' => $cartItemCount
      ];

        $view->with($data);
    }
}
