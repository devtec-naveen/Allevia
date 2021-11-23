<?php include("header.php");?>
	
<div class="wraper">
 <div class="inner_page_content">
  <div class="account_details_content">
   <div class="container">
    <div class="step_head animated zoomIn">
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
	   
	   <li class="nav-item">
	    <a class="nav-link" id="shots-tab" data-toggle="tab" href="#shots" role="tab" aria-controls="shots" aria-selected="false">
		 <div class="step_number">
		  <i>6</i>
		 </div>
		 <span>Shots</span>
		</a>
	   </li>
	   
	   <li class="nav-item">
	    <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">
		 <div class="step_number">
		  <i>7</i>
		 </div>
		 <span>Social History</span>
		</a>
	   </li>
	   
	   <li class="nav-item">
	    <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="false">
		 <div class="step_number">
		  <i>8</i>
		 </div>
		 <span>Additional Field</span>
		</a>
	   </li>
	  </ul>  
	 </div>
	 
	</div>
   
    <div class="tab-content" id="myTabContent">
     <div class="tab_content_inner animated zoomIn">
	 
	 <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
	  <div class="TitleHead">
	   <h3>Basic Information</h3>
	   <div class="seprator"></div>
	  </div>
	  
      <div class="tab_form_fild_bg">
	   <div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Occupation"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
		 <div class="radio_bg"> 
		  <h4>Marital Status </h4>
		  <div class="radio_list"> 
		   <div class="form-check">
		  <input type="radio" class="form-check-input" id="materialUnchecked" name="materialExampleRadios">
		  <label class="form-check-label" for="materialUnchecked">Married</label>
		</div>
		 
		   <div class="form-check">
		 <input type="radio" class="form-check-input" id="materialUnchecked2" name="materialExampleRadios">
		 <label class="form-check-label" for="materialUnchecked2">Divorce</label>
		</div>
	     
		   <div class="form-check">
		  <input type="radio" class="form-check-input" id="materialUnchecked3" name="materialExampleRadios">
		  <label class="form-check-label" for="materialUnchecked3">Single</label>
		</div>
		  </div>
		 </div>
		</div>
	   </div>  
	   
       <div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <select class="form-control">
		   <option>Sexual orientation </option>
		  </select>
		 </div>
		</div>
		
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <select class="form-control">
		   <option>Ethnicity</option>
		  </select>
		 </div>
		</div>
	   </div>  	   
	   
	   <div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Occupation"/> 
	     </div>
		</div>
		
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Occupation"/> 
	     </div>
		</div>
	   </div>  
	   
	   <div class="form_submit_button">
	    <button type="button" class="btn">Next</button>
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
     
	 <div class="tab-pane fade" id="shots" role="tabpanel" aria-labelledby="shots-tab">
	  <div class="TitleHead">
	   <h3>Shots</h3>
	   <div class="seprator"></div>
	  </div>
	  
      <div class="tab_form_fild_bg">
	   <div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Pneumonia"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="row"> 
		  <div class="col-md-7">
		   <div class="form-group form_fild_row"> 
	        <input type="text" class="form-control" placeholder="Year"/> 
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
	      <input type="text" class="form-control" placeholder="Hepatitis A"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="row"> 
		  <div class="col-md-7">
		   <div class="form-group form_fild_row"> 
	        <input type="text" class="form-control" placeholder="2017"/> 
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
	        <input type="text" class="form-control" placeholder="Select Reaction"/> 
	       </div>
		  </div>
		  
		  <div class="col-md-5">
		   <div class="crose_year">
		    <button class="btn">Add shots</button>
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
		   <span>Flu</span>
		  </button> 
		 </li>
		 
		 <li>
		  <button class="btn">
		   <i class="fas fa-plus-circle"></i>
		   <span>Hepatitis A</span>
		  </button> 
		 </li>
		 
		 <li>
		  <button class="btn">
		   <i class="fas fa-plus-circle"></i>
		   <span>Hepatitis B</span>
		  </button> 
		 </li>
		 
		 <li>
		  <button class="btn">
		   <i class="fas fa-plus-circle"></i>
		   <span>Measles  </span>
		  </button> 
		 </li>
		 
		 <li>
		  <button class="btn">
		   <i class="fas fa-plus-circle"></i>
		   <span>Meningococcal</span>
		  </button> 
		 </li>
		 
		 <li>
		  <button class="btn">
		   <i class="fas fa-plus-circle"></i>
		   <span>Mumps</span>
		  </button> 
		 </li>
        </ul>
	   </div>
	  </div>
	 </div>
     
	 <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
	  <div class="TitleHead">
	   <h3>	Social History</h3>
	   <div class="seprator"></div>
	  </div>
	  
      <div class="tab_form_fild_bg">
	   <div class="row">
	    <div class="col-md-6">
		<div class="check_box_bg"> 
		 <div class="custom-control custom-checkbox">
          <input class="custom-control-input" id="defaultUnchecked" type="checkbox" checked>
          <label class="custom-control-label" for="defaultUnchecked">Currently Smoking</label>
         </div>
		 </div>
		</div>
	   </div>
	   
	   <div class="row">
	    <div class="col-md-6">
         <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How much packs"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How many years"/> 
	     </div>
		</div>
	   </div>  
	   
	   <div class="row">
	    <div class="col-md-6">
		<div class="check_box_bg"> 
		 <div class="custom-control custom-checkbox">
          <input class="custom-control-input" id="defaultUnchecked" type="checkbox" checked>
          <label class="custom-control-label" for="defaultUnchecked">Past Smoking</label>
         </div>
		 </div>
		</div>
	   </div>
	   
	   <div class="row">
	    <div class="col-md-6">
         <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How much packs"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How many years"/> 
	     </div>
		</div>
	   </div> 
	   
	   <div class="row">
	    <div class="col-md-6">
		<div class="check_box_bg"> 
		 <div class="custom-control custom-checkbox">
          <input class="custom-control-input" id="defaultUnchecked" type="checkbox" checked>
          <label class="custom-control-label" for="defaultUnchecked">Currently Drinking</label>
         </div>
		 </div>
		</div>
	   </div>
	   
	   <div class="row">
	    <div class="col-md-6">
         <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How much packs"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How many years"/> 
	     </div>
		</div>
	   </div> 
	   
	   <div class="row">
	    <div class="col-md-6">
		<div class="check_box_bg"> 
		 <div class="custom-control custom-checkbox">
          <input class="custom-control-input" id="defaultUnchecked" type="checkbox" checked>
          <label class="custom-control-label" for="defaultUnchecked">Past drinking</label>
         </div>
		 </div>
		</div>
	   </div>
	   
	   <div class="row">
	    <div class="col-md-6">
         <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How much packs"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How many years"/> 
	     </div>
		</div>
	   </div> 
	   
	   <div class="row">
	    <div class="col-md-6">
		<div class="check_box_bg"> 
		 <div class="custom-control custom-checkbox">
          <input class="custom-control-input" id="defaultUnchecked" type="checkbox" checked>
          <label class="custom-control-label" for="defaultUnchecked">Other drugs</label>
         </div>
		 </div>
		</div>
	   </div>
	   
	   <div class="row">
	    <div class="col-md-6">
         <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="How much"/> 
	     </div>
		</div>
		
		<div class="col-md-6">
	     <div class="row"> 
		  <div class="col-md-9"> 
		   <div class="form-group form_fild_row"> 
	        <input type="text" class="form-control" placeholder="How many years"/> 
	       </div>
		  </div>
		  
		  <div class="col-md-3">
		   <div class="crose_year">
		    <button class="btn waves-effect waves-light"><i class="fas fa-plus"></i></button>
		   </div>
		  </div>
		 
		 </div> 
		</div>
	   </div> 
	   
       <div class="form_submit_button">
	    <button type="button" class="btn waves-effect waves-light">Next</button>
	   </div>	   
	  </div>
	 </div>
     
	 <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
	  <div class="TitleHead">
	   <h3>	Additional Field </h3>
	   <div class="seprator"></div>
	  </div>
	  
      <div class="tab_form_fild_bg">
	   <div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Age of first period"/> 
	     </div>
		</div>
		
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Number of pregnancies "/> 
	     </div>
		</div>
       </div> 
       
	   <div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Number of live births "/> 
	     </div>
		</div>
		
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Number of miscarriages/abortions"/> 
	     </div>
		</div>
       </div> 	   
	   
       <div class="row">
	    <div class="col-md-6">
	     <div class="form-group form_fild_row"> 
	      <input type="text" class="form-control" placeholder="Last pap smear"/> 
		  <div class="calender_button">
		   <a href="javascript:;"><i class="fas fa-calendar-alt"></i></a>
		  </div>
	     </div>
		</div>
		
	    <div class="col-md-6">
		 <div class="form-group form_fild_row"> 
	      <select class="form-control">
		   <option>Regular pap smear </option>
		  </select>
		 </div>
		</div>
	   </div>  	   
	   
	   <div class="row">
		<div class="col-md-6">
		 <div class="radio_bg"> 
		  <h4>Currently pregnant? </h4>
		  <div class="radio_list"> 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked12" name="materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked12">Yes</label>
		   </div>
		 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked13" name= "materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked13">No</label>
		   </div>
	      </div>
		 </div>
		</div>
		
		<div class="col-md-6">
		 <div class="radio_bg"> 
		  <h4>Previously given birth? </h4>
		  <div class="radio_list"> 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked10" name="materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked10">Yes</label>
		   </div>
		 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked11" name= "materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked11">No</label>
		   </div>
	      </div>
		 </div>
		</div>
	   </div>  
	   
	   <div class="row mar15">
		<div class="col-md-6">
		 <div class="radio_bg"> 
		  <h4>Any abnormal breast lumps before? </h4>
		  <div class="radio_list"> 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked14" name="materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked14">Yes</label>
		   </div>
		 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked15" name= "materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked15">No</label>
		   </div>
	      </div>
		 </div>
		</div>
		
		<div class="col-md-6">
		 <div class="radio_bg"> 
		  <h4>Any STIs/STDs? </h4>
		  <div class="radio_list"> 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked16" name="materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked16">Yes</label>
		   </div>
		 
		   <div class="form-check">
		     <input type="radio" class="form-check-input" id="materialUnchecked17" name= "materialExampleRadios">
		     <label class="form-check-label" for="materialUnchecked17">No</label>
		   </div>
	      </div>
		 </div>
		</div>
	   </div> 
	   
	   <div class="form_submit_button">
	    <button type="button" class="btn">Submit</button>
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
	
	