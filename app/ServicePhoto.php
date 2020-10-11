<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\UsesUUID;
class ServicePhoto extends Model
{    
    use SoftDeletes;
     
    use UsesUUID;
  
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
