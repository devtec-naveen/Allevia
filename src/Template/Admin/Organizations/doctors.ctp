<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Doctors
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li class="active">Doctor</li>
                            </ol>
                        </div>
                        <?php echo $this->Flash->render(); ?>
                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                             <th>Clinic Name</th>
                                             <th>Doctor Name</th>
                                             <th>Specialization</th>
                                             <th>Credentials</th>
                                             <th>created</th>
                                             <!-- <th>modified</th> -->
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php 
                                        $Cms = [];

                                        $i = 1;

                                        foreach ($doctors as $doctor): ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= h($doctor->organization->organization_name) ?></td>
                                          <td><?= h($doctor->doctor_name) ?></td>
                                          <td><?= h(isset($doctor->specialization_id) ? $doctor->specialization_id : '') ?></td>
                                          <td><?php   echo  h($doctor->credentials) ?></td>
                                          <td><?= h($doctor->created) ?></td>
                                          <!-- <td><?php // echo  h($doctor->modified) ?></td> -->
                                        <td class="actions">
                                          <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'viewDoctor', $doctor->id],['escape' => false,'class' => 'badge bg-black','style' => 'margin:1px;']) ?>
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'editDoctor', $doctor->id],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;']) ?>

<?php
               if($doctor->status==1){  
                    echo $this->Html->link($this->Html->tag('i','close',array('class'=>'material-icons')), ['action' => 'deactiveDoctor', $doctor->id],['escape' => false,'class' => 'badge bg-orange','title' =>'Deactivate', 'style' => 'margin:1px;']) ; 

                 } else{

                   echo $this->Html->link($this->Html->tag('i','check',array('class'=>'material-icons')), ['action' => 'activeDoctor', $doctor->id],['escape' => false,'class' => 'badge bg-green', 'title' =>'Activate','style' => 'margin:1px;']) ; 



                 }
?>


<?php 
                   echo $this->Html->link($this->Html->tag('i','delete',array('class'=>'material-icons')), ['action' => 'deleteDoctor', $doctor->id],['escape' => false,'class' => 'badge bg-red', 'title' =>'Delete','style' => 'margin:1px;', 'confirm'=>'Are you sure?']) ; 
 ?>  

                                       </td>
                                     </tr>
                                     <?php  $i++; endforeach; ?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'addDoctor'],['escape' => false,'class' => 'btn btn-primary btn-circle-lg waves-effect waves-circle waves-float sticky-btn-add', 'title' => 'Add Doctor']) ?>
            <!-- #END# Basic Examples -->
        </div>
    </section>