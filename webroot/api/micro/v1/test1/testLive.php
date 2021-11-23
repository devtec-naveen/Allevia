<?php
$grant_type = 'password';
$username = 'allevia@fruitstreet.com';//'john@valhalla.healthcare.community';
$password = 'c8rPS0npV5SLUkdkdKVR'.'HVu72BHbMu4UiUrfyQnnlD4k';//'fruitstreetjc114'. '0Pd27Dm57FztnoUHnVSrZpIc';
$client_id = '3MVG9CEn_O3jvv0z4UgWeFAoiWfDyUDhoQSd09a8QkfnUujzaGEvsYtayWExxT4y4RNeOhW8jYCyJl9AvKiCE';//'3MVG98im9TK34CUU8IyhZMC5eo7IDUM6Lc1VmGY_uHGLgecFGdpb85vZ5nf3E2swURldCfIQdyg==';
$client_secret = 'DF31B5EB8862DA9CF01219DC2F621C121FBEE81E1E5AFD7AF4706A6FBB07E2CA';//'8497224FD114D8B86432325117E9D3E004BF5CA8D8BB2F0DEE8D0391B57752C4';
$baseUrl = 'https://login.salesforce.com';//'https://test.salesforce.com';

$payload = 'grant_type='.$grant_type.'&username='.$username.'&'.'password='.$password.'&client_id='.$client_id.'&client_secret='.$client_secret;
// Curl routine to get authentication token.
$ch = curl_init();
// GET /supported POST /details POST /note
curl_setopt($ch, CURLOPT_URL, $baseUrl . "/services/oauth2/token");
curl_setopt($ch, CURLOPT_POST, 1);
// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
$result = curl_exec($ch);
//echo '<div class = "inner_div">';
//print_r($result);
//echo '</div>';
curl_close($ch);
////////////

$response = json_decode($result, true);

//echo $result;

// https://fruitstreet.my.salesforce.com
?>