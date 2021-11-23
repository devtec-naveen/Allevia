
<section class="content">
  <div class="container-fluid">
   <!-- Basic Examples -->
   <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            Add Doctor
          </h2>
          <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
            <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
            <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
            <li><a href="<?= ADMIN_SITE_URL.'organizations/doctors'  ?>">Doctors</a></li>
            <li class="active">Add</li>
          </ol>
        </div>
        <div class="body">
         <?php echo $this->Form->create( null , array('id'=>'add_doctor' , 'method' => 'POST')); ?>

         <div class="form-group form-float">
           <label class="form-label">Clinics</label>
           <div class="form-line">
             <?php echo $this->Form->Input("organization_id",array("empty"=>"Select Clinic",'label' => false, "class" => "form-control","type"=>"select","options" => $all_organizations, "value" => "", "default" => "", 'data-msg-required'=>'Select Clinic ',"required"=>true,'id' => 'clinic_name'));?>

           </div>
         </div>

         <div class="form-group form-float clicnic_org specialization_box">
           <label class="form-label">Specialization</label>
           <div class="form-line">
            <select name="specialization_id[]"  class="form-control selectpicker clinic_specialization" data-msg-required='Select Specialization' required="true" id="clinic_specialization1" data-number ="1">
              <option value="">Select Specialization</option>                                      
            </select> 
          </div>
        </div>
        <div class="form-group form-float visit_reason_box">
          <label class="form-label">Visit Reasons</label>
            <div class="form-line">
             <select name="visit_reason_ids[0][]" class="form-control selectpicker" title='Select Visit Reasons' id="visit_reason1" tabindex="-98" multiple="multiple">
              <option value="">Select Visit Reasons</option>
            </select>                                     
          </div>
        </div>
        <div class="form-group form-float location_box">
          <label class="form-label">Location</label>
          <div class="form-line">
           <select multiple="multiple" name="location[0][]"  class="form-control selectpicker" id="clinic_location1">
              <option value="">Select Location</option>                                                  
            </select>                                  
        </div>
        </div>

      <div class="repeatable_section"> 

                                <div class="form-group form-float">
                                  <label class="form-label">Doctor Name</label>
                                  <div class="form-line">
                                   <?php echo $this->Form->input("doctor_name[]" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Doctor Name*','label' => false, 'title'=>'Enter Doctor Name', "value" => "", "default" => "",  "required" => true));?>                                   
                                 </div>
                               </div>

                               <div class="form-group form-float">
                                <label class="form-label">Doctor Credential</label>
                                <div class="form-line">
                                 <?php echo $this->Form->input("credentials[]" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Credential','label' => false, 'title'=>'Enter Credential', "value" => "", "default" => "",  "required" => false));?>

                               </div>
                             </div>


                             <div class="form-group form-float">
                              <label class="form-label">E-mail</label>
                              <div class="form-line">
                               <?php echo $this->Form->input("email[]" , array("type" => "email","class" => "form-control",'data-msg-required'=>'Enter E-mail *','label' => false, 'title'=>'Enter E-mail', "value" => "", "default" => "",  "required" => false));?>

                             </div>
                           </div>

                         </div>  

                         <button id="add_more_doctor_btn" type="button" class="btn btn-primary m-t-15 waves-effect">Add More Doctor</button>

                         <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create Doctor</button>


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

  $( document ).ready(function() 
  { 
    var i = 2;
    $( "#add_more_doctor_btn" ).click(function() 
    {

      var clinic_id = $('#clinic_name').val();
      
    $.ajax({
      type: "GET",
      url: "<?php echo SITE_URL; ?>"+"/admin/organizations/getSpecializationLocation",
      data: {                 
        'clinic_id' : clinic_id
      },
      dataType: "text",
      beforeSend:function(){
        $('#add_more_doctor_btn').addClass('disabled');
        $('#add_more_doctor_btn').html('<img src="<?php echo SITE_URL.'/images/spinner.gif'?>" width="31px">');
        $('#add_more_doctor_btn').css('width','117px');
      },

      success: function(msg){

        var msg = JSON.parse(msg);
        console.log(msg);
        var total_location = $('body .location_box').length;
        console.log(total_location);

         //add slect box for specialization
        var data = '<div class="added_selectdiv form-group form-float specialization_box"> <label class="form-label">Specialization</label><div class="form-line"><select name="specialization_id[]" class = "form-control selectpicker clinic_specialization" id="clinic_specialization'+i+'" data-number = "'+i+'"><option value="">Select Specialization</option>'; 

        $.each(msg.specializations_data, function(index, element) {

            data += '<option value='+index+'>'+element+'</option>'; 
            
          });
        data += '</select> </div></div>';

         // Visit reason selector
        // var visitReason_data = '';
        data += '<div class="form-group form-float visit_reason_box"> <label class="form-label">Visit Reasons</label>';
        data += '<div class="form-line">';
        data += '<select multiple="multiple" name="visit_reason_ids['+total_location+'][]" class = "form-control selectpicker" id="visit_reason'+i+'" tabindex= "-98">';
        
        data += '</select> </div></div>';
        // $(clone_elem).prepend(visitReason_data);
        // end

        

      //add slect box for location
      data += '<div class="form-group form-float location_box"> <label class="form-label">Location</label>';
      data += '<div class="form-line">';
      data += '<select multiple="multiple" name="location['+total_location+'][]" class = "form-control selectpicker" id="clinic_location'+i+'" tabindex= "-98">';
      
      $.each(msg.location_data, function(index, element) {
            data += '<option value='+index+'>'+element+'</option>';
        });

        data += '</select> </div></div>';

       //console.log(data);
        var clone_elem = $('.repeatable_section:last').clone( true );
        //console.log(clone_elem);        
        $(clone_elem).find('.added_selectdiv').remove();
        $(clone_elem).find('.location_box').remove();
        $(clone_elem).find('.visit_reason_box').remove();
        //alert(clone_elem)
        $(clone_elem).prepend(data);        
        
        $(clone_elem).insertAfter('.repeatable_section:last');
        $('.repeatable_section:last').find('label').each(function() {
            if($( this ).hasClass( "error" )) 
              $(this).remove();
        });
        $('.repeatable_section:last').find('input').each(function() {
          $( this ).parents('.form-line').removeClass('error focused');
          $( this ).attr('id', 'field_id'+i ); 
          $( this ).val( "" );
          i++ ; 
        });
        //$('.selectpicker').selectpicker('destroy');
        $('.selectpicker').selectpicker('render');
        $('.selectpicker').selectpicker('refresh');

        $('#add_more_doctor_btn').removeClass('disabled');
        $('#add_more_doctor_btn').html('Add More Doctor');

        $("#add_doctor").validate({
          ignore: [] ,
          rules: {
              "organization_id": "required", 
              "specialization_id[]": "required", 
              "doctor_name[]": "required", 
              // "email[]": "required", 
          }
        });

      }
    });   
});

  $("#add_doctor").validate({
    ignore: [] ,
    rules: {
      "organization_id": "required", 
      "specialization_id[]": "required", 
      "doctor_name[]": "required",            
    }
  });

});

$('#clinic_name').on('change',function(){        
    var clinic_id = $(this).val();
    $.ajax({
      type: "GET",
      url: "<?php echo SITE_URL; ?>"+"/admin/organizations/getSpecializationLocation",
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
        var specializations_data = msg.specializations_data;
        var location_data = msg.location_data;
        var sep_options = '';
        var loc_options = '';        
        var vis_rea_options = '';
        if(msg.success){

          if(specializations_data.length <= 0){

            sep_options += '<option value="">Select Specialization</option>';
          }

          if(location_data.length <= 0){

            loc_options += '<option value="">Select Location</option>';
          }
          if(location_data.length <= 0){

            vis_rea_options += '<option value="">Select Visit Reason</option>';
          }         

          $.each(msg.specializations_data, function(index, element) {

            sep_options += '<option value='+index+'>'+element+'</option>'; 
                           
          });

          $.each(msg.location_data, function(index, element) {

            loc_options += '<option value='+index+'>'+element+'</option>'; 
                              
          }); 
          $.each(msg.visit_reason_data, function(index, element) {

            vis_rea_options += '<option value='+index+'>'+element+'</option>'; 
                              
          });                 
        }                 
        $('.specialization_box select').empty();
        $('.specialization_box select').append(sep_options);
        $('.location_box select').empty();
        $('.location_box select').append(loc_options);
        $('.visit_reason_box select').empty();
        $('.visit_reason_box select').append(vis_rea_options);
         //$('.selectpicker').selectpicker('render');
        // $("div").find('.visit_reason_box').removeClass("visit_reason_box");
        // $('#update_doctor').removeClass('visit_reason_box');
        $('.selectpicker').selectpicker('refresh');
        $('#update_doctor').removeClass('disabled');
        $('#update_doctor').html('Update Doctor');

      }
    });                   
  })


$(document).ready(function(){

//$('select.clinic_specialization').on('change',function(){ 

  $(document).on('change','select.clinic_specialization',function(){
  // alert('test');
    var id = $(this).attr('id');    
    var data_number = $(this).attr('data-number');   
    var specialization_id = $('#'+id).val();
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
                    $('#visit_reason'+data_number).empty();
                    $('#visit_reason'+data_number).append(vis_reas_options);
                    $('.selectpicker').selectpicker('refresh');

                  }
            });
});
})
</script>


