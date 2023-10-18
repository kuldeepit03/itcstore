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
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">Good Morning, Aman!</h4>
                                                <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                                            </div>
                                            <form>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label" for="mobile">From</label>
                                                                        <input type="date" class="form-control input-mask" name="audit_from" value="{{@$_GET['audit_from']}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label" for="mobile">To</label>
                                                                        <input type="date" class="form-control input-mask" name="audit_to" value="{{@$_GET['audit_to']}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-4">
                                                                <label class="form-label" for="unit">Order No</label>     
                                                               
                                                                <input type="date" class="form-control input-mask" name="audit_from" value="{{@$_GET['audit_from']}}">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="mb-4">
                                                                <label class="form-label" for="unit">Vendor</label>     
                                                                <select class="form-control" name="vendor">
                                                                    <option value="">All</option>
                                                                    
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="mb-4">
                                                                <label class="form-label" for="unit">Filter</label>     
                                                                <input type="submit" class="form-control input-mask btn btn-primary" name="filter" value="Filter">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @csrf
                                                </form>
                                            <!--<div class="mt-3 mt-lg-0">
                                                <form action="javascript:void(0);">
                                                    <div class="row g-3 mb-0 align-items-center">
                                                        <div class="col-sm-auto">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control border-0 dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y" data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                                <div class="input-group-text bg-primary border-primary text-white">
                                                                    <i class="ri-calendar-2-line"></i>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </form>
                                            </div>-->
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->            
                <!-- Recent Orders -->
                                <div class="row">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-soft-info btn-sm">
                                                    <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                                </button>
                                            </div>
                                        </div><!-- end card header -->

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
                                                            <td><button  class="btn btn-sm btn-soft-info" data-bs-toggle="modal" data-bs-target="#orderDetails">View</button></td>
                                                        </tr><!-- end tr -->
                                                        @endforeach
                                                    </tbody><!-- end tbody -->
                                                </table><!-- end table -->
                                            </div>
                                            <div class="align-items-center mt-2 row g-3 text-center">
                                            {{$ordersdata->links()}}
                                               
                                            </div>
                                        </div>                                      
                                    </div> 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

<div class="modal modal-xl fade" id="orderDetails" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-3 pe-0" >
                <form action="javascript:void(0);">
                    <div class="row">
                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                    <tr>
                                        <th scope="col">S No.</th>
                                        <th scope="col">SKU Name</th>
                                       
                                        <th scope="col">MRP</th>
                                        <th scope="col">Order Qty </th>
                                        <th scope="col">Delivered Qty </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1. 
                                        </td>
                                        <td>
                                            <a href="" class="fw-medium link-primary">Lay's Potato Chips 50g, Classic Salted Flavour, Crunchy Chips & Snacks</a>
                                        </td>
                                        <td>₹20.00
                                        </td>
                                        <td> <span class="text-info">1</span></td>
                                        <td> <span class="text-success">1</span></td>

                                    </tr><!-- end tr -->
                                    <tr>
                                        <td>
                                            2. 
                                        </td>
                                        <td>
                                            <a href="" class="fw-medium link-primary">Lay's Potato Chips 50g, Classic Salted Flavour, Crunchy Chips & Snacks</a>
                                        </td>
                                        <td>₹20.00
                                        </td>
                                        <td> <span class="text-info">1</span></td>
                                        <td> <span class="text-success">1</span></td>

                                    </tr><!-- end tr -->
                                    <tr>
                                        <td>
                                            3. 
                                        </td>
                                        <td>
                                            <a href="" class="fw-medium link-primary">Lay's Potato Chips 50g, Classic Salted Flavour, Crunchy Chips & Snacks</a>
                                        </td>
                                        <td>₹20.00
                                        </td>
                                        <td> <span class="text-info">1</span></td>
                                        <td> <span class="text-success">1</span></td>

                                    </tr><!-- end tr -->
                                    <tr>
                                        <td>
                                            4. 
                                        </td>
                                        <td>
                                            <a href="" class="fw-medium link-primary">Lay's Potato Chips 50g, Classic Salted Flavour, Crunchy Chips & Snacks</a>
                                        </td>
                                        <td>₹20.00
                                        </td>
                                        <td> <span class="text-info">1</span></td>
                                        <td> <span class="text-success">1</span></td>

                                    </tr><!-- end tr -->
                              
                                   
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div>
                            <div class="hstack gap-2 justify-content-end mt-4 pe-4">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                    </div><!--end row-->
                </form>
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