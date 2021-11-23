<?php 
use Cake\Utility\Security;
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Appointments List
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Appointments List </li>
                            </ol>
                        </div>

<div class="header">
          <?php //  echo  $this->Form->control('dob', ['type' => 'text', 'value' => (isset($user->dob)? $user->dob->i18nFormat('dd-MM-yyyy') : '') , 'class' => 'form-control', 'placeholder' => 'DOB', 'label' => false,  'id'=>'datetimepicker1', 'autocomplete' => 'off', 'required' => 'required']); ?>
   <?php echo $this->Form->create(null , array(   'autocomplete' => 'off', 
                                        
                            'inputDefaults' => array(
                            'label' => false,
                            'div' => false,
                                            
                            ),'enctype' => 'multipart/form-data')); ?>
                                           
    <input type="text" value="<?php echo isset($filter_start_date)? $filter_start_date->i18nFormat('MM-dd-yyyy') : '' ?>" name="start_date"  id='datetimepicker1' placeholder="Start Date">
    <input type="text" value="<?php echo isset($filter_end_date)? $filter_end_date->i18nFormat('MM-dd-yyyy') : '' ?>" name="end_date"  id='datetimepicker2' placeholder="End Date">  
    <input type="submit" class="btn btn-info" name="Filter" value="Filter">           
  <?php $this->Form->end(); ?>  

   <script>
  $( function() {
    $( "#datetimepicker1" ).datepicker({
            changeMonth: true, 

    changeYear: true, 

  dateFormat: "mm-dd-yy" // "dd-mm-yy"
});

    $( "#datetimepicker2" ).datepicker({
            changeMonth: true, 

    changeYear: true, 

  dateFormat: "mm-dd-yy" // "dd-mm-yy"
});

  } );
  </script>
</div>

                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr No.</th>
                                             <th>Patient</th>
                                             <th>Clinic</th>
                                             <th>Doctor</th>
                                             <th>Specialization</th>
                                             <th>Created</th>
                                              <th><?= __('Actions') ?></th> 
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php
                                         $Cms = [];
                                         $i = 1;

                                        foreach ($organizations as $cmspage): ?>
                                        <tr>
                                        <td><?= $i ?></td>

                                          <td><?= isset($cmspage->user->first_name) && !empty($cmspage->user->first_name) ? $this->CryptoSecurity->decrypt( base64_decode($cmspage->user->first_name), SEC_KEY).' '.(isset($cmspage->user->last_name) && !empty($cmspage->user->last_name) ? $this->CryptoSecurity->decrypt( base64_decode($cmspage->user->last_name), SEC_KEY) :"") : '' ?></td>
                                          <td><?= $cmspage->organization->organization_name ?></td>
                                          <td><?= $cmspage->doctor->doctor_name  ?></td>
                                          <td><?=  $cmspage->specialization->name ?></td>
                         <td><?php  echo  $cmspage->created->i18nFormat('MM-dd-yyyy'); ?></td>
                                    <td class="actions">
                                          <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $cmspage->id],['escape' => false,'class' => 'badge bg-blue']) ?>
                                       </td>

                                         <?php /* 
                                        <td class="actions">
                                          <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $cmspage->id],['escape' => false,'class' => 'badge bg-blue']) ?>
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', $cmspage->id],['escape' => false,'class' => 'badge bg-blue']) ?>
                                       </td>
                                       */ ?>
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