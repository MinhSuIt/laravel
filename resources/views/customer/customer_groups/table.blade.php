<div class="table-responsive">
    <table class="table" id="customerGroups-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($customerGroups as $customerGroup)
            <tr>
                <td>{{ $customerGroup->translate(app()->getLocale(),true)->name }}</td>
                <td>{{ $customerGroup->translate(app()->getLocale(),true)->descriptions }}</td>
                <td>
                    {!! Form::open(['route' => ['customerGroups.destroy', $customerGroup->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('customerGroups.show', [$customerGroup->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                        <a href="{{ route('customerGroups.edit', [$customerGroup->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
