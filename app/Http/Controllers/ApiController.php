<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Orders;
use Carbon\Carbon;
use DB;

class APIController extends Controller
{
    public function datareport() {
		
		$end = date('Y-m-d');
		$start = date('Y-m-d', strtotime('-1 months', strtotime($end)));
		//$start = '2023-10-22';
		
		$orders = DB::table('orders_data')
		->select('orders_data.id as id', 'order_details.order_no as order_no', 'orders_data.transaction_id as transaction_id', 'orders_data.bap_id as bap_id', 'order_details.sku_name as sku_name', 'order_details.sku_code as sku_code', 'orders_data.shipping_city as shipping_city', 'orders_data.total_price as total_price', 'orders_data.payment_status as payment_status', 'orders_data.payment_mode as payment_mode', 'orders_data.billing_name as billing_name', 'orders_data.order_status as orders_status', 'orders_data.buyer_finder_fee as buyer_finder_fee', 'orders_data.buyer_app_finder_fee_type as buyer_finder_fee_type', 'orders_data.withholding_amount as withholding_amount', 'orders_data.settlement_window as settlement_window', 'orders_data.payment_transaction_id as payment_transaction_id', 'orders_data.updated_datetime as updated_datetime', 'orders_data.datetime as datetime', 'orders_data.lm_delivery_date as lm_delivery_date', 'orders_data.shipped_date as shipped_date', 'orders_data.cancelled_date as cancelled_date', 'orders_data.cancelled_by as cancelled_by', 'orders_data.cancelled_reason as cancelled_reason', 'orders_data.cancellation_remark as cancellation_remark', 'orders_data.shipping_postal_code as shipping_postal_code', 'orders_data.warehouse_pincode as warehouse_pincode', 'orders_data.shipping_charges as shipping_charges', 'orders_data.b_phone as b_phone')
		->join('order_details', 'order_details.order_no', '=', 'orders_data.order_no')
		->whereDate('orders_data.datetime', '>=', $start)
		->whereDate('orders_data.datetime', '<=', $end)
		->orderBy('orders_data.datetime', 'DESC')
		->get();

		$i = 0;
		$processedData = [];

		foreach ($orders as $order) {
			$i++;

			$delivery_date = $order->lm_delivery_date ? date("d-m-Y H:i:s", strtotime($order->lm_delivery_date)) : "";
			$shipped_date = $order->shipped_date ? date("d-m-Y H:i:s", strtotime($order->shipped_date)) : "";
			$cancelled_date = $order->cancelled_date ? date("d-m-Y H:i:s", strtotime('+5 hour +30 minutes', strtotime($order->cancelled_date))) : "";

			$order_status = $order->orders_status;
			if ($order_status === null) {
				$order_status = "";
			} else {
				if (!in_array(strtolower($order_status), ['delivered', 'created', 'accepted', 'shipped & returned', 'cancelled'], true)) {
					$order_status = "In-Progress";
				} elseif (in_array(strtolower($order_status), ['delivered', 'created', 'accepted', 'shipped & returned'], true)) {
					$order_status = "Completed";
				} elseif (strtolower($order_status) === 'cancelled') {
					$order_status = "Cancelled";
				}
			}

			$cancelled_reason = "";
			switch ($order->cancelled_reason) {
				case "001":
					$cancelled_reason = "Price of one or more items have changed due to which the buyer was asked to make an additional payment";
					break;
				case "002":
					$cancelled_reason = "One or more items in the order not available";
					break;
				case "003":
					$cancelled_reason = "Product available at lower than the order price";
					break;
				case "004":
					$cancelled_reason = "Order in pending shipment / delivery state for too long";
					break;
				case "005":
					$cancelled_reason = "Merchant rejected the order";
					break;
				case "006":
					$cancelled_reason = "Order not shipped as per buyer app SLA";
					break;
				case "010":
					$cancelled_reason = "Buyer wants to modify details";
					break;
				case "011":
					$cancelled_reason = "Buyer not found or cannot be contacted";
					break;
				case "012":
					$cancelled_reason = "Buyer does not want the product anymore";
					break;
				case "013":
					$cancelled_reason = "Buyer refused to accept delivery";
					break;
				case "014":
					$cancelled_reason = "Address not found";
					break;
				case "015":
					$cancelled_reason = "Buyer not available at the location";
					break;
				case "016":
					$cancelled_reason = "Accident / rain / strike / vehicle issues";
					break;
				case "017":
					$cancelled_reason = "Order delivery delayed or not possible";
					break;
				case "018":
					$cancelled_reason = "Delivery pin code not serviceable";
					break;
			}

			$catQuery = DB::table('itc_product_master_v2')->where('sku_code', $order->sku_code)->first();
			$catType = $catQuery ? $catQuery->product_type : '';

			$custPhone = $order->b_phone;
			$custId = '';

			switch ($order->bap_id) {
				case 'prd.mystore.in':
					$custId = "MYST" . substr($custPhone, 8);
					break;
				case 'www.firstforwardondc.com':
					$custId = "IDFC" . substr($custPhone, 8);
					break;
				case 'www.spicesmartshop.com':
					$custId = "SPIC" . substr($custPhone, 8);
					break;
				case 'ondc.meesho.org':
					$custId = "MEES" . substr($custPhone, 8);
					break;
				case 'www.craftsvilla.com':
					$custId = "CRAF" . substr($custPhone, 8);
					break;
				case 'ondc.paytm.com':
					$custId = "PAYT" . substr($custPhone, 8);
					break;
				case 'shopping-network.phonepe.com':
					$custId = "PHON" . substr($custPhone, 8);
					break;
			}

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
				"Order Status" => $order_status,
				"Name of seller" => "ITCStore",
				"Seller Pincode" => $order->warehouse_pincode,
				"SKU Name" => $order->sku_name,
				"SKU Code" => $order->sku_code,
				"Order category" => $catType,
				"Ready To Ship At Date & Time" => $shipped_date,
				"Shipped At Date & Time" => $shipped_date,
				"Delivered At Date & Time" => $delivery_date,
				"Delivery Type" => "Off Network",
				"Logistics Network Order Id (For on-network delivery)" => "",
				"Logistics Network Transaction Id (For on-network delivery)" => "",
				"Delivery city" => $order->shipping_city,
				"Delivery Pincode" => $order->shipping_postal_code,
				"Cancelled Date & Time" => $cancelled_date,
				"Cancelled By" => $order->cancelled_by,
				"Cancellation Reason" => $cancelled_reason,
				"Cancellation Remark" => $order->cancellation_remark,
				"Shipping Charges" => $order->shipping_charges,
				"Total Order Value (Inc Shipping Charges)" => $order->total_price,
			];

			$processedData[] = $response;
		}

		echo json_encode($processedData);
	}
}