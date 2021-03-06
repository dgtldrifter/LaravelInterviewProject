<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('uploadFile', 'HomeController@uploadFile');
Route::post('/addSingleClient', 'HomeController@addSingleClient');
Route::post('/createUserFromClient', 'HomeController@createUserFromClient');
Route::delete('/deleteClient', 'HomeController@deleteClient');
Route::post('/exportData', 'HomeController@export');
