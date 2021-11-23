<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add Providers
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                                <li class="active">Add Providers</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create( null , array('id'=>'add_doctor' , 'method' => 'POST')); ?>

                                 <input type="hidden" name="organization_id" id="organization_id" value="<?php echo $organization['id']; ?>">

                              <div class="form-group form-float">
                                 <label class="form-label">Clinic</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->Input("organization_name",array('label' => false, "class" => "form-control","type"=>"text","value" => $organization['organization_name'], "required"=>true, 'readonly' => true));?>
                                    
                                  </div>
                                  </div>

                                  

                                  <div class="form-group form-float location_box">
                                    <label class="form-label">Location</label>
                                    <div class="form-line">
                                     <select name="location[0][]" class="form-control selectpicker"  title="Select Location"  id="clinic_location" tabindex="-98" multiple="multiple">
                                      <?php if(!empty($location)){ 
                                       
                                            foreach($location as $k => $val){                                          
                                            ?>
                                              <option value="<?php echo $k ; ?>" ><?php echo $val; ?></option>  
                                      <?php }                                         
                                          }
                                          else{ ?>

                                              <option value="">Select Location</option>
                                      <?php } ?>
                                    </select>                                     
                                  </div>
                                  </div>


                                <div class="repeatable_section">  
                                 

                                  <div class="form-group form-float">
                                      <label class="form-label">E-mail</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("email[]" , array("type" => "email","class" => "form-control",'data-msg-required'=>'Enter E-mail *','label' => false, 'title'=>'Enter E-mail', "value" => "", "default" => "",  "required" => true));?>
                                   
                                  </div>
                                  </div>

                                   <div class="form-group form-float">
                                      <label class="form-label">Password</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("password[]" , array("type" => "password","class" => "form-control",'data-msg-required'=>'Enter Password *','label' => false, 'title'=>'Enter Password', "value" => "", "default" => "",  "required" => true));?>
                                   
                                  </div>
                                  </div>

                                  <div class="form-group form-float">
                                      <label class="form-label">Confirm Password</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("confirm_password[]" , array("type" => "password","class" => "form-control",'data-msg-required'=>'Enter Password *','label' => false, 'title'=>'Enter Password', "value" => "", "default" => "",  "required" => true));?>
                                   
                                  </div>
                                  </div>

                                  <div class="form-group form-float">
                                        <label class="form-label">Callidus Provider Id</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("cl_provider_id[]" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Callidus Provider Id *','label' => false, 'title'=>'Enter Callidus Provider Id', "required" => false));?>
                                 
                                  </div>
                                  </div>
                               
                                  
                        </div>  

                        <button id="add_more_doctor_btn" type="button" class="btn btn-primary m-t-15 waves-effect">Add More Provider</button>

                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add Provider</button>
                               
                                
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

$( document ).ready(function() { 
  var i = 1; 
  $( "#add_more_doctor_btn" ).click(function() {

    var clicknicId = $("#organization_id").val();    
    var clone_elem = $('.repeatable_section:last').clone( true );
    $(clone_elem).find('.location_box').remove();
    var total_location = $('body .repeatable_section').length;
    var data = '';
    data += '<div class="form-group form-float location_box"> <label class="form-label">Location</label>';
    data += '<div class="form-line">';
    data += '<select multiple="multiple" name="location['+total_location+'][]" class = "form-control selectpicker" id="clinic_location'+i+'" tabindex= "-98">';
    data += '<?php 
      foreach ($location as $key => $value) {
        echo '<option value="'.$key.'">'.$value.'</option>' ; 
      }
      ?>
      ';
    data += '</select> </div></div>';

    $(clone_elem).prepend(data);

      $(clone_elem).insertAfter('.repeatable_section:last');     
      $('.repeatable_section:last').find('label').each(function() {
          if($( this ).hasClass( "error" )) 
            $(this).remove();
      });
      $('.repeatable_section:last').find('input').each(function() 
      {
          $( this ).parents('.form-line').removeClass('error focused');
          $( this ).attr('id', 'field_id'+i ) ; 
          $( this ).val( "" );
          i++;                                                        
      });

      $('.selectpicker').selectpicker('refresh');
       $("#add_doctor").validate({
         ignore: [] ,
        rules: {
            "organization_id": "required", 
            "organization_name": "required", 
            "email[]": "required", 
            "password[]": {
              "required": true,
              'minlength': 8 
          } 
        },
        messages:{
          "password[]":{
            'minlength': 'Password should be minimum 8 characters long',
          }
        }
    });   
    i++ ;  
  });

  $("#add_doctor").validate({
       ignore: [] ,
        rules: {
           "organization_id": "required", 
            "organization_name": "required", 
            "email[]": "required", 
            "password[]": {
              "required": true,
              'minlength': 8 
            }
        },
        messages:{
          "password[]":{
            'minlength': 'Password should be minimum 8 characters long',
          }
        }
    });
});

</script>


