<?php
  $url = $this->request->getParam('pass'); 
  $schedule_data = null;
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
	  <h3>Address</h3>
	  <div class="seprator"></div>
	 </div>
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create('' , array(

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

	   

		
	     <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('city', ['type' => 'text', 'class' => 'form-control','label' => 'City', 'autocomplete' => 'off', 'required' => 'required','value' =>!empty($schedule_data['city']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['city']),SEC_KEY) :""]); ?>
	     </div>
	    
	 

       <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('state', ['type' => 'text', 'class' => 'form-control','label' => 'State ', 'autocomplete' => 'off', 'required' => 'required','value' =>!empty($schedule_data['state']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['state']),SEC_KEY) :"",'readonly' => !empty($schedule_data['state'])?true:false]); ?>
	   </div>

	   <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('zip', ['type'=>"number", 'pattern'=>"[0-9]*", 'inputmode'=>"numeric",  'class' => 'form-control', 'label' => 'Zip code', 'autocomplete' => 'off', 'required' => 'required','maxlength' =>'6','value' =>!empty($schedule_data['zip code']) ? str_replace("-", "",$this->CryptoSecurity->decrypt(base64_decode($schedule_data['zip code']),SEC_KEY)):""]); // ,  'pattern' => "[1-9]{1}[0-9]{9}" ?>
	   </div>	  

	   <div class="form-group form_fild_row">
	   <label for="gender">Race</label>
      <select name="clinical_race" class="form-control" required="required">
                                    <?php $race = array('1' =>'American Indian or Alaska Native',
                                       '2' =>'Asian',
                                       '3' =>'Black or African American',
                                       '4' =>'Native Hawaiian or Other Pacific Islander',
                                       '5' =>'White',
                                       '6' =>'Other Race'); ?>  
                                    <option value="">Select Race</option>
                                    <?php foreach ($race as $key => $value) {
                                       ?>
                                    <option value="<?= $key ?>" <?php if(!empty($userInfo) && $userInfo['clinical_race'] == $key){ echo 'selected'; } ?>><?= $value ?> </option>
                                    <?php } ?>
                                 </select>
	   </div>

     <div class="form-group form_fild_row">
     <label for="gender">Ethnicity</label>
      <select name="clinical_ethnicity" class="form-control" required="required">
                                    <?php $ethnicity = array('1' =>'Hispanic or Latino',
                                       '2' =>'Not Hispanic or Latino'); ?>  
                                    <option value="">Select Ethnicity</option>
                                    <?php foreach ($ethnicity as $key => $value) {
                                       ?>
                                    <option value="<?= $key ?>" <?php if(!empty($userInfo) && $userInfo['clinical_ethnicity'] == $key){ echo 'selected'; } ?>><?= $value ?> </option>
                                    <?php } ?>
                                 </select>
     </div>


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
                return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
            }, "Please enter a valid email address.");

$.validator.addMethod("passwordregex", function(value, element, regexp) {

  return regexp.test(value) ;

   // return   /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) &&  // consists of only these
   //      /[a-zA-Z]/.test(value) // has a lowercase letter
   //     && /\d/.test(value) // has a digit
}, "Password must be at least 8 characters long and a combination of uppercase, lowercase character, number.");


jQuery.validator.addMethod("dob_validate", function(value, element) {

        return this.optional(element) || moment(value,"MM-DD-YYYY",true).isValid();
    }, "Please enter a valid date in the format MM-DD-YYYY");


  $().ready(function() {
    // validate the comment form when it is submitted
    $("#regster_form").validate({
      //ignore: ":hidden:not(.hiddenRecaptcha)", // validating recaptcha hidden input
      // onkeyup: function(element) {$(element).valid()},
      onfocusout: function(element) {$(element).valid()},

  // onkeyup: function(element) {   // this enables onkeyup for password only
  //   var element_id = jQuery(element).attr('name');
  //   if (this.settings.rules[element_id].onkeyup === true) {

  // // console.log(element);
  // $(element).valid();
  //   // $(arguments).valid(); // this is also working
  //     // jQuery.validator.defaults.onkeyup.apply(this, arguments);
  //   }
  // },



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
                   required: false,

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

			              required: false,
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
