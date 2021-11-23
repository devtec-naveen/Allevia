<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Banner
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'home-page/banner'  ?>">Banner</a></li>
                                <li class="active">Edit Banner</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($organizations, array('id'=>'add_organizations','enctype'=>'multipart/form-data')); ?>
             
                                <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("banner_url" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Banner Url','label' => false, 'title'=>'Banner Url', "required" => true));?>
                                     <label class="form-label">Banner Url</label>
                                  </div>
                                  </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("url_text" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Banner Url Text','label' => false, 'title'=>'Banner Url Text', "required" => true));?>
                                     <label class="form-label">Banner Url Text</label>
                                  </div>
                                  </div>   

                    <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("banner_title" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Banner Title','label' => false, 'title'=>'Banner Title', "required" => true));?>
                                     <label class="form-label">Banner Title</label>
                                  </div>
                                  </div>  


                        <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("banner_text" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Banner Text','label' => false, 'title'=>'Banner Text', "required" => true));?>


                                     <label class="form-label">Banner Text</label>
                                  </div>
                                  </div>


                          <div class="form-group form-float">
                             <label class="form-label">Banner Image</label>                                    
                                    <div class="form-line">
                                 <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$organizations->image; ?>">
                                     <?php echo $this->Form->input("image" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Banner Image','label' => false, 'title'=>'Banner Image', "required" => false));?>
                                     
                                  </div>
                                  </div>  
                                   
                                  
                                  
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create Banner</button>
                               
                                
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
