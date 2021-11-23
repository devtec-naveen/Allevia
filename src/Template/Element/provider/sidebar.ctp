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
          <!-- <a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a>
          <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Sign Out</a> -->
           <!-- <a class="dropdown-item" href="<?= SITE_URL.'providers/users/profile' ?>"><i class="fas fa-user"></i>Profile</a> -->
           <a class="dropdown-item" href="<?= SITE_URL.'providers/users/logout' ?>"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
        </div>
       </div>
       <div class="side-bar-menu menu">
         <ul class="navbar-nav mr-auto list">
            <li id="h-dashboard" <?php if( $this->request->controller == 'Dashboard' && $this->request->action == 'index'){ ?> class="nav-item active" <?php } ?>>
                        <a class="nav-link" href="<?= SITE_URL.'providers/dashboard' ?>">
                            <i class="fas fa-home"></i>Dashboard
                        </a>
            </li>
            <!-- <li class="nav-item active">
              <a class="nav-link" href="#"><i class="fas fa-home"></i>Dashboard</a>
            </li> -->
            <li id="h-past-schedule" <?php if($this->request->action == 'pastschedule'){ ?> class="nav-item active" <?php } ?>>
                        <a class="nav-link" href="<?= SITE_URL.'providers/dashboard/pastschedule' ?>">
                            <i class="far fa-calendar-alt"></i>Past Schedules
                        </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#"><i class="far fa-calendar-alt"></i> Past Schedules</a>
            </li> -->

             <li id="h-email-template" <?php if($this->request->controller == 'EmailTemplates'){ ?> class="nav-item active" <?php } ?>>
                        <a class="nav-link" href="<?= SITE_URL.'providers/email-templates' ?>">
                           <i class="fas fa-envelope"></i>Email and Text Templates
                        </a>
            </li>
           <!--  <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-envelope"></i> Email and Text Templates</a>
            </li> -->
            <li class="nav-item menu-more-out" <?php if($this->request->controller == 'Users' && ($this->request->action == 'profile' || $this->request->action == 'scheduleFieldSetting' || $this->request->action == 'tableColumnSetting' || $this->request->action == 'noteFormating' || $this->request->action == 'ancillaryDocuments' || $this->request->action == 'globalSettings' || $this->request->action == 'telehealth' || $this->request->action == 'timezone')){ ?> active <?php } ?>>
                        <a id="h-setting" class="nav-link menu-more collapsed menu-toggle" data-toggle="collapse" href="#Settings" role="button" aria-expanded="false" aria-controls="Settings">
                           <i class="fas fa-cog"></i> Settings <span><i class="fas fa-minus"></i><i class="fas fa-plus"></i></span>
                        </a>
                        <div class="collapse menu-more-menu ml-menu" id="Settings">
                                <a id="h-general-setting" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'profile'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/profile' ?>">
                                   General Settings
                                </a>

                                <a id="h-input-schedule-setting" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'scheduleFieldSetting'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/schedule-field-setting' ?>">
                                   Input Schedule Settings
                                </a>


                                <a id="h-display-column" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'tableColumnSetting'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/table-column-setting' ?>">
                                    <span>Display Columns</span>
                                </a>


                                <a id="h-note-formatting"  class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'noteFormating'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/note-formating' ?>">
                                    <span>Note Formatting</span>
                                </a>

                                <a id="h-telehealth" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'telehealth'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/telehealth' ?>">
                                    <span>Telehealth</span>
                                </a>

                                <a id="h-timezone" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'timezone'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/timezone' ?>">
                                    <span>Timezone</span>
                                </a>


                                <!-- <a class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'ancillaryDocuments'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/ancillary-documents' ?>">
                                    <span>Ancillary Documents</span>
                                </a> -->

                                <a id="h-automated-reminder-setting" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'globalSettings'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/global-settings' ?>">
                                    <span>Automated Reminder Settings</span>
                                </a>

                                <a id="h-timezone" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'sendgridSettings'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/sendgrid-settings' ?>">
                                    <span>Sendgrid Settings</span>
                                </a>

                        </div>

            </li>



            <li class="nav-item menu-more-out" <?php if($this->request->controller == 'Users' && ($this->request->action == 'profile' || $this->request->action == 'scheduleFieldSetting' || $this->request->action == 'tableColumnSetting' || $this->request->action == 'noteFormating' || $this->request->action == 'ancillaryDocuments' || $this->request->action == 'globalSettings' || $this->request->action == 'telehealth')){ ?> active <?php } ?>>
                        <a id="h-support" class="nav-link menu-more collapsed menu-toggle" data-toggle="collapse" href="#support" role="button" aria-expanded="false" aria-controls="support">
                           <i class="fas fa-user-cog"></i> Support <span><i class="fas fa-minus"></i><i class="fas fa-plus"></i></span>
                        </a>
                        <div class="collapse menu-more-menu ml-menu" id="support">
                                <a id="h-provider-tour" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'profile'){ ?> active <?php } ?>" href="javascript:;">
                                   Provider Tour
                                </a>

                                <a id="h-help-desk" class="dropdown-item <?php if($this->request->controller == 'Users' && $this->request->action == 'scheduleFieldSetting'){ ?> active <?php } ?>" href="<?= SITE_URL.'providers/users/support' ?>">
                                   Help Desk
                                </a>
                        </div>

            </li>

            <?php if($authUser['is_allow_analytics'] == 1){ ?>

            <li id="h-support" <?php if($this->request->controller == 'Users' && $this->request->action == 'support'){ ?> class="nav-item active" <?php } ?>>
            <a class="nav-link"  href="<?= SITE_URL.'providers/dashboard/analytics' ?>">
            <i class="fas fa-chart-pie"></i>Allevia Analytics 
            </a>
            </li>
            <?php }?> 


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
