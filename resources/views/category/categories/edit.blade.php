@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Category
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($category, ['route' => ['category.categories.update', $category->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('category.categories.edit_fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('.attributeGroups').select2({
        placeholder : "Choose attributeGroups",
        data:{!!json_encode($attributeGroups)!!},
        tags: true,
    });
});
</script>
@endpush