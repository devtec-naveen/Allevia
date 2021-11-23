<section class="content">


        <div class="container-fluid">
                 <!-- Basic Examples -->

        <?php $i = 0;
         // foreach($global_settings as $globalvalue){?>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                              Global Settings
                            </h2>
                            <?php if($i == 0){ ?>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Global Settings</li>
                            </ol>
                            <?php }?>
                        </div>
<?php echo $this->Form->create(null, array('id'=>'edit_organizations','enctype'=>'multipart/form-data')); ?>                        
                        <div class="body">

                            <?php foreach($global_settings as $settings){


                             if($settings['type'] == 'text'){ ?>
                        
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input name="<?= $settings['slug']; ?>" type="text" class="form-control" id="<?= $settings['slug']; ?>" value="<?= $settings['value']; ?>">
                                                <label class="form-label" ><?= $settings['title']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                 
                               
                                </div>
                                <?php }
                                if($settings['type'] == 'number'){ ?>
                        
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input name="<?= $settings['slug']; ?>" type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" id="<?= $settings['slug']; ?>" value="<?= $settings['value']; ?>">
                                                <label class="form-label" ><?= $settings['title']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                 
                               
                                </div>
                                <?php }
                                elseif($settings['type'] == 'file' || $settings['type'] == 'image'){ ?>

                                <div class="row clearfix">
                                    <div class="col-sm-12">

<?php if( $settings['type'] == 'image' && !empty($settings['value'])) { ?>
<img style="width: 100px; margin-bottom: 5px;" src="<?php echo  WEBROOT."img/".$settings['value']  ;  ?>" />  
<?php } ?>                                        
                                        <div class="form-group">
                                         <label class="form-label"><?= $settings['title']; ?></label>
                                            <div class="form-line">
                                                <input  name="<?= $settings['slug']; ?>"  type="file" id="<?= $settings['slug']; ?>" class="form-control">
                                               
                                            </div>
                                        </div>
                                    </div>
                                 
                    
                                </div>

                                <?php }
                                elseif($settings['type'] == 'textarea'){?>

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                         <label class="form-label" ><?= $settings['title']; ?></label>
                                            <div class="form-line">
                                                <textarea  name="<?= $settings['slug']; ?>"  class="form-control ckeditor" id="<?= $settings['slug']; ?>"><?= $settings['value']; ?></textarea>
                                               
                                            </div>
                                        </div>
                                    </div>
                                 
        
                                </div>

                                <?php }elseif($settings['type'] == 'select'){?>
                                <?php $options = array(1=>'Test Mode',2=>'Live Mode'); ?>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                              <label class="form-label"><?= $settings['title']; ?></label>
                                            <div class="form-line">
                                             <?php echo $this->Form->Input($settings['slug'],array("empty"=>"",'label' => false, "class" => "form-control","type"=>"select","options" => $options,'data-msg-required'=>'Select Payment Mode ',"required"=>true,'id'=>$settings['slug'],'value' =>$settings['value']));?>                                     
                                          </div>
                                          </div>
                                      </div>
                                  </div>
                              <?php }?>
                           <?php }?>
                          
<div class="row clearfix">

                                        <button type="submit"  class="btn btn-primary btn-lg m-l-15 waves-effect">SUBMIT </button>
                                    </div>
                           


                        </div>
<?php $this->Form->end(); ?>     
                    </div>
                </div>

            </div>

            <?php $i++; //} ?>


            
        </div>
   
    </section>
    
