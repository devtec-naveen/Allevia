<?php
use Cake\Utility\Security;
use Cake\I18n\Time ;
use Cake\Routing\Router;
use Cake\Core\Configure;
$iframe_prefix = Configure::read('iframe_prefix');
$start_year = 1930;
$curyearlast = date("Y");
$selected_chief_complnts = array();
$getScheduleData = $this->General->get_schedule($schedule_id);
$is_cc_doctor_or_not = "";
$is_show_payment = '';
$int_cond_value = "";
$is_hide_summary = 0;
if(!empty($user_detail->appointment_id->schedule_id))
{
	$is_hide_summary = $this->General->is_show_summary($user_detail->appointment_id->schedule_id);
}
if(!empty($user_detail->appointment_id) && isset($user_detail->appointment_id->organization_id) && !empty($user_detail->appointment_id->organization_id) && isset($user_detail->appointment_id->organization_id->is_show_payment)){

		$is_show_payment = $user_detail->appointment_id->organization_id->is_show_payment;
		//pr($is_show_payment);die;
	}
if ($step_id == 25) {

		$inte_med_old_dqid_val =array();
		$old_internal_taps1_assessment_detail = array();
		$is_tap2 = '';
		$unique_taps1_val = array();
		if(!empty($user_detail_old->chief_compliant_userdetail->is_chief_complaint_doctor)){
			$inte_med_old_dqid_val = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->is_chief_complaint_doctor), SEC_KEY));
			$is_cc_doctor_or_not = $inte_med_old_dqid_val[556];
			// pr($is_cc_doctor_or_not);
		}
		if(!empty($user_detail_old->chief_compliant_userdetail->internal_taps1_assessment_detail)){
			$old_internal_taps1_assessment_detail = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->internal_taps1_assessment_detail), SEC_KEY));
			// pr($is_cc_doctor_or_not);
		}
		if(!empty($old_internal_taps1_assessment_detail))
          {
            $unique_taps1_val = array_unique($old_internal_taps1_assessment_detail);
            if(in_array("Never",$unique_taps1_val) && count($unique_taps1_val) == 1)
            { 
              //die('test');
             $is_tap2 = "no-taps2";
            }
        }
}
if(!empty($getScheduleData) && $getScheduleData['bare_bones'] == 1)
{
	?>
	<style type="text/css">
		@media only screen and (min-width:480px) and (max-width:767px){
			.header-sticky-tit { top: 0px !important; }
		}
		@media only screen and (min-width:0px) and (max-width:479px){
			.header-sticky-tit { top: 0px !important; }}
			.header-sticky-tit { background: #fff;
				position: sticky;
				top: 0px;
				z-index: 9;
				padding: 15px 0;}

	</style>

	<?php
}
else
{
	?>
	<style type="text/css">
		@media only screen and (min-width:480px) and (max-width:767px){
			.header-sticky-tit { top: 49px !important; }}
			@media only screen and (min-width:0px) and (max-width:479px){
			.header-sticky-tit { top: 49px !important; }}
		    .header-sticky-tit { background: #fff;
			position: sticky;
			top: 63px;
			z-index: 9;
			padding: 15px 0;}

	</style>
	<?php

}
/*$iframe_api_data = null;
$session = $this->request->getSession();
if ($session->check('iframe_api_data')) {

    $iframe_api_data  = $session->read('iframe_api_data');
}*/
//$iframe_prefix = Configure::read('iframe_prefix');
?>
<style type="text/css">
	.screening_detail_question_1_2 select.question_2{

		margin-bottom: 10px;
	}
   .followupmedicaltimes, .surgicalhistoryfldtimes, .allergyhistoryfldtimes .btn{ margin-top: 29px;  }

	.phq-9-section .btn{

		text-transform: none;
	}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2-bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo WEBROOT ?>css/tagsinput.css" rel="stylesheet" type="text/css">
<link href="<?php echo WEBROOT ?>css/jquery.timepicker.css" rel="stylesheet" type="text/css">
<link href="<?php echo WEBROOT.'frontend/css/new_appointment.css'; ?>" rel="stylesheet" type="text/css">
<link href="<?php echo WEBROOT ?>css/jquery.loading-indicator.css" rel="stylesheet"/>
<script src="<?php echo WEBROOT ?>js/tagsinput.js"></script>
<script src="<?php echo WEBROOT ?>js/jquery.timepicker.js"></script>
<script src="<?php echo WEBROOT.'frontend/js/new_appointment.js'; ?>"></script>

<?php $current_steps = explode(',', $next_steps) ;   ?>
<?php $session_user = $this->request->getSession()->read('Auth.User'); ?>
<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
    <?php if(empty($iframe_prefix)){ ?>
     <div class="dashboard_menu ">
      <ul>
	 <?php if(!empty($session_user) && $session_user['role_id'] == 2){ ?>

	<?php
	 	$schedule_slug = $schedule_id.'-'.time();
	 ?>

	 		<input type="hidden" class="timeinterval"/>
<!-- 	<li class="active">
		  <a href="<?= SITE_URL?>users/new-appointmentstep2/<?= base64_encode($apt_id) ?>/<?= base64_encode($next_steps) ?>/<?= $step_id ?>/<?= base64_encode($schedule_slug) ?>">
		   <i></i>
		   <span>Pre-appointment questionnaire</span>
		  </a>
		</li>

	 	<li>
	  <a href="<?= SITE_URL?>users/scheduled-appointments">
	   <i></i>
	   <span  id="prev_apt_chnge" >Scheduled Appointments</span>
	  </a>
	 </li>

	   <li>
	  <a href="<?= SITE_URL?>users/previous-appointment">
	   <i></i>
	   <span  id="prev_apt_chnge">Previous Appointments</span>
	  </a>
	 </li>

	 <li>
	  <a href="<?= SITE_URL?>users/medicalhistory">
	   <i></i>
	   <span id="med_his_chnge">Edit Medical History</span>
	  </a>
	 </li> -->
	 <?php } ?>
	  </ul>
     </div>
    <?php } ?>

	 <div class="dashboard_content animated fadeInRight ">
	  <div class="new_appointment_box">
	    <?= $this->Flash->render() ?>

	   <div class="dashboard_head">
	   <h2 style="text-transform: none;">For appointment with <?php echo $apt_id_data->doctor->doctor_name; ?>, <?php echo Time::now()->i18nFormat('MM/dd/yyyy') ?></h2>
	  </div>

	   <div class="edit_medical_box">
	   <div class="step_head step_head_deactive">
	    <div class="step_tab">
	  <ul class="nav nav-tabs" id="myTab" role="tablist">
	  	<?php $cnt_round_tab_num = 1; ?>
	  	<?php if(in_array(1, $current_steps)) {  ?>
	   <li class="nav-item <?= $tab_number==1   ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 1], 'id' => 'home-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link  <?= $tab_number==1   ? ' active ' : '' ?>" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected=" <?= $tab_number==1  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Chief Complaint</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(6, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==6 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 6], 'id' => 'other_detail-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==6  ) ? ' active ' : '' ?>" id="other_detail-tab" data-toggle="tab" href="#other_detail" role="tab" aria-controls="other_detail" aria-selected="<?= $tab_number==6   ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Other Details</span>
		</a>
	   </li>
	   <?php
	}
if(in_array(2, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==2 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 2], 'id' => 'profile-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==2  ) ? ' active ' : '' ?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="<?= $tab_number==2   ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Details</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(20, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==20 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    //['data' => ['edited_tab' => 20], 'id' => 'profile-tabpostlink'] // third
    ['data' => ['edited_tab' => 20], 'id' => 'chronic-pain-tabpostlink']
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==20  ) ? ' active ' : '' ?>" id="cronic_pain_assessment-tab" data-toggle="tab" href="#cronic_pain_assessment" role="tab" aria-controls="cronic_pain_assessment" aria-selected="<?= $tab_number==20   ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Chronic pain assessment</span>
		</a>
	   </li>
	   <?php
	}
	if(in_array(23, $current_steps) && $step_id == 25) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 23) ? ' active ' : '' ?>">
	   	<?php
		echo $this->Form->postLink(
	    "post link", // first
	    null,  // second
	    ['data' => ['edited_tab' => 23], 'id' => 'chronic_assessment-tabpostlink'] // third
		);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 23) ? ' active ' : '' ?>" id="chronic_assessment-tab" data-toggle="tab" href="#chronic_assessment" role="tab" aria-controls="chronic_assessment" aria-selected="<?= ($tab_number == 23) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Assessment</span>
		</a>
	   </li>
	   <?php
	}
	/* Focused History  */
	if(in_array(22, $current_steps)) {
	// different condition for 4th tab because some steps start with 4th tab
		   ?>

		   <li class="nav-item   <?= ($tab_number == 22 || ( $tab_number <= 22 && 22 == $current_steps[0])) ? ' active ' : '' ?>">
		   	<?php
	echo $this->Form->postLink(
	    "post link", // first
	    null,  // second
	    ['data' => ['edited_tab' => 22], 'id' => 'focused_history-tabpostlink'] // third
	);
		   	?>
		    <a class="nav-link   <?= ($tab_number == 22 || ( $tab_number <= 22 && 22 == $current_steps[0])) ? ' active ' : '' ?>" id="focused_history-tab" data-toggle="tab" href="#focused_history" role="tab" aria-controls="focused_history" aria-selected="<?= ($tab_number == 22 || ( $tab_number <= 22 && 22 == $current_steps[0])) ? ' true ' : ' false ' ?>">
			 <div class="step_number">
			  <i><?= $cnt_round_tab_num ++ ?></i>
			 </div>
			 <span>Focused History</span>
			</a>
		   </li>
		   <?php
	 }
	 if(in_array(28, $current_steps) && $step_id == 25) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 28) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 28], 'id' => 'cancer_medical_history-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 28) ? ' active ' : '' ?>" id="cancer_medical_history-tab" data-toggle="tab" href="#cancer_medical_history" role="tab" aria-controls="cancer_medical_history" aria-selected="<?= ($tab_number == 28) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Medical History</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(18, $current_steps)) {
	// different condition for 4th tab because some steps start with 4th tab
		   ?>

		   <li class="nav-item   <?= ($tab_number == 18 || ( $tab_number <= 18 && 18 == $current_steps[0])) ? ' active ' : '' ?>">
		   	<?php
	echo $this->Form->postLink(
	    "post link", // first
	    null,  // second
	    ['data' => ['edited_tab' => 18], 'id' => 'covid_detail-tabpostlink'] // third
	);
		   	?>
		    <a class="nav-link   <?= ($tab_number == 18 || ( $tab_number <= 18 && 18 == $current_steps[0])) ? ' active ' : '' ?>" id="covid_detail-tab" data-toggle="tab" href="#covid_detail" role="tab" aria-controls="covid_detail" aria-selected="<?= ($tab_number == 18 || ( $tab_number <= 18 && 18 == $current_steps[0])) ? ' true ' : ' false ' ?>">
			 <div class="step_number">
			  <i><?= $cnt_round_tab_num ++ ?></i>
			 </div>
			 <span>COVID-19 Screening</span>
			</a>
		   </li>
		   <?php
		}


	if(in_array(19, $current_steps)) {
// different condition for 4th tab because some steps start with 4th tab
	   ?>

	   <li class="nav-item   <?= ($tab_number == 19 || ( $tab_number <= 19 && 19 == $current_steps[0])) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 19], 'id' => 'phq_9-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 19 || ( $tab_number <= 19 && 19 == $current_steps[0])) ? ' active ' : '' ?>" id="phq_9-tab" data-toggle="tab" href="#phq_9" role="tab" aria-controls="phq_9" aria-selected="<?= ($tab_number == 19 || ( $tab_number <= 19 && 19 == $current_steps[0])) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>PHQ-9</span>
		</a>
	   </li>
	   <?php
	}


	if(in_array(17, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==17 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 17], 'id' => 'follow_up_sx_detail-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==17  ) ? ' active ' : '' ?>" id="follow_up_sx_detail-tab" data-toggle="tab" href="#follow_up_sx_detail" role="tab" aria-controls="follow_up_sx_detail" aria-selected="<?= $tab_number==17   ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Follow Up Details</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(24, $current_steps)) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 24) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 24], 'id' => 'chronic_condition-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 24) ? ' active ' : '' ?>" id="chronic_condition-tab" data-toggle="tab" href="#chronic_condition" role="tab" aria-controls="chronic_condition" aria-selected="<?= ($tab_number == 24) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Chronic Conditions</span>
		</a>
	   </li>
	   <?php
	}

		if(in_array(23, $current_steps) && $step_id != 25) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 23) ? ' active ' : '' ?>">
	   	<?php
		echo $this->Form->postLink(
	    "post link", // first
	    null,  // second
	    ['data' => ['edited_tab' => 23], 'id' => 'chronic_assessment-tabpostlink'] // third
		);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 23) ? ' active ' : '' ?>" id="chronic_assessment-tab" data-toggle="tab" href="#chronic_assessment" role="tab" aria-controls="chronic_assessment" aria-selected="<?= ($tab_number == 23) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Assessment</span>
		</a>
	   </li>
	   <?php
	}

if(in_array(3, $current_steps)) {

	   ?>

	   <li class="nav-item   <?= ($tab_number==3 ) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 3], 'id' => 'contact-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==3 ) ? ' active ' : '' ?>" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="<?= $tab_number==3  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Associated Symptoms</span>
		</a>
	   </li>
	   <?php
	}

if(in_array(10, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==10 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 10], 'id' => 'post_checkup_detail-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==10  ) ? ' active ' : '' ?>" id="post_checkup_detail-tab" data-toggle="tab" href="#post_checkup_detail" role="tab" aria-controls="post_checkup_detail" aria-selected="<?= $tab_number==10  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Post-procedure Checkup Detail</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(14, $current_steps)) {
// different condition for 4th tab because some steps start with 4th tab
	   ?>

	   <li class="nav-item   <?= ($tab_number == 14 || ( $tab_number <= 14 && 14 == $current_steps[0])) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 14], 'id' => 'disease-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 14 || ( $tab_number <= 14 && 14 == $current_steps[0])) ? ' active ' : '' ?>" id="disease-tab" data-toggle="tab" href="#disease" role="tab" aria-controls="disease" aria-selected="<?= ($tab_number == 14 || ( $tab_number <= 14 && 14 == $current_steps[0])) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Select Disease</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(15, $current_steps)) {
// different condition for 4th tab because some steps start with 4th tab
	   ?>

	   <li class="nav-item   <?= ($tab_number == 15 || ( $tab_number <= 15 && 15 == $current_steps[0])) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 15], 'id' => 'disease_detail-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 15 || ( $tab_number <= 15 && 15 == $current_steps[0])) ? ' active ' : '' ?>" id="disease_detail-tab" data-toggle="tab" href="#disease_detail" role="tab" aria-controls="disease_detail" aria-selected="<?= ($tab_number == 15 || ( $tab_number <= 15 && 15 == $current_steps[0])) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Disease Detail</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(9, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==9 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 9], 'id' => 'screening-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==9  ) ? ' active ' : '' ?>" id="screening-tab" data-toggle="tab" href="#screening" role="tab" aria-controls="screening" aria-selected="<?= $tab_number==9  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Screening</span>
		</a>
	   </li>
	   <?php
	}




	if(in_array(7, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==7 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 7], 'id' => 'general_updates-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==7  ) ? ' active ' : '' ?>" id="general_updates-tab" data-toggle="tab" href="#general_updates" role="tab" aria-controls="general_updates" aria-selected="<?= $tab_number==7   ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>General Updates</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(8, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==8 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 8], 'id' => 'pain_updates-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==8  ) ? ' active ' : '' ?>" id="pain_updates-tab" data-toggle="tab" href="#pain_updates" role="tab" aria-controls="pain_updates" aria-selected="<?= $tab_number==8   ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Pain Updates</span>
		</a>
	   </li>
	   <?php
	}


	if(in_array(11, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==11 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 11], 'id' => 'procedure_detail-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==11  ) ? ' active ' : '' ?>" id="procedure_detail-tab" data-toggle="tab" href="#procedure_detail" role="tab" aria-controls="procedure_detail" aria-selected="<?= $tab_number==11  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Procedure Details</span>
		</a>
	   </li>
	   <?php
	}



	if(in_array(12, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==12 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 12], 'id' => 'pre_op_medications-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==12  ) ? ' active ' : '' ?>" id="pre_op_medications-tab" data-toggle="tab" href="#pre_op_medications" role="tab" aria-controls="pre_op_medications" aria-selected="<?= $tab_number==12  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>
		 	<?php if($step_id == 15){

		 		echo 'Details';
		 	}else{  ?>
		 		Medications

		 	<?php } ?>
		 	</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(13, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number==13 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 13], 'id' => 'pre_op_allergies-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==13  ) ? ' active ' : '' ?>" id="pre_op_allergies-tab" data-toggle="tab" href="#pre_op_allergies" role="tab" aria-controls="pre_op_allergies" aria-selected="<?= $tab_number==13  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Allergies</span>
		</a>
	   </li>
	   <?php
	}


	if(in_array(25, $current_steps)) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 25) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 25], 'id' => 'cancer_cc-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 25) ? ' active ' : '' ?>" id="cancer_cc-tab" data-toggle="tab" href="#cancer_cc" role="tab" aria-controls="cancer_cc" aria-selected="<?= ($tab_number == 25) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Chief Complaints</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(26, $current_steps)) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 26) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 26], 'id' => 'cancer_history-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 26) ? ' active ' : '' ?>" id="cancer_history-tab" data-toggle="tab" href="#cancer_history" role="tab" aria-controls="cancer_history" aria-selected="<?= ($tab_number == 26) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Cancer History</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(30, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number == 30 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 30], 'id' => 'oncology_general-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link <?= ($tab_number== 30 ) ? ' active ' : '' ?>" id="oncology_general-tab" data-toggle="tab" href="#oncology_general" role="tab" aria-controls="oncology_general" aria-selected="<?= $tab_number==30 ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>General</span>
		</a>
	   </li>
	   <?php
	}


	if(in_array(31, $current_steps)) {
	?>

	   <li class="nav-item   <?= ($tab_number == 31 ) ? ' active ' : '' ?>">

	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 31], 'id' => 'oncology_medical_history-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link <?= ($tab_number == 31 ) ? ' active ' : '' ?>" id="oncology_medical_history-tab" data-toggle="tab" href="#oncology_medical_history" role="tab" aria-controls="oncology_medical_history" aria-selected="<?= $tab_number == 31 ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Medical History</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(27, $current_steps)) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 27) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 27], 'id' => 'cancer_assessments-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 27) ? ' active ' : '' ?>" id="cancer_assessments-tab" data-toggle="tab" href="#cancer_assessments" role="tab" aria-controls="cancer_assessments" aria-selected="<?= ($tab_number == 27) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Assessments</span>
		</a>
	   </li>
	   <?php
	}


	if(in_array(28, $current_steps) && $step_id != 25) {
	   ?>

	   <li class="nav-item   <?= ($tab_number == 28) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 28], 'id' => 'cancer_medical_history-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 28) ? ' active ' : '' ?>" id="cancer_medical_history-tab" data-toggle="tab" href="#cancer_medical_history" role="tab" aria-controls="cancer_medical_history" aria-selected="<?= ($tab_number == 28) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Medical History</span>
		</a>
	   </li>
	   <?php
	}

	if(in_array(29, $current_steps)) {
		 ?>

		 <li class="nav-item   <?= ($tab_number == 29) ? ' active ' : '' ?>">
			<?php
echo $this->Form->postLink(
		"post link", // first
		null,  // second
		['data' => ['edited_tab' => 29], 'id' => 'pre_op_post_op-tabpostlink'] // third
);
			?>
			<a class="nav-link   <?= ($tab_number == 29) ? ' active ' : '' ?>" id="pre_op_post_op-tab" data-toggle="tab" href="#pre_op_post_op" role="tab" aria-controls="pre_op_post_op" aria-selected="<?= ($tab_number == 29) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
			<i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Pre Post Op Details</span>
		</a>
		 </li>
		 <?php
	}

	if(in_array(32, $current_steps)) {
		 ?>

		 <li class="nav-item   <?= ($tab_number == 32) ? ' active ' : '' ?>">
			<?php
echo $this->Form->postLink(
		"post link", // first
		null,  // second
		['data' => ['edited_tab' => 32], 'id' => 'cancer_assessments-tabpostlink'] // third
);
			?>
			<a class="nav-link   <?= ($tab_number == 32) ? ' active ' : '' ?>" id="cancer_assessments-tab" data-toggle="tab" href="#cancer_assessments" role="tab" aria-controls="cancer_assessments" aria-selected="<?= ($tab_number == 32) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
			<i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Assessments</span>
		</a>
		 </li>
		 <?php
	}
	//pr($current_steps[0]);
	if(in_array(33, $current_steps)) {
// different condition for 4th tab because some steps start with 4th tab
	   ?>

	   <li class="nav-item   <?= ($tab_number == 33 || ( $tab_number == 33)) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 33], 'id' => 'hospital_er_info-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 33 || ( $tab_number == 33 )) ? ' active ' : '' ?>" id="hospital_er_info-tab" data-toggle="tab" href="#hospital_er_info" role="tab" aria-controls="hospital_er_info" aria-selected="<?= ($tab_number == 33 || ( $tab_number <= 33 && 33 == $current_steps[0])) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Hospital/ER Visit Details</span>
		</a>
	   </li>
	   <?php
	}
	if(in_array(34, $current_steps)) {
// different condition for 4th tab because some steps start with 4th tab
		 ?>

		 <li class="nav-item   <?= ($tab_number == 34 || ( $tab_number == 34)) ? ' active ' : '' ?>">
			<?php
echo $this->Form->postLink(
		"post link", // first
		null,  // second
		['data' => ['edited_tab' => 34], 'id' => 'psychiatry_follow_up-tabpostlink'] // third
);
			?>
			<a class="nav-link   <?= ($tab_number == 34 || ( $tab_number == 34 )) ? ' active ' : '' ?>" id="psychiatry_follow_up-tab" data-toggle="tab" href="#psychiatry_follow_up" role="tab" aria-controls="psychiatry_follow_up" aria-selected="<?= ($tab_number == 34 || ( $tab_number <= 34 && 34 == $current_steps[0])) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
			<i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>General</span>
		</a>
		 </li>
		 <?php
	}

	if(in_array(4, $current_steps)) {

		//pr($current_steps);die;
// different condition for 4th tab because some steps start with 4th tab
	   ?>

	   <li class="nav-item   <?= ($tab_number == 4 || ( $tab_number <= 4 && 4 == $current_steps[0])) ? ' active ' : '' ?>">
	   	<?php
			echo $this->Form->postLink(
			    "post link", // first
			    null,  // second
			    ['data' => ['edited_tab' => 4], 'id' => 'family-tabpostlink'] // third
			);
	   	?>
	    <a class="nav-link   <?= ($tab_number == 4 || ( $tab_number <= 4 && 4 == $current_steps[0])) ? ' active ' : '' ?>" id="family-tab" data-toggle="tab" href="#family" role="tab" aria-controls="family" aria-selected="<?= ($tab_number == 4 || ( $tab_number <= 4 && 4 == $current_steps[0])) ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Health Questionnaire</span>
		</a>
	   </li>
	   <?php
	}


	if(in_array(16, $current_steps)){
		   ?>

		   <li class="nav-item   <?= ($tab_number == 16 || ( $tab_number <= 16 && 16 == $current_steps[0])) ? ' active ' : '' ?>">
		   	<?php
	echo $this->Form->postLink(
	    "post link", // first
	    null,  // second
	    ['data' => ['edited_tab' => 16], 'id' => 'mad_refill_drug-tabpostlink'] // third
	);
		   	?>
		    <a class="nav-link   <?= ($tab_number == 16 || ( $tab_number <= 16 && 16 == $current_steps[0])) ? ' active ' : '' ?>" id="mad_refill_drug-tab" data-toggle="tab" href="#mad_refill_drug" role="tab" aria-controls="mad_refill_drug" aria-selected="<?= ($tab_number == 16 || ( $tab_number <= 16 && 16 == $current_steps[0])) ? ' true ' : ' false ' ?>">
			 <div class="step_number">
			  <i><?= $cnt_round_tab_num ++ ?></i>
			 </div>
			 <?php if($step_id == 26){?>
			 	<span>Assessments</span>
			 <?php }else{?>
			 <span>Extra Details</span>
			<?php }?>
			</a>
		   </li>
		   <?php
		}


	if(in_array(5, $current_steps)) {
	   ?>

	   <li class="nav-item   <?= ($tab_number==5 ) ? ' active ' : '' ?>">
	   	<?php
echo $this->Form->postLink(
    "post link", // first
    null,  // second
    ['data' => ['edited_tab' => 5], 'id' => 'allergies-tabpostlink'] // third
);
	   	?>
	    <a class="nav-link   <?= ($tab_number==5 ) ? ' active ' : '' ?>" id="allergies-tab" data-toggle="tab" href="#allergies" role="tab" aria-controls="allergies" aria-selected="<?= $tab_number==5  ? ' true ' : ' false ' ?>">
		 <div class="step_number">
		  <i><?= $cnt_round_tab_num ++ ?></i>
		 </div>
		 <span>Summary</span>
		</a>
	   </li>
	<?php } ?>

	  </ul>
	 </div>
	   </div>

	    	  <?= $this->Flash->render() ?>
	   <div class="tab-content" id="myTabContent">
	    <div class="tab_content_inner">

     	<?php
     	// convert next step id to array


if(in_array(1, $current_steps) && $tab_number == 1 ){
     	echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => $step_id == 25 || $step_id == 26 || $step_id == 28? "form_tab_36" :"form_tab_1")); ?>
		  <div class="tab-pane fade  <?= ($tab_number==1 || 1==$current_steps[0]) ? '  show active ' : '' ?>" id="home" role="tabpanel" aria-labelledby="home-tab">


<?php if(!($step_id == 5 || $step_id == 2 || $step_id == 10)){ // for step id 5 (well woman exam) and step id 2 (Annual Exam) this section not appear  ?>
	<div class="errorHolder">
  				</div>
	<div class="TitleHead header-sticky-tit">
			 <h3>Chief complaint</h3>
	</div>
	<!-- Psychiatry -->
	<?php if($apt_id_data->specialization_id == 1 && $step_id == 26){
	if(!empty($user_detail_old->chief_compliant_userdetail->chief_complaint_psychiatry))

			$old_chief_complaint_psychiatry = $user_detail_old->chief_compliant_userdetail->chief_complaint_psychiatry ;
			// $old_chief_complaint_psychiatry = isset($old_chief_complaint_psychiatry)?$old_chief_complaint_psychiatry:'';
			$old_dqid_val = !empty($old_chief_complaint_psychiatry) ? unserialize(Security::decrypt( base64_decode($old_chief_complaint_psychiatry), SEC_KEY)) :'';
			// pr($old_chief_complaint_psychiatry);
			$ic = 1;
			if(!empty($psychiatry_question))
			{$i =694;
				foreach($psychiatry_question as $key => $value)
				{
					// $old_dqid_val = !empty($old_chief_complaint_psychiatry[$value->id]) ? $old_chief_complaint_psychiatry : '';
					 // pr($old_dqid_val);
					switch ($value->question_type) {
						case 2;
						?>
						<?php if(in_array($value['id'],[694])){ ?>
						<div class="tab-pane fade  <?= ($tab_number==1  || 1==$current_steps[0])  ? '  show active ' : '' ?>" id="chief_complaint_psychiatry" role="tabpanel" aria-labelledby="chief_complaint_psychiatry-tab">
							<div class="TitleHead header-sticky-tit">
							   <h3><?php echo $value->question?><span class="required">*</span><br></h3>
							   <div class="seprator"></div>
							</div>
							<div class="tab_form_fild_bg">
								<!-- <div class="row"> -->
									<!-- <div class="col-md-12 "> -->
						 				<!-- <div class="form-group form_fild_row new_appoint_checkbox_quest_a">	 -->
						 			<div class="new_appoint_checkbox_quest">
						 										<span></span>
							<?php
							$options = unserialize($value->options) ;
						foreach ($options as $k => $v) {

							 ?>
							<div class="check_box_bg">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input chief_complaint_psychiatry_<?= $value->id ?> <?= !in_array(
									$k,["None"]) ? "chief_complaint_psychiatry_questions" :""?>" <?= !empty($old_dqid_val) && is_array($old_dqid_val[$value->id]) && in_array($k, $old_dqid_val[$value->id])   ? 'checked' : '' ?>  name="chief_complaint_psychiatry[<?= $value->id ?>][]" value="<?php echo $k ?>" required="true" id="checkbox_question<?= $i ?>"  type="checkbox">
									<label class="custom-control-label" for="checkbox_question<?= $i ?>"><?php echo $v ?></label>
								</div>
							</div>
							<?php $i++; } ?>
						</div>
					</div>
				</div>
				<?php }?>
						<?php break;
					default:
						// code...
						break;
				}?>


	<?php }} ?>


	<?php }?>
	<!-- End Psychiatry -->
	<!-- Internal Medication module -->
	<?php
	 if ($step_id == 25 || $step_id == 28) {

		$old_dqid_val =array();
		if(!empty($user_detail_old->chief_compliant_userdetail->is_chief_complaint_doctor)){
			$old_dqid_val = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->is_chief_complaint_doctor), SEC_KEY));
			$is_cc_doctor_or_not = $old_dqid_val[556];
			//pr($is_cc_doctor_or_not);
		}
		//pr($user_detail_old->chief_compliant_userdetail->is_chief_complaint_doctor);die;

		//pr($old_dqid_val);
		if(!empty($internal_medication_question))
		{
			foreach($internal_medication_question as $key => $value)
			{
				if(in_array($value->id,[556]))
				{
		?>
				 <div class="form-group form_fild_row">

 <div class="radio_bg">
          <label><?= in_array($value->id,[556]) ? $value->question :'';  ?>

          &nbsp;<span class="required">*</span></label>

<div class="radio_list">
				<?php $i =1;
				$options = unserialize($value->options) ;

					foreach ($options as $k => $v) {

						?>
        <div class="form-check">
         <input type="radio"  value="<?= $v ?>" <?= !empty($old_dqid_val[556]) && $old_dqid_val[556] == $v ? 'checked' : ''  ?>   class="form-check-input is_chief_complaint_doctor" id="radio_question<?= $i ?>" name="is_chief_complaint_doctor[<?= $value->id ?>]" required="true">
         <label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
       </div>
						<?php
						$i++ ;
					}
					?>

			</div>
		</div>
	</div>

	<?php
}
	}
}
}
?>
<!-- End internal medication -->
<?php
$display_none_at_load_time = '';
if(in_array($step_id, [25,28]) && $tab_number == 1)
{
	if(!empty($old_dqid_val[556]) && $old_dqid_val[556] == "No")
	{
		$display_none_at_load_time = "display_none_at_load_time";
	}
	else if(!empty($old_dqid_val[556]) && $old_dqid_val[556] == "Yes")
	{
		$display_none_at_load_time = "";
	}
	else
	{
		$display_none_at_load_time = "display_none_at_load_time";
	}
}
?>
	<div class="chief_complaint_section <?php echo in_array($step_id,[25,26,28]) ? $display_none_at_load_time:''?>">
	<?php echo $this->element('front/chief_complaint_tab');?>
	<!-- Womens health and current medication -->
	</div>


	<script type="text/javascript">
	$(document).on("click", "input[type='radio'].is_chief_complaint_doctor", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == "Yes") {
            $('.chief_complaint_section').addClass('display_none_at_load_time').show();
            $("#main_chief_compliant_id").prop('required',true);
            $("#chief_compliant_length").prop('required',true);
        }else{

        	$( "#main_chief_compliant_id" ).val("");
        	$("#chief_compliant_length").val("");
        	$(".symptom_suggestion").val("");
        	$("#main_chief_compliant_id").prop('required',false);
            $("#chief_compliant_length").prop('required',false);
        	$( ".medicalhistoryfldtimes button" ).trigger("click");

			// on first time when document load, read the input value of the taginput and enter each tag as separate tag
        	$('.chief_complaint_section').removeClass('display_none_at_load_time').hide();

        }
    }
});
</script>
<?php } ?>
<!-- medication -->
<div class="currentMedicationSection">
<div class="TitleHead header-sticky-tit">
			 <h3>Current medication</h3>
			</div>
		<!-- </div> -->
<!-- <div class="tab_form_fild_bg"> -->

<!-- fill the old data when edited start ******************************************************  -->

<?php
if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail)){
	$cmd_old = $user_detail_old->chief_compliant_userdetail->compliant_medication_detail;

	foreach ($cmd_old as $ky => $ve) {

?>

<div class="row  currentmedicationfld">
	    <div class="col-md-4">
		 <div class="form-group form_fild_row">


<div class="custom-drop">
		<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
	      <ul class="med_suggestion_listul custom-drop-li">
			</ul>

		</div>


	     </div>
		</div>


			<div class="col-md-2">
				 <div class="form-group form_fild_row">
				  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
				 </div>
				</div>

				<div class="col-md-2">
				 <div class="form-group form_fild_row">
				  <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->

				<select class="form-control" name="medication_how_often[]">
					<option value="">how often?</option>
				<?php
						foreach ($length_arr as $key => $value) {

					echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

						}
					?>
					</select>

				 </div>
				</div>
			    <div class="col-md-3">
				 <div class="form-group form_fild_row">


<div class="custom-drop">

<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
	      <ul class="how_taken_suggestion_listul custom-drop-li">
			</ul>

		</div>



				 </div>
				</div>


		<div class="col-md-1">
	     <div class="row">

		  <div class=" currentmedicationfldtimes">
		   <div class="crose_year">
		    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div>
<?php
}
}

?>
<!-- fill the old data when edited end ******************************************************* -->



	   <div class="row currentmedicationfld">

	   </div>


<div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">

		   <div class="crose_year">
		    <button  type="button"  class="btn currentmedicationfldadd btn-medium">add a medication</button>
		   </div>


		 </div>
		</div>
	</div>

<?php
	foreach ($default_med_chiefcom as $key => $value) {
		$default_med_chiefcom[$key] = explode(',', $default_med_chiefcom[$key]);
	}

?>

<div class="common_conditions_button chief_complaint_button medicationboxdiv">
				<ul class="quick_pick_chiefcom_medication">

				</ul>




			   </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

 $(document).on("click",".medicationboxdiv button",function() {
 	var  index = $(this).attr('chief_cmp_attrid');
 	var  indexval = $(this).attr('chief_cmp_attrid_val');
 	var  rxnormval = $(this).attr('rxnormid_attr');

 	var flag = true;


	$('input.medicationbox').each(function(i, obj) {
	    if($(obj).val()===""){
	    	flag = false;
	    	$(obj).val(indexval);
	    	return false;
	    }
	});
	if(flag){
		$( ".currentmedicationfldadd" ).trigger( "click" );
		$('input.medicationbox').each(function(i, obj) {
		    if($(obj).val()===""){
		    	$(obj).val(indexval);
		    	return false;
		    }
		});

	}

	$(this).addClass('selected_chief_complaint');




		 });
 	});


</script>


 <!-- Womens Health -->
 <!--  -----------------    woman specific fields  -------------------   -->
<?php
 //pr($login_user); die;
 if($login_user['gender'] == 0 && $apt_id_data->specialization_id != 3 && $apt_id_data->specialization_id != 4 && $step_id != 25) {  // this block will not be visible for orthopedic module and orthopedic spine module and hide this section for internal medicine module
?>

<div class="row">
<div class="col-md-12">
	<!-- <div class="tab_form_fild_bg"> -->
		    <div class="TitleHead header-sticky-tit">
			 <h3>Womens Health</h3>
			</div>
	<!-- </div> -->
</div>
</div>

<div class="row">


	<div class="col-md-3">
			 <div class="form-group form_fild_row">
	         <!-- <label>Last period date</label>		 -->
	         <label>Last period start date</label>
	         <input type='text'  class="form-control"  name="last_period_date"  id='datetimepicker1'  placeholder="" readonly />



	   <script>
	  $( function() {
	    $( "#datetimepicker1" ).datepicker({
	  dateFormat: "mm-dd-yy", // "dd-mm-yy"
	    // setDate: new Date('2014-12-18')
	});
	  old_lpd =  '<?php echo !empty($user_detail_old->chief_compliant_userdetail->last_period_date) ? $user_detail_old->chief_compliant_userdetail->last_period_date->i18nFormat('yyyy-MM-dd') : ''; ?>';
	  // alert(old_lpd) ;
	  if(old_lpd)
	     $("#datetimepicker1").datepicker('setDate', new Date(old_lpd));
// $('#datetimepicker1').datepicker().val(new Date('2008,9,3')).trigger('change')

	  } );
	  </script>
	</div>
	</div>
<?php
$old_flow_duration_in_days = '';
$old_cycle_length_in_days = '';
$old_was_it_regular_or_not = '';
if(!empty($user_detail_old->chief_compliant_userdetail->last_period_info)){
	$old_lpi = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->last_period_info), SEC_KEY))  ;
	// pr($old_lpi); die;
	$old_flow_duration_in_days = !empty($old_lpi['flow_duration_in_days']) ? $old_lpi['flow_duration_in_days'] : '' ;
	$old_cycle_length_in_days = !empty($old_lpi['cycle_length_in_days']) ? $old_lpi['cycle_length_in_days'] : '' ;
	$old_was_it_regular_or_not = isset($old_lpi['was_it_regular_or_not']) ? ($old_lpi['was_it_regular_or_not'] == 1 ? 1 : 0) : '' ;

}


?>
<div class="col-md-3">
					 <div class="form-group form_fild_row">
					 <label>Flow Duration(in days)</label>
					  <input type="number" value="<?= $old_flow_duration_in_days ?>" class="form-control"  name="last_period_info[flow_duration_in_days]" placeholder=""/>
					 </div>
					</div>




<div class="col-md-3">
					 <div class="form-group form_fild_row">
					<label>Cycle Length(in days)</label>
					  <input type="number"  value="<?= $old_cycle_length_in_days ?>"  class="form-control"  name="last_period_info[cycle_length_in_days]" placeholder=""/>
					 </div>
					</div>




<div class="col-md-3">
		 <div class="form-group form_fild_row">
 <div class="radio_bg">
          <label>Are your cycles regular? </label>

<div class="radio_list">

        <div class="form-check">
         <input type="radio"  value="1" <?= $old_was_it_regular_or_not === 1 ? 'checked' : '' ?>   class="form-check-input" id="was_it_regular_or_not1" name="last_period_info[was_it_regular_or_not]">
         <label class="form-check-label" for="was_it_regular_or_not1">Yes</label>
       </div>

	   <div class="form-check">
         <input type="radio"  value="0"  <?= $old_was_it_regular_or_not === 0 ? 'checked' : '' ?>    class="form-check-input" id="was_it_regular_or_not2" name="last_period_info[was_it_regular_or_not]">
         <label class="form-check-label" for="was_it_regular_or_not2">No</label>
       </div>

        </div>
</div>
</div>
</div>





</div>


<div class="row">

<div class="col-md-12">
		 <div class="form-group form_fild_row">
<!-- If there is a more recent pap smear than the one provided at signup or edit medical history? -->

 <div class="radio_bg">
 	<?php
$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']  ;
$old_imrp = '';
// pr($user_detail_old->chief_compliant_userdetail->if_more_recent_papsmear); die;
if(isset($user_detail_old->chief_compliant_userdetail->if_more_recent_papsmear))
$old_imrp = (int)$user_detail_old->chief_compliant_userdetail->if_more_recent_papsmear;

// pr($old_imrp); die;

$old_papsmear_month = '';
$old_papsmear_year =  '';
$old_was_it_regular_or_not =  '';
$old_any_findings_or_procedures =  '';


if(!empty($user_detail_old->chief_compliant_userdetail->last_pap_smear_info)){
	$old_lpsi =  unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->last_pap_smear_info), SEC_KEY));
	// pr($old_lpsi); die;
	$old_papsmear_month =  isset($old_lpsi['papsmear_month']) ? (int) $old_lpsi['papsmear_month'] : '' ;
	$old_papsmear_year =  isset($old_lpsi['papsmear_year']) ?  (int)  $old_lpsi['papsmear_year'] : '' ;
	$old_was_it_regular_or_not =  isset($old_lpsi['was_it_regular_or_not']) ? (int) $old_lpsi['was_it_regular_or_not'] : '' ;
	$old_any_findings_or_procedures =  isset($old_lpsi['any_findings_or_procedures']) ? $old_lpsi['any_findings_or_procedures'] : '' ;

}

// var_dump($old_was_it_regular_or_not); die;

 	?>
          <label> <?= !empty($womandata->papsmear_month) && !empty($womandata->papsmear_year) ? 'Is there a more recent pap smear than '.$month_name[$womandata->papsmear_month].'/'.$womandata->papsmear_year.'?' : 'Have you had a pap smear?' ?> </label>


<div class="radio_list">

        <div class="form-check">
         <input type="radio"  value="1"  <?= $old_imrp === 1 ? 'checked' : '' ?>  class="form-check-input check_recent_papsmear" id="if_more_recent_papsmear1" name="if_more_recent_papsmear">
         <label class="form-check-label" for="if_more_recent_papsmear1">Yes</label>
       </div>

	   <div class="form-check">
         <input type="radio"  value="0"    <?= $old_imrp === 0 ? 'checked' : '' ?>   class="form-check-input check_recent_papsmear" id="if_more_recent_papsmear2" name="if_more_recent_papsmear">
         <label class="form-check-label" for="if_more_recent_papsmear2">No</label>
       </div>

        </div>
</div>
</div>
</div>
</div>


<div class="row recent_papsmear_realted_fields" style="<?= $old_imrp == 1 ? "" : "display: none" ?>;">



<div class="col-md-3">
	 <div class="form-group form_fild_row">
	        <label>Last pap smear month</label>
	          <select class="form-control" name="last_pap_smear_info[papsmear_month]">
	            <option value=""></option>
	            <?php
	          $cur_mon = 0 ;
	$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']  ;
	            for($cur_mon ; $cur_mon <=  11 ; $cur_mon++){
	              echo "<option  ".( $old_papsmear_month === $cur_mon ? 'selected' : '')."  value=".$cur_mon.">".$month_name[$cur_mon]."</option>";
	            }
	            ?>
	        </select>
       </div>
</div>


<div class="col-md-3">
	 <div class="form-group form_fild_row">
	        <label>Last pap smear year</label>
	          <select class="form-control" name="last_pap_smear_info[papsmear_year]">
	            <option value=""></option>
	            <?php
	            $curyearlast = date("Y");
	          $curyear = $curyearlast;
	          $start_year = 1930;
	            for($curyear ; $curyear>= $start_year ; $curyear--){
	              echo "<option  ".( $old_papsmear_year === $curyear ? 'selected' : (!is_numeric($old_papsmear_year) && isset($womandata->papsmear_year) && $womandata->papsmear_year==$curyear? 'selected' : ''))."   value=".$curyear.">".$curyear."</option>";
	            }
	            ?>
	        </select>
       </div>
</div>
<div class="col-md-3">
		 <div class="form-group form_fild_row">
 <div class="radio_bg">
          <label>Was the last pap smear regular?</label>


<div class="radio_list">

        <div class="form-check">
         <input type="radio" <?= $old_was_it_regular_or_not == 1 ? 'checked' : '' ?> value="1"    class="form-check-input was_regular_papsmear" id="was_it_regular_or_not3" name="last_pap_smear_info[was_it_regular_or_not]">
         <label class="form-check-label" for="was_it_regular_or_not3">Yes</label>
       </div>

	   <div class="form-check">
         <input type="radio"  <?= $old_was_it_regular_or_not === 0 ? 'checked' : '' ?>   value="0"    class="form-check-input was_regular_papsmear" id="was_it_regular_or_not4" name="last_pap_smear_info[was_it_regular_or_not]">
         <label class="form-check-label" for="was_it_regular_or_not4">No</label>
       </div>

        </div>
</div>

</div>
</div>

<div class="col-md-4 was_regular_papsmear_field"  style="<?= $old_was_it_regular_or_not === 0 ? 'display: block' : 'display: none'; ?>;">
					 <div class="form-group form_fild_row">
Any Findings/Procedures ?
					  <input type="text" value="<?= $old_any_findings_or_procedures ?>" class="form-control"  name="last_pap_smear_info[any_findings_or_procedures]" placeholder=""/>
					 </div>
					</div>


</div>


<!-- Previous pregnancy related field start  ****************  -->
<?php
	$old_is_curently_pregnant = '' ;
   if(isset($user_detail_old->chief_compliant_userdetail->is_curently_pregnant)){
   		$old_is_curently_pregnant = (int) $user_detail_old->chief_compliant_userdetail->is_curently_pregnant;
   }


 ?>
<div class="row">
<div class="col-md-6">
	<div class="form-group form_fild_row">
         <div class="radio_bg">
          <label>Are you currently pregnant? </label>
          <div class="radio_list">

            <div class="form-check">
             <input type="radio" <?= $old_is_curently_pregnant == 1 ? 'checked' : ''  ?>  value="1"  class="form-check-input  check_current_pregnancy" id="materialUnchecked12" name="is_curently_pregnant">
             <label class="form-check-label" for="materialUnchecked12">Yes</label>
           </div>
            <div class="form-check">
             <input type="radio"  <?= $old_is_curently_pregnant === 0 ? 'checked' : ''  ?>   value="0"  class="form-check-input  check_current_pregnancy" id="materialUnchecked13" name= "is_curently_pregnant">
             <label class="form-check-label" for="materialUnchecked13">No</label>
           </div>



          </div>
         </div>
     </div>
        </div>


<?php
$old_cbs_male = '' ;
$old_cbs_female = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->current_baby_sex)){
		$old_current_baby_sex = $user_detail_old->chief_compliant_userdetail->current_baby_sex;
		$old_current_baby_sex = explode(',', $old_current_baby_sex);
		// pr($old_current_baby_sex);
		// echo $old_cbs_male .'<br>';
		foreach ($old_current_baby_sex as $ks => $vs) {

			$old_user_sex = array_filter(explode(" ", trim($vs)));
			//pr($old_user_sex);

			if(isset($old_user_sex[1]) && $old_user_sex[1] == 'female'){

				$old_cbs_female = (int) $vs;
				continue;
			}

			if(isset($old_user_sex[1]) && $old_user_sex[1] == 'male'){

				$old_cbs_male = (int) $vs;
				continue;
			}


		}
	}
	$old_currently_pregnant_week = '' ;

	$old_currently_pregnant_days =  '' ;

	$old_currently_pregnant_complication =  '' ;

	if(isset($user_detail_old->chief_compliant_userdetail->currently_pregnant_week) && is_numeric($user_detail_old->chief_compliant_userdetail->currently_pregnant_week))
		$old_currently_pregnant_week = (int) $user_detail_old->chief_compliant_userdetail->currently_pregnant_week;
	if(isset($user_detail_old->chief_compliant_userdetail->currently_pregnant_days) && is_numeric($user_detail_old->chief_compliant_userdetail->currently_pregnant_days))
		$old_currently_pregnant_days =  (int) $user_detail_old->chief_compliant_userdetail->currently_pregnant_days;
	if(isset($user_detail_old->chief_compliant_userdetail->currently_pregnant_complication) && is_numeric($user_detail_old->chief_compliant_userdetail->currently_pregnant_complication))
		$old_currently_pregnant_complication =    $user_detail_old->chief_compliant_userdetail->currently_pregnant_complication;


?>
<div class="col-md-6  current_pregnancy_field     on_load_display_none_cls">
         <div class="form-group form_fild_row">
     <div><label>Current baby gender(s)</label></div>
   <!--       <input type="text"  name="current_baby_sex" value="" data-role="tagsinput"  placeholder="Current baby gender (Male/Female)"  />
 -->
  <div class="row">
 <div class="col-md-12">
      <select style="display: inline-block; width: 110px; margin-bottom: 5px;  " class="form-control " name="current_baby_sex[]" >
      	<!-- <option selected value=""></option> -->
      	<option <?= $old_cbs_male === 0 ? 'selected' : ''  ?> value="0 male">0</option>
      	<option  <?= $old_cbs_male == 1 ? 'selected' : ''  ?>  value="1 male">1</option>
      	<option  <?= $old_cbs_male == 2 ? 'selected' : ''  ?>  value="2 male">2</option>
      	<option  <?= $old_cbs_male == 3 ? 'selected' : ''  ?>  value="3 male">3</option>
      	<option  <?= $old_cbs_male == 4 ? 'selected' : ''  ?>  value="4 male">4</option>
      	<option  <?= $old_cbs_male == 5 ? 'selected' : ''  ?>  value="5 male">5</option>
      </select> <label style="margin-right: 10px; ">Male</label>
<!-- </div>
<div class="col-md-6"> -->
      <select style="display: inline-block; width: 110px;   " class="form-control " name="current_baby_sex[]" >
      	<!-- <option selected value=""></option>    -->
      	<option <?= $old_cbs_female === 0 ? 'selected' : ''  ?>  value="0 female">0</option>
      	<option <?= $old_cbs_female == 1 ? 'selected' : ''  ?>  value="1 female">1</option>
      	<option <?= $old_cbs_female == 2 ? 'selected' : ''  ?>  value="2 female">2</option>
      	<option <?= $old_cbs_female == 3 ? 'selected' : ''  ?>  value="3 female">3</option>
      	<option <?= $old_cbs_female == 4 ? 'selected' : ''  ?>  value="4 female">4</option>
      	<option <?= $old_cbs_female == 5 ? 'selected' : ''  ?>  value="5 female">5</option>
      </select> <label>Female</label>
  </div>
</div>



         </div>
        </div>


       </div>


<div class="row">
        <div class="col-md-3  current_pregnancy_field on_load_display_none_cls ">
 <div class="form-group form_fild_row">
        <label>How many weeks?</label>
        <select class="form-control"    name="currently_pregnant_week" >
                <option value=""></option>
                <?php
            $cnt = 0;

                for($cnt ; $cnt<= 50 ; $cnt++){
                    echo "<option ".($old_currently_pregnant_week === $cnt ? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
                }
                ?>

                <!-- <option value="morethan10">More than 10 years</option> -->
            </select>

</div>

        </div>
        <div class="col-md-3  current_pregnancy_field on_load_display_none_cls ">
 <div class="form-group form_fild_row">
        <label>How many days?</label>

            <select class="form-control"    name="currently_pregnant_days" >
                <option value=""></option>
                <?php
            $cnt = 0;

                for($cnt ; $cnt<= 6 ; $cnt++){
                    echo "<option  ".($old_currently_pregnant_days === $cnt ? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
                }
                ?>

                <!-- <option value="morethan10">More than 10 years</option> -->
            </select>


</div>

        </div>
        <div class="col-md-6  current_pregnancy_field on_load_display_none_cls ">
        	 <div class="form-group form_fild_row">
        <label>Complications if any?</label>
            <input type='text'   value="<?= $old_currently_pregnant_complication ?>"  class="form-control"  name="currently_pregnant_complication"    placeholder=""/>
        </div>
        </div>
    </div>

<script type="text/javascript">

// $old_is_curently_pregnant == 1
$( document ).ready(function() {
  // Handler for .ready() called.
  var old_is_curently_pregnant = '<?= $old_is_curently_pregnant ?>';
// alert(old_is_curently_pregnant);
  if(parseInt(old_is_curently_pregnant)){
  	$('.current_pregnancy_field').show();
  }else{
  	// alert(old_is_curently_pregnant);
  	$('.current_pregnancy_field').hide();
  }

});

$(document).on("click", "input[type='radio'].check_current_pregnancy", function () {
    if($(this).is(':checked')) {
        // alert($(this).val());
        if ($(this).val() == 0) {
            $('.current_pregnancy_field').hide();
            // $(this).parents('.radio_list').css('margin-bottom', '20px');
        }else{
            $('.current_pregnancy_field').show();
            // $(this).parents('.radio_list').css('margin-bottom', '0px');
        }
    }
});

</script>



<!-- Previous pregnancy related field end  *************   -->



<?php } ?>


<!--  ------------------- woman specific fields  ----------- -->


<!--    ----------------  sexual specific fields -------------------     -->
<?php if($apt_id_data->specialization_id == 2 || $step_id == 5 || $step_id == 25){ // for step id 5 (well woman exam) this section  appear
if(!empty($user_detail_old->chief_compliant_userdetail->sexual_info))
  $old_si = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->sexual_info), SEC_KEY));
	$old_saon = isset($old_si['sexual_active_or_not']) ? (int) $old_si['sexual_active_or_not'] : '';
	$old_nop = !empty($old_si['no_of_partner']) ?  $old_si['no_of_partner'] : '';
	$old_puon = isset($old_si['protection_used_or_not']) ? (int) $old_si['protection_used_or_not'] : '';
	$old_pm = !empty($old_si['protection_method']) ?  $old_si['protection_method'] : '';


 ?>
<div class="row">

	<div class="col-md-3">
		 <div class="form-group form_fild_row">
    <div class="radio_bg">
          <h4>Are you sexually active? </h4>
		<div class="radio_list">

		        <div class="form-check">
		         <input type="radio"  value="1"  <?= $old_saon === 1 ? 'checked' : ''  ?>  class="form-check-input  check_sexual_active" id="sexual_active1" name="sexual_info[sexual_active_or_not]">
		         <label class="form-check-label" for="sexual_active1">Yes</label>
		       </div>

			   <div class="form-check">
		         <input type="radio"  value="0"   <?= $old_saon === 0 ? 'checked' : ''  ?>   class="form-check-input  check_sexual_active" id="sexual_active2" name="sexual_info[sexual_active_or_not]">
		         <label class="form-check-label" for="sexual_active2">No</label>
		       </div>

        </div>
</div>

		 </div>
	</div>

	<div class="col-md-4 sexual_active_related_field"  style="<?= $old_saon == 1 ? '' : 'display: none'  ?>;">
		 <div class="form-group form_fild_row">
Number of sexual partners?
		<input type="number" value="<?= $old_nop ?>" class="form-control"  name="sexual_info[no_of_partner]" />
		</div>
	</div>

<div class="col-md-3  sexual_active_related_field" style="<?= $old_saon == 1 ? '' : 'display: none'  ?>;">
		 <div class="form-group form_fild_row">
 <div class="radio_bg">
          <h4>Do you use any birth prevention methods?</h4>


		<div class="radio_list">

		        <div class="form-check">
		         <input type="radio"  value="1" <?= $old_puon === 1 ? 'checked' : '' ?>   class="form-check-input check_protection_used" id="use_protection1" name="sexual_info[protection_used_or_not]">
		         <label class="form-check-label" for="use_protection1">Yes</label>
		       </div>

			   <div class="form-check">
		         <input type="radio"  value="0"   <?= $old_puon === 0 ? 'checked' : '' ?>   class="form-check-input check_protection_used" id="use_protection2" name="sexual_info[protection_used_or_not]">
		         <label class="form-check-label" for="use_protection2">No</label>
		       </div>

        </div>
</div>

		 </div>
	</div>

</div>

<div class="row protection_used_related_field sexual_active_related_field"  style="<?= $old_saon == 1 && $old_puon == 1 ? '' : 'display: none'  ?>;">
<div class="col-md-12">
		 <div class="form-group form_fild_row">
Birth prevention method(s)
<div class="custom-drop">

<input type="text" value="<?= $old_pm ?>" name="sexual_info[protection_method]" class="form-control protection_method_suggestion"   data-role="tagsinput"  />
        <ul class="protection_method_suggestion_listul custom-drop-li" style="max-height: 200px; ">
      </ul>

    </div>


		</div>
	</div>


</div>

<script type="text/javascript">

$(document).ready(function() {

  	var prev_val = $('.protection_method_suggestion').val();
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


$(document).on("click", "input[type='radio'].check_sexual_active", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
            $('.sexual_active_related_field').hide();

        }else{

            $('.sexual_active_related_field').show();
if($("input[type='radio'].check_protection_used").is(':checked')){
	 $('.protection_used_related_field').show();
}else{
	 $('.protection_used_related_field').hide();
}

        }
    }
});


$(document).on("click", "input[type='radio'].check_protection_used", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {
            $('.protection_used_related_field').hide();

        }else{
            $('.protection_used_related_field').show();

        }
    }
});


// ************************************** tags input related code start *************


var protection_methods = '<?php    echo json_encode($protection_methods); ?>';  // this time data is read from the static php array (not from the ajax request)

  protection_methods = JSON.parse(protection_methods);




var taginputli_click = false;
var old_prev_search_val = '';
$('.protection_method_suggestion').tagsinput({
      allowDuplicates: true,

    });

$('.protection_method_suggestion').on('itemRemoved', function(event) {
     prev_search_val = '';
});

$('.protection_method_suggestion').on('itemAdded', function(event) {

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

searchRequest = null;

	if(e.type == 'keydown'){
		if(isTextSelected($(this).find('input')[0])){ // if text selected with back space we will reset search criteria
			// alert('yes') ;
		   //text selected
		   prev_search_val = '';
		}
	}

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
console.log(prev_search_val);
    var temphtml = '' ;
$.each(protection_methods, function (key, data) {

  if (value && (data.toLowerCase().indexOf(value.toLowerCase()) != -1)){
// alert(data); alert(value);
    temphtml += '<li protection_method_suggestion_attr ="'+data+'" >'+data+'</li>' ;
  } else if(!value) {

      temphtml += '<li protection_method_suggestion_attr ="'+data+'" >'+data+'</li>' ;
  }



});

if(!temphtml){
    $(this).parents('.custom-drop').find('.custom-drop-li').hide();
}else{
    $(this).parents('.custom-drop').find('.custom-drop-li').show();
  // $(this).next('.protection_method_suggestion_listul').html(temphtml);
}

$(this).parents('.custom-drop').find('.protection_method_suggestion_listul').html(temphtml);
});



// ajax search for diagnose start


$(document).on("click", ".protection_method_suggestion_listul li", function () {

	taginputli_click = true;  // this variable is used for tracking list item click above in taginput add tag event handler


    var diag_sugg_atr = $(this).attr('protection_method_suggestion_attr');
// alert(diag_sugg_atr);
// alert($(this).parents('.custom-drop').find('.prev_diagnose_suggestion').val());

    var tmptext = $(this).parents('.protection_method_suggestion_listul').prev('.protection_method_suggestion');

     var ttext = $(tmptext).val();
     // alert(ttext);
     if(ttext.indexOf(diag_sugg_atr) == -1){  // we will add the tag only when it is not added previously
        $(tmptext).tagsinput('add', diag_sugg_atr);
     }


    $(this).parents('.protection_method_suggestion_listul').empty();

});



</script>



<?php }  // for step id 5 (well woman exam) this section  appear  ?>
 <!-- End women health -->



</div>
<?php  // for step id 5 (well woman exam) and step id 2 (annual exam) this section not appear  ?>

<!-- <div class="tab_form_fild_bg"> -->

<!-- medication secton -->
<!-- End medication section -->
<!-- all jquery of chief_complaint_tab -->

<!-- end all jquery of chief_complaint_tab -->


<!--    ----------------  sexual specific fields -------------------     -->

<?php if($apt_id_data->specialization_id == 9 && in_array($step_id, [25,28])){
if(!empty($user_detail_old->chief_compliant_userdetail->chronic_condition))

		$old_chronic_condition = $user_detail_old->chief_compliant_userdetail->chronic_condition ;
		$old_chronic_condition = isset($old_chronic_condition)?$old_chronic_condition:'';


		$ic = 1;


     	 //echo $this->Form->create(null , array('autocomplete' => 'off',
							//'inputDefaults' => array(
							//'label' => false,
							//'div' => false,
							//),'enctype' => 'multipart/form-data', 'id' => 'form_tab_24'));
		//pr($internal_medication_question);
		if(!empty($internal_medication_question))
		{$i =1;
			foreach($internal_medication_question as $key => $value)
			{
				if(in_array($value->id,['704,705'])) continue;
				if(in_array($value->id,[557,606,558,605,559,560,704,705,706,707,708,709]))
				switch ($value->question_type) {
				case 0:
				?><div class="<?php echo in_array($value->id,[605]) ? "display_none_at_load_time is_chief_complaint_doctor_558_605": ""; ?><?php echo in_array($value->id,[705]) ? "display_none_at_load_time is_chief_complaint_doctor_704_705": ""; ?><?php echo in_array($value->id,[709]) ? "display_none_at_load_time is_chief_complaint_doctor_708_709": ""; ?><?php echo in_array($value->id,[706,707]) ? "display_none_at_load_time is_chief_complaint_doctor_560_706_707_708": ""; ?>">
	 					<div class="form-group form_fild_row">
	 						<label>
							<?= $value->question ?>&nbsp;<span class="required">*</span>
							</label>
								<input type="text" value="<?= !empty($old_dqid_val[$value->id]) ? $old_dqid_val[$value->id] :'' ?>" class="form-control is_chief_complaint_doctor_<?= $value->id ?>"  name="is_chief_complaint_doctor[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'question_'.$value->id; ?>"/>

	 					</div>
					</div>
					<?php
					break;
					case 2;
					?>
					<?php if(in_array($value->id,[557])){?>
					<div class="tab-pane fade  <?= ($tab_number==1  || 1==$current_steps[0])  ? '  show active ' : '' ?>" id="chronic_condition" role="tabpanel" aria-labelledby="chronic_condition-tab">
						<div class="TitleHead header-sticky-tit">
						   <h3><?php echo $value->question?><span class="required">*</span><br></h3>
						   <div class="seprator"></div>
						</div>
						<div class="tab_form_fild_bg">
							<!-- <div class="row"> -->
								<!-- <div class="col-md-12 "> -->
					 				<!-- <div class="form-group form_fild_row new_appoint_checkbox_quest_a">	 -->
					 			<div class="new_appoint_checkbox_quest">
					 										<span></span>
				 <!-- <div class="row">	 -->
						<?php
						$options = unserialize($value->options) ;


					foreach ($options as $k => $v) {

						 ?>
						<div class="check_box_bg">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input chronic_condition_<?= $k ?> <?= !in_array(
								$k,["none"]) ? "chronic_conditions_questions" :""?>" <?= is_array($old_chronic_condition) && in_array($k, $old_chronic_condition)   ? 'checked' : '' ?>  name="chronic_condition[]" value="<?php echo $k ?>" required="true" id="<?php echo $k?>"  type="checkbox">
								<label class="custom-control-label" for="<?php echo $k?>"><?php echo $v ?></label>
							</div>
						</div>
						<?php $i++; } ?>
					</div>
				</div>
			</div>	
			<?php } ?>
			<?php if(in_array($value['id'],[704,708])){ ?>
					<div class="tab-pane <?php echo in_array($value->id,[708]) ? "display_none_at_load_time is_chief_complaint_doctor_560_706_707_708": ""; ?>"  >
						<div class="TitleHead header-sticky-tit">
						   <h3><?php echo $value->question?><span class="required">*</span><br></h3>
						   <div class="seprator"></div>
						</div>
						<div class="tab_form_fild_bg">
							<!-- <div class="row"> -->
								<!-- <div class="col-md-12 "> -->
					 				<!-- <div class="form-group form_fild_row new_appoint_checkbox_quest_a">	 -->
					 			<div class="new_appoint_checkbox_quest">
					 										<span></span>
						<?php
						$options = unserialize($value->options) ;
					foreach ($options as $k => $v) {

						 ?>
						<div class="check_box_bg">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input is_chief_complaint_doctor_<?= $value->id ?> " <?= !empty($old_dqid_val) && !empty($old_dqid_val[$value->id]) && in_array($k, $old_dqid_val[$value->id])   ? 'checked' : '' ?>  name="is_chief_complaint_doctor[<?= $value->id ?>][]" value="<?php echo $k ?>" required="true" id="checkbox_question<?= $i ?>"  type="checkbox">
								<label class="custom-control-label" for="checkbox_question<?= $i ?>"><?php echo $v ?></label>
							</div>
						</div>
						<?php $i++; } ?>
					</div>
				</div>
			</div>
			<?php }?>
					<?php
					break;
					case 1:
					?>
					<div class="form-group form_fild_row <?php echo in_array($value->id,[560]) ? "display_none_at_load_time is_chief_complaint_doctor_559_560": ""; ?> <?php echo in_array($value->id,[606]) ? "display_none_at_load_time is_chief_complaint_doctor_557_606": ""; ?>">

					 <div class="radio_bg">
					          <label><?= $value->question ?>

					          &nbsp;<span class="required">*</span></label>

					<div class="radio_list">
									<?php
									$options = unserialize($value->options) ;


										foreach ($options as $k => $v) {

											?>
					        <div class="form-check">
					         <input type="radio"  value="<?= $v ?>" <?= !empty($old_dqid_val[$value->id]) && $old_dqid_val[$value->id] == $v ? 'checked' : ''  ?>   class="form-check-input is_chief_complaint_doctor_<?= $value->id ?>" required="true" id="radio_question<?= $i ?>" name="is_chief_complaint_doctor[<?= $value->id ?>]"  >
					         <label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
					       </div>
											<?php
											$i++ ;
										}
										?>

								</div>
							</div>
						</div>
					<?php break;
				default:
					// code...
					break;
			}?>


<?php }} ?>


<?php }?>
<!-- Psychiatry -->
<?php if($apt_id_data->specialization_id == 1 && $step_id == 26){
if(!empty($user_detail_old->chief_compliant_userdetail->chief_complaint_psychiatry))

		$old_chief_complaint_psychiatry = $user_detail_old->chief_compliant_userdetail->chief_complaint_psychiatry ;
		// $old_chief_complaint_psychiatry = isset($old_chief_complaint_psychiatry)?$old_chief_complaint_psychiatry:'';
		$old_dqid_val = !empty($old_chief_complaint_psychiatry) ? unserialize(Security::decrypt( base64_decode($old_chief_complaint_psychiatry), SEC_KEY)) :'';
		// pr($old_chief_complaint_psychiatry);
		$ic = 1;
		if(!empty($psychiatry_question))
		{$i =1;
			foreach($psychiatry_question as $key => $value)
			{
				// $old_dqid_val = !empty($old_chief_complaint_psychiatry[$value->id]) ? $old_chief_complaint_psychiatry : '';
				 // pr($old_dqid_val);
				switch ($value->question_type) {
				case 0:
				?><div class="<?php echo in_array($value->id,[613]) ? "display_none_at_load_time chief_complaint_psychiatry_612_613": ""; ?> <?php echo in_array($value->id,[615]) ? "display_none_at_load_time chief_complaint_psychiatry_614_615": ""; ?><?php echo in_array($value->id,[610]) ? "display_none_at_load_time chief_complaint_psychiatry_694_610": ""; ?><?php echo in_array($value->id,[611]) ? "display_none_at_load_time chief_complaint_psychiatry_694_611": ""; ?>">
					 					<div class="form-group form_fild_row">
					 						<label>
											<?= $value->question ?>&nbsp;<span class="required">*</span>
											</label>

											<input type="text" value="<?= !empty($old_dqid_val[$value->id]) ? $old_dqid_val[$value->id] :'' ?>" class="form-control chief_complaint_psychiatry_<?= $value->id ?>"  name="chief_complaint_psychiatry[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'question_'.$value->id; ?>"/>


					 					</div>
					</div>
					<?php
					break;
					case 2;
					?>
					<?php if(!in_array($value['id'],[694])){ ?>
					<div class="tab-pane fade  <?= ($tab_number==1  || 1==$current_steps[0])  ? '  show active ' : '' ?>" id="chief_complaint_psychiatry" role="tabpanel" aria-labelledby="chief_complaint_psychiatry-tab">
						<div class="TitleHead header-sticky-tit">
						   <h3><?php echo $value->question?><span class="required">*</span><br></h3>
						   <div class="seprator"></div>
						</div>
						<div class="tab_form_fild_bg">
							<!-- <div class="row"> -->
								<!-- <div class="col-md-12 "> -->
					 				<!-- <div class="form-group form_fild_row new_appoint_checkbox_quest_a">	 -->
					 			<div class="new_appoint_checkbox_quest">
					 										<span></span>
						<?php
						$options = unserialize($value->options) ;
					foreach ($options as $k => $v) {

						 ?>
						<div class="check_box_bg">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input chief_complaint_psychiatry_<?= $value->id ?> <?= !in_array(
								$k,["None"]) ? "chief_complaint_psychiatry_questions" :""?>" <?= !empty($old_dqid_val) && is_array($old_dqid_val[$value->id]) && in_array($k, $old_dqid_val[$value->id])   ? 'checked' : '' ?>  name="chief_complaint_psychiatry[<?= $value->id ?>][]" value="<?php echo $k ?>" required="true" id="checkbox_question<?= $i ?>"  type="checkbox">
								<label class="custom-control-label" for="checkbox_question<?= $i ?>"><?php echo $v ?></label>
							</div>
						</div>
						<?php $i++; } ?>
					</div>
				</div>
			</div>
			<?php }?>
					<?php
					break;
					case 1:
					?>
					<div class="form-group form_fild_row">

					 <div class="radio_bg">
					          <label><?= $value->question ?>

					          &nbsp;<span class="required">*</span></label>

					<div class="radio_list">
									<?php
									$options = unserialize($value->options) ;


										foreach ($options as $k => $v) {

											?>
					        <div class="form-check">
					         <input type="radio"  value="<?= $v ?>" <?= !empty($old_dqid_val[$value->id]) && $old_dqid_val[$value->id] == $v ? 'checked' : ''  ?>   class="form-check-input chief_complaint_psychiatry_<?= $value->id ?>" required="true" id="radio_question<?= $i ?>" name="chief_complaint_psychiatry[<?= $value->id ?>]"  >
					         <label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
					       </div>
											<?php
											$i++ ;
										}
										?>

								</div>
							</div>
						</div>
					<?php break;
				default:
					// code...
					break;
			}?>


<?php }} ?>


<?php }?>
<!-- End Psychiatry -->
<script type="text/javascript">
	$(document).on("click", "input[type='radio'].is_chief_complaint_doctor_558", function () {
				//console.log('dfdsf');
			    if($(this).is(':checked')) {
			    	//alert($(this).val());
			        if ($(this).val() == 'No') {

			        	$('.is_chief_complaint_doctor_558_605').hide();

			            $('.is_chief_complaint_doctor_605').val('');
			            // $('.other_detail_question_2_3').hide();
			        }else{

			        	$('.is_chief_complaint_doctor_558_605').removeClass('display_none_at_load_time').show();

			        }
			    }
			});
	$(document).on("click", "input[type='radio'].is_chief_complaint_doctor_559", function () {
			    if($(this).is(':checked')) {
			        if ($(this).val() == 'Yes') {

			        	$('.is_chief_complaint_doctor_559_560').hide();
			        	$('.is_chief_complaint_doctor_560').prop('checked', false);
			        }else{

			        	$('.is_chief_complaint_doctor_559_560').removeClass('display_none_at_load_time').show();

			        }
			    }
			});
	$(document).on("click", "input[type='checkbox'].chronic_condition_dmii", function () {
			    if($(this).is(':checked')) {
			        	$('.is_chief_complaint_doctor_557_606').removeClass('display_none_at_load_time').show();
			    }else{

			        	$('.is_chief_complaint_doctor_557_606').hide();
			        	$('.is_chief_complaint_doctor_606').prop('checked', false);

			        }
	});

</script>

<!-- Remain Question -->




			   <div class="back_next_button">
				<ul>
				 <li style="float: right;margin-left: auto;">
				  <button type="submit" class="btn">Next</button>
				 </li>
				</ul>
			   </div>
			  </div>
		  </div>
		  <input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 <input type="hidden" name="tab_number" value="1">
			 <input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
   <?php $this->Form->end() ;

}
   ?>
<script type="text/javascript">
    $("#form_tab_1").validate({
    	 ignore: [],
    	 submitHandler: function(form) {
    	 	formsubmit(form);

        }
    });
    $("#form_tab_36").validate({

        showErrors: function(errorMap, errorList) {

            if(errorList.length>0){
                $("#form_tab_36 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });

    $("#form_tab_37").validate({

        showErrors: function(errorMap, errorList) {

            if(errorList.length>0){
                $("#form_tab_36 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
            }
        },
        submitHandler: function(form) {
            formsubmit(form);

        }

     });


$(document).ready(function() {

 $(".step_head_deactive li a:not(.active)").on("click", function(){
 	$(this).removeClass('active')
 	$(this).addClass('should_not_active');


 });




// suggestion search for how it taken (current medication field) suggestion start

var how_it_tken = '<?php echo json_encode($how_it_taken_arr); ?>';  // this time data is read from the static php array (not from the ajax request)

	how_it_tken = JSON.parse(how_it_tken);


searchRequest = null;
$(document).on("keyup click", ".how_taken_suggestion", function () {


        value = $(this).val();
        if(value){
        	value = value.split(',');
        	value = value[value.length - 1] ;
        }
    var temphtml = '' ;
$.each(how_it_tken, function (key, data) {

	if (data.toLowerCase().indexOf(value.toLowerCase()) >= 0){

		temphtml += '<li how_taken_suggestion_attr ="'+data+'" >'+data+'</li>' ;
	}



});

	$(this).next('.how_taken_suggestion_listul').html(temphtml);




    });


$(document).on("click", ".how_taken_suggestion_listul li", function () {

	var diag_sugg_atr = $(this).attr('how_taken_suggestion_attr');
	console.log(diag_sugg_atr);

	var tmptext = $(this).parents('.how_taken_suggestion_listul').prev('.how_taken_suggestion');
	console.log(diag_sugg_atr);
	var ttext = $(tmptext).val();
	console.log(ttext);
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

	$(this).parents('.how_taken_suggestion_listul').empty();

});


//  suggestion search for how it taken suggestion  end


// following code to hide and show of the ul tag suggestion (copied from edit medical history page)

$(document).click(function (event) {

    if ( $('.custom-drop').has(event.target).length === 0)
    {
        $('.custom-drop-li').hide();
    }else{
    	 $(event.target).parents('.custom-drop').find('.custom-drop-li').show();
    }
});





});

</script>
     	<?php

if(in_array(2, $current_steps) && $tab_number == 2){

if(!empty($user_detail_old->chief_compliant_userdetail->chief_compliant_details))
	$old_chief_compliant_details = $user_detail_old->chief_compliant_userdetail->chief_compliant_details ;

$specific_quickpick_chief_complaint_arr = array();
$ic = 1;

     	// complaint details question part start  TAB - 2
	$chief_compliant_userdata_name = isset($cur_cc_data->name) ? $cur_cc_data->name : '';
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_2')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==2  || 2==$current_steps[0])  ? '  show active ' : '' ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		  	 <div class="errorHolder">
  </div>
			   <div class="TitleHead header-sticky-tit">
			   <h3>Chief Complaint Details for <?php echo '<b>['.$chief_compliant_userdata_name.']</b>';  ?></h3>
			   <div class="seprator"></div>
			  </div>

			  <div class="tab_form_fild_bg">
			   <div class="row">

				  <!-- <input type="text" class="form-control" placeholder="Mononucleosis"/>  -->

					<?php
$i = 0 ;
$cb_class = '';
//pr($detail_question_id->all()); die;

					if(!empty($detail_question_id)){
						foreach ($detail_question_id as $key => $value) {

							if($step_id != 12 && ($value->id == 147 || $value->id == 148 || $value->id == 150)){

								continue;
							}
							// pr($value); die;
 $old_dqid_val = !empty($old_chief_compliant_details[$cur_cc_data->id][$value->id]['answer']) ? $old_chief_compliant_details[$cur_cc_data->id][$value->id]['answer'] : '';


							switch ($value->question_type) {
										    case 0:
										 ?>


					<div class="<?php echo ($value->id == 97 || $value->id == 99 || $value->id == 76) ? 'col-md-6' : 'col-md-12'; ?> <?php echo   $value->id == 27 ? 'display_none_at_load_time question_26_27' : ''; // 14 no question depend on 13 no question ?>  <?php echo   $value->id == 40 ? 'display_none_at_load_time question_39_40' : ''; // 14 no question depend on 13 no question ?><?php echo   $value->id == 51 ? 'display_none_at_load_time number_of_nps' : '';?><?php echo $value->id == 67 || $value->id == 65 ? 'stay_hospital_que display_none_at_load_time': '';?><?php echo $value->id == 79 ? 'question_79 display_none_at_load_time': '';?><?php echo $value->id == 89 ? 'question_89 display_none_at_load_time': '';?> <?php echo $value->id == 147 ? 'detail_question_146_147 display_none_at_load_time': '';?> <?php echo $value->id == 148 ? 'detail_question_146_148 display_none_at_load_time': '';?>">
					 <div class="form-group form_fild_row">
					 	<label><?= str_replace('****', $chief_compliant_userdata_name , $value->question); ?>
					 	<?php if($value->id != 105){?>&nbsp;<span class="required">*</span> <?php } ?></label>
					 	<?php if($value->id == 76) {?>
					 		<input type="number" pattern="[0-9]*" inputmode="numeric"  value="<?= $old_dqid_val ?>" class="form-control"  name="details_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" <?php if($value->id != 105){?> required="true" <?php } ?> id="<?php echo 'question_'.$value->id; ?>"/>
					 	<?php } else { ?>
<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="details_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" <?php if($value->id != 105){?> required="true" <?php } ?> id="<?php echo 'question_'.$value->id; ?>"/>
<?php  }?>


					<?php

						$chief_compliant_name_search = strtolower($chief_compliant_userdata_name);
						if($chief_compliant_name_search == 'runny nose'){
							$specific_quickpick_chief_complaint_arr[] = 'runny nose';
							if($value->id == 156){ ?>

								<div class="common_conditions_button quickpicks_question_156 detail_ques_cls" style="border: none; padding-top: 10px;">
						            <ul>

						            	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="going indoors" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>going indoors</span></button> </li>
						            </ul>
					           </div>
						<?php }

							if($value->id == 157){ ?>

								<div class="common_conditions_button quickpicks_question_156 detail_ques_cls" style="border: none; padding-top: 10px;">
						            <ul>

						            	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="going outdoors" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>going outdoors</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="cold weather" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>cold weather</span></button> </li>

						            </ul>
					           </div>
						<?php }
						}
					 ?>

					 <?php

						if($chief_compliant_name_search == 'sore throat'){
							$specific_quickpick_chief_complaint_arr[] = 'sore throat';
							if($value->id == 156){ ?>

								<div class="common_conditions_button quickpicks_question_156 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

					                	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="ibuprofen (Advil/Alleve/Motrin)" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>ibuprofen (Advil/Alleve/Motrin)</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="hot water gargles" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>hot water gargles</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="cough drops" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>cough drops</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="hot tea" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>hot tea</span></button> </li>
					                </ul>
					            </div>
						<?php }

							if($value->id == 157){ ?>

								<div class="common_conditions_button quickpicks_question_156 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

					                	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="swallowing" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>swallowing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="coughing" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>coughing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="talking" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>talking</span></button> </li>

					                </ul>
					            </div>
						<?php }
						}
					 ?>


					  <?php

						if($chief_compliant_name_search == 'joint pain'){
							$specific_quickpick_chief_complaint_arr[] = 'joint pain';
							if($value->id == 4){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>icing</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="resting" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>resting</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>exercise</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="stretching" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>stretching</span></button> </li>


										<li class="active"><button type="button" class="btn" attr_val="physical therapy" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>physical therapy</span></button> </li>
					                </ul>
					            </div>
						<?php }

							if($value->id == 5){ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="moving joint after cold weather" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>moving joint after cold weather</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="flying in a plane" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>flying in a plane</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="running" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>running</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="cycling" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>cycling</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="sitting for long time" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>sitting for long time</span></button> </li>
				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					   <?php

						if($chief_compliant_name_search == 'nausea'){
							$specific_quickpick_chief_complaint_arr[] = 'nausea';
							if($value->id == 147){ ?>

								<div class="common_conditions_button quickpicks_question_147 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="eating food" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Eating food</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="fasting" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Fasting</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 148){ ?>

								<div class="common_conditions_button quickpicks_question_148 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="throwing up" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Throwing up</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="antacids" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Antacids</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="eating food" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Eating food</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>

					 <?php

						if($chief_compliant_name_search == 'cramping'){
							$specific_quickpick_chief_complaint_arr[] = 'cramping';
							if($value->id == 147){ ?>

								<div class="common_conditions_button quickpicks_question_147 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="greasy or fried food" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Greasy or fried food</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="milk or dairy" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Milk or dairy</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 148){ ?>

								<div class="common_conditions_button quickpicks_question_148 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="gas-x" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Gas-X</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					  <?php

						if($chief_compliant_name_search == 'vomiting'){
							$specific_quickpick_chief_complaint_arr[] = 'vomiting';
							if($value->id == 147){ ?>

								<div class="common_conditions_button quickpicks_question_147 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="Eating food" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Eating food</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 148){ ?>

								<div class="common_conditions_button quickpicks_question_148 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="fasting" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Fasting</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>

					 <?php

						if($chief_compliant_name_search == 'cough'){
							$specific_quickpick_chief_complaint_arr[] = 'cough';
							if($value->id == 4){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="going indoors" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>going indoors</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="cough drops" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>cough drops</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 5){ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="going outdoors" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>going outdoors</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>exercise</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="after eating" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>after eating</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="lying down" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>lying down</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					  <?php

						if($chief_compliant_name_search == 'hand pain'){
							$specific_quickpick_chief_complaint_arr[] = 'hand pain';
							if($value->id == 4){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="shaking hand out" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>shaking hand out</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>icing</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 5){ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="gripping" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>gripping</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="making a fist" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>making a fist</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="opening hand" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>opening hand</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="movement" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>movement</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					 <?php

						if($chief_compliant_name_search == 'wrist pain'){
							$specific_quickpick_chief_complaint_arr[] = 'wrist pain';
							if($value->id == 4){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="shaking hand out" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>shaking hand out</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>icing</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 5){ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="gripping" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>gripping</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="repetitive movements" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>repetitive movements</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="rotating wrist" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>rotating wrist</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>

					 <?php

						if($chief_compliant_name_search == 'finger pain'){
							$specific_quickpick_chief_complaint_arr[] = 'finger pain';
							if($value->id == 4){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="shaking hand out" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>shaking hand out</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>icing</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 5){ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="movement" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>movement</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="curling finger in" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>curling finger in</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="extending finger" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>extending finger</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>

					 <?php

						if($chief_compliant_name_search == 'foot pain'){
							$specific_quickpick_chief_complaint_arr[] = 'foot pain';
							if($value->id == 124){ ?>

								<div class="common_conditions_button quickpicks_question_124 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>rest</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 125){ ?>

								<div class="common_conditions_button quickpicks_question_125 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="movement" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>movement</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="putting weight on foot" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>putting weight on foot</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					 <?php

						if($chief_compliant_name_search == 'headache'){
							$specific_quickpick_chief_complaint_arr[] = 'headache';
							if($value->id == 4){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

					                	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="lying down" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Lying down</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="darkness" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Darkness</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="quiet/decrease stimuli" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Quiet/decrease stimuli</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="ice pack" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Ice pack</span></button> </li>


					                </ul>
					            </div>
						<?php }

							if($value->id == 5){ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="Wine" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Wine</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="chocolate" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Chocolate</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="menstruation" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Menstruation</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="stress" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Stress</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="lack of sleep" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Lack of sleep</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="weather change" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Weather change</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Exercise</span></button> </li>
					                </ul>
					             </div>
						<?php }
						}
					 ?>


					 <?php

						if($chief_compliant_name_search == 'reflux'){
							$specific_quickpick_chief_complaint_arr[] = 'reflux';
							if($value->id == 61){ ?>

								<div class="common_conditions_button quickpicks_question_61 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										 <li class="active"><button type="button" class="btn" attr_val="lying down" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Lying down</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="heavy meals" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Heavy meals</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="fried or greasy foods" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Fried or greasy foods</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="chocolate" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Chocolate</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="tomato-based sauces" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Tomato-based sauces</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="hot liquids" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Hot liquids</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="acidic liquids" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Acidic liquids</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 62){ ?>

								<div class="common_conditions_button quickpicks_question_62 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
										<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="antacids" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Antacids</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="sitting up" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Sitting up</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					 <?php

						if($chief_compliant_name_search == 'hip pain'){
							$specific_quickpick_chief_complaint_arr[] = 'hip pain';
							if($value->id == 124){ ?>

								<div class="common_conditions_button quickpicks_question_124 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

					                	<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Icing</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Rest</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="massage/shaking hip out" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Massage/shaking hip out</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="tylenol" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Tylenol</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="uboprofen" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Uboprofen</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="aleve" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Aleve</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 125){ ?>

								<div class="common_conditions_button quickpicks_question_125 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
				                		<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="movement/excessive use" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Movement/excessive use</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					 <?php

						if($chief_compliant_name_search == 'ankle pain'){
							$specific_quickpick_chief_complaint_arr[] = 'ankle pain';
							if($value->id == 124){ ?>

								<div class="common_conditions_button quickpicks_question_124 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>
					                	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Icing</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Rest</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="massage/shaking ankle out" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Massage/shaking ankle out</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="tylenol" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Tylenol</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="ibuprofen" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Ibuprofen</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="aleve" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Aleve</span></button> </li>

					                </ul>
					            </div>
						<?php }

							if($value->id == 125){ ?>

								<div class="common_conditions_button quickpicks_question_125 detail_ques_cls" style="border: none; padding-top: 10px;">
				                	<ul>
				                		<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="movement/excessive use" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Movement/excessive use</span></button> </li>

				                	</ul>
				               	</div>
						<?php }
						}
					 ?>


					<?php
						if($cur_cc_data->specialization_id == 0){
/*
							$chief_compliant_arr1 = array('chest pain','pain in chest','chest pressure','short of breath','shortness of breath',"can't breathe",'cant breathe','hard to breathe');
               		 		$chief_compliant_arr2 = array('palpatations','racing heart','racing heart beat','heart beating fast','heart beats fast');
               		 		$specific_quickpick_chief_complaint_arr = array_merge($specific_quickpick_chief_complaint_arr,$chief_compliant_arr1,$chief_compliant_arr2);
               		 		$chief_compliant_arr3 = array_merge($chief_compliant_arr1,$chief_compliant_arr2);*/

							if($value->id == 4 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr)){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="antacids" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Antacids</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="sitting up" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Sitting up</span></button> </li>
					                </ul>
               					</div>
					<?php   }

							if($value->id == 5 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr))
							{ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="Wine" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Wine</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="chocolate" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Chocolate</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="menstruation" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Menstruation</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="stress" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Stress</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="lack of sleep" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Lack of sleep</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="weather change" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Weather change</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Exercise</span></button> </li>
					                </ul>
					            </div>
					<?php	}
						}
					 ?>

					 <?php
						if($cur_cc_data->specialization_id == 0  || $cur_cc_data->specialization_id == 5){

							$chief_compliant_arr1 = array('chest pain','pain in chest','chest pressure','short of breath','shortness of breath',"can't breathe",'cant breathe','hard to breathe');
               		 		$chief_compliant_arr2 = array('palpatations','racing heart','racing heart beat','heart beating fast','heart beats fast');
               		 		$specific_quickpick_chief_complaint_arr = array_merge($specific_quickpick_chief_complaint_arr,$chief_compliant_arr1,$chief_compliant_arr2);
               		 		$chief_compliant_arr3 = array_merge($chief_compliant_arr1,$chief_compliant_arr2);

							if($value->id == 61){ ?>

								<div class="common_conditions_button quickpicks_question_61 detail_ques_cls" style="border: none; padding-top: 10px;">
	                				<ul>
	                					<?php if(in_array($chief_compliant_name_search,$chief_compliant_arr3) ){ ?>

							               		<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>
												<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Exercise</span></button> </li>
												<li class="active"><button type="button" class="btn" attr_val="climbing stairs" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Climbing stairs</span></button> </li>

							            <?php } if(in_array($chief_compliant_name_search,$chief_compliant_arr1) ){ ?>


												<li class="active"><button type="button" class="btn" attr_val="walking" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Walking</span></button> </li>

										<?php }
											 if(in_array($chief_compliant_name_search,$chief_compliant_arr2) ){	 ?>

												<li class="active"><button type="button" class="btn" attr_val="stress" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Stress</span></button> </li>
										<?php } ?>
									</ul>
								</div>
					<?php	}

							if($value->id == 62){ ?>

								<div class="common_conditions_button quickpicks_question_62 detail_ques_cls" style="border: none; padding-top: 10px;">
                					<ul>

			                			<?php if(in_array($chief_compliant_name_search,$chief_compliant_arr3) ){ ?>

											<li class="active"><button type="button" class="btn" attr_val="nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>
											<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Rest</span></button> </li>
											<li class="active"><button type="button" class="btn" attr_val="lying down" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Lying down</span></button> </li>

										<?php } ?>
										<?php if(in_array($chief_compliant_name_search,$chief_compliant_arr1) ){ ?>

											<li class="active"><button type="button" class="btn" attr_val="antacids" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Antacids</span></button> </li>

										<?php } ?>

										<?php if(in_array($chief_compliant_name_search,$chief_compliant_arr3) ){ ?>

											<li class="active"><button type="button" class="btn" attr_val="nitroglycerin" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nitroglycerin</span></button> </li>
											<li class="active"><button type="button" class="btn" attr_val="aspirin" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Aspirin</span></button> </li>
										<?php } ?>
									</ul>
								</div>
					<?php	}

						}
					 ?>


					<?php
						if($cur_cc_data->specialization_id == 3){

							if($value->id == 4 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr)){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

					                	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>Icing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Rest</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="shaking" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Shaking</span></button> </li>
					                </ul>
				                </div>
					<?php   }

							if($value->id == 5 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr))
							{ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

					                	<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="movement" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Movement</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="flexing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Flexing</span></button> </li>
					                </ul>
					            </div>
					<?php	}

						}
					 ?>

					 <?php
						if($cur_cc_data->specialization_id == 4 || $apt_id_data->specialization_id == 7 ){

							if($value->id == 4 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr)){ ?>

								<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Rest</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Exercise</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="meds" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Meds</span></button> </li>



					                </ul>
					            </div>
					<?php   }

							if($value->id == 5 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr))
							{ ?>

								<div class="common_conditions_button quickpicks_question_5 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>
										<li class="active"><button type="button" class="btn" attr_val="Nothing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Nothing</span></button> </li>

										<?php if($cur_cc_data->id == 43) { ?>
										<li class="active"><button type="button" class="btn" attr_val="turning head" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Turning Head</span></button> </li>
										<?php }else { ?>

										<li class="active"><button type="button" class="btn" attr_val="leaning over" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Leaning over</span></button> </li>
										<?php } ?>

										<li class="active"><button type="button" class="btn" attr_val="walking up stairs" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Walking up stairs</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="walking down stairs" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Walking down stairs</span></button> </li>

										<?php if($cur_cc_data->id == 42) { ?>
										<li class="active"><button type="button" class="btn" attr_val="lifting objects" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Lifting Objects</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="sitting" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Sitting</span></button> </li>
										<?php } ?>

					                </ul>
					            </div>
					<?php	}

							if($value->id == 27){ ?>

								<div class="common_conditions_button quickpicks_question_27 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="falling" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Falling</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="lifting/picking up/moving objects" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Lifting/Picking up/Moving objects</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="car accident/car crash" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Car accident/Car crash</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="sports-related" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Sports-related</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="i don't know" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>I don't know</span></button> </li>

					                </ul>
					            </div>

					<?php	}

						}
					 ?>

					 <?php
						if($cur_cc_data->specialization_id == 7){

							if($value->id == 124 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr)){ ?>

								<div class="common_conditions_button quickpicks_question_124 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

										<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Icing</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Rest</span></button> </li>

										<li class="active"><button type="button" class="btn" attr_val="tylenol" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Tylenol</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="uboprofen" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Uboprofen</span></button> </li>
										<li class="active"><button type="button" class="btn" attr_val="aleve" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Aleve</span></button> </li>

					                </ul>
				                </div>
					<?php   }

							if($value->id == 125 && !in_array($chief_compliant_name_search,$specific_quickpick_chief_complaint_arr))
							{ ?>

								<div class="common_conditions_button quickpicks_question_125 detail_ques_cls" style="border: none; padding-top: 10px;">
					                <ul>

					                	<li class="active"><button type="button" class="btn" attr_val="movement/excessive use" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Movement/excessive use</span></button> </li>
					                </ul>
					            </div>
					<?php	}

						}
					 ?>






					 </div>
					</div>

						<?php
										        break;
										    case 1:

										    if($login_user['gender'] != 0 && $value->id == 92){

										    	continue;
										    }

										    if($step_id != 12 && ($value->id == 146 || $value->id == 149 || $value->id == 151 || $value->id == 152)){

										    	continue;
										    }
										    ?>
				<div class="col-md-12  <?php echo  $value->id == 14  ? 'display_none_at_load_time question_13_14' : ''; // 14 no question depend on 13 no question ?>  <?php echo   $value->id == 17 ? 'display_none_at_load_time question_16_17' : ''; // 14 no question depend on 13 no question ?>   <?php echo  $value->id == 35  ? 'display_none_at_load_time question_34_35' : ''; // 35 no question depend on 34 no question ?><?php echo $value->id == 68 ? 'stay_hospital_que display_none_at_load_time': '';?><?php //echo $value->id == 73 ? 'question_73': '';?><?php echo $value->id == 74 ? 'question_74 display_none_at_load_time': '';?> <?php echo $value->id == 123 ? 'detail_question_122_123 display_none_at_load_time': '';?> <?php echo $value->id == 107 ? 'detail_question_106_107 display_none_at_load_time': '';?> <?php echo $value->id == 128 ? 'detail_question_127_128 display_none_at_load_time': '';?> <?php echo $value->id == 136 ? 'detail_question_135_136 display_none_at_load_time': '';?> <?php echo $value->id == 143 ? 'detail_question_142_143 display_none_at_load_time': '';?> <?php echo $value->id == 134 ? 'detail_question_133_134 display_none_at_load_time': '';?><?php echo $value->id == 184 ? 'detail_question_182_184 display_none_at_load_time': '';?><?php echo $value->id == 185 ? 'detail_question_184_185 display_none_at_load_time': '';?>">
				 <div class="form-group form_fild_row">

 <div class="radio_bg">
          <label><?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>

          &nbsp;<span class="required">*</span></label>

<div class="radio_list">
				<?php
				$options = unserialize($value->options) ;

					foreach ($options as $k => $v) {

						?>
        <div class="form-check">
         <input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input   <?php echo  $value->id == 13 ? 'check_did_you_try_medication' : ''; // 14 no question depend on 13 no question ?> <?php echo  $value->id == 16 ? 'check_which_is_worse' : ''; // 17 no question depend on 16 no question ?>  <?php echo  $value->id == 26 ? 'check_any_accident' : ''; // 17 no question depend on 16 no question ?> <?php echo  $value->id == 34 ? 'which_joint_cls' : ''; // 35 no question depend on 34 no question ?> <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 53 ? 'take_exercise':""?><?php echo $value->id == 73 ? 'question_73':""?><?php echo $value->id == 57 ? 'travel_pain':""?><?php echo $value->id == 63 ? 'stay_hospital':""?><?php echo $value->id == 74 ? 'question_74': '';?><?php echo $value->id == 78 ? 'question_78': '';?><?php echo $value->id == 88 ? 'question_88': '';?><?php echo $value->id == 50 ? 'nps':""?> <?php echo $value->id == 122 ? "detail_question_122" : ""; ?> <?php echo $value->id == 117 ? "detail_question_117": "" ?> <?php echo $value->id == 106 ? "detail_question_106": "" ?> <?php echo $value->id == 122 ? "detail_question_122" : ""; ?> <?php echo $value->id == 117 ? "detail_question_117": "" ?> <?php echo $value->id == 127 ? "detail_question_127": "" ?> <?php echo $value->id == 135 ? "detail_question_135": "" ?> <?php echo $value->id == 110 ? "detail_question_110":""; ?> <?php echo $value->id == 142 ? "detail_question_142" : ""; ?> <?php echo $value->id == 133 ? "detail_question_133" : ""; ?> <?php echo $value->id == 146 ? "detail_question_146" : ""; ?><?php echo $value->id == 182 ? "detail_question_182" : ""; ?><?php echo $value->id == 184 ? "detail_question_184" : ""; ?><?php echo $value->id == 185 ? "detail_question_185" : ""; ?>" id="radio_question<?= $i ?>" name="details_question[<?= $value->id ?>]"  required="true">
         <label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
       </div>
						<?php
						$i++ ;
					}
					?>

</div>
					<?php

		// more option start  ( for some question like question id 18 there is 2 set of quesitons and user must choose one among each set )
			if(!empty($value->more_option)){


			$old_mo = $user_detail_old->chief_compliant_userdetail->more_options;
				// pr($old_chief_compliant_details); die;
				// pr($old_chief_compliant_details[$cur_cc_data->id]);
				// pr($old_dqid_val); die;
$old_mo = !empty($old_mo[$cur_cc_data->id][$value->id]) ? $old_mo[$cur_cc_data->id][$value->id] : '';
				?>
<span>And</span>
<div class="radio_list" >

				<?php

				$more_option = unserialize($value->more_option) ;

					foreach ($more_option as $k => $v) {
						?>
<div class="form-check">
         <input type="radio" <?= $old_mo == $v ? 'checked' : ''  ?>  value="<?= $v ?>"    class="form-check-input" id="radio_question<?= $i ?>" name="details_question[more_option][<?= $value->id ?>]"  required="true">
         <label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
       </div>
       <?php
       $i++ ;
					}
					?>
        </div>

					<?php

			}


	    // more option end




				 ?>


    </div>
				 </div>
				</div>
										      <?php
										        break;
										    case 3:
// pr($old_dqid_val); die;
			// if($value->id == 15 && $user_detail )
// pr($options); die;

if(!empty($user_detail->chief_compliant_id)){
	// get the main  cheief compliant id and compare it with current chief complaint id , we don't ask question no 15 if this is for main chief complaint id
if(strpos($user_detail->chief_compliant_id, ",") !== false)
  $maincc = substr($user_detail->chief_compliant_id, 0, strpos($user_detail->chief_compliant_id, ","));
else $maincc = $user_detail->chief_compliant_id ;
// echo 'hihi';
// pr($user_detail->chief_compliant_id);
// pr($maincc);
// // pr($user_detail);
// pr($cur_cc_data);
if($maincc == $cur_cc_data->id && $value->id == 15)  break;  // if this is for main chief complaint and question id is 15
}



						//echo $value->id;				 ?>


					<div class="<?php echo ($value->id == 98 || $value->id == 100 || $value->id == 77) ? 'col-md-6' : 'col-md-12'; ?> <?php echo $value->id == 64 || $value->id == 66 ? 'stay_hospital_que display_none_at_load_time': '';?><?php echo $value->id == 183 ? 'question_182_183 display_none_at_load_time': '';?>">
					 <div class="form-group form_fild_row">
					 	<?php if($value->id == 144){ ?>

					 		<p>On a scale of 1 to 10, 1 being 'no pain at all' and 10 being 'the worst pain you have ever felt,' please rate your <?php echo $chief_compliant_userdata_name; ?> for the following: <span class="required">*</span></p>
					 <?php	} ?>
					 <?php //if(!empty($value->question)){ ?>
					 	<label>

					 		<?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>

<?php  $options = unserialize($value->options) ; //pr($options); die;  ?>

					 	<?php if(isset($options[0]) && !empty($value->question)){ ?>
					 		<?php if(!empty($options[0])){ ?>
						 		<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">

						 		<i class="fa fa-question-circle" aria-hidden="true"></i></a>
						 	<?php } ?>
					 		<span class="required">*</span>
					 	<?php } ?>

					 </label>

<select class="form-control" name="details_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">



					<?php if($value->id == 64 ||$value->id == 69 ||$value->id == 70){

						foreach ($options as $ky => $ve) {
						// if($key == 0) continue; // we dont want placeholder here (first option is placeholder)

					// echo "<option ".($key == 0 ? 'disabled' : '')." value=".($key == 0 ? '' : $key).">".$value."</option>";

							if($value['id'] == 66 || $value['id'] == 98 || $value['id'] == 100 || $value['id'] == 104 || $value['id'] == 77){
								echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".$ky.">".$ve."</option>";
								 // for 15 id we will send the value as the select box value

							}
							else{

								echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".$ky.">".$ve."</option>";
								 // for 15 id we will send the value as the select box value
							}


						}

					}else{ ?>

					<?php	
					echo $old_dqid_val;				
						foreach ($options as $ky => $ve) {
						// if($key == 0) continue; // we dont want placeholder here (first option is placeholder)

					// echo "<option ".($key == 0 ? 'disabled' : '')." value=".($key == 0 ? '' : $key).">".$value."</option>";

							if($value['id'] == 66 || $value['id'] == 98 || $value['id'] == 100 || $value['id'] == 104 || $value['id'] == 77){

								echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>"; // for 15 id we will send the value as the select box value
							}
							else if($value['id'] == 48)
							{
							
							  $old_dqid_val = $old_chief_compliant_details[$cur_cc_data->id][$value->id]['answer'];						
								echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value='".$ky."'>".$ve."</option>"; 
							}
							else{

								echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>"; // for 15 id we will send the value as the select box value
								}
							}
					}
					?>


			</select>

					 </div>
					</div>

						<?php
						        break;
						           case 2:
						?>
					<div class="col-md-12  <?= ($value->id == 36 || $value->id == 37 || $value->id == 38 ) ? 'ques_id_36_37_38' : '' ?><?php echo $value->id == 54 ? 'time_exercise display_none_at_load_time': '';?><?php echo $value->id == 58 ? 'travel_pain_from display_none_at_load_time': '';?><?php echo $value->id == 68 ? 'stay_hospital_que display_none_at_load_time': '';?><?php echo $value->id == 75 ? 'question_75 display_none_at_load_time': '';?><?php echo $value->id == 90 ? 'question_90 display_none_at_load_time': '';?><?php echo $value->id == 94 ? 'question_94 display_none_at_load_time': '';?> <?php echo $value->id == 118 ? "detail_question_117_118 display_none_at_load_time": ""; ?><?php echo $value->id == 112 ? "detail_question_111_112 display_none_at_load_time": ""; ?><?php echo $value->id == 111 ? "detail_question_110_111 display_none_at_load_time" : ""; ?> ">
					 <div class="form-group form_fild_row <?= ($value->id == 19 || $value->id == 23 || $value->id == 36 || $value->id == 37 || $value->id == 38 || $value->id == 39 || $value->id == 30 || $value->id == 42 ||$value->id == 58|| $value->id == 56 ||$value->id == 2 || $value->id == 75 ||$value->id == 71 ||$value->id == 80 ||$value->id == 81||$value->id == 83 ||$value->id == 54 || $value->id == 87 ||$value->id == 90 ||$value->id == 93 ||$value->id == 94 || $value->id == 95 ||$value->id == 96 || $value->id == 101 || $value->id == 108 || $value->id == 109 || $value->id == 111 || $value->id == 112 || $value->id == 114 || $value->id == 118 || $value->id == 129 || $value->id == 130 || $value->id == 137 || $value->id == 155 || $value->id == 12) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 	<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 	<div class="<?= ($value->id == 19 || $value->id == 23 || $value->id == 36 || $value->id == 37 || $value->id == 38 || $value->id == 39 || $value->id == 30 || $value->id == 42 || $value->id == 58|| $value->id == 56 ||$value->id == 2 ||$value->id == 75 ||$value->id == 71||$value->id == 80 ||$value->id == 81||$value->id == 83 ||$value->id == 54 ||$value->id == 87 ||$value->id == 90 || $value->id == 93 ||$value->id == 94 ||$value->id == 95 || $value->id == 96 || $value->id == 101 || $value->id == 108 || $value->id == 109 || $value->id == 111 || $value->id == 112 || $value->id == 114 || $value->id == 118 || $value->id == 129 || $value->id == 130 || $value->id == 137 || $value->id == 155 || $value->id == 12) ? 'new_appoint_checkbox_quest' : '' ?>">
					 		<span></span>
					 	<?php
					 		$options = unserialize($value->options) ;
					 		// pr($options);
					 		// $ic = 1;
		// for 19 and 23 option if user select last option then other option should unchecked
 if($value->id == 19 || $value->id == 23 || $value->id == 36 || $value->id == 37 || $value->id == 38 || $value->id == 39  || $value->id == 30 || $value->id == 42 ){
 	$cb_class =  "last_option_single".$value->id  ;
?>

<script type="text/javascript">

$(document).ready(function() {


    $("input[type='checkbox'].<?= $cb_class ?>:last").change(function() {
        if($(this).is(":checked")) {
        		$("input[type='checkbox'].<?= $cb_class ?>:not(:last)").prop( "checked", false );
        		$("div.for_36_37_38").empty(); // empty  the subquestion of 36,37,38  if none of the above is clicked
        		// below code is to remove the answer of subquestion of 36,37,38 from corresponding checkbox value when None of the above is choosen
        		$(".ques_id_36_37_38 input[type='checkbox']").each(function( index, element ) {
        			// alert($(element).val())
        			$(element).val(($(element).val().split('-')[0]));  // removing the subquestoin answer, that is after '-'
        		});
        }
    });
    $("input[type='checkbox'].<?= $cb_class ?>:not(:last)").change(function() {
        if($(this).is(":checked")) {
       		 $("input[type='checkbox'].<?= $cb_class ?>:last").prop( "checked", false );
        }
    });
});

</script>
<?php

 }
 // pr($old_dqid_val);
 $temp_old_dqid_val = array();
$old_36_37_38 = array();
if(is_array($old_dqid_val)){
	foreach ($old_dqid_val as $kdq => $vdq) {
		if(($pos = stripos($vdq, '-')) !== false){
			$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
			// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

			$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
		}else{
			$temp_old_dqid_val[$vdq] = $vdq;
		}
	}
}

$old_dqid_val = $temp_old_dqid_val;
// pr($temp_old_dqid_val);
// pr($old_36_37_38);
//  die;

		foreach ($options as $ky => $val) {
			 			?>
<div class="check_box_bg">
		 <div class="custom-control custom-checkbox">
          <input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>  <?php echo  $value->id == 39 ? 'check_radiating_option' : ''; // 39 no question depend on 40 no question only in case of radiating option ?><?php echo  $value->id == 93 ? 'question_93' : '';?> <?php echo $value->id == 111 ? "detail_question_111":""; ?> <?php echo $value->id == 95 ? "detail_question_95":""; ?> <?php echo $value->id == 155 ? "detail_question_155":""; ?>"  name="details_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" subques="<?= !empty($old_36_37_38[$val]) ? $old_36_37_38[$val] : '' ?>" type="checkbox" required="required">
          <label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         </div>
		 </div>

			 			<?php
			 			$ic++;
					 		}

					 	?>



</div>


					 </div>
					</div>
<!-- below div will contain the dynamica radio button question related to the question id 36, 37 and 38 -->
<div class="col-md-12 for_36_37_38">

</div>
<!-- following text area contain the dummy radio button question that will be used for the question id 36, 37 and 38 -->
<textarea class="for_36_37_38" style="display: none;">
		<div class="form-group form_fild_row">
			<div class="radio_bg">
			          <label class="quest"></label>
				<div class="radio_list">
						<div class="form-check right">
				         <input type="radio" value="right" class="form-check-input" id="radio_question0"  required="true">
				         <label class="form-check-label" for="radio_question0">Right</label>
				       </div>
						<div class="form-check left">
				         <input type="radio" value="left" class="form-check-input" id="radio_question1"  required="true">
				         <label class="form-check-label" for="radio_question1">Left</label>
				       </div>
				       <div class="form-check both">
				         <input type="radio" value="both" class="form-check-input" id="radio_question2"  required="true">
				         <label class="form-check-label" for="radio_question2">Both</label>
				       </div>
				</div>
			</div>
		</div>
	</textarea>
<script type="text/javascript">
$(document).ready(function() {
	$(document).on("change", ".ques_id_36_37_38 input[type='checkbox']", function () {

		// alert($(this).prop("checked"));
			var checkval = $(this).val();
			// alert(checkval);
		if($(this).prop("checked") == true){
			// alert($(this).val());

			var ques_content = $('textarea.for_36_37_38').val(); // get the content of the next question
			if(checkval.indexOf('Arms') != -1) {
				addele(ques_content, '36_37_38_arm');
			}else if(checkval.indexOf('Legs') != -1){
				addele(ques_content, '36_37_38_leg');
			}else if(checkval.indexOf('Hands') != -1){
				addele(ques_content, '36_37_38_hand');
			}else if(checkval.indexOf('Feet') != -1){
				addele(ques_content, '36_37_38_foot');
			}
		}else{
			if(checkval.indexOf('Arms') != -1) {
				$('div.for_36_37_38 .36_37_38_armques').remove();
			}else if(checkval.indexOf('Legs') != -1){
				$('div.for_36_37_38 .36_37_38_legques').remove();
			}else if(checkval.indexOf('Hands') != -1){
				$('div.for_36_37_38 .36_37_38_handques').remove();
			}else if(checkval.indexOf('Feet') != -1){
				$('div.for_36_37_38 .36_37_38_footques').remove();
			}

		}
	});

	$(document).on("change", "div.for_36_37_38 .36_37_38_armques input[type='radio']", function () {
		 if($(this).is(':checked')) {
		 	var cvl = $(".ques_id_36_37_38 input[type='checkbox'][fixval='Arms']").val(); // we have taken fixval attribute as value attribute will be changed
		 	cvl = cvl.split('-')[0];
		 	cvl = cvl + '-' + $(this).val();
		 	$(".ques_id_36_37_38 input[type='checkbox'][fixval='Arms']").val(cvl);
		 	cvl = '';
		 	// alert($(this).val());
		 	// alert($(".ques_id_36_37_38 input[type='checkbox'][value='Arms']").val());
		 }
	});



	$(document).on("change", "div.for_36_37_38 .36_37_38_legques input[type='radio']", function () {
		 if($(this).is(':checked')) {
		 	var cvl = $(".ques_id_36_37_38 input[type='checkbox'][fixval='Legs']").val();
		 	cvl = cvl.split('-')[0];
		 	cvl = cvl + '-' + $(this).val();
		 	$(".ques_id_36_37_38 input[type='checkbox'][fixval='Legs']").val(cvl);
		 	cvl = '';
		 }
	});
	$(document).on("change", "div.for_36_37_38 .36_37_38_handques input[type='radio']", function () {
		 if($(this).is(':checked')) {
		 	var cvl = $(".ques_id_36_37_38 input[type='checkbox'][fixval='Hands']").val();
		 	cvl = cvl.split('-')[0];
		 	cvl = cvl + '-' + $(this).val();
		 	$(".ques_id_36_37_38 input[type='checkbox'][fixval='Hands']").val(cvl);
		 	cvl = '';
		 }
	});
	$(document).on("change", "div.for_36_37_38 .36_37_38_footques input[type='radio']", function () {
		 if($(this).is(':checked')) {
		 	var cvl = $(".ques_id_36_37_38 input[type='checkbox'][fixval='Feet']").val();
		 	cvl = cvl.split('-')[0];
		 	cvl = cvl + '-' + $(this).val();
		 	$(".ques_id_36_37_38 input[type='checkbox'][fixval='Feet']").val(cvl);
		 	cvl = '';
		 }
	});


// on page load this will check the subquestion and select them accordingly if old data is present
	$(".ques_id_36_37_38 input[type='checkbox']").each(function( index, element ) {
		// alert($(element).val())
		if($(element).attr('subques')){
		   $(element).trigger("change");
		   var mainq = $(element).val();
		   var subq =  $(element).attr('subques');  // this attribute will be set only when the user edit this tab and old data is present
		   // alert(mainq);
		   // alert(subq);
		   // alert(/arm/i.test(mainq))
		   if(/arm/i.test(mainq))
		   		$("#36_37_38_armques_"+subq).prop("checked", true);
		   if(/leg/i.test(mainq))
		   		$("#36_37_38_legques_"+subq).prop("checked", true);
		   if(/hand/i.test(mainq))
		   		$("#36_37_38_handques_"+subq).prop("checked", true);
		   if(/feet/i.test(mainq))
		   		$("#36_37_38_footques_"+subq).prop("checked", true);

		}
	});


});
function addele(ques_content, chec){
	// alert($("<div>" + ques_content + "</div>").find('.form_fild_row').length);
	// console.log($("<div>" + ques_content + "</div>").find('.form_fild_row')[0]) ;

	// console.log(ques_content);
	// console.log($("<div>" + ques_content + "</div>").find('.form_fild_row').addClass(chec+'ques'));
	// console.log($(ques_content));
	// console.log(ques_content);

	$('div.for_36_37_38').append(ques_content);
	// alert($('<div/>').html(ques_content).contents());
	// console.log($('<div/>').html(ques_content).contents());
$('div.for_36_37_38 .form_fild_row:last').addClass(chec+'ques');

$('div.for_36_37_38 .form_fild_row:last label.quest').text('Which '+chec.replace("36_37_38_","")+'?');
$("div.for_36_37_38 .form_fild_row:last .right input[type='radio']").attr('id', chec+'ques_right').attr('name', chec);
$("div.for_36_37_38 .form_fild_row:last .right label").attr('for', chec+'ques_right');
$("div.for_36_37_38 .form_fild_row:last .left input[type='radio']").attr('id', chec+'ques_left').attr('name', chec);
$("div.for_36_37_38 .form_fild_row:last .left label").attr('for', chec+'ques_left');
$("div.for_36_37_38 .form_fild_row:last .both input[type='radio']").attr('id', chec+'ques_both').attr('name', chec);
$("div.for_36_37_38 .form_fild_row:last .both label").attr('for', chec+'ques_both');

}
</script>
							<?php
							break;

							case 4:
							?>
		<div class="col-md-12">
			<div class="form-group form_fild_row">
					<?php if($value->id == 102 || $value->id == 43 || ($value->id == 103 && $login_user['gender'] == 1) || ($value->id == 103 && $login_user['gender'] == 0)){ ?>
					 	<label><?= $value->question ?></label>
					 <?php } ?>

					 	<?php if($value->id == 102){
					 			if($login_user['gender'] == 1){

					 				echo $this->element('front/abdominal_man', array('valueid' => $value->id,'step_id' => $step_id)) ;
					 			}elseif($login_user['gender'] == 0){

					 				echo $this->element('front/abdominal_female', array('valueid' => $value->id,'step_id' => $step_id)) ;
					 			}

					 	}


					 	if($value->id == 103){
					 			if($login_user['gender'] == 1){

					 				echo $this->element('front/chest_man', array('valueid' => $value->id)) ;
					 			}elseif($login_user['gender'] == 0){

					 				echo $this->element('front/chest_girl', array('valueid' => $value->id)) ;

					 			}

					 	}

					 	if($value->id == 43){ ?>
		<?php echo $this->element('front/detail_question_pic', array('valueid' => $value->id)) ;

		 }?>

			</div>
		</div>
					 <?php



								break;

										    default:

										        break;

										}
						}
					}

					?>



			   </div>
<script type="text/javascript">
	var date = new Date();
	$('#question_44').timepicker();
	$('#question_89').timepicker();
	$('#question_65').datepicker({maxDate: date});
	$('#question_105').datepicker({maxDate: date});

                // $(document).on("click",".detail_ques_cls button",function(event) {
                	$(".detail_ques_cls button").unbind().click(function() {
                		//console.log($(this).parents('.detail_ques_cls').prev('input').val());

                	var tp = $(this).parents('.detail_ques_cls').prev('input').val();
                	var tpm = $(this).attr('attr_val');
                	var que_id = $(this).attr('data-que');

                	if(tpm == 'nothing' || tpm == 'Nothing' || tpm == "i don't know"){
                		$(this).parents('.detail_ques_cls').prev('input').val($(this).attr('attr_val'));

                		$('.quickpicks_question_'+que_id+' button').each(function(){

   							//alert($(this).text());
   							$(this).removeClass('selected_chief_complaint');
   						})

                	}else{
                	// alert(tp) ; alert($(this).attr('attr_val'));
	                	if(tp && tp.toLowerCase().indexOf(tpm.toLowerCase()) == -1)
	                		if(tp.indexOf('nothing') != -1 || tp.indexOf('Nothing') != -1 || tp.indexOf("i don't know") != -1){

	                			$(this).parents('.detail_ques_cls').prev('input').val($(this).attr('attr_val'));

	                		}else{

	       						$(this).parents('.detail_ques_cls').prev('input').val(tp+", "+tpm);
	       					}
	   					else if(!tp)
   							$(this).parents('.detail_ques_cls').prev('input').val($(this).attr('attr_val'));

   						$('.quickpicks_question_'+que_id+' button').each(function(){

   							//alert($(this).text());
   							if($(this).attr('attr_val') == 'Nothing' || $(this).attr('attr_val') == 'nothing' || $(this).attr('attr_val') == "i don't know"){

   								$(this).removeClass('selected_chief_complaint');
   							}

   						});

   					}

   					$(this).addClass('selected_chief_complaint');

                });



$('select').on('change', function() {
	if($(this).val())
		$(this).css('background','#fff');
	else
		$(this).css('background','#ececec');
  // if($(this).val())
});
</script>


			   <div class="back_next_button">
				<ul>
				<li>
					<?php if($user_detail['current_step_id'] == 7){ ?>
						<button id="other_detail-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
					<?php } else{ ?>
						<button id="profile-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
					<?php } ?>
				  <!-- <button id="profile-tab-backbtn" type="button" class="btn">Go to previous tab</button> -->
			     </li>
				 <li style="float: right;margin-left: auto;">
				  <button type="submit" class="btn details_next">Next</button>
				 </li>



				</ul>
			   </div>
			  <!-- <div class="back_next_button">
				<ul>
				 <li>
				  <button id="profile-tab-backbtn" type="button" class="btn">Go to previous tab</button>
			     </li>
				</ul>
			   </div> -->



			  </div>
			 </div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>">


		  <input type="hidden" name="next_steps" value="<?= $next_steps ?>">

			 <input type="hidden" name="tab_number" value="2">
			 <input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
   <?php $this->Form->end() ;

}
   ?>
     	<?php
if(in_array(3, $current_steps) && $tab_number == 3){

if(!empty($user_detail_old->chief_compliant_userdetail->old_python_file_option_3rd_tab)){
	$old_pfo3t = $user_detail_old->chief_compliant_userdetail->old_python_file_option_3rd_tab;
	$tpr = array(0 => array(), 1 => array(), 2 => array());

	if(is_array($old_pfo3t)){
		foreach ($old_pfo3t as $kpt => $vpt) {
			// pr($kpt); pr($vpt);
			$result = array();
			array_walk_recursive($vpt,function($v) use (&$result){ $result[] = $v; });
			$tpr[$kpt] = $result;
			// pr($result); die;
		}
	}
	// pr($old_pfo3t);
	// pr($tpr); die;
	$old_pfo3t = $tpr ;
}



     	// complaint details question part start  TAB - 2
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_3')); ?>

		  <div class="tab-pane fade  <?= ($tab_number==3  || 3==$current_steps[0])  ? '  show active ' : '' ?>" id="contact" role="tabpanel" aria-labelledby="contact-tab">

		  	 <div class="errorHolder">
  </div>

			  <div class="TitleHead header-sticky-tit">
			   <h3 style="text-transform: none;">Do you have any of the following symptoms?&nbsp;<span class="required">*</span></h3>
			   <div class="seprator"></div>
			  </div>

			  <div class="tab_form_fild_bg question_symptom_newapp">
			  	<div class="row">
<?php

			 if(!empty($python_symptom_output) ){
			 	// pr($python_symptom_output);
$i = 0 ;
			 	foreach ($python_symptom_output as $key => $value) {

			 		?>
	 			 <div class="col-md-4">
				 	<h4><?= ucfirst($value) ?></h4>
				 </div>
				 <div class="col-md-6">

<div class="btn-group" data-toggle="buttons">
<label class="btn btn-primary  <?= !empty($old_pfo3t[0]) && !empty(preg_grep( "/".$value."/i" , $old_pfo3t[0] )) ? 'active' : '' ?>"  for="radio_symptom<?= $i ?>">
         <input type="radio"  value="0" <?= !empty($old_pfo3t[0]) &&  !empty(preg_grep( "/".$value."/i" , $old_pfo3t[0] )) ? 'checked' : '' ?>   class="form-check-input " id="radio_symptom<?= $i++ ?>" name="associated_symptom[<?= $key ?>]" required="true" >
        No</label>
<label class="btn btn-primary  <?= !empty($old_pfo3t[1]) &&  !empty(preg_grep( "/".$value."/i" , $old_pfo3t[1] )) ? 'active' : '' ?>"  for="radio_symptom<?= $i ?>">
         <input type="radio"  value="1"  <?= !empty($old_pfo3t[1]) &&  !empty(preg_grep( "/".$value."/i" , $old_pfo3t[1] ))  ? 'checked' : '' ?>    class="form-check-input" id="radio_symptom<?= $i++ ?>" name="associated_symptom[<?= $key ?>]" required="true" >
         Yes</label>
<label class="btn btn-primary <?= !empty($old_pfo3t[2]) &&  !empty(preg_grep( "/".$value."/i" , $old_pfo3t[2] )) ? 'active' : '' ?>"  for="radio_symptom<?= $i ?>">
         <input type="radio"  value="2"  <?= !empty($old_pfo3t[2]) &&   !empty(preg_grep( "/".$value."/i" , $old_pfo3t[2] )) ? 'checked' : '' ?>    class="form-check-input" id="radio_symptom<?= $i++ ?>" name="associated_symptom[<?= $key ?>]" required="true" >
       I don't know</label>

</div>
				 </div>

<input type="hidden" name="python_symptom_output[<?= $key ?>]" value="<?= $value ?>">

			 		<?php
			 	}

			 }

			?>
				</div>


<?php /*  // commented on 11-12-18  as now we will get symptom from python file
			   <div class="row">

				  <?php
				 if(!empty($default_symptoms_id) ){
$i = 0 ;
$j = 0;

				 	foreach ($default_symptoms_id as $key => $value) {
$i++;

// we are loading tab 3  , 2 times according to client requirement (first time 5 and rest symptom 2nd time)

if(empty($tab_3_load_2_time)){
	if($j++ == 5 ) break;
}else{
	if(++$j <= 5 ) continue;
}

				 	?>
				 	<div class="col-md-4">
				 	<h4><?= ucfirst($value) ?></h4>
				 </div>
				 <div class="col-md-6">


<div class="btn-group" data-toggle="buttons">
<label class="btn btn-primary"  for="radio_symptom<?= $i ?>">
         <input type="radio"  value="0"    class="form-check-input" id="radio_symptom<?= $i++ ?>" name="associated_symptom[<?= $key ?>]" required="true" >
        No</label>
<label class="btn btn-primary"  for="radio_symptom<?= $i ?>">
         <input type="radio"  value="1"    class="form-check-input" id="radio_symptom<?= $i++ ?>" name="associated_symptom[<?= $key ?>]" required="true" >
         Yes</label>
<label class="btn btn-primary"  for="radio_symptom<?= $i ?>">
         <input type="radio"  value="2"    class="form-check-input" id="radio_symptom<?= $i++ ?>" name="associated_symptom[<?= $key ?>]" required="true" >
       I don't know</label>

</div>
</div>

				 	<?php
				 	}

				 }
				 ?>

			   </div>

			 */ ?>

			   <div class="back_next_button">
				<ul>

					<?php if($step_id == 18){ ?>

						<li>
					<button id="chronic_assessment-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
			     	</li>
			     <?php } elseif($step_id == 25 || $step_id == 28){?>

						<li>
					<button id="internal_medicine_assessment-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
			     	</li>
			     <?php } else{ ?>
						<li>
						<button id="covid_detail-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				     	</li>
				     <?php } ?>
				 <li style="float: right;margin-left: auto;">
				  <button type="submit" class="btn">Next</button>
				 </li>



				</ul>
			   </div>

			   <!-- <div class="back_next_button">
				<ul>
				<li>
		<button id="contact-tab-backbtn" type="button" class="btn">Go to previous tab</button>
			     </li>
				</ul>
			   </div> -->


			  </div>
			 </div>
		  <input type="hidden" name="next_steps" value="<?= $next_steps ?>">
  <!--  commented on 11-12-18 as not required

  	<input type="hidden" name="tab_3_load_2_time" value="<?php // echo  empty($tab_3_load_2_time) ? 1 : $tab_3_load_2_time ?>"> -->
			 <input type="hidden" name="tab_number" value="3">
			 <input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

	 <a id="hiden_contact_anchor" style="visibility: hidden;" href="#contact-tab"></a>
   <?php $this->Form->end() ;
}

    ?>

     	<?php

if($tab_number == 4 || ( $tab_number <= 4 && 4 == $current_steps[0])){  // for 4th tab different condition is used because some steps start with 4th tab

     	// complaint details question part start  TAB - 2
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_4')); ?>

		  <div class="tab-pane fade  <?= ($tab_number==4  || 4==$current_steps[0])  ? '  show active ' : '' ?>" id="family" role="tabpanel" aria-labelledby="family-tab">



<div class="errorHolder">
  </div>

<!-- -------------  add medication only appear in medication refill case  start ---------    -->

<?php if($step_id == 4) {  // this section appear only in case of medication refill ( step id is 4)      ?>

			  <div class="TitleHead header-sticky-tit">
			  <h3>Which medications do you need refilled?</h3>
			   <div class="seprator"></div>
			  </div>

  <div class="tab_form_fild_bg medication_refill_medbox">


<!-- fill the old data when edited start ******************************************************  -->
<?php
$cmd_old = '';
if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail)){
	$cmd_old = $user_detail_old->chief_compliant_userdetail->compliant_medication_detail;
// pr($cmd_old); die;
	foreach ($cmd_old as $ky => $ve) {

?>

<div class="row  currentmedicationfld">
	    <div class="col-md-4">
		 <div class="form-group form_fild_row">
	      <!-- <input type="text" class="form-control"  name="medical_history[]" placeholder="Mononucleosis"/>  -->


<div class="custom-drop">
		<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication" />
	      <ul class="med_suggestion_listul custom-drop-li">
			</ul>

		</div>


	     </div>
		</div>


			<div class="col-md-2">
				 <div class="form-group form_fild_row">
				  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>" type="text" class="form-control ignore_fld" placeholder="Dose"/>
				 </div>
				</div>

				<div class="col-md-2">
				 <div class="form-group form_fild_row">
				  <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->

				<select class="form-control" name="medication_how_often[]">
					<option value="">how often?</option>
				<?php
						foreach ($length_arr as $key => $value) {

					echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

						}
					?>
					</select>

				 </div>
				</div>
			    <div class="col-md-3">
				 <div class="form-group form_fild_row">
				  <!-- <input type="text" name="medication_how_taken[]" class="form-control" placeholder="How is it taken?"/>  -->


<div class="custom-drop">

<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken???"/>
	      <ul class="how_taken_suggestion_listul custom-drop-li">
			</ul>

		</div>



				 </div>
				</div>


		<div class="col-md-1">
	     <div class="row">

		  <div class=" currentmedicationfldtimes_med_refill">
		   <div class="crose_year">
		    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div>
<?php
}
}

?>
<!-- fill the old data when edited end ******************************************************* -->






<div class="row currentmedicationfld">

	   </div>


<div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">

		   <div class="crose_year">
		    <button  type="button"  class="btn currentmedicationfldadd_medication_refill">add a medication</button>
		   </div>


		 </div>
		</div>
	</div>

<?php //pr($user_detail_old->chief_compliant_userdetail); ?>
<?php
$old_med_refill_medication_side_effects_radio = '' ;
if(!empty($user_detail_old->chief_compliant_userdetail->med_refill_medication_side_effects_radio))
	$old_med_refill_medication_side_effects_radio = $user_detail_old->chief_compliant_userdetail->med_refill_medication_side_effects_radio;
?>

<div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">
	        <!-- <label>Any side effects from taking medication?</label> -->

	       <div class="radio_bg">
          <h4>Any side effects from taking medication?</h4>

		<div class="radio_list">
	        <div class="form-check">
	         <input type="radio" value="1" class="form-check-input medication_side_effect_radio <?php echo !empty($old_med_refill_medication_side_effects_radio) && $old_med_refill_medication_side_effects_radio == 1? "trigger_click_if_checked":"" ?> " id="medication_side_effect_radio_1" name="medication_side_effect_radio" <?php echo !empty($old_med_refill_medication_side_effects_radio) && $old_med_refill_medication_side_effects_radio == 1? "checked":"" ?>>
	         <label class="form-check-label" for="medication_side_effect_radio_1">Yes</label>
	       </div>

		   <div class="form-check">
	         <input type="radio" value="0" class="form-check-input medication_side_effect_radio" id="medication_side_effect_radio_2" name="medication_side_effect_radio" <?php echo $old_med_refill_medication_side_effects_radio == 0? "checked":"" ?>>
	         <label class="form-check-label" for="medication_side_effect_radio_2">No</label>
	       </div>
        </div>
</div>
</div>

<?php
$old_mse = '' ;
if(!empty($user_detail_old->chief_compliant_userdetail->medication_side_effects))
	$old_mse = $user_detail_old->chief_compliant_userdetail->medication_side_effects;
?>

<div class="form-group form_fild_row med_refill_medication_side_effects display_none_at_load_time">
 <div class="custom-drop">
	<input type="text" value="<?= $old_mse ?>"  class="form-control  reaction_suggestion"  data-role="tagsinput"  name="medication_side_effects" />

	      <ul class="reaction_suggestion_listul  custom-drop-li">
			</ul>
		</div>

	</div>
	</div>
</div>



</div>


<script type="text/javascript">

	$(document).on("click", "input[type='radio'].medication_side_effect_radio", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 0) {

        	$('.med_refill_medication_side_effects .reaction_suggestion').val('');
            $('.med_refill_medication_side_effects').hide();
        }else{

        	$('.med_refill_medication_side_effects').removeClass('display_none_at_load_time').show();

        }
    }
});

$(document).ready(function() {
$( ".trigger_click_if_checked" ).trigger("click");

// on first time when document load, read the input value of the taginput and enter each tag as separate tag
$( ".reaction_suggestion" ).each(function() {
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
$('.reaction_suggestion').tagsinput({
      allowDuplicates: true,

        // onTagExists: function(item, $tag) {}
        // itemValue: 'id',  // this will be used to set id of tag
        // itemText: 'label' // this will be used to set text of tag
    });
$('.reaction_suggestion').on('itemAdded', function(event) {
  // event.item: contains the item
  // alert('hi');
  // console.log(taginputli_click); // will be true only when user chooses option from list item suggestion
  // console.log('*****');
  // console.log(prev_search_val);
  // console.log($(this).val());
  // console.log('*****');

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



 var prev_search_val = '';
$(document).on('keydown click', ".bootstrap-tagsinput", function(e) {
    // console.log($(this)); ;
 // alert($(this).next().val());
  // alert($('.taginpt').val());
  // $(this).tagsinput('add', 'some tag, some tag, some other tag');
  // console.log(e);
    // e.preventDefault();

// alert(String.fromCharCode(e.keyCode));

searchRequest = null;
	if(e.type == 'keydown'){
		if(isTextSelected($(this).find('input')[0])){ // if text selected with back space we will reset search criteria
			// alert('yes') ;
		   //text selected
		   prev_search_val = '';
		}
	}

        // value = $(this).next('.prev_diagnose_suggestion').val();
        // alert(e.which);

        // if(value){
        // 	value = value.split(',');
        // 	value = value[value.length - 1] ;
        // }
 		// console.log(e.keyCode);
        // prev_search_val = String.fromCharCode(e.keyCode);
        if(e.keyCode){ // checking only when key is pressed
        	if(e.keyCode == 8){ // in case of backspace character delete last character
        		prev_search_val = prev_search_val.slice(0, -1);

        		/*
        		if(isTextSelected($(this).find('input')[0])){ // if text selected with back space we will reset search criteria
        			// alert('yes') ;
				   //text selected
				   prev_search_val = '';
				}
				*/


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





        // console.log($(this).next('.prev_diagnose_suggestion').val());
        // console.log($(this).next('.prev_diagnose_suggestion').tagsinput('items'));
        // alert('hello');
        // console.log(prev_search_val);
value = prev_search_val ;
  // alert(value);
            if (searchRequest != null)
                searchRequest.abort();
            var curele = this;
            searchRequest = $.ajax({
                type: "GET",
                url:  "<?php echo SITE_URL ?>users/getsuggestion",
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
					$(curele).parents('.custom-drop').find('.reaction_suggestion_listul').html(temphtml);

                    //we need to check if the value is the same

                }
            });





});



// ajax search for diagnose start


$(document).on("click", ".reaction_suggestion_listul li", function () {
	taginputli_click = true;  // this variable is used for tracking list item click above in taginput add tag event handler
	var diag_sugg_atr = $(this).attr('diag_sugg_atr');
// alert(diag_sugg_atr);
// alert($(this).parents('.custom-drop').find('.prev_diagnose_suggestion').val());

	var tmptext = $(this).parents('.custom-drop').find('.reaction_suggestion');

	 var ttext = $(tmptext).val();

	 // alert(ttext);
	 if(ttext.indexOf(diag_sugg_atr) == -1){  // we will add the tag only when it is not added previously
 $(tmptext).tagsinput('refresh');
	 	 $(tmptext).tagsinput('add', diag_sugg_atr);

	 	 // below line to resolve the issue of duplicate tagsinput field
	 	 $(tmptext).prev('.bootstrap-tagsinput').prev('.bootstrap-tagsinput').remove();

	 }
	$(this).parents('.reaction_suggestion_listul').empty();

});

$(document).click(function (event) {

    if ( $('.custom-drop').has(event.target).length === 0)
    {
        $('.custom-drop-li').hide();
    }else{
    	 $(event.target).parents('.custom-drop').find('.custom-drop-li').show();
    }
});




});

</script>

<?php } ?>

<!--  -------------  add medication only appear in medication refill case end ---------    -->


			  <div class="TitleHead header-sticky-tit">
			   <!-- <h3 style="text-transform: none;">Have you had any of these symptoms in the past month?&nbsp;<span class="required">*</span></h3> -->
			   <h3 style="text-transform: none;">Have you had any of these symptoms in the past month?</h3>
			   <div class="seprator"></div>
			  </div>

			  <div class="tab_form_fild_bg question_symptom_newapp">
			   <div class="row">



				<div class="col-md-12">
				 <div class="form-group form_fild_row">
				  <!-- <input type="text" class="form-control" placeholder="Family member"/>  -->

<ul class="nav nav-tabs nav-tabs-pad" id="myTab222" role="tablist">
	<?php if(!empty($compliant_questin)){ ?>

		<li class="nav-item">
		    <a class="nav-link active" id="home-tab222" data-toggle="tab" href="#home222" role="tab" aria-controls="home222" aria-selected="true">Part 1</a>
		</li>

	<?php

		if(($step_id != 19 && count($compliant_questin) > 15) || (in_array($step_id,[19,21,25]) && count($compliant_questin) > 20) || ($step_id == 1 && count($compliant_questin) > 16)){ ?>

			<li class="nav-item">
			    <a class="nav-link" id="profile-tab222" data-toggle="tab" href="#profile222" role="tab" aria-controls="profile222" aria-selected="false">Part 2</a>
			</li>
	<?php	}

		//other health questionnaire is shown for step id = 18 and step id = 19
		if(($step_id == 18 && count($compliant_questin) > 30) || (in_array($step_id,[19,21,25]) && count($compliant_questin) > 40) || ($step_id == 1 && count($compliant_questin) > 40)) { ?>

			<li class="nav-item">
			    <a class="nav-link" id="chronic-tab222" data-toggle="tab" href="#chronic222" role="tab" aria-controls="chronic222" aria-selected="false">Part 3</a>
			 </li>

	<?php }

		if(($step_id == 18 && count($compliant_questin) > 45) || (in_array($step_id,[19,21,25]) && count($compliant_questin) > 60)){ ?>

			<li class="nav-item">
			    <a class="nav-link" id="chronic-tab333" data-toggle="tab" href="#chronic333" role="tab" aria-controls="chronic333" aria-selected="false">Part 4</a>
			</li>

	<?php }

		if(($step_id == 18 && count($compliant_questin) > 60) || (in_array($step_id,[19,21,25]) && count($compliant_questin) > 80)){ ?>

			<li class="nav-item">
		    	<a class="nav-link" id="chronic-tab444" data-toggle="tab" href="#chronic444" role="tab" aria-controls="chronic444" aria-selected="false">Part 5</a>
		  	</li>

		<?php }

		if(($step_id == 18 && count($compliant_questin) > 75) || (in_array($step_id,[19,21,25]) && count($compliant_questin) > 100)) { ?>

			<li class="nav-item">
			    <a class="nav-link" id="chronic-tab555" data-toggle="tab" href="#chronic555" role="tab" aria-controls="chronic555" aria-selected="false">Part 6</a>
			</li>

	<?php }

		}

	?>

</ul>
<div class="tab-content" id="myTabContent222">
	<div class="tab_content_inner">
  <div class="tab-pane fade show active" id="home222" role="tabpanel" aria-labelledby="home-tab222">




 										<?php
// echo 'hello' ;
 				//pr($compliant_questin); die;
// echo 'hhh'; die;
	if(!empty($compliant_questin) )
	{
		$old_qd = array();
		if(!empty($user_detail_old->chief_compliant_userdetail->questionnaire_detail))
			$old_qd = $user_detail_old->chief_compliant_userdetail->questionnaire_detail;

		//pr($old_qd);

		$i = 0 ;
		$j = 0;
		$ic = 0;
		// pr($old_qd);
		foreach ($compliant_questin as $key => $value)
		{		
		 //echo $value->id;	
			if(in_array($step_id,[19,21]))
			{
				if($j == 20){
				?>

				<div class="back_next_button">
				<ul>
				<li>
					<button id="cancer_medical_history-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
			    </li>
				<li style="float: right;margin-left: auto;">
				  <button type="button" class="btn go_to_part_2">Next</button>
				</li>
				</ul>
			   </div>
			</div>
			<div class="tab-pane fade" id="profile222" role="tabpanel" aria-labelledby="profile-tab222">

				<?php
				}
		     }
				 else{

				 if(($step_id ==1 && $j == 21) || (!in_array($step_id,[1]) && $j == 16)){
				 	?>

				<div class="back_next_button">
				<ul>
				<li>
					<?php if($step_id == 10){ ?>
						<button id="profile-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id == 14){ ?>
						<button id="disease_detail-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}


				elseif($step_id == 1){ ?>
						<button id="primary-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id == 2){ ?>
						<button id="annual-phq9-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id == 15){ ?>
						<button id="pre_op_medications-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id == 20){ ?>
						<button id="pre_op_post_op-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id == 22){ ?>
						<button id="hospital_er_info-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}
				elseif($step_id == 25 || $step_id == 28){ ?>
						<button id="internal_medicine_info-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id != 4){ ?>


					<button id="family-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php } ?>
			     </li>
				 <li style="float: right;margin-left: auto;">
				  <button type="button" class="btn go_to_part_2">Next</button>
				 </li>
				</ul>


			   </div>



				</div>
				<div class="tab-pane fade" id="profile222" role="tabpanel" aria-labelledby="profile-tab222">

				<?php }
				} ?>

				<?php
				//this is used in chronic conditions module only
				if(($step_id == 18 && $j == 30) || (in_array($step_id,[19,21,25]) && $j == 40) || ($step_id == 1 && $j == 52)){
				 	?>

				<div class="back_next_button">
				<ul>

				 <li style="float: right;margin-left: auto;">
				  <button type="button" class="btn go_to_part_3">Next</button>
				 </li>


				</ul>
			   </div>

				</div>
				<div class="tab-pane fade" id="chronic222" role="tabpanel" aria-labelledby="chronic-tab222">

				<?php }

				//this is used in chronic conditions module only
				if(($step_id == 18 && $j == 45) || (in_array($step_id,[19,21,25]) && $j == 60)){

				 	?>

				<div class="back_next_button">
				<ul>

				 <li style="float: right;margin-left: auto;">
				  <button type="button" class="btn go_to_part_4">Next</button>
				 </li>


				</ul>
			   </div>

</div>
<div class="tab-pane fade" id="chronic333" role="tabpanel" aria-labelledby="chronic-tab333">

				<?php }
				//this is used in chronic conditions module only
				if(in_array($step_id,[19,21,25]) && $j == 80){

				 	?>

				<div class="back_next_button">
				<ul>

				 <li style="float: right;margin-left: auto;">
				  <button type="button" class="btn go_to_part_5">Next</button>
				 </li>


				</ul>
			   </div>

</div>
<div class="tab-pane fade" id="chronic444" role="tabpanel" aria-labelledby="chronic-tab444">

				<?php } ?>

				<?php

				//this is used in chronic conditions module only
				if(in_array($step_id,[19,21,25]) && $j == 100){

				 	?>
				<div class="back_next_button">
				<ul>
				 <li style="float: right;margin-left: auto;">
				  <button type="button" class="btn go_to_part_6">Next</button>
				 </li>
				</ul>
			   </div>

</div>
<div class="tab-pane fade" id="chronic555" role="tabpanel" aria-labelledby="chronic-tab555">

				<?php } ?>




				<!-- <div class="row">
				<div class="col-md-4"><h4><?= ucfirst($value->questionnaire_text) ?></span></h4>
				</div>
				<div class="col-md-6">

<div class="btn-group" data-toggle="buttons">
<label class="btn btn-primary  <?= !empty($old_qd[0]) && in_array($value->id, $old_qd[0]) ? 'active' : '' ?> "  for="question_symptom<?= $i ?>">
         <input type="radio"  value="0" <?= !empty($old_qd[0]) && in_array($value->id, $old_qd[0]) ? 'checked' : '' ?>   class="form-check-input" id="question_symptom<?= $i++ ?>" name="question_symptom[<?= $value->id ?>]" required="true">
         No</label>

<label class="btn btn-primary    <?= !empty($old_qd[1]) && in_array($value->id, $old_qd[1]) ? 'active' : '' ?>  "  for="question_symptom<?= $i ?>">
         <input type="radio"  value="1"   <?= !empty($old_qd[1]) && in_array($value->id, $old_qd[1]) ? 'checked' : '' ?>   class="form-check-input" id="question_symptom<?= $i++ ?>" name="question_symptom[<?= $value->id ?>]" required="true">
        Yes</label>

<label class="btn btn-primary    <?= !empty($old_qd[2]) && in_array($value->id, $old_qd[2]) ? 'active' : '' ?>  "  for="question_symptom<?= $i ?>">
         <input type="radio"  value="2"  <?= !empty($old_qd[2]) && in_array($value->id, $old_qd[2]) ? 'checked' : '' ?>    class="form-check-input" id="question_symptom<?= ++$i ?>" name="question_symptom[<?= $value->id ?>]" required="true">
        I don't know</label>
       </div>
       </div>

</div> -->

<div class="row">
<div class="col-md-12">		
	<div class="form-group form_fild_row fdsfd">			
			<div class="check_box_bg">
				<div class="custom-control custom-checkbox">
					<input <?= !empty($old_qd[1]) && in_array($value['id'], $old_qd[1]) ? 'checked' : '' ?> class="custom-control-input"  name="question_symptom[<?= $value['id'] ?>]"  id="checkbox<?= $ic ?>" value="1" fixval="1" subques="1" type="checkbox">
					<input type="hidden" name="all_question_symptom[<?php echo $value['id'] ?>]" value="0">
					<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= ucfirst($value->questionnaire_text) ?></label>
				</div>
			</div>
			<?php
			$ic++;
	 	?>		
	</div>
</div>
</div>

 	<?php

 		$j++;

 	}

 }
 ?>


			<div class="back_next_button">
				<ul>
				<?php if(!empty($compliant_questin) && (($step_id != 19 && count($compliant_questin) < 15) || (in_array($step_id,[19,21,25]) && count($compliant_questin) < 20))){ ?>
				<li>
					<?php if($step_id == 10){ ?>
						<button id="profile-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id == 14){ ?>
						<button id="disease_detail-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}


				elseif($step_id == 15){ ?>
						<button id="pre_op_medications-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php	}

				elseif($step_id != 4){ ?>


				<button id="family-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				<?php } ?>
			     </li>
			    <?php } ?>
				<!--  <li style="float: right;margin-left: auto;">
				  <button type="submit" class="btn">Next</button>
				 </li> -->
				<li style="float: right;margin-left: auto;">
				<?php if($is_show_payment != 1){?>
				<button type="submit" class="btn ml-auto">Send Report</button>
				<?php }else{?>
				<button type="button" id="send_report" data-url="<?php echo SITE_URL."users/payment/".base64_encode($apt_id_data->id).'/'. base64_encode($apt_id_data->schedule_id).'/'.base64_encode($apt_id_data->organization_id)?>" class="btn ml-auto send_report">Send Report</button>
				<?php } ?>
			    </li>



				</ul>
			   </div>

				 </div>
</div>
				 </div>

				</div>
			   </div>
			  </div>
			 </div>
		  <input type="hidden" name="next_steps" value="<?= $next_steps ?>">

			 <input type="hidden" name="tab_number" value="4">
			 <input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
	 <a id="hiden_family_anchor" style="" href="#family-tab"></a>
   <?php $this->Form->end() ;
}
   ?>

     	<?php
if(in_array(5, $current_steps) && $tab_number == 5  ){
     	// complaint details question part start  TAB - 2
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_5')); ?>

		  <div class="tab-pane fade  <?= ($tab_number==5 || 5==$current_steps[0])  ? '  show active ' : '' ?>" id="allergies" role="tabpanel" aria-labelledby="allergies-tab">

		<?php

		if(!empty($already_sent)){
		?>
		<span style="font-size: 18px; " class="message success">Appointment already submitted.</span><br><hr>
		<?php
		} elseif(!empty($message_id)){
		?>
		<span  style="font-size: 18px; "  class="message success">Appointment successfully submitted to EHR, please keep this message id(<?php echo $message_id ; ?>) for future reference.  </span><br><hr>
		<?php
		}
		/*
		else {
		?>
		<span class="message error">Appointment could not be submitted to EHR.  </span><br><hr>

	<?php }
	*/

	?>



			<div class="TitleHead">
				<div class="d-flex align-items-center">
					<?php if($is_hide_summary == 1){?>
					<h3>Summary</h3>
					 <?php }?>
					<?php if($is_show_payment != 1){?>
			   		 <button type="submit" class="btn ml-auto">Send Report</button>
			   		<?php }else{?>
			   		<button type="button" id="send_report" data-url="<?php echo SITE_URL."users/payment/".base64_encode($apt_id_data->id).'/'. base64_encode($apt_id_data->schedule_id).'/'.base64_encode($apt_id_data->organization_id)?>" class="btn ml-auto send_report">Send Report</button>
			   	<?php } ?>
				</div>
			  </div>

		    <div class="tab_form_fild_bg">
			   <div class="row">
				<div class="col-md-12">
				 <div class="form-group form_fild_row">
				 	<div class="back_next_button">
						<ul>
							<li style="float: right;margin-left: auto;">

							 </li>
							</ul>
						</div>
						<?php if($is_hide_summary == 1){?>
				 	<h4><b>Please review the following information before sending.</b></h4><br />
				 <?php }?>
				  <!-- <input type="text" class="form-control" placeholder="Fish"/>  -->



				  <?php
// 				  pr($login_user);
 //pr($user_detail); die;
	  	if(!empty($user_detail)){
// pr($user_detail); die;
	// preparing layman summary start  ***********
	if(isset($user_detail->all_cc_detail_name)){

        $all_cc_name = $user_detail->all_cc_detail_name;
    }
    else{

      $all_cc_name = '';
    }
	$layman_summar = '' ;
	$prev_visit_layman_summar = '' ;
	$pre_visit_other_detail_question_layman = "";
	$pain_update_question_layman = null;
	$general_update_question_layman = null;
	$organization_name = "";
	$doctor_name = "";
	$screening_question_detail_layman = "";
	$post_checkup_detail_layman = "";
	$prev_visit_screening_question_detail = '';
	$prev_visit_post_checkup_detail_layman = "";
	$pre_op_procedure_detail_question_layman = "";
	$pre_op_medical_conditions_layman = "";
	$pre_op_alleries_conditions_layman  = '';
	$pre_op_not_affected_medical_conditions_layman = "";
	$pre_op_not_affected_alleries_conditions_layman = "";
	$pre_op_medication_detail_question_layman = "";
	$cronic_disease_layman = "";
	$follow_up_sx_detail = '';
	$phq_9_detail_layman = '';
	$covid_detail_layman = '';
	$cancer_cc_detail = '';
	$cancer_history_detail = '';
	$internal_medicine_layman = '';
	$general_internal_medicine_detail = '';
	$taps1_internal_medicine_detail = '';
	$taps2_internal_medicine_detail = '';
	$chronic_pain_assessment_detail_layman = '';
	$chronic_opioid_overdose_risk_detail_layman = '';
	$chronic_opioid_risk_tool_detail_layman = '';
	$cancer_assessments = '';
	$cancer_medical_detail = '';
	//$followup_assessments = '';
	$pre_op_post_op_layman = '';
	$general_follow_up_detail_layman = '';
	$followup_medical_history_detail_detail_layman = '';
	$chief_complaint_psychiatry_layman = '';

	$medication_refill_extra_detail_score = $this->General->prepare_medication_refill_extra_details_layman($user_detail->medication_refill_extra_details, $user_detail->medication_refill_comm_soapp_details);
	$focused_history_layman_detail = $this->General->focuses_history_layman($user_detail->focused_history_detail);
    $focused_history_layman = $focused_history_layman_detail['layman_summar'];

    // Pain Management
    $chronic_pain_assessment_detail = $this->General->chronic_pain_assessment_detail_layman($user_detail->chronic_pain_assessment_tmb,$user_detail->chronic_pain_assessment_pmh);

	 $chronic_pain_assessment_detail_layman = $chronic_pain_assessment_detail['layman_summar'];

	 $chronic_pain_treatment_history_detail = $this->General->chronic_pain_treatment_history_layman($user_detail->chronic_pain_treatment_history,$user_detail->chronic_pain_curr_treat_history,$user_detail->chronic_pain_past_treat_history);

	 $chronic_pain_treatment_history_layman = $chronic_pain_treatment_history_detail['layman_summar'];
	 $chronic_opioid_overdose_risk_detail = $this->General->chronic_opioid_overdose_risk_detail_layman($user_detail->chronic_pain_opioid_overdose_risk);

	 $chronic_opioid_overdose_risk_detail_layman = $chronic_opioid_overdose_risk_detail['layman_summar'];
	 $chronic_opioid_risk_tool_detail = $this->General->chronic_opioid_risk_tool_detail_layman($user_detail->chronic_pain_assessment_ort);

	 $chronic_opioid_risk_tool_detail_layman = $chronic_opioid_risk_tool_detail['layman_summar'];
    // End Pain Management

	$covid_detail_layman_detail = $this->General->covid_detail_layman($user_detail->covid_detail);
	$covid_detail_layman = $covid_detail_layman_detail['layman_summar'];

	$phq_9_detail_layman_detail = $this->General->phq_9_detail_layman($user_detail->phq_9_detail);
	//$phq_9_detail_layman = $phq_9_detail_layman_detail['layman_summar'];
	if(!empty($phq_9_detail_layman_detail['layman_summar'])){
		if($step_id == 1){

			$phq_9_detail_layman .= "<br /><strong>You have been bothered by the following over the past 2 weeks:</strong><br />".$phq_9_detail_layman_detail['layman_summar'];
		}
		else{

			$phq_9_detail_layman .= "<br /><strong>You provided these details for PHQ-9:</strong><br />".$phq_9_detail_layman_detail['layman_summar'];
		}
	}



	if(!empty($user_detail->appointment_id) && isset($user_detail->appointment_id->doctor_id) && !empty($user_detail->appointment_id->doctor_id) && isset($user_detail->appointment_id->doctor_id->doctor_name)){

		$doctor_name = $user_detail->appointment_id->doctor_id->doctor_name;
	}

	if(!empty($user_detail->appointment_id) && isset($user_detail->appointment_id->organization_id) && !empty($user_detail->appointment_id->organization_id) && isset($user_detail->appointment_id->organization_id->organization_name)){

		$organization_name = $user_detail->appointment_id->organization_id->organization_name;
	}

	//pr($prev_visit_user_detail);die;
	if(isset($prev_visit_user_detail) && !empty($prev_visit_user_detail) && $step_id != 16){
		$prev_visit_tmpx = $this->General->prepare_question_layman($prev_visit_user_detail); // function in General Helper prepare questoin answer in layman format



			$prev_visit_layman_summar =  '<br /><strong style="background: #ccc;"> In your previous visit you provided these details: </strong>'.$prev_visit_tmpx['layman_summar'].'<br />';
		$prev_visit_other_question_temp = $this->General->prepare_other_question_layman($prev_visit_user_detail);
		//pr($prev_visit_other_question_temp);die;
		if(!empty($prev_visit_other_question_temp['layman_summar'])){

			$pre_visit_other_detail_question_layman = '<br /><strong> In your previous visit you provided these other details: </strong>'.$prev_visit_other_question_temp['layman_summar'].'<br />';
		}

		$prev_visit_screening_question_detail = $this->General->prepare_screening_question_layman($prev_visit_user_detail);

		if(!empty($prev_visit_screening_question_detail) && isset($prev_visit_screening_question_detail['layman_summar'])){

			$prev_visit_screening_question_detail = $prev_visit_screening_question_detail['layman_summar'].'<br />';
		}

		$prev_visit_post_checkup_detail_layman = $this->General->prepare_post_checkup_question_layman($prev_visit_user_detail);

		if(isset($prev_visit_post_checkup_detail_layman['layman_summar'])){

			$prev_visit_post_checkup_detail_layman = $prev_visit_post_checkup_detail_layman['layman_summar'];
		}

		//pr($prev_visit_post_checkup_detail_layman);die;

	}


	$gender = $user_detail->user['gender'];

	if(!empty($user_detail->user['gender'])){
	  $gender = Security::decrypt(base64_decode($user_detail->user['gender']) , SEC_KEY);
	}

	$tmpx = $this->General->prepare_question_layman($user_detail,$gender); // function in General Helper prepare questoin answer in layman format

	$other_question_layman = $this->General->prepare_other_question_layman($user_detail);
	$screening_question_detail_layman = $this->General->prepare_screening_question_layman($user_detail);
	if(!empty($screening_question_detail_layman) && isset($screening_question_detail_layman['layman_summar'])){

		$screening_question_detail_layman = $screening_question_detail_layman['layman_summar'];
	}

	$pre_op_procedure_detail_question_layman = $this->General->prepare_pre_op_procedure_detail_question_layman($user_detail);

	if(!empty($pre_op_procedure_detail_question_layman) && isset($pre_op_procedure_detail_question_layman['layman_summar'])){

		$pre_op_procedure_detail_question_layman = $pre_op_procedure_detail_question_layman['layman_summar'];
	}

	$pre_op_medication_detail_question_layman = $this->General->prepare_pre_op_medication_detail_question_layman($user_detail);

    if(!empty($pre_op_medication_detail_question_layman) && isset($pre_op_medication_detail_question_layman['layman_summar'])){

      $pre_op_medication_detail_question_layman = $pre_op_medication_detail_question_layman['layman_summar'];
    }


	$pre_op_medical_conditions_layman = $this->General->prepare_pre_op_medical_conditions_layman($user_detail);
   // pr($pre_op_medical_conditions_layman);die;

    if(!empty($pre_op_medical_conditions_layman)){

      if(isset($pre_op_medical_conditions_layman['not_affected']) && !empty($pre_op_medical_conditions_layman['not_affected'])){

        $pre_op_not_affected_medical_conditions_layman = "<br>You had never diagnosed with these health conditions: ";
        $pre_op_not_affected_medical_conditions_layman .= $pre_op_medical_conditions_layman['not_affected'];
        $pre_op_not_affected_medical_conditions_layman .= "<br>";
      }

      if(isset($pre_op_medical_conditions_layman['layman_summar'])){
        $pre_op_medical_conditions_layman = $pre_op_medical_conditions_layman['layman_summar'];
      }
    }

    $pre_op_alleries_conditions_layman = $this->General->prepare_pre_op_allergies_conditions_layman($user_detail);
   // pr($pre_op_medical_conditions_layman);die;

    if(!empty($pre_op_alleries_conditions_layman)){

      if(isset($pre_op_alleries_conditions_layman['not_affected']) && !empty($pre_op_alleries_conditions_layman['not_affected'])){

        $pre_op_not_affected_alleries_conditions_layman = "<br>You are not allergic to these conditions: ";
        $pre_op_not_affected_alleries_conditions_layman .= $pre_op_alleries_conditions_layman['not_affected'];
        $pre_op_not_affected_alleries_conditions_layman .= "<br>";
      }

      if(isset($pre_op_alleries_conditions_layman['layman_summar'])){

        $pre_op_alleries_conditions_layman = $pre_op_alleries_conditions_layman['layman_summar'];
      }
    }


	//pr($pre_op_medical_conditions_layman);die;


	$post_checkup_detail_layman = $this->General->prepare_post_checkup_question_layman($user_detail);
	if(!empty($post_checkup_detail_layman) && isset($post_checkup_detail_layman['layman_summar'])){

		$post_checkup_detail_layman = $post_checkup_detail_layman['layman_summar'];
	}

	$cronic_disease_layman = $this->General->prepare_chronic_illnesses_layman($user_detail);

    if(!empty($cronic_disease_layman) && isset($cronic_disease_layman['layman_summar'])){

      $cronic_disease_layman = $cronic_disease_layman['layman_summar'];
    }


	// pr($tmpx); die;
	//$all_cc_name = $user_detail->all_cc_detail_name;
	$layman_summar = $tmpx['layman_summar'];
	$first_layman_summar = '';
	$first_name = 'User';
	//pr($user_detail);die;
if(!empty($user_detail->user->first_name))

		$first_name = $this->CryptoSecurity->decrypt( base64_decode($user_detail->user->first_name) , SEC_KEY);

	$first_layman_summar = "<h2>Hi ".ucfirst($first_name).", here is your appointment summary: </h2>";

	// pr($user_detail->chief_compliant_id); die;
  $coming_in_for = strtolower(trim($user_detail->current_step_id->step_name)) ;

 // $first_layman_summar .= "<h4>You're coming in for ".$user_detail->current_step_id->step_name.".</h4> ";
  // Condtion for hide summary

  //if($is_hide_summary == 1){

  if($step_id == 18){

  	$first_layman_summar .= "You're coming in for ".$coming_in_for.".<br /> ";
  	if(!empty($user_detail->chronic_condition)){

  		$first_layman_summar .= "You’re visiting Dr. <strong>".$doctor_name."</strong> at <strong>".$organization_name."</strong> for <strong>".(str_replace(['dmii','cad','copd','htn','chf'],['diabetes','coronary artery disease','chronic obstructive pulmonary disease','hypertension','congestive heart failure'],is_array($user_detail->chronic_condition) ? implode(", ", $user_detail->chronic_condition) : $user_detail->chronic_condition))."</strong>. <br />";
  	}
  }
  else{

  	$first_layman_summar .= "You're coming in for ".(($coming_in_for[0] == 'a' ? ' an ' : ($coming_in_for[0] == 's' ? ' ' : ' a ') ).$coming_in_for).".<br /> ";
  }

if(!empty($user_detail->random_chief_compliant))
$user_detail->random_chief_compliant = Security::decrypt( base64_decode($user_detail->random_chief_compliant) , SEC_KEY);

	if(!empty($all_cc_name)) { // if user chooses the chief compliant from list
	$all_cc_name = rtrim($all_cc_name, ', ') ;
	//$first_layman_summar .= "I see that you want to see your doctor for  <strong>".$all_cc_name.(!empty($user_detail->random_chief_compliant) ? ', '.$user_detail->random_chief_compliant : '')."</strong>. <br />";

	$first_layman_summar .= "You’re visiting Dr. <strong>".$doctor_name."</strong> at <strong>".$organization_name."</strong> for <strong>".$all_cc_name."</strong>. <br />";

	if($step_id != 6)
	$first_layman_summar .= "The ".$all_cc_name." started about <strong>".$user_detail->compliant_length." ago.</strong><br />" ;

	} elseif(!empty($user_detail->random_chief_compliant)){ // if user not chooses chief compliant from list and enter cc text manually
	//$first_layman_summar .= "I see that you want to see your doctor for  <strong>".(!empty($user_detail->random_chief_compliant) ? $user_detail->random_chief_compliant : '')."</strong>. <br />";

		$first_layman_summar .= "You’re visiting Dr. <strong>".$doctor_name."</strong> at <strong>".$organization_name."</strong> for <strong>".(!empty($user_detail->random_chief_compliant) ? $user_detail->random_chief_compliant : '')."</strong>. <br />";

	if($step_id != 6)
	$first_layman_summar .= "The ".(!empty($user_detail->random_chief_compliant) ? $user_detail->random_chief_compliant : '')." started about <strong>".$user_detail->compliant_length." ago.</strong><br />" ;
	}

	if($step_id == 8){

		if(isset($cur_cc_names)){

			$pain_update_question_layman = $this->General->prepare_pain_update_question_layman($user_detail,$cur_cc_names);
		}else{

			$pain_update_question_layman = $this->General->prepare_pain_update_question_layman($user_detail);
		}
		$pain_update_question_layman = $pain_update_question_layman['layman_summar'];

		$general_update_question_layman = $this->General->prepare_general_update_question_layman($user_detail);
		$general_update_question_layman = $general_update_question_layman['layman_summar'];

	}

	$cancer_assessments_detail_data = $this->General->prepare_cancer_assessments_layman($user_detail->cancer_assessments);

    $cancer_assessments = $cancer_assessments_detail_data['layman_summar'];

	if($step_id == 19 || $step_id == 25 || $step_id == 26 || $step_id == 28)
    {
    	$cancer_cc_detail_data = $this->General->prepare_cancer_cc_layman($user_detail->cancer_cc_detail);

    	$cancer_cc_detail = $cancer_cc_detail_data['layman_summar'];


    	$cancer_history_detail_data = $this->General->prepare_cancer_history_layman($user_detail->cancer_history_detail,$login_user['gender']);

    	$cancer_history_detail = $cancer_history_detail_data['layman_summar'];

    	$cancer_medical_detail_data = $this->General->prepare_cancer_medical_layman($user_detail->cancer_medical_detail,$user_detail->cancer_family_members,$user_detail->family_members_cancer_disease_detail,$step_id);

    	$cancer_medical_detail = $cancer_medical_detail_data['layman_summar'];

    }
    if($step_id == 25 || $step_id == 28)
    {
    	//pr($user_detail->focused_history_detail); die;
    	$is_chief_complaint_doctor = $this->General->is_chief_complaint_doctor($user_detail->is_chief_complaint_doctor);
    	$internal_medicine_layman = $is_chief_complaint_doctor['layman_summar'];

    	$internal_general_assessment_detail = $this->General->general_internal_medicine_assessment($user_detail->internal_general_assessment_detail);

    	$general_internal_medicine_detail = $internal_general_assessment_detail['layman_summar'];


    	$internal_taps1_assessment_detail = $this->General->taps1_internal_medicine_assessment($user_detail->internal_taps1_assessment_detail);
    	//pr($internal_taps1_assessment_detail);

    	$taps1_internal_medicine_detail = $internal_taps1_assessment_detail['layman_summar'];

    	$internal_taps2_assessment_detail = $this->General->taps2_internal_medicine_assessment($user_detail->internal_taps2_assessment_detail);

    	$taps2_internal_medicine_detail = $internal_taps2_assessment_detail['layman_summar'];

    }
    if($step_id == 26 || $step_id == 27)
    {
    	//pr($user_detail->focused_history_detail); die;
    	$chief_complaint_psychiatry = $this->General->chief_complaint_psychiatry($user_detail->chief_complaint_psychiatry);
    	$chief_complaint_psychiatry_layman = $chief_complaint_psychiatry['layman_summar'];

    }

		/*if($step_id == 21)
		{

			$followup_assessment_detail_data = $this->General->prepare_followup_assessments_layman($user_detail->followup_assessment);

    	$followup_assessments = $followup_assessment_detail_data['layman_summar'];

		}*/

	//pr($user_detail);die;

	if($step_id == 16 && isset($prev_visit_user_detail)){

      	$follow_up_sx_detail_data = $this->General->prepare_follow_up_sx_layman($user_detail, $prev_visit_user_detail);
      	$follow_up_sx_detail = $follow_up_sx_detail_data['layman_summar'];
    }

    $chronic_cad_layman_detail = $this->General->chronic_cad_layman($user_detail->chronic_cad_detail, $user_detail->chronic_cad_medication);
    $chronic_cad_layman = $chronic_cad_layman_detail['layman_summar'];

    $chronic_chf_layman_detail = $this->General->chronic_chf_layman($user_detail->chronic_chf_detail, $user_detail->chronic_chf_medication);
    $chronic_chf_layman = $chronic_chf_layman_detail['layman_summar'];

    $chronic_copd_layman_detail = $this->General->chronic_copd_layman($user_detail->chronic_copd_detail);
    $chronic_copd_layman = $chronic_copd_layman_detail['layman_summar'];

    $chronic_dmii_layman_detail = $this->General->chronic_dmii_layman($user_detail->chronic_dmii_detail , $user_detail->glucose_reading_detail, $user_detail->chronic_dmii_medication,$user_detail->is_chief_complaint_doctor);
    $chronic_dmii_layman = $chronic_dmii_layman_detail['layman_summar'];

    $chronic_asthma_layman_detail = $this->General->chronic_asthma_layman($user_detail->chronic_asthma_detail, $user_detail->peak_flow_reading_detail);
    $chronic_asthma_layman = $chronic_asthma_layman_detail['layman_summar'];


    $chronic_htn_layman_detail = $this->General->chronic_htn_layman($user_detail->chronic_htn_detail, $user_detail->bp_reading_detail, $user_detail->chronic_htn_medication);
    $chronic_htn_layman = $chronic_htn_layman_detail['layman_summar'];

    $chronic_general_detail_layman = $this->General->chronic_general_detail_layman($user_detail->chronic_general_detail);
    $chronic_general_layman = $chronic_general_detail_layman['layman_summar'];
    //pr($internal_medicine_layman);

    $pre_op_post_op_detail = $this->General->pre_op_post_op_layman($user_detail->pre_op_post_op);
  	$pre_op_post_op_layman = $pre_op_post_op_detail['layman_summar'];



		$general_follow_up_detail = $this->General->general_follow_up_layman($user_detail->cancer_followup_general_detail);
		$general_follow_up_detail_layman = $general_follow_up_detail['layman_summar'];


		$followup_medical_history_detail_detail = $this->General->followup_medical_history_detail_layman($user_detail->followup_medical_history_detail);
		$followup_medical_history_detail_detail_layman = $followup_medical_history_detail_detail['layman_summar'];


	$showSummaryFirstTwoParagraphSection = 	'';


	$layman_summar = $first_layman_summar.''.$other_question_layman['layman_summar'].''.$general_update_question_layman.''.$pain_update_question_layman.''.$screening_question_detail_layman .''.$post_checkup_detail_layman.''.$pre_op_procedure_detail_question_layman.''.$pre_op_medication_detail_question_layman.''.$pre_op_medical_conditions_layman.''.$pre_op_alleries_conditions_layman.''.$prev_visit_layman_summar."".$pre_visit_other_detail_question_layman.''.$prev_visit_screening_question_detail.''.$prev_visit_post_checkup_detail_layman.''.$cronic_disease_layman.''.$pre_op_not_affected_medical_conditions_layman."".$pre_op_not_affected_alleries_conditions_layman."".$follow_up_sx_detail.''.$chief_complaint_psychiatry_layman.''.$focused_history_layman.''.$chronic_pain_assessment_detail_layman.''.$chronic_pain_treatment_history_layman.''.$chronic_opioid_overdose_risk_detail_layman.''.$chronic_opioid_risk_tool_detail_layman.''.$covid_detail_layman.''.$phq_9_detail_layman.''.$chronic_cad_layman.''.$chronic_chf_layman.''.$chronic_copd_layman.''.$chronic_dmii_layman.''.$chronic_htn_layman.''.$chronic_asthma_layman.''.$chronic_general_layman.''.$internal_medicine_layman.''.$cancer_cc_detail.''.$general_internal_medicine_detail.''.$taps1_internal_medicine_detail.''.$taps2_internal_medicine_detail.''.$cancer_history_detail.''.$cancer_assessments.''.$cancer_medical_detail.''.$pre_op_post_op_layman.''.$general_follow_up_detail_layman.''.$followup_medical_history_detail_detail_layman;
		//.$cancer_cc_detail.''.$cancer_history_detail.''.$cancer_assessments.''.$cancer_medical_detail
	 // because $first_layman_summar  will come first when rendering

		if($user_detail->current_step_id->id == 4 && !empty($user_detail->compliant_medication_detail)){

          $length_arr =  '{"1x a day": "qd", "2x a day": "BID", "3x a day": "TID", "every 4 hours": "q4h", "every 6 hours": "q6h", "every 8 hours": "q8h", "every 12 hours": "q12h", "1x a week": "qwk", "2x a week": "2/wk", "3x a week": "3/wk", "at bedtime": "qhs", "in the morning": "qam", "as needed": "PRN"}' ;

          $length_arr = json_decode($length_arr, true);
          $length_arr = array_flip($length_arr);

            $layman_summar.= "<br><strong>Medication Details:- </strong></br>";
            foreach ($user_detail->compliant_medication_detail as $key => $value) {

                $layman_summar.= "Medication Name: <strong>".(isset($value['medication_name_name']) ? $value['medication_name_name'] : "")."</strong><br>";
                $layman_summar.= "Medication Dose: <strong>".(isset($value['medication_dose']) ? $value['medication_dose'] : "")."</strong><br>";
                $layman_summar.= "How Often: <strong>".(isset($value['medication_how_often']) && isset($length_arr[$value['medication_how_often']]) ? $length_arr[$value['medication_how_often']] : "")."</strong><br>";
                $layman_summar.= "How is it taken: <strong>".(isset($value['medication_how_taken']) ? $value['medication_how_taken'] : "")."</strong><br><br>";
            }
        }

        if($user_detail->current_step_id->id == 4 && !empty($user_detail->medication_side_effects)){

            $layman_summar.= "<strong>Medication side effect:- ".$user_detail->medication_side_effects."</strong></br><br>";
        }

	if(($step_id == 4 || $step_id == 26)&& !empty($user_detail->medication_refill_extra_details) && !empty($medication_refill_extra_detail_score)){

		//$layman_summar .= "You have performed <strong>SOAPP-R, COMM, DAST-10</strong>.<br><br>";
		if(!empty($medication_refill_extra_detail_score['soapp_description'])){

			$layman_summar .= "<strong>SOAPP-R Details:- </strong><br>".$medication_refill_extra_detail_score['soapp_description'].'<br>';
		}

		if(!empty($medication_refill_extra_detail_score['comm_description'])){

			$layman_summar .= "<strong>COMM Details:- </strong><br>".$medication_refill_extra_detail_score['comm_description'].'<br>';
		}

		if(!empty($medication_refill_extra_detail_score['dast_description'])){

			$layman_summar .= "<strong>DAST-10 Details:- </strong><br>".$medication_refill_extra_detail_score['dast_description'].'<br>';
		}

		if(!empty($medication_refill_extra_detail_score['padt_description'])){

			$layman_summar .= "<strong>PADT Details:- </strong><br>".$medication_refill_extra_detail_score['padt_description'].'<br>';
		}

		if(!empty($medication_refill_extra_detail_score['ort_description'])){

			$layman_summar .= "<strong>ORT Details:- </strong><br>".$medication_refill_extra_detail_score['ort_description'].'<br>';
		}
		if(!empty($medication_refill_extra_detail_score['m3_description'])){

			$layman_summar .= "<strong>M3 Details:- </strong><br>".$medication_refill_extra_detail_score['m3_description'].'<br>';
		}

	}


	if(!empty($user_detail->python_file_option_3rd_tab)){


	// $python_file_option_3rd_tab = unserialize(base64_decode($user_detail->python_file_option_3rd_tab));
    $python_file_option_3rd_tab = unserialize((Security::decrypt(base64_decode($user_detail->python_file_option_3rd_tab), SEC_KEY)));



// pr($python_file_option_3rd_tab);
	$positive_symptom = "";
	$negative_symptom = "";

	// pr($user_detail->compliant_symptom_ids); die;

	if(!empty($user_detail->compliant_symptom_ids)){

		foreach ($user_detail->compliant_symptom_ids as $key => $value) {

			$positive_symptom .= $value->name;

		}

	}

$positive_symptom = !empty($positive_symptom)? $positive_symptom.', ' : '' ;

if(!empty($user_detail->symptom_from_tab1)){
  // $tsym  = unserialize(base64_decode($user_detail->symptom_from_tab1));
	$tsym  = unserialize((Security::decrypt(base64_decode($user_detail->symptom_from_tab1), SEC_KEY)));

  $tsym = implode(', ', $tsym) ;
  $positive_symptom .=  $tsym ;
}
// pr($positive_symptom); die;
  $positive_symptom = !empty($positive_symptom)? $positive_symptom.', ' : '' ;

	if( isset($python_file_option_3rd_tab[1]) && is_array($python_file_option_3rd_tab[1])){
		foreach ($python_file_option_3rd_tab[1] as $key => $value) {
			$positive_symptom .= $value['layman'].', ';
		}

	}

	if(!empty($positive_symptom)){
				$positive_symptom = rtrim($positive_symptom, ', ') ;
		$layman_summar .= "You also have other symptoms including <strong>".$positive_symptom.".</strong><br />";
	}

	if( isset($python_file_option_3rd_tab[0]) && is_array($python_file_option_3rd_tab[0])){
		foreach ($python_file_option_3rd_tab[0] as $key => $value) {
			$negative_symptom .= $value['layman'].', ';
		}
		$negative_symptom = rtrim($negative_symptom, ', ') ;
		$layman_summar .= "You do not have <strong>".htmlspecialchars($negative_symptom) .".</strong><br />" ;
	}



	}


/* // commented on 11-12-18 as now we are reading symptom from python file and read data from different field
	// You also have other symptoms including phlegm, sore throat, muscle soreness.
	// You do NOT have runny nose.
	$positive_symptom = "";
	$negative_symptom = "";
	if( isset($user_detail->chief_compliant_symptoms[1]) && is_array($user_detail->chief_compliant_symptoms[1])){
		foreach ($user_detail->chief_compliant_symptoms[1] as $key => $value) {
			$positive_symptom .= $value->name.', ';
		}
		$positive_symptom = rtrim($positive_symptom, ', ') ;
		$layman_summar .= "<br />You also have other symptoms including <strong>".$positive_symptom.".</strong><br />";
	}

	if( isset($user_detail->chief_compliant_symptoms[0]) && is_array($user_detail->chief_compliant_symptoms[0])){
		foreach ($user_detail->chief_compliant_symptoms[0] as $key => $value) {
			$negative_symptom .= $value->name.', ';
		}
		$negative_symptom = rtrim($negative_symptom, ', ') ;
		$layman_summar .= "<br />You do NOT have <strong>".$negative_symptom.".</strong><br />" ;
	}
*/
	// In your general health questionnaire, you also noticed fever, vomiting, change in hearing, change in body hair, wheezing, palpitations, tremor, anxiety, red spots.
	$positive_symptom = "";
	$questionnaire_symptom = "";
	if( isset($user_detail->questionnaire_detail[1]) && is_array($user_detail->questionnaire_detail[1])){

		foreach ($user_detail->questionnaire_detail[1] as $key => $value) {
			$positive_symptom .= $value->questionnaire_text.', ';
		}
		$positive_symptom = rtrim($positive_symptom, ', ') ;
		$positive_symptom = strtolower($positive_symptom);
	$questionnaire_symptom = "<br />In your general health questionnaire, you also noticed <strong>".htmlspecialchars($positive_symptom)."</strong><br />";
	$layman_summar .= $questionnaire_symptom;
		}

	//Your medical history was last updated on 10/19/2018 03:54
	// pr($login_user); die;
	if(!empty($user_detail->user->medical_history_update_date))
	{
		$layman_summar .= "Your <strong>medical history </strong> was last updated on ".(!is_null($user_detail->user->medical_history_update_date) ? $user_detail->user->medical_history_update_date->i18nFormat('MM/dd/yyyy') : '').".<br />";
    }




    if($is_hide_summary == 1){

	 	echo "<div style='font-size: 18px; '>".$layman_summar."</div>" ;
    }
    else
    {
      	echo "<div style='font-size: 18px; '>".$showSummaryFirstTwoParagraphSection."</div>" ;
    }

	// preparing layman summary end **************

  	//}



  ?>

				 </div>
<!-- End Hidden summary  -->
<?php }if(empty($message_id)){ ?>
 <div class="form-group form_fild_row">
<label>Any other comments?</label>
<input type="text" class="form-control" name="additional_comment"  />
 </div>

<?php } ?>
				</div>


			   </div>

			    <div class="summary-page-previous-btn-left">

			   <?php

						if($user_detail_old->chief_compliant_userdetail->current_step_id['id'] == 18){

							$temp_chronic_cond = array();
							if(!empty($user_detail_old->chief_compliant_userdetail->chronic_condition) && is_array($user_detail_old->chief_compliant_userdetail->chronic_condition)){

								$temp_chronic_cond  = $user_detail_old->chief_compliant_userdetail->chronic_condition;
								//remove the other condition
						        if(($temp_key = array_search('other', $temp_chronic_cond)) !== false){

						          unset($temp_chronic_cond[$temp_key]);
						        }
							}

							if(empty($message_id) && ((empty($temp_chronic_cond)) || (!empty($user_detail_old->chief_compliant_userdetail->questionnaire_detail) && !empty($temp_chronic_cond)) )){


								if(empty($temp_chronic_cond)){
								?>

									<!-- <button id="chronic_condition-backbtn" type="button" class="btn">Previous tab</button> -->
									<?php if($step_id != 25){ ?>
										<button id="chronic_condition-backbtn" type="button" class="btn nofillborder">Previous tab</button>
									<?php } ?>
							 <?php }

							 	else{ ?>

									<button id="allergies-tab-backbtn" type="button" class="btn nofillborder">Previous tab</button>

						<?php }

							  ?>
					<?php	}
						}
					 ?>
		<?php


		if(empty($message_id) && !empty($user_detail_old->chief_compliant_userdetail->questionnaire_detail)){

			if($user_detail_old->chief_compliant_userdetail->current_step_id['id'] == 4 && isset($show_tab_16) && $show_tab_16 == 1){
		?>

				<button id="mad_refill_drug-backbtn" type="button" class="btn nofillborder">Previous Tab</button>


		<?php }else{
			if($user_detail_old->chief_compliant_userdetail->current_step_id['id'] != 18){
		 ?>


		<button id="allergies-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>


		<?php } } } ?>


		<?php

		//pr($user_detail_old->chief_compliant_userdetail->current_step_id);

		if(empty($message_id) && !empty($user_detail_old->chief_compliant_userdetail->pain_update_question) && $user_detail_old->chief_compliant_userdetail->current_step_id['id'] == 8){
		?>

	<button id="pain_updates-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>


		<?php } ?>

		<?php

		//pr($user_detail_old->chief_compliant_userdetail->current_step_id);

		if(empty($message_id) && !empty($user_detail_old->chief_compliant_userdetail->pre_op_allergies_detail) && $user_detail_old->chief_compliant_userdetail->current_step_id['id'] == 13){
		?>

	<button id="pre_op_allergies-backbtn" type="button" class="btn nofillborder">Previous Tab</button>




		<?php } ?>
		<?php if(empty($message_id) && $user_detail_old->chief_compliant_userdetail->current_step_id['id'] == 26){
		?>

	<button id="pre_assessment-backbtn" type="button" class="btn nofillborder">Previous Tab</button>




		<?php } ?>
	<?php if(empty($message_id) && $user_detail_old->chief_compliant_userdetail->current_step_id['id'] == 27){
		?>

	<button id="folloup_general-backbtn" type="button" class="btn nofillborder">Previous Tab</button>




		<?php } ?>
	</div>

			   <div class="back_next_button back_next_button_sticky">
				<ul class="clearfix">

					 <li style="float: right;margin-left: auto;">
				  <button type="submit" class="btn">Send Report</button>
				 </li>

				</ul>
			   </div>

			 <!-- <div class="back_next_button back_next_button_sticky">
				<ul class="clearfix">

					 <li style="float: right;">
				  <button type="button" id="send_report" data-url="<?php echo SITE_URL."users/payment/".base64_encode($apt_id_data->id).'/'. $apt_id_data->schedule_id?>" class="btn send_report">Send Report</button>
				 </li>
				</ul>
			   </div> -->


			  </div>
		  </div>
		  <input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		 <input type="hidden" name="tab_number" value="5">
		 <input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

	 <a id="hiden_allergies_anchor" style="visibility: hidden;" href="#allergies-tab"></a>

   <?php $this->Form->end() ;
}
   ?>

   <?php

//pr($tab_number);die;

if(in_array(6, $current_steps) && $tab_number == 6 ){

	$old_other_questions_treatment_detail = null;
	$old_taken_before_medicine_info = null;

	//pr($user_detail_old->chief_compliant_userdetail);die;

	if(!empty($user_detail_old->chief_compliant_userdetail->chief_compliant_other_details))

		$old_chief_compliant_other_details = $user_detail_old->chief_compliant_userdetail->chief_compliant_other_details ;
	//pr($old_chief_compliant_other_details);

	if(!empty($user_detail_old->chief_compliant_userdetail->other_questions_treatment_detail))

		$old_other_questions_treatment_detail =@unserialize(Security::decrypt(base64_decode($user_detail_old->chief_compliant_userdetail->other_questions_treatment_detail),SEC_KEY));

	if(!empty($user_detail_old->chief_compliant_userdetail->taken_before_medicine_info))

		$old_taken_before_medicine_info =@unserialize(Security::decrypt(base64_decode($user_detail_old->chief_compliant_userdetail->taken_before_medicine_info),SEC_KEY));

		$ic = 1;

     	// complaint details question part start  TAB - 6
		$chief_compliant_userdata_name = isset($cur_cc_data->name) ? $cur_cc_data->name : '';
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_6')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==6  || 6==$current_steps[0])  ? '  show active ' : '' ?>" id="other_detail" role="tabpanel" aria-labelledby="other_detail-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>Chief Complaint Other Details<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="other_detail_medicine_section">
				<div class="row">
				 	<div class="col-md-12">
				 		<p>Please list all medications you have taken before:</p>
				 		<button type="button" class="btn add_more_medicine" style="margin-bottom: 15px;">add more</button>
				 		<br>
				 	</div>
				</div>

				<div class="other_detail_medication_fields">

				<?php if(!empty($old_taken_before_medicine_info)){

					foreach ($old_taken_before_medicine_info as $key => $value) {
						?>

					<div class="row medicine_detail_section">
						<div class="col-md-3">
							<div class="form-group form_fild_row">
								<div class="custom-drop">
									<input type="text" name="medicine_name[]" class="form-control medicine_sug" id="" required="true" placeholder="Name" value="<?php echo (isset($value['medicine_name']) && !empty($value['medicine_name'])) ? $value['medicine_name'] : ''; ?>">
									<ul class="medicine_suggestion_listul custom-drop-li">
									</ul>
								</div>
					 		</div>
						</div>
						<div class="col-md-3">
							<div class="form-group form_fild_row">
								<div class="custom-drop">
									<input type="text" name="medicine_dose[]" class="form-control" id="" required="true" placeholder="Dose" value="<?php echo (isset($value['medicine_dose']) && !empty($value['medicine_dose'])) ? $value['medicine_dose'] : ''; ?>">
								</div>
					 		</div>
						</div>
						<div class="col-md-3">
								<div class="form-group form_fild_row">
								<select class="form-control" name="medicine_stop_reason[]" style="background: rgb(236, 236, 236);" required="true">
									<option value="">stopping reason</option>
									<option value="1" <?php echo (isset($value['medicine_stop_reason']) && $value['medicine_stop_reason'] == 1 ) ? "selected" : ''; ?> >didn't work</option>
									<option value="2" <?php echo (isset($value['medicine_stop_reason']) && $value['medicine_stop_reason'] == 2 ) ? "selected" : ''; ?>>finished taking</option>
									<option value="3" <?php echo (isset($value['medicine_stop_reason']) && $value['medicine_stop_reason'] == 3 ) ? "selected" : ''; ?>>told to stop by doctor</option>
								</select>
								</div>
						</div>

						<div class="col-md-3">
					     <div class="row">

						  <div class="">
						   <div class="crose_year">
						    <button type="button" class="btn medicine_cross_btn btn-icon-round" style="display: none"><i class="fas fa-times"></i></button>
						   </div>
						  </div>
						 </div>
						</div>
					</div>

					<?php }
				}else{ ?>

					<div class="row medicine_detail_section">
					<div class="col-md-3">
						<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text" name="medicine_name[]" class="form-control medicine_sug" id="" required="true" placeholder="Name">
								<ul class="medicine_suggestion_listul custom-drop-li">
								</ul>
							</div>
				 		</div>
					</div>
					<div class="col-md-3">
						<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text" name="medicine_dose[]" class="form-control" id="" required="true" placeholder="Dose">
							</div>
				 		</div>
					</div>
					<div class="col-md-3">
							<div class="form-group form_fild_row">
							<select class="form-control" name="medicine_stop_reason[]" style="background: rgb(236, 236, 236);" required="true">
								<option value="">stopping reason</option>
								<option value="1">didn't work</option>
								<option value="2">finished taking</option>
								<option value="3">told to stop by doctor</option>
							</select>
							</div>
					</div>

					<div class="col-md-3">
				     <div class="row">

					  <div class="">
					   <div class="crose_year">
					    <button type="button" class="btn medicine_cross_btn btn-icon-round" style="display: none"><i class="fas fa-times"></i></button>
					   </div>
					  </div>
					 </div>
					</div>
					</div>

				 <?php } ?>

				</div>
			</div>

			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						//pr($other_detail_question_id->toArray());

						if(!empty($other_detail_question_id)){
							foreach ($other_detail_question_id as $key => $value) {

								$old_dqid_val = !empty($old_chief_compliant_other_details[$value->id]['answer']) ? $old_chief_compliant_other_details[$value->id]['answer'] : '';
								//pr($old_dqid_val);die;
								switch ($value->question_type) {
										    case 0:
										 ?>

									<div class="col-md-12 <?php echo $value->id == 3 ? "display_none_at_load_time other_detail_question_2_3": ""; ?>">
					 					<div class="form-group form_fild_row">
					 						<?= str_replace('****', $chief_compliant_userdata_name , $value->question); ?>&nbsp;<span class="required">*</span>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="other_details_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'question_'.$value->id; ?>"/>

					 					</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $value->id == 1 ? "other_detail_question_1_2_3" : ""; ?> <?php echo $value->id == 12 ? "other_detail_question_12" : "";?> <?php echo  $value->id == 34 ? 'which_joint_cls' : ''; // 35 no question depend on 34 no question ?> <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?>" id="radio_question<?= $i ?>" name="other_details_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>

				 						<?php if($value->id == 12){
				 							//if($old_dqid_val == 'Yes' && !empty($old_other_questions_treatment_detail)){
				 							?>
				 						<div class="other_detail_question_information <?php echo ($old_dqid_val == 'Yes' && !empty($old_other_questions_treatment_detail)) ? "" :'display_none_at_load_time'  ?>">
				 						<div class="row">
				 							<div class="col-md-12">
				 								<p>Please list any injections, physical therapy, or chiropractic care received:</p>
				 								<button type="button" class="btn treatment_add_btn" style="margin-bottom: 15px;">add a procedure/treatment</button>
				 								<br />
				 							</div>
				 						</div>

				 							<div class="other_detail_question_12_section">

				 								<?php if(!empty($old_other_questions_treatment_detail)){

				 										foreach ($old_other_questions_treatment_detail as $key => $value) {

				 								 ?>

				 								<div class="row treatment_detail_section">
													<div class="col-md-6">
							 							<div class="form-group form_fild_row">
															<select class="form-control" name="treatment_type[]" style="background: rgb(236, 236, 236);" required="true">
																<option value="">Procedure/Treatments</option>
																<option value="injection" <?php if($value['treatment_type'] == 'injection'){ echo 'selected'; } ?>>Injection</option>
																<option value="physical therapy" <?php if($value['treatment_type'] == 'physical therapy'){ echo 'selected'; } ?> >Physical therapy</option>
																<option value="chiropractic" <?php if($value['treatment_type'] == 'chiropractic'){ echo 'selected'; } ?> >Chiropractic</option>
															</select>
							 							</div>
													</div>
						    						<div class="col-md-3">
							 							<div class="form-group form_fild_row">
															<div class="custom-drop">

																<input type="text" name="treatment_date[]" class="form-control treatment_date" id="" required="true" value="<?php echo $value['treatment_date']; ?>">

															</div>
													 	</div>
													</div>
													<div class="col-md-3">
												     <div class="row">

													  <div class="">
													   <div class="crose_year">
													    <button type="button" class="btn treatment_cross_btn btn-icon-round"><i class="fas fa-times"></i></button>
													   </div>
													  </div>
													 </div>
													</div>
	   											</div>
	   										<?php } }else{ ?>

	   											<div class="row treatment_detail_section">
													<div class="col-md-6">
							 							<div class="form-group form_fild_row">
															<select class="form-control" name="treatment_type[]" style="background: rgb(236, 236, 236);" required="true">
																<option value="">Procedure/Treatments</option>
																<option value="injection">Injection</option>
																<option value="physical therapy">Physical therapy</option>
																<option value="chiropractic">Chiropractic</option>
															</select>
							 							</div>
													</div>
						    						<div class="col-md-3">
							 							<div class="form-group form_fild_row">
															<div class="custom-drop">

																<input type="text" name="treatment_date[]" class="form-control treatment_date" id="" required="true">

															</div>
													 	</div>
													</div>
													<div class="col-md-3">
												     <div class="row">

													  <div class="">
													   <div class="crose_year">
													    <button type="button" class="btn treatment_cross_btn btn-icon-round"><i class="fas fa-times"></i></button>
													   </div>
													  </div>
													 </div>
													</div>
	   											</div>

	   										<?php } ?>
				 							</div>
				 						</div>
				 					<?php } ?>


									</div>


								<?php
									break;
									case 3:
							 	?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<label><?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>

											<?php $options = unserialize($value->options);?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control" name="other_details_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:
							?>
									<div class="col-md-12 <?php echo $value->id == 2 ? "display_none_at_load_time other_detail_question_1_2" : ""; ?>">
										<div class="form-group form_fild_row <?= ($value->id == 2) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="<?= ($value->id == 2) ? 'new_appoint_checkbox_quest' : '' ?>">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
													// for 19 and 23 option if user select last option then other option should unchecked
											if($value->id == 2){
											 	$cb_class =  "last_option_single".$value->id  ;
											?>

											<script type="text/javascript">

											$(document).ready(function() {


											    $("input[type='checkbox'].<?= $cb_class ?>:last").change(function() {
											        if($(this).is(":checked")) {
											        		$("input[type='checkbox'].<?= $cb_class ?>:not(:last)").prop( "checked", false );
											        		$("div.for_36_37_38").empty(); // empty  the subquestion of 36,37,38  if none of the above is clicked
											        		// below code is to remove the answer of subquestion of 36,37,38 from corresponding checkbox value when None of the above is choosen
											        		$(".ques_id_36_37_38 input[type='checkbox']").each(function( index, element ) {
											        			// alert($(element).val())
											        			$(element).val(($(element).val().split('-')[0]));  // removing the subquestoin answer, that is after '-'
											        		});
											        }
											    });
											    $("input[type='checkbox'].<?= $cb_class ?>:not(:last)").change(function() {
											        if($(this).is(":checked")) {
											       		 $("input[type='checkbox'].<?= $cb_class ?>:last").prop( "checked", false );
											        }
											    });
											});

											</script>
											<?php

											 }
 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo $value->id == 2 ? "other_detail_question_2" : ""; ?>"  name="other_details_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" subques="<?= !empty($old_36_37_38[$val]) ? $old_36_37_38[$val] : '' ?>" type="checkbox" required="required">
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>

					<div class="clone_other_detail_medication_fields" style="display: none">
					<div class="row medicine_detail_section">
					<div class="col-md-3">
						<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text" name="medicine_name[]" class="form-control medicine_sug" id="" required="true" placeholder="Name">
								<ul class="medicine_suggestion_listul custom-drop-li">
								</ul>
							</div>
				 		</div>
					</div>
					<div class="col-md-3">
						<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text" name="medicine_dose[]" class="form-control" id="" required="true" placeholder="Dose">
							</div>
				 		</div>
					</div>
					<div class="col-md-3">
							<div class="form-group form_fild_row">
							<select class="form-control" name="medicine_stop_reason[]" style="background: rgb(236, 236, 236);" required="true">
								<option value="">stopping reason</option>
								<option value="1">didn't work</option>
								<option value="2">finished taking</option>
								<option value="3">told to stop by doctor</option>
							</select>
							</div>
					</div>

					<div class="col-md-3">
				     <div class="row">

					  <div class="">
					   <div class="crose_year">
					    <button type="button" class="btn medicine_cross_btn btn-icon-round" style="display: none"><i class="fas fa-times"></i></button>
					   </div>
					  </div>
					 </div>
					</div>
					</div>
				</div>
			   </div>
		<script type="text/javascript">
			searchRequest = null;
			$(document).on("keyup click", ".medicine_sug", function () {


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
			                url: "<?php echo SITE_URL; ?>"+"/users/getmedicationsuggestion",
			                data: {
			                	// 'search_type' : 1, // 1 for searching medical  condition
			                    'search_keyword' : value
			                },
			                dataType: "text",
			                success: function(msg){

			                	var msg = JSON.parse(msg);
			                	var temphtml = '' ;
			                	$.each(msg, function(index, element) {
			                		// alert(index); alert(element);
			                		// as array is flipped in server side so now value will come in index now , it was necessary , other wise result will be not sorted
			                		// alert(element);
			                		temphtml += '<li med_suggestion_attr ="'+index+'" >'+index+'</li>' ;

								});
								$(curele).next('.medicine_suggestion_listul').html(temphtml);

			                    //we need to check if the value is the same

			                }
			            });

			    });


			$(document).on("click", ".medicine_suggestion_listul li", function () {

				var diag_sugg_atr = $(this).attr('med_suggestion_attr');

				var tmptext = $(this).parents('.medicine_suggestion_listul').prev('.medicine_sug');
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

				$(this).parents('.medicine_suggestion_listul').empty();

			});

			$( document ).ready(function() {
			    $( ".trigger_click_if_checked" ).trigger("click"); // trigger click event on the checked radio buttom so that its child question made visible .

			   //$(".medicine_cross_btn:first").css('medicine_cross_btn');
			});

			$(document).on("click", "input[type='radio'].other_detail_question_1_2_3", function () {
				//console.log('dfdsf');
			    if($(this).is(':checked')) {
			    	//alert($(this).val());
			        if ($(this).val() == 'No') {

			            $('.other_detail_question_1_2').hide();
			            $('.other_detail_question_2_3').hide();
			        }else{

			        	$('.other_detail_question_1_2').removeClass('display_none_at_load_time').show();

			        }
			    }
			});

			$(document).on("click",".treatment_cross_btn",function() {

				//console.log('xXCZXC');
			 	$(this).parents('.treatment_detail_section').remove();
			 });

			$(document).on('click','.treatment_add_btn',function(){

				var treatment_form = $('.treatment_detail_form').html();
				$('.other_detail_question_12_section').append(treatment_form);

			});


			$(document).on('click','.add_more_medicine',function(){

				var medicine_form = $('.clone_other_detail_medication_fields').html();
				//$('.medicine_detail_section')
				$('.other_detail_medicine_section').append(medicine_form);
				$('.medicine_cross_btn').css('display','block');
				$('.medicine_cross_btn:first').css('display','none');

			});

			$(document).on("click",".medicine_cross_btn",function() {

				//console.log('xXCZXC');
			 	$(this).parents('.medicine_detail_section').remove();
			 });


			$(document).on("click", "input[type='radio'].other_detail_question_12", function () {
				//console.log('dfdsf');
			    if($(this).is(':checked')) {
			    	//alert($(this).val());
			        if ($(this).val() == 'No') {

			        	$('.other_detail_question_information').hide();

			            // $('.other_detail_question_1_2').hide();
			            // $('.other_detail_question_2_3').hide();
			        }else{

			        	$('.other_detail_question_information').removeClass('display_none_at_load_time').show();

			        }
			    }
			});



			$(document).on("click", "input[type='checkbox'].other_detail_question_2", function () {
				//console.log('dfdsf');
			    if($(this).is(':checked')) {
			    	//alert($(this).val());
			        if ($(this).val() == 'other') {

			        	$('.other_detail_question_2_3').removeClass('display_none_at_load_time').show();

			        }else{

			        	$('.other_detail_question_2_3').hide();
			        }
			    }
			});


/*			var datePickerOptions = {
			    dateFormat: 'yy/m/d',
			    firstDay: 1,
			    changeMonth: true,
			    changeYear: true,
			    // ...
			}

			$(document).ready(function () {
    $(".treatment_date").datepicker(datePickerOptions);
 });*/

		   $('body').on('focus',".treatment_date", function(){
		   		var date = new Date();

		        $(this).datepicker({
		        	maxDate: date
		        });
		    });

		</script>
		<div class="treatment_detail_form"  style="display: none;">
		<div class="row treatment_detail_section">
			<div class="col-md-6">
					<div class="form-group form_fild_row">
					<select class="form-control" name="treatment_type[]" style="background: rgb(236, 236, 236);" required="true">
						<option value="">Procedure/Treatments</option>
						<option value="injection">Injection</option>
						<option value="physical therapy">Physical therapy</option>
						<option value="chiropractic">Chiropractic</option>
					</select>
					</div>
			</div>
			<div class="col-md-3">
					<div class="form-group form_fild_row">
					<div class="custom-drop">

						<input type="text" name="treatment_date[]" class="form-control treatment_date" id="" required="true">

					</div>
			 	</div>
			</div>
			<div class="col-md-3">
		     <div class="row">

			  <div class="">
			   <div class="crose_year">
			    <button type="button" class="btn treatment_cross_btn btn-icon-round"><i class="fas fa-times"></i></button>
			   </div>
			  </div>
			 </div>
			</div>
			</div>
			</div>

		   <div class="back_next_button">
			<ul>
			<li>

			  <button id="profile-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>

		     </li>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="6">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>

 <?php

//pr($general_update_questions);die;

if(in_array(7, $current_steps) && $tab_number == 7 ){

	//pr($user_detail);die;

	$old_general_update_provider_info = null;
	$old_general_update_procedure_detail = null;
	$cmd_old = null;

	if(!empty($user_detail->compliant_medication_detail)){
		$cmd_old = $user_detail->compliant_medication_detail;
	}

	//pr($$user_detail_old->chief_compliant_userdetail);die;

	if(!empty($user_detail_old->chief_compliant_userdetail->general_update_question))

		$old_general_update_question = $user_detail_old->chief_compliant_userdetail->general_update_question ;

	if(!empty($user_detail_old->chief_compliant_userdetail->general_update_provider_info))

		$old_general_update_provider_info = @unserialize(Security::decrypt(base64_decode($user_detail_old->chief_compliant_userdetail->general_update_provider_info),SEC_KEY));

	if(!empty($user_detail_old->chief_compliant_userdetail->general_update_procedure_detail))

		$old_general_update_procedure_detail = @unserialize(Security::decrypt(base64_decode($user_detail_old->chief_compliant_userdetail->general_update_procedure_detail),SEC_KEY));

	if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail))

		$cmd_old =$user_detail_old->chief_compliant_userdetail->compliant_medication_detail;

		$ic = 1;

     	// complaint details question part start  TAB - 6
		$chief_compliant_userdata_name = isset($cur_cc_data->name) ? $cur_cc_data->name : '';
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_7')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==7  || 7==$current_steps[0])  ? '  show active ' : '' ?>" id="other_detail" role="tabpanel" aria-labelledby="other_detail-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>General Updates<br></h3>
			   <div class="seprator"></div>
			</div>
			<p>Are you still taking any of these medications? Please add any new ones since your last visit:</p><br />

			<div class="tab_form_fild_bg">

				<!-- fill the old data when edited start ******************************************************  -->
				<?php
				if(!empty($cmd_old)){
					//$cmd_old = $user_detail->compliant_medication_detail;

					foreach ($cmd_old as $ky => $ve) {

				?>
				<div class="row  currentmedicationfld">
	    			<div class="col-md-4">
		 				<div class="form-group form_fild_row">

							<div class="custom-drop">
								<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
								<ul class="med_suggestion_listul custom-drop-li">
								</ul>
							</div>
	     				</div>
					</div>

					<div class="col-md-2">
				 		<div class="form-group form_fild_row">
				  			<input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
						</div>
					</div>

					<div class="col-md-2">
				 		<div class="form-group form_fild_row">
							<select class="form-control" name="medication_how_often[]">
								<option value="">how often?</option>
								<?php
									foreach ($length_arr as $key => $value) {
										echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

									}
								?>
							</select>
						 </div>
					</div>
			    	<div class="col-md-3">
						<div class="form-group form_fild_row">

							<div class="custom-drop">

								<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
	      						<ul class="how_taken_suggestion_listul custom-drop-li">
								</ul>
							</div>
				 		</div>
					</div>

					<div class="col-md-1">
	     				<div class="row">
		  					<div class=" currentmedicationfldtimes">
		   						<div class="crose_year">
		    						<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   						</div>
		 					</div>
		 				</div>
					</div>
	   			</div>
			<?php
			}
			}

			?>

			<div class="row add_medication_section">
	   			<div class="col-md-6">
					<div class="form-group form_fild_row">
		   				<div class="crose_year">
		    				<button  type="button"  class="btn medication_add_btn">add a medication</button>
		   				</div>
		 			</div>
				</div>
			</div>
		</div>

	<!-- **********   medication field for clone purpose display none  start ************* -->
	<div class="row clone_purpose_medication_section_display_none">
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
				<input name="medication_dose[]" type="text" class="form-control" placeholder="Dose"/>
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group form_fild_row">
				<select class="form-control" name="medication_how_often[]">
					<option value="">how often?</option>
					<?php
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

					<input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
	      			<ul class="how_taken_suggestion_listul custom-drop-li">
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-1">
	     <div class="row">

		  <div class=" currentmedicationfldtimes">
		   <div class="crose_year">
		    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div>

	<style type="text/css">
		.clone_purpose_medication_section_display_none{ display: none; }
	</style>


			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						//pr($other_detail_question_id->toArray());

						if(!empty($general_update_questions)){
							foreach ($general_update_questions as $key => $value) {

								$old_dqid_val = !empty($old_general_update_question[$value->id]['answer']) ? $old_general_update_question[$value->id]['answer'] : '';
								//pr($old_dqid_val);die;
								switch ($value->question_type) {
										    case 0:
										 ?>

									<div class="col-md-12 <?php echo $value->id == 14 ? "display_none_at_load_time general_update_question_13_14": ""; ?>">
					 					<div class="form-group form_fild_row">
					 						<?= str_replace('****', $chief_compliant_userdata_name , $value->question); ?>&nbsp;<span class="required">*</span>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="general_update_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'question_'.$value->id; ?>"/>

					 					</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $value->id == 13 ? "general_update_question_13" : "";?> <?php echo $value->id == 16 ? "general_update_question_16" : "";?> <?php echo $value->id == 15 ? "general_update_question_15" : "";?> <?php echo $value->id == 18 ? "general_update_question_18" : "";?> <?php echo  $value->id == 34 ? 'which_joint_cls' : ''; // 35 no question depend on 34 no question ?> <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?>" id="radio_question<?= $i ?>" name="general_update_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>

				 						<?php if($value->id == 15){


				 							?>
				 						<div class="general_update_provider_information <?php echo ($old_dqid_val == 'Yes' && !empty($old_general_update_provider_info)) ? "" :'display_none_at_load_time'  ?>">
	   											<div class="row provider_detail_section">
													<div class="col-md-3">
							 							<div class="form-group form_fild_row">
							 								<label>Name of Provider</label>
															<input type="text" name="provider_name" class="form-control" id="" required="true" value="<?php echo isset($old_general_update_provider_info['provider_name']) ? $old_general_update_provider_info['provider_name'] :""; ?>">
							 							</div>
													</div>
						    						<div class="col-md-3">
							 							<div class="form-group form_fild_row">
															<div class="custom-drop">

																<label>Speciality</label>

																<input type="text" name="speciality" class="form-control" id="" required="true" value="<?php echo isset($old_general_update_provider_info['speciality']) ? $old_general_update_provider_info['speciality'] :""; ?>">

															</div>
													 	</div>
													</div>

													<div class="col-md-3">
							 							<div class="form-group form_fild_row">
							 								<label>Address</label>
															<input type="text" name="address" class="form-control" id="" required="true" value="<?php echo isset($old_general_update_provider_info['address']) ? $old_general_update_provider_info['address'] :""; ?>">
							 							</div>
													</div>

													<div class="col-md-3">
							 							<div class="form-group form_fild_row">
							 								<label>Phone Number</label>
															<input type="text" name="phone" class="form-control" id="" required="true" value="<?php echo isset($old_general_update_provider_info['phone']) ? $old_general_update_provider_info['phone'] :""; ?>">
							 							</div>
													</div>
	   											</div>
				 							</div>
				 					<?php } ?>



				 						<?php if($value->id == 18){
				 							?>

				 							<div class="general_update_procedure_information <?php echo ($old_dqid_val == 'Yes' && !empty($old_general_update_procedure_detail)) ? "" :'display_none_at_load_time'  ?>">
	   										<?php for($i =0 ; $i<3 ; $i++){ ?>
	   											<div class="row provider_detail_section">

													<div class="col-md-6">
							 							<div class="form-group form_fild_row">
							 								<?php if($i == 0){ ?>
							 								<label>Type of Procedure</label>
							 							<?php } ?>
															<input type="text" name="procedure_type[]" class="form-control" id="" required="true" value="<?php echo isset($old_general_update_procedure_detail[$i]['procedure_type'])? $old_general_update_procedure_detail[$i]['procedure_type'] :""; ?>">
							 							</div>
													</div>
						    						<div class="col-md-6">
							 							<div class="form-group form_fild_row">
															<div class="custom-drop">
																<?php if($i == 0){ ?>
																<label>Date</label>
																<?php } ?>

																<input type="text" name="procedure_date[]" class="form-control procedure_date" id="" required="true" value="<?php echo isset($old_general_update_procedure_detail[$i]['procedure_date'])? $old_general_update_procedure_detail[$i]['procedure_date'] :""; ?>">

															</div>
													 	</div>
													</div>
	   											</div>

	   										<?php } ?>
				 							</div>
				 					<?php } ?>


									</div>


								<?php
									break;
									case 3:
							 	?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<label><?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>

											<?php $options = unserialize($value->options);?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control" name="general_update_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:
							?>
									<div class="col-md-12 <?php echo $value->id == 17 ? "display_none_at_load_time general_update_question_16_17" : ""; ?>">
										<div class="form-group form_fild_row <?= ($value->id == 17) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="<?= ($value->id == 17) ? 'new_appoint_checkbox_quest' : '' ?>">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
													// for 19 and 23 option if user select last option then other option should unchecked

 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo $value->id == 2 ? "other_detail_question_2" : ""; ?>"  name="general_update_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" subques="" type="checkbox" >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>
			   </div>
		<script type="text/javascript">

			searchRequest = null;
			$(document).on("keyup click", ".med_suggestion", function () {


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
			                url: "<?php echo SITE_URL; ?>"+"/users/getmedicationsuggestion",
			                data: {
			                	// 'search_type' : 1, // 1 for searching medical  condition
			                    'search_keyword' : value
			                },
			                dataType: "text",
			                success: function(msg){

			                	var msg = JSON.parse(msg);
			                	var temphtml = '' ;
			                	$.each(msg, function(index, element) {
			                		// alert(index); alert(element);
			                		// as array is flipped in server side so now value will come in index now , it was necessary , other wise result will be not sorted
			                		// alert(element);
			                		temphtml += '<li med_suggestion_attr ="'+index+'" >'+index+'</li>' ;

								});
								$(curele).next('.med_suggestion_listul').html(temphtml);

			                    //we need to check if the value is the same

			                }
			            });

			    });


			$(document).on("click", ".med_suggestion_listul li", function () {
				//event.stopPropagation();
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

			$(document).on("click",".medication_add_btn",function() {

			    var cloneob = $( ".clone_purpose_medication_section_display_none" ).clone();

				$(cloneob).removeClass('clone_purpose_medication_section_display_none').addClass('currentmedicationfld');
				$( cloneob ).find('input.med_suggestion').addClass('medicationbox');

				  $(cloneob).insertBefore(".add_medication_section" );
				$('.ignore_fld').removeClass('ignore_fld');
			});

			$(document).on("click",".currentmedicationfldtimes",function() {

 				var remove_medication = $(this).parents('.currentmedicationfld').find('.medicationbox').val();
 				// alert('remove_medication');
 				// console.log(remove_medication);
 				var flag = false;
 				$(this).parents('.currentmedicationfld').remove();

 				$('.medicationbox').each(function(){

 					if(remove_medication == $(this).val()){

 						flag = true;
 					}
 				});

 				if(!flag){

			 		$('.medicationboxdiv button').each(function(){

			 			var attr = $(this).attr('chief_cmp_attrid_val');
			 			if(remove_medication == attr){

			 				$(this).removeClass('selected_chief_complaint');
			 			}
			 		})
 				}
 			});
		$(".medicationbox").select2({
		  allowClear:true,
		  placeholder: 'Position'
		});

			$( document ).ready(function() {
			    $( ".trigger_click_if_checked" ).trigger("click"); // trigger click event on the checked radio buttom so that its child question made visible .
			});
			$(document).on("click", "input[type='radio'].general_update_question_13", function () {
			    if($(this).is(':checked')) {

			        if ($(this).val() == 'No') {

			            $('.general_update_question_13_14').hide();

			        }else{

			        	$('.general_update_question_13_14').removeClass('display_none_at_load_time').show();
			        }
			    }
			});


			$(document).on("click", "input[type='radio'].general_update_question_16", function () {

			    if($(this).is(':checked')) {

			        if ($(this).val() == 'No') {

			        	$('.general_update_question_16_17').hide();

			        }else{

			        	$('.general_update_question_16_17').removeClass('display_none_at_load_time').show();

			        }
			    }
			});


			$(document).on("click", "input[type='radio'].general_update_question_15", function () {

			    if($(this).is(':checked')) {

			        if ($(this).val() == 'No') {

			        	$('.general_update_provider_information').hide();

			        }else{

			        	$('.general_update_provider_information').removeClass('display_none_at_load_time').show();

			        }
			    }
			});

			$(document).on("click", "input[type='radio'].general_update_question_18", function () {

			    if($(this).is(':checked')) {

			        if ($(this).val() == 'No') {

			        	$('.general_update_procedure_information').hide();

			        }else{

			        	$('.general_update_procedure_information').removeClass('display_none_at_load_time').show();

			        }
			    }
			});

		   $('body').on('focus',".procedure_date", function(){
		   		var date = new Date();
		        $(this).datepicker({

		        	maxDate: date
		        });
		    });

		</script>


		   <div class="back_next_button">
			<ul>

			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="7">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>


<?php if(in_array(8, $current_steps) && $tab_number == 8 ){


	if(!empty($user_detail_old->chief_compliant_userdetail->pain_update_question))

		$old_pain_update_question = $user_detail_old->chief_compliant_userdetail->pain_update_question ;


		$ic = 1;
		//pr($cur_cc_data);die;

     	// complaint details question part start  TAB - 6
		$chief_compliant_userdata_name = isset($cur_cc_names) ? $cur_cc_names : '';
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_8')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==8  || 8 ==$current_steps[0])  ? '  show active ' : '' ?>" id="pain_update" role="tabpanel" aria-labelledby="pain_update-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>Pain Updates<br></h3>
			   <div class="seprator"></div>
			</div>

			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						//pr($other_detail_question_id->toArray());

						if(!empty($pain_update_questions)){
							foreach ($pain_update_questions as $key => $value) {

								$old_dqid_val = !empty($old_pain_update_question[$value->id]['answer']) ? $old_pain_update_question[$value->id]['answer'] : '';
								//pr($old_dqid_val);die;
								switch ($value->question_type) {
										    case 0:
										 ?>

									<div class="col-md-12 <?php echo $value->id == 2 ? "display_none_at_load_time pain_update_question_1_2": ""; ?>">
					 					<div class="form-group form_fild_row">
					 						<?= str_replace('****', $chief_compliant_userdata_name , $value->question); ?>&nbsp;<span class="required">*</span>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="pain_update_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'question_'.$value->id; ?>"/>



							 					<?php if($apt_id_data->specialization_id == 7) {

							   		$chief_compliant_name_search = strtolower($chief_compliant_userdata_name);

							   		if($value->id == 10){ ?>

							   			<div class="common_conditions_button detail_ques_cls" style="border: none; padding-top: 10px;">
							                <ul>

												 <li class="active"><button type="button" class="btn" attr_val="laying down" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Laying down</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="sitting" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Sitting</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Exercise</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="stretching" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Stretching</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="going up stairs" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Going up stairs</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="going down stairs" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Going down stairs</span></button> </li>


												<li class="active"><button type="button" class="btn" attr_val="leaning or bending over" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Leaning or bending over</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="heat" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Heat</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="tylenol" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Tylenol</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="ibuprofen" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Ibuprofen</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="aleve" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Aleve</span></button> </li>

												<li class="active"><button type="button" class="btn" attr_val="other medication" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Other medication</span></button> </li>

							               </ul>
							             </div>

							   		<?php }

							   		if($value->id == 11){ ?>
							   				<div class="common_conditions_button detail_ques_cls" style="border: none; padding-top: 10px;">
		                						<ul>



												 		<li class="active"><button type="button" class="btn" attr_val="laying down" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Laying down</span></button> </li>

												 		<li class="active"><button type="button" class="btn" attr_val="sitting" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Sitting</span></button> </li>

														<li class="active"><button type="button" class="btn" attr_val="exercise" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Exercise</span></button> </li>

														<li class="active"><button type="button" class="btn" attr_val="stretching" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Stretching</span></button> </li>

														<li class="active"><button type="button" class="btn" attr_val="going up stairs" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Going up stairs</span></button> </li>

														<li class="active"><button type="button" class="btn" attr_val="going down stairs" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Going down stairs</span></button> </li>

														<li class="active"><button type="button" class="btn" attr_val="leaning over" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Leaning over</span></button> </li>

														<li class="active"><button type="button" class="btn" attr_val="bending over" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Bending over</span></button> </li>

														<li class="active"><button type="button" class="btn" attr_val="picking up objects" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Picking up objects</span></button> </li>

		                						</ul>
		                					</div>
							   <?php	}
							}
							   ?>
								</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $value->id == 1 ? "pain_update_question_1" : "";?> <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?>" id="radio_question<?= $i ?>" name="pain_update_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>

									</div>


								<?php
									break;
									case 3:
							 	?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<label><?= str_replace('****', $chief_compliant_userdata_name , $value->question);  ?>

											<?php $options = unserialize($value->options);?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control" name="pain_update_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:
							?>
									<div class="col-md-12">
										<div class="form-group form_fild_row <?= ($value->id == 12) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="<?= ($value->id == 12) ? 'new_appoint_checkbox_quest' : '' ?>">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
													// for 19 and 23 option if user select last option then other option should unchecked

 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="pain_update_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" subques="" type="checkbox" >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>
			   </div>
		<script type="text/javascript">

			$(".detail_ques_cls button").unbind().click(function() {
                		//console.log($(this).parents('.detail_ques_cls').prev('input').val());

                	var tp = $(this).parents('.detail_ques_cls').prev('input').val();

                	// alert(tp);
                	var tpm = $(this).attr('attr_val');
                	var que_id = $(this).attr('data-que');

                	if(tpm == 'nothing'){
                		$(this).parents('.detail_ques_cls').prev('input').val($(this).attr('attr_val'));

                		$('.quickpicks_question_'+que_id+' button').each(function(){

   							//alert($(this).text());
   							$(this).removeClass('selected_chief_complaint');
   						})

                	}else{
                	// alert(tp) ; alert($(this).attr('attr_val'));
	                	if(tp && tp.toLowerCase().indexOf(tpm.toLowerCase()) == -1)
	                		if(tp.indexOf('nothing') != -1){

	                			$(this).parents('.detail_ques_cls').prev('input').val($(this).attr('attr_val'));

	                		}else{

	       						$(this).parents('.detail_ques_cls').prev('input').val(tp+", "+tpm);
	       					}
	   					else if(!tp)
   							$(this).parents('.detail_ques_cls').prev('input').val($(this).attr('attr_val'));

   					}

   					$(this).addClass('selected_chief_complaint');

                });


			$(document).on("click", "input[type='radio'].pain_update_question_1", function () {
			    if($(this).is(':checked')) {

			        if ($(this).val() == 'No') {

			            $('.pain_update_question_1_2').hide();

			        }else{

			        	$('.pain_update_question_1_2').removeClass('display_none_at_load_time').show();
			        }
			    }
			});

		</script>


		   <div class="back_next_button">
			<ul>

				<li>
				<button id="general_updates-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
		     	</li>

			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="8">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
		<input type="hidden" name="cc_name" value="<?php echo $cur_cc_names ?>">
	<?php $this->Form->end() ; ?>

<?php }
 ?>

 <?php

//pr($tab_number);die;

if(in_array(9, $current_steps) && $tab_number == 9){

	if(!empty($user_detail_old->chief_compliant_userdetail->screening_questions_detail))

		$old_screening_questions_detail = $user_detail_old->chief_compliant_userdetail->screening_questions_detail ;

		$ic = 1;

     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_9')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==9  || 9==$current_steps[0])  ? '  show active ' : '' ?>" id="screening" role="tabpanel" aria-labelledby="other_detail-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>GI health checkup Screening detail<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						//pr($other_detail_question_id->toArray());

						if(!empty($screening_questions)){
							foreach ($screening_questions as $key => $value) {

								if(!empty($prev_visit_for_gi_health) && ($value->id == 1 || $value->id == 2)){

									continue;
								}

								$old_dqid_val = !empty($old_screening_questions_detail[$value->id]['answer']) ? $old_screening_questions_detail[$value->id]['answer'] : '';
								//pr($old_dqid_val);
								switch ($value->question_type) {
										    case 0:
										 ?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<?= $value->question ?>&nbsp;<span class="required">*</span>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="screening_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'screening_question_'.$value->id; ?>"/>

					 					</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12 <?php echo $value->id == 7 ? "screening_detail_question_6_7 display_none_at_load_time" : ""; ?>">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= $value->question ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 1 ? "screening_detail_question_1" : ""; ?> <?php echo $value->id == 6 ? "screening_detail_question_6" : ""; ?>" id="radio_question<?= $i ?>" name="screening_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div>


								<?php
									break;
									case 3:
							 	?>

									<div class="col-md-12 <?php echo $value->id == 2 ? "screening_detail_question_1_2 display_none_at_load_time" : ""; ?>">
					 					<div class="form-group form_fild_row <?php echo $value->id == 2 ? "age_dropdown_detail" : ""; ?>">
					 						<label><?= $value->question ?>

											<?php $options = unserialize($value->options);?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<?php if($value->id == 2 && isset($old_dqid_val) && !empty($old_dqid_val) && is_array($old_dqid_val)){
												foreach($old_dqid_val as $old_que2_val){
											 ?>

											<select class="form-control question_<?= $value->id ?>" <?php if($value->id == 2){ ?>name="screening_question[<?= $value->id ?>][]" <?php  } else{ ?> name="screening_question[<?= $value->id ?>]" <?php } ?> style="background: #ececec;" required="true" id="">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_que2_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>

										<?php } } else{ ?>

											<select class="form-control question_<?= $value->id ?>" <?php if($value->id == 2){ ?>name="screening_question[<?= $value->id ?>][]" <?php  } else{ ?> name="screening_question[<?= $value->id ?>]" <?php } ?> style="background: #ececec;" required="true" id="">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
											 <?php } ?>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:
							?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
													// for 19 and 23 option if user select last option then other option should unchecked
											?>
											<?php

											// }
 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="screening_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>
					<div class="clone_screening_add_more_question_2_section display_none_at_load_time">
						<div class="col-md-12 screening_add_more_question_2_section">
							<div class="row">
							 	<div class="col-md-12">
							 		<button type="button" class="btn add_more_age_dropdown" style="margin-bottom: 15px;">add more  </button>
							 		<br>
							 	</div>
							</div>
						</div>
					</div>
			   </div>
		<script type="text/javascript">

			$(document).on("click", "input[type='radio'].screening_detail_question_1", function () {
				//console.log('dfdsf');
			    if($(this).is(':checked')) {
			    	//alert($(this).val());
			        if ($(this).val() == 'No') {

			            $('.screening_detail_question_1_2').hide();
			        }else{

			        	$('.screening_detail_question_1_2').removeClass('display_none_at_load_time').show();
			        	//alert($('.screening_add_more_question_2_section').length);
			        	if($(document).has('.screening_add_more_question_2_section').length <= 1){
				        	var add_more_btn_html = $('.clone_screening_add_more_question_2_section').html();
				        	//console.log(add_more_btn_html);
				        	$(add_more_btn_html).insertAfter('.screening_detail_question_1_2');
			        	}

			        }
			    }
			});

			$(document).on('click','.add_more_age_dropdown',function(){
				//var age_dropdown  = document.getElementById('question_2');

				var age_dropdown = $('.question_2:first').clone();
				console.log(age_dropdown);
				$(age_dropdown).clone().appendTo('.age_dropdown_detail');
				//$('.question_2:last').removeAttr('selected');
			})


			$(document).on("click", "input[type='radio'].screening_detail_question_6", function () {
				//console.log('dfdsf');
			    if($(this).is(':checked')) {
			    	//alert($(this).val());
			        if ($(this).val() == 'No') {

			        	$('.screening_detail_question_6_7').hide();

			            // $('.other_detail_question_1_2').hide();
			            // $('.other_detail_question_2_3').hide();
			        }else{

			        	$('.screening_detail_question_6_7').removeClass('display_none_at_load_time').show();

			        }
			    }
			});

		</script>

		 <div class="back_next_button">
			<ul>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>
			</ul>
		 </div>
		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="9">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>



 <?php

//pr($tab_number);die;

if(in_array(10, $current_steps) && $tab_number == 10){

	//pr($post_checkup_question);

	if(!empty($user_detail_old->chief_compliant_userdetail->post_checkup_question_detail))

		$old_post_checkup_question_detail = $user_detail_old->chief_compliant_userdetail->post_checkup_question_detail ;

		$ic = 1;

     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_10')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==10  || 10==$current_steps[0])  ? '  show active ' : '' ?>" id="post_checkup_detail" role="tabpanel" aria-labelledby="post_checkup_detail-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>Post-procedure Checkup detail<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						if(!empty($post_checkup_question)){
							foreach ($post_checkup_question as $key => $value) {

								$old_dqid_val = !empty($old_post_checkup_question_detail[$value->id]['answer']) ? $old_post_checkup_question_detail[$value->id]['answer'] : '';
								//pr($old_dqid_val);
								switch ($value->question_type) {
										    case 0:
										 ?>


									<div class="col-md-12 <?php echo $value->id == 14 ? 'post_checkup_question_13_14 display_none_at_load_time': ''; ?> <?php echo $value->id == 18 ? 'post_checkup_question_16_17_18 display_none_at_load_time': ''; ?>">
					 					<div class="form-group form_fild_row">
					 						<?php if(!empty($value->question)){ ?><?= $value->question ?>&nbsp; <span class="required">*</span> <?php } ?>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="post_checkup_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'post_checkup_question_'.$value->id; ?>"/>

					 					</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12 <?php echo $value->id == 17 ? "post_checkup_question_16_17 display_none_at_load_time" : ""; ?><?php echo $value->id == 23 ? "post_checkup_question_21_23 display_none_at_load_time" : ""; ?>">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= $value->question ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 13 ? "post_checkup_question_13" : ""; ?> <?php echo $value->id == 16 ? "post_checkup_question_16" : ""; ?> <?php echo $value->id == 17 ? "post_checkup_question_17" : ""; ?>" id="radio_question<?= $i ?>" name="post_checkup_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div>


								<?php
									break;
									case 3:
							 	?>

									<div class="col-md-12 <?php echo $value->id == 22 ? "post_checkup_question_21_22 display_none_at_load_time" : ""; ?>">
					 					<div class="form-group form_fild_row">
					 						<label><?= $value->question ?>

											<?php $options = unserialize($value->options);?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control question_<?= $value->id ?>" name="post_checkup_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:
							?>
									<div class="col-md-12">
										<div class="form-group form_fild_row <?php echo $value->id == 21 ? 'new_appoint_checkbox_quest_a': ''; ?>">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="<?php echo $value->id == 21 ? 'new_appoint_checkbox_quest': ''; ?>">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
													// for 19 and 23 option if user select last option then other option should unchecked
											?>
											<?php

											// }
 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo $value->id == 21 ? "post_checkup_question_21": ""; ?>"  name="post_checkup_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required" >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>
					<div class="clone_screening_add_more_question_2_section display_none_at_load_time">
						<div class="col-md-12 screening_add_more_question_2_section">
							<div class="row">
							 	<div class="col-md-12">
							 		<button type="button" class="btn add_more_age_dropdown" style="margin-bottom: 15px;">add more</button>
							 		<br>
							 	</div>
							</div>
						</div>
					</div>
			   </div>

		   <div class="back_next_button">
			<ul>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="10">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>


 <?php

//pr($tab_number);die;

if(in_array(11, $current_steps) && $tab_number == 11){

	//pr($post_checkup_question);

	if(!empty($user_detail_old->chief_compliant_userdetail->pre_op_procedure_detail))

		$old_pre_op_procedure_detail = $user_detail_old->chief_compliant_userdetail->pre_op_procedure_detail ;

	if(!empty($user_detail_old->chief_compliant_userdetail->pre_op_medical_condition_detail))

		$old_pre_op_md = $user_detail_old->chief_compliant_userdetail->pre_op_medical_condition_detail ;

		$ic = 1;

     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_11')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==11  || 11==$current_steps[0])  ? '  show active ' : '' ?>" id="procedure_detail" role="tabpanel" aria-labelledby="procedure_detail-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>Pre Operation Procedure details<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						if(!empty($procedure_detail_question)){
							foreach ($procedure_detail_question as $key => $value) {

								$old_dqid_val = !empty($old_pre_op_procedure_detail[$value->id]['answer']) ? $old_pre_op_procedure_detail[$value->id]['answer'] : '';
								//pr($old_dqid_val);
								switch ($value->question_type) {
										    case 0:
										 ?>


									<div class="col-md-12 <?php echo $value->id == 14 ? 'procedure_detail_question_13_14 display_none_at_load_time': ''; ?> <?php echo $value->id == 26 ? 'procedure_detail_question_25_26 display_none_at_load_time': ''; ?>">
					 					<div class="form-group form_fild_row">
					 						<?php if(!empty($value->question)){ ?><?= $value->question ?>&nbsp; <span class="required">*</span> <?php } ?>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="procedure_detail_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'procedure_detail_question'.$value->id; ?>"/>

					 					</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= $value->question ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 13 ? "procedure_detail_question_13" : ""; ?> <?php echo $value->id == 25 ? "procedure_detail_question_25" : ""; ?>" id="radio_question<?= $i ?>" name="procedure_detail_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div>


								<?php
									break;
									case 3:
							 	?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<label><?= $value->question ?>

											<?php $options = unserialize($value->options);?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control question_<?= $value->id ?>" name="procedure_detail_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:
							?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
													// for 19 and 23 option if user select last option then other option should unchecked
											?>
											<?php

											// }
 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="procedure_detail_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>
			   </div>

			   <div class="TitleHead header-sticky-tit">
				   <h3>Have you ever had or been diagnosed with any of the following health conditions?<br></h3>
				   <div class="seprator"></div>
				</div>

				<?php if(!empty($common_medical_cond)){

					foreach ($common_medical_cond as $m_cond_key => $medical_conditions) { ?>

						 <div class="TitleHead">
						   <h3><?php echo $m_cond_key; ?><br></h3>
						   <div class="seprator"></div>
						</div>

						<?php $i =1; foreach ($medical_conditions as $c_key => $cond) { ?>

							<div class="row">
								<div class="col-md-4">
									<h4><?= ucfirst($cond->name) ?></h4>
								</div>
								<div class="col-md-3">

									<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-primary medical_condition_name  <?= !empty($old_pre_op_md[$cond->id]) && $old_pre_op_md[$cond->id]['name'] == 0 ? 'active' : '' ?> "  for="medical_condition<?= $i ?>"  data-id ="<?php echo $cond->id; ?>">
									         <input type="radio"  value="0" <?= !empty($old_pre_op_md[$cond->id]) && $old_pre_op_md[$cond->id]['name'] == 0 ? 'checked' : '' ?>  class="form-check-input " id="medical_condition<?= $i++ ?>" name="medical_condition[<?= $cond->id ?>][name]" required="true" >
									         No</label>

									<label class="btn btn-primary medical_condition_name   <?= !empty($old_pre_op_md[$cond->id]) && $old_pre_op_md[$cond->id]['name'] == 1 ? 'active' : '' ?> "  for="medical_condition<?= $i ?>"  data-id ="<?php echo $cond->id; ?>">
									         <input type="radio"  value="1"  <?= !empty($old_pre_op_md[$cond->id]) && $old_pre_op_md[$cond->id]['name'] == 1 ? 'checked' : '' ?>  class="form-check-input" id="medical_condition<?= $i++ ?>" name="medical_condition[<?= $cond->id ?>][name]" required="true">
									        Yes</label>
									       </div>
       							</div>

       							<div class="col-md-5 blk-one-line medical_condition_year_<?php echo $cond->id; ?> <?= !empty($old_pre_op_md[$cond->id]) && $old_pre_op_md[$cond->id]['name'] == 1 ? '' : 'display_none_at_load_time' ?>">
       								<label>Diagnosis Year</label>
       								<div class="form-group form_fild_row">
       									<select class="form-control" required name="medical_condition[<?= $cond->id ?>][year]">
								        	<option value=""></option>
								     		<option  value="1" <?= !empty($old_pre_op_md[$cond->id]) && !empty($old_pre_op_md[$cond->id]['year'] && $old_pre_op_md[$cond->id]['year'] == 1) ? ' selected ' : '' ?>>Childhood</option>
								        	<?php

								        $curyear = date('Y');
								        $start_year = 1930;
								        	for($curyear ; $curyear>= $start_year ; $curyear--){

								        		echo "<option value=".$curyear.(!empty($old_pre_op_md[$cond->id]) && !empty($old_pre_op_md[$cond->id]['year'] && $old_pre_op_md[$cond->id]['year'] == $curyear) ? ' selected ' : '').">".$curyear."</option>";
								        	}
								        	?>
									    </select>

       									<!-- <input type="text" class="form-control" name="medical_condition[<?= $cond->id ?>][year]" required = "true" value="<?= !empty($old_pre_op_md[$cond->id]) && !empty($old_pre_op_md[$cond->id]['year']) ? $old_pre_op_md[$cond->id]['year'] : '' ?>"> -->
       								</div>
       							</div>

							</div>

						<?php } ?>

				<?php	}

				} ?>

		   <div class="back_next_button">
			<ul>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="11">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>


 <?php

//pr($tab_number);die;

if(in_array(12, $current_steps) && $tab_number == 12){

	//pr($post_checkup_question);

	if(!empty($user_detail_old->chief_compliant_userdetail->pre_op_medications_question_detail))

		$old_pre_op_medications_question_detail = $user_detail_old->chief_compliant_userdetail->pre_op_medications_question_detail ;



		$ic = 1;
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_12')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==12  || 12==$current_steps[0])  ? '  show active ' : '' ?>" id="pre_op_medications" role="tabpanel" aria-labelledby="pre_op_medications-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">

			   <h3>
			   	<?php echo $step_id == 15 ? "Hospital/ER Follow Up Details" : "Medications" ; ?>
			   	<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						if(!empty($pre_op_medications_question)){
							foreach ($pre_op_medications_question as $key => $value) {

								$old_dqid_val = !empty($old_pre_op_medications_question_detail[$value->id]['answer']) ? $old_pre_op_medications_question_detail[$value->id]['answer'] : '';
								//pr($old_dqid_val);
								switch ($value->question_type) {
										    case 0:
										 ?>


									<div class="col-md-12 <?php echo $value->id == 29 ? 'pre_op_medications_question_28_29 display_none_at_load_time': ''; ?> <?php echo $value->id == 34 ? 'pre_op_medications_question_33_34 display_none_at_load_time': ''; ?> <?php echo $value->id == 52 ? "pre_op_medications_question_51_52 display_none_at_load_time": ""; ?> <?php echo $value->id == 57 ? "pre_op_medications_question_56_57 display_none_at_load_time": ""; ?> <?php echo $value->id == 59 ? "pre_op_medications_question_58_59 display_none_at_load_time": ""; ?>">
					 					<div class="form-group form_fild_row">
					 						<?php if(!empty($value->question)){ ?><?= $value->question ?>&nbsp; <span class="required">*</span> <?php } ?>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="pre_op_medications_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'pre_op_medications_question'.$value->id; ?>"/>

					 					</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= $value->question ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>

        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 27 ? "pre_op_medications_question_27" : ""; ?> <?php echo $value->id == 32 ? "pre_op_medications_question_32" : ""; ?> <?php echo $value->id == 51 ? "pre_op_medications_question_51" : ""; ?> <?php echo $value->id == 56 ? "pre_op_medications_question_56" : ""; ?> <?php echo $value->id == 58 ? "pre_op_medications_question_58" : ""; ?>" id="radio_question<?= $i ?>" name="pre_op_medications_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div>


								<?php
									break;
									case 3:
							 	?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<label><?= $value->question ?>

											<?php $options = unserialize($value->options);?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control question_<?= $value->id ?>" name="pre_op_medications_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:

							?>
									<div class="col-md-12 <?php echo $value->id == 28 ? "pre_op_medications_question_27_28 display_none_at_load_time": ""; ?> <?php echo $value->id == 33 ? "pre_op_medications_question_32_33 display_none_at_load_time": ""; ?>">
										<div class="form-group form_fild_row <?php echo ($value->id == 28 || $value->id == 33) ? "new_appoint_checkbox_quest_a" : ""; ?>">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="<?php echo ($value->id == 28 || $value->id == 33) ? "new_appoint_checkbox_quest" : ""; ?>">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
													// for 19 and 23 option if user select last option then other option should unchecked
											?>
											<?php

											// }
 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo $value->id == 28 ? "pre_op_medications_question_28": ""; ?> <?php echo $value->id == 33 ? "pre_op_medications_question_33": ""; ?>"  name="pre_op_medications_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required" >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>
			   </div>


			<?php
				//current medication not show for hospital/ER followup module (step_id = 15)
			if($step_id != 15){ ?>
			 <!--  <div class="tab_form_fild_bg"> -->
			    <div class="TitleHead header-sticky-tit">
				 <h3>Current medication</h3>
				</div>
			<!-- </div> -->

			<div class="tab_form_fild_bg">

				<!-- fill the old data when edited start ******************************************************  -->
				<?php
				if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail)){
					$cmd_old = $user_detail_old->chief_compliant_userdetail->compliant_medication_detail;

					foreach ($cmd_old as $ky => $ve) {

				?>

					<div class="row  currentmedicationfld">
	   					<div class="col-md-4">
		 					<div class="form-group form_fild_row">
								<div class="custom-drop">
									<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
	      							<ul class="med_suggestion_listul custom-drop-li">
									</ul>
								</div>
	     					</div>
						</div>

						<div class="col-md-2">
				 			<div class="form-group form_fild_row">
				  				<input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
				 			</div>
						</div>

						<div class="col-md-2">
				 			<div class="form-group form_fild_row">

								<select class="form-control" name="medication_how_often[]">
									<option value="">how often?</option>
									<?php
											foreach ($length_arr as $key => $value) {

										echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

											}
										?>
								</select>
				 			</div>
						</div>
			    		<div class="col-md-3">
				 			<div class="form-group form_fild_row">
				 				<div class="custom-drop">
									<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
	      							<ul class="how_taken_suggestion_listul custom-drop-li">
									</ul>
								</div>
				 			</div>
						</div>
						<div class="col-md-1">
					     <div class="row">

						  <div class=" currentmedicationfldtimes">
						   <div class="crose_year">
						    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
						   </div>
						  </div>
						 </div>
						</div>
	   				</div>
				<?php
				}
				}

				?>
	   			<div class="row currentmedicationfld">

	   			</div>
				<div class="row">
				    <div class="col-md-6">
					 <div class="form-group form_fild_row">

					   <div class="crose_year">
					    <button  type="button"  class="btn currentmedicationfldadd">add a medication</button>
					   </div>


					 </div>
					</div>
				</div>

	   	<?php } ?>

		   <div class="back_next_button">
			<ul>
				<?php if($step_id == 15){ ?>

					 <li style="float: left;">
						<button id="profile-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
					</li>

				<?php }else{  ?>
				 <li style="float: left;">
					<button id="procedure_detail-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				</li>
				<?php } ?>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="12">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>


  <?php

//pr($tab_number);die;

if(in_array(13, $current_steps) && $tab_number == 13){


	if(!empty($user_detail_old->chief_compliant_userdetail->pre_op_allergies_detail))

		$old_pre_op_ac = $user_detail_old->chief_compliant_userdetail->pre_op_allergies_detail ;

		$ic = 1;

     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_13')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==13  || 13==$current_steps[0])  ? '  show active ' : '' ?>" id="pre_op_allergies" role="tabpanel" aria-labelledby="pre_op_allergies-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>Are you allergic to any of the following?<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">

				<?php if(!empty($common_allergies_cond)){
						$i =1;
					foreach ($common_allergies_cond as $a_cond_key => $alleries_conditions) { ?>

							<div class="row">
								<div class="col-md-4">
									<h4><?= ucfirst($alleries_conditions->name) ?></h4>
								</div>
								<div class="col-md-3">

									<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-primary alleries_conditions_name  <?= !empty($old_pre_op_ac[$alleries_conditions->id]) && $old_pre_op_ac[$alleries_conditions->id]['name'] == 0 ? 'active' : '' ?> "  for="alleries_conditions<?= $i ?>"  data-id ="<?php echo $alleries_conditions->id; ?>">
									         <input type="radio"  value="0" <?= !empty($old_pre_op_ac[$alleries_conditions->id]) && $old_pre_op_ac[$alleries_conditions->id]['name'] == 0 ? 'checked' : '' ?>  class="form-check-input " id="alleries_conditions<?= $i++ ?>" name="alleries_conditions[<?= $alleries_conditions->id ?>][name]" required="true" >
									         No</label>

									<label class="btn btn-primary alleries_conditions_name   <?= !empty($old_pre_op_ac[$alleries_conditions->id]) && $old_pre_op_ac[$alleries_conditions->id]['name'] == 1 ? 'active' : '' ?> "  for="alleries_conditions<?= $i ?>"  data-id ="<?php echo $alleries_conditions->id; ?>">
									         <input type="radio"  value="1"  <?= !empty($old_pre_op_ac[$alleries_conditions->id]) && $old_pre_op_ac[$alleries_conditions->id]['name'] == 1 ? 'checked' : '' ?>  class="form-check-input" id="alleries_conditions<?= $i++ ?>" name="alleries_conditions[<?= $alleries_conditions->id ?>][name]" required="true">
									        Yes</label>
									       </div>
       							</div>

       							<div class="col-md-5 blk-one-line alleries_conditions_reaction alleries_conditions_reaction<?php echo $alleries_conditions->id; ?> <?= !empty($old_pre_op_ac[$alleries_conditions->id]) && $old_pre_op_ac[$alleries_conditions->id]['name'] == 1 ? '' : 'display_none_at_load_time' ?>">
       								<label>Reaction</label>
       								<div class="form-group form_fild_row">

       									<input type="text" class="form-control" name="alleries_conditions[<?= $alleries_conditions->id ?>][reaction]" required = "true" value="<?= !empty($old_pre_op_ac[$alleries_conditions->id]) && !empty($old_pre_op_ac[$alleries_conditions->id]['reaction']) ? $old_pre_op_ac[$alleries_conditions->id]['reaction'] : '' ?>">
       								</div>
       							</div>

							</div>
				<?php	}

				} ?>

		   <div class="back_next_button">
			<ul>
			<li style="float: left;">
				<button id="pre_op_medications-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
			</li>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="13">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>


 <?php

//pr($tab_number);die;

if(in_array(14, $current_steps) && $tab_number == 14){

	//pr($common_diseases);die;
	if(!empty($user_detail_old->chief_compliant_userdetail->disease_name))

		$old_disease_name = $user_detail_old->chief_compliant_userdetail->disease_name ;
	//pr($old_disease_name);

     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_14')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==14  || 14==$current_steps[0])  ? '  show active ' : '' ?>" id="disease" role="tabpanel" aria-labelledby="disease-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>Select disease any of following?<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">

				<?php if(!empty($common_diseases)){
						$i =1;
					foreach ($common_diseases as $key => $value) { ?>

							<div class="check_box_bg">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input"  name="disease_name[]"  id="checkbox<?= $key ?>" value="<?= $key ?>" fixval="<?= $value ?>" type="checkbox" required="required" <?php echo (!empty($old_disease_name) && in_array($key, $old_disease_name)) ? "checked" : ""; ?> >
									<label class="custom-control-label" for="checkbox<?= $key ?>"><?= $value ?></label>
								</div>
							</div>
				<?php	}

				} ?>

		   <div class="back_next_button">
			<ul>

			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php //if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>"> -->
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="14">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>


<?php }
 ?>

<?php

if(in_array(15, $current_steps) && $tab_number == 15 ){

	if(!empty($user_detail_old->chief_compliant_userdetail->disease_questions_detail))
		$old_disease_questions_detail = $user_detail_old->chief_compliant_userdetail->disease_questions_detail ;

	//pr($old_disease_questions_detail);die;

	$ic = 1;
	$disease_name = isset($cur_disease_data->name) ? $cur_disease_data->name : '';
    echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_15')); ?>
	<div class="tab-pane fade  <?= ($tab_number==15  || 15==$current_steps[0])  ? '  show active ' : '' ?>" id="disease_detail" role="tabpanel" aria-labelledby="disease_detail-tab">
		<div class="errorHolder">
  		</div>
		<div class="TitleHead header-sticky-tit">

		   <h3>Disease Details for <?php echo '<b>['.$disease_name.']</b>';  ?></h3>
		   <div class="seprator"></div>
	    </div>

		<div class="tab_form_fild_bg">
			<div class="row">

			<?php   $i = 0 ;
					$cb_class = '';

					if(!empty($disease_detail_question_id)){
						foreach ($disease_detail_question_id as $key => $value) {				$old_dqid_val = '';
						$old_dqid_val = !empty($old_disease_questions_detail[$cur_disease_data->id]['disease_detail_question'][$value->id]['answer']) ? $old_disease_questions_detail[$cur_disease_data->id]['disease_detail_question'][$value->id]['answer'] : '';
							switch ($value->question_type) {
										    case 0:
										 ?>


					<div class="col-md-12 <?php echo $value->id == 36 ? 'display_none_at_load_time disease_detail_question_35_36' : ''; ?> <?php echo $value->id == 38 ? 'display_none_at_load_time disease_detail_question_37_38' : ''; ?> <?php echo $value->id == 40 ? 'display_none_at_load_time disease_detail_question_39_40' : ''; ?> <?php echo $value->id == 42 ? 'display_none_at_load_time disease_detail_question_41_42' : ''; ?>">
					 <div class="form-group form_fild_row">
					 	<?= str_replace('****', $disease_name, $value->question); ?>&nbsp;<span class="required">*</span>

						<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="disease_detail_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'disease_detail_question_'.$value->id; ?>"/>

					  <?php
					  // quick pick in case of orthopedic module questions id 4 and 5

					   if($apt_id_data->specialization_id == 3 ) {
					   	if($value->id == 4){
					   		?>

							<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
			                <ul>

								<li class="active"><button type="button" class="btn" attr_val="icing" data-que ="<?php echo $value->id; ?>" ><i class="fas fa-plus-circle"></i><span>Icing</span></button> </li>

								<li class="active"><button type="button" class="btn" attr_val="rest" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Rest</span></button> </li>

								<li class="active"><button type="button" class="btn" attr_val="shaking" data-que ="<?php echo $value->id; ?>"><i class="fas fa-plus-circle"></i><span>Shaking</span></button> </li>
			                </ul>
               			</div>
					<?php }
							}
						?>
					 </div>
					</div>

			<?php
					break;

					case 1:

				?>
				<div class="col-md-12  <?php echo  $value->id == 14  ? 'display_none_at_load_time question_13_14' : ''; ?>">
				 	<div class="form-group form_fild_row">

 						<div class="radio_bg">
          					<label>
          						<?= str_replace('****', $disease_name , $value->question);  ?>
	          					&nbsp;<span class="required">*</span>
	          				</label>

							<div class="radio_list">
								<?php
								$options = unserialize($value->options) ;

								foreach ($options as $k => $v) {

								?>

	       							<div class="form-check">
	         							<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 35? 'disease_detail_question_35':''; ?> <?php echo $value->id == 37? 'disease_detail_question_37':''; ?> <?php echo $value->id == 39? 'disease_detail_question_39':''; ?> <?php echo $value->id == 41? 'disease_detail_question_41':''; ?> <?php echo $value->id == 43? 'disease_detail_question_43':''; ?>" id="radio_question<?= $i ?>" name="disease_detail_question[<?= $value->id ?>]"  required="true">
	         							<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
	       							</div>
									<?php
									$i++ ;
								}
								?>
							</div>
    					</div>
				 	</div>
				</div>
		<?php if($value->id == 43){

			/*if(!empty($user_detail_old->chief_compliant_userdetail->chronic_illnesses_multivitamin_detail)){

				$old_multivitamin_data = $user_detail_old->chief_compliant_userdetail->chronic_illnesses_multivitamin_detail;

				//pr($old_multivitamin_data);
			}*/

			if(isset($old_disease_questions_detail[$cur_disease_data->id]['multivitamin_detail']) && !empty($old_disease_questions_detail[$cur_disease_data->id]['multivitamin_detail'])){

				$old_multivitamin_data = $old_disease_questions_detail[$cur_disease_data->id]['multivitamin_detail'];

			}
			?>
			<div class="display_none_at_load_time multivitamin_detail_section">
				<div class="row ">
				    <div class="col-md-5">
					 	<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text"    class="form-control " name="multivitamin[name]" required="true"  value="<?php echo (isset($old_multivitamin_data) && isset($old_multivitamin_data['name'])) ? $old_multivitamin_data['name'] : ""; ?>" id="multivitamin_textbox"/>
				      			<ul class="med_suggestion_listul custom-drop-li">
								</ul>
							</div>
				     	</div>
					</div>

					<div class="col-md-2">
						<div class="form-group form_fild_row">
							<input name="multivitamin[dose]" type="text" class="form-control" placeholder="Dose" required="true" value="<?php echo (isset($old_multivitamin_data) && isset($old_multivitamin_data['dose'])) ? $old_multivitamin_data['dose'] : ""; ?>"/>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group form_fild_row">
							<select class="form-control" name="multivitamin[how_often]" required="true">
								<option value="">how often?</option>
								<?php
									foreach ($length_arr as $key => $value) {

										echo "<option ".(isset($old_multivitamin_data['how_often']) && $old_multivitamin_data['how_often'] == $key ? 'selected': '')." value=".$key.">".$value."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text" name="multivitamin[how_taken]" class="form-control how_taken_suggestion" placeholder="How is it taken?" required="true" value="<?php echo (isset($old_multivitamin_data) && isset($old_multivitamin_data['how_taken'])) ? $old_multivitamin_data['how_taken'] : ""; ?>" />
				      			<ul class="how_taken_suggestion_listul custom-drop-li">
								</ul>
							</div>
						</div>
					</div>


				</div>
				<div class="common_conditions_button quickpicks_question_4 detail_ques_cls" style="border: none; padding-top: 10px;">
		            <ul>

						<li class="active"><button type="button" class="btn" attr_val="multivitamin" data-que ="" ><i class="fas fa-plus-circle"></i><span>multivitamin</span></button> </li>

						<li class="active"><button type="button" class="btn" attr_val="iron" data-que =""><i class="fas fa-plus-circle"></i><span>iron</span></button> </li>

						<li class="active"><button type="button" class="btn" attr_val="vitamin b12" data-que =""><i class="fas fa-plus-circle"></i><span>vitamin b12</span></button> </li>
		            </ul>
	               </div>
	            </div>
		<?php } ?>

	    <?php
	        break;

	    	case 3:
	    ?>

		<div class="col-md-12">
			<div class="form-group form_fild_row">

				<!-- this block for select list -->

					 </div>
					</div>

		<?php
		        break;
		       case 2:
		?>

					<div class="col-md-12">
					 <div class="form-group form_fild_row">
					 	<!-- this block for checkbox -->
				</div>
			</div>

			<?php
			break;

			case 4:
			?>
		<div class="col-md-12">
			<div class="form-group form_fild_row">
				<!-- this block for image diagram -->

			</div>
		</div>
		 <?php break;

			}
		}
	}

?>
</div>

<?php if(isset($cur_disease_data->id) && $cur_disease_data->id == 1){ ?>

	<div class="TitleHead header-sticky-tit">
	 	<h3>Current medication </h3>
	</div>

	<!-- fill the old data when edited start ******************************************************  -->
	<?php
		if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail))
		{

			$cmd_old = $user_detail_old->chief_compliant_userdetail->compliant_medication_detail;

			foreach ($cmd_old as $ky => $ve) {

	?>
				<div class="row  currentmedicationfld">
	    			<div class="col-md-4">
		 				<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
	      						<ul class="med_suggestion_listul custom-drop-li">
								</ul>
							</div>
	     				</div>
					</div>

					<div class="col-md-2">
						<div class="form-group form_fild_row">
				  			<input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
				 		</div>
					</div>

					<div class="col-md-2">
				 		<div class="form-group form_fild_row">

							<select class="form-control" name="medication_how_often[]">
								<option value="">how often?</option>
								<?php
									foreach ($length_arr as $key => $value) {

										echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";
									}
								?>
							</select>
				 		</div>
					</div>

			    	<div class="col-md-3">
				 		<div class="form-group form_fild_row">
							<div class="custom-drop">
								<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
	      						<ul class="how_taken_suggestion_listul custom-drop-li">
								</ul>
							</div>
				 		</div>
					</div>


				<div class="col-md-1">
	     			<div class="row">
		  				<div class=" currentmedicationfldtimes">
		   					<div class="crose_year">
		    					<button  type="button"  class="btn btn-icon-round">
		    						<i class="fas fa-times"></i>
		    					</button>
		   					</div>
		  				</div>
		 			</div>
				</div>
	   		</div>
	<?php
			}
		}
	?>

	<div class="row currentmedicationfld">
	</div>
	<div class="row">
	    <div class="col-md-6">
		 	<div class="form-group form_fild_row">
		   		<div class="crose_year">
		    		<button  type="button"  class="btn currentmedicationfldadd">add a medication</button>
		   		</div>
			</div>
		</div>
	</div>

	<?php

		if(isset($old_disease_questions_detail[$cur_disease_data->id]['smoking_detail']) && !empty($old_disease_questions_detail[$cur_disease_data->id]['smoking_detail'])){

			$old_smoking_detail = $old_disease_questions_detail[$cur_disease_data->id]['smoking_detail'];

		}
	?>



	<div class="TitleHead header-sticky-tit">
	   <h3>Tobacco Use</h3>
	   <div class="seprator"></div>
	</div>

	<div class="tab_form_fild_bg">

		<div class="row ">
			<div class="col-md-4">
				<div class="form-group form_fild_row">
			        <label>Do you currently smoke?</label>
			        <span class="required_star">*</span>
				 	<div class="radio_list">
				   		<div class="form-check">
				    		<input type="radio"  data-error="#errNm3" <?php echo (isset($old_smoking_detail['current']['currentlysmoking']) && $old_smoking_detail['current']['currentlysmoking'] == 1) ? 'checked' : '' ?>  value="1"  class="form-check-input currentlysmoking" name="smoking[current][currentlysmoking]"  id="currentlysmoking1" >
				    		<label class="form-check-label" for="currentlysmoking1">Yes</label>
				   		</div>

					   <div class="form-check">
					    <input type="radio"  data-error="#errNm3" <?php echo (isset($old_smoking_detail['current']['currentlysmoking']) && $old_smoking_detail['current']['currentlysmoking'] == 0) ? 'checked' : '' ?> value="0"  class="form-check-input currentlysmoking" name="smoking[current][currentlysmoking]"  id="currentlysmoking2"  >
					    <label class="form-check-label" for="currentlysmoking2">No</label>
					  </div>
			     	</div>
		          	<div class="errorTxt">
		            	<span id="errNm3"></span>
		          	</div>
				</div>
			</div>

			<div class="col-md-4  currentlysmokingdiv <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['current']['currentlysmoking']) && $old_smoking_detail['current']['currentlysmoking'] == 0)) ? 'elem_display_none' : '' ?>">
			    <div class="form-group form_fild_row">
		         	<label>How many packs? (per week)</label>

					<select class="form-control" name="smoking[current][current_smoke_pack]"  <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['current']['currentlysmoking']) && $old_smoking_detail['current']['currentlysmoking'] == 0)) ? 'disabled' : '' ?> >
			        	<option value=""></option>
			        	<?php
			        		$cnt = 1;

				        	for($cnt ; $cnt<= 10 ; $cnt++){
				        		echo "<option ".(isset($old_smoking_detail['current']['current_smoke_pack']) && $old_smoking_detail['current']['current_smoke_pack'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
				        	}
			        	?>
			        	<option <?php echo isset($old_smoking_detail['current']['current_smoke_pack']) && $old_smoking_detail['current']['current_smoke_pack'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10">More than 10 packs</option>
				    </select>
				</div>
			</div>

			<!-- <div class="col-md-4 currentlysmokingdiv <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['current']['currentlysmoking']) && $old_smoking_detail['current']['currentlysmoking'] == 0)) ? 'elem_display_none' : '' ?>">
				<div class="form-group form_fild_row">
				    <label>How many years?</label>

				    <select class="form-control" name="smoking[current][current_smoke_year]"   <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['current']['currentlysmoking']) && $old_smoking_detail['current']['currentlysmoking'] == 0)) ? 'disabled' : '' ?> >
				        <option value=""></option>
				        	<?php
				        		$cnt = 1;

					        	for($cnt ; $cnt<= 10 ; $cnt++){
					        		echo "<option ".(isset($old_smoking_detail['current']['current_smoke_year']) && $old_smoking_detail['current']['current_smoke_year'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
					        	}
				        	?>
				        <option <?php echo isset($old_smoking_detail['current']['current_smoke_year']) && $old_smoking_detail['current']['current_smoke_year'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10">More than 10 years</option>
					</select>
				</div>
			</div> -->
	   </div>


	<div class="row">
		<div class="col-md-4">
			<div class="form-group form_fild_row">
           		<label>Did you smoke in the past?</label>
           		<span class="required_star">*</span>
		 		<div class="radio_list">
		   			<div class="form-check">
		    			<input type="radio"  data-error="#errNm4" <?php echo (isset($old_smoking_detail['past']['pastsmoking']) && $old_smoking_detail['past']['pastsmoking'] == 1) ? 'checked' : '' ?> value="1"  class="form-check-input pastsmoking" name="smoking[past][pastsmoking]"  id="pastsmoking1" >
		    			<label class="form-check-label" for="pastsmoking1">Yes</label>
		   			</div>

				   <div class="form-check">
				    <input type="radio"  data-error="#errNm4" <?php echo (isset($old_smoking_detail['past']['pastsmoking']) && $old_smoking_detail['past']['pastsmoking'] == 0) ? 'checked' : '' ?> value="0"  class="form-check-input pastsmoking" name="smoking[past][pastsmoking]"  id="pastsmoking2"  >
				    <label class="form-check-label" for="pastsmoking2">No</label>
				  </div>
	     		</div>
	           <div class="errorTxt">
	            	<span id="errNm4"></span>
	           </div>
			</div>
		</div>

	    <div class="col-md-4 pastsmokingdiv <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['past']['pastsmoking']) && $old_smoking_detail['past']['pastsmoking'] == 0)) ? 'elem_display_none' : '' ?>">
         	<div class="form-group form_fild_row">
         		<label>How many packs? (per week)</label>

				<select class="form-control" name="smoking[past][past_smoke_pack]" <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['past']['pastsmoking']) && $old_smoking_detail['past']['pastsmoking'] == 0)) ? 'disabled' : '' ?> >
	        		<option value=""></option>
	        		<?php
	        			$cnt = 1;

			        	for($cnt ; $cnt<= 10 ; $cnt++){
			        		echo "<option ".(isset($old_smoking_detail['past']['past_smoke_pack']) && $old_smoking_detail['past']['past_smoke_pack'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
			        	}
	        		?>
	        		<option <?php echo isset($old_smoking_detail['past']['past_smoke_pack']) && $old_smoking_detail['past']['past_smoke_pack'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10">More than 10 packs</option>
		    	</select>
	     	</div>
		</div>

		<div class="col-md-4  pastsmokingdiv <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['past']['pastsmoking']) && $old_smoking_detail['past']['pastsmoking'] == 0)) ? 'elem_display_none' : '' ?>">
			<div class="form-group form_fild_row">
	      		<label>How many years?</label>


				<select class="form-control" name="smoking[past][past_smoke_year]" <?php echo (!isset($old_smoking_detail) || (isset($old_smoking_detail['past']['pastsmoking']) && $old_smoking_detail['past']['pastsmoking'] == 0)) ? 'disabled' : '' ?> >
	        		<option value=""></option>
	        		<?php
	        			$cnt = 1;

			        	for($cnt ; $cnt<= 10 ; $cnt++){
			        		echo "<option ".(isset($old_smoking_detail['past']['past_smoke_year']) && $old_smoking_detail['past']['past_smoke_year'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
			        	}
	        		?>
	        		<option  <?php echo isset($old_smoking_detail['past']['past_smoke_year']) && $old_smoking_detail['past']['past_smoke_year'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10" >More than 10 years</option>
		    	</select>

	     </div>
		</div>
	   </div>
	</div>

<?php

	if(isset($old_disease_questions_detail[$cur_disease_data->id]['alcohol_detail']) && !empty($old_disease_questions_detail[$cur_disease_data->id]['alcohol_detail'])){

		$old_alcohol_detail = $old_disease_questions_detail[$cur_disease_data->id]['alcohol_detail'];

	}
 ?>
	<div class="TitleHead header-sticky-tit">
	   <h3>Alcohol Use</h3>
	   <div class="seprator"></div>
	</div>
	<div class="tab_form_fild_bg">
		<div class="row">
			<div class="col-md-4">
				<div class="check_box_bg">
					<div class="form-group form_fild_row">
           				<label>Do you currently drink alcohol?</label>
           				<span class="required_star">*</span>
	 					<div class="radio_list">
	   						<div class="form-check">
	    						<input type="radio"  data-error="#errNm5" <?php echo (isset($old_alcohol_detail['current']['currentlydrinking']) && $old_alcohol_detail['current']['currentlydrinking'] == 1) ? 'checked' : '' ?> value="1"  class="form-check-input currentlydrinking" name="alcohol[current][currentlydrinking]"  id="currentlydrinking1" >
	    						<label class="form-check-label" for="currentlydrinking1">Yes</label>
	   						</div>

	  						<div class="form-check">
	    						<input type="radio"  data-error="#errNm5" <?php echo (isset($old_alcohol_detail['current']['currentlydrinking']) && $old_alcohol_detail['current']['currentlydrinking'] == 0) ? 'checked' : '' ?> value="0"  class="form-check-input currentlydrinking" name="alcohol[current][currentlydrinking]"  id="currentlydrinking2"  >
	    						<label class="form-check-label" for="currentlydrinking2">No</label>
	  						</div>
     					</div>
					</div>
		 		</div>
	          	<div class="errorTxt">
	            	<span id="errNm5"></span>
	          	</div>
			</div>


	    	<div class="col-md-4  currentlydrinkingdiv <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['current']['currentlydrinking']) && $old_alcohol_detail['current']['currentlydrinking'] == 0)) ? 'elem_display_none' : '' ?>">
         		<div class="form-group form_fild_row">
        			<label>How many drinks? (per week)</label>


					<select class="form-control" name="alcohol[current][current_drink_pack]"  <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['current']['currentlydrinking']) && $old_alcohol_detail['current']['currentlydrinking'] == 0)) ? 'disabled' : '' ?> >
	        			<option value=""></option>
	        			<?php
	        				$cnt = 1;
				        	for($cnt ; $cnt<= 14 ; $cnt++){
				        		echo "<option ".(isset($old_alcohol_detail['current']['current_drink_pack']) && $old_alcohol_detail['current']['current_drink_pack'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
				        	}
	        			?>
	        			<option <?php echo isset($old_alcohol_detail['current']['current_drink_pack']) && $old_alcohol_detail['current']['current_drink_pack'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10">More than 14 drinks</option>
		    		</select>
	     		</div>
			</div>

			<!-- <div class="col-md-4  currentlydrinkingdiv <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['current']['currentlydrinking']) && $old_alcohol_detail['current']['currentlydrinking'] == 0)) ? 'elem_display_none' : '' ?>">
	     		<div class="form-group form_fild_row">
	    			<label>How many years?</label>

					<select class="form-control" name="alcohol[current][current_drink_year]"  <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['current']['currentlydrinking']) && $old_alcohol_detail['current']['currentlydrinking'] == 0)) ? 'disabled' : '' ?> >
	        			<option value=""></option>
	        			<?php
	        				$cnt = 1;

				        	for($cnt ; $cnt<= 10 ; $cnt++){
				        		echo "<option ".(isset($old_alcohol_detail['current']['current_drink_year']) && $old_alcohol_detail['current']['current_drink_year'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
				        	}
	        			?>
	        			<option <?php echo isset($old_alcohol_detail['current']['current_drink_year']) && $old_alcohol_detail['current']['current_drink_year'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10">More than 10 years</option>
		    		</select>
	     		</div>
			</div> -->
	   </div>

	   <div class="row ">
			<div class="col-md-4">
				<div class="form-group form_fild_row">
           			<label>Did you drink alcohol in the past?</label>
           			<span class="required_star">*</span>
		 			<div class="radio_list">
		   				<div class="form-check">
		    				<input type="radio"  data-error="#errNm6" <?php echo (isset($old_alcohol_detail['past']['pastdrinking']) && $old_alcohol_detail['past']['pastdrinking'] == 1) ? 'checked' : '' ?> value="1"  class="form-check-input pastdrinking" name="alcohol[past][pastdrinking]"  id="pastdrinking1" >
		    				<label class="form-check-label" for="pastdrinking1">Yes</label>
		   				</div>

		   				<div class="form-check">
		    				<input type="radio"  data-error="#errNm6" <?php echo (isset($old_alcohol_detail['past']['pastdrinking']) && $old_alcohol_detail['past']['pastdrinking'] == 0) ? 'checked' : '' ?> value="0"  class="form-check-input pastdrinking" name="alcohol[past][pastdrinking]"  id="pastdrinking2"  >
		    				<label class="form-check-label" for="pastdrinking2">No</label>
		  				</div>
	     			</div>
		          	<div class="errorTxt">
		            	<span id="errNm6"></span>
		          	</div>
				</div>
			</div>

	   		<div class="col-md-4  pastdrinkingdiv <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['past']['pastdrinking']) && $old_alcohol_detail['past']['pastdrinking'] == 0)) ? 'elem_display_none' : '' ?>">
         		<div class="form-group form_fild_row">
        			<label>How many drinks? (per week)</label>
					<select class="form-control" name="alcohol[past][past_drink_pack]" <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['past']['pastdrinking']) && $old_alcohol_detail['past']['pastdrinking'] == 0)) ? 'disabled' : '' ?> >
	        			<option value=""></option>
	        			<?php
	        				$cnt = 1;

				        	for($cnt ; $cnt<= 14 ; $cnt++){
				        		echo "<option ".(isset($old_alcohol_detail['past']['past_drink_pack']) && $old_alcohol_detail['past']['past_drink_pack'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
				        	}
	        			?>
	        			<option <?php echo isset($old_alcohol_detail['past']['past_drink_pack']) && $old_alcohol_detail['past']['past_drink_pack'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10">More than 14 drinks</option>
		    		</select>
	     		</div>
			</div>

			<div class="col-md-4  pastdrinkingdiv <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['past']['pastdrinking']) && $old_alcohol_detail['past']['pastdrinking'] == 0)) ? 'elem_display_none' : '' ?>">
	     		<div class="form-group form_fild_row">
	     			<label>How many years?</label>
					<select class="form-control" name="alcohol[past][past_drink_year]" <?php echo (!isset($old_alcohol_detail) || (isset($old_alcohol_detail['past']['pastdrinking']) && $old_alcohol_detail['past']['pastdrinking'] == 0)) ? 'disabled' : '' ?> >
	        			<option value=""></option>
	        			<?php
	        				$cnt = 1;

				        	for($cnt ; $cnt<= 10 ; $cnt++){
				        		echo "<option ".(isset($old_alcohol_detail['past']['past_drink_year']) && $old_alcohol_detail['past']['past_drink_year'] ==$cnt? 'selected' : '')." value=".$cnt.">".$cnt."</option>";
				        	}
	        			?>
	        			<option <?php echo isset($old_alcohol_detail['past']['past_drink_year']) && $old_alcohol_detail['past']['past_drink_year'] == 'morethan10' ? 'selected' : ''; ?> value="morethan10">More than 10 years</option>
		    		</select>
	     		</div>
			</div>
	   </div>
	</div>

<?php } ?>

<?php if(!empty($base_line_symptoms)){

	$old_base_line_sysmptoms = isset($old_disease_questions_detail[$cur_disease_data->id]['baseline_sysmptom']) ? $old_disease_questions_detail[$cur_disease_data->id]['baseline_sysmptom'] : null;

	?>
<div class="TitleHead header-sticky-tit">
   <h3>Base Line Symptoms<br></h3>
   <div class="seprator"></div>
</div>

	<?php $i=1; foreach($base_line_symptoms as $key => $bsline_syptm){ ?>

		<div class="row">
			<div class="col-md-4">
				<h4><?= ucfirst($bsline_syptm->symptom) ?></h4>
			</div>
			<div class="col-md-3">

				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-primary baseline_sysmptom_name <?= !empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['answer'] == 0 ? 'active' : '' ?>"  for="baseline_sysmptom<?= $i ?>"  data-id ="<?php echo $bsline_syptm->id; ?>">
					         <input type="radio"  value="0" class="form-check-input " id="baseline_sysmptom<?= $i++ ?>" name="baseline_sysmptom[<?= $bsline_syptm->id ?>][answer]" required="true" <?= !empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['answer'] == 0 ? 'checked' : '' ?> >
					         No</label>

					<label class="btn btn-primary baseline_sysmptom_name <?= !empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['answer'] == 1 ? 'active' : '' ?>"  for="baseline_sysmptom<?= $i ?>"  data-id ="<?php echo $bsline_syptm->id; ?>">
				         <input type="radio"  value="1" class="form-check-input" id="baseline_sysmptom<?= $i++ ?>" name="baseline_sysmptom[<?= $bsline_syptm->id ?>][answer]" required="true" <?= !empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['answer'] == 1 ? 'checked' : '' ?> >
				        Yes</label>
				</div>
			</div>

			<div class="col-md-5 blk-one-line baseline_sysmptom_result_<?php echo $bsline_syptm->id; ?> <?= !empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['answer'] == 1 ? '' : 'display_none_at_load_time' ?>">
       			<label>Is it better, worse, or about the same since your last visit?</label>
				<div class="form-group form_fild_row">
					<select class="form-control" required name="baseline_sysmptom[<?= $bsline_syptm->id ?>][scale]">
			        	<option value=""></option>
			     		<option  value="better" <?= (!empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['scale'] == 'better') ? ' selected ' : '' ?> >Better</option>
			     		<option  value="worse" <?= (!empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['scale'] == 'worse') ? ' selected ' : '' ?> >Worse</option>
			     		<option  value="about the same" <?= (!empty($old_base_line_sysmptoms[$bsline_syptm->id]) && $old_base_line_sysmptoms[$bsline_syptm->id]['scale'] == 'about the same') ? ' selected ' : '' ?> >About the same</option>
			    	</select>
				</div>
       		</div>
		</div>
	<?php } ?>

<?php } ?>

<?php if(!empty($alarm_symptoms)){

	$old_alarm_sysmptoms = isset($old_disease_questions_detail[$cur_disease_data->id]['alarm_sysmptom']) ? $old_disease_questions_detail[$cur_disease_data->id]['alarm_sysmptom'] : null;
	?>
<div class="TitleHead header-sticky-tit">
   <h3>Alarm Symptoms<br></h3>
   <div class="seprator"></div>
</div>

	<?php $i=1; foreach($alarm_symptoms as $key => $arm_syptm){ ?>

		<div class="row">
			<div class="col-md-4">
				<h4><?= ucfirst($arm_syptm->symptom) ?></h4>
			</div>
			<div class="col-md-3">

				<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-primary alarm_sysmptom_name <?= !empty($old_alarm_sysmptoms[$arm_syptm->id]) && $old_alarm_sysmptoms[$arm_syptm->id]['answer'] == 0 ? 'active' : '' ?>"  for="alarm_sysmptom<?= $i ?>"  data-id ="<?php echo $arm_syptm->id; ?>">
				         <input type="radio"  value="0" class="form-check-input " id="alarm_sysmptom<?= $i++ ?>" name="alarm_sysmptom[<?= $arm_syptm->id ?>][answer]" required="true" <?= !empty($old_alarm_sysmptoms[$arm_syptm->id]) && $old_alarm_sysmptoms[$arm_syptm->id]['answer'] == 0 ? 'checked' : '' ?> >
				         No</label>

				<label class="btn btn-primary alarm_sysmptom_name <?= !empty($old_alarm_sysmptoms[$arm_syptm->id]) && $old_alarm_sysmptoms[$arm_syptm->id]['answer'] == 1 ? 'active' : '' ?>"  for="alarm_sysmptom<?= $i ?>"  data-id ="<?php echo $arm_syptm->id; ?>">
				         <input type="radio"  value="1" class="form-check-input" id="alarm_sysmptom<?= $i++ ?>" name="alarm_sysmptom[<?= $arm_syptm->id ?>][answer]" required="true" <?= !empty($old_alarm_sysmptoms[$arm_syptm->id]) && $old_alarm_sysmptoms[$arm_syptm->id]['answer'] == 1 ? 'checked' : '' ?> >
				        Yes</label>
				       </div>
				</div>
		</div>
	<?php } ?>

<?php } ?>

			<div class="back_next_button">
				<ul>
					<li>

						<button id="disease-backbtn" type="button" class="btn nofillborder">Previous Tab</button>

				     </li>
					 <li style="float: right;margin-left: auto;">
					  <button type="submit" class="btn details_next">Next</button>
					 </li>
				</ul>
			   </div>

			 </div>
		</div>

	 <input type="hidden" name="cur_disease_detail_tab" value="<?php if(!empty($cur_disease_detail_tab)) echo $cur_disease_detail_tab ?>">

	<input type="hidden" name="next_steps" value="<?= $next_steps ?>">

	<input type="hidden" name="tab_number" value="15">
	<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
   <?php $this->Form->end() ;

}
   ?>

<?php

	if($tab_number == 16 || ( $tab_number <= 16 && 16 == $current_steps[0])){
		//var_dump($is_show_soapp_comm);die;
		$old_medication_refill_extra_details = '';
		if(!empty($user_detail_old->chief_compliant_userdetail->medication_refill_extra_details))
			$old_medication_refill_extra_details = $user_detail_old->chief_compliant_userdetail->medication_refill_extra_details ;

		$old_medication_refill_comm_soapp_details = '';
		if(!empty($user_detail_old->chief_compliant_userdetail->medication_refill_comm_soapp_details))
			$old_medication_refill_comm_soapp_details = $user_detail_old->chief_compliant_userdetail->medication_refill_comm_soapp_details ;
		//pr($old_medication_refill_extra_details);die;

		$i= 0;
     	  ?>

		  	<div class="tab-pane fade  <?= ($tab_number==16  || 16==$current_steps[0])  ? '  show active ' : '' ?>" id="mad_refill_drug" role="tabpanel" aria-labelledby="mad_refill_drug-tab">

				<div class="errorHolder">
  				</div>

			  	<div class="TitleHead">
			   		<!-- <h3>Have you had any of these symptoms in the past month?&nbsp;<span class="required">*</span></h3> -->
			   		<div class="seprator"></div>
			  	</div>

			  	<div class="tab_form_fild_bg question_symptom_newapp">
			  		<?php //echo $active_sub_tab; ?>
			   		<div class="row">
						<div class="col-md-12">
				 			<div class="form-group form_fild_row">
								<ul class="nav nav-tabs" id="myTab222" role="tablist">
									<?php if(isset($is_show_soapp_comm) && $is_show_soapp_comm == 1){ ?>
	  									<li class="nav-item">
	  										<?php
													echo $this->Form->postLink(
													    "post link", // first
													    null,  // second
													    ['data' => ['edited_sub_tab' => 'soapp','edited_tab' => 16], 'id' => 'soapp-tabpostlink'] // third
													);
	   											?>
	    									<a class="nav-link current_sub_tab <?php echo $active_sub_tab == 'soapp' ? 'active' : ''; ?>" id="soapp-tab" data-toggle="tab" href="#soapp" role="tab" aria-controls="soapp" aria-selected="false" data-tab = '16'soapp data-sub-tab='soapp'>SOAPP-R</a>
	  									</li>
	  									<li class="nav-item">

	  										<?php
													echo $this->Form->postLink(
													    "post link", // first
													    null,  // second
													    ['data' => ['edited_sub_tab' => 'comm','edited_tab' => 16], 'id' => 'comm-tabpostlink'] // third
													);
	   											?>
	    									<a class="nav-link <?php echo $active_sub_tab == 'comm' ? 'active' : ''; ?>" id="comm-tab" data-toggle="tab" href="#comm" role="tab" aria-controls="comm" aria-selected="false">COMM</a>
	  									</li>
  									<?php } ?>

  									<?php if(isset($check_is_show_soapp_comm_padt_dast['padt']) && $check_is_show_soapp_comm_padt_dast['padt'] == 1){ ?>

		  									<li class="nav-item">

		  										<?php
													echo $this->Form->postLink(
													    "post link", // first
													    null,  // second
													    ['data' => ['edited_sub_tab' => 'padt','edited_tab' => 16], 'id' => 'padt-tabpostlink'] // third
													);
	   											?>
		    									<a class="nav-link <?php echo $active_sub_tab == 'padt' ? 'active' : ''; ?>" id="padt-tab" data-toggle="tab" href="#padt" role="tab" aria-controls="padt" aria-selected="false">PADT</a>
		  									</li>
	  								<?php } ?>
	  								<?php if(isset($check_is_show_soapp_comm_padt_dast['ort']) && $step_id == 26 && $check_is_show_soapp_comm_padt_dast['ort'] == 1){ ?>

		  									<li class="nav-item">

		  										<?php
													echo $this->Form->postLink(
													    "post link", // first
													    null,  // second
													    ['data' => ['edited_sub_tab' => 'ort','edited_tab' => 16], 'id' => 'ort-tabpostlink'] // third
													);
	   											?>
		    									<a class="nav-link <?php echo $active_sub_tab == 'ort' ? 'active' : ''; ?>" id="ort-tab" data-toggle="tab" href="#ort" role="tab" aria-controls="ort" aria-selected="false">ORT</a>
		  									</li>
	  								<?php } ?>
	  								<?php if(isset($check_is_show_soapp_comm_padt_dast['m3']) && $step_id == 26 && $check_is_show_soapp_comm_padt_dast['m3'] == 1){ ?>

		  									<li class="nav-item">

		  										<?php
													echo $this->Form->postLink(
													    "post link", // first
													    null,  // second
													    ['data' => ['edited_sub_tab' => 'm3','edited_tab' => 16], 'id' => 'm3-tabpostlink'] // third
													);
	   											?>
		    									<a class="nav-link <?php echo $active_sub_tab == 'm3' ? 'active' : ''; ?>" id="m3-tab" data-toggle="tab" href="#m3" role="tab" aria-controls="m3" aria-selected="false">M3</a>
		  									</li>
	  								<?php } ?>

  									<?php if(isset($check_is_show_soapp_comm_padt_dast['dast']) && $check_is_show_soapp_comm_padt_dast['dast'] == 1){ ?>

		  									<li class="nav-item">
		  										<?php
													echo $this->Form->postLink(
													    "post link", // first
													    null,  // second
													    ['data' => ['edited_sub_tab' => 'dast','edited_tab' => 16], 'id' => 'dast-tabpostlink'] // third
													);
	   											?>
		    									<a class="nav-link <?php echo $active_sub_tab == 'dast' ? 'active' : ''; ?>" id="dast-tab" data-toggle="tab" href="#dast" role="tab" aria-controls="dast" aria-selected="false">DAST-10</a>
		  									</li>
  									<?php } ?>


								</ul>
							<div class="tab-content" id="myTabContent222">
								<div class="tab_content_inner">
								   	<?php if(isset($is_show_soapp_comm) && $is_show_soapp_comm == 1){

								   		if($active_sub_tab == 'soapp'){
									   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_16_soapp'));
								   	 ?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'soapp' ? 'show active' : ''; ?>" id="soapp" role="tabpanel" aria-labelledby="soapp-tab">

	  										<?php if(!empty($soapp_drug_question)){

	  												foreach ($soapp_drug_question as $key => $value) {

	  													$old_val = !empty($old_medication_refill_comm_soapp_details) && isset($old_medication_refill_comm_soapp_details['soapp']) && !empty($old_medication_refill_comm_soapp_details['soapp']) &&isset($old_medication_refill_comm_soapp_details['soapp'][$value->id]['answer']) ? $old_medication_refill_comm_soapp_details['soapp'][$value->id]['answer'] : "";
	  													?>
				  										<div class="row">
				  											<div class="col-md-12">
				  												<div class="form-group form_fild_row">
				  													<div class="radio_bg">
				  														<label><?php echo $value->question; ?>&nbsp;<span class="required">*</span></label>
				  														<div class="radio_list">
				  															<?php
																				$options = unserialize($value->options) ;
																				foreach ($options as $k => $v) {

																			?>
																					<div class="form-check">
																						<input type="radio"  value="<?= $v ?>"  class="form-check-input" id="radio_question<?= $i ?>" name="soapp_drug_details_question[<?= $value->id ?>]"  required="true" <?php echo $old_val == $v ? 'checked': ""; ?>>
				         																<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
																					</div>
																			<?php $i++; } ?>
				  														</div>
				  													</div>
				  												</div>

				  											</div>
				  										</div>
	  										<?php 	}
	  											} ?>

	  											<div class="back_next_button">
													<ul>
														<li>
															<?php if($step_id == 26){?>
															<button id="cancer_medical_history-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
														<?php }else{?>

															<button id="allergies-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
														<?php }?>
														</li>
													 	<li style="float: right;margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="soapp">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="16">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										?>

										<?php

										if($active_sub_tab == 'comm'){
											echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_16_comm')); ?>
										<div class="tab-pane fade <?php echo $active_sub_tab == 'comm' ? 'show active' : ''; ?>" id="comm" role="tabpanel" aria-labelledby="comm-tab">
											<?php if(!empty($comm_drug_question)){

	  												foreach ($comm_drug_question as $key => $value) {

	  													$old_val = !empty($old_medication_refill_comm_soapp_details) && isset($old_medication_refill_comm_soapp_details['comm']) && !empty($old_medication_refill_comm_soapp_details['comm']) &&isset($old_medication_refill_comm_soapp_details['comm'][$value->id]['answer']) ? $old_medication_refill_comm_soapp_details['comm'][$value->id]['answer'] : "";
	  												 ?>

				  										<div class="row">
				  											<div class="col-md-12">
				  												<div class="form-group form_fild_row">
				  													<div class="radio_bg">
				  														<label><?php echo $value->question; ?>&nbsp;<span class="required">*</span></label>
				  														<div class="radio_list">
				  															<?php
																				$options = unserialize($value->options) ;
																				foreach ($options as $k => $v) {

																			?>
																					<div class="form-check">
																						<input type="radio"  value="<?= $v ?>"  class="form-check-input" id="radio_question<?= $i ?>" name="comm_drug_details_question[<?= $value->id ?>]"  required="true" <?php echo $old_val == $v ? 'checked': ""; ?> >
				         																<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
																					</div>
																			<?php $i++; } ?>
				  														</div>
				  													</div>
				  												</div>

				  											</div>
				  										</div>
	  										<?php 	}
	  											} ?>

	  											<div class="back_next_button">
													<ul>

													 	<li style="float: right;margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_dast">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="comm">Next</button>
													 	</li>
													</ul>
												</div>
										</div>

										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="16">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
									<?php

											$this->Form->end() ;
										}
									} ?>

									<?php if(isset($check_is_show_soapp_comm_padt_dast['padt']) && $check_is_show_soapp_comm_padt_dast['padt'] == 1 && $active_sub_tab == 'padt'){


									echo $this->Form->create(null , array(   'autocomplete' => 'off',

										'inputDefaults' => array(
										'label' => false,
										'div' => false,

										),'enctype' => 'multipart/form-data', 'id' => 'form_tab_16_padt'));
									?>

									<div class="tab-pane fade <?php echo $active_sub_tab == 'padt' ? 'show active' : ''; ?>" id="padt" role="tabpanel" aria-labelledby="padt-tab">
										<br>
										<div class="TitleHead header-sticky-tit">
										   <h3>Please rate the severity of any side effects you are experiencing:</h3>
										   <div class="seprator"></div>
										  </div>

  										<?php if(!empty($padt_drug_question)){

  												foreach ($padt_drug_question as $key => $value) {

  													$old_val = !empty($old_medication_refill_extra_details) && isset($old_medication_refill_extra_details['padt']) && !empty($old_medication_refill_extra_details['padt']) &&isset($old_medication_refill_extra_details['padt'][$value->id]['answer']) ? $old_medication_refill_extra_details['padt'][$value->id]['answer'] : "";
  													//var_dump($old_val);

  													switch ($value['question_type']) {
  														case 1: ?>

  																<div class="row">
						  											<div class="col-md-12">
						  												<div class="form-group form_fild_row">
						  													<div class="radio_bg">

						  														<?php if($value['id'] == 119){ ?>

						  															<div class="col-md-6" style="display: inline-flex;margin-bottom: 10px;padding: 0;">
						  																<label style="margin-right: 5px;"><?php echo $value->question; ?>&nbsp;</label>
						  																<input type="text" name="padt_other_question_119" class="form-control" value="<?php echo isset($old_medication_refill_extra_details['padt_other_question_119']) ? $old_medication_refill_extra_details['padt_other_question_119'] :'' ?>">

						  															</div>
						  															<br>
						  														<?php }
						  														else{ ?>

						  															<label><?php echo $value->question; ?>&nbsp;<span class="required">*</span></label>

						  														<?php }?>
						  														<div class="radio_list">
						  															<?php
																						$options = unserialize($value->options) ;
																						foreach ($options as $k => $v) {

																					?>
																							<div class="form-check">
																								<input type="radio"  value="<?= $v ?>"  class="form-check-input <?php echo $value['id'] == 119 ? 'ignore_fld' : ''; ?>" id="radio_question<?= $i ?>" name="padt_drug_details_question[<?= $value->id ?>]"  required=<?php echo $value['id'] != 119 ? "true":"false"; ?> <?php echo $old_val == $v ? 'checked': ""; ?>>
						         																<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
																							</div>
																					<?php $i++; } ?>
						  														</div>
						  													</div>
						  												</div>
						  											</div>
						  										</div>

  															<?php break;
  																case 3: ?>
  																<div class="row">
						  											<div class="col-md-12">
						  												<div class="form-group form_fild_row">
						  													<label>

					 															<?= $value->question ?>
																				<?php  	$options = unserialize($value->options) ;// pr($options);
																				?>
					 																<span class="required">*</span>
					 															</label>
																				<select class="form-control" name="padt_drug_details_question[<?= $value->id ?>]" style="background: #ececec !important;" required="required" id="padt_question_<?= $value->id ?>">

																					<?php
																					foreach ($options as $ky => $ve) {
																						echo "<option value='".$ky."'".((string)$old_val == (string)$ky ? 'selected' : '').">".$ve."</option>";
																					} ?>
																				</select>

						  												</div>
						  											</div>
						  										</div>

  														<?php default:
  															# code...
  															break;
  													}
  													?>

  										<?php 	}
  											} ?>

  											<div class="back_next_button">
												<ul>
												 	<li style="float: right;margin-left: auto;">
												  		<!-- <button type="submit" class="btn">Next</button> -->
												  		<button type="submit" class="btn" name="sub_tab_name" value="padt">Next</button>
												 	</li>
												</ul>
											</div>

									</div>

									<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
									<input type="hidden" name="tab_number" value="16">
									<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
								<?php

										$this->Form->end() ;
								} ?>


								<!-- ORT SUB tab -->
								<?php //pr($active_sub_tab);
								//pr($check_is_show_soapp_comm_padt_dast);
								 if(isset($check_is_show_soapp_comm_padt_dast['ort']) && $check_is_show_soapp_comm_padt_dast['ort'] == 1 && $active_sub_tab == 'ort')
								   		if($active_sub_tab == 'ort'){
								   			echo $this->Form->create(null , array(   'autocomplete' => 'off',

										'inputDefaults' => array(
										'label' => false,
										'div' => false,

										),'enctype' => 'multipart/form-data', 'id' => 'form_tab_16_ort'));

								   	?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'ort' ? 'show active' : ''; ?>" id="ort" role="tabpanel" aria-labelledby="ort-tab">

	  										<?php
	  										// pr($ort_drug_question);
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_cad_detail = '';

												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_ort))
									                $old_chronic_pain_assessment_ort = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_ort), SEC_KEY));

							  					if(!empty($ort_drug_question)){
													foreach ($ort_drug_question as $key => $value) {

														$old_val = !empty($old_medication_refill_extra_details) && isset($old_medication_refill_extra_details['ort']) && !empty($old_medication_refill_extra_details['ort']) &&isset($old_medication_refill_extra_details['ort'][$value->id]['answer']) ? $old_medication_refill_extra_details['ort'][$value->id]['answer'] : "";
														$old_dqid_val = '';
														switch ($value->question_type)
														{
															case 1:
															?>
															<div class="col-md-12">
																<div class="form-group form_fild_row">
																	<div class="radio_bg">
																		<label><?= $value->question ?>
																		&nbsp;<span class="required">*</span></label>
																		<div class="radio_list">
																			<?php
																			$options = unserialize($value->options) ;
																			foreach ($options as $k => $v)
																			{
																				?>
																				<div class="form-check">
																					<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?>" id="radio_question<?= $i ?>" name="ort_drug_details_question[<?= $value->id ?>]"  required="true">
																					<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
																				</div>
																				<?php
																				$i++ ;
																			}
																			?>
																		</div>
																	</div>
																</div>
															</div>
															<?php
															break;
																case 2:

																?>
																<div class="col-md-12">
																	<div class="form-group form_fild_row <?= ($value->id == 168) ? 'new_appoint_checkbox_quest_a' : '' ?>">
																		<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
																		<div class="<?= ($value->id == 168) ? 'new_appoint_checkbox_quest' : '' ?>">
																			<span></span>
																			<?php
																			$options = unserialize($value->options) ;
																			$temp_old_dqid_val = array();
																			$old_36_37_38 = array();
																			if(is_array($old_val)){
																				foreach ($old_val as $kdq => $vdq) {
																					if(($pos = stripos($vdq, '-')) !== false){
																						$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);

																						$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																					}else{
																						$temp_old_dqid_val[$vdq] = $vdq;
																					}
																				}
																			}
																			$old_val = $temp_old_dqid_val;
																			foreach ($options as $ky => $val) {
																				?>
																				<div class="check_box_bg">
																					<div class="custom-control custom-checkbox">
																						<input <?= is_array($old_val) && array_key_exists($val, $old_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="ort_drug_details_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_val[$val]) ? $old_val[$val] : $val ?>" fixval="<?= $val ?>" subques="<?= !empty($old_36_37_38[$val]) ? $old_36_37_38[$val] : '' ?>" type="checkbox" >
																						<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
																					</div>
																				</div>

																				<?php
																				$ic++;
																			}
																			?>
																		</div>
																	</div>
																</div>
																<?php
																break;
																default:
																break;
															}
															}

								  					?>

	  											<div class="back_next_button">
													 <ul>

															<!-- <li>
																<button id="chronic_opioid_risk_tool-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															</li> -->

													 	<li style="float: right;margin-left: auto;">
													  		<button type="submit" class="btn" name="sub_tab_name" value="ort">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="16">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
										<?php $this->Form->end();
										}}?>
								<!-- End -->
								<!-- M3 sub tab -->
								<?php

										if($active_sub_tab == 'm3'){
											echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_16_m3')); ?>
										<div class="tab-pane fade <?php echo $active_sub_tab == 'm3' ? 'show active' : ''; ?>" id="m3" role="tabpanel" aria-labelledby="m3-tab">
											<?php if(!empty($m3_drug_question)){
													// pr($old_medication_refill_extra_details);

	  												foreach ($m3_drug_question as $key => $value) {

	  													$old_val = !empty($old_medication_refill_extra_details) && isset($old_medication_refill_extra_details['m3']) && !empty($old_medication_refill_extra_details['m3']) &&isset($old_medication_refill_extra_details['m3'][$value->id]['answer']) ? $old_medication_refill_extra_details['m3'][$value->id]['answer'] : "";
	  												 ?>	<?php if($value->id == 671){ ?>
		  												 <div class="TitleHead header-sticky-tit">
															<h3>AD8 Dementia Screening</h3>
															<div class="seprator"></div>
														</div>
													<?php }?>
				  										<div class="row">
				  											<div class="col-md-12">
				  												<div class="form-group form_fild_row">
				  													<div class="radio_bg">
				  														<label><?php echo $value->question; ?>&nbsp;<span class="required">*</span></label>
				  														<div class="radio_list">
				  															<?php
																				$options = unserialize($value->options) ;
																				foreach ($options as $k => $v) {

																			?>
																					<div class="form-check">
																						<input type="radio"  value="<?= $v ?>"  class="form-check-input" id="radio_question<?= $i ?>" name="m3_drug_details_question[<?= $value->id ?>]"  required="true" <?php echo $old_val == $v ? 'checked': ""; ?> >
				         																<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
																					</div>
																			<?php $i++; } ?>
				  														</div>
				  													</div>
				  												</div>

				  											</div>
				  										</div>
	  										<?php 	}
	  											} ?>

	  											<div class="back_next_button">
													<ul>

													 	<li style="float: right;margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_dast">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="m3">Next</button>
													 	</li>
													</ul>
												</div>
										</div>

										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="16">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
									<?php

											$this->Form->end() ;
										} ?>
								<!-- End M3 sub tab -->


									<?php if(isset($check_is_show_soapp_comm_padt_dast['dast']) && $check_is_show_soapp_comm_padt_dast['dast'] == 1 && $active_sub_tab == 'dast'){


										echo $this->Form->create(null , array(   'autocomplete' => 'off',
											'inputDefaults' => array(
											'label' => false,
											'div' => false,

											),'enctype' => 'multipart/form-data', 'id' => 'form_tab_16_dast'));
									 ?>

									<div class="tab-pane fade <?php echo $active_sub_tab == 'dast' ? 'show active' : ''; ?>" id="dast" role="tabpanel" aria-labelledby="dast-tab">
										<?php if(!empty($dast_drug_question)){

  												foreach ($dast_drug_question as $key => $value) {

  													$old_val = !empty($old_medication_refill_extra_details) && isset($old_medication_refill_extra_details['dast']) && !empty($old_medication_refill_extra_details['dast']) &&isset($old_medication_refill_extra_details['dast'][$value->id]['answer']) ? $old_medication_refill_extra_details['dast'][$value->id]['answer'] : "";
  												 ?>

			  										<div class="row">
			  											<div class="col-md-12">
			  												<div class="form-group form_fild_row">
			  													<div class="radio_bg">
			  														<label><?php echo $value->question; ?>&nbsp;<span class="required">*</span></label>
			  														<div class="radio_list">
			  															<?php
																			$options = unserialize($value->options) ;
																			foreach ($options as $k => $v) {

																		?>
																				<div class="form-check">
																					<input type="radio"  value="<?= $v ?>"  class="form-check-input" id="radio_question<?= $i ?>" name="dast_drug_details_question[<?= $value->id ?>]"  required="true" <?php echo $old_val == $v ? 'checked': ""; ?> >
			         																<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
																				</div>
																		<?php $i++; } ?>
			  														</div>
			  													</div>
			  												</div>

			  											</div>
			  										</div>
  										<?php 	}
  											} ?>



											<div class="back_next_button">
												<ul>
													<?php if(!isset($is_show_soapp_comm) || (isset($is_show_soapp_comm) && $is_show_soapp_comm == 0 )){ ?>
													<li>

														<button id="allergies-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
													</li>
													<?php } ?>

												 	<li style="float: right;margin-left: auto;">
												  		<button type="submit" class="btn" name="sub_tab_name" value="dast">Next</button>
												 	</li>
												</ul>
											</div>
									</div>

									<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 						<input type="hidden" name="tab_number" value="16">
			 						<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

								<?php

									$this->Form->end();
								} ?>

								</div>
				 			</div>
						</div>
			   		</div>
			  	</div>
			</div>

   <?php //$this->Form->end() ;
}
   ?>

<?php

if(in_array(17, $current_steps) && $tab_number == 17){

	if(!empty($user_detail_old->chief_compliant_userdetail->follow_up_sx_detail))

		$old_follow_up_sx_detail = $user_detail_old->chief_compliant_userdetail->follow_up_sx_detail ;

		$ic = 1;
		$chief_compliant_userdata_name = isset($cur_cc_data->name) ? $cur_cc_data->name : '';
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_17')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==17  || 17==$current_steps[0])  ? '  show active ' : '' ?>" id="pre_op_medications" role="tabpanel" aria-labelledby="pre_op_medications-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">

			   <h3>
			   	Follow Up Details <?php echo '<b>['.$chief_compliant_userdata_name.']</b>';  ?>
			   	<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
					//pr($cur_cc_data);die;
						$i = 0 ;
						$cb_class = '';

						if(!empty($follow_up_question)){
							foreach ($follow_up_question as $key => $value) {


								//question is not shown when the previous follow up detail has not pain scale best and pain scale worst and temporal

								if($value['id'] == 134 && (empty($previous_follow_up_symptom_detail) || (!empty($previous_follow_up_symptom_detail) && !isset($previous_follow_up_symptom_detail['pain_best_scale'])))){

									//pain scale best
									continue;
								}
								elseif($value['id'] == 135 && (empty($previous_follow_up_symptom_detail) || (!empty($previous_follow_up_symptom_detail) && !isset($previous_follow_up_symptom_detail['pain_worst_scale'])))){

									//pain scale wrost
									continue;
								}
								elseif(($value['id'] == 136 || $value['id'] == 137) && (empty($previous_follow_up_symptom_detail) || (!empty($previous_follow_up_symptom_detail) && !isset($previous_follow_up_symptom_detail['temporal']))) ){

									//temporal
									continue;
								}

								elseif(($value['id'] == 131 || $value['id'] == 132 || $value['id'] == 133) && (empty($previous_follow_up_symptom_detail) || (!empty($previous_follow_up_symptom_detail) && !isset($previous_follow_up_symptom_detail['location']))) ){

									//temporal
									continue;
								}

								$best_pain_scale = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['pain_best_scale']) ? $previous_follow_up_symptom_detail['pain_best_scale'] : '');

								$worst_pain_scale = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['pain_worst_scale']) ? $previous_follow_up_symptom_detail['pain_worst_scale'] : '');

								$temporal = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['temporal']) ? $previous_follow_up_symptom_detail['temporal'] : '');

								if(!empty($temporal)){

					              if($temporal == 'afternoon' || $temporal == 'morning'){

					                  $temporal = 'in the '.$temporal;
					              }
					              elseif($temporal == 'night'){

					                  $temporal = 'at '.$temporal;
					              }
					              elseif($temporal == 'only after meals' || $temporal == 'same all day'){

					                  $temporal = $temporal;
					              }
					              else{

					                $temporal = 'in the '.$temporal;
					              }
					            }

								$location = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['location']) ? $previous_follow_up_symptom_detail['location'] : '');


								$old_dqid_val = !empty($old_follow_up_sx_detail[$cur_detail_tab_chief_compliant][$value->id]['answer']) ? $old_follow_up_sx_detail[$cur_detail_tab_chief_compliant][$value->id]['answer'] : '';
								//pr($old_dqid_val);
								switch ($value->question_type) {										    case 0:
										 ?>


									<div class="col-md-12 <?php echo $value->id == 133 ? 'follow_up_question_132_133 display_none_at_load_time': ''; ?> <?php echo $value->id == 139 ? 'follow_up_question_138_139 display_none_at_load_time': ''; ?>">
					 					<div class="form-group form_fild_row">
					 						<?php if(!empty($value->question)){ ?><?= str_replace(['***','**bestpain','**worstpain','**oldtemp','**oldloc'], [$chief_compliant_userdata_name,$best_pain_scale, $worst_pain_scale, $temporal, $location], $value->question) ?>&nbsp; <span class="required">*</span> <?php } ?>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="follow_up_question[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'follow_up_question'.$value->id; ?>"/>

					 					</div>
									</div>

								<?php
									    break;
									    case 1:
										?>

									<div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= str_replace(['***','**bestpain','**worstpain','**oldtemp','**oldloc'], [$chief_compliant_userdata_name,$best_pain_scale, $worst_pain_scale, $temporal, $location], $value->question) ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>

        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 132 ? "follow_up_question_132" : ""; ?> <?php echo $value->id == 138 ? "follow_up_question_138" : ""; ?>" id="radio_question<?= $i ?>" name="follow_up_question[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div>


								<?php
									break;
									case 3:

							 	?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<label><?= str_replace(['***','**bestpain','**worstpain','**oldtemp','**oldloc'], [$chief_compliant_userdata_name,$best_pain_scale, $worst_pain_scale, $temporal, $location], $value->question) ?>

											<?php $options = unserialize($value->options);
												//pr($options);
											?>

					 						<span class="required">*</span>
					 						</label>

											<select class="form-control question_<?= $value->id ?>" name="follow_up_question[<?= $value->id ?>]" style="background: #ececec;" required="true" id="">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>

							<?php
						        break;
						           case 2:

							?>
									<div class="col-md-12">
										<div class="form-group form_fild_row <?php echo ($value->id == 28 || $value->id == 33) ? "new_appoint_checkbox_quest_a" : ""; ?>">
					 						<label><?= str_replace(['***','**bestpain','**worstpain','**oldtemp','**oldloc'], [$chief_compliant_userdata_name,$best_pain_scale, $worst_pain_scale, $temporal, $location], $value->question) ?>&nbsp;<span class="required">*</span></label>
					 						<div class="<?php echo ($value->id == 28 || $value->id == 33) ? "new_appoint_checkbox_quest" : ""; ?>">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
									 		//pr($options);
													// for 19 and 23 option if user select last option then other option should unchecked
											?>
											<?php

											// }
 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if($value['id'] == 140){

												if(is_array($old_dqid_val)){
													foreach ($old_dqid_val as $kdq => $vdq) {
														if($kdq != 'med_type'){

															 $temp_old_dqid_val[$vdq] = $vdq;
														}else{

															$temp_old_dqid_val[$kdq] = $vdq;
														}
													}
												}
											}
											else{

												if(is_array($old_dqid_val)){
													foreach ($old_dqid_val as $kdq => $vdq) {
														if(($pos = stripos($vdq, '-')) !== false){
															$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
															// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

															$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
														}else{
															$temp_old_dqid_val[$vdq] = $vdq;
														}
													}
												}
											}


											$old_dqid_val = $temp_old_dqid_val;

											//pr($options);
											foreach ($options as $ky => $val) {

												if($value['id'] == 140){

													//pr($old_dqid_val);
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?><?php echo $value['id'] == 140 ? 'follow_up_question_140' : ''; ?>"  name="follow_up_question[<?= $value->id ?>][<?= $ky ?>]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" data-class_name="follow_up_medication_type_<?php echo $ky; ?>">
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

		 									<div class="col-md-12 follow_up_medication_type_<?php echo $ky; ?> display_none_at_load_time">
												<div class="form-group form_fild_row">
 													<div class="radio_bg">
	          											<label>How much did it help?
	          											&nbsp;<span class="required">*</span></label>

														<div class="radio_list">

	        												<div class="form-check">
	         													<input type="radio" value="a lot" class="form-check-input " id="med_type_radio_question_<?= $ky; ?>_1" name="follow_up_question[<?= $value->id ?>][med_type][<?= $ky ?>]" required="true" <?= !empty($old_dqid_val['med_type']) && isset($old_dqid_val['med_type'][$ky]) && $old_dqid_val['med_type'][$ky] == 'a lot' ? 'checked' : '' ?>>
	         													<label class="form-check-label" for="med_type_radio_question_<?= $ky; ?>_1">
	         														A lot
	         													</label>
	       													</div>

	        												<div class="form-check">
	         													<input type="radio" value="a little" class="form-check-input " id="med_type_radio_question_<?= $ky; ?>_2" name="follow_up_question[<?= $value->id ?>][med_type][<?= $ky ?>]" required="true" <?= !empty($old_dqid_val['med_type']) && isset($old_dqid_val['med_type'][$ky]) && $old_dqid_val['med_type'][$ky] == 'a little' ? 'checked' : '' ?> >
	         													<label class="form-check-label" for="med_type_radio_question_<?= $ky; ?>_2">
	         														A little
	         													</label>
	       													</div>

	       													<div class="form-check">
	         													<input type="radio" value="not at all" class="form-check-input " id="med_type_radio_question_<?= $ky; ?>_3" name="follow_up_question[<?= $value->id ?>][med_type][<?= $ky ?>]" required="true" <?= !empty($old_dqid_val['med_type']) && isset($old_dqid_val['med_type'][$ky]) && $old_dqid_val['med_type'][$ky] == 'not at all' ? 'checked' : '' ?> >
	         													<label class="form-check-label" for="med_type_radio_question_<?= $ky; ?>_3">
	         														Not at all
	         													</label>
	       													</div>

														</div>
   													</div>
				 								</div>
											</div>

										<?php } else{  ?>


											<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="follow_up_question[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" data-class_name="follow_up_medication_type_<?php echo $ky; ?>">
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>
										<?php } ?>

								 			<?php
								 				$ic++;
										 	}

										 	?>

										</div>
					 				</div>
								</div>
						<?php
								break;
								case 4:
										?>
									<div class="col-md-12">
										<div class="form-group form_fild_row">

											this block for image type questions

										</div>
									</div>
					 	<?php
								break;

								default:

								break;

							}
						}
					}

					?>
			   </div>

		   <div class="back_next_button">
			<ul>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>
		<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>">

		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="17">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>

 <?php

//pr($tab_number);die;

if(in_array(18, $current_steps) && $tab_number == 18){

	//pr($cur_cc_data);

	if(!empty($user_detail_old->chief_compliant_userdetail->covid_detail))

		$old_covid_detail = $user_detail_old->chief_compliant_userdetail->covid_detail ;

		//pr($old_follow_up_sx_detail);die;

		$ic = 1;

     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_18')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==18  || 18==$current_steps[0])  ? '  show active ' : '' ?>" id="covid_detail" role="tabpanel" aria-labelledby="covid_detail-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">

			   <h3>
			   	COVID-19 Screening Details
			   	<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row">

					<?php
						$i = 0 ;
						$cb_class = '';
						//pr($covid_questions);die;
						if(!empty($covid_questions)){
							foreach ($covid_questions as $key => $value) {


								$old_dqid_val = !empty($old_covid_detail[$value->id]['answer']) ? $old_covid_detail[$value->id]['answer'] : '';
								//pr($old_dqid_val);
								//$old_dqid_val = '';
								switch ($value->question_type) {
										case 0; ?>

											<div class="col-md-12 <?php echo   $value->id == 203 ? 'display_none_at_load_time covid_ques_202_203' : ''; ?>  <?php echo   $value->id == 206 ? 'display_none_at_load_time covid_ques_205_206' : ''; ?>">
					 								<div class="form-group form_fild_row">
					 									<?= $value->question ?>
					 									&nbsp;<span class="required">*</span>
														<input type="text" value="<?= $old_dqid_val ?>" class="form-control"  name="covid_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'question_'.$value->id; ?>"/>

													</div>
												</div>

									    <?php break;

									    case 1:
										?>

									<div class="col-md-12 <?php echo $value->id == 145 ? 'display_none_at_load_time covid_ques_144_145' : ''; ?> <?php echo $value->id == 146 ? 'display_none_at_load_time covid_ques_144_146' : ''; ?> <?php echo $value->id == 147 ? 'display_none_at_load_time covid_ques_144_147' : ''; ?> <?php echo $value->id == 150 ? 'display_none_at_load_time covid_ques_149_150' : ''; ?> <?php echo $value->id == 151 ? 'display_none_at_load_time covid_ques_149_151' : ''; ?> <?php echo $value->id == 152 ? 'display_none_at_load_time covid_ques_149_152' : ''; ?>">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= $value->question ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo 'covid_ques_'.$value->id; ?> <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> " id="radio_question<?= $i ?>" name="covid_detail[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div>


								<?php
									break;

									case 2:
						?>
							<div class="col-md-12 <?php echo $value->id == 144 ? 'display_none_at_load_time covid_ques_143_144' : ''; ?> <?php echo $value->id == 149 ? 'display_none_at_load_time covid_ques_148_149' : ''; ?> <?php echo $value->id == 202 ? 'display_none_at_load_time covid_ques_201_202' : ''; ?> <?php echo $value->id == 205 ? 'display_none_at_load_time covid_ques_204_205' : ''; ?>">
					 			<div class="form-group form_fild_row <?= ($value->id == 144 || $value->id == 149 || $value->id == 156 || $value->id == 202 || $value->id == 205) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 					<label><?= $value->question ?>&nbsp;<?php if($value->id != 156){ ?><span class="required">*</span><?php } ?></label>
					 					<div class="<?= ($value->id == 144 || $value->id == 149 || $value->id == 156 || $value->id == 202 || $value->id == 205) ? 'new_appoint_checkbox_quest' : '' ?>">
					 						<span></span>
					 						<?php
					 							$options = unserialize($value->options) ; ?>
										<?php
										 	$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
												$required = '';
												if($value->id == 156)
												{
													$required = "";
												}
												else
												{
													$required = "required='required'";
												}

			 							?>

												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?><?php echo $value->id == 156 ? ' do_not_ignore': ''; ?> <?php echo $value->id == 144 ? 'covid_ques_144': ''; ?> <?php echo $value->id == 149 ? 'covid_ques_149': ''; ?> <?php echo $value->id == 202 ? 'covid_ques_202' : ''; ?> <?php echo $value->id == 205 ? 'covid_ques_205' : ''; ?>"  name="covid_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" subques="<?= !empty($old_36_37_38[$val]) ? $old_36_37_38[$val] : '' ?>" type="checkbox" <?php echo $required?> >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

			 								<?php
			 									$ic++;
					 						}

					 						?>
										</div>
					 				</div>
								</div>
							<?php
							break;


								default:

								break;

							}
						}
					}

					?>
			   </div>

			   	<div class="TitleHead header-sticky-tit">

				   <h3>
				   	How often have you been bothered by the following over the past 2 weeks?
				   	<br></h3>
				   <div class="seprator"></div>
				</div>
				<div class="row phq-9-section">

					<?php

						$old_phq_9_detail = '';
						if(!empty($user_detail_old->chief_compliant_userdetail->phq_9_detail))
							$old_phq_9_detail = $user_detail_old->chief_compliant_userdetail->phq_9_detail ;

						$i = 0 ;
						$cb_class = '';
						//pr($covid_questions);die;
						if(!empty($phq_9_questions)){
							foreach ($phq_9_questions as $key => $value) {										$old_qd = !empty($old_phq_9_detail) && isset($old_phq_9_detail[$value->id]) ? $old_phq_9_detail[$value->id] : '';
								switch ($value->question_type) {

									    case 1:
										?>

										<div class="col-md-12">
											<h5><?= ucfirst($value->question) ?></span></h5>
										</div>
										<div class="col-md-12" style="margin-bottom: 25px;">
											<div class="btn-group" data-toggle="buttons">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>

														<label class="btn btn-primary  <?= $old_qd != '' && $old_qd == $k ? 'active' : '' ?> "  for="phq_9_ques<?= $i ?>">
									     					<input type="radio"  value="<?php echo $k;?>" <?= $old_qd != '' && $old_qd == $k ? 'checked' : '' ?>   class="form-check-input" id="phq_9_ques<?= $i++ ?>" name="phq_9_detail[<?= $value->id ?>]" required="true">
									     					<?php echo $v; ?>
									     				</label>


							    				<?php } ?>
							   				</div>
							   			</div>

								<?php
									break;

								default:

								break;

							}
						}
					}

					?>
			   </div>



		   <div class="back_next_button">
			<ul>
				<?php if($step_id == 17){ ?>

					<li>

						<button id="focus_history-backbtn" type="button" class="btn nofillborder">Previous Tab</button>

				     </li>


				<?php }
					else{
				?>
				<li>

					<button id="contact-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>

			     </li>
			 <?php } ?>

			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>


		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="18">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>

  <?php

//pr($tab_number);die;

if(in_array(19, $current_steps) && $tab_number == 19){

	//pr($cur_cc_data);
	$old_phq_9_detail = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->phq_9_detail))

		$old_phq_9_detail = $user_detail_old->chief_compliant_userdetail->phq_9_detail ;

		//pr($old_follow_up_sx_detail);die;

		$ic = 1;

     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_19')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==19  || 19==$current_steps[0])  ? '  show active ' : '' ?>" id="phq_9" role="tabpanel" aria-labelledby="phq_9-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">

			   <h3>
			   	PHQ-9 Details
			   	<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row phq-9-section">

					<?php
						$i = 0 ;
						$cb_class = '';
						//pr($covid_questions);die;
						if(!empty($phq_9_questions)){
							foreach ($phq_9_questions as $key => $value) {										$old_qd = !empty($old_phq_9_detail) && isset($old_phq_9_detail[$value->id]) ? $old_phq_9_detail[$value->id] : '';
								switch ($value->question_type) {

									    case 1:
										?>

									<!-- <div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= $value->question ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>

        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input" id="radio_question<?= $i ?>" name="covid_detail[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div> -->


										<div class="col-md-12">
											<h5><?= ucfirst($value->question) ?></span></h5>
										</div>
										<div class="col-md-12" style="margin-bottom: 25px;">
											<div class="btn-group" data-toggle="buttons">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>

														<label class="btn btn-primary  <?= $old_qd != '' && $old_qd == $k ? 'active' : '' ?> "  for="phq_9_ques<?= $i ?>">
									     					<input type="radio"  value="<?php echo $k;?>" <?= $old_qd != '' && $old_qd == $k ? 'checked' : '' ?>   class="form-check-input" id="phq_9_ques<?= $i++ ?>" name="phq_9_detail[<?= $value->id ?>]" required="true">
									     					<?php echo $v; ?>
									     				</label>


							    				<?php } ?>
							   				</div>
							   			</div>



								<?php
									break;

								default:

								break;

							}
						}
					}

					?>
			   </div>



		   <div class="back_next_button">
			<ul>

				<?php if($step_id == 1){ ?>
					<li>

						<button id="covid_detail-backbtn" type="button" class="btn nofillborder">Previous Tab</button>

				     </li>
			 	<?php } ?>

			 	<?php if($step_id == 2){ ?>
					<li>

						<button id="profile-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>

				     </li>
			 	<?php } ?>

			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>

		</div>
	</div>


		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="19">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>

<?php }
 ?>

 <?php

if(in_array(20, $current_steps) && $tab_number == 20){
	///pr(unserialize($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_tmb)); die;
	if(!empty($user_detail_old->chief_compliant_userdetail->chief_compliant_details))
		$old_chief_compliant_details = $user_detail_old->chief_compliant_userdetail->chief_compliant_details ;
	$old_chronic_pain_assessment_pmh = '';
	$old_chronic_pain_curr_treat_history = '';
	$old_chronic_pain_past_treat_history = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_pmh))
		$old_chronic_pain_assessment_pmh = $user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_pmh;

	if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_curr_treat_history))
		$old_chronic_pain_curr_treat_history = $user_detail_old->chief_compliant_userdetail->chronic_pain_curr_treat_history;

	if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_past_treat_history))
		$old_chronic_pain_past_treat_history = $user_detail_old->chief_compliant_userdetail->chronic_pain_past_treat_history;
	$ic = 1;

    echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_20')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==20  || 20==$current_steps[0])  ? '  show active ' : '' ?>" id="cronic_pain_assessment" role="tabpanel" aria-labelledby="cronic_pain_assessment-tab">
		  	 <!-- backup code -->
		  	 <!-- end back up code -->
	   <!-- Pain Management -->
	   <div class="errorHolder">
              </div>
			   <div class="TitleHead">
			  <!--  <h3>TMB Chronic Pain</h3> -->
			   <div class="seprator"></div>
			  </div>


			  <div class="tab_form_fild_bg">
			   <div class="row">

			   	<div class="form-group form_fild_row">
								<ul class="nav nav-tabs" id="myTab222" role="tablist">
									<?php
									//$chronicPainAssessment = array('0' =>'tmb','1' =>'thc','2' =>'thp','3' =>'other','4' =>'ort');
									$chronicPainAssessment = array('pain_assessments' =>'Pain assessments','treatment_history' =>'Treatment history','opioid_overdose_risk' =>'Opioid overdose risk','opioid_risk_tool' =>'Opioid risk tool');
										if(!empty($chronicPainAssessment)){

											foreach ($chronicPainAssessment as $cond_key => $cond_value) {
												$cond_value = strtolower($cond_value);
												?>
												<li class="nav-item">
													<?php if($cond_key == 'pain_assessments'){
															echo $this->Form->postLink(
															    "post link", // first
															     null,  // second
															    ['id' =>'pain_ass_tabpostlink'] // third
															);
														}
			   											?>
			  										<?php
															echo $this->Form->postLink(
															    "post link", // first
															     null,  // second
															    ['data' => ['edited_sub_tab' => ucfirst($cond_value),'edited_tab' => 20], 'id' => $cond_key.'-tabpostlink'] // third
															);
			   											?>

			    									<a class="nav-link current_sub_tab <?php echo $active_sub_tab == ucfirst($cond_value) ? 'active' : ''; ?>" id="<?php echo $cond_key.'-tab'; ?>" data-toggle="tab" href="#<?php echo $cond_value; ?>" role="tab" aria-controls="<?php echo $cond_value; ?>" aria-selected="false"><?php echo ucfirst($cond_value); ?></a>
			  									</li>
									<?php	}
									?>
									<?php } ?>
								</ul>

							<div class="tab-content" id="myTabContent222">
								<div class="tab_content_inner">

							     <?php if(in_array('Pain assessments', $chronicPainAssessment)){
							     	//pr($active_sub_tab);die;
							       if($active_sub_tab == 'Pain assessments'){

									   echo $this->Form->create(null , array('autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,
												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_20_tmb'));
								   	?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'Pain assessments' ? 'show active' : ''; ?>" id="pain_assessments" role="tabpanel" aria-labelledby="pain_assessments-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_cronic_pain_assessment_tmb_detail = '';

												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_tmb))
									                $old_cronic_pain_assessment_tmb_detail = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_tmb), SEC_KEY));
									            //pr($cronic_pain_assessment_tmb_question); die;
							  				if(!empty($cronic_pain_assessment_tmb_question)){
												foreach ($cronic_pain_assessment_tmb_question as $key => $value) {

												$old_val = !empty($old_cronic_pain_assessment_tmb_detail[$value->id]) ? $old_cronic_pain_assessment_tmb_detail[$value->id] : '';
												$old_dqid_val = '';
												switch ($value->question_type){
													case 1:	?>
													<div class="col-md-12">						<div class="form-group form_fild_row">
													<div class="radio_bg"><label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
													<div class="radio_list">
													<?php $options = unserialize($value->options);
													foreach ($options as $k => $v){?>
													<div class="form-check">
														<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?>" id="radio_question<?= $i ?>" name="chronic_pain_assessment_tmb[<?= $value->id ?>]"  required="true">
														<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
													</div>
													<?php
													$i++ ;}?>
													</div>
												</div>
											</div>
											</div>
											<?php
											break;
											case 3: ?>
											<div class="col-md-12">
											<div class="form-group form_fild_row">
											<label>
											<?= $value->question ?>
											<?php $options = unserialize($value->options) ; ?>						<?php if(isset($options[0]) && !empty($value->question)){ ?>
											<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">			<i class="fa fa-question-circle" aria-hidden="true"></i></a>				<span class="required">*</span>
											<?php } ?>
										</label>
										<select class="form-control" name="chronic_pain_assessment_tmb[<?= $value->id ?>]" style="background: #ececec;" id="question_<?= $value->id ?>" required="true">
										<?php
										foreach ($options as $ky => $ve) {
										echo "<option value='".$ky."'".((string)$old_val == (string)$ky ? 'selected' : '').">".$ve."</option>";
									} ?> ?>
										</select>
											</div>
									</div>
														<?php
														break;
														default:
														break;
													}
						}
					}
					?>
	  					<div class="col-md-12">
	  						<div class="TitleHead">
	  							<h3>Please check any of the health conditions you've been diagnosed with before ?</h3>
	  							<div class="seprator"></div>
	  						</div>

	  						<div class="tab_form_fild_bg">
	  							<?php //pr($cronic_pain_assessment_conditions); die;

	  							//pr($old_chronic_pain_assessment_pmh);die;
	  							if(!empty($cronic_pain_assessment_conditions)) {

	  								if(!empty($old_chronic_pain_assessment_pmh))
									                $old_chronic_pain_assessment_pmh = unserialize(Security::decrypt( base64_decode($old_chronic_pain_assessment_pmh), SEC_KEY));

	  								foreach($cronic_pain_assessment_conditions as $k => $v) {
	  									$k_exst = false;

	  									?>
	  									<div class="row shotshistoryfld">
	  										<div class="col-md-4">
	  											<div class="form-group form_fild_row">
	  												<label><?php echo ucfirst($v->name); ?></label>
	  											</div>
	  										</div>

	  										<div class="col-md-4">
	  											<div class="form-group form_fild_row">
	  												<div class="custom-control custom-checkbox">
	  													<input name="chronic_pain_assessment_pmh[<?=  $v->id ?>][sym_id]" value="<?=  $v->id ?>" class="custom-control-input check_pain" id="shotid<?php echo $v->id ; ?>" <?= isset($old_chronic_pain_assessment_pmh) && !empty($old_chronic_pain_assessment_pmh) && ($k_exst = array_key_exists($v->id, $old_chronic_pain_assessment_pmh)) ? 'checked' : ''?> type="checkbox">
	  													<label class="custom-control-label" for="shotid<?php echo $v->id ; ?>">I've had this symptom.</label>
	  												</div>
	  											</div>
	  										</div>
	  										<div class="col-md-4">
	  											<div class="row">
	  												<div class="col-md-12">
	  													<div class="form-group form_fild_row">
	  														<input type="text" name="chronic_pain_assessment_pmh[<?= $v->id ?>][date]" class="form-control chronicpain <?= !empty($k_exst) && $k_exst === true ? '' : 'on_load_display_none_cls' ?>"  name="chronic_pain_assessment_codition[<?= $v->id ?>][date]" required="required" value="<?= isset($old_chronic_pain_assessment_pmh[$v->id]) ? $old_chronic_pain_assessment_pmh[$v->id] :'' ?>">
								  													</div>
								  												</div>
								  											</div>
								  										</div>
								  									</div>
								  								<?php } } ?>
								  							</div>
								  						</div>

	  											<div class="back_next_button">
													<ul>
													 	<li style="float: right;margin-left: auto;">
													  		<button type="submit" class="btn" name="sub_tab_name" value="Pain assessments">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="20">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
										<?php $this->Form->end();
										}
									}
										?>


									<?php if(in_array('Treatment history', $chronicPainAssessment)){

											 if($active_sub_tab == 'Treatment history'){

									   		echo $this->Form->create(null , array('autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,
												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_20_treatment_history'));
								   	?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'Treatment history' ? 'show active' : ''; ?>" id="treatment_history" role="tabpanel" aria-labelledby="treatment_history-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_cad_detail = '';

												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_treatment_history))
									                $old_chronic_pain_treatment_history = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->chronic_pain_treatment_history), SEC_KEY));
									            // pr(unserialize($old_chronic_pain_treatment_history)); die;

							  					if(!empty($cronic_pain_assessment_thc_question)){
													foreach ($cronic_pain_assessment_thc_question as $key => $value) {

														$old_val = !empty($old_chronic_pain_treatment_history[$value->id]) ? $old_chronic_pain_treatment_history[$value->id] : '';

														$old_dqid_val = '';
														switch ($value->question_type)
														{case 1:
														?>
														<div class="col-md-12">
															<div class="form-group form_fild_row">
															<div class="radio_bg">
											<label><?= $value->question ?>
											&nbsp;<span class="required">*</span></label>
											<div class="radio_list">
												<?php
												$options = unserialize($value->options) ;
												//pr($options); die;
												foreach ($options as $k => $v)
												{
													?>
													<div class="form-check">
														<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_pain_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_pain_assessment_thc[<?= $value->id ?>]"  required="true">
														<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
													</div>
													<?php
													$i++ ;
												}
												?>
											</div>
										</div>
									</div>
								</div>
								<?php
								break;
								case 2:
									?>
									<div class="col-md-12 <?php echo $value->id == 170 ? 'chronic_treatmenthistory_question_168_170 display_none_at_load_time' : '' ?><?php echo $value->id == 173 ? 'chronic_treatmenthistory_question_172_173 display_none_at_load_time' : '' ?>">
										<div class="form-group form_fild_row <?= ($value->id == 168) ? 'new_appoint_checkbox_quest_a' : '' ?>">
											<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
											<div class="<?= ($value->id == 170 || $value->id == 173) ? 'new_appoint_checkbox_quest' : '' ?>">
												<span></span>
												<?php
												$options = unserialize($value->options) ;
												// $temp_old_dqid_val = array();
												// $old_36_37_38 = array();
												// if(is_array($old_val)){
												// 	foreach ($old_val as $kdq => $vdq) {
												// 		if(($pos = stripos($vdq, '-')) !== false){
												// 			$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);

												// 			$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
												// 		}else{
												// 			$temp_old_dqid_val[$vdq] = $vdq;
												// 		}
												// 	}
												// }
												// $old_val = $temp_old_dqid_val;
												//pr($options);
												//pr($old_val);
												foreach ($options as $ky => $val) {
													?>
													<div class="check_box_bg">
														<div class="custom-control custom-checkbox">
															<input <?= is_array($old_val) && array_key_exists($ky, array_filter($old_val))   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo $value->id == 170 ? 'chronic_pain_assessment_ques_170' : ''; ?><?php echo $value->id == 173 ? 'chronic_pain_assessment_ques_173' : ''; ?>"  name="chronic_pain_assessment_thc[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="" fixval="<?= $val ?>" type="checkbox" required="true" >
											<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
										</div>
									</div>
									<?php
									$ic++;
								}
								?>
							</div>
						</div>
					</div>

					<?php if($value->id == 170 ){
						$p = 0;
						foreach ($options as $painkey => $painvalue) {

							if($painvalue == 'medication')
							continue;
							?>
							<div class="col-md-12 display_none_at_load_time chornic_assessment_<?php echo $value->id ?>_<?php echo $painkey ?>">
								<div class="form-group form_fild_row">
									<div class="radio_bg">
										<h4>How much did it help treat your pain?</h4>
										<div class="radio_list">
											<div class="form-check">
												<input type="radio" value="1" <?php echo !empty($old_val[$painkey]) && $old_val[$painkey] == 1 ?'checked':'' ?> class="form-check-input chronic_pain_history<?= $value->id ?>" id="chronic_pain_history1_<?php echo $p?>" name="chronic_pain_assessment_thc[<?= $value->id ?>][<?= $p?>]" required ="true" >
												<label class="form-check-label" for="chronic_pain_history1_<?php echo $p?>">Helped a lot</label>
											</div>

											<div class="form-check">
												<input type="radio" value="2" <?php echo !empty($old_val[$painkey]) &&  $old_val[$painkey] == 2 ?'checked':'' ?>  class="form-check-input chronic_pain_history<?= $value->id ?> " id="chronic_pain_history2_<?php echo $p?>" name="chronic_pain_assessment_thc[<?= $value->id ?>][<?= $p?>]" required ="true">
												<label class="form-check-label" for="chronic_pain_history2_<?php echo $p?>">Helped a little</label>
											</div>

											<div class="form-check">
												<input type="radio" value="3" <?php echo !empty($old_val[$painkey]) &&  $old_val[$painkey] == 3 ?'checked':'' ?>  class="form-check-input chronic_pain_history<?= $value->id ?>" id="chronic_pain_history3_<?php echo $p?>" name="chronic_pain_assessment_thc[<?= $value->id ?>][<?= $p?>]" required ="true">
												<label class="form-check-label" for="chronic_pain_history3_<?php echo $p?>">Didn't help at all</label>
											</div>
										</div>
									</div>
								</div>
						</div>
							<?php
							$p++;
						}
						?>
					<?php }?>


					<?php if($value->id == 170 ){?>
						<div class="col-md-12 <?php echo $value->id == 170 ? 'chronic_treatmenthistory_question_170 display_none_at_load_time' : '' ?>">
							<div class="TitleHead">
								<h3>Please select any of the medication you've tried for pain?</h3>
								<div class="seprator"></div>
							</div>

							<div class="tab_form_fild_bg">
								<?php
								if(!empty($all_chronic_medication_detail)) {

									foreach($all_chronic_medication_detail as $k => $v) {
										$k_exst = false;
										?>
										<div class="row shotshistoryfld">
											<div class="col-md-4">
												<div class="form-group form_fild_row">
													<label><?php echo ucfirst($v); ?></label>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group form_fild_row">
													<div class="custom-control custom-checkbox">
														<input name="chronic_pain_curr_treat_history[<?=  $k ?>][sym_id]" value="<?=  $k ?>" class="custom-control-input check_treatment" id="shotidc<?php echo $k ; ?>" <?= isset($old_chronic_pain_curr_treat_history) && !empty($old_chronic_pain_curr_treat_history) && ($k_exst = array_key_exists($k, $old_chronic_pain_curr_treat_history)) ? 'checked' : ''  ?> type="checkbox"   >
													<label class="custom-control-label" for="shotidc<?php echo $k ; ?>">I've tried this pain.</label>
													</div>
													</div>
													</div>
													<div class="col-md-4">
													<div class="row">
													<div class="col-md-12">
													<div class="form-group form_fild_row">
													<?php $efficacy = array('1' =>'helped a lot', '2' =>'helped a little', '3' =>"didn't help at all")?>
													<select class="form-control <?= !empty($k_exst) && $k_exst === true ? '' : 'on_load_display_none_cls' ?>"  name="chronic_pain_curr_treat_history[<?= $k ?>][pain]" required="required">
						        							<option value="">How much did it help ?</option>
												        	<?php
													        	foreach($efficacy as $ekey => $evalue){
													        		echo "<option value='".$ekey."'".(isset($old_chronic_pain_curr_treat_history[$k]) && $old_chronic_pain_curr_treat_history[$k] == $ekey ? 'selected' : '').">".$evalue."</option>";
													        	}
												        	?>
							    						</select>

															</div>
														</div>
													</div>
												</div>
											</div>
										<?php } } ?>
									</div>

								</div>

						<?php }?>


							<?php if($value->id == 173 ){
							$p = 0;
							foreach ($options as $painkey => $painvalue) {

								if($painvalue == 'medication')
									  continue;
								?>
								<div class="col-md-12 display_none_at_load_time chornic_assessment_<?php echo $value->id ?>_<?php echo $painkey ?>">
									<div class="form-group form_fild_row">
										<div class="radio_bg">
											<h4>How much did it help treat your pain?</h4>
											<div class="radio_list">
												<div class="form-check">
								<input type="radio" value="1" <?php echo !empty($old_val) && $old_val[$painkey] == 1 ?'checked':'' ?> class="form-check-input chronic_pain_history<?= $value->id ?>" id="chronic_pain_history4_<?php echo $p?>" name="chronic_pain_assessment_thc[<?= $value->id ?>][<?= $p?>]"  required ="true">
								<label class="form-check-label" for="chronic_pain_history4_<?php echo $p?>">Helped a lot</label>
							</div>

							<div class="form-check">
								<input type="radio" value="2" <?php echo !empty($old_val) && $old_val[$painkey] == 2 ?'checked':'' ?> class="form-check-input chronic_pain_history<?= $value->id ?>" id="chronic_pain_history5_<?php echo $p?>" name="chronic_pain_assessment_thc[<?= $value->id ?>][<?= $p?>]" required ="true">
								<label class="form-check-label" for="chronic_pain_history5_<?php echo $p?>">Helped a little</label>
							</div>

							<div class="form-check">
								<input type="radio" value="3" <?php echo !empty($old_val) && $old_val[$painkey] == 3 ?'checked':'' ?> class="form-check-input chronic_pain_history<?= $value->id ?>" id="chronic_pain_history6_<?php echo $p?>" name="chronic_pain_assessment_thc[<?= $value->id ?>][<?= $p?>]" required ="true">
								<label class="form-check-label" for="chronic_pain_history6_<?php echo $p?>">Didn't help at all</label>
							</div>
						</div>
					</div>
				</div>
		</div>
			<?php
			$p++;
		}
		?>
	<?php }?>

	<?php if($value->id == 173 ){?>
		<div class="col-md-12 <?php echo $value->id == 173 ? 'chronic_treatmenthistory_question_173 display_none_at_load_time' : '' ?>">
			<div class="TitleHead">
				<h3>Please select any of the medication you've tried for pain?</h3>
				<div class="seprator"></div>
			</div>

			<div class="tab_form_fild_bg">
				<?php
				if(!empty($all_chronic_medication_detail)) {

					foreach($all_chronic_medication_detail as $k => $v) {
						$k_exst = false;
						?>
						<div class="row shotshistoryfld">
							<div class="col-md-4">
								<div class="form-group form_fild_row">
									<label><?php echo ucfirst($v); ?></label>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group form_fild_row">
									<div class="custom-control custom-checkbox">
										<input name="chronic_pain_past_treat_history[<?=  $k ?>][sym_id]" value="<?=  $k ?>" class="custom-control-input check_treatment" id="shotidp<?php echo $k ; ?>" <?= isset($old_chronic_pain_past_treat_history) && !empty($old_chronic_pain_past_treat_history) && ($k_exst = array_key_exists($k, $old_chronic_pain_past_treat_history)) ? 'checked' : ''  ?> type="checkbox"   >
										<label class="custom-control-label" for="shotidp<?php echo $k ; ?>">I've tried this pain.</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group form_fild_row">
											<?php $efficacy = array('1' =>'helped a lot', '2' =>'helped a little', '3' =>"didn't help at all")?>
												<select class="form-control <?= !empty($k_exst) && $k_exst === true ? '' : 'on_load_display_none_cls' ?>"  name="chronic_pain_past_treat_history[<?= $k ?>][pain]" required="required">
	        							<option value="">How much did it help ?</option>
							        	<?php
							     			$start_rate = 1;
								        	foreach($efficacy as $key => $value){
								        		echo "<option value='".$key."'".(isset($old_chronic_pain_past_treat_history[$k]) && $old_chronic_pain_past_treat_history[$k] == $key ? 'selected' : '').">".$value."</option>";
								        	}
							        	?>
		    						</select>

										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } } ?>
				</div>
			</div>
	<?php }?>
	<?php
	break;
	default:
	break;
}
}
}
?>
						<div class="back_next_button">
						<ul>

						<li>
						<button id="chronic_treatment_history-backbtn" type="button" class="btn nofillborder">Previous tab</button>
						</li>
						<li style="float: right;margin-left: auto;">
						<button type="submit" class="btn" name="sub_tab_name" value="Treatment history">Next</button>
						</li>
						</ul>
						</div>

						</div>
						<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
						<input type="hidden" name="tab_number" value="20">
						<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
						<?php $this->Form->end();
						}
						}
						?>

						<?php if(in_array('Opioid overdose risk', $chronicPainAssessment)){
						if($active_sub_tab == 'Opioid overdose risk'){

						echo $this->Form->create(null , array('autocomplete' => 'off',
						'inputDefaults' => array(
						'label' => false,
						'div' => false,
						),'enctype' => 'multipart/form-data', 'id' => 'form_tab_20_overdose_risk'));
						?>
						<div class="tab-pane fade <?php echo $active_sub_tab == 'Opioid overdose risk' ? 'show active' : ''; ?>" id="other" role="tabpanel" aria-labelledby="other-tab">

						<?php
						$i = 0;
						$ic = 0;
						$cb_class = '';
						$old_chronic_cad_detail = '';

						if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk))
						$old_chronic_pain_opioid_overdose_risk = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk), SEC_KEY));

						if(!empty($cronic_pain_opioid_overdose_risk_question)){
						foreach ($cronic_pain_opioid_overdose_risk_question as $key => $value) {

						$old_val = !empty($old_chronic_pain_opioid_overdose_risk[$value->id]) ? $old_chronic_pain_opioid_overdose_risk[$value->id] : '';

						$old_dqid_val = '';
						switch ($value->question_type)
						{
						case 0:	?>
						<div class="col-md-12 <?php echo $value->id == 194 ? 'opioid_overdose_risk_question_193_194 display_none_at_load_time' : ''; ?><?php echo $value->id == 195 ? 'opioid_overdose_risk_question_193_195 display_none_at_load_time' : ''; ?>">
						<div class="form-group form_fild_row">
						<label>
						<?= $value->question ?>&nbsp;<span class="required">*</span>
						</label>
						<input type="text" value="<?= $old_val ?>" class="form-control <?php echo 'opioid_overdose_question_'.$value->id; ?>"  name="chronic_pain_opioid_overdose_risk[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
						</div>
						</div>

						<?php
						break;
						case 1:
						?>
						<div class="col-md-12">
						<div class="form-group form_fild_row">
						<div class="radio_bg">
						<label><?= $value->question ?>
						&nbsp;<span class="required">*</span></label>
						<div class="radio_list">
						<?php
						$options = unserialize($value->options) ;
						foreach ($options as $k => $v)
						{
						?>
						<div class="form-check">
						<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_overdose_risk_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_pain_opioid_overdose_risk[<?= $value->id ?>]"  required="true">
						<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
						</div>
						<?php
						$i++ ;
						}
						?>
						</div>
						</div>
						</div>
						</div>
						<?php
						break;

						case 3:
						?>
						<div class="col-md-12">
						<div class="form-group form_fild_row <?php echo $value->id == 192 ? 'chronic_overdose_risk_question_191_192 display_none_at_load_time' : '' ?>">
						<label>
						<?= $value->question ?>

						<?php  $options = unserialize($value->options) ; ?>

						<?php if(isset($options[0]) && !empty($value->question)){ ?>
						<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">

						<i class="fa fa-question-circle" aria-hidden="true"></i></a>
						<span class="required">*</span>
						<?php } ?>
						</label>
						<select class="form-control" name="chronic_pain_opioid_overdose_risk[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">
						<?php

											foreach ($options as $ky => $ve) {
						 	echo "<option value='".$ky."'".((string)$old_val == (string)$ky ? 'selected' : '').">".$ve."</option>";
						} ?>
										?>
									</select>
								</div>
							</div>
							<?php
							break;

						case 2:

	?>
	<div class="col-md-12">
		<div class="form-group form_fild_row <?= ($value->id == 168) ? 'new_appoint_checkbox_quest_a' : '' ?>">
			<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
			<div class="<?= ($value->id == 168) ? 'new_appoint_checkbox_quest' : '' ?>">
				<span></span>
				<?php
				$options = unserialize($value->options) ;


				$temp_old_dqid_val = array();
				$old_36_37_38 = array();
				if(is_array($old_val)){
					foreach ($old_val as $kdq => $vdq) {
							$temp_old_dqid_val[$vdq] = $vdq;
					}
				}
				$old_val = $temp_old_dqid_val;
				foreach ($options as $ky => $val) {
					?>
					<div class="check_box_bg">
						<div class="custom-control custom-checkbox">
							<input <?= is_array($old_val) && array_key_exists($val, $old_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="chronic_pain_opioid_overdose_risk[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_val[$val]) ? $old_val[$val] : $val ?>" fixval="<?= $val ?>" subques="<?= !empty($old_val[$val]) ? $old_val[$val] : '' ?>" type="checkbox" >
							<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
						</div>
					</div>

					<?php
					$ic++;
				}
				?>
			</div>
		</div>
	</div>
	<?php if($value->id == 168){ ?>
		<div class="col-md-12 health_condition_section">
		</div>
	<?php } ?>

	<?php
	break;
	default:
	break;

							}
															}
														}
								  					?>

	  											<div class="back_next_button">
													<ul>

															<li>
																<button id="chronic_opioid_overdose_risk-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															</li>

													 	<li style="float: right;margin-left: auto;">
													  		<button type="submit" class="btn" name="sub_tab_name" value="Opioid overdose risk">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="20">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
										<?php $this->Form->end();
										} }?>

									   <?php if(in_array('Opioid risk tool', $chronicPainAssessment)){
								   		if($active_sub_tab == 'Opioid risk tool'){
									   		echo $this->Form->create(null , array('autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,
												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_20_opioid_risk_tool'));
								   	?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'Opioid risk tool' ? 'show active' : ''; ?>" id="ort" role="tabpanel" aria-labelledby="ort-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_cad_detail = '';

												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_ort))
									                $old_chronic_pain_assessment_ort = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->chronic_pain_assessment_ort), SEC_KEY));

							  					if(!empty($cronic_pain_assessment_ort_question)){
													foreach ($cronic_pain_assessment_ort_question as $key => $value) {

														$old_val = !empty($old_chronic_pain_assessment_ort[$value->id]) ? $old_chronic_pain_assessment_ort[$value->id] : '';

																					$old_dqid_val = '';
																					switch ($value->question_type)
																					{
																						case 1:
																						?>
																						<div class="col-md-12">
																							<div class="form-group form_fild_row">
																								<div class="radio_bg">
																									<label><?= $value->question ?>
																									&nbsp;<span class="required">*</span></label>
																									<div class="radio_list">
																										<?php
																										$options = unserialize($value->options) ;
																										foreach ($options as $k => $v)
																										{
																											?>
																											<div class="form-check">
																												<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?>" id="radio_question<?= $i ?>" name="chronic_pain_assessment_ort[<?= $value->id ?>]"  required="true">
																												<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
																											</div>
																											<?php
																											$i++ ;
																										}
																										?>
																									</div>
																								</div>
																							</div>
																						</div>
																						<?php
																						break;
																							case 2:

																							?>
																							<div class="col-md-12">
																								<div class="form-group form_fild_row <?= ($value->id == 168) ? 'new_appoint_checkbox_quest_a' : '' ?>">
																									<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
																									<div class="<?= ($value->id == 168) ? 'new_appoint_checkbox_quest' : '' ?>">
																										<span></span>
																										<?php
																										$options = unserialize($value->options) ;
																										$temp_old_dqid_val = array();
																										$old_36_37_38 = array();
																										if(is_array($old_val)){
																											foreach ($old_val as $kdq => $vdq) {
																												if(($pos = stripos($vdq, '-')) !== false){
																													$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);

																													$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																												}else{
																													$temp_old_dqid_val[$vdq] = $vdq;
																												}
																											}
																										}
																										$old_val = $temp_old_dqid_val;
																										foreach ($options as $ky => $val) {
																											?>
																											<div class="check_box_bg">
																												<div class="custom-control custom-checkbox">
																													<input <?= is_array($old_val) && array_key_exists($val, $old_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="chronic_pain_assessment_ort[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_val[$val]) ? $old_val[$val] : $val ?>" fixval="<?= $val ?>" subques="<?= !empty($old_36_37_38[$val]) ? $old_36_37_38[$val] : '' ?>" type="checkbox" >
																													<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
																												</div>
																											</div>

																											<?php
																											$ic++;
																										}
																										?>
																									</div>
																								</div>
																							</div>
																							<?php
																							break;
																							default:
																							break;
																						}
															}
														}
								  					?>

	  											<div class="back_next_button">
													 <ul>

															<li>
																<button id="chronic_opioid_risk_tool-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															</li>

													 	<li style="float: right;margin-left: auto;">
													  		<button type="submit" class="btn" name="sub_tab_name" value="Opioid risk tool">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="20">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
										<?php $this->Form->end();
										}}?>


								</div>
							</div>
				   </div>
					<?php
						$i = 0 ;
						$cb_class = '';
					?>
			   </div>
	   <!-- End Pain management -->
<script type="text/javascript">

	$(document).on("click", "input[type='checkbox'].chronic_pain_assessment_ques_170", function () {

	 var checkval = $(this).val();
	 checkvalClass = checkval.replace(/[&\/\\#, +()$~%.'":*?<>{}]/g,"_");
		if($(this).prop("checked") == true)
		{
			//chornic_assessment_170_1
			//$('.chronic_pain_assessment_health_condtion_html .condition_name label').text(checkval);
			//var data = $('.chronic_pain_assessment_health_condtion_html').html();
			//data = "<div class = 'row health_condtion "+checkvalClass+"'>"+data+"</div>";
			//$('.health_condition_section').append(data);
		}else{
			//$('.health_condition_section .health_condtion.'+checkvalClass).remove();
		}
	});

</script>
<script type="text/javascript">

	$(document).on("click", "input[type='checkbox'].chronic_pain_assessment_ques_168", function () {

			var checkval = $(this).val();
			alert(checkval);
		if($(this).prop("checked") == true)
		{
			$('.chronic_pain_assessment_health_condtion_html .condition_name label').text(checkval);
			var data = $('.chronic_pain_assessment_health_condtion_html').html();

			console.log(data);
			data = "<div class = 'row health_condtion "+checkval+"'>"+data+"</div>";
			$('.health_condition_section').append(data);
		}else{

			$('.health_condition_section .health_condtion.'+checkval).remove();
		}
	});

</script>
<script type="text/javascript">
	var date = new Date();
	$('#question_44').timepicker();
	$('#question_89').timepicker();
	$('#question_65').datepicker({maxDate: date});
	$('#question_105').datepicker({maxDate: date});




$('select').on('change', function() {
	if($(this).val())
		$(this).css('background','#fff');
	else
		$(this).css('background','#ececec');
  // if($(this).val())
});



$( document ).ready(function() {
    $( ".trigger_click_if_checked" ).trigger("click"); // trigger click event on the checked radio buttom so that its child question made visible .
});

$(document).on("click", "input[type='radio'].check_did_you_try_medication", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'No') {
        	$('.question_13_14').val('');
        	// $('#radio_question7').attr('disabled',true);
        	// $('#radio_question8').attr('disabled',true);
            $('.question_13_14').hide();
        }else{
        	// $('#radio_question7').attr('disabled',false);
        	// $('#radio_question8').attr('disabled',false);
        	$('.question_13_14').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].detail_question_146", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'about the same') {
        	$('.detail_question_146_147').val('');
        	$('.detail_question_146_148').val('');

            $('.detail_question_146_147').hide();
            $('.detail_question_146_148').hide();
        }else if($(this).val() == 'better'){

        	$('.detail_question_146_147').hide();
        	$('.detail_question_146_148').removeClass('display_none_at_load_time').show();


        }
        else if($(this).val() == 'worse'){

        	$('.detail_question_146_148').hide();
        	$('.detail_question_146_147').removeClass('display_none_at_load_time').show();

        }
    }
});



$(document).on("click", "input[type='radio'].detail_question_122", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'morning') {

            $('.detail_question_122_123').hide();
        }else{

        	$('.detail_question_122_123').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_133", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'morning') {

            $('.detail_question_133_134').hide();
        }else{

        	$('.detail_question_133_134').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].detail_question_142", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'morning') {

            $('.detail_question_142_143').hide();
        }else{

        	$('.detail_question_142_143').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].detail_question_117", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'No') {

            $('.detail_question_117_118').hide();
        }else{

        	$('.detail_question_117_118').removeClass('display_none_at_load_time').show();


        }
    }
});



$(document).on("click", "input[type='radio'].detail_question_106", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'Both') {

            $('.detail_question_106_107').hide();
        }else{

        	$('.detail_question_106_107').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].detail_question_127", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'Both') {

            $('.detail_question_127_128').hide();
        }else{

        	$('.detail_question_127_128').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_135", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'Both') {

            $('.detail_question_135_136').hide();
        }else{

        	$('.detail_question_135_136').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].detail_question_110", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'Suddenly') {

            $('.detail_question_110_111').hide();
            $('.detail_question_111_112').hide();
        }else{

        	$('.detail_question_110_111').removeClass('display_none_at_load_time').show();


        }
    }
});




$(document).on("click", "input[type='radio'].take_exercise", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'No') {
        	//$('.question_13_14').val('');
            $('.time_exercise').hide();
        }else{
        	$('.time_exercise').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].question_73", function () {
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'No') {
        	//$('.question_13_14').val('');
            $('.question_74').hide();
            $('.question_75').hide();
            // $('#radio_question2').attr('disabled',true);
            // $('#radio_question3').attr('disabled',true);
            // $('#radio_question4').attr('disabled',true);
        }else{

        	// $('#radio_question2').attr('disabled',false);
         //    $('#radio_question3').attr('disabled',false);
         //    $('#radio_question4').attr('disabled',false);
        	$('.question_74').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].question_88", function () {
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'No') {
        	//$('.question_13_14').val('');
            $('.question_89').hide();
            $('.question_90').hide();

        }else{

        	$('.question_89').removeClass('display_none_at_load_time').show();
        	$('.question_90').removeClass('display_none_at_load_time').show();


        }
    }
});

/*$(document).on("change", "#question_76", function () {
	var value = $.trim($(this).val());
	//alert(value);
	if(value == undefined || value == ''){
		$('.question_77').hide();

	}else{

		$('.question_77').removeClass('display_none_at_load_time').show();
	}
});*/

$(document).on("click", "input[type='radio'].question_74", function () {
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'Liquids only') {

        	$('.question_75').removeClass('display_none_at_load_time').show();

        }else{

        	$('.question_75').hide();
        }
    }
});




$(document).on("click", "input[type='radio'].question_78", function () {
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'No') {
        	//$('.question_13_14').val('');
            $('.question_79').hide();
            $('#question_79').attr('disabled',true);

        }else{

        	$('#question_79').attr('disabled',false);
        	$('.question_79').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].stay_hospital", function () {
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'No') {

        	// $('#question_64').attr('disabled','true');
        	// $('#question_65').attr('disabled','true');
        	// $('#question_66').attr('disabled','true');
        	// $('#question_67').attr('disabled','true');
        	// $('#radio_question2').attr('disabled','true');
        	// $('#radio_question3').attr('disabled','true');
        	// $('#radio_question4').attr('disabled','true');
            $('.stay_hospital_que').hide();

        }else{
        	//alert('fdf');
        	/*$('#question_64').attr('disabled','false');
        	$('#question_65').attr('disabled','false');
        	$('#question_66').attr('disabled','false');
        	$('#question_67').attr('disabled','false');
        	$('#question_68').attr('disabled','false');
        	$('#radio_question2').attr('disabled','false');
        	$('#radio_question3').attr('disabled','false');
        	$('#radio_question4').attr('disabled','false'); */
        	// $('#question_64').removeAttr('disabled');
        	// $('#question_65').removeAttr('disabled');
        	// $('#question_66').removeAttr('disabled');
        	// $('#question_67').removeAttr('disabled');
        	// $('#question_68').removeAttr('disabled');
        	// $('#radio_question2').removeAttr('disabled');
        	// $('#radio_question3').removeAttr('disabled');
        	// $('#radio_question4').removeAttr('disabled');
        	$('.stay_hospital_que').removeClass('display_none_at_load_time').show();


        }
    }
});

$(document).on("click", "input[type='radio'].travel_pain", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'No') {
        	//$('.question_13_14').val('');
            $('.travel_pain_from').hide();
        }else{
        	$('.travel_pain_from').removeClass('display_none_at_load_time').show();


        }
    }
});


$(document).on("click", "input[type='radio'].nps", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'No') {
        	//$('.question_13_14').val('');
            $('.number_of_nps').hide();
        }else{
        	$('.number_of_nps').removeClass('display_none_at_load_time').show();


        }
    }
});



$(document).on("click", "input[type='radio'].check_which_is_worse", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'Both') {
        	$('.question_16_17').val('');
            $('.question_16_17').hide();
        }else{
        	$('.question_16_17').removeClass('display_none_at_load_time').show();

        }
    }
});


$(document).on("click", "input[type='radio'].which_joint_cls", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() != 'Joints') {
        	$('.question_34_35').val('');
            $('.question_34_35').hide();
        }else{
        	$('.question_34_35').removeClass('display_none_at_load_time').show();

        }
    }
});



$(document).on("click", "input[type='radio'].check_any_accident", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'No') {
        	$('.question_26_27').val('');
            $('.question_26_27').hide();
        }else{
        	$('.question_26_27').removeClass('display_none_at_load_time');
            $('.question_26_27').show();

        }
    }
});


$(document).on("change", "input[type='checkbox'].check_radiating_option", function () {

var rad_flag = false;
  $( "input[type='checkbox'].check_radiating_option" ).each(function( index, element ) {

  	if($(element).is(':checked') && $(element).val() == 'Radiating'){

    	 rad_flag = true;
  	}
  });


        if (!rad_flag) {
        	$('.question_39_40').val('');
            $('.question_39_40').hide();
        }else{
        	$('.question_39_40').removeClass('display_none_at_load_time');
            $('.question_39_40').show();

        }

});



/*$(document).on("click", "input[type='checkbox'].detail_question_111", function () {
    if($(this).is(':checked')) {
    	// alert($(this).val());
        if ($(this).val() == 'fall') {

            $('.detail_question_111_112').hide();
        }else{

        	$('.detail_question_111_112').removeClass('display_none_at_load_time').show();


        }
    }
});*/


$(document).on("change", "input[type='checkbox'].detail_question_111", function () {

var rad_flag = false;
  $( "input[type='checkbox'].detail_question_111" ).each(function( index, element ) {

  	if($(element).is(':checked') && $(element).val() == 'fall'){

    	 rad_flag = true;
  	}
  });


        if (!rad_flag) {
            $('.detail_question_111_112').hide();
        }else{
        	$('.detail_question_111_112').removeClass('display_none_at_load_time');
            $('.detail_question_111_112').show();

        }

});



$(document).on("change", "input[type='checkbox'].question_93", function () {

var rad_flag = false;
  $( "input[type='checkbox'].question_93" ).each(function( index, element ) {

  	//alert($(element).val());

  	if($(element).is(':checked') && $(element).val() == 'Radiating'){

    	 rad_flag = true;
  	}
  });


        if (!rad_flag) {

        	// $('#checkbox7').attr('disabled',true);
        	// $('#checkbox8').attr('disabled',true);
        	// $('#checkbox9').attr('disabled',true);
        	// $('#checkbox10').attr('disabled',true);
        	// $('#checkbox11').attr('disabled',true);
        	//$('#checkbox12').attr('disabled',true);

            $('.question_94').hide();
        }else{

        	// $('#checkbox7').attr('disabled',false);
        	// $('#checkbox8').attr('disabled',false);
        	// $('#checkbox9').attr('disabled',false);
        	// $('#checkbox10').attr('disabled',false);
        	// $('#checkbox11').attr('disabled',false);
        	//$('#checkbox12').attr('disabled',false);

        	$('.question_94').removeClass('display_none_at_load_time').show();
           // $('.question_94').show();

        }

});

$(document).ready(function () {

var rad_flag = false;
  $( "input[type='checkbox'].question_93" ).each(function( index, element ) {

  	//alert($(element).val());

  	if($(element).is(':checked') && $(element).val() == 'Radiating'){

    	 rad_flag = true;
  	}
  });


        if (!rad_flag) {

        	// $('#checkbox7').attr('disabled',true);
        	// $('#checkbox8').attr('disabled',true);
        	// $('#checkbox9').attr('disabled',true);
        	// $('#checkbox10').attr('disabled',true);
        	// $('#checkbox11').attr('disabled',true);
        	//$('#checkbox12').attr('disabled',true);

            $('.question_94').hide();
        }else{

        	// $('#checkbox7').attr('disabled',false);
        	// $('#checkbox8').attr('disabled',false);
        	// $('#checkbox9').attr('disabled',false);
        	// $('#checkbox10').attr('disabled',false);
        	// $('#checkbox11').attr('disabled',false);
        	//$('#checkbox12').attr('disabled',false);

        	$('.question_94').removeClass('display_none_at_load_time').show();
           // $('.question_94').show();

        }

});


$(document).on("click", "input[type='checkbox'].detail_question_95", function () {
	//console.log('dfdsf');
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'No') {

        	var id = $(this).attr('id');
        	//alert(".detail_question_95 #"+id);
        	//alert("input[type='checkbox'].detail_question_95 #"+id);
        	$(".detail_question_95").prop("checked", false);
        	$(".detail_question_95#"+id).prop("checked", true);

        }else{


        	$('.detail_question_95').each(function(index, value){

        		if($(this).val() == 'No'){

        			$(this).prop("checked", false);
        		}
        	})


        }
    }
});

$(document).on("click", "input[type='checkbox'].detail_question_155", function () {
	//console.log('dfdsf');
    if($(this).is(':checked')) {
    	//alert($(this).val());
        if ($(this).val() == 'All over') {

        	var id = $(this).attr('id');
        	$(".detail_question_155").prop("checked", false);
        	$(".detail_question_155#"+id).prop("checked", true);

        }else{


        	$('.detail_question_155').each(function(index, value){

        		if($(this).val() == 'All over'){

        			$(this).prop("checked", false);
        		}
        	})


        }
    }
});

$(document).on("click", "input[type='checkbox'].detail_question_111", function () {

	//var class_name = $(this).data('class_name');
	if($(this).is(':checked') && $(this).val() == "I don't know"){

		 $("input[type='checkbox'].detail_question_111").prop('checked', false);
		 $(this).prop('checked',true);
	}
	else
	{
		$("input[type='checkbox'].detail_question_111").each(function(index, element){

			if($(element).is(':checked') && $(element).val() == "I don't know"){

				$(this).prop('checked',false);
			}
		});
	  	//$('.'+class_name).hide();
	}

});




</script>


			   <!-- <div class="back_next_button">
				<ul>
				<li>
					<?php if($user_detail['current_step_id'] == 7){ ?>
						<button id="other_detail-tab-backbtn" type="button" class="btn">Previous Tab</button>
					<?php } else{ ?>
						<button id="profile-tab-backbtn" type="button" class="btn">Previous Tab</button>
					<?php } ?> -->
				  <!-- <button id="profile-tab-backbtn" type="button" class="btn">Go to previous tab</button> -->
			     <!-- </li>
				 <li style="float: right;">
				  <button type="submit" class="btn details_next">Next</button>
				 </li>



				</ul>
			   </div> -->
			  <!-- <div class="back_next_button">
				<ul>
				 <li>
				  <button id="profile-tab-backbtn" type="button" class="btn">Go to previous tab</button>
			     </li>
				</ul>
			   </div> -->



			  </div>
			 </div>
	<!-- pass the current chief compliant as hidden value for which we are asking the questions -->
 		<!-- <input type="hidden" name="cur_detail_tab_chief_compliant" value="<?php if(!empty($cur_detail_tab_chief_compliant)) echo $cur_detail_tab_chief_compliant ?>">


		  <input type="hidden" name="next_steps" value="<?= $next_steps ?>">

			 <input type="hidden" name="tab_number" value="2">
			 <input type="hidden" name="step_id" value="<?php echo $step_id ; ?>"> -->
   <?php //$this->Form->end();

}
   ?>

  <script type="text/javascript">

    $("#form_tab_2").validate({

    	rules: {
            'details_question[38][]': {
                required: true,
                minlength: 1
            },
            'details_question[2][]': {
                required: true,
                minlength: 1
            },
            'details_question[39][]': {
                required: true,
                minlength: 1
            },
            'details_question[36][]': {
                required: true,
                minlength: 1
            },
            'details_question[37][]': {
                required: true,
                minlength: 1
            },
            'details_question[30][]': {
                required: true,
                minlength: 1
            },
            'details_question[19][]': {
                required: true,
                minlength: 1
            },
            'details_question[23][]': {
                required: true,
                minlength: 1
            },
            'details_question[54][]': {
                required: true,
                minlength: 1
            },
            'details_question[42][]': {
                required: true,
                minlength: 1
            }

        },
	ignore: ':hidden:not(.do_not_ignore)',
  	showErrors: function(errorMap, errorList) {
  		  	if(errorList.length>0){
        		$("#form_tab_2 div.errorHolder").addClass(' alert alert-danger').html("All fields must be completed before you submit the form.");
    		}
 	},
 	submitHandler: function(form) {
            form.submit();
            loading();
            homeLoader.hide();

        }

});


</script>

<?php
if(in_array(22, $current_steps) && $tab_number == 22){

	$old_focused_history = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->focused_history_detail))

		$old_focused_history = $user_detail_old->chief_compliant_userdetail->focused_history_detail ;
		$ic = 1;
     	 echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_22')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==22  || 22==$current_steps[0])  ? '  show active ' : '' ?>" id="focused_history" role="tabpanel" aria-labelledby="focused_history-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">

			   <h3>
			   	Focused History
			   	<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
			   <div class="row">
			   </div>
			</div>
				<?php
						$i = 0 ;
						$cb_class = '';
						if(!empty($focusStory_question)){
							foreach ($focusStory_question as $key => $value) {

								$old_focsedh_val = !empty($old_focused_history) && isset($old_focused_history[$value->id]['answer']) && !empty($old_focused_history[$value->id]['answer']) ? $old_focused_history[$value->id]['answer'] : '';
								//die('fdfd');
								switch ($value->question_type) {
											case 0:

											//show the question 218 for female only
										    /*if($login_user['gender'] != 0 && ( $value->id == 220 || $value->id == 222)){

										    	continue;
										    }*/
											?>

											<div class="col-md-12 <?php echo $value->id == 220 ? 'display_none_at_load_time focused_history_219_220' : '';?>  <?php echo $value->id == 222 ? 'display_none_at_load_time focused_history_221_222' : '';?>">
					 								<div class="form-group form_fild_row">
					 									<?= $value->question ?>
					 									<?php if($value->id != 220 && $value->id != 222){?>&nbsp;<span class="required">*</span> <?php } ?>
														<input type="number" pattern="[0-9]*" inputmode="numeric"  value="<?= $old_focsedh_val ?>" class="form-control"  name="focused_history[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'focused_history_'.$value->id; ?>"/>
													</div>
												</div>

										   <?php
										   		break;
										    case 1:

										    //show the question 218 for female only
										    if($login_user['gender'] != 0 && ($value->id == 218)){

										    	continue;
										    }
										?>

									<div class="col-md-12">
										<div class="form-group form_fild_row">
 											<div class="radio_bg">
	          									<label><?= $value->question ?>
	          									&nbsp;<span class="required">*</span></label>

												<div class="radio_list">
												<?php
													$options = unserialize($value->options) ;

													foreach ($options as $k => $v) {
														?>
        												<div class="form-check">
         													<input type="radio"  value="<?= $v ?>" <?= $old_focsedh_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo 'focused_history_'.$value->id; ?> <?php echo $old_focsedh_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo $value->id == 561 ? "is_check_allergy_his" : ""?>" id="radio_question<?= $i ?>" name="focused_history[<?= $value->id ?>]"  required="true">
         													<label class="form-check-label" for="radio_question<?= $i ?>">
         														<?= $v ?>
         													</label>
       													</div>
													<?php
														$i++ ;
													}
													?>
												</div>
   											</div>
				 						</div>
									</div>


								<?php
									break;
									//die('sfdf');

									case 2:
						?>
							<div class="col-md-12">
					 			<div class="form-group form_fild_row <?= ($value->id == 212 || $value->id == 213) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 					<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 					<div class="<?= ($value->id == 212 || $value->id == 213) ? 'new_appoint_checkbox_quest' : '' ?>">
					 						<span></span>
					 						<?php
					 							$options = unserialize($value->options) ;

					 							$health_condtion_options = null;
					 							if($value->id == 212){

					 								$health_condtion_options = $options;
					 							}
					 							?>
										<?php

											foreach ($options as $ky => $val) {
			 							?>

												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_focsedh_val) && in_array($val, $old_focsedh_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo $value->id == 212 ? 'focused_history_212': ''; ?>"  name="<?php if($value->id ==212){ ?>focused_history[<?= $value->id ?>][<?= $ky ?>] <?php }else{ ?>focused_history[<?= $value->id ?>][] <?php } ?>"  id="checkbox<?= $ic ?>" value="<?= $val ?>" fixval="<?= $val ?>" type="checkbox" <?php if($value->id !=212){ ?>required="required" <?php } ?> >
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>

			 								<?php
			 									$ic++;
					 						}

					 						?>
										</div>
					 				</div>
								</div>
							<?php

							if($value->id == 212){ ?>

							<div class="health_conditions_members">

								<?php if(!empty($health_condtion_options)){

									$health_condtion_members_options = array(

										1 => 'Father',
										2 => 'Mother',
										3 => 'Paternal grandmother',
										4 => 'Paternal grandfather',
										5 => 'Maternal grandmother',
										6 => 'Maternal grandfather',
										7 => 'Brother',
										8 => 'Sister',
										9 => 'Son',
										10 => 'Daughter'
									);

									$health_condtion_translate = array(

										'Asthma' => 'asthma',
										'Heart disease (coronary artery disease)' => 'cad',
										'High blood pressure (hypertension)' => 'hbp',
										'Diabetes' => 'diabetes'
									);
									$hc_count = 1;

									foreach ($health_condtion_options as $hc_key => $hc_value) { ?>

										<div class="col-md-12 <?php echo "health_condtion_".$health_condtion_translate[$hc_value]; ?> display_none_at_load_time">
											<div class="form-group form_fild_row new_appoint_checkbox_quest_a">
												<label>Who has the <?php echo $hc_value; ?>?&nbsp;<span class="required">*</span></label>
												<div class="new_appoint_checkbox_quest">
													<span></span>
													<?php
														foreach ($health_condtion_members_options as $hcm_key => $hcm_value) {

															?>

															<div class="check_box_bg">
					 											<div class="custom-control custom-checkbox">
			          												<input <?= isset($old_focsedh_val['members']) && isset($old_focsedh_val['members'][$hc_key]) && is_array($old_focsedh_val['members'][$hc_key]) && isset($old_focsedh_val['members'][$hc_key]) && in_array($hcm_value, $old_focsedh_val['members'][$hc_key])   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?>"  name="focused_history[<?= $value->id ?>][members][<?= $hc_key ?>][]"  id="health_condition_member_checkbox<?= $hc_count ?>" value="<?= $hcm_value ?>" fixval="<?= $hcm_value ?>" type="checkbox" required="required" >
			          												<label class="custom-control-label" for="health_condition_member_checkbox<?= $hc_count ?>"><?= $hcm_value ?></label>
			         									</div>
					 										</div>
														<?php $hc_count++; }
													 ?>
												</div>
											</div>
										</div>
									<?php  }
								} ?>
							</div>

							<?php }
							break;
								}
							}
						}
						?>
			</div>

			<div class="back_next_button">
			<ul>
				<li>
					<button id="psychiatry_focused-tab-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
			  </li>

			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>



			</ul>
		   </div>
		 <input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="22">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
  <?php $this->Form->end() ; ?>

  <?php
  } ?>

  <?php

	if(in_array(23, $current_steps) && $tab_number == 23){

		$reading_timing_arr = array(

	          "" => "Reading timing",
	          1 => 'Before breakfast',
	          2 => 'Before lunch',
	          3 => 'Before dinner',
	          4 => "Bedtime",
	          5 => 'After exercise',
	          6 => 'After a meal'
	        );

		$peakflow_reading_timing_arr = array(

	          "" => "Reading timing",
	          'morning' => 'Morning',
	          'afternoon' => 'Afternoon'
	        );

		/*$family_relation = ['father'=>'Father', 'mother'=>'Mother', 'grandmother (dad-side)'=>'Grandmother (Dad-side)', 'grandfather (dad-side)'=>'Grandfather (Dad-side)', 'grandmother (mom-side)'=>'Grandmother (Mom-side)', 'grandfather (mom-side)'=>'Grandfather (Mom-side)', 'brother'=>'Brother', 'sister'=>'Sister', 'son'=>'Son', 'daughter'=>'Daughter'];*/

		$family_relation = [1=>'Father', 2=>'Mother', 3=>'Grandmother (Dad-side)', 4=>'Grandfather (Dad-side)', 5=>'Grandmother (Mom-side)', 6=>'Grandfather (Mom-side)', 7=>'Brother', 8=>'Sister', 9=>'Son', 10=>'Daughter'];


		$chronicCondition_trans = array('cad' =>'Coronary artery disease','chf' =>'Congestive heart failure','copd' =>'Chronic obstructive pulmonary disease','dmii' =>'Diabetes','htn'=>'Hypertension','other' =>'Other');


		// $im_active_sub_tab = 'general';
		// if(!empty($user_detail_old->chief_compliant_userdetail->im_active_sub_tab))
		// $im_active_sub_tab = $user_detail_old->chief_compliant_userdetail->im_active_sub_tab;
		// $i= 0;

		$old_chronic_condition = array();
		if(!empty($user_detail_old->chief_compliant_userdetail->chronic_condition))
			$old_chronic_condition = $user_detail_old->chief_compliant_userdetail->chronic_condition;

		//pr($old_chronic_condition);

		//remove the other condition
	    if(($temp_cond_key = array_search('other', $old_chronic_condition)) !== false){

	    	//pr($temp_cond_key);
	      unset($old_chronic_condition[$temp_cond_key]);
	    }

	    $is_show_potassium_opt = 0;
	    //show high potassium option for cad, htn, chf

	    if(!empty($old_chronic_condition)){

	    	if(in_array("cad", $old_chronic_condition) || in_array("chf", $old_chronic_condition) || in_array("htn", $old_chronic_condition)){

	    		$is_show_potassium_opt = 1;
	    	}
	    }

		$i= 0;
     	  ?>

		  	<div class="tab-pane fade  <?= ($tab_number==23  || 23==$current_steps[0])  ? '  show active ' : '' ?>" id="chronic_assessment" role="tabpanel" aria-labelledby="chronic_assessment-tab">

				<div class="errorHolder">
  				</div>

			  	<div class="TitleHead">
			   		<!-- <h3>Have you had any of these symptoms in the past month?&nbsp;<span class="required">*</span></h3> -->
			   		<div class="seprator"></div>
			  	</div>

			  	<div class="tab_form_fild_bg question_symptom_newapp">
			  		<?php //echo $active_sub_tab; ?>
			   		<div class="row">
						<div class="col-md-12">
				 			<div class="form-group form_fild_row">
								<ul class="nav nav-tabs" id="myTab222" role="tablist">
									<?php if(in_array($step_id, [25,28])){?>
			  									<!-- <li class="nav-item">
			  										<?php
														echo $this->Form->postLink(
															    "post link", // first
															    null,  // second
															    ['data' => ['edited_sub_tab' => 'general_tap','edited_tab' => 23], 'id' => 'general-assessment-tabpostlink'] // third
															);
			   											?>
			    									<a class="nav-link current_sub_tab <?php echo $active_sub_tab == 'general_tap' ? 'active' : ''; ?>" id="general-assessment-tab" data-toggle="tab" href="#general-assessment" role="tab" aria-controls="general-assessment" aria-selected="false">Gen</a>
			  									</li> -->
			  									<!-- <li class="nav-item">
			  										<?php
															echo $this->Form->postLink(
															    "post link", // first
															    null,  // second
															    ['data' => ['edited_sub_tab' => 'taps1','edited_tab' => 23], 'id' => 'taps1-assessment-tabpostlink'] // third
															);
			   											?>
			    									<a class="nav-link current_sub_tab <?php echo $active_sub_tab == 'taps1' ? 'active' : ''; ?>" id="taps1-assessment-tab" data-toggle="tab" href="#taps1-assessment" role="tab" aria-controls="taps1" aria-selected="false">TAPS-1 (12 M)</a>
			  									</li>
			  									<?php if(empty($is_tap2)){ ?>
			  									<li class="nav-item">
			  										<?php
															echo $this->Form->postLink(
															    "post link", // first
															    null,  // second
															    ['data' => ['edited_sub_tab' => 'taps2','edited_tab' => 23], 'id' => 'taps2-assessment-tabpostlink'] // third
															);
			   											?>
			    									<a class="nav-link current_sub_tab <?php echo $active_sub_tab == 'taps2' ? 'active' : ''; ?>" id="taps2-assessment-tab" data-toggle="tab" href="#taps2-assessment" role="tab" aria-controls="taps2" aria-selected="false">TAPS-2 (3 M)</a>
			  									</li> -->
			  								<?php } ?>
									<?php } ?>


									<?php
										if(!empty($old_chronic_condition)){
											if(($temp_key = array_search('other', $old_chronic_condition)) !== false){

											      unset($old_chronic_condition[$temp_key]);
											    }
											    if(($temp_key = array_search('none', $old_chronic_condition)) !== false){

											      unset($old_chronic_condition[$temp_key]);
											    }
											//pr($old_chronic_condition);
											foreach ($old_chronic_condition as $cond_key => $cond_value) {
												$cond_value = strtolower($cond_value);
												if(in_array($step_id, [25,28]) && in_array($cond_value,['cad','htn','dmii','copd']))
												{
													if($cond_value == 'cad')
													{
														$int_cond_value = "Heart Disease";
													}
													else if($cond_value == 'htn')
													{
														$int_cond_value = "Hypertension";
													}
													else if($cond_value == 'dmii')
													{
														$int_cond_value = "Diabetes";
													}
													else if($cond_value == 'copd')
													{
														$int_cond_value = "COPD";
													}
												}
												?>

												<li class="nav-item">
			  										<?php
															echo $this->Form->postLink(
															    "post link", // first
															    null,  // second
															    ['data' => ['edited_sub_tab' => $cond_value,'edited_tab' => 23], 'id' => $cond_value.'-tabpostlink'] // third
															);
			   											?>
			    									<a class="nav-link current_sub_tab <?php echo $active_sub_tab == $cond_value ? 'active' : ''; ?>" id="<?php echo $cond_value.'-tab'; ?>" data-toggle="tab" href="#<?php echo $cond_value; ?>" role="tab" aria-controls="<?php echo $cond_value; ?>" aria-selected="false"><?php echo !empty($int_cond_value) && in_array($cond_value,['cad','htn','dmii','copd']) ? $int_cond_value :  ucfirst($cond_value); ?></a>
			  									</li>


									<?php }
									?>
												<?php if(!empty($old_chronic_condition) && $old_chronic_condition[0] != 'none' && $step_id != 25){ ?>
												<li class="nav-item">
			  										<?php
															echo $this->Form->postLink(
															    "post link", // first
															    null,  // second
															    ['data' => ['edited_sub_tab' => 'general','edited_tab' => 23], 'id' => 'chronic-general-tabpostlink'] // third
															);
			   											?>
			    									<a class="nav-link current_sub_tab <?php echo $active_sub_tab == 'general' ? 'active' : ''; ?>" id="chronic-general-tab" data-toggle="tab" href="#chronic-general" role="tab" aria-controls="general" aria-selected="false">Gen Details</a>
			  									</li>
			  								<?php } ?>

								<?php } ?>
								</ul>
							<div class="tab-content" id="myTabContent222">
								<div class="tab_content_inner">
								   	<?php if(in_array('cad', $old_chronic_condition)){

								   		if($active_sub_tab == 'cad'){
									   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_23_cad'));
								   	?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'cad' ? 'show active' : ''; ?>" id="cad" role="tabpanel" aria-labelledby="cad-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_cad_detail = '';

												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_cad_detail))
									                $old_chronic_cad_detail = $user_detail_old->chief_compliant_userdetail->chronic_cad_detail;

							  					if(!empty($choronic_cad_question)){
													foreach ($choronic_cad_question as $key => $value) {

														$old_val = !empty($old_chronic_cad_detail[$value->id]) ? $old_chronic_cad_detail[$value->id] : '';

														switch ($value->question_type) {
															case 1:
															?>
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group form_fild_row">
							 											<div class="radio_bg">
								          									<label><?= str_replace("***", "coronary artery disease", $value->question) ?>
								          									&nbsp;<span class="required">*</span></label>

																			<div class="radio_list">
																			<?php
																				$options = unserialize($value->options);

																				foreach ($options as $k => $v) {
																					?>
							        												<div class="form-check">
							         													<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_cad_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_cad_detail[<?= $value->id ?>]"  required="true">
							         													<label class="form-check-label" for="radio_question<?= $i ?>">
							         														<?= $v ?>
							         													</label>
							       													</div>
																				<?php
																					$i++ ;
																				}
																				?>
																			</div>
							   											</div>
											 						</div>
																</div>
															</div>

															<?php if($value->id == 292){

																?>
																<div class="current_cad_medicationfld_section display_none_at_load_time">

																<label>What medication are you taking for coronary artery disease?&nbsp;<span class="required">*</span></label> <!--  -->
																<?php
																	if(!empty($user_detail_old->chief_compliant_userdetail->chronic_cad_medication)){
																		$cmd_old = $user_detail_old->chief_compliant_userdetail->chronic_cad_medication;

																		foreach ($cmd_old as $ky => $ve) {

																	?>

																			<div class="row currentmedicationfld">

																			    <div class="col-md-4">
																				 	<!-- <div class="form-group form_fild_row">  -->
																						<div class="custom-drop">
																							<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
																						    <ul class="med_suggestion_listul cronic-drop-li">
																							</ul>
																						<!-- </div> -->
																					</div>
																				</div>
																				<div class="col-md-2">
																					 <!-- <div class="form-group form_fild_row"> -->
																					  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
																					 <!-- </div> -->
																					</div>

																				<div class="col-md-2">
																				<select class="form-control" name="medication_how_often[]">
																					<option value="">how often?</option>
																				<?php
																						foreach ($length_arr as $key => $value) {

																					echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

																						}
																					?>
																					</select>
																					<!-- </div> -->
																				</div>
																			    <div class="col-md-3">
																				 	<!-- <div class="form-group form_fild_row"> -->
																						<div class="custom-drop">

																							<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
																					      <ul class="how_taken_suggestion_listul custom-drop-li">
																							</ul>
																						<!-- </div> -->
																				 	</div>
																				</div>
																			<div class="col-md-1">
																		     <div class="row">

																			  <div class=" chronic_currentmedicationfldtimes">
																			   <div class="crose_year">
																			    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																			   </div>
																			  </div>
																			 </div>
																			</div>
																		   </div>
																		<?php
																			}
																		}
																		else{ ?>
																		<div class="row currentmedicationfld">
																		   <div class="col-md-4">
																		      <div class="custom-drop">
																		         <input type="text"    class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
																		         <ul class="med_suggestion_listul cronic-drop-li">
																		         </ul>
																		      </div>
																		   </div>
																		   <div class="col-md-2">
																		      <input name="medication_dose[]" type="text" class="form-control ignore_fld" placeholder="Dose"/>
																		   </div>

																		   <div class="col-md-2">
																		      <select class="form-control" name="medication_how_often[]">
																		         <option value="">how often?</option>
																		         <?php
																		            foreach ($length_arr as $key => $value) {
																		               echo "<option value=".$key.">".$value."</option>";
																		            }
																		         ?>
																		      </select>
																		   </div>
																		   <div class="col-md-3">
																		      <div class="custom-drop">
																		         <input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
																		         <ul class="how_taken_suggestion_listul custom-drop-li">
																		         </ul>
																		      </div>
																		   </div>
																		   <div class="col-md-1">
																		      <div class="row">
																		         <div class=" chronic_currentmedicationfldtimes">
																		            <div class="crose_year">
																		               <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																		            </div>
																		         </div>
																		      </div>
																		   </div>
																		</div>
																	<?php } ?>
																	<div class="row">
																	    <div class="col-md-6">
																		 <div class="form-group form_fild_row">
																		   <div class="crose_year">
																		    <button  type="button"  class="btn currentmedicationfldadd_chronic_condition btn-medium">add a medication</button>
																		   </div>
																		 </div>
																		</div>
																	</div>
																</div>

															<?php } ?>
															<?php
															break;
																}
															}
														}
								  					?>

	  											<div class="back_next_button">
													<ul>

														<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'cad'){ ?>
															<li>
															<?php if($step_id != 25){?>
																<button id="chronic_condition-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															<?php } ?>
															</li>
														<?php } ?>
													 	<li style="float: right;margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="cad">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										} ?>


									<?php if(in_array('dmii', $old_chronic_condition)){

								   		if($active_sub_tab == 'dmii'){
									   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_23_dmii'));
								   	 ?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'dmii' ? 'show active' : ''; ?>" id="dmii" role="tabpanel" aria-labelledby="dmii-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_dmii_detail = '';

												//pr($user_detail_old->chief_compliant_userdetail->chronic_dmii_detail);die;
												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_dmii_detail))
									                $old_chronic_dmii_detail = $user_detail_old->chief_compliant_userdetail->chronic_dmii_detail;

							  					if(!empty($choronic_dmii_question)){
													foreach ($choronic_dmii_question as $key => $value) {

														$old_dmii_val = !empty($old_chronic_dmii_detail[$value->id]) ? $old_chronic_dmii_detail[$value->id] : '';

														switch ($value->question_type) {

															case 0:  ?>

															<div class="row">
																<div class="col-md-12 <?php echo $value->id == 227 ? 'chronic_dmii_question_225_227 display_none_at_load_time' : '' ?> <?php echo $value->id == 236 ? 'chronic_dmii_question_235_236 display_none_at_load_time' : '' ?> <?php echo $value->id == 237 ? 'chronic_dmii_question_235_237 display_none_at_load_time' : '' ?> <?php echo $value->id == 238 ? 'chronic_dmii_question_235_238 display_none_at_load_time' : '' ?>" >
						 											<div class="form-group form_fild_row">
						 												<?=  $value->question ?>
						 												<?php if(!empty($value->question)){ ?>
						 												&nbsp;<span class="required">*</span> <?php } ?>

						 												<?php if($value->data_type == 2){ ?>

																			<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?php echo $old_dmii_val; ?>" class="form-control <?php echo 'chronic_dmii_question_'.$value->id; ?>"  name="chronic_dmii_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>
																		<?php }
																		else{ ?>

																				<input type="text" value="<?php echo $old_dmii_val; ?>" class="form-control <?php echo 'chronic_dmii_question_'.$value->id; ?>"  name="chronic_dmii_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>

																			<?php } ?>
																	</div>
																</div>
															</div>

															<?php
																break;
															case 1:
															?>
															<div class="row">
																<div class="col-md-12 <?php echo $value->id == 225 ? 'chronic_dmii_question_240_225 display_none_at_load_time' : ''; ?>">
																	<div class="form-group form_fild_row">
							 											<div class="radio_bg">
								          									<label><?= str_replace("***", "diabetes", $value->question) ?>
								          									&nbsp;<span class="required">*</span></label>

																			<div class="radio_list">
																			<?php
																				$options = unserialize($value->options);

																				foreach ($options as $k => $v) {
																					?>
							        												<div class="form-check">
							         													<input type="radio"  value="<?= $v ?>" <?= $old_dmii_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dmii_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_dmii_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_dmii_detail[<?= $value->id ?>]"  required="true">
							         													<label class="form-check-label" for="radio_question<?= $i ?>">
							         														<?= $v ?>
							         													</label>
							       													</div>
																				<?php
																					$i++ ;
																				}
																				?>
																			</div>
							   											</div>
											 						</div>
																</div>
															</div>

																<?php if($value->id == 235){

																?>
																		<div class="currentreadingfld_section display_none_at_load_time">
																			<?php
																			if(!empty($user_detail_old->chief_compliant_userdetail->glucose_reading_detail))
																			{
																				$old_reading = $user_detail_old->chief_compliant_userdetail->glucose_reading_detail;

																				foreach ($old_reading as $old_read_ky => $old_read_ve)
																				{

																					//pr($old_read_ve);die;

																			?>

																			<div class="row currentreadingfld ">
																		    <div class="col-md-4">
																			 	<!-- <div class="form-group"> -->

																						<input type="text" class="form-control glucose_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" value="<?php echo $old_read_ve['reading_date']; ?>" />

																		     	<!-- </div> -->
																			</div>
																			<div class="col-md-4">
																				<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">

																					<?php foreach ($reading_timing_arr as $reading_key => $reading_value) { ?>


																						<option value="<?php echo $reading_key; ?>" <?php echo $old_read_ve['reading_timing'] == $reading_key ? 'selected' : "" ;?>><?php echo $reading_value; ?></option>
																					<?php } ?>
																				</select>

																					<!-- <input  type="text" class="form-control ignore_fld" placeholder="Enter Reading timing"/>  -->

																			</div>

																			<div class="col-md-3">

																					<input type="number" pattern="[0-9]*" inputmode="numeric" name="reading_val[]" class="form-control" placeholder="Enter Reading" required="true" value="<?php echo $old_read_ve['reading_val']; ?>"/>

																			</div>
																			<div class="col-md-1">
																		     	<div class="row">
																			  		<div class=" currentreadingfldtimes">
																			   			<div class="crose_year">
																			    			<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																			   			</div>
																			  		</div>
																			 	</div>
																			</div>
																		</div>

																		<?php }
																		}
																		else{ ?>
																		<div class="row currentreadingfld ">
																		    <div class="col-md-4">
																			 	<!-- <div class="form-group"> -->

																						<input type="text" class="form-control glucose_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" />

																		     	<!-- </div> -->
																			</div>
																			<div class="col-md-4">
																				<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">

																					<?php foreach ($reading_timing_arr as $reading_key => $reading_value) { ?>


																						<option value="<?php echo $reading_key; ?>"><?php echo $reading_value; ?></option>
																					<?php } ?>
																				</select>

																					<!-- <input  type="text" class="form-control ignore_fld" placeholder="Enter Reading timing"/>  -->

																			</div>

																			<div class="col-md-3">

																					<input type="number" pattern="[0-9]*" inputmode="numeric" name="reading_val[]" class="form-control" placeholder="Enter Reading" required="true"/>

																			</div>
																			<div class="col-md-1">
																		     	<div class="row">
																			  		<div class=" currentreadingfldtimes">
																			   			<div class="crose_year">
																			    			<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																			   			</div>
																			  		</div>
																			 	</div>
																			</div>
																		</div>
																	<?php } ?>
																	<div class="row">
																	    <div class="col-md-6 chronic_dmii_question_235_add_reading_btn display_none_at_load_time">
																		 <div class="form-group form_fild_row">

																		   <div class="crose_year">
																		    <button  type="button"  class="btn btn-medium currentreadingfldadd">add Reading</button>
																		   </div>
																		 </div>
																		</div>
																	</div>
																</div>

																<?php } ?>

																<?php if($value->id == 292){

																?>
																<div class="current_dmii_medicationfld_section display_none_at_load_time">

																<label>What medication are you taking for diabetes?&nbsp;<span class="required">*</span></label> <!--  -->
																<?php
																	if(!empty($user_detail_old->chief_compliant_userdetail->chronic_dmii_medication)){
																		$cmd_old = $user_detail_old->chief_compliant_userdetail->chronic_dmii_medication;

																		foreach ($cmd_old as $ky => $ve) {

																	?>

																			<div class="row currentmedicationfld">

																			    <div class="col-md-4">
																				 	<!-- <div class="form-group form_fild_row">  -->
																						<div class="custom-drop">
																							<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
																						    <ul class="med_suggestion_listul cronic-drop-li">
																							</ul>
																						<!-- </div> -->
																					</div>
																				</div>
																				<div class="col-md-2">
																					 <!-- <div class="form-group form_fild_row"> -->
																					  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
																					 <!-- </div> -->
																					</div>

																				<div class="col-md-2">
																				 <!-- <div class="form-group form_fild_row">  -->
																				  <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->

																				<select class="form-control" name="medication_how_often[]">
																					<option value="">how often?</option>
																				<?php
																						foreach ($length_arr as $key => $value) {

																					echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

																						}
																					?>
																					</select>
																					<!-- </div> -->
																				</div>
																			    <div class="col-md-3">
																				 	<!-- <div class="form-group form_fild_row"> -->
																						<div class="custom-drop">

																							<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
																					      <ul class="how_taken_suggestion_listul custom-drop-li">
																							</ul>
																						<!-- </div> -->
																				 	</div>
																				</div>
																			<div class="col-md-1">
																		     <div class="row">

																			  <div class=" chronic_currentmedicationfldtimes">
																			   <div class="crose_year">
																			    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																			   </div>
																			  </div>
																			 </div>
																			</div>
																		   </div>
																		<?php
																			}
																		}
																		else{ ?>
																		<div class="row currentmedicationfld">
																		   <div class="col-md-4">
																		      <div class="custom-drop">
																		         <input type="text"    class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
																		         <ul class="med_suggestion_listul cronic-drop-li">
																		         </ul>
																		      </div>
																		   </div>
																		   <div class="col-md-2">
																		      <input name="medication_dose[]" type="text" class="form-control ignore_fld" placeholder="Dose"/>
																		   </div>

																		   <div class="col-md-2">
																		      <select class="form-control" name="medication_how_often[]">
																		         <option value="">how often?</option>
																		         <?php
																		            foreach ($length_arr as $key => $value) {
																		               echo "<option value=".$key.">".$value."</option>";
																		            }
																		         ?>
																		      </select>
																		   </div>
																		   <div class="col-md-3">
																		      <div class="custom-drop">
																		         <input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
																		         <ul class="how_taken_suggestion_listul custom-drop-li">
																		         </ul>
																		      </div>
																		   </div>
																		   <div class="col-md-1">
																		      <div class="row">
																		         <div class=" chronic_currentmedicationfldtimes">
																		            <div class="crose_year">
																		               <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																		            </div>
																		         </div>
																		      </div>
																		   </div>
																		</div>
																	<?php } ?>
																	<div class="row">
																	    <div class="col-md-6">
																		 <div class="form-group form_fild_row">
																		   <div class="crose_year">
																		    <button  type="button"  class="btn currentmedicationfldadd_chronic_condition btn-medium">add a medication</button>
																		   </div>
																		 </div>
																		</div>
																	</div>
																</div>

															<?php } ?>

															<?php
																break;

															   case 3:

														 	?>

										  					<div class="row">
																<div class="col-md-12 <?php echo $value->id == 228 ? 'chronic_dmii_question_225_228 display_none_at_load_time' : '' ?> <?php echo $value->id == 229 ? 'chronic_dmii_question_225_229 display_none_at_load_time' : '' ?> <?php echo $value->id == 231 ? 'chronic_dmii_question_230_231 display_none_at_load_time' : '' ?> <?php echo $value->id == 233 ? 'chronic_dmii_question_232_233 display_none_at_load_time' : '' ?> <?php echo $value->id == 239 ? 'chronic_dmii_question_235_239 display_none_at_load_time' : '' ?>">
												 					<div class="form-group form_fild_row">
												 						<label><?= $value->question ?>

																		<?php $options = unserialize($value->options);?>

												 						<?php if(isset($options[0]) && !empty($options[0])){ ?>
												 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
												 						<?php } ?><span class="required">*</span>
												 						</label>

																		<select class="form-control <?php echo 'chronic_dmii_question_'.$value->id; ?>" name="chronic_dmii_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="">

																		<?php

																			foreach ($options as $ky => $ve) {

																				echo "<option ".($old_dmii_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
																				// for 15 id we will send the value as the select box value
																			}
																		?>
																		</select>
												 					</div>
																</div>
															</div>

														<?php
													        break;
															case 2:
														?>
															<div class="row">
																<div class="col-md-12 <?php echo $value->id == 226 ? 'chronic_dmii_question_225_226 display_none_at_load_time' : '' ?>">
														 			<div class="form-group form_fild_row <?= ($value->id == 226 || $value->id == 223) ? 'new_appoint_checkbox_quest_a' : '' ?>">
														 					<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
														 					<div class="<?= ($value->id == 226 || $value->id == 223) ? 'new_appoint_checkbox_quest' : '' ?>">
														 						<span></span>
														 						<?php
														 							$options = unserialize($value->options) ; ?>
																			<?php
																			 	$temp_old_dqid_val = array();
																				$old_36_37_38 = array();
																				if(is_array($old_dmii_val)){
																					foreach ($old_dmii_val as $kdq => $vdq) {
																						if(($pos = stripos($vdq, '-')) !== false){
																							$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																							// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																							$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																						}else{
																							$temp_old_dqid_val[$vdq] = $vdq;
																						}
																					}
																				}

																				$old_dmii_val = $temp_old_dqid_val;

																				foreach ($options as $ky => $val) {
												 							?>

																					<div class="check_box_bg">
											 											<div class="custom-control custom-checkbox">
									          												<input <?= is_array($old_dmii_val) && array_key_exists($val, $old_dmii_val)   ? 'checked' : '' ?> class="custom-control-input <?php echo 'chronic_dmii_question_'.$value->id; ?>"  name="chronic_dmii_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_chronic_cad_val[$val]) ? $old_chronic_cad_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="true">
									          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
									         											</div>
											 										</div>

												 								<?php
												 									$ic++;
														 						}

														 						?>
																			</div>
														 				</div>
																	</div>
																</div>
															<?php
															break;
																}
															}
														}
								  					?>
													<!-- **********   glucose reading for clone purpose display none  start ************* -->


													<div class="row clone_purpose_reading_field_display_none">
														    <div class="col-md-4">
															 	<!-- <div class="form-group"> -->

																		<input type="text" class="form-control glucose_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" />

														     	<!-- </div> -->
															</div>
															<div class="col-md-4">

																	<!-- <input name="reading_timing[]" type="text" class="form-control ignore_fld" placeholder="Enter Reading timing"/> -->

																	<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">

																		<?php foreach ($reading_timing_arr as $reading_key => $reading_value) { ?>


																			<option value="<?php echo $reading_key; ?>"><?php echo $reading_value; ?></option>
																		<?php } ?>
																	</select>

															</div>

															<div class="col-md-3">

																	<input type="number" pattern="[0-9]*" inputmode="numeric" name="reading_val[]" class="form-control" placeholder="Enter Reading" required="true"/>

															</div>
															<div class="col-md-1">
														     	<div class="row">
															  		<div class=" currentreadingfldtimes">
															   			<div class="crose_year">
															    			<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
															   			</div>
															  		</div>
															 	</div>
															</div>
														</div>

													<!-- ************   glucose reading field for clone purpose display none end *************** -->

	  											<div class="back_next_button">
													<ul>

														<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'dmii'){ ?>
															<li>
																<!-- <button id="chronic_condition-backbtn" type="button" class="btn">Previous tab</button> -->
															<?php if($step_id != 25){?>
																<button id="chronic_condition-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															<?php } ?>
															</li>
														<?php } ?>

													 	<li style="float: right;margin-left: left">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="dmii">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										} ?>


										<?php if(in_array('chf', $old_chronic_condition)){

									   		if($active_sub_tab == 'chf'){
										   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
													'inputDefaults' => array(
													'label' => false,
													'div' => false,

													),'enctype' => 'multipart/form-data', 'id' => 'form_tab_23_chf'));
									   	 ?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'chf' ? 'show active' : ''; ?>" id="chf" role="tabpanel" aria-labelledby="chf-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_chf_detail = '';

												//pr($user_detail_old->chief_compliant_userdetail->chronic_dmii_detail);die;
												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_chf_detail))
									                $old_chronic_chf_detail = $user_detail_old->chief_compliant_userdetail->chronic_chf_detail;

							  					if(!empty($choronic_chf_question)){
													foreach ($choronic_chf_question as $key => $value) {

														$old_val = !empty($old_chronic_chf_detail[$value->id]) ? $old_chronic_chf_detail[$value->id] : '';

														switch ($value->question_type) {
															case 1:
															?>
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group form_fild_row">
							 											<div class="radio_bg">
								          									<label><?= str_replace("***", "congestive heart failure", $value->question) ?>
								          									&nbsp;<span class="required">*</span></label>

																			<div class="radio_list">
																			<?php
																				$options = unserialize($value->options);

																				foreach ($options as $k => $v) {
																					?>
							        												<div class="form-check">
							         													<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_chf_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_chf_detail[<?= $value->id ?>]"  required="true">
							         													<label class="form-check-label" for="radio_question<?= $i ?>">
							         														<?= $v ?>
							         													</label>
							       													</div>
																				<?php
																					$i++ ;
																				}
																				?>
																			</div>
							   											</div>
											 						</div>
																</div>
															</div>

															<?php
															break;
																}
															}
														}
								  					?>

								  					<?php if($value->id == 292){

												?>
													<div class="current_chf_medicationfld_section display_none_at_load_time">

													<label>What medication are you taking for congestive heart failure?&nbsp;<span class="required">*</span></label> <!--  -->
													<?php
														if(!empty($user_detail_old->chief_compliant_userdetail->chronic_chf_medication)){
															$cmd_old = $user_detail_old->chief_compliant_userdetail->chronic_chf_medication;

															foreach ($cmd_old as $ky => $ve) {

														?>

																<div class="row currentmedicationfld">

																    <div class="col-md-4">
																	 	<!-- <div class="form-group form_fild_row">  -->
																			<div class="custom-drop">
																				<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
																			    <ul class="med_suggestion_listul cronic-drop-li">
																				</ul>
																			<!-- </div> -->
																		</div>
																	</div>
																	<div class="col-md-2">
																		 <!-- <div class="form-group form_fild_row"> -->
																		  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
																		 <!-- </div> -->
																		</div>

																	<div class="col-md-2">

																	<select class="form-control" name="medication_how_often[]">
																		<option value="">how often?</option>
																	<?php
																			foreach ($length_arr as $key => $value) {

																		echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

																			}
																		?>
																		</select>
																		<!-- </div> -->
																	</div>
																    <div class="col-md-3">
																	 	<!-- <div class="form-group form_fild_row"> -->
																			<div class="custom-drop">

																				<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
																		      <ul class="how_taken_suggestion_listul custom-drop-li">
																				</ul>
																			<!-- </div> -->
																	 	</div>
																	</div>
																<div class="col-md-1">
															     <div class="row">

																  <div class=" chronic_currentmedicationfldtimes">
																   <div class="crose_year">
																    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																   </div>
																  </div>
																 </div>
																</div>
															   </div>
															<?php
																}
															}
															else{ ?>
															<div class="row currentmedicationfld">
															   <div class="col-md-4">
															      <div class="custom-drop">
															         <input type="text"    class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
															         <ul class="med_suggestion_listul cronic-drop-li">
															         </ul>
															      </div>
															   </div>
															   <div class="col-md-2">
															      <input name="medication_dose[]" type="text" class="form-control ignore_fld" placeholder="Dose"/>
															   </div>

															   <div class="col-md-2">
															      <select class="form-control" name="medication_how_often[]">
															         <option value="">how often?</option>
															         <?php
															            foreach ($length_arr as $key => $value) {
															               echo "<option value=".$key.">".$value."</option>";
															            }
															         ?>
															      </select>
															   </div>
															   <div class="col-md-3">
															      <div class="custom-drop">
															         <input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
															         <ul class="how_taken_suggestion_listul custom-drop-li">
															         </ul>
															      </div>
															   </div>
															   <div class="col-md-1">
															      <div class="row">
															         <div class=" chronic_currentmedicationfldtimes">
															            <div class="crose_year">
															               <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
															            </div>
															         </div>
															      </div>
															   </div>
															</div>
														<?php } ?>
														<div class="row">
														    <div class="col-md-6">
															 <div class="form-group form_fild_row">
															   <div class="crose_year">
															    <button  type="button"  class="btn currentmedicationfldadd_chronic_condition btn-medium">add a medication</button>
															   </div>
															 </div>
															</div>
														</div>
													</div>

												<?php } ?>

	  											<div class="back_next_button">
													<ul>

														<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'chf'){ ?>
															<li>
																<!-- <button id="chronic_condition-backbtn" type="button" class="btn">Previous tab</button> -->
															<?php if($step_id != 25){?>
																<button id="chronic_condition-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															<?php } ?>
															</li>
														<?php } ?>

													 	<li style="float: right;margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="chf">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										} ?>

										<?php if(in_array('copd', $old_chronic_condition)){

									   		if($active_sub_tab == 'copd'){
										   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
													'inputDefaults' => array(
													'label' => false,
													'div' => false,

													),'enctype' => 'multipart/form-data', 'id' => 'form_tab_23_copd'));
									   	 ?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'copd' ? 'show active' : ''; ?>" id="copd" role="tabpanel" aria-labelledby="copd-tab">

									<?php
          								$i = 0;
          								$ic = 0;
										$cb_class = '';
										$old_chronic_copd_detail = '';

										//pr($user_detail_old->chief_compliant_userdetail->chronic_general_detail);die;
										if(!empty($user_detail_old->chief_compliant_userdetail->chronic_copd_detail))
							                $old_chronic_copd_detail = $user_detail_old->chief_compliant_userdetail->chronic_copd_detail;

					  					if(!empty($choronic_copd_question)){
											foreach ($choronic_copd_question as $key => $value) {

												$old_val = !empty($old_chronic_copd_detail[$value->id]) ? $old_chronic_copd_detail[$value->id] : '';

												switch ($value->question_type) {

													case 0:  ?>

													<div class="row <?php echo $value->id == 291 ? 'chronic_copd_question_290_291 display_none_at_load_time' : '' ?>">
														<div class="col-md-12 <?php echo $value->id == 264 ? 'chronic_copd_question_263_264 display_none_at_load_time' : '' ?> <?php echo $value->id == 266 ? 'chronic_copd_question_265_266 display_none_at_load_time' : '' ?>" >
				 											<div class="form-group form_fild_row">
				 												<?=  $value->question ?>
				 												<?php if(!empty($value->question)){ ?>
				 												&nbsp;<span class="required">*</span> <?php } ?>

				 												<?php if($value->data_type == 2){ ?>

				 													<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?php echo $old_val; ?>" class="form-control <?php echo 'chronic_copd_question_'.$value->id; ?>"  name="chronic_copd_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>

				 												<?php }
																else{ ?>

																	<input type="text" value="<?php echo $old_val; ?>" class="form-control <?php echo 'chronic_copd_question_'.$value->id; ?>"  name="chronic_copd_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>
																<?php } ?>
															</div>
														</div>
													</div>

													<?php
														break;
													case 1:
													if((in_array($value->id, [270,274]))){

														continue;
													}
													?>

													<div class="row <?php echo $value->id == 273 ? 'chronic_copd_question_270_272 display_none_at_load_time' : '' ?> <?php echo $value->id == 280 ? 'chronic_copd_question_278_280 display_none_at_load_time' : '' ?> <?php echo $value->id == 281 ? 'chronic_copd_question_280_281 display_none_at_load_time' : '' ?> <?php echo $value->id == 282 ? 'chronic_copd_question_281_282 display_none_at_load_time' : '' ?><?php echo $value->id == 287 ? 'chronic_copd_question_285_287 display_none_at_load_time' : '' ?><?php echo $value->id == 283 ? 'chronic_copd_question_278_283 display_none_at_load_time' : '' ?><?php echo $value->id == 284 ? 'chronic_copd_question_278_284 display_none_at_load_time' : '' ?><?php echo $value->id == 285 ? 'chronic_copd_question_278_285 display_none_at_load_time' : '' ?>" id="<?php echo $value->id == 267 ? 'chronic_copd_question_267_section' : ''; ?>">
														<div class="col-md-12">
															<div class="form-group form_fild_row">
					 											<div class="radio_bg">
						          									<label><?= $value->question ?>
						          									&nbsp;<span class="required">*</span></label>

																	<div class="radio_list">
																	<?php
																		$options = unserialize($value->options);

																		foreach ($options as $k => $v) {
																			?>
					        												<div class="form-check">
					         													<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_copd_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_copd_detail[<?= $value->id ?>]"  required="true">
					         													<label class="form-check-label" for="radio_question<?= $i ?>">
					         														<?= $v ?>
					         													</label>
					       													</div>
																		<?php
																			$i++ ;
																		}
																		?>
																	</div>
					   											</div>
									 						</div>
														</div>
													</div>
													<?php
														break;

													   case 3:

												 	?>


								  					<div class="row <?php echo $value->id == 271 ? 'chronic_copd_question_270_271 display_none_at_load_time' : '' ?> <?php echo $value->id == 272 ? 'chronic_copd_question_270_272 display_none_at_load_time' : '' ?> <?php echo $value->id == 279 ? 'chronic_copd_question_278_279 display_none_at_load_time' : '' ?><?php echo $value->id == 288 ? 'chronic_copd_question_287_288 display_none_at_load_time' : '' ?><?php echo $value->id == 286 ? 'chronic_copd_question_285_286 display_none_at_load_time' : '' ?><?php echo $value->id == 276 ? 'chronic_copd_question_275_276 display_none_at_load_time' : '' ?>">
														<div class="col-md-12">
										 					<div class="form-group form_fild_row">
										 						<label><?= $value->question ?>

																<?php $options = unserialize($value->options);?>

										 						<?php if(isset($options[0]) && !empty($options[0])){ ?>
										 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
										 						<?php } ?><span class="required">*</span>
										 						</label>

																<select class="form-control <?php echo 'chronic_copd_question_'.$value->id; ?>" name="chronic_copd_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="">

																<?php

																	foreach ($options as $ky => $ve) {

																		echo "<option ".($old_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
																		// for 15 id we will send the value as the select box value
																	}

																?>
																</select>
										 					</div>
														</div>
													</div>

												<?php
											        break;
													case 2:
												?>
								<div class="row <?php echo $value->id == 290 ? 'chronic_copd_question_289_290 display_none_at_load_time' : '' ?><?php echo $value->id == 320 ? 'chronic_copd_question_275_320 display_none_at_load_time' : '' ?>">
									<div class="col-md-12">
							 			<div class="form-group form_fild_row <?= ($value->id == 268 || $value->id == 269 || $value->id == 320) ? 'new_appoint_checkbox_quest_a' : '' ?>">
							 					<label><?= $value->question ?>&nbsp;<?php if(!in_array($value->id,[268,269,289])){ ?><span class="required">*</span><?php } ?></label>
							 					<div class="<?= ($value->id == 268 || $value->id == 269 || $value->id == 320) ? 'new_appoint_checkbox_quest' : '' ?>">
							 						<span></span>
							 						<?php
							 							$options = unserialize($value->options) ;

							 							 if($value->id == 290){

															$Other = array_search("Other", $options);
															$donut = $options[$Other];  // If you don't need to keep the value, skip this line
															unset($options[$Other]);
															asort($options);
															$options += array($Other => $donut);
														  }
							 							?>
												<?php
												 	$temp_old_dqid_val = array();
													$old_36_37_38 = array();
													if(is_array($old_val)){
														foreach ($old_val as $kdq => $vdq) {
															if(($pos = stripos($vdq, '-')) !== false){
																$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
															}else{
																$temp_old_dqid_val[$vdq] = $vdq;
															}
														}
													}

													$old_val = $temp_old_dqid_val;

													foreach ($options as $ky => $val) {
					 							?>

														<div class="check_box_bg">
				 											<div class="custom-control custom-checkbox">
		          												<input <?= is_array($old_val) && array_key_exists($val, $old_val)   ? 'checked' : '' ?> class="custom-control-input <?php echo 'chronic_copd_question_'.$value->id; ?>"  name="chronic_copd_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_val[$val]) ? $old_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" <?php if(!in_array($value->id,[268,269,289])){ ?> required="true" <?php } ?>>
		          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
		         											</div>
				 										</div>

					 								<?php
					 									$ic++;
							 						}

							 						?>
												</div>
							 				</div>
										</div>
									</div>
								<?php
								break;
									}
								}
							}
						  					?>
						  					<div class="back_next_button">
												<ul>
													<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'copd'){ ?>
															<li>
															<?php if($step_id != 25){?>
																<button id="chronic_condition-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															<?php } ?>
																<!-- <button id="chronic_condition-backbtn" type="button" class="btn">Previous tab</button> -->
															</li>
														<?php } ?>
												 	<li style="float: right;margin-left: auto;">
												  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
												  		<button type="submit" class="btn" name="sub_tab_name" value="copd">Next</button>
												 	</li>
												</ul>
											</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										} ?>

										<?php if(in_array('htn', $old_chronic_condition)){

									   		if($active_sub_tab == 'htn'){
										   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
													'inputDefaults' => array(
													'label' => false,
													'div' => false,

													),'enctype' => 'multipart/form-data', 'id' => 'form_tab_23_htn'));
									   	 ?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'htn' ? 'show active' : ''; ?>" id="htn" role="tabpanel" aria-labelledby="htn-tab">

											<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_htn_detail = '';

												//pr($user_detail_old->chief_compliant_userdetail->chronic_dmii_detail);die;
												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_htn_detail))
									                $old_chronic_htn_detail = $user_detail_old->chief_compliant_userdetail->chronic_htn_detail;

							  					if(!empty($choronic_htn_question)){
													foreach ($choronic_htn_question as $key => $value) {

														$old_val = !empty($old_chronic_htn_detail[$value->id]) ? $old_chronic_htn_detail[$value->id] : '';

														switch ($value->question_type) {
															case 1:
															?>
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group form_fild_row">
							 											<div class="radio_bg">
								          									<label><?= str_replace("***", 'hypertension', $value->question) ?>
								          									&nbsp;<span class="required">*</span></label>

																			<div class="radio_list">
																			<?php
																				$options = unserialize($value->options);

																				foreach ($options as $k => $v) {
																					?>
							        												<div class="form-check">
							         													<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_htn_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_htn_detail[<?= $value->id ?>]"  required="true">
							         													<label class="form-check-label" for="radio_question<?= $i ?>">
							         														<?= $v ?>
							         													</label>
							       													</div>
																				<?php
																					$i++ ;
																				}
																				?>
																			</div>
							   											</div>
											 						</div>
																</div>
															</div>

																<?php if($value->id == 243){

																?>
																	<div class="currentbpreadingfld_section display_none_at_load_time"> <!--  -->
																	<?php
																	if(!empty($user_detail_old->chief_compliant_userdetail->bp_reading_detail))
																	{
																		$old_reading = $user_detail_old->chief_compliant_userdetail->bp_reading_detail;

																		//pr($old_reading);die;

																		foreach ($old_reading as $old_read_ky => $old_read_ve)
																		{

																			//pr($old_read_ve);die;

																	?>

																	<div class="row currentbpreadingfld ">
																	    <div class="col-md-2">
																			<input type="text" class="form-control bp_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" value="<?php echo $old_read_ve['reading_date']; ?>" />
																		</div>
																		<div class="col-md-3">
																			<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">

																				<?php foreach ($reading_timing_arr as $reading_key => $reading_value) { ?>


																					<option value="<?php echo $reading_key; ?>" <?php echo $old_read_ve['reading_timing'] == $reading_key ? 'selected' : "" ;?>><?php echo $reading_value; ?></option>
																				<?php } ?>
																			</select>
																		</div>

																		<div class="col-md-3">
																			<input type="number" pattern="[0-9]*" inputmode="numeric" name="top_number[]" class="form-control" placeholder="Enter Top Number" required="true" value="<?php echo $old_read_ve['top_number']; ?>"/>
																		</div>
																		<div class="col-md-3">
																			<input type="number" pattern="[0-9]*" inputmode="numeric" name="bottom_number[]" class="form-control" placeholder="Enter Bottom Number" required="true" value="<?php echo $old_read_ve['bottom_number']; ?>"/>
																		</div>
																		<div class="col-md-1">
																	     	<div class="row">
																		  		<div class="currentbpreadingfldtimes">
																		   			<div class="crose_year">
																		    			<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																		   			</div>
																		  		</div>
																		 	</div>
																		</div>
																	</div>

																			<?php }
																			}
																			else{ ?>
																			<div class="row currentbpreadingfld ">
																			    <div class="col-md-2">
																					<input type="text" class="form-control bp_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" />
																				</div>
																				<div class="col-md-3">
																					<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">
																						<?php foreach ($reading_timing_arr as $reading_key => $reading_value) { ?>
																							<option value="<?php echo $reading_key; ?>"><?php echo $reading_value; ?></option>
																						<?php } ?>
																					</select>
																				</div>

																				<div class="col-md-3">
																					<input type="number" pattern="[0-9]*" inputmode="numeric" name="top_number[]" class="form-control" placeholder="Enter Top Number" required="true"/>
																				</div>
																				<div class="col-md-3">
																					<input type="number" pattern="[0-9]*" inputmode="numeric" name="bottom_number[]" class="form-control" placeholder="Enter Bottom Number" required="true"/>
																				</div>
																				<div class="col-md-1">
																			     	<div class="row">
																				  		<div class="currentbpreadingfldtimes">
																				   			<div class="crose_year">
																				    			<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																				   			</div>
																				  		</div>
																				 	</div>
																				</div>
																			</div>
																		<?php } ?>
																		<div class="row">
																		    <div class="col-md-6 bp_add_reading_btn display_none_at_load_time">
																			 <div class="form-group form_fild_row">

																			   <div class="crose_year">
																			    <button  type="button"  class="btn currentbpreadingfldadd btn-medium">add Reading</button>
																			   </div>
																			 </div>
																			</div>
																		</div>
																	</div>

																<?php } ?>

															<?php
															break;
																}
															}
														}
								  					?>

								  					<?php if($value->id == 292){

												?>
													<div class="current_htn_medicationfld_section display_none_at_load_time">

													<label>What medication are you taking for hypertension?&nbsp;<span class="required">*</span></label> <!--  -->
													<?php
														if(!empty($user_detail_old->chief_compliant_userdetail->chronic_htn_medication)){
															$cmd_old = $user_detail_old->chief_compliant_userdetail->chronic_htn_medication;

															foreach ($cmd_old as $ky => $ve) {

														?>

																<div class="row currentmedicationfld">

																    <div class="col-md-4">
																	 	<!-- <div class="form-group form_fild_row">  -->
																			<div class="custom-drop">
																				<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
																			    <ul class="med_suggestion_listul cronic-drop-li">
																				</ul>
																			<!-- </div> -->
																		</div>
																	</div>
																	<div class="col-md-2">
																		 <!-- <div class="form-group form_fild_row"> -->
																		  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
																		 <!-- </div> -->
																		</div>

																	<div class="col-md-2">

																	<select class="form-control" name="medication_how_often[]">
																		<option value="">how often?</option>
																	<?php
																			foreach ($length_arr as $key => $value) {

																		echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

																			}
																		?>
																		</select>
																		<!-- </div> -->
																	</div>
																    <div class="col-md-3">
																	 	<!-- <div class="form-group form_fild_row"> -->
																			<div class="custom-drop">

																				<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
																		      <ul class="how_taken_suggestion_listul custom-drop-li">
																				</ul>
																			<!-- </div> -->
																	 	</div>
																	</div>
																<div class="col-md-1">
															     <div class="row">

																  <div class=" chronic_currentmedicationfldtimes">
																   <div class="crose_year">
																    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																   </div>
																  </div>
																 </div>
																</div>
															   </div>
															<?php
																}
															}
															else{ ?>
															<div class="row currentmedicationfld">
															   <div class="col-md-4">
															      <div class="custom-drop">
															         <input type="text"    class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
															         <ul class="med_suggestion_listul cronic-drop-li">
															         </ul>
															      </div>
															   </div>
															   <div class="col-md-2">
															      <input name="medication_dose[]" type="text" class="form-control ignore_fld" placeholder="Dose"/>
															   </div>

															   <div class="col-md-2">
															      <select class="form-control" name="medication_how_often[]">
															         <option value="">how often?</option>
															         <?php
															            foreach ($length_arr as $key => $value) {
															               echo "<option value=".$key.">".$value."</option>";
															            }
															         ?>
															      </select>
															   </div>
															   <div class="col-md-3">
															      <div class="custom-drop">
															         <input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
															         <ul class="how_taken_suggestion_listul custom-drop-li">
															         </ul>
															      </div>
															   </div>
															   <div class="col-md-1">
															      <div class="row">
															         <div class=" chronic_currentmedicationfldtimes">
															            <div class="crose_year">
															               <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
															            </div>
															         </div>
															      </div>
															   </div>
															</div>
														<?php } ?>
														<div class="row">
														    <div class="col-md-6">
															 <div class="form-group form_fild_row">
															   <div class="crose_year">
															    <button  type="button"  class="btn currentmedicationfldadd_chronic_condition btn-medium">add a medication</button>
															   </div>
															 </div>
															</div>
														</div>
													</div>

												<?php } ?>

	  											<div class="back_next_button">
													<ul>

														<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'htn'){ ?>
															<li>
																<?php if($step_id != 25){?>
																<button id="chronic_condition-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															<?php } ?>
																<!-- <button id="chronic_condition-backbtn" type="button" class="btn">Previous tab</button> -->
															</li>
														<?php } ?>

													 	<li style="float: right;margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="htn">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										} ?>


										<?php if(in_array('asthma', $old_chronic_condition)){

									   		if($active_sub_tab == 'asthma'){
										   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
													'inputDefaults' => array(
													'label' => false,
													'div' => false,

													),'enctype' => 'multipart/form-data', 'id' => 'form_tab_23_asthma'));
									   	 ?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'asthma' ? 'show active' : ''; ?>" id="asthma" role="tabpanel" aria-labelledby="asthma-tab">

									<?php
          								$i = 0;
          								$ic = 0;
										$cb_class = '';
										$old_chronic_asthma_detail = '';

										//pr($user_detail_old->chief_compliant_userdetail->chronic_general_detail);die;
										if(!empty($user_detail_old->chief_compliant_userdetail->chronic_asthma_detail))
							                $old_chronic_asthma_detail = $user_detail_old->chief_compliant_userdetail->chronic_asthma_detail;

							            //pr($choronic_asthma_question);

					  					if(!empty($choronic_asthma_question)){
											foreach ($choronic_asthma_question as $key => $value) {

												$old_val = isset($old_chronic_asthma_detail[$value->id]) ? $old_chronic_asthma_detail[$value->id] : '';

												switch ($value->question_type) {

													case 0:  ?>

													<div class="row <?php echo $value->id == 294 ? 'chronic_asthma_question_293_294 display_none_at_load_time' : '' ?>">
														<div class="col-md-12" >
				 											<div class="form-group form_fild_row">
				 												<?=  $value->question ?>
				 												<?php if(!empty($value->question)){ ?>
				 												&nbsp;<span class="required">*</span> <?php } ?>
				 												<?php if($value->data_type == 2){ ?>

				 													<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?php echo $old_val; ?>" class="form-control <?php echo 'chronic_asthma_question_'.$value->id; ?>"  name="chronic_asthma_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>

																<?php }
																else{ ?>
																	<input type="text" value="<?php echo $old_val; ?>" class="form-control <?php echo 'chronic_asthma_question_'.$value->id; ?>"  name="chronic_asthma_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>
																<?php } ?>
															</div>
														</div>
													</div>

													<?php
														break;
													case 1:
													if((in_array($value->id, [310,312]))){

														continue;
													}

													?>

													<div class="row <?php echo $value->id == 308 ? 'chronic_asthma_question_306_308 display_none_at_load_time' : '' ?><?php echo $value->id == 305 ? 'chronic_asthma_question_303_305 display_none_at_load_time' : '' ?><?php echo $value->id == 306 ? 'chronic_asthma_question_303_306 display_none_at_load_time' : '' ?>">
														<div class="col-md-12">
															<div class="form-group form_fild_row">
					 											<div class="radio_bg">
						          									<label><?= $value->question ?>
						          									&nbsp;<span class="required">*</span></label>

																	<div class="radio_list">
																	<?php
																		$options = unserialize($value->options);

																		foreach ($options as $k => $v) {
																			?>
					        												<div class="form-check">
					         													<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_asthma_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_asthma_detail[<?= $value->id ?>]"  required="true">
					         													<label class="form-check-label" for="radio_question<?= $i ?>">
					         														<?= $v ?>
					         													</label>
					       													</div>
																		<?php
																			$i++ ;
																		}
																		?>
																	</div>
					   											</div>
									 						</div>
														</div>
													</div>
													<?php if($value->id == 295){ ?>
														<div class="currentpeakflowreadingfld_section display_none_at_load_time"> <!--  -->
														<?php
														if(!empty($user_detail_old->chief_compliant_userdetail->peak_flow_reading_detail))
														{
															$old_reading = $user_detail_old->chief_compliant_userdetail->peak_flow_reading_detail;
															foreach ($old_reading as $old_read_ky => $old_read_ve)
															{
														?>

														<div class="row currentpeakflowreadingfld ">
														    <div class="col-md-4">
																<input type="text" class="form-control peak_flow_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" value="<?php echo $old_read_ve['reading_date']; ?>" />
															</div>
															<div class="col-md-4">
																<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">

																	<?php foreach ($peakflow_reading_timing_arr as $reading_key => $reading_value) { ?>


																		<option value="<?php echo $reading_key; ?>" <?php echo $old_read_ve['reading_timing'] == $reading_key ? 'selected' : "" ;?>><?php echo $reading_value; ?></option>
																	<?php } ?>
																</select>
															</div>

															<div class="col-md-3">
																<input type="number" pattern="[0-9]*" inputmode="numeric" name="reading_val[]" class="form-control" placeholder="Enter Reading" required="true" value="<?php echo $old_read_ve['reading_val']; ?>"/>
															</div>
															<div class="col-md-1">
														     	<div class="row">
															  		<div class="currentpeakflowreadingfldtimes">
															   			<div class="crose_year">
															    			<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
															   			</div>
															  		</div>
															 	</div>
															</div>
														</div>

																<?php }
																}
																else{ ?>
																<div class="row currentpeakflowreadingfld ">
																    <div class="col-md-4">
																		<input type="text" class="form-control peak_flow_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" />
																	</div>
																	<div class="col-md-4">
																		<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">
																			<?php foreach ($peakflow_reading_timing_arr as $reading_key => $reading_value) { ?>
																				<option value="<?php echo $reading_key; ?>"><?php echo $reading_value; ?></option>
																			<?php } ?>
																		</select>
																	</div>

																	<div class="col-md-3">
																		<input type="number" pattern="[0-9]*" inputmode="numeric" name="reading_val[]" class="form-control" placeholder="Enter Reading" required="true"/>
																	</div>
																	<div class="col-md-1">
																     	<div class="row">
																	  		<div class="currentpeakflowreadingfldtimes">
																	   			<div class="crose_year">
																	    			<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
																	   			</div>
																	  		</div>
																	 	</div>
																	</div>
																</div>
															<?php } ?>
															<div class="row">
															    <div class="col-md-6 peakflow_add_reading_btn">
																 <div class="form-group form_fild_row">

																   <div class="crose_year">
																    <button  type="button"  class="btn currentpeakflowreadingfldadd btn-medium">add Reading</button>
																   </div>
																 </div>
																</div>
															</div>
														</div>

													<?php } ?>
													<?php
														break;

													   case 3:

												 	?>

								  					<div class="row <?php echo $value->id == 302 ? 'chronic_asthma_question_301_302 display_none_at_load_time' : '' ?><?php echo $value->id == 307 ? 'chronic_asthma_question_306_307 display_none_at_load_time' : '' ?><?php echo $value->id == 304 ? 'chronic_asthma_question_303_304 display_none_at_load_time' : '' ?>">
														<div class="col-md-12">
										 					<div class="form-group form_fild_row">
										 						<label><?= $value->question ?>

																<?php $options = unserialize($value->options);?>

										 						<?php if(isset($options[0]) && !empty($options[0])){ ?>
										 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
										 						<?php } ?><?php if(!in_array($value->id ,[316,701])){ ?><span class="required">*</span><?php } ?>
										 						</label>
																<select class="form-control <?php echo 'chronic_asthma_question_'.$value->id; ?>" name="chronic_asthma_detail[<?= $value->id ?>]" style="background: #ececec;" <?php if(!in_array($value->id ,[316,701])){ ?>required="true" <?php } ?> id="">

																<?php

																	if(in_array($value->id ,[316,701])){

																		echo "<option value=''></option>";

																		for($start_year = date('Y'); $start_year >= 1970 ; $start_year--)
																		{

																			echo "<option ".($old_val == $start_year ? 'selected' : '')." value=".$start_year.">".$start_year."</option>";
																		}
																	}
																	else{

																		foreach ($options as $ky => $ve) {

																			echo "<option ".($old_val != '' && $old_val == $ky ? 'selected' : '')." value=".$ky.">".$ve."</option>";
																		}
																	}
																?>
																</select>
										 					</div>
														</div>
													</div>

												<?php
											        break;
													case 2:
												?>
									<div class="row <?php echo $value->id == 290 ? 'chronic_copd_question_289_290 display_none_at_load_time' : '' ?><?php echo $value->id == 314 ? 'chronic_asthma_question_313_314 display_none_at_load_time' : '' ?>">
										<div class="col-md-12">
								 			<div class="form-group form_fild_row <?= ($value->id == 309 || $value->id == 319 || $value->id == 314) ? 'new_appoint_checkbox_quest_a' : '' ?>">
								 					<label><?= $value->question ?>&nbsp;<?php if(!in_array($value->id,[293,309])){ ?><span class="required">*</span><?php } ?></label>
								 					<div class="<?= ($value->id == 309 || $value->id == 319 || $value->id == 314) ? 'new_appoint_checkbox_quest' : '' ?>">
								 						<span></span>
								 						<?php

								 							$options = unserialize($value->options);
														  if($value->id == 293){

															$Other = array_search("Other", $options);
															$donut = $options[$Other];  // If you don't need to keep the value, skip this line
															unset($options[$Other]);
															asort($options);
															$options += array($Other => $donut);
														  }

															?>
													<?php
													 	$temp_old_dqid_val = array();
														$old_36_37_38 = array();
														if(is_array($old_val)){
															foreach ($old_val as $kdq => $vdq) {
																if(($pos = stripos($vdq, '-')) !== false){
																	$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																	// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																	$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																}else{
																	$temp_old_dqid_val[$vdq] = $vdq;
																}
															}
														}

														$old_val = $temp_old_dqid_val;
														//pr($options);
														foreach ($options as $ky => $val) {
						 							?>

															<div class="check_box_bg">
					 											<div class="custom-control custom-checkbox">
			          			<input <?= is_array($old_val) && array_key_exists($val, $old_val)   ? 'checked' : '' ?> class="custom-control-input <?php echo 'chronic_asthma_question_'.$value->id; ?>"  name="chronic_asthma_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_val[$val]) ? $old_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" <?php if(!in_array($value->id,[293,309])){ ?> required="true" <?php } ?>>
			          								<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
			         											</div>
					 										</div>

						 								<?php
						 									$ic++;
								 						}

								 						?>
													</div>
								 				</div>
											</div>
										</div>
													<?php
													break;
														}
													}
												}
						  					?>
						  					<div class="back_next_button">
												<ul>
												<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'asthma'){ ?>
															<li>
																<!-- <button id="chronic_condition-backbtn" type="button" class="btn">Previous tab</button> -->
															<?php if($step_id != 25){?>
																<button id="chronic_condition-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															<?php } ?>
															</li>
														<?php } ?>
												 	<li style="float: right;margin-left: auto;">
												  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
												  		<button type="submit" class="btn" name="sub_tab_name" value="asthma">Next</button>
												 	</li>
												</ul>
											</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										} ?>

										<?php if($active_sub_tab == 'general'){

									   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_23_general'));
								   	 	?>
	  									<div class="tab-pane fade <?php echo $active_sub_tab == 'general' ? 'show active' : ''; ?>" id="chronic-general" role="tabpanel" aria-labelledby="chronic-general-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_chronic_general_detail = '';

												//pr($user_detail_old->chief_compliant_userdetail->chronic_general_detail);die;
												if(!empty($user_detail_old->chief_compliant_userdetail->chronic_general_detail))
									                $old_chronic_general_detail = $user_detail_old->chief_compliant_userdetail->chronic_general_detail;

							  					if(!empty($choronic_general_question)){
													foreach ($choronic_general_question as $key => $value) {

														$old_val = !empty($old_chronic_general_detail[$value->id]) ? $old_chronic_general_detail[$value->id] : '';

														switch ($value->question_type) {

															case 0:  ?>

															<div class="row">
																<div class="col-md-12 <?php echo $value->id == 249 ? 'chronic_general_question_248_249 display_none_at_load_time' : '' ?><?php echo $value->id == 318 ? 'chronic_general_question_317_318 display_none_at_load_time' : ''; ?><?php echo $value->id == 703 ? 'chronic_general_question_702_703 display_none_at_load_time' : ''; ?>" >
						 											<div class="form-group form_fild_row">
						 												<?=  $value->question ?>
						 												<?php if(!empty($value->question)){ ?>
						 												&nbsp;<span class="required">*</span> <?php } ?>

						 												<?php if($value->data_type == 2){ ?>

						 													<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?php echo $old_val; ?>" class="form-control <?php echo 'chronic_general_question_'.$value->id; ?>"  name="chronic_general_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>

																		<?php }
																		else{ ?>
																			<input type="text" value="<?php echo $old_val; ?>" class="form-control <?php echo 'chronic_general_question_'.$value->id; ?>"  name="chronic_general_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id=""/>
																		<?php } ?>
																	</div>
																</div>
															</div>

															<?php
																break;
															case 1:
															if((in_array($value->id, [252,254])) && in_array($step_id,[25,28])){

														continue;
													}
															?>
															<div class="row">
																<div class="col-md-12 <?php echo $value->id == 225 ? 'chronic_dmii_question_240_225 display_none_at_load_time' : ''; ?> <?php echo $value->id == 247 ? 'chronic_general_question_246_247 display_none_at_load_time' : ''; ?>">
																	<div class="form-group form_fild_row">
							 											<div class="radio_bg">
								          									<label><?= $value->question ?>
								          									&nbsp;<span class="required">*</span></label>

																			<div class="radio_list">
																			<?php
																				$options = unserialize($value->options);

																				foreach ($options as $k => $v) {
																					?>
							        												<div class="form-check">
							         													<input type="radio"  value="<?= $v ?>" <?= $old_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'chronic_general_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="chronic_general_detail[<?= $value->id ?>]"  required="true">
							         													<label class="form-check-label" for="radio_question<?= $i ?>">
							         														<?= $v ?>
							         													</label>
							       													</div>
																				<?php
																					$i++ ;
																				}
																				?>
																			</div>
							   											</div>
											 						</div>
																</div>
															</div>
															<?php
																break;

															   case 3:

														 	?>

										  					<div class="row">
																<div class="col-md-12 <?php echo $value->id == 253 ? 'chronic_general_question_252_253 display_none_at_load_time' : '' ?><?php echo $value->id == 253 ? 'chronic_general_question_252_253 display_none_at_load_time' : '' ?> <?php echo $value->id == 255 ? 'chronic_general_question_254_255 display_none_at_load_time' : '' ?> <?php echo $value->id == 250 ? 'chronic_general_question_246_250 display_none_at_load_time' : '' ?> <?php echo $value->id == 251 ? 'chronic_general_question_246_251 display_none_at_load_time' : '' ?> <?php echo $value->id == 260 ? 'chronic_general_question_258_coffee display_none_at_load_time' : '' ?> <?php echo $value->id == 261 ? 'chronic_general_question_258_energy_drinks display_none_at_load_time' : '' ?> <?php echo $value->id == 262 ? 'chronic_general_question_258_green_black_tea display_none_at_load_time' : '' ?><?php echo $value->id == 316 ? 'chronic_general_question_315_316 display_none_at_load_time' : '' ?><?php echo $value->id == 701 ? 'chronic_general_question_700_701 display_none_at_load_time' : '' ?>">

												 					<div class="form-group form_fild_row">
												 						<label><?= $value->question ?>

																		<?php $options = unserialize($value->options);?>

												 						<?php if(isset($options[0]) && !empty($options[0])){ ?>
												 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
												 						<?php } ?><?php if(!in_array($value->id ,[316,701])){ ?><span class="required">*</span><?php } ?>
												 						</label>

																		<select class="form-control <?php echo 'chronic_general_question_'.$value->id; ?>" name="chronic_general_detail[<?= $value->id ?>]" style="background: #ececec;" <?php if(!in_array($value->id ,[316,701])){ ?> required="true" <?php } ?> id="">


																		<?php
																		if(in_array($value->id ,[316,701])){

																			echo "<option value=''></option>";

																			for($start_year = date('Y'); $start_year >= 1970 ; $start_year--)
																			{

																				echo "<option ".($old_val == $start_year ? 'selected' : '')." value=".$start_year.">".$start_year."</option>";
																			}
																		}
																		else{

																			if(in_array($value->id ,[316,701])){

																				echo "<option value=''></option>";

																				for($start_year = date('Y'); $start_year >= 1970 ; $start_year--)
																				{

																					echo "<option ".($old_val == $start_year ? 'selected' : '')." value=".$start_year.">".$start_year."</option>";
																				}
																			}
																			else{


																				foreach ($options as $ky => $ve) {

																					echo "<option ".($old_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";

																				}
																			}
																		}
																		?>
																		</select>
												 					</div>
																</div>
															</div>

														<?php
													        break;
															case 2:
														?>

															<div class="row <?php echo $value->id == 259 ? 'chronic_general_question_258_259 display_none_at_load_time' : '' ?><?php echo $value->id == 319 ? 'chronic_general_question_315_319 display_none_at_load_time' : '' ?>">
																<div class="col-md-12 <?php echo $value->id == 248 ? 'chronic_general_question_246_248 display_none_at_load_time' : '' ?> ">
														 			<div class="form-group form_fild_row <?= ($value->id == 244 || $value->id == 248 || $value->id == 259 || $value->id == 268 || $value->id == 269) ? 'new_appoint_checkbox_quest_a' : '' ?>">

														 					<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
														 					<div class="<?= ($value->id == 244 || $value->id == 248 || $value->id == 259 || $value->id == 268 || $value->id == 269 || $value->id == 319) ? 'new_appoint_checkbox_quest' : '' ?>">
														 						<span></span>
														 						<?php
														 							$options = unserialize($value->options) ; ?>
																			<?php
																			 	$temp_old_dqid_val = array();
																				$old_36_37_38 = array();
																				if(is_array($old_val)){
																					foreach ($old_val as $kdq => $vdq) {
																						if(($pos = stripos($vdq, '-')) !== false){
																							$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																							// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																							$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																						}else{
																							$temp_old_dqid_val[$vdq] = $vdq;
																						}
																					}
																				}

																				$old_val = $temp_old_dqid_val;

																				foreach ($options as $ky => $val) {

																					if($value->id == 244 && strtolower($val) == 'high potassium' && $is_show_potassium_opt == 0){

																						continue;
																					}
												 							?>

																					<div class="check_box_bg">
											 											<div class="custom-control custom-checkbox">
									          												<input <?= is_array($old_val) && array_key_exists($val, $old_val)   ? 'checked' : '' ?> class="custom-control-input <?php echo 'chronic_general_question_'.$value->id; ?>"  name="chronic_general_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_val[$val]) ? $old_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="true">
									          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
									         											</div>
											 										</div>

												 								<?php
												 									$ic++;
														 						}

														 						?>
																			</div>
														 				</div>
																	</div>
																</div>
															<?php
															break;
																}
															}
														}
								  					?>

	  											<div class="back_next_button">
													<ul>
													 	<li style="float: right;margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="general">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											}
										?>

										<!-- internal assessment -->
								  	<?php //if(in_array('cad', $old_chronic_condition)){
								   	if($step_id == 25 || $step_id == 28){
									   		echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_34_general'));
								   	?>
	  								<div class="tab-pane fade <?php echo $active_sub_tab == 'general_tap' ? 'show active' : ''; ?>" id="general-assessment" role="tabpanel" aria-labelledby="general-assessment-tab">

	  										<?php
                  								$i = 0;
                  								$ic = 0;
												$cb_class = '';
												$old_gen_internal_medication = '';
												//pr($internal_general_assessment_question);
												if(!empty($user_detail_old->chief_compliant_userdetail->internal_general_assessment_detail))
									                $old_gen_internal_medication = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->internal_general_assessment_detail), SEC_KEY));
									            //pr($internal_general_assessment_question);

							  					if(!empty($internal_general_assessment_question)){
													foreach ($internal_general_assessment_question as $key => $value) {

														 $old_dqid_val = !empty($old_gen_internal_medication[$value->id]) ? $old_gen_internal_medication[$value->id] : '';
														//pr($old_dqid_val);

														switch ($value->question_type) {
															case 1:
															?>
																<div class="col-md-12">
																	<div class="form-group form_fild_row">
							 											<div class="radio_bg">
								          									<label><?= str_replace("***", "coronary artery disease", $value->question) ?>
								          									&nbsp;<span class="required">*</span></label>

																			<div class="radio_list">
																			<?php
																				$options = unserialize($value->options);

																				foreach ($options as $k => $v) {
																					?>
							        												<div class="form-check">
							         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'internal_med_general_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="internal_general_assessment_detail[<?= $value->id ?>]"  required="true">
							         													<label class="form-check-label" for="radio_question<?= $i ?>">
							         														<?= $v ?>
							         													</label>
							       													</div>
																				<?php
																					$i++ ;
																				}
																				?>
																			</div>
							   											</div>
											 						</div>
																</div>
															<?php
															break;
						           case 2:
							?>
									<div class="col-md-12">
										<div class="form-group form_fild_row  <?= ($value->id == 568) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 						<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 						<div class="<?= ($value->id == 568) ? 'new_appoint_checkbox_quest' : '' ?>">
					 						<span></span>
					 						<?php
									 		$options = unserialize($value->options) ;
 											$temp_old_dqid_val = array();
											$old_36_37_38 = array();
											if(!empty($old_dqid_val) && is_array($old_dqid_val)){
												foreach ($old_dqid_val as $kdq => $vdq) {
													if(($pos = stripos($vdq, '-')) !== false){
														$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
														// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

														$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
													}else{
														$temp_old_dqid_val[$vdq] = $vdq;
													}
												}
											}

											$old_dqid_val = $temp_old_dqid_val;
											foreach ($options as $ky => $val) {
			 								?>
												<div class="check_box_bg">
		 											<div class="custom-control custom-checkbox">
          												<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo $value->id == 2 ? "other_detail_question_2" : ""; ?>"  name="internal_general_assessment_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" subques="<?= !empty($old_36_37_38[$val]) ? $old_36_37_38[$val] : '' ?>" type="checkbox" required="required">
          												<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         											</div>
		 										</div>


								 			<?php
								 				$ic++;
										 	}


										 	?>

										</div>
					 				</div>
								</div>
								<?php break;
									case 3:
							 	?>

									<div class="col-md-12 <?= in_array($value->id,[569,570]) ? 'display_none_at_load_time int_gen_med_607_'.$value->id : ''  ?>">
					 					<div class="form-group form_fild_row">
					 						<label><?= $value->question;  ?>

											<?php $options = unserialize($value->options); $options = array('' =>'' , ) + $options;?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control" name="internal_general_assessment_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">

											<?php

												foreach ($options as $ky => $ve) {
													echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value="."'".$ve."'".">".$ve."</option>";

													// echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>
									<?php break;
																}
															}
														}
								  					?>

	  											<div class="back_next_button">
													<ul>

														<?php //if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'cad'){ ?>
															<li>
																<button id="<?= $is_cc_doctor_or_not == "Yes" ? "internal_medicine_detail-backbtn" : "internal_medicine_cc-backbtn" ?>" type="button" class="btn nofillborder">Previous tab</button>
															</li>
														<?php //} ?>
													 	<li style="float: right;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="general_tap">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											//}
										} ?>

								<!-- TAPS1 -->
								<?php
								echo $this->Form->create(null , array(   'autocomplete' => 'off',
									'inputDefaults' => array(
									'label' => false,
									'div' => false,
									),'enctype' => 'multipart/form-data', 'id' => 'form_tab_34_taps1'));
								   	?>
	  								<div class="tab-pane fade <?php echo $active_sub_tab == 'taps1' ? 'show active' : ''; ?>" id="taps1-assessment" role="tabpanel" aria-labelledby="taps1-assessment-tab">

	  									<?php
                  								// $i = 0;
                  								// $ic = 0;
												$cb_class = '';
												$old_taps1_internal_medication = '';
											//pr($internal_taps1_assessment_question);
											if(!empty($user_detail_old->chief_compliant_userdetail->internal_taps1_assessment_detail))
									                $old_taps1_internal_medication = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->internal_taps1_assessment_detail), SEC_KEY));
									//pr($old_taps1_internal_medication); echo'klhjkh';

							  		if(!empty($internal_taps1_assessment_question)){
							  			//pr($login_user['gender']);
										foreach ($internal_taps1_assessment_question as $key => $value) {

											$old_dqid_val = !empty($old_taps1_internal_medication[$value->id]) ? $old_taps1_internal_medication[$value->id] : '';
														// pr($old_dqid_val);

											switch ($value->question_type) {
													case 3:
										if($login_user['gender'] == 0 && (in_array($value->id, [572])) || $login_user['gender'] == 1 && (in_array($value->id, [573]))){

											continue;
										}

											 	?>

									<div class="col-md-12">
					 					<div class="form-group form_fild_row">
					 						<label><?= $value->question;  ?>

											<?php $options = unserialize($value->options); $options = array('' =>'' , ) + $options;?>

					 						<?php if(isset($options[0])){ ?>
					 							<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>"></a>
					 						<?php } ?><span class="required">*</span>
					 						</label>

											<select class="form-control" name="internal_taps1_assessment_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">

											<?php

												foreach ($options as $ky => $ve) {

													echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value="."'".$ve."'".">".$ve."</option>";
													// for 15 id we will send the value as the select box value
												}
											?>
											</select>
					 					</div>
									</div>
									<?php break;
													}
												}

								  		?>

	  											<div class="back_next_button">
													<ul>

														<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'taps1'){ ?>
															<li>
																<button id="internal_assessment-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															</li>
														<?php } ?>
													 	<li style="float: right; margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="taps1">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											//}
										} ?>
										<!-- End TAPS1 -->

								<!-- TAPS2 -->
									<?php
									echo $this->Form->create(null , array(   'autocomplete' => 'off',
												'inputDefaults' => array(
												'label' => false,
												'div' => false,

												),'enctype' => 'multipart/form-data', 'id' => 'form_tab_34_tabs2'));
								   	?>
	  								<div class="tab-pane fade <?php echo $active_sub_tab == 'taps2' ? 'show active' : ''; ?>" id="taps2-assessment" role="tabpanel" aria-labelledby="taps2-assessment-tab">
	  										<?php
                  								// $i = 0;
                  								// $ic = 0;
												$cb_class = '';
												$old_taps1_internal_medication = '';
												$old_taps2_internal_medication = '';
												if(!empty($user_detail_old->chief_compliant_userdetail->internal_taps2_assessment_detail))
									                $old_taps2_internal_medication = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->internal_taps2_assessment_detail), SEC_KEY));
									            if(!empty($user_detail_old->chief_compliant_userdetail->internal_taps1_assessment_detail))
									                $old_taps1_internal_medication = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->internal_taps1_assessment_detail), SEC_KEY));
									            // pr($old_taps1_internal_medication); die;
							  					if(!empty($internal_taps2_assessment_question)){
													foreach ($internal_taps2_assessment_question as $key => $value) {

														 $old_dqid_val = !empty($old_taps2_internal_medication[$value->id]) ? $old_taps2_internal_medication[$value->id] : '';
														switch ($value->question_type) {
															case 0:
															if((isset($old_taps1_internal_medication[574]) && $old_taps1_internal_medication[574] == "Never") && in_array($value->id, [603])){

																	continue;
																}
															?><div class="<?php echo in_array($value->id,[603]) ? " display_none_at_load_time internal_medication_taps2_question_602_603": ""; ?>">
																 					<div class="form-group form_fild_row">
																 						<label>
																						<?= $value->question ?>&nbsp;<span class="required">*</span>
																						</label>

																						<input type="text" value="<?= !empty($old_dqid_val) ? $old_dqid_val :'' ?>" class="form-control internal_taps2_question_<?= $value->id ?>"  name="internal_taps2_assessment_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" id="<?php echo 'question_'.$value->id; ?>"/>

																 					</div>
																				</div>
																<?php
																break;
															case 1:
															if($login_user['gender'] == 0 && (in_array($value->id, [581])) || $login_user['gender'] == 1 && (in_array($value->id, [580]))){

																	continue;
																}
																if(!empty($old_taps1_internal_medication ) && (in_array($value->id, [576])) && $old_taps1_internal_medication[571] == "Never"){

																	continue;
																}
																if(isset($old_taps1_internal_medication[572]) && $old_taps1_internal_medication[572] == "Never" && in_array($value->id, [579])){

																	continue;
																}
																if(isset($old_taps1_internal_medication[573]) && $old_taps1_internal_medication[573] == "Never" && in_array($value->id, [579])){

																	continue;
																}
																if((isset($old_taps1_internal_medication[574]) && $old_taps1_internal_medication[574] == "Never") && in_array($value->id, [584,587,590,602])){

																	continue;
																}
																if((isset($old_taps1_internal_medication[575 ]) && $old_taps1_internal_medication[575] == "Never") && in_array($value->id, [593,596,599])){

																	continue;
																}
															?>
															<div class="row internal_taps1_ass_<?= $value->id ?> <?= in_array($value->id, [577,578]) ? 'display_none_at_load_time internal_medication_taps2_question_576_577_578':''?> <?= in_array($value->id, [580,581,582,583]) ? 'display_none_at_load_time internal_medication_taps2_question_579_580_581_582_583':''?><?= in_array($value->id, [585,586]) ? 'display_none_at_load_time internal_medication_taps2_question_584_585_586':''?><?= in_array($value->id, [588,589]) ? 'display_none_at_load_time internal_medication_taps2_question_587_588_589':''?> <?= in_array($value->id, [591,592]) ? ' display_none_at_load_time internal_medication_taps2_question_590_591_592':''?><?= in_array($value->id, [594,595]) ? 'display_none_at_load_time internal_medication_taps2_question_593_594_595':''?><?= in_array($value->id, [597,598]) ? 'display_none_at_load_time internal_medication_taps2_question_596_597_598':''?><?= in_array($value->id, [600,601]) ? 'display_none_at_load_time internal_medication_taps2_question_599_600_601':''?>">
																<div class="col-md-12">
																	<div class="form-group form_fild_row">
							 											<div class="radio_bg">
								          									<label><?= $value->question ?>
								          									&nbsp;<span class="required">*</span></label>
																			<div class="radio_list">
																			<?php
																				$options = unserialize($value->options);

																				foreach ($options as $k => $v) {
																					?>
							        												<div class="form-check">
							         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'internal_taps2_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="internal_taps2_assessment_detail[<?= $value->id ?>]"  required="true">
							         													<label class="form-check-label" for="radio_question<?= $i ?>">
							         														<?= $v ?>
							         													</label>
							       													</div>
																				<?php
																					$i++ ;
																				}
																				?>
																			</div>
							   											</div>
											 						</div>
																</div>
															</div>
															<?php
															break;
							?>
									<?php
																}
															}

								  					?>

	  											<div class="back_next_button">
													<ul>

														<?php if(!empty($old_chronic_condition) && is_array($old_chronic_condition) && current($old_chronic_condition) == 'taps2'){ ?>
															<li>
																<button id="internal_assessment-backbtn" type="button" class="btn nofillborder">Previous tab</button>
															</li>
														<?php } ?>
													 	<li style="float: right; margin-left: auto;">
													  		<!-- <button type="button" class="btn go_to_part_comm">Next</button> -->
													  		<button type="submit" class="btn" name="sub_tab_name" value="taps2">Next</button>
													 	</li>
													</ul>
												</div>

										</div>
										<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
										<input type="hidden" name="tab_number" value="23">
										<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

										<?php $this->Form->end() ;

											//}
										} ?>
										<!-- End TAPS2 -->
										<!-- End -->

								</div>
				 			</div>
						</div>
			   		</div>
			  	</div>
			</div>

   <?php //$this->Form->end() ;
}
   ?>


    <?php

if(in_array(24, $current_steps) && $tab_number == 24){

	//$chronicCondition = array('cad' =>'Coronary artery disease','chf' =>'Congestive heart failure','copd' =>'Chronic obstructive pulmonary disease','dmii' =>'Diabetes','htn'=>'Hypertension','other' =>'Other');

	if(!empty($user_detail_old->chief_compliant_userdetail->chronic_condition))

		$old_chronic_condition = $user_detail_old->chief_compliant_userdetail->chronic_condition ;
		$old_chronic_condition = isset($old_chronic_condition)?$old_chronic_condition:'';


		$ic = 1;

     	 echo $this->Form->create(null , array('autocomplete' => 'off',
							'inputDefaults' => array(
							'label' => false,
							'div' => false,
							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_24')); ?>
		  <div class="tab-pane fade  <?= ($tab_number==24  || 24==$current_steps[0])  ? '  show active ' : '' ?>" id="chronic_condition" role="tabpanel" aria-labelledby="chronic_condition-tab">
		  	<div class="errorHolder">
  			</div>
			<div class="TitleHead header-sticky-tit">
			   <h3>What are you coming in for today?<br></h3>
			   <div class="seprator"></div>
			</div>
			<div class="tab_form_fild_bg">
				 <!-- <div class="row">	 -->
						 <?php
						 foreach($chronicCondition as $key =>$value){
						 ?>
						<div class="check_box_bg">
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input" <?= is_array($old_chronic_condition) && in_array($key, $old_chronic_condition)   ? 'checked' : '' ?>  name="chronic_condition[]" value="<?php echo $key ?>" id="<?php echo $key?>"  type="checkbox" required="true">
								<label class="custom-control-label" for="<?php echo $key?>"><?php echo $value ?></label>
							</div>
						</div>
						<?php }?>


			  <!--  </div>		 -->
		   <div class="back_next_button">
			<ul>
			 <li style="float: right;margin-left: auto;">
			  <button type="submit" class="btn details_next">Next</button>
			 </li>

			</ul>
		   </div>

		</div>
	</div>
		<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
		<input type="hidden" name="tab_number" value="24">
		<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ; ?>
<?php }
 ?>



<?php

if(in_array(25, $current_steps) && $tab_number == 25){

	$old_chief_compliant_details = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->cancer_cc_detail))
		$old_chief_compliant_details = $user_detail_old->chief_compliant_userdetail->cancer_cc_detail;

	//pr($old_chief_compliant_details);
	$ic = 1;
    echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_25')); ?>
	<div class="tab-pane fade  <?= ($tab_number==25  || 25==$current_steps[0])  ? '  show active ' : '' ?>" id="cancer_cc" role="tabpanel" aria-labelledby="cancer_cc-tab">
		<div class="errorHolder">
  		</div>
		<div class="TitleHead header-sticky-tit">
			<h3>Chief Complaint Details</h3>
			<div class="seprator"></div>
		</div>

		<div class="tab_form_fild_bg">
			<div class="row">
				<?php
					$i = 0 ;
					$cb_class = '';
					if(!empty($cancer_cc_question)){
						foreach ($cancer_cc_question as $key => $value) {

							//client requirement we dont have to show question 333
							if($value->id == 333){
								continue;
							}


							$old_dqid_val = !empty($old_chief_compliant_details) && isset($old_chief_compliant_details[$value->id]) ? $old_chief_compliant_details[$value->id] : '';

							switch ($value->question_type) {
								case 0:	?>

									<div class="col-md-12 <?php echo $value->id == 322 ? 'cancer_cc_question_321_322 display_none_at_load_time' : ''; ?><?php echo $value->id == 324 ? 'cancer_cc_question_323_324 display_none_at_load_time' : ''; ?><?php echo $value->id == 326 ? 'cancer_cc_question_325_326 display_none_at_load_time' : ''; ?><?php echo $value->id == 330 ? 'cancer_cc_question_329_330 display_none_at_load_time' : ''; ?>">
					 					<div class="form-group form_fild_row">
					 						<label>
					 							<?= $value->question ?>&nbsp;<span class="required">*</span>
					 						</label>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'cancer_cc_question_'.$value->id; ?>"  name="cancer_cc_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
 										</div>
									</div>

							<?php
									break;
								case 1:  ?>

										<div class="col-md-12">
				 							<div class="form-group form_fild_row">
 												<div class="radio_bg">
          											<label>
          												<?= $value->question ?>&nbsp;<span class="required">*</span>
          											</label>
													<div class="radio_list">
														<?php
														$options = unserialize($value->options) ;
														foreach ($options as $k => $v) {
														?>
	        												<div class="form-check">
	         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'cancer_cc_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="cancer_cc_detail[<?= $value->id ?>]"  required="true">
	         													<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
	       													</div>
														<?php
															$i++ ;
														}
														?>
													</div>
    											</div>
				 							</div>
										</div>
									<?php
										    break;
										case 3: ?>

											<div class="col-md-12">
					 							<div class="form-group form_fild_row">
					 								<label>
					 									<?= $value->question ?>
														<?php
														$options = unserialize($value->options) ; ?>
													 	<?php if(isset($options[0]) && !empty($value->question)){ ?>
													 		<?php if(!empty($options[0])){ ?>
														 		<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">

														 		<i class="fa fa-question-circle" aria-hidden="true"></i></a>
														 	<?php } ?>
													 		<span class="required">*</span>
													 	<?php } ?>
					 								</label>
					 								<!-- style="background: #ececec;" -->
													<select class="form-control <?php echo 'cancer_cc_question_'.$value->id; ?>" name="cancer_cc_detail[<?= $value->id ?>]"  required="true" id="question_<?= $value->id ?>">
														<?php if($value->id == 64 ||$value->id == 69 ||$value->id == 70){

															foreach ($options as $ky => $ve) {

																if($value['id'] == 66 || $value['id'] == 98 || $value['id'] == 100 || $value['id'] == 104 || $value['id'] == 77){
																	echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".$ky.">".$ve."</option>";
																	 // for 15 id we will send the value as the select box value

																}
																else{

																	echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".$ky.">".$ve."</option>";
																	 // for 15 id we will send the value as the select box value
																}
															}

														}else{ ?>

														<?php

															foreach ($options as $ky => $ve) {

																if($value['id'] == 66 || $value['id'] == 98 || $value['id'] == 100 || $value['id'] == 104 || $value['id'] == 77){

																	echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>"; // for 15 id we will send the value as the select box value
																}
																else{

																	echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>"; // for 15 id we will send the value as the select box value
																	}
																}
														}
														?>
													</select>
					 							</div>
											</div>
										<?php
										     	break;
										    case 2:
										?>
												<div class="col-md-12 <?php echo $value->id == 321 ? 'cancer_cc_question_320_321 display_none_at_load_time' : ''; ?><?php echo $value->id == 328 ? 'cancer_cc_question_327_328 display_none_at_load_time' : ''; ?><?php echo $value->id == 323 ? 'cancer_cc_question_332_323 display_none_at_load_time' : ''; ?><?php echo $value->id == 325 ? 'cancer_cc_question_332_325 display_none_at_load_time' : ''; ?>">
					 								<div class="form-group form_fild_row <?= in_array($value->id, [321,323,325,328,332]) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 									<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 									<div class="<?= in_array($value->id, [321,323,325,328,332]) ? 'new_appoint_checkbox_quest' : '' ?>">
					 										<span></span>
					 										<?php
					 											$options = unserialize($value->options) ;
 																$temp_old_dqid_val = array();
																$old_36_37_38 = array();
																if(is_array($old_dqid_val)){
																	foreach ($old_dqid_val as $kdq => $vdq) {
																		if(($pos = stripos($vdq, '-')) !== false){
																			$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																			// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																			$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																		}else{
																			$temp_old_dqid_val[$vdq] = $vdq;
																		}
																	}
																}

																$old_dqid_val = $temp_old_dqid_val;
																//pr($old_dqid_val);
																foreach ($options as $ky => $val) {
			 												?>
																	<div class="check_box_bg">
		 																<div class="custom-control custom-checkbox">
          																	<input <?php
          																			if($value->id == 321){

          																				echo is_array($old_dqid_val) && in_array($val, $old_dqid_val)   ? 'checked' : '';
          																			}
          																			else{

          																				echo is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '';
          																			}
          																	 ?>
          																	class="custom-control-input <?= $cb_class ?> <?php echo 'cancer_cc_question_'.$value->id; ?>"  name="cancer_cc_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required">
          																	<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         																</div>
		 															</div>

													 			<?php
													 				$ic++;
															 	}
															 	?>
															</div>
					 									</div>
													</div>

												<?php
													break;
												}
											}
										}
									?>
			   					</div>

			   					<!-- <div class="tab_form_fild_bg"> -->
								    <div class="TitleHead header-sticky-tit">
									 <h3>Current medication</h3>
									</div>
								<!-- </div> -->
								<div class="tab_form_fild_bg">

								<!-- fill the old data when edited start ******************************************************  -->
								<?php
								if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail)){
									$cmd_old = $user_detail_old->chief_compliant_userdetail->compliant_medication_detail;

									foreach ($cmd_old as $ky => $ve) {

								?>

								<div class="row  currentmedicationfld">
									<div class="col-md-4">
										<div class="form-group form_fild_row">
											<div class="custom-drop">
												<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
									      		<ul class="med_suggestion_listul custom-drop-li">
												</ul>
											</div>
									    </div>
									</div>
									<div class="col-md-2">
										 <div class="form-group form_fild_row">
										  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
										 </div>
										</div>

									<div class="col-md-2">
									 <div class="form-group form_fild_row">
									  <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->

									<select class="form-control" name="medication_how_often[]">
										<option value="">how often?</option>
									<?php
											foreach ($length_arr as $key => $value) {

										echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

											}
										?>
										</select>

									 </div>
									</div>
								    <div class="col-md-3">
									 <div class="form-group form_fild_row">


					<div class="custom-drop">

					<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
						      <ul class="how_taken_suggestion_listul custom-drop-li">
								</ul>

							</div>



									 </div>
									</div>


								<div class="col-md-1">
							     <div class="row">

								  <div class=" currentmedicationfldtimes">
								   <div class="crose_year">
								    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
								   </div>
								  </div>
								 </div>
								</div>
							   </div>
							<?php
							}
							}

							?>
							<!-- fill the old data when edited end ******************************************************* -->

					   <div class="row currentmedicationfld">

					   </div>

					<div class="row">
						    <div class="col-md-6">
							 <div class="form-group form_fild_row">

							   <div class="crose_year">
							    <button  type="button"  class="btn currentmedicationfldadd btn-medium">add a medication</button>
							   </div>


							 </div>
							</div>
						</div>

								<div class="back_next_button">
									<ul>
										<!-- <li>
									  		<button id="cancer_cc-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
									 	</li> -->
									 	<li style="float: right;margin-left: auto;">

									  		<button type="submit" class="btn details_next">Next</button>
									 	</li>
									</ul>
			   					</div>
			  				</div>
			 			</div>
		  				<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 			<input type="hidden" name="tab_number" value="25">
			 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ;

}
?>

<?php

if(in_array(26, $current_steps) && $tab_number == 26){

	$old_cancer_history_detail = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->cancer_history_detail))
		$old_cancer_history_detail = $user_detail_old->chief_compliant_userdetail->cancer_history_detail;

	$old_cancer_chief_compliant = strtolower($cur_cancer_chief_compliant == 'throat cancer (esophageal)' ? "esophageal cancer" : $cur_cancer_chief_compliant);
	//pr($old_cancer_history_detail);
	$ic = 1;
    echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_26')); ?>
	<div class="tab-pane fade  <?= ($tab_number==26 || 26==$current_steps[0])  ? '  show active ' : '' ?>" id="cancer_history" role="tabpanel" aria-labelledby="cancer_history-tab">
		<div class="errorHolder">
  		</div>
		<div class="TitleHead header-sticky-tit">
			<h3><?php echo ucfirst($cur_cancer_chief_compliant); ?> Details</h3>
			<div class="seprator"></div>
		</div>

		<div class="tab_form_fild_bg">
			<div class="row">
				<?php
					$i = 0 ;
					$cb_class = '';
					//pr($old_cancer_history_detail);
					if(!empty($cancer_history_question)){
						foreach ($cancer_history_question as $key => $value) {

							if($old_cancer_chief_compliant == 'throat cancer (esophageal)'){

					          $old_cancer_chief_compliant = 'esophageal cancer';
					        }
					        elseif($old_cancer_chief_compliant == 'colon-rectal cancer'){

					          $old_cancer_chief_compliant = 'colon cancer';
					        }
							$old_dqid_val = !empty($old_cancer_history_detail) && isset($old_cancer_history_detail[$old_cancer_chief_compliant]) && isset($old_cancer_history_detail[$old_cancer_chief_compliant][$value->id]) ? $old_cancer_history_detail[$old_cancer_chief_compliant][$value->id] : '';

							switch ($value->question_type) {
								case 0:	?>

									<div class="col-md-12 <?php echo $value->id == 372 ? 'cancer_history_question_334_372 display_none_at_load_time' : ''; ?><?php echo $value->id == 395 ? 'cancer_history_question_393_395 display_none_at_load_time' : ''; ?><?php echo $value->id == 401 ? 'cancer_history_question_400_401 display_none_at_load_time' : ''; ?><?php echo $value->id == 406 ? 'cancer_history_question_405_406 display_none_at_load_time' : ''; ?><?php echo $value->id == 409 ? 'cancer_history_question_408_409 display_none_at_load_time' : ''; ?><?php echo $value->id == 412 ? 'cancer_history_question_411_412 display_none_at_load_time' : ''; ?><?php echo $value->id == 415 ? 'cancer_history_question_414_415 display_none_at_load_time' : ''; ?><?php echo $value->id == 427 ? 'cancer_history_question_426_427 display_none_at_load_time' : ''; ?><?php echo $value->id == 418 ? 'cancer_history_question_417_418 display_none_at_load_time' : ''; ?><?php echo $value->id == 421 ? 'cancer_history_question_420_421 display_none_at_load_time' : ''; ?><?php echo $value->id == 430 ? 'cancer_history_question_429_430 display_none_at_load_time' : ''; ?><?php echo $value->id == 424 ? 'cancer_history_question_423_424 display_none_at_load_time' : ''; ?><?php echo $value->id == 450 ? 'cancer_history_question_449_450 display_none_at_load_time' : ''; ?><?php echo $value->id == 454 ? 'cancer_history_question_453_454 display_none_at_load_time' : ''; ?><?php echo $value->id == 446 ? 'cancer_history_question_445_446 display_none_at_load_time' : ''; ?><?php echo $value->id == 442 ? 'cancer_history_question_440_442 display_none_at_load_time' : ''; ?><?php echo $value->id == 435 ? 'cancer_history_question_433_435 display_none_at_load_time' : ''; ?><?php echo $value->id == 436 ? 'cancer_history_question_433_436 display_none_at_load_time' : ''; ?><?php echo $value->id == 437 ? 'cancer_history_question_433_437 display_none_at_load_time' : ''; ?>
									<?php echo $value->id == 551 ? 'cancer_history_question_343_551 display_none_at_load_time' : ''; ?><?php echo $value->id == 552 ? 'cancer_history_question_343_552 display_none_at_load_time' : ''; ?><?php echo $value->id == 553 ? 'cancer_history_question_343_553 display_none_at_load_time' : ''; ?><?php echo $value->id == 554 ? 'cancer_history_question_343_554 display_none_at_load_time' : ''; ?><?php echo $value->id == 555 ? 'cancer_history_question_343_555 display_none_at_load_time' : ''; ?>">
					 					<div class="form-group form_fild_row">
					 						<label>
					 							<?= $value->question ?>&nbsp;<?php if(!in_array($value->id, ['551','552','553','554','555'])){ ?><span class="required">*</span><?php }?>
					 						</label>
					 						<?php if($value->data_type == 2){ ?>

												<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'cancer_history_question_'.$value->id; ?>"  name="cancer_history_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>"/>
											<?php } else {
												?>
												<input type="text" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'cancer_history_question_'.$value->id; ?>"  name="cancer_history_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" <?php if(!in_array($value->id, ['551','552','553','554','555'])){?> required="true" <?php }?>/>
												<?php
											}
											?>


 										</div>
									</div>

							<?php
									break;
								case 1:  ?>
										<div class="col-md-12 <?php echo $value->id == 341 ? 'cancer_history_que_341_section' : ''; ?><?php echo $value->id == 338 ? 'cancer_history_question_336_338 display_none_at_load_time' : ''; ?><?php echo $value->id == 394 ? 'cancer_history_question_393_394 display_none_at_load_time' : ''; ?>">
				 							<div class="form-group form_fild_row">
 												<div class="radio_bg">
          											<label>
          												<?= $value->question ?>&nbsp;<span class="required">*</span>
          											</label>
													<div class="radio_list">
														<?php
														$options = unserialize($value->options) ;
														foreach ($options as $k => $v) {
														?>
	        												<div class="form-check">
	         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'cancer_history_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="cancer_history_detail[<?= $value->id ?>]"  required="true">
	         													<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
	       													</div>
														<?php
															$i++ ;
														}
														?>
													</div>
    											</div>
				 							</div>
										</div>
									<?php
										    break;
										case 3: ?>

											<div class="col-md-12 <?php echo $value->id == 337 ? 'cancer_history_question_336_337 display_none_at_load_time' : ''; ?> <?php echo $value->id == 505 ? 'cancer_history_question_334_505 display_none_at_load_time' : ''; ?><?php echo $value->id == 507 ? 'cancer_history_question_334_507 display_none_at_load_time' : ''; ?><?php echo $value->id == 508 ? 'cancer_history_question_334_508 display_none_at_load_time' : ''; ?><?php echo $value->id == 509 ? 'cancer_history_question_334_509 display_none_at_load_time' : ''; ?><?php echo $value->id == 510 ? 'cancer_history_question_334_510 display_none_at_load_time' : ''; ?><?php echo $value->id == 511 ? 'cancer_history_question_334_511 display_none_at_load_time' : ''; ?><?php echo $value->id == 513 ? 'cancer_history_question_334_513 display_none_at_load_time' : ''; ?><?php echo $value->id == 514 ? 'cancer_history_question_334_514 display_none_at_load_time' : ''; ?><?php echo $value->id == 515 ? 'cancer_history_question_334_515 display_none_at_load_time' : ''; ?>">
					 							<div class="form-group form_fild_row">
					 								<label>
					 									<?= $value->question ?>
														<?php
														$options = unserialize($value->options) ; ?>
													 	<?php if(isset($options[0]) && !empty($value->question)){ ?>
													 		<?php if(!empty($options[0])){ ?>
														 		<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">

														 		<i class="fa fa-question-circle" aria-hidden="true"></i></a>
														 	<?php } ?>

													 	<?php } ?>
													 	<span class="required">*</span>
					 								</label>

													<select class="form-control <?php echo 'cancer_history_question_'.$value->id; ?>" name="cancer_history_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">
														<?php if(in_array($value->id, [335,337,396,505,507,508,509,510,511,513,514,515])){ ?>

															<option value="">How long?</option>
															<option <?php echo $old_dqid_val == '1 hour' ? 'selected' : '' ?> value="1 hour">1 hour</option>
															<option <?php echo $old_dqid_val == '2 hours' ? 'selected' : '' ?> value="2 hours">2 hours</option>
															<option <?php echo $old_dqid_val == '3 hours' ? 'selected' : '' ?> value="3 hours">3 hours</option>
															<option <?php echo $old_dqid_val == '6 hours' ? 'selected' : '' ?> value="6 hours">6 hours</option>
															<option <?php echo $old_dqid_val == '12 hours' ? 'selected' : '' ?> value="12 hours">12 hours</option>

															<?php
																for ($start_day=1; $start_day < 14 ; $start_day++) {
																	?>
															<option <?php echo $old_dqid_val == $start_day. ($start_day>1 ?' days' : ' day') ? 'selected' : '' ?> value="<?php echo  $start_day. ($start_day>1 ?' days' : ' day') ?>"><?php echo  $start_day. ($start_day>1 ?' days' : ' day') ?></option>


																	<?php


																}
																for ($start_week=2; $start_week < 7 ; $start_week++) {
																	?>
															<option <?php echo $old_dqid_val == $start_week. ($start_week>1 ?' weeks' : ' week') ? 'selected' : '' ?> value="<?php echo  $start_week. ($start_week>1 ?' weeks' : ' week') ?>"><?php echo  $start_week. ($start_week>1 ?' weeks' : ' week') ?></option>

																	<?php

																}
																for ($start_month=2; $start_month < 12 ; $start_month++) {
																	?>
															<option <?php echo $old_dqid_val == $start_month. ($start_month>1 ?' months' : ' month') ? 'selected' : '' ?> value="<?php echo  $start_month. ($start_month>1 ?' months' : ' month') ?>"><?php echo  $start_month. ($start_month>1 ?' months' : ' month') ?></option>

																	<?php

																}
																for ($start_year=1; $start_year < 11 ; $start_year++) {
																	?>
															<option <?php echo $old_dqid_val == $start_year. ($start_year>1 ?' years' : ' year') ? 'selected' : '' ?> value="<?php echo  $start_year. ($start_year>1 ?' years' : ' year') ?>"><?php echo  $start_year. ($start_year>1 ?' years' : ' year') ?></option>

																	<?php

																}
															?>
															<option <?php echo $old_dqid_val == "10+ years" ? 'selected' : '' ?> value="10+ years">10+ years</option>

														<?php }else{ ?>

														<?php

															foreach ($options as $ky => $ve) {

																echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>"; // for 15 id we will send the value as the select box value

															}
														}
														?>
													</select>
					 							</div>
											</div>
										<?php
										     	break;
										    case 2:
										?>
												<div class="col-md-12 <?php echo $value->id == 343 ? 'cancer_history_question_342_343 display_none_at_load_time' : ''; ?><?php echo $value->id == 399 ? 'cancer_history_question_398_399 display_none_at_load_time' : ''; ?><?php echo $value->id == 404 ? 'cancer_history_question_398_404 display_none_at_load_time' : ''; ?><?php echo $value->id == 432 ? 'cancer_history_question_398_432 display_none_at_load_time' : ''; ?><?php echo $value->id == 452 ? 'cancer_history_question_398_452 display_none_at_load_time' : ''; ?><?php echo $value->id == 448 ? 'cancer_history_question_398_448 display_none_at_load_time' : ''; ?><?php echo $value->id == 444 ? 'cancer_history_question_398_444 display_none_at_load_time' : ''; ?><?php echo $value->id == 439 ? 'cancer_history_question_398_439 display_none_at_load_time' : ''; ?><?php echo $value->id == 506 ? 'cancer_history_question_334_506 display_none_at_load_time' : ''; ?>">
					 								<div class="form-group form_fild_row <?= in_array($value->id, [334,343,393,397,399,400,402,404,405,407,410,408,411,413,414,416,426,428,417,419,420,422,429,431,432,423,425,449,451,452,453,448,447,445,444,440,443,439,438,433,506]) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 									<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 									<div class="<?= in_array($value->id, [334,343,393,397,399,400,402,404,405,407,410,408,411,413,414,416,426,428,417,419,420,422,429,431,432,423,425,449,451,452,453,448,447,445,444,440,443,439,438,433,506]) ? 'new_appoint_checkbox_quest' : '' ?>">
					 										<span></span>
					 										<?php
					 											$options = unserialize($value->options) ;
 																$temp_old_dqid_val = array();
																$old_36_37_38 = array();
																if(is_array($old_dqid_val)){
																	foreach ($old_dqid_val as $kdq => $vdq) {
																		if(($pos = stripos($vdq, '-')) !== false){
																			$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																			// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																			$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																		}else{
																			$temp_old_dqid_val[$vdq] = $vdq;
																		}
																	}
																}

																$old_dqid_val = $temp_old_dqid_val;
																foreach ($options as $ky => $val) {
			 												?>
																	<div class="check_box_bg">
		 																<div class="custom-control custom-checkbox">
          																	<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo 'cancer_history_question_'.$value->id; ?> <?php echo in_array($value->id, [404]) ? 'retain_single_option' : ''; ?>"  name="cancer_history_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required" <?php if($val == 'Dont know'){ ?> retain_val = "<?= $val ?>" <?php } ?> data-uni_class_name = "<?php echo 'cancer_history_question_'.$value->id; ?>">
          																	<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         																</div>
		 															</div>

													 			<?php
													 				$ic++;
															 	}
															 	?>
															</div>
					 									</div>
													</div>

												<?php
													break;

													case 4: ?>

														<div class="col-md-12 <?php echo $value->id == 441 ? 'cancer_history_question_440_441 display_none_at_load_time' : ''; ?><?php echo $value->id == 434 ? 'cancer_history_question_433_434 display_none_at_load_time' : ''; ?>">
															<div class="form-group form_fild_row">
																<label><?= $value->question ?></label>

																<?php


																if($login_user['gender'] == 0){

																	echo $this->element('front/abdominal_female', array('valueid' => $value->id,'step_id' => $step_id,'cur_cc_data' =>$cur_cancer_chief_compliant)) ;
													 			}
													 			else
													 			{
													 				echo $this->element('front/abdominal_man', array('valueid' => $value->id,'step_id' => $step_id,'cur_cc_data' =>$cur_cancer_chief_compliant));
													 			}
													 			?>
															</div>
														</div>

											<?php
													break;
												}
											}
										}
									?>
			   					</div>

								<div class="back_next_button">
									<ul>

										<li>
									  		<button id="cancer_cc-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
									 	</li>
									 	<li style="float: right;">
									  		<button type="submit" class="btn details_next">Next</button>
									 	</li>
									</ul>
			   					</div>
			  				</div>
			 			</div>
		  				<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 			<input type="hidden" name="tab_number" value="26">
			 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
			 			<input type="hidden" name="cur_cancer_chief_compliant" value="<?php echo $cur_cancer_chief_compliant ; ?>">

<?php $this->Form->end() ;

}
?>

<?php
if(in_array(27, $current_steps) && $tab_number == 27){

	$old_cancer_assessments = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->cancer_assessments))
		$old_cancer_assessments = $user_detail_old->chief_compliant_userdetail->cancer_assessments;

	$ic = 1;
    echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_27')); ?>
	<div class="tab-pane fade  <?= ($tab_number==27 || 27==$current_steps[0])  ? '  show active ' : '' ?>" id="cancer_assessments" role="tabpanel" aria-labelledby="cancer_assessments-tab">
		<div class="errorHolder">
  		</div>

  		<div class="TitleHead header-sticky-tit">
			<h3>Have you had any of these symptoms in the last 24 hours?</h3>
			<div class="seprator"></div>
		</div>

		<div class="tab_form_fild_bg">
			<?php
			if(!empty($cancer_assessments)) {


				foreach($cancer_assessments as $k => $v) {
					$k_exst = false;
			?>
	   			<div class="row shotshistoryfld">
	    			<div class="col-md-4">
		 				<div class="form-group form_fild_row">
	     					<label><?php echo ucfirst($v->name); ?></label>
	     				</div>
					</div>

					<div class="col-md-4">
		 				<div class="form-group form_fild_row">
							<div class="custom-control custom-checkbox">
          						<input name="assessment_history[<?=  $v->id ?>][sym_id]" value="<?=  $v->id ?>" class="custom-control-input check_had_shot" id="shotid<?php echo $v->id ; ?>" <?= isset($old_cancer_assessments['assessment_history']) && !empty($old_cancer_assessments['assessment_history']) && ($k_exst = array_key_exists($v->id, $old_cancer_assessments['assessment_history'])) ? 'checked' : ''  ?> type="checkbox"   >
          						<label class="custom-control-label" for="shotid<?php echo $v->id ; ?>">I've had this symptom.</label>
         					</div>
	     				</div>
					</div>


					<div class="col-md-4">
	     				<div class="row">
		  					<div class="col-md-12">
		   						<div class="form-group form_fild_row">
	        						<select class="form-control <?= !empty($k_exst) && $k_exst === true ? '' : 'on_load_display_none_cls' ?>"  name="assessment_history[<?= $v->id ?>][rate]" required="required">
	        							<option value="">1 being very mild and 10 being very severe</option>
							        	<?php
							     			$start_rate = 1;
								        	for($start_rate = 1; $start_rate <= 10 ; $start_rate++){
								        		echo "<option value='".$start_rate."'".(isset($old_cancer_assessments['assessment_history'][$v->id]) && $old_cancer_assessments['assessment_history'][$v->id] == $start_rate ? 'selected' : '').">".$start_rate."</option>";
								        	}
							        	?>
		    						</select>
	       						</div>
		  					</div>
		 				</div>
					</div>
	  			 </div>

	   			<?php } } ?>
	   		</div>

	   		<div class="TitleHead header-sticky-tit">
				<h3>Please rate the following activity levels:</h3>

				<div class="seprator"></div>
			</div>

			<div class="tab_form_fild_bg">

	   			<?php
			if(!empty($cancer_life_quality_assessments)) {


				foreach($cancer_life_quality_assessments as $k => $v) {
					$k_exst = false;
			?>
	   			<div class="row shotshistoryfld">
	    			<div class="col-md-6">
		 				<div class="form-group form_fild_row">
	     					<label><?php echo ucfirst($v->name); ?></label>
	     				</div>
					</div>

					<div class="col-md-6">
	     				<div class="row">
		  					<div class="col-md-12">
		   						<div class="form-group form_fild_row">
	        						<select class="form-control"  name="life_assessment[<?= $v->id ?>]" required="required">
	        							<option value="">1 is low, 5 is average, 10 is high</option>
							        	<?php
							     			$start_rate = 1;
								        	for($start_rate = 1; $start_rate <= 10 ; $start_rate++){
								        		echo "<option value='".$start_rate."'".(isset($old_cancer_assessments['life_assessment'][$v->id]) && $old_cancer_assessments['life_assessment'][$v->id] == $start_rate ? 'selected' : '').">".$start_rate."</option>";
								        	}
							        	?>
		    						</select>
	       						</div>
		  					</div>
		 				</div>
					</div>
	  			 </div>

	   			<?php } } ?>
			</div>
			<?php if(isset($is_show_chemo_assessment) && $is_show_chemo_assessment == 1){ ?>
			<div class="TitleHead header-sticky-tit">
				<h3>Please select the option that best represents your current symptoms:</h3>
				<div class="seprator"></div>
			</div>

			<div class="tab_form_fild_bg">
	   			<?php
			if(!empty($cancer_chemo_assessments)) {


				foreach($cancer_chemo_assessments as $k => $v) {
					$k_exst = false;
			?>
	   			<div class="row shotshistoryfld">
	    			<div class="col-md-6">
		 				<div class="form-group form_fild_row">
	     					<label><?php echo ucfirst($v->name); ?></label>
	     				</div>
					</div>

					<div class="col-md-6">
	     				<div class="row">
		  					<div class="col-md-12">
		   						<div class="form-group form_fild_row">
	        						<select class="form-control"  name="chemo_assessment[<?= $v->id ?>]" required="required">
	        							<option value="">Please rate your symptom</option>
	        							<option value="none" <?php echo (isset($old_cancer_assessments['chemo_assessment'][$v->id]) && $old_cancer_assessments['chemo_assessment'][$v->id] == 'none' ? 'selected' : '') ?> >None</option>
	        							<option value="mild" <?php echo (isset($old_cancer_assessments['chemo_assessment'][$v->id]) && $old_cancer_assessments['chemo_assessment'][$v->id] == 'mild' ? 'selected' : '') ?> >Mild</option>
	        							<option value="moderate" <?php echo (isset($old_cancer_assessments['chemo_assessment'][$v->id]) && $old_cancer_assessments['chemo_assessment'][$v->id] == 'moderate' ? 'selected' : '') ?> >Moderate</option>
	        							<option value="severe" <?php echo (isset($old_cancer_assessments['chemo_assessment'][$v->id]) && $old_cancer_assessments['chemo_assessment'][$v->id] == 'severe' ? 'selected' : '') ?> >Severe</option>
	        							<option value="life threatening" <?php echo (isset($old_cancer_assessments['chemo_assessment'][$v->id]) && $old_cancer_assessments['chemo_assessment'][$v->id] == 'life threatening' ? 'selected' : '') ?> >Disabling/life threatening</option>

		    						</select>
	       						</div>
		  					</div>
		 				</div>
					</div>
	  			 </div>

	   			<?php } } ?>
			</div>
		<?php } ?>

		<?php if(isset($cancer_covid_question) && !empty($cancer_covid_question)){ ?>
			<div class="TitleHead header-sticky-tit">
				<h3>Other medical history questions:</h3>
				<div class="seprator"></div>
		 </div>

		 <div class="tab_form_fild_bg">
			<div class="row">
				<?php
					$i = 0 ;
					$cb_class = '';
					if(!empty($cancer_covid_question)){
						foreach ($cancer_covid_question as $key => $value) {

							$old_dqid_val = !empty($old_cancer_assessments['cancer_covid_question']) && isset($old_cancer_assessments['cancer_covid_question'][$value->id]) ? $old_cancer_assessments['cancer_covid_question'][$value->id] : '';

							switch ($value->question_type) {
								case 1:
								 ?>

 										<div class="col-md-12 <?php echo $value->id == 341 ? 'cancer_history_que_341_section' : ''; ?><?php echo $value->id == 338 ? 'cancer_history_question_336_338 display_none_at_load_time' : ''; ?><?php echo $value->id == 394 ? 'cancer_history_question_393_394 display_none_at_load_time' : ''; ?>">
				 							<div class="form-group form_fild_row">
 												<div class="radio_bg">
          											<label>
          												<?= $value->question ?>&nbsp;<span class="required">*</span>
          											</label>
													<div class="radio_list">
														<?php
														$options = unserialize($value->options) ;
														foreach ($options as $k => $v) {
														?>
	        												<div class="form-check">
	         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'cancer_history_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="cancer_covid_question[<?= $value->id ?>]"  required="true">
	         													<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
	       													</div>
														<?php
															$i++ ;
														}
														?>
													</div>
    											</div>
				 							</div>
										</div>


		<?php }} } }?>
				</div>
			</div>




			<div class="back_next_button">
				<ul>

					<li>
				  		<button id="cancer_history-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				 	</li>
				 	<li style="float: right;">
				  		<button type="submit" class="btn details_next">Next</button>
				 	</li>
				</ul>
			</div>

			<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
 			<input type="hidden" name="tab_number" value="27">
 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">

  		</div>

<?php $this->Form->end() ;

}
?>

<?php

$family_members = array(

		'mother' => 'Mother',
		'father' => 'Father',
		'sister' =>'Sister',
		'brother' => 'Brother',
		'maternal cousin' => "Cousin(mom's side)",
		'paternal cousin' => "Cousin(dad's side)",
		'maternal grandmother' => "Grandmother(mom's side)",
		'paternal grandmother' => "Grandmother(dad's side)",
		'maternal grandfather' => "Grandfather(mom's side)",
		'paternal grandfather' => "Grandfather(dad's side)",
		'maternal aunt' => "Aunt(mom's side)",
		'paternal aunt' => "Aunt(dad's side)",
		'maternal uncle' => "Uncle(mom's side)",
		'paternal uncle' => "Uncle(dad's side)",

	);
$how_many_time_drink = array(
		'' =>'',
		'Once a month or less' => 'Once a month or less',
		'2-3 times a month' => '2-3 times a month',
		'1-2 times a week' =>'1-2 times a week',
		'3-4 times a week' => '3-4 times a week',
		'5-6 times a week' => "5-6 times a week",
		'Once a day' => "Once a day",
		'2-3 a day' => "2-3 a day",
		'4-6 a day' => "4-6 a day",
		'More than 6 a day' => "More than 6 a day",
	);
$smoking_types = array(

		'Cigarettes' => 'Cigarettes',
		'Cigars' => 'Cigars',
		'Pipe tobacco' =>'Pipe tobacco',
		'Smokeless tobacco' => 'Smokeless tobacco',
	);
 ?>

<?php

if(in_array(28, $current_steps) && $tab_number == 28){


	$old_cancer_medical_detail = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->cancer_medical_detail))
		$old_cancer_medical_detail = $user_detail_old->chief_compliant_userdetail->cancer_medical_detail;

	$old_cancer_family_members = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->cancer_family_members))
		$old_cancer_family_members = $user_detail_old->chief_compliant_userdetail->cancer_family_members;

	$old_family_members_cancer_disease_detail = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->family_members_cancer_disease_detail))
		$old_family_members_cancer_disease_detail = $user_detail_old->chief_compliant_userdetail->family_members_cancer_disease_detail;

	$old_cancer_conditions = array();

	if(!empty($user_detail_old->chief_compliant_userdetail->cancer_conditions))
		$old_cancer_conditions = $user_detail_old->chief_compliant_userdetail->cancer_conditions;

	//pr($old_cancer_conditions);

	$ic = 1;
    echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_28')); ?>
	<div class="tab-pane fade  <?= ($tab_number==28  || 28==$current_steps[0])  ? '  show active ' : '' ?>" id="cancer_medical_history" role="tabpanel" aria-labelledby="cancer_medical_history-tab">
		<div class="errorHolder">
  		</div>
		<!--Nutrition section commented -->
		<?php if($step_id == 25){?>
			<!-- <div class="TitleHead header-sticky-tit">
			<h3>Nutrition</h3>
			<div class="seprator"></div>
			</div> -->

		<?php }else {?>
			<div class="TitleHead header-sticky-tit">
			<h3>Medical History</h3>
			<div class="seprator"></div>
			</div>
		<?php } ?>

		
		<!-- <div class="TitleHead header-sticky-tit">
			<h3>Nutrition</h3>
			<div class="seprator"></div>
		</div> -->
		<div class="tab_form_fild_bg">
			<div class="row">
				<?php
					$i = 0 ;
					$cb_class = '';
					// pr($cancer_mh_question); die;
					if(!empty($cancer_mh_question)){
						foreach ($cancer_mh_question as $key => $value) {

							//Start Nutrition section 
							if(in_array($value->id,[562,563,564,565,566]))
							{
								continue;
							}
							//End Nutrition section


							//show question for female and discard for male
							if($login_user['gender'] != 0 && (in_array($value->id, [344,345,346,347,348]) || $value->tab_number == 'ob')){

								continue;
							}

							if(in_array($value->id, [456,457]) && (!in_array("thyroid cancer", $old_cancer_conditions) && !in_array("Thyroid cancer", $old_cancer_conditions))){

								continue;
							}

							if(in_array($value->id, [458]) && (!in_array("liver cancer", $old_cancer_conditions) && !in_array("Liver cancer", $old_cancer_conditions))){

								continue;
							}

							$old_dqid_val = !empty($old_cancer_medical_detail) && isset($old_cancer_medical_detail[$value->id]) ? $old_cancer_medical_detail[$value->id] : '';

							switch ($value->question_type) {
								case 0:	?>

									<div class="col-md-12 <?php echo $value->id == 371 ? 'cancer_medical_question_370_371 display_none_at_load_time':''; ?><?php echo $value->id == 357 ? 'cancer_medical_question_356_357 display_none_at_load_time':''; ?> <?php echo $value->id == 358 ? 'cancer_medical_question_355_358 display_none_at_load_time' : ''; ?><?php echo $value->id == 392 ? 'cancer_medical_question_391_392 display_none_at_load_time':''; ?><?php echo $value->id == 390 ? 'cancer_medical_question_389_390 display_none_at_load_time':''; ?><?php echo $value->id == 385 ? 'cancer_medical_question_384_385 display_none_at_load_time' : ''; ?><?php echo $value->id == 386 ? 'cancer_medical_question_384_386 display_none_at_load_time' : ''; ?><?php echo $value->id == 387 ? 'cancer_medical_question_384_387 display_none_at_load_time' : ''; ?><?php echo $value->id == 382 ? 'cancer_medical_question_374_382 display_none_at_load_time' : ''; ?><?php echo $value->id == 501 ? 'cancer_medical_question_499_501 display_none_at_load_time' : ''; ?><?php echo $value->id == 679 ? 'cancer_medical_question_620_679 display_none_at_load_time' : ''; ?>
 										<?php echo $value->id == 680 ? 'cancer_medical_question_621_680 display_none_at_load_time' : ''; ?><?php echo $value->id == 684 ? 'cancer_medical_question_683_684 display_none_at_load_time' : ''; ?><?php echo $value->id == 692 ? 'cancer_medical_question_691_692 display_none_at_load_time' : ''; ?>	" >
					 					<div class="form-group form_fild_row">
					 						<label>
					 							<?= $value->question ?>&nbsp;<?php if($value->id != 358){ ?><span class="required">*</span> <?php } ?>
					 						</label>
					 						<?php if($value->data_type == 2){ ?>

												<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'cancer_medical_question_'.$value->id; ?>"  name="cancer_medical_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" <?php if($value->id != 358){ ?> required="true" <?php } ?>/>
											<?php }
											else{ ?>

												<input type="text" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'cancer_medical_question_'.$value->id; ?>"  name="cancer_medical_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
										<?php } ?>
 										</div>
									</div>

							<?php
									break;
								case 1:

									if($value->id == 355 || $value->id == 685){ ?>

										<div class="TitleHead header-sticky-tit" style="margin-left:13px;">
											<?php if($step_id == 25){ ?>
											<h3>Family History</h3>
										<?php } else{?>
											<h3>Do you have any family members that have been diagnosed with any of these medical conditions?</h3>
										<?php } ?>
											<div class="seprator"></div>
										</div>
											<?php if($step_id == 25){?>
  												<div class="radio_bg">
           											<label style="margin-left: 13px;">
           												Do you have any family members that have been diagnosed with any of these medical conditions?
           											</label>
     											</div>
     										<?php }?>

								<?php }
								 ?>
								 <?php
								 if($value->id == 528 && $step_id != 25 ){ ?>

										<div class="TitleHead header-sticky-tit">
											<h3>Do you have a personal history of being diagnosed with any of the following:</h3>
											<div class="seprator"></div>
										</div>

								<?php }
								else if($value->id == 529 && $step_id == 25){ ?>

									 <div class="TitleHead header-sticky-tit" style="margin-bottom: -4px !important;background: none !important;">
									 	<?php if($step_id == 25){ ?>
											<h3 style="padding-bottom: 26px !important;margin-left: 13px;">Medical History</h3>
										<?php } else{?>
											<h3>Do you have a personal history of being diagnosed with any of the following:</h3>
										<?php } ?>
											<div class="seprator"></div>
									 <!-- </div>	 -->
										<?php if($step_id == 25){?>
												<div class="radio_bg text-left">
       											<label style="margin-left: 13px;">Do you have a personal history of being diagnosed with any of the following:
       											</label>
 											</div>
 										<?php }?>
										 <!-- <h3>Do you have a personal history of being diagnosed with any of the following:</h3> -->
										 <!-- <div class="seprator"></div> -->
									 </div>

							 <?php }
							 if($value->id == 608){ ?>

										<div class="TitleHead header-sticky-tit" style="margin-left:13px;">
											<h3>Social History</h3>
											<div class="seprator"></div>
										</div>

								<?php }
								 ?>



								 <?php if($value->id == 363){ ?>
 									<?php	$y = 0;	foreach ($family_members as $keys => $values) { $y++;?>
 						 				<div class="col-md-12 diabetes_show_<?php echo str_replace(' ', '_', $keys); ?>" <?php if(!isset($old_dqid_val[$keys])) { echo 'style="display:none"'; } ?>>
 				 							<div class="form-group form_fild_row">
  												<div class="radio_bg">
           											<label>
           												<?= $value->question ?> <?= strtolower($values) ?> ?&nbsp;<span class="required">*</span>
           											</label>
     											</div>
     											<div class="radio_list">
 													<?php
 													$options = unserialize($value->options) ;
 													$z = 10;
 													foreach ($options as $k => $v) { $z++;
 													?>
         												<div class="form-check">
          													<input type="radio"  value="<?= $v ?>"  name="cancer_medical_detail[363][<?= $keys ?>]" id="radio_question_diabetes12<?= $y ?><?= $z ?>" <?php if(isset($old_dqid_val[$keys]) && $old_dqid_val[$keys] == $v) { echo 'checked'; } ?> required="true">
          													<label class="form-check-label" for="radio_question_diabetes12<?= $y ?><?= $z ?>" ><?= $v ?></label>
        													</div>
 													<?php
 													}
 													?>
 												</div>
 				 							</div>
 										</div>
 									<?php } ?>

 									<?php } else{ ?>


 										<div class="col-md-12 <?php echo $value->id == 345 ? 'cancer_medical_question_344_345 display_none_at_load_time' : ''; ?><?php echo $value->id == 363 ? 'cancer_medical_question_362_363 display_none_at_load_time':''; ?><?php echo $value->id == 391 ? 'cancer_medical_question_389_391 display_none_at_load_time' : ''; ?><?php echo $value->id == 389 ? 'cancer_medical_question_384_389 display_none_at_load_time' : ''; ?><?php echo $value->id == 388 ? 'cancer_medical_question_384_388 display_none_at_load_time' : ''; ?>
 										<?php echo $value->id == 540 ? 'cancer_medical_question_539_540 display_none_at_load_time' : ''; ?>
 										<?php echo $value->id == 541 ? 'cancer_medical_question_539_541 display_none_at_load_time' : ''; ?>
 										<?php echo $value->id == 542 ? 'cancer_medical_question_541_542 display_none_at_load_time' : ''; ?>
 										<?php echo $value->id == 543 ? 'cancer_medical_question_539_543 display_none_at_load_time' : ''; ?><?php echo $value->id == 548 ? 'cancer_medical_question_528_548 display_none_at_load_time' : ''; ?><?php echo $value->id == 634 ? 'cancer_medical_question_633_634 display_none_at_load_time' : ''; ?><?php echo $value->id == 637 ? 'cancer_medical_question_633_637 display_none_at_load_time' : ''; ?><?php echo $value->id == 635 ? 'cancer_medical_question_634_635 display_none_at_load_time' : ''; ?><?php echo $value->id == 636 ? 'cancer_medical_question_635_636 display_none_at_load_time' : ''; ?><?php echo $value->id == 638 ? 'cancer_medical_question_637_638 display_none_at_load_time' : ''; ?><?php echo $value->id == 695 ? 'cancer_medical_question_638_695 display_none_at_load_time' : ''; ?>
 										">

 				 							<div class="form-group form_fild_row">

 				 								<!-- dsfdf -->
 				 								<?php if(in_array($value->id, [355,360,362,364,365,367,368,369,370,528,529,530,531,532,533,534,535,536,537,685,686,687,688,689,690,691,693])) { ?>
 				 								<div class="check_box_bg">
					 								<div class="custom-control custom-checkbox">
			          									<input  class="custom-control-input <?= $cb_class ?> <?php echo 'cancer_medical_question_'.$value->id; ?> <?php echo in_array($value->id, [355,359,360,361,362,364,365,366,367,368,369,370,685,686,687,688,689,690,691]) ? 'cancer_family_history' : 'cancer_personal_history' ?>"  name="cancer_medical_detail[<?= $value->id ?>]"  id="checkbox<?= $ic ?>" value="<?= $old_dqid_val ? $old_dqid_val :"No" ?>" data-que_id="<?= $value->id ?>" fixval="<?= $old_dqid_val ? $old_dqid_val :"No" ?>" type="checkbox" <?php if(isset($old_dqid_val) && $old_dqid_val == "Yes") { echo 'checked'; } ?>>
			          									<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $value->question ?></label>
			         								</div>
					 							</div>

					 						<?php $ic++;} ?>
 				 								<!-- dfgdfg -->
 				 								<?php if(!in_array($value->id, [355,360,362,364,365,367,368,369,370,528,529,530,531,532,533,534,535,536,537,685,686,687,688,689,690,691,693])) {?>
  												<div class="radio_bg">
           											<label>
           												<?= $value->question ?>&nbsp;<span class="required">*</span>
           											</label>
 													<div class="radio_list">
 														<?php
 														$options = unserialize($value->options) ;
 														foreach ($options as $k => $v) {
 														?>
 	        												<div class="form-check">
 	         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'cancer_medical_question_'.$value->id; ?> <?php echo in_array($value->id, [355,359,360,361,362,364,365,366,367,368,369,370,685,686,687,688,689,690,691]) ? 'cancer_family_history' : '' ?>" data-que_id = "<?php echo $value->id; ?>" id="radio_question<?= $i ?>" name="cancer_medical_detail[<?= $value->id ?>]"  required="true">
 	         													<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
 	       													</div>
 														<?php
 															$i++ ;
 														}
 														?>
 													</div>
     											</div>
     										<?php } ?>
 				 							</div>
 										</div>
 									<?php

 								} ?>
									<?php
						//add family members checkbox question
						if(in_array($value->id, [355,359,360,361,362,364,365,366,367,368,369,370,685,686,687,688,689,690,691]))
						{
							 ?>
							<div class="col-md-12 <?php echo 'cancer_family_members_que_'.$value->id.' display_none_at_load_time'; ?>">
	 								<div class="form-group form_fild_row new_appoint_checkbox_quest_a">
	 									<label>Which family member(s)?&nbsp;<span class="required">*</span></label>
	 									<div class="new_appoint_checkbox_quest">
	 										<span></span>
	 										<?php
	 										$old_fm = !empty($old_cancer_family_members) && isset($old_cancer_family_members[$value->id]) ? $old_cancer_family_members[$value->id] : '';
	 										//pr($old_fm);die;
												foreach ($family_members as $ky => $val) {
												?>
													<div class="check_box_bg">
															<div class="custom-control custom-checkbox">
																<input <?= is_array($old_fm) && in_array($ky, $old_fm)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo 'cancer_family_members_'.$value->id; ?>"  name="sym_family_members[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?php echo $ky; ?>" fixval="<?= $ky ?>" type="checkbox" required="required" data-name="<?php echo strtolower(str_replace(" ", "", $ky)); ?>">
																<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
															</div>
														</div>

									 			<?php
									 				$ic++;
											 	}
											 	?>
											</div>
	 									</div>
									</div>

						<?php }

										if($value->id == 355){

											$cancer_type = @unserialize('a:18:{i:1;s:12:"Brain cancer";i:2;s:13:"Breast cancer";i:3;s:12:"Colon cancer";i:4;s:15:"Cervical cancer";i:5;s:26:"Throat cancer (esophageal)";i:6;s:14:"Stomach cancer";i:7;s:17:"Pancreatic cancer";i:8;s:14:"Ovarian cancer";i:9;s:15:"Prostate cancer";i:10;s:11:"Lung cancer";i:11;s:12:"Liver cancer";i:12;s:14:"Thyroid cancer";i:13;s:13:"Kidney cancer";i:14;s:14:"Uterine cancer";i:15;s:14:"Vaginal cancer";i:16;s:12:"Vulva cancer";i:17;s:8:"Leukemia";i:18;s:5:"Other";}');

											foreach ($family_members as $ky => $val) {

												$family_members_class_name = strtolower(str_replace(" ", "", $ky));

												$old_fm_age = '';
												$old_fm_other_cancer_type = '';
												$old_fm_cancer_type = '';

												if(!empty($old_family_members_cancer_disease_detail) && isset($old_family_members_cancer_disease_detail[$ky])){

													$old_fm_age = isset($old_family_members_cancer_disease_detail[$ky]['age']) ? $old_family_members_cancer_disease_detail[$ky]['age'] : '';

													$old_fm_cancer_type = isset($old_family_members_cancer_disease_detail[$ky]['disease']) ? $old_family_members_cancer_disease_detail[$ky]['disease'] : '';
													$old_fm_other_cancer_type = isset($old_family_members_cancer_disease_detail[$ky]['other']) ? $old_family_members_cancer_disease_detail[$ky]['other'] : '';
												}


											 ?>
								<div class="cancer_type_detail_section <?php echo strtolower(str_replace(" ", "", $ky)).'_cancer_detail_section'; ?> display_none_at_load_time">
										<fieldset>

											<div class="col-md-12">
												<legend><?php echo $val; ?></legend>

												<div class="form-group form_fild_row new_appoint_checkbox_quest_a">

																<label><?php echo "Which cancer(s) was your ".strtolower($val)." diagnosed with?"; ?>&nbsp;<span class="required">*</span></label>
							 									<div class="new_appoint_checkbox_quest">
							 										<span></span>
							 										<?php


							 											//$old_fm_cancer_type = '';
							 											//pr($old_fm_cancer_type);
							 											foreach ($cancer_type as $ckey => $cvalue) { ?>

							 												<div class="check_box_bg">
				 																<div class="custom-control custom-checkbox">
		          																	<input <?= is_array($old_fm_cancer_type) && in_array($cvalue, $old_fm_cancer_type)   ? 'checked' : '' ?> class="custom-control-input family_members_cancer_type <?= $cb_class ?> <?php echo $family_members_class_name."_disease_detail"; ?>"  name="family_members_disease_detail[<?= $ky ?>][disease][]"  id="checkbox<?= $ic ?>" value="<?php echo $cvalue; ?>" fixval="<?= $cvalue ?>" type="checkbox" required="required" data-name="<?php echo $family_members_class_name; ?>">
		          																	<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $cvalue ?></label>
		         																</div>
				 															</div>

							 										<?php $ic++;
							 										}
							 										?>
															</div>
														</div>
													</div>

													<?php  ?>
													<div class="col-md-12 <?php echo $family_members_class_name.'_other_cancer'; ?> display_none_at_load_time">
														<div class="form-group form_fild_row">
									 						<label>
									 							Please specify other cancer:&nbsp;<span class="required">*</span>
									 						</label>
									 						<input type="text" value="<?php echo $old_fm_other_cancer_type ; ?>" class="form-control other_cancer_textbox <?php echo $family_members_class_name.'_other_cancer_textbox'; ?>"  name="family_members_disease_detail[<?= $ky ?>][other]" required="true"/>
								 						</div>
													</div>



													<div class="col-md-12">
														<div class="form-group form_fild_row">
									 						<label>
									 							<?php echo "About how old was your ".strtolower($val)." when they were diagnosed? (Leave blank if not sure)"; ?>
									 						</label>
									 						<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?php echo $old_fm_age; ?>" class="form-control age_detail <?php echo $family_members_class_name."_age_detail"; ?>"  name="family_members_disease_detail[<?= $ky ?>][age]" placeholder="" />
								 						</div>
													</div>
												</fieldset>
										</div>

										<?php	}
										}
										?>

										<?php  //}
												break;
										case 3: ?>
											<div class="col-md-12 <?php echo $value->id == 346 ? 'cancer_medical_question_344_346 display_none_at_load_time' : ''; ?><?php echo $value->id == 348 ? 'cancer_medical_question_347_348 display_none_at_load_time' : ''; ?><?php echo $value->id == 350 ? 'cancer_medical_question_349_350 display_none_at_load_time' : ''; ?><?php echo $value->id == 352 ? 'cancer_medical_question_351_352 display_none_at_load_time' : ''; ?><?php echo $value->id == 375 ? 'cancer_medical_question_374_375 display_none_at_load_time' : ''; ?><?php echo $value->id == 376 ? 'cancer_medical_question_374_376 display_none_at_load_time' : ''; ?><?php echo $value->id == 377 ? 'cancer_medical_question_374_377 display_none_at_load_time' : ''; ?><?php echo $value->id == 378 ? 'cancer_medical_question_374_378 display_none_at_load_time' : ''; ?><?php echo $value->id == 379 ? 'cancer_medical_question_374_379 display_none_at_load_time' : ''; ?><?php echo $value->id == 380 ? 'cancer_medical_question_374_380 display_none_at_load_time' : ''; ?><?php echo $value->id == 381 ? 'cancer_medical_question_374_381 display_none_at_load_time' : ''; ?><?php echo $value->id == 383 ? 'cancer_medical_question_374_383 display_none_at_load_time' : ''; ?><?php echo $value->id == 500 ? 'cancer_medical_question_499_500 display_none_at_load_time' : ''; ?><?php echo $value->id == 502 ? 'cancer_medical_question_499_502 display_none_at_load_time' : ''; ?> <?php echo $value->id == 504 ? 'cancer_medical_question_374_504 display_none_at_load_time' : ''; ?><?php echo $value->id == 639 ? 'cancer_medical_question_695_639 display_none_at_load_time' : ''; ?><?php echo $value->id == 624 ? 'cancer_medical_question_623_624 display_none_at_load_time' : ''; ?><?php echo $value->id == 629 ? 'cancer_medical_question_628_629 display_none_at_load_time' : ''; ?><?php echo $value->id == 617 ? 'cancer_medical_question_616_617 display_none_at_load_time' : ''; ?>">
					 							<div class="form-group form_fild_row">
					 								<label>
					 									<?= $value->question ?>
														<?php
														$options = unserialize($value->options) ; ?>
													 	<?php if(isset($options[0]) && !empty($value->question)){ ?>
													 		<?php if(!empty($options[0])){ ?>
														 		<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">

														 		<i class="fa fa-question-circle" aria-hidden="true"></i></a>
														 	<?php } ?>

													 	<?php } ?>
													 	<span class="required">*</span>
					 								</label>

													<select class="form-control <?php echo 'cancer_medical_question_'.$value->id; ?>" name="cancer_medical_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">
														<?php

														if(in_array($value->id, [346,348])){
															echo '<option value=""></option>';
															if($value->id == 346){
																?>
																<option value="you don't remember when" <?php if($old_dqid_val == "you don't remember when"){
																	echo "selected";
																} ?>>I don't remember when</option>
															<?php }
															for($start_year = date('Y'); $start_year >= 1970 ; $start_year--)
															{

																echo "<option ".($old_dqid_val == $start_year ? 'selected' : '')." value=".$start_year.">".$start_year."</option>";
															}
														}
														else{
															if($value['id'] == 350){

																echo '<option value=""></option>';

																for($start_i = 1; $start_i <=10 ; $start_i++)
																{

																	echo "<option ".($old_dqid_val == $start_i ? 'selected' : '')." value=".$start_i.">".$start_i."</option>";
																}

																echo '<option value="morethan10"'.($old_dqid_val == 'morethan10' ? 'selected' : "").'>More than 10 packs</option>';
															}
															elseif($value['id'] == 352){

																echo '<option value=""></option>';

																for($start_i = 1; $start_i <=14 ; $start_i++)
																{

																	echo "<option ".($old_dqid_val == $start_i ? 'selected' : '')." value=".$start_i.">".$start_i."</option>";
																}

																echo '<option value="morethan10"'.($old_dqid_val == 'morethan10' ? 'selected' : "").'>More than 14 drinks</option>';
															}
															else{
																//pr($options);
																if(in_array($value->id ,[626,639]))
																	{
																		$old_dqid_val = $options[$old_dqid_val];
																	}

																foreach ($options as $ky => $ve) {

																	echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : (!empty($ky) ? $ky :'')) : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>";
																}
															}
														}

														?>
													</select>
					 							</div>
											</div>
										<?php
										     	break;
										    case 2:
										?>
												<div class="col-md-12 <?php echo $value->id == 356 ? 'cancer_medical_question_355_356 display_none_at_load_time' : ''; ?><?php echo $value->id == 374 ? 'cancer_medical_question_373_374 display_none_at_load_time' : ''; ?><?php echo $value->id == 499 ? 'cancer_medical_question_498_499 display_none_at_load_time' : ''; ?><?php echo $value->id == 565 ? 'smoking_medical_question_564_565 display_none_at_load_time' : ''; ?><?php echo $value->id == 567 ? 'smoking_medical_question_566_567 display_none_at_load_time' : ''; ?>">
					 								<div class="form-group form_fild_row <?= in_array($value->id, [356,374,458,499,565,567]) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 									<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 									<div class="<?= in_array($value->id, [356,374,458,499,563,5,565,567,620,621,628,630,633,683]) ? 'new_appoint_checkbox_quest' : '' ?>">
					 										<span></span>
					 										<?php
															//pr($value->options);
					 											$options = unserialize($value->options) ;
 																$temp_old_dqid_val = array();
																$old_36_37_38 = array();
																//pr($old_dqid_val);
																if(!empty($old_dqid_val['time']))
																$temp_drink_time = $old_dqid_val['time'];
;																if(is_array($old_dqid_val)){
																	foreach ($old_dqid_val as $kdq => $vdq) {
																			if(is_numeric($kdq))
																			$temp_old_dqid_val[$vdq] = $vdq;
																	}
																}

																$old_dqid_val = $temp_old_dqid_val;

																foreach ($options as $ky => $val) {
			 												?>
																	<div class="check_box_bg">
		 																<div class="custom-control custom-checkbox">
          																	<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?php echo in_array($value->id,[563]) ?($val != "None of these" ? 'drinking_items_'.$value->id :'drinking_items_none_of_these'):''; ?> <?= $cb_class ?> <?php echo 'cancer_medical_question_'.$value->id; ?>"  name="cancer_medical_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" data-name="<?= strtok($val, " ")?>" type="checkbox" required="required">
          																	<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         																</div>
		 															</div>

													 			<?php
													 				$ic++;
															 	}
															 	?>
															</div>
					 									</div>
													</div>
													<!-- how many time drink -->
													<?php
													//pr($old_dqid_val);
												if(!empty($temp_drink_time))
													$old_dqid_val = $temp_drink_time;
													//pr($old_dqid_val);
												foreach ($options as $k => $v) {
													if(!empty($old_dqid_val[$v]))
													{
														$old_dqid_val_val = $old_dqid_val[$v];
													}
													else
													{
														$old_dqid_val_val = '';
													}
													//pr($old_dqid_val_val);
													if(in_array($value->id, [563]) && $v != "None of these"){  //pr($old_dqid_val);?>
													<div class="col-md-12 drink_medical_detail_563 cancer_medical_detail_563_<?= strtok($v, " ")?> <?php echo !empty($old_dqid_val[$v]) ?'':'display_none_at_load_time'  ?>">
									 					<div class="form-group form_fild_row">
									 						<label>How often do you drink
												               <?= $v ?>
												               <?php
												                  //$options = unserialize($value->options) ; ?>
												               <span class="required">*</span>
												               </label>
															<select class="form-control how_many_drinking_items_563 how_many_time_drink_563_<?= strtok($v, " ")?>" name="cancer_medical_detail[<?=$value->id?>][time][<?= $v ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">

															<?php
															//pr($old_dqid_val[$v]);
																foreach ($how_many_time_drink as $ky => $ve) {

																	echo "<option " .($old_dqid_val_val == $ve ? 'selected' : '')." value='".$ve."'>".$ve."</option>";
																}
															?>
															</select>
									 					</div>
													</div>
												<?php }
											}?>
													<!-- End -->

												<?php
													break;
												}
											}
										}
									?>
			   					</div>
			   					<!-- End PMH Oncology Question -->
			   					<!-- first ask question about any surgical history is there end -->
			<?php if($step_id == 25 || $step_id == 26){ if(!empty($user_data->is_check_allergy_his)) {

					$user_data->is_check_allergy_his =  (Security::decrypt(base64_decode($user_data->is_check_allergy_his), SEC_KEY));
				}?>
			<div class="tab_form_fild_bg">
				<div class="row">
				   <div class="col-md-12">
						<div class="form-group form_fild_row">
			         		<label>Are you allergic to any food or medications? </label>  <span class="required">*</span>
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

   			<?php //$allergy_history = unserialize((Security::decrypt(base64_decode($user_detail_old->chief_compliant_userdetail->allergy_history), SEC_KEY)));
   			if(!empty($user_data->is_latex_allergy)) {
   			$user_data->is_latex_allergy = (Security::decrypt(base64_decode($user_data->is_latex_allergy), SEC_KEY));
   			}
				//pr($is_latex_allergy);
   			 //if(($user_data->gender == 0) && empty($check_surgical_allergy['checkallergy'])) {   ?>
				<?php if(($user_data->gender == 0) && empty($check_surgical_allergy['checkallergy'])) {   ?>
				<div class="tab_form_fild_bg  is_check_allergy_his_div  <?php if(is_null($user_data->is_check_allergy_his) || $user_data->is_check_allergy_his == 0 ) echo 'on_load_display_none_cls '; ?>  ">
					<div class="row">
		   				<div class="col-md-12">
							<div class="form-group form_fild_row">
					        	<label> Are you allergic to latex? </label>  <span class="required">*</span>
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
</div>
<?php } ?>

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

								<div class="back_next_button">
									<ul>
										<li>
											<?php $is_old_chronic_condition = array();
											if(!empty($user_detail_old->chief_compliant_userdetail->chronic_condition))
												$is_old_chronic_condition = $user_detail_old->chief_compliant_userdetail->chronic_condition;
											//pr($is_old_chronic_condition);
													?>
															<?php if($step_id == 26 && empty($user_detail_old->chief_compliant_userdetail->chief_compliant_details)){?>
																<button id="chief_cc-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
															<?php }elseif($step_id == 26){?>
																<button id="cc_detail-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
															<?php }else{?>
																<button id="<?php echo $step_id == 25 ? "internal_mh_assessments-backbtn":"cancer_assessments-backbtn" ?>" type="button" class="btn nofillborder">Previous Tab</button>
															<?php }?>

									 	</li>
									 	<li style="float: right;margin-left: auto;">
									  		<button type="submit" class="btn details_next">Next</button>
									 	</li>
									</ul>
			   					</div>
			  				</div>
			 			</div>
		  				<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 			<input type="hidden" name="tab_number" value="28">
			 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end();

}
?>

<?php
/* Pre op post op module  */
if(in_array(29, $current_steps) && $tab_number == 29){
	$old_pre_op_post_op_detail = '';
if(!empty($user_detail_old->chief_compliant_userdetail->pre_op_post_op))
$old_pre_op_post_op_detail = $user_detail_old->chief_compliant_userdetail->pre_op_post_op;
$ic = 1;
echo $this->Form->create(null , array('autocomplete' => 'off',
'inputDefaults' => array(
'label' => false,
'div' => false,
),'enctype' => 'multipart/form-data', 'id' => 'form_tab_29')); ?>
<div class="tab-pane fade  <?= ($tab_number==29 || 29==$current_steps[0])  ? '  show active ' : '' ?>" id="preoppostop" role="tabpanel" aria-labelledby="preoppostop-tab">
   <div class="errorHolder">
   </div>
   <div class="TitleHead header-sticky-tit">
   		<h3>Pre Post Operation Details</h3>
      <div class="seprator"></div>
   </div>
   <div class="tab_form_fild_bg">
      <div class="row">
         <?php
            $i = 0 ;
            $cb_class = '';
            if(!empty($preop_postop_questions)){
            	foreach ($preop_postop_questions as $key => $value) {

            		$old_dqid_val = !empty($old_pre_op_post_op_detail) && isset($old_pre_op_post_op_detail[$value->id]) ? $old_pre_op_post_op_detail[$value->id] : '';

            		switch ($value->question_type) {
            			case 0:	?>
         <div class="col-md-12 <?php echo $value->id == 460 ? 'preop_postop_question_459_460 display_none_at_load_time' : ''; ?><?php echo $value->id == 464 ? 'preop_postop_question_463_464 display_none_at_load_time' : ''; ?>">
            <div class="form-group form_fild_row">
               <label>
               <?= $value->question ?>&nbsp;<span class="required">*</span>
               </label>
               <input type="text" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'pre_op_post_op'.$value->id; ?>"  name="pre_op_post_op[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
            </div>
         </div>
         <?php
            break;
            case 1:  ?>
         <div class="col-md-12 <?php echo $value->id == 469 ? 'preop_postop_question_467_469 display_none_at_load_time' : ''; ?><?php echo $value->id == 463 ? 'preop_postop_question_462_463 display_none_at_load_time' : ''; ?>">
            <div class="form-group form_fild_row">
               <div class="radio_bg">
                  <label>
                  <?= $value->question ?>&nbsp;<span class="required">*</span>
                  </label>
                  <div class="radio_list">
                     <?php
                        $options = unserialize($value->options) ;
                        foreach ($options as $k => $v) {
                        ?>
                     <div class="form-check">
                        <input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'preop_postop_question'.$value->id; ?>" id="radio_question<?= $i ?>" name="pre_op_post_op[<?= $value->id ?>]"  required="true">
                        <label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
                     </div>
                     <?php
                        $i++ ;
                        }
                        ?>
                  </div>
               </div>
            </div>
         </div>
         <?php
            break;
            case 3: ?>
         <div class="col-md-12 <?php echo $value->id == 468 ? 'preop_postop_question_467_468 display_none_at_load_time' : ''; ?>">
            <div class="form-group form_fild_row">
               <label>
               <?= $value->question ?>
               <?php
                  $options = unserialize($value->options) ; ?>
               <?php if(isset($options[0]) && !empty($value->question)){ ?>
               <?php if(!empty($options[0])){ ?>
               <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">
               <i class="fa fa-question-circle" aria-hidden="true"></i></a>
               <?php } ?>
               <?php } ?>
               <span class="required">*</span>
               </label>
               <select class="form-control" name="pre_op_post_op[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">
               <?php
                  foreach ($options as $ky => $ve) {
                  	echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".$ve.">".$ve."</option>"; // for 15 id we will send the value as the select box value
                  }
                  ?>
               </select>
            </div>
         </div>
         <?php
            break;
            case 2:
            ?>
         <div class="col-md-12">
            <div class="form-group form_fild_row <?= in_array($value->id, [467]) ? 'new_appoint_checkbox_quest_a' : '' ?>">
               <label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
               <div class="<?= in_array($value->id, [467]) ? 'new_appoint_checkbox_quest' : '' ?>">
                  <span></span>
                  <?php
                     $options = unserialize($value->options) ;
                     $temp_old_dqid_val = array();
                     if(is_array($old_dqid_val)){
                     foreach ($old_dqid_val as $kdq => $vdq) {
                     	if(($pos = stripos($vdq, '-')) !== false){
                     		$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
                     	}else{
                     		$temp_old_dqid_val[$vdq] = $vdq;
                     	}
                     }
                     }
                     $old_dqid_val = $temp_old_dqid_val;
                     foreach ($options as $ky => $val) {
                     ?>
                  <div class="check_box_bg">
                     <div class="custom-control custom-checkbox">
                        <input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo 'preop_postop_question_'.$value->id; ?>"  name="pre_op_post_op[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required">
                        <label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
                     </div>
                  </div>
                  <?php
                     $ic++;
                     }
                     ?>
               </div>
            </div>
         </div>
         <?php
            break;
            }
            }
            }
            ?>
      </div>
      <div class="back_next_button">
         <ul>
            <li style="float: right;margin-left: auto;">
               <button type="submit" class="btn details_next">Next</button>
            </li>
         </ul>
      </div>
   </div>
</div>
<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
<input type="hidden" name="tab_number" value="29">
<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ;
}
?>

<?php

if(in_array(30, $current_steps) && $tab_number == 30){

	$old_cancer_followup_general_detail = '';
	if(!empty($user_detail_old->chief_compliant_userdetail->cancer_followup_general_detail))
		$old_cancer_followup_general_detail = $user_detail_old->chief_compliant_userdetail->cancer_followup_general_detail;
	$ic = 1;
    echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_30')); ?>
	<div class="tab-pane fade  <?= ($tab_number==30  || 30==$current_steps[0])  ? '  show active ' : '' ?>" id="oncology_general" role="tabpanel" aria-labelledby="oncology_general-tab">
		<div class="errorHolder">
  		</div>
		<div class="TitleHead header-sticky-tit">
			<h3>General Details</h3>
			<div class="seprator"></div>
		</div>

		<div class="tab_form_fild_bg">
			<div class="row">
				<?php
					$i = 0 ;
					$cb_class = '';
					if(!empty($cancer_followup_general_question)){
						foreach ($cancer_followup_general_question as $key => $value) {


							$old_dqid_val = !empty($old_cancer_followup_general_detail) && isset($old_cancer_followup_general_detail[$value->id]) ? $old_cancer_followup_general_detail[$value->id] : '';

							switch ($value->question_type) {
								case 0:	?>

									<div class="col-md-12 <?php echo $value->id == 503 ? 'followup_general_question_474_503 display_none_at_load_time' : ''; ?>">
					 					<div class="form-group form_fild_row">
					 						<label>
					 							<?= $value->question ?>&nbsp;<span class="required">*</span>
					 						</label>
											<input type="text" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'followup_general_question_'.$value->id; ?>"  name="followup_general_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
 										</div>
									</div>

							<?php
									break;
								case 1:  ?>

										<div class="col-md-12">
				 							<div class="form-group form_fild_row">
 												<div class="radio_bg">
          											<label>
          												<?= $value->question ?>&nbsp;<span class="required">*</span>
          											</label>
													<div class="radio_list">
														<?php
														$options = unserialize($value->options) ;
														foreach ($options as $k => $v) {
														?>
	        												<div class="form-check">
	         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'followup_general_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="followup_general_detail[<?= $value->id ?>]"  required="true">
	         													<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
	       													</div>
														<?php
															$i++ ;
														}
														?>
													</div>
    											</div>
				 							</div>
										</div>
										<?php if($value->id == 473){?>
											<div class="col-md-12 <?php echo $value->id == 473 ? 'followup_general_question_474 display_none_at_load_time': ''; ?>" >
												<div class="form-group form_fild_row">
													<label>What is the main reason you need to see your doctor for?&nbsp;<span class="required">*</span></label>
													<div class="row">
												 <div class="col-md-8">
												 <div class="form-group form_fild_row chief_compliant_select_div">


											<div class="custom-drop">
												<input type="text" id="main_chief_compliant_id" class="form-control symptombox    <?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho' : 'symptom_suggestion'; // symptom_suggestion_ortho class will be added to main chief complaint box when the specialization is orthopedics(3) or orthopedics_spine (4) otherwise symptom_suggestion class will be added ?>" name="main_chief_compliant_id" placeholder="Enter symptom" value="<?php echo  !empty($user_detail_old->chief_compliant_userdetail->chief_compliant_id->name) ? $user_detail_old->chief_compliant_userdetail->chief_compliant_id->name : '' ?>" required="true" />

														<ul class="<?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho_listul' : 'symptom_suggestion_listul';  ?> custom-drop-li">
													</ul>
											</div>

												 </div>
												</div>

												<div class="col-md-4">
												 <div class="row">

													<div class="col-md-12">
													 <div class="form-group form_fild_row">
							      	 <?php  $old_compliant_length =  !empty($user_detail_old->chief_compliant_userdetail->compliant_length) ? $user_detail_old->chief_compliant_userdetail->compliant_length : '' ?>
													<select class="form-control" name="chief_compliant_length" required="true">
												<option value="">How long?</option>
												<option <?php echo $old_compliant_length == '1 hour' ? 'selected' : '' ?> value="1 hour">1 hour</option>
												<option <?php echo $old_compliant_length == '2 hours' ? 'selected' : '' ?> value="2 hours">2 hours</option>
												<option <?php echo $old_compliant_length == '3 hours' ? 'selected' : '' ?> value="3 hours">3 hours</option>
												<option <?php echo $old_compliant_length == '6 hours' ? 'selected' : '' ?> value="6 hours">6 hours</option>
												<option <?php echo $old_compliant_length == '12 hours' ? 'selected' : '' ?> value="12 hours">12 hours</option>


												<?php
														for ($i=1; $i < 14 ; $i++) {
															?>
													<option <?php echo $old_compliant_length == $i. ($i>1 ?' days' : ' day') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' days' : ' day') ?>"><?php echo  $i. ($i>1 ?' days' : ' day') ?></option>


															<?php

														}
														for ($i=2; $i < 7 ; $i++) {
															?>
													<option <?php echo $old_compliant_length == $i. ($i>1 ?' weeks' : ' week') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' weeks' : ' week') ?>"><?php echo  $i. ($i>1 ?' weeks' : ' week') ?></option>

															<?php

														}
														for ($i=2; $i < 12 ; $i++) {
															?>
													<option <?php echo $old_compliant_length == $i. ($i>1 ?' months' : ' month') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' months' : ' month') ?>"><?php echo  $i. ($i>1 ?' months' : ' month') ?></option>

															<?php

														}
														for ($i=1; $i < 11 ; $i++) {
															?>
													   <option <?php echo $old_compliant_length == $i. ($i>1 ?' years' : ' year') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' years' : ' year') ?>"><?php echo  $i. ($i>1 ?' years' : ' year') ?></option>

															<?php

														}
													?>
													<option value="10+ years">10+ years</option>

													</select>
													 </div>
													</div>
												 </div>
												</div>
												 </div>

												</div>
											</div>

											<style type="text/css">
												.symptom_field_display_none_onload{ display: none; }
												.medicalhistoryfld { margin-bottom: 10px;  }
											</style>



											<?php



											if(!empty($user_detail_old->chief_compliant_userdetail->sub_chief_compliant_id)){
											  foreach ($user_detail_old->chief_compliant_userdetail->sub_chief_compliant_id as $ky => $ve) {


											?>



											<div class="row  medicalhistoryfld col-md-12 <?php echo $value->id == 473 ? 'followup_general_question_474 display_none_at_load_time': ''; ?>">
												    <div class="col-md-6">
													 <div class="form-group form_fild_row">


											<div class="custom-drop">
													<input type="text"  value="<?= $ve->name ?>"  class="form-control    symptom_suggestion" name="chief_compliant_id[]" placeholder="Enter Symptom"/>

												      <ul class="symptom_suggestion_listul custom-drop-li">
														</ul>

													</div>

												     </div>
													</div>

													<div class="col-md-6">
														<div class="row">
													  <div class="col-md-5 medicalhistoryfldtimes">
													   <div class="crose_year">
													    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
													   </div>
													  </div>
													</div>

													</div>
												   </div>


											<?php
											}
											}
											?>


											<!-- we will display here the old data end ************************** -->

											<div class="row medicalhistoryfld col-md-12">

											</div>
												<div class="col-md-12 <?php echo $value->id == 473 ? 'followup_general_question_474 display_none_at_load_time': ''; ?>">
														 <div class="form-group form_fild_row">

														   <div class="crose_year">
														    <button  type="button"  class="btn medicalhistoryfldadd btn-medium">add a Symptom</button>
														   </div>


														 </div>

													</div>

													<div class="row  symptom_field_display_none_onload">
														    <div class="col-md-6">
															 <div class="form-group form_fild_row">

													<div class="custom-drop">
															<input type="text"    class="form-control    <?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho' : 'symptom_suggestion';?>" name="chief_compliant_id[]" placeholder="Enter Symptom"/>

														      <ul class="<?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho_listul' : 'symptom_suggestion_listul';  ?> custom-drop-li">
																</ul>

															</div>



														     </div>
															</div>

															<div class="col-md-6">
														     <div class="row">

															  <div class="col-md-5 medicalhistoryfldtimes">
															   <div class="crose_year">
															    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
															   </div>
															  </div>
															 </div>
															</div>
													</div>


										<?php }?>
									<?php
										break;
										case 3: ?>

											<div class="col-md-12">
					 							<div class="form-group form_fild_row">
					 								<label>
					 									<?= $value->question ?>
														<?php
														$options = unserialize($value->options) ; ?>
													 	<?php if(isset($options[0]) && !empty($value->question)){ ?>
													 		<?php if(!empty($options[0])){ ?>
														 		<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">

														 		<i class="fa fa-question-circle" aria-hidden="true"></i></a>
														 	<?php } ?>
													 		<span class="required">*</span>
													 	<?php } ?>
					 								</label>

													<select class="form-control <?php echo 'followup_general_question_'.$value->id; ?>" name="followup_general_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">
														<?php if($value->id == 64 ||$value->id == 69 ||$value->id == 70){

															foreach ($options as $ky => $ve) {

																if($value['id'] == 66 || $value['id'] == 98 || $value['id'] == 100 || $value['id'] == 104 || $value['id'] == 77){
																	echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".$ky.">".$ve."</option>";
																	 // for 15 id we will send the value as the select box value

																}
																else{

																	echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".$ky.">".$ve."</option>";
																	 // for 15 id we will send the value as the select box value
																}
															}

														}else{ ?>

														<?php

															foreach ($options as $ky => $ve) {

																if($value['id'] == 66 || $value['id'] == 98 || $value['id'] == 100 || $value['id'] == 104 || $value['id'] == 77){

																	echo "<option ".($old_dqid_val == $ky ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>"; // for 15 id we will send the value as the select box value
																}
																else{

																	echo "<option ".($old_dqid_val == $ve ? 'selected' : '')." value=".($ky == 0 ? ($value->id == 15 ? "'".$ve."'" : '') : ($value->id == 15 ? "'".$ve."'" : $ky)).">".$ve."</option>"; // for 15 id we will send the value as the select box value
																	}
																}
														}
														?>
													</select>
					 							</div>
											</div>
										<?php
										     	break;
										    case 2:
										?>
												<div class="col-md-12 <?php echo $value->id == 472 ? 'followup_general_question_471_472 display_none_at_load_time': ''; ?><?php echo $value->id == 474 ? 'followup_general_question_473_474 display_none_at_load_time' : ''; ?>">
					 								<div class="form-group form_fild_row <?= in_array($value->id, [472,474]) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 									<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 									<div class="<?= in_array($value->id, [472,474]) ? 'new_appoint_checkbox_quest' : '' ?>">
					 										<span></span>
					 										<?php
					 											$options = unserialize($value->options) ;
 																$temp_old_dqid_val = array();
																$old_36_37_38 = array();
																if(is_array($old_dqid_val)){
																	foreach ($old_dqid_val as $kdq => $vdq) {
																		if(($pos = stripos($vdq, '-')) !== false){
																			$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																			// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																			$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																		}else{
																			$temp_old_dqid_val[$vdq] = $vdq;
																		}
																	}
																}

																$old_dqid_val = $temp_old_dqid_val;
																foreach ($options as $ky => $val) {
			 												?>
																	<div class="check_box_bg">
		 																<div class="custom-control custom-checkbox">
          																	<input
          																	<?php
          																	if($value->id == 474){

          																		echo is_array($old_dqid_val) && in_array($val, $old_dqid_val)   ? 'checked' : '';
          																	}
          																	else{

          																		echo is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '';
          																	}
          																	?>
          																	 class="custom-control-input <?= $cb_class ?> <?php echo 'followup_general_question_'.$value->id; ?>"  name="followup_general_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required">
          																	<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         																</div>
		 															</div>

													 			<?php
													 				$ic++;
															 	}
															 	?>
															</div>
					 									</div>
													</div>

												<?php
													break;
												}
											}
										}
									?>
			   					</div>


							    <div class="TitleHead header-sticky-tit">
								 <h3>Current medication</h3>
								</div>

								<div class="tab_form_fild_bg">

								<!-- fill the old data when edited start ******************************************************  -->
								<?php
								if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail)){
									$cmd_old = $user_detail_old->chief_compliant_userdetail->compliant_medication_detail;

									foreach ($cmd_old as $ky => $ve) {

								?>

								<div class="row  currentmedicationfld">
									<div class="col-md-4">
										<div class="form-group form_fild_row">
											<div class="custom-drop">
												<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
									      		<ul class="med_suggestion_listul custom-drop-li">
												</ul>
											</div>
									    </div>
									</div>
									<div class="col-md-2">
										 <div class="form-group form_fild_row">
										  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
										 </div>
										</div>

									<div class="col-md-2">
									 <div class="form-group form_fild_row">
									  <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->

									<select class="form-control" name="medication_how_often[]">
										<option value="">how often?</option>
									<?php
											foreach ($length_arr as $key => $value) {

										echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

											}
										?>
										</select>

									 </div>
									</div>
								    <div class="col-md-3">
									 <div class="form-group form_fild_row">


					<div class="custom-drop">

					<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
						      <ul class="how_taken_suggestion_listul custom-drop-li">
								</ul>

							</div>



									 </div>
									</div>


								<div class="col-md-1">
							     <div class="row">

								  <div class=" currentmedicationfldtimes">
								   <div class="crose_year">
								    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
								   </div>
								  </div>
								 </div>
								</div>
							   </div>
							<?php
							}
							}

							?>
							<!-- fill the old data when edited end ******************************************************* -->

					   <div class="row currentmedicationfld">

					   </div>

					<div class="row">
						    <div class="col-md-6">
							 <div class="form-group form_fild_row">

							   <div class="crose_year">
							    <button  type="button"  class="btn currentmedicationfldadd btn-medium">add a medication</button>
							   </div>


							 </div>
							</div>
						</div>

								<div class="back_next_button">
									<ul>
									 	<li style="float: right;margin-left: auto;">
									  		<button type="submit" class="btn details_next">Next</button>
									 	</li>
									</ul>
			   					</div>
			  				</div>
			 			</div>
		  				<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 			<input type="hidden" name="tab_number" value="30">
			 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ;?>


<script type="text/javascript">

$(document).ready(function() {
 $(document).on("click",".medicalhistoryfldadd",function() {


		var cloneob = $( ".symptom_field_display_none_onload" ).clone();

$( cloneob ).addClass('medicalhistoryfld col-md-12').removeClass('symptom_field_display_none_onload');
$( cloneob ).find('input').addClass('symptombox');
// $( cloneob ).find('select').addClass('symptombox').select2(); // commented as select box is not used now
		$(cloneob).insertAfter( ".medicalhistoryfld:last" );

	});
});



searchRequest = null;
$(document).on("keyup click", ".symptom_suggestion", function () {


				value = $(this).val();

				if(!value || ($.trim(value) == '')){
					return;
				}
				value = $.trim(value);
				if(value){
					value = value.split(',');
					value = value[value.length - 1] ;
				}

						if (searchRequest != null)
								searchRequest.abort();
						var curele = this;
						searchRequest = $.ajax({
								type: "GET",
								url: "<?php echo SITE_URL; ?>"+"/users/getsymptomsuggestion",
								data: {
									// 'search_type' : 1, // 1 for searching medical  condition
										'search_keyword' : value
								},
								dataType: "text",
								success: function(msg){
									var msg = JSON.parse(msg);
									var temphtml = '' ;
									$.each(msg, function(index, element) {
										// alert(index);
										// alert(element);
										temphtml += '<li  symptom_suggestion_attrid ="'+index+'"  symptom_suggestion_attr ="'+element+'" >'+element+'</li>' ;

					});
					// $(curele).next('.symptom_suggestion_listul').html(temphtml);
						$(curele).parents('.custom-drop').find('.symptom_suggestion_listul').html(temphtml);

										//we need to check if the value is the same

								}
						});

		});



$(document).on("click", ".symptom_suggestion_listul li", function () {


var diag_sugg_atr = $(this).attr('symptom_suggestion_attr');
var parent_list = $(this).parent('.symptom_suggestion_listul');
var current_index = $('.symptom_suggestion_listul').index(parent_list);



//console.log('gfgfgf');
// $(this).parents('.symptom_suggestion_listul').empty();
// return;
var pre_exist_flg = false;
$('.symptom_suggestion').each(function( index, element ) {
if(current_index != index && ($(element).val()).indexOf(diag_sugg_atr) != -1) pre_exist_flg = true;
});

if(pre_exist_flg){
alert(diag_sugg_atr + ' is already chosen before.')
$(this).parents('.symptom_suggestion_listul').empty();
$('.symptom_suggestion').each(function( index, element ) {
	if(current_index == index)
	{
		$(this).val('');
	}
})
return;
}


if(pre_exist_flg == false)
{
				 checkSynonyms('symptom_suggestion',diag_sugg_atr, current_index);
}



// alert(diag_sugg_atr);

var diag_sugg_atrid = $(this).attr('symptom_suggestion_attrid'); // get also id of the symptom



// var tmptext = $(this).parents('.symptom_suggestion_listul').prev('.symptom_suggestion');
var tmptext = $(this).parents('.custom-drop').find('.symptom_suggestion');
// console.log(tmptext);
var ttext = $(tmptext).val();
$(tmptext).attr('chief_cmp_attrid', diag_sugg_atrid );
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

$(this).parents('.symptom_suggestion_listul').empty();

// checking if the field is for chief complaint and not symptom then call quickpicks
if($(tmptext).attr('name') == "main_chief_compliant_id"){

add_medicatin_quickpick(diag_sugg_atrid); // call medication quick pick
$("#main_chief_compliant_id").valid(); // validate single element in jquery validate js
}
});

$(document).on("click",".symptomboxdiv button",function() {
 var  index_id = $(this).attr('chief_cmp_attrid');
 var flag = true;
 var symptomflag = true;

var spcializationClass = '<?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho' : 'symptom_suggestion'?>';
 // for symtom start
if(symptomflag){ // for main chief compliant , this if block will run only when the main chief compliant field is not empty
 // var  index = $(this).attr('condval');
 var  index = $(this).attr('chief_cmp_attrid_val');
// alert(index);
// check that option is pre existing or not start
 var ccav = index;
 var pre_exist_flg = false;
 $('.'+spcializationClass).each(function( index, element ) {
			if(($(element).val()).indexOf(ccav) != -1) pre_exist_flg = true;
	 });

 if(pre_exist_flg){
	 alert(ccav + ' is already chosen before.')
	 // $(this).parents('.symptom_suggestion_listul').empty();
		 return;
 }
// check that option is pre existing or not end

//check synonyms exist or not
var pre_exist_synonyms = false;

$.ajax({
					 type: 'POST',
					 url: "<?php echo SITE_URL.'users/synonyms/' ?>",
					 data: {
							 value: ccav
					 },
					 beforeSend: function(xhr) { // Add this line
							 xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
					 },
					 success: function(res) {

							 var samevalue = '';
							 $.each(JSON.parse(res), function(key, value) {

									 $('.'+spcializationClass).each(function(index, element) {
									 console.log(value + '' + $(element).val().toLowerCase().trim());
											 if (value == $(element).val().toLowerCase().trim()) {

													 pre_exist_synonyms = true;
													 samevalue = $(element).val().toLowerCase().trim();
													 return;
											 }
									 })
							 });
							 if(pre_exist_synonyms)
							 {
								 alert(samevalue +' is synonyms of ' + ccav +' that already exist');
								 return;
							 }

							 if(!pre_exist_synonyms){

						 var flag = true;
						 $('input.symptombox').each(function(i, obj) {
								 if($(obj).val()===""){
									 flag = false;
									 $(obj).val(index);
									 $(obj).attr('chief_cmp_attrid', index_id ); // add the id also as input attribute

									 return false;
								 }
						 });
						 if(flag){
							 $( ".medicalhistoryfldadd" ).trigger( "click" );
							 $('input.symptombox').each(function(i, obj) {
									 if($(obj).val()===""){
										 $(obj).val(index);
										 $(obj).attr('chief_cmp_attrid', index_id ); // add the id also as input attribute
										 return false;
									 }
							 });

						 }
					 }
							 //alert(pre_exist_synonyms);
					 },
					 error: function(e) {
							 // window.location = "<?php //echo SITE_URL.'providers/'; ?>"
					 }
			 });
}
 // for symptom end
		});

		/*
		  To check synonyms in cheif complaint table
		*/
		function checkSynonyms(spcializationClass,inpuvalue,current_index = null)
		{
			$.ajax({
						    type: 'POST',
						    url: "<?php echo SITE_URL.'users/synonyms/' ?>",
						    data: {
						        value: inpuvalue
						    },
						    beforeSend: function(xhr) { // Add this line
						        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
						    },
						    success: function(res) {
						        console.log(res);
						        var pre_exist_synonyms = false;
						        var samevalue;
						        $.each(JSON.parse(res), function(key, value) {
						            $('.'+spcializationClass).each(function(index, element) {
						                if (value == $(element).val().toLowerCase().trim()) {
						                    pre_exist_synonyms = true;
						                    samevalue = $(element).val().toLowerCase().trim();
						                    return;
						                }
						            })
						        });
						        if(pre_exist_synonyms)
						        {
						        	alert(samevalue +' is synonyms of ' + inpuvalue +' that already exist');
						        	$('.'+spcializationClass).each(function( index, element ) {
										if(current_index == index)
										{
											$(this).val('');
										}
									})
						        }
						        //alert(pre_exist_synonyms);
						    },
						    error: function(e) {
						        // window.location = "<?php //echo SITE_URL.'providers/'; ?>"
						    }
						})
		}




</script>
<?php
}
?>


<?php

if(in_array(31, $current_steps) && $tab_number == 31){

	$old_chief_compliant_details = '';

	if(!empty($user_detail_old->chief_compliant_userdetail->followup_medical_history_detail))
		$old_followup_medical_history_detail = $user_detail_old->chief_compliant_userdetail->followup_medical_history_detail;



	$ic = 1;
  echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_31')); ?>
	<div class="tab-pane fade  <?= ($tab_number == 31  || 31 ==$current_steps[0])  ? '  show active ' : '' ?>" id="oncology_medical_history" role="tabpanel" aria-labelledby="oncology_medical_history-tab">
		<div class="errorHolder">
  		</div>
		<div class="TitleHead header-sticky-tit">
			<h3>Medical History Details</h3>
			<div class="seprator"></div>
		</div>

		<div class="tab_form_fild_bg">
			<div class="row">
				<?php
					$i = 0 ;
					$cb_class = '';
					if(!empty($cancer_followup_medical_history_question)){
						foreach ($cancer_followup_medical_history_question as $key => $value) {

							if($login_user['gender'] != 0 && $value->id == 504){
								continue;
							}
							$old_dqid_val = !empty($old_followup_medical_history_detail) && isset($old_followup_medical_history_detail['followup_medical_history_detail'][$value->id]) ? $old_followup_medical_history_detail['followup_medical_history_detail'][$value->id] : '';

							switch ($value->question_type) {
								case 0:	?>

									<div class="col-md-12 <?php echo $value->id == 485 ? 'followup_medical_history_question_484_485 display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [480,481,482,483]) ? 'hospital_stay_questions display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [486,487,488]) ? 'er_room_visit_questions display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [508,509,510]) ? 'followup_medical_history_question_507_lmp_yes display_none_at_load_time' : ''; ?><?php echo $value->id == 517 ? 'followup_medical_history_question_516_517 display_none_at_load_time' : ''; ?><?php echo $value->id == 515 ? 'followup_medical_history_question_514_515 display_none_at_load_time' : ''; ?>">
					 					<div class="form-group form_fild_row">
					 						<label>
					 							<?= $value->question ?>&nbsp;<span class="required">*</span>
					 						</label>

											<?php if($value->data_type == 2){ ?>

												<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'followup_medical_history_question_'.$value->id; ?>"  name="followup_medical_history_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
											<?php }
											else{ ?>

												<input type="text" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'followup_medical_history_question_'.$value->id; ?>"  name="followup_medical_history_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
										<?php } ?>
 										</div>
									</div>

							<?php
									break;
								case 1:  ?>

										<div class="col-md-12 <?php echo in_array($value->id, [484]) ? 'hospital_stay_questions display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [489,490]) ? 'er_room_visit_questions display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [479]) ? 'followup_medical_history_question_478_479 display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [511]) ? 'followup_medical_history_question_507_lmp_yes display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [514]) ? 'followup_medical_history_question_511_514 display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [515]) ? 'followup_medical_history_question_514_515 display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [516]) ? 'followup_medical_history_question_514_516 display_none_at_load_time' : ''; ?><?php echo in_array($value->id, [513]) ? 'followup_medical_history_question_512_513 display_none_at_load_time' : ''; ?>">
				 							<div class="form-group form_fild_row">
 												<div class="radio_bg">
          											<label>
          												<?= $value->question ?>&nbsp;<span class="required">*</span>
          											</label>
													<div class="radio_list">
														<?php
														$options = unserialize($value->options) ;

														foreach ($options as $k => $v) {
														?>
	        												<div class="form-check">
	         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'followup_medical_history_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="followup_medical_history_detail[<?= $value->id ?>]"  required="true">
	         													<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
	       													</div>
														<?php
															$i++ ;
														}
														?>
													</div>
    											</div>
				 							</div>
										</div>

										<?php
										if($value->id == 476){

										if(!empty($old_followup_medical_history_detail['medical_history'])) {

											$tempmedical_history = $old_followup_medical_history_detail['medical_history'];

											$old_medical_suggestion_name = array();



											foreach($tempmedical_history as $k => $v) {

												$old_medical_suggestion_name[] = $v['name'];
										?>
											<div class="col-md-12 <?php echo $value->id == 476 ? 'followup_general_question_476 display_none_at_load_time': ''; ?>">
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
														<div class="col-md-5 medicalhistoryfldtimes followupmedicaltimes">
															<div class="crose_year">
																<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
															</div>
														</div>
												</div>
											</div>
											</div>
										</div>
									<?php } }

									?>
									<div class="col-md-12 <?php echo $value->id == 476 ? 'followup_general_question_476 display_none_at_load_time': ''; ?>">
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

													<div class="col-md-5 medicalhistoryfldtimes followupmedicaltimes">
														<div class="crose_year">
															<button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
														</div>
													</div>
											</div>
										</div>
										</div>
									</div>

									<div class="col-md-12 <?php echo $value->id == 476 ? 'followup_general_question_476 display_none_at_load_time': ''; ?>">
									<div class="form-group form_fild_row">
										<div class=" medicalhistoryfldadd">
												<div class="crose_year">
													<button  type="button"  class="btn btn-medium">Add a condition</button>
												</div>
										</div>
									</div>
								 </div>

								  <?php }?>


								 <?php 	if($value->id == 477){ ?>

									 <?php
									 if(!empty($old_followup_medical_history_detail['surgical_history'])) {

										 $tempmedical_history = $old_followup_medical_history_detail['surgical_history'];

										 $old_sergical_con_arr = array();
										 foreach($tempmedical_history as $k => $v) {
											 $old_sergical_con_arr[] = $v['name'];
									 ?>
									 	<div class="col-md-12 <?php echo $value->id == 477 ? 'followup_general_question_477 display_none_at_load_time': ''; ?>">
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
											 </div>
										 <?php } } ?>



									 <div class="col-md-12 <?php echo $value->id == 477 ? 'followup_general_question_477 display_none_at_load_time': ''; ?>">
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
								 </div>


										<div class="col-md-12 <?php echo $value->id == 477 ? 'followup_general_question_477 display_none_at_load_time': ''; ?>">
										 <div class="form-group form_fild_row">
											 <div class=" surgicalhistoryfldadd">
													 <div class="crose_year">
														 <button  type="button" class="btn btn-medium">Add a surgery</button>
													 </div>
												 </div>
										 </div>
									 </div>


								<?php } ?>

								<?php if($value->id == '497') {
									$al = 0 ;
									if(!empty($old_followup_medical_history_detail['allergy_history'])) {

										$tempmedical_history =  $old_followup_medical_history_detail['allergy_history'];

										$old_allergy_cond_arr = array();

										foreach($tempmedical_history as $k => $v) {


											$old_allergy_cond_arr[] = $v['name'];
									?>
									<div class="col-md-12 <?php echo $value->id == 497 ? 'followup_general_question_497 display_none_at_load_time': ''; ?>">
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
											</div>
										<?php $al++ ;  } } ?>

										<script>
										  var al = '<?= $al ?>';
											$(document).ready(function() {
											    $(document).on("click", ".allergyhistoryfldadd button", function() {
											        al++;
											        var alergy_clone = $(".allergyhistoryfld:last").clone();
											        $(alergy_clone).find('.react_cond_select').attr('name', 'allergy_history[' + al + '][reaction]');

											        $(alergy_clone).find('.al_cond_select').attr('name', 'allergy_history[' + al + '][name]');
											        $(alergy_clone).find('input').each(function() {
											            $(this).parents('.on_load_display_none_cls').removeClass('on_load_display_none_cls');
											            $(this).removeAttr('disabled');
											            $(this).val('');
											        });
											        $(alergy_clone).insertAfter(".allergyhistoryfld:last");
											    });
											    $(document).on("click", ".allergyhistoryfldtimes button", function() {
											        if ($(this).parents('.allergyhistoryfld').find('input.allergycondbox').val().trim() == "Latex") {
											            $("input[value='0'].is_latex_allergy").prop("checked", true); // if user removes Latex then uncheck
											        }
											        var remove_val = $(this).parents('.allergyhistoryfld').find('input.allergycondbox').val().trim();
											        var flag = false;
											        $(this).parents('.allergyhistoryfld').remove();
											        $('.allergy_suggestion').each(function() {
											            if (remove_val == $(this).val()) {
											                flag = true;
											            }
											        });
											        if (!flag) {

											            $('.allergycondboxdiv button').each(function() {

											                var attr = $(this).attr('condval');
											                if (remove_val == attr) {

											                    $(this).removeClass('selected_chief_complaint');
											                }
											            })
											        }
											    });
											});
										</script>


									<div class="col-md-12 <?php echo $value->id == 497 ? 'followup_general_question_497 display_none_at_load_time': ''; ?>">
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
							</div>





								<div class="col-md-12 <?php echo $value->id == 497 ? 'followup_general_question_497 display_none_at_load_time': ''; ?>">
								<div class="form-group form_fild_row">
									<div class=" allergyhistoryfldadd">
											<div class="crose_year">
												<button  type="button"  class="btn btn-medium">Add a allergy</button>
											</div>
										</div>
								</div>
							</div>


							  <?php } ?>


									<?php
										    break;
										case 3:
										?>

											<div class="col-md-12 <?php echo $value->id == 492 ? 'followup_general_question_491_492 display_none_at_load_time': ''; ?><?php echo $value->id == 494 ? 'followup_general_question_493_494 display_none_at_load_time': ''; ?>">
					 							<div class="form-group form_fild_row">
					 								<label>
					 									<?= $value->question ?>
														<?php
														$options = unserialize($value->options) ; ?>
													 	<?php if(isset($options[0]) && !empty($value->question)){ ?>
													 		<?php if(!empty($options[0])){ ?>
														 		<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">
														 		<i class="fa fa-question-circle" aria-hidden="true"></i></a>
														 	<?php } ?>
													 	<?php } ?>
													 	<span class="required">*</span>
					 								</label>

													<select class="form-control <?php echo 'followup_medical_history_question_'.$value->id; ?>" name="followup_medical_history_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">
														<?php if($value->id == 492 ||$value->id == 494){
															?>
															<option value=""></option>
										        	<?php
										        		$cnt = 1;
											        	for($cnt ; $cnt<= 10 ; $cnt++){
											        		echo "<option ".(isset($old_dqid_val) && $old_dqid_val ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
											        	}
										        	?>
						        					<option <?=  (isset($old_dqid_val) && $old_dqid_val == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 packs</option>
															<?php

														}
														elseif(in_array($value->id, [504,505,506])){
															?>
															<option value=""></option>
															<option value="dont remember" <?php echo $old_dqid_val == 'dont remember' ? "selected" : ""; ?>>Don't remember</option>
										        	<?php

											        	for($start_year = date('Y') ; $start_year >= 1997 ; $start_year--){
											        		echo "<option ".(isset($old_dqid_val) && $old_dqid_val ==$start_year? 'selected' : '')."  value=".$start_year.">".$start_year."</option>";
											        	}

														}
														?>
													</select>
					 							</div>
											</div>
										<?php
										     	break;
										    case 2:
										?>
												<div class="col-md-12 <?php echo $value->id == 472 ? 'followup_general_question_471_472 display_none_at_load_time': ''; ?>">
					 								<div class="form-group form_fild_row <?= in_array($value->id, [472]) ? 'new_appoint_checkbox_quest_a' : '' ?>">
					 									<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 									<div class="<?= in_array($value->id, [472]) ? 'new_appoint_checkbox_quest' : '' ?>">
					 										<span></span>
					 										<?php
					 											$options = unserialize($value->options) ;
 																$temp_old_dqid_val = array();
																$old_36_37_38 = array();
																if(is_array($old_dqid_val)){
																	foreach ($old_dqid_val as $kdq => $vdq) {
																		if(($pos = stripos($vdq, '-')) !== false){
																			$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																			// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																			$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																		}else{
																			$temp_old_dqid_val[$vdq] = $vdq;
																		}
																	}
																}

																$old_dqid_val = $temp_old_dqid_val;
																foreach ($options as $ky => $val) {
			 												?>
																	<div class="check_box_bg">
		 																<div class="custom-control custom-checkbox">
          																	<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo 'followup_medical_history_question_'.$value->id; ?>"  name="followup_medical_history_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required">
          																	<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         																</div>
		 															</div>

													 			<?php
													 				$ic++;
															 	}
															 	?>
															</div>
					 									</div>
													</div>

												<?php
													break;
												}
											}
										}
									?>
			   					</div>

								<div class="back_next_button">
									<ul>
										<li>
				  							<button id="oncology_general-backbtn" type="button" class="btn nofillborder">Previous Tab</button>
				 						</li>
									 	<li style="float: right;">
									  		<button type="submit" class="btn details_next">Next</button>
									 	</li>
									</ul>
			   					</div>
			  				</div>
			 			</div>
		  				<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 			<input type="hidden" name="tab_number" value="31">
			 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ;

}
?>

<?php

if(in_array(33, $current_steps) && $tab_number == 33){
	//pr($user_detail_old); die;

	$old_chief_compliant_details = '';

	if(!empty($user_detail_old->chief_compliant_userdetail->hospital_er_detail))
		$old_hospital_er_detail = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->hospital_er_detail), SEC_KEY));


	//pr($old_hospital_er_detail); die;
	$ic = 1;
  echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'form_tab_33')); ?>
	<div class="tab-pane fade  <?= ($tab_number == 33  || 33 ==$current_steps[0])  ? '  show active ' : '' ?>" id="hospital_er_info" role="tabpanel" aria-labelledby="hospital_er_info-tab">
		<div class="errorHolder">
  		</div>
		<div class="TitleHead header-sticky-tit">
			<h3>Hospital/ER Information</h3>
			<div class="seprator"></div>
		</div>

		<div class="tab_form_fild_bg">
			<div class="row">
				<?php
					$i = 0 ;
					$cb_class = '';
					//pr($old_hospital_er_detail); die;
					if(!empty($hospital_er_question)){
						foreach ($hospital_er_question as $key => $value) {

							if($login_user['gender'] != 0 && $value->id == 504){
								continue;
							}
							$old_dqid_val = !empty($old_hospital_er_detail) && isset($old_hospital_er_detail[$value->id]) ? $old_hospital_er_detail[$value->id] : '';

							switch ($value->question_type) {
								case 0:	?>

									<div class="col-md-12 <?php echo $value->id == 522 ? 'hospital_er_question_521_522 display_none_at_load_time' : ""; ?><?php echo in_array($value->id, [523,524,525]) ? 'er_info_questions display_none_at_load_time': ""; ?><?php echo in_array($value->id, [517,518,519,520]) ? 'hospital_info_questions display_none_at_load_time': ""; ?>">
					 					<div class="form-group form_fild_row">
					 						<label>
					 							<?= $value->question ?>&nbsp;<span class="required">*</span>
					 						</label>

											<?php if($value->data_type == 2){ ?>

												<input type="number" pattern="[0-9]*" inputmode="numeric" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'hospital_er_question_'.$value->id; ?>"  name="hospital_er_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
											<?php }
											else{ ?>

												<input type="text" value="<?= $old_dqid_val ?>" class="form-control <?php echo 'hospital_er_question_'.$value->id; ?>"  name="hospital_er_detail[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true"/>
										<?php } ?>
 										</div>
									</div>

							<?php
									break;
								case 1:  ?>


										<div class="col-md-12 <?php echo in_array($value->id, [526,527]) ? 'er_info_questions display_none_at_load_time': ""; ?><?php echo in_array($value->id, [521]) ? 'hospital_info_questions display_none_at_load_time': ""; ?>">
				 							<div class="form-group form_fild_row">
 												<div class="radio_bg">
          											<label>
          												<?= $value->question ?>&nbsp;<span class="required">*</span>
          											</label>
													<div class="radio_list">
														<?php
														$options = unserialize($value->options) ;


														foreach ($options as $k => $v) {
														?>
	        												<div class="form-check">
	         													<input type="radio"  value="<?= $v ?>" <?= $old_dqid_val == $v ? 'checked' : ''  ?>   class="form-check-input <?php echo $old_dqid_val == $v ? 'trigger_click_if_checked' : '' ?> <?php echo 'hospital_er_question_'.$value->id; ?>" id="radio_question<?= $i ?>" name="hospital_er_detail[<?= $value->id ?>]"  required="true">
	         													<label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
	       													</div>
														<?php
															$i++ ;
														}
														?>
													</div>
    											</div>
				 							</div>
										</div>
									<?php
										    break;
										case 3:
										?>

											<div class="col-md-12">
					 							<div class="form-group form_fild_row">
					 								<label>
					 									<?= $value->question ?>
														<?php
														$options = unserialize($value->options) ; ?>
													 	<?php if(isset($options[0]) && !empty($value->question)){ ?>
													 		<?php if(!empty($options[0])){ ?>
														 		<a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $options[0]; // first option is placeholder  ?>">
														 		<i class="fa fa-question-circle" aria-hidden="true"></i></a>
														 	<?php } ?>
													 	<?php } ?>
													 	<span class="required">*</span>
					 								</label>

													<select class="form-control <?php echo 'followup_medical_history_question_'.$value->id; ?>" name="hospital_er_detail[<?= $value->id ?>]" style="background: #ececec;" required="true" id="question_<?= $value->id ?>">
														<?php if($value->id == 492 ||$value->id == 494){
															?>
															<option value=""></option>
										        	<?php
										        		$cnt = 1;
											        	for($cnt ; $cnt<= 10 ; $cnt++){
											        		echo "<option ".(isset($old_dqid_val) && $old_dqid_val ==$cnt? 'selected' : '')."  value=".$cnt.">".$cnt."</option>";
											        	}
										        	?>
						        					<option <?=  (isset($old_dqid_val) && $old_dqid_val == 'morethan10' ? 'selected' : '')  ?> value="morethan10">More than 10 packs</option>
															<?php

														}
														elseif(in_array($value->id, [504,505,506])){
															?>
															<option value=""></option>
															<option value="dont remember" <?php echo $old_dqid_val == 'dont remember' ? "selected" : ""; ?>>Don't remember</option>
										        	<?php

											        	for($start_year = date('Y') ; $start_year >= 1997 ; $start_year--){
											        		echo "<option ".(isset($old_dqid_val) && $old_dqid_val ==$start_year? 'selected' : '')."  value=".$start_year.">".$start_year."</option>";
											        	}

														}
														?>
													</select>
					 							</div>
											</div>
										<?php
										     	break;
										    case 2:
										?>
												<div class="col-md-12 ">
					 								<div class="form-group">
					 									<label><?= $value->question ?>&nbsp;<span class="required">*</span></label>
					 									<div class="">
					 										<span></span>
					 										<?php
					 											$options = unserialize($value->options) ;
 																$temp_old_dqid_val = array();
																$old_36_37_38 = array();
																if(is_array($old_dqid_val)){
																	foreach ($old_dqid_val as $kdq => $vdq) {
																		if(($pos = stripos($vdq, '-')) !== false){
																			$old_36_37_38[strstr($vdq, '-', true)] =	substr($vdq, $pos+1);
																			// $old_dqid_val[$kdq] = strstr($vdq, '-', true); // substr($vdq, 0, strpos($vdq, "-"));

																			$temp_old_dqid_val[strstr($vdq, '-', true)] = $vdq;
																		}else{
																			$temp_old_dqid_val[$vdq] = $vdq;
																		}
																	}
																}

																$old_dqid_val = $temp_old_dqid_val;
																foreach ($options as $ky => $val) {
			 												?>
																	<div class="check_box_bg">
		 																<div class="custom-control custom-checkbox">
          																	<input <?= is_array($old_dqid_val) && array_key_exists($val, $old_dqid_val)   ? 'checked' : '' ?> class="custom-control-input <?= $cb_class ?> <?php echo 'followup_medical_history_question_'.$value->id; ?>"  name="hospital_er_detail[<?= $value->id ?>][]"  id="checkbox<?= $ic ?>" value="<?= !empty($old_dqid_val[$val]) ? $old_dqid_val[$val] : $val ?>" fixval="<?= $val ?>" type="checkbox" required="required">
          																	<label class="custom-control-label" for="checkbox<?= $ic ?>"><?= $val ?></label>
         																</div>
		 															</div>

													 			<?php
													 				$ic++;
															 	}
															 	?>
															</div>
					 									</div>
													</div>

												<?php
													break;
												}
											}
										}
									?>
			   					</div>
			   					<!-- Add a medication -->

								<!-- <div class="tab_form_fild_bg"> -->
										    <div class="TitleHead header-sticky-tit">
											 <h3>Current medication</h3>
											</div>
										<!-- </div> -->

								<!-- fill the old data when edited start ******************************************************  -->
								<?php
								if(!empty($user_detail_old->chief_compliant_userdetail->compliant_medication_detail)){
									$cmd_old = $user_detail_old->chief_compliant_userdetail->compliant_medication_detail;

									foreach ($cmd_old as $ky => $ve) {

								?>

								<div class="row  currentmedicationfld">
									<div class="col-md-4">
										<div class="form-group form_fild_row">
											<div class="custom-drop">
												<input type="text" value="<?php echo  !empty($ve['medication_name_name']) ? $ve['medication_name_name'] : ''; ?>"   class="form-control  med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
									      		<ul class="med_suggestion_listul custom-drop-li">
												</ul>
											</div>
									    </div>
									</div>
									<div class="col-md-2">
										 <div class="form-group form_fild_row">
										  <input name="medication_dose[]"  value="<?php echo  !empty($ve['medication_dose']) ? $ve['medication_dose'] : ''; ?>"   type="text" class="form-control" placeholder="Dose"/>
										 </div>
										</div>

									<div class="col-md-2">
									 <div class="form-group form_fild_row">
									  <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->

									<select class="form-control" name="medication_how_often[]">
										<option value="">how often?</option>
									<?php
											foreach ($length_arr as $key => $value) {

										echo "<option ".(!empty($ve['medication_how_often']) && $ve['medication_how_often'] == $key ? "selected" : '' )." value=".$key.">".$value."</option>";

											}
										?>
										</select>

									 </div>
									</div>
								    <div class="col-md-3">
									 <div class="form-group form_fild_row">



					<div class="custom-drop">


					<input type="text" name="medication_how_taken[]"  value="<?php echo  !empty($ve['medication_how_taken']) ? $ve['medication_how_taken'] : ''; ?>"  class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
						      <ul class="how_taken_suggestion_listul custom-drop-li">
								</ul>

							</div>



									 </div>
									</div>


								<div class="col-md-1">
							     <div class="row">

								  <div class=" currentmedicationfldtimes">
								   <div class="crose_year">
								    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
								   </div>
								  </div>
								 </div>
								</div>
							   </div>
							<?php
							}
							}

							?>
							<!-- End Edited Tab of Medication -->
								<div class="row currentmedicationfld"></div>
								<div class="row">
								    <div class="col-md-6">
									 <div class="form-group form_fild_row">

									   <div class="crose_year">
									    <button  type="button"  class="btn currentmedicationfldadd btn-medium">add a medication</button>
									   </div>



									 </div>
									</div>
								</div>
								<?php


									foreach ($default_med_chiefcom as $key => $value) {
										$default_med_chiefcom[$key] = explode(',', $default_med_chiefcom[$key]);
									}
									//pr($default_med_chiefcom); die;
								?>

							<div class="common_conditions_button chief_complaint_button medicationboxdiv">
								<ul class="quick_pick_chiefcom_medication">

								</ul>
							</div>
			   					<!-- End add medication -->

								<div class="back_next_button">
									<ul>
									 	<li style="float: right;margin-left: auto;">
									  		<button type="submit" class="btn details_next">Next</button>
									 	</li>
									</ul>
			   					</div>
			  				</div>
			 			</div>
		  				<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 			<input type="hidden" name="tab_number" value="33">
			 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ;

}
?>
<?php
// pr($tab_number);
if(in_array(34, $current_steps) && $tab_number == 34){
	$ic = 1;
  echo $this->Form->create(null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

						),'enctype' => 'multipart/form-data', 'id' => 'form_tab_34')); ?>
	<div class="tab-pane fade  <?= ($tab_number == 34  || 34 ==$current_steps[0])  ? '  show active ' : '' ?>" id="psychiatry_follow_up" role="tabpanel" aria-labelledby="psychiatry_follow_up-tab">
		<div class="errorHolder">
  		</div>
		<div class="TitleHead header-sticky-tit">
			<h3>General Details</h3>
			<div class="seprator"></div>
		</div>

		<div class="tab_form_fild_bg">
			<div class="row">
			<?php
			if(!empty($user_detail_old->chief_compliant_userdetail->chief_complaint_psychiatry))

					$old_chief_complaint_psychiatry = $user_detail_old->chief_compliant_userdetail->chief_complaint_psychiatry ;
					// $old_chief_complaint_psychiatry = isset($old_chief_complaint_psychiatry)?$old_chief_complaint_psychiatry:'';
					$old_dqid_val = !empty($old_chief_complaint_psychiatry) ? unserialize(Security::decrypt( base64_decode($old_chief_complaint_psychiatry), SEC_KEY)) :'';
					// pr($psychiatry_question);
					$ic = 1;
					if(!empty($psychiatry_question))
					{$i =1;
						foreach($psychiatry_question as $key => $value)
						{
							// $old_dqid_val = !empty($old_chief_complaint_psychiatry[$value->id]) ? $old_chief_complaint_psychiatry : '';
							 // pr($old_dqid_val);
							if(in_array($value->id,[610,611,612,613,694]))
							continue;
							switch ($value->question_type) {
							case 0:
							?>
							<div class="col-md-12">
							<div class="<?php echo in_array($value->id,[615]) ? "display_none_at_load_time chief_complaint_psychiatry_614_615": ""; ?>">
													<div class="form-group form_fild_row">
														<label>
														<?= $value->question ?>&nbsp;<span class="required">*</span>
														</label>

														<input type="text" value="<?= !empty($old_dqid_val[$value->id]) ? $old_dqid_val[$value->id] :'' ?>" class="form-control chief_complaint_psychiatry_<?= $value->id ?>"  name="chief_complaint_psychiatry[<?= $value->id ?>]" placeholder="<?= $value->placeholder ?>" required="true" id="<?php echo 'question_'.$value->id; ?>"/>


													</div>
								</div>
							</div>
								<?php
								break;
								case 2;
								?>
								<div class="col-md-12">
								<div class="tab-pane fade  <?= ($tab_number==34  || 34==$current_steps[0])  ? '  show active ' : '' ?>" id="chief_complaint_psychiatry_followup" role="tabpanel" aria-labelledby="chief_complaint_psychiatry_followup-tab">
									<div class="TitleHead header-sticky-tit">
										 <h3><?php echo $value->question?><span class="required">*</span><br></h3>
										 <div class="seprator"></div>
									</div>
									<div class="tab_form_fild_bg">
										<!-- <div class="row"> -->
											<!-- <div class="col-md-12 "> -->
												<!-- <div class="form-group form_fild_row new_appoint_checkbox_quest_a">	 -->
											<div class="new_appoint_checkbox_quest">
																		<span></span>
									<?php
									$options = unserialize($value->options) ;
								foreach ($options as $k => $v) {

									 ?>
									<div class="check_box_bg">
										<div class="custom-control custom-checkbox">
											<input class="custom-control-input chief_complaint_psychiatry_<?= $value->id ?> <?= !in_array(
											$k,["None"]) ? "chief_complaint_psychiatry_questions" :""?>" <?= !empty($old_dqid_val) && is_array($old_dqid_val[$value->id]) && in_array($k, $old_dqid_val[$value->id])   ? 'checked' : '' ?>  name="chief_complaint_psychiatry[<?= $value->id ?>][]" value="<?php echo $k ?>" required="true" id="checkbox_question<?= $i ?>"  type="checkbox">
											<label class="custom-control-label" for="checkbox_question<?= $i ?>"><?php echo $v ?></label>
										</div>
									</div>
									<?php $i++; } ?>
								</div>
							</div>
						</div>
					</div>
								<?php
								break;
								case 1:
								?>
								<div class="col-md-12">
								<div class="form-group form_fild_row">

								 <div class="radio_bg">
													<label><?= $value->question ?>

													&nbsp;<span class="required">*</span></label>

								<div class="radio_list">
												<?php
												$options = unserialize($value->options) ;


													foreach ($options as $k => $v) {

														?>
												<div class="form-check">
												 <input type="radio"  value="<?= $v ?>" <?= !empty($old_dqid_val[$value->id]) && $old_dqid_val[$value->id] == $v ? 'checked' : ''  ?>   class="form-check-input chief_complaint_psychiatry_<?= $value->id ?>" required="true" id="radio_question<?= $i ?>" name="chief_complaint_psychiatry[<?= $value->id ?>]"  >
												 <label class="form-check-label" for="radio_question<?= $i ?>"><?= $v ?></label>
											 </div>
														<?php
														$i++ ;
													}
													?>

											</div>
										</div>
									</div>
								</div>
								<?php break;
							default:
								// code...
								break;
						}
					}
		} ?>
							</div>
								<div class="back_next_button">
									<ul>
									 	<li style="float: right;margin-left: auto;">
									  		<button type="submit" class="btn details_next">Next</button>
									 	</li>
									</ul>
			   					</div>
			  				</div>
			 			</div>
		  				<input type="hidden" name="next_steps" value="<?= $next_steps ?>">
			 			<input type="hidden" name="tab_number" value="34">
			 			<input type="hidden" name="step_id" value="<?php echo $step_id ; ?>">
<?php $this->Form->end() ;

}
?>
	<div class="radio_bg">

		</div>
       </div>
      </div>
	  </div>

	 </div>
   	</div>
   </div>
  </div>
 </div>
</div>

<script type="text/javascript">


$(document).ready(function(){
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

// $('select').on('change', function() {
 $(document).on("change","select",function() {
	// alert();
	if($(this).val())
		$(this).css('background','#fff');
	else
		$(this).css('background','#ececec');
  // if($(this).val())
});

// for number validation
 $('[name="last_period_info[flow_duration_in_days]"], [name="last_period_info[cycle_length_in_days]"]').keydown(function (e) {

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

</script>

<style type="text/css">
.new_appointment_box .edit_medical_box .step_head.step_head_deactive .step_tab::before {   width: <?php if($step_id == 1 || $step_id == 17) echo '85%'; else if($step_id == 5 || $step_id == 6 || $step_id == 2 || $step_id == 18 || $step_id == 21) echo '75%';else if($step_id == 7 || $step_id == 19 || $step_id == 25 || $step_id == 26) echo '82%'; else if($step_id == 8 || $step_id == 10 || $step_id == 11 || $step_id == 9 || $step_id == 4 || $step_id == 16) echo '65%'; elseif($step_id == 13 || $step_id == 14 || $step_id == 15) echo '75%'; elseif($step_id == 20 || $step_id == 22) echo '60%'; elseif($step_id == 12){

		if(isset($follow_up_step_id) && $follow_up_step_id == 1){

			echo '80%';
		}
		elseif(isset($follow_up_step_id) && $follow_up_step_id == 9){

			echo '65%';
		}
		elseif(isset($follow_up_step_id) && $follow_up_step_id == 11){

			echo '70%';

		}else{

			echo '55%';
		}

	} else echo '55%'; ?> !important; }


</style>

<?php echo $this->element('front/add_medication_clone'); ?>
<?php echo $this->element('front/chronic_condition_add_medication_clone'); ?>
<?php echo $this->element('front/medication_refill_add_medication_clone'); ?>
<?php echo $this->element('front/bp_reading_clone'); ?>
<?php echo $this->element('front/peak_flow_reading_clone'); ?>

<script type="text/javascript">

$(document).ready(function() {

 $(document).on("click"," .currentmedicationfldadd",function() {

	var cloneob = $( ".clone_purpose_medication_field_display_none" ).clone() ;

$(cloneob).removeClass('clone_purpose_medication_field_display_none').addClass('currentmedicationfld');

$( cloneob ).find('input.med_suggestion').addClass('medicationbox');


	$(cloneob).insertAfter( ".currentmedicationfld:last" );


	});

 $(document).on("click"," .currentmedicationfldadd_chronic_condition",function() {

	var cloneob = $( ".chronic_condition_clone_purpose_medication_field_display_none" ).clone() ;
	$(cloneob).removeClass('chronic_condition_clone_purpose_medication_field_display_none').addClass('currentmedicationfld');
	$( cloneob ).find('input.med_suggestion').addClass('medicationbox');
	$(cloneob).insertAfter( ".currentmedicationfld:last" );

});

$(document).on("click"," .currentmedicationfldadd_medication_refill",function() {

	var cloneob = $( ".clone_purpose_medication_refill_medication_field_display_none" ).clone() ;
	$(cloneob).removeClass('clone_purpose_medication_refill_medication_field_display_none').addClass('currentmedicationfld');
	$( cloneob ).find('input.med_suggestion').addClass('medicationbox');
	$(cloneob).insertAfter( ".currentmedicationfld:last" );

});

$(document).on("click",".currentmedicationfldtimes_med_refill",function() {
 	// alert(ignore_fld);
 	// alert($(".med_suggestion").length);
 	if($(".med_suggestion").length <= 2){
 		$('.ignore_fld').removeClass('ignore_fld'); // remove class if all medical field deleted
 	}
  $(this).parents('.currentmedicationfld').remove();
 });

 $(document).on("click",".currentmedicationfldtimes",function() {
 	//alert('dfdfd');
 	var remove_medication = $(this).parents('.currentmedicationfld').find('.medicationbox').val();
 	//alert(remove_medication);
 	var flag = false;
 	$(this).parents('.currentmedicationfld').remove();

 	$('.medicationbox').each(function(){

 		if(remove_medication == $(this).val()){

 			flag = true;
 		}
 		console.log($(this).val());
 	});

 	if(!flag){

 		$('.medicationboxdiv button').each(function(){

 			var attr = $(this).attr('chief_cmp_attrid_val');
 			if(remove_medication == attr){

 				$(this).removeClass('selected_chief_complaint');
 			}
 		})
 	}
 });

 searchRequest = null;
			$(document).on("keyup click", ".med_suggestion", function () {


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
			                url: "<?php echo SITE_URL; ?>"+"/users/getmedicationsuggestion",
			                data: {
			                	// 'search_type' : 1, // 1 for searching medical  condition
			                    'search_keyword' : value
			                },
			                dataType: "json",
			                success: function(msg){
			                	//var msg = JSON.parse(msg);
			                	var temphtml = '' ;
			                	$.each(msg, function(index, element) {
			                		temphtml += '<li med_suggestion_attr ="'+element.layman_name+'" >'+element.layman_name+'</li>' ;

								});
								$(curele).next('.med_suggestion_listul').html(temphtml);
			                }
			            });

			    });


			$(document).on("click", ".med_suggestion_listul li", function () {
				//event.stopPropagation();
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



$(".medicationbox").select2({
  allowClear:true,
  placeholder: 'Position'
});


$(document).on("click",".currentreadingfldadd",function() {

	console.log('reading');
	var cloneob = $( ".clone_purpose_reading_field_display_none" ).clone() ;
	console.log('cloneob');
	$(cloneob).removeClass('clone_purpose_reading_field_display_none').addClass('currentreadingfld');
	//$( cloneob ).find('input.med_suggestion').addClass('medicationbox');
	$(cloneob).insertAfter( ".currentreadingfld:last" );

});

$(document).on("click",".currentreadingfldtimes",function() {
 	$(this).parents('.currentreadingfld').remove();
 });

});

$('body').on('focus',".glucose_reading_date", function(){
	var date = new Date();
    $(this).datepicker({
    	maxDate: date
    });
});


//show cancer related child question for family members
$(document).on("click", "input[type='checkbox'].cancer_family_members_355", function () {

    var show_question_arr = [];

    $( "input[type='checkbox'].cancer_family_members_355" ).each(function( index, element ) {

        if($(element).is(':checked')){

            var name = $(this).attr('data-name');
            show_question_arr.push(name);
            $('.'+name+"_cancer_detail_section").removeClass('display_none_at_load_time').show();
        }
    });

    <?php

    	foreach ($family_members as $key => $value) {

    		$family_members_class_name = strtolower(str_replace(" ", "", $key)); ?>

    		var family_class_name = "<?php echo $family_members_class_name; ?>";
    		if(show_question_arr.includes(family_class_name) == false){

		        $('.'+family_class_name+"_age_detail").val('');
		        $('.'+family_class_name+"_other_cancer_textbox").val('');
		        $('.'+family_class_name+"_disease_detail").prop("checked", false);
		        $('.'+family_class_name+"_cancer_detail_section").hide();
		    }
    <?php }

     ?>
});

$(document).ready(function () {

    var show_question_arr = [];

    $( "input[type='checkbox'].cancer_family_members_355" ).each(function( index, element ) {

        if($(element).is(':checked')){

            var name = $(this).attr('data-name');
            show_question_arr.push(name);
            $('.'+name+"_cancer_detail_section").removeClass('display_none_at_load_time').show();
        }
    });

    <?php

    	foreach ($family_members as $key => $value) {

    		$family_members_class_name = strtolower(str_replace(" ", "", $key)); ?>

    		var family_class_name = "<?php echo $family_members_class_name; ?>";
    		if(show_question_arr.includes(family_class_name) == false){

		        $('.'+family_class_name+"_age_detail").val('');
		        $('.'+family_class_name+"_other_cancer_textbox").val('');
		        $('.'+family_class_name+"_disease_detail").prop("checked", false);
		        $('.'+family_class_name+"_cancer_detail_section").hide();
		    }
    <?php }

     ?>
});




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

	$(document).on("click", ".medicalhistoryfldtimes button", function() {
	    var remove_medical = $(this).parents('.medicalhistoryfld').find('.medical_suggestion').val();
	    var flag = false;
	    $(this).parents('.medicalhistoryfld').remove();
	    $('.medical_suggestion').each(function() {

	        if (remove_medical == $(this).val()) {

	            flag = true;
	        }
	        console.log($(this).val());
	    });

	    if (!flag) {

	        $('.medicalcondboxdiv button').each(function() {

	            var attr = $(this).attr('condval');
	            if (remove_medical == attr) {

	                $(this).removeClass('selected_chief_complaint');
	            }
	        })
	    }
	});

// ajax search for medical suggestion start


searchRequest = null;
$(document).on("keyup click", ".medical_suggestion", function() {
    value = $(this).val();
    if (value) {
        value = value.split(',');
        value = value[value.length - 1];
    }
    if (searchRequest != null)
        searchRequest.abort();
    var curele = this;
    searchRequest = $.ajax({
        type: "GET",
        url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
        data: {
            'search_type': 1, // 1 for searching medical  condition
            'search_keyword': value
        },
        dataType: "text",
        success: function(msg) {
            // alert(msg);
            var msg = JSON.parse(msg);
            console.log(msg);
            var temphtml = '';
            $.each(msg, function(index, element) {
                temphtml += '<li medical_suggestion_attr ="' + element + '" >' + element + '</li>';

            });
            console.log(temphtml);
            console.log(curele);
            $(curele).next('.medical_suggestion_listul').html(temphtml);

            //we need to check if the value is the same

        }
    });
});




$(document).on("click", ".medical_suggestion_listul li", function() {

    var diag_sugg_atr = $(this).attr('medical_suggestion_attr');

    var tmptext = $(this).parents('.medical_suggestion_listul').prev('.medical_suggestion');
    var ttext = $(tmptext).val();
    if (ttext) {
        if (ttext.charAt(ttext.length - 1) == ',') {
            $(tmptext).val(ttext + ' ' + diag_sugg_atr);
        } else {
            ttext = ttext.substr(0, ttext.lastIndexOf(","));
            if (ttext)
                $(tmptext).val(ttext + ', ' + diag_sugg_atr);
            else
                $(tmptext).val(ttext + ' ' + diag_sugg_atr);

        }
    } else {
        $(tmptext).val(diag_sugg_atr);
    }

    $(this).parents('.medical_suggestion_listul').empty();

});


//  ajax search for medical suggestion  end

});


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
	$(document).on("click", ".surgicalhistoryfldtimes button", function() {

	    if ($(this).parents('.surgicalhistoryfld').find('input.surgicalcondbox').val().trim() == "Uterus removal (hysterectomy)") {
	        $("input[value='0'].is_uterus_removal").prop("checked", true); // if user removes Uterus removal (hysterectomy) then uncheck
	    }
	    var remove_val = $(this).parents('.surgicalhistoryfld').find('input.surgicalcondbox').val().trim();
	    var flag = false;
	    $(this).parents('.surgicalhistoryfld').remove();

	    $('.surgical_suggestion').each(function() {

	        if (remove_val == $(this).val()) {

	            flag = true;
	        }
	        //console.log($(this).val());
	    });

	    if (!flag) {

	        $('.surgicalcondboxdiv button').each(function() {

	            var attr = $(this).attr('condval');
	            if (remove_val == attr) {

	                $(this).removeClass('selected_chief_complaint');
	            }
	        })
	    }

	});



// ajax search for surgery suggestion start


searchRequest = null;
$(document).on("keyup click", ".surgical_suggestion", function() {


    value = $(this).val();
    if (value) {
        value = value.split(',');
        value = value[value.length - 1];
    }

    if (searchRequest != null)
        searchRequest.abort();
    var curele = this;
    searchRequest = $.ajax({
        type: "GET",
        url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
        data: {
            'search_type': 2, // 2 for searching surgical condition
            'search_keyword': value
        },
        dataType: "text",
        success: function(msg) {
            var msg = JSON.parse(msg);
            var temphtml = '';
            $.each(msg, function(index, element) {
                temphtml += '<li surgical_suggestion_attr ="' + element + '" >' + element + '</li>';

            });
            console.log(temphtml);
            console.log(curele);
            $(curele).next('.surgical_suggestion_listul').html(temphtml);

            //we need to check if the value is the same

        }
    });

});


	$(document).on("click", ".surgical_suggestion_listul li", function() {

		    var diag_sugg_atr = $(this).attr('surgical_suggestion_attr');

		    var tmptext = $(this).parents('.surgical_suggestion_listul').prev('.surgical_suggestion');
		    var ttext = $(tmptext).val();

		    if ((ttext.indexOf('Uterus removal (hysterectomy)') != -1) || diag_sugg_atr.trim() == 'Uterus removal (hysterectomy)')
		        $("input[value='1'].is_uterus_removal").prop("checked", true); // check the radio button if user chooses Uterus removal (hysterectomy)
		    if (ttext) {
		        if (ttext.charAt(ttext.length - 1) == ',') {
		            $(tmptext).val(ttext + ' ' + diag_sugg_atr);
		        } else {
		            ttext = ttext.substr(0, ttext.lastIndexOf(","));
		            if (ttext)
		                $(tmptext).val(ttext + ', ' + diag_sugg_atr);
		            else
		                $(tmptext).val(ttext + ' ' + diag_sugg_atr);

		            // $(tmptext).val(ttext+', '+diag_sugg_atr);
		        }
		    } else {
		        $(tmptext).val(diag_sugg_atr);
		    }

		    $(this).parents('.surgical_suggestion_listul').empty();

		});


//  ajax search for surgery suggestion  end
$(document).on("change", "input[type='radio'].is_uterus_removal", function() {

            if ($(this).is(':checked')) {
                // alert($(this).val());
                if ($(this).val() == 0) {
                    $('input.surgicalcondbox').each(function(i, obj) {
                        if ($(obj).val().trim() == "Uterus removal (hysterectomy)") {
                            $(this).parents('.surgicalhistoryfld').remove();
                        }
                    });
                } else {
                    $(".surgicalhistoryfldadd button").trigger("click");

                    $(".surgicalhistoryfld:last").find('input.surgicalcondbox').val("Uterus removal (hysterectomy)");
                }
            }
});
});



$(document).ready(function() {
    // ajax search for allergy start


    searchRequest = null;
    $(document).on("keyup click", ".reaction_suggestion", function() {


        value = $(this).val();
        if (value) {
            value = value.split(',');
            value = value[value.length - 1];
        }

        if (searchRequest != null)
            searchRequest.abort();
        var curele = this;
        searchRequest = $.ajax({
            type: "GET",
            url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
            data: {
                'search_type': 5, // 5 for searching allergy reaction condition
                'search_keyword': value
            },
            dataType: "text",
            success: function(msg) {
                var msg = JSON.parse(msg);
                var temphtml = '';
                $.each(msg, function(index, element) {
                    temphtml += '<li reaction_sugg_attr ="' + element + '" >' + element + '</li>';

                });
                $(curele).next('.reaction_suggestion_listul').html(temphtml);

                //we need to check if the value is the same

            }
        });

    });


    searchRequest = null;
    $(document).on("keyup click", ".allergy_suggestion", function() {


        value = $(this).val();
        if (value) {
            value = value.split(',');
            value = value[value.length - 1];
        }

        if (searchRequest != null)
            searchRequest.abort();
        var curele = this;
        searchRequest = $.ajax({
            type: "GET",
            url: "<?php echo SITE_URL.'users/getsuggestion'; ?>",
            data: {
                'search_type': 3, // 3 for searching allergy  condition
                'search_keyword': value
            },
            dataType: "text",
            success: function(msg) {
                var msg = JSON.parse(msg);
                var temphtml = '';
                $.each(msg, function(index, element) {
                    temphtml += '<li allergy_sugg_attr ="' + element + '" >' + element + '</li>';

                });
                $(curele).next('.allergy_suggestion_listul').html(temphtml);

                //we need to check if the value is the same

            }
        });

    });

    $(document).on("click", ".allergy_suggestion_listul li", function() {

        var diag_sugg_atr = $(this).attr('allergy_sugg_attr');

        var tmptext = $(this).parents('.allergy_suggestion_listul').prev('.allergy_suggestion');
        var ttext = $(tmptext).val();

        if ((ttext.indexOf('Latex') != -1) || diag_sugg_atr.trim() == 'Latex')
            $("input[value='1'].is_latex_allergy").prop("checked", true); // check the radio button if user chooses Latex


        if (ttext) {
            if (ttext.charAt(ttext.length - 1) == ',') {
                $(tmptext).val(ttext + ' ' + diag_sugg_atr);
            } else {
                ttext = ttext.substr(0, ttext.lastIndexOf(","));
                if (ttext)
                    $(tmptext).val(ttext + ', ' + diag_sugg_atr);
                else
                    $(tmptext).val(ttext + ' ' + diag_sugg_atr);

                // $(tmptext).val(ttext+', '+diag_sugg_atr);
            }
        } else {
            $(tmptext).val(diag_sugg_atr);
        }

        $(this).parents('.allergy_suggestion_listul').empty();

    });

    $(document).on("click", ".reaction_suggestion_listul li", function() {

        var diag_sugg_atr = $(this).attr('reaction_sugg_attr');

        var tmptext = $(this).parents('.reaction_suggestion_listul').prev('.reaction_suggestion');
        var ttext = $(tmptext).val();



        if (ttext) {
            if (ttext.charAt(ttext.length - 1) == ',') {
                $(tmptext).val(ttext + ' ' + diag_sugg_atr);
            } else {
                ttext = ttext.substr(0, ttext.lastIndexOf(","));
                if (ttext)
                    $(tmptext).val(ttext + ', ' + diag_sugg_atr);
                else
                    $(tmptext).val(ttext + ' ' + diag_sugg_atr);
                // $(tmptext).val(ttext+', '+diag_sugg_atr);
            }
        } else {
            $(tmptext).val(diag_sugg_atr);
        }

        $(this).parents('.reaction_suggestion_listul').empty();

    });
});



</script>
<!-- For allergic question -->
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

// Nutrition Water

// End Nutriion water

</script>

<script type="text/javascript">

   var medicatoin_arr = [];
   var rxnorm_arr = [];
   <?php foreach ($chief_compliant_medication as $key => $value) { ?>

   // medicatoin_arr['<?php echo   $value->id ?>'] = "<?php echo  $value->layman_name." ( ".$value->doctor_specific_name." ) " ?>";
   medicatoin_arr['<?php echo $value->id ?>'] = "<?php echo $value->layman_name ?>";
   rxnorm_arr['<?php echo $value->id ?>'] = "<?php echo $value->rxnormid ?>";

	<?php } ?>



function add_medicatin_quickpick(chief_cmp_id){


	 var default_med_chiefcom = <?php echo  json_encode($default_med_chiefcom);  ?>;

   	 var temp_str = '';
	 $.each(default_med_chiefcom, function(k, v) {

	   // alert( k + "        " + v + "\n");
	   temp_str = '';
	   if(chief_cmp_id == k){
	     $.each(v, function(k1, v1) {

	     	if(medicatoin_arr[v1] != undefined){

			 	temp_str += '<li class="active"><button type="button" class="btn" chief_cmp_attrid_val="'+medicatoin_arr[v1]+'"  chief_cmp_attrid="'+v1+'" rxnormid_attr="'+rxnorm_arr[v1]+'"> <i class="fas fa-plus-circle"></i>				   <span>'+medicatoin_arr[v1]+'</span> </button> </li>';
	     	}


	     });

 $('.quick_pick_chiefcom_medication').html(temp_str);
	 }
	  });

}

</script>
<!-- <script>
	let loading = async(msg ='') => {
        var homeLoader = $('.dashboard_content').loadingIndicator({
					useImage: false,
				}).data("loadingIndicator");
    }
	// $(function() {
	// 			var homeLoader = $('.dashboard_content').loadingIndicator({
	// 				useImage: false,
	// 			}).data("loadingIndicator");

	// 			setTimeout(function() {
	// 				homeLoader.hide();
	// 			}, 1000);

	// 		});

	// $('body').on('click','.back_next_button', function(e){
	// 	form.submit();
 //        loading();
 //        homeLoader.hide();
	// });

	$("form").submit(function( event ) {
  		loading();
        homeLoader.hide();
  		event.preventDefault();
});
</script> -->
