<!-- Addressable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('addressable_id', 'Addressable Id:') !!}
    {!! Form::number('addressable_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Addressable Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('addressable_type', 'Addressable Type:') !!}
    {!! Form::number('addressable_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Info Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('info', 'Info:') !!}
    {!! Form::textarea('info', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('addresses.index') }}" class="btn btn-default">Cancel</a>
</div>
