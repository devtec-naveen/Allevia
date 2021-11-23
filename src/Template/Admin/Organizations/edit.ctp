<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Clinic
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                        <div class="body"> 
                                                
                                 <?php echo $this->Form->create($organizations, array('id'=>'edit_organizations','enctype'=>'multipart/form-data')); ?>
        
                                <div class="form-group form-float">
                                      <label class="form-label">Clinic Name</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("organization_name" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Clinic Name *','label' => false, 'title'=>'Enter Clinic Name', "required" => true));?>
                                 
                                  </div>
                                  </div>

                                  <div class="form-group form-float">
                                      <label class="form-label">Clinic Slug</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("org_url" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Clinic Slug *','label' => false, 'title'=>'Enter Clinic Slug', "required" => true));?>                                     
                                 
                                  </div>
                                  </div>

                                  <?php if(!empty($userData) && $userData['email'] !=''){?>

                                    <div class="form-group form-float">
                                      <label class="form-label">Clinic Email</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("email" , array("type" => "email","class" => "form-control",'data-msg-required'=>'Enter Clinic Email *','label' => false, 'autocomplete' => 'off','title'=>'Enter Clinic Email', "required" => true,'value' => !empty($userData['email']) ? $this->CryptoSecurity->decrypt(base64_decode($userData['email']),SEC_KEY) : '', 'disabled'));?>                                 
                                    </div>
                                    </div>

                                  <?php }else {
                                    ?>
                                     <div class="form-group form-float">
                                      <label class="form-label">Clinic Email</label>
                                      <div class="form-line">
                                       <?php echo $this->Form->input("email" , array("type" => "email","class" => "form-control",'data-msg-required'=>'Enter Clinic Email *','label' => false, 'autocomplete' => 'off','title'=>'Enter Clinic Email', "required" => true,'value' => ''));?>                                 
                                      </div>
                                      </div>
                                    <?php
                                    }
                                    ?>


                                  <div class="form-group form-float margin_top_label_error">
                                      <label class="form-label">Specializations</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->Input("specialization_ids",array("empty"=>"",'label' => false, "class" => "form-control","type"=>"select","options" => $specializations,'data-msg-required'=>'Select Specializations ',"required"=>true, "multiple" => true, 'placeholder' => 'Select Specializations'));?>
                                     
                                  </div>
                                  </div>

                                  <div class="form-group form-float">
                                    <label class="form-label">Access Code</label>  
                                    <div class="form-line">
                                     <?php echo $this->Form->input("access_code" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Access Code*','label' => false, 'title'=>'Enter Access Code', "required" => true));?>
                                   
                                  </div>
                                  </div>

                             
                                  <div class="form-group form-float">
                                      <label class="form-label">Destination url</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("destination_url_for_json" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Destination url *','label' => false, 'title'=>'Enter Destination url', "required" => true));?>
                                   
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                     <label class="form-label">Api Key</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("api_key" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Api Key *','label' => false, 'title'=>'Enter Api Key', "required" => true));?>
                                    
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                       <label class="form-label">Api Secret</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("api_secret" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Api Secret *','label' => false, 'title'=>'Enter Api Secret', "required" => true));?>
                                  
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                   <label class="form-label">System Id</label>   
                                    <div class="form-line">
                                     <?php echo $this->Form->input("api_system_id" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter System Id *','label' => false, 'title'=>'Enter System Id', "required" => true));?>
                                   
                                  </div>
                                  </div>

                                   <div class="form-group form-float">
                                        <label class="form-label">Callidus Group Id</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("cl_group_id" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Callidus Group Id *','label' => false, 'title'=>'Enter Callidus Group Id', "required" => false));?>
                                 
                                  </div>
                                  </div>                                   
                              

                                <div class="form-group form-float">
                                      <label class="form-label">Logo</label>
                                    <div class="form-line">
                    <?php 
                    if(!empty($organizations->clinic_logo)) {
                    ?>                    
                                  <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$organizations->clinic_logo; ?>">
                    <?php } ?>

         <?php echo $this->Form->input("clinic_logo" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Enter Logo ','label' => false, 'title'=>'Please choose png/jpg/jpeg/gif/svg image.', "required" => false));?>
                                   
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <label class="form-label">Clinic Logo Status</label>
                                    <div class="form-line">
                                      <?php $all_organizations = [1 => "Only show allevia logo", 2 => "Replace allevia logo with clinic logo", 3 => "Show both allevia logo and clinic logo"]; ?>
                                     <?php echo $this->Form->Input("clinic_logo_status",array('label' => false, "class" => "form-control","type"=>"select","options" => $all_organizations,'data-msg-required'=> 'Select Clinic Logo Status',"required"=>true,'id' => 'progress_bar_graphic'));?>
                                  
                                    </div>
                                  </div>                                                                                               

                                <div class="form-group form-float">
                                      <label class="form-label">Upload Data Dump(.csv file only)</label>
                             <?php 

  $file_name = WWW_ROOT.'clinic_data_dump/'.$organizations->clinic_data_dump; 
   if(!empty($organizations->clinic_data_dump) && is_file($file_name) && file_exists($file_name)) { ?>
                              <div>    <a href="<?= SITE_URL ?>admin/organizations/download_file/<?= $organizations->clinic_data_dump  ?>">download old file</a></div> 
                              <?php } ?>     
                                 <div class="form-line">
         <?php echo $this->Form->input("clinic_data_dump" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Enter Data Dump ','label' => false, 'title'=>'Please choose data dump file (csv format only).', "required" => false));?>
                                   
                                  </div>
                                  </div> 
                                  <div class="form-group form-float">
                                        <label class="form-label">Payment Amount (In $)</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("payment_amount" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Payment Amount *','label' => false, 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');", 'title'=>'Enter Payment Amount', "required" => true,'
                                     '));?>
                                 
                                  </div>
                                  </div>
                                  <div class="form-line">
                                      <?php echo $this->Form->checkbox('is_show_insurance', ['hiddenField' => false,'id' =>'is_show_insurance', $organizations->is_show_insurance == 1 ? 'checked' : '','value' =>1]); ?>
                                        <label for="is_show_insurance" class="form-label"><b>Show Insurance</b></label>
                                 
                                  </div>                                
                                  <div class="form-line">
                                      <?php echo $this->Form->checkbox('is_show_user_info', ['hiddenField' => false,'id' =>'is_show_user_info', $organizations->is_show_user_info == 1 ? 'checked' : '','value' =>1]); ?>
                                        <label for="is_show_user_info" class="form-label"><b>Show User Information (Address, Pharmacy, Phone Number)</b></label>
                                 
                                  </div>
                                  <div class="form-line">
                                      <?php echo $this->Form->checkbox('is_show_payment', ['hiddenField' => false,'id' =>'is_show_payment', $organizations->is_show_payment == 1 ? 'checked' : '']); ?>
                                        <label for="is_show_payment" class="form-label"><b>Show Payment</b></label>
                                 
                                  </div>                                  
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Clinic</button>
                               
                                
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
<script type="text/javascript">

$( document ).ready(function() { 


  $('#edit_organizations').validate({
        rules: {
            clinic_logo: {
                extension: "png|jpg|jpeg|gif|svg",
            },
            clinic_data_dump: {
                extension: "csv",
            }
        },
    });


});




</script>
