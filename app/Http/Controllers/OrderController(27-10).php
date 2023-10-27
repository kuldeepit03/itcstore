<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Orders::query();

        if ($request->filled('audit_no')) {
            $query->where('order_no', $request->input('audit_no'));
        }

        if ($request->filled('buyer')) {
            $query->where('bap_id', $request->input('buyer'));
        }
        if ($request->filled('status')) {
            $query->where('order_status', $request->input('status'));
        }
        if ($request->filled('audit_from')) {
            $query->whereDate('datetime', '>=', Carbon::parse($request->audit_from)->format('Y-m-d'));
        }

        if ($request->filled('audit_to')) {
            $query->whereDate('datetime', '<=', Carbon::parse($request->audit_to)->format('Y-m-d'));
        }
        $data['ordersdata'] = $query->orderBy('id', 'desc')->paginate(20);
    
        $data['buyer_app']= Orders::select('bap_id')->distinct()->get();

        $data['order_status']= Orders::select('order_status')->distinct()->get();
       
         return view('orders',$data);
    }
	
	public function MISOverview(Request $request){
        //$query = Orders::query();
        $currentDate = date('Y-m-d');
        
        //$query->whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'));

        $data['total_no'] = Orders::whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'))->count();

        $data['total_amt'] = Orders::whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'))->sum(DB::raw('total_price - shipping_charges'));

        $data['phonepe'] = Orders::where([ ['bap_id', 'like','%shopping-network.phonepe.com%'],['datetime', 'like', $currentDate.'%'] ])->whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'))->get()->count();

        $data['phonepe_amt'] = Orders::where('bap_id', 'like','%shopping-network.phonepe.com%')->whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'))->sum(DB::raw('total_price - shipping_charges'));

        $data['paytm'] = Orders::where([ ['bap_id', 'like','%ondc.paytm.com%'],['datetime', 'like', $currentDate.'%'] ])->whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'))->get()->count();

        $data['paytm_amt'] = Orders::where([ ['bap_id', 'like','%ondc.paytm.com%'],['datetime', 'like', $currentDate.'%'] ])->sum(DB::raw('total_price - shipping_charges'));

        $data['magicpin'] = Orders::where([ ['bap_id', 'like','%webapi.magicpin.in%'],['datetime', 'like', $currentDate.'%'] ])->whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'))->get()->count();

        $data['magicpin_amt'] = Orders::where([ ['bap_id', 'like','%webapi.magicpin.in%'],['datetime', 'like', $currentDate.'%'] ])->sum(DB::raw('total_price - shipping_charges'));

        $data['nobrokerhood'] = Orders::where([ ['bap_id', 'like','%nobrokerhood%'],['datetime', 'like', $currentDate.'%'] ])->whereDate('datetime', '=', Carbon::parse($currentDate)->format('Y-m-d'))->get()->count();

        $data['nobrokerhood_amt'] = Orders::where([ ['bap_id', 'like','%nobrokerhood%'],['datetime', 'like', $currentDate.'%'] ])->sum(DB::raw('total_price - shipping_charges'));

        $start_date = date('Y-m-d',strtotime("last Monday"));
        $end_date = date('Y-m-d', strtotime($start_date . ' + 6 days'));

        // Query for MIS overview data
       $result = Orders::selectRaw('date(datetime) as date, std_code, 
                SUM(IF(bap_id like "%shopping-network.phonepe.com%", 1, 0)) AS phonepe_orders,
                SUM(IF(bap_id like "%shopping-network.phonepe.com%", total_price, 0)) AS phonepe_price,
                SUM(IF(bap_id like "%shopping-network.phonepe.com%" AND order_status="Cancelled", 1, 0)) AS phonepe_cancelled_orders,
                SUM(IF(bap_id like "%shopping-network.phonepe.com%" AND order_status="Cancelled", total_price, 0)) AS phonepe_cancelled_amt,
                SUM(IF(bap_id like "%ondc.paytm.com%", 1, 0)) AS paytm_orders,
                SUM(IF(bap_id like "%ondc.paytm.com%", total_price, 0)) AS paytm_price,
                SUM(IF(bap_id like "%ondc.paytm.com%" AND order_status="Cancelled", 1, 0)) AS paytm_cancelled_orders,
                SUM(IF(bap_id like "%ondc.paytm.com%" AND order_status="Cancelled", total_price, 0)) AS paytm_cancelled_amt,
                SUM(IF(bap_id like "%webapi.magicpin.in%", 1, 0)) AS magicpin_orders,
                SUM(IF(bap_id like "%webapi.magicpin.in%", total_price, 0)) AS magicpin_price,
                SUM(IF(bap_id like "%webapi.magicpin.in%" AND order_status="Cancelled", 1, 0)) AS magicpin_cancelled_orders,
                SUM(IF(bap_id like "%webapi.magicpin.in%" AND order_status="Cancelled", total_price, 0)) AS magicpin_cancelled_amt,
                SUM(IF(bap_id like "%nobrokerhood%", 1, 0)) AS nobrokerhood_orders,
                SUM(IF(bap_id like "%nobrokerhood%", total_price, 0)) AS nobrokerhood_price,
                SUM(IF(bap_id like "%nobrokerhood%" AND order_status="Cancelled", 1, 0)) AS nobrokerhood_cancelled_orders,
                SUM(IF(bap_id like "%nobrokerhood%" AND order_status="Cancelled", total_price, 0)) AS nobrokerhood_cancelled_amt')
                ->whereBetween(DB::raw('date(datetime)'), [$start_date, $end_date])
                ->groupBy(DB::raw('date(datetime)'), 'std_code')
                ->orderBy('date', 'desc')
                ->get();
                
                $result_monthly = Orders::selectRaw("MONTH(datetime) as month,
                    SUM(IF(bap_id like '%shopping-network.phonepe.com%', 1, 0)) AS phonepe_orders,
                    SUM(IF(bap_id like '%shopping-network.phonepe.com%', total_price, 0)) AS phonepe_price,
                    SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Cancelled', 1, 0)) AS phonepe_cancelled_orders,
                    SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Cancelled', total_price, 0)) AS phonepe_cancelled_amt,
                    SUM(IF(bap_id like '%ondc.paytm.com%', 1, 0)) AS paytm_orders,
                    SUM(IF(bap_id like '%ondc.paytm.com%', total_price, 0)) AS paytm_price,
                    SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Cancelled', 1, 0)) AS paytm_cancelled_orders,
                    SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Cancelled', total_price, 0)) AS paytm_cancelled_amt,
                    SUM(IF(bap_id like '%webapi.magicpin.in%', 1, 0)) AS magicpin_orders,
                    SUM(IF(bap_id like '%webapi.magicpin.in%', total_price, 0)) AS magicpin_price,
                    SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Cancelled', 1, 0)) AS magicpin_cancelled_orders,
                    SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Cancelled', total_price, 0)) AS magicpin_cancelled_amt,
                    SUM(IF(bap_id like '%nobrokerhood%', 1, 0)) AS nobrokerhood_orders,
                    SUM(IF(bap_id like '%nobrokerhood%', total_price, 0)) AS nobrokerhood_price,
                    SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Cancelled', 1, 0)) AS nobrokerhood_cancelled_orders,
                    SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Cancelled', total_price, 0)) AS nobrokerhood_cancelled_amt")
                    ->whereBetween('datetime', ['2023-04-01', '2023-09-30'])
                    ->groupByRaw("MONTH(datetime)")
                    ->get();
             
        

        return view('misoverview',$data,compact('result','result_monthly'));
    }


     public function downloadCSV(Request $request)
    {
       $fileName = 'overview.csv';
       
       $result = Orders::selectRaw('date(datetime) as date, std_code, 
                SUM(IF(bap_id like "%shopping-network.phonepe.com%", 1, 0)) AS phonepe_orders,
                SUM(IF(bap_id like "%shopping-network.phonepe.com%", total_price, 0)) AS phonepe_price,
                SUM(IF(bap_id like "%shopping-network.phonepe.com%" AND order_status="Cancelled", 1, 0)) AS phonepe_cancelled_orders,
                SUM(IF(bap_id like "%shopping-network.phonepe.com%" AND order_status="Cancelled", total_price, 0)) AS phonepe_cancelled_amt,
                SUM(IF(bap_id like "%ondc.paytm.com%", 1, 0)) AS paytm_orders,
                SUM(IF(bap_id like "%ondc.paytm.com%", total_price, 0)) AS paytm_price,
                SUM(IF(bap_id like "%ondc.paytm.com%" AND order_status="Cancelled", 1, 0)) AS paytm_cancelled_orders,
                SUM(IF(bap_id like "%ondc.paytm.com%" AND order_status="Cancelled", total_price, 0)) AS paytm_cancelled_amt,
                SUM(IF(bap_id like "%webapi.magicpin.in%", 1, 0)) AS magicpin_orders,
                SUM(IF(bap_id like "%webapi.magicpin.in%", total_price, 0)) AS magicpin_price,
                SUM(IF(bap_id like "%webapi.magicpin.in%" AND order_status="Cancelled", 1, 0)) AS magicpin_cancelled_orders,
                SUM(IF(bap_id like "%webapi.magicpin.in%" AND order_status="Cancelled", total_price, 0)) AS magicpin_cancelled_amt,
                SUM(IF(bap_id like "%nobrokerhood%", 1, 0)) AS nobrokerhood_orders,
                SUM(IF(bap_id like "%nobrokerhood%", total_price, 0)) AS nobrokerhood_price,
                SUM(IF(bap_id like "%nobrokerhood%" AND order_status="Cancelled", 1, 0)) AS nobrokerhood_cancelled_orders,
                SUM(IF(bap_id like "%nobrokerhood%" AND order_status="Cancelled", total_price, 0)) AS nobrokerhood_cancelled_amt')
                ->whereBetween(DB::raw('date(datetime)'), ['2023-10-01', '2023-10-11'])
                ->groupBy(DB::raw('date(datetime)'), 'std_code')
                ->get();



            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = array('', 'Order Date', '', '','Phonepe', '','', '','', '','Paytm', '','', '', '', '','Magicpin', '','', '','', '','Nobrokerhood', '','', '');
            $columns2 = array('Order date', 'Location', 'Order Qty', 'Amount','AOV', 'Repeat custom','Cancelled qty', 'Cancelled amt','Order Qty', 'Amount','AOV', 'Repeat custom','Cancelled qty', 'Cancelled amt', 'Order Qty', 'Amount','AOV', 'Repeat custom','Cancelled qty', 'Cancelled amt','Order Qty', 'Amount','AOV', 'Repeat custom','Cancelled qty', 'Cancelled amt');
            

            $callback = function() use($result, $columns,$columns2) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fputcsv($file, $columns2);
                $i=1;
                $row=array();
                foreach ($result as $res) {

                    $magicpin_AOV = 0;
                    $phonepe_AOV = 0;
                    $paytm_AOV = 0;
                    $nobrokerhood_AOV = 0;
                    if($res->phonepe_orders != 0){
                        $phonepe_AOV = round($res->phonepe_price/$res->phonepe_orders,0);
                    }
                    if($res->paytm_orders!=0){
                        $paytm_AOV = round($res->paytm_price/$res->paytm_orders,0);
                    }
                    if($res->magicpin_orders!=0){
                        $magicpin_AOV = round($res->magicpin_price/$res->magicpin_orders,0);
                    }
                    if($res->nobrokerhood_orders!=0){
                        $nobrokerhood_AOV = round($res->nobrokerhood_price/$res->nobrokerhood_orders,0);
                    }

                    $row['Order date']  = $res->date;
                    $row['Location']    = $res->std_code;
                    $row['Phonepe Order Qty']    = $res->phonepe_orders;
                    $row['Phonepe Amount']  = $res->phonepe_price;
                    $row['Phonepe AOV']  = $phonepe_AOV;
                    $row['Phonepe Repeat custom']  = 0;
                    $row['Phonepe Cancelled qty']  = $res->phonepe_cancelled_orders;
                    $row['Phonepe Cancelled amt']  = $res->phonepe_cancelled_amt;

                    $row['Paytm Order Qty']    = $res->paytm_orders;
                    $row['Paytm Amount']  = $res->paytm_price;
                    $row['Paytm AOV']  = $paytm_AOV;
                    $row['Paytm Repeat custom']  = 0;
                    $row['Paytm Cancelled qty']  = $res->paytm_cancelled_orders;
                    $row['Paytm Cancelled amt']  = $res->paytm_cancelled_amt;

                    $row['Magicpin Order Qty']    = $res->magicpin_orders;
                    $row['Magicpin Amount']  = $res->magicpin_price;
                    $row['Magicpin AOV']  = $magicpin_AOV;
                    $row['Magicpin Repeat custom']  = 0;
                    $row['Magicpin Cancelled qty']  = $res->magicpin_cancelled_orders;
                    $row['Magicpin Cancelled amt']  = $res->magicpin_cancelled_amt;

                    $row['Nobrokerhood Order Qty']    = $res->nobrokerhood_orders;
                    $row['Nobrokerhood Amount']  = $res->nobrokerhood_price;
                    $row['Nobrokerhood AOV']  = $nobrokerhood_AOV;
                    $row['Nobrokerhood Repeat custom']  = 0;
                    $row['Nobrokerhood Cancelled qty']  = $res->nobrokerhood_cancelled_orders;
                    $row['Nobrokerhood Cancelled amt']  = $res->nobrokerhood_cancelled_amt;

                    fputcsv($file, array($row['Order date'], $row['Location'], $row['Phonepe Order Qty'], $row['Phonepe Amount'] , $row['Phonepe AOV'] , $row['Phonepe Repeat custom'] , $row['Phonepe Cancelled qty'] , $row['Phonepe Cancelled amt'] , $row['Paytm Order Qty'], $row['Paytm Amount'] , $row['Paytm AOV'] , $row['Paytm Repeat custom'] , $row['Paytm Cancelled qty'] , $row['Paytm Cancelled amt'] , $row['Magicpin Order Qty'], $row['Magicpin Amount'] , $row['Magicpin AOV'] , $row['Magicpin Repeat custom'] , $row['Magicpin Cancelled qty'] , $row['Magicpin Cancelled amt'] , $row['Nobrokerhood Order Qty'], $row['Nobrokerhood Amount'] , $row['Nobrokerhood AOV'] , $row['Nobrokerhood Repeat custom'] , $row['Nobrokerhood Cancelled qty'] , $row['Nobrokerhood Cancelled amt']   ));
                    // 
                    $i++;
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
    }
    public function resetFilters(Request $request)
    {
        if ($request->has('clear')) 
        {
            return redirect()->route('orders?page=1');
        }
    }
	
	public function SBDMISOverview(Request $request){

        $start_date = date('Y-m-d',strtotime("last Monday"));
        $end_date = date('Y-m-d', strtotime($start_date . ' + 6 days'));

        
         $result=DB::select("SELECT     
                DATE(CASE 
                 WHEN SUBSTR(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), -1)='D' 
                 THEN DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'D', '') DAY) 
                 ELSE DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'H', '') HOUR)  END) AS delivery_dt,
                std_code, 
                SUM(IF(bap_id like '%shopping-network.phonepe.com%', 1, 0)) AS phonepe_order_qty,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%', total_price, 0)) AS phonepe_tprice,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Delivered', 1, 0)) AS phonepe_order_delivered,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='DISPATCHED', 1, 0)) AS phonepe_order_outfordelivery,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Cancelled', 1, 0)) AS phonepe_cancelled_orders,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Shipped & Returned', 1, 0)) AS phonepe_shipped_returned,
                SUM(IF(bap_id like '%ondc.paytm.com%', 1, 0)) AS paytm_order_qty,
                SUM(IF(bap_id like '%ondc.paytm.com%', total_price, 0)) AS paytm_tprice,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Delivered', 1, 0)) AS paytm_order_delivered,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='DISPATCHED', 1, 0)) AS paytm_order_outfordelivery,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Cancelled', 1, 0)) AS paytm_cancelled_orders,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Shipped & Returned', 1, 0)) AS paytm_shipped_returned,
                SUM(IF(bap_id like '%webapi.magicpin.in%', 1, 0)) AS magicpin_order_qty,
                SUM(IF(bap_id like '%webapi.magicpin.in%', total_price, 0)) AS magicpin_tprice,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Delivered', 1, 0)) AS magicpin_order_delivered,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='DISPATCHED', 1, 0)) AS magicpin_order_outfordelivery,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Cancelled', 1, 0)) AS magicpin_cancelled_orders,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Shipped & Returned', 1, 0)) AS magicpin_shipped_returned,
                SUM(IF(bap_id like '%nobrokerhood%', 1, 0)) AS nobrokerhood_order_qty,
                SUM(IF(bap_id like '%nobrokerhood%', total_price, 0)) AS nobrokerhood_tprice,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Delivered', 1, 0)) AS nobrokerhood_order_delivered,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='DISPATCHED', 1, 0)) AS nobrokerhood_order_outfordelivery,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Cancelled', 1, 0)) AS nobrokerhood_cancelled_orders,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Shipped & Returned', 1, 0)) AS nobrokerhood_shipped_returned
                from orders_data WHERE ((IF(SUBSTR(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), -1)='D', DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'D', '') DAY), DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'D', '') HOUR))) BETWEEN '$start_date' and '$end_date') GROUP BY delivery_dt, std_code");
        
             

        
            
        return view('SBDmisoverview',compact('result'));
    }

    public function getSbdData(Request $request){
        $sbd_from=$request->input('sbd_from');
        $sbd_to=$request->input('sbd_to');
		$sbd_to = date('Y-m-d', strtotime($sbd_to. ' + 1 days'));

        $result=DB::select("SELECT     
                DATE(CASE 
                 WHEN SUBSTR(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), -1)='D' 
                 THEN DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'D', '') DAY) 
                 ELSE DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'H', '') HOUR)  END) AS delivery_dt,
                std_code, 
                SUM(IF(bap_id like '%shopping-network.phonepe.com%', 1, 0)) AS phonepe_order_qty,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%', total_price, 0)) AS phonepe_tprice,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Delivered', 1, 0)) AS phonepe_order_delivered,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='DISPATCHED', 1, 0)) AS phonepe_order_outfordelivery,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Cancelled', 1, 0)) AS phonepe_cancelled_orders,
                SUM(IF(bap_id like '%shopping-network.phonepe.com%' AND order_status='Shipped & Returned', 1, 0)) AS phonepe_shipped_returned,
                SUM(IF(bap_id like '%ondc.paytm.com%', 1, 0)) AS paytm_order_qty,
                SUM(IF(bap_id like '%ondc.paytm.com%', total_price, 0)) AS paytm_tprice,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Delivered', 1, 0)) AS paytm_order_delivered,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='DISPATCHED', 1, 0)) AS paytm_order_outfordelivery,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Cancelled', 1, 0)) AS paytm_cancelled_orders,
                SUM(IF(bap_id like '%ondc.paytm.com%' AND order_status='Shipped & Returned', 1, 0)) AS paytm_shipped_returned,
                SUM(IF(bap_id like '%webapi.magicpin.in%', 1, 0)) AS magicpin_order_qty,
                SUM(IF(bap_id like '%webapi.magicpin.in%', total_price, 0)) AS magicpin_tprice,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Delivered', 1, 0)) AS magicpin_order_delivered,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='DISPATCHED', 1, 0)) AS magicpin_order_outfordelivery,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Cancelled', 1, 0)) AS magicpin_cancelled_orders,
                SUM(IF(bap_id like '%webapi.magicpin.in%' AND order_status='Shipped & Returned', 1, 0)) AS magicpin_shipped_returned,
                SUM(IF(bap_id like '%nobrokerhood%', 1, 0)) AS nobrokerhood_order_qty,
                SUM(IF(bap_id like '%nobrokerhood%', total_price, 0)) AS nobrokerhood_tprice,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Delivered', 1, 0)) AS nobrokerhood_order_delivered,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='DISPATCHED', 1, 0)) AS nobrokerhood_order_outfordelivery,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Cancelled', 1, 0)) AS nobrokerhood_cancelled_orders,
                SUM(IF(bap_id like '%nobrokerhood%' AND order_status='Shipped & Returned', 1, 0)) AS nobrokerhood_shipped_returned
                from orders_data WHERE ((IF(SUBSTR(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), -1)='D', DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'D', '') DAY), DATE_ADD(datetime, INTERVAL REPLACE(REPLACE(REPLACE(delivery_tat, 'PT', ''), 'P', ''), 'D', '') HOUR))) BETWEEN '$sbd_from' and '$sbd_to') GROUP BY delivery_dt, std_code");

            // print_r($result);

        return json_encode($result);
    }
}
