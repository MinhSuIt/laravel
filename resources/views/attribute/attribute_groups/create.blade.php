@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Attribute Group
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'attributeGroups.store']) !!}

                        @include('attribute.attribute_groups.add_fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('.categories').select2({
        placeholder : "Choose Category",
        data:{!!json_encode($categoriesCus)!!},
        tags: true,
    });
});
</script>
@endpush