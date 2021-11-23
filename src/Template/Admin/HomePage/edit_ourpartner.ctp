<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Our Partner
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'home-page/ourpartner'  ?>">Our Partner</a></li>
                                <li class="active">Edit Our Partner</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($organizations, array('id'=>'add_organizations','enctype'=>'multipart/form-data')); ?>
             
                                

                          <div class="form-group form-float">
                             <label class="form-label">Value Props Image</label>                                    
                                    <div class="form-line">
                                 <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$organizations->image; ?>">

                                     <?php echo $this->Form->input("image" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Our Partner Image','label' => false, 'title'=>'Our Partner Image', "required" => false));?>
                                     
                                  </div>
                                  </div>  
                                   
                                  
                                  
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                               
                                
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
