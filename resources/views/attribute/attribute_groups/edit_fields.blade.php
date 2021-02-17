<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <label class="radio-inline">
        {!! Form::radio('status', 1, $attributeGroup->status==1 || true) !!} Active
    </label>

    <label class="radio-inline">
        {!! Form::radio('status', 0, $attributeGroup->status==0 || true) !!} Deactive
    </label>
    <select class="categories block" style="width: 100%" name="category_ids[]" id="categories" multiple="multiple">
    </select>
    {{-- <div class="form-group col-sm-12"> --}}
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
                        {!! Form::text($language->code.'[name]', $attributeGroup->translate($language->code,true)->name, ['class' => 'form-control']) !!}
                </div>
                </li>
            @endforeach
    
            
        </div>
    {{-- </div> --}}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('attributeGroups.index') }}" class="btn btn-default">Cancel</a>
</div>




