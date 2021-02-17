@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Product
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($product, ['route' => ['product.products.update', $product->id], 'method' => 'patch','files' => true]) !!}

                        @include('product.products.edit_fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
@push('scripts')
    <script>
        $('.categories').select2({
            placeholder : "Choose Category",
            data:{!!json_encode($categoriesCus)!!},
            tags: true,
        });
    </script>   
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    
    tinymce.init({
            selector: ".textarea-content",
            // inline: true,
            relative_urls: false,
            paste_data_images: true,
            height:600,
            // automatic_uploads: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1:
                "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons",
            // images_upload_url: "/uploadByContentProduct",
            file_picker_types: "image",
            image_title: true,
            // override default upload handler to simulate successful upload
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement("input");
                input.setAttribute("type", "file");
                input.setAttribute("accept", "image/*");
                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function() {
                        var id = "blobid" + new Date().getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(",")[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                };
                input.click();
            }
        });
        </script>
        <script>
            // console.log(tinymce.activeEditor;
            // tinymce.activeEditor.selection.select(tinymce.activeEditor.getBody());
            // tinymce.activeEditor.execCommand( "Copy" );
        </script>
@endpush