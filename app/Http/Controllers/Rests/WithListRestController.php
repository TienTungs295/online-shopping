<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\WithList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WithListRestController extends Controller
{
    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $data = WithList::all();
        foreach ($data as $item) {
            $item->product = $item->product()->first();
        }
        return $ajax_response->setData($data)->toApiResponse();
    }

    public function count(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $count = WithList::where('customer_id',1)->count();
        return $ajax_response->setData($count)->toApiResponse();
    }

    public function store(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $ajax_response->setMessage("Sản phẩm đã tồn tại trong danh sách yêu thích!");
        $count = WithList::where('customer_id', 1)
            ->where('product_id', $request->post('product_id'))
            ->count();
        if ($count > 0) return $ajax_response->toApiResponse();

        $with_list = new WithList();
        $with_list->customer_id = 1;
        $with_list->product_id = $request->post('product_id');
        $with_list->save();
        $ajax_response->setMessage("Thêm sản phẩm vào danh sách yêu thích thành công!");
        return $ajax_response->setData($with_list)->toApiResponse();
    }

    public function destroy(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $ajax_response->setMessage("Đối tượng không tồn tại hoặc đã bị xóa!");
        try {
            $with_list = WithList::findOrFail($request->post("id"));
        } catch (ModelNotFoundException $e) {
            return $ajax_response->toApiResponse();
        }
        $with_list->delete();
        $ajax_response->setMessage("Xóa sản phẩm trong danh sách thành công!");
        return $ajax_response->setData($with_list)->toApiResponse();
    }

}
