 <?php $gender = array(0 => 'Female',1=>'Male', 2=>'Other' ); 
  use Cake\Utility\Security; 
  ?>
<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
        <div class="msgsuccess alert alert-success" style="display: none;">                                 
        </div>
         <?= $this->Flash->render() ?>
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Past Schedules</h4>
          </div>
          <div class="card-body"> 
                <form method="get" action="" class="form form-inline">
                   <div class="selection">
                      
                         
                          
                               <select name="month" onchange="this.form.submit();" class="form-control">
                                  <option value="1" <?php echo 1 == $month ? "selected" : ""; ?>>Jan</option>
                                  <option value="2" <?php echo 2 == $month ? "selected" : ""; ?>>Feb</option>
                                  <option value="3" <?php echo 3 == $month ? "selected" : ""; ?>>Mar</option>
                                  <option value="4" <?php echo 4 == $month ? "selected" : ""; ?>>Apr</option>
                                  <option value="5" <?php echo 5 == $month ? "selected" : ""; ?>>May</option>
                                  <option value="6" <?php echo 6 == $month ? "selected" : ""; ?>>Jun</option>
                                  <option value="7" <?php echo 7 == $month ? "selected" : ""; ?>>Jul</option>
                                  <option value="8" <?php echo 8 == $month ? "selected" : ""; ?>>Aug</option>
                                  <option value="9" <?php echo 9 == $month ? "selected" : ""; ?>>Sep</option>
                                  <option value="10" <?php echo 10 == $month ? "selected" : ""; ?>>Oct</option>
                                  <option value="11" <?php echo 11 == $month ? "selected" : ""; ?>>Nov</option>
                                  <option value="12" <?php echo 12 == $month ? "selected" : ""; ?>>Dec</option>
                               </select>
                          
                         
                    
                      
                               <select name="year" onchange="this.form.submit();" class="form-control">
                                  <?php for($i = 2011; $i<= date('Y') ; $i++){ ?>
                                  <option value="<?php echo $i; ?>" <?php echo $i == $year ? "selected" : ""; ?>><?php echo $i; ?></option>
                                  <?php  } ?>
                               </select>
                            
                      
                   </div>
                </form>

                    <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getParam('_csrfToken'); ?>">
                    <?php if(isset($temp_scheduled_data) && !empty($temp_scheduled_data)){ 
                        $i = 1;
                     ?>

                   <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                      <?php foreach ($temp_scheduled_data as $key => $schedule) { ?>

                        <?php if($i == 1){ ?>
                          <div class="card">
                            <div class="card-header" role="tab" id="heading_<?php echo $i; ?>">
                              <a href="#collapse_<?php echo $i; ?>" class="btn btn-header-link" data-toggle="collapse" data-target="#collapse_<?php echo $i; ?>"
                            aria-expanded="true" aria-controls="collapse_<?php echo $i; ?>"  ><?php echo date('F d, Y', strtotime($key)); ?></a>
                            </div>
                            <div id="collapse_<?php echo $i; ?>" class="collapse show" role="tabpanel" aria-labelledby="heading_<?php echo $i; ?>" data-parent="#accordion">
                              <div class="card-body">
                                <div class="table-responsive">
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
                                            

                                            <?php if(isset($display_columns['appointment_reason']) && $display_columns['appointment_reason'] ==  1){ ?>

                                                   <th>Appointment Reason</th>
                                                  
                                            <?php } ?>

                                            
                                             <th>Progress</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      <?php if(!empty($schedule)){ 

                                          foreach ($schedule as $s_key => $s_value) { 
                                            
                                        ?>

                                          <tr>

                                             <?php if(isset($display_columns['appointment_time']) && $display_columns['appointment_time'] ==  1){ ?>

                                                <?php $time  = !empty($s_value['appointment_time']) ? $s_value['appointment_time'] : "";
                                                $start_time = '';
                                                if(!empty($time)){

                                                  $temp_time = explode('-',$time);
                                                  $start_time = isset($temp_time[1]) ? trim($temp_time[1]) : (isset($temp_time[0]) ? trim($temp_time[0]) : "");
                                                  $start_time = !empty($start_time) ? strtotime($start_time) : "";
                                                }
                                               ?>
                                                  <td><span style="display: none;"><?php echo $start_time; ?></span> <?= $time ?></td>
                                                  
                                            <?php } ?>

                                            <?php if(isset($display_columns['last_name']) && $display_columns['last_name'] ==  1){ ?>

                                                   <td><?= !empty($s_value['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['last_name']),SEC_KEY) : "" ?></td>

                                            <?php } ?>

                                            <?php if(isset($display_columns['first_name']) && $display_columns['first_name'] ==  1){ ?>

                                                    <td><?= !empty($s_value['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['first_name']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>

                                            <?php
                                             $gender = array(0 => 'Female',1=>'Male', 2=>'Other' );
                                             if(isset($display_columns['gender']) && $display_columns['gender'] ==  1){ ?>

                                                      <td><?= !empty($s_value['user']['gender']) ? $gender[Security::decrypt(base64_decode($s_value['user']['gender']),SEC_KEY)] : "" ?></td>
                                                    
                                            <?php } ?>

                                            <?php if(isset($display_columns['dob']) && $display_columns['dob'] ==  1){ ?>

                                                    <td><?= !empty($s_value['dob']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['dob']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>
                                            
                                            <?php if(isset($display_columns['mrn']) && $display_columns['mrn'] ==  1){ ?>

                                                    <td><?= !empty($s_value['mrn']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['mrn']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>

                                            <?php if(isset($display_columns['email']) && $display_columns['email'] ==  1){ ?>

                                                    <td><?= !empty($s_value['email']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['email']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>
                                            
                                            <?php if(isset($display_columns['phone']) && $display_columns['phone'] ==  1){ ?>

                                                    <td><?= !empty($s_value['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['phone']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>
                                            
                                            <?php if(isset($display_columns['doctor_name']) && $display_columns['doctor_name'] ==  1){ ?>

                                                    <td>
                                                      <?php if(!empty($s_value['doctor'])){

                                                          echo $s_value['doctor']['doctor_name'];
                                                      }
                                                      else{

                                                        echo !empty($s_value['doctor_name']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['doctor_name']),SEC_KEY) : "";
                                                      } 
                                                      ?>
                                                        
                                                      </td>
                                                    
                                            <?php } ?>                                           

                                            <?php if(isset($display_columns['appointment_reason']) && $display_columns['appointment_reason'] ==  1){ ?>

                                                   <td><?= !empty($s_value['appointment_reason']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['appointment_reason']),SEC_KEY) : "" ?></td>
                                                  
                                            <?php } ?>
                                            
                                            <td>
                                              <?php if($s_value['status'] == 0){

                                                echo '-';
                                              }
                                              elseif($s_value['status'] == 1){

                                                echo '<a href="javascript:;" class="bg-red pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Form sent but not started"><i class="fas fa-times red-close"></i></a>';
                                              }elseif($s_value['status'] == 2){

                                                echo '<a href="javascript:;" class="bg-orange pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Form at stage'.$s_value["stage"].'"><i class="fas fa-exclamation-triangle orange-warning"></i></a>';

                                              }elseif($s_value['status'] == 3){

                                                echo '<a href="javascript:;" class="bg-green pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Form completed"><i class="fas fa-check blue-check"></i></a>';
                                              }
                                              ?>
                                            </td>
                                            
                                          <td class="actions">

                                           <?php if($s_value['status'] == 3){ ?>
                                            <div class="btn-groups dropdown">
                                              <a href="javascript:;" class="btn btn-round" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                              </a>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <?php if($user->note_formating == 'full'){ ?>


                                              <a href="javascript:;" class="bg-green view_ipc dropdown-item" style="margin:1px;"  data-schedule_id = "<?php echo $s_value['id']; ?>"><i class="far fa-dot-circle"></i>iPatientCare</a>

                                           <?php }
                                                  else{ 
                                            ?>
                                            <a href="javascript:;" class="bg-black view_note dropdown-item" style="margin:1px;" data-schedule_id = "<?php echo $s_value['id']; ?>"><i class="fas fa-eye"></i>View Note</a>

                                          <?php } ?>                                            

                                            <a href="javascript:;" class="bg-orange print_pdf dropdown-item" style="margin:1px;" data-schedule_id="<?php echo $s_value->id; ?>"><i class="fas fa-print"></i>Print Pdf</a>
                                             </div>
                                          </div>  

                                        <?php  } ?>                                           

                                         </td>
                                       </tr>

                                      <?php } }  ?>
                                      
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php }
                            else{ ?>
                                <div class="card">
                                  <div class="card-header" role="tab" id="heading_<?php echo $i; ?>">                                   
                                     <a href="#collapse_<?php echo $i; ?>" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#collapse_<?php echo $i; ?>"
                                      aria-expanded="true" aria-controls="collapse_<?php echo $i; ?>"><?php echo date('F d, Y', strtotime($key)); ?></a>
                                  </div>


                                  <div id="collapse_<?php echo $i; ?>" class="collapse" role="tabpanel" aria-labelledby="heading_<?php echo $i; ?>"  data-parent="#accordion">
                                    <div class="card-body">
                                       <div class="table-responsive">
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

                                            

                                            <?php if(isset($display_columns['appointment_reason']) && $display_columns['appointment_reason'] ==  1){ ?>

                                                   <th>Appointment Reason</th>
                                                  
                                            <?php } ?>
                                            
                                             <th>Progress</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      <?php if(!empty($schedule)){ 

                                          foreach ($schedule as $s_key => $s_value) { 
                                        ?>

                                          <tr>

                                            <?php if(isset($display_columns['appointment_time']) && $display_columns['appointment_time'] ==  1){ ?>

                                                <?php $time  = !empty($s_value['appointment_time']) ? $s_value['appointment_time']: "";
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

                                                   <td><?= !empty($s_value['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['last_name']),SEC_KEY) : "" ?></td>

                                            <?php } ?>

                                            <?php if(isset($display_columns['first_name']) && $display_columns['first_name'] ==  1){ ?>

                                                    <td><?= !empty($s_value['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['first_name']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>

                                            <?php if(isset($display_columns['gender']) && $display_columns['gender'] ==  1){ ?>
                                                     <td><?= !empty($s_value['user']['gender']) ? $gender[Security::decrypt(base64_decode($s_value['user']['gender']),SEC_KEY)] : "" ?></td>
                                                    
                                            <?php } ?>

                                            <?php if(isset($display_columns['dob']) && $display_columns['dob'] ==  1){ ?>

                                                    <td><?= !empty($s_value['dob']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['dob']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>
                                            
                                            <?php if(isset($display_columns['mrn']) && $display_columns['mrn'] ==  1){ ?>

                                                    <td><?= !empty($s_value['mrn']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['mrn']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>

                                            <?php if(isset($display_columns['email']) && $display_columns['email'] ==  1){ ?>

                                                    <td><?= !empty($s_value['email']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['email']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>
                                            
                                            <?php if(isset($display_columns['phone']) && $display_columns['phone'] ==  1){ ?>

                                                    <td><?= !empty($s_value['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['phone']),SEC_KEY) : "" ?></td>
                                                    
                                            <?php } ?>
                                            
                                            <?php if(isset($display_columns['doctor_name']) && $display_columns['doctor_name'] ==  1){ ?>

                                                    <td>
                                                      <?php if(!empty($s_value['doctor'])){

                                                          echo $s_value['doctor']['doctor_name'];
                                                      }
                                                      else{

                                                        echo !empty($s_value['doctor_name']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['doctor_name']),SEC_KEY) : "";
                                                      } 
                                                      ?>
                                                        
                                                      </td>
                                                    
                                            <?php } ?>

                                            <?php if(isset($display_columns['appointment_reason']) && $display_columns['appointment_reason'] ==  1){ ?>

                                                   <td><?= !empty($s_value['appointment_reason']) ? $this->CryptoSecurity->decrypt(base64_decode($s_value['appointment_reason']),SEC_KEY) : "" ?></td>
                                                  
                                            <?php } ?>

                                            
                                            <td>
                                              <?php if($s_value['status'] == 0){

                                                echo '-';
                                              }
                                              elseif($s_value['status'] == 1){

                                                echo '<a href="javascript:;" class="bg-red pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Form sent but not started"><i class="fas fa-times red-close"></i></a>';
                                              }elseif($s_value['status'] == 2){

                                                echo '<a href="javascript:;" class="bg-orange pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Form at stage'.$s_value["stage"].'"><i class="fas fa-exclamation-triangle orange-warning"></i></a>';

                                              }elseif($s_value['status'] == 3){

                                                echo '<a href="javascript:;" class="bg-green pointer" style="margin:1px;" data-toggle="tooltip" data-placement="bottom" title="Form completed"><i class="fas fa-check blue-check"></i></a>';
                                              }
                                              ?>
                                            </td>
                                            
                                          <td class="actions">                                        

                                           <?php if($s_value['status'] == 3){ ?>

                                            
                                               <!--  <a class="dropdown-item" href="#"><i class="fas fa-sticky-note"></i> View Note</a>
                                                <a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Copy Note</a>
                                                <a class="dropdown-item" href="#"><i class="fas fa-print"></i> Print PDF</a> -->
                                              <div class="btn-groups dropdown">
                                              <a href="javascript:;" class="btn btn-round" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                              </a>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                             

                                            <?php if($user->note_formating == 'full'){ ?>
                                               
                                              
                                                <a href="javascript:;" class="bg-green view_ipc dropdown-item" style="margin:1px;" data-schedule_id = "<?php echo $s_value['id']; ?>"><i class="far fa-dot-circle"></i>iPatientCare</a>                                            
                                            <?php } else{ ?>      


                                              <a href="javascript:;" class="bg-black view_note dropdown-item" style="margin:1px;" data-schedule_id = "<?php echo $s_value['id']; ?>"><i class="fas fa-eye"></i>View Note</a>

                                            <?php } ?>

                                            <a href="javascript:;" class="bg-orange print_pdf dropdown-item" style="margin:1px;" data-schedule_id="<?php echo $s_value->id; ?>"><i class="fas fa-print"></i>Print Pdf</a>
                                             </div>
                                            </div>

                                        <?php  } ?>

                                            
                                         </td>
                                       </tr>

                                      <?php } }  ?>
                                      
                                    </tbody>
                                  </table>
                                </div>
                                    </div>
                                  </div>
                                </div>
                            <?php }
                         ?>
                      <?php $i++; } ?>  
                    </div> 

                    <?php } ?>                          
                                
                                              
          </div>
         </div>
      </div>
     </div>
   </div> 


<style type="text/css">
   /*  .msgsuccess{ display: none; margin-left: 10px;
              text-align: center;
              background: green;
              padding: 8px;
       } */
       .note_view_model{

         max-width: 70% !important;
       }
</style>

<div class="modal fade share_link_bg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog note_view_model" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Schedule Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">      

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


<div class="modal fade share_link_bg" id="ipc_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog note_view_model" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">iPatientCare</h5>
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

            <div class="patient_soapp_detail_section">
           
            <div class="soapp_detail_header d-flex"> 
              <h4>SOAPP-R Details</h4>

                <button  id=""  class="btn btn-blue copy_soapp_detail" data-model_id = 'ipc_model' >Copy SOAPP-R Details</button>
              

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

                <button id="" class="btn btn-blue copy_dast_detail" data-model_id = 'ipc_model'>Copy DAST-10 Details</button>
              

            </div>
            <div class="dast_copy_link_box">
               
            </div>
            
          </div>           
          </div>
         </div>
      </div>
   </div>
</div>


<script type="text/javascript">

     $(document).on('click','.copy_schedule',function(){

        var copyTextarea = document.querySelector('.copy_link_box');
        
        copy_schedule_notes(copyTextarea,'myModal');
      });

     $(document).on('click','.copy_medical_detail',function(){

        var copyTextarea = document.querySelector('.medical_copy_link_box');
        
        copy_schedule_notes(copyTextarea,'ipc_model');
      });

     $(document).on('click','.copy_basic_detail',function(){

        var copyTextarea = document.querySelector('.basic_copy_link_box');
        
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
       // alert(model_id);
        var selectbox = '#'+model_id+' .em_copy_link_box';
        var copyTextarea = document.querySelector(selectbox);        
        copy_schedule_notes(copyTextarea,model_id);
      });

/*      function copy_schedule_notes(copyTextarea, model_name){
        try{

          $(copyTextarea).find('pre').css('background-color','#fff');
          $(copyTextarea).find('pre').css('border','none');

          var $temp = $("<div>");
          $("body").append($temp);
          $temp.attr("contenteditable", true)
               .html($(copyTextarea).html()).select()
               .on("focus", function() { document.execCommand('selectAll',false,null) })
               .focus();
           var successful = document.execCommand("copy");
           var msg = successful ? 'successful' : 'unsuccessful';
           console.log('Copying text command was ' + msg);
          $('#'+model_name).modal('hide');
          $('.msgsuccess').html('Copied '+msg+' .<button type="button" class="close"><span aria-hidden="true">&times;</span></button>');
          $('.msgsuccess').show();
          //$('.msgsuccess').fadeOut( 7000, "linear" );
          $temp.remove();
        }
        catch (err) {
          console.log('Oops, unable to copy');
        }
      }*/

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


      $(document).on('click','.view_note',function() {

              var schedule_id = $(this).attr('data-schedule_id');
              console.log(schedule_id);

              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/viewNote'; ?>",
                  data:{schedule_id:schedule_id},
                  
                  beforeSend: function (req) {
                    console.log('before');
                   // Add this line
                      req.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                      $('.copy_link_box').addClass('text-center');
                      
                      $('.copy_link_box').html('<img src="<?php echo WEBROOT.'images/spinner.gif'; ?>" width="35px" />');
                      $('button.copy_schedule').hide();
                      $('#myModal').modal('show');
                   }, 
                  success:function(res)
                  {
                    //console.log(JSON.parse(res));
                    var result = JSON.parse(res);
                     /*var note = JSON.stringify(JSON.parse(result.note), undefined, 2);
                      var note_data = "<pre>"+note+"</pre>";
                      $('.copy_link_box').html('');

                      $('.copy_link_box').html(note_data);
                      $('#myModal').modal('show');*/
                      var note_data = "<pre>"+result.note+"</pre>";
                      var soapp_note_data = "<pre>"+result.soapp_summary+"</pre>";
                      var comm_note_data = "<pre>"+result.comm_summary+"</pre>";
                      var dast_note_data = "<pre>"+result.dast_summary+"</pre>";
                      var em_note_data = "<pre>"+result.em_line+"</pre>";

                      $('.copy_link_box').removeClass('text-center');
                      $('button.copy_schedule').show();
                      $('.copy_link_box').html('');

                      $('.copy_link_box').html(note_data);

                      $('#myModal .em_copy_link_box').html('');
                      $('#myModal .em_copy_link_box').html(em_note_data);

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
                      $('#myModal').modal('show');
                                         
                  }
               })
          });

      $('.view_ipc').on('click',function() {

              var schedule_id = $(this).attr('data-schedule_id');
              //console.log(schedule_id);

              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/viewNote'; ?>",
                  data:{schedule_id:schedule_id},
                  
                  beforeSend: function (req) {
                    console.log('before');
                   // Add this line
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
                    //console.log(res);
                    var result = JSON.parse(res);
                    //console.log(result);
                    
                      var basic_note_data = "<pre>"+result.patient_basic_detail+"</pre>";
                      var medical_note_data = "<pre>"+result.patient_medical_detail+"</pre>";
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

      $('.print_pdf').on('click',function(e) {
              var schedule_id = $(this).attr('data-schedule_id');
              console.log(schedule_id);

              $.ajax({
                  type:'POST',
                  url: "<?php echo SITE_URL.'/providers/dashboard/printPdf'; ?>",
                  data:{schedule_id:schedule_id},
                  
                  beforeSend: function (xhr) { // Add this line
                      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                   }, 
                  success:function(res)
                  {
                    console.log(res);
                     var result = JSON.parse(res);
                    //window.location.href = result.url;
                    window.open(result.url, '_blank');                                        
                  }
               })
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
    </script>
