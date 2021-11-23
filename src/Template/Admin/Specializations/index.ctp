<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Specializations
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Specializations</li>
                            </ol>
                        </div>
                        <div class="body">
                            <?= $this->Flash->render() ?>
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                             <th>Specialization Name</th>
                                             <th>created</th>
                                             <th>modified</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php 

                                        $Cms = [];
                                        
                                        $i = 1;

                                        foreach ($organizations as $organization): ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= h($organization->name) ?></td>
                                          <td><?= h($organization->created) ?></td>
                                          <td><?= h($organization->modified) ?></td>
                                        <td class="actions">
                                          <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $organization->id],['escape' => false,'class' => 'badge bg-blue']) ?>
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', $organization->id],['escape' => false,'class' => 'badge bg-blue']) ?>&nbsp;

   <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'addSteps', $organization->id],['escape' => false,  'title' => 'Add Steps' ,'class' => 'badge bg-blue']) ?>&nbsp;

<?php

               if($organization->status==1){  
                    echo $this->Html->link($this->Html->tag('i','close',array('class'=>'material-icons')), ['action' => 'deactive', $organization->id],['escape' => false, 'title' => 'Deactivate'   ,'class' => 'badge bg-blue']) ; 

                 } else{

                   echo $this->Html->link($this->Html->tag('i','check',array('class'=>'material-icons')), ['action' => 'active', $organization->id],['escape' => false,  'title' => 'Activate'    ,'class' => 'badge bg-blue']) ; 



                 }
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
        <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'add'],['escape' => false,'class' => 'btn btn-primary btn-circle-lg waves-effect waves-circle waves-float sticky-btn-add', 'title' => 'Add Specialization']) ?>
            <!-- #END# Basic Examples -->
        </div>
        
    </section>