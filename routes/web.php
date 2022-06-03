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


// Product Routes
Route::get('/', 'ProductsController@index')->name('store.index');
Route::get('/product/{slug}', 'ProductsController@show')->name('store.show');

// Cart Routes
Route::post('/cart/store', 'CartController@store')->name('cart.store');
Route::get('/shoppingcart', 'CartController@index')->name('cart.index');
Route::put('/shoppingcart/{rowId}', 'CartController@update')->name('cart.update');
Route::delete('/shoppingcart/{rowId}', 'CartController@destroy')->name('cart.destroy');

// Checkout Routes
Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
Route::get('/successfulpayment', 'CheckoutController@successfulpayment')->name('checkout.successfulpayment');