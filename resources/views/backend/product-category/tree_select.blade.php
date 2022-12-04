
@foreach($product_categories as $item)
    @if($item["parent_id"] == $parent_id)
        <option value="{!! $item["id"] !!}"
            {!! isset($selected_id) && $selected_id == $item["id"] ? 'selected' : ''!!}>
            {!!$prefix!!}
            @if($prefix == "")
                 {!! $item["name"] !!}
            @else
                --| {!!$item["name"]!!}
            @endif
        </option>
        @include('backend.product-category.tree_select',['product_categories' => $product_categories,'selected_id' => $selected_id,'parent_id' => $item["id"],'prefix'=> $prefix." --|"])
    @endif
@endforeach
