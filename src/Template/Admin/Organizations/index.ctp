<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Clinics
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Clinics</li>
                            </ol>
                        </div>
                        <?php echo $this->Flash->render(); ?>
                        <div class="body">
                            <div class="table-responsive">

                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                             <th>Logo</th>
                                             <th>Clinic Name</th>
                                             <th>Access Code</th>
                                             <th>Specializations</th>
                                             <th>Location</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php
                                        $Cms = [];                                        
                                        $i = 1;
                                        foreach ($organizations as $organization){ ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td>
                                            <?php 
                                            if(!empty($organization->clinic_logo)) {
                                            ?>                    
                                              <img width="50px" height="50px" src="<?php echo WEBROOT.'img/'.$organization->clinic_logo; ?>">
                                            <?php } ?>                                             

                                          </td>
                                          <td><?= h($organization->organization_name) ?></td>
                                          <td><?= h($organization->access_code) ?></td>
                                          <td><?= h($organization->specialization_ids) ?></td>
                                          <td><?= h($organization->org_location) ?></td>
                                          <td class="actions">
                                            <?= $this->Html->link($this->Html->tag('i','remove_red_eye',array('class'=>'material-icons')), ['action' => 'view', $organization->id],['escape' => false,'class' => 'badge bg-black','style' => 'margin:1px;']) ?>
                                            <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', $organization->id],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;']) ?>
                                            <?php
                                             if($organization->status==1){  
                                                  echo $this->Html->link($this->Html->tag('i','close',array('class'=>'material-icons')), ['action' => 'deactive', $organization->id],['escape' => false,'class' => 'badge bg-orange','title' =>'Deactivate', 'style' => 'margin:1px;']) ;
                                               } 
                                               else
                                               {
                                                 echo $this->Html->link($this->Html->tag('i','check',array('class'=>'material-icons')), ['action' => 'active', $organization->id],['escape' => false,'class' => 'badge bg-green', 'title' =>'Activate','style' => 'margin:1px;']) ;
                                               }
                                            ?>
                                            <?php 
                                              echo $this->Html->link($this->Html->tag('i','delete',array('class'=>'material-icons')), ['action' => 'delete', $organization->id],['escape' => false,'class' => 'badge bg-red', 'title' =>'Delete','style' => 'margin:1px;', 'confirm'=>'Are you sure?']) ; 

                                              echo $this->Html->link($this->Html->tag('i','format_color_fill',array('class'=>'material-icons')), ['action' => 'clinicColorScheme', $organization->id],['escape' => false,'class' => 'badge bg-green', 'title' => 'Clinic color scheme','style' => 'margin:1px;']) ; 

                                              // radio button for making test clinic that will print the json output instead of sending to the EHR api
                                              if($organization->make_test_clinic ==1){  
                                                  echo $this->Html->link($this->Html->tag('i','radio_button_checked',array('class'=>'material-icons')), ['action' => 'maketestclinic', $organization->id, 0],['escape' => false,'class' => 'badge bg-red','title' =>'Remove Test clinic status', 'style' => 'margin:1px;']) ; 

                                               } else{

                                                 echo $this->Html->link($this->Html->tag('i','radio_button_unchecked',array('class'=>'material-icons')), ['action' => 'maketestclinic', $organization->id, 1],['escape' => false,'class' => 'badge bg-green', 'title' =>'Make Test clinic','style' => 'margin:1px;']) ; 
                                               }
                                            ?> 

                                            <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'addProviders', $organization->id],['escape' => false,'class' => 'badge bg-black','style' => 'margin:1px;' ,'title' =>'Add provider portal email access']) ?>

                                            <?= $this->Html->link($this->Html->tag('i','radio_button_checked',array('class'=>'material-icons')), ['action' => 'outputFormat', base64_encode($organization->id)],['escape' => false,'class' => 'badge bg-blue', 'title' =>'Update output format','style' => 'margin:1px;']) ?> 

                                            <?= $this->Html->link($this->Html->tag('i','person_add',array('class'=>'material-icons')), ['action' => 'clinicDoctorList', base64_encode($organization->id)],['escape' => false,'class' => 'badge bg-blue', 'title' =>'Doctor List','style' => 'margin:1px;']) ?> 

                                            <?= $this->Html->link($this->Html->tag('i','person',array('class'=>'material-icons')), ['action' => 'clinicProviderList', base64_encode($organization->id)],['escape' => false,'class' => 'badge bg-blue', 'title' =>'Provider List','style' => 'margin:1px;']) ?>  
                                          <?php 
                                            if(!empty($organization->client_id) && !empty($organization->client_secret) && $organization->show_credential == 0){
                                          ?>
                                              <a href="javascript:;" class="btn btn-primary showcredential credential_<?php echo  $organization->id ?>" data-type="1" data-id="<?php echo $organization->id ?>" title = "Show Credential"><i class="material-icons">code</i></a>
                                          <?php 
                                            }
                                          ?>
                                          <a href="<?php echo SITE_URL?>/admin/organizations/generateorgsecret/<?php echo base64_encode($organization->id)?>" class="btn btn-primary generatenew t" data-id="<?php echo $organization->id ?>" title = "Generate New Credential"><i class="material-icons">autorenew</i></a>

                                         <?php                                            
                                            if(!empty($organization->user_id) ){
                                          ?>
                                          <a href="<?php echo SITE_URL?>/admin/organizations/reset_link/<?php echo base64_encode($organization->id)?>" class="btn btn-primary generatenew t" data-id="<?php echo $organization->id ?>" title = "Reset Password Email"><i class="material-icons">email</i></a>  
                                          <?php }?>  

                                          <?= $this->Html->link($this->Html->tag('i','location_on',array('class'=>'material-icons')), ['action' => 'locations', base64_encode($organization->id)],['escape' => false,'class' => 'badge bg-red','style' => 'margin:1px;' ,'title' =>'Manage location']) ?>

                                          <?php
                                             // if($organization->is_show_insurance==1){  
                                             //      echo $this->Html->link($this->Html->tag('i','close',array('class'=>'material-icons')), ['action' => 'deactiveInsurance', $organization->id],['escape' => false,'class' => 'badge bg-red','title' =>'Deactivate Insurance', 'style' => 'margin:1px;']) ;
                                             //   } 
                                             //   else
                                             //   {
                                             //     echo $this->Html->link($this->Html->tag('i','check',array('class'=>'material-icons')), ['action' => 'activeInsurance', $organization->id],['escape' => false,'class' => 'badge bg-green', 'title' =>'Activate Insurance','style' => 'margin:1px;']) ;
                                             //   }
                                            ?>                                         
                                       </td>
                                     </tr>
                                    
                                     <?php  $i++; 
                                        }
                                     ?>
                                   </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'add'],['escape' => false,'class' => 'btn btn-primary btn-circle-lg waves-effect waves-circle waves-float sticky-btn-add', 'title' => 'Add Clinic']) ?>
            <!-- #END# Basic Examples -->
        </div>
        
    </section>
 <style type="text/css">    
       .note_view_model{
          max-width: 70% !important;
       }
   </style>


      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">API credential</h5>       
          </div>
          <div class="modal-body">
            <div class="message" style="color:green"></div>
            <div>
              <h5>Client Id</h5><a href="javascript:;" onclick="copyToClipboard('#client_id')" class="copypro"><i class="material-icons">content_copy</i></a>
            </div>
            <p id="client_id"><?php echo $organization->client_id ?></p>
            <hr>
            <div>
              <h5>Client Secret</h5><a href="javascript:;" onclick="copyToClipboard('#client_secret')" class="copypro"><i class="material-icons">content_copy</i></a> 
            </div>
            <p id="client_secret"><?php echo $organization->client_secret ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-primary" data-dismiss="modal">Close</button>            
          </div>
        </div>
      </div>
    </div>
 




    <script type="text/javascript">    
        $(".showcredential").on('click', function(){          
              var organizationsId = $(this).attr('data-id');                                  
              $.ajax({
                        type:'POST',
                        url: "<?php echo SITE_URL.'admin/organizations/generateOrganizationSecret'; ?>",
                        data:{organizationsId:organizationsId},                  
                        beforeSend: function (xhr) { // Add this line
                            xhr.setRequestHeader('X-CSRF-Token', '<?php echo $this->request->getParam('_csrfToken'); ?>');
                        }, 
                        success:function(res)
                        {
                             var result = JSON.parse(res);                          
                             $("#client_id").text(result.client_id); 
                             $("#client_secret").text(result.client_secret);
                             $(".credential_"+organizationsId).hide();
                             $("#exampleModal").modal('show');                                                            
                        
                        },   
                        error: function(e) {
                        window.location = "<?php echo SITE_URL.'/admin/organizations/'; ?>"
                    }               
                   })
        }) 
    </script>

