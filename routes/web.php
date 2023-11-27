<?php

use App\Mail\SendTokenMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    try {

        $email = request()->get('email');
        $token = request()->get('token');
        $contactIsEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($contactIsEmail) {
            Mail::send('emails.send-token', ['token' => $token], function ($message) use ($email) {
                $message->to($email)->subject('filamingo verify token');
            });
        }

        return response()->json(['status' => true, 'message' => 'success']);
    } catch (Exception $e) {
        Log::error($e);
        return response()->json(['status' => false, 'message' => $e->getMessage() ?? 'failed']);
    }
});
