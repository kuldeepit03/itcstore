<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
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
	
	public function sendOrderDataZypp()
    {
		$apiConfig = Config::get('api');
	
        date_default_timezone_set("Asia/Kolkata");
        //$order_id = request()->input("order_id");
		$order_id = 'OD2310250816499055197412';
        $items = [];
        $ordersData = DB::table('orders_data')->where('order_no', $order_id)->get();

        foreach ($ordersData as $fetchData) {
            $order_date = $fetchData->datetime;
            $final_amount = $fetchData->total_price;
            $slotStart = $fetchData->datetime;
            $time = strtotime($fetchData->end_timestamp);
            $slotEnd = date("Y-m-d H:i:s", $time);
            $pickup_start_timestamp = strtotime($fetchData->picked_datetime);
            $orderPickupTime = date("Y-m-d H:i:s", $pickup_start_timestamp);
            $idx = strpos($fetchData->s_latlog, ",");
            $cust_latitude = substr($fetchData->s_latlog, 0, $idx);
            $cust_longitude = substr($fetchData->s_latlog, $idx + 1);
            $cust_name = $fetchData->shipping_name;
            $cust_phoneNumber = $fetchData->s_phone;
            $cust_streetNumber = $fetchData->s_door;
            $cust_streetName = $fetchData->s_door;
            $cust_addressLine2 = $fetchData->s_locality;
            $cust_cityName = $fetchData->shipping_city;
            $cust_postalCode = $fetchData->shipping_postal_code;
            $shipping_add = $fetchData->shipping_address;

            $fetchLineItems = DB::table('order_details')->where('order_no', $order_id)->get();
            foreach ($fetchLineItems as $fetchItemDetails) {
                $sku_code = $fetchItemDetails->sku_code;
                $sku_name = $fetchItemDetails->sku_name;
                $quantity = $fetchItemDetails->qty;
                $price = $fetchItemDetails->price;
                $weightQuery = DB::table('itc_product_master_v2')->where('sku_code', $sku_code)->first();
                $prod_weight = $weightQuery->variant_gram;
                $item_data = [
                    'menuCode' => $sku_code,
                    'menuDescription' => $sku_name,
                    'quantity' => (int)$quantity,
                    'size' => $prod_weight,
                    'unitPrice' => (int)$price,
                ];
                $items[] = $item_data;
            }
        }

        $data = [
            'order' => [
                'orderNumber' => $order_id,
                'orderDate' => $order_date,
                'finalAmount' => (float)$final_amount,
                'slotStart' => $slotStart,
                'slotEnd' => $slotEnd,
                'orderPickupTime' => $orderPickupTime,
                'instruction' => 'NA',
                'piecesDetails' => $items,
            ],
            'customer' => [
                'latitude' => (float)$cust_latitude,
                'longitude' => (float)$cust_longitude,
                'name' => 'ITC Store',
                'phoneNumber' => $cust_phoneNumber,
                'streetNumber' => $cust_streetNumber,
                'streetName' => $cust_streetName,
                'cityName' => $cust_cityName,
                'addressLine2' => 'cust addressLine2',
                'addressLine3' => '',
                'addressLine4' => '',
                'postalCode' => $cust_postalCode,
            ],
            'originDetails' => [
                'latitude' => '28.4190306',
                'longitude' => '77.037344',
                'name' => 'Gurgaon Store',
                'phoneNumber' => '',
                'streetNumber' => 'H no 242 ',
                'streetName' => 'Q1 Block',
                'cityName' => 'Gurgaon',
                'addressLine2' => 'H no 242 basement',
                'addressLine3' => 'Q1 Block, Pocket H, Nirvana Country, Sector 49',
                'addressLine4' => 'Nirvana Country, Sector 49 - South city 2 Gurugram, Haryana',
                'postalCode' => '122018',
            ],
            'payment' => [
                [
                    'paid' => true,
                    'platform' => 'PrePaid',
                    'collectableAmount' => (int)$final_amount,
                ],
            ],
        ];

        $postdata = json_encode($data);
        $response = Http::withHeaders([
            'Content-Type' 		=> 'application/json',
        ])->withBasicAuth($apiConfig['username_zypp_test'], $apiConfig['password_zypp_test'])
		->post($apiConfig['base_url_zypp_test']. '/api/secure/v1/merchant/add/order', json_decode($postdata, true));
        return $response;
    }

	

	public function updateStatusZypp (Request $request)
    {
        $headers = $request->header('key');
        if ($headers != "hH&^%FDtrwrew$$^^*^PBCFAFA") {
            return response()->json(['responseCode' => 401, 'responseMessage' => 'Unauthorized'], 401);
        }

		date_default_timezone_set('Asia/Calcutta');
		$datetime = date("Y-m-d H:i:s");
		date_default_timezone_set("UTC");
		$date = date("Y-m-d H:i:s");
		$timestamp1 = microtime(true); 

		$timestamp = date('Y-m-d\TH:i:s.').((int)(($timestamp1 - (int)$timestamp1) * 1000)).'Z';
        $requestData = $request->json()->all();
        $orderNumber = $requestData['orderNumber'];
        $status = $requestData['status'];
		$rider_name = $requestData['worker']['name'];
		$rider_contact = $requestData['worker']['contact'];
		$rider_lat = $requestData['worker']['lat'];
		$rider_lng = $requestData['worker']['lng'];
		$eta = $requestData['eta'];
        $order = Orders::where('order_no', $orderNumber)->first();
		$order_id =  $order->id;
		$client_order_id = 'ONDC000'.$order_id;
        if (!$order) {
            return response()->json(['responseCode' => 0, 'responseMessage' => 'Error! Invalid orderNumber.'], 400);
        }


        if ($status == "Picked" || $status == "order_picked_up") {
			$order->where('id', $order_id)->update([
				'order_status' => "Picked",
				'picked_datetime' => $timestamp,
				'updated_datetime' => $timestamp,
				'int_updated_datetime' => $datetime,
			]);
		} elseif ($status == "Packed" || $status == "pickup_started" || $status == "pickup_hub_reached") {
			$order->where('id', $order_id)->update([
				'order_status' => "Packed",
				'updated_datetime' => $timestamp,
				'int_updated_datetime' => $datetime,
			]);
		} elseif ($status === "DISPATCHED") {
			$order->where('id', $order_id)->update([
				'order_status' => "DISPATCHED",
				'out_for_delivery_datetime' => $timestamp,
				'updated_datetime' => $timestamp,
				'int_updated_datetime' => $datetime,
			]);
		} elseif ($status === "Delivered" || $status === "delivered" || $status === "order_delivered") {
			$order->where('id', $order_id)->update([
				'order_status' => "Delivered",
				'delivery_date' => $timestamp,
				'updated_datetime' => $timestamp,
				'int_updated_datetime' => $datetime,
			]);
		} elseif ($status === "order_cancelled") {
			$order->where('id', $order_id)->update([
				'order_status' => "Cancelled",
				'cancelled_date' => $timestamp,
				'cancelled_by' => 'Buyer',
				'cancelled_reason' => '012',
				'updated_datetime' => $timestamp,
				'int_updated_datetime' => $datetime,
			]);
		} else {
			$order->where('id', $order_id)->update([
				'order_status' => $status,
				'updated_datetime' => $timestamp,
				'int_updated_datetime' => $datetime,
			]);
		}
		DB::table('lm_data')->insert([
			'time' 				=> $datetime,
			'query_time' 		=> $datetime,
			'rider_name' 		=> $rider_name,
			'sfx_order_id' 		=> $orderNumber,
			'order_id' 			=> $client_order_id ,
			'client_order_id' 	=> $client_order_id ,
			'order_status' 		=> $status,
			'rider_contact' 	=> $rider_contact,
			'rider_latitude' 	=> $rider_lat,
			'rider_longitude' 	=> $rider_lng,
			'drop_eta' 			=> $eta,
		]);
		return response()->json(['responseCode' => 200, 'responseMessage' => 'Data saved & Status updated successfully'], 200);
    }



	public function createOrderBorzo()
    {
		$bzr_conf = Config::get('api');
		date_default_timezone_set("Asia/Kolkata");
        //$order_id = request()->input("order_id");
		$order_id = 'F3406DFA6FF6D943F21E4EDDD18409C9';
		//$order_id = 'F3406DFA6FF6D943F21E4EDDD18409C9';
        $ordersData = DB::table('orders_data')->where('order_no', $order_id)->get();

        foreach ($ordersData as $fetchData) {
            $order_date = $fetchData->datetime;
            $final_amount = $fetchData->total_price;			
            $idx = strpos($fetchData->s_latlog, ",");
            $cust_latitude = substr($fetchData->s_latlog, 0, $idx);
            $cust_longitude = substr($fetchData->s_latlog, $idx + 1);
            $cust_name = $fetchData->shipping_name;
            $cust_phoneNumber = $fetchData->s_phone;
            $cust_streetNumber = $fetchData->s_door;
            $cust_streetName = $fetchData->s_door;
            $cust_addressLine2 = $fetchData->s_locality;
            $cust_cityName = $fetchData->shipping_city;
			$cust_state = $fetchData->shipping_state;
            $cust_postalCode = $fetchData->shipping_postal_code;
            $shipping_add = $fetchData->shipping_address;

            $fetchLineItems = DB::table('order_details')->where('order_no', $order_id)->get();
			$prod_weight = 0;
            foreach ($fetchLineItems as $fetchItemDetails) {
                $sku_code = $fetchItemDetails->sku_code;
                $sku_name = $fetchItemDetails->sku_name;
                $quantity = $fetchItemDetails->qty;
                $price = $fetchItemDetails->price;

                $weightQuery = DB::table('itc_product_master_v2')->where('sku_code', $sku_code)->first();
                $prod_weight = $weightQuery->variant_gram + $prod_weight;
				$prod_weight_kg =  $prod_weight/1000;
            }
        }
		$address = $shipping_add.','.$cust_cityName.','.$cust_state.','.$cust_postalCode;
		//$address = $cust_addressLine2.','.$cust_cityName.','.$cust_state;
		$data = [ 
			'matter' => 'Documents', 
			'total_weight_kg'=> $prod_weight_kg,
			'points' => [ 
				[ 
					'address' => 'H no 242 basement, Q1 Block, Pocket H, Nirvana Country, Sector 49 - South city 2 Gurugram, Haryana', 
					'contact_person' => [ 
						'phone' => '918880000001', 
					], 
					'client_order_id' => $order_id,
					'note' => $address,
					'taking_amount' => (float)$final_amount,
				], 
				
				[ 
					//'address' =>  $address,
					'address' => 'unit no 310 311 good earth city center sector 50 gurgaon',
					'contact_person' => [ 
						'phone' => $cust_phoneNumber, 
					], 
				], 
			], 
		];  
        $postdata = json_encode($data);
        $response = Http::withHeaders([
            'Content-Type' 		=> 'application/json',
            'X-DV-Auth-Token' 	=> $bzr_conf['bzr_token_test'],
        ])->post($bzr_conf['base_url_bzr_test']. '/api/business/1.4/create-order', json_decode($postdata, true));

        return $response;
    }

}