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
		$orders = Orders::join('order_details', 'order_details.order_no', '=', 'orders_data.order_no')
			->whereDate('orders_data.datetime', '>=', $start)
			->whereDate('orders_data.datetime', '<=', $end)
			->orderBy('orders_data.datetime', 'DESC')
			->get();

		$processedData = [];
		$i=0;
		foreach ($orders as $order) {
			$i++;
			$lmDeliveryDate = $order->lm_delivery_date ? date("d-m-Y H:i:s", strtotime($order->lm_delivery_date)) : "";
			$shippedDate = $order->shipped_date ? date("d-m-Y H:i:s", strtotime($order->shipped_date)) : "";
			$cancelledDate = $order->cancelled_date ? date("d-m-Y H:i:s", strtotime('+5 hour +30 minutes', strtotime($order->cancelled_date))) : "";

			$orderStatus = $order->orders_status;
			if ($orderStatus === null) {
				$orderStatus = "";
			} else {
				if (!in_array(strtolower($orderStatus), ['delivered', 'created', 'accepted', 'shipped & returned', 'cancelled'], true)) {
					$orderStatus = "In-Progress";
				} elseif (in_array(strtolower($orderStatus), ['delivered', 'created', 'accepted', 'shipped & returned'], true)) {
					$orderStatus = "Completed";
				} elseif ($orderStatus === 'cancelled') {
					$orderStatus = "Cancelled";
				}
			}

			$cancelledReason = "";
			switch ($order->cancelled_reason) {
				case "001":
					$cancelledReason = "Price of one or more items have changed due to which the buyer was asked to make an additional payment";
					break;
				case "002":
					$cancelledReason = "One or more items in the order not available";
					break;
				case "003":
					$cancelledReason = "Product available at lower than the order price";
					break;
				case "004":
					$cancelledReason = "Order in pending shipment / delivery state for too long";
					break;
				case "005":
					$cancelledReason = "Merchant rejected the order";
					break;
				case "006":
					$cancelledReason = "Order not shipped as per buyer app SLA";
					break;
				case "010":
					$cancelledReason = "Buyer wants to modify details";
					break;
				case "011":
					$cancelledReason = "Buyer not found or cannot be contacted";
					break;
				case "012":
					$cancelledReason = "Buyer does not want the product anymore";
					break;
				case "013":
					$cancelledReason = "Buyer refused to accept delivery";
					break;
				case "014":
					$cancelledReason = "Address not found";
					break;
				case "015":
					$cancelledReason = "Buyer not available at the location";
					break;
				case "016":
					$cancelledReason = "Accident / rain / strike / vehicle issues";
					break;
				case "017":
					$cancelledReason = "Order delivery delayed or not possible";
					break;
				case "018":
					$cancelledReason = "Delivery pin code not serviceable";
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

		print_r(json_encode($processedData));
	}
}