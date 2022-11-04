    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Rests\WithListRestController;
use App\Http\Controllers\Rests\CartRestController;
use App\Http\Controllers\Rests\OrderRestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by RouteServiceProvider RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['isMember','auth:web'], 'prefix' => 'quan-tri'], function () {
    Route::get('/', ['as' => 'homeView', 'uses' => 'HomeController@index']);
    Route::group(['prefix' => 'nhan-san-pham'], function () {
        Route::get('', ['as' => 'labelView', 'uses' => 'ProductLabelController@index']);
        Route::get('/them-moi', ['as' => 'createLabelView', 'uses' => 'ProductLabelController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateLabelView', 'uses' => 'ProductLabelController@edit']);
        Route::post('/luu-tru', ['as' => 'createLabel', 'uses' => 'ProductLabelController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateLabel', 'uses' => 'ProductLabelController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteLabel', 'uses' => 'ProductLabelController@destroy']);
    });

    Route::group(['prefix' => 'bo-suu-tap'], function () {
        Route::get('', ['as' => 'collectionView', 'uses' => 'ProductCollectionController@index']);
        Route::get('/them-moi', ['as' => 'createCollectionView', 'uses' => 'ProductCollectionController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateCollectionView', 'uses' => 'ProductCollectionController@edit']);
        Route::post('/luu-tru', ['as' => 'createCollection', 'uses' => 'ProductCollectionController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateCollection', 'uses' => 'ProductCollectionController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteCollection', 'uses' => 'ProductCollectionController@destroy']);
    });

    Route::group(['prefix' => 'danh-muc'], function () {
        Route::get('', ['as' => 'categoryView', 'uses' => 'ProductCategoryController@index']);
        Route::get('/them-moi', ['as' => 'createCategoryView', 'uses' => 'ProductCategoryController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateCategoryView', 'uses' => 'ProductCategoryController@edit']);
        Route::post('/luu-tru', ['as' => 'createCategory', 'uses' => 'ProductCategoryController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateCategory', 'uses' => 'ProductCategoryController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteCategory', 'uses' => 'ProductCategoryController@destroy']);
    });

    Route::group(['prefix' => 'bai-viet'], function () {
        Route::get('', ['as' => 'blogView', 'uses' => 'BlogController@index']);
        Route::get('/them-moi', ['as' => 'createBlogView', 'uses' => 'BlogController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateBlogView', 'uses' => 'BlogController@edit']);
        Route::post('/luu-tru', ['as' => 'createBlog', 'uses' => 'BlogController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateBlog', 'uses' => 'BlogController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteBlog', 'uses' => 'BlogController@destroy']);
    });

    Route::group(['prefix' => 'flash-sale'], function () {
        Route::get('', ['as' => 'flashSaleView', 'uses' => 'FlashSaleController@index']);
        Route::get('/them-moi', ['as' => 'createFlashSaleView', 'uses' => 'FlashSaleController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateFlashSaleView', 'uses' => 'FlashSaleController@edit']);
        Route::post('/luu-tru', ['as' => 'createFlashSale', 'uses' => 'FlashSaleController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateFlashSale', 'uses' => 'FlashSaleController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteFlashSale', 'uses' => 'FlashSaleController@destroy']);
    });

    Route::group(['prefix' => 'ma-giam-gia'], function () {
        Route::get('', ['as' => 'discountView', 'uses' => 'DiscountController@index']);
        Route::get('/them-moi', ['as' => 'createDiscountView', 'uses' => 'DiscountController@create']);
        Route::post('/luu-tru', ['as' => 'createDiscount', 'uses' => 'DiscountController@store']);
        Route::post('/xoa/{id}', ['as' => 'deleteDiscount', 'uses' => 'DiscountController@destroy']);
    });

    Route::group(['prefix' => 'san-pham'], function () {
        Route::get('', ['as' => 'productView', 'uses' => 'ProductController@index']);
        Route::get('/them-moi', ['as' => 'createProductView', 'uses' => 'ProductController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateProductView', 'uses' => 'ProductController@edit']);
        Route::post('/luu-tru', ['as' => 'createProduct', 'uses' => 'ProductController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateProduct', 'uses' => 'ProductController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteProduct', 'uses' => 'ProductController@destroy']);
    });

    Route::group(['prefix' => 'don-hang'], function () {
        Route::get('', ['as' => 'orderView', 'uses' => 'OrderController@index']);
        Route::get('/them-moi', ['as' => 'createOrderView', 'uses' => 'OrderController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateOrderView', 'uses' => 'OrderController@edit']);
        Route::post('/luu-tru', ['as' => 'createOrder', 'uses' => 'OrderController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateOrder', 'uses' => 'OrderController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteOrder', 'uses' => 'OrderController@destroy']);
        Route::post('/cap-nhat-trang-thai/{id}', ['as' => 'changeOrderStatus', 'uses' => 'OrderController@changeStatus']);
    });

    Route::group(['prefix' => 'danh-gia'], function () {
        Route::get('', ['as' => 'reviewView', 'uses' => 'ReviewController@index']);
        Route::post('/xoa/{id}', ['as' => 'deleteReview', 'uses' => 'ReviewController@destroy']);
        Route::post('/cap-nhat-trang-thai/{id}', ['as' => 'changeReviewStatus', 'uses' => 'ReviewController@changeStatus']);
    });

    Route::group(['middleware' => 'isAdmin', 'prefix' => 'nhan-vien'], function () {
        Route::get('', ['as' => 'userView', 'uses' => 'UserController@index']);
        Route::get('/them-moi', ['as' => 'createUserView', 'uses' => 'UserController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateUserView', 'uses' => 'UserController@edit']);
        Route::post('/luu-tru', ['as' => 'createUser', 'uses' => 'UserController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateUser', 'uses' => 'UserController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteUser', 'uses' => 'UserController@destroy']);
    });
});

Route::group(['prefix' => 'rest'], function () {
    Route::group(['prefix' => 'cart'], function () {
        Route::get('/find-all', [CartRestController::class, 'findAll']);
        Route::get('/count', [CartRestController::class, 'count']);
        Route::post('/add', [CartRestController::class, 'store']);
        Route::post('/update', [CartRestController::class, 'update']);
        Route::post('/remove', [CartRestController::class, 'remove']);
        Route::post('/apply-coupon', [CartRestController::class, 'applyCoupon']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('/check-out', [OrderRestController::class, 'checkOut']);
    });

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => 'with-list'], function () {
            Route::get('/find-all', [WithListRestController::class, 'findAll']);
            Route::get('/count', [WithListRestController::class, 'count']);
            Route::post('/save', [WithListRestController::class, 'store']);
            Route::post('/delete', [WithListRestController::class, 'destroy']);
        });
    });
});

Route::any('{all}', function () {
    return view('frontend.index');
})->where(['all' => '^((?!rest|quan-tri).)*$']);;

//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified'
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');
//});
