<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Traits\UsesUUID;

class ShippingAdress extends Model
{

    use UsesUUID;
    //
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
