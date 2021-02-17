@extends('layouts.app')
@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
@endsection
@section('content')
{{-- {{dd($statistics)}} --}}


<div class="product-sales-area mg-b-30 pd-t-15">
  <div class="container-fluid">
      <div class="row">
          <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
              <div class="product-sales-chart">
                  <div class="portlet-title">
                      <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <canvas id="doanhthu"></canvas>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <canvas id="customer"></canvas>
                        </div>
                        <div class="col-xs-12 col-md-12">
                            <canvas id="order"></canvas>
                        </div>

                      </div>
                  </div>
                  {{-- <div id="extra-area-chart" style="height: 356px;"></div> --}}
              </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 res-mg-t-30 table-mg-t-pro-n tb-sm-res-d-n dk-res-t-d-n">
                  <h3 class="box-title">Total Customer</h3>
                  <ul class="list-inline two-part-sp">
                      <li>
                          <div id="sparklinedash"></div>
                      </li>
                    <li class="text-right sp-cn-r"><i class="fa fa-user" aria-hidden="true"></i> <span class="counter text-success">{{$statistics['total_customers']['total']}}</span></li>
                  </ul>
              </div>
              <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
                  <h3 class="box-title">Total Order</h3>
                  <ul class="list-inline two-part-sp">
                      <li>
                          <div id="sparklinedash2"></div>
                      </li>
                      <li class="text-right graph-two-ctn"><i class="fa fa-user" aria-hidden="true"></i> <span class="counter text-purple">{{$statistics['total_orders']['total']}}</span></li>
                  </ul>
              </div>
              <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
                  <h3 class="box-title">Total Order Pending</h3>
                  <ul class="list-inline two-part-sp">
                      <li>
                          <div id="sparklinedash3"></div>
                      </li>
                    <li class="text-right graph-three-ctn"><i class="fa fa-user" aria-hidden="true"></i> <span class="counter text-info">{{$statistics['orderPendingNumber']}}</span></li>
                  </ul>
              </div>
              <div class="white-box analytics-info-cs table-dis-n-pro tb-sm-res-d-n dk-res-t-d-n">
                <h3 class="box-title">total doanh thu </h3>
                  <ul class="list-inline two-part-sp">
                      <li>
                          <div id="sparklinedash4"></div>
                      </li>
                      <li class="text-right graph-four-ctn"><i class="fa fa-user" aria-hidden="true"></i> <span class="text-danger"><span class="counter">{{$statistics['total_sales']['total']}}
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="traffic-analysis-area mg-b-30">
  <div class="container-fluid">
      <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="social-media-edu">
                  <i class="fa fa-facebook"></i>
                  <div class="social-edu-ctn">
                      <h3>Doanh thu trong tháng</h3>
                  <p>{{$statistics['inMonth']['proceeds']}}</p>
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="social-media-edu twitter-cl res-mg-t-30 table-mg-t-pro-n">
                  <i class="fa fa-twitter"></i>
                  <div class="social-edu-ctn">
                      <h3>New customer trong tháng</h3>
                      <p>{{$statistics['inMonth']['newCustomerNumber']}}</p>
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="social-media-edu linkedin-cl res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                  <i class="fa fa-linkedin"></i>
                  <div class="social-edu-ctn">
                      <h3>Số đơn hàng trong tháng</h3>
                      <p>{{$statistics['inMonth']['OrderNumber']}}</p>
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="social-media-edu youtube-cl res-mg-t-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                  <i class="fa fa-youtube"></i>
                  <div class="social-edu-ctn">
                      <h3>Số đơn hàng trong tháng thành công</h3>
                      <p>{{$statistics['inMonth']['successOrderNumber']}}</p>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="product-status mg-b-15">
  <div class="container-fluid">
      <div class="row">
          <div class="col-xs-12 col-md-4">
            <div class="product-status-wrap drp-lst">
                <h4>Top customer</h4>
                <div class="asset-inner">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Name </th>
                            <th>Email</th>
                            <th>total_orders</th>
                            <th>money</th>
                        </tr>
                        @php
                            $customers = $statistics['customer_with_most_sales'] ?? [];
                        @endphp
                        @foreach ($customers as $item)
                        <tr>
                            <td>1</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->total_orders}}</td>
                        <td>{{$item->money}}</td>
                        </tr>
                        @endforeach

                        
                    </table>
                </div>
            </div>
        </div>
          <div class="col-xs-12 col-md-4">
            <div class="product-status-wrap drp-lst">
                <h4>Top category</h4>
                <div class="asset-inner">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Name </th>
                            <th>product quantity</th>
                        </tr>
                        @php
                            $categories = $statistics['top_selling_categories'] ?? [];
                        @endphp
                        @foreach ($categories as $item)
                        <tr>
                            <td>1</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->quantity}}</td>
                        </tr>
                        @endforeach

                        
                    </table>
                </div>
            </div>
        </div>
          <div class="col-xs-12 col-md-4">
            <div class="product-status-wrap drp-lst">
                <h4>Top product</h4>
                <div class="asset-inner">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Name </th>
                            <th>total_quantity</th>
                        </tr>
                        @php
                            $customers = $statistics['top_selling_products'] ?? [];
                        @endphp
                        @foreach ($customers as $item)
                        <tr>
                            <td>1</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->total_quantity}}</td>
                        </tr>
                        @endforeach

                        
                    </table>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>

@endsection
@push('scripts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> 
 <script src="//cdn.jsdelivr.net/npm/ramda@latest/dist/ramda.min.js"></script>  
 <script>
    let ctx1 = document.getElementById('doanhthu');
    let data1 ={!!json_encode($statistics['total_sales']['perMonthOfYear'])!!};
    let labels1 =R.pluck('month',data1);
    let dt1 =R.pluck('total',data1);
    var myChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels1,
            datasets: [{
                label: 'Doanh thu theo tháng trong năm',
                data: dt1,
                backgroundColor: [
                    'rgba(255,228,196, 0.2)',
                        'rgba(210,105,30, 0.2)',
                        'rgba(176,196,222, 0.2)',
                        'rgba(107,142,35, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                ],
                // borderColor: [
                //     'rgba(255, 99, 132, 1)',
                //     'rgba(54, 162, 235, 1)',
                //     'rgba(255, 206, 86, 1)',
                //     'rgba(75, 192, 192, 1)',
                //     'rgba(153, 102, 255, 1)',
                //     'rgba(255, 159, 64, 1)'
                // ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>
     <script>
        let ctx = document.getElementById('customer');
        let data ={!!json_encode($statistics['total_customers']['perMonthOfYear'])!!};
        let labels =R.pluck('month',data);
        let dt =R.pluck('customerNumber',data);
        console.log(labels);
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Customer đăng ký theo tháng  trong năm',
                    data: dt,
                    backgroundColor: [
                        
                        'rgba(255,228,196, 0.2)',
                        'rgba(210,105,30, 0.2)',
                        'rgba(176,196,222, 0.2)',
                        'rgba(107,142,35, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    // borderColor: [
                    //     'rgba(255, 99, 132, 1)',
                    //     'rgba(54, 162, 235, 1)',
                    //     'rgba(255, 206, 86, 1)',
                    //     'rgba(75, 192, 192, 1)',
                    //     'rgba(153, 102, 255, 1)',
                    //     'rgba(255, 159, 64, 1)'
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        </script>
     <script>
        let ctx2 = document.getElementById('order');
        let data2 ={!!json_encode($statistics['total_orders']['perMonthOfYear'])!!};
        let labels2 =R.pluck('month',data2);
        let dt2 =R.pluck('orderNumber',data2);
        var myChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Số order theo tháng trong năm',
                    data: dt2,
                    backgroundColor: [
                        
                        'rgba(255,228,196, 0.2)',
                        'rgba(210,105,30, 0.2)',
                        'rgba(176,196,222, 0.2)',
                        'rgba(107,142,35, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    // borderColor: [
                    //     'rgba(255, 99, 132, 1)',
                    //     'rgba(54, 162, 235, 1)',
                    //     'rgba(255, 206, 86, 1)',
                    //     'rgba(75, 192, 192, 1)',
                    //     'rgba(153, 102, 255, 1)',
                    //     'rgba(255, 159, 64, 1)'
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        </script>
@endpush