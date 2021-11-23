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
	  <h3>Interested User</h3>
	  <div class="seprator"></div>
	 </div>
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create($InterestedUser , array(

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'interest_form')); ?>

              <?php if(!empty($zipcode)){ ?>
                <input type="hidden" name="zipcode" value="<?php echo $zipcode;?>">
                <?php } ?>
            	 <div class="form_fild_content row">
            	  <div class="col-md-6 ">
                 <div class="form-group form_fild_row">
                    <?php echo  $this->Form->control('email', ['type' => 'email', 'class' => 'form-control','label' => 'Email Address', 'autocomplete' => 'off', 'required' => 'required','value' =>!empty($schedule_data['email']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule_data['email']),SEC_KEY) :"",'readonly' => !empty($schedule_data['email'])?true:false]); ?>
                 </div>
            	   <div class="form_submit_button">
            	    <button type="submit" class="btn">Notify Me When I'm eligible</button>
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
<script>
  $().ready(function() {
    // validate the comment form when it is submitted
    $("#interest_form").validate({      
      onfocusout: function(element) {$(element).valid()},
            rules : {
                email : {
                   required: true,
                  }
            },
     messages: {
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
