<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Http\Responses\AjaxResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ReviewRestController extends Controller
{
    public function save(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $review = new Review();
        $comment = $request->post("comment");
        if (!isset($comment))
            return $ajax_response->setMessage("Đánh giá không được phép bỏ trống")->toApiResponse();
        $review->comment = $comment;
        $review->star = 5;
        $review->status = 1;
        $review->product_id = $request->post("product_id");
        $review->customer_id = auth()->user()->id;
        $review->save();
        return $ajax_response->setData($review)->toApiResponse();
    }

    public function delete(Request $request)
    {
        $ajax_response = new AjaxResponse();
        try {
            $review = Review::findOrFail($request->input("id"));
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Đánh giá không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        if ($review->customer_id != auth()->user()->id) {
            return $ajax_response->setMessage("Bạn không có quyền xóa đánh giá này")->toApiResponse();
        }
        $review->delete();
        return $ajax_response->setData($review)->toApiResponse();
    }

    public function findByProduct(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $product_id = $request->input("product_id");
        try {
            Product::findOrFail($product_id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Sản phẩm không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $reviews = Review::with(['customer'])
            ->where('product_id', $product_id)
            ->where('status', 2)
            ->orderBy('created_at', 'DESC')
            ->paginate(15)
            ->toArray();
        return $ajax_response->setData($reviews)->toApiResponse();
    }

    public function countByProduct(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $product_id = $request->input("product_id");
        try {
            Product::findOrFail($product_id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Sản phẩm không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $count = Review::where('status', 2)->where('product_id', $product_id)->count();
        return $ajax_response->setData($count)->toApiResponse();
    }
}
