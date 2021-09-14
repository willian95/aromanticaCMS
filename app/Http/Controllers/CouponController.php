<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CouponRequest;
use App\Coupon;
use App\CouponUser;
use App\CouponProduct;
use App\User;

class CouponController extends Controller
{
    
    function index(){

        return view("admin.coupons.index");

    }

    function create(){

        return view("admin.coupons.create");

    }

    function store(CouponRequest $request){

        try{

            $coupon = new Coupon;
            $coupon->discount_type = $request->discountType;
            $coupon->total_discount = $request->totalDiscount;
            $coupon->discount_amount = $request->discountAmount;
            $coupon->end_date = $request->endDate;
            $coupon->all_users = $request->allUsers;
            $coupon->all_products = $request->allProducts;
            $coupon->coupon_code = $request->couponCode;
            $coupon->save();

            $this->addUsers($request, $coupon->id);
            $this->addProducts($request, $coupon->id);

            return response()->json(["success" => true, "msg" => "Cupón creado"]);

        }catch(\Exception $e){  

            return response()->json(["success" => false, "msg" => "Hubo un problema"]);

        }

    }

    function fetch(){

        $coupons = Coupon::with(["couponUsers", "couponProducts", "couponUsers.user", "couponProducts.productTypeSize", "couponProducts.productTypeSize.product", "couponProducts.productTypeSize.size", "couponProducts.productTypeSize.type", "couponProducts.productTypeSize.product.brand"])->orderBy("id", "desc")->paginate(10);
        return response()->json(["coupons" => $coupons]);

    }

    function addUsers($request, $coupon_id){

        if($request->allUsers == false){

            foreach($request->users as $user){
           
                $couponUser = new CouponUser;
                $couponUser->user_id = $user["id"];
                $couponUser->coupon_id = $coupon_id;
                $couponUser->save();

            }

        }

    }

    function addProducts($request, $coupon_id){

        if($request->allProducts == false){

            foreach($request->products as $product){

                $couponProduct = new CouponProduct;
                $couponProduct->product_type_size_id = $product["id"];
                $couponProduct->coupon_id = $coupon_id;
                $couponProduct->save();

            }

        }

    }

    function delete(Request $request){
        try{

            Coupon::where("id", $request->id)->first()->delete();

            return response()->json(["success" => true, "msg" => "Cupón eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema"]);

        }
        

    }

}
