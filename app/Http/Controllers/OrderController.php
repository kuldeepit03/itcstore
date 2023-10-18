<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Carbon\Carbon;

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
        if ($request->filled('audit_from')) {
            $query->whereDate('b_created_at', '>=', Carbon::parse($request->audit_from)->format('Y-m-d'));
        }

        if ($request->filled('audit_to')) {
            $query->whereDate('b_created_at', '<=', Carbon::parse($request->audit_to)->format('Y-m-d'));
        }
        $data['ordersdata'] = $query->orderBy('id', 'desc')->paginate(20);

    
        $data['buyer_app']= Orders::select('bap_id')->distinct()->get();
       
         return view('orders',$data);
    }
    public function resetFilters(Request $request)
    {
        if ($request->has('clear')) 
        {
            return redirect()->route('orders?page=1');
        }
    }
}
