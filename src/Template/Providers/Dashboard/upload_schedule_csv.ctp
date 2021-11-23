<?php use Cake\I18n\Time;use Cake\Utility\Security; ?>
<section class="content">
  <div class="container-fluid provider_dashboard">
   <!-- Basic Examples -->
   <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="msgsuccess alert alert-success" style="display: none;">
      </div>

      <div class="msgerror alert alert-danger" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Error!</h3>
        <div class="error-body"></div>  
      </div>
      <?php echo $this->Flash->render(); ?>
      <div class="card">
        <div class="header">
          <div class="col-md-9">
            <h2 class="providers_header">
              <?php echo date('l F d, Y'); ?>
            </h2>
            <div style="display: flex;">

              <form id="upload_schedule_form" enctype="multipart/form-data" method="post">
                <a href="javascript:;" class="btn btn-primary" id="uploadcvsbtn">Upload Schedule <input type="file" name="csv_file" id="uploadcvs"></a>
                <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getParam('_csrfToken'); ?>"> 
                <!-- <input type="text" name="csv_file" id="uploadcvs"> -->

              </form>

              <form id="validate_csv_form" enctype="multipart/form-data" method="post" style="margin-left: 10px;">
                <a href="javascript:;" class="btn btn-primary" id="validate_csv_btn">Validate Excel/Csv<input type="file" name="excel_file" id="validate_cvs"></a>


                <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getParam('_csrfToken'); ?>"> 
              </form>
            </div>


          </div>
          <div class="col-md-3 text-right">
            <!-- <a href="<?php //echo SITE_URL.'providers/dashboard/send-all'; ?>" class="btn btn-primary">Send All</a> -->
            <a href="<?php echo SITE_URL.'providers/dashboard/remind-all'; ?>" class="btn btn-primary">Remind All</a>
          </div>
        </div>

        <div class="body">
          <!-- <div class="col-md-12"> -->
            <div class="table-responsive dashbord-stricky-header">


              <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                  <tr>

                    <?php if(isset($display_columns['appointment_time']) && $display_columns['appointment_time'] ==  1){ ?>

                      <th>Appointment Time</th>

                    <?php } ?>

                    <?php if(isset($display_columns['last_name']) && $display_columns['last_name'] ==  1){ ?>

                      <th>Last Name</th>

                    <?php } ?>

                    <?php if(isset($display_columns['first_name']) && $display_columns['first_name'] ==  1){ ?>

                      <th>First Name</th>

                    <?php } ?>

                    <?php if(isset($display_columns['gender']) && $display_columns['gender'] ==  1){ ?>

                      <th>Gender</th>

                    <?php } ?>

                    <?php if(isset($display_columns['dob']) && $display_columns['dob'] ==  1){ ?>

                      <th>DOB</th>

                    <?php } ?>

                    <?php if(isset($display_columns['mrn']) && $display_columns['mrn'] ==  1){ ?>

                      <th>MRN</th>

                    <?php } ?>

                    <?php if(isset($display_columns['email']) && $display_columns['email'] ==  1){ ?>

                      <th>Email Address</th>

                    <?php } ?>


                    <?php if(isset($display_columns['phone']) && $display_columns['phone'] ==  1){ ?>

                      <th>Phone Number</th>

                    <?php } ?>

                    <?php if(isset($display_columns['doctor_name']) && $display_columns['doctor_name'] ==  1){ ?>

                      <th>Doctor Name</th>

                    <?php } ?>

                    <?php if(isset($display_columns['appointment_date']) && $display_columns['appointment_date'] ==  1){ ?>

                     <th>Appointment Date</th>

                   <?php } ?>                                            

                   <?php if(isset($display_columns['appointment_reason']) && $display_columns['appointment_reason'] ==  1){ ?>

                     <th>Appointment Reason</th>

                   <?php } ?>

                   <th>Progress</th>


                   <!-- <th>created</th> -->
                   <!-- <th>modified</th> -->
                   <th><?= __('Actions') ?></th>
                 </tr>
               </thead>
               <tbody>
                <?php 

                $Cms = [];

                $i = 1;

                if(isset($schedule_data) && !empty($schedule_data)){ 

                  foreach ($schedule_data as $schedule):
                                         // pr($schedule);
                   ?>

                   <tr>

                    <?php if(isset($display_columns['appointment_time']) && $display_columns['appointment_time'] ==  1){ ?>

                      <?php $time  = !empty($schedule['appointment_time']) ? $schedule['appointment_time']: "";
                      $start_time = '';
                      if(!empty($time)){

                        $temp_time = explode('-',$time);
                        $start_time = isset($temp_time[1]) ? trim($temp_time[1]) : (isset($temp_time[0]) ? trim($temp_time[0]) : "");
                        $start_time = !empty($start_time) ? strtotime($start_time) : "";
                      }
                      ?>
                      <td><span style="display:none;"><?php echo $start_time; ?></span> <?= $time ?></td>

                    <?php } ?>

                    <?php if(isset($display_columns['last_name']) && $display_columns['last_name'] ==  1){ ?>

                     <td><?= !empty($schedule['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['last_name']),SEC_KEY) : ""  ?></td>

                   <?php } ?>

                   <?php if(isset($display_columns['first_name']) && $display_columns['first_name'] ==  1){ ?>

                    <td><?= !empty($schedule['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['first_name']),SEC_KEY) : "" ?></td>

                  <?php } ?>

                  <?php $gender = array(0 => 'Female',1=>'Male', 2=>'Other' ); if(isset($display_columns['gender']) && $display_columns['gender'] ==  1){ ?>

                    <td><?= !empty($schedule['user']['gender']) ? $gender[Security::decrypt(base64_decode($schedule['user']['gender']),SEC_KEY)] : "" ?></td>

                  <?php } ?>

                  <?php if(isset($display_columns['dob']) && $display_columns['dob'] ==  1){ ?>

                    <td><?= !empty($schedule['dob']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['dob']),SEC_KEY) : "" ?></td>

                  <?php } ?>

                  <?php if(isset($display_columns['mrn']) && $display_columns['mrn'] ==  1){ ?>

                    <td><?= !empty($schedule['mrn']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['mrn']),SEC_KEY) : "" ?></td>

                  <?php } ?>

                  <?php if(isset($display_columns['email']) && $display_columns['email'] ==  1){ ?>

                    <td><?= !empty($schedule['email']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['email']),SEC_KEY) : "" ?></td>

                  <?php } ?>

                  <?php if(isset($display_columns['phone']) && $display_columns['phone'] ==  1){ ?>

                    <td><?= !empty($schedule['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['phone']),SEC_KEY) : "" ?></td>

                  <?php } ?>

                  <?php if(isset($display_columns['doctor_name']) && $display_columns['doctor_name'] ==  1){ ?>

                   <td>
                    <?php if(!empty($schedule['doctor'])){

                      echo $schedule['doctor']['doctor_name'];
                    }
                    else{

                      echo !empty($schedule['doctor_name']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['doctor_name']),SEC_KEY) : "";
                    } 
                    ?>

                  </td>

                <?php } ?>

                <?php if(isset($display_columns['appointment_date']) && $display_columns['appointment_date'] ==  1){ ?>

                  <td><?= date('m/d/Y',strtotime($schedule['appointment_date']))?></td>

                <?php } ?>



                <?php if(isset($display_columns['appointment_reason']) && $display_columns['appointment_reason'] ==  1){ ?>

                 <td><?= !empty($schedule['appointment_reason']) ? $this->CryptoSecurity->decrypt(base64_decode($schedule['appointment_reason']),SEC_KEY) : "" ?></td>

               <?php } ?>


               <td>
                <?php if($schedule['status'] == 0){

                  echo '-';
                }
                elseif($schedule['status'] == 1){
                  $title = $schedule["stage"] ? $schedule["stage"] :"Form sent but not started";
                  echo '<a href="javascript:;" class="bg-red pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="'.$title.'"><i class="fas fa-times red-close"></i></a>';
                }elseif($schedule['status'] == 2){

                  echo '<a href="javascript:;" class="bg-orange pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="'.$schedule["stage"].'"><i class="fas fa-exclamation-triangle orange-warning"></i></a>';

                }elseif($schedule['status'] == 3){

                  echo '<a href="javascript:;" class="bg-green pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Form completed"><i class="fas fa-check blue-check"></i></a>';
                }
                ?>
              </td>

              <td class="actions">

               <div class="btn-groups dropdown">
                <a href="javascript:;" class="btn btn-round" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                                                                                      //button for telehealth appontment
                            $login_user_data = $this->request->getSession()->read('Auth.User');

                            if(!empty($login_user_data)){

                              if($this->General->checkTelehealthAppointmentData($login_user_data['id'], $login_user_data['organization_id'], $schedule))
                                { ?>
                                  <a href = 'javascript:;' data-schedule_id ="<?php echo $schedule['id']; ?>" id="telehealth-appt-<?php echo $schedule['id']; ?>" class=" bg-green telehealth-appt dropdown-item" style="margin:1px;"><i class="fas fa-video"></i>Start Telehealth Appointment</a>

                                  <?php if(!empty($schedule['email']) || !empty($schedule['phone'])){ 


                                   echo  $this->Html->link('<i class="fas fa-envelope"></i>Send Telehealth Appointment Time Reminder', ['action' => 'sendMail', $schedule->id, 0, 'telehealth'],['escape' => false,'class' => 'bg-green dropdown-item','style' => 'margin:1px;']);

                                 }
                               } 
                             }

                             if($schedule['status'] != 3){

                              if(!empty($schedule['user_id'])){ ?>

                                <a  href = 'javascript:;' data-url="<?php echo SITE_URL.'providers/dashboard/fill-appointment-form/'.base64_encode($schedule['user_id']).'/'.base64_encode($schedule->id); ?>" class="bg-green open-patient-panel dropdown-item" style="margin:1px;" title="Fill Pre-Appointment Form"><i class="fas fa-receipt"></i>Fill Pre-Appointment Form</a>
                              <?php }
                              else{

                                $is_registered = $this->General->is_registered($schedule);

                                if($is_registered){
                                  ?>

                                  <a  href = 'javascript:;' data-url="<?php echo SITE_URL.'providers/dashboard/fill-appointment-form/'.base64_encode($is_registered->id).'/'.base64_encode($schedule->id); ?>" class="bg-green open-patient-panel dropdown-item" style="margin:1px;" title="Fill Pre-Appointment Form"><i class="fas fa-receipt"></i>Fill Pre-Appointment Form</a>

                                <?php }

                                else{ ?>

                                  <a href="javascript:;" data-url="<?php echo SITE_URL.'users/register-front-user/'.base64_encode($schedule->id.'-P'); ?>" class="bg-gray open-patient-panel dropdown-item" style="margin:1px;"><i class="far fa-user"></i>Register User</a>                                                          

                                  <a href="javascript:;" class="bg-red dropdown-item" style="margin:1px;" id="loginAndRegister" data-schedule_id = "<?php echo base64_encode($schedule->id); ?>"><i class="fas fa-home"></i>Register And Login User</a> 

                                <?php }

                              }
                            }
                            ?>


                            <?php if($schedule['status'] == 0 && (!empty($schedule['email']) || !empty($schedule['phone']))){ ?>

                              <?= $this->Html->link('<i class="fas fa-envelope"></i>Send Pre-Appointment Form Link', ['action' => 'sendMail', $schedule->id],['escape' => false,'class' => 'bg-blue dropdown-item','style' => 'margin:1px;']) ?>

                            <?php  } ?>

                            <?php if(($schedule['status'] == 1 || $schedule['status'] == 2) && (!empty($schedule['email']) || !empty($schedule['phone']))){ ?>                                      

                              <?= $this->Html->link('<i class="fas fa-sync-alt"></i>Send Pre-Appointment Form Reminder', ['action' => 'sendMail',$schedule->id,1],['escape' => false,'class' => ' bg-orange dropdown-item','style' => 'margin:1px;']) ?>

                            <?php  } ?>

                            <?php if($schedule['status'] == 3){ ?>

                              <?php if($user->note_formating == 'full'){ ?>

                               <a href="javascript:;" class="bg-green view_ipc dropdown-item" style="margin:1px;" data-schedule_id = "<?php echo $schedule['id']; ?>"><i class="far fa-dot-circle"></i>iPatientCare</a>

                             <?php } else{ ?>

                              <a href="javascript:;" class="bg-black view_note dropdown-item" style="margin:1px;"  data-schedule_id = "<?php echo $schedule['id']; ?>"><i class="fas fa-eye"></i>View Note</a>

                            <?php } ?>



                            <a href="javascript:;" class="bg-blue copy_note dropdown-item" style="margin:1px;"  id="copy_schedule" data-schedule_id = "<?php echo $schedule['id']; ?>"><i class="fas fa-paperclip"></i>Copy Note</a>



                            <a href="javascript:;" class="bg-orange print_pdf dropdown-item" style="margin:1px;" data-schedule_id="<?php echo $schedule->id; ?>"><i class="fas fa-print"></i>Print Pdf</a>

                          <?php  } ?>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php  $i++; endforeach; ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <!-- </div> -->

  </div>

</div>

</section>
<style type="text/css">
 .msgsuccess{ display: none; margin-left: 10px;
  text-align: center;
  background: green;
  padding: 8px;
}
.note_view_model{

  max-width: 70% !important;
}
</style>

