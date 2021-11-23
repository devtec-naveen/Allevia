<?php 

/*$iframe_api_data = null;
$session = $this->request->getSession();
if ($session->check('iframe_api_data')) {

    $iframe_api_data  = $session->read('iframe_api_data');
}*/

use Cake\Core\Configure; 
$iframe_prefix = Configure::read('iframe_prefix');
?>
<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
    <?php if(empty($iframe_prefix)){ ?>
     <div class="dashboard_menu ">
      <ul>

	 <?php $login_user = $this->request->getSession()->read('Auth.User');

	if(!empty($login_user) && $login_user['role_id'] == 2){ ?>

		<!-- <li class="active">
		<a href="<?= SITE_URL?>users/scheduled-appointments">
		<i></i>
		<span  id="prev_apt_chnge" >Scheduled Appointments</span>
		</a>
		</li>

		<li>
		<a href="<?= SITE_URL?>users/previous-appointment">
		<i></i>
		<span  id="prev_apt_chnge" >Previous Appointments</span>
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
    
<div class="dashboard_content  pevious_appointments animated fadeInRight">
	<?= $this->Flash->render() ?>
	  <div class="dashboard_head">
	   <h2>Scheduled Appointments</h2>
	  </div> 
	  
	  <div class="dashboard_appointments_box">
	  	<div>
	  		<p>Click on the pre-appointment questionnaire for your upcoming appointment!</p>
	  	</div>
	   <div class="appointments_bottom">
	    <div class="appointment_table_box">
		 <table>
		  <thead>
		   <tr>
			<th>Clinic</th>
			<th>Doctor</th>
			<th class="text-right">Action</th>
		   </tr>
		  </thead>
		  
		  <tbody>
		  <?php 

		//  pr($schedule_data);
		  if(!empty($schedule_data)){
		  		foreach($schedule_data as $singlelevel){
		  			?>

		   <tr>
			<td><?= $singlelevel->organization->organization_name ?></td>
			<td>
				
				<?php if(isset($singlelevel['doctor']) && !empty($singlelevel['doctor']))
				{ 
					echo $singlelevel['doctor']['doctor_name'];
				}
				elseif(!empty($singlelevel['doctor_name'])){

					echo $this->CryptoSecurity->decrypt(base64_decode($singlelevel['doctor_name']),SEC_KEY) ;
				}
				else{

					echo '-';
				}
				?>

			</td>
			<?php $schedule_slug = $singlelevel['id'].'-'.time(); ?>
		<td class="text-right"><a href="<?php echo SITE_URL.(!empty($iframe_prefix) ? $iframe_prefix.'/' : '').'users/new-appointment/'.base64_encode($schedule_slug); ?>" class="btn btn-info btn-lg">Pre-appointment questionnaire</a></td>
		   </tr> 

		  <?php
		  		}
		  	} else {

		  ?>
		  	<tr><td colspan="6">No Record Found!</td></tr>
		<?php } ?>

	      </tbody>
		 </table>
		</div>	
	   </div>
	  </div>
	 </div>	 
   	
   
   
   
    </div>
   </div>
  </div> 
 </div>
</div>


<script>
$(document).ready(function(){
	var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(".summary_show").click(function(){
    	var aptid = $(this).attr('dataattr_aptid');
        $.post({
				  method: "POST",
				  url: "show-appoint",
				  data: { aptid: aptid },
				   headers: {
				        'X-CSRF-Token': csrfToken
				    },
				    success:  function( data ) {
						 	
				    	$('.modal-body').html(data);
				        

						}
				} ); 



    });
});



$(document).ready(function(){

	// alert($(window).width()) ;
	// console.log($(window).width()) ;
	// dashboard, appointment, summaries, medical history
	if($(window).width() < 700){
		      
		$("#dash_chnge").html('dashboard');
		$("#new_apt_chnge").html('appointment');
		$("#prev_apt_chnge").html('summaries');
		$("#med_his_chnge").html('medical history');

	}

}); 


</script>


 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Appointment Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  