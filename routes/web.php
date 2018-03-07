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

/****  BEGIN ADMIN ROUTES ****/

Route::group(['prefix' => 'dashboard',  'middleware' => 'auth'], function()
{
    Route::get('/','Admin\DashboardController@index')->name('dashboardindex');

    // REGISTRATION //
    Route::get('registration','Admin\RegistrationController@index')->name('registrationindex');
    
    // USERS //
    Route::prefix('users')->group(function () {
       Route::get('/','Admin\UsersController@index')->name('usersindex');
       Route::get('create','Admin\UsersController@create');
       Route::post('store','Admin\UsersController@store');
       Route::get('edit/{id}','Admin\UsersController@edit');
       Route::get('show/{id}','Admin\UsersController@show'); 
       Route::post('update/{id}','Admin\UsersController@update');
       //Route::get('delete/{id}','Admin\UsersController@destroy');
    });

    // PATIENTS //
    Route::prefix('patients')->group(function () {
        Route::get('/','Admin\PatientsController@index')->name('patientsindex');
        Route::get('create','Admin\PatientsController@create');
        Route::post('store','Admin\PatientsController@store');
        Route::get('edit/{id}','Admin\PatientsController@edit');
        Route::post('update/{id}','Admin\PatientsController@update');
        Route::get('delete/{id}','Admin\PatientsController@destroy');
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

     // CATEGORIES //
    Route::prefix('categories')->group(function () {
        Route::get('/','Admin\CategoriesController@index')->name('categoriesindex');
        Route::get('create','Admin\CategoriesController@create');
        Route::post('store','Admin\CategoriesController@store');
        Route::get('edit/{id}','Admin\CategoriesController@edit');
        Route::post('update','Admin\CategoriesController@update');
        Route::get('delete/{id}','Admin\CategoriesController@destroy');
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


/****  BEGIN PUBLIC ROUTES ****/
Route::get('/','Store\PageController@index')->name('storeindex');
Route::get('{page}','Store\PageController@page');

//Route::get('/home', 'HomeController@index')->name('home');
