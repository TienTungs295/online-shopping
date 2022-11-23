<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CustomerAccount;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_pending_order = Order::where('status', 1)->count();
        $total_pending_review = Review::where('status', 1)->count();
        $total_product = Product::all()->count();
        $total_post = Blog::all()->count();
        $total_category = ProductCategory::all()->count();
        $total_customer_account = CustomerAccount::all()->count();
        return View('backend.home.index',
            compact("total_pending_order",
                "total_pending_review",
                "total_product",
                "total_post",
                "total_category",
                "total_customer_account"));
    }

}
