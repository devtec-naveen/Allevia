<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Doctor
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations/doctors'  ?>">Doctors</a></li>
                                <li class="active">Edit</li>
                            </ol>

                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create($doctors, array('id'=>'edit_doctor')); ?>

                              <div class="form-group form-float">
                                    <label class="form-label">Clinic</label>
                                    <div class="form-line">

                                     <?php echo $this->Form->Input("organization_id",array("empty"=>"Select Clinic",'label' => false, "class" => "form-control","type"=>"select","options" => $all_organizations,'data-msg-required'=>'Select Clinic ',"required"=>true,'id' => 'clinic_name'));?>
                                  
                                  </div>
                                  </div>
                                <div class="form-group form-float">
                          <label class="form-label">Doctor Name</label>                                  
                                    <div class="form-line">
                                     <?php echo $this->Form->input("doctor_name" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Doctor Name*','label' => false, 'title'=>'Enter Doctor Name', "required" => true));?>
                                 
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                          <label class="form-label">Doctor Credential</label>                                  
                                    <div class="form-line">
                                     <?php echo $this->Form->input("credentials" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Credential','label' => false, 'title'=>'Enter Credential', "required" => false));?>
                                 
                                  </div>
                                  </div>
                                  <div class="form-group form-float" id="specialization_box">
                                    <label class="form-label">Specialization</label>
                                    <div class="form-line">                               

                                     <select name="specialization_id" class="form-control selectpicker"  title="Select Specialization" id="clinic_specialization1" tabindex="-98">
                                      <?php if(!empty($specializations)){ 
                                        foreach($specializations as $k => $val){
                                        ?>
                                          <option value="<?php echo $k ; ?>" <?php if($doctors['specialization_id'] == $k){ echo 'selected'; }?>><?php echo $val; ?></option>                                          
                                        <?php } 
                                          } ?>
                                    </select>                                     
                                  </div>
                                  </div>
                                  <?php //pr($visit_reason_data);?>
                                  <div class="form-group form-float visit_reason_box" id="visit_reasons_box">
                                    <label class="form-label">Visit Reasons</label>
                                    <div class="form-line">
                                     <select name="visit_reason_ids[]" class="form-control selectpicker"  title="Select Visit Reasons"  id="visit_reasons" tabindex="-98" multiple="multiple">
                                      <?php if(!empty($visit_reason_data)){ 
                                        $i = 0;
                                        foreach($visit_reason_data as $k => $val){                                          
                                        ?>
                                          <option value="<?php echo $k ; ?>" <?php if(in_array($k, $doctorVisitReasons)) { echo 'selected'; } ?> ><?php echo $val; ?></option>  
                                         <?php $i++; }                                         
                                          } ?>
                                    </select>                                     
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
                                          <option value="<?php echo $k ; ?>" <?php if(in_array($k, $doctor_location)) { echo 'selected'; } ?> ><?php echo $val; ?></option>  
                                         <?php $i++; }                                         
                                          } ?>
                                    </select>                                     
                                  </div>
                                  </div>



                                  <div class="form-group form-float"> 
                                    <label class="form-label">E-mail</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("email" , array("type" => "email","class" => "form-control",'data-msg-required'=>'Enter E-mail *','label' => false, 'title'=>'Enter E-mail', "required" => false));?>                                     
                                  </div>
                                  </div>                                 
                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect" id="update_doctor"> Update Doctor</button>
                               
                                
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
      })
      
      $('#clinic_name').on('change',function(){

        var clinic_id = $(this).val();
        $.ajax({
                type: "GET",
                url: "<?php echo SITE_URL; ?>"+"/admin/organizations/getSpecializationLocation",
                data: {
                  // 'search_type' : 1, // 1 for searching medical  condition
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
                  var specializations_data = msg.specializations_data;
                  var location_data = msg.location_data;
                  var sep_options = '';
                  var loc_options = '';

                  if(msg.success){

                    if(specializations_data.length <= 0){

                      sep_options += '<option value="">Select Specialization</option>';
                    }

                    if(location_data.length <= 0){

                      loc_options += '<option value="">Select Location</option>';
                    }


                    $.each(specializations_data, function(index, element) {

                      sep_options += '<option value='+index+'>'+element+'</option>'; 
                                     
                    });

                    $.each(location_data, function(index, element) {

                      loc_options += '<option value='+index+'>'+element+'</option>'; 
                                        
                    });          
          
                  }

                  $('#clinic_specialization1').empty();
                  $('#clinic_specialization1').append(sep_options);
                  $('#clinic_location').empty();
                  $('#clinic_location').append(loc_options);
                   //$('.selectpicker').selectpicker('render');
                   $('.selectpicker').selectpicker('refresh');
                  $('#update_doctor').removeClass('disabled');
                  $('#update_doctor').html('Update Doctor');

                }
            });
      })
    $(document).ready(function(){

$('#clinic_specialization1').on('change',function(){        
    var specialization_id = $(this).val();
    //alert(specialization_id)
    $.ajax({
                  type: "GET",
                  url: "<?php echo SITE_URL; ?>"+"/admin/organizations/getVisitReasons",
                  data: {                 
                    'specialization_id' : specialization_id
                  },
                  dataType: "text",
                  beforeSend:function(){
                  },

                  success: function(res){
                    var res = JSON.parse(res);
                    var visit_reason_data = res.visit_reason_data;
                    var vis_reas_options = '';      

                    if(res.success){

                      if(visit_reason_data.length <= 0){

                        vis_reas_options += '<option value="">Select Visit Reason</option>';
                      }         

                      $.each(res.visit_reason_data, function(index, element) {

                        vis_reas_options += '<option value='+index+'>'+element+'</option>'; 
                                       
                      });                 
                    } 
                    //alert(vis_reas_options);                
                    $('.visit_reason_box select').empty();
                    $('.visit_reason_box select').append(vis_reas_options);
                    $('.selectpicker').selectpicker('refresh');

                  }
            });
});
})
    </script>
