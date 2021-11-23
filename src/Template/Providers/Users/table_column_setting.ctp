<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
        <?= $this->Flash->render() ?>
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Display Columns</h4>
          </div>
          <div class="card-body">
          <?php echo $this->Form->Create(null, array('id'=>'add_organizations'));     ?>              
               <?php
                   if(count($columns)){
                            $i= 1;
                            foreach ($columns as $key => $value) { ?>
                             <!--  <div class="custom-control custom-checkbox">

                              <input name="shots_history[223][shot_id]" value="223" class="custom-control-input check_had_shot" id="shotid223" type="checkbox" style="cursor: pointer;">
                              <label class="custom-control-label" for="shotid223">I've had this shot.</label>
                             </div> -->
                             
                             <div class="form-group form-float">
                              <div class="custom-control custom-checkbox">
                                <?php echo $this->Form->checkbox('columns.', ['id' => 'column'.$i,'class' => 'custom-control-input check_had_shot','value'=>$value->id,  'hiddenField' => false, $value->is_show == 1 ? 'checked' : '']); ?>
                                <label for="<?php echo 'column'.$i; ?>" class="custom-control-label"><?php echo $value->title; ?></label>    
                              </div>
                            </div>

                  <?php       $i++;
                            }
                        }
                     ?>               
             <div class="btns">               
               <button class="btn btn-blue" type="submit">Update</button>                   
             </div>
            <?php echo $this->Form->end()?>
          </div>
         </div>
      </div>
     </div>
   </div>  