<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueCoupon extends Model
{
    
    public function coupon(){

        return $this->belongsTo(Coupon::class);

    }

}
