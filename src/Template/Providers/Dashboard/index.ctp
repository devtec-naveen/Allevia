
<?php use Cake\I18n\Time;
    use Cake\I18n\Date;
    use Cake\Utility\Security;

  $session = $this->request->getSession();
  $login_user_data = $session->read('Auth.User');

  $is_start_tour = $user['is_start_tour'];  
  $is_telehealth_provider = $this->General->is_telehealth_provider($login_user_data['id']);
  $timezone = $this->General->getProviderTimezone($login_user_data['id']);
  //echo $timezone;die;

  $current_date = new \DateTime("now", new \DateTimeZone($timezone) );
  $current_date = $current_date->format('l F d, Y h:i:s A');
  $current_date = strtotime($current_date)+3600;
  $current_date = date('l F d, Y',$current_date); //
 ?>
   <div class="inner-wraper provider_dashboard">
     <div class="row">
      <div class="col-md-12">
        <div class="msgsuccess alert alert-success" style="display: none;">
        </div>

        <div class="msgerror alert alert-danger" style="display: none;">
          <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3>Error!</h3>
          <div class="error-body"></div>
        </div>

        <?php echo $this->Flash->render(); ?>
        <div class="card">

          <div class="card-header">
   <div class="row">
    <div class="col-md-6 d-flex">
            <h4 class="header-title mt-2 mr-3"><?php echo $current_date; ?></h4>

            <div class="btn-groups mr-auto">
              <div style="display: flex;">
              <form id="upload_schedule_form" enctype="multipart/form-data" method="post">
                  <a href="javascript:;" class="btn btn-blue mr-1" id="uploadcvsbtn" data-toggle="tooltip" title="Upload exported EHR schedule" data-placement="bottom">Upload Schedule <input type="file" name="csv_file" id="uploadcvs"></a>
                  <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getParam('_csrfToken'); ?>">
              </form>

              <form id="validate_csv_form" enctype="multipart/form-data" method="post" style="margin-left: 5px;">
                  <a href="javascript:;" class="btn btn-blue-border" id="validate_csv_btn" data-toggle="tooltip" title="Validate schedule errors" data-placement="bottom">Validate Excel/Csv<input type="file" name="excel_file" id="validate_cvs"></a>
                   <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getParam('_csrfToken'); ?>">
              </form>
               <a href="javascript:;" class="" data-placement="bottom" id="ml-auto"></a>

               </div>


            </div>  
          </div>  
          <div class="col-md-1">
            <div id="middledashboard"></div>          
          </div>
          <div class="col-md-5">
            <div class="record-sec">
              <div class="ml-auto">

                <?php if($is_telehealth_provider){ ?>
                  <a href="<?php echo SITE_URL.'providers/dashboard/telehealth-records'; ?>" class="btn btn-blue" data-toggle="tooltip" title="Get all telehealth records" data-placement="bottom">Telehealth Records</a>

                <?php } ?>

                <a href="javascript:;" class="btn btn-blue remind-all" data-toggle="tooltip" title="Send email and text reminders" data-placement="bottom" id="remind-all">Remind All</a>
                <a href="<?php echo SITE_URL.'providers/dashboard/add-patient'; ?>" class="btn btn-blue" data-toggle="tooltip" title="Add patient & schedule appointment" data-placement="bottom" id="add-patient" >Add Patient</a>
                
              </div>
            </div>
          </div>
        </div>
          </div>

          <div class="card-body">
             <div class="table-box mt-4 table-responsive dashbord-stricky-header">
                  <table id="example" class="table table-striped table-hover js-basic-example">
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

                                                  <th>Doctor</th>

                                            <?php } ?>

                                            <?php if(isset($display_columns['appointment_date']) && $display_columns['appointment_date'] ==  1){ ?>

                                                   <th>Appointment Date</th>

                                            <?php } ?>

                                            <?php if(isset($display_columns['appointment_reason']) && $display_columns['appointment_reason'] ==  1){ ?>

                                                   <th>Appointment Reason</th>

                                            <?php } ?>

                                             <th>Progress</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                  </thead>
                  <tbody>
                    <?php

                                        $Cms = [];

                                        $i = 1;

                                         if(isset($schedule_data) && !empty($schedule_data)){

                                        foreach ($schedule_data as $schedule):
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
                                              echo '<a href="javascript:;" class="bg-red pointer" style="margin:1px;"  data-toggle="tooltip" title="'.$title.'" data-placement="bottom"><i class="fas fa-times red-close"></i></a>';
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
                                            <!--   <a class="dropdown-item" href="#"><i class="fas fa-sticky-note"></i> View Note</a>
                                              <a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Copy Note</a>
                                              <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Print PDF</a> -->

                                        <?php


                                              if(!empty($login_user_data)){

                                                if($this->General->checkTelehealthAppointmentData($login_user_data['id'], $login_user_data['organization_id'], $schedule))
                                                { ?>
                                                    <a href='javascript:;' data-schedule_id ="<?php echo $schedule['id']; ?>" id="telehealth-appt-<?php echo $schedule['id']; ?>" class=" bg-green telehealth-appt dropdown-item" style="margin:1px;"><i class="fas fa-video"></i>Start Telehealth Appointment</a>


                                          <?php
                                                  if(!empty($schedule['email']) || !empty($schedule['phone'])){

                                                      echo  $this->Html->link('<i class="fas fa-envelope"></i>Send Telehealth Appointment Time Reminder', ['action' => 'sendMail', $schedule->id, 0, 'telehealth'],['escape' => false,'class' => 'bg-green dropdown-item',]);
                                                 }

                                                }
                                              }

                                              if($schedule['status'] != 3){

                                                if(!empty($schedule['user_id'])){ ?>

                                                    <a  href = 'javascript:;' data-url="<?php echo SITE_URL.'providers/dashboard/fill-appointment-form/'.base64_encode($schedule['user_id']).'/'.base64_encode($schedule->id); ?>" class="bg-green dropdown-item open-patient-panel" style="margin:1px;"><i class="fas fa-receipt"></i>Fill Pre-Appointment Form</a>
                                            <?php }
                                                  else{

                                                        $is_registered = $this->General->is_registered($schedule);

                                                        if($is_registered){
                                                        ?>

                                                         <a  href = 'javascript:;' data-url="<?php echo SITE_URL.'providers/dashboard/fill-appointment-form/'.base64_encode($is_registered->id).'/'.base64_encode($schedule->id); ?>" class="bg-green open-patient-panel dropdown-item" style="margin:1px;"><i class="fas fa-receipt"></i>Fill Pre-Appointment Form</a>

                                                  <?php }

                                                      else{ ?>


                                                          <a href="javascript:;" data-url="<?php echo SITE_URL.'users/preceding-signup/'.base64_encode($schedule->id.'-P'); ?>" class="bg-gray open-patient-panel dropdown-item" style="margin:1px;"><i class="far fa-user"></i>Register User</a>

                                                           <a href="javascript:;" class="bg-red dropdown-item" style="margin:1px;"  id="loginAndRegister" data-schedule_id = "<?php echo base64_encode($schedule->id); ?>"><i class="fas fa-home"></i>Register And Login User</a>
                                                       <?php
                                                     }
                                                    }
                                                }
                                            ?>


                                        <?php if($schedule['status'] == 0 && (!empty($schedule['email']) || !empty($schedule['phone']))){ ?>

                                          <?= $this->Html->link('<i class="fas fa-envelope"></i>Send Pre-Appointment Form Link', ['action' => 'sendMail', $schedule->id],['escape' => false,'class' => 'bg-blue dropdown-item','style' => 'margin:1px;']) ?>

                                      <?php  } ?>

                                      <?php if(($schedule['status'] == 1 || $schedule['status'] == 2) && (!empty($schedule['email']) || !empty($schedule['phone']))){ ?>

                                            <?= $this->Html->link('<i class="fas fa-sync-alt"></i>Send Pre-Appointment Form Reminder ', ['action' => 'sendMail',$schedule->id,1],['escape' => false,'class' => 'bg-orange dropdown-item','style' => 'margin:1px;']) ?>


                                      <?php  } ?>

                                      <?php if($schedule['status'] == 3){ ?>

                                            <?php if($user->note_formating == 'full'){ ?>

                                                 <a href="javascript:;" class="bg-green view_ipc dropdown-item" style="margin:1px;" data-schedule_id = "<?php echo $schedule['id']; ?>"><i class="far fa-dot-circle"></i>iPatientCare</a>

                                            <?php } else{ ?>

                                              <a href="javascript:;" class="bg-black view_note dropdown-item" style="margin:1px;" data-schedule_id = "<?php echo $schedule['id']; ?>"><i class="fas fa-eye"></i>View Note</a>

                                            <?php } ?>



                                          <a href="javascript:;" class="bg-blue copy_note dropdown-item" style="margin:1px;" id="copy_schedule" data-schedule_id = "<?php echo $schedule['id']; ?>"><i class="fas fa-paperclip"></i>Copy Note</a>



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
     </div>
   </div>



    <style type="text/css">
     /*.msgsuccess{ display: none; margin-left: 10px;
              text-align: center;
              background: green;
              padding: 8px;
        } */
       .note_view_model{
          max-width: 70% !important;
       }
   </style>

<div id="myModal" class="modal fade share_link_bg" role="dialog">
   <div class="modal-dialog note_view_model">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Schedule Note</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

         </div>
         <div class="modal-body">
          <!--  <span class="msgsuccess" style="color: green;">Copied successfully</span> -->

           <!-- <div class="text-right" style="margin-bottom: 10px;">
              <button  id=""  class=" btn btn-primary waves-effect waves-light copy_schedule">Copy Note</button>
            </div>
            <div class="copy_link_box">

            </div> -->

            <div class="patient_em_detail_section">

            <div class="em_detail_header d-flex">
              <h4>E/M Details</h4>

                <button  id=""  class="btn btn-blue copy_em_detail" data-model_id = 'myModal'>Copy E/M Details</button>


            </div>
            <div class="em_copy_link_box">

            </div>

          </div>

            <div class="patient_basic_detail_section">

            <div class="basic_detail_header d-flex">
              <h4>Basic Details</h4>

                <button  id=""  class="btn btn-blue copy_schedule">Copy Basic Details</button>


            </div>
            <div class="copy_link_box">

            </div>

          </div>

            <div class="patient_soapp_detail_section">

            <div class="soapp_detail_header d-flex">
              <h4>SOAPP-R Details</h4>

                <button  id=""  class="btn btn-blue copy_soapp_detail" data-model_id = 'myModal'>Copy SOAPP-R Details</button>


            </div>
            <div class="soapp_copy_link_box">

            </div>

          </div>

          <div class="patient_comm_detail_section">

            <div class="comm_detail_header d-flex">
              <h4>COMM Details</h4>

                <button  id=""  class="btn btn-blue copy_comm_detail" data-model_id = 'myModal'>Copy COMM Details</button>


            </div>
            <div class="comm_copy_link_box">

            </div>

          </div>

          <div class="patient_dast_detail_section">

            <div class="dast_detail_header d-flex">
              <h4>DAST-10 Details</h4>

                <button  id=""  class="btn btn-blue copy_dast_detail" data-model_id = 'myModal'>Copy DAST-10 Details</button>


            </div>
            <div class="dast_copy_link_box">

            </div>

          </div>


         </div>
      </div>
   </div>
</div>



<div id="ipc_model" class="modal fade share_link_bg" role="dialog">
   <div class="modal-dialog note_view_model">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">iPatientCare</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

         </div>
         <div class="modal-body">
          <div class="loader">

          </div>

          <div class="patient_em_detail_section">

            <div class="em_detail_header d-flex">
              <h4>E/M Details</h4>

                <button  id=""  class="btn btn-blue copy_em_detail" data-model_id = 'ipc_model'>Copy E/M Details</button>


            </div>
            <div class="em_copy_link_box">

            </div>

          </div>

          <!--  <span class="msgsuccess" style="color: green;">Copied successfully</span> -->
          <div class="patient_basic_detail_section">

            <div class="basic_detail_header d-flex">
              <h4>Basic Details</h4>

              <button  id=""  class="btn btn-blue copy_basic_detail">Copy Basic Details</button>

            </div>
            <div class="basic_copy_link_box">

            </div>

          </div>

          <div class="patient_medical_detail_section">

            <div class="medical_detail_header d-flex">
              <h4>Medical Details</h4>

                <button  id=""  class="btn btn-blue copy_medical_detail">Copy Medical Details</button>


            </div>
            <div class="medical_copy_link_box">

            </div>

          </div>

          <div class="patient_soapp_detail_section">

            <div class="soapp_detail_header d-flex">
              <h4>SOAPP-R Details</h4>

                <button  id=""  class="btn btn-blue copy_soapp_detail" data-model_id = 'ipc_model'>Copy SOAPP-R Details</button>


            </div>
            <div class="soapp_copy_link_box">

            </div>

          </div>

          <div class="patient_comm_detail_section">

            <div class="comm_detail_header d-flex">
              <h4>COMM Details</h4>

                <button  id=""  class="btn btn-blue copy_comm_detail" data-model_id = 'ipc_model'>Copy COMM Details</button>


            </div>
            <div class="comm_copy_link_box">

            </div>

          </div>

          <div class="patient_dast_detail_section">

            <div class="dast_detail_header d-flex">
              <h4>DAST-10 Details</h4>

                <button  id=""  class="btn btn-blue copy_dast_detail" data-model_id = 'ipc_model'>Copy DAST-10 Details</button>


            </div>
            <div class="dast_copy_link_box">

            </div>

          </div>

          <!-- <div class="patient_other_detail_section">

            <div class="other_detail_header d-flex">
              <h4>Other Details</h4>

                <button  id=""  class="btn btn-primary waves-effect waves-light copy_other_detail">Copy Other Details</button>


            </div>
            <div class="other_copy_link_box">

            </div>

          </div> -->


         </div>
      </div>
   </div>
</div>


<!-- Modal -->
<div class="modal fade share_link_bg" id="validate_csv_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog note_view_model" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Validation of Excel/Csv Result</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="loader">

        </div>
        <div class="validation_result">

        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal fade share_link_bg" id="walkthrough" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog note_view_model" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Provider Panel user walkthrough</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <h3>Dashboard</h3>
         <h6 id="upload-schedule">1.Upload Schedule</h6>
         <p>Upload the patient schedule excel here.</p>
      </div>
    </div>
  </div>
</div>

<style type="text/css">


  #basicExampleAddNewGroup .modal-content,#reminder-to-all .modal-content{

    height: auto;
  }

  #basicExampleAddNewGroup .patient_gender,#reminder-to-all .patient_gender{

    color: #fff;
    background: #103394;
    margin-right: 15px;
  }


