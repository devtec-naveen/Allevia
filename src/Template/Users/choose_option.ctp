<?php 
use Cake\Core\Configure;
$session_user = $this->request->getSession()->read('Auth.User');

/*$iframe_api_data = null;
$session = $this->request->getSession();
if ($session->check('iframe_api_data')) {

    $iframe_api_data  = $session->read('iframe_api_data');
}*/
$iframe_prefix = Configure::read('iframe_prefix');
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

	<!--  	 <li class="active">
	  <a href="<?= SITE_URL?>users/new-appointment/<?= base64_encode($schedule_id) ?>">
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
	   <h2>Choose Visit Reason</h2>
	  </div>   	

	  <div class="dashboard_appointments_box">
	   <div class="new_appointment_form">
	    <div class="row">

	    	<?php

	    	//pr($step_detail); 
	    	foreach ($step_detail as $key => $value) {

	    		if($value->id == 16 || $value->id == 6 || $value->id == 8 || $value->id == 27 || $value->id == 28){

	    			continue;
	    		}
?>
 



<?php 		$spc_id = base64_decode($specialization_id);
			if(($spc_id == 1 || $spc_id == 3 || $spc_id == 4 || $spc_id == 7 || $spc_id == 9) && ($value->id == 1 || $value->id == 7 || $value->id == 26 || $value->id == 25)){ ?>

				<div class="col-md-3 dropdown">
					<a href="#" title="<?php echo $value->step_name ; ?>" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="<?php echo WEBROOT.'img/'.$value->step_image; ?>">
						<div class="alert alert-info appointment_box_button"><?php echo ucfirst($value->step_name); ?></div>
					</a>
						<ul class="dropdown-menu">
						    <!-- <a class="dropdown-item" href="#">New Visit</a> -->

						   	<li> <?php

						    	echo $this->Form->postLink(
									"New Visit" , // first
								    ['action' => 'chooseOption','prefix' => $iframe_prefix, $apt_id, $specialization_id ],  // second
								    ['escape' => false, 'title' => $value->step_name , 'class' => '', 'method' =>'post', 'data' => array('apt_id' => $apt_id , 'specialization_id' => $specialization_id , 'next_steps' => $value->next_steps, 'step_id' => $value->id )] // third
								);
						     ?>
							</li>

							<?php if(isset($step_detail[6])){ ?>
								<li> <?php

							    	echo $this->Form->postLink(
										"Follow-Up Visit" , // first
									    ['action' => 'chooseOption','prefix' => $iframe_prefix, $apt_id, $specialization_id ],  // second
									    ['escape' => false, 'title' => $step_detail[6]->step_name , 'class' => '', 'method' =>'post', 'data' => array('apt_id' => $apt_id , 'specialization_id' => $specialization_id , 'next_steps' => $step_detail[6]->next_steps, 'step_id' => $step_detail[6]->id )] // third
									);
							     ?>
								</li>
							<?php }?>

							<?php if(isset($step_detail[8])){ ?>
								<li> <?php

							    	echo $this->Form->postLink(
										"Follow-Up Visit" , // first
									    ['action' => 'chooseOption','prefix' => $iframe_prefix, $apt_id, $specialization_id ],  // second
									    ['escape' => false, 'title' => $step_detail[8]->step_name , 'class' => '', 'method' =>'post', 'data' => array('apt_id' => $apt_id , 'specialization_id' => $specialization_id , 'next_steps' => $step_detail[8]->next_steps, 'step_id' => $step_detail[8]->id )] // third
									);
							     ?>
								</li>
							<?php }?>

							<?php if(isset($step_detail[16]) && $value->id == 1){ ?>
								<li> <?php

							    	echo $this->Form->postLink(
										"Follow-Up Visit" , // first
									    ['action' => 'chooseOption','prefix' => $iframe_prefix, $apt_id, $specialization_id ],  // second
									    ['escape' => false, 'title' => $step_detail[16]->step_name , 'class' => '', 'method' =>'post', 'data' => array('apt_id' => $apt_id , 'specialization_id' => $specialization_id , 'next_steps' => $step_detail[16]->next_steps, 'step_id' => $step_detail[16]->id )] // third
									);
							     ?>
								</li>
							<?php }?>
							<?php if(isset($step_detail[27]) && $value->id == 26){ ?>
								<li> <?php

							    	echo $this->Form->postLink(
										"Follow-Up Visit" , // first
									    ['action' => 'chooseOption','prefix' => $iframe_prefix, $apt_id, $specialization_id ],  // second
									    ['escape' => false, 'title' => $step_detail[27]->step_name , 'class' => '', 'method' =>'post', 'data' => array('apt_id' => $apt_id , 'specialization_id' => $specialization_id , 'next_steps' => $step_detail[27]->next_steps, 'step_id' => $step_detail[27]->id )] // third
									);
							     ?>
								</li>
							<?php }?>
							<?php if(isset($step_detail[28]) && $value->id == 25){ ?>
								<li> <?php

							    	echo $this->Form->postLink(
										"Follow-Up Visit" , // first
									    ['action' => 'chooseOption','prefix' => $iframe_prefix, $apt_id, $specialization_id ],  // second
									    ['escape' => false, 'title' => $step_detail[28]->step_name , 'class' => '', 'method' =>'post', 'data' => array('apt_id' => $apt_id , 'specialization_id' => $specialization_id , 'next_steps' => $step_detail[28]->next_steps, 'step_id' => $step_detail[28]->id )] // third
									);
							     ?>
								</li>
							<?php }?>

						</ul>
					
				</div>

				<!-- <a href="javascript:;" title="<?php echo $value->step_name ; ?>" class="showpopup"><img src="<?php echo WEBROOT.'img/'.$value->step_image; ?>"><div class="alert alert-info"><?php echo ucfirst($value->step_name); ?></div></a> -->

			<?php }
			else{ ?>
				
				<div class="col-md-3">
					<?php 
						echo $this->Form->postLink(
							"<img src='".WEBROOT."img/".$value->step_image."'><div class='alert alert-info appointment_box_button'>".ucfirst($value->step_name)."</div>" , // first
						    ['action' => 'chooseOption','prefix' => $iframe_prefix, $apt_id, $specialization_id ],  // second
						    ['escape' => false, 'title' => $value->step_name , 'class' => '', 'method' =>'post', 'data' => array('apt_id' => $apt_id , 'specialization_id' => $specialization_id , 'next_steps' => $value->next_steps, 'step_id' => $value->id )] // third
						); ?>
				</div>
		<?php }
			?>

			<?php 

	    	}
	    	?>
		 </div>
		
	   </div>
	  </div>
	 </div>
   	</div>
   </div>
  </div> 
 </div>
</div>
<style type="text/css">	
	.dashboard_appointments_box { text-align: center; }
</style>

<div class="modal fade delivery-modal" id="basicExampleAddNewGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
         	<center>
         	<div>                     
            	<a href="javascript:;">test1</a>
            </div>
            <hr>
            <div>                     
            	<a href="javascript:;">test2</a>
            </div>
            </center>
          
         </div>
        
      </div>
   </div>
</div>
<script type="text/javascript">
	$(document).on('click','.showpopup',function(){

		$('#basicExampleAddNewGroup').modal('show');

	})
</script>