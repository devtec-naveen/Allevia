<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Providers
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a class="active" href="<?= ADMIN_SITE_URL.'organizations/providers'; ?>">Providers</a></li>
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
                                             <th>Provider Email</th>     
                                              <th>Locations </th>                                                    
                                             <th>created</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php                                      

                                        $i = 1;

                                        foreach ($users as $user){ ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= isset($user->organization->organization_name) ? h($user->organization->organization_name): ""; ?></td>
                                          <td><?= h($this->CryptoSecurity->decrypt(base64_decode($user->email),SEC_KEY)) ?></td>
                                          <td> 
                                          <?php
                                          $providerLocation = array();
                                          if(!empty($user['user_locations']))
                                          {
                                            foreach ($user['user_locations'] as $key => $value) {

                                              $providerLocation[] = $value['location']['location'];
                                              # code...
                                            }
                                          }    

                                          if(!empty($providerLocation))
                                          {
                                            if(array_filter($providerLocation))
                                            {
                                            echo implode(', ', $providerLocation);
                                            }
                                            else
                                            {
                                              echo '-';
                                            }  
                                          } 
                                          else
                                          {
                                            echo '-';
                                          } 
                                          ?>  

                                          </td>   
                                          <td><?= h($user->created) ?></td>
                                         
                                        <td class="actions">                                                                
                                          
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'editProvider', $user->id],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;']) ?>

                                          <?php 
                                                echo $this->Html->link($this->Html->tag('i','delete',array('class'=>'material-icons')), ['action' => 'deleteProvider', $user->id],['escape' => false,'class' => 'badge bg-red', 'title' =>'Delete','style' => 'margin:1px;', 'confirm'=>'Are you sure?']) ; 

                                                ?>
                                                <a href="<?php echo SITE_URL?>/admin/organizations/view-note/<?php echo base64_encode($user->id)?>" class="badge bg-blue" title="View Note"><i class="material-icons">remove_red_eye</i></a>
                                                <?php

                                                if(!empty($user->cl_provider_id) && !empty($user->organization->cl_group_id)){
                                                    if($user->enable_telehealth ==1){  
                                                        echo $this->Html->link($this->Html->tag('i','radio_button_checked',array('class'=>'material-icons')), ['action' => 'enabletelehealth', $user->id, 0],['escape' => false,'class' => 'badge bg-red','title' =>'Disable Telehealth', 'style' => 'margin:1px;']) ; 

                                                     } else{

                                                       echo $this->Html->link($this->Html->tag('i','radio_button_unchecked',array('class'=>'material-icons')), ['action' => 'enabletelehealth', $user->id, 1],['escape' => false,'class' => 'badge bg-green', 'title' =>'Enable Telehealth','style' => 'margin:1px;']) ; 
                                                     }
                                                 }
                                           ?>

                                            <?php 
                                              if(!empty($user->provider_secret) && $user->show_credential == 0){
                                            ?>
                                               <a href="javascript:;" class="badge bg-blue showcredential credential_<?php echo  $user->id ?>" data-type="1" data-id="<?php echo $user->id ?>" title = "Show Credential"><i class="material-icons">code</i></a>
                                            <?php } ?>
                                               <a href="<?php echo SITE_URL?>/admin/organizations/generateProviderSecret/<?php echo base64_encode($user->id)?>" class="badge bg-blue generatenew t" data-id="<?php echo $user->id ?>" title = "Generate New Credential"><i class="material-icons">autorenew</i></a>

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
        </div>
    </section>

     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">API credential</h5>       
          </div>
          <div class="modal-body">
            <div class="message" style="color:green"></div>
            <div>
              <h5>Provider Secret</h5><a href="javascript:;" onclick="copyToClipboard('#provider_secret')" class="copypro"><i class="material-icons">content_copy</i></a>
              </div> 
            <p id="provider_secret"><?php echo $user->provider_secret ?></p>            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-primary" data-dismiss="modal">Close</button>            
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">    
        $(".showcredential").on('click', function(){          
              var providerId = $(this).attr('data-id');                                 
              $.ajax({
                        type:'POST',
                        url: "<?php echo SITE_URL.'admin/organizations/showProSecret'; ?>",
                        data:{providerId:providerId},                  
                        beforeSend: function (xhr) { // Add this line
                            xhr.setRequestHeader('X-CSRF-Token', '<?php echo $this->request->getParam('_csrfToken'); ?>');
                        }, 
                        success:function(res)
                        {                             
                             var result = JSON.parse(res);                                                        
                             $("#provider_secret").text(result.provider_secret);
                             $(".credential_"+providerId).hide();
                             $("#exampleModal").modal('show');                                                            
                        
                        },   
                        error: function(e) {
                        window.location = "<?php echo SITE_URL.'/admin/organizations/providers'; ?>"
                    }               
                   })
        });
         
    </script>