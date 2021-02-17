<div class="table-responsive">
    <table class="table" id="addresses-table">
        <thead>
            <tr>
                <th>Addressable Id</th>
        <th>Addressable Type</th>
        <th>Info</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($addresses as $address)
            <tr>
                <td>{{ $address->addressable_id }}</td>
            <td>{{ $address->addressable_type }}</td>
            <td>{{ $address->info }}</td>
                <td>
                    {!! Form::open(['route' => ['addresses.destroy', $address->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('addresses.show', [$address->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('addresses.edit', [$address->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
