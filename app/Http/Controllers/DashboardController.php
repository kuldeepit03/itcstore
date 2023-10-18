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

        if ($request->filled('audit_from')) {
            $query->whereDate('b_created_at', '>=', Carbon::parse($request->audit_from)->format('Y-m-d'));
        }

        if ($request->filled('audit_to')) {
            $query->whereDate('b_created_at', '<=', Carbon::parse($request->audit_to)->format('Y-m-d'));
        }

        if ($request->filled('audit_no')) {
            $query->where('order_no', $request->input('audit_no'));
        }

        $data = [
            'total_no' => $query->count(),
            'total_amt' => $query->sum(DB::raw('total_price - shipping_charges')),
            'delivered' => $query->whereIn('order_status', ['Delivered', 'delivered'])->count(),
            'deliv_amt' => $query->whereIn('order_status', ['Delivered', 'delivered'])->sum(DB::raw('total_price - shipping_charges')),
            'cancelled' => $query->whereIn('order_status', ['Cancelled', 'cancelled'])->count(),
            'cancel_amt' => $query->whereIn('order_status', ['Cancelled', 'cancelled'])->sum(DB::raw('total_price - shipping_charges')),
            'pending' => $query->where(function ($query) {
                $query->whereNull('order_status')
                    ->orWhereNotIn('order_status', ['Delivered', 'delivered', 'Cancelled', 'cancelled']);
            })->count(),
            'pending_amt' => $query->where(function ($query) {
                $query->whereNull('order_status')
                    ->orWhereNotIn('order_status', ['Delivered', 'delivered', 'Cancelled', 'cancelled']);
            })->sum(DB::raw('total_price - shipping_charges')),
        ];
        
        $data['recent_orders'] = Orders::orderBy('id', 'desc')->take(15)->get();

        $data['total_sale'] = Products::select(DB::raw('SUM(qty) as total_sku_sale'))->get() ;

        $data['top_sku'] = Products::select(DB::raw('count(id) as total_sku, SUM(qty) as sku_sale, sku_name'))
                                        ->groupBy('sku_name')->orderBy('sku_sale', 'desc')->take(7)->get();

        return view('dashboard',$data);
    }
}
