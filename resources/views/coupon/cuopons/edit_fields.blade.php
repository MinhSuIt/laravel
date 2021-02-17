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
    {!! Form::number('amount', $coupon->amount, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('value', 'value:') !!}
    {!! Form::text('value', $coupon->value, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('status', 'status:') !!}
    {!! Form::label('Yes', 'Yes') !!}
    {!! Form::radio('status', 1,$coupon->status ? true : false ) !!}
    {!! Form::label('No', 'No') !!}
    {!! Form::radio('status', 0,$coupon->status ? true : false) !!}
</div>
<div class="form-group col-sm-6">
    isPercent: <input type="radio" name="isPercent" value=1 
    @if ($coupon->isPercent)
        {{"checked"}}
    @endif>
    trừ thẳng tiền : <input type="radio" name="isPercent" value=0 @if (!$coupon->isPercent)
    {{"checked"}}
@endif>
</div>
<div class="form-group col-sm-6">
    isTotalCoupon: <input type="radio" name="isTotalCoupon" value=1 
    @if ($coupon->isTotalCoupon)
        {{"checked"}}
    @endif
    >
    isProductCoupon : <input type="radio" name="isTotalCoupon" value=0
    @if (!$coupon->isTotalCoupon)
        {{"checked"}}
    @endif
    >
</div>
<div class="form-group col-sm-6">
    {!! Form::label('product', 'product:') !!}
    <select name="product_id[]" id="product_id" class="product_id form-control"  multiple>
    </select>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('starts_from', 'starts_from:') !!}
    {!! Form::date('starts_from', $coupon->getDateStart(), ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('ends_till', 'ends_till:') !!}
    {!! Form::date('ends_till', $coupon->getDateEnd(), ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('coupon.cuopons.index') }}" class="btn btn-default">Cancel</a>
</div>
