	
<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
     <div class="dashboard_menu ">
      <ul>

<!-- 	   <li class="active">
	  <a href="<?= SITE_URL ?>users/dashboard">
	   <i></i>
	   <span id="dash_chnge">Dashboard</span>
	  </a>
	 </li>
	 
	   <li>
	  <a href="<?= SITE_URL?>users/new-appointment">
	   <i></i>
	   <span id="new_apt_chnge">Pre-appointment questionnaire</span>
	  </a>
	 </li>
	 
	   <li>
	  <a href="<?= SITE_URL?>users/previous-appointment">
	   <i></i>
	   <span id="prev_apt_chnge">Previous Appointments</span>
	  </a>
	 </li>
	 
	   <li>
	  <a href="<?= SITE_URL?>users/edit-medical-history">
	   <i></i>
	   <span id="med_his_chnge">Edit Medical History</span>
	  </a>
	 </li> -->
	  </ul> 
     </div>
    
	 <div class="dashboard_content animated fadeInRight ">
	 		 	  <?= $this->Flash->render() ?>
	  <div class="dashboard_head">
	   <h2>Dashboard</h2>
	  </div> 
	  
	  <div class="dashboard_appointments_box">
	   
	   <div class="row appointments_top">
	    <div class="col-md-4">
		 <div class="appointments_box">
		  <div class="appointments_box_top">
		   <div class="appointments_left">

		    <h4><?= $tot_appoint ?></h4>   
			<span>Appointments </span>
		   </div>  
		   <div class="appointments_progress">
		   	<div class="circle" id="circles-1"></div>
		    <!-- <img src="images/appointments_prog1.png"/>  -->
		   </div>
		  </div> 
		 
		  <div class="appointments_button">
		   <a href="javascript:;" class="waves-effect waves-light">Total Appointments </a>
		  </div>
		 </div>
		</div> 
		
		<div class="col-md-4">
		 <div class="appointments_box">
		  <div class="appointments_box_top">
		   <div class="appointments_left">
		    <h4><?= $completed_appoint ?></h4>   
			<span>Appointments </span>
		   </div>  
		   <div class="appointments_progress">
		    <!-- <img src="images/appointments_prog2.png"/>  -->
		    <div class="circle" id="circles-2"></div>
		   </div>
		  </div> 
		 
		  <div class="appointments_button">
		   <a href="javascript:;" class="waves-effect waves-light">Completed Appointments</a>
		  </div>
		 </div>
		</div>
	   
        <div class="col-md-4">
		 <div class="appointments_box">
		  <div class="appointments_box_top">
		   <div class="appointments_left">
		    <h4><?= $pending_appoint ?></h4>   
			<span>Appointments </span>
		   </div>  
		   <div class="appointments_progress">
		    <!-- <img src="images/appointments_prog3.png"/>  -->
		    <div class="circle" id="circles-3"></div>
		   </div>
		  </div> 
		 
		  <div class="appointments_button">
		   <a href="javascript:;" class="waves-effect waves-light">Upcoming Appointments</a>
		  </div>
		 </div>
		</div>
	   </div>
	  
	   <div class="appointments_bottom">
	    <h2>Appointments</h2>
	    <div class="appointment_table_box">
		 <table>
		  <thead>
		   <tr>
		    <th>Doctor</th>
			<th>Specialty </th>
			<!-- <th>Date & Time</th>			 -->
			<th>Status</th>
		   </tr>
		  </thead>
		  
		  <tbody>
		 	<?php 

		 	foreach($appont_data as $levelone) {
		 		?>
		  <tr>
<!--	   <td>
		     <div class="appointment_user">
			 <a href="javascript:;"><img src="<?php // echo  SITE_URL.'images/'.$levelone->doctor->image ?>"/></a>
			</div> 
		   </td> -->
		   <td><span><?= isset($levelone->doctor->doctor_name) ? $levelone->doctor->doctor_name : '' ?></span></td>
		   <td><?= isset($levelone->specialization->name) ? $levelone->specialization->name : '' ?></td>
	<!-- 	   <td><?php //echo  isset($levelone->appointment_date) ? $levelone->appointment_date->format('d/m/Y h:i A') : ''  ?></td>	 -->	   
		   <td>
		    <div class="completed_button">
			<a href="javascript:;" class="btn"><?php echo $levelone->status == 0 ? 'Pending' : 'Completed' ?></a>
			</div>
		   </td>
		  </tr>

		 		<?php

		 	}


		 	?>
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





<script type="text/javascript" src="<?php echo WEBROOT ?>js/circles.min.js"></script>   
<script type="text/javascript">
	var total = "<?= !empty($tot_appoint) ? $tot_appoint : 0 ?>";
	var compapp =  "<?= !empty($completed_appoint) ? $completed_appoint : 0 ?>";
	var penapp =  "<?= !empty($pending_appoint) ? $pending_appoint : 0 ?>";
	total = parseInt(total) ; compapp = parseInt(compapp) ; penapp = parseInt(penapp) ; 

  if (isNaN(total)) { total =  0 ; }
  if (isNaN(compapp)) { compapp =  0 ; }
  if (isNaN(penapp)) { penapp =  0 ; }


var myCircle = Circles.create({
  id:                  'circles-1',
  radius:              40,
  value:               total,
  maxValue:            total,
  width:               4,
  text:                function(value){return value ;},
  colors:              ['#f2f2f2', '#00ffcc'],
  duration:            400,
  wrpClass:            'circles-wrp',
  textClass:           'circles-text',
  valueStrokeClass:    'circles-valueStroke',
  maxValueStrokeClass: 'circles-maxValueStroke',
  styleWrapper:        true,
  styleText:           true
});

var myCircle1 = Circles.create({
  id:                  'circles-2',
  radius:              40,
  value:               compapp,
  maxValue:            total,
  width:               4,
  text:                function(value){return value ;},
  colors:              ['#f2f2f2', '#ff6633'],
  duration:            400,
  wrpClass:            'circles-wrp',
  textClass:           'circles-text',
  valueStrokeClass:    'circles-valueStroke',
  maxValueStrokeClass: 'circles-maxValueStroke',
  styleWrapper:        true,
  styleText:           true
});
var myCircle2 = Circles.create({
  id:                  'circles-3',
  radius:              40,
  value:               penapp,
  maxValue:            total,
  width:               4,
  text:                function(value){return value ;},
  colors:              ['#f2f2f2', '#ff0066'],
  duration:            400,
  wrpClass:            'circles-wrp',
  textClass:           'circles-text',
  valueStrokeClass:    'circles-valueStroke',
  maxValueStrokeClass: 'circles-maxValueStroke',
  styleWrapper:        true,
  styleText:           true
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