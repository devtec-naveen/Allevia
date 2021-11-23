<div class="inner-wraper">
   <?php $i = 0;?>
   <div class="row">
      <div class="col-md-12">
         <?= $this->Flash->render() ?>
         <div class="card">
            <div class="card-header d-flex">
               <h4 class="header-title mt-2 mr-5">Automated Reminder Settings</h4>
            </div>
            <div class="card-body">
               <?php echo $this->Form->create(null, array('id'=>'edit_organizations','enctype'=>'multipart/form-data')); ?>
               <div class="form-group form-float">
                  <div>                              
                     <label class="form-label">
                     <span><strong>Patient intake settings</strong></span>
                     </label>    
                  </div>
               </div>
               <!--  <div class="custom-control custom-checkbox">

                              <input name="shots_history[223][shot_id]" value="223" class="custom-control-input check_had_shot" id="shotid223" type="checkbox" style="cursor: pointer;">
                              <label class="custom-control-label" for="shotid223">I've had this shot.</label>
                             </div> -->
               <div class="form-group form-float">
                  <div class="custom-control custom-checkbox">
                     <?php echo $this->Form->checkbox('patient_intake_cvs_upload_reminder', ['id' => 'patient_intake_cvs_upload_reminder','class' =>'custom-control-input check_had_shot','value'=>'1','hiddenField' => false, $global_settings['patient_intake_cvs_upload_reminder'] == 1 ? 'checked' : '']); ?>
                     <label for="patient_intake_cvs_upload_reminder" class="custom-control-label">Automatically send a reminder when the schedule data is uploaded</label>    
                  </div>
               </div>
               <div class="form-group form-float">
                  <div class="custom-control custom-checkbox">
                     <?php echo $this->Form->checkbox('patient_intake_before_appointment_reminder', ['id' => 'patient_intake_before_appointment_reminder','class' =>'custom-control-input check_had_shot','value'=>'1','hiddenField' => false, $global_settings['patient_intake_before_appointment_reminder'] == 1 ? 'checked' : '']); ?>
                     <label for="patient_intake_before_appointment_reminder" class="custom-control-label">Automatically send a reminder x minutes before the appointment</label>    
                  </div>
               </div>
               <div class="form-group form-float">
                  <div class="form-line">
                    <label class="form-label">x minutes (time before appointment for reminder)</label>
                     <?php echo $this->Form->input("patient_intake_before_appointment_reminder_time" , array("type" => "text", "class" => "form-control",'title'=>'Enter x minutes (time before appointment for reminder)','data-msg-required'=>'Enter x minutes (time before appointment for reminder)','label' => false, 'value'  => $global_settings->patient_intake_before_appointment_reminder_time));?>
                     
                  </div>
               </div>
               <div class="form-group form-float">
                  <div>                              
                     <label class="form-label">
                     <span><strong>Telehealth settings</strong></span>
                     </label>    
                  </div>
               </div>
               <div class="form-group form-float">
                  <div class="custom-control custom-checkbox">
                     <?php echo $this->Form->checkbox('telehealth_cvs_upload_reminder', ['id' => 'telehealth_cvs_upload_reminder','value'=>'1', 'class' =>'custom-control-input check_had_shot','hiddenField' => false, $global_settings['telehealth_cvs_upload_reminder'] == 1 ? 'checked' : '']); ?>
                     <label for="telehealth_cvs_upload_reminder" class="custom-control-label">Automatically send a reminder when the schedule data is uploaded</label>    
                  </div>
               </div>
               <div class="form-group form-float">
                  <div class="custom-control custom-checkbox">
                     <?php echo $this->Form->checkbox('telehealth_before_appointment_reminder', ['id' => 'telehealth_before_appointment_reminder','value'=>'1','class' =>'custom-control-input check_had_shot','hiddenField' => false, $global_settings['telehealth_before_appointment_reminder'] == 1 ? 'checked' : '']); ?>
                     <label for="telehealth_before_appointment_reminder" class="custom-control-label">Automatically send a reminder x minutes before the appointment</label>    
                  </div>
               </div>
               <div class="form-group form-float">
                  <div class="form-line">
                    <label class="form-label">x minutes (time before appointment for reminder)</label>
                     <?php echo $this->Form->input("telehealth_appointment_reminder_time" , array("type" => "text", "class" => "form-control",'title'=>'Enter x minutes (time before appointment for reminder)','data-msg-required'=>'Enter x minutes (time before appointment for reminder)','label' => false, 'value'  => $global_settings->telehealth_appointment_reminder_time));?>                     
                  </div>
               </div>
               <div class="btns">               
                  <button class="btn btn-blue" type="submit">Submit</button>                   
               </div>
               <?php echo $this->Form->end()?>
            </div>
         </div>
      </div>
   </div>
   <?php $i++; ?> 
</div>

