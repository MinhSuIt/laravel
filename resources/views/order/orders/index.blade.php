@extends('layouts.app')

@section('content')


    <section class="content-header">
        <h1>Orders</h1>
    </section>
    @php
    $value = request()->query->get('filter');
  @endphp
<form action="">
        <div class="form-row align-items-center">
          <div class="col-sm-2 my-1">
            <label class="sr-only" for="inlineFormInputName">Name</label>
            {{old('filter[name]')}}
          <input type="text" class="form-control" id="inlineFormInputName" placeholder="Search by customer name" name ='filter[name]' value="{{request()->input('filter.name')}}" />
          </div>
          <div class="col-sm-2 my-1">
            <label class="sr-only" for="inlineFormInputName">Email</label>
          <input type="text" class="form-control" id="inlineFormInputName" placeholder="Search by customer email" name ='filter[email]' value="{{request()->input('filter.email')}}" />
          </div>
          <div class="col-sm-2">

            <label class="sr-only" for="Category">status</label>
 
            <div class="form-group">
             <select class="form-control" id="exampleFormControlSelect1" name="filter[status]">
               <option value="">status</option>
               @foreach ($status as $key => $item)
                  <option value="{{$key}}"
                   @if( !empty($value) && isset($value['status']) && $value['status'] == $key) {{"selected"}}
                   @endif
                   >{{$item}}</option>
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
                    @include('order.orders.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>




@endsection

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

 <script>
    let status = document.getElementsByClassName('status');
    for (var i = 0; i < status.length; i++) {
      status[i].addEventListener('change',changeStatus);
    }
    async function changeStatus (){
      console.log(this.value,this.name);
      let response  =await axios({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
        method: 'post',
        url: '{{route("order.changeStatus")}}',
        data: {
          status: this.value,
          id:this.name,
        }
      }).catch(err=>{
        console.log(err.response);
      });
      console.log(response);
    }
   </script>   
@endpush