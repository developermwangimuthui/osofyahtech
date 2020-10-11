<?php

use Illuminate\Support\Facades\Auth;
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



Auth::routes(['verify' => true, 'register' => false]);
Route::get('/', 'HomeController@index')->name('index');
Route::get('/single-service/{id}', 'HomeController@singleService')->name('singleService');
// Route::get('/contact-us', 'HomeController@Contact')->name('contact');
Route::get('/About-us', 'HomeController@about')->name('about');
Route::get('/shop/products', 'HomeController@shop')->name('shop');
Route::get('/shop/products/category/{id}', 'HomeController@productCategory')->name('productCategory');
Route::get('/shop/product-details/{id}', 'HomeController@singleProduct')->name('singleproduct');
Route::get('/account/inquiries', 'HomeController@cart')->name('cart');
Route::get('/enquiry', 'HomeController@enquiry')->name('enquiry');
Route::post('/enquiry-submit', 'HomeController@submitEnquiry')->name('submitEnquiry');
// Route::get('/account/checkout', 'HomeController@checkout')->name('checkout');
// Route::get('/account/orders', 'HomeController@allorders')->name('orders');
// Route::get('/account/singleOrder/{id}', 'HomeController@singleOrder')->name('singleOrder');
Route::get('/product/select2', 'HomeController@getProducts')->name('search-products');



Route::group(['middleware' => 'auth'], function () {
Route::get('/dashboard/index', 'HomeController@dashboard')->name('dashboard');



// ..................Services..............................//
Route::get('/service/index', 'ServiceController@index')->name('service.index');
Route::post('/service/store', 'ServiceController@store')->name('service.store');
Route::get('/service/edit/{id}', 'ServiceController@edit')->name('service.edit');
Route::post('/service/update/{id}', 'ServiceController@update')->name('service.update');
Route::delete('/service/destroy/', 'ServiceController@destroy')->name('service.destroy');
Route::delete('/service/photo/destroy/', 'ServiceController@photoDestroy')->name('service.photo.destroy');

// ...............................Orders..........................//
Route::get('/order/index', 'OrderController@index')->name('order.index');
Route::put('/order/change/status', 'OrderController@changeStatus')->name('order.changeStatus');
Route::get('/order/update/{id}', 'OrderController@update')->name('order.update');
Route::get('/order/edit/{id}', 'OrderController@edit')->name('order.edit');
Route::get('/order/chart', 'OrderController@chart')->name('order.chart');

// ...............................enquire..........................//
Route::get('/enquiry/index', 'InquiryController@index')->name('enquiry.index');
Route::delete('/enquiry/destroy', 'InquiryController@destroy')->name('enquiry.destroy');


// ..................Products..............................//
Route::get('/product/index', 'ProductController@index')->name('product.index');
Route::post('/product/store', 'ProductController@store')->name('product.store');
Route::get('/product/edit/{id}', 'ProductController@edit')->name('product.edit');
Route::post('/product/update/{id}', 'ProductController@update')->name('product.update');
Route::delete('/product/destroy/', 'ProductController@destroy')->name('product.destroy');
Route::delete('/photo/destroy/', 'ProductController@photoDestroy')->name('photo.destroy');

// ..................serviceProduct..............................//
Route::get('/serviceProduct/index', 'ServiceProductController@index')->name('serviceProduct.index');
Route::post('/serviceProduct/store', 'ServiceProductController@store')->name('serviceProduct.store');
Route::get('/serviceProduct/edit/{id}', 'ServiceProductController@edit')->name('serviceProduct.edit');
Route::post('/serviceProduct/update/{id}', 'ServiceProductController@update')->name('serviceProduct.update');
Route::delete('/serviceProduct/destroy/', 'ServiceProductController@destroy')->name('proserviceProductduct.destroy');
Route::delete('/serviceProductphoto/destroy/', 'ServiceProductController@photoDestroy')->name('serviceProduct.destroy');

// ..................Category..............................//
Route::get('/category/index', 'CategoryController@index')->name('category.index');
Route::post('/category/store', 'CategoryController@store')->name('category.store');
Route::get('/category/edit/{id}', 'CategoryController@edit')->name('category.edit');
Route::post('/category/update/{id}', 'CategoryController@update')->name('category.update');
Route::delete('/category/destroy/', 'CategoryController@destroy')->name('category.destroy');

// ..................Slider..............................//
Route::get('/slider/index', 'SliderController@index')->name('slider.index');
Route::post('/slider/store', 'SliderController@store')->name('slider.store');
Route::get('/slider/edit/{id}', 'SliderController@edit')->name('slider.edit');
Route::post('/slider/update/{id}', 'SliderController@update')->name('slider.update');
Route::delete('/slider/destroy/', 'SliderController@destroy')->name('slider.destroy');

// ..................ProjectGallery..............................//
// Route::get('/projectgallery/index', 'ProjectGalleryController@index')->name('projectgallery.index');
// Route::get('/projectgallery/edit/{id}', 'ProjectGalleryController@edit')->name('projectgallery.edit');
// Route::get('/projectgallery/update/{id}', 'ProjectGalleryController@update')->name('projectgallery.update');
// Route::delete('/projectgallery/destroy/', 'ProjectGalleryController@destroy')->name('projectgallery.destroy');


// Route::get('/home', 'HomeController@index')->name('home');

// ...........................................Cart........................//

Route::post('/cartItems/update', 'CartController@cartUpdate')->name('cartItems.update');
Route::post('/cartItems/delete', 'CartController@cartDelete')->name('cartItems.delete');
// ...............Orders...............................//

Route::get('/orders/singleBackendOrder/{id}', 'OrderController@singleBackendkOrder')->name('singleBackendkOrder');
Route::post('/order/place', 'OrderController@placeOrder')->name('order.place');
});
