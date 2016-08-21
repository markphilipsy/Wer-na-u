<?php

$msg=$_GET['place'];

    $arr_post_body = array(
        "message_type" => "SEND",
        "mobile_number" => "639277442565",
        "shortcode" => "2929067712",
        "message_id" => "12345678901234567890123456789012",
        "message" => urlencode("Wer na u: Here at ".$msg),
        "client_id" => "0d81d7e2976606db2a9cd8fac9bd896d871c9d41db896bc25f0ca7a96064552c",
        "secret_key" => "5bb1e7c5baa686eb62332afef01ac6928090b172e37afdd1ea91f2e1800a2dfb"
    );

    $query_string = "";
    foreach($arr_post_body as $key => $frow)
    {
        $query_string .= '&'.$key.'='.$frow;
    }

    $URL = "https://post.chikka.com/smsapi/request";

    $curl_handler = curl_init();
    curl_setopt($curl_handler, CURLOPT_URL, $URL);
    curl_setopt($curl_handler, CURLOPT_POST, count($arr_post_body));
    curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
    curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl_handler);
    curl_close($curl_handler);

    exit(0);



?>