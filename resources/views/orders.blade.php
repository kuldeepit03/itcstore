@extends('layouts.app', ['pageSlug' => 'dashboard'])
@section('content')
                <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Order List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Orders</li>
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
                                        
                                            <form method="GET" action="{{ route('orders') }}">
                                                <div class="row">     
                                                    <div class="col-md-2">
                                                        <div class="mb-6">
                                                            <label class="form-label" for="mobile">From</label>
                                                            <input type="date" class="form-control input-mask" name="audit_from" value="{{@$_GET['audit_from']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-6">
                                                            <label class="form-label" for="mobile">To</label>
                                                            <input type="date" class="form-control input-mask" name="audit_to" value="{{@$_GET['audit_to']}}">
                                                        </div>
                                                    </div>
                                                            
                                                        
                                                        <div class="col-md-2">
                                                            <div class="mb-6">
                                                                <label class="form-label" for="unit">Order No</label>     
                                                               
                                                                <input type="text" class="form-control input-mask" name="audit_no" value="{{@$_GET['audit_no']}}">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
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
                                                                <label class="form-label" for="unit">Order Status</label>     
                                                                <select class="form-control" name="status">
                                                                    <option value="">All</option>
                                                                    @foreach($order_status as $status)
                                                                    <option value="{{$status->order_status}}">{{$status->order_status}}</option>
                                                                    @endforeach
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="mb-6">
                                                                <label class="form-label" for="unit">&nbsp;</label>     
                                                                <input type="submit" class="form-control input-mask btn btn-primary" name="filter" value="Filter">                                                         
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @csrf
                                                </form>
                                    </div>                                    
                                </div>           
                <!-- Recent Orders -->
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                                        </div>

                                        <form class="app-search d-none d-md-block">
                                            <div class="position-relative">
                                                <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                                                <span class="mdi mdi-magnify search-widget-icon"></span>
                                                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                                            </div>
                                           
                                        </form>
                                        <div class="card-body">
                                            <div class="table-responsive table-card">
                                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
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
                                                    @php
                                                    $totalRecords = $ordersdata->total();
                                                    $serialNumber = $totalRecords - ($ordersdata->currentPage() - 1) * 20;
                                                    @endphp
                                                    @foreach($ordersdata as $order)
                                                        <tr>
                                                            <td>
                                                           {{ $serialNumber-- }}
                                                            </td>
                                                            <td>
                                                            {{$order->order_no}}
                                                            </td>
                                                            <td>{{$order->bap_id}}</td>
                                                            <td>
                                                                <span class="text-success">₹ {{$order->total_price}} </span>
                                                            </td>
                                                            <td>
                                                            {{ \Carbon\Carbon::parse($order->b_created_at)->format('d-m-Y H:i:s') }}
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-success-subtle text-success fs-11 p-2">{{$order->order_status}}</span>
                                                            </td>
                                                            <td><a href="{{URL('/orderinfo/'.$order->order_no)}}"><button class="btn btn-sm btn-soft-info">View</button></a></td>
                                                            <!--<td><button  class="btn btn-sm btn-soft-info" data-bs-toggle="modal" data-bs-target="#orderDetails">View</button></td>-->
                                                        </tr><!-- end tr -->
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="align-items-center mt-2 row g-3 text-center">
                                            {{ $ordersdata->appends(request()->input())->links() }}
                                               
                                            </div>
                                        </div>                                      
                                    </div> 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
<style>
    .w-5
    { 
        width:16px;}
    .leading-5
    {
        margin-top: 1rem;
    }
</style>
@endsection