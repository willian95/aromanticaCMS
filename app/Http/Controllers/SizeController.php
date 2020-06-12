<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SizeStoreRequest;
use App\Http\Requests\SizeUpdateRequest;
use App\Size;

class SizeController extends Controller
{
    function index(){
        return view("admin.sizes.index");
    }

    function store(SizeStoreRequest $request){

        try{

            $size = new Size;
            $size->name = $request->name;
            $size->save();

            return response()->json(["success" => true, "msg" => "Tamaño creado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function update(SizeUpdateRequest $request){

        try{

            if(Size::where('name', $request->name)->where('id', '<>', $request->id)->count() == 0){
                
                $size = Size::find($request->id);
                $size->name = $request->name;
                $size->update();

                return response()->json(["success" => true, "msg" => "Tamaño actualizado"]);
            
            }else{

                return response()->json(["success" => false, "msg" => "Este nombre ya existe"]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }
        
    }

    function delete(Request $request){

        try{

            $size = Size::find($request->id);
            $size->delete();

            return response()->json(["success" => true, "msg" => "Tamaño eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $sizes = Size::skip($skip)->take(20)->get();
            $sizesCount = Size::count();

            return response()->json(["success" => true, "sizes" => $sizes, "sizesCount" => $sizesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }
}
