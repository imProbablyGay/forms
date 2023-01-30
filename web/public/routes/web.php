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

Route::get('/test', 'App\Http\Controllers\Test\TestController@test')->name('test');

Route::get('/', function () {
    return view('home');
});


Route::get('/logout', 'App\Http\Controllers\Auth\LogoutController@index')->name('logout.index');

Route::get('/login', 'App\Http\Controllers\Auth\LoginController@index')->name('login.index');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@update')->name('login.update');

Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@index')->name('register.index');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@store')->name('register.store');


Route::get('/contact', 'App\Http\Controllers\ContactController@show_contact_form')->name('show_contact_form');
Route::post('/contact_form_process', 'App\Http\Controllers\ContactController@contact_form_process')->name('contact_form_process');

Route::get('/password/forgot', 'App\Http\Controllers\Auth\ForgotPasswordController@index')->name('forgot_password.index');
Route::post('/password/forgot', 'App\Http\Controllers\Auth\ForgotPasswordController@store')->name('forgot_password.store');

Route::get('/password/restore/{link}', 'App\Http\Controllers\Auth\RestorePasswordController@index')->name('restore_password.index');
Route::post('/password/restore_process/{link}', 'App\Http\Controllers\Auth\RestorePasswordController@update')->name('restore_password.update');

Route::get('/password/restored', 'App\Http\Controllers\Auth\RestorePasswordController@show')->name('restore_password.show');


Route::get('/profile/edit', 'App\Http\Controllers\Profile\EditDataController@index')->name('edit_profile.index');
Route::post('/profile/edit_data', 'App\Http\Controllers\Profile\EditDataController@update')->name('edit_profile_data.update');
Route::post('/profile/edit_picture', 'App\Http\Controllers\Profile\EditPictureController@update')->name('edit_profile_picture.update');

Route::get('/form/create', 'App\Http\Controllers\FormController@show_create_form')->name('show_create_form');
Route::post('/form/create_process', 'App\Http\Controllers\FormController@create_form_process')->name('upload_form_process');

Route::get('/404', 'App\Http\Controllers\ErrorsController@not_found')->name('not_found');
