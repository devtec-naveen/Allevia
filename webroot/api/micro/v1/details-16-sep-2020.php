<html>
<head>

<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet">

<link href="bootstrap.min.css" rel="stylesheet" /> 
<!-- <link rel="stylesheet" href="mdb.min.css" rel="stylesheet"/> -->
<link href="fontawesome-all.css" rel="stylesheet"/>
<link href="fontawesome.css" rel="stylesheet"/>
<link href="style.css" rel="stylesheet"/>
<!-- <link href="developer.css" rel="stylesheet"/> -->

<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="bootstrap.min.js"></script>

<style type="text/css">
	.clone_purpose_medication_field_display_none, .allergyhistoryfld_clone_on_load_display_none_cls{ display: none; }
</style>
</head>
<body>
<div id="wrapper">
	<div class="inner_page_content">
   <div class="dashboard_content_bg">
   	<div class="container">
   		<div class="TitleHead">
 			<h1>Patient Intake Form</h1>
 		</div> 		

<?php

session_start();

// $currentCookieParams = session_get_cookie_params();  
// $sidvalue = session_id();  
// setcookie(  
//     'PHPSESSID',//name  
//     $sidvalue,//value  
//     0,//expires at end of session  
//     $currentCookieParams['path'],//path  
//     $currentCookieParams['domain'],//domain  
//     true //secure  
// ); 
$currentCookieParams = session_get_cookie_params();  
$sidvalue = session_id(); 
header('Set-Cookie: PHPSESSID='.$sidvalue.'; SameSite=None; Secure');
// header('Set-Cookie: cross-site-cookie=PHPSESSID; SameSite=None; Secure');

// header('Set-Cookie: cross-site-cookie=PHPSESSID; SameSite=None; Secure');

include("apiKey.php");
//session_set_cookie_params(['SameSite' => 'None', 'Secure' => true]);
// session_set_cookie_params(3600*24, '/;SameSite=None', $_SERVER['HTTP_HOST'], true);


$testing = false;

if (!$testing) {
	if ( empty($_GET) ) {
		exit();
	}

	// Must pass in apikey
	if (!isset($_GET["apiKey"])) {
		exit();
	} else if (!in_array($_GET["apiKey"], $acceptableApiKeys)) {
		exit();
	}	
}

// Only allow update to be accessed from main.
$_SESSION['fromMain'] = true;

$existingJson = array();

$date = date('Y-m-d H:i:s');
date_default_timezone_set('America/Chicago');

//Dummy for required fields
$existingJson = array("date"=>$date . "CT", 
	"email"=>"",
	"phone"=>"",
	"MRN"=>"",
	"insuranceType"=>"",
"caseId"=> "5003u00000Mpp0HAAR",//"5001h0000052q6RAAQ",
 "caseNumber" => "00001976",//"00001098",
	"age"=>"0",
	"gender"=>"F",
	"patientStatus"=>"new",
	"firstName"=>"mary",
	"lastName"=>"appleseed",
	"DOB"=>"04/10/1980",
	"chiefComplaints"=>array(),
);

if ($testing) {
	$existingJson["caseId"] = "5003u00000Mpp0HAAR";#"5001h0000052q6RAAQ"; #5003u00000Mpp0HAAR #5007A000005VXoiQAG
	$existingJson["caseNumber"] = "00001097";#"00001098";#  "00001097"#"00003930"
}

function trueOrFalseToYesNo($inputValue) {
	if (strtolower($inputValue) == 'true') {
		return "Yes";
	} else {
		return "No";
	}
}

