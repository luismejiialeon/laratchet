<?php

namespace SysMl\Laratchet\Controllers;

use Illuminate\Routing\Controller;
use Laratchet;

/**
 * Class RatchetController
 * @package SysMl\Ratchet
 */
class LaratchetController extends Controller {


    /**
     * Test method for push
     */
    public function pushTest()
    {
        Laratchet::broadcast(

            \Config::get('laratchet.demoPushChannel'),
            ['title' => 'Name']
        );

        return redirect()->back()->with('message','Push was send to clients.');
    }

    /**
     * Show the push send form
     *
     * @return \Illuminate\View\View
     */
    public function pusher()
    {
        return view('laratchet::pusher');
    }

    /**
     * Test client for push
     *
     * @return \Illuminate\View\View
     */
    public function pushClient()
    {
        return view('laratchet::client');
    }

}