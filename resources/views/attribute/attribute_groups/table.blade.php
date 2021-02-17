<div class="table-responsive">
    <table class="table" id="attributeGroups-table">
        <thead>
            <tr>
                <th>Name<a href="{{ request()->fullUrlWithQuery(['sort'=>'-name']) }}"><i class="fa fa-angle-up"></i></a><a href="{{ request()->fullUrlWithQuery(['sort'=>'name']) }}"><i class="fa fa-angle-down"></i></a></th>
                <th>Attributes</th>
                <th>Categories</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>

        @foreach($attributeGroups as $attributeGroup)

            <tr>
            <th>{{$attributeGroup->name}}</th>
            <th>
                @php 
                    $attributes =$attributeGroup->attributes;
                @endphp
                @foreach ($attributes as $item)
                    <span class="badge badge-secondary" style="font-size:10px">{{$item->name}}</span>
                    {{-- @php 
                        $options =$item->options;
                    @endphp
                    @foreach ( $options as $option)
                        <span class="badge badge-secondary">{{$option->name}}</span>
                    @endforeach  --}}
                @endforeach
            </th>
            <th>
                @php 
                    $categories =$attributeGroup->attributes;
                @endphp
                @foreach ($categories as $item)
                    <span class="badge badge-secondary" style="font-size:10px">{{$item->name}}</span>
                @endforeach
            </th>
            <th colspan="3">                    
                <div class='btn-group'>
                    {{-- <a href="{{ route('attributeGroups.show', [$attributeGroup->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{{ route('attributeGroups.edit', [$attributeGroup->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
            </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $attributeGroups->withQueryString()->links() }}

</div>
