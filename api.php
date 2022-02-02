<?php

require_once('settings.php');

$BASE_URL = 'http://' . $SEPIDAR_ADDRESS . ':' . $SEPIDAR_PORT .
            '/api/v1';

$REQUEST_HEADERS = array(
    'Authorization' => 'Basic ' . base64_encode($SEPIDAR_USERNAME . ':' . $SEPIDAR_PASSWORD)
);


function get_url($method_name) {
    global $BASE_URL;
    return $BASE_URL . '/' . $method_name;
}

function send_invoice($data){
	global $REQUEST_HEADERS;
    $url = get_url('RegisterInvoice');
	$ivoice_id = $data['number'];
	$date = $data['date'];
	$product_id = $data['product_id'];
	$fee = $data['fee'];
	$quantity = $['quantity'];
    $body = [
    {
        "sourceid": 0,
        "number": $invoice_id,
        "date": $date,
        "customercode": "20001",
        "saletypenumber": 2,
        "itemcode": $product_id,
        "quantity": $quantity,
        "fee": $fee,
        "discount": 0,
        "addition": 0,
        "currencyRate": 1,
        "stockCode": 101
    }
	]
	$args = array(
        'headers' => $REQUEST_HEADERS,
		'body' => $body,
        'timeout' => 20,
		'method' => 'POST',
    );

    $req = wp_remote_post($url, $args);
    if (is_wp_error($req)) {
        error_log('Failed to send invoice');
        error_log(print_r($req->errors, true));
        return array();
    }

    $body = wp_remote_retrieve_body($req);
	return $body['message'];
}

function send_exit($invoice_id){
	global $REQUEST_HEADERS;
    $url = get_url('RegisterInventorydelivery');
	$body = array(
			"invoicenumber" : $invoice_id,
			"saletypenumner" : 2
			)
	$args = array(
        'headers' => $REQUEST_HEADERSi,
		'body' => $body,
        'method' => 'POST',
		'timeout' => 20,
    );
    $req = wp_remote_post($url, $args);
    if (is_wp_error($req)) {
        error_log('Failed to send exit');
        error_log(print_r($req->errors, true));
        return array();
    }

    $body = wp_remote_retrieve_body($req);
	return $body['message'];
}
