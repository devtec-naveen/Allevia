<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $organizations->organization_name ?> Doctor List
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li class="active">Doctor List</li>
                            </ol>
                        </div>
                        <?php echo $this->Flash->render(); ?>
                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                             <th>Doctor Name</th>
                                             <th>Specialization</th>
                                             <th>Email</th> 
                                             <th>Action</th>                                              
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php 

                                        $Cms = [];
                                        
                                        $i = 1;

                                        foreach ($doctorList as $doctor): ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= h($doctor->doctor_name) ?></td>
                                           <td><?= h($doctor->specialization->name) ?></td>
                                          <td><?= h($doctor->email) ?></td> 
                                          <td>
                                          <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'viewDoctor', $doctor->id],['escape' => false,'class' => 'badge bg-black','style' => 'margin:1px;','target' =>'_blank']) ?>
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'editDoctor', $doctor->id],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;','target' =>'_blank']) ?>

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
            <!-- #END# Basic Examples -->
        </div>
        
    </section>