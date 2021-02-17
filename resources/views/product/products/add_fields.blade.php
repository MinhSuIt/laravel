

<!-- Sku Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sku', 'Sku:') !!}
    {!! Form::text('sku', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 amount" >
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', 0, ['class' => 'form-control']) !!}
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', 0, ['class' => 'form-control']) !!}
</div>
<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image') !!}
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6">
    {!! Form::label('images[]', 'Other Image:') !!}
    {!! Form::file('images[]',['multiple'=>true]) !!}
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6">

{{-- {!! Form::select('categories[]', $categoriesCus, null, ['placeholder' => 'Categories','multiple'=>true]) !!} --}}

{!! Form::label('category', 'Category') !!} <br/>
<select class="categories block" style="width: 100%" name="categories[]" id="categories" multiple="multiple">
    {{-- @foreach ($categoriesCus as $key => $item)
        <option value="0" >No Category</option>
        <option value="{{$key}}">{{$item}}</option>
    @endforeach --}}
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
            <div class="tab-pane fade{{$active}}" id="{{$language->code}}" role="tabpanel" aria-labelledby="{{$language->code}}-tab">
                    {!! Form::label($language->code.'[name]', 'Name') !!}
                    {!! Form::text($language->code.'[name]', null, ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[description]', 'description') !!}
                    {!! Form::text($language->code.'[description]', null, ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[slug]', 'slug') !!}
                    {!! Form::text($language->code.'[slug]', null, ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[meta_title]', 'Meta title') !!}
                    {!! Form::text($language->code.'[meta_title]', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label($language->code.'[meta_description]', 'Meta description') !!}
                    {!! Form::text($language->code.'[meta_description]', null, ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[meta_keywords]', 'meta_keywords') !!}
                    {!! Form::text($language->code.'[meta_keywords]', null, ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[content]', 'Content') !!}
                    {!! Form::text($language->code.'[content]', '', ['class' => 'form-control textarea-content']) !!}
            </div>
            </li>
        @endforeach

        
    </div>

</div>

