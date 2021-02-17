<!-- Sort Order Field -->
<div class="form-group">
    {!! Form::label('sort_order', 'Sort Order:') !!}
    <p>{{ $customerGroup->sort_order }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerGroup->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerGroup->updated_at }}</p>
</div>

