<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Clinic Pending Request
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
                                             
                                             <th>Clinic Name</th>                                           
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php
                                        $Cms = [];                                        
                                        $i = 1;
                                        if(!empty($organizations))
                                        {  
                                        foreach ($organizations as $organization){ ?>
                                        <tr>
                                          <td><?= $this->Number->format($i) ?></td>                                     
                                          <td><?= h($organization->organization_name) ?></td>                                         
                                          <td class="actions">                                      

                                          <?php if($organization->is_request_accept == 1){?>

                                          <a href="<?php echo SITE_URL?>/admin/organizations/secretkeyaction/<?php echo base64_encode($organization->id)?>/1" class="btn btn-primary generatenew t" data-id="<?php echo $organization->id ?>" title = "Accept request to show key"><i class="material-icons">low_priority</i></a>
                                          <a href="<?php echo SITE_URL?>/admin/organizations/secretkeyaction/<?php echo base64_encode($organization->id)?>/2" class="btn btn-primary generatenew t" data-id="<?php echo $organization->id ?>" title = "Reject request to show key"><i class="material-icons">alarm_off</i></a>
                                          <?php }?>

                                          <?php if($organization->is_generate_new_key == 1){
                                            ?>
                                              <a href="<?php echo SITE_URL?>admin/organizations/secretkeyaction/<?php echo base64_encode($organization->id)?>/3" class="btn btn-primary generatenew t" data-id="<?php echo $organization->id ?>" title = "Acknowledgement to organization for key generated"><i class="material-icons">send</i></a>
                                            <?php
                                           } ?>                                             
                                       </td>
                                     </tr>                                    
                                     <?php  $i++; 
                                        }
                                      }
                                     ?>
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
            <p id="client_id"><?php echo $organization->client_id; ?></p>
            <hr>
            <div>
              <h5>Client Secret</h5><a href="javascript:;" onclick="copyToClipboard('#client_secret')" class="copypro"><i class="material-icons">content_copy</i></a> 
            </div>
            <p id="client_secret"><?php echo $organization->client_secret; ?></p>
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

