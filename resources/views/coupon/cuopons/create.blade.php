@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Coupon
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'coupon.cuopons.store']) !!}

                        @include('coupon.cuopons.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('.product_id').select2({
        placeholder : "Choose products",
        data:{!!json_encode($products)!!},
        tags: true,
    });
});
</script>
@endpush