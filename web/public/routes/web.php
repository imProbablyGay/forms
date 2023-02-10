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
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.login');

Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@index')->name('register.index');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register.register');


Route::get('/contact', 'App\Http\Controllers\ContactController@show_contact_form')->name('show_contact_form');
Route::post('/contact_form_process', 'App\Http\Controllers\ContactController@contact_form_process')->name('contact_form_process');

Route::get('/password/forgot', 'App\Http\Controllers\Auth\ForgotPasswordController@index')->name('forgot_password.index');
Route::post('/password/forgot', 'App\Http\Controllers\Auth\ForgotPasswordController@store')->name('forgot_password.store');

Route::get('/password/restore/{link}', 'App\Http\Controllers\Auth\RestorePasswordController@index')->name('restore_password.index');
Route::post('/password/restore_process/{link}', 'App\Http\Controllers\Auth\RestorePasswordController@restore')->name('restore_password.restore');

Route::get('/password/restored', 'App\Http\Controllers\Auth\RestorePasswordController@show')->name('restore_password.show');


Route::get('/profile/edit', 'App\Http\Controllers\Profile\EditDataController@edit')->name('edit_profile_data.edit');
Route::post('/profile/update', 'App\Http\Controllers\Profile\EditDataController@update')->name('edit_profile_data.update');
Route::post('/profile/update_picture', 'App\Http\Controllers\Profile\EditPictureController@update')->name('edit_profile_picture.update');

Route::get('/form/create', 'App\Http\Controllers\Form\CreateController@index')->name('create_form.index');
Route::post('/form/create', 'App\Http\Controllers\Form\CreateController@store')->name('create_form.store');
Route::post('/form/create_image', 'App\Http\Controllers\Form\CreateController@create_image')->name('create_form.store_image');

Route::get('/404', 'App\Http\Controllers\ErrorsController@not_found')->name('not_found');
