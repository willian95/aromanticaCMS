<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("coupon_id");
            $table->unsignedBigInteger("product_type_size_id");

            $table->foreign("product_type_size_id")->references("id")->on("product_type_sizes");
            $table->foreign("coupon_id")->references("id")->on("coupons");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_products');
    }
}
