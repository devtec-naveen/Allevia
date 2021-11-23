<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
                
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Location
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations/providers'  ?>">Locations</a></li>
                                <li class="active">Edit</li>
                            </ol>

                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($location, array('id'=>'edit_provider')); ?>

                                <div class="form-group form-float">
                                 <label class="form-label">Clinic</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->Input("organization_name",array('label' => false, "class" => "form-control","type"=>"text","value" => $location['organization']['organization_name'], "required"=>true, 'readonly' => true));?>
                                    
                                  </div>
                                </div>
                             
                                <div class="form-group form-float">
                                    <label class="form-label">Location</label>                                  
                                    <div class="form-line">
                                     <?php echo $this->Form->input("location" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Provider Email*','label' => false, 'title'=>'Enter Provider Email', "required" => true,'value' => !empty($location->location) ? $location->location: ""));?>                                 
                                    </div>
                                </div>                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect"> Update location</button>
                               
                                
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
