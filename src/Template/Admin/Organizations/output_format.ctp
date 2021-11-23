
<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Output Format
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations/output-format'  ?>">Output Format</a></li>
                                <li class="active">Add</li>
                            </ol>
                        </div>
                        <div class="body">
                          <?php //pr($org_format); ?>
                                 <?php echo $this->Form->create( null , array('id'=>'add_doctor' , 'method' => 'POST')); ?>

                              <div class="form-group form-float">
                                 <label class="form-label">Format</label>
                                    <div class="form-line">
                                      <?php //$format = array(1=> 'Open emr format',2=> 'Json format',3 => 'Plain text format'); ?>

                                      <select name="format">
                                        
                                        <option value="3" <?php echo $org_format == 3 ? "selected": ""; ?> >Plain text format</option>
                                        <?php  if($org_data->make_test_clinic == 1){ ?>
                                        <option value="1" <?php echo $org_format == 1 ? "selected": ""; ?> >Json format</option>
                                        <option value="2" <?php echo $org_format == 2 ? "selected": ""; ?> >Open emr format</option>
                                      <?php } ?>
                                      </select>
                                     <?php //echo $this->Form->Input("format",array("empty"=>"Select Format",'label' => false, "class" => "form-control","type"=>"select","options" => $format, "value" => "", "default" => $org_format, 'data-msg-required'=>'Select Clinic ',"required"=>true,'id' => 'clinic_name'));?>
                                    
                                  </div>
                                  </div>
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                               
                                
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

