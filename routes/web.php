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
    return view('welcome');
});

Route::get('/site', 'ProductController@index')->name('products.index');
Route::get('/site/{slug}','ProductController@show')->name('product.show');
Route::get('/search','ProductController@search')->name('products.search');
/*cart route */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/panier', 'CartController@index')->name('cart.index');
    Route::post('/panier/ajouter','CartController@store')->name('cart.store');
    Route::patch('/panier/{rowId}', 'CartController@update')->name('cart.update');
    Route::delete('/panier/{rowId}','CartController@destroy')->name('cart.destroy');
    Route::post('/coupon', 'CartController@storeCoupon')->name('cart.store.coupon');
    Route::delete('/coupon','CartController@destroyCoupon')->name('cart.destroy.coupon');
});
/*checkout */
Route::group(['middleware' => ['auth']], function () {
Route::get('/paiment','CheckoutController@index')->name('checkout.index');
Route::post('/paiment','CheckoutController@store')->name('checkout.store');
Route::get('/merci','CheckoutController@merci')->name('checkout.merci');

});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
