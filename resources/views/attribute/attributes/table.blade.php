<div class="table-responsive">
    <table class="table" id="attributes-table">
        <thead>
            <tr>
                <th>Name<a href="{{ request()->fullUrlWithQuery(['sort'=>'-name']) }}"><i class="fa fa-angle-up"></i></a><a href="{{ request()->fullUrlWithQuery(['sort'=>'name']) }}"><i class="fa fa-angle-down"></i></a></th>
                <th>options</th>
                <th>Group</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($attributes as $attribute)
            <tr>
                <td>{{ $attribute->translate(app()->getLocale(),true)->name }}</td>
                <td>
                    @foreach ($attribute->options as $item)
                        <span class="badge badge-secondary">{{$item->translate(app()->getLocale(),true)->name}}</span>                        
                    @endforeach
                </td>
                <td>{{ $attribute->attributeGroup->translate(app()->getLocale(),true)->name }}</td>

                <td>
                    {!! Form::open(['route' => ['attributes.destroy', $attribute->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('attributes.show', [$attribute->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                        <a href="{{ route('attributes.edit', [$attribute->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $attributes->withQueryString()->links() }}
</div>
