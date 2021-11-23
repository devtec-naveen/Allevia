	
<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
	 <div class="TitleHead">
	  <h3>Reset Password</h3>
	  <div class="seprator"></div>
	 </div> 
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create(null , array(   'autocomplete' => 'off', 
										
							'inputDefaults' => array(
							'label' => false,
							'div' => false,
											
							),'enctype' => 'multipart/form-data', 'id' => 'reset_form')); ?>    	 
	 <div class="form_fild_content row">
	  <div class="col-md-6">
	   <div class="form-group form_fild_row"> 
	<?php echo  $this->Form->control('password', ['type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'label' => false, 'autocomplete' => 'off', 'required' => true]); ?>	

	   </div>
	   <div class="form-group form_fild_row"> 
	<?php echo  $this->Form->control('confirm_password', ['type' => 'password', 'class' => 'form-control', 'placeholder' => 'Retype Password', 'label' => false, 'autocomplete' => 'off', 'required' => true]); ?>	

	   </div>       
	   <div class="form_submit_button">
	    <button type="submit" class="btn">Submit</button>
	   </div>
	  </div> 
	 
	  <div class="col-md-6 ger_box">
	   <div class="form_ger">
	    <img src="<?= WEBROOT ?>images/forgot_ger.png"/>
	   </div>
	  </div>
	 </div>
	 <?php echo $this->Form->end(); ?>
	 
	</div> 
   </div> 
  </div> 
 </div>
</div>



<script type="text/javascript">
  $.validator.addMethod("passwordregex", function(value, element, regexp) {

  return regexp.test(value) ; 
 
   // return   /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) &&  // consists of only these
   //      /[a-zA-Z]/.test(value) // has a lowercase letter
   //     && /\d/.test(value) // has a digit
}, "Password must be at least 8 characters long and a combination of uppercase, lowercase character, number.");


  $().ready(function() {
    // validate the comment form when it is submitted
    $("#reset_form").validate({
            // rules : {
            //     password : {
            //         minlength : 6
            //     },
            //     confirm_password : {
            //         minlength : 6,
            //         equalTo : "#password"
            //     }
            // }

      onfocusout: function(element) {$(element).valid()},
            rules : {
                password : {
                   passwordregex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
                    minlength : 8,
                   
                },
                confirm_password : {
                    equalTo : "#password"
                }
            },
     messages: {

      confirm_password: "Passwords don't match",

     }


        });

  }); 

</script>