<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use SoftDeletes;

    public function couponUsers(){

        return $this->hasMany(CouponUser::class);

    }

    public function couponProducts(){

        return $this->hasMany(CouponProduct::class);

    }

}
