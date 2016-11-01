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

Route::get('/', 'Pages@home');

Route::get('/login', 'Accounts@login_form'); // implement
Route::post('/login', 'Accounts@login'); // NOT WORKING

Route::get('/createAccount', 'Accounts@createAccount'); // implement
// make post request

Route::get('/logout', 'Accounts@logout'); // implement