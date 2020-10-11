<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ServiceProduct;
use App\Traits\UsesUUID;

class ServiceProductPhoto extends Model
{
    use UsesUUID;
  
    use SoftDeletes;

    public function serviceproduct(){
        return $this->belongsTo(ServiceProduct::class);
    }
}
