@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Customers</h1>
           <a class="btn btn-primary" href="{{ route('customers.create') }}">Add New</a>
    </section>
    <form action="{{route('customers.index')}}">
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
            <label class="sr-only" for="inlineFormInputName">Email</label>
            <input type="text" class="form-control" id="inlineFormInputName" placeholder="Email" name ='filter[email]' 
            value="{{!empty($value ) ? (isset($value['email']) ? $value['email'] : '') : ''}}"
            />
          </div>
          <div class="col-sm-2">

           <label class="sr-only" for="Category">group</label>

           <div class="form-group">
            <select class="form-control" id="exampleFormControlSelect1" name="filter[customer_group_id]">
              <option value="">group</option>
              @foreach ($groups as $item)
                 <option value="{{$item->id}}"
                  @if( !empty($value) && isset($value['customer_group_id']) && $value['customer_group_id'] == $item->id) {{"selected"}}
                  @endif
                  >{{$item->translate(app()->getLocale(),true)->name}}</option>
             @endforeach
            </select>
          </div>
            
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
                    @include('customer.customers.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

