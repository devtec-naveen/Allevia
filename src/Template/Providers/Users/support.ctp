<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
         <?= $this->Flash->render() ?>
        <div class="card support">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Support</h4>
          </div>
          <div class="card-body">
            <?= $this->Flash->render() ?>
                  <div class="body">                    
                    <strong>Need immediate help?</strong> Call or Text us at <?= $allsettings['provider_support_call'] ?>
                  </div>
                  <div class="body" style="margin-top: 10px; display: flex;">
                    <?php if(isset($allsettings['provider-desk']) && $allsettings['provider-desk'] != ''){?>
                      <strong>For any query or feedbacks, click on &nbsp;</strong><a href="<?php echo $allsettings['provider-desk']; ?>" target="_blank"><h6>Help Desk</h6></a>
                    <?php }?>
                  </div>          
          </div>
         </div>
      </div>
     </div>
   </div>  
