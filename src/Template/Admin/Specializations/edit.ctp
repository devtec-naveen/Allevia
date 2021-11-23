<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Specialization
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'specializations'  ?>">Specializations</a></li>
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($organizations, array('id'=>'edit_organizations')); ?>
        
                                <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("name" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Specialization Name *','label' => false, 'title'=>'Enter Specialization Name', "required" => true));?>
                                     <label class="form-label">Specialization Name</label>
                                  </div>
                                  </div>
                                  
                                  
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Specialization</button>
                               
                                
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
