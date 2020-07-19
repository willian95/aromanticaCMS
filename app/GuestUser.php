<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    protected $table="guest_users";

    public function payments(){
        return $this->hasMany(App\Payment::class);
    }

}
