<div class="table-responsive">
    <table class="table" id="orders-table">
        <thead>
            <tr>
                <th>Customer name</th>
                <th>email</th>
                <th>total</th>
                <th>orderItems</th>
                <th>Number of items</th>
                <th>Number of product</th>
                <th colspan="3">State</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 0;   
            @endphp
        @foreach($orders as $order)
            @php
                $count++;   
            @endphp
            <tr>
                {{-- true là trả về locale mặc định nếu ko có locale đó --}}
                {{-- {{dd($order->getTranslation('en'))}} --}}
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->total }}</td>

                <td>
                    @foreach ($order->orderItems as $item)
                        <span>{{$item->name}}</span>
                    @endforeach
                </td>
                <td>{{ $order->items_count }}</td>
                <td>{{ $order->items_qty }}</td>
                {{-- {{dd($order->status)}} --}}
                <td>
                    @php 
                        $states = $order->statusLabel;
                    @endphp
                    <select name="{{$count}}" class="status">
                        @foreach ($states as $key => $state)
                            <option value={{$key}} @if($key === $order->status) {{"selected"}} @endif>{{$state}}</option>
                        @endforeach
                    </select>
                    
                </td>
                
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $orders->withQueryString()->links() }}
</div>
