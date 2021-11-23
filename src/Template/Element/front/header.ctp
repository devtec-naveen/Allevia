<?php use Cake\Utility\Security;?>
<?php
    $session = $this->request->getSession();
    $clinic_color_scheme = $session->read('clinic_color_scheme');
    if(isset($clinic_color_scheme['clinic_logo']) && !empty($clinic_color_scheme['clinic_logo'])) {
      $clinic_logo = $clinic_color_scheme['clinic_logo'];
    }else{
      $clinic_logo = "";
    }
    if(isset($clinic_color_scheme['clinic_logo_status']) && !empty($clinic_color_scheme['clinic_logo_status'])) {
      $clinic_logo_status = $clinic_color_scheme['clinic_logo_status'];
    }else{
      $clinic_logo_status = 1;
    }
?>

     <header>
        <div class="header-nav">
          <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
              <?php if(!empty($clinic_logo_status) && $clinic_logo_status != 2) { ?>
              <a href="<?= SITE_URL?>"><img src="<?php echo  WEBROOT."img/".$allsettings['logo_image']  ;  ?>"/></a>
              <?php } ?>
              <?php if(!empty($clinic_logo_status) && $clinic_logo_status != 1 && !empty($clinic_logo)) { ?>
              <img src="<?= WEBROOT ?>img/<?php echo $clinic_logo;  ?>" style="width: 5%"/>
              <?php } ?>

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo SITE_URL?>pages/cms/<?php echo $all_cms_page[1]->slug ?>"><?php echo $all_cms_page[1]->menu_display_title ?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo SITE_URL?>pages/cms/<?php echo $all_cms_page[3]->slug ?>"><?php echo $all_cms_page[3]->menu_display_title ?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo SITE_URL?>pages/cms/<?php echo $all_cms_page[8]->slug ?>"><?php echo $all_cms_page[8]->menu_display_title?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo SITE_URL?>pages/cms/<?php echo $all_cms_page[9]->slug ?>"><?php echo $all_cms_page[9]->menu_display_title?></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo SITE_URL?>pages/cms/<?php echo $all_cms_page[10]->slug ?>"><?php echo $all_cms_page[10]->menu_display_title?></a>
                    </li>
                  </ul>
              </div>
              <div class="schedule-btns">                
                  <?php if(empty($authUser)) { ?>
                  <a href="javascript:;" class="btn btn-blue">Schedule a Call</a>
                  <a class="btn btn-blue" href="<?= SITE_URL.'users/login' ?>">Login</a>
                  <a class="btn btn-blue" href="<?= SITE_URL.'users/preceding_signup' ?>">Sign Up</a>
                  <?php }?>
              </div>
              <?php   if(!empty($authUser) && $authUser['role_id'] == 2) { ?>
            <div class="my_account_box">
               <div class="my_account_button" data-toggle="dropdown">
                  <a href="javascript:;">
                  <span>My Account</span>
                  </a>
               </div>
               <ul class="dropdown-menu">
                  <li><a href="<?= SITE_URL.'users/dashboard' ?>">Dashboard</a></li>
                  <li><a href="<?= SITE_URL.'users/myprofile' ?>">My Profile</a></li>
                  <li><a href="<?= SITE_URL.'users/communication-setting' ?>">Communications</a></li>
                  <?php
                     foreach ($all_cms_page as $key => $value) {
                         if(strpos($value->menu_type, '2') !== false){
                             ?>
                  <li><a href="<?php echo   SITE_URL ?>pages/cms/<?php echo $value->slug ?>"><?= $value->menu_display_title ?></a></li>
                  <?php
                     }
                     }
                     
                     ?>
                  <li><a href="<?= SITE_URL.'users/logout' ?>">Logout</a></li>
               </ul>
            </div>
            <?php } ?>
            <?php   if(!empty($authUser) && $authUser['role_id'] == 3) { ?>
            <div class="my_account_box">
               <div class="my_account_button" data-toggle="dropdown">
                  <a href="javascript:;">
                  <span>My Account</span>
                  </a>
               </div>
               <ul class="dropdown-menu">
                  <li><a href="<?= SITE_URL.'providers/dashboard' ?>">Dashboard</a></li>
                  <li><a href="<?= SITE_URL.'providers/users/logout' ?>">Logout</a></li>
               </ul>
            </div>
            <?php } ?>
            <?php  if(!empty($authUser) && $authUser['role_id'] == 1) { ?>
            <div class="my_account_box">
               <div class="my_account_button" data-toggle="dropdown">
                  <a href="javascript:;">
                  <span>My Account</span>
                  </a>
               </div>
               <ul class="dropdown-menu">
                  <li><a href="<?= SITE_URL.'admin/dashboard' ?>">Dashboard</a></li>
                  <li><a href="<?= SITE_URL.'admin/users/logout' ?>">Logout</a></li>
               </ul>
            </div>
            <?php } ?>
            </nav>
          </div>
        </div>
      </header>




