<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use PDF;

class UserController extends Controller
{
    
    function index(){

        return view("admin.clients.index");

    }

    function shopping($user_id){

        return view("admin.clients.shoppings", ["user_id" => $user_id]);

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $users = User::skip($skip)->where("role_id", 2)->take(20)->get();
            $usersCount = User::where("role_id", 2)->count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function excelExport(){
        return Excel::download(new UsersExport, 'clientes.xlsx');
    }

    function csvExport(){
        return Excel::download(new UsersExport, 'clientes.csv');
    }

    function pdfExport(){
        $pdf = PDF::loadView('pdf.clients');
        return $pdf->stream();
    }

    function search(Request $request){

        $users = User::where("name", "like", '%'.$request->search.'%')->orWhere("email", "like", '%'.$request->search.'%')->take(20)->get();
        
        return response()->json(["users" => $users]);

    }

}
