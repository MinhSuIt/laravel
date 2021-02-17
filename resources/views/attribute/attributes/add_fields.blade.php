<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <label class="radio-inline">
        {!! Form::radio('status', "true", null) !!} Active
    </label>

    <label class="radio-inline">
        {!! Form::radio('status', "false", null) !!} Deactive
    </label>

</div>
<div class="form-group col-sm-12">
    Group attribute:
    <select class="attribute_group_id block" style="width: 100%" name="attribute_group_id" id="attribute_group_id" >
        <option value="" >No group</option>
        @foreach ($group as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
    </select>
</div>



<div class="clearfix"></div>

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

            </div>
            </li>
        @endforeach

        
    </div>
</div>




