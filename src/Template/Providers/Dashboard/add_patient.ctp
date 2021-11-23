<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<div class="inner-wraper">
     <div class="row">
      <div class="col-md-12">
        <?= $this->Flash->render(); ?>
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Add Patient</h4>
          </div>
          <div class="card-body">

          <?php echo $this->Form->create($user, array('id'=>'addpatientform'));?>
          <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">First Name</label>
                                         <?php echo $this->Form->input("first_name" , array("type" => "text", "class" => "form-control",'title'=>'Enter First Name','label' => false,'required'));?>
                                    </div>
                                </div>

                                <div class="form-group form-float">

                                    <div class="form-line">
                                        <label class="form-label">Last Name</label>
                                         <?php echo $this->Form->input("last_name" , array("type" => "text", "class" => "form-control",'title'=>'Enter Last Name','label' => false,'required'));?>

                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                         <label class="form-label">Dob</label>
                                         <?php echo $this->Form->input("dob" , array("type" => "text","class" => "form-control",'title'=>'Enter Phone','label' => false,'required','id'=>'dob','readonly'));?>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                  <div class="form-line">
                                  <label class="form-label">Gender</label>
                                    <?php
                                     $gender = array( 1 => 'Male', 0 => 'Female', 2 => 'Other');
                                     echo $this->Form->select('gender', $gender, ['class' => 'form-control' , 'empty' => 'Select Gender' ,'required' => 'required','label' => false]); ?>
                                   </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Email</label>
                                         <?php echo $this->Form->input("email" , array("type" => "email","class" => "form-control",'title'=>'Enter Email','label' => false,'value' => isset($_POST['email']) ? $_POST['email'] : ""));?>
                                    </div>
                                </div>

                                 <div class="form-group form-float">
                                    <div class="form-line">
                                         <label class="form-label">Phone</label>
                                         <?php echo $this->Form->input("phone" , array("type" => "text","class" => "form-control",'title'=>'Enter Phone','label' => false, 'value' => isset($_POST['phone']) ? $_POST['phone'] : "")) ;?>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">MRN</label>
                                         <?php echo $this->Form->input("mrn" , array("type" => "text","class" => "form-control",'title'=>'Enter Mrn Number','label' => false));?>
                                    </div>
                                </div>

                              <div class="form-group form-float">
                                  <div class="form-line">
                                       <label class="form-label">Appointment Date</label>
                                       <?php echo $this->Form->input("appointment_date" , array("type" => "text","class" => "form-control appointmentdate",'title'=>'Enter Appointment Date','label' => false,'required','id'=>'appointmentdate','readonly'));?>
                                  </div>
                              </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                <label class="form-label">Select Doctor</label>
                                <?php
                                 echo $this->Form->select('doctor_id', $doctors, ['class' => 'form-control','empty' => 'Select Doctor','id' =>'doctor_id']); ?>
                                 </div>
                               </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                <label class="form-label">Appointment Reason</label>
                                <?php
                                 echo $this->Form->input('appointment_reason', array('class'=>'form-control','id' =>'appointment_reason','type' => 'select','label'=>false,'empty' => 'Select Appointment Reason')); 
                                 //echo $this->Form->select('appointment_reason',null, ['class' => 'form-control','empty' => 'Select Appointment Reason','id' =>'appointment_reason']); ?>
                                <!-- <select id="appointment_reason" name="appointment_reason" class="form-control"> -->

                                </select>
                                 </div>
                            </div>
             <div class="btns">
               <button class="btn btn-blue" type="submit">Save</button>
             </div>
            <?php echo $this->Form->end()?>
          </div>
         </div>
      </div>
     </div>
   </div>
<script>
$("#doctor_id").on('change', function(){
                     var doctor_id = $(this).val();
                     $.ajax({
                          type:'POST',
                          url: "<?php echo SITE_URL.'/providers/dashboard/getspecializationfordoctor'; ?>",
                          data:{doctor_id:doctor_id},

                          beforeSend: function (xhr) { // Add this line
                              xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                           },
                          success:function(res)
                          {
                            if(res){
                                    var res = JSON.parse(res);
                                    var options = '';
                                    options = '<option value="">Select Appointment Reason</option>';
                                    $.each(res, function(index, element) {
                                        options += '<option value="'+element+'">'+element+'</option>' ;
                                    });
                                    $('#appointment_reason').html(options) ;

                                    } else{
                                       $('#appointment_reason').html('<option value="">Select Appointment Reason</option>');
                                    }
                          },
                          error: function(e) {

                            window.location = "<?php echo SITE_URL.'/providers/'; ?>"
                          }
                       });
                })

$(document).ready(function(){
  var doctor_id = $('#doctor_id').val();
  var apt_rea ='<?php echo isset($user->appointment_reason) ?$user->appointment_reason:''; ?>'
  $.ajax({
                          type:'POST',
                          url: "<?php echo SITE_URL.'/providers/dashboard/getspecializationfordoctor'; ?>",
                          data:{doctor_id:doctor_id},

                          beforeSend: function (xhr) { // Add this line
                              xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                           },
                          success:function(res)
                          {
                            if(res){
                                    var res = JSON.parse(res);
                                    var options = '';
                                    options = '<option value="">Select Appointment Reason</option>';
                                    $.each(res, function(index, element) {
                                      if(apt_rea == element)
                                      {
                                        var sel ='selected';
                                      }
                                      else
                                      {
                                        var sel = '';
                                      }
                                        options += '<option value="'+element+'" '+sel+'>'+element+'</option>' ;
                                      
                                      
                                    });
                                    $('#appointment_reason').html(options) ;

                                    } else{
                                       $('#appointment_reason').html('<option value="">Select Appointment Reason</option>');
                                    }
                          },
                          error: function(e) {

                            window.location = "<?php echo SITE_URL.'/providers/'; ?>"
                          }
                       });
})
</script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script> 
<script type="text/javascript">
$(function() {
    $("#dob").datepicker({
        autoHide: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: "mm-dd-yy", // "dd-mm-yy",
        maxDate: new Date(),
        onClose: function() {
      $(this).focus().blur();
    },
    });
    $(".appointmentdate").datepicker({
        autoHide: true,
        changeMonth: true,
        changeYear: true,     
        dateFormat: "mm-dd-yy", // "dd-mm-yy",
        minDate: new Date(),
        onClose: function() {
      $(this).focus().blur();
    },
    }).on('change', function() {
        $(this).valid(); // triggers the validation test
    });

});
</script>
