<!-- Sort Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sort_order', 'Sort Order:') !!}
    {!! Form::number('sort_order', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach ($languages as $language)
            @if ($loop->first)
                @php $active=' active' @endphp
            @else 
                @php $active='' @endphp
            @endif
            <li class="nav-item{{$active}}">
            <a class="nav-link{{$active}}" id="{{$language->code}}-tab" data-toggle="tab" href="#{{$language->code}}" role="tab" aria-controls="{{$language->code}}" aria-selected="true">{{$language->name}}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">

        @foreach ($languages as $language)
            @if ($loop->first)
                @php $active=' active in' @endphp
            @else 
                @php $active='' @endphp
            @endif
            <div class="tab-pane fade{{$active}}" id="{{$language->code}}" role="tabpanel" aria-labelledby="{{$language->code}}-tab">
                    {!! Form::label($language->code.'[name]', 'Name') !!}
                    {!! Form::text($language->code.'[name]', null, ['class' => 'form-control']) !!}
                    {!! Form::label($language->code.'[descriptions]', 'descriptions') !!}
                    {!! Form::text($language->code.'[descriptions]', null, ['class' => 'form-control']) !!}
            </div>
            </li>
        @endforeach

        
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('customerGroups.index') }}" class="btn btn-default">Cancel</a>
</div>
