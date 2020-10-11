<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\ProductPhoto;
use App\CartProduct;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

use App\Traits\UsesUUID;
class Product extends Model
{
    use UsesUUID;

    use SoftDeletes,CascadeSoftDeletes;
    protected $cascadeDeletes = ['cartproducts','productphotos'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function cartproducts(){
        return $this->hasMany(CartProduct::class);
    }
    public function productphotos(){
        return $this->hasMany(ProductPhoto::class);
    }
}
