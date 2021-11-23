<?php 
use Cake\Core\Configure;
$session_user = $this->request->getSession()->read('Auth.User');

$apt_id = isset($this->request->params['pass'][0])?$this->request->params['pass'][0]:'';
$next_steps = isset($this->request->params['pass'][1])?$this->request->params['pass'][1]:'';
$step_id = isset($this->request->params['pass'][2])?$this->request->params['pass'][2]:'';
$apt_id_data_schedule_id =  isset($this->request->params['pass'][3])?$this->request->params['pass'][3]:'';
$iframe_prefix = Configure::read('iframe_prefix');
?>
<link href="<?php echo WEBROOT.'frontend/css/new_appointment.css'; ?>" rel="stylesheet" type="text/css">
<script src="<?php echo WEBROOT.'frontend/js/new_appointment.js'; ?>"></script>
<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
    <?php if(empty($iframe_prefix)){ ?>
     <div class="dashboard_menu">
      <ul>
	   
	  

	 <?php if(!empty($session_user) && $session_user['role_id'] == 2){ ?>

<!-- 	 	 <li class="active">
	  <a href="<?= SITE_URL?>users/new-appointment/<?= base64_encode($apt_id_data_schedule_id) ?>">
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
	   <span>Previous Appointments</span>
	  </a>
	 </li>


	  <li>
	  <a href="<?= SITE_URL?>users/medicalhistory">
	   <i></i>
	   <span>Edit Medical History</span>
	  </a>
	 </li> -->

	  <?php } ?>
	  </ul> 
     </div>
    <?php } ?>

     <?php
	  echo $this->Form->create(null , array('autocomplete' => 'off',
							'inputDefaults' => array(
							'label' => false,
							'div' => false,
							),'enctype' => 'multipart/form-data', 'id' => 'verify_insurance'));
	    	?>		    	
	    	<input type="hidden" name="apt_id" value="<?php echo $apt_id ?>"/>
	    	<input type="hidden" name="next_steps" value="<?php echo $next_steps ?>"/>
	    	<input type="hidden" name="step_id" value="<?php echo $step_id?>"/>
	    	<input type="hidden" name="schedule_id" value="<?php echo $apt_id_data_schedule_id ?>"/>

    
    
	 <div class="dashboard_content animated fadeInRight">
	 		  <?= $this->Flash->render() ?>
	  <div class="dashboard_head header-sticky-tit">
	   <h2>Insurance Verification</h2>
	  </div>   

	 
	   <div class="errorHolder"></div>
	  <div class="dashboard_appointments_box">
	   <div class="new_appointment_form">
	    <div class="row">

	    	

	    	<div class="col-md-12">

	    	 <div class="save_info" style="<?php echo !empty($userInfo->insuranceType) ? 'display:block':'display:none'; ?>">

	    	  

	    	   <div class="form-group form_fild_row">
 						<label>Insurance Type : </label>
  						<?php echo !is_null($userInfo->insuranceType) ? ucwords($userInfo->insuranceType): '' ?>
 			   </div>
 			

 			   <?php if(!empty($userInfo->subscriberName)) {?>	
 			   <div class="form-group form_fild_row">
 						<label>Subscriber Name : </label>
  						<?php echo !is_null($userInfo->subscriberName) ? ucwords($userInfo->subscriberName): '' ?>
 			   </div>
 			   <?php }?>

 			   <?php if(!empty($userInfo->identificationNumber)) {?>
 			   <div class="form-group form_fild_row">
 						<label>Identification Number : </label>
  						<?php echo !is_null($userInfo->identificationNumber) ? ucwords($userInfo->identificationNumber): '' ?>
 			   </div>
 			   <?php }?>

 			   <?php if(!empty($userInfo->groupNumber)) {?>
 			   <div class="form-group form_fild_row">
 						<label>Group Number : </label>
  						<?php echo !is_null($userInfo->groupNumber) ? ucwords($userInfo->groupNumber): '' ?>
 			   </div>
 			   <?php }?>


 			   <?php if(!empty($userInfo->insuranceCompany)) {?>
 			   <div class="form-group form_fild_row">
 						<label>Insurance Company : </label>
  						<?php echo !is_null($userInfo->insuranceCompany) ? ucwords($userInfo->insuranceCompany): '' ?>
 			   </div>
 			   <?php }?>

 			   <div class="back_next_button">
					<ul>						
						 <li>
						   <button type="button" value="2" name="next" class="btn details_next" id="editinsurance">Edit</button>
						 </li>
						 <li style="float: right;">
						   <button type="submit" formnovalidate="formnovalidate" value="2" name="next" class="btn details_next">Confirm</button>
						 </li>
					</ul>
			   </div>
			</div>


	<div class="insurance_filled_info" style="<?php echo !empty($userInfo->insuranceType) ? 'display:none':'display:block'; ?>">
       <div class="form-group form_fild_row">
 						<label>Insurance Type <span class="required">*</span></label>
  						<select class="form-control insuranceType" name="insuranceType" id="insuranceType" required="true">
  						   <option value=""></option>									
						   <option <?php echo !is_null($userInfo->insuranceType) &&  $userInfo->insuranceType == 'medicare' ? 'selected' : '' ;  ?> value="medicare">Medicare</option>
						   <option <?php echo !is_null($userInfo->insuranceType) && $userInfo->insuranceType == 'commercial' ? 'selected' : '' ;  ?> value="commercial">Commercial</option>
  						</select>
 					</div>

					<div class="form-group form_fild_row subscribername" style="display: none;">
					<label>Subscriber Name</label><span class="required">*</span>
					<input type="text" value="<?php echo !empty($userInfo['subscriberName']) ? $userInfo['subscriberName']:''?>" class="form-control"  name="subscriberName" placeholder="" required="true" id="subscriberName" />
					</div>

					<div class="form-group form_fild_row identification" style="display: none;">
					<label>Identification Number</label><span class="required">*</span>
					<input type="text" value="<?php echo !empty($userInfo['identificationNumber']) ? $userInfo['identificationNumber']:''?>" class="form-control"  name="identificationNumber" placeholder="" required="true" id="identificationNumber"/>
					</div>

					<div class="form-group form_fild_row groupnumber" style="display: none;">
					<label>Group Number</label><span class="required">*</span>
					<input type="text" value="<?php echo !empty($userInfo['groupNumber']) ? $userInfo['groupNumber']:''?>" class="form-control"  name="groupNumber" placeholder="" required="true" id="groupNumber"/>
					</div>

					<div class="form-group form_fild_row insurancecompany" style="display: none;">
					<label>Insurance Company</label><span class="required">*</span>
					<input type="text" value="<?php echo !empty($userInfo['insuranceCompany']) ? $userInfo['insuranceCompany']:''?>" class="form-control"  name="insuranceCompany" placeholder="" required="true" id="insuranceCompany"/>
					</div>

					<div class="back_next_button">
					<ul>
						 <li style="float: right;margin-left: auto;">
						   <button id="profile-tab-backbtn" type="submit" value="1" name="verify" class="btn">Save and continue</button>
					     </li>						
					</ul>
			</div> 
