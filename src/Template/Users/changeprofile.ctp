 <?php
 use Cake\Utility\Security;
 //echo $this->CryptoSecurity->decrypt(base64_decode($organizations->dob),SEC_KEY);die;
// pr($organizations); die;
 ?>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
 <script src="<?php echo WEBROOT.'frontend/js/new_appointment.js'; ?>"></script>


<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
    <input type="hidden" class="timeinterval"/>
   <div class="TitleHead">
    <h3>My Profile</h3>
    <div class="seprator"></div>
       <?= $this->Flash->render() ?>
   </div>

      <?php echo $this->Form->create($organizations , array(   'autocomplete' => 'off',

              'inputDefaults' => array(
              'label' => false,
              'div' => false,

              ),'enctype' => 'multipart/form-data', 'id' => 'contact_form')); ?>
   <div class="form_fild_content row">


    <div class="col-md-6" style="margin: auto; ">
     <div class="form-group form_fild_row">
      <!-- <input type="text" class="form-control" placeholder="Name"/>  -->
<label>First Name</label>
  <?php echo  $this->Form->control('first_name', ['type' => 'text', 'class' => 'form-control', 'placeholder' => 'First Name', 'label' => false, 'autocomplete' => 'off', 'value' => !empty($organizations->first_name) ?  $this->CryptoSecurity->decrypt( base64_decode($organizations->first_name) , SEC_KEY) : '' , 'required' => true ]); ?>

     </div>
     <div class="form-group form_fild_row">
      <!-- <input type="text" class="form-control" placeholder="Name"/>  -->
<label>Last Name</label>
  <?php echo  $this->Form->control('last_name', ['type' => 'text', 'class' => 'form-control', 'placeholder' => 'Last Name', 'label' => false, 'autocomplete' => 'off', 'value' => !empty($organizations->last_name) ? $this->CryptoSecurity->decrypt( base64_decode($organizations->last_name) , SEC_KEY) : '' , 'required' => true ]); ?>

     </div>
     <div class="form-group form_fild_row">
      <!-- <input type="text" class="form-control" placeholder="Name"/>  -->
<label>Phone</label>
  <?php echo  $this->Form->control('phone', ['type'=>"number", 'pattern'=>"[0-9]*", 'inputmode'=>"numeric", 'class' => 'form-control', 'placeholder' => 'Phone', 'label' => false, 'autocomplete' => 'off', 'required' => false,'disabled' => true,'value' => !empty($organizations->phone) ? $this->CryptoSecurity->decrypt( base64_decode($organizations->phone) , SEC_KEY) : '']); ?>

     </div>

     <div class="form-group form_fild_row">
      <!-- <input type="text" class="form-control" placeholder="Name"/>  -->
<label>Email</label>
  <?php echo  $this->Form->control('email', ['type'=>"text", 'class' => 'form-control', 'placeholder' => 'Email', 'label' => false, 'autocomplete' => 'off', 'required' => false,'disabled' => true,'value' => !empty($organizations->email) ? $this->CryptoSecurity->decrypt( base64_decode($organizations->email) , SEC_KEY) : '']); ?>

     </div>



<div class="form-group form_fild_row">
<!--      <select class="form-control">
     <option>Date of Birth    dob  </option>
    </select> -->

<label>Date of birth</label>

                    <!-- <input type='text' name="dob" class="form-control" placeholder="DOB" id='datetimepicker1' 'required' = 'required' /> -->
        <?php echo  $this->Form->control('dob', ['type' => 'text', 'value' => (isset($organizations->dob) && !empty($organizations->dob)? date('m-d-Y',strtotime($this->CryptoSecurity->decrypt(base64_decode($organizations->dob),SEC_KEY))) : '') , 'class' => 'form-control', 'placeholder' => 'Date of birth', 'label' => false,  'id'=>'datetimepicker1', 'autocomplete' => 'off', 'required' => true]); ?>



   <script>
  $( function() {
    $( "#datetimepicker1" ).datepicker({
          changeMonth: true,

    changeYear: true,
yearRange: "-100:+0",
  dateFormat: "mm-dd-yy", // "dd-mm-yy",
  maxDate: new Date()
}).on('change', function() {
        $(this).valid();  // triggers the validation test
        // '$(this)' refers to '$("#datepicker")'
    });
  } );
  </script>



     </div>

       <div class="form-group form_fild_row">
        <label>New Password</label>
        <?php echo  $this->Form->control('password', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'required' => false]); ?>

     </div>

       <div class="form-group form_fild_row">
                <label>Confirm New Password</label>
      <?php echo  $this->Form->control('confirm_password', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'required' => false]); ?>
     </div>

     <?php /*
     <div class="form-group form_fild_row">
      <!-- <input type="text" class="form-control" placeholder="Email id"/>  -->
     <?php echo  $this->Form->control('email', ['type' => 'email', 'class' => 'form-control', 'placeholder' => 'Email id', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>
     </div>
     */ ?>

     <input type="hidden" name="input_pass" value="<?php echo isset($input_pass) ? $input_pass : '' ; ?>">


     <div class="form_submit_button">
      <button type="submit" class="btn">Update</button>
     </div>
      </div>
      <div class="col-md-12" >
<div style="text-align: center; color: green;  ">Hint : Please leave new password and confirm new password fields empty if you don't want to change the password. </div>
      </div>

   </div>
     <?php echo $this->Form->end(); ?>
  </div>
   </div>
  </div>
 </div>
</div>
<script type="text/javascript">



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




  $.validator.addMethod("passwordregex", function(value, element, regexp) {

  return  this.optional(element) || regexp.test(value) ;

   // return   /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) &&  // consists of only these
   //      /[a-zA-Z]/.test(value) // has a lowercase letter
   //     && /\d/.test(value) // has a digit
}, "Password must be at least 8 characters long and a combination of uppercase, lowercase character, number.");


jQuery.validator.addMethod("dob_validate", function(value, element) {

        return this.optional(element) || moment(value,"MM-DD-YYYY",true).isValid();
    }, "Please enter a valid date in the format MM-DD-YYYY");

// first_name  last_name  phone  dob  password  confirm_password
  $().ready(function() {
    // validate the comment form when it is submitted


    $("#contact_form").validate({
      // onkeyup: function(element) {$(element).valid()},
      // onfocusout: function(element) {$(element).valid()},
   onfocusout: function(element) {$(element).valid(); },

  // onkeyup: function(element) {   // this enables onkeyup for password only
  //   var element_id = jQuery(element).attr('name');
  //   // alert(this.settings.rules[element_id].onkeyup);
  //   if ( this.settings.rules[element_id].onkeyup === true) {
  // // console.log(element);
  // $(element).valid();
  //   // $(arguments).valid(); // this is also working
  //     // jQuery.validator.defaults.onkeyup.apply(this, arguments);
  //   }

  // },
            rules : {
                first_name : {
                  // onkeyup: true,
                   required: true,

                },
                last_name : {
                   required: true,
                   // onkeyup: false,
                },
                password : {
                   required: false,
                   passwordregex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,
                    minlength : 8,
                    // onkeyup: true,

                },
                confirm_password : {
                  required: false,
                    equalTo : "#password",
                    // onkeyup: true,
                },
                 dob : {
                  dob_validate : true,
                  // onkeyup: false,
                 },
              phone: {
            required: true,
            number: true,
               minlength: 10,
               maxlength: 10
              }
            },
    messages: {

      confirm_password: "Passwords don't match",
      phone: "Phone number should be 10 numbers."


     },

        });


  });

</script>