</style>

<div class="modal fade delivery-modal" id="basicExampleAddNewGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel4">Patient Gender</h5>
         </div>

         <div class="modal-body">
            <div class="form-group form_fild_row">
                <select name="gender" class="form-control" required="required" id="gender_select_box">
                  <option value="">Select Gender</option>
                  <option value="1">Male</option>
                  <option value="0">Female</option>
                  <option value="2">Other</option>
                </select>
                <div class="gender_error" style="color: red;"></div>
              </div>
              <input type="hidden" name="schedule_id" id="patient_schedule_id">

         </div>
         <div class="modal-footer-btn text-right" style="padding-bottom: 20px;">
            <button type="button" class="btn waves-effect waves-light patient_gender" id="reset_gender">Cancel</button>
            <button  class="btn waves-effect waves-light patient_gender" id="input_gender">Submit</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade delivery-modal" id="reminder-to-all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <form action="<?php echo SITE_URL.'providers/dashboard/remind-all'; ?>" method="post">
      <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getParam('_csrfToken'); ?>">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel4">Which kind of reminder do you want to send?</h5>
         </div>

         <div class="modal-body">

            <div class="form-float">
                <input type="radio" name="type" value="telehealth" id="telehealth-reminder">
                <label for="telehealth-reminder" class="form-label">Telehealth appointment time
                  <!-- <span><strong>In-person</strong></span> -->
                </label>
            </div>
            <div class="form-float">
                <input type="radio" name="type" value="patient intake" id="patient-intake-reminder" checked="true">
                <label for="patient-intake-reminder" class="form-label">Pre-Appointment Form
                  <!-- <span><strong>Telehealth</strong></span> -->
                </label>
            </div>

         </div>
         <div class="modal-footer-btn text-right" style="padding-bottom: 20px;">
            <button type="button" class="btn waves-effect waves-light patient_gender" id="reset-reminder-type">Cancel</button>
            <input type="submit" name="Submit" class="btn waves-effect waves-light patient_gender" id="reminder-type-save" value="Send" />
         </div>
       </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   var run_cron = 1;
      let time=1000*60*1;
      var search = "";
      var page_length = 25;
      var sorting_column = 0;
      var sorting_dir = "asc";
      $('.js-basic-example').on( 'draw.dt', function () {
           page_length = $('.dataTables_length select').val();
        });

      $('.js-basic-example').on('search.dt', function() {
           search = $('.dataTables_filter input').val();
        });


      /*$('.js-basic-example').on( 'order.dt', function () {
          // This will show: "Ordering on column 1 (asc)", for example
          var order = $('.js-basic-example').dataTable().fnSettings().aaSorting;
          sorting_column = order[0][0];
          sorting_dir = order[0][1];

         // $('#orderInfo').html( 'Ordering on column '+order[0][0]+' ('+order[0][1]+')' );
      } );*/

      $(document).ready(function(){

       //alert(page_length);
          setInterval(()=>{
            //alert(run_cron)
             if(run_cron){
             $.ajax({
                    type:'GET',
                    url: "<?php echo SITE_URL.'/providers/dashboard/index'; ?>/"+page_length+"/"+search,
                    success:function(result)
                    {

                      result = JSON.parse(result);
                      console.log(result)

                        if(result.success){
                          var view = result.view;
                          var search = result.search;
                          //console.log(search);
                          var page_length = result.page_length;
                          var view = result.view;
                          var view_data = $(view).find('.provider_dashboard table.js-basic-example').html();
                          //console.log(view_data);
                           console.log(sorting_column);
                           console.log(sorting_dir);
                          $('.provider_dashboard table.js-basic-example').html(view_data);
                          if(search == "" || search == null){

                            $('.js-basic-example').DataTable({
                              destroy : true,
                              responsive: true,                              
                              stateSave: true,
                              fixedHeader: true,
                              iDisplayLength : parseInt(page_length),
                              lengthMenu: [[25, 50, 100], [25, 50, 100]],
                              order: [[ sorting_column, sorting_dir ]],                              
                              dom:"<'myfilter'f><'mylength'l>tt<'mylength'p>",
                            });

                          }else{


                            $('.js-basic-example').DataTable({
                              destroy : true,
                              responsive: true,                              
                              stateSave: true,
                              fixedHeader: true,
                              oSearch : {"sSearch": search},
                              iDisplayLength : parseInt(page_length),
                              lengthMenu: [[25, 50, 100], [25, 50, 100]],
                              order: [[ sorting_column, sorting_dir ]],
                              
                              dom:"<'myfilter'f><'mylength'l>tt<'mylength'p>",
                            });
                          }

                        }
                        else{

                          window.location = "<?php echo SITE_URL.'/providers/'; ?>";
                        }
                             $('body').ready(function(){
                              $('[data-toggle="tooltip"]').tooltip({
                                    trigger : 'hover'
                                })
                              });
                              $('body').ready(function(){
                                 $('[data-toggle="tooltip"]').click(function () {
                                    $('[data-toggle="tooltip"]').tooltip("hide");

                                 });
                             });

                    },
                    error: function(e) {

                        window.location = "<?php echo SITE_URL.'/providers/'; ?>"
                    }
                 })
               }
          },time);

        //after 15 mintues page will be reload
        time +=1000*60*1;
      });

      $(document).on('click','.open-patient-panel',function(){

          run_cron = 0;
          var url = $(this).data('url');
          setTimeout(function(){ document.location.reload(true) }, 2000);
         // window.location = url;
         var win = window.open(url, '_blank');
         win.focus();
      })


      $(document).on('change','#uploadcvs',function(){

        $("#upload_schedule_form").submit();
     });

      $(document).on('change','#validate_cvs',function(){

        $("#validate_csv_form").submit();
     });

      $('#validate_csv_form').on('submit',function(e) {
              e.preventDefault();
              var formData = new FormData(this);
              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/validateCsv'; ?>",
                  data:formData,
                 cache: false,
                contentType: false,
                processData: false,
                  processData: false,
                  beforeSend: function (xhr) {

                      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                      $('#validate_csv_model .loader').html('<img src="<?php echo WEBROOT."images/spinner.gif"; ?>" width="35px" height="24px" />');
                      $('#validate_csv_model').modal('show');
                   },
                  success:function(res)
                  {

                    var result = JSON.parse(res);
                    var messages = result.messages;
                    var messages_data = "<div class='messages'><div class='text-center messeges_header'><h3>Messages</h3></div>";
                    if(messages.length === 0){

                      messages_data += "No message found.";

                    }
                    else{

                        messages_data += "<ul>";
                        $(messages).each(function(index, value) {

                            messages_data += "<li>"+value+"</li>";
                        });
                        messages_data += "</ul>";
                    }

                    messages_data += "</div>";

                    //set warning data
                    var warnings = result.warnings;
                    var warnings_data = "<div class='warnings'><div class='text-center warnings_header'><h3>Warnings</h3></div>";
                    if(warnings.length === 0){

                      warnings_data += "No warning found.";

                    }
                    else{

                        warnings_data += "<ul>";
                        $(warnings).each(function(index, value) {

                            warnings_data += "<li>"+value+"</li>";
                        });
                        warnings_data += "</ul>";
                    }

                    warnings_data += "</div>";

                    //set warning data
                    var errors = result.errors;
                    var errors_data = "<div class='errors'><div class='text-center errors_header'><h3>Errors</h3></div>";
                    if(errors.length === 0){

                      errors_data += "No error found.";

                    }
                    else{

                        errors_data += "<ul>";
                        $(errors).each(function(index, value) {

                            errors_data += "<li>"+value+"</li>";
                        });
                        errors_data += "</ul>";
                    }

                    errors_data += "</div>";

                    //set valid uploaded data

                    var valid_upload = result.save_data;
                    //console.log(valid_upload);

                    var valid_upload_data = "<div class='valid_upload_data'><div class='text-center valid_data_header'><h3>Valid schedule data</h3></div>";
                    if(valid_upload.length === 0){

                      valid_upload_data += "No valid schedule data found.";

                    }
                    else{

                        valid_upload_data += "<div class='table-responsive'>"
                        valid_upload_data += "<table class='table table-bordered table-striped table-hover'>";
                        valid_upload_data += "<thead>";
                        valid_upload_data += "<tr>";
                        valid_upload_data += "<th>Last Name</th>";
                        valid_upload_data += "<th>First Name</th>";
                        valid_upload_data += "<th>Gender</th>";
                        valid_upload_data += "<th>Email</th>";
                        valid_upload_data += "<th>DOB</th>";
                        valid_upload_data += "<th>MRN</th>";
                        valid_upload_data += "<th>Mobile</th>";
                        valid_upload_data += "<th>Doctor Name</th>";
                        valid_upload_data += "<th>Appointment Time</th>";
                        valid_upload_data += "<th>Appointment Reason</th>";

                        $(valid_upload).each(function(index, value) {

                          //console.log(value);
                          valid_upload_data += "<tr>";

                          valid_upload_data += "<td>"+value.last_name+"</td>";
                          valid_upload_data += "<td>"+value.first_name+"</td>";
                          valid_upload_data += "<td>"+value.gender+"</td>";
                          valid_upload_data += "<td>"+value.email+"</td>";
                          valid_upload_data += "<td>"+value.dob+"</td>";
                          valid_upload_data += "<td>"+value.mrn+"</td>";
                          valid_upload_data += "<td>"+value.phone+"</td>";
                          valid_upload_data += "<td>"+value.doctor_name+"</td>";
                          valid_upload_data += "<td>"+value.appointment_time+"</td>";
                          valid_upload_data += "<td>"+value.appointment_reason+"</td>";

                          valid_upload_data += "</tr>";
                        });

                        valid_upload_data += "</table></div>";
                    }
                    valid_upload_data += "</div>";


                    //set final result data
                    var final_result = result.final_result;
                    var final_result_data = "<div class='final_result'><div class='text-center valid_data_header'><h3>File Final Result</h3></div>";

                    final_result_data += final_result;
                    final_result_data += "</div>";

                    $('#validate_csv_model .loader').hide();
                    $('.validation_result').html('');
                    $('.validation_result').append(messages_data);
                    $('.validation_result').append(warnings_data);
                    $('.validation_result').append(errors_data);
                    $('.validation_result').append(valid_upload_data);
                     $('.validation_result').append(final_result_data);
                      $('#validate_cvs').val("");
                    $('#validate_csv_model').modal('show');


                  },
                  error: function(e) {

                    window.location = "<?php echo SITE_URL.'/providers/'; ?>"
                  }
               })
          });


      $('#upload_schedule_form').on('submit',function(e) {
              e.preventDefault();
              var formData = new FormData(this);
              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/uploadScheduleCsv'; ?>",
                  data:formData,
                 cache: false,
                contentType: false,
                processData: false,
                  processData: false,
                  beforeSend: function (xhr) { // Add this line
                      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                      $('#uploadcvsbtn').css('width','152px');
                      $('#uploadcvsbtn').css('height','47px');
                      $('#uploadcvsbtn').html('<img src="<?php echo WEBROOT.'images/spinner.gif'; ?>" width="35px" height="24px" />');
                   },
                  success:function(res)
                  {
                     var result = JSON.parse(res);
                     // console.log(result);

                     if(!result.success){

                        $('#uploadcvsbtn').html('Upload Schedule <input type="file" name="csv_file" id="uploadcvs"></a>');
                        $('.msgerror').css('display','block');
                        $('.error-body').html();
                        $('.error-body').html(result.msg);
                        $('#uploadcvs').val('');

                     }else{

                      var view = result.view;                    
                      var view_data = $(view).find('.provider_dashboard table.js-basic-example').html();
                      $('#uploadcvsbtn').html('Upload Schedule <input type="file" name="csv_file" id="uploadcvs"></a>');
                      $('.provider_dashboard table.js-basic-example').html(view_data);
                      $('#uploadcvs').val("");
                     // console.log(search);
                      if(search == "" || search == null){

                          $('.js-basic-example').DataTable({
                            responsive: true,
                            destroy : true,
                            stateSave: true,
                            // oSearch : {"sSearch": search},
                            iDisplayLength : parseInt(page_length),
                            lengthMenu: [[25, 50, 100], [25, 50, 100]],
                            order: [[ sorting_column, sorting_dir ]],
                            fixedHeader: true,
                            dom:"<'myfilter'f><'mylength'l>tt<'mylength'p>",

                          });
                      }else{


                        $('.js-basic-example').DataTable({
                            responsive: true,
                            destroy : true,
                            stateSave: true,
                            oSearch : {"sSearch": search},
                            iDisplayLength : parseInt(page_length),
                            lengthMenu: [[25, 50, 100], [25, 50, 100]],
                            order: [[ sorting_column, sorting_dir ]],
                            fixedHeader: true,
                            dom:"<'myfilter'f><'mylength'l>tt<'mylength'p>",
                            
                          });
                      }

                     }
                     $('body').ready(function(){
                              $('[data-toggle="tooltip"]').tooltip({
                                    trigger : 'hover'
                                })
                              });
                              $('body').ready(function(){
                                 $('[data-toggle="tooltip"]').click(function () {
                                    $('[data-toggle="tooltip"]').tooltip("hide");

                                 });
                             });

                  },
                  error: function(e) {

                   // window.location = "<?php echo SITE_URL.'/providers/'; ?>"
                  }
               })
          });


      $(document).on('click','.view_note',function(e) {
              var schedule_id = $(this).attr('data-schedule_id');
              console.log(schedule_id);

              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/viewNote'; ?>",
                  data:{schedule_id:schedule_id},

                  beforeSend: function (xhr) { // Add this line
                      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());

                      $('.copy_link_box').addClass('text-center');

                      $('.copy_link_box').html('<img src="<?php echo WEBROOT.'images/spinner.gif'; ?>" width="35px" />');
                      $('button.copy_schedule').hide();
                      $('#myModal .patient_soapp_detail_section').hide();
                       $('#myModal .patient_comm_detail_section').hide();
                       $('#myModal .patient_dast_detail_section').hide();
                       $('#myModal .patient_basic_detail_section').hide();
                       $('#myModal .patient_em_detail_section').hide();

                      $('#myModal').modal('show');
                    },

                  success:function(res)
                  {
                    // console.log(res);
                     var result = JSON.parse(res);
                     var note_data = "<pre>"+result.note+"</pre>";
                     var soapp_note_data = "<pre>"+result.soapp_summary+"</pre>";
                     var comm_note_data = "<pre>"+result.comm_summary+"</pre>";
                     var dast_note_data = "<pre>"+result.dast_summary+"</pre>";
                     var em_note_data = "<pre>"+result.em_line+"</pre>";

                     $('.copy_link_box').removeClass('text-center');
                     $('button.copy_schedule').show();
                     $('#myModal .copy_link_box').html('');
                     $('#myModal .copy_link_box').html(note_data);
                     $('#myModal .patient_basic_detail_section').show();

                     $('#myModal .em_copy_link_box').html('');
                     $('#myModal .em_copy_link_box').html(em_note_data);
                     $('#myModal .patient_em_detail_section').show();

                     if(result.soapp_summary != undefined && result.soapp_summary == ''){

                        $('#myModal .patient_soapp_detail_section').hide();
                      }
                      else{

                        $('#myModal .soapp_copy_link_box').html('');
                        $('#myModal .soapp_copy_link_box').html(soapp_note_data);
                        $('#myModal .patient_soapp_detail_section').show();
                      }

                      if(result.comm_summary != undefined && result.comm_summary == ''){

                        $('#myModal .patient_comm_detail_section').hide();
                      }
                      else{

                        $('#myModal .comm_copy_link_box').html('');
                        $('#myModal .comm_copy_link_box').html(comm_note_data);
                        $('#myModal .patient_comm_detail_section').show();
                      }

                      if(result.dast_summary != undefined && result.dast_summary == ''){

                        $('#myModal .patient_dast_detail_section').hide();
                      }
                      else{

                        $('#myModal .dast_copy_link_box').html('');
                        $('#myModal .dast_copy_link_box').html(dast_note_data);
                        $('#myModal .patient_dast_detail_section').show();
                      }

                  },
                  error: function(e) {

                    //window.location = "<?php echo SITE_URL.'providers/'; ?>"
                  }
               })
          });

      $(document).on('click','.print_pdf',function(e) {
              var schedule_id = $(this).attr('data-schedule_id');
              console.log(schedule_id);

              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'providers/dashboard/printPdf'; ?>",
                  data:{schedule_id:schedule_id},

                  beforeSend: function (xhr) { // Add this line
                      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                   },
                  success:function(res)
                  {

                     var result = JSON.parse(res);
                    window.open(result.url, '_blank');


                  },
                  error: function(e) {

                    window.location = "<?php echo SITE_URL.'providers/'; ?>"
                  }
               })
          });


      $(document).on('click','.copy_schedule',function(){

        var copyTextarea = document.querySelector('.copy_link_box');
        copy_schedule_notes(copyTextarea,'myModal');
      });

       $(document).on('click','.copy_medical_detail',function(){

        var copyTextarea = document.querySelector('.medical_copy_link_box');
        copy_schedule_notes(copyTextarea,'ipc_model');
      });

       $(document).on('click','.copy_soapp_detail',function(){

        var model_id = $(this).data('model_id');
        var selectbox = '#'+model_id+' .soapp_copy_link_box';
        var copyTextarea = document.querySelector(selectbox);
        copy_schedule_notes(copyTextarea,model_id);
      });

       $(document).on('click','.copy_comm_detail',function(){

        var model_id = $(this).data('model_id');
        var selectbox = '#'+model_id+' .comm_copy_link_box';
        var copyTextarea = document.querySelector(selectbox);
        copy_schedule_notes(copyTextarea,model_id);
      });

       $(document).on('click','.copy_dast_detail',function(){

        var model_id = $(this).data('model_id');
        var selectbox = '#'+model_id+' .dast_copy_link_box';
        var copyTextarea = document.querySelector(selectbox);
        copy_schedule_notes(copyTextarea,model_id);
      });

       $(document).on('click','.copy_em_detail',function(){

        var model_id = $(this).data('model_id');
        var selectbox = '#'+model_id+' .em_copy_link_box';
        var copyTextarea = document.querySelector(selectbox);
        copy_schedule_notes(copyTextarea,model_id);
      });


     $(document).on('click','.copy_basic_detail',function(){

        var copyTextarea = document.querySelector('.basic_copy_link_box');
        copy_schedule_notes(copyTextarea,'ipc_model');
      });


      $(document).on('click','.copy_note',function(){

        var schedule_id = $(this).attr('data-schedule_id');
        console.log(schedule_id);
        $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/copyNote'; ?>",
                  data:{schedule_id:schedule_id},

                  beforeSend: function (xhr) { // Add this line
                      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                   },
                  success:function(res)
                  {


                     var note_data = "<pre>"+res+"</pre>";
                      $('.copy_link_box').html('');

                      $('.copy_link_box').html(note_data);
                     var copyTextarea = document.querySelector('.copy_link_box');
                      copy_notes(copyTextarea);

                  },
                  error: function(e) {

                    window.location = "<?php echo SITE_URL.'/providers/'; ?>"
                  }
               });
      })

      // function copy_schedule_notes(copyTextarea,model_name){
      //   try{
      //     $(copyTextarea).find('pre').css('background-color','#fff');
      //     $(copyTextarea).find('pre').css('border','none');

      //      var $temp = $("<div>");
      //      $("body").append($temp);
      //       $temp.attr("contenteditable", true)
      //           .html($(copyTextarea).html()).select()
      //           .on("focus", function() { document.execCommand('selectAll',false,null) })
      //           .focus();
      //      var successful = document.execCommand("copy");
      //      var msg = successful ? 'successfully' : 'unsuccessfully';

      //     $('#'+model_name).modal('hide');
      //     $('.msgsuccess').html('Copied '+msg+' .<button type="button" class="close"><span aria-hidden="true">&times;</span></button>' );
      //     $('.msgsuccess').show();
      //     $temp.remove();
      //   }
      //   catch (err) {
      //     console.log('Oops, unable to copy');
      //   }
      // }
        function copy_notes(copyTextarea)
        {
           try{
            $(copyTextarea).find('pre').css('background-color','#fff');
            $(copyTextarea).find('pre').css('border','none');

             var $temp1 = $("<input>");
             $("body").append($temp1);
             $temp1.val($(copyTextarea).text()).select()
             var successful = document.execCommand("copy");
             var msg = successful ? 'successfully' : 'unsuccessfully';
            $('.msgsuccess').html('Copied '+msg+' .<button type="button" class="close"><span aria-hidden="true">&times;</span></button>' );
            $('.msgsuccess').show();
            $('html,body').animate({scrollTop: 0});
            $temp1.remove();
          }
          catch (err) {
            console.log('Oops, unable to copy');
          }
        }

        function copy_schedule_notes(copyTextarea,model_name){
        try{
          //alert(copyTextarea.target.class);
          $(copyTextarea).find('pre').css('background-color','#fff');
          $(copyTextarea).find('pre').css('border','none');
         // alert($(copyTextarea).text());
          var $temp = $("<div>");
          $('.wraper #'+model_name+' .modal-content').append($temp);
          $temp.attr("contenteditable", true)
               .html($(copyTextarea).html())
               .select()
               .focus()
               document.execCommand("copy");
               document.execCommand('selectAll',false,null)
               var successful = document.execCommand("copy");
               var msg = successful ? 'successfully' : 'unsuccessfully';
                $('#'+model_name).modal('hide');
                $('.msgsuccess').html('Copied '+msg+' .<button type="button" class="close"><span aria-hidden="true">&times;</span></button>' );
                 $('.msgsuccess').show();
                $('html,body').animate({scrollTop: 0});
               $temp.remove();
        }
        catch (err) {
         // alert(err.message);
          console.log('Oops, unable to copy');
        }
      }

      $(document).on('click','.view_ipc',function() {

              var schedule_id = $(this).attr('data-schedule_id');

              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/viewNote'; ?>",
                  data:{schedule_id:schedule_id},

                  beforeSend: function (req) {

                      req.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                      $('#ipc_model .modal-body').addClass('text-center');

                      $('#ipc_model .loader').html('<img src="<?php echo WEBROOT.'images/spinner.gif'; ?>" width="35px" />');
                      $('#ipc_model .patient_basic_detail_section').hide();
                       $('#ipc_model .patient_medical_detail_section').hide();
                       $('#ipc_model .patient_soapp_detail_section').hide();
                       $('#ipc_model .patient_comm_detail_section').hide();
                       $('#ipc_model .patient_dast_detail_section').hide();
                       $('#ipc_model .patient_em_detail_section').hide();
                      $('#ipc_model').modal('show');
                   },
                  success:function(res)
                  {
                    var result = JSON.parse(res);
                    var basic_note_data = "<pre>"+result.patient_basic_detail+"</pre>";
                    var medical_note_data = "<pre>"+result.patient_medical_detail+"</pre>";
                   // var other_note_data = "<pre>"+result.patient_other_detail+"</pre>";
                   var soapp_note_data = "<pre>"+result.soapp_summary+"</pre>";
                     var comm_note_data = "<pre>"+result.comm_summary+"</pre>";
                     var dast_note_data = "<pre>"+result.dast_summary+"</pre>";
                     var em_note_data = "<pre>"+result.em_line+"</pre>";

                     $('#ipc_model .em_copy_link_box').html('');
                      $('#ipc_model .em_copy_link_box').html(em_note_data);
                     $('#ipc_model .patient_em_detail_section').show();

                    $('#ipc_model .modal-body').removeClass('text-center');
                    $('#ipc_model .loader').hide();
                    $('#ipc_model .basic_copy_link_box').html('');
                    $('#ipc_model .basic_copy_link_box').html(basic_note_data);
                    $('#ipc_model .patient_basic_detail_section').show();



                    $('#ipc_model .medical_copy_link_box').html('');
                    $('#ipc_model .medical_copy_link_box').html(medical_note_data);
                    $('#ipc_model .patient_medical_detail_section').show();
                    //other_note_data = 'sdsddsds';
                    /*if(result.patient_other_detail == ''){

                      $('.patient_other_detail_section').hide();
                    }
                    else{

                      $('.other_copy_link_box').html('');
                      $('.other_copy_link_box').html(other_note_data);
                      $('.patient_other_detail_section').show();
                    }*/

                    if(result.soapp_summary == ''){

                      $('#ipc_model .patient_soapp_detail_section').hide();
                    }
                    else{

                      $('#ipc_model .soapp_copy_link_box').html('');
                      $('#ipc_model .soapp_copy_link_box').html(soapp_note_data);
                      $('#ipc_model .patient_soapp_detail_section').show();
                    }

                    if(result.comm_summary == ''){

                      $('#ipc_model .patient_comm_detail_section').hide();
                    }
                    else{

                      $('#ipc_model .comm_copy_link_box').html('');
                      $('#ipc_model .comm_copy_link_box').html(comm_note_data);
                      $('#ipc_model .patient_comm_detail_section').show();
                    }

                    if(result.dast_summary == ''){

                      $('#ipc_model .patient_dast_detail_section').hide();
                    }
                    else{

                      $('#ipc_model .dast_copy_link_box').html('');
                      $('#ipc_model .dast_copy_link_box').html(dast_note_data);
                      $('#ipc_model .patient_dast_detail_section').show();
                    }
                    $('#ipc_model').modal('show');
                  }
               })
          });

      $(document).on('click','#loginAndRegister',function(){

        var schedule_id = $(this).attr('data-schedule_id');
        //console.log(schedule_id);
        $('#patient_schedule_id').val(schedule_id);
        $('#basicExampleAddNewGroup').modal('show');

      });

      $(document).on('click','#input_gender',function(){

        $('.gender_error').html('');
        var schedule_id = $('#patient_schedule_id').val();
        var gender = $('#gender_select_box').val();
        var patient_type = 0;
        if(gender == ''){

            $('.gender_error').html('Gender is required.');
          }
        else{

            $('#basicExampleAddNewGroup').modal('hide');
            run_cron = 0;
            var url = "<?php echo SITE_URL.'providers/dashboard/registerUser'; ?>/"+schedule_id+"/"+patient_type+"/"+gender;
            //window.open(url,'_blank');
            setTimeout(function(){ document.location.reload(true) }, 2000);
            var win = window.open(url, '_blank');
            win.focus();
        }
      });
      $(document).on('click','#reset_gender',function(){
        $('#basicExampleAddNewGroup .bootstrap-select button').each(function(){

            if($(this).data('id') == 'gender_select_box'){
              $(this).find('span.filter-option').text('Select Gender');
            }
        })
        //$('#basicExampleAddNewGroup .bootstrap-select button span.filter-option').text('select gender');
        $('#gender_select_box').val('');
        $('.gender_error').html('');
        //$('#patient_type_select_box').val('');
        $('#basicExampleAddNewGroup').modal('hide');
      });


      $(document).on('click','.telehealth-appt',function(e)
      {
        var schedule_id = $(this).attr('data-schedule_id');
        console.log(schedule_id);
        $.ajax({
            type:'POST',
            url: "<?php echo SITE_URL.'/providers/dashboard/telehealthAppointment'; ?>",
            data:{schedule_id:schedule_id},
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                $('#telehealth-appt-'+schedule_id).removeClass('telehealth-appt');
                $('#telehealth-appt-'+schedule_id).html('');
                $('#telehealth-appt-'+schedule_id).html('<img src="<?php echo WEBROOT."images/spinner.gif"; ?>" width="24px" />');

              },
            success:function(res)
            {

              var result = JSON.parse(res);
              if(result.success){

                  var win = window.open(result.video_url, '_blank');
                  win.focus();
              }
              else{

                  $('.msgerror .error-body').html('');
                  $('.msgerror .error-body').html(result.error);
                  $('.msgerror').css('display','block');

              }

              $('#telehealth-appt-'+schedule_id).addClass('telehealth-appt');
              $('#telehealth-appt-'+schedule_id).html('<i class="fas fa-video"></i>Start Telehealth Appointment');

            },
            error: function(e) {

              window.location = "<?php echo SITE_URL.'providers/'; ?>"
            }
        })
      });


      //show model for send reminder to all appointments

      $(document).on('click','.remind-all',function(){
        $('#reminder-to-all').modal('show');
      });

      $(document).on('click','#reset-reminder-type',function(){
        //$('.reminder-type').val('');
        $("#patient-intake-reminder").prop("checked", true);
        $('#reminder-to-all').modal('hide');
      });


   $('body').ready(function(){
      $('[data-toggle="tooltip"]').tooltip({
            trigger : 'hover'
        })
   });

   $('body').ready(function(){
         $('[data-toggle="tooltip"]').click(function () {
            $('[data-toggle="tooltip"]').tooltip("hide");
         });
   });



      $('body').on("click",'.msgsuccess .close',function(e){
                $(this).parent().hide();
      });


      $('body').on("click",'.msgerror .close',function(e){
                $(this).parent().hide();
      });

