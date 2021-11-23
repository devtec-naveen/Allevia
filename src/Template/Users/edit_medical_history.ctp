<?php

use Cake\Utility\Security;
use Cake\Core\Configure;
$iframe_prefix = Configure::read('iframe_prefix');
//pr($active_tab);
$i = 1;
$tabcount = 1;
$start_year = 1930;
$curyearlast = date("Y");
$session_user = $this->request->getSession()->read('Auth.User');
$url = $this->request->getParam('pass');

$user_id = null;
if(!empty($session_user) && $session_user['role_id'] == 2){

	$user_id = $session_user['id'];
}elseif(!empty($url)){

	$user_id = $url[0];
}

if(!is_null($user_data->gender) && !empty($user_data->gender)){

	$user_data->gender = Security::decrypt(base64_decode($user_data->gender), SEC_KEY);
}


$allTab = array('1','2','3','4','5','6','7');
$completedTab = array_filter(
    $allTab,
    function ($value) use($active_tab) {
        return ($value < $active_tab );
    }
);

/*$iframe_api_data = null;
$session = $this->request->getSession();
if ($session->check('iframe_api_data')) {

    $iframe_api_data  = $session->read('iframe_api_data');
}*/

//pr($iframe_api_data);die;
//$iframe_prefix = Configure::read('iframe_prefix');

?>
<input type="hidden" class="timeinterval"/>
<link href="<?php echo WEBROOT ?>css/tagsinput.css" rel="stylesheet" type="text/css">
<script src="<?php echo WEBROOT ?>js/tagsinput.js"></script>
<script src="<?php echo WEBROOT.'frontend/js/new_appointment.js'; ?>"></script>
<?php
$session = $this->request->session();
$clinic_color_scheme = $session->read('clinic_color_scheme');
if(!empty($clinic_color_scheme['progress_bar_graphic'])){
	$progress_bar_graphic = WEBROOT.'images/'.$clinic_color_scheme['progress_bar_graphic'].'.png';
	$progress_bar_graphic_light = WEBROOT.'images/'.$clinic_color_scheme['progress_bar_graphic'].'_light.png';
}else{
	$progress_bar_graphic = WEBROOT.'images/step_number_active.png';
	$progress_bar_graphic_light = WEBROOT.'images/step_number_in_gray.png';
}
// echo "Hello"; echo $progress_bar_graphic;exit;
?>
<style type="text/css">

