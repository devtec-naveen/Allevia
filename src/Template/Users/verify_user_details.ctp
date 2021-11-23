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
	  <h3>Verify Details</h3>
	  <div class="seprator"></div>
	 </div>
	 	  <?= $this->Flash->render() ?>
     	<?php echo $this->Form->create(null , array(

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
	      <?php echo  $this->Form->control('first_name', ['type' => 'text', 'class' => 'form-control','label' => "First Name", 'autocomplete' => 'off', 'required' => true]); ?>
	     </div>
        </div>

		<div class="col-md-6">
	     <div class="form-group form_fild_row">
	      <?php echo  $this->Form->control('last_name', ['type' => 'text', 'class' => 'form-control','label' => 'Last Name', 'autocomplete' => 'off', 'required' => true]); ?>
	     </div>
	    </div>
	   </div>

	   <div class="form-group form_fild_row">

	      <?php echo  $this->Form->control('dob', ['type' => 'text', 'class' => 'form-control','label' => 'Date Of Birth',  'id'=>'datetimepicker1', 'autocomplete' => 'off', 'required' => true]); ?>
	   </div>

	   <div class="form_submit_button">
	    <button type="submit" class="btn">Submit</button>	    
	   </div>
	   <div>
	   	<p style="font-size: 14px;color: gray;">
	    This form may take 5-15 minutes to complete. Any answers will be automatically saved
	    </p>
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
  $( function() 
  {
    $( "#datetimepicker1" ).datepicker(
    {
      changeMonth: true,
      changeYear: true,
      yearRange: "-100:+0",
      dateFormat: "yy-mm-dd" , // "dd-mm-yy",
      maxDate: new Date()
    }).on('change', function() 
    {
        $(this).valid();
    });
  });
  </script>

<style type="text/css">
  input[readonly] {
    background-color: #fff !important;
}
</style>
