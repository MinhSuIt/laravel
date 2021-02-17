<!-- Ispercent Field -->
<div class="form-group">
    {!! Form::label('isPercent', 'Ispercent:') !!}
    <p>{{ $coupon->isPercent }}</p>
</div>

<!-- Istotalcoupon Field -->
<div class="form-group">
    {!! Form::label('isTotalCoupon', 'Istotalcoupon:') !!}
    <p>{{ $coupon->isTotalCoupon }}</p>
</div>

<!-- Product Id Field -->
<div class="form-group">
    {!! Form::label('product_id', 'Product Id:') !!}
    <p>{{ $coupon->product_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $coupon->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $coupon->updated_at }}</p>
</div>

