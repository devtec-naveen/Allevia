<?php include("inner_header.php");?>
	
<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
     <div class="dashboard_menu">
      <ul>
	   <li>
	  <a href="dashboard.php">
	   <i></i>
	   <span>Dashboard</span>
	  </a>
	 </li>
	 
	 <li class="active">
	  <a href="dashboard_new_appointment.php">
	   <i></i>
	   <span>New Appointment</span>
	  </a>
	 </li>
	 
	   <li>
	  <a href="dashboard_previous_appointments.php">
	   <i></i>
	   <span>Previous Appointment</span>
	  </a>
	 </li>
	 
	   <li>
	  <a href="dashboard_edit_medical_history.php">
	   <i></i>
	   <span>Edit Medical History</span>
	  </a>
	 </li>
	  </ul> 
     </div>
    
	 <div class="dashboard_content animated fadeInRight">
	  <div class="dashboard_head">
	   <h2>New Appointment</h2>
	  </div> 
	  
	  <div class="dashboard_appointments_box">
	   <div class="new_appointment_form">
	    <div class="row">
		 <div class="col-md-6">
		  <div class="form-group form_fild_row"> 
	       <input class="form-control" placeholder="Organization Name" type="text"> 
	      </div>
		 </div>
		 
		 <div class="col-md-6">
		  <div class="form-group form_fild_row"> 
	       <select class="form-control">
		    <option>Select Doctor </option>
		   </select>
		  </div>
		 </div>
		</div>
		
		<div class="row">
		 <div class="col-md-6">
		  <div class="form-group form_fild_row"> 
	       <select class="form-control">
		    <option>Select Specialization</option>
		   </select>
		  </div>
		 </div>
		 
		 <div class="col-md-6">
          <div class="form-group form_fild_row"> 
	       <input class="form-control" placeholder="Chief Complaint" type="text"> 
	      </div>
		 </div>
		</div>
		
		<div class="form_submit_button">
	     <button type="button" class="btn waves-effect waves-light">Login</button>
	    </div>
		
	   </div>
	  </div>
	 </div>
   	</div>
   </div>
  </div> 
 </div>
</div>

<?php include("footer.php");?>
	
	