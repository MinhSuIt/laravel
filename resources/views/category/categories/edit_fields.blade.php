<!-- Position Field -->
<div class="form-group col-sm-6">
    {!! Form::label('position', 'Position:') !!}
    {!! Form::number('position',$category->position ? $category->position : 0, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <img style="width:140px" src="{{getThumbImage($category->image)}}" alt="">

    {!! Form::file('image') !!}
</div>
<div class="clearfix"></div>
<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <label class="radio-inline">
        {!! Form::radio('status', "1", $category->status==1 || true ) !!} Yes
    </label>

    <label class="radio-inline">
        {!! Form::radio('status', "0", $category->status==0 || true ) !!} No
    </label>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('attributeGroups', 'Attribute group') !!} <br/>
    <select class="attributeGroups block" style="width: 100%" name="attributeGroups[]" id="attributeGroups" multiple="multiple">
    </select>
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
            @php 
                    $translate = $category->translate($language->code);
                    
            @endphp
            <div class="tab-pane fade{{$active}}" id="{{$language->code}}" role="tabpanel" aria-labelledby="{{$language->code}}-tab">
                    {!! Form::label($language->code.'[name]', 'Name') !!}
                    {!! Form::text($language->code.'[name]',$translate && $translate->name ? $translate->name :'', ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[slug]', 'slug') !!}
                    {!! Form::text($language->code.'[slug]', $translate && $translate->slug ? $translate->slug :'', ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[description]', 'description') !!}
                    {!! Form::text($language->code.'[description]', $translate && $translate->description ? $translate->description :'', ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[meta_title]', 'Meta title') !!}
                    {!! Form::text($language->code.'[meta_title]', $translate && $translate->meta_title ? $translate->meta_title :'', ['class' => 'form-control']) !!}
                    
                    {!! Form::label($language->code.'[meta_description]', 'Meta description') !!}
                    {!! Form::text($language->code.'[meta_description]', $translate && $translate->meta_description ? $translate->meta_description :'', ['class' => 'form-control']) !!}
                    
                    {!! Form::label($language->code.'[meta_keywords]', 'meta_keywords') !!}
                    {!! Form::text($language->code.'[meta_keywords]', $translate && $translate->meta_keywords ? $translate->meta_keywords :'', ['class' => 'form-control']) !!}
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
