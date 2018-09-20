<?php
/**
 * Autor: UBa
 * Date: 30.11.2014
 * Time: 11:54
 * Description: All routes for package barrot/intranet-connector
 */

Route::get('loginservice', function ()
{

    return "Works as designed";
});

Route::get('laratchet/client', 'Barrot\Laratchet\Controllers\LaratchetController@pushClient');
Route::get('laratchet/pusher', 'Barrot\Laratchet\Controllers\LaratchetController@pusher');
Route::get('laratchet/test', 'Barrot\Laratchet\Controllers\LaratchetController@pushTest');


