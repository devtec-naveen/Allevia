<?php use Cake\I18n\Time;
   $session = $this->request->getSession();
   $login_user_data = $session->read('Auth.User');
   ?>
<div class="inner-wraper">
   <div class="row">
      <div class="col-md-8">
         <div class="message"></div>
         <?= $this->Flash->render() ?>
         <div class="card">
            <div class="card-header d-flex">
               <h4 class="header-title mt-2 mr-5">Authentication Portal</h4>
               <div class="btns">
                  <?php if($authUser['organization_id']['is_show_secret_key'] == 0 && ($authUser['organization_id']['is_request_accept'] == 2 || $authUser['organization_id']['is_request_accept'] == 0 )){?>
                  <a class="btn btn-blue" href="<?php echo SITE_URL?>organizations/users/viewsecret">View secret key</a>
                  <?php }?>
                  <?php if($authUser['organization_id']['is_show_secret_key'] == 2 ){?>
                  <a class="btn btn-blue" href="<?php echo SITE_URL?>organizations/users/sendrequest">Request to view keys again</a>
                  <?php }?>

                  <?php if($authUser['organization_id']['is_generate_new_key'] == 0 ){?>
                  <a class="btn btn-blue-border" href="<?php echo SITE_URL?>organizations/users/keyrequest">Request to generate new keys</a>
                 <?php }?>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-md-2">
                     <h6>Client Id :</h6>
                  </div>
                  <div class="col-md-8">
                     <?php $clientId = $this->CryptoSecurity->decrypt(base64_decode($authUser['organization_id']['client_id']),SEC_KEY) ?>
                     <p id="orgclient_id"><?php echo $clientId  != ''? $clientId :'-'  ; ?> </p>
                  </div>
                  <div class="col-md-2">
                     <?php if($clientId != ''){?>
                     <a href="javascript:;" onclick="copyToClipboard('#orgclient_id')" class="copypro"><i class="material-icons">content_copy</i></a>
                  <?php }?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-2">
                     <h6>Client Secret :</h6>
                  </div>
                  <div class="col-md-8">
                     <p id="orgclient_secret"> 
                        <?php
                        $clientSecret = $this->CryptoSecurity->decrypt(base64_decode($authUser['organization_id']['client_secret']),SEC_KEY);
                        ?>

                        <?php if($authUser['organization_id']['is_show_secret_key'] == 1){
                           echo $clientSecret;
                           }else{
                             echo $clientSecret !='' ? '**************':'-';
                              ?>                         
                        <?php }?>
                     </p>
                  </div>
                  <div class="col-md-2">
                     <?php if($authUser['organization_id']['is_show_secret_key'] == 1 && $clientSecret != ''){?>
                     <a href="javascript:;" onclick="copyToClipboard('#orgclient_secret')" class="copypro"><i class="material-icons">content_copy</i></a>
                     <?php }?>
                  </div>
               </div>
               <table id="example" class="table">
                  <thead>
                     <tr>
                        <th>Email Address</th>
                        <th>Provider Secret</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     $i = 1;
                     if(isset($user) && !empty($user)){                        
                        foreach ($user as $userinfo):
                           $providerSecret = $this->CryptoSecurity->decrypt(base64_decode($userinfo['provider_secret']),SEC_KEY);
                           ?>
                           <tr>
                              <td> <?= $this->CryptoSecurity->decrypt(base64_decode($userinfo['email']),SEC_KEY) ?></td>
                              <td>
                                 <?php if($authUser['organization_id']['is_show_secret_key'] == 1 ){
                                    echo '<p id="'.'provider_secret_'.$userinfo['id'].'">'.$providerSecret.'</p>';
                                   }
                                   else
                                    {
                                       echo $providerSecret != '' ? '**************' :'-';
                                    }
                                    ?>

                              </td>
                              <td>
                                 <?php if($authUser['organization_id']['is_show_secret_key'] == 1 && $providerSecret != ''){?>
                                    <a href="javascript:;" onclick="copyToClipboard('#provider_secret_<?php echo $userinfo['id'] ?>')" class="copypro"><i class="material-icons">content_copy</i></a>
                                 <?php } else { echo '-';}?>
                              </td>
                           </tr>
                           <?php  $i++; endforeach; ?>
                        <?php } else{
                           ?>
                           <tr>
                              <td colspan="3" align="center"> No providers created yet</td>
                           </tr>
                           <?php
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

