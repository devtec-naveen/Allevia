<?php
session_start();

include("apiKey.php");
include("medication.php");
include("database.php");
$secure = true; // if you only want to receive the cookie over HTTPS
$httponly = true; // prevent JavaScript access to session cookie
$samesite = 'lax';
$maxlifetime = 6000;

if(PHP_VERSION_ID < 70300) {
	session_set_cookie_params($maxlifetime, '/; samesite='.$samesite, $_SERVER['HTTP_HOST'], $secure, $httponly);
} 
else 
{
	session_set_cookie_params([
		'lifetime' => $maxlifetime,
		'path' => '/',
		'domain' => $_SERVER['HTTP_HOST'],
		'secure' => $secure,
		'httponly' => $httponly,
		'samesite' => $samesite
	]);
}
$testing = "0"; // "0" for prod, "1" for sbuat, "2" for partial

if ( empty($_POST) ) {
	exit();
}

// Make sure from main.
if (!isset($_SESSION["fromMain"])) {
	exit();
}

//change the medication layman to doctor specific name
$temp_med_name = array();
$temp_dose = array();
$temp_how_often = array();
$temp_route = array();
if(isset($_POST['medication_name_name']) && !empty($_POST['medication_name_name'])){

	$medication_layman_name = $_POST['medication_name_name'];
	if(!empty($medication_layman_name)){

		$all_med_name = all_med($conn);

		foreach ($medication_layman_name as $key => $value) {
			if (empty($value)) {
				continue;
			}
			
			$temp_med_name[] = isset($all_med_name[$value]) ? $all_med_name[$value] : $value;
			$temp_dose[] = $_POST["medication_dose"][$key];
			$temp_how_often[] = $_POST["medication_how_often"][$key];
			$temp_route[] = $_POST["medication_how_taken"][$key];

			
		}


		/*echo '<pre>';
		print_r($temp_med_name);
		echo '<pre>';
		print_r($all_med_name);
		die;*/
	}
}
$_POST['medication_name_name'] = $temp_med_name; 
$_POST['medication_dose'] = $temp_dose;
$_POST['medication_how_often'] = $temp_how_often;
$_POST['medication_how_taken'] = $temp_route;

if (!isset($_POST['allergy_history'])) {
	$_POST['allergy_history'] = array();
}

// echo '<pre>';
// print_r($_POST);die;

// Receive the information from sampleDetails. in $_POST.
// Restructure the data to recover the original structure.
// Need the name, title, value, tag, key.
$originalPayload = json_decode($_SESSION["originalResult"], true);

// Adding allergy_history and medication_name_name medication_dose medication_how_often medication_how_taken
$originalPayload["body"]["medicationList"] = array();
$originalPayload["body"]["medicationList"]["medicationName"] = $_POST['medication_name_name'];
$originalPayload["body"]["medicationList"]["medicationDose"] = $_POST['medication_dose'];
$originalPayload["body"]["medicationList"]["medicationFreq"] = $_POST['medication_how_often'];
$originalPayload["body"]["medicationList"]["medicationRoute"] = $_POST['medication_how_taken'];
$originalPayload["body"]["allergiesList"] = $_POST['allergy_history'];

// Added to take in originalData which may have excluded some questions.
$_POST = array_merge($_SESSION["originalData"], $_POST);

foreach ($originalPayload["body"]["order"] as $dummy => $key) {
	if ($key == "details") {
		foreach ($originalPayload["body"][$key]["questions"] as $cc => $questions) {
			foreach ($originalPayload["body"][$key]["questions"][$cc] as $idx => $question) {
				$nameWithUnderscore = str_replace(' ', '_', $question["name"]);
				if (array_key_exists($nameWithUnderscore, $_POST)) {
					$originalPayload["body"][$key]["questions"][$cc][$idx]["value"] = $_POST[$nameWithUnderscore];
				}
			}
		}
	} else {
		foreach ($originalPayload["body"][$key]["questions"] as $idx => $question) {
			$nameWithUnderscore = str_replace(' ', '_', $question["name"]);
			if (array_key_exists($nameWithUnderscore, $_POST)) {
				$originalPayload["body"][$key]["questions"][$idx]["value"] = $_POST[$nameWithUnderscore];
			}
		}
	}
}

