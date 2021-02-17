<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('description', 'description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'amount:') !!}
    {!! Form::number('amount', 0, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('value', 'value:') !!}
    {!! Form::text('value', 0, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('status', 'status:') !!}
    {!! Form::label('Yes', 'Yes') !!}
    {!! Form::radio('status', true, true) !!}
    {!! Form::label('No', 'No') !!}
    {!! Form::radio('status', false) !!}
</div>
<div class="form-group col-sm-6">
    
    isPercent: <input type="radio" name="isPercent" value=1>
    trừ thẳng tiền : <input type="radio" name="isPercent" value=0>
</div>
<div class="form-group col-sm-6">
    isTotalCoupon: <input type="radio" name="isTotalCoupon" value=1>
    isProductCoupon : <input type="radio" name="isTotalCoupon" value=0>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('product', 'product:') !!}
    <select name="product_id[]" id="product_id" class="product_id form-control"  multiple>
    </select>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('starts_from', 'starts_from:') !!}
    {!! Form::date('starts_from', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('ends_till', 'ends_till:') !!}
    {!! Form::date('ends_till', 0, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('coupon.cuopons.index') }}" class="btn btn-default">Cancel</a>
</div>
