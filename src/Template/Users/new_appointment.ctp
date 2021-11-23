<?php
use Cake\Core\Configure;
$iframe_prefix = Configure::read('iframe_prefix');
  $url = $this->request->getParam('pass');
  $session_user = $this->request->getSession()->read('Auth.User');
  /*$iframe_api_data = null;
$session = $this->request->getSession();
if ($session->check('iframe_api_data')) {

    $iframe_api_data  = $session->read('iframe_api_data');
}*/
//$iframe_prefix = Configure::read('iframe_prefix');
?>
<input type="hidden" class="timeinterval"/>
<link rel="stylesheet" type="text/css" href="<?= SITE_URL ?>css/jquery.datetimepicker.css"/>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="<?php echo WEBROOT.'frontend/js/new_appointment.js'; ?>"></script>

<script src="<?= SITE_URL ?>js/jquery.datetimepicker.js"></script>

<style type="text/css">

	.appointment_error{

		background: red;
	    padding: 15px;
	    margin-bottom: 10px
	}
</style>

<div class="wraper">
 <div class="inner_page_content">
  <div class="dashboard_content_bg">
   <div class="container">
    <div class="dashboard_content_inner">
    <?php if(empty($iframe_prefix)){ ?>
     <div class="dashboard_menu ">
      <ul>

	 <?php if(!empty($session_user) && $session_user['role_id'] == 2){ ?>

<!-- 	 	<li class="active">
		  <a href="<?= SITE_URL?>users/new-appointment/<?= $url[0] ?>">
		   <i></i>
		   <span id="new_apt_chnge" >Pre-appointment questionnaire</span>
		  </a>
		 </li>	

	 	<li>
	  <a href="<?= SITE_URL?>users/scheduled-appointments">
	   <i></i>
	   <span  id="prev_apt_chnge" >Scheduled Appointments</span>
	  </a>
	 </li>

	 <li>
	  <a href="<?= SITE_URL?>users/previous-appointment">
	   <i></i>
	   <span  id="prev_apt_chnge" >Previous Appointments</span>
	  </a>
	 </li>

	 <li>
	  <a href="<?= SITE_URL?>users/medicalhistory">
	   <i></i>
	   <span id="med_his_chnge">Edit Medical History</span>
	  </a>
	 </li> -->
	  <?php } ?>
	  </ul>
     </div>
    <?php } ?>

	 <div class="dashboard_content animated fadeInRight ">
	 		  <?= $this->Flash->render() ?>
	  <div class="dashboard_head">
	   <h2>Pre-appointment questionnaire</h2>
	  </div>
     	<?php echo $this->Form->create( null , array(   'autocomplete' => 'off',

							'inputDefaults' => array(
							'label' => false,
							'div' => false,

							),'enctype' => 'multipart/form-data', 'id' => 'login_form')); ?>

	  <div class="dashboard_appointments_box">
	  	<div>
	  		<p>Please select the doctor you are seeing today:</p>
	  	</div>
	   <div class="new_appointment_form">
	    <div class="row">
	    	<?php /*
		 <div class="col-md-6">
		  <div class="form-group form_fild_row">

			<select name="organization_id" class="form-control"  readonly disabled >
		    <option value="">Select Clinic </option>
		    <?php foreach ($org_list as $key => $value) {
		    ?>
		    <option <?php echo $login_user['organization_id'] == $key ? 'selected' : ''  ?> value="<?= $key ?>"><?= $value ?> </option>
			<?php } ?>
		   </select>

	      </div>
		 </div>
		 */ //pr($doctor_list);?>
		 <div class="col-md-6">
		  <div class="form-group form_fild_row">

			  	<select name="doctor_id" class="form-control" required="required">
			    <option value="">Select Doctor </option>
			    <?php foreach ($doctor_list as $key => $value) {
			    ?>
			    <option value="<?= base64_encode($key) ?>" <?php if(!empty($selected_doctor_data) && $selected_doctor_data['id'] == $key){ echo 'selected'; } ?>><?= $value ?> </option>
				<?php } ?>
			   </select>
		  </div>
		 </div>

		<div class="col-md-6" style="display: none;">
		  <div class="form-group form_fild_row">
	       <select id="specialization_id" name="specialization_id" class="form-control">
		    <option value="">Select Specialization</option>

		    <?php foreach ($specialization_list as $key => $value) {
		    ?>
		    <option value="<?= base64_encode($key)  ?>"><?= $value ?> </option>
			<?php } ?>
		   </select>
		  </div>
		 </div>


		</div>

		<div class="row">
			<?php /*
		 <div class="col-md-6">
		  <div class="form-group form_fild_row">
	       <select name="specialization_id" class="form-control" required="required">
		    <option value="">Select Specialization</option>

		    <?php foreach ($specialization_list as $key => $value) {
		    ?>
		    <option value="<?= $key ?>"><?= $value ?> </option>
			<?php } ?>
		   </select>
		  </div>
		 </div>
		 */ ?>
