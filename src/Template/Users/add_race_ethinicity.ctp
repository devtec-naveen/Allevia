<?php 
   use Cake\Core\Configure;
   $session_user = $this->request->getSession()->read('Auth.User');
   $apt_id = isset($this->request->params['pass'][0])?$this->request->params['pass'][0]:'';
   $next_steps = isset($this->request->params['pass'][1])?$this->request->params['pass'][1]:'';
   $step_id = isset($this->request->params['pass'][2])?$this->request->params['pass'][2]:'';
   $apt_id_data_schedule_id =  isset($this->request->params['pass'][3])?$this->request->params['pass'][3]:'';
   $iframe_prefix = Configure::read('iframe_prefix');
   ?>
<link href="<?php echo WEBROOT.'frontend/css/new_appointment.css'; ?>" rel="stylesheet" type="text/css">
<script src="<?php echo WEBROOT.'frontend/js/new_appointment.js'; ?>"></script>
<div class="wraper">
   <div class="inner_page_content">
      <div class="dashboard_content_bg">
         <div class="container">
            <div class="dashboard_content_inner">
               <?php if(empty($iframe_prefix)){ ?>
               <div class="dashboard_menu">
                  <ul>
                     <?php if(!empty($session_user) && $session_user['role_id'] == 2){ ?>
                <!--      <li class="active">
                        <a href="<?= SITE_URL?>users/new-appointment/<?= base64_encode($apt_id_data_schedule_id) ?>">
                        <i></i>
                        <span>Pre-appointment questionnaire</span>
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
                        <span>Previous Appointments</span>
                        </a>
                     </li>
                     <li>
                        <a href="<?= SITE_URL?>users/medicalhistory">
                        <i></i>
                        <span>Edit Medical History</span>
                        </a>
                     </li> -->
                     <?php } ?>
                  </ul>
               </div>
               <?php } ?>
               <?php
                  echo $this->Form->create(null , array('autocomplete' => 'off',
                  			'inputDefaults' => array(
                  			'label' => false,
                  			'div' => false,
                  			),'enctype' => 'multipart/form-data', 'id' => 'add_race'));
                   	?>		    	
               <input type="hidden" name="apt_id" value="<?php echo $apt_id ?>"/>
               <input type="hidden" name="next_steps" value="<?php echo $next_steps ?>"/>
               <input type="hidden" name="step_id" value="<?php echo $step_id?>"/>
               <input type="hidden" name="schedule_id" value="<?php echo $apt_id_data_schedule_id ?>"/>
               <div class="dashboard_content animated fadeInRight">
                  <?= $this->Flash->render() ?>
                  <div class="dashboard_head header-sticky-tit">
                     <h2>Clinically required information</h2>
                  </div>
                  <div class="errorHolder"></div>
                  <div class="dashboard_appointments_box">
                     <div class="new_appointment_form">
                        <div>
                           <p>What is your race?</p>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group form_fild_row">
                                 <select name="clinical_race" class="form-control" required="required">
                                    <?php $race = array('1' =>'American Indian or Alaska Native',
                                       '2' =>'Asian',
                                       '3' =>'Black or African American',
                                       '4' =>'Native Hawaiian or Other Pacific Islander',
                                       '5' =>'White',
                                       '6' =>'Other Race'); ?>	
                                    <option value="">Select Race</option>
                                    <?php foreach ($race as $key => $value) {
                                       ?>
                                    <option value="<?= $key ?>" <?php if(!empty($userInfo) && $userInfo['clinical_race'] == $key){ echo 'selected'; } ?>><?= $value ?> </option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div>
                           <p>What is your ethnicity?</p>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="radio_bg">
                                 <div class="form-group form_fild_row">
                                    <div class="radio_bg">
                                       <div class="radio_list">
                                          <div class="form-check right">
                                             <input type="radio" value="1" class="form-check-input" name="clinical_ethnicity" id="radio_question6"  required="true" <?php echo $userInfo['clinical_ethnicity'] =='1' ?'checked':'' ?>>
                                             <label class="form-check-label" for="radio_question6">Hispanic or Latino</label>
                                          </div>
                                          <div class="form-check left">
                                             <input type="radio" value="2" class="form-check-input" name="clinical_ethnicity" id="radio_question7"  required="true" <?php echo $userInfo['clinical_ethnicity'] =='2' ?'checked':'' ?>>
                                             <label class="form-check-label" for="radio_question7">Not Hispanic or Latino</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form_submit_button">
                           <button type="submit" id="doctor_submit" class="btn waves-effect waves-light">Submit</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php $this->Form->end() ;?>
      </div>
   </div>
</div>
</div>
</div>

