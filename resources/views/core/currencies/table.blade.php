<div class="table-responsive">
    <table class="table" id="currencies-table">
        <thead>
            <tr>
                <th>Code</th>
        <th>Name</th>
        <th>Rate</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($currencies as $currency)
            <tr>
                <td>{{ $currency['code'] }}</td>
            <td>{{ $currency['name'] }}</td>
            <td>{{ $currency['exchange_rate'] }}</td>
                <td>
                    {!! Form::open(['route' => ['currencies.destroy', $currency['code']], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('core.currencies.show', [$currency['code']]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                        <a href="{{ route('currencies.edit', [$currency['code']]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
