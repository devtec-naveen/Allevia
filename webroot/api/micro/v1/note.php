<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet">
<link href="bootstrap.min.css" rel="stylesheet" /> 
<!-- <link rel="stylesheet" href="mdb.min.css" rel="stylesheet"/> -->
<link rel="stylesheet" href="fontawesome-all.css" rel="stylesheet"/>
<link rel="stylesheet" href="fontawesome.css" rel="stylesheet"/>
<link href="style.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="bootstrap.min.js"></script>

<!-- <h1 style="margin-left: 10px; margin-right: 10px;">Note endpoint example</h1> -->
<style type="text/css">
	
	.inner_div{

		/*border: solid 2px;*/
	    margin-bottom: 10px;
	    /*padding-left: 15px;
	    padding-right: 15px;*/
	    padding: 15px;
	}
</style>
</head>
<body>
	<!-- <div class="container" style="margin-left: 10px; margin-right: 10px;"> -->
	<div id="wrapper">
		<div class="inner_page_content">
				<div class="dashboard_content_bg">
					<div class="container">
						<div class="TitleHead" style="margin-bottom: 20px;">
				 			<h1>Note endpoint example</h1>
				 		</div>
				 		<div class="row" id="form_div">
<?php
include("apiKey.php");
session_start();

// Receive the information from sampleDetails. in $_POST.
// Restructure the data to recover the original structure.
// Need the name, title, value, tag, key.
/*$originalPayload = json_decode($_SESSION["originalResult"], true);

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
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
$result = curl_exec($ch);
echo '<div class = "inner_div">';
//print_r($result);
echo '</div>';
curl_close($ch);*/
////////////

$result = $_SESSION['noteOutput'];
// Get back the note.
$resultDecoded = json_decode($result, true);

?>

<!-- <div id="wrapper"> -->


<?php
// Display the note.
/*if(!empty($resultDecoded)){
	foreach($resultDecoded["body"]["order"] as $dummy => $section) {
		echo '<div class = "inner_div">';
		echo "<h1>" . $section . "</h1>";
		foreach($resultDecoded["body"][$section] as $dummy2 => $tuple) {
			echo $tuple[0] . ": " . $tuple[1] . "<br>";
		}
		echo '</div>';
		//echo '<hr/>';
	}
}*/
?>

<?php
//Display the note.
if(!empty($resultDecoded)){
	foreach($resultDecoded["body"]["order"] as $dummy => $section) {
		echo '<div class = "inner_div">';
		echo "<h1>" . $section . "</h1>";
		foreach($resultDecoded["body"][$section] as $dummy2 => $tuple) {
			echo $dummy2 . ": ";
			foreach ($tuple as $dummy3 => $content) {
				echo $content . "<br>";
			}
		}
		echo '</div>';
	}
}
?>

</div>
</div>
</div>
</div>
</div>
</body>

</html>