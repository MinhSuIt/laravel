@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Role
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'roles.store']) !!}

                        @include('authorization.roles.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
    $(document).ready(function() {
        $('.permissions').select2({
            placeholder : "Choose permissions",
            data:{!!json_encode($permissions)!!},
            tags: true,
        });
    });
    </script>
@endpush