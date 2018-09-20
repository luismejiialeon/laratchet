<?php

Route::filter('syncSession', function ()
{

	//Demo
    Laratchet::syncUserSession();
});