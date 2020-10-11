<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;

use App\Traits\UsesUUID;
class ProductPhoto extends Model
{

    use UsesUUID;
  
    use SoftDeletes;
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
