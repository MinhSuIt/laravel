@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Currencies</h1>
           <a class="btn btn-primary" href="{{ route('currencies.create') }}">Add New</a>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('core.currencies.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

