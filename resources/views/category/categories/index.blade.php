@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <section class="content-header">
        <h1>Categories</h1>
          <a class="btn btn-primary"  target="_blank" href="{{ route('category.export',request()->all()) }}">Export</a>
          {{-- <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >Import</a> --}}
          <a class="btn btn-primary"  href="{{ route('category.categories.index') }}">Clear filter</a>
           <a class="btn btn-primary"  href="{{ route('category.categories.create') }}">Add New</a>
           <a class="btn btn-primary"  href="{{ route('category.categories.index',['filter'=>['trashed'=>'only']]) }}">Trash</a>
    </section>

      <form action="
      @if ($isTrash) {{route('category.categories.index')}}
      @else {{route('category.categories.index')}}
      @endif
      ">
      @php
        $value = request()->query->get('filter');
      @endphp
        <div class="form-row align-items-center">
          <div class="col-sm-2">
            <label class="sr-only" for="inlineFormInputName">Name</label>
            {{old('filter[name]')}}
          <input type="text" class="form-control" id="inlineFormInputName" placeholder="Search by name" name ='filter[name]' value="{{request()->input('filter.name')}}" />
          </div>

          <div class="col-sm-2">
            <label class="sr-only" for="Category group">Attribute group</label>
            <div class="form-group">
             <select class="form-control" id="exampleFormControlSelect1" name="filter[attribute_group_id]">
               <option value="">Attribute group</option>
               @foreach ($attributeGroups as $item)
                  <option value="{{$item->id}}"
                   @if( !empty($value) && isset($value['attribute_group_id']) && $value['attribute_group_id'] == $item->id) {{"selected"}}
                   @endif
                   >{{$item->translate(app()->getLocale(),true)->name}}</option>
              @endforeach
             </select>
           </div>
          </div>

          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </div>
      </form>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('category.categories.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>




@endsection

