<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<?php
  $url = $this->request->getParam('pass');

 // pr($shedule_id);die;
  $schedule_data = null;
  //pr($url);
  if(!empty($url)){

  	$shedule_id = explode("-",base64_decode($url[0]))[0];
    $schedule_data = $this->General->get_schedule($shedule_id);
  }

  $organization_data = null;
  if(!empty($schedule_data)){

    $organization_data = $this->General->get_organization_data($schedule_data['organization_id']);
  }
?>
<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
	 <div class="TitleHead">
	  <h3>Registration</h3>
	  <div class="seprator"></div>
	 </div>
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create($user , array(

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'regster_form')); ?>

              <?php if(!empty($schedule_data)){ ?>
                <input type="hidden" name="schedule_user" value="1">
                <input type="hidden" name="schedule_id" value="<?php echo $url[0];?>">
                <?php } ?>
	 <div class="form_fild_content row">
	  <div class="col-md-6 ">

	   <div class="row">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('first_name', ['type' => 'text', 'class' => 'form-control','label' => "First Name", 'autocomplete' => 'off', 'required' => true,'value' =>!empty($schedule_data['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['first_name']),SEC_KEY):""]); ?>
	     </div>
        </div>

		<div class="col-md-6">
	     <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('last_name', ['type' => 'text', 'class' => 'form-control','label' => 'Last Name', 'autocomplete' => 'off', 'required' => 'required','value' =>!empty($schedule_data['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['last_name']),SEC_KEY) :""]); ?>
	     </div>
	    </div>
	   </div>

       <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('email', ['type' => 'email', 'class' => 'form-control','label' => 'Email Address', 'autocomplete' => 'off', 'required' => 'required','value' =>!empty($schedule_data['email']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['email']),SEC_KEY) :"",'readonly' => !empty($schedule_data['email'])?true:false]); ?>
	   </div>

	   <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('phone', ['type'=>"number", 'pattern'=>"[0-9]*", 'inputmode'=>"numeric",  'class' => 'form-control', 'label' => 'Mobile Number', 'autocomplete' => 'off', 'required' => 'required','value' =>!empty($schedule_data['phone']) ? str_replace("-", "",$this->CryptoSecurity->decrypt(base64_decode($schedule_data['phone']),SEC_KEY)):""]); // ,  'pattern' => "[1-9]{1}[0-9]{9}" ?>
	   </div>

	    <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('password', ['type' => 'password', 'class' => 'form-control','label' => 'Password', 'autocomplete' => 'new-password', 'required' => 'required']); ?>
        <p style="color: green">Password Hint:- Password must be at least 8 characters long and a combination of uppercase, lowercase characters and numbers.</p>
	   </div>

       <div class="form-group form_fild_row">
      <?php echo  $this->Form->control('confirm_password', ['type' => 'password', 'class' => 'form-control','label' => 'Confirm Password', 'autocomplete' => 'off', 'required' => 'required']); ?>
	   </div> 

       <!-- <div class="form-group form_fild_row">

        <?php if(isset($schedule_data['organization_id']) && !empty($schedule_data['organization_id'])){ ?>

       		<?php echo  $this->Form->control('organization_name', ['type' => 'text', 'class' => 'form-control','label' => 'Organization Name', 'autocomplete' => 'off', 'required' => true,'value' =>!empty($schedule_data['organization']) ? $schedule_data['organization']['organization_name']:"", 'readonly' => true]); ?>

          <input type="hidden" name="organization_id" value="<?php echo $schedule_data['organization_id']; ?>">

       	<?php }else{ ?>

          <label for="organization_id">Organization Name</label>
       		<?php echo $this->Form->select('organization_id', $org_data, ['class' => 'form-control' , 'empty' => 'Select Clinic' , 'required' => 'required','default'=> isset($schedule_data['organization_id']) && !empty($schedule_data['organization_id']) ? $schedule_data['organization_id']:"Select Clinic",'readonly' =>isset($schedule_data['organization_id']) && !empty($schedule_data['organization_id'])? true:false]); ?>


       	<?php  } ?>

	   </div>

	   <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('org_access_code', ['type' => 'password', 'class' => 'form-control','label' => 'Clinic Access Code', 'autocomplete' => 'off', 'required' => 'required','value' => !empty($schedule_data['organization']) ? $schedule_data['organization']['access_code'] : "",'readonly' => !empty($schedule_data['organization']) ? true :false]); ?>
	   </div> -->



	   <div class="form-group form_fild_row">

	      <?php echo  $this->Form->control('dob', ['type' => 'text', 'value' => (!empty($schedule_data->dob)? date('m-d-Y',strtotime($this->CryptoSecurity->decrypt(base64_decode($schedule_data->dob),SEC_KEY))) : '') , 'class' => 'form-control','label' => 'Date Of Birth',  'id'=>'datetimepicker1', 'autocomplete' => 'off', 'required' => 'required']); ?>



   <script>
  $( function() {
    $( "#datetimepicker1" ).datepicker({
    	    changeMonth: true,

    changeYear: true,
yearRange: "-100:+0",
  dateFormat: "mm-dd-yy" , // "dd-mm-yy",
  maxDate: new Date()
}).on('change', function() {
        $(this).valid();  // triggers the validation test
        // '$(this)' refers to '$("#datepicker")'
    });
  } );
  </script>



	   </div>

	   <div class="form-group form_fild_row">
	   <label for="gender">Gender</label>
     	<?php
     		$gender = array( 1 => 'Male', 0 => 'Female', 2 => 'Other');
     	 echo $this->Form->select('gender', $gender, ['class' => 'form-control' , 'empty' => 'Select Gender' , 'required' => 'required']); ?>
	   </div>

<div class="remember_me_box">
	    <div class="custom-control custom-checkbox">
         <!-- <input type="checkbox" name="rememberme" class="custom-control-input" id="defaultUnchecked"> -->
         <?php echo $this->Form->checkbox('terms_conditions', ['hiddenField' => true, 'class' => 'custom-control-input', 'id' => 'terms_conditions',  'data-error'=>"#errNm1" , 'required' => true]); ?>
         <label class="custom-control-label" for="terms_conditions">I agree to <a href="#"  data-toggle="modal" data-target="#myModal1">Terms and Conditions</a>, <a href="#"  data-toggle="modal" data-target="#myModal2">Privacy Policy</a> and <a href="#"  data-toggle="modal" data-target="#myModal3">PHI authorization</a>.</label>
 <div class="errorTxt">
    <span id="errNm1"></span>
  </div>
        </div>
	   </div>


<?php /*
<div class="remember_me_box">
	    <div class="custom-control custom-checkbox">
         <!-- <input type="checkbox" name="rememberme" class="custom-control-input" id="defaultUnchecked"> -->
         <?php echo $this->Form->checkbox('privacy_policy', ['hiddenField' => true, 'class' => 'custom-control-input', 'id' => 'privacy_policy', 'required' => true]); ?>
         <label class="custom-control-label" for="privacy_policy"><a  target="_blank"  href="<?php echo SITE_URL ?>pages/privacy-policy">Privacy Policy</a></label>
        </div>
	   </div>
<div class="remember_me_box">
	    <div class="custom-control custom-checkbox">
         <!-- <input type="checkbox" name="rememberme" class="custom-control-input" id="defaultUnchecked"> -->
         <?php echo $this->Form->checkbox('phi_authorization', ['hiddenField' => true, 'class' => 'custom-control-input', 'id' => 'phi_authorization', 'required' => true]); ?>
         <label class="custom-control-label" for="phi_authorization"><a  target="_blank"  href="<?php echo SITE_URL ?>pages/phi-authorization">PHI Authorization</a></label>
        </div>
	   </div>
*/ ?>

<!-- <div class="form-group form_fild_row">
<div class="g-recaptcha" data-sitekey=""  data-callback="recaptchaCallback"></div>
<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
     </div> -->

	   <div class="form_submit_button">
	    <button type="submit" class="btn">Submit</button>
	   </div>

	  </div>

	  <div class="col-md-6 ger_box">
	   <div class="form_ger">
	    <img src="<?= WEBROOT ?>images/signup_ger.png"/>
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
/*
jQuery('#phone').keyup(function () {   // phone number restriction to 10 digits and allow only numbers, character not allowed

    this.value = this.value.replace(/[^0-9\.]/g,'');
    if (this.value.length > 10)
              this.value =  this.value.substr(0, 10);
});
*/

$("#password").keyup(function(e){
  var flag = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test($(this).val());
  if($('#password-error').length && !flag){
    $('#password-error').val('Password must be at least 8 characters long and a combination of uppercase, lowercase character, number.');
  }else if(!$('#password-error').length && !flag){
     $(this).after('<label id="password-error" class="error" for="password" style="">Password must be at least 8 characters long and a combination of uppercase, lowercase character, number.</label>');
  }else if(flag){
    $(document).find('#password-error').remove();

  }
});


$("#confirm_password").keyup(function(e){
  var flag = $('#password').val() == $('#confirm_password').val();


  if($('#confirm-password-error').length && !flag){
     $('#confirm-password-error').val("Passwords don't match");
  }else if(!$('#confirm-password-error').length && !flag){
     $(this).after('<label id="confirm-password-error" class="error" for="confirm-password">Passwords don\'t match</label>');
  }else if(flag){
    $(document).find('#confirm-password-error').remove();

  }

});


$.validator.addMethod("phoenregex", function(value, element, regexp) {

  return regexp.test(value) ;

}, "Allowed format for phone number is - XXX-XXX-XXXX.");

    $.validator.addMethod("email", function(value, element) {
                return this.optional(element) || /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            }, "Please enter a valid email address.");

$.validator.addMethod("passwordregex", function(value, element, regexp) {

  return regexp.test(value) ;  
}, "Password must be at least 8 characters long and a combination of uppercase, lowercase character, number.");


jQuery.validator.addMethod("dob_validate", function(value, element) {

        return this.optional(element) || moment(value,"MM-DD-YYYY",true).isValid();
    }, "Please enter a valid date in the format MM-DD-YYYY");


  $().ready(function() {
    // validate the comment form when it is submitted
    $("#regster_form").validate({      
      onfocusout: function(element) {$(element).valid()},
            rules : {
                first_name : {
                   required: true,
                   // onkeyup: false,
                },
                last_name : {
                   required: true,
                   // onkeyup: false,
                },
                organization_id : {
                   required: true,
                   // onkeyup: false,
                },
                email : {
                   required: true,

                },
                org_access_code : {
                   required: true,
                   // onkeyup: false,
                },
                gender : {
                   required: true,
                   // onkeyup: false,
                },
                terms_conditions : {
                   required: true,
                   // onkeyup: false,
                },
                password : {
                   passwordregex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
                    minlength : 8,
                   // onkeyup: true,
                },
                confirm_password : {
                    equalTo : "#password",
                    // onkeyup: true
                },
                dob : {
                  dob_validate : true,
                  // onkeyup: false
                },
                phone: {

			              required: true,
			               number: true,
			               minlength: 10,
			               maxlength: 10
			    },
  /*hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            }  */
            },
     messages: {

      confirm_password: "Passwords don't match",
      phone: "Phone number should be 10 numbers."

     },
    errorPlacement: function(error, element) {   // different error location for specific element with attribute  'data-error'=>"#errNm1"
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }

        });


  });




// jQuery(function($) {
//   var validator = $('#form').validate({
//     rules: {
//       first: {
//         required: true
//       },
//       second: {
//         required: true
//       }
//     },
//     messages: {},
//     errorPlacement: function(error, element) {
//       var placement = $(element).data('error');
//       if (placement) {
//         $(placement).append(error)
//       } else {
//         error.insertAfter(element);
//       }
//     }
//   });
// });

$(document).ready(function(){
  if($(window).width() < 700){
    $(".ger_box").hide();
  }
});

// remove validation error mesage on recaptcha validate
function recaptchaCallback() {
  $('#hiddenRecaptcha').valid();
};

</script>



  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	     <h4 class="modal-title">Terms and Conditions</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
         <?php echo $pages_data['terms-conditions']; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
    <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	      <h4 class="modal-title">Privacy Policy</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <?php echo $pages_data['privacy-policy']; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
    <div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog  modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">PHI authorization</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <?php echo $pages_data['phi-authorization']; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

<style type="text/css">
  input[readonly] {
    background-color: #fff !important;
}
</style>
