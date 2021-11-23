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
	  <div class="new_appointment_box">
	   <div class="dashboard_head">
	   <h2>New Appointment</h2>
	  </div> 
	  
	   <div class="edit_medical_box">
	   <div class="step_head">
	    <div class="step_tab">
	  <ul class="nav nav-tabs" id="myTab" role="tablist">
	   <li class="nav-item active">
	    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
		 <div class="step_number">
		  <i>1</i>
		 </div>
		 <span>Basic Information</span>
		</a>
	   </li>
	   
	   <li class="nav-item">
	    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
		 <div class="step_number">
		  <i>2</i>
		 </div>
		 <span>Medical History</span>
		</a>
	   </li>
	   
	   <li class="nav-item">
	    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
		 <div class="step_number">
		  <i>3</i>
		 </div>
		 <span>Surgical History</span>
		</a>
	   </li>
	   
	   <li class="nav-item">
	    <a class="nav-link" id="family-tab" data-toggle="tab" href="#family" role="tab" aria-controls="family" aria-selected="false">
		 <div class="step_number">
		  <i>4</i>
		 </div>
		 <span>Family History</span>
		</a>
	   </li>
	   
	   <li class="nav-item">
	    <a class="nav-link" id="allergies-tab" data-toggle="tab" href="#allergies" role="tab" aria-controls="allergies" aria-selected="false">
		 <div class="step_number">
		  <i>5</i>
		 </div>
		 <span>Allergies</span>
		</a>
	   </li>

	  </ul>  
	 </div>
	   </div> 
	   
	   <div class="tab-content" id="myTabContent">
	    <div class="tab_content_inner">
	 
		  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
		    <div class="TitleHead">
			 <h3>Chief complaint</h3>
			</div>
			  
		    <div class="tab_form_fild_bg">
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Chief complaint"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-3">
				   <div class="crose_year">
					<button class="btn"><i class="fas fa-times"></i></button>
				   </div>
				  </div>
				  
				  <div class="col-md-9">
				   <div class="form-group form_fild_row"> 
					<select class="form-control">
					 <option>Length</option>
					</select>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Chief complaint"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn">add symptom</button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="common_conditions_button chief_complaint_button">
				<ul>
				 <li class="active">
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Cats</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Contrast</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Eggs</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Fish</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Peanuts</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Shellfish</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Soaps</span>
				  </button> 
				 </li>
				</ul>
			   </div>
			   
			   <div class="row">
			    <div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Chief complaint"/> 
				 </div>
				</div>
				
				<div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Dose"/> 
				 </div>
				</div>
				
				<div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="How aften?"/> 
				 </div>
				</div>
			   </div> 
			   
			   <div class="row">
			    <div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="How is it teken?"/> 
				 </div>
				</div>
				
				<div class="col-md-4">
                 <div class="crose_year">
				  <button class="btn waves-effect waves-light"><i class="fas fa-times"></i></button>
				 </div>
				</div>
	           </div> 
			   
			   <div class="add_medication_row">
			    <div class="row">
			    <div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Chief complaint"/> 
				 </div>
				</div>
				
				<div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Dose"/> 
				 </div>
				</div>
				
				<div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="How aften?"/> 
				 </div>
				</div>
			   </div> 
			   
			    <div class="row">
			    <div class="col-md-4">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="How is it teken?"/> 
				 </div>
				</div>
				
				<div class="col-md-4">
                 <div class="crose_year">
				  <button class="btn waves-effect waves-light">add medication</button>
				 </div>
				</div>
	           </div> 
			   </div>
			   
			   <div class="back_next_button">
				<ul>
				 <li>
				  <button type="button" class="btn">Next</button>
				 </li>
				</ul>
			   </div>
			  </div>
		  </div>
			 
		  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			   <div class="TitleHead">
			   <h3>Medical History</h3>
			   <div class="seprator"></div>
			  </div>
			  
			  <div class="tab_form_fild_bg">
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Mononucleosis"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				   <div class="form-group form_fild_row"> 
					<select class="form-control">
					 <option>Year</option>
					</select>
				   </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn"><i class="fas fa-times"></i></button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Mononucleosis"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				   <div class="form-group form_fild_row"> 
					<select class="form-control">
					 <option>Year</option>
					</select>
				   </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn">add diagnosis</button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="back_next_button">
				<ul>
				 <li>
				  <button type="button" class="btn">Back</button>
				 </li>
				 <li>
				  <button type="button" class="btn">Next</button>
				 </li>
				</ul>
			   </div>
			   
			   <div class="common_conditions_button">
				<h4>Common conditions</h4>
				<ul>
				 <li class="active">
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Asthma</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Chicken Pox</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Diabetes</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Heart Disease</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>High Cholesterol</span>
				  </button> 
				 </li>
				</ul>
			   </div>
			  </div>
			 </div>
			
		  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
			  <div class="TitleHead">
			   <h3>Surgical History</h3>
			   <div class="seprator"></div>
			  </div>
			  
			  <div class="tab_form_fild_bg">
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Appendix"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				   <div class="form-group form_fild_row"> 
					<select class="form-control">
					 <option>2014</option>
					</select>
				   </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn"><i class="fas fa-times"></i></button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Tonsils"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				   <div class="form-group form_fild_row"> 
					<select class="form-control">
					 <option>2017</option>
					</select>
				   </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn">add surgery</button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="back_next_button">
				<ul>
				 <li>
				  <button type="button" class="btn">Back</button>
				 </li>
				 <li>
				  <button type="button" class="btn">Next</button>
				 </li>
				</ul>
			   </div>
			   
			   <div class="common_conditions_button">
				<h4>Common conditions</h4>
				<ul>
				 <li class="active">
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Appendix removal</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Gallbladder removal</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Gallstones removal</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Hernia</span>
				  </button> 
				 </li>
				</ul>
			   </div>
			  </div>
			 </div>
			 
		  <div class="tab-pane fade" id="family" role="tabpanel" aria-labelledby="family-tab">
			  <div class="TitleHead">
			   <h3>Family History</h3>
			   <div class="seprator"></div>
			  </div>
			  
			  <div class="tab_form_fild_bg">
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Family member"/> 
				 </div>
				 
				<div class="form-group form_fild_row">		 
				 <div class="radio_list"> 
				   <div class="form-check">
					<input type="radio" class="form-check-input" id="materialUnchecked" name="materialExampleRadios">
					<label class="form-check-label" for="materialUnchecked">Alive</label>
				   </div>
				 
				   <div class="form-check">
					<input type="radio" class="form-check-input" id="materialUnchecked2" name="materialExampleRadios">
					<label class="form-check-label" for="materialUnchecked2">Deceased</label>
				  </div>
				 </div>
				</div>
				
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				  <div class="form-group form_fild_row"> 
				   <input type="text" class="form-control" placeholder="Diabetes"/> 
				  </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn"><i class="fas fa-times"></i></button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Father side grandfather"/> 
				 </div>
				 
				<div class="form-group form_fild_row">		 
				 <div class="radio_list"> 
				   <div class="form-check">
					<input type="radio" class="form-check-input" id="materialUnchecked" name="materialExampleRadios">
					<label class="form-check-label" for="materialUnchecked">Alive</label>
				   </div>
				 
				   <div class="form-check">
					<input type="radio" class="form-check-input" id="materialUnchecked2" name="materialExampleRadios">
					<label class="form-check-label" for="materialUnchecked2">Deceased</label>
				  </div>
				 </div>
				</div>
				
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				  <div class="form-group form_fild_row"> 
				   <input type="text" class="form-control" placeholder="Diabetes, high blood pressure"/> 
				  </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn">family member</button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div> 
			  
			  
			   <div class="back_next_button">
				<ul>
				 <li>
				  <button type="button" class="btn">Back</button>
				 </li>
				 <li>
				  <button type="button" class="btn">Next</button>
				 </li>
				</ul>
			   </div>
			  </div>
			 </div>
			 
		  <div class="tab-pane fade" id="allergies" role="tabpanel" aria-labelledby="allergies-tab">
			<div class="TitleHead">
			   <h3>Allergies</h3>
			   <div class="seprator"></div>
			  </div>
			  
		    <div class="tab_form_fild_bg">
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Fish"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				   <div class="form-group form_fild_row"> 
					<input type="text" class="form-control" placeholder="Select Reaction "/> 
				   </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn"><i class="fas fa-times"></i></button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Peanuts"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				   <div class="form-group form_fild_row"> 
					<input type="text" class="form-control" placeholder="Select Reaction"/> 
				   </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn"><i class="fas fa-times"></i></button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="row">
				<div class="col-md-6">
				 <div class="form-group form_fild_row"> 
				  <input type="text" class="form-control" placeholder="Select allergies"/> 
				 </div>
				</div>
				
				<div class="col-md-6">
				 <div class="row"> 
				  <div class="col-md-7">
				   <div class="form-group form_fild_row"> 
					<input type="text" class="form-control" placeholder="Select allergies"/> 
				   </div>
				  </div>
				  
				  <div class="col-md-5">
				   <div class="crose_year">
					<button class="btn">Add allergy</button>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>  
			   
			   <div class="back_next_button">
				<ul>
				 <li>
				  <button type="button" class="btn">Back</button>
				 </li>
				 <li>
				  <button type="button" class="btn">Next</button>
				 </li>
				</ul>
			   </div>
			   
			   <div class="common_conditions_button">
				<h4>Common conditions</h4>
				<ul>
				 <li class="active">
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Cats</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Contrast</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Eggs</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Fish</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Peanuts</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Shellfish</span>
				  </button> 
				 </li>
				 
				 <li>
				  <button class="btn">
				   <i class="fas fa-plus-circle"></i>
				   <span>Soaps</span>
				  </button> 
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
   	</div>
   </div>
  </div> 
 </div>
</div>

<?php include("footer.php");?>
	
	