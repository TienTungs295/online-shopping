<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\Blog;
use App\Models\ProductCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BlogRestController extends Controller
{

    public function findAll(Request $request)
    {
        $page_size = $request->input("page_size");
        if (!isset($page_size)) $page_size = 3;
        $ajax_response = new AjaxResponse();
        $blogs = Blog::orderBy("updated_at", "DESC")->paginate($page_size);
        return $ajax_response->setData($blogs)->toApiResponse();
    }

    public function detail(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $id = $request->input("id");
        $blog = null;
        try {
            $blog = Blog::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Đối tượng không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        return $ajax_response->setData($blog)->toApiResponse();
    }

    public function related(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $id = $request->input("id");
        $ajax_response = new AjaxResponse();
        $blogs = Blog::where('id', '!=', $id)->random(3);
        return $ajax_response->setData($blogs)->toApiResponse();
    }
}
