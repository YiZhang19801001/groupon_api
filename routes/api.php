<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('user', function (Request $request) {
//     return $request->user();
// });

Route::get("initial", "InitController@index");

Route::get('products/{product_id}', 'ProductController@show');
Route::get('products', 'ProductController@index');
Route::post('products', 'ProductController@create');
Route::put('products/{product_id}', 'ProductController@update');
Route::patch('products/{product_id}', 'ProductController@switchProductStatus');

Route::get('categories', 'CategoryController@index');
Route::get('categories/{category_id}', 'CategoryController@show');
Route::post('categories', 'CategoryController@create');
Route::put('categories/{category_id}', 'CategoryController@update');
Route::delete("categories/{category_id}", "CategoryController@delete");

Route::get('options', 'OptionController@index');
Route::post("options", "OptionController@create");

Route::get('locations', 'LocationController@index');
Route::get('locations/{location_id}', 'LocationController@show');
Route::post('locations', 'LocationController@create');
Route::put('locations/{location_id}', 'LocationController@update');

Route::get('reports', 'ReportsController@summary');

// The registration and login requests doesn't come with tokens
// as users at that point have not been authenticated yet
// Therefore the jwtMiddleware will be exclusive of them
Route::post('user/login', 'UserController@login');
Route::post('user/register', 'UserController@register');

Route::group(['middleware' => ['jwt.auth']], function () {
// all routes to protected resources are registered here
    Route::get('users/list', function () {
        $users = App\User::all();
        $response = ['success' => true, 'data' => $users];
        return response()->json($response, 201);
    });
    Route::get("user", function (Request $request) {
        return response()->json($request->user(), 200);
    });

    Route::get('orders', 'OrderController@index');
    Route::post('orders', 'OrderController@create');
    Route::delete('order/{order_id}', 'OrderController@remove');
});

Route::post('convert', 'OrderController@convertOrderToShoppingCartList');

Route::get('allorders', 'OrderController@getAll');
Route::get('orders/{order_id}', 'OrderController@show');
Route::put("orders/{order_id}", "OrderController@update");
Route::patch("orders/{order_id}", "OrderController@updateStatus");

Route::post('layout', "LayoutTextController@create");
