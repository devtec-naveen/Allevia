<?php
include("apiKey.php");
$ch = curl_init();
// GET /supported POST /details POST /note
curl_setopt($ch, CURLOPT_URL, "https://q3clezf4jb.execute-api.us-east-2.amazonaws.com/alpha/supported");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',"x-api-key:".$apikey));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, POST DATA);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  1);
$result = curl_exec($ch);


print_r($result);
curl_close($ch);
?>
