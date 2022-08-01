<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRestController extends Controller
{
    public function findByName(Request $request)
    {
        $name = $request->input('name');
        $exclude_id = $request->input('exclude_id');
        $product_query = Product::where('id', '>', 0);
        if (isset($exclude_id)) {
            $product_query->where('id', '!=', $exclude_id);
        };
        $products = $product_query->where('name', 'like', '%' . $name . '%')->get();
        return response()->json(["status" => "success", "data" => compact('products')]);
    }
}
