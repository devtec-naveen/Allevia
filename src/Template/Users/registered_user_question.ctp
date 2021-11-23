<?php
   use Cake\Utility\Security; 
   use Cake\Core\Configure;
   $session_user = $this->request->getSession()->read('Auth.User');
   $apt_id = isset($this->request->params['pass'][0])?$this->request->params['pass'][0]:'';
   $next_steps = isset($this->request->params['pass'][1])?$this->request->params['pass'][1]:'';
   $step_id = isset($this->request->params['pass'][2])?$this->request->params['pass'][2]:'';
   $apt_id_data_schedule_id =  isset($this->request->params['pass'][3])?$this->request->params['pass'][3]:'';
   $iframe_prefix = Configure::read('iframe_prefix');
   ?>
<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
	 <div class="TitleHead">
	  <h3>User Information</h3>
	  <div class="seprator"></div>
	 </div>
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create('' , array(

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'regstered_user')); ?>

              <?php if(!empty($schedule_data)){ ?>
              <input type="hidden" name="apt_id" value="<?php echo $apt_id ?>"/>
              <input type="hidden" name="next_steps" value="<?php echo $next_steps ?>"/>
              <input type="hidden" name="step_id" value="<?php echo $step_id?>"/>
              <input type="hidden" name="schedule_id" value="<?php echo $apt_id_data_schedule_id ?>"/>
                <?php } ?>
	 <div class="form_fild_content row">
	  <div class="col-md-6 ">
     <div class="form-group form_fild_row">
       <div class="radio_bg">
        <?php $address = !empty($login_user['address']) ? Security::decrypt( base64_decode($login_user['address']), SEC_KEY):'';
        $address_arr = explode(' ', $address);
        $state = !empty($login_user['state']) ? Security::decrypt( base64_decode($login_user['state']), SEC_KEY):'';
        $state_arr = explode(' ',$state);
        $city = !empty($login_user['city']) ? Security::decrypt( base64_decode($login_user['city']), SEC_KEY):'';
        $city_arr = explode(' ',$city);
        $zip = !empty($login_user['zip']) ? Security::decrypt( base64_decode($login_user['zip']), SEC_KEY):'';
        $zip_arr = explode(' ',$zip);
        $full_address = array_merge($address_arr,$city_arr,$state_arr,$zip_arr);
        $full_address =array_filter($full_address);
        $long_address = array();
        // pr($full_address);
        if(!empty($full_address))
        {
          foreach ($full_address as $key => $value) {
            if(strlen($value) > 2)
            {
              $long_address[$key] =  substr_replace($value, str_repeat("X", strlen($value)-2), 2,strlen($value));
            }
            else
            {
              $long_address[$key] = $value;
            }
            
          }
        }
        //pr($long_address);
        $addressess = implode(' ',$long_address);

        $pharmacy = !empty($login_user['pharmacy']) ? Security::decrypt( base64_decode($login_user['pharmacy']), SEC_KEY) :"";
        $pharmacy_arr = explode(' ', $pharmacy);
        $pharmacy_arr = array_filter($pharmacy_arr);
        $mask_pharmacy = array();
        if(!empty($pharmacy_arr))
        {
          foreach ($pharmacy_arr as $key => $value) {
            $mask_pharmacy[$key] =  substr_replace($value, str_repeat("X", strlen($value)-2), 3,strlen($value));
          }
        }
        $masked_pharmacy = implode(' ',$mask_pharmacy);


        ?>
                <label>Do you still live at <?php echo !empty($addressess) ? $addressess:'';?>?</label>
      <div class="radio_list">
          <div class="form-check">
               <input type="radio"  value="1" class="form-check-input is_address" id="was_it_regular_or_not1" name="is_address" checked="">
               <label class="form-check-label" for="was_it_regular_or_not1">Yes</label>
          </div>
           <div class="form-check">
               <input type="radio"  value="0"  class="form-check-input is_address" id="was_it_regular_or_not2" name="is_address">
               <label class="form-check-label" for="was_it_regular_or_not2">No</label>
            </div>
          </div>
        </div>
      </div>
      <div class="address_section display_none_at_load_time">
      <div class="form-group form_fild_row">
        <?php echo  $this->Form->control('address', ['type' => 'text', 'class' => 'form-control','label' => 'Address', 'autocomplete' => 'off','id' =>'address']); ?>
       </div>
       <div class="form-group form_fild_row">
        <?php echo  $this->Form->control('city', ['type' => 'text', 'class' => 'form-control','label' => 'City', 'autocomplete' => 'off','id' =>'city']); ?>
       </div>
       <div class="form-group form_fild_row">
        <?php echo  $this->Form->control('state', ['type' => 'text', 'class' => 'form-control','label' => 'State ', 'autocomplete' => 'off','id' =>'state']); ?>
     </div>
     <div class="form-group form_fild_row">
        <?php echo  $this->Form->control('zip', ['type'=>"number", 'pattern'=>"[0-9]*", 'inputmode'=>"numeric",  'class' => 'form-control', 'label' => 'Zip code', 'autocomplete' => 'off','id' =>'zip_code','maxlength' =>'6']); // ,  'pattern' => "[1-9]{1}[0-9]{9}" ?>
     </div>
   </div>
      <div class="form-group form_fild_row">
       <div class="radio_bg">
        <label>Is your pharmacy still <?php echo !empty($login_user['pharmacy']) ? $masked_pharmacy :''; ?>?
                              &nbsp;</label>
      <div class="radio_list">
          <div class="form-check">
               <input type="radio"  value="1" class="form-check-input is_pharmacy" id="was_it_regular_or_not3" name="is_pharmacy" checked="">
               <label class="form-check-label" for="was_it_regular_or_not3">Yes</label>
          </div>
           <div class="form-check">
               <input type="radio"  value="0"  class="form-check-input is_pharmacy" id="was_it_regular_or_not4" name="is_pharmacy">
               <label class="form-check-label" for="was_it_regular_or_not4">No</label>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group form_fild_row pharmacy_section display_none_at_load_time">
        <?php echo  $this->Form->control('pharmacy', ['type' => 'text', 'class' => 'form-control','label' => 'Pharmacy', 'autocomplete' => 'off','id' =>'pharmacy']); ?>
       </div>
      <div class="form-group form_fild_row">
       <div class="radio_bg">
                <?php $phone_number = !empty($login_user['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($login_user['phone']),SEC_KEY) :"";?>
                <label>Is your phone number still <?php echo !empty($login_user['phone']) ? substr_replace($phone_number, str_repeat("X", strlen($phone_number)-4), 0,-4):''; ?>?
                              &nbsp;</label>
      <div class="radio_list">
          <div class="form-check">
               <input type="radio"  value="1" class="form-check-input is_phone" id="was_it_regular_or_not5" name="is_phone" checked="">
               <label class="form-check-label" for="was_it_regular_or_not5">Yes</label>
          </div>
           <div class="form-check">
               <input type="radio"  value="0"  class="form-check-input is_phone" id="was_it_regular_or_not6" name="is_phone">
               <label class="form-check-label" for="was_it_regular_or_not6">No</label>
            </div>
          </div>
        </div>
      </div>	     
      <div class="form-group form_fild_row phone_section display_none_at_load_time">
        <?php echo  $this->Form->control('phone', ['type' => 'text', 'class' => 'form-control','label' => 'Phone Number', 'autocomplete' => 'off']); ?>
       </div>
	   <div class="form_submit_button">
	    <button type="submit" class="btn">Submit</button>
	   </div>
	 </div>
	 <?php echo $this->Form->end(); ?>
  <div class="col-md-6 ger_box">
     <div class="form_ger">
      <img src="<?= WEBROOT ?>images/signup_ger.png"/>
     </div>
    </div>
	</div>
   </div>
  </div>
 </div>
</div>
</div>
<script>
  $(document).on("click", "input[type='radio'].is_address", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 0) {
          $('.address_section').removeClass('display_none_at_load_time').show();
        }else{ 
          $('.address_section').hide();
          $('#address').val('');
          $('#city').val('');
          $('#state').val('');
          $('#zip_code').val('');
        }
    }
});
</script>
<script>
  $(document).on("click", "input[type='radio'].is_pharmacy", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 0) {
          $('.pharmacy_section').removeClass('display_none_at_load_time').show();
        }else{
          $('.pharmacy_section').hide();
          $('#pharmacy').val('');
        }
    }
});
</script>
<script>
  $(document).on("click", "input[type='radio'].is_phone", function () {
    if($(this).is(':checked')) {
        if ($(this).val() == 0) {
          $('.phone_section').removeClass('display_none_at_load_time').show();
        }else{
          $('.phone_section').hide();
          $('#phone').val('');
        }
    }
});
</script>
<script type="text/javascript">
$.validator.addMethod("phoenregex", function(value, element, regexp) {

  return regexp.test(value) ;

}, "Allowed format for phone number is - XXX-XXX-XXXX.");

  $().ready(function() {
    // validate the comment form when it is submitted
    $("#regstered_user").validate({
      //ignore: ":hidden:not(.hiddenRecaptcha)", // validating recaptcha hidden input
      // onkeyup: function(element) {$(element).valid()},
      onfocusout: function(element) {$(element).valid()},
            rules : {
                state : {
                   required: true,
                   // onkeyup: false,
                },
                city : {
                   required: true,
                   // onkeyup: false,
                },
                address : {
                   required: true,
                   // onkeyup: false,
                },
                zip : {
                   required: true,

                },
                pharmacy : {
                   required: true,
                   // onkeyup: false,
                },
                phone: {

			              required: true,
			               number: true,
			               minlength: 10,
			               maxlength: 10
			    },
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
</script>