// Add required parameters.
$originalPayload["body"]["specialization"] = $_SESSION["specialization"];
$originalPayload["body"]["visitReason"] = $_SESSION["visitReason"];
$originalPayload["body"]["age"] = $_SESSION["age"];
$originalPayload["body"]["gender"] = $_SESSION["gender"];
$originalPayload["body"]["patientStatus"] = $_SESSION["patientStatus"];
$originalPayload["body"]["firstName"] = $_SESSION["firstName"];
$originalPayload["body"]["lastName"] = $_SESSION["lastName"];
$originalPayload["body"]["DOB"] = $_SESSION["DOB"];
$originalPayload["body"]["email"] = $_SESSION["email"];
$originalPayload["body"]["phone"] = $_SESSION["phone"];
$originalPayload["body"]["MRN"] = $_SESSION["MRN"];
$originalPayload["body"]["date"] = $_SESSION["date"];
$originalPayload["body"]["typeOfService"] = $_SESSION["typeOfService"];
$originalPayload["body"]["insuranceType"] = $_SESSION["insuranceType"];
$originalPayload["body"]["caseId"] = $_SESSION["caseId"];

// Send the data to the API.
$payload = json_encode($originalPayload);

// print_r($payload);

///////////
// Curl routine.
$ch = curl_init();
if (($testing == "1") or ($testing == "2")) {
	// GET /supported POST /details POST /note
	curl_setopt($ch, CURLOPT_URL, "https://q3clezf4jb.execute-api.us-east-2.amazonaws.com/test/note");
} else {
	// GET /supported POST /details POST /note
	curl_setopt($ch, CURLOPT_URL, "https://q3clezf4jb.execute-api.us-east-2.amazonaws.com/v1/note");
}
curl_setopt($ch, CURLOPT_POST, 1);
// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',"x-api-key:".$apikey));
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

// Get back the note.
//$resultDecoded = json_decode($result, true);
$_SESSION["noteOutput"] = $result;

