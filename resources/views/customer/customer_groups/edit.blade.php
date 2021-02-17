@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Customer Group
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($customerGroup, ['route' => ['customerGroups.update', $customerGroup->id], 'method' => 'patch']) !!}

                        @include('customer.customer_groups.update_fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection