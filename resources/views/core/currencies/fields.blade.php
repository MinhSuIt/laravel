<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exchange_rate', 'Exchange rate:') !!}
    {!! Form::number('exchange_rate', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('symbol', 'Symbol:') !!}
    {!! Form::text('symbol', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('format', 'Format:') !!}
    {!! Form::text('format', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::label('active', 'active:') !!}
    <label class="radio-inline">
        {!! Form::radio('active', "1", true) !!} Yes
    </label>

    <label class="radio-inline">
        {!! Form::radio('active', "0", null) !!} No
    </label>

</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('currencies.index') }}" class="btn btn-default">Cancel</a>
</div>
