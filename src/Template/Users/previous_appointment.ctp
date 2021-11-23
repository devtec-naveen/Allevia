	
<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
     <div class="dashboard_menu ">
      <ul>
      	
	<!-- 	  <li>
	  <a href="<?= SITE_URL?>users/scheduled-appointments">
	   <i></i>
	   <span  id="prev_apt_chnge" >Scheduled Appointments</span>
	  </a>
	 </li>

	 	
	 
	   <li  class="active">
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
	  </ul> 
     </div>
    
<div class="dashboard_content  pevious_appointments animated fadeInRight">
	  <div class="dashboard_head">
	   <h2>Previous Appointments</h2>
	  </div> 
	  
	  <div class="dashboard_appointments_box">
	   <div class="appointments_bottom">
	    <div class="appointment_table_box">
		 <table>
		  <thead>
		   <tr>
		    <th>Doctor</th>
			<th>Clinic</th>
			<!-- <th>Date & Time</th> -->
			<th>Specialty</th>
			<th>Reason for visit</th>
			<th>Chief Complaint</th>
			<!-- <th>Duration</th> -->
			<th>Summary</th>
		   </tr>
		  </thead>
		  
		  <tbody>
		  <?php 
		  if(!empty($tot_appoint)){
		  		foreach($tot_appoint as $singlelevel){
		  			// if(empty($singlelevel->chief_complain_name)) continue; 
		  			?>

		   <tr>
		    <td><?= $singlelevel->doctor->doctor_name ?></td>
			<td><?= $singlelevel->organization->organization_name ?></td>
	<?php /*		<td><?= isset($singlelevel->appointment_date) ? $singlelevel->appointment_date->format('d/m/Y h:i A') : ''  ?></td> */ ?>
			<td><?= $singlelevel->specialization->name ?></td>
			<td><?= !empty($singlelevel->current_step_id->step_name) ?  $singlelevel->current_step_id->step_name : '--' ?></td>
			<td><?= !empty($singlelevel->chief_complain_name) ?  $singlelevel->chief_complain_name : '--' ?></td>
		<?php /*	<td><?= !empty($singlelevel->chief_complain_length) ? $singlelevel->chief_complain_length : '--' ?></td> */ ?>
		<td><button type="button" dataattr_aptid = "<?php echo base64_encode($singlelevel->id) ?>" class="btn btn-info btn-lg summary_show" data-toggle="modal" data-target="#myModal">Show</button></td>
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


				    	console.log(data);
						 	
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
  