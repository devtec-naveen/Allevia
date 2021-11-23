<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
         <?= $this->Flash->render() ?>
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Change Password</h4>
          </div>
          <div class="card-body">
          <?php echo $this->Form->create($user, array('id'=>'edit_profile','type' => 'file')); ?>           
             
               <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Old Password</label>
                                         <?php echo $this->Form->input("old_password" , array("type" => "password", "class" => "form-control",'title'=>'Enter Old Password','data-msg-required'=>'Enter Password *','label' => false));?>
                                        
                                    </div>
                </div>
                               
                <div class="form-group form-float">
                    <div class="form-line">
                         <label class="form-label">Password</label>
                         <?php echo $this->Form->input("password" , array("type" => "password", "class" => "form-control",'title'=>'Enter Password','data-msg-required'=>'Enter Password *','label' => false));?>
                       
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <label class="form-label">Confirm Password</label>
                         <?php echo $this->Form->input("confirm_password" , array("type" => "password","class" => "form-control",'title'=>'Enter Confirm Password','data-msg-required'=>'Enter Confirm Password *','label' => false));?>
                        
                    </div>
                </div>


             <div class="btns">               
               <button class="btn btn-blue" type="submit">Update Profile</button>                   
             </div>
            <?php echo $this->Form->end()?>
          </div>
         </div>
      </div>
     </div>
   </div>  