<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('mail', function () {
//     try {
//         Mail::to("wahyall278@gmail.com")->send(new \App\Mail\SendOTPMail("Wahyu Agung Laksono", "949201", "wahyall278@gmail.com"));
//     } catch (\Throwable $th) {
//         $response = Http::withHeaders([
//             'api-key' => env('BREVO_API_KEY'),
//             'accept' => 'application/json',
//             'content-type' => 'application/json'
//         ])->post(env('BREVO_API_URL'), [
//             'sender' => [
//                 'name' => env('APP_NAME'),
//                 'email' => env('MAIL_FROM_ADDRESS')
//             ],
//             'to' => [
//                 ['name' => "Wahyu Agung Laksono", 'email' => "wahyall278@gmail.com"]
//             ],
//             'subject' => 'Verifikasi Email - OTP',
//             'htmlContent' => view('email.otp', ['nama' => "Wahyu Agung Laksono", 'email' => "wahyall278@gmail.com", 'otp' => "949201"])->render()
//         ]);
//     }
// });

Route::get('report', function () {
    return view('report.tagihan-pembayaran');
});

Route::get('/{any}', function (Request $request) {
    $config = \App\Models\Setting::first();
    return view('app', compact('config'));
})->where('any', '^(?!api\/)[\/\w\.-]*');
