<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\Traits\UsesUUID;
class Cart extends Model
{
    
    use UsesUUID;
    public function orders()
    {        
        return $this->hasOne(Order::class);
    }
    public function cartproducts()
    {        
        return $this->hasMany(CartProduct::class);
    }
}
