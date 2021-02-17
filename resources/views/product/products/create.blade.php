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
                    {!! Form::open(['route' => 'product.products.store','files' => true]) !!}
                        {{-- <div class="form-group col-sm-12">
                            {!! Form::label('kind_of_product', 'Kind of product') !!} <br/>
                            <select class="kind_of_product block" style="width: 100%" name="kind_of_product" id="kind_of_product" >
                                <option value="simple" >simple product</option>
                                <option value="variation" >variation product</option>
                            </select>
                        </div> --}}
                        @include('product.products.add_fields')
                        {{-- <div id="list-option">
                                <div class="form-group col-sm-4">
                                    <label for="exampleFormControlSelect1">Attribute group</label>
                                    <select class="form-control" id="attribute_group_id" name="attribute_group_id">
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="exampleFormControlSelect1">Attribute</label>
                                    <select class="form-control" id="attribute_option_id" name="attribute_option_id">
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="exampleFormControlSelect1">variation attribute</label>
                                    <select class="form-control" id="attribute_option_id" name="attribute_option_id">
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12"><button type="button" class="btn btn-primary addOption" >Add variation attribute</button></div>
                        </div> --}}
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('product.products.index') }}" class="btn btn-default">Cancel</a>
                        </div>
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



{{-- <script>
    var count = 1;
    function getStringOption(count) {
        return `<div class="form-group col-sm-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach ($languages as $language)
                                    @if ($loop->first)
                                        @php $active=' active' @endphp
                                    @else 
                                        @php $active='' @endphp
                                    @endif
                                    <li class="nav-item{{$active}}">
                                    <a class="nav-link{{$active}}" id="{{$language->code}}-tab-${count}" data-toggle="tab" href="#{{$language->code}}-${count}" role="tab" aria-controls="{{$language->code}}-${count}" aria-selected="true">{{$language->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="myTabContent">
                        
                                @foreach ($languages as $language)
                                    @if ($loop->first)
                                        @php $active=' active in' @endphp
                                    @else 
                                        @php $active='' @endphp
                                    @endif
                                    <div class="tab-pane fade{{$active}}" id="{{$language->code}}-${count}" role="tabpanel" aria-labelledby="{{$language->code}}-tab-${count}">
                                            {!! Form::label($language->code.'[name]', 'Name') !!}
                                            {!! Form::text('attribute_value[${count}]'.'['.$language->code.']'.'[name]', null, ['class' => 'form-control']) !!}
                        
                                    </div>
                                    </li>
                                @endforeach
                        
                                
                            </div>
                    </div>`;
    }
    document.querySelector('.addOption').addEventListener('click',function (e) {
        document.getElementById('option-list').insertAdjacentHTML('beforeend',getStringOption(count));
        count++;
    })
</script> --}}
<script>
    document.querySelector('.addOption').addEventListener('click',function(e){

                let text = document.getElementById('attribute_option_id').options[document.getElementById('attribute_option_id').selectedIndex].text;
                let value=document.getElementById('attribute_option_id').options[document.getElementById('attribute_option_id').selectedIndex].value;
                let price = Number(document.getElementById('price').value);
                let amount = Number(document.getElementById('amount').value);

                if(text !== '' && value!=='' && typeof price === 'number' && typeof amount === 'number'){
                    document.getElementById('list-option').insertAdjacentHTML('beforeend',renderAttributeOption(text,value,price,amount));
                }else{
                    alert('ban nhap thieu thong tin');
                }
            })
    function renderAttributeOption(text,value,price,amount){
        return `
            <div>
                <h1><span>${text}</span>-<span>extra price:${price}</span>-<span>amount:${amount}</span></h1>
                <input type="hidden" name="attribute_options[${value}][price]" value="${price}"/>
                <input type="hidden" name="attribute_options[${value}][amount]" value="${amount}"/>
            </div>
        `;
    }
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