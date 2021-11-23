<?php
include('database.php');
$search_keyword = $_GET['search_keyword'];
$search_type = $_GET['search_type'];
getrection($search_keyword,$search_type, $conn);
function getrection($search_keyword, $search_type, $conn){

    
    $med_data = array();
    if(!empty($search_keyword))
    {
    	$sql = "SELECT id, name FROM common_conditions WHERE name LIKE '%{$search_keyword}%' AND cond_type = {$search_type} ORDER BY name ASC";		
    }
    else{

    	$sql = "SELECT id, name FROM common_conditions AND cond_type = {$search_type} ORDER BY name ASC";
    }
    //echo $sql;
    $result = mysqli_query($conn, $sql);
    // echo '<pre>';
    // print_r($result);die;
	if (mysqli_num_rows($result) > 0) {

		//fetch all records
		$med_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		// Free result set
		mysqli_free_result($result);
	}

	$common_reaction_cond = array();
	if(!empty($med_data)){

		foreach ($med_data as $key => $value) {
			
			$common_reaction_cond[$value['id']] = $value['name'];
		}
	}
    mysqli_close($conn);
 	echo json_encode($common_reaction_cond); 
    die;
    }
?>