<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use App\ServiceProductPhoto;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

use App\Traits\UsesUUID;
class ServiceProduct extends Model
{
    use UsesUUID;
  
    use SoftDeletes,CascadeSoftDeletes;
    protected $cascadeDeletes = ['serviceproductphotos'];

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function serviceproductphotos(){
        return $this->hasMany(ServiceProductPhoto::class);
    }
}
