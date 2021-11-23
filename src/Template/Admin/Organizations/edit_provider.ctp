<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
                
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Provider
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations/providers'  ?>">Providers</a></li>
                                <li class="active">Edit</li>
                            </ol>

                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($user, array('id'=>'edit_provider')); ?>

                               <div class="form-group form-float">
                                    <label class="form-label">Clinic</label>
                                    <div class="form-line">

                                     <?php echo $this->Form->Input("organization_id",array("empty"=>"Select Clinic",'label' => false, "class" => "form-control","type"=>"select","options" => $all_organizations,'data-msg-required'=>'Select Clinic ',"required"=>true));?>
                                  
                                  </div>
                                </div>


                                <div class="form-group form-float" id="clinic_box">
                                    <label class="form-label">Location</label>
                                    <div class="form-line">
                                     <select name="location[]" class="form-control selectpicker"  title="Select Location"  id="clinic_location" tabindex="-98" multiple="multiple">
                                      <?php if(!empty($org_location)){ 
                                        $i = 0;
                                        foreach($org_location as $k => $val){                                          
                                        ?>
                                          <option value="<?php echo $k ; ?>" <?php if(in_array($k, $provider_location)) { echo 'selected'; } ?> ><?php echo $val; ?></option>  
                                         <?php $i++; }                                         
                                          } ?>
                                    </select>                                     
                                  </div>
                                  </div>


                                <div class="form-group form-float">
                                    <label class="form-label">Provider Email</label>                                  
                                    <div class="form-line">
                                     <?php echo $this->Form->input("email" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Provider Email*','label' => false, 'title'=>'Enter Provider Email', "required" => true,'value' => !empty($user->email) ? $this->CryptoSecurity->decrypt(base64_decode($user->email),SEC_KEY) : ""));?>
                                 
                                    </div>
                                </div>

                                <!-- <div class="form-group form-float">
                                    <label class="form-label">Provider Password</label>                                  
                                    <div class="form-line">

                                      <?php echo $this->Form->input("password" , array("type" => "password","class" => "form-control",'data-msg-required'=>'Enter Provider Password*','label' => false, 'title'=>'Enter Provider Password','value'=>"","required" => false));?>
                                 
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <label class="form-label">Confirm Password</label>                                  
                                    <div class="form-line">
                                     <?php echo $this->Form->input("confirm_password" , array("type" => "password","class" => "form-control",'data-msg-required'=>'Enter Confirm Password*','label' => false, 'title'=>'Enter Confirm Password'));?>
                                 
                                    </div>
                                </div> -->

                                 <div class="form-group form-float">
                                        <label class="form-label">Callidus Provider Id</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("cl_provider_id" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Callidus Provider Id *','label' => false, 'title'=>'Enter Callidus Provider Id', "required" => false, 'value' => !empty($user->cl_provider_id) ? $this->CryptoSecurity->decrypt(base64_decode($user->cl_provider_id),SEC_KEY) : ""));?>
                                 
                                  </div>
                                  </div>                                  
                                        
                                  <div class="form-line">
                                      <?php echo $this->Form->checkbox('is_allow_analytics', ['hiddenField' => false,'id' =>'is_allow_analytics', $user->is_allow_analytics == 1 ? 'checked' : '','value' =>1]); ?>
                                        <label for="is_allow_analytics" class="form-label"><b>Show Analytics</b></label>
                                 
                                  </div>
                                 
                                  <div class="form-line">
                                      <?php echo $this->Form->checkbox('is_hide_summary', ['hiddenField' => false,'id' =>'is_hide_summary', $user->is_hide_summary == 1 ? 'checked' : '','value' =>1]); ?>
                                        <label for="is_hide_summary" class="form-label"><b>Show Summary</b></label>
                                 
                                  </div>


                                  
                                  
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect"> Update Provider</button>
                               
                                
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
        $(document).ready(function(){

          $('.selectpicker').selectpicker('refresh');
        });
      
      $('#organization-id').on('change',function(){
              
        var clinic_id = $(this).val();

             $.ajax({
                type: "GET",
                url: "<?php echo SITE_URL; ?>"+"/admin/organizations/getlocation",
                data: {                 
                  'clinic_id' : clinic_id
                },
                dataType: "text",
                beforeSend:function(){
                  $('#update_doctor').addClass('disabled');
                  $('#update_doctor').html('<img src="<?php echo SITE_URL.'/images/spinner.gif'?>" width="31px">');
                  $('#update_doctor').css('width','117px');
                },

                success: function(msg){
                 var msg = JSON.parse(msg);
                 var locations_data = msg.locations_data;
                 var options = '';

                if(msg.success){ 

                  if(locations_data.length <= 0){

                    options += '<option value="">Select Location</option>';
                  }
                 
                  
                  $.each(locations_data, function(index, element) {

                    options += '<option value='+index+'>'+element+'</option>'; 
                                     
                  });                  
                }                 
                
                $('#clinic_location').empty();
                $('#clinic_location').append(options);
                $('.selectpicker').selectpicker('refresh');
                $('#update_doctor').removeClass('disabled');
                $('#update_doctor').html('Update Doctor');
              }
            });
        // console.log(org_specializations);
      })
    </script>

