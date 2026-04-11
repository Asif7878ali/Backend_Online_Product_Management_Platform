<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockAlert;

Route::get('/', function () {
    return view('welcome');
});


// Route::get("/syezainalyl", function () {
//     $asifcheeta = Mail::to("aloasif31@gmail.com")->cc(["aloasif31@gmail.com", "zaidk4076@gmail.com"])->send(new LowStockAlert("anmeis"));
//     if ($asifcheeta) {
//         echo "mail send";
//     } else {
//         echo "error";
//     }
//     exit;
// });