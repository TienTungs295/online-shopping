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
        $withList = Cart::instance($this->getName())->content();
        $product_ids = [];
        $cartMap = array();
        foreach ($withList as $key => $item) {
            $product_id = $item->id;
            array_push($product_ids, $product_id);
            $cartMap[$product_id] = $item->rowId;
        }
        $products = Product::whereIn('id', $product_ids)->get();
        $db_pro_ids = $products->pluck('id')->toArray();
        // all products are deleted
        if (sizeof($db_pro_ids) == 0) {
            foreach ($cartMap as $key => $value) {
                try {
                    Cart::instance($this->getName())->remove($value);
                } catch (InvalidRowIDException $e) {
                }
            }
            return $ajax_response->setData(array("with_list" => Cart::instance($this->getName())->content(), "total" => Cart::instance($this->getName())->count()))->toApiResponse();
        }

        //some products are deleted
        foreach ($product_ids as $product_id) {
            if (!in_array($product_id, $db_pro_ids)) {
                try {
                    Cart::instance($this->getName())->remove($cartMap[$product_id]);
                } catch (InvalidRowIDException $e) {
                }
            }
        }

        //update product in withList
        foreach ($products as $product) {
            $rowId = $cartMap[$product->id];
            if ($rowId != null)
                Cart::instance($this->getName())->update($rowId, $this->getCartItem($product));
        }

        return $ajax_response->setData(array("with_list" => Cart::instance($this->getName())->content(), "total" => Cart::instance($this->getName())->count()))->toApiResponse();
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

        $existProducts = Cart::instance($this->getName())->search(function ($item) use ($product_id) {
            return $item->id == $product_id;
        });
        if ($existProducts->count() > 0)
            return $ajax_response->setMessage("Sản phẩm " . $product->name . " đã tồn tại trong danh sách yêu thích", 2)->toApiResponse();
        Cart::instance($this->getName())->add($this->getCartItem($product));
        return $ajax_response->setStatus(2)
            ->setMessage("Thêm sản phẩm " . $product->name . " danh sách yêu thích thành công!")
            ->toApiResponse();
    }

    public function destroy(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $rowId = $request->post('row_id');
        try {
            Cart::instance($this->getName())->remove($rowId);
        } catch (InvalidRowIDException $e) {
        }
        return $ajax_response->setData($rowId)->toApiResponse();
    }

    private function getName()
    {
        return 'with-list-' . auth()->user()->id;
    }

    private function getCartItem($product)
    {
        $cart_item = ['id' => $product->id, 'name' => $product->name, 'price' => $product->real_price, 'qty' => 1, 'options' => [
            'image' => $product->image,
            'customer_id' => auth()->user()->id,
            'slug' => $product->slug,
            'price' => $product->price,
            'is_contact' => $product->is_contact,
            'is_out_of_stock' => $product->is_out_of_stock,
            'on_sale' => $product->on_sale,
            'sale_off' => $product->sale_off]];
        if ($product->is_contact) {
            $cart_item["price"] = 0;
            $cart_item["options"]["price"] = 0;
        }
        return $cart_item;
    }

}
