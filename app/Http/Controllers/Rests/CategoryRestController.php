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
        $categories = ProductCategory::withCount('products')->orderBy('updated_at', 'DESC')->get();
        return $ajax_response->setData($categories)->toApiResponse();
    }

    public function findFeatured(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $categories = ProductCategory::where('is_featured', true)->orderBy('updated_at', 'DESC')->limit(5)->get();
        return $ajax_response->setData($categories)->toApiResponse();
    }

    public function findTop(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $categories = ProductCategory::where('is_featured', true)
            ->orderBy('updated_at', 'DESC')
            ->limit(10)->get();
        return $ajax_response->setData($categories)->toApiResponse();
    }
}
