@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

                        @include('users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.roles').select2({
            placeholder : "Choose roles",
            data:{!!json_encode($roles)!!},
            tags: true,
        });
    });
</script>
@endpush