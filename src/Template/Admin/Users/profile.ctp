<?php //echo $user->password; echo $user->confirm_password; echo 'hi'; pr($user); die;  ?>
<section class="content">
    <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Profile
                                <small>User Details</small>
                            </h2>
                            <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Profile</li>
                            </ol>
                        </div>
                        <div class="body">
                             <?php echo $this->Form->create($user, array('id'=>'edit_profile','type' => 'file')); ?>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                         <?php echo $this->Form->input("first_name" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter First Name *','title'=>'Enter First Nam','label' => false,"required" => true,'value' => !empty($user->first_name) ? $this->CryptoSecurity->decrypt(base64_decode($user->first_name),SEC_KEY) : ""));?>
                                        <label class="form-label">Firstname</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                         <?php echo $this->Form->input("last_name" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Last Name *','title'=>'Enter Last Name','label' => false,"required" => true,'value' => !empty($user->last_name) ? $this->CryptoSecurity->decrypt(base64_decode($user->last_name),SEC_KEY) : ""));?>
                                        <label class="form-label">Lastname</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                         <?php echo $this->Form->input("password" , array("type" => "password", "class" => "form-control",'title'=>'Enter Password','data-msg-required'=>'Enter Password *','label' => false,"required" => false));?>
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                         <?php echo $this->Form->input("confirm_password" , array("type" => "password","class" => "form-control",'title'=>'Enter Confirm Password','data-msg-required'=>'Enter Confirm Password *','label' => false,"required" => false));?>
                                        <label class="form-label">Confirm Password</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE PROFILE</button>
                             <?php echo $this->Form->end()?>
                        </div>
                    </div>
                </div>
         </div>
    </div>
</section>    