<?php /*   // date field commented as it not required according to client feedback doc 10th oct 18
		 <div class="col-md-6">
          <div class="form-group form_fild_row">
	       <!-- <input name="appointment_date" class="form-control" placeholder="Chief Complaint" type="text">  -->


    <input type="text" name="appointment_date"  placeholder="Appointment Date" class="form-control"   id="datetimepicker" required="required" />


  <script>

$('#datetimepicker').datetimepicker({
    	    changeMonth: true,
    changeYear: true,
  // dateFormat: "dd-mm-yy"
format: 'd-m-Y H:i',
// formatTime: 'H:i',
// formatDate: 'dd-mm-yy',


});

</script>



	      </div>
		 </div>
*/ ?>

		</div>

		<div class="form_submit_button">
	     <button type="submit" id="doctor_submit" class="btn waves-effect waves-light">Submit</button>
	    </div>

	   </div>
	  </div>

	  <?php $this->Form->end(); ?>

	 </div>
   	</div>
   </div>
  </div>
 </div>
</div>

<script type="text/javascript">


$(document).ready(function(){

	// alert($(window).width()) ;
	// console.log($(window).width()) ;
	// dashboard, appointment, summaries, medical history
	if($(window).width() < 700){

		$("#dash_chnge").html('dashboard');
		$("#new_apt_chnge").html('appointment');
		$("#prev_apt_chnge").html('summaries');
		$("#med_his_chnge").html('medical history');

	}

	// doctor_id specialization_id
	$( "#doctor_id" ).change(function() {
	   var doc_id = $(this).val() ;

            $.ajax({
                type: "GET",
                url: "<?php echo SITE_URL; ?>"+"/users/getspecializationfordoctor",
                data: {
                	// 'search_type' : 1, // 1 for searching medical  condition
                    'doc_id' : doc_id
                },
                dataType: "text",
                beforeSend:function(){
                	$('#doctor_submit').addClass('disabled');
                	$('#doctor_submit').html('<img src="<?php echo WEBROOT.'/images/spinner.gif'?>" width="31px">');
                },

                success: function(msg){

                	// alert(msg);
                	if(msg){
                	var msg = JSON.parse(msg);
                	var options = '';
                	$.each(msg, function(index, element) {
                		options += '<option value='+index+'>'+element+'</option>' ;
					});
					$('#specialization_id').html(options) ;

					} else{
				$('#specialization_id').html('<option value="">Select Specialization</option>');

					}
					$('#doctor_submit').removeClass('disabled');
					$('#doctor_submit').html('submit');
                    //we need to check if the value is the same

                }
            });
	});
});

$(document).ready(function(){

	var doc_id = $('#doctor_id').val();

	console.log(doc_id);

    $.ajax({
        type: "GET",
        url: "<?php echo SITE_URL; ?>"+"/users/getspecializationfordoctor",
        data: {
        	// 'search_type' : 1, // 1 for searching medical  condition
            'doc_id' : doc_id
        },
        dataType: "text",
        success: function(msg){
        	// alert(msg);
        	console.log(msg);
        	if(msg){
        	var msg = JSON.parse(msg);
        	var options = '';
        	$.each(msg, function(index, element) {
        		options += '<option value='+index+'>'+element+'</option>' ;
			});
			$('#specialization_id').html(options) ;
			} else{
		$('#specialization_id').html('<option value="">Select Specialization</option>');

			}
            //we need to check if the value is the same

        }
    });
})

</script>
