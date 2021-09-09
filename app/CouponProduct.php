<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    public function couponProducts(){

        return $this->belongsTo(Coupon::class);

    }

    public function productTypeSize(){

        return $this->belongsTo(ProductTypeSize::class);

    }
}
