<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit User
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'users'  ?>">Users</a></li>
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($organizations, array('id'=>'edit_organizations')); ?>
        
                                <div class="form-group form-float">
                                      <label class="form-label">Email</label>
                                      <!-- <div><?php //echo  $organizations->email ?></div> -->
                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("email" , array("type" => "text","class" => "form-control",'label' => false, "disabled" => true, 'readOnly' => true));?>
                                     <label class="form-label">Email Id</label>
                                  </div>
                             
                                  </div>

                                <div class="form-group form-float">
                                     <label class="form-label">First Name</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("first_name" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter First Name *','label' => false, 'title'=>'Enter First Name', "required" => true));?>
                                    
                                  </div>
                                  </div>




                                 <div class="form-group form-float">
                                    <label class="form-label">Last Name</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("last_name" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Last Name *','label' => false, 'title'=>'Enter Last Name', "required" => true));?>
                                     
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                        <label class="form-label">Phone</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("phone" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Phone Number *','label' => false, 'title'=>'Enter Phone Number', "required" => true));?>
                                 
                                  </div>
                                  </div>
                                  
                                                               
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                               
                                
                                </div>
                                <!-- /.box-body -->

                             <?php echo $this->Form->end()?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>
