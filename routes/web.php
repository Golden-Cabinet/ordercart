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

Route::group(['prefix' => 'dashboard',  'middleware' => 'auth'], function()
{
    Route::get('/','Admin\DashboardController@index')->name('dashboardindex');
    
    // USERS //
    Route::prefix('users')->group(function () {
       Route::get('/','Admin\UserController@index')->name('usersindex');
       Route::get('create','Admin\UserController@create');
       Route::post('store','Admin\UserController@store');
       Route::get('edit/{id}','Admin\UserController@edit');
       Route::get('show/{id}','Admin\UserController@show');
       Route::post('update','Admin\UserController@update');
       Route::get('delete/{id}','Admin\UserController@destroy');
    });

    // PATIENTS //
    Route::prefix('patients')->group(function () {
        Route::get('/','Admin\PatientController@index')->name('patientsindex');
        Route::get('create','Admin\PatientController@create');
        Route::post('store','Admin\PatientController@store');
        Route::get('edit/{id}','Admin\PatientController@edit');
        Route::post('update','Admin\PatientController@update');
        Route::get('delete/{id}','Admin\PatientController@destroy');
     });

     // ORDERS //
    Route::prefix('orders')->group(function () {
        Route::get('/','Admin\OrderController@index')->name('ordersindex');
        Route::get('view','Admin\OrderController@show');
        Route::get('create','Admin\OrderController@create');
        Route::post('store','Admin\OrderController@store');
        Route::get('edit/{id}','Admin\OrderController@edit');
        Route::post('update','Admin\OrderController@update');
        Route::get('delete/{id}','Admin\OrderController@destroy');
     });

     // FORMULAS //
    Route::prefix('formulas')->group(function () {
        Route::get('/','Admin\FormulaController@index')->name('formulasindex');
        Route::get('view','Admin\FormulaController@show');
        Route::get('duplicate/{id}','Admin\FormulaController@duplicate');
        Route::get('share/{id}','Admin\FormulaController@share');
        Route::get('create','Admin\FormulaController@create');
        Route::post('store','Admin\FormulaController@store');
        Route::get('edit/{id}','Admin\FormulaController@edit');
        Route::post('update','Admin\FormulaController@update');
        Route::get('delete/{id}','Admin\FormulaController@destroy');
     });

     // PRODUCTS //
    Route::prefix('products')->group(function () {
        Route::get('/','Admin\ProductController@index')->name('productsindex');
        Route::get('create','Admin\ProductController@create');
        Route::post('store','Admin\ProductController@store');
        Route::get('edit/{id}','Admin\ProductController@edit');
        Route::post('update','Admin\ProductController@update');
        Route::get('delete/{id}','Admin\ProductController@destroy');
     });

     // BRANDS //
    Route::prefix('brands')->group(function () {
        Route::get('/','Admin\BrandController@index')->name('brandsindex');
        Route::get('create','Admin\BrandController@create');
        Route::post('store','Admin\BrandController@store');
        Route::get('edit/{id}','Admin\BrandController@edit');
        Route::post('update','Admin\BrandController@update');
        Route::get('delete/{id}','Admin\BrandController@destroy');
     });

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
