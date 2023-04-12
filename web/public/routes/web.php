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


Route::get('/logout', 'App\Http\Controllers\Auth\LogoutController@index')->name('logout.index');

// if user is authorized redirect him to profile page
Route::group(['middleware' => 'redirect_if_authorized'], function() {
    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@index')->name('login.index');
    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.login');

    Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@index')->name('register.index');
    Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register.register');
});

Route::get('/password/forgot', 'App\Http\Controllers\Auth\ForgotPasswordController@index')->name('forgot_password.index');
Route::post('/password/forgot', 'App\Http\Controllers\Auth\ForgotPasswordController@store')->name('forgot_password.store');

Route::get('/password/restore/{link}', 'App\Http\Controllers\Auth\RestorePasswordController@index')->name('restore_password.index');
Route::post('/password/restore_process/{link}', 'App\Http\Controllers\Auth\RestorePasswordController@restore')->name('restore_password.restore');

Route::get('/password/restored', 'App\Http\Controllers\Auth\RestorePasswordController@show')->name('restore_password.show');


// auth required!
Route::group(['middleware' => 'auth'], function() {

    // create form
    Route::get('form/create', 'App\Http\Controllers\Form\CreateController@index')->name('create_form.index');
    Route::post('form/create', 'App\Http\Controllers\Form\CreateController@store')->name('create_form.store');
    Route::post('form/create_image', 'App\Http\Controllers\Form\CreateController@create_image')->name('create_form.store_image');
    // delete form
    Route::post('form/delete/{form_hash}', 'App\Http\Controllers\Form\Controller@destroy')->name('form.delete');
    // get form max values
    Route::post('form/create/max_values', 'App\Http\Controllers\Form\CreateController@get_max_values')->name('create_form.get_max_values');

    // profile
    Route::group(['prefix' => 'profile'],function() {
        // show
        Route::get('', 'App\Http\Controllers\Profile\ShowController@index')->name('profile.index');
        Route::post('/get_answers_description', 'App\Http\Controllers\Profile\ShowController@get_answers_description')->name('profile.get_answers_description');
        // get statistics on profile form page
        Route::post('/form/{form_hash}/statistics', 'App\Http\Controllers\Profile\ShowController@get_profile_form_statistics')->name('profile.get_profile_form_statistics');
        // get certain answer on profile form page
        Route::post('/form/{form_hash}/certain_answer/{a_id}', 'App\Http\Controllers\Profile\ShowController@get_profile_form_certain_answer')->name('profile.get_profile_form_certain_answer');
        // get options answer text
        Route::post('/option/{id}', 'App\Http\Controllers\Profile\ShowController@get_option_text')->name('profile.get_option_text');


        //show published form in profile
        Route::get('/form/{form_hash}', 'App\Http\Controllers\Profile\ShowController@show_form')->name('profile.show_form');

        // edit
        Route::get('/edit', 'App\Http\Controllers\Profile\EditDataController@edit')->name('edit_profile_data.edit');
        Route::post('/update', 'App\Http\Controllers\Profile\EditDataController@update')->name('edit_profile_data.update');
        Route::post('/update_picture', 'App\Http\Controllers\Profile\EditPictureController@update')->name('edit_profile_picture.update');
    });
});

// form
Route::group(['prefix' => 'form'], function() {

    // answer
    Route::get('/{form_hash}', 'App\Http\Controllers\Answer\Controller@index')->name('answer_form.index');
    Route::post('/{form_hash}', 'App\Http\Controllers\Answer\Controller@get_form')->name('answer_form.get_form');
    Route::post('/{form_hash}/upload_answer', 'App\Http\Controllers\Answer\Controller@upload_answer')->name('answer_form.upload_answer');
});



Route::get('/404', 'App\Http\Controllers\ErrorsController@not_found')->name('not_found');
