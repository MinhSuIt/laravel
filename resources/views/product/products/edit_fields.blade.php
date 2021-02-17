<!-- Sku Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sku', 'Sku:') !!}
    {!! Form::text('sku', $product->sku, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', $product->amount, ['class' => 'form-control']) !!}
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', $product->price, ['class' => 'form-control']) !!}
</div>
<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {{-- viết hàm get link của image --}}
    <img style="width:140px" src="{{ asset('storage/'.$product->image) }}" alt="">
    {!! Form::file('image') !!}
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6">
    {!! Form::label('images', 'Other Image:') !!}
    @foreach ($product->images as $item)
        <img style="width:140px" src="{{ asset('storage/'.$item->image) }}" alt="">
    @endforeach
    {!! Form::file('images[]',['multiple'=>true]) !!}
</div>
<div class="clearfix"></div>
<div class="form-group col-sm-6">

{{-- {!! Form::select('categories[]', $categoriesCus, null, ['placeholder' => 'Categories','multiple'=>true]) !!} --}}

{!! Form::label('category', 'Category') !!} <br/>
<select class="categories block" style="width: 100%" name="categories[]" id="categories" multiple="multiple">
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
                    {!! Form::text($language->code.'[name]', isset($product->name) ? $product->name : '', ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[description]', 'description') !!}
                    {!! Form::text($language->code.'[description]', isset($product->description) ? $product->description : '', ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[slug]', 'slug') !!}
                    {!! Form::text($language->code.'[slug]', isset($product->slug) ? $product->slug : '', ['class' => 'form-control']) !!}
                    
                    {!! Form::label($language->code.'[meta_title]', 'Meta title') !!}
                    {!! Form::text($language->code.'[meta_title]', isset($product->meta_title) ? $product->meta_title : '', ['class' => 'form-control']) !!}
                    
                    {!! Form::label($language->code.'[meta_description]', 'Meta description') !!}
                    {!! Form::text($language->code.'[meta_description]', isset($product->meta_description) ? $product->meta_description : '', ['class' => 'form-control']) !!}

                    {!! Form::label($language->code.'[meta_keywords]', 'meta_keywords') !!}
                    {!! Form::text($language->code.'[meta_keywords]', isset($product->meta_keywords) ? $product->meta_keywords : '', ['class' => 'form-control']) !!}
            
                    {!! Form::label($language->code.'[content]', 'Content') !!}
                    {!! Form::text($language->code.'[content]', isset($product->translate($language->code,true)->content) ? $product->getContentForEdit($product->getTranslatedAttribute($language->code,'content'),'img','src') : '', ['class' => 'form-control textarea-content']) !!}
            </div>
            </li>
        @endforeach

        
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('product.products.index') }}" class="btn btn-default">Cancel</a>
</div>
