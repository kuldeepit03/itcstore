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
                        <h4 class="mb-sm-0">SBD Overview</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">SBD Reports</li>
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
                                                        <th class="align-middle text-center" rowspan="2">Order Month</th>
                                                        <th class="align-middle text-center" colspan="6">Pincode</th>
                                                        <th class="align-middle text-center" colspan="6">Paytm</th>
                                                        <th class="align-middle text-center" colspan="6">Magicpin</th>
                                                        <th class="align-middle text-center" colspan="6">NoBrokerHood</th>
                                                       
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery/Re-attempt</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>

                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery/Re-attempt</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>

                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery/Re-attempt</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>

                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>
                                                        
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody id="sbd-monthly-table-body">
                                                    
                                                    @foreach($monthly_result as $res)
                                                   @php
                                                                $month_num =$res->month; 
                                                                $month_name = date("F", mktime(0, 0, 0, $month_num, 10)); 
                                                            @endphp
                                                    <tr>
                                                        <td class="align-middle text-center">{{ $month_name }}</td>
                                                        
                                                        <td class="align-middle text-center">{{ $res->phonepe_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res-> phonepe_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_cancelled_orders }}</td>


                                                        <td class="align-middle text-center">{{ $res->paytm_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_cancelled_orders }}</td>

                                                        <td class="align-middle text-center">{{ $res->magicpin_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_cancelled_orders }}</td>

                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_cancelled_orders }}</td>                                            
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                  
                                            </table>
                                                </div>
                                            </div>  
                                        </div>                                
                                    </div> 
                                </div> 
                    
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <form>
                                            <div class="row">     
                                                <div class="col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="mobile">From</label>
                                                        <input type="date" class="form-control input-mask" name="audit_from" id="sbd_from" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="mobile">To</label>
                                                        <input type="date" class="form-control input-mask" name="audit_to" id="sbd_to" value="">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-1">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                        <input type="submit" class="form-control input-mask btn btn-primary" name="filter" value="Filter" onclick="get_sbd_data(event)">                                                         
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                                                                            
                                                    </div>
                                                </div>

                                                <!-- <div class="col-md-2">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="unit">&nbsp;</label>     
                                                        <input type="button" class="form-control input-mask btn btn-danger" name="csv-download" value="Download CSV" onclick="download_csv()">                                                         
                                                    </div>
                                                </div> -->
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
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery/Re-attempt</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>

                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery/Re-attempt</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>

                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery/Re-attempt</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>

                                                        <th class="align-middle text-center">Order Qty</th>
                                                        <th class="align-middle text-center">Amount</th>
                                                        <th class="align-middle text-center">Order Delivered</th>
                                                        <th class="align-middle text-center">Out for delivery</th>
                                                        <th class="align-middle text-center">Shipped & Returned</th>
                                                        <th class="align-middle text-center">Order Cancellation</th>
                                                        
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody id="sbd-table-body">
                                                    
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
                                                        <td class="align-middle text-center">{{ $res->delivery_dt }}</td>
                                                        <td class="align-middle text-center">{{ $city }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res-> phonepe_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->phonepe_cancelled_orders }}</td>


                                                        <td class="align-middle text-center">{{ $res->paytm_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->paytm_cancelled_orders }}</td>

                                                        <td class="align-middle text-center">{{ $res->magicpin_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->magicpin_cancelled_orders }}</td>

                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_order_qty }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_tprice }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_order_delivered }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_order_outfordelivery }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_shipped_returned }}</td>
                                                        <td class="align-middle text-center">{{ $res->nobrokerhood_cancelled_orders }}</td>

                                                                                                     
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                       
                                                    
                                                     
                                            </table>
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
    
    function get_sbd_data(e){
        e.preventDefault();
        var sbd_from=$('#sbd_from').val();
        var sbd_to=$('#sbd_to').val();
        console.log("sbd dates::",sbd_from,sbd_to);
        $.ajax({
                         type: 'POST',
                         url: "{{ url('get-sbd-data') }}",
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         data: {'sbd_from':sbd_from ,'sbd_to':sbd_to },
                         success: function (data) {
                                console.log("data:::::",data);
                                if(data){
                                    var obj = JSON.parse(data);
                                    console.log("length::::",obj.length);
                                    var row = '';
                                    for(var i = 0; i < obj.length; i++){
                                        var delivery_dt = obj[i]['delivery_dt'];
                                        var std_code = obj[i]['std_code'];
                                        var phonepe_order_qty = obj[i]['phonepe_order_qty'];
                                        var phonepe_tprice = obj[i]['phonepe_tprice'];
                                        var phonepe_order_delivered = obj[i]['phonepe_order_delivered'];
                                        var phonepe_order_outfordelivery = obj[i]['phonepe_order_outfordelivery'];
                                        var phonepe_cancelled_orders = obj[i]['phonepe_cancelled_orders'];
                                        var phonepe_shipped_returned = obj[i]['phonepe_shipped_returned'];

                                        var paytm_order_qty = obj[i]['paytm_order_qty'];
                                        var paytm_tprice = obj[i]['paytm_tprice'];
                                        var paytm_order_delivered = obj[i]['paytm_order_delivered'];
                                        var paytm_order_outfordelivery = obj[i]['paytm_order_outfordelivery'];
                                        var paytm_cancelled_orders = obj[i]['paytm_cancelled_orders'];
                                        var paytm_shipped_returned = obj[i]['paytm_shipped_returned'];

                                        var magicpin_order_qty = obj[i]['magicpin_order_qty'];
                                        var magicpin_tprice = obj[i]['magicpin_tprice'];
                                        var magicpin_order_delivered = obj[i]['magicpin_order_delivered'];
                                        var magicpin_order_outfordelivery = obj[i]['magicpin_order_outfordelivery'];
                                        var magicpin_cancelled_orders = obj[i]['magicpin_cancelled_orders'];
                                        var magicpin_shipped_returned = obj[i]['magicpin_shipped_returned'];

                                        var nobrokerhood_order_qty = obj[i]['nobrokerhood_order_qty'];
                                        var nobrokerhood_tprice = obj[i]['nobrokerhood_tprice'];
                                        var nobrokerhood_order_delivered = obj[i]['nobrokerhood_order_delivered'];
                                        var nobrokerhood_order_outfordelivery = obj[i]['nobrokerhood_order_outfordelivery'];
                                        var nobrokerhood_cancelled_orders = obj[i]['nobrokerhood_cancelled_orders'];
                                        var nobrokerhood_shipped_returned = obj[i]['nobrokerhood_shipped_returned'];
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
                                                        <td class="align-middle text-center">'+delivery_dt+'</td>\
                                                        <td class="align-middle text-center">'+city+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(phonepe_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_shipped_returned+'</td>\
                                                        <td class="align-middle text-center">'+paytm_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(paytm_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+paytm_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+paytm_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+paytm_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+paytm_shipped_returned+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(magicpin_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_shipped_returned+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(nobrokerhood_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_shipped_returned+'</td>\
                                                        </tr>';
                                    }
                                    $('#sbd-table-body').html(row);
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


    function get_city_data(e){  //monthly sbd data as per the city code
        e.preventDefault();
        var std_code = $('#city_code').val();
        if(std_code == 'all'){
            location.reload();
        }
        $.ajax({
                         type: 'POST',
                         url: "{{ url('get-sbd-city-data') }}",
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         data: {'std_code':std_code  },
                         success: function (data) {
                            // console.log(data); 
                            const date = new Date();
                            
                            var obj = JSON.parse(data);
                            var monthly_row = '';
                            
                            for(var i = 0; i < obj.length; i++){
                               
                                var month = obj[i]['month'];
                                var phonepe_order_qty = obj[i]['phonepe_order_qty'];
                                        var phonepe_tprice = obj[i]['phonepe_tprice'];
                                        var phonepe_order_delivered = obj[i]['phonepe_order_delivered'];
                                        var phonepe_order_outfordelivery = obj[i]['phonepe_order_outfordelivery'];
                                        var phonepe_cancelled_orders = obj[i]['phonepe_cancelled_orders'];
                                        var phonepe_shipped_returned = obj[i]['phonepe_shipped_returned'];

                                        var paytm_order_qty = obj[i]['paytm_order_qty'];
                                        var paytm_tprice = obj[i]['paytm_tprice'];
                                        var paytm_order_delivered = obj[i]['paytm_order_delivered'];
                                        var paytm_order_outfordelivery = obj[i]['paytm_order_outfordelivery'];
                                        var paytm_cancelled_orders = obj[i]['paytm_cancelled_orders'];
                                        var paytm_shipped_returned = obj[i]['paytm_shipped_returned'];

                                        var magicpin_order_qty = obj[i]['magicpin_order_qty'];
                                        var magicpin_tprice = obj[i]['magicpin_tprice'];
                                        var magicpin_order_delivered = obj[i]['magicpin_order_delivered'];
                                        var magicpin_order_outfordelivery = obj[i]['magicpin_order_outfordelivery'];
                                        var magicpin_cancelled_orders = obj[i]['magicpin_cancelled_orders'];
                                        var magicpin_shipped_returned = obj[i]['magicpin_shipped_returned'];

                                        var nobrokerhood_order_qty = obj[i]['nobrokerhood_order_qty'];
                                        var nobrokerhood_tprice = obj[i]['nobrokerhood_tprice'];
                                        var nobrokerhood_order_delivered = obj[i]['nobrokerhood_order_delivered'];
                                        var nobrokerhood_order_outfordelivery = obj[i]['nobrokerhood_order_outfordelivery'];
                                        var nobrokerhood_cancelled_orders = obj[i]['nobrokerhood_cancelled_orders'];
                                        var nobrokerhood_shipped_returned = obj[i]['nobrokerhood_shipped_returned'];

                                 monthly_row += '<tr>\
                                                        <td class="align-middle text-center">'+getMonthName(month)+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(phonepe_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+phonepe_shipped_returned+'</td>\
                                                        <td class="align-middle text-center">'+paytm_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(paytm_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+paytm_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+paytm_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+paytm_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+paytm_shipped_returned+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(magicpin_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+magicpin_shipped_returned+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_order_qty+'</td>\
                                                        <td class="align-middle text-center">'+Math.round(nobrokerhood_tprice)+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_order_delivered+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_order_outfordelivery+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_cancelled_orders+'</td>\
                                                        <td class="align-middle text-center">'+nobrokerhood_shipped_returned+'</td>\
                                                        </tr>';
                            }
                            // console.log("row::",monthly_row);
                            $('#sbd-monthly-table-body').html(monthly_row);
                         }
        });

    }

</script>