// Reformat $existingJson.
$chiefComplaints = array();// array("cough");
if ($testing) {
	$chiefComplaints = array("cough");
}
// $_GET["arg14"] = 'TRUE';
// $_GET["arg19"] = 'TRUE';
if (isset($_GET["arg1"])) { // Id
	$existingJson["caseId"] = $_GET["arg1"];
} 
if (isset($_GET["arg2"])) {
	$existingJson["caseNumber"] = $_GET["arg2"];
} 
if (isset($_GET["arg4"])) {
	$existingJson["pregnant"] = trueOrFalseToYesNo($_GET["arg4"]);
} 
if (isset($_GET["arg7"])) {
	$existingJson["gender"] = $_GET["arg7"];
} 
if (isset($_GET["arg8"])) {
	$existingJson["DOB"] = $_GET["arg8"];
} 
if (isset($_GET["arg11"])) { // healthQuestionnaire
	$existingJson["chills"] = trueOrFalseToYesNo($_GET["arg11"]);
	if ($existingJson["chills"] == "Yes") {
		array_push($chiefComplaints, "chills");
	}
} 
// if (isset($_GET["arg12"])) { // Too complicated from their side.
// 	$existingJson["labCOVIDContact"] = $_GET["arg12"];
// } 
if (isset($_GET["arg14"])) { // associatedSymptoms and chiefComplaints
	$existingJson["cough"] = trueOrFalseToYesNo($_GET["arg14"]);
	if ($existingJson["cough"] == "Yes") {
		array_push($chiefComplaints, "cough");
	}
} 
if (isset($_GET["arg15"])) {
	$existingJson["smoking"] = trueOrFalseToYesNo($_GET["arg15"]);
} 
if (isset($_GET["arg17"])) { // associatedSymptom
	$existingJson["diarrhea"] = trueOrFalseToYesNo($_GET["arg17"]);
	if ($existingJson["diarrhea"] == "Yes") {
		array_push($chiefComplaints, "diarrhea");
	}
} 
if (isset($_GET["arg18"])) {
	$existingJson["fever"] = trueOrFalseToYesNo($_GET["arg18"]);
	if ($existingJson["fever"] == "Yes") {
		array_push($chiefComplaints, "fever");
	}
}
if (isset($_GET["arg19"]) && (!isset($existingJson["fever"]) || ($existingJson["fever"] == "No"))) {
	$existingJson["fever"] = trueOrFalseToYesNo($_GET["arg19"]);
	if ($existingJson["fever"] == "Yes") {
		array_push($chiefComplaints, "fever");
	}
}
if (isset($_GET["arg20"])) {
	$existingJson["firstName"] = $_GET["arg20"];
} 
if (isset($_GET["arg21"])) {
	if ($_GET["arg21"] == "Yes") {
		$existingJson["HCPFR"] = "Yes";
	} else {
		$existingJson["HCPFR"] = "No";
	}
	
} 
if (isset($_GET["arg22"])) {
	$headache = trueOrFalseToYesNo($_GET["arg22"]);
	$existingJson["headache"] = $headache;
	if ($headache == "Yes") {
		array_push($chiefComplaints, "headache");
	}
} 
if (isset($_GET["arg25"])) {
	$existingJson["lastName"] = $_GET["arg25"];
} 
if (isset($_GET["arg26"])) {
	$existingJson["lossofsmell"] = trueOrFalseToYesNo($_GET["arg26"]);
	if ($existingJson["lossofsmell"] == "Yes") {
		array_push($chiefComplaints, "loss of smell");
	}
} 
if (isset($_GET["arg27"])) {
	$existingJson["lossoftaste"] = trueOrFalseToYesNo($_GET["arg27"]);
	if ($existingJson["lossoftaste"] == "Yes") {
		array_push($chiefComplaints, "loss of taste");
	}
} 
if (isset($_GET["arg28"])) { //nausea
	$nausea = trueOrFalseToYesNo($_GET["arg28"]);
	if ((isset($existingJson["nauseaorvomiting"])) && ($existingJson["nauseaorvomiting"] == "No")) {
		$existingJson["nauseaorvomiting"] = $nausea;
	} else {
		$existingJson["nauseaorvomiting"] = $nausea;
	}
	
	if ($nausea == "Yes") {
		array_push($chiefComplaints, "nausea");
	}
} 
if (isset($_GET["arg29"])) {
	if ($_GET["arg29"] == 'TRUE') {
		$existingJson["domesticTravel"] = "No";
	}
} 
if (isset($_GET["arg30"])) {
	if ($_GET["arg30"] == 'TRUE') {
		$existingJson["internationalTravel"] = "No";
	}
} 
if (isset($_GET["arg38"])) {
	$existingJson["age"] = $_GET["arg38"];
} 
if (isset($_GET["arg40"])) {
	$existingJson["patientStatus"] = strtolower($_GET["arg40"]);
} 
if (isset($_GET["arg42"])) {
	$existingJson["eyeredness"] = trueOrFalseToYesNo($_GET["arg42"]);
	if ($existingJson["eyeredness"] == "Yes") {
		array_push($chiefComplaints, "eye redness");
	}
} 
if (isset($_GET["arg43"])) {
	$existingJson["runnynose"] = trueOrFalseToYesNo($_GET["arg43"]);
} 
if (isset($_GET["arg44"])) {
	$sob = trueOrFalseToYesNo($_GET["arg44"]);
	$existingJson["shortnessofbreath"] = $sob;
	if ($sob == "Yes") {
		array_push($chiefComplaints, "shortness of breath");
	}
} 
if (isset($_GET["arg46"])) {
	$existingJson["vaping"] = trueOrFalseToYesNo($_GET["arg46"]);
} 
if (isset($_GET["arg47"])) {
	$vomiting = trueOrFalseToYesNo($_GET["arg47"]);
	if ((isset($existingJson["nauseaorvomiting"])) && ($existingJson["nauseaorvomiting"] == "No")) {
		$existingJson["nauseaorvomiting"] = $vomiting;
	} else {
		$existingJson["nauseaorvomiting"] = $vomiting;
	}
	if ($vomiting == "Yes") {
		array_push($chiefComplaints, "vomiting");
	}
	
} 


$existingJson["chiefComplaints"] = $chiefComplaints;
$existingJson["MRN"] = "";
$existingJson["insuranceType"] = "";

// Fixed parameters.
$_SESSION["specialization"] = "covid";
$_SESSION["visitReason"] = "covid";
$_SESSION["typeOfService"] = "telehealth";

// This will come in somehow, e.g. via $_POST. // These are needed for the api.
$_SESSION["caseId"] = $existingJson["caseId"];
$_SESSION["age"] = $existingJson["age"];
$_SESSION["gender"] = $existingJson["gender"];
$_SESSION["patientStatus"] = $existingJson["patientStatus"];
$_SESSION["firstName"] = $existingJson["firstName"];
$_SESSION["lastName"] = $existingJson["lastName"];
$_SESSION["DOB"] = $existingJson["DOB"];
$_SESSION["email"] = $existingJson["email"];
$_SESSION["phone"] = $existingJson["phone"];
$_SESSION["MRN"] = $existingJson["MRN"];
$_SESSION["date"] = $existingJson["date"];
$_SESSION["insuranceType"] = $existingJson["insuranceType"];
$_SESSION["chiefComplaints"] = $existingJson["chiefComplaints"];//array("cough", "fatigue","fever", "runny nose", "shortness of breath", "chest pain");

$payload = array("body"=>array("specialization"=>$_SESSION["specialization"],"visitReason"=>$_SESSION["visitReason"],"chiefComplaints"=>$_SESSION["chiefComplaints"],"age"=>$_SESSION["age"],"gender"=>$_SESSION["gender"], "patientStatus"=>$_SESSION["patientStatus"],"caseId"=>$_SESSION["caseId"]), "receivedProcessed"=>json_encode($existingJson),"received"=>json_encode($_GET));
$payload = json_encode($payload);

///////////
// Curl routine.
$ch = curl_init();

