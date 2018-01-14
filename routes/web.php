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

Route::get('/', function () {
    return redirect()->route('festivals.index');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::resource('festivals', 'Front\FestivalsController');
Route::post('visitors/store/festival/{festival}', 'Front\VisitorsController@store')->name('visitors.store');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::resource('festivals', 'Admin\AdminFestivalsController', ['as' => 'admin']);
    Route::get('festivals/{festival}/applicants', 'Admin\AdminFestivalsController@applicants')->name('admin.festivals.applicants');
});