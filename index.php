<?php

/* gets the data from a URL */
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function login() {

	$url = @"http://www.eshop-rychlo.sk/admin/pruvodce.php";
	$fields = array(
					'name_login' => urlencode("lubosjurik@gmail.com"),
					'name_passw' => urlencode("petersrnka"),
				);
				
	//url-ify the data for the POST
	$fields_string = ""; 
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	//open connection
	$ch = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	//execute post
	$result = curl_exec($ch);
	
	//close connection
	curl_close($ch);
	
	return $result;
}

login();

$admin_login_page = get_data(@"http://www.eshop-rychlo.sk/admin/script.php?vol=eshop4&svol=2");

echo $admin_login_page;

