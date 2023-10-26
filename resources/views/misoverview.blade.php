@extends('layouts.app', ['pageSlug' => 'mis-overview'])
@section('content')
                <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">MIS Overview</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">MIS Reports</li>
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
                                                    
                                                <div class="col-md-1">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                        <input type="submit" class="form-control input-mask btn btn-primary" name="filter" value="Filter">                                                         
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                                                                            
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                        <input type="button" class="form-control input-mask btn btn-danger" name="csv-download" value="Download CSV" onclick="download_csv()">                                                         
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
                                            <h4 class="card-title mb-0 flex-grow-1">Today's Stats</h4>
                                        </div>
                                        <div class="card-header align-items-center d-flex">
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table style="font-size:13px" class="table table-bordered table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th scope="col" class="align-middle text-center" rowspan="2">Date</th>
                                                                <th class="align-middle text-center" colspan="2">PhonePay</th>
                                                                <th class="align-middle text-center" colspan="2">Paytm</th>
                                                                <th class="align-middle text-center" colspan="2">Magicpin</th>
                                                                <th class="align-middle text-center" colspan="2">NoBrokerHood</th>
                                                                <th class="align-middle text-center" colspan="2">Total</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="align-middle text-center">Order Qty</th>
                                                                <th class="align-middle text-center">Amount</th>
                                                                <th class="align-middle text-center">Order Qty</th>
                                                                <th class="align-middle text-center">Amount</th>
                                                                <th class="align-middle text-center">Order Qty</th>
                                                                <th class="align-middle text-center">Amount</th>
                                                                <th class="align-middle text-center">Order Qty</th>
                                                                <th class="align-middle text-center">Amount</th>
                                                                <th class="align-middle text-center">Order Qty</th>
                                                                <th class="align-middle text-center">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-middle text-center">{{ date("Y-m-d") }}</td>
                                                                <td class="align-middle text-center">{{ $phonepe }}</td>
                                                                <td class="align-middle text-center">{{ round($phonepe_amt, 2) }}</td>
                                                                <td class="align-middle text-center">{{ $paytm }}</td>
                                                                <td class="align-middle text-center">{{ round($paytm_amt, 2) }}</td>
                                                                <td class="align-middle text-center">{{ $magicpin }}</td>
                                                                <td class="align-middle text-center">{{ round($magicpin_amt, 2) }}</td>
                                                                <td class="align-middle text-center">{{ $nobrokerhood }}</td>
                                                                <td class="align-middle text-center">{{ round($nobrokerhood_amt, 2) }}</td>
                                                                <td class="align-middle text-center">{{ $total_no }}</td>
                                                                <td class="align-middle text-center">{{ round($total_amt, 2) }}</td>
                                                            </tr>  
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>  
</div>                                
                                    </div> 
                                </div> 


                                <div class="row">
                                    <div class="card" style="overflow: scroll;">
                                       
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Weekly Stats</h4>
                                        </div>
                                        <div class="card-header align-items-center d-flex">
                                            <table style="font-size:13px" class="table table-bordered table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th class="align-middle text-center" rowspan="2">Order date</th>
                                                        <th class="align-middle text-center" rowspan="2">Location</th>
                                                        <th class="align-middle text-center" colspan="6">Pincode</th>
                                                        <th class="align-middle text-center" colspan="6">Paytm</th>
                                                        <th class="align-middle text-center" colspan="6">Magicpin</th>
                                                        <th class="align-middle text-center" colspan="6">NoBrokerHood</th>
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">AOV</th>
                                                        <th class="align-middle text-center">Repeat custom</th>
                                                        <th class="align-middle text-center">Cancel Qty</th>
                                                        <th class="align-middle text-center">Cancel Amount</th>
                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">AOV</th>
                                                        <th class="align-middle text-center">Repeat custom</th>
                                                        <th class="align-middle text-center">Cancel Qty</th>
                                                        <th class="align-middle text-center">Cancel Amount</th>
                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">AOV</th>
                                                        <th class="align-middle text-center">Repeat custom</th>
                                                        <th class="align-middle text-center">Cancel Qty</th>
                                                        <th class="align-middle text-center">Cancel Amount</th>
                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">AOV</th>
                                                        <th class="align-middle text-center">Repeat custom</th>
                                                        <th class="align-middle text-center">Cancel Qty</th>
                                                        <th class="align-middle text-center">Cancel Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach($result as $res)
													@php
                                                    switch ($res->std_code) {
                                                        case "std:011":
                                                            $city = 'New Delhi';
                                                            break;
                                                        case "std:0124":
                                                            $city = 'Gurugram';
                                                            break;
                                                        case "std:080":
                                                            $city = 'Bengalore';
                                                            break;
                                                        case "std:0120":
                                                            $city = 'Ghaziabad';
                                                            break;
                                                        case "std:022":
                                                            $city = 'Mumbai';
                                                            break;
                                                        case "std:0129":
                                                            $city = 'Faridabad';
                                                            break;
                                                        case "std:033":
                                                            $city = 'Kolkata';
                                                            break;
                                                        case "std:040":
                                                            $city = 'Hyderabad';
                                                            break;
                                                        default:
                                                            $city ='';
                                                    }

 

                                                    @endphp
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $res->date }}</td>
                                                        <td class="align-middle text-center">{{ $city }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->phonepe_orders!=0)

                                                             {{ round($res->phonepe_price/$res->phonepe_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->phonepe_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_cancelled_amt }}</td>

                                                        <td class="align-middle text-center">{{ $res->paytm_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->paytm_orders!=0)

                                                             {{ round($res->paytm_price/$res->paytm_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->paytm_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_cancelled_amt }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->magicpin_orders!=0)

                                                             {{ round($res->magicpin_price/$res->magicpin_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_cancelled_amt }}</td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->nobrokerhood_orders!=0)

                                                             {{ round($res->nobrokerhood_price/$res->nobrokerhood_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_cancelled_amt }}</td>

                                                                                                        
                                                    </tr>
</tbody>
                                                     @endforeach  
                                                     <thead class="text-muted table-light">
                                                    <tr>
                                                        <th colspan="26">
                                                            
                                                                Monthly Stats
                                                            
                                                        </th>
                                                    </tr>
</thead>
</tbody>
                                                     @foreach($result_monthly as $res)
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $res->month }}</td>
                                                        <td class="align-middle text-center"></td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->phonepe_orders!=0)

                                                             {{ round($res->phonepe_price/$res->phonepe_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->phonepe_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_cancelled_amt }}</td>

                                                        <td class="align-middle text-center">{{ $res->paytm_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->paytm_orders!=0)

                                                             {{ round($res->paytm_price/$res->paytm_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->paytm_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_cancelled_amt }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->magicpin_orders!=0)

                                                             {{ round($res->magicpin_price/$res->magicpin_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->magicpin_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_cancelled_amt }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_orders }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_price }}</td>
                                                        <td class="align-middle text-center">
                                                            @if($res->nobrokerhood_orders!=0)

                                                             {{ round($res->nobrokerhood_price/$res->nobrokerhood_orders,0) }}
                                                            @else
                                                             0
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center"> 0 </td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_cancelled_orders  }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_cancelled_amt }}</td>

                                                                                                        
                                                    </tr>
                                                     @endforeach  
                                                    
                                                </tbody>
                                            </table>
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

<script type="text/javascript">

    function download_csv() {
        var _url = "{{url('download-csv')}}";
        window.location.href = _url;
    }
    
</script>