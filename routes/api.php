<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix("bills")->group(function () {
    Route::get('/address/{user_id}', 'App\Http\Controllers\AddressController@ajaxAll');
    Route::get('/cities', 'App\Http\Controllers\AddressController@getCities');
    Route::post('/carts', 'App\Http\Controllers\BillController@getProducts');
    Route::get('/{bill}', 'App\Http\Controllers\BillController@ajaxOne');
    Route::post('/address', 'App\Http\Controllers\AddressController@store');
    Route::post('/', 'App\Http\Controllers\BillController@store');
    Route::post('/reports', 'App\Http\Controllers\BillController@report');
});

Route::prefix("products")->group(function () {
    Route::get("paginate/{sub_category}", 'App\Http\Controllers\ProductController@paginate');
    Route::get("/{products}", 'App\Http\Controllers\ProductController@ajaxOne');
    Route::get("", 'App\Http\Controllers\ProductController@getRandomProduct');
});

Route::get("/image", 'App\Http\Controllers\ImageController@destroy');
Route::prefix("categories")->group(function () {
    Route::get("/", 'App\Http\Controllers\CategoryController@ajaxAll');
    Route::get("/{category}", 'App\Http\Controllers\CategoryController@ajaxOne');
});

Route::prefix("sub-categories")->group(function () {
    Route::get("/", 'App\Http\Controllers\SubCategoryController@ajaxAll');
    Route::get("/{sub_category}", 'App\Http\Controllers\SubCategoryController@ajaxOne');
    Route::post("/{subCategory}/get-products",'App\Http\Controllers\ProductController@getProductsBySubCateogryPaginated');
});

Route::get("images/{image}","App\Http\Controllers\ImageController@getImage");

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'App\Http\Controllers\Auth\ApiController@login');
    Route::post('signup', 'App\Http\Controllers\Auth\ApiController@register');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'App\Http\Controllers\ApiAuthController@logout');
        Route::get('user', 'App\Http\Controllers\ApiAuthController@user');
    });
});

