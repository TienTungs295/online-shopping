<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\ProductCollection;
use Illuminate\Http\Request;

class CollectionRestController extends Controller
{
    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $collections = ProductCollection::all();
        return $ajax_response->setData($collections)->toApiResponse();
    }
}
