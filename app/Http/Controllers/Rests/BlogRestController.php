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
        $next_blog = Blog::where('id', '>', $id)->first();
        $prev_blog = Blog::where('id', '<', $id)->orderBy('id','DESC')->first();
        return $ajax_response->setData(array(
            'prev_blog' => $prev_blog,
            'blog' => $blog,
            'next_blog' => $next_blog
        ))->toApiResponse();
    }

    public function related(Request $request)
    {
        $id = $request->input("id");
        $ajax_response = new AjaxResponse();
        $blogs = Blog::where('id', '!=', $id)->take(2)->get();
        return $ajax_response->setData($blogs)->toApiResponse();
    }

    public function recent(Request $request)
    {
        $id = $request->input("id");
        $ajax_response = new AjaxResponse();
        $query = Blog::where('id', '>', 1);
        if (isset($id)) $query->where('id', '!=', $id);
        $blogs = $query->orderBy('updated_at', 'DESC')->take(3)->get();
        return $ajax_response->setData($blogs)->toApiResponse();
    }
}
