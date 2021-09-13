<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PromotionMail;
use App\Http\Requests\PromotionMailRequest;
use App\User;
use App\GuestUser;

class PromotionMailController extends Controller
{
    
    function index(){

        return view("admin.promotions.index");

    }

    function fetch($page = 1){

        try{

            $skip = ($page - 1) * 20;

            $promotions = PromotionMail::skip($skip)->take(20)->orderBy("id", "desc")->get();
            $promotionsCount = PromotionMail::count();

            return response()->json(["success" => true, "promotions" => $promotions, "promotionsCount" => $promotionsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }



    }

    function store(PromotionMailRequest $request){

        try{

            $promotion = new PromotionMail;
            $promotion->title = $request->title;
            $promotion->body = $request->description;
            $promotion->link = $request->link;
            $promotion->include_newsletter = $request->includeNewsletter;
            $promotion->save();

            /*$users = User::where("role_id", 2)->get();

            foreach($users as $user){

                $to_name = $user->name;
                $to_email = $user->email;
                $data = ["title" => $request->title, "body" => $request->description, "link" => $request->link];

                \Mail::send("emails.promotion", $data, function($message) use ($to_name, $to_email, $request) {

                    $message->to($to_email, $to_name)->subject($request->title);
                    $message->from("ventas@aromantica.co", env("MAIL_FROM_NAME"));

                });

            }

            $newsletterEmails = Newsletter::all();

            foreach($newsletterEmails as $guest){

                $to_name = $guest->name;
                $to_email = $guest->email;
                $data = ["title" => $request->title, "body" => $request->description, "link" => $request->link];

                \Mail::send("emails.promotion", $data, function($message) use ($to_name, $to_email, $request) {

                    $message->to($to_email, $to_name)->subject($request->title);
                    $message->from("ventas@aromantica.co", env("MAIL_FROM_NAME"));

                });

            }

            /*$guests = GuestUser::all();

            foreach($guests as $guest){

                $to_name = $guest->name;
                $to_email = $guest->email;
                $data = ["title" => $request->title, "body" => $request->description, "link" => $request->link];

                \Mail::send("emails.promotion", $data, function($message) use ($to_name, $to_email, $request) {

                    $message->to($to_email, $to_name)->subject($request->title);
                    $message->from("ventas@aromantica.co", env("MAIL_FROM_NAME"));

                });

            }*/

            return response()->json(["success" => true, "msg" => "Email de promoción creado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