</script>
<script>
	var tour =   {
    id: "hello-hopscotch",
    steps: [ 
      {
        target: "middledashboard",
        title: "Dashboard",
        content: "<strong>Upload Schedule:</strong> Upload the patient schedule excel sheet.<br><strong>Remind all:</strong> Popup to choose to send notifications to all loaded patients for the appointment time or the pre-appointment questionnaire.<br><strong>Add Patient:</strong> Patients outside of the uploaded schedule, such as walk-in patients, can be added here.",
        placement: "bottom",            
        yOffset:35,                
      },   
      {
        target: "toggle-menu",
        title: "Hamburger menu",
        content: "Gives a pop-up side menu for more details and settings. Click on the button",
        placement: "bottom",
        yOffset: 20,
        onNext: function(tour) {
          $('.menu--slide-right').addClass('active');
          $('.toggle-menu').addClass('active');
        },
        onPrev: function(tour) {
          $('.menu--slide-right').removeClass('active');
          $('.toggle-menu').removeClass('active');
        }
      },
      {
        target: "h-past-schedule",
        title: "Top Level of Side Menu",
        content: "<strong>Dashboard:</strong> The default main page. View patient schedule table and actions here.<br><strong>Past Schedules:</strong> Displays past schedules and notes similar to the dashboard table.<br><strong>Email and Text Templates:</strong> Edit email and messaging templates here.",
        placement: "right",
        delay:300,
        onNext: function(tour) {
          $('#h-setting').removeClass('collapsed');
          $('#Settings').addClass('show');
        },  
      },    

      {
        target: "h-input-schedule-setting",
        title: "Top Level of Settings Menu",
        content: "<strong>General Settings:</strong> Edit your password and other account settings here.<br><strong>Input Schedule Settings:</strong> If schedules are uploaded manually to the dashboard, edit the configuration here.<br><strong>Display Columns:</strong> Choose columns to display in the dashboard.",
        placement: "right",
        onPrev :function(tour) {
          $('#h-setting').addClass('collapsed');
          $('#Settings').removeClass('show');
        },    
        
      },
      {
        target: "h-telehealth",
        title: "Bottom Level of Settings Menu",
        content: "<strong>Note Formatting:</strong> Choose the output note for proper EHR format.<br><strong> Telehealth:</strong> Toggle to activate telehealth (if subscribed).<br><strong>Automated Reminder Settings:</strong> Edit frequency and automated text and email reminders.",
        placement: "right",
        onPrev :function(tour) {
          $('#h-support').addClass('collapsed');
          $('#support').removeClass('show');
        },
        onNext: function(tour) {
          $('#h-support').removeClass('collapsed');
          $('#support').addClass('show');
        },
      },
      {
        target: "h-provider-tour",
        title: "Support",
        content: "<strong>Provider Tour:</strong> Initiate this walkthrough at any time.<br><strong> Help Desk:</strong> Provider help desk.",
        placement: "right",
        onPrev :function(tour) {
          $('#h-support').addClass('collapsed');
          $('#support').removeClass('show');
        },        
      },     
    ],
    showPrevButton: true,
    scrollTopMargin: 100,
    onEnd: function() {
      <?php $session->write('is_start_tour',0); ?>
        //setCookie("toured", "toured");
    },
    onClose: function() {
      <?php $session->write('is_start_tour',0); ?>
        //setCookie("toured", "toured");
    }
  }
