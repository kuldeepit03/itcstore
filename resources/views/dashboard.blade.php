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
                                                            <label class="form-label" for="unit">Order No</label>     
                                                            
                                                            <input type="text" class="form-control input-mask" name="audit_no" value="{{@$_GET['audit_no']}}">
                                                            
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
                                <!--end row-->
                              
                                <div class="row">
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
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
                                                        <a href="" class="text-decoration-underline">View details</a>

                                                    </div>
                                                   
                                                </div>
                                               
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body pb-0">
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
                                                    <div class="w-100">
                                                        <h4  class="fs-20 fw-semibold ff-secondary"><span class="counter-value" data-target="{{$delivered}}">0</span></h4>
                                                        <h4 class="fs-22 fw-semibold ff-secondary">₹<span class="counter-value" data-target="{{ round($deliv_amt, 2) }}">0</span></h4>
                                                        
                                                        <div class="d-flex justify-content-between " >
                                                            <div>
                                                                <p class="text-uppercase fw-medium text-success text-truncate mb-0">Settled</p>
                                                                <p class="fs-16 fw-semibold" >₹<span class="counter-value" data-target="1296">0</span></p>
        
                                                            </div>
                                                                   
                                                             <div>
                                                                <p class="text-uppercase fw-medium text-danger text-truncate mb-0">PENDING</p>
                                                                <p class="fs-16 fw-semibold" >₹<span class="counter-value" data-target="3000">0</span></p>
        
                                                         
                                                             </div>
                                                        </div>
                                                   
                                                               
                                                        


                                                    </div>
                                                    
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
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
                                                        <h4 class="fs-22 fw-semibold ff-secondary">₹<span class="counter-value" data-target="{{ round($cancel_amt, 2) }}">1260</span></h4>
                                                        <a href="" class="text-decoration-underline">View details</a>
                                                    </div>
                                                 
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
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
                                                        <h4  class="fs-22 fw-semibold ff-secondary"><span class="counter-value" data-target="{{$pending}}">0</span></h4>
                                                        <h4 class="fs-22 fw-semibold ff-secondary">₹<span class="counter-value" data-target="{{ round($pending_amt, 2) }}">0</span></h4>
                                                        <a href="" class="text-decoration-underline">View details</a>
                                                    </div>
                                                   
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    
                                   

                                   
                                </div> <!-- end row-->
                                
                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="card">
                                            <div class="card-header border-0 align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Sales Projection</h4>
                                                <!--<div>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        ALL
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        1M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        6M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        1Y
                                                    </button>
                                                </div>-->
                                            </div><!-- end card header -->

                                            <div class="card-header p-0 border-0 bg-light-subtle">
                                                <div class="row g-0 text-center">
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="7585">0</span></h5>
                                                            <p class="text-muted mb-0">Orders</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1">₹<span class="counter-value" data-target="22.89">0</span>k</h5>
                                                            <p class="text-muted mb-0">Earnings</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="367">0</span></h5>
                                                            <p class="text-muted mb-0">Refunds</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-6 col-sm-3">
                                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                            <h5 class="mb-1 text-success"><span class="counter-value" data-target="18.92">0</span>%</h5>
                                                            <p class="text-muted mb-0">Conversation Ratio</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body p-0 pb-2">
                                                <div class="w-100">
                                                    <div id="customer_impression_charts" data-colors='["--vz-primary", "--vz-success", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-4">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Top Performing SKUS</h4>
                                                <div class="flex-shrink-0">
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        Export Report
                                                    </button>
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
                                                            {!! nl2br(e(str_limit(wordwrap($sku->sku_name, 40, "\n", true), 100))) !!}
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
                                                    <!--<div class="d-flex mb-2">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-info me-2"></i>Kurukure 10g</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="mb-0">17.51%</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mb-2">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-success me-2"></i>Lays Classic Salted 20g</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="mb-0">23.05%</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mb-2">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-warning me-2"></i>Mountain Dew 250ml</p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="mb-0">12.22%</p>
                                                        </div>
                                                    </div>-->
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-danger me-2"></i>Others </p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <p class="mb-0">{{ round(( $res / $total_sale[0]->total_sku_sale)*100, 2)}}%</p>
                                                        </div>
                                                    </div>
                                                </div>
            
                                                <!--<div class="mt-2 text-center">
                                                    <a href="javascript:void(0);" class="text-muted text-decoration-underline">Show All</a>
                                                </div>-->
                                               
            
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    <!-- end col -->
                                </div>                     
<!-- Recent Orders -->
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                                            <!--<div class="flex-shrink-0">
                                                <button type="button" class="btn btn-soft-info btn-sm">
                                                    <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                                </button>
                                            </div>-->
                                        </div><!-- end card header -->

                                        <!--<form class="app-search d-none d-md-block">
                                            <div class="position-relative">
                                                <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                                                <span class="mdi mdi-magnify search-widget-icon"></span>
                                                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                                            </div>
                                           
                                        </form>-->
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
                                                            {{ \Carbon\Carbon::parse($r_order->b_created_at)->format('d-m-Y H:i:s') }}
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
                                                   
                                                    <div class="text-muted">Showing recent <span class="fw-semibold">15</span> Orders
                                                    </div>
                                                </div>
                                              
                                            </div>
                                        </div>
                                        
                                    </div> <!-- .card-->
                                </div> <!-- end row-->

                            </div> <!-- end .h-100-->

                        </div> <!-- end col -->

                        
                    </div>

                </div>
                <!-- container-fluid -->
                <!-- Grids in modals -->
@endsection