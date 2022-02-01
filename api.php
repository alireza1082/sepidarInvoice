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

function send_invoice(){
	global $REQUEST_HEADERS;
    $url = get_url('PriceNoteList');
	$ivoice_id = 220;
	$date = "2022-01-29";
	$product_id = "90000065";
	$fee = 1000000;
	$quantity = 1;
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
    );

    $req = wp_remote_get($url, $args);
    if (is_wp_error($req)) {
        error_log('Failed to send invoice');
        error_log(print_r($req->errors, true));
        return array();
    }

    $body = wp_remote_retrieve_body($req);
}

function send_exit(){
	global $REQUEST_HEADERS;
    $url = get_url('RegisterInventorydelivery');
    $invoice_id = 220;
	$body = array(
			"invoicenumber" : $invoice_id,
			"saletypenumner" : 2
			)
	$args = array(
        'headers' => $REQUEST_HEADERSi,
		'body' => $body,
        'timeout' => 20,
    );
    $req = wp_remote_get($url, $args);
    if (is_wp_error($req)) {
        error_log('Failed to send exit');
        error_log(print_r($req->errors, true));
        return array();
    }

    $body = wp_remote_retrieve_body($req);
}
