<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

class ProductController extends Controller
{
    public function index(Request $request,$id)
    {
        $data = array();
        if(isset($id)) {
            $data['products'] = Products::where("order_no",$id)->get();
        }
        return view('orderinfo',$data);
    }
}
