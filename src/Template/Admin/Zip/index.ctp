<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Zip Code List
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Zip Code List</li>
                            </ol>
                        </div>
                        <?php echo $this->Flash->render(); ?>
                        <div class="body">
                            <div class="table-responsive">                        
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                             <th>Sr. No.</th>
                                             <th>Zip Code</th>  
                                             <th>Created</th>
                                             <th><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                        <?php

                                        if(isset($zipcodes) && !empty($zipcodes)){                                         
                                        $i = 1;

                                        foreach ($zipcodes as $value): ?>
                                        <tr>    
                                          <td><?= $this->Number->format($i) ?></td>
                                          <td><?= h($value->zipcode) ?></td>
                                          
                                            <td><?= h($value->created) ?></td>

                                          <td class="actions">
                                          
                                          <?= $this->Html->link($this->Html->tag('i','mode_edit',array('class'=>'material-icons')), ['action' => 'edit', base64_encode($value->id)],['escape' => false,'class' => 'badge bg-blue','style' => 'margin:1px;']) ?>

                                          <?php 
                                                echo $this->Html->link($this->Html->tag('i','delete',array('class'=>'material-icons')), ['action' => 'delete', $value->id],['escape' => false,'class' => 'badge bg-red', 'title' =>'Delete','style' => 'margin:1px;', 'confirm'=>'Are you sure?']) ;
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
            <?= $this->Html->link($this->Html->tag('i','add',array('class'=>'material-icons')), ['action' => 'add'],['escape' => false,'class' => 'btn btn-primary btn-circle-lg waves-effect waves-circle waves-float sticky-btn-add', 'title' => 'Add Zip Code']) ?>
        </div>
        
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">API credential</h5>       
          </div>
          <div class="modal-body">
            <div>
            <h5>Provider Secret</h5><a href="javascript:;" onclick="copyToClipboard('#provider_secret')" class="copypro"><i class="material-icons">content_copy</i></a>
          </div>
            <p id="provider_secret"><?php echo $provider->provider_secret ?></p>            
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
        }) 
    </script>