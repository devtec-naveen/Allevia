<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
        <?= $this->Flash->render() ?>
        <div class="card">          
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Timezone Setting</h4>
          </div>
          <div class="card-body">
            <?php echo $this->Form->Create(null, array('id'=>'add_organizations')); ?>             
               <div class="form-group form-float">
                  <div>
                    <input type="radio" name="timezone" value="CST" id="CST" <?php echo $user_data->timezone == 'CST' ? "checked" : ""; ?>>                                
                    <label for="CST" class="form-label">
                      <span><strong>CST</strong></span>
                    </label>    
                  </div>
                </div>
                <div class="form-group form-float">
                  <div>
                    <input type="radio" name="timezone" value="MST" id="MST" <?php echo $user_data->timezone == "MST" ? "checked" : ""; ?>>                                
                    <label for="MST" class="form-label">
                      <span><strong>MST</strong></span>
                    </label>    
                  </div>
                </div>


                <div class="form-group form-float">
                  <div>
                    <input type="radio" name="timezone" value="EST" id="EST" <?php echo $user_data->timezone == 'EST' ? "checked" : ""; ?>>                                
                    <label for="EST" class="form-label">
                      <span><strong>EST</strong></span>
                    </label>    
                  </div>
                </div>
                <div class="form-group form-float">
                  <div>
                    <input type="radio" name="timezone" value="PST" id="PST" <?php echo $user_data->timezone == "PST" ? "checked" : ""; ?>>                                
                    <label for="PST" class="form-label">
                      <span><strong>PST</strong></span>
                    </label>    
                  </div>
                </div>
                <div class="form-group form-float">
                  <div>
                    <input type="radio" name="timezone" value="HST" id="HST" <?php echo $user_data->timezone == "HST" ? "checked" : ""; ?>>                                
                    <label for="HST" class="form-label">
                      <span><strong>HST</strong></span>
                    </label>    
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