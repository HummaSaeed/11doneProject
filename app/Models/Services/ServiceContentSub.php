<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;

class ServiceContentSub extends Model
{
    
    protected $fillable = ['name', 'price', 'service_content_id'];
    
    public function service_content()
    {
        return $this->belongsTo(ServiceContent::class, 'service_content_id', 'id');
    }


}
