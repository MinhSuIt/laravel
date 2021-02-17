@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 >Roles</h1>
           <a class="btn btn-primary" href="{{ route('roles.create') }}">Add New</a>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('authorization.roles.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

