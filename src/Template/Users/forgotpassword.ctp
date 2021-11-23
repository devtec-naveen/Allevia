	
<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
	 <div class="TitleHead">
	  <h3>Forgot Password</h3>
	  <div class="seprator"></div>
	 </div> 
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create(null , array(   'autocomplete' => 'off', 
										
							'inputDefaults' => array(
							'label' => false,
							'div' => false,
											
							),'enctype' => 'multipart/form-data', 'id' => 'forgot_form')); ?>    	 
	 <div class="form_fild_content row">
	  <div class="col-md-6">
	   <div class="form-group form_fild_row"> 
	<?php echo  $this->Form->control('email', ['type' => 'text', 'class' => 'form-control', 'placeholder' => 'Email ID', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>	

	   </div>


<div class="form-group form_fild_row"> 
<!-- <div class="g-recaptcha" data-sitekey="6LejgogUAAAAAImgVcAUoiBCU78T0mnGCo0icWXb"></div> -->
<div class="g-recaptcha" data-sitekey="<?= CAPTCHA_KEY ?>"  data-callback="recaptchaCallback"></div>
<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
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
  /*$.validator.addMethod("email", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
            }, "Please enter a valid email address.");*/

  $().ready(function() {
    // validate the comment form when it is submitted
    $("#forgot_form").validate( {
      ignore: ":hidden:not(.hiddenRecaptcha)", // validating recaptcha hidden input 


            rules : {
             
              hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            }           
            },

    } );

  }); 


// remove validation error mesage on recaptcha validate 
function recaptchaCallback() {
  $('#hiddenRecaptcha').valid();
};

</script>



<!-- circle chart demo --> 
<!--          circle chart related code for dashboard allevia
<div class="circle" id="circles-1"></div>

<script type="text/javascript" src="<?php echo WEBROOT ?>js/circles.min.js"></script>   
<script type="text/javascript">
	

var myCircle = Circles.create({
  id:                  'circles-1',
  radius:              40,
  value:               43,
  maxValue:            100,
  width:               5,
  text:                function(value){return value ;},
  colors:              ['#f2f2f2', '#00ffcc'],
  duration:            400,
  wrpClass:            'circles-wrp',
  textClass:           'circles-text',
  valueStrokeClass:    'circles-valueStroke',
  maxValueStrokeClass: 'circles-maxValueStroke',
  styleWrapper:        true,
  styleText:           true
});


</script>
-->
<!-- circle chart demo --> 