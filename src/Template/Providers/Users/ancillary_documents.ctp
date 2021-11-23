<div class="inner-wraper">
 <div class="row">     
  <div class="col-md-12">
    <?= $this->Flash->render() ?>
    <div class="card">          
      <div class="card-header d-flex">
        <h4 class="header-title mt-2 mr-5">Ancillary Documents</h4>
      </div>
      <div class="card-body">
        <?php
        if(!empty($user_data['organization']) && (!empty($user_data['organization']['treatment_consent_docs']) || !empty($user_data['organization']['privacy_policy_docs']))){ ?>

          <div>
            <h5>Uploaded Documents</h5>

            <?php if(!empty($user_data['organization']['privacy_policy_docs'])){ ?>
              <div>
                <a href="<?php echo WEBROOT.'uploads/ancillary_docs/'.$user_data['organization']['privacy_policy_docs']; ?>" target="_blank"><strong>Privacy Policy Docs</a> 
                </div>
              <?php } ?>

              <?php if(!empty($user_data['organization']['treatment_consent_docs'])){ ?>
                <div>
                  <a href="<?php echo WEBROOT.'uploads/ancillary_docs/'.$user_data['organization']['treatment_consent_docs']; ?>" target="_blank"><strong>Consent For Treatment Docs</strong></a> 
                </div>
              <?php } ?>
            </div>

            <hr>
            <br>
          <?php }
          ?>
          <?php echo $this->Form->Create(null, array('id'=>'add_organizations','enctype' => 'multipart/form-data')); ?>

          <div class="form-group form-float">
            <div class="custom-control custom-checkbox">                                
              <input type="checkbox" name="is_show_ancillary_docs" value="1" id="is_show_ancillary_docs" class='custom-control-input check_had_shot' <?php if(!empty($user_data['organization']) && $user_data['organization']['is_show_ancillary_docs'] == 1){ echo 'checked = "checked"'; } ?> >
              <label for="is_show_ancillary_docs" class="custom-control-label">Show Ancillary Documents</label>
            </div>
          </div>

          <div class="form-group form-float">                
            <div class=""> 
              <label for="column1" class="form-label">
                Privacy Policy
              </label>                              
              <input type="file" name="privacy_policy_docs" id="column1" style="margin-left: 85px;">

            </div>
          </div>

          <div class="form-group form-float">                             
            <div class=""> 
              <label for="column2" class="form-label">
                Consent For Treatment
              </label>                               
              <input type="file" name="treatment_consent_docs" id="column2" style="margin-left: 28px;">
            </div>
          </div>


          <div class="btns">               
           <button class="btn btn-blue" type="submit">Update</button>                   
         </div>
         <?php echo $this->Form->end()?>
       </div>
     </div>
   </div>
 </div>
</div>  