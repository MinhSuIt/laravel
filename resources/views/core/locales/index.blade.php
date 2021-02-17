@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 >Locales</h1>
           <a class="btn btn-primary "  href="{{ route('locales.create') }}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('core.locales.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

