<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryRestController extends Controller
{
    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $categories = ProductCategory::all();
        return $ajax_response->setData($categories)->toApiResponse();
    }

    public function findAllWithCount(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $categories = ProductCategory::all();
        return $ajax_response->setData($categories)->toApiResponse();
    }

    public function findTop(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $categories = ProductCategory::where('is_featured', true)->limit(5)->get();
        return $ajax_response->setData($categories)->toApiResponse();
    }
}
