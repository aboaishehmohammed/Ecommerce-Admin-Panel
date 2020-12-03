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
Route::get("images/{image}", "App\Http\Controllers\ImageController@getImage");

Route::prefix("admin")->group(function () {
    Route::prefix("categories")->group(function () {
        Route::get("/", 'App\Http\Controllers\CategoryController@index');
    });

    Route::prefix("sub-categories")->group(function () {
        Route::get("/", 'App\Http\Controllers\SubCategoryController@index');
    });

    Route::prefix("products")->group(function () {
        Route::get("/", 'App\Http\Controllers\ProductController@index');
    });

    Route::prefix("bills")->group(function () {
        Route::get("/", 'App\Http\Controllers\BillController@index');
    });
    Route::prefix("reports")->group(function () {
        Route::get("/", 'App\Http\Controllers\BillController@indexReport');
    });


});

Route::prefix("adminData")->group(function () {
    Route::prefix("categories")->group(function () {
        Route::get("/", 'App\Http\Controllers\CategoryController@ajaxAll');
        Route::post("/", 'App\Http\Controllers\CategoryController@store');
        Route::get('paginate', 'App\Http\Controllers\CategoryController@paginate');
        Route::get("/{category}", 'App\Http\Controllers\CategoryController@ajaxOne');
        Route::post("{category}", 'App\Http\Controllers\CategoryController@update');
        Route::delete("{category}", 'App\Http\Controllers\CategoryController@destroy');
        Route::patch("{category}", 'App\Http\Controllers\CategoryController@restore');

    });
    Route::prefix("sub-categories")->group(function () {
        Route::get("/", 'App\Http\Controllers\SubCategoryController@ajaxAll');
        Route::post("/", 'App\Http\Controllers\SubCategoryController@store');
        Route::get('paginate', 'App\Http\Controllers\SubCategoryController@paginate');
        Route::get("/{sub_category}", 'App\Http\Controllers\SubCategoryController@ajaxOne');
        Route::post("{sub_category}", 'App\Http\Controllers\SubCategoryController@update');
        Route::delete("{sub_category}", 'App\Http\Controllers\SubCategoryController@destroy');
        Route::patch("{sub_category}", 'App\Http\Controllers\SubCategoryController@restore');

    });

    Route::prefix("products")->group(function () {
        Route::get("/", 'App\Http\Controllers\ProductController@ajaxAll');
        Route::post("/", 'App\Http\Controllers\ProductController@store');
        Route::post('paginate', 'App\Http\Controllers\ProductController@paginate');
        Route::get("/{products}", 'App\Http\Controllers\ProductController@ajaxOne');
        Route::post("{product}", 'App\Http\Controllers\ProductController@update');
        Route::delete("{product}", 'App\Http\Controllers\ProductController@destroy');
        Route::patch("{product}", 'App\Http\Controllers\ProductController@restore');

    });
    Route::prefix("bills")->group(function () {
        Route::post('/', 'App\Http\Controllers\BillController@store');
        Route::get('/', 'App\Http\Controllers\BillController@ajaxAll');
        Route::get('/paginate', 'App\Http\Controllers\BillController@paginate');
        Route::post('reports', 'App\Http\Controllers\BillController@report');
        Route::post('reports/{str}', 'App\Http\Controllers\BillController@report');

        Route::post('/order/{bill}', 'App\Http\Controllers\BillController@orderDone');
        Route::get('{bill}', 'App\Http\Controllers\BillController@ajaxOne');
        Route::delete('{bill}', 'App\Http\Controllers\BillController@destroy');
        Route::patch('{bill}', 'App\Http\Controllers\BillController@restore');
    });
});


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
