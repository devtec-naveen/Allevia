<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
     <div class="dashboard_menu ">
      <ul>

	 <?php $login_user = $this->request->getSession()->read('Auth.User');
	 	

	if(!empty($login_user) && $login_user['role_id'] == 2){ ?>

<!-- 	 	<li >
	  <a href="<?= SITE_URL?>users/scheduled-appointments">
	   <i></i>
	   <span  id="prev_apt_chnge" >Scheduled Appointments</span>
	  </a>
	 </li>

	 <li class="active">
 		<a href="<?= SITE_URL?>users/all-signed-docs">
	   		<i></i>
	   		<span  id="prev_apt_chnge" >Signed Documents</span>
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
    
<div class="dashboard_content  pevious_appointments animated fadeInRight">
	  <div class="dashboard_head">
	   <h2>Patient Signed Documents</h2>
	  </div> 
	  
	  <div class="dashboard_appointments_box">
	  	
	   <div class="appointments_bottom">
	    <div class="appointment_table_box">
		 <table>
		  <thead>
		   <tr>
			<th>Clinic</th>
			<th>Patient Type</th>
			<th>Date</th>
			<th>Privacy Policy Document</th>
			<th class="text-right">Treatment Consent Document</th>

		   </tr>
		  </thead>
		  
		  <tbody>
		  <?php 

		//  pr($schedule_data);
		  if(!empty($doc_data)){
		  		foreach($doc_data as $singlelevel){
		  			?>

		   <tr>
			<td><?= $singlelevel->organization->organization_name ?></td>
			<td>
				<?php if($singlelevel['patient_type'] == 1){

					echo 'New Patient';
				}
				elseif($singlelevel['patient_type'] == 2){

					echo 'Existing Patient';
				}
				else{

					echo '-';
				}
				 ?>

			</td>
			<td><?php echo date('F d, Y',strtotime($singlelevel['created'])); ?></td>
			<td>
				<?php if(!empty($singlelevel['privacy_policy_docs'])){ ?>				
					<a href="<?php echo WEBROOT.'uploads/user_signed_docs/'.$singlelevel['privacy_policy_docs']; ?>" class="btn btn-info btn-lg" target="_blank">Privacy Policy Doc</a>
				<?php }
						else{

							echo '-';
						}
				 ?>
			</td>
			
		<td class="text-right">
			<?php if(!empty($singlelevel['treatment_docs'])){ ?>
				<a href="<?php echo WEBROOT.'uploads/user_signed_docs/'.$singlelevel['treatment_docs']; ?>" class="btn btn-info btn-lg" target="_blank">Treatment Consent Doc</a></td>
			<?php }
					else{

							echo '-';
						}
			 ?>
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
  