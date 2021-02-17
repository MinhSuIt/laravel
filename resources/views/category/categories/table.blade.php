<div class="table-responsive">
    <table class="table" id="categories-table">
        <thead>
            <tr>
                {{-- {{route('category.categories.index',array_merge(request()->query(),['sort'=>'-name']))}} --}}
                {{-- nếu cho sort nhiều trường thì phải check request()->query('sort').contains('-name') --}}
                <th>Name<a class="{{active_class(if_query('sort','-name'), 'activeSort')}}" href="{{ request()->fullUrlWithQuery(['sort'=>'-name']) }}"><i class="fa fa-angle-up"></i></a><a class="{{active_class(if_query('sort','name'), 'activeSort')}}" href="{{ request()->fullUrlWithQuery(['sort'=>'name']) }}"><i class="fa fa-angle-down"></i></a></th>
                <th>Position<a class="{{active_class(if_query('sort','-position'), 'activeSort')}}" href="{{request()->fullUrlWithQuery(['sort'=>'-position']) }}"><i class="fa fa-angle-up"></i></a><a class="{{active_class(if_query('sort','position'), 'activeSort')}}" href="{{request()->fullUrlWithQuery(['sort'=>'position']) }}"><i class="fa fa-angle-down"></i></a></th>
                <th>Image</th>
                <th>Status<a class="{{active_class(if_query('sort','-status'), 'activeSort')}}" href="{{request()->fullUrlWithQuery(['sort'=>'-status']) }} "><i class="fa fa-angle-up"></i></a><a class="{{active_class(if_query('sort','status'), 'activeSort')}}" href="{{request()->fullUrlWithQuery(['sort'=>'status']) }}"><i class="fa fa-angle-down"></i></a></th>
                <th>Attribute group</th>
                <th>Number of product <a class="{{active_class(if_query('sort','-products_count'), 'activeSort')}}" href="{{request()->fullUrlWithQuery(['sort'=>'-products_count']) }} "><i class="fa fa-angle-up"></i></a><a class="{{active_class(if_query('sort','products_count'), 'activeSort')}}" href="{{request()->fullUrlWithQuery(['sort'=>'products_count']) }}"><i class="fa fa-angle-down"></i></a></th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                {{-- true là trả về locale mặc định nếu ko có locale đó --}}
                {{-- {{dd($category->getTranslation('en'))}} --}}
                <td>{{ $category->getTranslatedAttribute(app()->getLocale(),'name') }}</td>
                <td>{{ $category->position }}</td>
                {{-- @if ($category->id == 60)
                    {{dd($category->getMedia('categories'))}}
                @endif --}}
                <td><img style="width:140px" src="{{getThumbImage($category->image)}}" alt=""></td>
                {{-- <td><img style="width:140px" src="{{$category->getFirstMediaUrl('categories')}}" alt=""></td> --}}
                <td>{{ $category->status ? "Active" : "Deactive" }}</td>

                <td>
                    @php 
                        $groups = $category->attributeGroups;
                        // dd($groups);
                    @endphp
                    @foreach ($groups as $item)
                        <h5>
                            {{$item->getTranslatedAttribute(app()->getLocale(),'name')." "}}
                            {{-- @php
                                $atts = $item->attributes;
                            @endphp
                            @foreach ($atts as $att)
                                <span>{{$att->translate(app()->getLocale(),true)->name}}</span>
                            @endforeach --}}
                        </h5>
                    @endforeach
                </td>
                <td>{{$category->products_count}}</td>
                <td>
                    
                    @if ($isTrash)
                        {!! Form::open(['route' => ['category.categories.forceDelete', ['id'=>$category->id,'filter'=>['trashed'=>'only']]], 'method' => 'delete']) !!}
                    @else
                        {!! Form::open(['route' => ['category.categories.destroy', $category->id], 'method' => 'delete']) !!}
                    @endif
                    <div class='btn-group'>
                        {{-- <a href="{{ route('category.categories.show', [$category->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                        @if ($isTrash)
                            <a href="{{ route('category.categories.edit',['category'=>$category->id,'filter'=>['trashed'=>'only']]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        @else
                            <a href="{{ route('category.categories.edit',$category->id) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        @endif
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}
</div>
