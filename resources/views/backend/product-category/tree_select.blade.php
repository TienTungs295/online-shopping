
@foreach($product_categories as $item)
    @if($item["parent_id"] == $parent_id)
        <option value="{!! $item["id"] !!}"
            {!! old('parent_id', isset($product_category["parent_id"]) && $product_category["parent_id"] == $item["id"] ? 'selected' : '')!!}>
            {!!$prefix!!}
            @if($prefix == "")
                 {!! $item["name"] !!}
            @else
                --| {!!$item["name"]!!}
            @endif
        </option>
        @include('backend.product-category.tree_select',['product_categories' => $product_categories,'product_category' => $product_category,'parent_id' => $item["id"],'prefix'=> $prefix." --|"])
    @endif
@endforeach
