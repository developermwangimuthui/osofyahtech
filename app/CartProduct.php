<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Traits\UsesUUID;
class CartProduct extends Model
{


    use UsesUUID;
    //
    public function products()
    {        
        return $this->belongsTo(Product::class);
    }
}
