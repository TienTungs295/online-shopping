<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use App\Http\Responses\AjaxResponse;
use App\Models\Image;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Models\Product;
use App\Models\OrderProduct;
use Carbon\Carbon;
use \stdClass;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class ProductRestController extends Controller
{
    public function findByName(Request $request)
    {
        $name = $request->input('name');
        $exclude_id = $request->input('exclude_id');
        $product_query = Product::with(['productLabels'])->where('id', '>', 0);
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
        $products = [];
        if (is_null($collection_id)) {
            $firstCollection = ProductCollection::first();
            if (is_null($firstCollection)) return $ajax_response->setData($products)->toApiResponse();
            else $collection_id = $firstCollection->id;
        }
        try {
            ProductCollection::findOrFail($collection_id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Đối tượng không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $products = Product::with(['productLabels'])->whereHas('productCollections', function ($query) use ($collection_id) {
            $query->where('product_collection_id', $collection_id);
        })->orderBy('id', 'DESC')->paginate(12);
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function findAll(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $param = json_decode($request->input("param"));
        $page_size = 9;
        $sort = "";
        $collection_ids = null;
        if (isset($param->page_size) && !empty($param->page_size)) $page_size = $param->page_size;
        if (isset($param->sort) && !empty($param->sort)) $sort = $param->sort;
        $current_time = Carbon::now();
        $query = Product::with(['productLabels'])->where(function ($query) use ($param, $current_time) {
            $category_id = isset($param->category_id) ? $param->category_id : null;
            $name = isset($param->name) ? $param->name : null;
            $min_price = null;
            $max_price = null;
            $is_contact = false;
            if (isset($param->price)) {
                if ($param->price == "option1") {
                    $max_price = 50000;
                } elseif ($param->price == "option2") {
                    $min_price = 50000;
                    $max_price = 100000;
                } elseif ($param->price == "option3") {
                    $min_price = 100000;
                    $max_price = 200000;
                } elseif ($param->price == "option4") {
                    $min_price = 200000;
                    $max_price = 500000;
                } elseif ($param->price == "option5") {
                    $min_price = 500000;
                    $max_price = 1000000;
                } elseif ($param->price == "option6") {
                    $min_price = 1000000;
                } elseif ($param->price == "option7") {
                    $is_contact = true;
                }
            }
            $collection_ids = null;
            if (isset($param->collection_ids) && count($param->collection_ids) > 0) $collection_ids = array_map('intval', $param->collection_ids);
            if (!is_null($category_id)) $query->where('category_id', $category_id);
            if ($collection_ids != null) {
                $query->whereHas('productCollections', function ($query) use ($collection_ids) {
                    $query->whereIn('product_collection_id', $collection_ids);
                });
            }
            if (!empty($name)) $query->where('name', 'like', '%' . $name . '%');
            if ($is_contact) $query->where('is_contact', true);
            if (!is_null($min_price) || !is_null($max_price)) {
                //find by product on sale
                $query->where(function ($query) use ($current_time, $min_price, $max_price) {
                    $query->orWhere(function ($query) use ($current_time, $min_price, $max_price) {
                        if (!is_null($min_price) && is_null($max_price)) {
                            $query->where('sale_price', ">", $min_price);
                        } else if (is_null($min_price) && !is_null($max_price)) {
                            $query->where('sale_price', "<", $max_price);
                        } else {
                            $query->where('sale_price', ">=", $min_price);
                            $query->where('sale_price', "<=", $max_price);
                        }
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
                        if (!is_null($min_price) && is_null($max_price)) {
                            $query->where('price', ">", $min_price);
                        } else if (is_null($min_price) && !is_null($max_price)) {
                            $query->where('price', "<", $max_price);
                        } else {
                            $query->where('price', ">=", $min_price);
                            $query->where('price', "<=", $max_price);
                        }
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
                });
            }
        });
        if ($sort == "date_asc") $query->orderBy("updated_at", "ASC");
        if ($sort == "date_desc") $query->orderBy("updated_at", "DESC");
        if ($sort == "price_asc" || $sort == "price_desc") {
            $sortType = $sort == "price_asc" ? "ASC" : "DESC";
            $query->orderByRaw("CASE WHEN (sale_price is not null && ((start_date is null and end_date is null) or (start_date is null and end_date >= '" . $current_time . "') or (start_date <= '" . $current_time . "' and end_date is null) or (start_date <= '" . $current_time . "' and end_date >= '" . $current_time . "'))) THEN sale_price ELSE price END " . $sortType);
        }
        if ($sort == "name_asc") $query->orderBy("name", "ASC");
        if ($sort == "name_desc") $query->orderBy("name", "DESC");
        $products = $query->paginate($page_size);
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function findFeatured(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $products = Product::with(['productLabels'])->where('is_featured', true)->orderBy("updated_at", "DESC")->paginate(12)->toArray();
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function findOnSale(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $products = Product::with(['productLabels'])->where(function ($query) {
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
        })->paginate(12);
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function findTrending(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $products = Product::with(['productLabels'])
            ->join('ec_order_product', 'ec_order_product.product_id', '=',
                'ec_products.id')
            ->groupByRaw('ec_products.id')
            ->orderByRaw("SUM(ec_order_product.qty) DESC")
            ->distinct()
            ->select([
                'ec_products.*'
            ])
            ->paginate(12)
            ->toArray();
        return $ajax_response->setData($products)->toApiResponse();
    }

    public function detail(Request $request)
    {
        $related_size = 5;
        $ajax_response = new AjaxResponse();
        $id = $request->input("id");
        $product = null;
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $ajax_response->setMessage("Đối tượng không tồn tại hoặc đã bị xóa")->toApiResponse();
        }
        $images = [];
        $image = new Image();
        $image->id = 0;
        $image->image = $product->image;
        array_push($images, $image);
        $plus_image = $product->images()->get()->toArray();
        $images = array_merge($images, $plus_image);
        $product->images = $images;
        $product->category = $product->category()->first();
        $related_products = $product->productsRelated()->orderBy("id", 'DESC')->limit(5)->get();
        $total_related = $related_products->count();
        if ($total_related < $related_size) {
            $related_product_ids = [];
            $related_products = [];
            if ($total_related > 0) {
                $related_product_ids = $related_products->pluck("id")->toArray();
                $related_products = $related_products->toArray();
            }
            $miss = $related_size - $total_related;
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

    public function findTopRate(Request $request)
    {
        $ajax_response = new AjaxResponse();
        $products = Product::with(['productLabels'])->whereHas('reviews', function ($query) {
            $query->orderBy('star', 'DESC');
        })->paginate(12)->toArray();
        return $ajax_response->setData($products)->toApiResponse();
    }
}
