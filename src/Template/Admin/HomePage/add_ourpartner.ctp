<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add Our Partner
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'home-page/ourpartner'  ?>">Our Partner</a></li>
                                <li class="active">Add Our Partner</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($organizations, array('id'=>'add_organizations','enctype'=>'multipart/form-data')); ?>
             
                                

                          <div class="form-group form-float">
                             <label class="form-label">Our Partner Image</label>                                    
                                    <div class="form-line">

                                     <?php echo $this->Form->input("image" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Our Partner Image','label' => false, 'title'=>'Our Partner Image', "required" => true));?>
                                     
                                  </div>
                                  </div>  
                                   
                                  
                                  
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create Our Partner</button>
                               
                                
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