if ($testing) {
	// GET /supported POST /details POST /note
	curl_setopt($ch, CURLOPT_URL, "https://q3clezf4jb.execute-api.us-east-2.amazonaws.com/test/details");	
} else {
	// GET /supported POST /details POST /note
	curl_setopt($ch, CURLOPT_URL, "https://q3clezf4jb.execute-api.us-east-2.amazonaws.com/v1/details");	
}

curl_setopt($ch, CURLOPT_POST, 1);
// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',"x-api-key:".$apikey));
// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  1);
$resultCurl = curl_exec($ch);

// $questions = json_decode($result);
// echo '<pre>';
// print_r($questions);die;
//echo '<div class="row" style = "margin-bottom: 20px;">';
//print_r($resultCurl);
//echo '</div>';
echo '<hr/>';
curl_close($ch);
////////////

//// These will also come in. Save it. Combine with $_POST results on the note.
$_SESSION['originalData'] = $existingJson;

$_SESSION['originalResult'] = $resultCurl; // Used in this sample code for sending to the note.

$result = json_decode($resultCurl, true);
 // echo "<pre>";
 // print_r($result);die;

//// And then remove from questions ($result).
foreach ($result["body"]["order"] as $dummy => $key) {
	if ($key == "details") {
		foreach ($result["body"][$key]["questions"] as $cc => $questions) {
			foreach ($result["body"][$key]["questions"][$cc] as $idx => $question) {
				$nameWithUnderscore = str_replace(' ', '_', $question["name"]);
				if (array_key_exists($nameWithUnderscore, $existingJson)) {
					unset($result["body"][$key]["questions"][$cc][$idx]);
				} else if (array_key_exists($question["name"], $existingJson)) {
					unset($result["body"][$key]["questions"][$cc][$idx]);
				}
			}
		}
	} else {
		foreach ($result["body"][$key]["questions"] as $idx => $question) {
			$nameWithUnderscore = str_replace(' ', '_', $question["name"]);
			if (array_key_exists($nameWithUnderscore, $existingJson)) {
				unset($result["body"][$key]["questions"][$idx]);
			} else if (array_key_exists($question["name"], $existingJson)) {
				unset($result["body"][$key]["questions"][$idx]);
			}
		}
	}
}

//// Check if there is anything in questions.

$result = json_encode($result);
$how_it_taken_arr = ['mouth','nasal spray','subcutaneously','muscle injection', 'both ears', 'right ear', 'left ear', 'both eyes', 'right eye', 'left eye','injection under skin', 'under tongue','other'];
?>


<div class = "row" id="form_div">
<!--https://www.allevia.md/webroot/api/micro/v1/update.php-->
 <form method="post" action="update.php" id="detailsForm">
 
 <!-- Change to >1 when phq-2 score is above a certain threshold. -->
 <input type="hidden" id="hiddenPHQ2Field1" name="hiddenPHQ2Field1" value="0">
 <input type="hidden" id="hiddenPHQ2Field2" name="hiddenPHQ2Field2" value="0">

 <!-- Change to >1 when phq-2 score is above a certain threshold. -->
 <input type="hidden" id="hiddenPHQ2" name="hiddenPHQ2" value=">1">

 <div class="container" id="medication">
 	<h3>Medications</h3>
 	<div class="row currentmedicationfld">	   
	</div> 


	<div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 

		   <div class="crose_year">
		    <button  type="button"  class="btn btn-primary currentmedicationfldadd">add a medication</button>
		   </div>
		 </div>
		</div>
	</div>
<!-- **********   medication field for clone purpose display none  start ************* -->
<div class="row clone_purpose_medication_field_display_none">
	<div class="col-md-4">
		<div class="form-group form_fild_row">
			<div class="custom-drop">
				<input type="text"    class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/> 
	      		<ul class="med_suggestion_listul custom-drop-li">
				</ul>
			</div>
	    </div>
	</div>
	<div class="col-md-2">
		<div class="form-group form_fild_row"> 
			<input name="medication_dose[]" type="text" class="form-control ignore_fld" placeholder="Dose"/> 
		</div>
	</div>
				
	<div class="col-md-2">
		<div class="form-group form_fild_row">
			<select class="form-control" name="medication_how_often[]">
				<option value="">how often?</option>
				<?php 	
						$length_arr =  '{"1x a day": "qd", "2x a day": "BID", "3x a day": "TID", "every 4 hours": "q4h", "every 6 hours": "q6h", "every 8 hours": "q8h", "every 12 hours": "q12h", "1x a week": "qwk", "2x a week": "2/wk", "3x a week": "3/wk", "at bedtime": "qhs", "in the morning": "qam", "as needed": "PRN"}' ;

  						$length_arr = json_decode($length_arr, true); 
  						$length_arr = array_flip($length_arr); 
						foreach ($length_arr as $key => $value) {
							

							echo "<option value=".$key.">".$value."</option>"; 

						}
					?>
			</select>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group form_fild_row">
			<div class="custom-drop">
				<select class="form-control" name="medication_how_taken[]">
				<option value="">How is it taken?</option>
				<?php 	
						 
						foreach ($how_it_taken_arr as $key => $value) {						

							echo "<option value='".$value."'>".$value."</option>";
						}
					?>
			</select>
				<!-- <input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion" placeholder="How is it taken?"/> 
	      		<ul class="how_taken_suggestion_listul custom-drop-li">
				</ul> -->
			</div>
		</div>
	</div>		
	<div class="col-md-1">
	    <div class="row">
		  	<div class=" currentmedicationfldtimes">
		   		<div class="crose_year">
		    		<button  type="button"  class="btn btn-primary">&#10006;<!-- <i class="fa fa-times"></i> --></button>
		   		</div>
		  	</div>
		</div>
	</div>
