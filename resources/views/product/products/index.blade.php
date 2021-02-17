@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Products</h1>
          <a class="btn btn-primary"  target="_blank" href="{{ route('product.export',request()->all()) }}">Export</a>
          {{-- <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Import</a> --}}
          <a class="btn btn-primary "  href="{{ route('product.products.index') }}">Clear filter</a>
           <a class="btn btn-primary "  href="{{ route('product.products.create') }}">Add New</a>
           <a class="btn btn-primary"  href="{{ route('product.products.index',['filter'=>['trashed'=>'only']]) }}">Trash</a>
    </section>
  <br/>
    <form action="{{route('product.products.index')}}">
        @php
          $value = request()->query->get('filter');
        @endphp
        {{-- lọc các giá trị null bằng middleware FilterQueryMiddleware --}}
          <div class="col-sm-2">
            <label class="sr-only" for="inlineFormInputName">Name</label>
            <input type="text" class="form-control" id="inlineFormInputName" placeholder="Name" name ='filter[name]' 
            value="{{!empty($value ) ? (isset($value['name']) ? $value['name'] : '') : ''}}"
            />
          </div>
          <div class="col-sm-2">

          <label class="sr-only" for="Sku">Sku</label>
            <input type="text" class="form-control" id="Sku" placeholder="Sku" name ='filter[sku]' 
            value="{{!empty($value ) ? (isset($value['sku']) ? $value['sku'] : '') : ''}}"
            />
          </div>
          <div class="col-sm-2">

           <label class="sr-only" for="Category">Category</label>

           <div class="form-group">
            <select class="form-control" id="exampleFormControlSelect1" name="filter[category_id]">
              <option value="">Category</option>
              @foreach ($categories as $item)
                 <option value="{{$item->id}}"
                  @if( !empty($value) && isset($value['category_id']) && $value['category_id'] == $item->id) {{"selected"}}
                  @endif
                  >{{$item->translate(app()->getLocale(),true)->name}}</option>
             @endforeach
            </select>
          </div>

            {{-- <input type="text" class="form-control" id="inlineFormInputName" placeholder="category" name ='filter[category_id]' 
            value="{{!empty($value) ? (isset($value['category_id']) ? $value['category_id'] : '') : ''}}"
            /> --}}
          </div>
           <div class="col-sm-2">

           <label class="sr-only" for="attribute">attribute</label>
           <div class="form-group">
            <select class="form-control" id="exampleFormControlSelect1" name="filter[attribute_id]">
              <option value="">Attribute</option>
              @foreach ($attributes as $item)
                 <option value="{{$item->id}}"
                  @if( !empty($value) && isset($value['attribute_id']) && $value['attribute_id'] == $item->id) {{"selected"}}
                  @endif
                  >{{$item->translate(app()->getLocale(),true)->name}}</option>
             @endforeach
            </select>
          </div>
            {{-- <input type="text" class="form-control" id="inlineFormInputName" placeholder="attribute" name ='filter[attribute_id]' 
            value="{{!empty($value) ? (isset($value['attribute_id']) ? $value['attribute_id'] : '') : ''}}"
            /> --}}
          </div>
          <div class="col-sm-2">
            <label class="sr-only" for="price">price</label>
            <div style="position: relative">
              <input type="text" class="form-control" id="inlineFormInputName" placeholder="price" name ='filter[price]' 
              value="{{!empty($value) ? (isset($value['price']) ? $value['price'] : '') : ''}}"
              />
              <select name="conditionPrice" id="conditionPrice" style="position: absolute;right:0;top:50%;transform: translateY(-50%);height:100%">
                <option value="">Condition</option>
                @php
               $conditions = [
                   '>','<','=','>=','<='
               ];
                @endphp
                
                @foreach ($conditions as $item)
                 <option value="{{$item}}" 
                 @if($item === request()->query->get('conditionPrice')) 
                 {{"selected"}}
                 @endif
                 >{{$item}}</option>
                @endforeach
              </select>
            </div>
            
             {{-- <input type="text" class="form-control" id="inlineFormInputName" placeholder="conditionPrice" name ='conditionPrice' 
             value="{{!empty(request()->query->get('conditionPrice')) ? request()->query->get('conditionPrice') : ''}}"
             /> --}}

           </div>
           <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
      </form>
    
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('product.products.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

