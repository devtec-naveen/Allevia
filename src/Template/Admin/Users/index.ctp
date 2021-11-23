<?php 
use Cake\Utility\Security;
?>
<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Users
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Users</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table responsive table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                          <tr>
                                           <!-- <th scope="col"><input type="checkbox" id="checkAll" class="minimal"><label for="checkAll"></label></th> -->
                                           <th style="width: 50px;">Sr. No.</th>
           
                                           <th style="width: 50px;">First Name</th>
                                           <th style="width: 50px;">Last Name</th>
                                           <th>Gender</th>                                           
                                           <th>Email Address</th>
                                           <th>Phone</th>
                                           <th>status</th>
                                           <!-- <th>created</th> -->
                                           <th class="actions"><?= __('Actions') ?></th>
                                         </tr>
                                    </thead>
                                     <tbody>
                                        <?php $i = 1;

                                        foreach ($users as $user): ?>
                                        <tr>
                                 <!--        <td><input type="checkbox" id="users<?= $i?>" class="minimal"><label for="users<?= $i?>"></label></td> -->
                                        <td><?= $i ?></td>
                                    
                                        <td><?php 

                                      if(!empty($user->first_name))
                                        echo  h($this->CryptoSecurity->decrypt( base64_decode($user->first_name), SEC_KEY)); ?>
                                          
                                        </td>
                                        <td>
                                          <?php 

                                        if(!empty($user->last_name))
                                          echo  h($this->CryptoSecurity->decrypt( base64_decode($user->last_name), SEC_KEY)); ?>
                                            

                                          </td>
                                        <td><?php 
                                      if(!empty($user->gender))
                                        echo (Security::decrypt( base64_decode($user->gender), SEC_KEY) == 0)? 'Female' : 'Male' ;

                                        ?></td>
                                        
                                        <td><?= h($this->CryptoSecurity->decrypt( base64_decode($user->email), SEC_KEY)) ?></td>
                                        <td><?= h($this->CryptoSecurity->decrypt( base64_decode($user->phone), SEC_KEY)) ?></td>
                                        <td><?php  if($user->status == 1){ ?>
                                            <span class="badge bg-green deactive" style="cursor:pointer" id="userid<?php echo $user->id ?>" data-status="active"   data-id="<?php echo $user->id ?>">Active</span>
                                           <?php  }
                                            else {  ?>
                                             <span class="badge bg-red deactive" style="cursor:pointer"  id="userid<?php echo $user->id ?>" data-status="inactive"  data-id="<?php echo $user->id ?>">Inactive</span>
                                        <?php   }  ?></td>
                                        <!-- <td><?php // echo  h($user->created) ?></td> -->
                                        <td class="actions">

<?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $user->id],['escape' => false,'class' => 'badge bg-black', 'style' => 'margin:2px;']) ?>
<?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', $user->id],['escape' => false,'class' => 'badge bg-blue', 'style' => 'margin:2px;']) ?>

<?php

               if($user->status==1){  
                    echo $this->Html->link($this->Html->tag('i','close',array('class'=>'material-icons')), ['action' => 'deactive', $user->id],['escape' => false,'class' => 'badge bg-orange','title' =>'Deactivate', 'style' => 'margin:2px;']) ; 

                 } else{

                   echo $this->Html->link($this->Html->tag('i','check',array('class'=>'material-icons')), ['action' => 'active', $user->id],['escape' => false,'class' => 'badge bg-green', 'title' =>'Activate','style' => 'margin:2px;']) ; 



                 }


                   echo $this->Html->link($this->Html->tag('i','delete',array('class'=>'material-icons')), ['action' => 'delete', $user->id],['escape' => false,'class' => 'badge bg-red', 'title' =>'Delete','style' => 'margin:2px;', 'confirm'=>'Are you sure?']) ; 

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