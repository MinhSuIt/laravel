@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 >Permissions</h1>
    </section>
        @php
        $value = request()->query->get('filter');
      @endphp
        <form action="{{route('authorization.permissions.index')}}">
            <div class="form-row align-items-center">
              <div class="col-sm-3 my-1">
                <label class="sr-only" for="inlineFormInputName">Name</label>
                {{-- {{old('filter[name]')}} tuong tu ben duoi --}}
              <input type="text" class="form-control" id="inlineFormInputName" placeholder="Search by name" name ='filter[name]' value="{{request()->input('filter.name')}}" />
              </div>
              <div class="col-sm-2">
                <label class="sr-only" for="attribute">role</label>
                <div class="form-group">
                 <select class="form-control" id="exampleFormControlSelect1" name="filter[role_id]">
                   <option value="">role</option>
                   @foreach ($roles as $item)
                      <option value="{{$item->id}}"
                       @if( !empty($value) && isset($value['role_id']) && $value['role_id'] == $item->id) {{"selected"}}
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
                    @include('authorization.permissions.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

