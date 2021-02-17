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
                   {!! Form::model($attributeGroup, ['route' => ['attributeGroups.update', $attributeGroup->id], 'method' => 'patch']) !!}

                        @include('attribute.attribute_groups.edit_fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection