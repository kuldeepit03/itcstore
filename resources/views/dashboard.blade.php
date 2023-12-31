@extends('layouts.app', ['pageSlug' => 'dashboard'])
@section('content')
                <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Home</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
                    <div class="row">
                        <div class="col">
                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">Good Morning, Aman!</h4>
                                                <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                                            </div>
                                            <div class="col-8">
                                            <form method="GET" action="{{ route('dashboard') }}">
                                                <div class="row">     
                                                    <div class="col-md-3">
                                                        <div class="mb-6">
                                                            <label class="form-label" for="mobile">From</label>
                                                            <input type="date" class="form-control input-mask" name="audit_from" value="{{@$_GET['audit_from']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-6">
                                                            <label class="form-label" for="mobile">To</label>
                                                            <input type="date" class="form-control input-mask" name="audit_to" value="{{@$_GET['audit_to']}}">
                                                        </div>
                                                    </div>
                                                            
                                                        
                                                    <div class="col-md-3">
                                                        <div class="mb-6">
                                                        <label class="form-label" for="unit">Buyer Apps</label>     
                                                                <select class="form-control" name="buyer">
                                                                    <option value="">All</option>
                                                                    @foreach($buyer_app as $buyer)
                                                                    <option value="{{$buyer->bap_id}}">{{$buyer->bap_id}}</option>
                                                                    @endforeach
                                                                    
                                                                </select>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-2">
                                                        <div class="mb-6">
                                                            <label class="form-label" for="unit">&nbsp;</label>     
                                                            <input type="submit" class="form-control input-mask btn btn-primary" name="filter" value="Filter">                                                         
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-1">
                                                        <div class="mb-6">
                                                            
                                                            <label class="form-label" for="unit">&nbsp;</label> 
                                                            <button type="submit" name="clear" value="1" class="form-control input-mask btn btn-secondary">Clear</button>
                                                            
                                                        </div>
                                                    </div>-->
                                                </div>
                                                    @csrf
                                            </form>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                              
                                <div class="row">
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Orders </p>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                                            <i class="bx bx-box text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div class="mb-4">
                                                        <h4  class="fs-20 fw-semibold ff-secondary "><span class="counter-value" data-target="{{ $total_no }}">0</span></h4>
                                                        <h4 class="fs-22 fw-semibold ff-secondary ">₹<span class="counter-value" data-target="{{ round($total_amt, 2) }}">0</span></h4>
                                                        <a href="{{ route('orders') }}" class="text-decoration-underline">View details</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Delivered Orders</p>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        
                                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                                            <i class="ri-truck-line text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div class="mb-4">
                                                         <h4  class="fs-20 fw-semibold ff-secondary"><span class="counter-value" data-target="{{$delivered}}">0</span></h4>
                                                        <h4 class="fs-22 fw-semibold ff-secondary">₹<span class="counter-value" data-target="{{ round($deliv_amt, 2) }}">0</span></h4>
                                                        <a href="{{ route('orders') }}?status=Delivered" class="text-decoration-underline">View details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Cancelled Orders</p>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                            <i class="ri-close-circle-line text-danger"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div class="mb-4">
                                                         <h4  class="fs-20 fw-semibold ff-secondary"><span class="counter-value" data-target="{{$cancelled}}">0</span></h4>
                                                        <h4 class="fs-22 fw-semibold ff-secondary">₹<span class="counter-value" data-target="{{ round($cancel_amt, 2) }}">0</span></h4>
                                                        <a href="{{ route('orders') }}?status=Cancelled" class="text-decoration-underline">View details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending Deliveries</p>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                            <i class="bx bx-shopping-bag text-primary"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div class="mb-4">
                                                        <h4  class="fs-20 fw-semibold ff-secondary"><span class="counter-value" data-target="{{$pending}}">0</span></h4>
                                                        <h4 class="fs-22 fw-semibold ff-secondary">₹<span class="counter-value" data-target="{{ round($pending_amt, 2) }}">0</span></h4>
                                                        <a href="" class="">&nbsp;</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                                
                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="card">
                                        
                                           <div class="card-header border-0 align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Sales Projection</h4>
                                            </div>
                                            

                                            <div class="card-header p-0 border-0 bg-light-subtle">
                                                <div class="row g-0 text-center">
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="{{ $total_no }}">0</span></h5>
                                                            <p class="text-muted mb-0">Orders</p>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1">₹<span class="counter-value" data-target="{{ round($total_amt, 2) }}">0</span></h5>
                                                            <p class="text-muted mb-0">Earnings</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="{{$delivered}}">0</span></h5>
                                                            <p class="text-muted mb-0">Delivered</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="{{$cancelled}}">0</span></h5>
                                                            <p class="text-muted mb-0">Cancelled</p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="card-body p-0 pb-2">
                                                <div class="w-100">
                                                
                                                <div id="curve_chart" style="width: 800px; height: 500px"></div>
                                                
                                                    <!--<div id="customer_impression_charts" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts" dir="ltr"></div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Top Performing SKUS</h4>
                                                <div class="flex-shrink-0">
                                                    <!--<button type="button" class="btn btn-soft-primary btn-sm">
                                                        Export Report
                                                    </button>-->
                                                </div>
                                            </div>
            
                                            <div class="card-body">
            
                                                <div class="row align-items-center">
                                                    <div class="col-6">
                                                        <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">Total Sales</h6>
                                                        <h4 class="mb-0">{{ $total_sale[0]->total_sku_sale }}</h4>
                                                        <!--<p class="mb-0 mt-2 text-muted"><span class="badge bg-success-subtle text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 15.72 % </span> vs. previous month</p>-->
                                                    </div>
                                                    
                                                </div>
                                                <!--<div class="mt-3 pt-2">
                                                    <div class="progress progress-lg rounded-pill">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 18%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 19%" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>-->
            
                                                <div class="mt-3 pt-2">
                                                @php
                                                $result = 0;
                                                @endphp
                                                @foreach($top_sku as $sku)
                                               
                                                    <div class="d-flex mb-2">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-primary me-2"></i>
                                                            <!--{!! nl2br(e(str_limit(wordwrap($sku->sku_name, 35, "\n", true), 100))) !!}-->
                                                            {{ \Illuminate\Support\Str::limit($sku->sku_name, 35) }}
                                                           </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="mb-0">{{ round(($sku->sku_sale / $total_sale[0]->total_sku_sale)*100, 2)}}%</p>
                                                        </div>
                                                    </div>
                                                    @php
                                                    $result = $result + $sku->sku_sale;
                                                    $res = $total_sale[0]->total_sku_sale - $result;
                                                    @endphp
                                                    @endforeach
                                                   
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-danger me-2"></i>Others </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="mb-0">{{ round(( $res / $total_sale[0]->total_sku_sale)*100, 2)}}%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>                     
<!-- Recent Orders -->
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>                                          
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive table-card">
                                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0" id = "order_result">
                                                    <thead class="text-muted table-light">
                                                        <tr>
                                                            <th scope="col">S No.</th>
                                                            <th scope="col">Order No</th>
                                                            <th scope="col">Buyer App</th>
                                                            <th scope="col">Order Amount</th>
                                                            <th scope="col">Order Date</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($recent_orders as $ind => $r_order)
                                                    
                                                        <tr>
                                                            <td>
                                                            {{$ind + 1}} 
                                                            </td>
                                                            <td>
                                                                <!--
                                                                    {{ $loop->iteration }}
                                                                    <a href="" class="fw-medium link-primary">{{$r_order->order_no}}</a>-->
                                                                {{$r_order->order_no}}
                                                            </td>
                                                            <td>{{$r_order->bap_id}} </td>
                                                            <td>
                                                                <span class="text-success">₹ {{$r_order->total_price}} </span>
                                                            </td>
                                                            <td>
                                                            {{ \Carbon\Carbon::parse($r_order->datetime)->format('d-m-Y H:i:s') }}
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-success-subtle text-success fs-11 p-2">{{$r_order->order_status}}</span>
                                                            </td>
                                                                <!--
                                                                <span class="badge bg-warning-subtle fs-11 text-warning p-2">PICKUP STARTED</span>
                                                                <span class="badge bg-success-subtle text-success fs-11 p-2">DISPATCHED</span>
                                                                <span class="badge bg-danger-subtle text-danger fs-11 p-2">REJECTED</span> -->

                                                                <!--<td><button  class="btn btn-sm btn-soft-info view-order" data-bs-toggle="modal" data-bs-target="#orderDetails" data-order="{{ $r_order->order_no }}">View</button></td>-->

                                                                <td><a href="{{URL('/orderinfo/'.$r_order->order_no)}}"><button class="btn btn-sm btn-soft-info">View</button></a></td>
                                                            
                                                            <!--<button  class="btn btn-sm btn-soft-info view-order" data-order="{{ $r_order->order_no }}" data-bs-toggle="modal" data-bs-target="#orderDetails">View</button>
                                                            <td><a href="javascript:void(0);"><button data-order="{{ $r_order->order_no }}" class="btn btn-sm btn-soft-info view-order">View</button></a>-->
                                                        
                                                        </tr><!-- end tr -->
                                                        @endforeach
                                                       
                                                    </tbody><!-- end tbody -->
                                                </table><!-- end table -->
                                            </div>
                                            <div class="align-items-center mt-2 row g-3 text-center text-sm-start">
                                                <div class="col-sm">
                                                   
                                                    <div class="text-muted">Showing recent <span class="fw-semibold">20</span> Orders
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      var monthly= @json($monthly);
      console.log(monthly);
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(monthly);
        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
@endsection