<div class="side-bar menu--slide-right sidebar" id="menu--slide-right" id="leftsidebar">
    <div class="side-bar-in">
      <div class="side-pro-top dropdown">
         <div class="d-flex" id="profile-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <figcaption>

            
             <h4><?= ucfirst($authUser['organization_id']['organization_name']) ?><i class="fas fa-sort-down profilearrow"></i></h4>

           
           </figcaption>
           <figure>

             <?php if($authUser['organization_id']['clinic_logo'] == ''){?>
             <img src="<?php echo WEBROOT?>images/logo.png">
             <?}else{?>
             <img src="<?php echo WEBROOT?>img/<?php echo $authUser['organization_id']['clinic_logo']?>">
             <?php }?>
           </figure>
         </div>
         <div class="dropdown-menu" aria-labelledby="profile-option">  
          <a class="dropdown-item" href="<?= SITE_URL.'organizations/users/logout' ?>"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
        </div>
       </div>
       <div class="side-bar-menu menu">
         <ul class="navbar-nav mr-auto list">
            <li id="h-dashboard" <?php if( $this->request->controller == 'Dashboard' && $this->request->action == 'index'){ ?> class="nav-item active" <?php } ?>>
                        <a class="nav-link" href="<?= SITE_URL.'organizations/users' ?>">
                            <i class="fas fa-home"></i>Dashboard
                        </a>
            </li>

            <li id="h-email-template" <?php if($this->request->controller == 'profile'){ ?> class="nav-item active" <?php } ?>>
                        <a class="nav-link" href="<?= SITE_URL.'organizations/users/add_uri' ?>">
                           <i class="fa fa-link"></i>Add Redirect Uri
                        </a>
            </li>
          </ul>
       </div>
       <div class="side-pro-btm">
         <div class="d-flex">
           <figcaption>
            <div>
              <span>brought to you by</span>
              <h4>Valhalla Healthcare</h4>
            </div>
           </figcaption>
           <figure>
             <img src="<?php echo WEBROOT?>images/logo.png">
           </figure>
         </div>
       </div>
    </div>
</div>
