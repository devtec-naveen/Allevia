<div class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="<?php echo ADMIN_SITE_URL ?>">
                Allevia
                <b>
                    Panel
                </b>
            </a>
            <small>
                Your Personal AI-powered Medical Assistant
            </small>
        </div>
        <div class="card">
            <div class="body">
	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create(null , array(   'autocomplete' => 'off', 
										
							'inputDefaults' => array(
							'label' => false,
							'div' => false,
											
							),'enctype' => 'multipart/form-data', 'id' => 'reset_form')); ?> 
                    <!-- <div class="msg">
                        Enter your email address that you used to register. We'll send you an email with your username and a
                        link to reset your password.
                    </div> -->
                     <!-- <div class="form-group form-float">
                        <div class="form-line">
                         <?php //echo $this->Form->control('token', ['type' => 'text','data-msg-required'=>'Enter OTP *','label' => false,'class' => 'form-control','required' => true]); ?>
                         <label class="form-label">Otp</label>
                      </div>
                    </div> -->
                    <div class="form-group form-float">
                        <div class="form-line">
                         <?php  echo $this->Form->control('password', ['type' => 'password','data-msg-required'=>'Enter Password *','id'=>'password','label' => false,'class' => 'form-control','required' => true]); ?>


                         <label class="form-label">Password</label>
                      </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                        <?php echo $this->Form->control('confirm_password', ['type' => 'password','data-msg-required'=>'Enter Confirm Password *','label' => false,'class' => 'form-control','required' => true]); ?>
                         <label class="form-label">Confirm Password</label>
                      </div>
                    </div>
                     <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                   <?= $this->Form->end() ?>
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