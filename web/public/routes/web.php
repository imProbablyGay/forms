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
    return view('home');
});

Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::get('/login', 'App\Http\Controllers\AuthController@show_login_form')->name('login');
Route::post('/login/process', 'App\Http\Controllers\AuthController@login_process')->name('login_process');

Route::get('/register', 'App\Http\Controllers\AuthController@show_register_form')->name('register');
Route::post('/register/process', 'App\Http\Controllers\AuthController@register_process')->name('register_process');


Route::get('/contact', 'App\Http\Controllers\ContactController@show_contact_form')->name('show_contact_form');
Route::post('/contact_form_process', 'App\Http\Controllers\ContactController@contact_form_process')->name('contact_form_process');

Route::get('/password/forgot', 'App\Http\Controllers\AuthController@show_forgot_password')->name('show_forgot_password');
Route::post('/password/forgot_process', 'App\Http\Controllers\AuthController@forgot_password_process')->name('forgot_password_process');

Route::get('/password/restore/{link}', 'App\Http\Controllers\AuthController@show_restore_password')->name('show_restore_password');
Route::post('/password/restore_process/{link}', 'App\Http\Controllers\AuthController@restore_password_process')->name('restore_password_process');

Route::get('/password/restored', 'App\Http\Controllers\AuthController@show_restored_password')->name('show_restored_password');


Route::get('/profile/edit', 'App\Http\Controllers\AuthController@show_edit')->name('show_profile_edit');
Route::post('/profile/edit_process', 'App\Http\Controllers\AuthController@edit_profile_process')->name('edit_profile_process');
Route::post('/profile/edit_picture_process', 'App\Http\Controllers\AuthController@edit_profile_picture_process')->name('edit_profile_picture_process');

Route::get('/form/create', 'App\Http\Controllers\FormController@show_create_form')->name('show_create_form');
Route::post('/form/create_process', 'App\Http\Controllers\FormController@create_form_process')->name('upload_form_process');

Route::get('/404', 'App\Http\Controllers\ErrorsController@not_found')->name('not_found');
