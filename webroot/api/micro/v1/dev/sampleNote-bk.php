<?php
include("apiKey.php");
session_start();

// Receive the information from sampleDetails. in $_POST.
// Restructure the data to recover the original structure.
// Need the name, title, value, tag, key.
$originalPayload = json_decode($_SESSION["originalResult"], true);

foreach ($originalPayload["body"]["order"] as $dummy => $key) {
	if ($key == "details") {
		foreach ($originalPayload["body"][$key]["questions"] as $cc => $questions) {
			foreach ($originalPayload["body"][$key]["questions"][$cc] as $idx => $question) {
				if (array_key_exists($question["name"], $_POST)) {
					$originalPayload["body"][$key]["questions"][$cc][$idx]["value"] = $_POST[$question["name"]];
				}
			}
		}
	} else {
		foreach ($originalPayload["body"][$key]["questions"] as $idx => $question) {
			if (array_key_exists($question["name"], $_POST)) {
				$originalPayload["body"][$key]["questions"][$idx]["value"] = $_POST[$question["name"]];
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


// Send the data to the API.
$payload = json_encode($originalPayload);

///////////
// Curl routine.
$ch = curl_init();
// GET /supported POST /details POST /note
curl_setopt($ch, CURLOPT_URL, "https://q3clezf4jb.execute-api.us-east-2.amazonaws.com/alpha/note");
curl_setopt($ch, CURLOPT_POST, 1);
// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',"x-api-key:".$apikey));
// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  1);
$result = curl_exec($ch);

print_r($result);
curl_close($ch);
////////////

// Get back the note.
$resultDecoded = json_decode($result, true);

?>

<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet">

<h1>Note endpoint example</h1>
</head>
<body>
<div id="wrapper">
<div id="form_div">

<?php
// Display the note.
foreach($resultDecoded["body"]["order"] as $dummy => $section) {
	echo "<h1>" . $section . "</h1>";
	foreach($resultDecoded["body"][$section] as $dummy2 => $tuple) {
		echo $tuple[0] . ": " . $tuple[1] . "<br>";
	}
}
?>

</div>
</div>
</body>

</html>