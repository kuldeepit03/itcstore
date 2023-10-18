<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\Products;
class DashboardController extends Controller
{
    public function index()
    {

        $data['total_no'] = Orders::all()->count();

        $data['total_amt'] = Orders::select(DB::raw('SUM(total_price - shipping_charges) as total_sale'))->get() ;

        $data['delivered'] = Orders::whereIn('order_status', ['Delivered', 'delivered'])->count();

        $data['deliv_amt'] = Orders::select(DB::raw('SUM(total_price - shipping_charges) as deliv_sale'))
                                        ->whereIn('order_status', ['Delivered', 'delivered'])
                                        ->get();
        $data['cancelled'] = Orders::whereIn('order_status', ['Cancelled', 'cancelled'])->count();
                                                   
        $data['cancel_amt'] = Orders::select(DB::raw('SUM(total_price - shipping_charges) as cancel_sale'))
                                        ->whereIn('order_status', ['Cancelled', 'cancelled'])
                                        ->get();
        $data['pending'] = Orders::where(function ($query) {
                                        $query->whereNull('order_status')
                                        ->orWhereNotIn('order_status', ['Delivered', 'delivered', 'Cancelled', 'cancelled']);
                                        })->count();

        $data['pending_amt'] = Orders::select(DB::raw('SUM(total_price - shipping_charges) as pending_sale'))
                                        ->where(function ($query) {
                                        $query->whereNull('order_status')
                                        ->orWhereNotIn('order_status', ['Delivered', 'delivered', 'Cancelled', 'cancelled']);
                                        })
                                        ->get();

        $data['recent_orders'] = Orders::orderBy('id', 'desc')->take(15)->get();

        $data['total_sale'] = Products::select(DB::raw('SUM(qty) as total_sku_sale'))->get() ;

        $data['top_sku'] = Products::select(DB::raw('count(id) as total_sku, SUM(qty) as sku_sale, sku_name'))
                                        ->groupBy('sku_name')->orderBy('sku_sale', 'desc')->take(7)->get();

        return view('dashboard',$data);
    }
}
