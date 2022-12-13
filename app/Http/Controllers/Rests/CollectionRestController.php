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
        $collections = ProductCollection::orderByRaw('ISNULL(priority), priority ASC')->orderBy('updated_at', 'DESC')->get();
        return $ajax_response->setData($collections)->toApiResponse();
    }
}
