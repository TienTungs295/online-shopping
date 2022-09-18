<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\Product;
use Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WithListRestController extends Controller
{
    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $data = Cart::instance('withList')->content();
        return $ajax_response->setData($data)->toApiResponse();
    }

    public function count(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $count = Cart::instance('withList')->count();
        return $ajax_response->setData($count)->toApiResponse();
    }

    public function store(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $product_id = $request->post('product_id');
        try {
            $product = Product::findOrFail($product_id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Sản phẩm hiện không được bày bán!")->toApiResponse();
        }

        $existProduct = Cart::instance('withList')->search(function ($item, $row_id) use ($product_id) {
            return $item->id == $product_id;
        });
        if ($existProduct->count() > 0) return $ajax_response->setMessage("Sản phẩm đã tồn tại trong danh sách yêu thích!")->toApiResponse();

        Cart::instance('withList')->add(['id' => $product_id, 'name' => $product->name, 'price' => $product->real_price, 'qty' => 1, 'options' => [
            'image' => $product->image,
            'slug' => $product->slug,
            'price' => $product->price,
            'on_sale' => $product->on_sale,
            'sale_off' => $product->sale_off]]);
        return $ajax_response->setData(Cart::instance('withList')->content())
            ->setMessage("Thêm sản phẩm " . $product->name . " danh sách yêu thích thành công!")
            ->toApiResponse();
    }

    public function destroy(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $rowId = $request->post('row_id');
        Cart::instance('withList')->remove($rowId);
        return $ajax_response->setData($rowId)->toApiResponse();
    }

}