<!-- <header class="home_header">
   <div class="container">
      <?php if(!empty($clinic_logo_status) && $clinic_logo_status != 2) { ?>
      <div class="logo">
         <a href="<?= SITE_URL?>"><img src="<?php echo  WEBROOT."img/".$allsettings['logo_image']  ;  ?>"/></a>
      </div>
      <?php } ?>
      <div class="clinic_logo">
         <a href="javascript:void();">
         <?php if(!empty($clinic_logo_status) && $clinic_logo_status != 1 && !empty($clinic_logo)) { ?>
         <img src="<?= WEBROOT ?>img/<?php echo $clinic_logo;  ?>"/>
         <?php } ?>
         </a>
      </div>
      <nav class="navbar navbar-expand-lg scrolling-navbar">
         <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"><i class="fas fa-bars"></i><i class="fas fa-times"></i></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav MenuNav">
               <?php
                  foreach ($all_cms_page as $key => $value) {
                      if(strpos($value->menu_type, '1') !== false){
                          ?>
               <li class="nav-item"><a class="nav-link" href="<?php echo   SITE_URL?>pages/cms/<?php echo $value->slug ?>"><?= $value->menu_display_title ?></a></li>
               <?php
                  if(stripos($value->slug, 'contact') !== false){
                  ?>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="kuldeep" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="false"
                     aria-expanded="false">Providers</a>
                  <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">                  
                     <?php
                        $drop_all_cms_page = $all_cms_page;
                            foreach ($drop_all_cms_page as $key1 => $value1) {
                                if(strpos($value1->menu_type, '5') !== false){
                                    ?>
                     <a class="dropdown-item" href="<?php echo   SITE_URL?>pages/cms/<?php echo $value1->slug ?>"><?= $value1->menu_display_title ?></a>
                     <?php
                        }
                        }
                        ?>
                  </div>
               </li>
               <?php
                  }
                  }
                  }                  
                  ?>
            </ul>
            <ul class="navbar-nav login_signup">
               <?php if(empty($authUser)) { ?>
               <li class="nav-item"><a class="nav-link btn" href="<?= SITE_URL.'users/login' ?>">Login</a></li>
               <li class="nav-item"><a class="nav-link btn" href="<?= SITE_URL.'users/preceding_signup' ?>">Sign Up</a></li>
               <?php }  ?>
            </ul>
            <?php   if(!empty($authUser) && $authUser['role_id'] == 2) { ?>
            <div class="my_account_box">
               <div class="my_account_button" data-toggle="dropdown">
                  <a href="javascript:;">
                  <span>My Account</span>
                  </a>
               </div>
               <ul class="dropdown-menu">
                  <li><a href="<?= SITE_URL.'users/dashboard' ?>">Dashboard</a></li>
                  <li><a href="<?= SITE_URL.'users/myprofile' ?>">My Profile</a></li>
                  <li><a href="<?= SITE_URL.'users/communication-setting' ?>">Communications</a></li>
                  <?php
                     foreach ($all_cms_page as $key => $value) {
                         if(strpos($value->menu_type, '2') !== false){
                             ?>
                  <li><a href="<?php echo   SITE_URL ?>pages/cms/<?php echo $value->slug ?>"><?= $value->menu_display_title ?></a></li>
                  <?php
                     }
                     }
                     
                     ?>
                  <li><a href="<?= SITE_URL.'users/logout' ?>">Logout</a></li>
               </ul>
            </div>
            <?php } ?>
            <?php   if(!empty($authUser) && $authUser['role_id'] == 3) { ?>
            <div class="my_account_box">
               <div class="my_account_button" data-toggle="dropdown">
                  <a href="javascript:;">
                  <span>My Account</span>
                  </a>
               </div>
               <ul class="dropdown-menu">
                  <li><a href="<?= SITE_URL.'providers/dashboard' ?>">Dashboard</a></li>
                  <li><a href="<?= SITE_URL.'providers/users/logout' ?>">Logout</a></li>
               </ul>
            </div>
            <?php } ?>
            <?php  if(!empty($authUser) && $authUser['role_id'] == 1) { ?>
            <div class="my_account_box">
               <div class="my_account_button" data-toggle="dropdown">
                  <a href="javascript:;">
                  <span>My Account</span>
                  </a>
               </div>
               <ul class="dropdown-menu">
                  <li><a href="<?= SITE_URL.'admin/dashboard' ?>">Dashboard</a></li>
                  <li><a href="<?= SITE_URL.'admin/users/logout' ?>">Logout</a></li>
               </ul>
            </div>
            <?php } ?>
         </div>
      </nav>
      <div class="name_dob_header_cls name_dob_header_cls_color">
         <?php   if(!empty($authUser)) {
            $authuser_gender = "";
            if(!empty($authUser['gender'])){
            
              $authuser_gender = Security::decrypt(base64_decode($authUser['gender']),SEC_KEY);
            }
            
            $authuser_dob = $this->CryptoSecurity->decrypt(base64_decode($authUser['dob']),SEC_KEY);
            $age = "";
            if(!empty($authuser_dob)){
            
             $age = date('Y') - date('Y',strtotime($authuser_dob));
            }            
            echo !empty($authUser['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($authUser['first_name']), SEC_KEY).' ' : '';
            echo !empty($authUser['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($authUser['last_name']), SEC_KEY).' ' : '';
            echo !empty($authUser['dob']) ? ' | '.date('m-d-Y',strtotime($this->CryptoSecurity->decrypt(base64_decode($authUser['dob']),SEC_KEY))) : '';
            echo in_array($authuser_gender, [0,1,2]) ? ($authuser_gender == 0 ? " | F" : " | M") : "";
            
            echo !empty($age) ? " | ".$age : "";
            
            } ?>
      </div>
   </div>
</header>
 -->

