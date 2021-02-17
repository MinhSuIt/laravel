<!-- Addressable Id Field -->
<div class="form-group">
    {!! Form::label('addressable_id', 'Addressable Id:') !!}
    <p>{{ $address->addressable_id }}</p>
</div>

<!-- Addressable Type Field -->
<div class="form-group">
    {!! Form::label('addressable_type', 'Addressable Type:') !!}
    <p>{{ $address->addressable_type }}</p>
</div>

<!-- Info Field -->
<div class="form-group">
    {!! Form::label('info', 'Info:') !!}
    <p>{{ $address->info }}</p>
</div>

