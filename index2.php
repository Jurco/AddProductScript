<?php
$url = "http://www.eshop-rychlo.sk/admin/pruvodce.php";
$indexPageURL = "http://www.eshop-rychlo.sk/admin/script.php?vol=eshop4&svol=2";
$addProductURL = "http://www.eshop-rychlo.sk/admin/script.php?vol=440&pages=0&akce=x&menu=&druh=&svol=2&slovo=&filtrsk=";
$scriptURL = "www.eshop-rychlo.sk/admin/script.php?function=theFormSubmitted";
$usn = "lubosjurik@gmail.com";
$pwd = "petersrnka";

// $sessionID = GetSessionID($url) . "<br><br>";
Login($url, $usn, $pwd);
download_page($addProductURL);
echo addProduct($scriptURL);


function download_page($url2){        
        $debug=fopen("KSL_debug2.txt","w"); // this will give you insight into what cURL is doing
        $cookies = 'KSL_cookiejar.txt';

        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url2);        
        curl_setopt($ch, CURLOPT_FAILONERROR,1);        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);    
        //curl_setopt($ch, CURLOPT_COOKIE,$sessionID);   
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);  
        curl_setopt($ch, CURLOPT_STDERR, $debug);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);

        $retValue = curl_exec($ch);                              
        curl_close($ch);        
        return $retValue;
}  

function addProduct($url) {
        $debug=fopen("KSL_debug3.txt","w"); // this will give you insight into what cURL is doing
        $cookies = 'KSL_cookiejar.txt';

        //set POST variables
        $post_data = array(
                'nazev' => 'AUTOMATICKE'
        );

        //url-ify the data for the POST
		$fields_string = "";
        foreach($post_data as $key=>$value) {
                $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string,'&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,count($post_data));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
       
        //remove below?
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        //curl_setopt($ch, CURLOPT_COOKIE,$sessionID);
        curl_setopt($ch, CURLOPT_STDERR, $debug);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
       
        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        return $result;
}

function Login($url, $email, $password){
        $debug=fopen("KSL_debug1.txt","w"); // this will give you insight into what cURL is doing
        $cookies = 'KSL_cookiejar.txt';

        //set POST variables
        $post_data = array(
                'login' => $email,
                'passw' => $password
        );

        //url-ify the data for the POST
		$fields_string = "";
        foreach($post_data as $key=>$value) {
                $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string,'&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,count($post_data));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
       
        //remove below?
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        //curl_setopt($ch, CURLOPT_COOKIE,$sessionID);
        curl_setopt($ch, CURLOPT_STDERR, $debug);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
       
        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        return $result;
}


function GetSessionID($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $buffer = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        curl_close($ch);
        $header_size = $curl_info[CURLINFO_HEADER_SIZE];
        $headers = substr($buffer, 0, $header_size);
        $startPos = strpos($headers, "PHPSESSID=") + 10;
        $endPos = strpos($headers, ";", $startPos);
        return substr($headers, $startPos, $endPos-$startPos);
}

function WriteFile($filename, $contents){
        $fh = fopen($filename, 'w') or die("can't open file");
        fwrite($fh, $contents);
        fclose($fh);
}

function GetRequestHeaders() {
        foreach($_SERVER as $h=>$v){
                if(ereg('HTTP_(.+)',$h,$hp)){
                        $headers[$hp[1]]=$v;
                }
        }
        return $headers;
}

function OutputArrayValues($array){
        while (list($key, $value) = each($array))
        {
                if ("" != $value)
                {
                        echo "$key = $value<br>";
                }
        }
}
