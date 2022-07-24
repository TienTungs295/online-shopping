@foreach($product_categories as $item)
    @if($item["parent_id"] == $parent_id)
        <tr>
            <th scope="row">{!!$item["id"]!!}</th>
            <td>
                @if($prefix == "")
                    <span class="text-primary">{!!$prefix!!}  {!! $item["name"] !!}</span>
                @else
                    <span class="text-success">{!!$prefix!!} --| {!!$item["name"]!!}</span>
                @endif
            </td>
            <td class="text-center">
                {!! date('H:i:s d-m-Y', strtotime($item["updated_at"]))  !!}
            </td>
            <td class="text-center">
                <a href="{!! route('updateCategoryView',['id' => $item["id"]]) !!}"
                   class="btn btn-info btn-sm text-white">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{!! route('deleteCategory',['id' => $item["id"]]) !!}" class="d-inline-block"
                      method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa nhãn này không?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @include('backend.product-category.tree',['product_categories' => $product_categories,'parent_id' => $item["id"],'prefix'=> $prefix." --|"])
    @endif
@endforeach
