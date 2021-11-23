<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add CMS Pages
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'cms'  ?>">CMS</a></li>
                                <li class="active">Add</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($Cms, array('id'=>'add_cms')); ?>
        
                                <div class="form-group form-float">
                                      <label class="form-label">Title</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("title" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Page Title *','label' => false, 'title'=>'Enter Page Title', "required" => true));?>
                                   
                                  </div>
                              </div>
                              <div class="form-group form-float">
                            
                                   <label class="form-label">Menu display title</label>
                                <div class="form-line">
                                     <?php echo $this->Form->input("menu_display_title" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Page Title ','label' => false, 'title'=>'Enter Menu display Title', "required" => false));?>
                                    
                                  </div>

                                  </div>

  


       <div class="form-group form-float margin_top_label_error">
                                      <label class="form-label">Choose Menu Type</label>
                                    <div class="form-line">

                                        <?php 

                     $menu_type = array(1 => "Header Manu", 2 => "Header Dropdown Menu Right", 3 => "Footer Menu", 5 => "Header Main Dropdown Menu 1", 4 => "Other" );
                            echo $this->Form->select('menu_type', $menu_type, ['class' => 'form-control' , 'empty' => false, 'multiple' => 'multiple' , 'required' => false]); ?>

                                     
                                  </div>
                                  </div>

                                   <div class="form-group ">
                                    <label class="form-label">Bottom Content</label>
                                    <div class="form-line">
    <?php echo $this->Form->input("bottom_content" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Bottom Content *','label' => false, "required" => true));?>
                                    
                                  </div>
                                  </div>
                                 

                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create CMS Page</button>
                               
                                
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
