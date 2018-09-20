<?php
/**
 * Autor: UBa
 * Date: 30.11.2014
 * Time: 11:54
 * Description: All routes for package sysMl/intranet-connector
 */

Route::get('loginservice', function ()
{

    return "Works as designed";
});

Route::get('laratchet/client', 'SysMl\Laratchet\Controllers\LaratchetController@pushClient');
Route::get('laratchet/pusher', 'SysMl\Laratchet\Controllers\LaratchetController@pusher');
Route::get('laratchet/test', 'SysMl\Laratchet\Controllers\LaratchetController@pushTest');


