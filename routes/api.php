<?php

use App\Http\Controllers\Rests\AuthRestController;
use App\Http\Controllers\Rests\BlogRestController;
use App\Http\Controllers\Rests\CartRestController;
use App\Http\Controllers\Rests\CategoryRestController;
use App\Http\Controllers\Rests\CollectionRestController;
use App\Http\Controllers\Rests\OrderRestController;
use App\Http\Controllers\Rests\ProductRestController;
use App\Http\Controllers\Rests\UploadRestController;
use App\Http\Controllers\Rests\WithListRestController;
use App\Http\Controllers\Rests\ReviewRestController;
use Illuminate\Http\Request;
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

// Below mention routes are available only for the authenticated users.

Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['prefix' => 'with-list'], function () {
        Route::get('/find-all', [WithListRestController::class, 'findAll']);
        Route::get('/count', [WithListRestController::class, 'count']);
        Route::post('/save', [WithListRestController::class, 'store']);
        Route::post('/delete', [WithListRestController::class, 'destroy']);
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [AuthRestController::class, 'logout']);
        Route::post('/refresh', [AuthRestController::class, 'refresh']);
        Route::get('/user-profile', [AuthRestController::class, 'userProfile']);
        Route::post('/change-pass', [AuthRestController::class, 'changePassWord']);
        Route::post('/update', [AuthRestController::class, 'update']);
        Route::get('/is-authenticated', [AuthRestController::class, 'isAuthenticated']);
    });

    Route::group(['prefix' => 'review'], function () {
        Route::post('/save', [ReviewRestController::class, 'save']);
        Route::post('/delete', [ReviewRestController::class, 'delete']);
        Route::get('/find-by-product', [ReviewRestController::class, 'findByProduct']);
        Route::get('/count-by-product', [ReviewRestController::class, 'countByProduct']);
    });
});


Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthRestController::class, 'register']);
    Route::post('/login', [AuthRestController::class, 'login']);
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/find-by-name', [ProductRestController::class, 'findByName']);
    Route::get('/find-by-collection', [ProductRestController::class, 'findByCollection']);
    Route::get('/find-all', [ProductRestController::class, 'findAll']);
    Route::get('/find-featured', [ProductRestController::class, 'findFeatured']);
    Route::get('/find-on-sale', [ProductRestController::class, 'findOnSale']);
    Route::get('/find-trending', [ProductRestController::class, 'findTrending']);
    Route::get('/detail', [ProductRestController::class, 'detail']);
});
Route::group(['prefix' => 'category'], function () {
    Route::get('/find-all', [CategoryRestController::class, 'findAll']);
    Route::get('/find-featured', [CategoryRestController::class, 'findFeatured']);
    Route::get('/find-top', [CategoryRestController::class, 'findTop']);
});
Route::group(['prefix' => 'blog'], function () {
    Route::get('/find-all', [BlogRestController::class, 'findAll']);
    Route::get('/detail', [BlogRestController::class, 'detail']);
    Route::get('/related', [BlogRestController::class, 'related']);
    Route::get('/recent', [BlogRestController::class, 'recent']);
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/find-all', [CartRestController::class, 'findAll']);
    Route::get('/count', [CartRestController::class, 'count']);
    Route::post('/add', [CartRestController::class, 'store']);
    Route::post('/update', [CartRestController::class, 'update']);
    Route::post('/remove', [CartRestController::class, 'remove']);
});

Route::group(['prefix' => 'collection'], function () {
    Route::get('/find-all', [CollectionRestController::class, 'findAll']);
});

Route::group(['prefix' => 'order'], function () {
    Route::post('/check-out', [OrderRestController::class, 'checkOut']);
});

Route::post('/tai-anh', ['as' => 'uploadImage', UploadRestController::class, 'storeImage']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


