<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Zip Code
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'zip'  ?>">Zip Codes</a></li>
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($ZipCodes, array('id'=>'edit_zip','enctype'=>'multipart/form-data')); ?>
        
                                <div class="form-group form-float">
                                   <label class="form-label">Zip Code</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("zipcode" , array('type'=>"number", 'pattern'=>"[0-9]*", 'inputmode'=>"numeric",'oninput'=> "javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);","class" => "form-control",'data-msg-required'=>'Enter Zip Code *','label' => false, 'title'=>'Enter Zip Code', "required" => true,'maxlength' =>'6'));?>
                                    
                                  </div>                             

                                  </div>
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Zip Code</button>
                               
                                
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