.imageUrl_active { background-image: url(<?php echo $progress_bar_graphic; ?>) !important;  }
.imageUrl_notactive {  background-image: url(<?php echo WEBROOT."images/step_number.png"; ?>)  !important ;  }
.imageUrl_error {  background-image: url(<?php echo WEBROOT."images/step_number_in_red.png"; ?>) !important ;  }

 .common_conditions_button	li.medicalcondbottom { margin-bottom: 5px;  }

 .btn{ margin-top: 29px;  }
 .common_conditions_button .btn, .back_next_button .btn { margin: 0px;  }
 /*.previous_pregnancy_field { display: none; }*/
 .on_load_display_none_cls { display: none !important; }

 .custom-drop-li { display: none; z-index: 99; }
 .prev_given_birth_repeatable .close_prev_child_info_close .btn , .biopsy_field_repeatable .close_biopsy_info_close .btn { margin-top: 0px; float: right; }
 /*.radio_bg{ margin-bottom: 5px; margin-top: 5px;   }*/
 .common_conditions_button {    border-top: solid 1px #b1b1b1;    padding-top: 30px;    border-bottom: solid 1px #b1b1b1;    padding-bottom: 30px; background: #ececec; }
 .required_star { color: red; }
  input[readonly] { background-color: #fff !important; }
  .bootstrap-tagsinput .badge{ padding: 3px 11px;  }
  .elem_display_none { display: none; }
  .radio_list {margin-bottom: 0.4rem;}

.badge.badge-info {	font-weight: normal;font-size: 14px; }

</style>

<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
    <?php if(empty($iframe_prefix)){ ?>
     <div class="dashboard_menu ">
      <ul>
		<?php if(!empty($session_user) && $session_user['role_id'] == 2){  ?>

		<!-- 	<li>
		 		<a href="<?= SITE_URL?>users/scheduled-appointments">
			   		<i></i>
			   		<span  id="prev_apt_chnge" >Scheduled Appointments</span>
		  		</a>
	 		</li>
	 		

	   		<li>
			  <a href="<?= SITE_URL?>users/previous-appointment">
				   <i></i>
				   <span id="prev_apt_chnge">Previous Appointments</span>
			  </a>
	 		</li> -->
		<?php } ?>

	   		<!-- <li  class="active">
			  <a href="<?= SITE_URL?>users/medicalhistory">
				   <i></i>
				   <span id="med_his_chnge">Edit Medical History</span>
			  </a>
	 		</li> -->
	  	</ul>
       </div>
   <?php } ?>


    	<?php $width = '14.28%';  if($user_data->gender == 0) { $width = '12.5%';  } ?>
    	<style>.basicdddd li{ width:<?php echo $width; ?> !important; }</style>

		<div class="dashboard_content  <?= !empty($load_the_shots_tab) ? '' : ' animated fadeInRight ' ?>">
	  		<div class="dashboard_head">
	   			<h2>Edit Medical History</h2>
	  		</div>

	  <div class="edit_medical_box">
	  		  <?= $this->Flash->render() ?>

	  		 	<div id="errorHolder"></div>
	  		 	<?= $this->Flash->render('errorapt') ?>


	   <div class="step_head">
	 <div class="step_tab">

	  <ul class="nav nav-tabs basicdddd" id="myTab" role="tablist">
	  	<li class="nav-item <?= $active_tab ==1   ? ' active ' : '' ?>">

	   	<?php
			echo $this->Form->postLink(
				    "post link", // first
				    null,  // second
				    ['data' => ['edited_tab' => 1], 'id' => 'home-tabpostlink'] // third
				);
	   	?>
	    <a class="nav-link  <?= $active_tab ==1   ? ' active ' : '' ?>" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected=" <?= $active_tab==1  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
			<?php if($active_tab == 1){ ?>
		  <i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
		<?php }else if($user_data->max_visited_tab >= 1 && $active_tab != 1){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else{?>
				<i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
				<?php } ?>
		 </div>
		 <span>Basic Information</span>
		</a>
	   </li>


	   	<li class="nav-item <?= $active_tab == 2   ? ' active ' : '' ?>">
		   	<?php
				echo $this->Form->postLink(
					    "post link", // first
					    null,  // second
					    ['data' => ['edited_tab' => 2], 'id' => 'profile-tabpostlink'] // third
					);
		   	?>
		    <a class="nav-link <?=  $active_tab == 2 ? ' active ' : '' ?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="<?=  $active_tab == 2 ? 'true' : 'false' ?>">
			 <div class="step_number">
				 <?php if($active_tab == 2){ ?>
				 <i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
			 <?php }else if($user_data->max_visited_tab >= 2 && $active_tab != 2){ ?>
					 <i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
				 <?php }else{?>
					 <i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
					 <?php } ?>

			 </div>
			 <span>Medical History</span>

			</a>
	   	</li>

	   <li class="nav-item">
	   <?php
				echo $this->Form->postLink(
					    "post link", // first
					    null,  // second
					    ['data' => ['edited_tab' => 3], 'id' => 'contact-tabpostlink'] // third
					);
		   	?>
		    <a class="nav-link <?= $active_tab == 3 ? ' active ' : '' ?>" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="<?= $active_tab == 3 ? 'true' : 'false' ?>">
			 <div class="step_number">
				 <?php if($active_tab == 3){ ?>
			 	<i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else if($user_data->max_visited_tab >= 3 && $active_tab != 3 ){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
				<?php }else{?>
 				 <i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
 				 <?php } ?>
			 </div>
			 <span>Surgical History</span>

			</a>
	   </li>

	   <li class="nav-item">
	   		<?php
				echo $this->Form->postLink(
					    "post link", // first
					    null,  // second
					    ['data' => ['edited_tab' => 4], 'id' => 'family-tabpostlink'] // third
					);
		   	?>
		    <a class="nav-link <?= $active_tab == 4 ? ' active ' : '' ?>" id="family-tab" data-toggle="tab" href="#family" role="tab" aria-controls="family" aria-selected="<?= $active_tab == 4 ? 'true' : 'false' ?>">
			 <div class="step_number">
				 <?php if($active_tab == 4){ ?>
			   <i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
			 <?php }else if($user_data->max_visited_tab >= 4 && $active_tab != 4){ ?>
				 <i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
			 <?php }else{?>
				 <i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
				 <?php } ?>
			 </div>
			 <span>Family History</span>
			</a>

	   </li>

	   <li class="nav-item">
	   	<?php
				echo $this->Form->postLink(
					    "post link", // first
					    null,  // second
					    ['data' => ['edited_tab' => 5], 'id' => 'allergies-tabpostlink'] // third
					);
		   	?>
		    <a class="nav-link <?= $active_tab == 5 ? ' active ' : '' ?>" id="allergies-tab" data-toggle="tab" href="#allergies" role="tab" aria-controls="allergies" aria-selected="<?= $active_tab == 5 ? 'true' : 'false' ?>">
			 <div class="step_number">
				 <?php if($active_tab == 5){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else if($user_data->max_visited_tab >= 5 && $active_tab != 5){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else{?>
				<i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
				<?php } ?>
			 </div>
			 <span>Allergies</span>

			</a>

	   </li>


	   <li class="nav-item">
	   	<?php
				echo $this->Form->postLink(
					    "post link", // first
					    null,  // second
					    ['data' => ['edited_tab' => 6], 'id' => 'social-tabpostlink'] // third
					);
		   	?>

		    <a class="nav-link <?= $active_tab == 6 ? ' active ' : '' ?>" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="<?= $active_tab == 6 ? 'true' : 'false' ?>">
			 <div class="step_number">
				 <?php if($active_tab == 6){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else if($user_data->max_visited_tab >= 6){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else{?>
				<i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
				<?php } ?>

			 </div>
			 <span>Social History</span>

			</a>
	   </li>


   <?php if($user_data->gender == 0) {  ?>
	   <li class="nav-item">

	   	<?php
				echo $this->Form->postLink(
					    "post link", // first
					    null,  // second
					    ['data' => ['edited_tab' => 7], 'id' => 'additional-tabpostlink'] // third
					);
		   	?>
		    <a class="nav-link  <?= $active_tab == 7 ? ' active ' : '' ?>" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="<?= $active_tab == 7 ? 'true' : 'false' ?>">
			 <div class="step_number">
				 <?php if($active_tab == 7){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else if($user_data->max_visited_tab >= 7 && $active_tab != 7){ ?>
				<i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
			<?php }else{?>
				<i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
				<?php } ?>

			 </div>

			 <span>OB/GYN</span>
			</a>

	   </li>
  <?php } ?>


	<li class="nav-item">
	   	<?php
				echo $this->Form->postLink(
					    "post link", // first
					    null,  // second
					    ['data' => ['edited_tab' => 8], 'id' => 'shots1-tabpostlink'] // third
					);
		   	?>
		    <a class="nav-link <?= $active_tab == 8 ? ' active ' : '' ?>" id="shots1-tab" data-toggle="tab" href="#shots1" role="tab" aria-controls="shots1" aria-selected="false">
			 <div class="step_number">
				 <?php if($active_tab == 8){ ?>
			 <i style="background: url(<?php echo $progress_bar_graphic_light ?>) no-repeat;"><?= $i++ ?></i>
		 <?php }else if($user_data->max_visited_tab >= 8 && $active_tab != 8){ ?>
			 <i style="background: url(<?php echo $progress_bar_graphic ?>) no-repeat;"><?= $i++ ?></i>
		 <?php }else{?>
			 <i style="background: url(<?php echo WEBROOT."images/step_number.png";?>) no-repeat;"><?= $i++ ?></i>
			 <?php } ?>

			 </div>
			 <span>Shots</span>
			</a>
	   </li>

	  </ul>
	 </div>
	</div>

	<script type="text/javascript">
    $( document ).ready(function() {

     $( "#home-tab" ).click(function() { $( '#home-tabpostlink' ).trigger('click'); });
     $( "#profile-tab" ).click(function() { $( '#profile-tabpostlink' ).trigger('click'); });
     $( "#contact-tab" ).click(function() { $( '#contact-tabpostlink' ).trigger('click'); });
     $( "#family-tab" ).click(function() { $( '#family-tabpostlink' ).trigger('click'); });
     $( "#allergies-tab" ).click(function() { $( '#allergies-tabpostlink' ).trigger('click'); });
     $( "#social-tab" ).click(function() { $( '#social-tabpostlink' ).trigger('click'); });
     $( "#additional-tab" ).click(function() { $( '#additional-tabpostlink' ).trigger('click'); });
     $( "#shots1-tab" ).click(function() { $( '#shots1-tabpostlink' ).trigger('click'); });


     // below code for back button edit

     $( "#home-tab-backbtn" ).click(function() { $( '#home-tabpostlink' ).trigger('click'); });
     $( "#profile-tab-backbtn" ).click(function() { $( '#profile-tabpostlink' ).trigger('click'); });
     $( "#contact-tab-backbtn" ).click(function() { $( '#contact-tabpostlink' ).trigger('click'); });
     $( "#family-tab-backbtn" ).click(function() { $( '#family-tabpostlink' ).trigger('click'); });
     $( "#allergies-tab-backbtn" ).click(function() { $( '#allergies-tabpostlink' ).trigger('click'); });
     $( "#social-tab-backbtn" ).click(function() { $( '#social-tabpostlink' ).trigger('click'); });
     $( "#additional-tab-backbtn" ).click(function() { $( '#additional-tabpostlink' ).trigger('click'); });
     $( "#shots1-tab-backbtn" ).click(function() { $( '#shots1-tabpostlink' ).trigger('click'); });

    });

</script>
<style type="text/css">
	#home-tabpostlink, #profile-tabpostlink, #contact-tabpostlink, #family-tabpostlink, #allergies-tabpostlink,#social-tabpostlink,#additional-tabpostlink,#shots1-tabpostlink{
		display: none !important;
	}
</style>


 <?php  if($user_data->gender != 0) {  ?>

 	<style type="text/css">
	 .edit_medical_box .step_head .step_tab::before {   width: 86% !important; }

	</style>

 <?php } ?>

<div class="tab-content" id="myTabContent">
	<div class="tab_content_inner">


	<?php

	if($active_tab == 1){

		echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_1')); ?>


	 	<div class="tab-pane fade   <?= $active_tab == 1 ? '  show active ' : '' ?>" id="home" role="tabpanel" aria-labelledby="home-tab">
	  		<div class="errorHolder">
  			</div>
	  		<div class="TitleHead">
	   			<h3>Basic Information</h3>
	   			<div class="seprator"></div>
	  		</div>

      		<div class="tab_form_fild_bg">
	   			<div class="row">

					<div class="col-md-6">
		 				<div class="radio_bg">
		  					<label>Are you currently retired?<span class="required_star">*</span></label>
		  					<div class="radio_list">
		   						<div class="form-check">
		  							<input type="radio" value="1" class="form-check-input r_u_retired_radio" <?php echo  isset($user_data->is_retired) && !is_null($user_data->is_retired)  && $user_data->is_retired == 1 ? 'checked = checked' : '' ;  ?> id="retireUnchecked" name="is_retired" required="true">
		  							<label class="form-check-label" for="retireUnchecked">Yes</label>
								</div>

		   						<div class="form-check">
		 							<input type="radio" value="0"  <?php echo  isset($user_data->is_retired) && !is_null($user_data->is_retired) && $user_data->is_retired == 0 ? 'checked = checked' : '' ;  ?> class="form-check-input r_u_retired_radio" id="retireUnchecked2" name="is_retired" required="true">
		 							<label class="form-check-label" for="retireUnchecked2">No</label>
								</div>
		  					</div>
		 				</div>
					</div>
					<div class="col-md-6">
		 				<div class="form-group form_fild_row">
		 					<label>Current Occupation (past if retired)</label> <span class="required_star">*</span>
	      					<input type="text" name="occupation" value="<?php echo !empty($user_data->occupation) ? $user_data->occupation : ''; ?>" class="form-control r_u_retired_text_input" placeholder="" required="true"/>
	     				</div>
					</div>
				</div>
	   			<div class="row">
	    			<div class="col-md-3">
		    			<?php

							// calculate bmi start

								$height_inches_cal = $user_data->height;
								$weight_cal = $user_data->weight;
								$bmi_cal = '' ;
								if(!empty($height_inches_cal) && !empty($weight_cal)){
								 	 $bmi_cal = ($weight_cal * 0.45) / (pow(($height_inches_cal*0.025), 2)) ;
								 	 $bmi_cal = round($bmi_cal, 1);
								}
							// calculate bmi end

					    	$hght_feet = '' ; $hght_inches = '' ;
					    	if(!empty($user_data->height)){
					    		$hght_feet = intval($user_data->height/12);
					    		$hght_inches = fmod($user_data->height, 12); //floatval($user_data->height%12) ;
					    	}

		    	   		?>
				 		<div class="form-group form_fild_row">
				  			<label>Height(ft)</label> <span class="required_star">*</span>
	        				<select class="form-control" name="height" required="true">
	        					<option value=""></option>
	        					<?php
	        						$curhght = 1;
	        						for($curhght ; $curhght<=7 ; $curhght++){
	        							echo "<option ".( is_numeric($hght_feet) && $hght_feet==$curhght? 'selected' : '')."  value=".$curhght.">".$curhght."</option>";
	        						}
	        					?>
		    				</select>
			     		</div>
					</div>
		 			<div class="col-md-3">
				 		<div class="form-group form_fild_row">
				  			<label>Height(in)</label> <span class="required_star">*</span>
							<select class="form-control" name="height_inches" required="true">
	        					<option value=""></option>
					        	<?php
					        		$curhght = 0;
					        		for($curhght ; $curhght<12 ; $curhght++){
					        			echo "<option ".( is_numeric($hght_inches) && $hght_inches==$curhght? 'selected' : '')."  value=".$curhght.">".$curhght."</option>";
					        		}
					        	?>
		    				</select>
			     		</div>
					</div>
					<div class="col-md-3">
			 			<div class="form-group form_fild_row">
		 					<label>Weight(lbs)</label> <span class="required_star">*</span>
	      					<input   type="number" pattern="[0-9]*" inputmode="numeric"  name="weight" value="<?php echo isset($user_data->weight) ? $user_data->weight : '' ;  ?>" class="form-control" placeholder="" required="true"/>
	     				</div>
					</div>
					<div class="col-md-3">
		 				<div class="form-group form_fild_row">
		 					<label>BMI</label>
	      					<input style="background: #ececec !important; " type="text" disabled readonly name="weight" value="<?php echo isset($user_data->bmi) ? $user_data->bmi : '' ;  ?>" class="form-control bmi_field" placeholder="" required="true"/>
	      					<input class="bmi_field" type="hidden" name="bmi" value="<?php echo !empty($user_data->bmi) ? $user_data->bmi : $bmi_cal ;  ?>">
	     				</div>
					</div>
				</div>

	   			<div class="row">

					<div class="col-md-6">
		 				<div class="form-group form_fild_row">
		 					<label>Sexual Orientation <span class="required_star">*</span> <a href="javascript:void(0)" data-toggle="tooltip" title="Sexual orientation can provide important health information for your doctor to make an accurate diagnosis."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
	      					<select class="form-control" name="sexual_orientation" required="true">
		   						<option value=""></option>
	 							<option <?php echo !is_null($user_data->sexual_orientation) && $user_data->sexual_orientation == 9 ? 'selected' : '' ;  ?> value="9">Prefer not to say </option>
							   	<option <?php echo !is_null($user_data->sexual_orientation) && is_numeric($user_data->sexual_orientation) && $user_data->sexual_orientation == 0 ? 'selected' : '' ;  ?> value="0">Heterosexual </option>
							   	<option <?php echo !is_null($user_data->sexual_orientation) && $user_data->sexual_orientation == 1 ? 'selected' : '' ;  ?> value="1">Homosexual </option>
							   	<option <?php echo !is_null($user_data->sexual_orientation) && $user_data->sexual_orientation == 2 ? 'selected' : '' ;  ?> value="2">Bisexual </option>
		  					</select>
		 				</div>
					</div>

					<div class="col-md-6">
		 				<div class="radio_bg">
		  					<label>Marital Status  <span class="required_star">*</span></label>
		  					<div class="radio_list">
		   						<div class="form-check">
		  							<input type="radio" value="1"   class="form-check-input" <?php echo  !is_null($user_data->marital_status)  && $user_data->marital_status == 1 ? 'checked = checked' : '' ;  ?> id="materialUnchecked" name="marital_status" required="true">
		  							<label class="form-check-label" for="materialUnchecked">Married</label>
								</div>

			   					<div class="form-check">
								 	<input type="radio" value="2"   <?php echo  !is_null($user_data->marital_status)   && $user_data->marital_status == 2 ? 'checked = checked' : '' ;  ?> class="form-check-input" id="materialUnchecked2" name="marital_status" required="true">
								 	<label class="form-check-label" for="materialUnchecked2">Divorced</label>
								</div>

		   						<div class="form-check">
								  	<input type="radio" value="0"   <?php echo  !is_null($user_data->marital_status)   &&  is_numeric($user_data->marital_status) &&  $user_data->marital_status == 0 ? 'checked = checked' : '' ;  ?> class="form-check-input" id="materialUnchecked3" name="marital_status" required="true">
								  	<label class="form-check-label" for="materialUnchecked3">Single</label>
								</div>
		  					</div>
		 				</div>
	   				</div>
	   			</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form_fild_row">
				 				<label>Address</label> <span class="required_star">*</span>
			      				<input type="text" name="address"   value="<?php echo !empty($user_data->address) ? $user_data->address : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div>
						<div class="col-md-2">
							<div class="form-group form_fild_row">
				 				<label>City</label> <span class="required_star">*</span>
			      				<input type="text" name="city"   value="<?php echo !empty($user_data->city) ? $user_data->city : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div>
						<div class="col-md-2">
							<div class="form-group form_fild_row">
				 				<label>State</label> <span class="required_star">*</span>
								<?php

								$state_options = array('Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'District Of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming', 'American Samoa', 'Guam', 'Northern Mariana Islands', 'Puerto Rico', 'United States Minor Outlying Islands', 'Virgin Islands');
								$state_options = array(
								"AL" => "Alabama",
								"AK" => "Alaska",
								"AZ" => "Arizona",
								"AR" => "Arkansas",
								"CA" => "California",
								"CO" => "Colorado",
								"CT" => "Connecticut",
								"DE" => "Delaware",
								"DC" => "District Of Columbia",
								"FL" => "Florida",
								"GA" => "Georgia",
								"HI" => "Hawaii",
								"ID" => "Idaho",
								"IL" => "Illinois",
								"IN" => "Indiana",
								"IA" => "Iowa",
								"KS" => "Kansas",
								"KY" => "Kentucky",
								"LA" => "Louisiana",
								"ME" => "Maine",
								"MD" => "Maryland",
								"MA" => "Massachusetts",
								"MI" => "Michigan",
								"MN" => "Minnesota",
								"MS" => "Mississippi",
								"MO" => "Missouri",
								"MT" => "Montana",
								"NE" => "Nebraska",
								"NV" => "Nevada",
								"NH" => "New Hampshire",
								"NJ" => "New Jersey",
								"NM" => "New Mexico",
								"NY" => "New York",
								"NC" => "North Carolina",
								"ND" => "North Dakota",
								"OH" => "Ohio",
								"OK" => "Oklahoma",
								"OR" => "Oregon",
								"PA" => "Pennsylvania",
								"RI" => "Rhode Island",
								"SC" => "South Carolina",
								"SD" => "South Dakota",
								"TN" => "Tennessee",
								"TX" => "Texas",
								"UT" => "Utah",
								"VT" => "Vermont",
								"VA" => "Virginia",
								"WA" => "Washington",
								"WV" => "West Virginia",
								"WI" => "Wisconsin",
								"WY" => "Wyoming",
								"AS" => "American Samoa",
								"GU" => "Guam",
								"MP" => "Northern Mariana Islands",
								"PR" => "Puerto Rico",
								"UM" => "United States Minor Outlying Islands",
								"VI" => "Virgin Islands"
								);
								?>

								<?php echo $this->Form->select('state', $state_options, ['default' =>  $user_data->state , 'class' => 'form-control', 'empty' => true,'required' => true]); ?>

			     			</div>
						</div>
						<div class="col-md-2">
							<div class="form-group form_fild_row">
				 				<label>Zip</label> <span class="required_star">*</span>
			      				<input   type="number" pattern="[0-9]*" inputmode="numeric"   name="zip"   value="<?php echo !empty($user_data->zip) ? $user_data->zip : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div>
					</div>

       				<div class="row">
	    				<div class="col-md-3">
		 					<div class="form-group form_fild_row">
		 						<label>Pay Method</label> <span class="required_star">*</span>
	      						<select name="guarantor" class="form-control guarantor" required="true">
	      							<option value="">Select Pay Method</option>
						      		<option value="self-pay" <?php if(!empty($user_data->guarantor) && $user_data->guarantor == 'self-pay'){ echo 'selected'; }?>>Self-pay</option>

						      		<option value="health insurance" <?php if(!empty($user_data->guarantor) && $user_data->guarantor == 'health insurance'){ echo 'selected'; }?>>Health Insurance</option>

						      	 	<option value="medicare" <?php if(!empty($user_data->guarantor) && $user_data->guarantor == 'medicare'){ echo 'selected'; }?>>Medicare</option>

						      	 	<option value="medicaid" <?php if(!empty($user_data->guarantor) && $user_data->guarantor == 'medicaid'){ echo 'selected'; }?>>Medicaid</option>

						      	 	<option value="others" <?php if(!empty($user_data->guarantor) && $user_data->guarantor == 'others'){ echo 'selected'; }?>>Others</option>
	      						</select>
		 					</div>
						</div>
						<?php $insurance_company = !empty($user_data->insurance_company) ? Security::decrypt(base64_decode($user_data->insurance_company), SEC_KEY):""; ?>
						<div class="col-md-3">
		 					<div class="form-group form_fild_row insurance_company_div">
		 						<label>Insurance company</label> <span class="required_star">*</span>
	      						<input type="text" name="insurance_company"   value="<?php echo $insurance_company;  ?>" class="form-control insurance_company" placeholder="" required="true"/>
		 					</div>
						</div>

						<script type="text/javascript">
							$(document).ready(function(){

								var guarantor = $('.guarantor').val();

								if(guarantor == 'health insurance'){

									$('.insurance_company_div').css('display','block');
								}else{

									$('.insurance_company_div').css('display','none');
								}

								$('.guarantor').on('change',function(){

									var guarantor = $(this).val();
									if(guarantor == 'health insurance'){

										$('.insurance_company_div').css('display','block');
									}else{

										$('.insurance_company_div').css('display','none');
									}
								})
							})
						</script>

	    				<div class="col-md-3">
		 					<div class="form-group form_fild_row">
		 						<label>Ethnicity <span class="required_star">*</span> <a href="javascript:void(0)" data-toggle="tooltip" title="Some medical conditions can be related to ethnicity and provides additional information for your doctor to make an accurate diagnosis."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
	      						<select class="form-control" name="ethinicity" required="true">
	      							<option value=""></option>
									<option <?php echo !is_null($user_data->ethinicity) && $user_data->ethinicity == 9 ? 'selected' : '' ;  ?> value="9">Prefer not to say </option>
								   <option <?php echo !is_null($user_data->ethinicity) && is_numeric($user_data->ethinicity) &&  $user_data->ethinicity == 0 ? 'selected' : '' ;  ?> value="0">Asian</option>
								   <option  <?php echo !is_null($user_data->ethinicity) && $user_data->ethinicity == 1 ? 'selected' : '' ;  ?> value="1">Caucasian</option>
								   <option  <?php echo !is_null($user_data->ethinicity) && $user_data->ethinicity == 2 ? 'selected' : '' ;  ?> value="2">Hispanic</option>
								   <option  <?php echo !is_null($user_data->ethinicity) && $user_data->ethinicity == 3 ? 'selected' : '' ;  ?> value="3">Pacific</option>
								   <option  <?php echo !is_null($user_data->ethinicity) && $user_data->ethinicity == 4 ? 'selected' : '' ;  ?> value="4">Native American</option>
								   <option  <?php echo !is_null($user_data->ethinicity) && $user_data->ethinicity == 5 ? 'selected' : '' ;  ?> value="5">African American</option>
		  						</select>
		 					</div>
						</div>

						<div class="col-md-3">
							<div class="form-group form_fild_row">
				 				<label>Preferred Pharmacy</label><span class="required_star">*</span>
			      				<input type="text" name="pharmacy"   value="<?php echo !empty($user_data->pharmacy) ? $user_data->pharmacy : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div>
						<div class="col-md-6">
		 					<div class="radio_bg">
		  						<label>Race <span class="required_star">*</span></label>
	  							<div class="radio_list">
	   								<div class="form-check">
									  	<input type="radio"   data-error="#errRace"  value="1" class="form-check-input race_radio" <?php echo  isset($user_data->race) && !is_null($user_data->race)  && $user_data->race == 1 ? 'checked = checked' : '' ;  ?> id="raceUnchecked" name="race" required="true">
									  	<label class="form-check-label" for="raceUnchecked">Hispanic</label>
									</div>

	   								<div class="form-check">
	 									<input type="radio"  data-error="#errRace"  value="0"  <?php echo  isset($user_data->race) && !is_null($user_data->race) && is_numeric($user_data->race) &&  $user_data->race == 0 ? 'checked = checked' : '' ;  ?> class="form-check-input race_radio" id="raceUnchecked2" name="race" required="true">
	 									<label class="form-check-label" for="raceUnchecked2">Non hispanic</label>
									</div>
	  							</div>
		 					</div>
						</div>
					<!-- 	<div class="col-md-3">
		 					<div class="form-group form_fild_row">
		 						<label>Insurance Type <span class="required_star">*</span> <a href="javascript:void(0)" data-toggle="tooltip" title="Some medical conditions can be related to ethnicity and provides additional information for your doctor to make an accurate diagnosis."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
	      						<select class="form-control insuranceType" name="insuranceType" required="true">
	      						   <option value=""></option>									
								   <option <?php echo !is_null($user_data->insuranceType) &&  $user_data->insuranceType == 'medicare' ? 'selected' : '' ;  ?> value="medicare">Medicare</option>
								   <option  <?php echo !is_null($user_data->insuranceType) && $user_data->insuranceType == 'commercial' ? 'selected' : '' ;  ?> value="commercial">Commercial</option>
		  						</select>
		 					</div>
						</div> -->
						
					<!-- 	<div class="col-md-3">
							<div class="form-group form_fild_row subscriber_name_div">
				 				<label>Subscriber Name</label> <span class="required_star">*</span>
			      				<input type="text" name="subscriberName" id="subscriberName" value="<?php echo !empty($user_data->subscriberName) ? $user_data->subscriberName : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div>
						<div class="col-md-3">
							<div class="form-group form_fild_row identification_number_div">
				 				<label>Identification Number</label> <span class="required_star">*</span>
			      				<input type="number" name="identificationNumber" id="identificationNumber" value="<?php echo !empty($user_data->identificationNumber) ? $user_data->identificationNumber : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div>
						<div class="col-md-3">
							<div class="form-group form_fild_row group_number_div">
				 				<label>Group Number</label> <span class="required_star">*</span>
			      				<input type="number" name="groupNumber" id="groupNumber"  value="<?php echo !empty($user_data->groupNumber) ? $user_data->groupNumber : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div>
						<div class="col-md-3">
							<div class="form-group form_fild_row insurance_comp_div">
				 				<label>Insurance Company</label> <span class="required_star">*</span>
			      				<input type="text" name="insuranceCompany" id="insuranceCompany"   value="<?php echo !empty($user_data->insuranceCompany) ? $user_data->insuranceCompany : '';  ?>" class="form-control" placeholder="" required="true"/>
			     			</div>
						</div> -->

	   				</div>
					<div class="back_next_button">
	    				<ul>
		 					<li>
		 						<button type="submit" name="tab_number" value="1" class="btn">Next</button>
	     					</li>
						</ul>
	   				</div>
					<script type="text/javascript">
						$(document).ready(function(){

							$('input[name=weight], select[name=height_inches], select[name=height]').on('change keyup', function() {

								var height_inches = (parseFloat($('select[name=height]').val()) * 12) + parseFloat($('select[name=height_inches]').val());
								var weight = parseFloat($('input[name=weight]').val());


							 	var bmi = (weight * 0.45) / (Math.pow((height_inches*0.025), 2)) ;

							 	if(!isNaN(bmi)) {
							 		$('.bmi_field').val(bmi.toFixed(1));
							 	}else{
							 		$('.bmi_field').val('');
							 	}
							});

    						$('[data-toggle="tooltip"]').tooltip();  // for tool tip

							$("#basic_info_btn").click(function(){

							    $("#profile-tab").trigger("click");

								$('#checkmedical').val(1);

							    window.location = "#profile-tab";
							});
						});
	   				</script>
	  			</div>
	 		</div>
	 <?php $this->Form->end() ; ?>
	<script type="text/javascript">

	 	$("#form_tab_1").validate({

			ignore: ':hidden:not(.do_not_ignore)',
		  	showErrors: function(errorMap, errorList) {
	  		  	if(errorList.length>0){
	        		$("#form_tab_1 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
	    		}
		 	},
		 	submitHandler: function(form) {
            formsubmit(form);

        }
		});
	</script>

<?php } ?>


    <?php

    if($active_tab == 2){ //pr($$user_data->is_check_med_his); die; 

		echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_2')); ?>


	<div class="tab-pane fade   <?= $active_tab == 2 ? '  show active ' : '' ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		<div class="errorHolder">
  		</div>
	  	<div class="TitleHead">
	   		<h3>Medical History</h3>
	   		<div class="seprator"></div>
	  	</div>

		<!-- first ask question about any medical history is there start -->
		<div class="tab_form_fild_bg">
			<div class="row">
		   		<div class="col-md-12">
					<div class="form-group form_fild_row">
	         			<label>Do you have any past medical conditions? </label>   <span class="required_star">*</span>
			 			<div class="radio_list">
			   				<div class="form-check">
			    				<input type="radio"  <?php echo !is_null($user_data->is_check_med_his) && $user_data->is_check_med_his == 1 ? 'checked' : '' ?>     value="1"  class="form-check-input is_check_med_his" name="is_check_med_his"  id="is_check_med_his1" required = 'true'>
			    				<label class="form-check-label" for="is_check_med_his1">Yes</label>
			   				</div>

			  				<div class="form-check">
			    				<input type="radio"     value="0"  <?php echo !is_null($user_data->is_check_med_his) && is_numeric($user_data->is_check_med_his) && $user_data->is_check_med_his == 0 ? 'checked' : '' ?>  class="form-check-input is_check_med_his" name="is_check_med_his"  id="is_check_med_his2" required = 'true' >
			    				<label class="form-check-label" for="is_check_med_his2">No</label>
			  				</div>
		     			</div>
					</div>
		  		</div>
			</div>
	  	</div>
		<!-- first ask question about any medical history is there end -->

      <div class="tab_form_fild_bg is_check_med_his_div <?php if(is_null($user_data->is_check_med_his) || $user_data->is_check_med_his == 0 ) echo 'on_load_display_none_cls'; ?>">

			<?php
			if(!empty($user_data->medical_history)) {

				$tempmedical_history = unserialize( (Security::decrypt(base64_decode($user_data->medical_history), SEC_KEY)) );
				
				$old_medical_suggestion_name = array();


				if(!empty($tempmedical_history)){
				foreach($tempmedical_history as $k => $v) {

					$old_medical_suggestion_name[] = $v['name'];
			?>

	   		<div class="row  medicalhistoryfld">
	    		<div class="col-md-6">
		 			<div class="form-group form_fild_row">

	      				<label>Condition</label>
		 				<div class="custom-drop">
							<input type="text" id="medical_<?php echo $k?>" value="<?php echo  $v['name'] ?>"  class="form-control  medicalcondbox medical_suggestion" name="medical_history[name][]" placeholder=""/>
	      					<ul class="medical_suggestion_listul custom-drop-li">
							</ul>
						</div>
	     			</div>
				</div>
				<div class="col-md-6">
	     			<div class="row">
		  				<div class="col-md-7">
		   					<div class="form-group form_fild_row">
		   						<label>Year Diagnosed</label>
	        					<select class="form-control" name="medical_history[year][]">
	        						<option value=""></option>
	       							<option <?php echo  $v['year']==1 ? 'selected' : '' ;  ?> value="1">Childhood</option>
						        	<?php
						        		$curyear = $curyearlast;

						        		for($curyear ; $curyear>= $start_year ; $curyear--){
						        			echo "<option ".($v['year']==$curyear? 'selected' : '')."  value=".$curyear.">".$curyear."</option>";
						        		}
						        	?>
		    					</select>
		   					</div>
		 				</div>
		  				<div class="col-md-5 medicalhistoryfldtimes">
		   					<div class="crose_year">
		    					<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   					</div>
		  				</div>
		 			</div>
				</div>
	   		</div>
		<?php }
	}

	} ?>
	   	<div class="row medicalhistoryfld on_load_display_none_cls">
	    	<div class="col-md-6 ">
		 		<div class="form-group form_fild_row">
	      			<label>Condition</label>
		    		<div class="custom-drop">
						<input type="text"  value="test" disabled class="form-control  medicalcondbox medical_suggestion" name="medical_history[name][]" placeholder=""/>

	      				<ul class="medical_suggestion_listul custom-drop-li">
						</ul>
					</div>
	     		</div>
			</div>

			<div class="col-md-6">
	     		<div class="row">
		  			<div class="col-md-7 ">
		   				<div class="form-group form_fild_row">
		   					<label>Year Diagnosed</label>
	        				<select class="form-control" disabled name="medical_history[year][]">
	        					<option value=""></option>
	     						<option  value="1">Childhood</option>
					        	<?php

					        		$curyear = $curyearlast;
					        		for($curyear ; $curyear>= $start_year ; $curyear--){
					        			echo "<option value=".$curyear.">".$curyear."</option>";
					        		}
					        	?>
		    				</select>
		   				</div>
		  			</div>

		  			<div class="col-md-5 medicalhistoryfldtimes ">
		   				<div class="crose_year">
		    				<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   				</div>
		  			</div>
		 		</div>
			</div>
	   	</div>

	   	<div class="row">
	    	<div class="col-md-6">
		 		<div class="form-group form_fild_row">
					<div class=" medicalhistoryfldadd">
		   				<div class="crose_year">
		    				<button  type="button"  class="btn btn-medium">Add a condition</button>
		   				</div>
		 			</div>
		 		</div>
			</div>
		</div>

<script type="text/javascript">

$(document).ready(function() {
 $(document).on("click",".medicalhistoryfldadd button",function() {

		var cloneob = $( ".medicalhistoryfld:last" ).clone();
		$( cloneob ).find('input').each(function() {
							$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
							$(this).removeAttr('disabled');
							  $(this).val('');
							    });

			$( cloneob ).find('select').each(function() {
							$(this).removeAttr('disabled');
							  $(this).val('');
							    });


		$( cloneob ).insertAfter( ".medicalhistoryfld:last" );


	});
 $(document).on("click",".medicalhistoryfldtimes button",function() {

 	var remove_medical = $(this).parents('.medicalhistoryfld').find('.medical_suggestion').val();
 	var flag = false;
 	$(this).parents('.medicalhistoryfld').remove();



 	$('.medical_suggestion').each(function(){

 		if(remove_medical == $(this).val()){

 			flag = true;
 		}
 		console.log($(this).val());
 	});

 	if(!flag){

 		$('.medicalcondboxdiv button').each(function(){

 			var attr = $(this).attr('condval');
 			if(remove_medical == attr){

 				$(this).removeClass('selected_chief_complaint');
 			}
 		})
 	}

 });

// ajax search for medical suggestion start


searchRequest = null;
$(document).on("keyup click", ".medical_suggestion", function () {


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
                url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
                data: {
                	'search_type' : 1, // 1 for searching medical  condition
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                	// alert(msg);
                	var msg = JSON.parse(msg);
                	 console.log(msg);
                	var temphtml = '' ;
                	$.each(msg, function(index, element) {
                		temphtml += '<li medical_suggestion_attr ="'+element+'" >'+element+'</li>' ;

					});
					console.log(temphtml);
					console.log(curele);
					$(curele).next('.medical_suggestion_listul').html(temphtml);

                    //we need to check if the value is the same

                }
            });

    });




$(document).on("click", ".medical_suggestion_listul li", function () {

	var diag_sugg_atr = $(this).attr('medical_suggestion_attr');

	var tmptext = $(this).parents('.medical_suggestion_listul').prev('.medical_suggestion');
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

	$(this).parents('.medical_suggestion_listul').empty();

});


//  ajax search for medical suggestion  end

});

</script>
		<div class="common_conditions_button  medicalcondboxdiv">
	    	<h4>Common conditions</h4>
			<ul>

				<?php
					$i = 0 ;
					foreach ($common_medical_cond as $key => $value) {

				?>
				  <li class="active medicalcondbottom">
							<button  type="button"  condid="<?= $key ?>" condval="<?= $value ?>"  class="btn <?php if(isset($old_medical_suggestion_name) && !empty($old_medical_suggestion_name) && in_array($value, $old_medical_suggestion_name)) { echo 'selected_chief_complaint'; }?>">
								<i class="fas fa-plus-circle"></i>
								<span><?= $value ?></span>
							</button>
					</li>
				<?php
					$i++;
					}
				?>
			</ul>
	   	</div>

	   	<script type="text/javascript">

		/*$(document).ready(function(){
			$("#medical_back_btn").click(function(){

			    $("#home-tab").trigger("click");

$('#checkbasic').val(1);

			      window.location = "#home-tab";
			});
			$("#medical_next_btn").click(function(){
			    $("#contact-tab").trigger("click");
			    $('#checksurgical').val(1);
			     window.location = "#contact-tab";
			});
		});*/

	   	</script>


	  </div>

	   <div class="back_next_button">
	    <ul>
		 <li>
		  <button id="home-tab-backbtn" type="button" class="btn">Back</button>
	     </li>
		  <li>
		 <button type="submit"  name="tab_number" value="2"  class="btn">Next</button>
	     </li>
		</ul>
	   </div>



	 </div>


<script type="text/javascript">
	$(document).ready(function() {



$(document).on("change", "input[type='radio'].is_check_med_his", function () {

   if($(this).is(':checked')) {

        if ($(this).val() == 0) {

        	$('.is_check_med_his_div').css( "display", "none" );
        }else{
        	$('.is_check_med_his_div').removeClass('on_load_display_none_cls');
        	$('.is_check_med_his_div').css( "display", "block" );
        }
    }
 });


 $(document).on("click",".medicalcondboxdiv button",function() {
 	var  index = $(this).attr('condval');
 	var flag = true;
	$('input.medicalcondbox').each(function(i, obj) {
	    if($(obj).val()===""){
	    	flag = false;
	    	$(obj).val(index);
	    	return false;
	    }
	});
	if(flag){
		$( ".medicalhistoryfldadd button" ).trigger( "click" );
		$('input.medicalcondbox').each(function(i, obj) {
		    if($(obj).val()===""){
		    	$(obj).val(index);
		    	return false;
		    }
		});

	}

	$(this).addClass('selected_chief_complaint');

		 });
 	});


</script>


<?php $this->Form->end() ; ?>
	<script type="text/javascript">

	 	$("#form_tab_2").validate({

			ignore: ':hidden:not(.do_not_ignore)',
		  	showErrors: function(errorMap, errorList) {
		  			console.log(errorList);
		  		  	if(errorList.length>0){
		        		$("#form_tab_2 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
		    		}
		 	},
		 	submitHandler: function(form) {
            formsubmit(form);

        }

		});
	 </script>

<?php } ?>

    <?php

    if($active_tab == 3){

		echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_3')); ?>

	<div class="tab-pane fade   <?= $active_tab == 3 ? '  show active ' : '' ?>" id="contact" role="tabpanel" aria-labelledby="contact-tab">
		<div class="errorHolder"></div>
	  	<div class="TitleHead">
	   		<h3>Surgical History</h3>
	   		<div class="seprator"></div>
	  	</div>

		<!-- first ask question about any surgical history is there start -->
		<div class="tab_form_fild_bg">
			<div class="row">
		   		<div class="col-md-12">
					<div class="form-group form_fild_row">
	         			<label>Do you have any past surgeries? </label>   <span class="required_star">*</span>
			 			<div class="radio_list">
			   				<div class="form-check">
			    				<input type="radio"  <?php echo !is_null($user_data->is_check_surg_his) && $user_data->is_check_surg_his == 1 ? 'checked' : '' ?>     value="1"  class="form-check-input is_check_surg_his" name="is_check_surg_his"  id="is_check_surg_his1" required = "true">
			    				<label class="form-check-label" for="is_check_surg_his1">Yes</label>
			   				</div>
			   				<div class="form-check">
			    				<input type="radio"     value="0"  <?php echo !is_null($user_data->is_check_surg_his) && is_numeric($user_data->is_check_surg_his) &&  $user_data->is_check_surg_his == 0 ? 'checked' : '' ?>  class="form-check-input is_check_surg_his" name="is_check_surg_his"  id="is_check_surg_his2" required = "true">
			    				<label class="form-check-label" for="is_check_surg_his2">No</label>
			  				</div>
		     			</div>
					</div>
		  		</div>
			</div>
	  	</div>
		<!-- first ask question about any surgical history is there end -->
   		<?php   if($user_data->gender == 0 && empty($check_surgical_allergy['checksurgical'])) {  ?>
	  		<div class="tab_form_fild_bg   is_check_surg_his_div  <?php if(is_null($user_data->is_check_surg_his) || $user_data->is_check_surg_his == 0 ) echo 'on_load_display_none_cls '; ?>  ">
					<div class="row">
		   				<div class="col-md-12">
							<div class="form-group form_fild_row">
	         					<label> Do you have surgical history of uterus removal (hysterectomy)? <span class="required_star">*</span></label>
			 					<div class="radio_list">
			   						<div class="form-check">
			    						<input type="radio" <?php echo !is_null($user_data->is_uterus_removal) && $user_data->is_uterus_removal == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input is_uterus_removal" name="is_uterus_removal"  id="is_uterus_removal1" required="true">
			    						<label class="form-check-label" for="is_uterus_removal1">Yes</label>
			   						</div>

			   						<div class="form-check">
			    						<input type="radio"  <?php echo  !is_null($user_data->is_uterus_removal) &&  is_numeric($user_data->is_uterus_removal) &&   $user_data->is_uterus_removal == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input is_uterus_removal" name="is_uterus_removal"  id="is_uterus_removal2" required="true">
			    						<label class="form-check-label" for="is_uterus_removal2">No</label>
			  						</div>
		     					</div>
							</div>
		  				</div>
					</div>
	  			</div>
			<?php } ?>
      		<div class="tab_form_fild_bg is_check_surg_his_div  <?php if(is_null($user_data->is_check_surg_his) || $user_data->is_check_surg_his == 0 ) echo 'on_load_display_none_cls '; ?> ">

				<?php
				if(!empty($user_data->surgical_history)) {

					$tempmedical_history = unserialize((Security::decrypt(base64_decode($user_data->surgical_history), SEC_KEY)) );

					$old_sergical_con_arr = array();
					foreach($tempmedical_history as $k => $v) {
						$old_sergical_con_arr[] = $v['name'];
				?>

	   					<div class="row surgicalhistoryfld">
	    					<div class="col-md-6">
		 						<div class="form-group form_fild_row">
	      							<label>Surgery</label>
 									<div class="custom-drop">
										<input type="text" id="surguryId_<?php echo $k ?>" value="<?php echo  $v['name'] ?>"  class="form-control  surgicalcondbox surgical_suggestion" name="surgical_history[name][]" placeholder=""/>
	      								<ul class="surgical_suggestion_listul  custom-drop-li">
										</ul>
									</div>
	     						</div>
							</div>

							<div class="col-md-6">
	     						<div class="row">
		  							<div class="col-md-7">
		   								<div class="form-group form_fild_row">
		   									<label>Year performed</label>
	        								<select class="form-control"  name="surgical_history[year][]">
	        									<option value=""></option>
     											<option <?php echo  $v['year']==1 ? 'selected' : '' ;  ?> value="1">Childhood</option>
									        	<?php

									        		$curyear = $curyearlast;
									        		for($curyear ; $curyear>= $start_year ; $curyear--){
									        			echo "<option  ".($v['year']==$curyear? 'selected' : '')."   value=".$curyear.">".$curyear."</option>";
									        		}
									        	?>
		    								</select>
		   								</div>
		  							</div>

		  							<div class="col-md-5 surgicalhistoryfldtimes">
		   								<div class="crose_year">
		    								<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   								</div>
		  							</div>
		 						</div>
							</div>
	   					</div>
					<?php } } ?>
	   				<div class="row surgicalhistoryfld  on_load_display_none_cls">
	    				<div class="col-md-6">
		 					<div class="form-group form_fild_row">
	      						<label>Surgery</label>
 								<div class="custom-drop">
									<input type="text"   class="form-control  surgicalcondbox surgical_suggestion" name="surgical_history[name][]"  value="test" disabled placeholder=""/>
	      							<ul class="surgical_suggestion_listul  custom-drop-li">
									</ul>
								</div>
	     					</div>
						</div>

						<div class="col-md-6">
	     					<div class="row">
		  						<div class="col-md-7">
		   							<div class="form-group form_fild_row">
		   								<label>Year performed</label>
        								<select class="form-control " disabled name="surgical_history[year][]">
        									<option value=""></option>
											<option  value="1">Childhood</option>
								        	<?php
								     			$curyear = $curyearlast;
									        	for($curyear ; $curyear>= $start_year ; $curyear--){
									        		echo "<option value=".$curyear.">".$curyear."</option>";
									        	}
								        	?>
	    								</select>
		   							</div>
		  						</div>
		  						<div class="col-md-5 surgicalhistoryfldtimes">
		   							<div class="crose_year">
		    							<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   							</div>
		  						</div>
		 					</div>
						</div>
	   				</div>

					<div class="row">
	    				<div class="col-md-6">
		 					<div class="form-group form_fild_row">
								<div class=" surgicalhistoryfldadd">
		   							<div class="crose_year">
		    							<button  type="button"  class="btn btn-medium">Add a surgery</button>
		   							</div>
		  						</div>
		 					</div>
						</div>
					</div>

<script type="text/javascript">

$(document).ready(function() {
 $(document).on("click",".surgicalhistoryfldadd button",function() {

		var cloneob = $( ".surgicalhistoryfld:last" ).clone();
		$( cloneob ).find('input').each(function() {
				$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
				$(this).removeAttr('disabled');
							  $(this).val('');
							    });

			$( cloneob ).find('select').each(function() {
							$(this).removeAttr('disabled');
							  $(this).val('');
							    });

		$(cloneob).insertAfter( ".surgicalhistoryfld:last" );


	});
 $(document).on("click",".surgicalhistoryfldtimes button",function() {

 if($(this).parents('.surgicalhistoryfld').find('input.surgicalcondbox').val().trim() == "Uterus removal (hysterectomy)") {
		$("input[value='0'].is_uterus_removal").prop("checked", true); // if user removes Uterus removal (hysterectomy) then uncheck
 	}
 	var remove_val = $(this).parents('.surgicalhistoryfld').find('input.surgicalcondbox').val().trim();
 	var flag = false;
 	$(this).parents('.surgicalhistoryfld').remove();

 	$('.surgical_suggestion').each(function(){

 		if(remove_val == $(this).val()){

 			flag = true;
 		}
 		//console.log($(this).val());
 	});

 	if(!flag){

 		$('.surgicalcondboxdiv button').each(function(){

 			var attr = $(this).attr('condval');
 			if(remove_val == attr){

 				$(this).removeClass('selected_chief_complaint');
 			}
 		})
 	}

 });



// ajax search for surgery suggestion start


searchRequest = null;
$(document).on("keyup click", ".surgical_suggestion", function () {


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
                url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
                data: {
                	'search_type' : 2, // 2 for searching surgical condition
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                	var msg = JSON.parse(msg);
                	var temphtml = '' ;
                	$.each(msg, function(index, element) {
                		temphtml += '<li surgical_suggestion_attr ="'+element+'" >'+element+'</li>' ;

					});
					console.log(temphtml);
					console.log(curele);
					$(curele).next('.surgical_suggestion_listul').html(temphtml);

                    //we need to check if the value is the same

                }
            });

    });


$(document).on("click", ".surgical_suggestion_listul li", function () {

	var diag_sugg_atr = $(this).attr('surgical_suggestion_attr');

	var tmptext = $(this).parents('.surgical_suggestion_listul').prev('.surgical_suggestion');
	var ttext = $(tmptext).val();

	if((ttext.indexOf('Uterus removal (hysterectomy)') != -1) || diag_sugg_atr.trim() == 'Uterus removal (hysterectomy)' )
		$("input[value='1'].is_uterus_removal").prop("checked", true); // check the radio button if user chooses Uterus removal (hysterectomy)
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

	$(this).parents('.surgical_suggestion_listul').empty();

});


//  ajax search for surgery suggestion  end



$(document).on("change", "input[type='radio'].is_uterus_removal", function () {

    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
				$('input.surgicalcondbox').each(function(i, obj) {
				    if($(obj).val().trim() == "Uterus removal (hysterectomy)"){
				    	$(this).parents('.surgicalhistoryfld').remove();
				    }
				});
        }else{
        	 $(".surgicalhistoryfldadd button").trigger("click");

        	 $(".surgicalhistoryfld:last").find('input.surgicalcondbox').val("Uterus removal (hysterectomy)") ;
        }
    }
});
});

</script>
<div class="common_conditions_button  surgicalcondboxdiv">
	<h4>Common surgeries</h4>
	<ul>

		<?php
		$i = 0 ;
		foreach ($common_surgical_cond as $key => $value) {


		?>
		  <li class="active medicalcondbottom">
				 <button  type="button"  condid="<?= $key ?>" condval="<?= $value ?>"  class="btn <?php if(isset($old_sergical_con_arr) && !empty($old_sergical_con_arr) && in_array($value, $old_sergical_con_arr)) { echo 'selected_chief_complaint'; }?>">
					 <i class="fas fa-plus-circle"></i>
					 <span><?= $value ?></span>
				 </button>
		 </li>
		<?php
		$i++;
		}
		?>
    </ul>
</div>

<script type="text/javascript">

		/*$(document).ready(function(){
			$("#surgical_back_btn").click(function(){
			    $("#profile-tab").trigger("click");


$('#checkmedical').val(1);

			     window.location = "#profile-tab";
			});
			$("#surgical_next_btn").click(function(){
			    $("#family-tab").trigger("click");
			    $('#checkfamily').val(1);
			    window.location = "#family-tab";
			});
		});
*/
	   	</script>

	  </div>


	<div class="back_next_button">
	    <ul>
		 	<li>
		  		<button id="profile-tab-backbtn" type="button" class="btn">Back</button>
	     	</li>
	     	<li>
		 		<button type="submit"  name="tab_number" value="3"  class="btn">Next</button>
	     	</li>
		</ul>
	</div>

</div>


<script type="text/javascript">
	$(document).ready(function() {




$(document).on("change", "input[type='radio'].is_check_surg_his", function () {

   if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        	$('.is_check_surg_his_div').css( "display", "none" );
        }else{
        	$('.is_check_surg_his_div').removeClass('on_load_display_none_cls');
        	$('.is_check_surg_his_div').css( "display", "block" );
        }
    }



 });


 $(document).on("click",".surgicalcondboxdiv button",function() {
 	var  index = $(this).attr('condval');
 	var flag = true;
	$('input.surgicalcondbox').each(function(i, obj) {
	    if($(obj).val()===""){
	    	flag = false;
	    	$(obj).val(index);
	    	return false;
	    }
	});
	if(flag){
		$( ".surgicalhistoryfldadd button" ).trigger( "click" );
		$('input.surgicalcondbox').each(function(i, obj) {
		    if($(obj).val()===""){
		    	$(obj).val(index);
		    	return false;
		    }
		});

	}
	$(this).addClass('selected_chief_complaint');

		 });
 	});


</script>


<?php $this->Form->end() ; ?>
<script type="text/javascript">

 	$("#form_tab_3").validate({

		ignore: ':hidden:not(.do_not_ignore)',
	  	showErrors: function(errorMap, errorList) {
  		  	if(errorList.length>0){
        		$("#form_tab_3 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
    		}
	 	},
	 	submitHandler: function(form) {
            formsubmit(form);

        }
	});
</script>

<?php } ?>

	<?php

	if($active_tab == 4){

		echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_4')); ?>



	 			<div class="tab-pane fade   <?= $active_tab == 4 ? '  show active ' : '' ?>" id="family" role="tabpanel" aria-labelledby="family-tab">
	 				<div class="errorHolder"></div>
	  				<div class="TitleHead">
	   					<h3>Family History</h3>
	   					<h6 style="text-align: left;">Do not include step-relatives.</h6>
	   					<div class="seprator"></div>
	  				</div>
					<!-- first ask question about any medical history is there start -->

					<div class="tab_form_fild_bg">
						<div class="row">
		   					<div class="col-md-12">
								<div class="form-group form_fild_row">
	         						<label>Do any of your family members have past medical conditions? </label>   <span class="required_star">*</span>
			 						<div class="radio_list">
			   							<div class="form-check">
			    							<input type="radio"  <?php echo !is_null($user_data->is_family_his) && $user_data->is_family_his == 1 ? 'checked' : '' ?>     value="1"  class="form-check-input is_family_his" name="is_family_his"  id="is_family_his1" required = "true" >
			    							<label class="form-check-label" for="is_family_his1">Yes</label>
			   							</div>

			   							<div class="form-check">
			    							<input type="radio"     value="0"  <?php echo !is_null($user_data->is_family_his) && is_numeric($user_data->is_family_his) && $user_data->is_family_his == 0 ? 'checked' : '' ?>  class="form-check-input is_family_his" name="is_family_his"  id="is_family_his2" required = "true">
			    							<label class="form-check-label" for="is_family_his2">No</label>
			  							</div>
		     						</div>
								</div>
		  					</div>
						</div>
	  				</div>
					<!-- first ask question about any medical history is there end -->
      				<div class="tab_form_fild_bg   is_family_his_div <?php if(is_null($user_data->is_family_his) || $user_data->is_family_his == 0 ) echo 'on_load_display_none_cls'; ?>">

						<?php

						$family_relation = [1=>'Father', 2=>'Mother', 3=>'Grandmother (Dad-side)', 4=>'Grandfather (Dad-side)', 5=>'Grandmother (Mom-side)',
						 6=>'Grandfather (Mom-side)', 7=>'Brother', 8=>'Sister', 9=>'Son', 10=>'Daughter',11 =>"Cousin(mom's side)",12 =>"Cousin(dad's side)",13 =>"Aunt(mom's side)",14 =>"Aunt(dad's side)",15=>"Uncle(mom's side)",16 =>"Uncle(dad's side)"];
							$j = 0;

							if(!empty($user_data->family_history)) {

								$tempmedical_history = unserialize((Security::decrypt(base64_decode($user_data->family_history), SEC_KEY)));


								foreach($tempmedical_history as $k => $v) {

						?>
	   								<div class="row familyhistoryfld">
	    								<div class="col-md-4">
		 									<div class="form-group form_fild_row">
	      										<label>Family Member</label>
	        									<select class="form-control " name="family_history[name][]">
	        										<option value=""></option>
										        	<?php
										        		foreach ($family_relation as $fkey => $fvalue) {
										        	?>
										        		<option <?= $fkey==$v['name'] ? 'selected' : '' ?> value="<?= $fkey ?>"><?= $fvalue ?></option>
										        	<?php
										        		}
										        	?>
	        									</select>
	     									</div>
        									<div class="form-group form_fild_row">
        										<label>Alive Status</label>
	 											<div class="radio_list">
	   												<div class="form-check">
	    												<input type="radio"  <?php echo isset($v['alive_status']) && $v['alive_status'] == 1 ? 'checked = checked' : '' ;  ?>  value="1" class="form-check-input alive_disease_radio" id="alive<?= $j ?>" name="family_history[alive_status][<?= $j ?>]">
	    												<label class="form-check-label" for="alive<?= $j ?>">Alive</label>
	   												</div>

		   											<div class="form-check">
													    <input type="radio"   <?php echo isset($v['alive_status']) &&  is_numeric($v['alive_status']) &&  $v['alive_status'] == 0 ? 'checked = checked' : '' ;  ?>   value="0" class="form-check-input alive_disease_radio" id="descase<?= $j ?>" name="family_history[alive_status][<?= $j ?>]">
													    <label class="form-check-label" for="descase<?= $j ?>">Deceased</label>
		  											</div>
     											</div>
											</div>
										</div>

										<div class="col-md-8">
	     									<div class="row">
		  										<div class="col-md-9">
	      											<div class="form-group form_fild_row">
	       												<label>Medical Conditions</label>
 														<div class="custom-drop">

															<input type="text" value="<?php echo isset($v['disease']) && !empty($v['disease'])? $v['disease']: '';  ?>" class="form-control prev_diagnose_suggestion" name="family_history[disease][]"  data-role="tagsinput"  placeholder=""/>
														    <ul class="prev_diagnose_suggestion_listul  custom-drop-li">
															</ul>
														</div>
	      											</div>

 													<div class="form-group form_fild_row">
														<!-- deceased specific control -->
	    												<div class="deceased_specific_control"  style="display:<?php echo isset($v['alive_status']) && $v['alive_status'] == 0 ? 'block' : 'none';  ?>;">
	    													<div class="row">
	   															<div class="col-md-4">
		 															<div class="form-group form_fild_row">
																       	<label>Age at death</label>
																        <select class="form-control" name="family_history[decease_year][<?= $j ?>]" >
																        	<option value=""></option>
																        	<option <?php echo  isset($v['decease_year']) && is_numeric ($v['decease_year']) && $v['decease_year']==911 ? 'selected' : '' ;  ?> value="911">Don't know</option>
      																		<option <?php echo  isset($v['decease_year']) && is_numeric ($v['decease_year'])  && $v['decease_year']==999 ? 'selected' : '' ;  ?> value="999">Childhood</option>
																        	<?php

																        	for($dece = 0 ; $dece <= 110 ; $dece++){

																        		echo "<option  ".(isset($v['decease_year']) && is_numeric ($v['decease_year'])  && $v['decease_year']==$dece? 'selected' : '')."  value=".$dece.">".$dece."</option>";
																        	}
																        	?>
		    															</select>
	     															</div>
	     														</div>
																<div class="col-md-8">
		 															<div class="form-group form_fild_row">
		  																<label>Cause of death</label>
																		<div class="custom-drop">
																			<input type="text" class="form-control prev_diagnose_suggestion" name="family_history[cause_of_death][<?= $j ?>]" value="<?= !empty($v['cause_of_death']) ? $v['cause_of_death']  : '' ?>"   data-role="tagsinput"  placeholder=""/>

																			<ul class="prev_diagnose_suggestion_listul  custom-drop-li">
																			</ul>
																		</div>
	     															</div>
	 															</div>
															</div>
														</div>
														<!-- deceased specific control -->
 													</div>
		  										</div>
		  										<div class="col-md-3 familyhistoryfldtimes">
		   											<div class="crose_year">
		    											<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   											</div>
		  										</div>
		 									</div>
										</div>
	   								</div>
								<?php $j++;  } } ?>
	   						<div class="row familyhistoryfld  on_load_display_none_cls">
	    						<div class="col-md-4">
		 							<div class="form-group form_fild_row">
	      								<label>Family Member</label>
								        <select class="form-control " name="family_history[name][]">
								        	<option value=""></option>
								        	<?php
								        		foreach ($family_relation as $fkey => $fvalue) {
								        	?>
								        		<option  value="<?= $fkey ?>"><?= $fvalue ?></option>
								        	<?php
								        		}
								        	?>
								        </select>
	     							</div>
        							<div class="form-group form_fild_row">
           								<label>Alive Status</label>
		 								<div class="radio_list">
		  									<div class="form-check">
											    <input type="radio"  value="1"  class="form-check-input alive_disease_radio"  id="alive" name="family_history[alive_status][]">
											    <label class="form-check-label" for="alive">Alive</label>
		   									</div>
		   									<div class="form-check">
											    <input type="radio"  value="0"  class="form-check-input alive_disease_radio"  id="descase"  name="family_history[alive_status][]">
											    <label class="form-check-label" for="descase">Deceased</label>
		  									</div>
	     								</div>
									</div>
								</div>
								<div class="col-md-8">
	     							<div class="row">
		  								<div class="col-md-9">
	      									<div class="form-group form_fild_row">
	       										<label>Medical Conditions</label>
 												<div class="custom-drop">
													<input type="text" class="form-control prev_diagnose_suggestion"  data-role="tagsinput"  name="family_history[disease][]" placeholder=""/>
													<ul class="prev_diagnose_suggestion_listul  custom-drop-li">

													</ul>
												</div>
	      									</div>
 											<div class="form-group form_fild_row">
												<!-- deceased specific control -->
	    										<div class="deceased_specific_control" style="display: none;">
	    											<div class="row">
	   													<div class="col-md-4">
		 													<div class="form-group form_fild_row">
	      														<label>Age at death</label>
														        <select class="form-control" name="family_history[decease_year][]" >
														        	<option value=""></option>
														        	<option value="911">Don't know</option>

													   				<option  value="999">Childhood</option>
														        	<?php

														        	for($dece = 0 ; $dece <= 110 ; $dece++){

														        		echo "<option  value=".$dece.">".$dece."</option>";
														        	}
														        	?>
															    </select>
													     	</div>
													    </div>
														<div class="col-md-8">
		 													<div class="form-group form_fild_row">
		 														<label>Cause of death</label>
																<div class="custom-drop">
																    <input type="text" class="form-control prev_diagnose_suggestion" name="family_history[cause_of_death][]"   data-role="tagsinput"  placeholder=""/>
																    <ul class="prev_diagnose_suggestion_listul  custom-drop-li">
																	</ul>
																</div>
	     													</div>
	 													</div>
													</div>
												</div>
												<!-- deceased specific control -->
 											</div>
		  								</div>
		  								<div class="col-md-3 familyhistoryfldtimes">
		   									<div class="crose_year">
		    									<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   									</div>
		  								</div>
		 							</div>
								</div>
	   						</div>
							<div class="row">
	    						<div class="col-md-6">
		 							<div class="form-group form_fild_row">
										<div class=" familyhistoryfldadd">
		   									<div class="crose_year">
		    									<button  type="button"  class="btn btn-medium">Add a member</button>
		   									</div>
		  								</div>
		 							</div>
								</div>
							</div>
							<div class="row familyhistoryfld_display_none">
	    						<div class="col-md-4">
		 							<div class="form-group form_fild_row">
									    <label>Family Member</label>
								        <select class="form-control " disabled name="family_history[name][]">
								        	<option value=""></option>
								        	<?php
								        		foreach ($family_relation as $fkey => $fvalue) {
								        	?>
								        		<option  value="<?= $fkey ?>"><?= $fvalue ?></option>
								        	<?php
								        		}
								        	?>
								        </select>
	     							</div>

        							<div class="form-group form_fild_row">
           								<label>Alive Status</label>
		 								<div class="radio_list">
										   	<div class="form-check">
										    	<input type="radio"  disabled  value="1"  class="form-check-input alive_disease_radio"  id="alive" name="family_history[alive_status][]">
										   		<label class="form-check-label" for="alive">Alive</label>
										   	</div>
										   <div class="form-check">
										    	<input type="radio"  disabled  value="0"  class="form-check-input alive_disease_radio"  id="descase"  name="family_history[alive_status][]">
										    	<label class="form-check-label" for="descase">Deceased</label>
										  	</div>
									    </div>
									</div>
								</div>

								<div class="col-md-8">
	    							<div class="row">
		  								<div class="col-md-9">
	      									<div class="form-group form_fild_row">
	       										<label>Medical Conditions</label>
												<div class="custom-drop">
													<input type="text"  disabled   class="form-control prev_diagnose_suggestion" value="" data-role="tagsinput"  name="family_history[disease][]" placeholder=""/>
													<ul class="prev_diagnose_suggestion_listul  custom-drop-li">
													</ul>
												</div>
	      									</div>
      										<div class="form-group form_fild_row">
												<!-- deceased specific control -->
												<div class="deceased_specific_control" style="display: none;">
													<div class="row">
													   	<div class="col-md-4">
														 	<div class="form-group form_fild_row">
													      		<label>Age at death</label>
													        	<select class="form-control"  disabled  name="family_history[decease_year][]" >
													        		<option value=""></option>
													        		<option  value="911">Don't know</option>
												   					<option  value="999">Childhood</option>
														        	<?php

														        	for($dece = 0 ; $dece <= 110 ; $dece++){

														        		echo "<option  value=".$dece.">".$dece."</option>";
														        	}
														        	?>
														    	</select>
													     	</div>
													    </div>
														<div class="col-md-8">
														 	<div class="form-group form_fild_row">
														 	 	<label>Cause of death</label>
												 				<div class="custom-drop">
													      			<input type="text"  disabled  class="form-control prev_diagnose_suggestion" name="family_history[cause_of_death][]"   data-role="tagsinput"  placeholder=""/>

													      			<ul class="prev_diagnose_suggestion_listul  custom-drop-li">
																	</ul>
																</div>
													     	</div>
													 	</div>
													</div>
												</div>
												<!-- deceased specific control -->
      										</div>
		  								</div>
		  								<div class="col-md-3 familyhistoryfldtimes">
		   									<div class="crose_year">
		    									<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   									</div>
		  								</div>
		 							</div>
								</div>
	   						</div>



<script type="text/javascript">

$(document).ready(function() {

// on first time when document load, read the input value of the taginput and enter each tag as separate tag
$( ".prev_diagnose_suggestion" ).each(function() {
  	var prev_val = $(this).val();
  	if(prev_val){
  		$(this).tagsinput('removeAll');
  		  // $(this).tagsinput('add', 'some tag, some tag, some other tag');
  		 prev_val = prev_val.split(',');
  		 var i;
		for (i = 0; i < prev_val.length; ++i) {
		    // do something with `substr[i]`
		    // alert(prev_val[i]);
		    $(this).tagsinput('add', prev_val[i]);
		}
  	}
});



var taginputli_click = false;
var old_prev_search_val = '';
$('.prev_diagnose_suggestion').tagsinput({
      allowDuplicates: true,

        // onTagExists: function(item, $tag) {}
        // itemValue: 'id',  // this will be used to set id of tag
        // itemText: 'label' // this will be used to set text of tag
    });
// $('.prev_diagnose_suggestion').on('itemAdded', function(event) {

$(document).on('itemAdded', ".prev_diagnose_suggestion", function(event) {



  // we are using 2 extra variable here taginputli_click and old_prev_search_val , if user click the list item after entering manual entry from key board then delete the manual entered value otherwise not (if user does not clicked list item)
  // taginputli_click value will be true if user chooses from list other wise it will be false , when it is true, we delete the manual entered value
  if(taginputli_click && old_prev_search_val){
  	$(this).tagsinput('remove', old_prev_search_val.toLowerCase());
  	taginputli_click = false ;
  	old_prev_search_val = '' ;
  }

$(this).tagsinput('refresh');
// alert('item added');
old_prev_search_val = prev_search_val;  // assign the current search value in the old_prev_search_val to keep the value
  prev_search_val = '';
});


 // tag input realted code start ********************************************************
 var prev_search_val = '';
$(document).on('keydown click', ".bootstrap-tagsinput", function(e) {

	if(e.type == 'keydown'){
		if(isTextSelected($(this).find('input')[0])){ // if text selected with back space we will reset search criteria
			// alert('yes') ;
		   //text selected
		   prev_search_val = '';
		}
	}
searchRequest = null;



        if(e.keyCode){ // checking only when key is pressed
        	if(e.keyCode == 8){ // in case of backspace character delete last character
        		prev_search_val = prev_search_val.slice(0, -1);

        	}else{
        		// check for only printable characters otherwise ignore any command characters
        		if( (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 32  || (e.keyCode > 64 && e.keyCode < 91)   || (e.keyCode > 95 && e.keyCode < 112)  || (e.keyCode > 185 && e.keyCode < 193) || (e.keyCode > 218 && e.keyCode < 223) ||
       				e.keyCode ==173 || e.keyCode ==61  || e.keyCode ==59

        			){
        			// console.log(e.keyCode);
        			prev_search_val += String.fromCharCode(e.keyCode);
        		}

        	}

        }
value = prev_search_val ;
  // alert(value);
            if (searchRequest != null)
                searchRequest.abort();
            var curele = this;
            searchRequest = $.ajax({
                type: "GET",
                url: "<?php echo SITE_URL.'users/gettaginputsuggestion'; ?>", // we need different function for tag input suggestion , it searches by start matching
                data: {
                	'search_type' : 1, // 1 for searching default medical condition
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                	// alert(msg);
                	var msg = JSON.parse(msg);
                	var temphtml = '' ;
                	$.each(msg, function(index, element) {
                		// alert(index);
                		// alert(element);
                		temphtml += '<li diag_sugg_atr ="'+element+'" >'+element+'</li>' ;

					});
					// alert(temphtml);
					$(curele).parents('.custom-drop').find('.prev_diagnose_suggestion_listul').html(temphtml);

                    //we need to check if the value is the same

                }
            });





});



// ajax search for diagnose start


$(document).on("click", ".prev_diagnose_suggestion_listul li", function () {
	taginputli_click = true;  // this variable is used for tracking list item click above in taginput add tag event handler
	var diag_sugg_atr = $(this).attr('diag_sugg_atr');


	var tmptext = $(this).parents('.custom-drop').find('.prev_diagnose_suggestion');

	 var ttext = $(tmptext).val();

	 // alert(ttext);
	 if(ttext.indexOf(diag_sugg_atr) == -1){  // we will add the tag only when it is not added previously
 $(tmptext).tagsinput('refresh');
	 	 $(tmptext).tagsinput('add', diag_sugg_atr);

	 	 // below line to resolve the issue of duplicate tagsinput field
	 	 $(tmptext).prev('.bootstrap-tagsinput').prev('.bootstrap-tagsinput').remove();

	 }

	$(this).parents('.prev_diagnose_suggestion_listul').empty();

});


// ajax search for diagnose end



// tag input related code end ***********************************************************




$(document).on("click", "input[type='radio'].alive_disease_radio", function () {
    if($(this).is(':checked')) {

        if ($(this).val() == 0) {
            $(this).parents('.familyhistoryfld').find('.deceased_specific_control').css('display', 'block');
        }else{
            $(this).parents('.familyhistoryfld').find('.deceased_specific_control').css('display', 'none');
        }
    }
});



 $(document).on("click",".familyhistoryfldadd button",function() {

		var cloneob = $( ".familyhistoryfld_display_none" ).clone();

		$( cloneob ).find('input').each(function() {
									  $(this).removeAttr('disabled');

									    });

			$( cloneob ).find('select').each(function() {
							$(this).removeAttr('disabled');

							    });



		$( cloneob ).addClass(' familyhistoryfld_display_none123').removeClass('familyhistoryfld_display_none').insertAfter( ".familyhistoryfld:last" );
		$(".familyhistoryfld_display_none123").addClass('familyhistoryfld');

$(cloneob).find('.prev_diagnose_suggestion').tagsinput('refresh');  // to refresh the dynamic tag input
 $(cloneob).find('.prev_diagnose_suggestion').prev('.bootstrap-tagsinput').prev('.bootstrap-tagsinput').remove(); // solve the 2 tagsinput field issue

var numItems = $('.familyhistoryfld').length
f = numItems;
// alert(f);
$('.familyhistoryfld_display_none123').find('#alive').attr('id','alive'+f);

$('.familyhistoryfld_display_none123').find('#alive'+f).attr('name','family_history[alive_status]['+(f-1)+']');

$('.familyhistoryfld_display_none123').find("label[for='alive']").attr('for','alive'+f);
$('.familyhistoryfld_display_none123').find('#descase').attr('id','descase'+f);

$('.familyhistoryfld_display_none123').find('#descase'+f).attr('name','family_history[alive_status]['+(f-1)+']');

$('.familyhistoryfld_display_none123').find("label[for='descase']").attr('for','descase'+f);
$('.familyhistoryfld_display_none123').removeClass('familyhistoryfld_display_none123');



	});
 $(document).on("click",".familyhistoryfldtimes button",function() {
 	$(this).parents('.familyhistoryfld').remove();
 });

});

</script>
<style type="text/css">

.familyhistoryfld_display_none { display: none; }
 .familyhistoryfld { border-bottom: 2px solid #ececec;   margin-bottom: 23px; }

</style>

<script type="text/javascript">

// 		$(document).ready(function(){
// 			$("#family_back_btn").click(function(){
// 			    $("#contact-tab").trigger("click");


// $('#checksurgical').val(1);

// 			      window.location = "#contact-tab";
// 			});
// 			$("#family_next_btn").click(function(){
// 			    $("#allergies-tab").trigger("click");
// 			    $('#checkallergy').val(1);
// 			      window.location = "#allergies-tab";
// 			});
// 		});

	   	</script>

	  </div>

	   <div class="back_next_button">
	    <ul>
		 <li>
		  <button id="contact-tab-backbtn" type="button" class="btn">Back</button>
	     </li>
		 <!-- <li>
		  <button id="family_next_btn" type="button" class="btn">Next</button>
	     </li> -->
	     <li>
		 <button type="submit"  name="tab_number" value="4"  class="btn">Next</button>
	     </li>

		</ul>
	   </div>
<!-- <div class="back_next_button">
	    <ul>
		 <li>
		 <button type="submit"  name="tab_name" value="<?= $tabcount++ ?>"  class="btn">Next</button>
	     </li>
		</ul>
	   </div> -->


	 </div>

<script type="text/javascript">

	$(document).ready(function() {
		$(document).on("change", "input[type='radio'].is_family_his", function () {

		   if($(this).is(':checked')) {
		    	// alert($(this).val());
		    	// alert($(this).val());
		        if ($(this).val() == 0) {
		        	// alert();
		        	// $('.is_check_med_his_div').removeClass('on_load_display_none_cls');
		        	$('.is_family_his_div').css( "display", "none" );
		        }else{
		        	$('.is_family_his_div').removeClass('on_load_display_none_cls');
		        	$('.is_family_his_div').css( "display", "block" );
		        }
		    }
		 });
	});


</script>

	 <?php $this->Form->end() ; ?>
	<script type="text/javascript">

	 	$("#form_tab_4").validate({

			ignore: ':hidden:not(.do_not_ignore)',
		  	showErrors: function(errorMap, errorList) {
	  		  	if(errorList.length>0){
	        		$("#form_tab_4 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
	    		}
		 	},
		 	submitHandler: function(form) {
            formsubmit(form);

        }
		});
	</script>

<?php } ?>


<?php

if($active_tab == 5){

	echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_5')); ?>


		<div class="tab-pane fade   <?= $active_tab == 5 ? '  show active ' : '' ?>" id="allergies" role="tabpanel" aria-labelledby="allergies-tab">
			<div class="errorHolder"></div>
		  	<div class="TitleHead">
		   		<h3>Allergies</h3>
		   		<div class="seprator"></div>
		  	</div>
			<!-- first ask question about any surgical history is there start -->
			<div class="tab_form_fild_bg">
				<div class="row">
				   <div class="col-md-12">
						<div class="form-group form_fild_row">
			         		<label>Do you have any allergies? </label>  <span class="required_star">*</span>
					 		<div class="radio_list">
					   			<div class="form-check">
					    			<input type="radio"  <?php echo !is_null($user_data->is_check_allergy_his) && $user_data->is_check_allergy_his == 1 ? 'checked' : '' ?>    value="1"  class="form-check-input is_check_allergy_his" name="is_check_allergy_his"  id="is_check_allergy_his1" required = "true">
					    			<label class="form-check-label" for="is_check_allergy_his1">Yes</label>
					   			</div>

					   			<div class="form-check">
					    			<input type="radio"     value="0"  <?php echo !is_null($user_data->is_check_allergy_his) &&  is_numeric($user_data->is_check_allergy_his) &&  $user_data->is_check_allergy_his == 0 ? 'checked' : '' ?>   class="form-check-input is_check_allergy_his" name="is_check_allergy_his"  id="is_check_allergy_his2" required = "true"  >
					    			<label class="form-check-label" for="is_check_allergy_his2">No</label>
					  			</div>
				     		</div>
						</div>
				  	</div>
				</div>
			</div>
			<!-- first ask question about any surgical history is there end -->

   			<?php if(($user_data->gender == 0) && empty($check_surgical_allergy['checkallergy'])) {   ?>
				<div class="tab_form_fild_bg  is_check_allergy_his_div  <?php if(is_null($user_data->is_check_allergy_his) || $user_data->is_check_allergy_his == 0 ) echo 'on_load_display_none_cls '; ?>  ">
					<div class="row">
		   				<div class="col-md-12">
							<div class="form-group form_fild_row">
					        	<label> Are you allergic to latex? </label>  <span class="required_star">*</span>
							 	<div class="radio_list">
							   		<div class="form-check">
							    		<input type="radio" <?php echo  !is_null($user_data->is_latex_allergy) && $user_data->is_latex_allergy == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input is_latex_allergy" name="is_latex_allergy"  id="is_latex_allergy1" required="true">
							    		<label class="form-check-label" for="is_latex_allergy1">Yes</label>
							   		</div>
							   		<div class="form-check">
							    		<input type="radio"  <?php echo  !is_null($user_data->is_latex_allergy) &&   is_numeric($user_data->is_latex_allergy) &&   $user_data->is_latex_allergy == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input is_latex_allergy" name="is_latex_allergy"  id="is_latex_allergy2" required="true">
							    		<label class="form-check-label" for="is_latex_allergy2">No</label>
							  		</div>
		     					</div>
							</div>
		  				</div>
					</div>
	  			</div>
			<?php } ?>
      		<div class="tab_form_fild_bg  is_check_allergy_his_div  <?php if(is_null($user_data->is_check_allergy_his) || $user_data->is_check_allergy_his == 0 ) echo 'on_load_display_none_cls '; ?>   ">

				<?php
					$al = 0 ;
				if(!empty($user_data->allergy_history)) {

					$tempmedical_history =  unserialize((Security::decrypt(base64_decode($user_data->allergy_history), SEC_KEY)));

					$old_allergy_cond_arr = array();

					if(!empty($tempmedical_history)){

					foreach($tempmedical_history as $k => $v) {


						$old_allergy_cond_arr[] = $v['name'];
				?>

					   	<div class="row allergyhistoryfld">
					    	<div class="col-md-6">
						 		<div class="form-group form_fild_row">
					     			<label>Allergy</label>
				 					<div class="custom-drop">
										<input type="text" id="allergy_<?php echo $k ?>" value="<?php echo  $v['name'] ?>"  class="form-control  allergycondbox allergy_suggestion" name="allergy_history[<?= $al ?>][name]" placeholder=""/>

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
												<input type="text" value="<?php echo  $v['reaction'] ?>"  class="form-control  reaction_suggestion" name="allergy_history[<?= $al ?>][reaction]" placeholder=""/>

									      		<ul class="reaction_suggestion_listul custom-drop-li">
												</ul>
											</div>
									    </div>
									</div>
								  	<div class="col-md-5 allergyhistoryfldtimes">
								   		<div class="crose_year">
								    		<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
								   		</div>
								  	</div>
								</div>
							</div>
	   					</div>
					<?php $al++ ;  } }} ?>

				   	<div class="row allergyhistoryfld  on_load_display_none_cls">
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
							  	<div class="col-md-5 allergyhistoryfldtimes">
							   		<div class="crose_year">
							    		<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
							   		</div>
							  	</div>
							</div>
						</div>
	   				</div>


					<div class="row">
					    <div class="col-md-6">
						 	<div class="form-group form_fild_row">
								<div class=" allergyhistoryfldadd">
						   			<div class="crose_year">
						    			<button  type="button"  class="btn btn-medium">Add a allergy</button>
						   			</div>
						  		</div>
						 	</div>
						</div>
					</div>

<script type="text/javascript">
	var al = '<?= $al ?>';
$(document).ready(function() {
 $(document).on("click",".allergyhistoryfldadd button",function() {

 		al++;
 		var alergy_clone = $( ".allergyhistoryfld:last" ).clone() ;

 		$(alergy_clone).find('.react_cond_select').attr('name','allergy_history['+ al +'][reaction]');

		$(alergy_clone).find('.al_cond_select').attr('name','allergy_history['+ al +'][name]');
$(alergy_clone).find('input').each(function() {

		$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
							  $(this).removeAttr('disabled');
							  $(this).val('');
							    });

		$(alergy_clone).insertAfter( ".allergyhistoryfld:last" );



	});
 $(document).on("click",".allergyhistoryfldtimes button",function() {

 if($(this).parents('.allergyhistoryfld').find('input.allergycondbox').val().trim() == "Latex") {
		$("input[value='0'].is_latex_allergy").prop("checked", true); // if user removes Latex then uncheck
 	}

 	var remove_val = $(this).parents('.allergyhistoryfld').find('input.allergycondbox').val().trim();
 	var flag = false;
 	$(this).parents('.allergyhistoryfld').remove();

 	$('.allergy_suggestion').each(function(){

 		if(remove_val == $(this).val()){

 			flag = true;
 		}

 	});

 	if(!flag){

 		$('.allergycondboxdiv button').each(function(){

 			var attr = $(this).attr('condval');
 			if(remove_val == attr){

 				$(this).removeClass('selected_chief_complaint');
 			}
 		})
 	}

 });

});

</script>
<div class="common_conditions_button  allergycondboxdiv">
	<h4>Common allergies</h4>
	<ul>

	<?php
	$i = 0 ;

	foreach ($common_allergy_cond as $key => $value) {
	?>
	<li class="active medicalcondbottom">
			<button  type="button"  condid="<?= $key ?>" condval="<?= $value ?>"  class="btn <?php if(isset($old_allergy_cond_arr) && !empty($old_allergy_cond_arr) && in_array($value, $old_allergy_cond_arr)) { echo 'selected_chief_complaint'; }?>">
				<i class="fas fa-plus-circle"></i>
				<span><?= $value ?></span>
			</button>
	</li>
	<?php
		$i++;
	}

	?>

    </ul>
</div>

<script type="text/javascript">
	//  home-tab  profile-tab   contact-tab   family-tab  allergies-tab  shots-tab  social-tab  additional-tab
$(document).ready(function(){
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
                url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
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


$(document).on("click", ".reaction_suggestion_listul li", function () {

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
                url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
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


$(document).on("click", ".allergy_suggestion_listul li", function () {

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






			$("#allergy_back_btn").click(function(){
			    $("#family-tab").trigger("click");


$('#checkfamily').val(1);

			       window.location = "#family-tab";
			});
			$("#allergy_next_btn").click(function(){
	// shots related field are commented as now next tab is social tab
			    // $("#shots-tab").trigger("click");
			    $("#social-tab").trigger("click");
			    // $('#checkshots').val(1);
			    $('#checksocial').val(1);
			    // window.location = "#shots-tab";
			    window.location = "#social-tab";
			});


$(document).on("change", "input[type='radio'].is_latex_allergy", function () {

    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
				$('input.allergycondbox').each(function(i, obj) {
				    if($(obj).val().trim() == "Latex"){
				    	$(this).parents('.allergyhistoryfld').remove();
				    }
				});
        }else{
        	 $(".allergyhistoryfldadd button").trigger("click");

        	 $(".allergyhistoryfld:last").find('input.allergycondbox').val("Latex") ;
        }
    }
});



		});

	   	</script>


	  </div>

	   	<div class="back_next_button">
	    	<ul>
		 		<li>
		  			<button id="family-tab-backbtn" type="button" class="btn">Back</button>
	     		</li>
	     		<li>
		 			<button type="submit"  name="tab_number" value="5"  class="btn">Next</button>
	     		</li>
			</ul>
	   </div>
    </div>
<script type="text/javascript">
	$(document).ready(function() {
$(document).on("change", "input[type='radio'].is_check_allergy_his", function () {

   if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        	$('.is_check_allergy_his_div').css( "display", "none" );
        }else{
        	$('.is_check_allergy_his_div').removeClass('on_load_display_none_cls');
        	$('.is_check_allergy_his_div').css( "display", "block" );
        }
    }



 });

 $(document).on("click",".allergycondboxdiv button",function() {
 var  index = $(this).attr('condval');

 var flag = true;
 $('input.allergycondbox').each(function(i, obj) {
		 if($(obj).val()===""){
			 flag = false;
			 $(obj).val(index);
			 return false;
		 }
 });
 if(flag){
	 $( ".allergyhistoryfldadd button" ).trigger( "click" );
	 $('input.allergycondbox').each(function(i, obj) {
			 if($(obj).val()===""){
				 $(obj).val(index);
				 return false;
			 }
	 });

 }
 $(this).addClass('selected_chief_complaint');

		});
 	});


</script>

	 <?php $this->Form->end() ; ?>
	<script type="text/javascript">

	 	$("#form_tab_5").validate({

			ignore: ':hidden:not(.do_not_ignore)',
		  	showErrors: function(errorMap, errorList) {
	  		  	if(errorList.length>0){
	        		$("#form_tab_5 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
	    		}
		 	},
		 	submitHandler: function(form) {
            formsubmit(form);

        }
		});
	</script>

<?php } ?>

<?php

if($active_tab == 6){

	echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_6')); ?>


	 	<div class="tab-pane fade   <?= $active_tab == 6 ? '  show active ' : '' ?>" id="social" role="tabpanel" aria-labelledby="social-tab">
	 		<div class="errorHolder"></div>
		  	<div class="TitleHead">
		   		<h3>Tobacco Use</h3>
		   		<div class="seprator"></div>
		  	</div>
      		<div class="tab_form_fild_bg">
	   			<div class="row ">
					<div class="col-md-4">
						<div class="form-group form_fild_row">
           					<label>Do you currently smoke?</label>  <span class="required_star">*</span>
		 					<div class="radio_list">
							   	<div class="form-check">
							    	<input type="radio"  data-error="#errNm3"  <?php echo !is_null($user_data->is_currentlysmoking) && $user_data->is_currentlysmoking == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input currentlysmoking" name="currentlysmoking"  id="currentlysmoking1" required = "true">
							   		<label class="form-check-label" for="currentlysmoking1">Yes</label>
							   	</div>
							   	<div class="form-check">
							    	<input type="radio"  data-error="#errNm3"  <?php echo  !is_null($user_data->is_currentlysmoking) &&  is_numeric($user_data->is_currentlysmoking) &&  $user_data->is_currentlysmoking == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input currentlysmoking" name="currentlysmoking"  id="currentlysmoking2" required = "true">
							    	<label class="form-check-label" for="currentlysmoking2">No</label>
							  	</div>
	     					</div>
						</div>
					</div>

	    		<div class="col-md-4  currentlysmokingdiv  <?php echo  (!is_null($user_data->is_currentlysmoking) && $user_data->is_currentlysmoking == 0 ?"elem_display_none":($user_data->is_currentlysmoking == 1?"":'elem_display_none')) ?> ">
         				<div class="form-group form_fild_row">
         					<label>How many packs? (per week)</label>
							<select class="form-control" <?php echo empty($user_data->is_currentlysmoking) ? 'disabled' : ''; ?> name="current_smoke_pack"  >
	        					<option value=""></option>
					        	<?php
					        		$cnt = 1;
						        	for($cnt ; $cnt<= 10 ; $cnt++){
						        		echo "<option ".(isset($user_data->current_smoke_pack) && $user_data->current_smoke_pack ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
						        	}
					        	?>
	        					<option <?=  (isset($user_data->current_smoke_pack) && $user_data->current_smoke_pack == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 packs</option>
		    				</select>
	     				</div>
					</div>
					<!-- <div class="col-md-4 currentlysmokingdiv  <?php echo  (!is_null($user_data->is_currentlysmoking) && $user_data->is_currentlysmoking == 0 ? "elem_display_none":($user_data->is_currentlysmoking == 1 ? "" : 'elem_display_none')) ?> ">
	     				<div class="form-group form_fild_row">
	     					<label>How many years?</label>
	      					<select class="form-control"  <?php echo empty($user_data->is_currentlysmoking) ? 'disabled' : ''; ?>  name="current_smoke_year"  >
	        					<option value=""></option>
					        	<?php
					        		$cnt = 1;
						        	for($cnt ; $cnt<= 10 ; $cnt++){
						        		echo "<option ".(isset($user_data->current_smoke_year) && $user_data->current_smoke_year ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
						        	}
					        	?>
	        					<option <?=  (isset($user_data->current_smoke_year) && $user_data->current_smoke_year == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 years</option>
		    				</select>
	     				</div>
					</div> -->
	   			</div>

<script type="text/javascript">

$(document).ready(function() {

$(document).on("change", "input[type='radio'].currentlysmoking", function () {

    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        	$('.currentlysmokingdiv').addClass('elem_display_none') ;
  $('.currentlysmokingdiv input, .currentlysmokingdiv select').attr('disabled', 'disabled');
        }else{
        	$('.currentlysmokingdiv').removeClass('elem_display_none') ;
  $('.currentlysmokingdiv input, .currentlysmokingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});




});

</script>



	<div class="row">
		<div class="col-md-4">
			<div class="form-group form_fild_row">
		        <label>Did you smoke in the past?</label>	 <span class="required_star">*</span>
				<div class="radio_list">
				   	<div class="form-check">
				    	<input type="radio"  data-error="#errNm4"  <?php echo  !is_null($user_data->is_pastsmoking) && $user_data->is_pastsmoking == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input pastsmoking" name="pastsmoking"  id="pastsmoking1" required = "true" >
				    	<label class="form-check-label" for="pastsmoking1">Yes</label>
				   	</div>

				   	<div class="form-check">
				    	<input type="radio"  data-error="#errNm4"  <?php echo  !is_null($user_data->is_pastsmoking) &&  is_numeric($user_data->is_pastsmoking) &&  $user_data->is_pastsmoking == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input pastsmoking" name="pastsmoking"  id="pastsmoking2" required = "true">
				    	<label class="form-check-label" for="pastsmoking2">No</label>
				  	</div>
			    </div>
			</div>
		</div>
	    <div class="col-md-4 pastsmokingdiv   <?php echo  (!is_null($user_data->is_pastsmoking) && $user_data->is_pastsmoking == 0 ? "elem_display_none":($user_data->is_pastsmoking == 1 ? "" : 'elem_display_none')) ?>  ">
         	<div class="form-group form_fild_row">
         		<label>How many packs? (per week)</label>
				<select class="form-control"   <?php echo empty($user_data->is_pastsmoking) ? 'disabled' : ''; ?>  name="past_smoke_pack"  >
	        		<option value=""></option>
	        		<?php
	        			$cnt = 1;
			        	for($cnt ; $cnt<= 10 ; $cnt++){
			        		echo "<option ".(isset($user_data->past_smoke_pack) && $user_data->past_smoke_pack ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
			        	}
	        		?>
	        		<option <?=  (isset($user_data->past_smoke_pack) && $user_data->past_smoke_pack == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 packs</option>
		    	</select>
	     	</div>
		</div>
		<div class="col-md-4  pastsmokingdiv   <?php echo  (!is_null($user_data->is_pastsmoking) && $user_data->is_pastsmoking == 0 ? "elem_display_none":($user_data->is_pastsmoking == 1 ? "" : 'elem_display_none')) ?>  ">
	     	<div class="form-group form_fild_row">
	      		<label>How many years?</label>
				<select class="form-control"   <?php echo empty($user_data->is_pastsmoking) ? 'disabled' : ''; ?>  name="past_smoke_year"  >
	        		<option value=""></option>
	        		<?php
	        			$cnt = 1;
			        	for($cnt ; $cnt<= 10 ; $cnt++){
			        		echo "<option ".(isset($user_data->past_smoke_year) && $user_data->past_smoke_year ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
			        	}
	        		?>
	        		<option <?=  (isset($user_data->past_smoke_year) && $user_data->past_smoke_year == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 years</option>
		    	</select>
	    	</div>
		</div>
	</div>

<script type="text/javascript">

$(document).ready(function() {


$(document).on("change", "input[type='radio'].pastsmoking", function () {

    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        	$('.pastsmokingdiv').addClass('elem_display_none') ;
  $('.pastsmokingdiv input, .pastsmokingdiv select').attr('disabled', 'disabled');
        }else{
        	$('.pastsmokingdiv').removeClass('elem_display_none') ;
 $('.pastsmokingdiv input, .pastsmokingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});




});

</script>
<div class="TitleHead">
	<h3>Alcohol Use</h3>
	<div class="seprator"></div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="check_box_bg">

			<div class="form-group form_fild_row">
           		<label>Do you currently drink alcohol?</label>	 <span class="required_star">*</span>
		 		<div class="radio_list">
		   			<div class="form-check">
		    			<input type="radio"  data-error="#errNm5"  <?php echo  !is_null($user_data->is_currentlydrinking) && $user_data->is_currentlydrinking == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input currentlydrinking" name="currentlydrinking"  id="currentlydrinking1" required = "true" >
		    			<label class="form-check-label" for="currentlydrinking1">Yes</label>
		   			</div>
				   	<div class="form-check">
				    	<input type="radio"  data-error="#errNm5"  <?php echo  !is_null($user_data->is_currentlydrinking) &&  is_numeric($user_data->is_currentlydrinking) &&  $user_data->is_currentlydrinking == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input currentlydrinking" name="currentlydrinking"  id="currentlydrinking2" required = "true" >
				    	<label class="form-check-label" for="currentlydrinking2">No</label>
				  	</div>
	     		</div>
			</div>
		</div>
        <div class="errorTxt">
            <span id="errNm5"></span>
        </div>
	</div>
	<div class="col-md-4  currentlydrinkingdiv  <?php echo  (!is_null($user_data->is_currentlydrinking) && $user_data->is_currentlydrinking == 0 ? "elem_display_none":($user_data->is_currentlydrinking == 1 ? "" : 'elem_display_none')) ?>  ">
        <div class="form-group form_fild_row">
         	<label>How many drinks? (per week)</label>
			<select class="form-control"    <?php echo empty($user_data->is_currentlydrinking) ? 'disabled' : ''; ?>   name="current_drink_pack"  >
	        	<option value=""></option>
	        	<?php
	        		$cnt = 1;
		        	for($cnt ; $cnt<= 14 ; $cnt++){
		        		echo "<option ".(isset($user_data->current_drink_pack) && $user_data->current_drink_pack ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
		        	}
	        	?>
	        	<option <?=  (isset($user_data->current_drink_pack) && $user_data->current_drink_pack == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 14 drinks</option>
		    </select>
	    </div>
	</div>

	<!-- <div class="col-md-4  currentlydrinkingdiv   <?php echo  (!is_null($user_data->is_currentlydrinking) && $user_data->is_currentlydrinking == 0 ? "elem_display_none":($user_data->is_currentlydrinking == 1 ? "" : 'elem_display_none')) ?> ">
	    <div class="form-group form_fild_row">
	     	<label>How many years?</label>
			<select class="form-control"    <?php echo empty($user_data->is_currentlydrinking) ? 'disabled' : ''; ?>   name="current_drink_year"  >
	        	<option value=""></option>
	        	<?php
	        		$cnt = 1;
		        	for($cnt ; $cnt<= 10 ; $cnt++){
		        		echo "<option ".(isset($user_data->current_drink_year) && $user_data->current_drink_year ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
		        	}
	        	?>
	        	<option <?=  (isset($user_data->current_drink_year) && $user_data->current_drink_year == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 years</option>
		    </select>
	    </div>
	</div> -->
</div>

<script type="text/javascript">

$(document).ready(function() {



$(document).on("change", "input[type='radio'].currentlydrinking", function () {

    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        	$('.currentlydrinkingdiv').addClass('elem_display_none') ;
$('.currentlydrinkingdiv input, .currentlydrinkingdiv select').attr('disabled', 'disabled');
        }else{
        	$('.currentlydrinkingdiv').removeClass('elem_display_none') ;
$('.currentlydrinkingdiv input, .currentlydrinkingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});

});

</script>


<div class="row ">
	<div class="col-md-4">

		<div class="form-group form_fild_row">
	        <label>Did you drink alcohol in the past?</label>	 <span class="required_star">*</span>
			<div class="radio_list">
			   	<div class="form-check">
			    	<input type="radio"  data-error="#errNm6"  <?php echo  !is_null($user_data->is_pastdrinking) && $user_data->is_pastdrinking == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input pastdrinking" name="pastdrinking"  id="pastdrinking1" required = "true" >
			    	<label class="form-check-label" for="pastdrinking1">Yes</label>
			   	</div>
			   	<div class="form-check">
			    	<input type="radio"  data-error="#errNm6"  <?php echo  !is_null($user_data->is_pastdrinking) &&  is_numeric($user_data->is_pastdrinking) &&  $user_data->is_pastdrinking == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input pastdrinking" name="pastdrinking"  id="pastdrinking2" required = "true">
			    	<label class="form-check-label" for="pastdrinking2">No</label>
			  	</div>
		    </div>
	        <div class="errorTxt">
	            <span id="errNm6"></span>
	        </div>
		</div>
	</div>
	<div class="col-md-4  pastdrinkingdiv   <?php echo  (!is_null($user_data->is_pastdrinking) && $user_data->is_pastdrinking == 0 ? "elem_display_none":($user_data->is_pastdrinking == 1 ? "" : 'elem_display_none')) ?>  ">
        <div class="form-group form_fild_row">
         	<label>How many drinks? (per week)</label>
			<select class="form-control"   <?php echo empty($user_data->is_pastdrinking) ? 'disabled' : ''; ?>   name="past_drink_pack"  >
	        	<option value=""></option>
	        	<?php
	        		$cnt = 1;
		        	for($cnt ; $cnt<= 14 ; $cnt++){
		        		echo "<option ".(isset($user_data->past_drink_pack) && $user_data->past_drink_pack ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
		        	}
	        	?>
	        	<option <?=  (isset($user_data->past_drink_pack) && $user_data->past_drink_pack == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 14 drinks</option>
		    </select>
	     </div>
	</div>
	<div class="col-md-4  pastdrinkingdiv   <?php echo  (!is_null($user_data->is_pastdrinking) && $user_data->is_pastdrinking == 0 ? "elem_display_none":($user_data->is_pastdrinking == 1 ? "" : 'elem_display_none')) ?> ">
	    <div class="form-group form_fild_row">
	     	<label>How many years?</label>
			<select class="form-control"    <?php echo empty($user_data->is_pastdrinking) ? 'disabled' : ''; ?>   name="past_drink_year"  >
	        	<option value=""></option>
	        	<?php
	        		$cnt = 1;
		        	for($cnt ; $cnt<= 10 ; $cnt++){
		        		echo "<option ".(isset($user_data->past_drink_year) && $user_data->past_drink_year ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
		        	}
	        	?>
	        	<option <?=  (isset($user_data->past_drink_year) && $user_data->past_drink_year == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 years</option>
		    </select>
	    </div>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function() {

$(document).on("change", "input[type='radio'].pastdrinking", function () {

    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        	$('.pastdrinkingdiv').addClass('elem_display_none') ;
 $('.pastdrinkingdiv input, .pastdrinkingdiv select').attr('disabled', 'disabled');
        }else{
        	$('.pastdrinkingdiv').removeClass('elem_display_none') ;
$('.pastdrinkingdiv input, .pastdrinkingdiv select').removeAttr('disabled', 'disabled');
        }
    }
});

});

</script>
<div class="TitleHead">
	<h3>Other Drugs</h3>
	<div class="seprator"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group form_fild_row">
           <label>Do you currently use any other drugs or substances?  <span class="required_star">*</span> <a href="javascript:void(0)" data-toggle="tooltip" title="This information can be helpful for your doctor to make an accurate diagnosis. Any information provided remains private and is protected by HIPAA."><i class="fa fa-question-circle" aria-hidden="true"></i></a>	</label>
		 	<div class="radio_list">
				<div class="form-check">
				    <input type="radio"  data-error="#errNm7"  <?php echo  !is_null($user_data->is_otherdrug) && $user_data->is_otherdrug == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input otherdrug" name="otherdrug"  id="otherdrug1" required = "true" >
				    <label class="form-check-label" for="otherdrug1">Yes</label>
				</div>

				<div class="form-check">
				    <input type="radio"  data-error="#errNm7"  <?php echo  !is_null($user_data->is_otherdrug) &&  is_numeric($user_data->is_otherdrug) &&  $user_data->is_otherdrug == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input otherdrug" name="otherdrug"  id="otherdrug2" required = "true" >
				    <label class="form-check-label" for="otherdrug2">No</label>
				</div>
			</div>
		</div>
        <div class="errorTxt">
            <span id="errNm7"></span>
        </div>
	</div>
</div>
<?php
if(!empty($user_data->other_drug_history)) {
	$tempmedical_history = unserialize(Security::decrypt(base64_decode($user_data->other_drug_history), SEC_KEY));
	foreach($tempmedical_history as $k => $v) {

?>
	<div class="row otherdrughistoryfld">
	    <div class="col-md-4">
         	<div class="form-group form_fild_row">
        		<label>Drug Name</label>
	      		<input type="text" value="<?= isset($v['name']) ? $v['name'] : ''  ?>" class="form-control" name="other_drug_history[name][]" placeholder=""/>
	     	</div>
		</div>
		<div class="col-md-4">
	     	<div class="row">
		  		<div class="col-md-8">
		   			<div class="form-group form_fild_row">
		   	 			<label>How many years?</label>
  						<select class="form-control" name="other_drug_history[year][]" >
	        				<option value=""></option>
				        	<?php
				        	$cnt = 1;

				        	for($cnt ; $cnt<= 10 ; $cnt++){
				        		echo "<option ".(isset($v['year']) && $v['year'] ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
				        	}
				        	?>
	        				<option  <?=  (isset($v['year']) && $v['year'] == 'morethan10' ? 'selected' : '')  ?>  value="morethan10">More than 10 years</option>
		    			</select>
				    </div>
				</div>
				<div class="col-md-4 otherdrughistoryfldtimes">
				   <div class="crose_year">
				    	<button  type="button" class="btn waves-effect waves-light btn-icon-round"><i class="fas fa-times"></i></button>
				   	</div>
				</div>
		 	</div>
		</div>
	</div>
<?php } } ?>
<div class="row otherdrughistoryfld  on_load_display_none_cls">
	<div class="col-md-4">
        <div class="form-group form_fild_row">
          	<label>Drug Name</label>
	      	<input type="text"  value="" <?php echo empty($user_data->is_otherdrug) ? 'disabled' : ''; ?>    class="form-control"  name="other_drug_history[name][]"  placeholder=""/>
	    </div>
	</div>
	<div class="col-md-4">
	    <div class="row">
		  	<div class="col-md-8">
		   		<div class="form-group form_fild_row">
		   			<label>How many years?</label>
  					<select class="form-control"  <?php echo empty($user_data->is_otherdrug) ? 'disabled' : ''; ?>    name="other_drug_history[year][]" >
	        			<option value=""></option>
	        			<?php
	        				$cnt = 1;
				        	for($cnt ; $cnt<= 10 ; $cnt++){
				        		echo "<option  value=".$cnt.">".$cnt."</option>";
				        	}
	        			?>
	        			<option value="morethan10">More than 10 years</option>
		    		</select>
	       		</div>
		  	</div>
		  	<div class="col-md-4 otherdrughistoryfldtimes ">
		   		<div class="crose_year">
		    		<button  type="button" class="btn waves-effect waves-light btn-icon-round"><i class="fas fa-times"></i></button>
		   		</div>
		  	</div>
		</div>
	</div>
</div>

<div class="row ">
	<div class="col-md-6">
		<div class="form-group form_fild_row">
			<div class=" otherdrughistoryfldadd">
		   		<div class="crose_year">
		    		<button  type="button"  class="btn btn-medium    <?php echo empty($user_data->other_drug_history) ? 'on_load_display_none_cls' : '' ;  ?>">Add a drug</button>
		   		</div>
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">

$(document).ready(function() {

$(document).on("change", "input[type='radio'].otherdrug", function () {
// alert();
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        		$('.otherdrughistoryfld').addClass('elem_display_none') ;
$('.otherdrughistoryfld input, .otherdrughistoryfld select').attr('disabled', 'disabled');
        	   $('.otherdrughistoryfld button').hide();
        	    $('.otherdrughistoryfldadd button').hide();
        	    // $('.otherdrughistoryfldadd button').addClass('on_load_display_none_cls');
        }else{
        	$('.otherdrughistoryfld').removeClass('elem_display_none') ;
$('.otherdrughistoryfld input, .otherdrughistoryfld select').removeAttr('disabled', 'disabled');
        	 $('.otherdrughistoryfld button').show();
        	 $('.otherdrughistoryfldadd button').show();
        	  $('.otherdrughistoryfld button').removeClass('on_load_display_none_cls');
        	 $('.otherdrughistoryfldadd button').removeClass('on_load_display_none_cls');
        }
    }
});
});

</script>

<script type="text/javascript">

$(document).ready(function() {
 $(document).on("click",".otherdrughistoryfldadd button",function() {

		var cloneob = $( ".otherdrughistoryfld:last" ).clone();
		$( cloneob ).find('input').each(function() {

				$(this).removeAttr('disabled');
							  $(this).val('');
							    });
$( cloneob ).find('select').each(function() {
				$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
				$(this).removeAttr('disabled');
							  $(this).val('');
							    });

		$( cloneob ).insertAfter( ".otherdrughistoryfld:last" );



	});
 $(document).on("click",".otherdrughistoryfldtimes button",function() {
 	$(this).parents('.otherdrughistoryfld').remove();
 });

});

</script>
<!--  *********  other drug history (past) start ******************* -->
<div class="row">
	<div class="col-md-6">
		<div class="form-group form_fild_row">
           	<label>Did you use any other drugs or substances in the past? <span class="required_star">*</span><a href="javascript:void(0)" data-toggle="tooltip" title="This information can be helpful for your doctor to make an accurate diagnosis. Any information provided remains private and is protected by HIPAA."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
		 	<div class="radio_list">
		   		<div class="form-check">
		    		<input type="radio"  data-error="#errNm8"  <?php echo  !is_null($user_data->is_otherdrugpast) && $user_data->is_otherdrugpast == 1 ? 'checked' : '' ?>   value="1"  class="form-check-input otherdrugpast" name="otherdrugpast"  id="otherdrugpast1" required = "true" >
		    		<label class="form-check-label" for="otherdrugpast1">Yes</label>
		   		</div>
			   	<div class="form-check">
			    	<input type="radio"  data-error="#errNm8"  <?php echo  !is_null($user_data->is_otherdrugpast) &&  is_numeric($user_data->is_otherdrugpast) &&   $user_data->is_otherdrugpast == 0 ? 'checked' : '' ?>    value="0"  class="form-check-input otherdrugpast" name="otherdrugpast"  id="otherdrugpast2" required = "true" >
			    	<label class="form-check-label" for="otherdrugpast2">No</label>
			  	</div>
	     	</div>
		</div>
        <div class="errorTxt">
            <span id="errNm8"></span>
        </div>
	</div>
</div>
<?php
if(!empty($user_data->other_drug_history_past)) {
$tempmedical_history = unserialize(Security::decrypt(base64_decode($user_data->other_drug_history_past), SEC_KEY));

	foreach($tempmedical_history as $k => $v) {

?>
	<div class="row otherdrughistorypastfld">
	    <div class="col-md-4">
         	<div class="form-group form_fild_row">
         		<label>Drug Name</label>
	      		<input type="text" value="<?= isset($v['name']) ? $v['name'] : ''  ?>" class="form-control" name="other_drug_history_past[name][]" placeholder=""/>
	     	</div>
		</div>
		<div class="col-md-4">
	     	<div class="row">
		  		<div class="col-md-8">
		   			<div class="form-group form_fild_row">
		   	 			<label>How many years?</label>
  						<select class="form-control" name="other_drug_history_past[year][]" >
	        				<option value=""></option>
				        	<?php
				        	$cnt = 1;
				        	for($cnt ; $cnt<= 10 ; $cnt++){
				        		echo "<option ".(isset($v['year']) && $v['year'] ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
				        	}
				        	?>
	        				<option  <?=  (isset($v['year']) && $v['year'] == 'morethan10' ? 'selected' : '')  ?>  value="morethan10">More than 10 years</option>
		    			</select>
	       			</div>
		  		</div>
		  		<div class="col-md-4 otherdrughistoryfldpasttimes">
		   			<div class="crose_year">
		    			<button  type="button" class="btn waves-effect waves-light btn-icon-round"><i class="fas fa-times"></i></button>
		   			</div>
		  		</div>
		 	</div>
		</div>
	</div>
<?php } } ?>
	<div class="row otherdrughistorypastfld  on_load_display_none_cls">
	    <div class="col-md-4">
         	<div class="form-group form_fild_row">
         		<label>Drug Name</label>
	      		<input type="text"  value="" <?php echo empty($user_data->is_otherdrugpast) ? 'disabled' : ''; ?>   class="form-control"  name="other_drug_history_past[name][]"  placeholder=""/>
	     	</div>
		</div>
		<div class="col-md-4">
	     	<div class="row">
		  		<div class="col-md-8">
		   			<div class="form-group form_fild_row">
		   				<label>How many years?</label>
  						<select class="form-control"  <?php echo empty($user_data->is_otherdrugpast) ? 'disabled' : ''; ?>   name="other_drug_history_past[year][]" >
	        				<option value=""></option>
				        	<?php
				        	$cnt = 1;

				        	for($cnt ; $cnt<= 10 ; $cnt++){
				        		echo "<option  value=".$cnt.">".$cnt."</option>";
				        	}
				        	?>
	        				<option value="morethan10">More than 10 years</option>
		    			</select>
	       			</div>
		  		</div>
			  	<div class="col-md-4 otherdrughistoryfldpasttimes ">
			   		<div class="crose_year">
			    		<button  type="button" class="btn waves-effect waves-light btn-icon-round"><i class="fas fa-times"></i></button>
			   		</div>
			  	</div>
		 	</div>
		</div>
	</div>
	<div class="row ">
	    <div class="col-md-6">
		 	<div class="form-group form_fild_row">
				<div class=" otherdrughistoryfldpastadd">
		   			<div class="crose_year">
		    			<button  type="button"  class="btn btn-medium   <?php echo empty($user_data->other_drug_history_past) ? 'on_load_display_none_cls' : '' ;  ?>">Add a drug</button>

		   			</div>
		  		</div>
		 	</div>
		</div>
	</div>
<script type="text/javascript">

$(document).ready(function() {
$(document).on("change", "input[type='radio'].otherdrugpast", function () {

    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
        	$('.otherdrughistorypastfld').addClass('elem_display_none') ;
$('.otherdrughistorypastfld input, .otherdrughistorypastfld select').attr('disabled', 'disabled');
        	   $('.otherdrughistorypastfld button').hide();
        	    $('.otherdrughistoryfldpastadd button').hide();
        }else{
        		$('.otherdrughistorypastfld').removeClass('elem_display_none') ;
$('.otherdrughistorypastfld input, .otherdrughistorypastfld select').removeAttr('disabled', 'disabled');
        	 $('.otherdrughistorypastfld button').show();
        	 $('.otherdrughistoryfldpastadd button').show();
        	  $('.otherdrughistoryfldpastadd button').removeClass('on_load_display_none_cls');
        }
    }
});

});

</script>

<script type="text/javascript">

$(document).ready(function() {
 $(document).on("click",".otherdrughistoryfldpastadd button",function() {

		var cloneob = $( ".otherdrughistorypastfld:last" ).clone();
		$( cloneob ).find('input').each(function() {

				$(this).removeAttr('disabled');
							  $(this).val('');
							    });
$( cloneob ).find('select').each(function() {
				$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
				$(this).removeAttr('disabled');
							  $(this).val('');
							    });

		$( cloneob ).insertAfter( ".otherdrughistorypastfld:last" );


	});
 $(document).on("click",".otherdrughistoryfldpasttimes button",function() {
 	$(this).parents('.otherdrughistorypastfld').remove();
 });

});

</script>

<input type="hidden" name="load_the_shots_tab" value="1">
<div class="back_next_button">
	<ul>
		<li>
		  	<button id="allergies-tab-backbtn" type="button" class="btn">Back</button>
	    </li>
	    <li>
		 	<button type="submit"  name="tab_number" value="6"  class="btn">Next</button>
	    </li>
	</ul>
</div>
<!--  *********  other drug history (past) end ********************** -->

<script type="text/javascript">

		/*$(document).ready(function(){
			$("#social_back_btn").click(function(){
				// new the previous tab is allergies tab

			    // $("#shots-tab").trigger("click");
			    $("#allergies-tab").trigger("click");

				// $('#checkshots').val(1);
				$('#checkallergy').val(1);
			    // window.location = "#shots-tab";
			    window.location = "#allergies-tab";
			});
			$("#social_next_btn").click(function(){
			    $("#additional-tab").trigger("click");
			    $('#checkobgyn').val(1);
			     window.location = "#additional-tab";
			});
		});
*/
	   	</script>

	</div>
</div>


	 <?php $this->Form->end() ; ?>
	<script type="text/javascript">

	 	$("#form_tab_6").validate({

			ignore: ':hidden:not(.do_not_ignore)',
		  	showErrors: function(errorMap, errorList) {
	  		  	if(errorList.length>0){
	        		$("#form_tab_6 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
	    		}
		 	},
		 	submitHandler: function(form) {
            formsubmit(form);

        }
		});
	</script>

<?php } ?>
<?php  if($user_data->gender == 0) {  ?>
	<?php

	if($active_tab == 7){

		echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_7')); ?>

		<div class="tab-pane fade <?= $active_tab == 7 ? '  show active ' : '' ?>" id="additional" role="tabpanel" aria-labelledby="additional-tab">
		  	<div class="TitleHead">
		   		<h3>OB/GYN</h3>
		   		<div class="seprator"></div>
		  	</div>
      		<div class="tab_form_fild_bg">
				<div class="row">
					<div class="col-md-12">
						<div class="radio_bg">
						  	<label>Have you previously been pregnant? (including miscarriages and/or abortions) </label>
						  	<div class="radio_list">
						  		<div class="form-check">
						     		<input type="radio"  value="1"  <?php echo isset($womandata->is_previous_birth) && !is_null($womandata->is_previous_birth) && $womandata->is_previous_birth == 1 ? 'checked = checked' : '' ;  ?>   class="form-check-input  check_previous_pregnancy" id="materialUnchecked10" name="womenspecific[is_previous_birth]">
						     		<label class="form-check-label" for="materialUnchecked10">Yes</label>
						   		</div>
								<div class="form-check">
								    <input type="radio"  value="0"  <?php echo  isset($womandata->is_previous_birth) &&  !is_null($womandata->is_previous_birth) &&  is_numeric($womandata->is_previous_birth) &&   $womandata->is_previous_birth == 0 ? 'checked = checked' : '' ;  ?>   class="form-check-input  check_previous_pregnancy" id="materialUnchecked11" name= "womenspecific[is_previous_birth]">
								    <label class="form-check-label" for="materialUnchecked11">No</label>
		   						</div>
	      					</div>
		 				</div>
					</div>
					<script type="text/javascript">
					$(document).on("click", "input[type='radio'].check_previous_pregnancy", function () {
					    if($(this).is(':checked')) {
					    	// alert($(this).val());
					        if ($(this).val() == 0) {
					            $('.previous_pregnancy_field').hide();
					             // $(this).parents('.radio_list').css('margin-bottom', '20px');
					        }else{
					            $('.previous_pregnancy_field').show();
					            $('.previous_pregnancy_field').removeClass('on_load_display_none_cls');


					        }
					    }
					});

					</script>
	   			</div>
	   			<div class="row">
					<div class="col-md-3  previous_pregnancy_field   <?php echo empty($womandata->is_previous_birth)  ? 'on_load_display_none_cls' : '' ;  ?>">
						<div class="form-group form_fild_row">
							<label>Number of pregnancies</label>
							<select class="form-control"    name="womenspecific[no_of_pregnency]" >
								<option value=""></option>
					        	<?php
					        	$cnt = 0;

					        	for($cnt ; $cnt<= 15 ; $cnt++){
					        		echo "<option ".(isset($womandata->no_of_pregnency) && is_numeric($womandata->no_of_pregnency) && $womandata->no_of_pregnency == $cnt ? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
					        	}
					        	?>
							</select>
	     				</div>
					</div>
					<div class="col-md-5   previous_pregnancy_field   <?php echo empty($womandata->is_previous_birth)  ? 'on_load_display_none_cls' : '' ;  ?>">
		 				<div class="form-group form_fild_row">
		 					<label>Number of miscarriages and/or abortions</label>
							<select class="form-control"    name="womenspecific[no_of_miscarriage]" >
								<option value=""></option>
					        	<?php
					        	$cnt = 0;

					        	for($cnt ; $cnt<= 15 ; $cnt++){
					        		echo "<option ".(isset($womandata->no_of_miscarriage) && is_numeric($womandata->no_of_miscarriage) && $womandata->no_of_miscarriage == $cnt ? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
					        	}
					        	?>
								</select>
	     					</div>
						</div>
	    				<div class="col-md-4   previous_pregnancy_field   <?php echo empty($womandata->is_previous_birth)  ? 'on_load_display_none_cls' : '' ;  ?>">
		 					<div class="form-group form_fild_row">
		 						<label>Number of live births</label>
								<select class="form-control"    name="womenspecific[no_of_live_birth]" >
						        	<option value=""></option>
						        	<?php
						        	$cnt = 0;

						        	for($cnt ; $cnt<= 15 ; $cnt++){
						        		echo "<option ".(isset($womandata->no_of_live_birth) && is_numeric($womandata->no_of_live_birth)  && $womandata->no_of_live_birth == $cnt ? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
						        	}
						        	?>
								</select>
	     					</div>
						</div>
       				</div>
					<!-- ************     repeatable fields based on given birth radio button ------------->
				<?php

				$ch = 1;
				if(!empty($womandata->prev_birth_detail)){


					$prev_birth_detail = unserialize((Security::decrypt(base64_decode($womandata->prev_birth_detail), SEC_KEY))) ;


				foreach ($prev_birth_detail['previous_birth_sex'] as $key => $value) {

				?>


				<div class="prev_given_birth_repeatable  previous_pregnancy_field    <?php echo empty($womandata->is_previous_birth) ? 'on_load_display_none_cls' : '' ;  ?>">
					<div class="row">
						<div class="col-md-12 close_prev_child_info_close">
							<div class="TitleHead" style="float: left;">
								<h3>	child <?= $ch ?> </h3>
								<div class="seprator"></div>
							</div>
							<div class="crose_year">
								<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6   ">
						 	<div class="form-group form_fild_row">
						  	<label>Child gender </label>
					      	<select  class="form-control"  name="womenspecific[prev_birth][previous_birth_sex][]" placeholder="">
						   		<option value=""></option>
						   		<option  <?= isset($prev_birth_detail['previous_birth_sex'][$key]) && $prev_birth_detail['previous_birth_sex'][$key]==1? 'selected' : '' ?>  value="1">Male</option>
						   		<option  <?= isset($prev_birth_detail['previous_birth_sex'][$key]) && $prev_birth_detail['previous_birth_sex'][$key]==0? 'selected' : '' ?>   value="0">Female</option>
						  	</select>
						</div>
					</div>
					<div class="col-md-3">
		   				<div class="form-group form_fild_row">
		   					<label>Choose Month</label>
	        				<select class="form-control" name="womenspecific[prev_birth][previous_birth_month][]">
	        					<option value=""></option>
	        					<?php
		        					$cur_mon = 0 ;
									$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']	 ;
						        	for($cur_mon ; $cur_mon <=  11 ; $cur_mon++){
						        		echo "<option  ".(isset($prev_birth_detail['previous_birth_month'][$key]) && is_numeric($prev_birth_detail['previous_birth_month'][$key]) && $prev_birth_detail['previous_birth_month'][$key]==$cur_mon? 'selected' : '')."  value=".$cur_mon.">".$month_name[$cur_mon]."</option>";
						        	}
	        					?>
		    				</select>
		   				</div>
					</div>
					<div class="col-md-3">
					   <div class="form-group form_fild_row">
					   		<label>Choose Year</label>
				        	<select class="form-control" name="womenspecific[prev_birth][previous_birth_year][]">
				        		<option value=""></option>
				        		<?php
				        			$curyear = $curyearlast;
						        	for($curyear ; $curyear>= $start_year ; $curyear--){
						        		echo "<option  ".(isset($prev_birth_detail['previous_birth_year'][$key]) && $prev_birth_detail['previous_birth_year'][$key]==$curyear? 'selected' : '')."   value=".$curyear.">".$curyear."</option>";
						        	}
				        		?>
					    	</select>
					   	</div>
					</div>
				</div>
      			<div class="row">
					<div class="col-md-6">
						<div class="form-group form_fild_row">
							<label>Delivery method</label>
						    <select  class="form-control"  name="womenspecific[prev_birth][previous_delivery_method][]" placeholder="">
							   <option value=""></option>
							   <option  <?= isset($prev_birth_detail['previous_delivery_method'][$key]) && is_numeric($prev_birth_detail['previous_delivery_method'][$key]) && $prev_birth_detail['previous_delivery_method'][$key]==0? 'selected' : '' ?> value="0">Vaginal delivery</option>
							   <option  <?= isset($prev_birth_detail['previous_delivery_method'][$key]) && $prev_birth_detail['previous_delivery_method'][$key]==1? 'selected' : '' ?> value="1">C-section </option>
							</select>
						</div>
					</div>
	    			<div class="col-md-6">
		 				<div class="form-group form_fild_row">
		 					<label>Pregnancy duration (weeks)</label>
							<select class="form-control"    name="womenspecific[prev_birth][previos_pregnancy_duration][]"  >
				                <option value=""></option>
				                <?php
				            		$cnt = 20;
					                for($cnt ; $cnt<= 50 ; $cnt++){
					                    echo "<option ".(isset($prev_birth_detail['previos_pregnancy_duration'][$key] ) && $prev_birth_detail['previos_pregnancy_duration'][$key] == $cnt ? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
					                }
				                ?>
				            </select>
	     				</div>
					</div>
       			</div>
		       	<div class="row">
			    	<div class="col-md-6">
				 		<div class="form-group form_fild_row">
							<label>Complications</label>
			      			<input type="text" class="form-control"  value="<?= isset($prev_birth_detail['previous_complication'][$key] ) ? $prev_birth_detail['previous_complication'][$key] : '' ?>"   name="womenspecific[prev_birth][previous_complication][]" placeholder=""/>
			     		</div>
					</div>
			    	<div class="col-md-6">
				 		<div class="form-group form_fild_row">
				 			<label>Hospital</label>
			      			<input type="text" class="form-control"   value="<?= isset($prev_birth_detail['previous_hospital'][$key]) ? $prev_birth_detail['previous_hospital'][$key] : '' ?>"   name="womenspecific[prev_birth][previous_hospital][]" placeholder=""/>
			     		</div>
					</div>
		       	</div>
			</div>
	<?php
	$ch++; 	}

	}
	?>
	<div class="prev_given_birth_repeatable p_g_b_r_static on_load_display_none_cls">

		<div class="row">
			<div class="col-md-12 close_prev_child_info_close">
				<div class="TitleHead" style="float: left;">
					<h3></h3>
					<div class="seprator"></div>
				</div>
				<div class="crose_year">
					<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6   ">
				<div class="form-group form_fild_row">
				  	<label>Child gender </label>
			      	<select  class="form-control"  disabled name="womenspecific[prev_birth][previous_birth_sex][]" placeholder="">
				   		<option value=""></option>
				   		<option   value="1">Male</option>
				   		<option   value="0">Female</option>
				  	</select>
				</div>
			</div>
			<div class="col-md-3">
		   		<div class="form-group form_fild_row">
		   			<label>Choose Month</label>
	        		<select class="form-control" disabled name="womenspecific[prev_birth][previous_birth_month][]">
	        			<option value=""></option>
			        	<?php
			        		$cur_mon = 0 ;
							$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']	 ;
				        	for($cur_mon ; $cur_mon <=  11 ; $cur_mon++){
				        		echo "<option  value=".$cur_mon.">".$month_name[$cur_mon]."</option>";
				        	}
			        	?>
		    		</select>
		   		</div>
			</div>
			<div class="col-md-3">
		   		<div class="form-group form_fild_row">
		   			<label>Choose Year</label>
	        			<select class="form-control" disabled name="womenspecific[prev_birth][previous_birth_year][]">
	        				<option value=""></option>
	        				<?php
					        	$curyear = $curyearlast;

					        	for($curyear ; $curyear>= $start_year ; $curyear--){
					        		echo "<option   value=".$curyear.">".$curyear."</option>";
					        	}
					        ?>
		    			</select>
		   			</div>
				</div>
			</div>
      		<div class="row">
				<div class="col-md-6">
		 			<div class="form-group form_fild_row">
		  				<label>Delivery method</label>
	      				<select  class="form-control" disabled name="womenspecific[prev_birth][previous_delivery_method][]" placeholder="">
		   					<option value=""></option>
						   <option  value="0">Vaginal delivery</option>
						   <option  value="1">C-section </option>
		  				</select>
		 			</div>
				</div>
	    		<div class="col-md-6">
		 			<div class="form-group form_fild_row">
		 				<label>Pregnancy duration (weeks)</label>
						<select class="form-control"   name="womenspecific[prev_birth][previos_pregnancy_duration][]"  >
                			<option value=""></option>
			                <?php
			            		$cnt = 20;
				                for($cnt ; $cnt<= 50 ; $cnt++){
				                    echo "<option  value=".$cnt.">".$cnt."</option>";
				                }
			                ?>
            			</select>
	     			</div>
				</div>
       		</div>
       		<div class="row">
	    		<div class="col-md-6">
		 			<div class="form-group form_fild_row">
		 				<label>Complications</label>
	      				<input type="text" disabled class="form-control"  value=""   name="womenspecific[prev_birth][previous_complication][]" placeholder=""/>
	     			</div>
				</div>
	    		<div class="col-md-6">
		 			<div class="form-group form_fild_row">
		 				<label>Hospital</label>
	      				<input type="text" disabled class="form-control"   value=""   name="womenspecific[prev_birth][previous_hospital][]" placeholder=""/>
	     			</div>
				</div>
       		</div>
		</div>

<script type="text/javascript">

var ch = <?= $ch ?> ;

$(document).ready(function() {
	var flag_close_btn = true ;
 $(document).on("click",".add_prev_child_info_add button",function() {

 	var cloneob = 	$( ".prev_given_birth_repeatable:last" ).clone() ;

$( cloneob ).find('.TitleHead h3').html('Child '+ch);
ch++;
		$( cloneob ).find('input').each(function() {
				$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
				$(this).removeAttr('disabled');

							    });
		$( cloneob ).find('select').each(function() {
				$(this).removeAttr('disabled');
							    });
$( cloneob ).removeClass('p_g_b_r_static').addClass('previous_pregnancy_field').insertAfter( ".prev_given_birth_repeatable:last" );


 });


  $(document).on("click",".close_prev_child_info_close button",function() {

  	$(this).parents('.prev_given_birth_repeatable').remove();

  });

});

</script>
<!-- ************     repeatable fields based on given birth radio button ------------->
<div class="row">
	<div class="col-md-6 previous_pregnancy_field add_prev_child_info_add   <?php echo empty($womandata->is_previous_birth)  ? 'on_load_display_none_cls' : '' ;  ?>">
		   <div class="crose_year">
		    	<button  type="button"  class="btn">Add a previous child info</button>
		   	</div>
		</div>
	</div>
	<div class="row" style="margin-top: 15px; ">
		<div class="col-md-6">
			<div class="TitleHead">
				   <!-- <h3>	Additional Fields </h3> -->
				   <h3>Women's Health</h3>
				   <div class="seprator"></div>
			  </div>
		</div>
	</div>
	<div class="row">

		<div class="col-md-3">
			<div class="form-group form_fild_row">
			 	<label>Age of first period</label>
		      	<input   type="number" pattern="[0-9]*" inputmode="numeric"  class="form-control ageoffirstpriod" value="<?= isset($womandata->age_of_first_priod) ? $womandata->age_of_first_priod : '' ?>" name="womenspecific[age_of_first_priod]" placeholder=""/>
		    </div>
		</div>
		<div class="col-md-3">
			<div class="form-group form_fild_row">
		 		<div class="radio_bg">
		  			<label>Was the last pap smear regular?</label>
		  			<div class="radio_list">
		  				<div class="form-check">
						     <input type="radio" class="form-check-input check_regular_papsmear"  <?php echo  isset($womandata->is_regular_papsmear) &&  !is_null($womandata->is_regular_papsmear) && $womandata->is_regular_papsmear == 1 ? 'checked = checked' : '' ;  ?>  id="is_regular_papsmear1" value="1" name="womenspecific[is_regular_papsmear]">
						     <label class="form-check-label" for="is_regular_papsmear1">Yes</label>
		   				</div>
						<div class="form-check">
					     <input type="radio" class="form-check-input check_regular_papsmear" id="is_regular_papsmear" value="0"  <?php echo  isset($womandata->is_regular_papsmear) && !is_null($womandata->is_regular_papsmear) &&  is_numeric($womandata->is_regular_papsmear) &&  $womandata->is_regular_papsmear == 0 ? 'checked = checked' : '' ;  ?>  name= "womenspecific[is_regular_papsmear]">
					     <label class="form-check-label" for="is_regular_papsmear">No</label>
					   </div>
	      			</div>
		 		</div>
			</div>
		</div>
 		<div class="col-md-3">
			<div class="form-group form_fild_row">
	        	<label>Last pap smear month</label>
	          	<select class="form-control" name="womenspecific[papsmear_month]">
	            	<option value=""></option>
	            	<?php
	          			$cur_mon = 0 ;
						$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','November', 'December']  ;
			            for($cur_mon ; $cur_mon <=  11 ; $cur_mon++){
			              echo "<option  ".(is_numeric($womandata->papsmear_month) && $womandata->papsmear_month==$cur_mon? 'selected' : '')."  value=".$cur_mon.">".$month_name[$cur_mon]."</option>";
			            }
	            	?>
	        	</select>
       		</div>
 		</div>
 		<div class="col-md-3">
			<div class="form-group form_fild_row">
	        	<label>Last pap smear year</label>
	         	<select class="form-control" name="womenspecific[papsmear_year]">
	            	<option value=""></option>
	            	<?php
	          			$curyear = $curyearlast;
			            for($curyear ; $curyear>= $start_year ; $curyear--){
			              echo "<option  ".(isset($womandata->papsmear_year) && $womandata->papsmear_year==$curyear? 'selected' : '')."   value=".$curyear.">".$curyear."</option>";
			            }
	            	?>
	        	</select>
       		</div>
 		</div>
	</div>
	<div class="row not_regular_papsmear_field"  style="<?php echo isset($womandata->is_regular_papsmear) && $womandata->is_regular_papsmear == 0 ? '' : 'display: none;' ;  ?>">
		<div class="col-md-12">
	        <label>What were the findings/procedures?</label>
	          <input type='text'   value="<?= isset($womandata->papsmear_finding) && $womandata->is_regular_papsmear == 0 ? $womandata->papsmear_finding : '' ?>"  class="form-control"  name="womenspecific[papsmear_finding]"    placeholder=""/>
		</div>
	</div>
<script type="text/javascript">

$(document).on("click", "input[type='radio'].check_regular_papsmear", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
            $('.not_regular_papsmear_field').show();
             $('.not_regular_papsmear_field').removeClass('on_load_display_none_cls');
         	// $(this).parents('.radio_list').css('margin-bottom', '20px');
        }else{
            $('.not_regular_papsmear_field').hide();
            // $(this).parents('.radio_list').css('margin-bottom', '0px');
        }
    }
});

</script>
<div class="row mar15">
	<div class="col-md-12">
		<div class="radio_bg">
		  	<label>Have you ever been diagnosed with a sexually-transmitted infection? (aka STD) <a href="javascript:void(0)" data-toggle="tooltip" title="This information can be important for your doctor to know because some sexually-transmitted infections can increase the risk of certain medical conditions."><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
		  	<div class="radio_list">
		   		<div class="form-check">
		     		<input type="radio"  value="1"  <?php echo  isset($womandata->is_sti_std) && !is_null($womandata->is_sti_std) && $womandata->is_sti_std == 1 ? 'checked = checked' : '' ;  ?>   class="form-check-input  check_sti_std" id="materialUnchecked16" name="womenspecific[is_sti_std]">
		     		<label class="form-check-label" for="materialUnchecked16">Yes</label>
		   		</div>
			   <div class="form-check">
			     <input type="radio"  value="0"  <?php echo  isset($womandata->is_sti_std) &&  !is_null($womandata->is_sti_std) &&  is_numeric($womandata->is_sti_std) &&   $womandata->is_sti_std == 0 ? 'checked = checked' : '' ;  ?>   class="form-check-input  check_sti_std" id="materialUnchecked17" name= "womenspecific[is_sti_std]">
			     <label class="form-check-label" for="materialUnchecked17">No</label>
			   </div>

				<div class="form-check">
				     <input type="radio"  value="2"  <?php echo  isset($womandata->is_sti_std) && !is_null($womandata->is_sti_std) &&  $womandata->is_sti_std == 2 ? 'checked = checked' : '' ;  ?>   class="form-check-input  check_sti_std" id="materialUnchecked18" name= "womenspecific[is_sti_std]">
				     <label class="form-check-label" for="materialUnchecked18">Prefer not to answer</label>
		   		</div>
	      	</div>
		</div>
	</div>

</div>

<div class="row"  style="margin-top: 10px; margin-bottom: 10px;">
<div class="col-md-12 sti_std_field      <?php echo (empty($womandata->is_sti_std) || $womandata->is_sti_std !=1 )  ? 'on_load_display_none_cls' : '' ;  ?>">
	<table>

<?php
if(!empty($womandata->sti_std_detail))
    // $sti_std_detail = unserialize(base64_decode($womandata->sti_std_detail)) ;
 $sti_std_detail = unserialize((Security::decrypt(base64_decode($womandata->sti_std_detail), SEC_KEY))) ;

    else
    $sti_std_detail = array();
$sti_std_detail_arr = $sti_std_detail;

	$sti_std_disease = array("Human papillomavirus (HPV)", "Gonorrhea", "Chlamydia", "Genital herpes", "Syphilis", "Trichomoniasis", "HIV/AIDS", "OTHER");
	$i= 0;
	foreach ($sti_std_disease as $key => $value) {
		// if($i%2 == 0 && $i > 0) echo '</td><tr>'
?>
<tr>
	<td width="50%">

<div class="check_box_bg">
		 <div class="custom-control custom-checkbox">
          <input name="womenspecific[sti_std_detail][<?= $key ?>][sti_std_key]" value="<?= $key ?>" class="custom-control-input <?php echo $value == 'OTHER' ? 'otherstistd' : '' ; ?>" id="stistd<?php echo $key ; ?>" type="checkbox" <?= is_array($sti_std_detail) && ( $matched_key = array_key_exists($key, $sti_std_detail) ) ? 'checked' : '' ?>  >
          <label class="custom-control-label" for="stistd<?php echo $key ; ?>"><?php echo $value; ?></label>
         </div>
		 </div>

<?php if($key === 7) { ?>
<div class="row otherstistd_field" style="<?php echo is_array($sti_std_detail) && array_key_exists( 7 , $sti_std_detail)? '' : 'display: none' ; ?> ;">
	<div class="col-md-12 sti_std_field      <?php echo isset($womandata->is_sti_std) && $womandata->is_sti_std != 1 ? 'on_load_display_none_cls' : '' ;  ?>">

		<div class="form-group form_fild_row">
				 <!-- <label>Other STIs/STDs Detail?</label>		 -->
			      <input type="text" class="form-control"   value="<?php echo !empty($sti_std_detail['other']) ? $sti_std_detail['other'] : ''  ?>"   name="womenspecific[sti_std_detail][other]" placeholder=""/>
		</div>

	</div>
</div>
<?php } ?>

	</td>
	<td>
		   <div class="form-group form_fild_row">
		   	<label>Year contracted</label>
	        <select class="form-control" name="womenspecific[sti_std_detail][<?= $key ?>][year]">
	        	<option value=""></option>
	     		<option <?php echo ($matched_key && ($sti_std_detail[$key] == $curyear)  ? 'selected' : '');  ?> value="1">Childhood</option>
	        	<?php

	        $curyear = $curyearlast;
	        	for($curyear ; $curyear>= $start_year ; $curyear--){
	        		echo "<option  ".($matched_key && ($sti_std_detail[$key] == $curyear)  ? 'selected' : '')."  value=".$curyear.">".$curyear."</option>";
	        	}
	        	?>
		    </select>
		   </div>
	</td>

</tr>

<?php
$matched_key = false;
$i++;
	}

// $sti_std_detail = array_flip($sti_std_detail);

?>

</table>

		</div>
	</div>

	       <script type="text/javascript">
	$(document).on("click", "input[type='checkbox'].otherstistd", function () {
	 if($(this).is(':checked')) {
		$('.otherstistd_field').show();
		 $('.otherstistd_field').removeClass('on_load_display_none_cls');
	}else{
		$('.otherstistd_field').hide();
	}
	});

$(document).on("click", "input[type='radio'].check_sti_std", function () {
    if($(this).is(':checked')) {

        if ($(this).val() != 1) {
            $('.sti_std_field').hide();

        }else{
            $('.sti_std_field').show();
            $('.sti_std_field').removeClass('on_load_display_none_cls');

        }
    }
});

</script>

<div class="row" style="margin-top: 15px; ">
	<div class="col-md-6">
		<div class="TitleHead">
			   <!-- <h3>	Additional Fields </h3> -->
			   <h3>Breast History</h3>
			   <div class="seprator"></div>
		  </div>
	</div>
</div>


<div class="row" style="margin-bottom: 15px; ">

<div class="col-md-6">
		 <div class="radio_bg">
		  <label> Have you ever had a mammogram? </label>
		  <div class="radio_list">
		   <div class="form-check">
		     <input type="radio"  value="1"   <?php echo isset($womandata->is_mammogram) && !is_null($womandata->is_mammogram) && $womandata->is_mammogram == 1 ? 'checked = checked' : '' ;  ?>   class="form-check-input check_is_mammogram" id="is_mammogram14" name="womenspecific[is_mammogram]">
		     <label class="form-check-label" for="is_mammogram14">Yes</label>
		   </div>

		   <div class="form-check">
		     <input type="radio"  value="0"   <?php echo  isset($womandata->is_mammogram) && !is_null($womandata->is_mammogram) &&  is_numeric($womandata->is_mammogram) &&  $womandata->is_mammogram == 0 ? 'checked = checked' : '' ;  ?>  class="form-check-input check_is_mammogram" id="is_mammogram15" name= "womenspecific[is_mammogram]">
		     <label class="form-check-label" for="is_mammogram15">No</label>
		   </div>
	      </div>
		 </div>
		</div>




<div class="col-md-3  check_mammogram_field   <?php echo  !isset($womandata->is_mammogram) || is_null($womandata->is_mammogram) || $womandata->is_mammogram == 0 ? 'on_load_display_none_cls' : '' ;  ?> ">

       <div class="form-group form_fild_row">
        <label>Last mammogram month</label>
          <select class="form-control" name="womenspecific[mammogram_month]">
            <option value=""></option>
            <?php
          $cur_mon = 0 ;
$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']  ;
            for($cur_mon ; $cur_mon <=  11 ; $cur_mon++){
              echo "<option  ".(isset($womandata->mammogram_month) && is_numeric($womandata->mammogram_month) && $womandata->mammogram_month==$cur_mon? 'selected' : '')."  value=".$cur_mon.">".$month_name[$cur_mon]."</option>";
            }
            ?>
        </select>
       </div>

    </div>

<div class="col-md-3  check_mammogram_field <?php echo  !isset($womandata->is_mammogram) || is_null($womandata->is_mammogram) || $womandata->is_mammogram == 0 ? 'on_load_display_none_cls' : '' ;  ?>">

       <div class="form-group form_fild_row">
        <label>Last mammogram year</label>
          <select class="form-control" name="womenspecific[mammogram_year]">
            <option value=""></option>
            <?php
          $curyear = $curyearlast;

            for($curyear ; $curyear>= $start_year ; $curyear--){
              echo "<option  ".(isset($womandata->mammogram_year)  && is_numeric($womandata->mammogram_year) && $womandata->mammogram_year==$curyear? 'selected' : '')."   value=".$curyear.">".$curyear."</option>";
            }
            ?>
        </select>
       </div>

    </div>




       </div>

<script type="text/javascript">


$(document).on("click", "input[type='radio'].check_is_mammogram", function () {
    if($(this).is(':checked')) {



        if ($(this).val() == 0) {
            $('.check_mammogram_field').hide();

        }else{
            $('.check_mammogram_field').show();
            $('.check_mammogram_field').removeClass('on_load_display_none_cls');

        }
    }
});


</script>


       <div class="row" style="margin-bottom: 15px; ">

<div class="col-md-6">
		 <div class="radio_bg">
		  <label>Have you had any abnormal breast lumps? </label>
		  <div class="radio_list">
		   <div class="form-check">
		     <input type="radio"  value="1"   <?php echo  isset($womandata->previous_abnormal_breast_lump) && !is_null($womandata->previous_abnormal_breast_lump) && $womandata->previous_abnormal_breast_lump == 1 ? 'checked = checked' : '' ;  ?>   class="form-check-input check_breast_lump" id="materialUnchecked14" name="womenspecific[previous_abnormal_breast_lump]">
		     <label class="form-check-label" for="materialUnchecked14">Yes</label>
		   </div>

		   <div class="form-check">
		     <input type="radio"  value="0"   <?php echo  isset($womandata->previous_abnormal_breast_lump) &&  !is_null($womandata->previous_abnormal_breast_lump) && is_numeric($womandata->previous_abnormal_breast_lump) &&  $womandata->previous_abnormal_breast_lump == 0 ? 'checked = checked' : '' ;  ?>  class="form-check-input check_breast_lump" id="materialUnchecked15" name= "womenspecific[previous_abnormal_breast_lump]">
		     <label class="form-check-label" for="materialUnchecked15">No</label>
		   </div>
	      </div>
		 </div>
		</div>

<div class="col-md-6  any_biopsy_field    <?php echo empty($womandata->previous_abnormal_breast_lump)  ? 'on_load_display_none_cls' : '' ;  ?>">
		 <div class="radio_bg">
		  <label>Did you have a biopsy of this lump? </label>
		  <div class="radio_list">
		   <div class="form-check">
		     <input type="radio"  value="1"   <?php echo  isset($womandata->any_biopsy) &&  !is_null($womandata->any_biopsy) &&  $womandata->any_biopsy == 1 ? 'checked = checked' : '' ;  ?>   class="form-check-input check_biopsy" id="any_biopsy1" name="womenspecific[any_biopsy]">
		     <label class="form-check-label" for="any_biopsy1">Yes</label>
		   </div>

		   <div class="form-check">
		     <input type="radio"  value="0"   <?php echo  isset($womandata->any_biopsy) && !is_null($womandata->any_biopsy) &&  is_numeric($womandata->any_biopsy) &&   $womandata->any_biopsy == 0 ? 'checked = checked' : '' ;  ?>  class="form-check-input  check_biopsy" id="any_biopsy2" name= "womenspecific[any_biopsy]">
		     <label class="form-check-label" for="any_biopsy2">No</label>
		   </div>
	      </div>
		 </div>
		</div>


       </div>




<!-- ************     repeatable fields based on given birth radio button ------------->


<?php


if(!empty($womandata->breast_lump_biopsy_result)){


$breast_lump_biopsy_result = unserialize((Security::decrypt(base64_decode($womandata->breast_lump_biopsy_result), SEC_KEY))) ;


foreach ($breast_lump_biopsy_result['biopsy_month'] as $key => $value) {

?>

<div class="biopsy_field_repeatable    check_biopsy_field any_biopsy_field    <?php echo !empty($womandata->previous_abnormal_breast_lump) &&  !empty($womandata->any_biopsy)  ? '' : 'on_load_display_none_cls' ;  ?>">

<div class="row"><div class="col-md-12 close_biopsy_info_close"><div class="crose_year"> <button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button></div></div></div>


<div class="row ">




<div class="col-md-3">

       <div class="form-group form_fild_row">
        <label>Choose Month</label>
          <select class="form-control" name="womenspecific[breast_lump_biopsy_result][biopsy_month][]">
            <option value=""></option>
            <?php
          $cur_mon = 0 ;
$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']  ;
            for($cur_mon ; $cur_mon <=  11 ; $cur_mon++){
              echo "<option  ".(isset($breast_lump_biopsy_result['biopsy_month'][$key]) && $breast_lump_biopsy_result['biopsy_month'][$key]==$cur_mon? 'selected' : '')."  value=".$cur_mon.">".$month_name[$cur_mon]."</option>";
            }
            ?>
        </select>
       </div>

    </div>

<div class="col-md-3">

       <div class="form-group form_fild_row">
        <label>Choose Year</label>
          <select class="form-control" name="womenspecific[breast_lump_biopsy_result][biopsy_year][]">
            <option value=""></option>
            <?php
          $curyear = $curyearlast;

            for($curyear ; $curyear>= $start_year ; $curyear--){
              echo "<option  ".(isset($breast_lump_biopsy_result['biopsy_year'][$key]) && $breast_lump_biopsy_result['biopsy_year'][$key]==$curyear? 'selected' : '')."   value=".$curyear.">".$curyear."</option>";
            }
            ?>
        </select>
       </div>

    </div>



<div class="col-md-6">
		 <div class="form-group form_fild_row">
		 <label>Breast Lump biopsy result</label>
	      <input type="text" class="form-control"  value="<?= isset($breast_lump_biopsy_result['biopsy_result'][$key] ) ? $breast_lump_biopsy_result['biopsy_result'][$key] : '' ?>" name="womenspecific[breast_lump_biopsy_result][biopsy_result][]" placeholder=""/>
	     </div>
		</div>
       </div>
</div>

<?php
  }

}


?>




<div class="biopsy_field_repeatable p_f_r_static     on_load_display_none_cls">

<div class="row"><div class="col-md-12 close_biopsy_info_close"><div class="crose_year"> <button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button></div></div></div>

<div class="row ">




<div class="col-md-3">

       <div class="form-group form_fild_row">
        <label>Choose Month</label>
          <select class="form-control" disabled name="womenspecific[breast_lump_biopsy_result][biopsy_month][]">
            <option value=""></option>
            <?php
          $cur_mon = 0 ;
$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']  ;
            for($cur_mon ; $cur_mon <=  11 ; $cur_mon++){
              echo "<option  value=".$cur_mon.">".$month_name[$cur_mon]."</option>";
            }
            ?>
        </select>
       </div>

    </div>

<div class="col-md-3">

       <div class="form-group form_fild_row">
        <label>Choose Year</label>
          <select class="form-control" disabled  name="womenspecific[breast_lump_biopsy_result][biopsy_year][]">
            <option value=""></option>
            <?php
          $curyear = $curyearlast;

            for($curyear ; $curyear>= $start_year ; $curyear--){
            echo "<option   value=".$curyear.">".$curyear."</option>";
            }
            ?>
        </select>
       </div>

    </div>



<div class="col-md-6">
		 <div class="form-group form_fild_row">
		 <label>Breast Lump biopsy result</label>
	      <input type="text"  disabled class="form-control"  value="" name="womenspecific[breast_lump_biopsy_result][biopsy_result][]" placeholder=""/>
	     </div>
		</div>
       </div>
</div>

<div class="row" style="margin-bottom: 10px;  ">
<div class="col-md-6 check_biopsy_field any_biopsy_field add_biopsy_info_add   <?php echo !empty($womandata->previous_abnormal_breast_lump) &&  !empty($womandata->any_biopsy)  ? '' : 'on_load_display_none_cls' ;  ?>">

       <div class="crose_year">
        <button  type="button"  class="btn">Add a previous biopsy info</button>
       </div>

    </div>
</div>

<input type="hidden" name="load_the_shots_tab" value="1">

<div class="back_next_button">
	    <ul>
		<li>
		  <button id="additional_back_btn" type="button" class="btn">Back</button>
	     </li>
		<!--  <li>
		  <button  id="additional_next_btn_sbmt"   type="submit"  name="load_the_shots_tab" value="1"  class="btn">Next</button>
	     </li> -->

	     <li>

			<button type="submit" name="tab_number" value="7" class="btn">Next</button>
	     </li>
		</ul>
	   </div>


<!-- <div class="back_next_button">
	    <ul>
		 <li>


<button type="submit" name="tab_name" value="<?= $tabcount++ ?>" class="btn">Save</button>
	     </li>
		</ul>
	   </div>	 -->




<script type="text/javascript">



$(document).ready(function() {
  var flag_close_btn = true ;
 $(document).on("click",".add_biopsy_info_add button",function() {

    var tempcln = $( ".biopsy_field_repeatable:last" ).clone()
 $(tempcln).find('input').each(function() {
			$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
				$(this).removeAttr('disabled');
                             $( this ).val( "" );
                           });
  $(tempcln).find('select').each(function() {
							$(this).removeAttr('disabled');
                             $( this ).val( "" );
                           });

 $(tempcln).removeClass('p_f_r_static').addClass('  check_biopsy_field any_biopsy_field ').insertAfter( ".biopsy_field_repeatable:last" );


 });


  $(document).on("click",".close_biopsy_info_close button",function() {

    $(this).parents('.biopsy_field_repeatable').remove();

  });

});

</script>




<script type="text/javascript">


$(document).on("click", "input[type='radio'].check_breast_lump", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());

        if ($(this).val() == 0) {
            $('.any_biopsy_field').hide();
         	// $(this).parents('.radio_list').css('margin-bottom', '20px');
        }else{
            $('.any_biopsy_field').show();
            $('.any_biopsy_field').removeClass('on_load_display_none_cls');



			        if ($("input[type='radio']:checked.check_biopsy").val() == 1) {

			         	 $('.check_biopsy_field').show();
			         	  $('.check_biopsy_field').removeClass('on_load_display_none_cls');
			        }else{

			       		 $('.check_biopsy_field').hide();
			        }

        }
    }
});



$(document).on("click", "input[type='radio'].check_biopsy", function () {
    if($(this).is(':checked')) {

    	 // alert($(this).val());

        if ($(this).val() == 0) {
            $('.check_biopsy_field').hide();
         	// $(this).parents('.radio_list').css('margin-bottom', '20px');
        }else{
            $('.check_biopsy_field').show();
             $('.check_biopsy_field').removeClass('on_load_display_none_cls');
            // $(this).parents('.radio_list').css('margin-bottom', '0px');
        }
    }
});


</script>





<script type="text/javascript">
	//  home-tab  profile-tab   contact-tab   family-tab  allergies-tab  shots-tab  social-tab  additional-tab
		$(document).ready(function(){
			$("#additional_back_btn").click(function(){
			    $("#social-tab").trigger("click");

$('#checksocial').val(1);
			       window.location = "#social-tab";
			});





		});

	   	</script>

	  </div>
	 </div>
<?php } ?>


	 <?php $this->Form->end() ; ?>
	<script type="text/javascript">

	 	$("#form_tab_7").validate({

			ignore: ':hidden:not(.do_not_ignore)',
		  	showErrors: function(errorMap, errorList) {
	  		  	if(errorList.length>0){
	        		$("#form_tab_7 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
	    		}
		 	},
		 	submitHandler: function(form) {
            formsubmit(form);

        }
		});
	</script>


<?php } ?>


<!-- 10-12-18 Shots tab should be the last tab and reload after submission of all tab start ***** -->

	<?php

	if($active_tab == 8){

		echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_8')); ?>


	<?php //echo $load_the_shots_tab.'  '.$active_tab;?>
	 <div class="tab-pane fade <?= $active_tab == 8 ? '  show active ' : '' ?>" id="shots1" role="tabpanel" aria-labelledby="shots1-tab">
	  <div class="TitleHead">
	   <h3>Shots</h3>
	   <h5 style="text-align: left;">Please provide information about your vaccine history:</h5><br>
	   <div class="seprator"></div>
	  </div>
<div class="tab_form_fild_bg">

<?php
// pr($shots_id_arr); die;
if(!empty($shots_id_arr)) {


	foreach($shots_id_arr as $k => $v) {
?>
	   <div class="row shotshistoryfld">
	    <div class="col-md-4">
		 <div class="form-group form_fild_row">
	      <!-- <input type="text" class="form-control" placeholder="Pneumonia"/>  -->
	      <label><?php echo $v; ?></label>

	     </div>
		</div>

		<div class="col-md-3">
		 <div class="form-group form_fild_row">
	      <!-- <input type="text" class="form-control" placeholder="Pneumonia"/>  -->



		<div class="custom-control custom-checkbox">

          <input name="shots_history[<?=  $k ?>][shot_id]" value="<?=  $k ?>" class="custom-control-input check_had_shot" id="shotid<?php echo $k ; ?>" <?= !empty($prev_shot_arr) && ($k_exst = array_key_exists($k, $prev_shot_arr )) ? 'checked' : ''  ?> type="checkbox"   >
          <label class="custom-control-label" for="shotid<?php echo $k ; ?>">I've had this shot.</label>
         </div>

	     </div>
		</div>


		<div class="col-md-5">
	     <div class="row">
		  <div class="col-md-7 ">
		   <div class="form-group form_fild_row">


	        <select class="form-control <?= !empty($k_exst) && $k_exst === true ? '' : 'on_load_display_none_cls' ?>"  name="shots_history[<?=  $k ?>][year]">
	        	<option value="">Year</option>

	<option <?php echo ( !empty($prev_shot_arr) && $k_exst === true  && $prev_shot_arr[$k] == 1 ? 'selected' : '' );  ?> value="1">Childhood</option>
	        	<?php
	     $curyear = $curyearlast;

	        	for($curyear ; $curyear>= $start_year ; $curyear--){
	        		echo "<option ".( !empty($prev_shot_arr) && $k_exst === true  && $prev_shot_arr[$k] == $curyear ? 'selected' : '' )."   value=".$curyear.">".$curyear."</option>";
	        	}
	        	?>
		    </select>


	       </div>
		  </div>

		  <div class="col-md-5 shotshistoryfldtimes">
		   <div class="crose_year">
		    <button  type="button" class="btn btn-icon-round"   style="margin:  3px 0px 3px 0px;"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div>

	   <?php } } ?>
	   <div class="row  shotshistoryfld on_load_display_none_cls">

	    <div class="col-md-4">
		 <div class="form-group form_fild_row">
	      <!-- <input type="text" class="form-control" placeholder="Pneumonia"/>  -->
	      <label class="immun_name"></label>

	     </div>
		</div>

		<div class="col-md-3">
		 <div class="form-group form_fild_row">
	      <!-- <input type="text" class="form-control" placeholder="Pneumonia"/>  -->



		<div class="custom-control custom-checkbox">

          <input name="" value="" class="custom-control-input check_had_shot" id="" type="checkbox">
          <label class="custom-control-label" for="">I've had this shot.</label>
         </div>

	     </div>
		</div>


		<div class="col-md-5 ">
	     <div class="row">
		  <div class="col-md-7">
		   <div class="form-group form_fild_row">


	        <select class="form-control on_load_display_none_cls"  name="">
	        	<option value="">Year</option>

	<option value="1">Childhood</option>
	        	<?php
	     $curyear = $curyearlast;

	        	for($curyear ; $curyear>= $start_year ; $curyear--){
	        		echo "<option    value=".$curyear.">".$curyear."</option>";
	        	}
	        	?>
		    </select>


	       </div>
		  </div>

		  <div class="col-md-5 shotshistoryfldtimes">
		   <div class="crose_year">
		    <button  type="button" class="btn btn-icon-round" style="margin: 3px 0px 3px 0px;"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>



	   </div>

	   <?php
$temp_other_shots_history = "";
if(!empty($user_data->other_shots_history)) 
{
	if(!empty($$user_data->other_shots_history))
	{

		$temp_other_shots_history = unserialize( (Security::decrypt(base64_decode($user_data->other_shots_history), SEC_KEY)) );
	}
}

$other_shots_counter = 0;
if(!empty($temp_other_shots_history)) {


	foreach($temp_other_shots_history as $k => $v) {
?>
	   <div class="row othershotshistoryfld">
	    <div class="col-md-4">
		 <div class="form-group form_fild_row">
	      <input type="text" class="form-control" placeholder="Shots name" value="<?php echo $v['name']; ?>" name="other_shots_history[name][]"/>
	      <label></label>

	     </div>
		</div>

		<div class="col-md-3">
		 <div class="form-group form_fild_row">

		<div class="custom-control custom-checkbox">

          <input name="other_shots_history[shot_id][]" value="<?=  $other_shots_counter ?>" class="custom-control-input other_check_had_shot" id="other_shotid<?php echo $other_shots_counter ; ?>" <?= isset($v['name']) && !empty($v['name']) ? 'checked' : ''  ?> type="checkbox"   >
          <label class="custom-control-label" for="other_shotid<?php echo $other_shots_counter ; ?>">I've had this shot.</label>
         </div>

	     </div>
		</div>


		<div class="col-md-5">
	     <div class="row">
		  <div class="col-md-7 ">
		   <div class="form-group form_fild_row">

	        <select class="form-control <?= isset($v['name']) && !empty($v['name']) ? '' : 'on_load_display_none_cls' ?>"  name="other_shots_history[year][]">
	        	<option value="">Year</option>

	<option <?php echo (isset($v['year']) && !empty($v['year']) && $v['year'] == 1 ? 'selected' : '' );  ?> value="1">Childhood</option>
	        	<?php
	     $curyear = $curyearlast;

	        	for($curyear ; $curyear>= $start_year ; $curyear--){
	        		echo "<option ".( isset($v['year']) && !empty($v['year']) && $v['year'] == $curyear ? 'selected' : '' )."   value=".$curyear.">".$curyear."</option>";
	        	}
	        	?>
		    </select>


	       </div>
		  </div>

		  <div class="col-md-5 shotshistoryfldtimes">
		   <div class="crose_year">
		    <button  type="button" class="btn btn-icon-round"   style="margin:  3px 0px 3px 0px;"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div>

	   <?php
	   $other_shots_counter++ ; 
	} } ?>

	<div class="row  othershotshistoryfld on_load_display_none_cls">

	    <div class="col-md-4">
		 <div class="form-group form_fild_row">
	      <input type="text" class="form-control" placeholder="Shots name" name="other_shots_history[name][]"/>
	      <label class="immun_name"></label>

	     </div>
		</div>

		<div class="col-md-3">
		 <div class="form-group form_fild_row">

		<div class="custom-control custom-checkbox">

          <input name="other_shots_history[shot_id][]" value="1" class="custom-control-input other_check_had_shot" id="" type="checkbox">
          <label class="custom-control-label" for="">I've had this shot.</label>
         </div>

	     </div>
		</div>


		<div class="col-md-5 ">
	     <div class="row">
		  <div class="col-md-7">
		   <div class="form-group form_fild_row">


	        <select class="form-control on_load_display_none_cls" name="other_shots_history[year][]">
	        	<option value="">Year</option>

	<option value="1">Childhood</option>
	        	<?php
	     $curyear = $curyearlast;

	        	for($curyear ; $curyear>= $start_year ; $curyear--){
	        		echo "<option    value=".$curyear.">".$curyear."</option>";
	        	}
	        	?>
		    </select>


	       </div>
		  </div>

		  <div class="col-md-5 othershotshistoryfldtimes">
		   <div class="crose_year">
		    <button  type="button" class="btn btn-icon-round" style="margin: 3px 0px 3px 0px;"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>



	   </div>

<?php /* // commented on 18-12-18 as add shot button is removed in requirement and only quickpicks will be there
*/ ?>

<div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">
<div class="other_shotshistoryfldadd">
		   <div class="crose_year">
		    <button  type="button"  class="btn">Add a shots</button>
		   </div>
		  </div>

		 </div>
		</div>
	</div>

<div class="row" style="display: none;">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">
<div class=" shotshistoryfldadd">
		   <div class="crose_year">
		    <button  type="button"  class="btn">Add a shots</button>
		   </div>
		  </div>

		 </div>
		</div>
	</div>

<script type="text/javascript">


$(document).ready(function(){

    // $('input[type="checkbox"].check_had_shot').click(function(){
 $(document).on("click","input[type='checkbox'].check_had_shot",function() {

        if($(this).is(":checked")){
            // alert("Checkbox is checked.");
         $(this).parents('.shotshistoryfld').find('select').removeClass('on_load_display_none_cls');
        } else{
        	// alert("Checkbox is not checked.");
       $(this).parents('.shotshistoryfld').find('select').addClass('on_load_display_none_cls');
        }
    });

});

$(document).on("click","input[type='checkbox'].other_check_had_shot",function() {

        if($(this).is(":checked")){
         $(this).parents('.othershotshistoryfld').find('select').removeClass('on_load_display_none_cls');
        } else{
       $(this).parents('.othershotshistoryfld').find('select').addClass('on_load_display_none_cls');
        }
    });



$(document).ready(function() {
	var other_shots_counter = "<?php echo $other_shots_counter; ?>"
 $(document).on("click",".other_shotshistoryfldadd button",function() {

		var cloneob = $(".othershotshistoryfld:last" ).clone();
		console.log(cloneob);

		$( cloneob ).find('input').each(function() {
				$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
				$(this).removeAttr('disabled');
							  $(this).val('');
							    });
			$( cloneob ).find('select').each(function() {
							$(this).removeAttr('disabled');
							  $(this).val('');
							    });		

		$(cloneob).insertAfter( ".othershotshistoryfld:last" );
		$(".othershotshistoryfld:last").find('.custom-checkbox input').attr('value', other_shots_counter ) ;
		$(".othershotshistoryfld:last").find('.custom-checkbox input').prop('checked',false) ;
		$(".othershotshistoryfld:last").find('.custom-checkbox input').attr('id', 'other_shotid'+other_shots_counter ) ;
		$(".othershotshistoryfld:last").find('.custom-checkbox label').attr('for', 'other_shotid'+other_shots_counter++) ;


	});

 $(document).on("click",".shotshistoryfldadd button",function() {

		var cloneob = $(".shotshistoryfld:last" ).clone();

		$( cloneob ).find('input').each(function() {
				$(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
				$(this).removeAttr('disabled');
							  $(this).val('');
							    });
			$( cloneob ).find('select').each(function() {
							$(this).removeAttr('disabled');
							  $(this).val('');
							    });


		$(cloneob).insertAfter( ".shotshistoryfld:last" );


	});

 
 $(document).on("click",".shotshistoryfldtimes button",function() {

 	var remove_val = $(this).parents('.shotshistoryfld').find('.col-md-4 label').text().trim();
 	var flag = false;
 	console.log(remove_val);
 	$(this).parents('.shotshistoryfld').remove();

 	$('.shotshistoryfld .col-md-4 label').each(function(){

 		if(remove_val == $(this).text()){

 			flag = true;
 		}
 		//console.log($(this).val());
 	});

 	if(!flag){

 		$('.shotscondboxdiv button').each(function(){

 			var attr = $(this).attr('condval');
 			if(remove_val == attr){

 				$(this).removeClass('selected_chief_complaint');
 			}
 		})
 	}

 });

 $(document).on("click",".othershotshistoryfldtimes button",function() {

 	$(this).parents('.othershotshistoryfld').remove();
 	
 });

 


});

</script>


<div class="common_conditions_button  shotscondboxdiv">
	    <h4>Common shots</h4>
		<ul>

			<?php
			$i = 0 ;
			foreach ($common_shot_cond as $key => $value) {

				$i++;
			?>
		 <li class="active medicalcondbottom">
		  <button  type="button"  condid="<?= $key ?>" condval="<?= $value ?>" class="btn <?php if(isset($shots_id_arr) && !empty($shots_id_arr) && in_array($value, $shots_id_arr)) { echo 'selected_chief_complaint'; }?>">
		   <i class="fas fa-plus-circle"></i>
		   <span><?= $value ?></span>
		  </button>
		 </li>
			<?php
			}

			?>

		</ul>
	   </div>

	   <div class="back_next_button">
	    <ul>

		 <li>
		  <button id="<?php echo $user_data['gender'] == 0 ? 'additional-tab-backbtn' : 'social-tab-backbtn' ?>" type="button" class="btn">Back</button>
	     </li>
		 <!-- <li>
		  <button id="shots_next_btn" type="button" class="btn">Next</button>
	     </li> -->

	     <li>
		 <button type="submit"  name="tab_number" value="8"  class="btn">Save</button>
	     </li>
		</ul>
	   </div>
<div class="back_next_button">
	    <ul>
		 <!-- <li>
		 <button type="submit"  name="tab_name" value="<?php //echo !empty($load_the_shots_tab) && $load_the_shots_tab==1 ? 8 : 7; ?>"  class="btn">Save</button>
	     </li> -->
		</ul>
	   </div>
	 <?php  if($user_data->gender == 0) {  ?>
<script type="text/javascript">
	//  home-tab  profile-tab   contact-tab   family-tab  allergies-tab  shots-tab  social-tab  additional-tab


		$(document).ready(function(){
			$("#shots_back_btn").click(function(){
			    $("#additional-tab").trigger("click");

//$('#checkobgyn').val(1);

			     window.location = "#additional-tab";
			});

		});

	   	</script>
	 <?php } else { ?>

<script type="text/javascript">
	//  home-tab  profile-tab   contact-tab   family-tab  allergies-tab  shots-tab  social-tab  additional-tab


		$(document).ready(function(){
			$("#shots_back_btn").click(function(){
			    $("#social-tab").trigger("click");

$('#checksocial').val(1);

			     window.location = "#social-tab";
			});

		});

	   	</script>
	 <?php }	?>

<script type="text/javascript">
	$(document).ready(function() {

 $(document).on("click",".shotscondboxdiv button",function() {
 	var  index = $(this).attr('condval');
 	var  index_id = $(this).attr('condid');
 	var cnt = 1;

 	var flag = true;

	if(flag){
$( ".shotshistoryfldadd button" ).trigger( "click" );
$(".shotshistoryfld:last").find('label.immun_name').html(index);
$(".shotshistoryfld:last").find('.custom-checkbox input').attr('name', 'shots_history['+index_id+'][shot_id]' ) ;
$(".shotshistoryfld:last").find('.custom-checkbox input').attr('value', index_id ) ;
$(".shotshistoryfld:last").find('.custom-checkbox input').attr('id', 'shotid'+index_id+cnt ) ;
$(".shotshistoryfld:last").find('.custom-checkbox label').attr('for', 'shotid'+index_id+cnt++ ) ;
$(".shotshistoryfld:last").find('select').attr('name', 'shots_history['+index_id+'][year]' ) ;



	}

	$(this).addClass('selected_chief_complaint');

		 });
 	});


</script>
	  </div>


	 </div>



	 <?php $this->Form->end() ; ?>
	<script type="text/javascript">

	 	$("#form_tab_8").validate({

			ignore: ':hidden:not(.do_not_ignore)',
		  	showErrors: function(errorMap, errorList) {
	  		  	if(errorList.length>0){
	        		$("#form_tab_8 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
	    		}
		 	},
		 	submitHandler: function(form) {
            formsubmit(form);

        }y
		});
	</script>

	<?php } ?>



<!-- 10-12-18 Shots tab should be the last tab and reload after submission of all tab end ******* -->












    </div>
       </div>


<!-- <input type="hidden" id="checkbasic" value="0"  name="check_emh_field_view[checkbasic]">
<input type="hidden"  id="checkmedical" value="0" name="check_emh_field_view[checkmedical]">
<input type="hidden"  id="checksurgical" value="0" name="check_emh_field_view[checksurgical]">
<input type="hidden"  id="checkfamily" value="0" name="check_emh_field_view[checkfamily]">
<input type="hidden"  id="checkallergy" value="0" name="check_emh_field_view[checkallergy]">
<input type="hidden"  id="checkshots" value="0" name="check_emh_field_view[checkshots]">
<input type="hidden"  id="checksocial" value="0" name="check_emh_field_view[checksocial]">
<input type="hidden"  id="checkobgyn" value="0" name="check_emh_field_view[checkobgyn]"> -->



<script type="text/javascript">
	//  home-tab  profile-tab   contact-tab   family-tab  allergies-tab  shots-tab  social-tab  additional-tab
		/*$(document).ready(function(){



$("#home-tab").click(function(){ $('#checkbasic').val(1); });
$("#profile-tab").click(function(){ $('#checkmedical').val(1); });
$("#contact-tab").click(function(){ $('#checksurgical').val(1); });
$("#family-tab").click(function(){ $('#checkfamily').val(1); });
$("#allergies-tab").click(function(){ $('#checkallergy').val(1); });
// $("#shots-tab").click(function(){ $('#checkshots').val(1); });
$("#social-tab").click(function(){ $('#checksocial').val(1); });
$("#additional-tab").click(function(){ $('#checkobgyn').val(1); });


		});*/

	   	</script>




      </div>



	 </div>
   	</div>
   </div>
  </div>
 </div>
</div>


<script type="text/javascript">
		$(document).ready(function(){
			$(".nav-item a").click(function(){
				 if ($(this).parents('#myTab').length > 0) {

					$('#myTab li').removeClass('active');
					$('#myTab li a').removeClass('active');
					// $(this).addClass('active');
				}
			});


$(document).on('keyup click', function(event) {

    if ( $('.custom-drop').has(event.target).length === 0)
    {
        $('.custom-drop-li').hide();
    }else{
    	 $(event.target).parents('.custom-drop').find('.custom-drop-li').show();
    }
});



 $('[name="weight"], [name="zip"],.ageoffirstpriod').keydown(function (e) {

        // Allow: backspace, delete, tab, escape, enter, dot and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110,190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
var patent_gender = "<?php echo $user_data->gender ?>" ;
//var all_field_atleast_click = <?php echo $all_field_atleast_click ;  ?> ;
//console.log(all_field_atleast_click);
//my_custom_validate(patent_gender, all_field_atleast_click);

  // $(document).on("blur", "#regster_form", function () {
  	$('#regster_form').on('keyup blur change', function(e) {

		//my_custom_validate(patent_gender , all_field_atleast_click);

	});




});


function my_custom_validate(patent_gender, all_field_atleast_click){
	var surgical_q_flg = false;
	var allergy_q_flg = false;
	var medical_q_flg = false;
	var family_q_flg = false;
	var msg = '' ;
	var atl_msg = '';
	var atl_flag = false ;
	if(all_field_atleast_click == 0 ){
		atl_msg += "<b>*Please visit all sections at least once.</b> <br />";
		atl_flag = true ;
	}

	/*if(validation_error == 1 ){
		atl_msg += "<b>*Please fill all required fields.</b> <br />";
		atl_flag = true ;
	}*/

	var is_retired = $('[name="is_retired"]').is(':checked');
	var is_race = $('[name="race"]').is(':checked');

	var occupation = $('[name="occupation"]').val().trim();
	var height = $('[name="height"]').val().trim();
	var height_inches = $('[name="height_inches"]').val().trim();
	var weight = $('[name="weight"]').val().trim();


	var address = $('[name="address"]').val().trim();
	var city = $('[name="city"]').val().trim();
	var state = $('[name="state"]').val().trim();
	var guarantor =  $('[name="guarantor"]').val().trim();
	var zip = $('[name="zip"]').val().trim();


	var sexual_orientation = $('[name="sexual_orientation"]').val().trim();
	var marital_status = $('[name="marital_status"]').is(':checked');
	var ethinicity = $('[name="ethinicity"]').val().trim();


	var is_check_med_his = $('[name="is_check_med_his"]').is(':checked');
	var is_check_surg_his = $('[name="is_check_surg_his"]').is(':checked');
	var is_check_allergy_his = $('[name="is_check_allergy_his"]').is(':checked');
	var is_family_his = $('[name="is_family_his"]').is(':checked');



	if($('[name="is_uterus_removal"]').length){
		var is_uterus_removal = $('[name="is_uterus_removal"]').is(':checked');
	}else{
		var is_uterus_removal = true;
	}

	if(is_check_surg_his && $('[name="is_check_surg_his"]:checked').val() == 0 && $('[name="is_uterus_removal"]').length){ // if first quesiton of surgical history is checked for no and second question exists (as second question does not exist for more than one time so we are chaecking length)
		var is_uterus_removal = true;
	}

	if($('[name="is_latex_allergy"]').length){
		var is_latex_allergy = $('[name="is_latex_allergy"]').is(':checked');
	}else{
		var is_latex_allergy = true;
	}

	if(is_check_allergy_his && $('[name="is_check_allergy_his"]:checked').val() == 0 && $('[name="is_latex_allergy"]').length){ // if first quesiton of allergy history is checked for no and second question exists
		var is_latex_allergy = true;
	}


	var currentlysmoking = $('[name="currentlysmoking"]').is(':checked');
	var pastsmoking = $('[name="pastsmoking"]').is(':checked');
	var currentlydrinking = $('[name="currentlydrinking"]').is(':checked');
	var pastdrinking = $('[name="pastdrinking"]').is(':checked');
	var otherdrug = $('[name="otherdrug"]').is(':checked');
	var otherdrugpast = $('[name="otherdrugpast"]').is(':checked');

	imageUrl_notactive = "<?= WEBROOT ?>images/step_number.png";
	imageUrl_active = "<?php echo $progress_bar_graphic ?>";
	imageUrl_error = "<?= WEBROOT ?>images/step_number_in_red.png";
	var flag = false ;
	var basic_flag = false;
	var social_flag = false;
	// basic information tab validation start
	if(!is_retired || !occupation || !height || !height_inches || !weight|| !sexual_orientation || !marital_status || !ethinicity || !address || !city || !state || !zip || !is_race || !guarantor){

	$('.step_head .step_tab ul li a#home-tab .step_number i').addClass('imageUrl_error');


		basic_flag = true;
	flag = true ;

	}else{

$('.step_head .step_tab ul li a#home-tab .step_number i').removeClass('imageUrl_error') ;


	}
	// basic information tab validation end
	// surgical history and allergy history tab validation start

	if((patent_gender == 0 && !is_uterus_removal ) || !is_check_surg_his){

	$('.step_head .step_tab ul li a#contact-tab .step_number i').addClass('imageUrl_error');

		// if(!flag)  window.location = "#contact-tab";
		// msg += "*Please reply the question in Surgical history.<br />";
		surgical_q_flg = true;
		flag = true ;

	}else{

$('.step_head .step_tab ul li a#contact-tab .step_number i').removeClass('imageUrl_error');

	}


	if((patent_gender == 0 && !is_latex_allergy ) || !is_check_allergy_his){

	$('.step_head .step_tab ul li a#allergies-tab .step_number i').addClass('imageUrl_error');


		allergy_q_flg = true;

		flag = true ;

	}else{
$('.step_head .step_tab ul li a#allergies-tab .step_number i').removeClass('imageUrl_error');

	}


	if(!is_check_med_his){

	$('.step_head .step_tab ul li a#profile-tab .step_number i').addClass('imageUrl_error');


		medical_q_flg = true;

		flag = true ;

	}else{
$('.step_head .step_tab ul li a#profile-tab .step_number i').removeClass('imageUrl_error');

	}



	if(!is_family_his){

	$('.step_head .step_tab ul li a#family-tab .step_number i').addClass('imageUrl_error');


		family_q_flg = true;

		flag = true ;

	}else{
$('.step_head .step_tab ul li a#family-tab .step_number i').removeClass('imageUrl_error');

	}

   var q_flag_msg = '';
   if(medical_q_flg){
   		q_flag_msg += 'medical history tab';
   }
   if(surgical_q_flg){
   	  if(family_q_flg || allergy_q_flg){
   	  		q_flag_msg += q_flag_msg ? ', surgical history tab' : 'surgical history tab';
   	  }else{
   	  	  q_flag_msg += q_flag_msg ? ' and surgical history tab' : 'surgical history tab';
   	  }

   }
   // alert(family_q_flg)
   if(family_q_flg){
   	  if(allergy_q_flg){
   	  	q_flag_msg +=  q_flag_msg ? ', family history tab' : 'family history tab';
   	  }else{
   	  	q_flag_msg +=  q_flag_msg ? ' and family history tab' : 'family history tab';
   	  }

   }
   if(allergy_q_flg){
   		q_flag_msg +=   q_flag_msg ? ' and allergies tab' : 'allergies tab';
   }

   q_flag_msg = q_flag_msg ? '*Please answer the questions in the '+q_flag_msg+'.<br />' : '';

   msg += q_flag_msg;


	// surgical history and allergy history tab validation end

	if(!currentlysmoking || !pastsmoking || !currentlydrinking || !pastdrinking || !otherdrug || !otherdrugpast){

		$('.step_head .step_tab ul li a#social-tab .step_number i').addClass('imageUrl_error');


		social_flag = true;

		flag = true ;
	}else{

$('.step_head .step_tab ul li a#social-tab .step_number i').removeClass('imageUrl_error');

	}



	if(basic_flag && social_flag ){
	msg = "*All fields in the basic information tab and social history tab are required.<br />"+msg
	}else if(basic_flag){
		msg = "*All fields in the basic information tab are required.<br />"+msg
	}else if(social_flag){
		msg += "*All fields in the social history tab are required.<br />"
	}


	if(flag){
		$('#errorHolder').addClass(' alert alert-danger').html(atl_msg+""+msg);
	}else if(atl_flag){
		$('#errorHolder').addClass(' alert alert-danger').html(atl_msg);

	} else {
		$('#errorHolder').removeClass(' alert alert-danger').empty();
	}


}




$(document).ready(function(){

	/*var shot_field_click_check = <?php //echo $shot_field_click_check ?>;
	if(shot_field_click_check != 1){
		$('.step_head .step_tab ul li a#shots11-tab .step_number i').addClass('imageUrl_error');
	}else{
		$('.step_head .step_tab ul li a#shots11-tab .step_number i').removeClass('imageUrl_error');
	}*/

<?php if($user_data->gender == 0) { ?>
	/*var obgyn_field_click_check = <?php //echo $obgyn_field_click_check ?>;
	if(obgyn_field_click_check != 1){
		$('.step_head .step_tab ul li a#additional-tab .step_number i').addClass('imageUrl_error');
	}else{
		$('.step_head .step_tab ul li a#additional-tab .step_number i').removeClass('imageUrl_error');
	}

$("#additional-tab").click(function(){
	$('.step_head .step_tab ul li a#additional-tab .step_number i').removeClass('imageUrl_error');
 });*/


<?php } ?>


	if($(window).width() < 700){

		$("#dash_chnge").html('dashboard');
		$("#new_apt_chnge").html('appointment');
		$("#prev_apt_chnge").html('summaries');
		$("#med_his_chnge").html('medical history');

	}

$( "select" ).each(function() {
 	if($(this).val())
		$(this).css('background','#fff');
	else
		$(this).css('background','#ececec');
});


 $(document).on("change","select",function() {

	if($(this).val())
		$(this).css('background','#fff');
	else
		$(this).css('background','#ececec');

});

// drop down fix for safari ios issue
var ua = navigator.userAgent.toLowerCase();
// alert(ua);
if (ua.indexOf('safari') != -1) {
  if (ua.indexOf('chrome') > -1) {
    // alert("1") // Chrome
    $('input, select').css('cursor', 'pointer');
  } else {
    // alert("2") // Safari
    $('input, select').css('cursor', 'pointer');
  }
}


});
// check if text is selected or not
function isTextSelected(input){
   var startPos = input.selectionStart;
   var endPos = input.selectionEnd;
   var doc = document.selection;

   if(doc && doc.createRange().text.length != 0){
      return true;
   }else if (!doc && input.value.substring(startPos,endPos).length != 0){
      return true;
   }
   return false;
}
</script>
<script type="text/javascript">

	$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});



// var min = 0;
// var second = 00;
// var zeroPlaceholder = 0;
// var counterId = setInterval(function() {
//     countUp();
// }, 1000);
//
// function countUp() {
//     second++;
//     if (second == 59) {
//         second = 00;
//         min = min + 1;
//     }
//     if (second == 10) {
//         zeroPlaceholder = '';
//     } else
//     if (second == 00) {
//         zeroPlaceholder = 0;
//     }
// 		$(".time").val(min + ':' + zeroPlaceholder + second)
// }
</script>
<!-- <script>
	let loading = async(msg ='') => {
        var homeLoader = $('.dashboard_content').loadingIndicator({
					useImage: false,
				}).data("loadingIndicator");
    }
	$('body').on('click','.back_next_button', function(e){
        loading();  
        homeLoader.hide();
	});
</script>
 -->