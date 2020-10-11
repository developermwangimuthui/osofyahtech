<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ShippingAdress;
use App\Traits\UsesUUID;
use App\Cart;
use App\User;
class Order extends Model
{

    use UsesUUID;

    public function shippingadress(){
        return $this->hasOne(ShippingAdress::class);
    }
    public function cart()
    {        
        return $this->belongsTo(Cart::class);
    }

    public function user()
    {        
        return $this->belongsTo(User::class);
    }
}
