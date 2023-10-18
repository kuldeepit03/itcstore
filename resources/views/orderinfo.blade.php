@extends('layouts.app', ['pageSlug' => 'dashboard'])
@section('content')
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Product List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Products</li>
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
                            
                                                                
                        </div>           
        
                        <div class="row">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Order Details</h4>
                                    <div class="flex-shrink-0">
                                    <a href="{{URL ('/orders')}}"><button type="button" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Back
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
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
                                            
                                            @foreach($products as $sno => $product)
                                                <tr>
                                                    <td>
                                                    {{$sno + 1}}
                                                    </td>
                                                    <td>
                                                    {{$product->sku_name}}
                                                    </td>
                                                    
                                                    <td>
                                                        <span class="text-success">₹ {{$product->price}} </span>
                                                    </td>
                                                    <td><span class="text-info">{{$product->qty}}</span>
                                                    
                                                    </td>
                                                    <td>
                                                        <span class="text-success"> {{$product->shipped_qty }}</span>
                                                   
                                                    </td>
                                                    
                                                </tr><!-- end tr -->
                                                @endforeach
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                        <div class="hstack gap-2 justify-content-end mt-4 pe-4">
                                            <a href="{{URL ('/orders')}}"><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button></a>
                                        </div>
                                    </div>
                                    <div class="align-items-center mt-2 row g-3 text-center">
                                   
                                        
                                    </div>
                                </div>                                      
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
@endsection