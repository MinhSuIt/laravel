<div class="table-responsive">
    <table class="table" id="products-table">
        <thead>
            <tr>
                <th>Sku</th>
                <th>Name<a href="{{route('product.products.index',array_merge(request()->query(),['sort'=>'-name']))}}"><i class="fa fa-angle-up"></i></a><a href="{{route('product.products.index',array_merge(request()->query(),['sort'=>'name']))}}"><i class="fa fa-angle-down"></i></a></th>
                <th>Image</th>
                <th>Images</th>
                <th>Price<a href="{{route('product.products.index',array_merge(request()->query(),['sort'=>'-price']))}}"><i class="fa fa-angle-up"></i></a><a href="{{route('product.products.index',array_merge(request()->query(),['sort'=>'price']))}}"><i class="fa fa-angle-down"></i></a></th>
                <th>Categories</th>
                <th>Attributes</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            {{-- {{dd($product->translate(app()->getLocale(),true))}} --}}
            <tr>
                <td>{{ $product->sku }}</td>
            <td>{{ $product->translate(app()->getLocale(),true)->name }}</td>
            <td><img src="{{ getThumbImage($product->image) }}" alt=""></td>
            <td>
                @foreach ($product->getMedia($product::SLIDE_IMAGE_COLLECTION) as $item)
                    <img src="{{$item->getUrl()}}" alt="">
                @endforeach
            </td>
            {{-- @if ($product->id ==)
                
            @endif --}}
            <td>{{ $product->getFormatPrice() }}</td>
            <td>
                @php
                    $categories = $product->categories;
                @endphp

                @foreach ($categories as $item)
                    <h6>{{$item->getTranslatedAttribute(app()->getLocale(),'name')}} </h6>
                @endforeach
            
            </td>
            <td>
                @php
                    $attributes = $product->attributes;
                @endphp

                @foreach ($attributes as $item)
                    <h5>

                        {{$item->getTranslatedAttribute(app()->getLocale(),'name')}} 

                    </h5>
                @endforeach
            </td>
            <td>
                {!! Form::open(['route' => ['product.products.destroy', $product->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {{-- <a href="{{ route('product.products.show', [$product->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{{ route('product.products.edit', [$product->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $products->withQueryString()->links() }}

</div>
