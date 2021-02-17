@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 >Attribute Groups</h1>
           <a class="btn btn-primary "  href="{{ route('attributeGroups.create') }}">Add New group</a>
    </section>
    @php
    $value = request()->query->get('filter');
  @endphp
    <form action="{{route('attributeGroups.index')}}">
        <div class="form-row align-items-center">
          <div class="col-sm-2 my-1">
            <label class="sr-only" for="inlineFormInputName">Name</label>
            {{old('filter[name]')}}
          <input type="text" class="form-control" id="inlineFormInputName" placeholder="Search by name" name ='filter[name]' value="{{request()->input('filter.name')}}" />
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
                    @include('attribute.attribute_groups.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('#click').addEventListener('click',function(){
            window.location.href = "{{url('home')}}";
        })
    </script>
@endpush