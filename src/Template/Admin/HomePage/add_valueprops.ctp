<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add Value Props
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'home-page/valueprops'  ?>">Value Props</a></li>
                                <li class="active">Add Value Props</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($organizations, array('id'=>'add_organizations','enctype'=>'multipart/form-data')); ?>
             
                                <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("heading" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter  Title','label' => false, 'title'=>'Enter  Title', "required" => true));?>
                                     <label class="form-label">Enter  Title</label>
                                  </div>
                                  </div>

                          <div class="form-group form-float">
                             <label class="form-label">Value Props Image</label>                                    
                                    <div class="form-line">

                                     <?php echo $this->Form->input("image" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Value Props Icon','label' => false, 'title'=>'Value Props Icon', "required" => true));?>
                                     
                                  </div>
                                  </div>  
                                   <div class="form-group form-float">
                                     <label class="form-label">Description</label>

                                    <div class="form-line">
                                     <?php echo $this->Form->input("description" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Description','label' => false,  "required" => true));?>
                                  </div>
                                  </div>
                                  
                                  
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create Value Props</button>
                               
                                
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