</div>	

			</div>
		 </div>		
	   </div>
	   </div>	 
	</div>
	 <?php $this->Form->end() ;?>
   	</div>
   </div>
  </div> 
 </div>
</div>



 <script type="text/javascript">
     

           var insuranceType = '<?php echo !empty($userInfo->insuranceType) ? $userInfo->insuranceType: ""; ?>';
           if(insuranceType == 'commercial')
            {
                  $(".subscribername").show();
	              $(".identification").show();
	              $(".groupnumber").show();
	              $(".insurancecompany").show();
            }  
            else if(insuranceType == 'medicare' )
            {
	              $(".subscribername").hide();
	              $(".identification").hide();
	              $(".groupnumber").hide();
	              $(".insurancecompany").hide();
	              $("#subscriberName").val('');
	              $("#identificationNumber").val('');
	              $("#groupNumber").val('');
	              $("#insuranceCompany").val('');
            }  
      

      $("#insuranceType").on('change',function(){

          var insuranceType =  $(this).val();
          if(insuranceType == 'commercial')
          {
              $(".subscribername").show();
              $(".identification").show();
              $(".groupnumber").show();
              $(".insurancecompany").show();
          }  
          else if(insuranceType == 'medicare')
          {
              $(".subscribername").hide();
              $(".identification").hide();
              $(".groupnumber").hide();
              $(".insurancecompany").hide();
              $("#subscriberName").val('');
              $("#identificationNumber").val('');
              $("#groupNumber").val('');
              $("#insuranceCompany").val('');
          }  
      })

      $("#editinsurance").on('click', function(){

      	$(".insurance_filled_info").show();
      	$(".save_info").hide();


      })

    </script>