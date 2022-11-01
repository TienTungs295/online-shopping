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
        $star = $request->post("star");
        if (is_null($star) || $star == 0)
            return $ajax_response->setMessage("Vui lòng chọn số sao")->toApiResponse();
        if ($star < 1 || $star > 5)
            return $ajax_response->setMessage("Số sao không hợp lệ")->toApiResponse();
        if (!isset($comment))
            return $ajax_response->setMessage("Đánh giá không được phép bỏ trống")->toApiResponse();
        $review->comment = $comment;
        $review->star = $star;
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
            return $ajax_response->setMessage("Bạn không đủ quyền thực hiện tác vụ này")->toApiResponse();
        }
        $review->delete();
        return $ajax_response->setData($review)->toApiResponse();
    }

    public function findByProduct(Request $request)
    {
        $page_size = 10;
        $hasMorePage = false;
        $last_id = $request->input("last_id");
        $ajax_response = new AjaxResponse();
        $product_id = $request->input("product_id");
        $user = auth()->user();
        try {
            Product::findOrFail($product_id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Sản phẩm không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $query = Review::with(['customer'])->where(function ($query) use ($product_id, $last_id, $user) {
            $query->where('product_id', $product_id);
            if (!is_null($last_id)) $query->where('id', '<', $last_id);
            $query->where(function ($query) use ($last_id, $user) {
                $query->where('status', 2);
                if ($user != null) {
                    $query->orWhere(function ($query) use ($user) {
                        $query->where('status', 1);
                        $query->where('customer_id', $user->id);
                    });
                }
            });
        });
        $reviews = $query->take($page_size + 1)->get()->toArray();
        if (sizeof($reviews) > $page_size) {
            $hasMorePage = true;
            array_pop($reviews);
        }

        //count total reviews
        $totalReviews = Review::where('product_id', $product_id)
            ->where(function ($query) use ($user) {
                $query->where('status', 2);
                if (!is_null($user)) {
                    $query->orWhere(function ($query) use ($user) {
                        $query->where('status', 1);
                        $query->where('customer_id', $user->id);
                    });
                }
            })->count();
        return $ajax_response->setData(array('data' => $reviews, 'hasMorePage' => $hasMorePage, 'totalReviews' => $totalReviews))->toApiResponse();
    }
}
