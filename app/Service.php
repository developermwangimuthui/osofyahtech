<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ServicePhoto;
use App\ServiceProduct;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

use App\Traits\UsesUUID;
class Service extends Model
{

    use UsesUUID;
  
    use SoftDeletes,CascadeSoftDeletes;
    protected $cascadeDeletes = ['serviceProducts','servicephotos'];

    public function serviceProducts(){
        return $this->belongsTo(ServiceProduct::class);
    }
    
    public function servicephotos(){
        return $this->hasMany(ServicePhoto::class);
    }
}
