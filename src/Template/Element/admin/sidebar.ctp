    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo  WEBROOT."img/".$allsettings['logo_image']  ;  ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $this->CryptoSecurity->decrypt(base64_decode($authUser['first_name']),SEC_KEY).' '.$this->CryptoSecurity->decrypt(base64_decode($authUser['last_name']),SEC_KEY)   ?></div>
                    <div class="email"><?= $this->CryptoSecurity->decrypt(base64_decode($authUser['email']),SEC_KEY) ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?= ADMIN_SITE_URL.'users/profile' ?>"><i class="material-icons">person</i>Profile</a></li>
                            <li><a href="<?= ADMIN_SITE_URL.'users/logout' ?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li <?php if($this->request->getParam('controller') == 'Dashboard'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>dashboard">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                     <li <?php if($this->request->getParam('controller') == 'Users' && ($this->request->getParam('action') != 'profile' && $this->request->getParam('action') != 'useractivity' && $this->request->getParam('action') != 'timetracking')){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>users">
                            <i class="material-icons">person</i>
                            <span>Users </span>
                        </a>
                    </li>
                   <?php //pr($this->request->action); ?>
                      <li <?php if($this->request->getParam('controller') == 'Organizations' && ($this->request->getParam('action') != 'providers' && $this->request->getParam('action') != 'editProvider' && $this->request->getParam('action') != 'viewNote')){ ?> class="active" <?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">group</i>
                            <span>Clinics & Doctor </span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if($this->request->getParam('controller') == 'Organizations' && $this->request->getParam('action') == 'add' ||  $this->request->getParam('action') == 'index' || $this->request->getParam('action') == 'edit' || $this->request->getParam('action') == 'view'){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>organizations">
                                    <span>Clinics</span>
                                </a>
                            </li>

                            <li <?php if($this->request->getParam('controller') == 'Organizations' && $this->request->getParam('action') == 'clinicrequest'){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>organizations/clinicrequest">
                                    <span>Clinics Pending Request</span>
                                </a>
                            </li>


                            <li <?php if($this->request->getParam('controller') == 'Organizations' && $this->request->getParam('action') == 'doctors' || $this->request->getParam('action') == 'add-doctor' || $this->request->getParam('action') == 'edit-doctor' || $this->request->getParam('action') == 'view-doctor'){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>organizations/doctors">
                                    <span>Doctors</span>
                                </a>
                            </li>

                            <li <?php if($this->request->getParam('controller') == 'Organizations' && $this->request->getParam('action') == 'managelocation'){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>organizations/managelocation">
                                    <span>Manage locations</span>
                                </a>
                            </li>



                        </ul>
                    </li>
                    <li <?php if($this->request->getParam('action') == 'providers' || $this->request->getParam('action') == 'editProvider' || $this->request->getParam('action') == 'viewNote'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>organizations/providers">
                            <i class="material-icons">group</i>
                            <span>Clinic Providers  </span>
                        </a>
                    </li>

                     <li <?php if($this->request->getParam('controller') == 'Appointments'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>appointments">
                            <i class="material-icons">event</i>
                            <span>Appointments  </span>
                        </a>
                    </li>



                    <!-- <li <?php if($this->request->controller == 'Specializations'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>specializations">
                            <i class="material-icons">insert_drive_file</i>
                            <span>Specializations Management </span>
                        </a>
                    </li> -->


<li <?php if($this->request->getParam('controller') == 'Specializations'){ ?> class="active" <?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">insert_drive_file</i>
                            <span>Specializations </span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if($this->request->getParam('controller') == 'Specializations' && $this->request->getParam('action') == 'index' ||  $this->request->getParam('action') == 'index' ){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>specializations">
                                    <span>Specializations</span>
                                </a>
                            </li>
                            <li <?php if($this->request->getParam('controller') == 'Organizations' && $this->request->getParam('action') == 'substeps' || $this->request->action == 'substeps'){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>specializations/substeps">
                                    <span>Steps</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php /*
                     <li <?php if($this->request->controller == 'FormsManagement'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>forms-management">
                            <i class="material-icons">insert_drive_file</i>
                            <span>Forms Management </span>
                        </a>
                    </li>

                    */ ?>




                     <li <?php if($this->request->getParam('controller') == 'Cms'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>cms">
                            <i class="material-icons">pages</i>
                            <span>CMS </span>
                        </a>
                    </li>
                    <li <?php if($this->request->getParam('controller') == 'Zip'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>zip">
                            <i class="material-icons">location_on</i>
                            <span>Zip Codes </span>
                        </a>
                    </li>
                    <li <?php if($this->request->getParam('controller') == 'TransactionHistory'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>transaction-history">
                            <i class="material-icons">paid</i>
                            <span>Transaction History </span>
                        </a>
                    </li>


<li <?php if($this->request->getParam('controller') == 'HomePage' ){ ?> class="active" <?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">insert_drive_file</i>
                            <span>Home Page </span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if($this->request->getParam('controller') == 'HomePage' && $this->request->getParam('action') == 'homepage'  ){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>home-page/homepage">
                                    <span>Home Page  </span>
                                </a>
                            </li>
                            <li <?php if($this->request->getParam('controller') == 'HomePage' && $this->request->getParam('action') == 'valueprops' ){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>home-page/valueprops">
                                    <span>Value Props section </span>
                                </a>
                            </li>
                            <li <?php if($this->request->getParam('controller') == 'HomePage' && $this->request->getParam('action') == 'ourpartner' ){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>home-page/ourpartner">
                                    <span>Our Partner section </span>
                                </a>
                            </li>
                            <li <?php if($this->request->getParam('controller') == 'HomePage' && $this->request->getParam('action') == 'banner' ){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>home-page/banner">
                                    <span>Banner </span>
                                </a>
                            </li>
                        </ul>
                    </li>


<?php /*
                    <li <?php if($this->request->controller == 'EmailTemplates'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>email-templates">
                            <i class="material-icons">email</i>
                            <span>Email Templates</span>
                        </a>
                    </li>
*/  ?>
<li <?php if($this->request->getParam('controller') == 'EmailTemplates'){ ?> class="active" <?php } ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">email</i>
                            <span>Email Templates </span>
                        </a>
                        <ul class="ml-menu">
                            <li <?php if($this->request->getParam('controller') == 'EmailTemplates' && $this->request->getParam('action') == 'index' ){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>email-templates">
                                    <span>Template List</span>
                                </a>
                            </li>
                            <li <?php if($this->request->getParam('controller') == 'EmailTemplates' && $this->request->getParam('action') == 'sendemail' ){ ?> class="active" <?php } ?>>
                                <a href="<?= ADMIN_SITE_URL ?>email-templates/sendemail">
                                    <span>Send Email</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                     <li <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'useractivity'){ ?> class="active" <?php } ?>>
                       <a href="<?= ADMIN_SITE_URL ?>users/useractivity">
                           <i class="material-icons">person</i>
                           <span>Users Activity </span>

                       </a>
                   </li>

                   <li <?php if($this->request->getParam('controller') == 'Users' && $this->request->getParam('action') == 'timetracking'){ ?> class="active" <?php } ?>>
                     <a href="<?= ADMIN_SITE_URL ?>users/timetracking">
                         <i class="material-icons">access_time</i>
                         <span>Time Tracking Section </span>

                     </a>
                   </li>

                     <li <?php if($this->request->getParam('controller') == 'ReportsStatistics'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>reports-statistics">
                            <i class="material-icons">graphic_eq</i>
                            <span>Reports and Statistics </span>
                        </a>
                    </li>
                      <li <?php if($this->request->getParam('controller') == 'GlobalSections'){ ?> class="active" <?php } ?>>
                        <a href="<?= ADMIN_SITE_URL ?>global-sections">
                            <i class="material-icons">settings</i>
                            <span>Global Settings </span>
                        </a>
                    </li>


                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
<!--             <div class="legal">
                <div class="copyright">
                    &copy; 2018 - 2019 <a href="javascript:void(0);">Allevia Admin Panel</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div> -->
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

    </section>


    <style type="text/css">

        .list { min-height: 1000px;  }
    </style>
