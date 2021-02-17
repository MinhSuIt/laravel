@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 >Customer Groups</h1>
           <a class="btn btn-primary"href="{{ route('customerGroups.create') }}">Add New</a>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('customer.customer_groups.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

