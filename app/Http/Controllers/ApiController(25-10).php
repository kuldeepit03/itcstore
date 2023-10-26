<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Orders;
use Carbon\Carbon;
use DB;

class ApiController extends Controller
{
    public function datareport()
    {
        $end = now();
        $start = now()->subMonths(3);

        $orders = DB::table('orders_data')
            ->select('orders_data.id as id', 'order_details.order_no as order_no', 'orders_data.transaction_id as transaction_id', 'orders_data.bap_id as bap_id', 'order_details.sku_name as sku_name', 'order_details.sku_code as sku_code', 'orders_data.shipping_city as shipping_city', 'orders_data.total_price as total_price', 'orders_data.payment_status as payment_status', 'orders_data.payment_mode as payment_mode', 'orders_data.billing_name as billing_name', 'orders_data.order_status as orders_status', 'orders_data.buyer_finder_fee as buyer_finder_fee', 'orders_data.buyer_app_finder_fee_type as buyer_finder_fee_type', 'orders_data.withholding_amount as withholding_amount', 'orders_data.settlement_window as settlement_window', 'orders_data.payment_transaction_id as payment_transaction_id', 'orders_data.updated_datetime as updated_datetime', 'orders_data.datetime as datetime', 'orders_data.lm_delivery_date as lm_delivery_date', 'orders_data.shipped_date as shipped_date', 'orders_data.cancelled_date as cancelled_date', 'orders_data.cancelled_by as cancelled_by', 'orders_data.cancelled_reason as cancelled_reason', 'orders_data.cancellation_remark as cancellation_remark', 'orders_data.shipping_postal_code as shipping_postal_code', 'orders_data.warehouse_pincode as warehouse_pincode', 'orders_data.shipping_charges as shipping_charges', 'orders_data.b_phone as b_phone')
            ->join('order_details', 'order_details.order_no', '=', 'orders_data.order_no')
            ->where('orders_data.datetime', '>=', $start)
            ->where('orders_data.datetime', '<=', $end)
            ->orderBy('orders_data.datetime', 'DESC')
            ->get();

        $processedData = [];
        $i = 0;

        foreach ($orders as $order) {
            $i++;

            $lmDeliveryDate = $order->lm_delivery_date ? date("d-m-Y H:i:s", strtotime($order->lm_delivery_date)) : "";
            $shippedDate = $order->shipped_date ? date("d-m-Y H:i:s", strtotime($order->shipped_date)) : "";
            $cancelledDate = $order->cancelled_date ? date("d-m-Y H:i:s", strtotime('+5 hour +30 minutes', strtotime($order->cancelled_date))) : "";

            $orderStatus = $order->orders_status;
            if ($orderStatus === null) {
                $orderStatus = "";
            } else {
                $orderStatus = $this->processOrderStatus($orderStatus);
            }

            $cancelledReason = $this->getCancelledReason($order->cancelled_reason);

            $catQuery = DB::table('itc_product_master_v2')->where('sku_code', $order->sku_code)->first();
            $catType = $catQuery ? $catQuery->product_type : '';

            $custPhone = $order->b_phone;
            $custId = $this->getCustomerIdentifier($order->bap_id, $custPhone);

            $response = [
                "S.No." => $i,
                "Buyer NP Name" => $order->bap_id,
                "Seller NP Name" => "retailconnect.co.in",
                "Order Created Date & Time" => date("d-m-Y H:i:s", strtotime($order->datetime)),
                "Customer Unique Identifier" => $custId,
                "Network Order Id" => $order->order_no,
                "Network Transaction Id" => $order->transaction_id,
                "Seller NP Order Id" => $order->id,
                "Seller NP Type" => "Inventory seller node",
                "Order Status" => $orderStatus,
                "Name of seller" => "ITCStore",
                "Seller Pincode" => $order->warehouse_pincode,
                "SKU Name" => $order->sku_name,
                "SKU Code" => $order->sku_code,
                "Order category" => $catType,
                "Ready To Ship At Date & Time" => $shippedDate,
                "Shipped At Date & Time" => $shippedDate,
                "Delivered At Date & Time" => $lmDeliveryDate,
                "Delivery Type" => "Off Network",
                "Logistics Network Order Id(For on-network delivery)" => "",
                "Logistics Network Transaction Id(For on-network delivery)" => "",
                "Delivery city" => $order->shipping_city,
                "Delivery Pincode" => $order->shipping_postal_code,
                "Cancelled Date & Time" => $cancelledDate,
                "Cancelled By" => $order->cancelled_by,
                "Cancellation Reason" => $cancelledReason,
                "Cancellation Remark" => $order->cancellation_remark,
                "Shipping Charges" => $order->shipping_charges,
                "Total Order Value(Inc Shipping Charges)" => $order->total_price,
            ];

            $processedData[] = $response;
        }

        return response()->json($processedData);
    }

    private function processOrderStatus($orderStatus)
    {
        $orderStatus = strtolower($orderStatus);

        if (!in_array($orderStatus, ['delivered', 'created', 'accepted', 'shipped & returned', 'cancelled'])) {
            return "In-Progress";
        } elseif (in_array($orderStatus, ['delivered', 'created', 'accepted', 'shipped & returned'])) {
            return "Completed";
        } elseif ($orderStatus === 'cancelled') {
            return "Cancelled";
        }

        return $orderStatus;
    }

    private function getCancelledReason($code)
    {
        $reasons = [
            "001" => "Price of one or more items have changed due to which the buyer was asked to make an additional payment",
            "002" => "One or more items in the order not available",
            "003" => "Product available at lower than the order price",
            "004" => "Order in pending shipment / delivery state for too long",
            "005" => "Merchant rejected the order",
            "006" => "Order not shipped as per buyer app SLA",
            "010" => "Buyer wants to modify details",
            "011" => "Buyer not found or cannot be contacted",
            "012" => "Buyer does not want the product anymore",
            "013" => "Buyer refused to accept delivery",
            "014" => "Address not found",
            "015" => "Buyer not available at the location",
            "016" => "Accident / rain / strike / vehicle issues",
            "017" => "Order delivery delayed or not possible",
            "018" => "Delivery pin code not serviceable",
        ];

        return $reasons[$code] ?? "";
    }

    private function getCustomerIdentifier($bapId, $phone)
    {
        switch ($bapId) {
            case 'prd.mystore.in':
                return "MYST" . substr($phone, 8);
            case 'www.firstforwardondc.com':
                return "IDFC" . substr($phone, 8);
            case 'www.spicesmartshop.com':
                return "SPIC" . substr($phone, 8);
            case 'ondc.meesho.org':
                return "MEES" . substr($phone, 8);
            case 'www.craftsvilla.com':
                return "CRAF" . substr($phone, 8);
            case 'ondc.paytm.com':
                return "PAYT" . substr($phone, 8);
            case 'shopping-network.phonepe.com':
                return "PHON" . substr($phone, 8);
            default:
                return "";
        }
    }
}