$decodedResult = json_decode($result, true);
// print_r($decodedResult);
$toSalesforce = array();
$toSalesForce["Chief_Complaint__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["cc"]);
$toSalesForce["History_of_Present_Illness__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["hpi"]);
$toSalesForce["Review_of_Systems__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["ros"]);
$toSalesForce["Medication_List__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["meds"]);
$toSalesForce["PMFSH__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["pmfsh"]);
$toSalesForce["Allergies__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["all"]);
$toSalesForce["Vitals__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["vitals"]);
$toSalesForce["Physical_Exam__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["pe"]);
$toSalesForce["Assessment__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["assessment"]);
$toSalesForce["Plan__c"] = implode("\r\n",$decodedResult["body"]["Medical Details"]["plan"]);
$toSalesForce["E_M_Visit_Code_s__c"] = implode("\r\n",$decodedResult["body"]["Billing E/M codes"]["Billing codes"]);
$toSalesForce["Other_CPT_Codes__c"] = implode("\r\n",$decodedResult["body"]["Billing E/M codes"]["Other codes"]);
$toSalesForce["ICD_10_Codes__c"] = implode("\r\n",$decodedResult["body"]["Billing E/M codes"]["ICD-10 codes"]);
$toSalesForce["Preferred_Pharmacy__c"] = implode("\r\n",$decodedResult["body"]["Basic Details"]["Preferred Pharmacy"]);
$toSalesForce["IsSurveyCompleted__c"] = true; // For purposes of showing button to let user continue.
// Push to SalesForce end.
$payloadToSalesforce = json_encode($toSalesForce);

///////////
$grant_type = 'password';
if ($testing == "1") {
	#$username = 'john@valhalla.healthcare.community';
	$username = 'allevia@fruitstreet.com.sbuat';
} else if ($testing == "0") {
	$username = 'allevia@fruitstreet.com';
} else { // "2"
	$username = 'allevia@fruitstreet.com.partial';
}

if ($testing == "1") {
	#$password = 'fruitstreetjc114'. '0Pd27Dm57FztnoUHnVSrZpIc';
	$password = 'salesforcejc114' . 'MLdQT5dyDpyTm20BYZoI8noO';
} else if ($testing == "2") {
	$password = 'salesforcejc114' . '6JtvKJUmIHNSF86VQCjhNjqgl';
} else {#old:'uhTsYgqPT71oENOffxFqafhGz'.'HVu72BHbMu4UiUrfyQnnlD4k'
	$password = 'jbPHJns2mkBXAR6' . 'uhTsYgqPT71oENOffxFqafhGz';
}

if ($testing == "1") {
	#$client_id = '3MVG98im9TK34CUU8IyhZMC5eo7IDUM6Lc1VmGY_uHGLgecFGdpb85vZ5nf3E2swURldCfIQdyg==';
	//$client_id = '3MVG93MGy9V8hF9P5tOvZXvSk6W3UHDKBVtR0nvwrpYPZzsdZEGs22i_0rHK_FniBT_VzZ1_PRG_TmnL0mZno';
	$client_id = '3MVG9oZtFCVWuSwOvwwAVjUooDXpQg_vjJmw5pepek4LWsrAMGoxIr..xLLWrwSV7IbDs5HrxnFn9Ep1cWYvy'; // Latest
} else if ($testing == "2")  {
	$client_id = '3MVG98im9TK34CUU_AvwaugYPyFSgDUdGks5GBpR.pIMVQbDC.0lCJsYYlDASoBurpyFRR0rZ1nmWYgpntRLE';
} else {
	$client_id = '3MVG9CEn_O3jvv0z4UgWeFAoiWfDyUDhoQSd09a8QkfnUujzaGEvsYtayWExxT4y4RNeOhW8jYCyJl9AvKiCE';
}

if ($testing == "1") {
	#$client_secret = '8497224FD114D8B86432325117E9D3E004BF5CA8D8BB2F0DEE8D0391B57752C4';
	//$client_secret = '219684ED341671EF4C9EEA421AA4C81C099E687F6AB57B31167A49F92BA32179';
	$client_secret = 'F75FC99A059936E238DC62EDF0796BE24B38D98490EF514BA5D2187CD6166B01'; //Latest
} else if ($testing == "2") {
	$client_secret = '5C762114CC16AFC45113D5D42C66BFA922F310D27B03D81477EE4B476C004F93';
} else {
	$client_secret = 'DF31B5EB8862DA9CF01219DC2F621C121FBEE81E1E5AFD7AF4706A6FBB07E2CA';
}

if (($testing == "1") or ($testing == "2")) {
	$baseUrl = 'https://test.salesforce.com';
} else {
	$baseUrl = 'https://login.salesforce.com';
}


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

$id = $response["id"];

$access_token = $response["access_token"];
if ($testing == "1") {
	#$instanceUrl = 'https://fruitstreet--community.my.salesforce.com';
	$instanceUrl = 'https://fruitstreet--sbuat.my.salesforce.com';
} else if ($testing == "2") {
	$instanceUrl = 'https://fruitstreet--partial.my.salesforce.com';
} else {
	$instanceUrl = 'https://fruitstreet.my.salesforce.com';
}

// Curl routine to update record.
$ch = curl_init();
// GET /supported POST /details POST /note
curl_setopt($ch, CURLOPT_URL, $instanceUrl . '/services/data/v40.0/sobjects/Case/' . $_SESSION["caseId"] . '?_HttpMethod=PATCH');
curl_setopt($ch, CURLOPT_POST, 1);
// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadToSalesforce);
// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));
// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
//Adding these lines
// curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//curl_setopt($ch, CURLOPT_AUTOREFERER, true);

$result = curl_exec($ch);
//echo '<div class = "inner_div">';
//print_r($result);
//echo '</div>';
// print_r(curl_getinfo($ch));
// print_r($result);
// echo $result;
// echo "hi";
// echo curl_error($ch);
curl_close($ch);
// ////////////
//echo $_SESSION["caseId"];
//echo $result;

// $newURL = 'https://community-fruitstreet.cs79.force.com/covidmd/s/virtual-waiting-room?id=5001h0000052qF8AAI';
// header('Location: '.$newURL);

echo "<div class='fullscreenDiv'>";
echo '<div class="center"><h3>Form submitted successfully.</h3></div>';
echo "</div>";

//TEMP
//if ($testing) {
//	header('Location: https://www.allevia.md/webroot/api/micro/v1/test/note.php');
//}
?>
<style type="text/css">
	.center {
    position: absolute;
    /*width: 100px;
    height: 50px;*/
    top: 50%;
    left: 50%;
    margin-left: -50px; /* margin is -0.5  dimension */
    margin-top: -25px; 
}


.fullscreenDiv {
   /* background-color: #e8e8e8;*/
    width: 100%;
    height: auto;
    bottom: 0px;
    top: 0px;
    left: 0;
    position: absolute;
}
</style>