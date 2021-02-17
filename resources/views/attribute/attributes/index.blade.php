@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 >Attributes</h1>
           <a class="btn btn-primary "  href="{{ route('attributes.create') }}">Add New</a>
    </section>
    @php
    $value = request()->query->get('filter');
  @endphp
    <form action="{{route('attributes.index')}}">
        <div class="form-row align-items-center">
          <div class="col-sm-3 my-1">
            <label class="sr-only" for="inlineFormInputName">Name</label>
            {{-- {{old('filter[name]')}} --}}
          <input type="text" class="form-control" id="inlineFormInputName" placeholder="Search by name" name ='filter[name]' value="{{request()->input('filter.name')}}" />
          </div>
          <div class="col-sm-2">
            <label class="sr-only" for="attribute">group</label>
            <div class="form-group">
             <select class="form-control" id="exampleFormControlSelect1" name="filter[attribute_group_id]">
               <option value="">group</option>
               @foreach ($groups as $item)
                  <option value="{{$item->id}}"
                   @if( !empty($value) && isset($value['attribute_group_id']) && $value['attribute_group_id'] == $item->id) {{"selected"}}
                   @endif
                   >{{$item->name}}</option>
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
                    @include('attribute.attributes.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

