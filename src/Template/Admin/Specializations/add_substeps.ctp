<section class="content">
  <div class="container-fluid">
      <div class="row clearfix">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="card">
                <?= $this->Flash->render() ?>
                  <div class="header">                           
                    <h2>Add Sub Steps</h2>
                    <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                      <li>
                        <a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a>
                      </li>

                      <li>
                        <a href="<?= ADMIN_SITE_URL.'specializations'  ?>">Specializations</a>
                      </li>

                      <li class="active">Add</li>
                    </ol>
                  </div>

                  <div class="body">

                    <?php echo $this->Form->create(null, array('id'=>'add_organizations')); ?>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps1','class' => 'check_uncheck_first_3','value'=>'1',  'hiddenField' => false, is_array($inputsteps) && in_array(1, $inputsteps) ? 'checked' : '']); ?>
                            <label for="substeps1" class="form-label">Chief complaint</label>    
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>

                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps2','class' => 'check_uncheck_first_3','value'=>'2',  'hiddenField' => false, is_array($inputsteps) && in_array(2, $inputsteps) ? 'checked' : '']); ?>
                            <label for="substeps2" class="form-label">Chief complaint details</label>                                    
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps3','class' => 'check_uncheck_first_3','value'=>'3',  'hiddenField' => false, is_array($inputsteps) && in_array(3, $inputsteps) ? 'checked' : '']); ?>
                            <label for="substeps3" class="form-label">Associated symptoms</label>                                    
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps4','value'=>'4',  'hiddenField' => false, is_array($inputsteps) && in_array(4, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps4" class="form-label">Health questionnaire</label>                                    
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>

                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps5','value'=>'5',  'hiddenField' => false, is_array($inputsteps) && in_array(5, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps5" class="form-label">Summary</label>                                 
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>

                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps6','value'=>'6',  'hiddenField' => false, is_array($inputsteps) && in_array(6, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps6" class="form-label">Chief complaint Other Details</label>                                    
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>

                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps7','value'=>'7',  'hiddenField' => false, is_array($inputsteps) && in_array(7, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps7" class="form-label">General updates</label>                                    
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>

                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps8','value'=>'8',  'hiddenField' => false, is_array($inputsteps) && in_array(8, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps8" class="form-label">Pain updates</label>                                    
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps9','value'=>'9',  'hiddenField' => false, is_array($inputsteps) && in_array(9, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps9" class="form-label">Screening</label>                                    
                          </div>
                        </div>
   
   
                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps10','value'=>'10',  'hiddenField' => false, is_array($inputsteps) && in_array(10, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps10" class="form-label">Post-procedure Checkup Detail</label>                                    
                          </div>
                        </div>


                       <div class="form-group form-float">
                         <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps11','value'=>'11',  'hiddenField' => false, is_array($inputsteps) && in_array(11, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps11" class="form-label">Pre-Operation Procedure Details</label>                                    
                          </div>
                        </div>

                       <div class="form-group form-float">
                         <div>

                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps12','value'=>'12',  'hiddenField' => false, is_array($inputsteps) && in_array(12, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps12" class="form-label">Pre-Operation Medications</label>                                    
                          </div>
                        </div>


                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps13','value'=>'13',  'hiddenField' => false, is_array($inputsteps) && in_array(13, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps13" class="form-label">Pre-Operation Allergies</label>
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps14','value'=>'14',  'hiddenField' => false, is_array($inputsteps) && in_array(14, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps14" class="form-label">Select Disease</label>
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps15','value'=>'15',  'hiddenField' => false, is_array($inputsteps) && in_array(15, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps15" class="form-label">Disease Detail</label>
                          </div>
                        </div>  

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps16','value'=>'16',  'hiddenField' => false, is_array($inputsteps) && in_array(16, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps16" class="form-label">Medicine Refill Extra Details</label>
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps17','value'=>'17',  'hiddenField' => false, is_array($inputsteps) && in_array(17, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps17" class="form-label">Follow Up Detail</label>
                          </div>
                        </div> 

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps18','value'=>'18',  'hiddenField' => false, is_array($inputsteps) && in_array(18, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps18" class="form-label">CDC COVID-19 Screening</label>
                          </div>
                        </div>

                        <div class="form-group form-float">
                          <div>
                            <?php echo $this->Form->checkbox('substeps.', ['id' => 'substeps19','value'=>'19',  'hiddenField' => false, is_array($inputsteps) && in_array(19, $inputsteps) ? 'checked' : '']); ?>
                             <label for="substeps19" class="form-label">PHQ-9</label>
                          </div>
                        </div>    
                                 
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add Steps</button>                           
                                
                      </div>
                  <?php echo $this->Form->end()?>
              </div>
          </div>
      </div>
  </div>
</section>


<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"].check_uncheck_first_3').change(function(){
            if($(this).prop("checked") == true){
                $('input[type="checkbox"].check_uncheck_first_3').prop('checked', true);
                alert("First 3 options are interlinked.");
            } else if($(this).prop("checked") == false){
               $('input[type="checkbox"].check_uncheck_first_3').prop('checked', false);
                alert("First 3 options are interlinked.");
            }
        });
    });
</script>