<?php

use App\Chat;
use App\Events\MessageSentEvent;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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


// Route::get('/a', function(){
//     // session()->put('email', 'jai@gmail.com');
//     dd(Session::all());


//     dd(session()->get('email'));
//     dd(auth()->user()->messages);
// });
Route::get('/', function () {
    return view('welcome');
});
Route::get('/a', function () {
    echo phpinfo();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('fetchusers', 'ChatsController@fetchUsers');
Route::get('fetchmessages/{receiver}', 'ChatsController@fetchMessages');
Route::post('sendmessage/{receiver}', 'ChatsController@sendMessage');
