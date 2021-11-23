<?php
use Cake\Utility\Security;
//pr($global_settings);
?>
<div class="inner-wraper">
   <?php $i = 0;?>
   <div class="row">
      <div class="col-md-12">
         <?= $this->Flash->render() ?>
         <div class="card">
            <div class="card-header d-flex">
               <h4 class="header-title mt-2 mr-5">Sendgrid Settings</h4>
            </div>
            <div class="card-body">
               <?php echo $this->Form->create(null, array('id'=>'edit_organizations','enctype'=>'multipart/form-data')); ?>
               
               <div class="form-group form-float">
                  <div class="form-line">
                    <label class="form-label">Sendgrid Email</label>
                     <?php echo $this->Form->input("sendgrid_email" , array("type" => "text", "class" => "form-control",'placeholder'=>'Enter email','data-msg-required'=>'Enter email','label' => false, 'value'  => (!empty($global_settings->sendgrid_email) ? Security::decrypt(base64_decode($global_settings->sendgrid_email),SEC_KEY): "") ));?>
                     
                  </div>
               </div>
               <div class="form-group form-float">
                  <div class="form-line">
                    <label class="form-label">Sendgrid Api Key</label>
                     <?php echo $this->Form->input("sendgrid_api_key" , array("type" => "text", "class" => "form-control",'placeholder'=>'Enter endgrid api key','data-msg-required'=>'Enter sendgrid api key','label' => false, 'value'  => (!empty($global_settings->sendgrid_api_key) ? Security::decrypt(base64_decode($global_settings->sendgrid_api_key),SEC_KEY): "")));?>                     
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
</div>

