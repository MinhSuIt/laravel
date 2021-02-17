<!-- Position Field -->
<div class="form-group col-sm-6">
    {!! Form::label('position', 'Position:') !!}
    {!! Form::number('position',0, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image') !!}
</div>
<div class="clearfix"></div>

<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <label class="radio-inline">
        {!! Form::radio('status', "1", true) !!} Yes
    </label>

    <label class="radio-inline">
        {!! Form::radio('status', "0", null) !!} No
    </label>
<div class="form-group col-sm-12">
    {!! Form::label('attributeGroups', 'Attribute group') !!} <br/>
    <select class="attributeGroups block" style="width: 100%" name="attributeGroups[]" id="attributeGroups" multiple="multiple">
    </select>
</div>
<div class="clearfix"></div>

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

                    {!! Form::label($language->code.'[meta_title]', 'Meta title') !!}
                    {!! Form::text($language->code.'[meta_title]', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label($language->code.'[meta_description]', 'Meta description') !!}
                    {!! Form::text($language->code.'[meta_description]', null, ['class' => 'form-control']) !!}
            </div>
            </li>
        @endforeach

        
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('category.categories.index') }}" class="btn btn-default">Cancel</a>
</div>
