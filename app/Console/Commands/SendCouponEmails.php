<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\QueueCoupon;
use App\Coupon;
use App\CouponUser;
use App\CouponProduct;
use App\User;

class SendCouponEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:coupon_emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        
        $this->createQueue();

        if(Storage::exists('scheduleMonitor.txt')){

            $scheduleMonitorContent = Storage::get("scheduleMonitor.txt");

            if(strpos($scheduleMonitorContent, "finished") > -1){
                
                $this->sendEmails();
            }

        }
        

    }

    function sendEmails(){
        try{

            Storage::put("scheduleMonitor.txt", "started");
            foreach(QueueCoupon::where("sent", 0)->get() as $email){    

                $couponProduct = CouponProduct::where("coupon_id", $email->coupon_id)->get();
                $couponInfo = Coupon::find($email->coupon_id);

                $data = ["couponName" => $email->name, "couponEmail" => $email->email, "products" => $couponProduct,"coupon" => $couponInfo];
                $to_email = $email->email;
                $title = "Cupón de descuento";


                \Mail::send("emails.massive_emails", $data, function($message) use ($to_email, $title) {

                    $message->to($to_email)->subject("Cupón de descuento");
                    $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

                });



                $massiveEmail = QueueCoupon::where("id", $email->id)->first();
                $massiveEmail->sent = 1;
                $massiveEmail->update();

                sleep(1);

            }

            Storage::put("scheduleMonitor.txt", "finished");


        }catch(\Exception $e){

            Storage::put("scheduleMonitor.txt", "finished");

        }

    }

    function createQueue(){

        $coupons = Coupon::where("coupon_email_creation", false)->get();
        
        foreach($coupons as $coupon){

            if($coupon->all_users){

                foreach(User::where("role_id", 2)->get() as $user){

                    $queueCoupon = new QueueCoupon;
                    $queueCoupon->name = $user->name;
                    $queueCoupon->email = $user->email;
                    $queueCoupon->coupon_id = $coupon->id;
                    $queueCoupon->save();

                }


            }else{

                $users = CouponUser::where("coupon_id", $coupon->id)->get();
                foreach($users as $user){

                    $userModel = User::find($user->user_id);

                    $queueCoupon = new QueueCoupon;
                    $queueCoupon->name = $userModel->name;
                    $queueCoupon->email = $userModel->email;
                    $queueCoupon->coupon_id = $coupon->id;
                    $queueCoupon->save();

                }


            }

        }

        Coupon::where("coupon_email_creation", false)->update(["coupon_email_creation" => true]);

    }

}
