<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\ProductTypeSize;

class ProductController extends Controller
{
    function index(){
        return view("admin.products.index");
    }

    function create(){
        return view("admin.products.create");
    }

    function edit($id){
        $product = Product::where("id", $id)->with("brand", "category")->first();
        return view("admin.products.edit", ["product" => $product]);
    }

    function store(ProductStoreRequest $request){

        try{

            $imageData = $request->get('image');

            if(strpos($imageData, "svg+xml") > 0){

                $data = explode( ',', $imageData);
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                $ifp = fopen($fileName, 'wb' );
                fwrite($ifp, base64_decode( $data[1] ) );
                rename($fileName, 'images/products/'.$fileName);

            }else{

                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/products/').$fileName);

            }
            

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

        try{

            $product = new Product;
            $product->name = $request->name;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;
            $product->image = $fileName;
            $product->save();

            foreach($request->productSizeTypes as $productTypeSize){

                $productType = new ProductTypeSize;
                $productType->product_id = $product->id;
                $productType->type_id = $productTypeSize["type"]["id"];
                $productType->size_id = $productTypeSize["size"]["id"];
                $productType->stock = $productTypeSize["stock"];
                $productType->price = $productTypeSize["price"];
                $productType->save();

            }

            return response()->json(["success" => true, "msg" => "Producto creado"]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function update(ProductUpdateRequest $request){

        if($request->get("image") != null){

            try{

                $imageData = $request->get('image');
    
                if(strpos($imageData, "svg+xml") > 0){
    
                    $data = explode( ',', $imageData);
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                    $ifp = fopen($fileName, 'wb' );
                    fwrite($ifp, base64_decode( $data[1] ) );
                    rename($fileName, 'images/products/'.$fileName);
    
                }else{
    
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                    Image::make($request->get('image'))->save(public_path('images/products/').$fileName);
    
                }
                
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }

        }

        try{

            $product = Product::find($request->id);
            $product->name = $request->name;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;
            if($request->get("image") != null){
                $product->image = $fileName;
            }
            $product->update();

            //ProductTypeSize::where("product_id", $request->id)->delete();

            $productTypeArray = [];
            $productTypes = ProductTypeSize::where("product_id", $product->id)->get();
            foreach($productTypes as $productType){
                array_push($productTypeArray, $productType->id);
            }

            $requestArray = [];
            foreach($request->productSizeTypes as $productTypeSizeRequest){
                if(array_key_exists("id", $productTypeSizeRequest)){
                    array_push($requestArray, $productTypeSizeRequest["id"]);
                }
            }

            $deleteProductTypes = array_diff($productTypeArray, $requestArray);
            
            foreach($deleteProductTypes as $productDelete){
                ProductTypeSize::where("id", $productDelete)->delete();
            }

            foreach($request->productSizeTypes as $productTypeSize){
                
                if(array_key_exists("id", $productTypeSize)){

                    if(ProductTypeSize::where("id", $productTypeSize["id"])->count() > 0){
                        $productType = ProductTypeSize::find($productTypeSize["id"]);
                        $productType->product_id = $product->id;
                        $productType->type_id = $productTypeSize["type"]["id"];
                        $productType->size_id = $productTypeSize["size"]["id"];
                        $productType->stock = $productTypeSize["stock"];
                        $productType->price = $productTypeSize["price"];
                        $productType->update();
                    }

                }else{
                    $productType = new ProductTypeSize;
                    $productType->product_id = $product->id;
                    $productType->type_id = $productTypeSize["type"]["id"];
                    $productType->size_id = $productTypeSize["size"]["id"];
                    $productType->stock = $productTypeSize["stock"];
                    $productType->price = $productTypeSize["price"];
                    $productType->save();
                }
                

            }

            return response()->json(["success" => true, "msg" => "Producto actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => true, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $products = Product::with("category", "brand", "productTypeSizes", "productTypeSizes.type", "productTypeSizes.size")->skip($skip)->take(20)->get();
            $productsCount = Product::with("category", "brand", "productTypeSizes", "productTypeSizes.type", "productTypeSizes.size")->count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){

        try{

            Product::where("id", $request->id)->delete();
            ProductTypeSize::where("product_id", $request->id)->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function productTypeFetch($id){

        try{

            $productType = ProductTypeSize::where("product_id", $id)->with("type", "size")->get();
            return response()->json(["success" => true, "productType" => $productType]);

        }catch(\Exception $e){  

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }   

    }

}
