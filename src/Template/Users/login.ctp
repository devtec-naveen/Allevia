<?php
use Cake\Core\Configure;
$iframe_prefix = Configure::read('iframe_prefix');
 ?>
<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
	 <div class="TitleHead">
	  <h3>Login</h3>
	  <div class="seprator"></div>
	 </div> 
	 <?php //echo $rememberme_cookie["email"];die;  ?>
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create( null , array(   'autocomplete' => 'off', 
										
							'inputDefaults' => array(
							'label' => false,
							'div' => false,
											
							),'enctype' => 'multipart/form-data', 'id' => 'login_form')); ?>   	 
	 <div class="form_fild_content row">
	  <div class="col-md-6">
	   <div class="form-group form_fild_row"> 
	      <?php echo  $this->Form->control('email', ['type' => 'text', 'value' => (isset($rememberme_cookie["email"]) ? $this->CryptoSecurity->decrypt(base64_decode($rememberme_cookie["email"]),SEC_KEY) : '' )  , 'class' => 'form-control', 'placeholder' => 'Email Id', 'label' => 'Email', 'autocomplete' => 'off', 'required' => 'required']); ?>	    
	   </div>
       
	   <div class="form-group form_fild_row">

	      <?php echo  $this->Form->control('password', ['type' => 'password',  'value' => (isset($rememberme_cookie["password"]) ? $rememberme_cookie["password"] : '' )  ,  'class' => 'form-control', 'placeholder' => 'Password', 'label' => 'Password', 'autocomplete' => 'off', 'required' => 'required']); ?>		    
	   </div>	   
	   
	   <div class="remember_me_box">
	    <div class="custom-control custom-checkbox">
         <!-- <input type="checkbox" name="rememberme" class="custom-control-input" id="defaultUnchecked"> -->
         <?php echo $this->Form->checkbox('rememberme', ['hiddenField' => true, 'class' => 'custom-control-input', 'id' => 'defaultUnchecked','checked'=>(!empty($rememberme_cookie["rememberme"]) ? $rememberme_cookie["rememberme"] : '' )]); ?>
         <label class="custom-control-label" for="defaultUnchecked">Remember Me</label>
        </div>
	   </div>
<?php 
if(isset($login_attempt) && $login_attempt > 2) {

	?>

<div class="form-group form_fild_row"> 
<!-- <div class="g-recaptcha" data-sitekey="6LejgogUAAAAAImgVcAUoiBCU78T0mnGCo0icWXb"></div> -->
<div class="g-recaptcha" data-sitekey="<?= CAPTCHA_KEY ?>"  data-callback="recaptchaCallback"></div>
<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
     </div>
<?php } ?>	   
	   <div class="form_submit_button">
	    <button type="submit" class="btn">Login</button>
	   </div>
	   
	   <div class="forgot_password_box">
	    <a href="<?= SITE_URL.(!empty($iframe_prefix) ? $iframe_prefix.'/': '').'users/forgotpassword' ?>">Forgot Password ?</a>
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
  
  /*$.validator.addMethod("email", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
            }, "Please enter a valid email address.");*/
  $().ready(function() {
    // validate the comment form when it is submitted
    $("#login_form").validate( {
      //ignore: ":hidden:not(.hiddenRecaptcha)", // validating recaptcha hidden input 


            rules : {
             
  				/*hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            } */          
            },

    } );

  }); 



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