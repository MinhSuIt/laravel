@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Config
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('core.configs.show_fields')
                    <a href="{{ route('configs.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
