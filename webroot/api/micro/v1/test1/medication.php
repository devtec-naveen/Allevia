<?php

function all_med($conn)
{
    
    $med_data = array();
    $sql = "SELECT id, layman_name, doctor_specific_name FROM chief_compliant_medication";
  
    $result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {

		//fetch all records
		$med_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		// Free result set
		mysqli_free_result($result);
	}

	$common_medical_cond = array();
	if(!empty($med_data)){

		foreach ($med_data as $key => $value) {
			
			$layman_name = $value['layman_name'].(!empty($value['doctor_specific_name']) ? "( ".$value['doctor_specific_name']." )" : '');
			if(!empty($value['doctor_specific_name'])){
				
				$common_medical_cond[$layman_name] = $value['doctor_specific_name'];
			}
			else{

				$common_medical_cond[$layman_name] =  $value['layman_name'];
			}
		}
	}
	mysqli_close($conn);
	// echo '<pre>';
	// print_r($common_medical_cond);die;
	return $common_medical_cond;
}

?>