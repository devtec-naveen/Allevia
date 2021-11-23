<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add Email and Text Template
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'email-templates'  ?>">Email and Text Templates</a></li>
                                <li class="active">Add</li>
                            </ol>
                        </div>
                        <div class="body">
                         <?php echo $this->Form->create($emailtemplates, array('id'=>'add_email_template')); ?>
        
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <?php echo $this->Form->input("name" , array("type" => "text","class" => "form-control",'label' => false, "title"=>"Please Enter E-mail Template Name", "required" => "required"));?>
                                     <label class="form-label">Email Template Name</label>
                                  </div>
                                  </div>
                                   <div class="form-group form-float">
                                    <div class="form-line">
                                    <?php echo $this->Form->input("subject" , array("type" => "text","class" => "form-control",'label' => false, "title"=>"Please Enter E-mail Template Subject", "required" => "required"));?>
                                     <label class="form-label">Email Template Subject</label>
                                  </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="form-label">Email Template Description</label>
                                    <div class="form-line">
                                   <?php echo $this->Form->input("description" , array("type" => "textarea","class" => "form-control ckeditor",'label' => false, "title"=>"Please Enter E-mail Template Description", "required" => "required"));?>
                                   
                                  </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="form-label">Text Message Description</label>
                                    <div class="form-line">
                                   <?php echo $this->Form->input("text_message" , array("type" => "textarea","class" => "form-control ckeditor",'label' => false, "title"=>"Please Enter Text Message Description", "required" => false));?>
                                   
                                  </div>
                                  </div>

                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create Email Template</button>
                               
                                
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
