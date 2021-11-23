<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Manage location
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li class="active">Clinic location</li>
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
                                             <th>Location</th>
                                             <th>Created</th>                                             
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php

                                        if(isset($allLocation) && !empty($allLocation)){

                                        $i = 1;                                        
                                        foreach ($allLocation as $location): ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= h($location->organization->organization_name) ?></td>
                                          <td><?= h($location->location) ?></td>
                                          <td><?= h($location->created) ?></td>
                                          <!-- <td><?php // echo  h($doctor->modified) ?></td> -->
                                        <td class="actions">                                        
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'editLocation', base64_encode($location->id)],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;']) ?>


<?php 
                   echo $this->Html->link($this->Html->tag('i','delete',array('class'=>'material-icons')), ['action' => 'deleteLocation', $location->id],['escape' => false,'class' => 'badge bg-red', 'title' =>'Delete','style' => 'margin:1px;', 'confirm'=>'Are you sure?']) ; 
 ?>  

                                       </td>
                                     </tr>
                                     <?php  $i++; endforeach; ?>
                                 <?php } ?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <!-- #END# Basic Examples -->

            <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'addLocation'],['escape' => false,'class' => 'btn btn-primary btn-circle-lg waves-effect waves-circle waves-float sticky-btn-add', 'title' => 'Add Location']) ?>
        </div>
    </section>