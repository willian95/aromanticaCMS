<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get("/", "LoginController@index");
Route::post("/login", "LoginController@login");
Route::get("/logout", "LoginController@logout");

Route::middleware(['admin'])->group(function () {

    Route::get("/admin/dashboard", function () {

        return view("admin.index");
    });

    Route::get("/admin/category/index", "CategoryController@index");
    Route::get("/admin/category/fetch/all", "CategoryController@fetchAll");
    Route::post("/admin/category/store", "CategoryController@store");
    Route::post("/admin/category/delete", "CategoryController@delete");
    Route::get("/admin/category/fetch/{page}", "CategoryController@fetch");
    Route::get("/admin/category/pdf", "CategoryController@pdfExport");
    Route::get("/admin/category/excel", "CategoryController@excelExport");
    Route::get("/admin/category/csv", "CategoryController@csvExport");
    Route::post("/admin/category/update", "CategoryController@update");

    Route::get("/admin/brand/index", "BrandController@index");
    Route::get("/admin/brand/fetch/all", "BrandController@fetchAll");
    Route::post("/admin/brand/store", "BrandController@store");
    Route::post("/admin/brand/delete", "BrandController@delete");
    Route::get("/admin/brand/fetch/{page}", "BrandController@fetch");
    Route::get("/admin/brand/pdf", "BrandController@pdfExport");
    Route::get("/admin/brand/excel", "BrandController@excelExport");
    Route::get("/admin/brand/csv", "BrandController@csvExport");
    Route::post("/admin/brand/update", "BrandController@update");

    Route::get("/admin/type/index", "TypeController@index");
    Route::get("/admin/type/fetch/all", "TypeController@fetchAll");
    Route::post("/admin/type/store", "TypeController@store");
    Route::post("/admin/type/delete", "TypeController@delete");
    Route::get("/admin/type/fetch/{page}", "TypeController@fetch");
    Route::get("/admin/type/pdf", "TypeController@pdfExport");
    Route::get("/admin/type/excel", "TypeController@excelExport");
    Route::get("/admin/type/csv", "TypeController@csvExport");
    Route::post("/admin/type/update", "TypeController@update");

    Route::get("/admin/size/index", "SizeController@index");
    Route::get("/admin/size/fetch/all", "SizeController@fetchAll");
    Route::post("/admin/size/store", "SizeController@store");
    Route::post("/admin/size/delete", "SizeController@delete");
    Route::get("/admin/size/fetch/{page}", "SizeController@fetch");
    Route::get("/admin/size/pdf", "SizeController@pdfExport");
    Route::get("/admin/size/excel", "SizeController@excelExport");
    Route::get("/admin/size/csv", "SizeController@csvExport");
    Route::post("/admin/size/update", "SizeController@update");

    Route::get("/admin/user/index", "UserController@index");
    Route::get("/admin/user/fetch/{page}", "UserController@fetch");
    Route::get("/admin/user/shopping/{user_id}", "UserController@shopping");
    Route::get("/admin/user/shopping/{page}/user/{user_id}", "ShoppingController@fetchByUser");
    Route::get("/admin/user/pdf", "UserController@pdfExport");
    Route::get("/admin/user/excel", "UserController@excelExport");
    Route::get("/admin/user/csv", "UserController@csvExport");
    Route::post("/admin/user/search", "UserController@search");

    Route::get("/admin/product/index", "ProductController@index");
    Route::get("/admin/product/create", "ProductController@create");
    Route::get("/admin/product/fetch/{page}", "ProductController@fetch");
    Route::get("/admin/product/edit/{id}", "ProductController@edit");
    Route::get("/admin/product/product-type/{id}", "ProductController@productTypeFetch");
    Route::get("/admin/product/excel", "ProductController@excelExport");
    Route::get("/admin/product/pdf", "ProductController@pdfExport");
    Route::get("/admin/product/csv", "ProductController@csvExport");
    Route::post("/admin/product/store", "ProductController@store");
    Route::post("/admin/product/search", "ProductController@search");
    Route::post("/admin/product/update", "ProductController@update");
    Route::post("/admin/product/delete", "ProductController@delete");

    Route::get("/admin/shopping/index", "ShoppingController@index");
    Route::get("/admin/shopping/fetch/{page}", "ShoppingController@fetch");
    Route::get("/admin/shopping/excel", "ShoppingController@excelExport");
    Route::get("/admin/shopping/pdf", "ShoppingController@pdfExport");
    Route::get("/admin/shopping/csv", "ShoppingController@csvExport");

    Route::get("/admin/shopping/chart", "ShoppingController@chart");

    Route::get("/admin/promotions/mail/index", "PromotionMailController@index");
    Route::get("/admin/promotions/mail/fetch/{page}", "PromotionMailController@fetch");
    Route::post("/admin/promotions/mail/store", "PromotionMailController@store");

    Route::get("/admin/banner/index", "BannerController@index");
    Route::post("/admin/banner/update", "BannerController@update");

    Route::get("/admin/top-product/index", "TopProductController@index");
    Route::get("/admin/top-product/fetch", "TopProductController@fetch");
    Route::post("/admin/top-product/search", "TopProductController@search");
    Route::post("/admin/top-product/store", "TopProductController@store");
    Route::post("/admin/top-product/delete", "TopProductController@delete");

    Route::get("/admin/coupon/index", "CouponController@index");
    Route::get("/admin/coupon/create", "CouponController@create");
    Route::get("admin/coupon/fetch", "CouponController@fetch");
    Route::post("/admin/coupon/store", "CouponController@store");
    Route::post("/admin/coupon/delete", "CouponController@delete");
});