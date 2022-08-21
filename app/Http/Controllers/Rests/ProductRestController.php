<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\Product;
use Carbon\Carbon;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function findByCollection(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $collection_id = $request->input('collection_id');
        try {
            if (!isset($collection_id)) $collection_id = ProductCollection::firstOrFail()->id;
            else ProductCollection::findOrFail($collection_id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Đối tượng không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $products = [];
        if (isset($collection_id)) {
            $products = Product::whereHas('productCollections', function ($query) use ($collection_id) {
                $query->where('product_collection_id', $collection_id);
            })->orderBy('id', 'DESC')->simplePaginate(3);
        }
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $page_size = $request->input("page_size") || 9;
        $sort = $request->input("sort");
        $current_time = Carbon::now();
        $query = Product::where(function ($query) use ($request, $current_time) {
            $category_id = $request->input("category_id");
            $name = $request->input("name");
            $min_price = $request->input("min_price");
            $max_price = $request->input("max_price");
            if (!is_null($category_id)) $query->where('category_id', $category_id);
            if (!empty($name)) $query->where('name', 'like', '%' . $name . '%');
            if (!is_null($min_price) && !is_null($max_price)) {
                //find by product on sale
                $query->orWhere(function ($query) use ($current_time, $min_price, $max_price) {
                    $query->where('sale_price', ">=", $min_price);
                    $query->where('sale_price', "<=", $max_price);
                    $query->where(function ($query) use ($current_time) {
                        $query->orWhere(function ($query) {
                            $query->where('start_date', null);
                            $query->where('end_date', null);
                        });
                        $query->orWhere(function ($query) use ($current_time) {
                            $query->where('start_date', null);
                            $query->where('end_date', '>=', $current_time);
                        });
                        $query->orWhere(function ($query) use ($current_time) {
                            $query->where('start_date', '<=', $current_time);
                            $query->where('end_date', null);
                        });
                        $query->orWhere(function ($query) use ($current_time) {
                            $query->where('start_date', '<=', $current_time);
                            $query->where('end_date', '>=', $current_time);
                        });
                    });
                });
                $query->orWhere(function ($query) use ($current_time, $min_price, $max_price) {
                    $query->where('price', ">=", $min_price);
                    $query->where('price', "<=", $max_price);
                    $query->where(function ($query) use ($current_time) {
                        //find by normal price of product
                        $query->orWhere('sale_price', null);

                        //find by normal price when expire sale
                        $query->orWhere(function ($query) use ($current_time) {
                            $query->where('sale_price', '!=', null);
                            $query->where(function ($query) use ($current_time) {
                                $query->orWhere('start_date', '>', $current_time);
                                $query->orWhere('end_date', '<', $current_time);
                            });
                        });
                    });
                });
            }
        });
        if ($sort == "date_asc") $query->orderBy("updated_at", "ASC");
        if ($sort == "date_desc") $query->orderBy("updated_at", "DESC");
        if ($sort == "price_asc" || $sort == "price_desc") {
            $sortType = $sort == "price_asc" ? "ASC" : "DESC";
            $query->orderByRaw("CASE WHEN (sale_price is not null && ((start_date is null and end_date is null) or (start_date is null and end_date >= '" . $current_time . "') or (start_date <= '" . $current_time . "' and end_date is null) or (start_date <= '" . $current_time . "' and end_date >= '" . $current_time . "'))) THEN sale_price ELSE price END ASC");
        }
        if ($sort == "name_asc") $query->orderBy("name", "ASC");
        if ($sort == "name_desc") $query->orderBy("name", "DESC");
        $products = $query->paginate($page_size);
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function findTop(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $products = Product::where('is_featured', true)->paginate(3);
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function findOnSale(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $products = Product::where(function ($query) {
            $query->where('sale_price', "!=", null);
            $query->where(function ($query) {
                $current_time = Carbon::now();
                $query->orWhere(function ($query) use ($current_time) {
                    $query->where('start_date', null);
                    $query->where('end_date', null);
                });
                $query->orWhere(function ($query) use ($current_time) {
                    $query->where('start_date', null);
                    $query->where('end_date', '>=', $current_time);
                });
                $query->orWhere(function ($query) use ($current_time) {
                    $query->where('start_date', '<=', $current_time);
                    $query->where('end_date', null);
                });
                $query->orWhere(function ($query) use ($current_time) {
                    $query->where('start_date', '<=', $current_time);
                    $query->where('end_date', '>=', $current_time);
                });
            });
        })->paginate(3);
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function detail(Request $request)
    {
        $related_side = 5;
        $ajax_response = new AjaxResponse();
        $id = $request->input("id");
        $product = null;
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Đối tượng không tồn tại hoặc đã bị xóa")->toApiResponse();
        }

        $image_string = "";
        $size = $product->images()->count();
        foreach ($product->images()->get() as $key => $item) {
            $image_string .= url('uploads/images/' . $item->image);
            if ($key < $size - 1) $image_string .= ",";
        }
        if ($product->image) {
            $product->image = url('uploads/images/' . $product->image);
        }
        $product->images = $image_string;
        $related_products = $product->productsRelated()->orderBy("id", 'DESC')->limit(5)->get();
        $total_related = $related_products->count();
        if ($total_related < $related_side) {
            $related_product_ids = [];
            $related_products = [];
            if ($total_related > 0) {
                $related_product_ids = $related_products->pluck("id")->toArray();
                $related_products = $related_products->toArray();
            }
            $miss = $related_side - $total_related;
            $query = Product::where('id', '!=', $id)
                ->where("category_id", $product->category_id);
            if (count($related_product_ids) > 0) $query->whereNotIn("id", $related_product_ids);
            $bonus_products = $query->inRandomOrder()->limit($miss)->get();
            $total_bonus = $bonus_products->count();
            if ($total_bonus > 0) $related_products = array_merge($related_products, $bonus_products->toArray());
            if ($total_bonus < $miss) {
                if ($total_bonus > 0) $related_product_ids = array_merge($related_product_ids, $bonus_products->pluck("id")->toArray());
                $miss2 = $miss - $total_bonus;
                $random_query = Product::where('id', '!=', $id);
                if (count($related_product_ids) > 0) $random_query->whereNotIn("id", $related_product_ids);
                $random_products = $random_query->inRandomOrder()->limit($miss2)->get()->toArray();
                if (count($random_products) > 0) $related_products = array_merge($related_products, $random_products);
            }
        }
        $product->related_products = $related_products;
        return $ajax_response->setData($product)->toApiResponse();
    }
}
