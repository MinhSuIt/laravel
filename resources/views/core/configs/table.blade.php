<div class="table-responsive">
    <table class="table" id="configs-table">
        <thead>
            <tr>
                <th>Code</th>
        <th>Value</th>
        <th>Descriptions</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($configs as $config)
            <tr>
                <td>{{ $config->code }}</td>
            <td>{{ $config->getValue() }}</td>
            <td>{{ $config->descriptions }}</td>
                <td>
                    {!! Form::open(['route' => ['configs.destroy', $config->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('core.configs.show', [$config->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                        <a href="{{ route('configs.edit', [$config->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
