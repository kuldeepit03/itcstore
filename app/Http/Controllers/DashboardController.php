<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\Products;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Orders::query();
        $query1 = Orders::query();
        $query2 = Orders::query();

        if ($request->filled('audit_from')) {
            $query->whereDate('datetime', '>=', Carbon::parse($request->audit_from)->format('Y-m-d'));
            $query1->whereDate('datetime', '>=', Carbon::parse($request->audit_from)->format('Y-m-d'));
            $query2->whereDate('datetime', '>=', Carbon::parse($request->audit_from)->format('Y-m-d'));
        }

        if ($request->filled('audit_to')) {
            $query->whereDate('datetime', '<=', Carbon::parse($request->audit_to)->format('Y-m-d'));
            $query1->whereDate('datetime', '<=', Carbon::parse($request->audit_to)->format('Y-m-d'));
            $query2->whereDate('datetime', '<=', Carbon::parse($request->audit_to)->format('Y-m-d'));
        }

        if ($request->filled('buyer')) {
            $query->where('bap_id', $request->input('buyer'));
        }

        $data = [
            'total_no' => $query->count(),
            //'total_amt' => $query->sum(DB::raw('total_price - shipping_charges')),
            'total_amt' => $query->sum(DB::raw('total_price')),
            'delivered' => $query->whereIn('order_status', ['Delivered', 'delivered'])->count(),
            //'deliv_amt' => $query->whereIn('order_status', ['Delivered', 'delivered'])->sum(DB::raw('total_price - shipping_charges')),
            'deliv_amt' => $query->whereIn('order_status', ['Delivered', 'delivered'])->sum(DB::raw('total_price')),
            'cancelled' => $query1->whereIn('order_status', ['Cancelled', 'cancelled'])->count(),
            //'cancel_amt' => $query1->whereIn('order_status', ['Cancelled', 'cancelled'])->sum(DB::raw('total_price - shipping_charges')),
            'cancel_amt' => $query1->whereIn('order_status', ['Cancelled', 'cancelled'])->sum(DB::raw('total_price')),
            'pending' => $query2->where(function ($query2) {
                         $query2->whereNull('order_status')
                                ->orWhereNotIn('order_status', ['Delivered', 'delivered', 'Cancelled', 'cancelled']);
                              })->count(),
            //'pending_amt' => $query2->whereNotIn('order_status', ['Delivered', 'delivered', 'Cancelled', 'cancelled'])
            //                        ->orWhereNull('order_status')
             //                       ->sum(DB::raw('total_price - shipping_charges')),
            'pending_amt' => $query2->whereNotIn('order_status', ['Delivered', 'delivered', 'Cancelled', 'cancelled'])
                                    ->orWhereNull('order_status')
                                    ->sum(DB::raw('total_price')),
        ];
        
        $data['recent_orders'] = Orders::orderBy('id', 'desc')->take(20)->get();

        $data['total_sale'] = Products::select(DB::raw('SUM(qty) as total_sku_sale'))->get() ;

        $data['top_sku'] = Products::select(DB::raw('count(id) as total_sku, SUM(qty) as sku_sale, sku_name'))
                                        ->groupBy('sku_name')->orderBy('sku_sale', 'desc')->take(7)->get();

        $data['buyer_app']= Orders::select('bap_id')->distinct()->get();


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
                $chart_data[]=['Month','PhonePay','PayTM','MagicPin','NoBrokerHood'];
                foreach($result_monthly as $key => $value)
                {
                    $chart_data[++$key] = [$value->month,(int)$value->phonepe_orders, (int)$value->paytm_orders, (int)$value->magicpin_orders, (int)$value->nobrokerhood_orders];
                }
            //return view('dashboard')->with('monthly',$chart_data);
            return view('dashboard',$data)->with('monthly',$chart_data);

        //return view('dashboard',$data);
    }
}
