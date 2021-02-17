<div class="table-responsive">
    <table class="table" id="cuopons-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>description</th>
                <th>value</th>
        <th>Kind of coupon</th>
        <th>Products</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cuopons as $coupon)
            <tr>
                <td>{{ $coupon->name }}</td>
                <td>{{ $coupon->description }}</td>
            <td>{{ $coupon->getValue() }} </td>
            <td>{{ $coupon->getKindOfCoupon() }}</td>
                <td>
                    @foreach ($coupon->products() as $item)
                        <h5>{{$item->translate(app()->getLocale(),true)->name}}</h5>
                    @endforeach
                </td>
                <td>
                    {!! Form::open(['route' => ['coupon.cuopons.destroy', $coupon->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('coupon.cuopons.edit', [$coupon->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
