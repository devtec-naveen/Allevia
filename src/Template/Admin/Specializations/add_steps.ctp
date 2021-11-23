<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
   <?= $this->Flash->render() ?>
                        <div class="header">
                         
                            <h2>
                                Add Steps
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'specializations'  ?>">Specializations</a></li>
                                <li class="active">Add</li>
                            </ol>
                        </div>

                        <div class="body">

                                 <?php echo $this->Form->create(null, array('id'=>'add_organizations')); ?>
        
                                <div class="form-group form-float">
                  <?php 
                  $i = 1; 
                  foreach ($step_detial as $key => $value) {
                  ?>
                                   <div>
     <!--       1 - symptom compliant, 2- annual exam, 3 - lab check, 4 - medication refill, 5- well woman exam -->
    <?php echo $this->Form->checkbox('steps.', ['id' => 'step'.$i,'value'=>$value->id,  'hiddenField' => false, is_array($inputsteps) && in_array($value->id, $inputsteps) ? 'checked' : '']); ?>
       <label for="<?= 'step'.$i ?>" class="form-label"><?= $value->step_name ?></label>
      
                                  </div>
                  <?php
                  $i++; 
                  }

                  ?>
 
                                  </div>
 
 
 
                                   
                                  
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add Steps</button>
                               
                                
                                </div>
                                <!-- /.box-body -->

                             <?php echo $this->Form->end()?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>
