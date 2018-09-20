<?php

namespace Barrot\Laratchet\Models;

use Illuminate\Database\Eloquent\Model;


class Session extends Model{


    public $table = 'sessions';

    public $timestamps = false;


    /**
     * Sync the users current session with the user id
     */
    public static function syncUserSession()
    {

        $session = Session::where('id',\Session::getId())->first();
        $session -> user_id = \Auth::user()->id;
        $session -> save();
    }



}