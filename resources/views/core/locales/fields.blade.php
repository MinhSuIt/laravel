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

<!-- Direction Field -->
<div class="form-group col-sm-6">
    {!! Form::label('direction', 'Direction:') !!}
    {!! Form::select('direction', ['ltr' => 'LeftToRight', 'rtl' => 'RightToLeft'], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('locales.index') }}" class="btn btn-default">Cancel</a>
</div>
