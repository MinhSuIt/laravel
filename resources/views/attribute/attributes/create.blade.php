@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Attribute
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'attributes.store','id'=>'form']) !!}

                        @include('attribute.attributes.add_fields')
                        <div id="option-list">
                            <div class="form-group col-sm-12">
                                <button type="button" class="btn btn-primary float-right addOption" style="float:right" >Add attribute value</button>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($languages as $language)
                                        @if ($loop->first)
                                            @php $active=' active' @endphp
                                        @else 
                                            @php $active='' @endphp
                                        @endif
                                        <li class="nav-item{{$active}}">
                                        <a class="nav-link{{$active}}" id="{{$language->code}}-tab-0" data-toggle="tab" href="#{{$language->code}}-0" role="tab" aria-controls="{{$language->code}}-0" aria-selected="true">{{$language->name}}</a>
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
                                        <div class="tab-pane fade{{$active}}" id="{{$language->code}}-0" role="tabpanel" aria-labelledby="{{$language->code}}-tab-0">
                                                {!! Form::label($language->code.'[name]', 'Name') !!}
                                                {!! Form::text('attribute_value[0]'.'['.$language->code.']'.'[name]', null, ['class' => 'form-control']) !!}

                            
                                        </div>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('attributes.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
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
    </script>
@endpush