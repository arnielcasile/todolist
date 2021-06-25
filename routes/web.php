<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/todolist', 'PageController@todo');
Route::get('/login', 'Auth\LoginController@index');
Route::post('/main/checklogin', 'Auth\LoginController@checklogin');
Route::get('/main/successlogin', 'Auth\LoginController@successlogin');
Route::get('/main/logout', 'Auth\LoginController@logout');