</div>
<!-- ************   medication field for clone purpose display none end *************** -->
</div>
<hr />
<div class="container" id="allergies">
 	<h3>Allergies</h3>
 	<div class="row allergyhistoryfld">
 		
 	</div>
 	<div class="row">
	    <div class="col-md-6">
		 	<div class="form-group form_fild_row"> 
				<div class=" allergyhistoryfldadd">
		   			<div class="crose_year">
		    			<button  type="button"  class="btn btn-primary">Add a allergy</button>
		   			</div>
		  		</div>
		 	</div>
		</div>
	</div>

	<!-- html for clone the allergies -->
	<div class="row allergyhistoryfld_clone_on_load_display_none_cls">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      
	      <label>Allergy</label>
	     

 <div class="custom-drop">
	<input type="text"  value="test"  disabled class="form-control al_cond_select allergycondbox  allergy_suggestion" name="allergy_history[<?= $al ?>][name]" placeholder=""/> 

	      <ul class="allergy_suggestion_listul  custom-drop-li">
			</ul>	
</div>
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="row"> 
		  <div class="col-md-7">
		   <div class="form-group form_fild_row"> 
	
	        <label>Reaction</label>
	        
 			<div class="custom-drop">
				<input type="text" disabled  class="form-control react_cond_select reaction_suggestion" name="allergy_history[<?= $al ?>][reaction]" placeholder=""/>
	      		<ul class="reaction_suggestion_listul  custom-drop-li">
				</ul>		    
			</div>
	       </div>
		  </div>
		  
		  <div class="col-md-5 allergyhistoryfldtimes" style="margin-top: 27px;">
		   <div class="crose_year">
		    <button  type="button" class="btn btn-primary">&#10006;</button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div> 

<script type="text/javascript">
	var al = 0; 
$(document).ready(function() {
$(document).on("click",".allergyhistoryfldadd button",function() 
{
 	al++; 
 	var alergy_clone = $( ".allergyhistoryfld_clone_on_load_display_none_cls" ).clone() ;
 	$(alergy_clone).removeClass('allergyhistoryfld_clone_on_load_display_none_cls').addClass('allergyhistoryfld');
 	$(alergy_clone).find('.react_cond_select').attr('name','allergy_history['+ al +'][reaction]');
	$(alergy_clone).find('.al_cond_select').attr('name','allergy_history['+ al +'][name]'); 		
	$(alergy_clone).find('input').each(function() 
	{

		$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
		$(this).removeAttr('disabled');
		$(this).val('');
	});

	$(alergy_clone).insertAfter( ".allergyhistoryfld:last" );
});

 $(document).on("click",".allergyhistoryfldtimes button",function() {

 	var remove_val = $(this).parents('.allergyhistoryfld').find('input.allergycondbox').val();
 	//var flag = false;
 	$(this).parents('.allergyhistoryfld').remove();

 });

 // ajax search for allergy start


searchRequest = null; 
$(document).on("keyup click", ".reaction_suggestion", function () {    


        value = $(this).val();
        if(value){
        	value = value.split(',');
        	value = value[value.length - 1] ; 
        }
    
            if (searchRequest != null) 
                searchRequest.abort();
            var curele = this;
            searchRequest = $.ajax({
                type: "GET",
                url: "reaction.php",//http://localhost/allevia_covid/
                data: {
                	'search_type' : 5, // 5 for searching allergy reaction condition
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                	var msg = JSON.parse(msg);
                	var temphtml = '' ; 
                	$.each(msg, function(index, element) {
                		temphtml += '<li reaction_sugg_attr ="'+element+'" >'+element+'</li>' ; 

					});
					$(curele).next('.reaction_suggestion_listul').html(temphtml);
            
                    //we need to check if the value is the same

                }
            });
        
    });


$(document).on("click touchstart", ".reaction_suggestion_listul li", function () {  

	var diag_sugg_atr = $(this).attr('reaction_sugg_attr');

	var tmptext = $(this).parents('.reaction_suggestion_listul').prev('.reaction_suggestion');
	var ttext = $(tmptext).val();



	if(ttext){
		if(ttext.charAt(ttext.length-1) == ','){
			$(tmptext).val(ttext+' '+diag_sugg_atr); 
		} else {
			ttext = ttext.substr(0, ttext.lastIndexOf(","));
			if(ttext)
				$(tmptext).val(ttext+', '+diag_sugg_atr); 
			else
				$(tmptext).val(ttext+' '+diag_sugg_atr); 			
			// $(tmptext).val(ttext+', '+diag_sugg_atr); 
		}
	}else{
		$(tmptext).val(diag_sugg_atr); 
	}
	
	$(this).parents('.reaction_suggestion_listul').empty();

}); 





searchRequest = null; 
$(document).on("keyup click", ".allergy_suggestion", function () {    


        value = $(this).val();
        if(value){
        	value = value.split(',');
        	value = value[value.length - 1] ; 
        }
    
            if (searchRequest != null) 
                searchRequest.abort();
            var curele = this;
            searchRequest = $.ajax({
                type: "GET",
                url: "reaction.php",//http://localhost/allevia_covid/
                data: {
                	'search_type' : 3, // 3 for searching allergy  condition
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                	var msg = JSON.parse(msg);
                	var temphtml = '' ; 
                	$.each(msg, function(index, element) {
                		temphtml += '<li allergy_sugg_attr ="'+element+'" >'+element+'</li>' ; 

					});
					$(curele).next('.allergy_suggestion_listul').html(temphtml);
            
                    //we need to check if the value is the same

                }
            });
        
    });


$(document).on("click touchstart", ".allergy_suggestion_listul li", function () {  

	var diag_sugg_atr = $(this).attr('allergy_sugg_attr');

	var tmptext = $(this).parents('.allergy_suggestion_listul').prev('.allergy_suggestion');
	var ttext = $(tmptext).val();

	if((ttext.indexOf('Latex') != -1) || diag_sugg_atr.trim() == 'Latex' )
		$("input[value='1'].is_latex_allergy").prop("checked", true); // check the radio button if user chooses Latex


	if(ttext){
		if(ttext.charAt(ttext.length-1) == ','){
			$(tmptext).val(ttext+' '+diag_sugg_atr); 
		} else {
			ttext = ttext.substr(0, ttext.lastIndexOf(","));
			if(ttext)
				$(tmptext).val(ttext+', '+diag_sugg_atr); 
			else
				$(tmptext).val(ttext+' '+diag_sugg_atr); 

			// $(tmptext).val(ttext+', '+diag_sugg_atr); 
		}
	}else{
		$(tmptext).val(diag_sugg_atr); 
	}
	
	$(this).parents('.allergy_suggestion_listul').empty();

}); 




// ajax search for allergy end
 

}); 