$(document).ready(function() {
    var is_start_tour = '<?php echo $is_start_tour?>';
    if (is_start_tour == 0) {
        $.ajax({
            type: 'POST',
            url: "<?php echo SITE_URL.'providers/dashboard/firstlogintour'; ?>",
            success: function(res) {},
            error: function(e) {window.location = "<?php echo SITE_URL.'providers/'; ?>"}
        })
    }
    var is_start_tour = '<?php echo $is_start_tour; ?>';
    if (is_start_tour == 0) {
        hopscotch.startTour(tour);
    }
});

$("#h-provider-tour").on('click', function(){
  hopscotch.startTour(tour, 0);
})

function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
};

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
};

function Revealer() {
  var OVERLAY_ZINDEX = 10;
  var OVERLAY_BACKGROUND = 'rgba(0,0,0,0.5)';

  var $overlay, $prevTarget, $currTarget;

  function overlay() {
    if ($overlay) {
      return $overlay;
    }
    $overlay = $('<div>');
    var $prevTarget, $currTarget;
    $overlay.css({
      zIndex:     OVERLAY_ZINDEX,
      background: OVERLAY_BACKGROUND,
      position:   'fixed',
      display:    'none',
      top:        0,
      right:      0,
      bottom:     0,
      left:       0
    });
    $(document.body).append($overlay);
    return $overlay;
  }

  function cleanupPrevTarget() {
    if ($prevTarget) {
      $prevTarget.css({
        position: '',
        zIndex:   ''
      });
    }
    $prevTarget = null;
  }

  function hide() {
    overlay().fadeOut();
    cleanupPrevTarget();
  }

  function reveal(target) {
    cleanupPrevTarget();
    overlay().fadeIn();
    if (target) {
      $currTarget = $(target);
      // make sure the target node's `position` behaves with `z-index` correctly
      var position = $currTarget.css('position')
      if (!/^(?:absolute|fixed|relative)$/.test(position)) {
        position = 'relative';
      }
      $currTarget.css({
        position: position,
        zIndex:   OVERLAY_ZINDEX + 1
      });
      $prevTarget = $currTarget;
    }
  }

  return {
    reveal: reveal,
    hide: hide
  };
}
var revealer = new Revealer();
hopscotch.listen('show', function() {
  revealer.reveal();
});
hopscotch.listen('close', function() {
  revealer.hide();
});
hopscotch.listen('end', function() {
  revealer.hide();
});
</script>
