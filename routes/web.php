    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by tRouteServiceProviderhe RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'rest'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::get('/find-by-name', ['uses' => 'Rests\ProductRestController@findByName']);
        Route::get('/find-by-collection', ['uses' => 'Rests\ProductRestController@findByCollection']);
        Route::get('/find-all', ['uses' => 'Rests\ProductRestController@findAll']);
        Route::get('/find-featured', ['uses' => 'Rests\ProductRestController@findFeatured']);
        Route::get('/find-on-sale', ['uses' => 'Rests\ProductRestController@findOnSale']);
        Route::get('/find-trending', ['uses' => 'Rests\ProductRestController@findTrending']);
        Route::get('/detail', ['uses' => 'Rests\ProductRestController@detail']);
    });
    Route::group(['prefix' => 'category'], function () {
        Route::get('/find-all', ['uses' => 'Rests\CategoryRestController@findAll']);
        Route::get('/find-featured', ['uses' => 'Rests\CategoryRestController@findFeatured']);
        Route::get('/find-top', ['uses' => 'Rests\CategoryRestController@findTop']);
    });
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/find-all', ['uses' => 'Rests\BlogRestController@findAll']);
        Route::get('/detail', ['uses' => 'Rests\BlogRestController@detail']);
        Route::get('/related', ['uses' => 'Rests\BlogRestController@related']);
        Route::get('/recent', ['uses' => 'Rests\BlogRestController@recent']);
    });

    Route::group(['prefix' => 'with-list'], function () {
        Route::get('/find-all', ['uses' => 'Rests\WithListRestController@findAll']);
        Route::get('/count', ['uses' => 'Rests\WithListRestController@count']);
        Route::post('/save', ['uses' => 'Rests\WithListRestController@store']);
        Route::post('/delete', ['uses' => 'Rests\WithListRestController@destroy']);
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/find-all', ['uses' => 'Rests\CartRestController@findAll']);
        Route::get('/count', ['uses' => 'Rests\CartRestController@count']);
        Route::post('/add', ['uses' => 'Rests\CartRestController@store']);
        Route::post('/update', ['uses' => 'Rests\CartRestController@update']);
        Route::post('/remove', ['uses' => 'Rests\CartRestController@remove']);
    });

    Route::group(['prefix' => 'collection'], function () {
        Route::get('/find-all', ['uses' => 'Rests\CollectionRestController@findAll']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('/check-out', ['uses' => 'Rests\OrderRestController@checkOut']);
    });

    Route::post('/tai-anh', ['as' => 'uploadImage', 'uses' => 'Rests\UploadRestController@storeImage']);
});


Route::group(['middleware' => 'isMember', 'prefix' => 'quan-tri'], function () {
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

    Route::group(['middleware' => 'isAdmin', 'prefix' => 'nhan-vien'], function () {
        Route::get('', ['as' => 'userView', 'uses' => 'UserController@index']);
        Route::get('/them-moi', ['as' => 'createUserView', 'uses' => 'UserController@create']);
        Route::get('/chinh-sua/{id}', ['as' => 'updateUserView', 'uses' => 'UserController@edit']);
        Route::post('/luu-tru', ['as' => 'createUser', 'uses' => 'UserController@store']);
        Route::post('/cap-nhat/{id}', ['as' => 'updateUser', 'uses' => 'UserController@update']);
        Route::post('/xoa/{id}', ['as' => 'deleteUser', 'uses' => 'UserController@destroy']);
    });
});

Route::group(['prefix' => '/'], function () {
    Route::get('', ['as' => 'indexView', 'uses' => 'IndexController@index']);
});

//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified'
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');
//});