</script>
</div>
<hr />


	<script type="text/javascript">
	function dependencyShowHide(listOfDependencies, label, section_name = null, question_number = null) {
	/*
	listOfDependencies - list of dictionaries which are name to value.
	*/
	// Big assumption: Each dependency only contains one clause.
	// Also, dependencies are always onclick events.
	// This is used to handle fields with dependencies.
	//alert(label);
	for (var depIdx = 0; depIdx < listOfDependencies.length; depIdx++) {

		// Establish an onclick event.
		for (var depKey in listOfDependencies[depIdx]) {
			// Very basic way of handling [] which is necessary for php
			// To handle submitting multiple checkboxes with the same name.
			//alert(depKey);
			var elements = document.getElementsByName(depKey);
			if (elements.length == 0) {
				var elements = document.getElementsByName(depKey + "[]");
			}

			if (elements.length > 0) {
				for (var eleIdx in elements) {
					
					if(elements[eleIdx].type == 'radio'){
						var dependencies_value = listOfDependencies[depIdx][depKey];
						elements[eleIdx].addEventListener('click', (function() {
							
							var question_parent_div_id = section_name+"_inner_div_"+question_number;
							var parent_div = document.getElementById(question_parent_div_id);						
							if (this.checked && this.value == dependencies_value) {
								// LABEL!
								
								label.style.display = "block";
								if(parent_div != null){

									parent_div.style.display = "block";
									parent_div.style.marginBottom = "15px";
								}
								
							} else {
								// LABEL!
								
								label.style.display = "none";
								if(parent_div != null){
									parent_div.style.display = "none";
									parent_div.style.marginBottom = "0px";
								}
							}								
								
						}));
					}
					else
					{					
						if (elements[eleIdx].value == listOfDependencies[depIdx][depKey]) {						
							elements[eleIdx].addEventListener('click', (function() {
								
								var question_parent_div_id = section_name+"_inner_div_"+question_number;
								var parent_div = document.getElementById(question_parent_div_id);						
								if (this.checked) {
									// LABEL!
									
									label.style.display = "block";
									if(parent_div != null){
										parent_div.style.display = "block";
										parent_div.style.marginBottom = "15px";
									}
								} else {
									// LABEL!
									label.style.display = "none";
									if(parent_div != null){
										parent_div.style.display = "none";
										parent_div.style.marginBottom = "0px";
									}
								}						
								
							}));
						}
					}
				}
			}
		}
	}

	}
	function displayForm()
	{
		var divName = "detailsForm";
		var detailsDict = <?php echo $result; ?>;
		var detailsDict = detailsDict["body"];

		for (var keyIdx = 0; keyIdx < detailsDict["order"].length; keyIdx++) { // This is for the order of displaying keys.
			var key = detailsDict["order"][keyIdx]
			if (!(key in detailsDict)) {
				continue;
			}

			// Get rid of the extra title and section for GAD7.
			if (key != "GAD7") {
				// Creating title of each section, e.g. title of health questionnaire.
				var h1 = document.createElement('h3');
				var div = document.createElement('div');
				//div.setAttribute('class','row');
				var tabName = key;
				div.setAttribute('class','container');
				div.setAttribute('id',tabName);
				var hr = document.createElement('hr');

				hr.setAttribute('style','margin-bottom:35px;');
				document.getElementById(divName).appendChild(div);
				document.getElementById(divName).appendChild(hr);
				h1.appendChild(document.createTextNode(detailsDict[key]["title"]));
				document.getElementById(tabName).appendChild(h1);
				//document.getElementById(divName).appendChild(div);
			}


			// The "details" key is a little different.
			if (key == "details") {
				// For demo purposes, we just have a patient with cough and fatigue.
				// And for demo purposes we just flatten the values.
				//questions = array_reduce(array_values(detailsDict[key]["questions"]), 'array_merge', array());
				var questionsIdx = 0;
				questions = [];
				for (var questionsKey in detailsDict[key]["questions"]) {
					questions = questions.concat(detailsDict[key]["questions"][questionsKey]);
				}
				//questions = detailsDict[key]["questions"]["cough"];
			} else {
				questions = detailsDict[key]["questions"];
			}

			// Generating html for questions.
			for (var i in questions) {//= 0; i < questions.length; i++) {
				q = questions[i];
				//creating inner div

				var inDivName = key+'_inner_div_'+i;
				var inDiv = document.createElement('div');
				//inDiv.setAttribute('class','row');
				inDiv.setAttribute('class','row '+key+'_inner_div');
				inDiv.setAttribute('id',inDivName);
				
				if(q['dependencies'].length > 0){

					inDiv.setAttribute('style','margin-bottom:0px;');
					inDiv.setAttribute('style','display:none;');
				}
				else{

					inDiv.setAttribute('style','margin-bottom:15px;');
				}
				
				document.getElementById(tabName).appendChild(inDiv);

				// Creating label.
				var label = document.createElement('label');
				label.setAttribute("for",q["name"]);
				label.setAttribute("id",q["name"] + 'label');

				// Requested to capitalize
				if (q["title"].length < 2) {
					label.innerHTML = q["title"];
				} else {
					label.innerHTML = q["title"].charAt(0).toUpperCase() + q["title"].slice(1);
				}
				
				label.style.display = "block";
				if (q["dependencies"].length > 0) {
					label.style.display = "none";
					//inDiv.setAttribute('style','margin-bottom:0px;');
					// Hides if there is a dependency. dependencyShowHide
					// is a naive implementation which assumes only one
					// dependency of size 1.
					//inDiv.setAttribute('style','margin-bottom:0px;');
					dependencyShowHide(q["dependencies"], label,key,i);
				}

				// For styling purposes.
				if(key == 'healthQuestionnaire' || key == 'associatedSymptoms' || key == 'phq'){
					//create a div of col-md-4 for healthquestionnaire label
					var subLableDiv = document.createElement('div');
					subLableDiv.setAttribute('class','col-md-4');
					//subLableDiv.innerHTML = label;
					subLableDiv.appendChild(label);
					document.getElementById(inDivName).appendChild(subLableDiv);
				}
				else if(key == 'details'){

					var subLableDiv = document.createElement('div');
					subLableDiv.setAttribute('class','col-md-12');
					//subLableDiv.innerHTML = label;
					subLableDiv.appendChild(label);
					document.getElementById(inDivName).appendChild(subLableDiv);
				}
				else{

					var subLableDiv = document.createElement('div');
					subLableDiv.setAttribute('class','col-md-12');
					//subLableDiv.innerHTML = label;
					subLableDiv.appendChild(label);
					document.getElementById(inDivName).appendChild(subLableDiv);
					//document.getElementById(inDivName).appendChild(label);
				}
				// Need to handle each of the scenarios:
				// text, radio, dropdown (select), checkbox, text with options where the
				// options are supported to be "quickpicks"
				// Did not implement selectedOptions as well as fieldType restrictions.
				 // For styling purposes.
				if (key == 'healthQuestionnaire' || key == 'associatedSymptoms' || key == 'phq'){
					var subRadioDiv = document.createElement('div');
					subRadioDiv.setAttribute('class','col-md-8');
					var buttonDiv = document.createElement('div');						
					buttonDiv.setAttribute('class','btn-group');
					buttonDiv.setAttribute('data-toggle',"buttons");
				}
				else {

					var subRadioDiv = document.createElement('div');
					subRadioDiv.setAttribute('class','col-md-12');
					var buttonDiv = document.createElement('div');
					buttonDiv.setAttribute('class','btn-group');
					buttonDiv.setAttribute('data-toggle',"buttons");
				}
				if (q["options"].length) {

					if (q["type"] == "radio") {					
						

						for (var j = 0; j < q["options"].length; j++) {

							// Constructing label.

							var label = document.createElement('label');
							label.setAttribute("for",q["name"] + q["options"][j]);
							label.setAttribute("id",q["name"] + q["options"][j] + "label");
							if(key == 'focusedHistory' || key =='covidScreening' || key == 'details'){
							label.setAttribute('class','form-check-label');								
							}
							else
							{
								label.setAttribute('class','btn btn-primary');	
							}
						   	
							// Requested to capitalize.
							label.innerHTML = q["options"][j];

							if (q["dependencies"].length > 0) {
								label.style.display = "none";
								// Hides if there is a dependency. dependencyShowHide
								// is a naive implementation which assumes only one
								// dependency of size 1.
								dependencyShowHide(q["dependencies"], label, key,i);
							}							
							document.getElementById(inDivName).appendChild(label);

							var newInput=document.createElement('input');
							//newInput.style.display = "block";
							newInput.setAttribute("name",q["name"]);
							newInput.setAttribute("title",q["title"]); // No use, but useful for note.
							newInput.setAttribute("id",q["name"] + q["options"][j]);
							newInput.setAttribute("type",q["type"]);
							newInput.setAttribute("placeholder",q["placeholder"]);
							if (q["required"]) {
								newInput.setAttribute("required",q["required"]);
							}
							if (q["dependencies"].length > 0) {
								newInput.style.display = "none";
								// Hides if there is a dependency. dependencyShowHide
								// is a naive implementation which assumes only one
								// dependency of size 1.
								dependencyShowHide(q["dependencies"], newInput,key,i);
							}
							newInput.setAttribute("value",q["options"][j]);
							newInput.setAttribute("tag",q["tag"]);
							newInput.setAttribute("key",q["key"]);
							if(key != 'focusedHistory'){
								newInput.setAttribute('class','form-check-input');
						    }		
							

							document.getElementById(inDivName).appendChild(newInput);

							//if(key == 'healthQuestionnaire' || key == 'associatedSymptoms' || key == 'phq'){
								
								//subRadioDiv.appendChild(newInput);
								//subRadioDiv.appendChild(label);
								//alert(key);
								if(key == 'focusedHistory' || key =='covidScreening' || key =='details'){
								subRadioDiv.appendChild(newInput);
								subRadioDiv.appendChild(label);
								//subRadioDiv.appendChild(buttonDiv);

								}	
								else
							   {
							   	label.appendChild(newInput);
								buttonDiv.appendChild(label);
								subRadioDiv.appendChild(buttonDiv);

							   }

								document.getElementById(inDivName).appendChild(subRadioDiv);
							/*}
							else{

								document.getElementById(inDivName).appendChild(newInput);
								document.getElementById(inDivName).appendChild(label);
							}*/

						}
					} else if (q["type"] == "checkbox") {
						for (var j = 0; j < q["options"].length; j++) {

							var checkboxdiv = document.createElement('div');
							checkboxdiv.setAttribute('class','custom-control custom-checkbox');
							var newInput=document.createElement('input');
							newInput.setAttribute('class','custom-control-input check_had_shot');
							//newInput.style.display = "block";
							newInput.setAttribute("name",q["name"] + "[]"); // Adding [] allows for multiple checkbox options with the same name.
							newInput.setAttribute("title",q["title"]); // No use, but useful for note.
							newInput.setAttribute("id",q["name"] + q["options"][j]);
							newInput.setAttribute("type",q["type"]);
							newInput.setAttribute("placeholder",q["placeholder"]);
							if (q["required"]) {
								newInput.setAttribute("required",q["required"]);
							}
							if (q["dependencies"].length > 0) {
								newInput.style.display = "none";
								// Hides if there is a dependency. dependencyShowHide
								// is a naive implementation which assumes only one
								// dependency of size 1.
								dependencyShowHide(q["dependencies"], newInput, key, i);
							}
							newInput.setAttribute("value",q["options"][j]);
							newInput.setAttribute("tag",q["tag"]);
							newInput.setAttribute("key",q["key"]);
							//document.getElementById(tabName).appendChild(newInput);

							// Constructing label.
							var label = document.createElement('label');
							label.setAttribute("for",q["name"] + q["options"][j]);
							label.setAttribute('class','custom-control-label');
							label.innerHTML = q["options"][j];
							if (q["dependencies"].length > 0) {
								label.style.display = "none";
								// Hides if there is a dependency. dependencyShowHide
								// is a naive implementation which assumes only one
								// dependency of size 1.
								dependencyShowHide(q["dependencies"], label, key, i);
							}

							checkboxdiv.appendChild(newInput);
							checkboxdiv.appendChild(label);

							subRadioDiv.appendChild(checkboxdiv);
							//subRadioDiv.appendChild(label);
							//checkboxdiv.appendChild(subRadioDiv);
							document.getElementById(inDivName).appendChild(subRadioDiv);
							//document.getElementById(tabName).appendChild(label);
						}
					} else if (q["type"] == "dropdown") {
						var newInput=document.createElement('select');
						//newInput.style.display = "block";
						newInput.setAttribute("name",q["name"]);
						newInput.setAttribute("title",q["title"]); // No use, but useful for note.
						newInput.setAttribute("id",q["name"]);
						newInput.setAttribute("placeholder",q["placeholder"]);
						newInput.setAttribute("class",'form-control valid');
						if (q["required"]) {
							newInput.setAttribute("required",q["required"]);
						}
						if (q["dependencies"].length > 0) {
							newInput.style.display = "none";
							// Hides if there is a dependency. dependencyShowHide
							// is a naive implementation which assumes only one
							// dependency of size 1.
							dependencyShowHide(q["dependencies"], newInput);
						}
						newInput.setAttribute("tag",q["tag"]);
						newInput.setAttribute("key",q["key"]);
						//document.getElementById(inDivName).appendChild(newInput);
						subRadioDiv.appendChild(newInput);
						//subRadioDiv.appendChild(label);
						document.getElementById(inDivName).appendChild(subRadioDiv);

						var array = q["options"];

						//Create and append the options.
						for (var opt = 0; opt < array.length; opt++) {
						    var option = document.createElement("option");
						    option.value = array[opt];
						    option.text = array[opt];
						    newInput.appendChild(option);
						}
						
					} else if (q["type"] == "text") { // Text with options.
						var newInput=document.createElement('input');
						newInput.style.display = "block";
						newInput.setAttribute("name",q["name"]);
						newInput.setAttribute("title",q["title"]); // No use, but useful for note.
						newInput.setAttribute("id",q["name"]);
						newInput.setAttribute("type",q["type"]);
						newInput.setAttribute("placeholder",q["placeholder"]);
						newInput.setAttribute("class",'form-control');
						if (q["required"]) {
							newInput.setAttribute("required",q["required"]);
						}
						if (q["dependencies"].length > 0) {
							newInput.style.display = "none";
							// Hides if there is a dependency. dependencyShowHide
							// is a naive implementation which assumes only one
							// dependency of size 1.
							dependencyShowHide(q["dependencies"], newInput);
						}
						newInput.setAttribute("tag",q["tag"]);
						newInput.setAttribute("key",q["key"]);
						//document.getElementById(inDivName).appendChild(newInput);
						subRadioDiv.appendChild(newInput);
						//subRadioDiv.appendChild(label);
						document.getElementById(inDivName).appendChild(subRadioDiv);
					} 
				} else if (q["type"] == "date") {
					var newInput=document.createElement('input');
					newInput.style.display = "block";
					newInput.setAttribute("name",q["name"]);
					newInput.setAttribute("title",q["title"]); // No use, but useful for note.
					newInput.setAttribute("class",'form-control');
					newInput.setAttribute("id",q["name"]);
					newInput.setAttribute("type",q["type"]);
					newInput.setAttribute("placeholder",q["placeholder"]);
					if (q["required"]) {
						newInput.setAttribute("required",q["required"]);
					}
					if (q["dependencies"].length > 0) {
						newInput.style.display = "none";
						// Hides if there is a dependency. dependencyShowHide
						// is a naive implementation which assumes only one
						// dependency of size 1.
						dependencyShowHide(q["dependencies"], newInput);
					}
					// Still need to add options, selected options, fieldType 
					newInput.setAttribute("tag",q["tag"]);
					newInput.setAttribute("key",q["key"]);
					//document.getElementById(inDivName).appendChild(newInput);
					subRadioDiv.appendChild(newInput);
					//subRadioDiv.appendChild(label);
					document.getElementById(inDivName).appendChild(subRadioDiv);
				} else { // "options" is empty.
					var newInput=document.createElement('input');
					newInput.style.display = "block";
					newInput.setAttribute("name",q["name"]);
					newInput.setAttribute("title",q["title"]); // No use, but useful for note.
					newInput.setAttribute("class",'form-control');
					newInput.setAttribute("id",q["name"]);
					newInput.setAttribute("type",q["type"]);
					newInput.setAttribute("placeholder",q["placeholder"]);
					if (q["required"]) {
						newInput.setAttribute("required",q["required"]);
					}
					if (q["dependencies"].length > 0) {
						newInput.style.display = "none";
						// Hides if there is a dependency. dependencyShowHide
						// is a naive implementation which assumes only one
						// dependency of size 1.
						dependencyShowHide(q["dependencies"], newInput);
					}
					// Still need to add options, selected options, fieldType 
					newInput.setAttribute("tag",q["tag"]);
					newInput.setAttribute("key",q["key"]);
					//document.getElementById(inDivName).appendChild(newInput);
					subRadioDiv.appendChild(newInput);
					//subRadioDiv.appendChild(label);
					document.getElementById(inDivName).appendChild(subRadioDiv);
				}
			}

			// Add medication here.

		}
	}
	
	
	displayForm();	
	</script>
	<script type="text/javascript">
	var phqOptions = ["Not at all", "Several days","More than half the days","Nearly every day"]

	for (var phqOptionIdx in phqOptions) {
		var phqOption = phqOptions[phqOptionIdx];
		var element = document.getElementById("anhedonia" + phqOption+"label");
		if (phqOption == "Not at all") {
			element.addEventListener('click', (function() {		
				var val = 0;
				var target = document.getElementById("hiddenPHQ2Field1");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field2").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
					}
					
				} else {
					if (document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		} else if (phqOption == "Several days") {
			element.addEventListener('click', (function() {		
				var val = 1;
				var target = document.getElementById("hiddenPHQ2Field1");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field2").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
						
					}
					
				} else {
					if (document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		} else if (phqOption == "More than half the days") {
			element.addEventListener('click', (function() {		
				var val = 2;
				var target = document.getElementById("hiddenPHQ2Field1");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field2").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
					}
					
				} else {
					if (document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		} else {
			element.addEventListener('click', (function() {		
				var val = 3;
				var target = document.getElementById("hiddenPHQ2Field1");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field2").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
					}
					
				} else {
					if (document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		}


		var element = document.getElementById("depressedMood" + phqOption+"label");

		if (phqOption == "Not at all") {
			element.addEventListener('click', (function() {	
				//console.log('tried1');	
				var val = 0;
				var target = document.getElementById("hiddenPHQ2Field2");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field1").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
					}
					
				} else {
					//console.log('tried');
					if (document.getElementById("hiddenPHQ2").checked) {
						console.log('got inside checked');
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		} else if (phqOption == "Several days") {
			element.addEventListener('click', (function() {		
				var val = 1;
				var target = document.getElementById("hiddenPHQ2Field2");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field1").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
					}
					
				} else {
					if (document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		} else if (phqOption == "More than half the days") {
			element.addEventListener('click', (function() {		
				var val = 2;
				var target = document.getElementById("hiddenPHQ2Field2");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field1").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
					}
					
				} else {
					if (document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		} else {
			element.addEventListener('click', (function() {		
				var val = 3;
				var target = document.getElementById("hiddenPHQ2Field2");
				target.value = val;
				if (parseInt(document.getElementById("hiddenPHQ2Field1").value) + parseInt(target.value) > 1) {
					if (!document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = true;
						document.getElementById("hiddenPHQ2").click();
					}
					
				} else {
					if (document.getElementById("hiddenPHQ2").checked) {
						document.getElementById("hiddenPHQ2").checked = false;
						document.getElementById("hiddenPHQ2").click();
					}
				}
			}));
		}
	}
	</script>

  <input type="submit" name="submitForm" class="btn go_to_part_2" value="submit" style="color: white">
 </form>
</div>
</div>
</div>
</div>

</div>

<script type="text/javascript">

//medication related script
$(document).ready(function() {

 	$(document).on("click"," .currentmedicationfldadd",function() 
 	{
		var cloneob = $( ".clone_purpose_medication_field_display_none" ).clone() ;
		$(cloneob).removeClass('clone_purpose_medication_field_display_none').addClass('currentmedicationfld');
		$( cloneob ).find('input.med_suggestion').addClass('medicationbox');
		$(cloneob).insertAfter( ".currentmedicationfld:last" );	 

	});

 	$(document).on("click",".currentmedicationfldtimes",function()
 	{
 	var remove_medication = $(this).parents('.currentmedicationfld').find('.medicationbox').val();
 	//var flag = false;
 	$(this).parents('.currentmedicationfld').remove();
 	
 });

 // ajax search for add symptoms start


searchRequest = null; 
$(document).on("keyup click", ".med_suggestion", function () 
{ 
    value = $(this).val();
    if(value)
    {
    	value = value.split(',');
    	value = value[value.length - 1] ; 
    }
    
    if (searchRequest != null) 
        searchRequest.abort();
    	var curele = this;
    	searchRequest = $.ajax({
        type: "GET",
        url: "getmedicationsuggestion.php",// http://localhost/allevia_covid/
        data: {
            'search_keyword' : value
        },
        dataType: "text",
        success: function(msg){
        	
        	var msg = JSON.parse(msg);
        	var temphtml = '' ; 
        	$.each(msg, function(index, element) 
        	{
        		temphtml += '<li med_suggestion_attr ="'+element+'" >'+element+'</li>' ; 

			});
			$(curele).next('.med_suggestion_listul').html(temphtml);

        }
    });
        
});


$(document).on("click touchstart", ".med_suggestion_listul li", function () {  

	var diag_sugg_atr = $(this).attr('med_suggestion_attr');

	var tmptext = $(this).parents('.med_suggestion_listul').prev('.med_suggestion');
	var ttext = $(tmptext).val();
	if(ttext){
		if(ttext.charAt(ttext.length-1) == ','){
			$(tmptext).val(ttext+' '+diag_sugg_atr); 
		} else {
			ttext = ttext.substr(0, ttext.lastIndexOf(","));
			if(ttext)
				$(tmptext).val(ttext+', '+diag_sugg_atr); 
			else
				$(tmptext).val(ttext+' '+diag_sugg_atr); 

		}
	}else{
		$(tmptext).val(diag_sugg_atr); 
	}
	
	$(this).parents('.med_suggestion_listul').empty();

}); 

}); 

</script>
</body>
</html>