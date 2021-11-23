<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
        <?= $this->Flash->render() ?>
        <div class="card">          
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Telehealth Setting</h4>
          </div>
          <div class="card-body">
            <?php echo $this->Form->Create(null, array('id'=>'add_organizations')); ?>             
               <div class="form-group form-float">
                  <div>
                    <input type="radio" name="is_telehealth_provider" value="0" id="column1" <?php echo $user_data->is_telehealth_provider == 0 ? "checked" : ""; ?>>                                
                    <label for="column1" class="form-label">
                      <span><strong>In-person</strong></span>
                    </label>    
                  </div>
                </div>
                <div class="form-group form-float">
                  <div>
                    <input type="radio" name="is_telehealth_provider" value="1" id="column2" <?php echo $user_data->is_telehealth_provider == 1 ? "checked" : ""; ?>>                                
                    <label for="column2" class="form-label">
                      <span><strong>Telehealth</strong></span>
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