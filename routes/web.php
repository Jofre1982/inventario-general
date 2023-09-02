<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Route::resource('categories','App\Http\Controllers\CategoryController');
Route::resource('clients','App\Http\Controllers\ClientController');
Route::resource('products','App\Http\Controllers\ProductController');
Route::resource('providers','App\Http\Controllers\ProviderController');
Route::resource('purchases','App\Http\Controllers\PurchaseController')->except(['edit','update','destroy']);
Route::resource('sales','App\Http\Controllers\SaleController')->except(['edit','update','destroy']);

Route::get('purchases/pdf/{purchase}','App\Http\Controllers\PurchaseController@pdf')->name('purchases.pdf');
Route::get('sales/pdf/{sale}','App\Http\Controllers\SaleController@pdf')->name('sales.pdf');
Route::get('sales/print/{sale}','App\Http\Controllers\SaleController@print')->name('sales.print');

Route::resource('business','BusinessController')->only(['index','update']);
Route::resource('printer','PrinterController')->only(['index','update']);

Route::get('purchases/upload/{purchase}','App\Http\Controllers\SaleController@upload')->name('upload.purchases');

Route::get('change_status/products/{product}','App\Http\Controllers\ProductController@change_status')->name('change.status.product');
Route::get('change_status/purchases/{purchase}','App\Http\Controllers\PurchaseController@change_status')->name('change.status.purchase');
Route::get('change_status/sales/{sale}','App\Http\Controllers\SaleController@change_status')->name('change.status.sale');

Route::get('sales/reports_day','App\Http\Controllers\SaleController@reports_day')->name('reports.day');
Route::get('sales/reports_date','App\Http\Controllers\SaleController@reports_date')->name('reports.date');

Route::post('sales/reports_results','App\Http\Controllers\SaleController@reports_results')->name('reports.results');

Route::get('/users', function () {
    return view('users.index');

	

});


Auth::routes();


Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

