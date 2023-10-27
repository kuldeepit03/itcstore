<style>
    .card {
    overflow: scroll;
}
</style>
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
                      

                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <form method="GET">
                                            <div class="row">     
                                                <div class="col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="mobile">Select City</label>
                                                        <select class="form-control input-mask" id="city_code" value="">
                                                            <option value="all">All</option>
                                                            @foreach($cities as $ct)
                                                            @php
                                                                $city = $ct->std_code;
                                                                switch ($city) {
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
                                                            <option value="{{ $ct->std_code }}">{{ $city }}</option>
                                                            @endforeach
                                                            
                                                        </select>
                                                        
                                                    </div>  
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                        <input type="submit" class="form-control input-mask btn btn-primary" name="filter" value="Filter" onclick="get_city_data(event)">                                                         
                                                    </div>
                                                </div>
                                                    
                                                <!-- <div class="col-md-2">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                        <input type="button" class="form-control input-mask btn btn-danger" name="csv-download" value="Download CSV" onclick="">                                                         
                                                    </div>
                                                </div> -->
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
                                                        <tbody id="today-data">
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
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Monthly Stats</h4>
                                        </div>
                                        <div class="card-header align-items-center d-flex">
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table style="font-size:13px" class="table table-bordered table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                    <tr>
                                                        <th class="align-middle text-center" rowspan="2">Order date</th>
                                                        
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
                                                
                                                        <tbody id="monthly-table-head">
                                                            @foreach($result_monthly as $res)
                                                            @php
                                                                $month_num =$res->month; 
                                                                $month_name = date("F", mktime(0, 0, 0, $month_num, 10)); 
                                                            @endphp
                                                            <tr>
                                                                <td class="align-middle text-center">{{ $month_name }}</td>
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

                    <div class="row">
                        <div class="col">
                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <form method="GET">
                                            <div class="row">     
                                                <div class="col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="mobile">From</label>
                                                        <input type="date" class="form-control input-mask" name="audit_from" id="misdata_from" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="mobile">To</label>
                                                        <input type="date" class="form-control input-mask" name="audit_to" id="misdata_to" value="">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-1">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                        <input type="submit" class="form-control input-mask btn btn-primary" name="filter" value="Filter" onclick="get_mis_data(event)">                                                         
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
                                                <tbody id="mis-table-body">
                                                    
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

    function get_mis_data(e){
        e.preventDefault();
        var date_from = $('#misdata_from').val();
        var date_to = $('#misdata_to').val();
        console.log("sbd dates::",date_from,date_to);
        
        $.ajax({
                         type: 'POST',
                         url: "{{ url('get-mis-data') }}",
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         data: {'date_from':date_from ,'date_to':date_to },
                         success: function (data) {
                                console.log("data:::::",data);
                                if(data){
                                    var obj = JSON.parse(data);
                                    var row = '';
                                    console.log("length::::",obj.length);
                                    for(var i = 0; i < obj.length; i++){
                                        var orderDate = obj[i]['date'];
                                        var std_code = obj[i]['std_code'];
                                        var phonepe_orders = obj[i]['phonepe_orders'];
                                        var phonepe_price = obj[i]['phonepe_price'];
                                        var phonepe_cancelled_orders = obj[i]['phonepe_cancelled_orders'];
                                        var phonepe_cancelled_amt = obj[i]['phonepe_cancelled_amt'];

                                        var paytm_orders = obj[i]['paytm_orders'];
                                        var paytm_price = obj[i]['paytm_price'];
                                        var paytm_cancelled_orders = obj[i]['paytm_cancelled_orders'];
                                        var paytm_cancelled_amt = obj[i]['paytm_cancelled_amt'];

                                        var magicpin_orders = obj[i]['magicpin_orders'];
                                        var magicpin_price = obj[i]['magicpin_price'];
                                        var magicpin_cancelled_orders = obj[i]['magicpin_cancelled_orders'];
                                        var magicpin_cancelled_amt = obj[i]['magicpin_cancelled_amt'];

                                        var nobrokerhood_orders = obj[i]['nobrokerhood_orders'];
                                        var nobrokerhood_price = obj[i]['nobrokerhood_price'];
                                        var nobrokerhood_cancelled_orders = obj[i]['nobrokerhood_cancelled_orders'];
                                        var nobrokerhood_cancelled_amt = obj[i]['nobrokerhood_cancelled_amt'];

                                        var city = '';
                                                    switch (std_code) {
                                                        case "std:011":
                                                            city = 'New Delhi';
                                                            break;
                                                        case "std:0124":
                                                            city = 'Gurugram';
                                                            break;
                                                        case "std:080":
                                                            city = 'Bengalore';
                                                            break;
                                                        case "std:0120":
                                                            city = 'Ghaziabad';
                                                            break;
                                                        case "std:022":
                                                            city = 'Mumbai';
                                                            break;
                                                        case "std:0129":
                                                            city = 'Faridabad';
                                                            break;
                                                        case "std:033":
                                                            city = 'Kolkata';
                                                            break;
                                                        case "std:040":
                                                            city = 'Hyderabad';
                                                            break;
                                                        default:
                                                            city ='';
                                                    }

                                        row += '<tr>\
                                                        <td class="align-middle text-center">'+orderDate+'</td>\
                                                        <td class="align-middle text-center">'+city+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(phonepe_price)+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(phonepe_cancelled_amt)+'</td>\
                                                        <td class="align-middle text-center">'+paytm_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(paytm_price)+'</td>\
                                                        <td class="align-middle text-center">'+paytm_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(paytm_cancelled_amt)+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(magicpin_price)+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(magicpin_cancelled_amt)+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(nobrokerhood_price)+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(nobrokerhood_cancelled_amt)+'</td>\
                                                        </tr>';
                                    }
                                    $('#mis-table-body').html(row);
                                }
                            
                            }      
                                   
                });
    }

    function getMonthName(monthNumber) {
      const date = new Date();
      date.setMonth(monthNumber - 1);

      // Using the browser's default locale.
      return date.toLocaleString([], { month: 'long' });
    }


    function get_city_data(e){
        e.preventDefault();
        var std_code = $('#city_code').val();
        if(std_code == 'all'){
            location.reload();
        }
        $.ajax({
                         type: 'POST',
                         url: "{{ url('get-city-data') }}",
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         data: {'std_code':std_code  },
                         success: function (data) {
                            console.log(data);

                            const date = new Date();
                            var current_date = date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate();
                            console.log("current date:::",current_date);
                            var obj = JSON.parse(data);
                            var total_no = obj['today_data']['total_no'];
                            var total_amt = obj['today_data']['total_amt'];
                            var phonepe = obj['today_data']['phonepe'];
                            var phonepe_amt = obj['today_data']['phonepe_amt'];
                            var paytm = obj['today_data']['paytm'];
                            var paytm_amt = obj['today_data']['paytm_amt'];
                            var magicpin = obj['today_data']['magicpin'];
                            var magicpin_amt = obj['today_data']['magicpin_amt'];
                            var nobrokerhood = obj['today_data']['nobrokerhood'];
                            var nobrokerhood_amt = obj['today_data']['nobrokerhood_amt'];
                            var row_today = '';
                            var monthly_row = '';
                            row_today += '<tr>\
                                                <td class="align-middle text-center">' +current_date+ '</td>\
                                                <td class="align-middle text-center">' +phonepe+ '</td>\
                                                <td class="align-middle text-center">' +Math.round(phonepe_amt)+ '</td>\
                                                <td class="align-middle text-center">' +paytm+ ' </td>\
                                                <td class="align-middle text-center">' +Math.round(paytm_amt)+ '</td>\
                                                <td class="align-middle text-center">' +magicpin+ '</td>\
                                                <td class="align-middle text-center">' +Math.round(magicpin_amt)+ '</td>\
                                                <td class="align-middle text-center">' +nobrokerhood+ '</td>\
                                                <td class="align-middle text-center">' +Math.round(nobrokerhood_amt)+ '</td>\
                                                <td class="align-middle text-center">'+total_no+'</td>\
                                                <td class="align-middle text-center">' +Math.round(total_amt)+ '</td>\
                                                </tr>';
                            $('#today-data').html(row_today);
                            for(var i = 0; i < obj['result'].length; i++){
                                // console.log("month::",obj['result'][i]['month']);
                                var month = obj['result'][i]['month'];
                                var phonepe_orders = obj['result'][i]['phonepe_orders'];
                                var phonepe_price = obj['result'][i]['phonepe_price'];
                                if(phonepe_orders != 0){
                                    var phonepeAOV = Math.round(phonepe_price/phonepe_orders);
                                }else{
                                    var phonepeAOV = 0;
                                }
                                var phonepe_cancelled_orders = obj['result'][i]['phonepe_cancelled_orders'];
                                var phonepe_cancelled_amt = obj['result'][i]['phonepe_cancelled_amt'];
                                var paytm_orders = obj['result'][i]['paytm_orders'];
                                var paytm_price = obj['result'][i]['paytm_price'];
                                if(paytm_orders != 0){
                                    var paytmAOV = Math.round(paytm_price/paytm_orders);
                                }else{
                                    var paytmAOV = 0;
                                }
                                var paytm_cancelled_orders = obj['result'][i]['paytm_cancelled_orders'];
                                var paytm_cancelled_amt = obj['result'][i]['paytm_cancelled_amt'];
                                var magicpin_orders = obj['result'][i]['magicpin_orders'];
                                var magicpin_price = obj['result'][i]['magicpin_price'];
                                if(magicpin_orders != 0){
                                    var magicpinAOV = Math.round(magicpin_price/magicpin_orders);
                                }else{
                                    var magicpinAOV = 0;
                                }
                                var magicpin_cancelled_orders = obj['result'][i]['magicpin_cancelled_orders'];
                                var magicpin_cancelled_amt = obj['result'][i]['magicpin_cancelled_amt'];
                                var nobrokerhood_orders = obj['result'][i]['nobrokerhood_orders'];
                                var nobrokerhood_price = obj['result'][i]['nobrokerhood_price'];
                                if(nobrokerhood_orders != 0){
                                    var nobrokerhoodAOV = Math.round(nobrokerhood_price/nobrokerhood_orders);
                                }else{
                                    var nobrokerhoodAOV = 0;
                                }
                                var nobrokerhood_cancelled_orders = obj['result'][i]['nobrokerhood_cancelled_orders'];
                                var nobrokerhood_cancelled_amt = obj['result'][i]['nobrokerhood_cancelled_amt'];
                                

                                
                                monthly_row += '<tr>\
                                                    <td class="align-middle text-center">'+getMonthName(month)+'</td>\
                                                    <td class="align-middle text-center">'+phonepe_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(phonepe_price)+'</td>\
                                                    <td class="align-middle text-center">'+phonepeAOV+' </td>\
                                                    <td class="align-middle text-center"> 0 </td>\
                                                    <td class="align-middle text-center">'+phonepe_cancelled_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(phonepe_cancelled_amt)+'</td>\
                                                    <td class="align-middle text-center">'+paytm_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(paytm_price)+'</td>\
                                                    <td class="align-middle text-center">'+paytmAOV+' </td>\
                                                    <td class="align-middle text-center"> 0 </td>\
                                                    <td class="align-middle text-center">'+paytm_cancelled_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(paytm_cancelled_amt)+'</td>\
                                                    <td class="align-middle text-center">'+magicpin_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(magicpin_price)+'</td>\
                                                    <td class="align-middle text-center">'+magicpinAOV+' </td>\
                                                    <td class="align-middle text-center"> 0 </td>\
                                                    <td class="align-middle text-center">'+magicpin_cancelled_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(magicpin_cancelled_amt)+'</td>\
                                                    <td class="align-middle text-center">'+nobrokerhood_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(nobrokerhood_price)+'</td>\
                                                    <td class="align-middle text-center">'+nobrokerhoodAOV+' </td>\
                                                    <td class="align-middle text-center"> 0 </td>\
                                                    <td class="align-middle text-center">'+nobrokerhood_cancelled_orders+'</td>\
                                                    <td class="align-middle text-center">'+Math.round(nobrokerhood_cancelled_amt)+'</td>\
                                                </tr>';
                            }
                            $('#monthly-table-head').html(monthly_row);
                         }

        });



    }
    
</script>