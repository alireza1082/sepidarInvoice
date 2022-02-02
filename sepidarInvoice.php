<?php
/**
* Plugin Name: Sepidar Invoice
* Plugin URI: https://www.kashanehmode.ir/
* Description: This plugin use for register Invoices
* Version: 1.0
* Author: Alireza Rahmani
* Author URI: http://yourwebsiteurl.com/
**/

require_once('settings.php');
require_once('api.php');

function order_processing($order_id) {
	error_log("$order_id set to process");
	$body = array();
	$order = wc_get_order($order_id);
	$date_modified = $order->get_date_modified()
	$date = $date_modified->format('Y-m-d');
	foreach ($order->get_items() as $item_key => $item ){
		$itemcode = $item->get_product_id();
		$quantity = $item->get_quantity();
		$product = $item->get_product();
		$price = $product->get_price();
		$fee = $price * 10000;
		$data = array(
				"sourceid"=> 0,
				"customercode"=> "20001",
				"saletypenumber"=> 2,
				"discount"=> 0,
				"addition"=> 0,
				"currencyRate"=> 1,
				"stockCode"=> 101
				"number" => $oreder_id - 8000,
				"date" => $date,
				"itemcode" => $itemcode,
				"quantity" => $quantity,
				"fee" => $fee
				)
		array_push($body, $data);
	}
	send_invoice($body);
}

add_action( 'woocommerce_order_status_processing', 'order_processing', 10, 1);

