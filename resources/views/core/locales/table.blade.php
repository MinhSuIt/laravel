<div class="table-responsive">
    <table class="table" id="locales-table">
        <thead>
            <tr>
                <th>Code</th>
        <th>Name</th>
        <th>Direction</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($locales as $locale)
            <tr>
                <td>{{ $locale->code }}</td>
            <td>{{ $locale->name }}</td>
            <td>{{ $locale->direction }}</td>
                <td>
                    {!! Form::open(['route' => ['locales.destroy', $locale->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('locales.show', [$locale->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                        <a href="{{ route('locales.edit', [$locale->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
