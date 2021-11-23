<?php 
use Cake\Core\Configure;
$session_user = $this->request->getSession()->read('Auth.User');
$iframe_prefix = Configure::read('iframe_prefix');
	//pr($selected_step);die; 
?>
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
	  <a href="">
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
    
	 <div class="dashboard_content animated fadeInRight">
	 		  <?= $this->Flash->render() ?>
	  <div class="dashboard_head">
	   <h2>Sign Ancillary Documents</h2>
	  </div>

	  

	  <?php echo $this->Form->create( null , array(   'autocomplete' => 'off', 
										
							'inputDefaults' => array(
							'label' => false,
							'div' => false,
											
							),'enctype' => 'multipart/form-data', 'id' => 'doc_sign')); 

	  						//pr($user_sign_data);
							?>

				<div class="errorHolder">
  				</div>
	 	<div class="row">			  											
			<div class="col-md-12">
				<div class="form-group form_fild_row">
					<div class="radio_bg">
						<label>Are you a new patient at this clinic?<span class="required">*</span></label>
						<div class="radio_list">
							
							<div class="form-check">
								<input type="radio"  value="1"  class="form-check-input patient_type" id="radio_question_1" name="new_patient"  required="true" <?php echo !empty($user_sign_data) && $user_sign_data['patient_type'] == 1 ? 'checked' : ""; ?>>
									<label class="form-check-label" for="radio_question_1">Yes</label>
							</div>

							<div class="form-check">
								<input type="radio"  value="2"  class="form-check-input patient_type" id="radio_question_0" name="new_patient"  required="true" <?php echo !empty($user_sign_data) && $user_sign_data['patient_type'] == 2 ? 'checked' : ""; ?>>
									<label class="form-check-label" for="radio_question_0">No</label>
							</div>
						
						</div>
					</div>
				</div>
				
			</div>
		</div>
	<div class="back_next_button">
		<ul style="display: initial;">
			<!-- <li>												
			
				<button id="allergies-tab-backbtn" type="button" class="btn">Previous tab</button>
			</li> -->			 
		 	<li style="float: right;">
		  		<!-- <button type="button" class="btn save_doc_data">Next</button> -->
		  		<button type="submit" class="btn">Next</button>
		 	</li>
		</ul>
	</div>
	<?php $this->Form->end(); ?>
	</div>	 	
</div>
		
		
	   </div>
	  </div>

	  <?php //$this->Form->end(); ?>

	 </div>
   	</div>
   </div>
  </div> 
 </div>
</div>
<style type="text/css">
	
	.dashboard_appointments_box { text-align: center; }
</style>

<script type="text/javascript">
	
	$(document).ready(function(){

		
	    if ($('.patient_type:checked').val() == '1') {
	    	//$('.question_13_14').val('');
	        
	        $('.patient_doc_section').removeClass('display_none_at_load_time').show();
	    }else{	    	
	       
	        $('.patient_doc_section').hide();
	    }
	    

	});

	$(document).on("click", "input[type='radio'].patient_type", function () {	
    if($(this).is(':checked')) {
    	 
        if ($(this).val() == '2') {
        	//$('.question_13_14').val('');
            $('.patient_doc_section').hide();
        }else{
        	$('.patient_doc_section').removeClass('display_none_at_load_time').show();
           
            
        }
    }
});

	$('.save_doc_data').on('click',function(e){

		//alert('dfdsa');
		if ($('.patient_type:checked').val() == '1') {

			if($('#treatment_docs').length && $('#treatment_docs').val() == ''){

				$("#doc_sign div.errorHolder").addClass(' alert alert-danger').html("Please sign the treatment consent document.");
			}
			else if($('#privacy_policy_docs').length && $('#privacy_policy_docs').val() == ''){

				$("#doc_sign div.errorHolder").addClass(' alert alert-danger').html("Please sign the privacy policy document.");
			}
			else{

				$('#doc_sign').submit();	
			}
		}
		else{

			$('#doc_sign').submit();
		}
	})

	$("#doc_sign").validate({
        // Use this one to place the error
 		//ignore: ".ignore_fld",
 		ignore: ':hidden:not(.do_not_ignore)',

   // errorLabelContainer: $("#form_tab_2 div.errorHolder")

  showErrors: function(errorMap, errorList) {
  		
	  	if(errorList.length>0){
	  		
	       	$("#doc_sign div.errorHolder").addClass(' alert alert-danger').html("*All fields must be completed before you submit the form.");
	    }
    }

 });
</script>