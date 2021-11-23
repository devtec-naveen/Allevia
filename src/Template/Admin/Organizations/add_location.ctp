<section class="content">
   <div class="container-fluid">
      <!-- Basic Examples -->
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
               <div class="header">
                  <h2>
                     Add Location
                  </h2>
                  <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                     <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                     <li><a href="<?= ADMIN_SITE_URL.'organizations'  ?>">Clinics</a></li>
                     <li class="active">Add Location</li>
                  </ol>
               </div>
               <div class="body">
                  <?php echo $this->Form->create( null , array('id'=>'add_location' , 'method' => 'POST')); ?>
                  <div class="form-group form-float">
                   <label class="form-label">Clinics</label>
                   <div class="form-line">
                     <?php echo $this->Form->Input("organization_id",array("empty"=>"Select Clinic",'label' => false, "class" => "form-control","type"=>"select","options" => $all_organizations, "value" => "", "default" => "", 'data-msg-required'=>'Select Clinic ',"required"=>true,'id' => 'clinic_name'));?>

                   </div>
                 </div>
                 
                  <div class="repeatable_section">
                     <div class="form-group form-float">
                        <label class="form-label">Location</label>
                        <div class="form-line">
                           <?php echo $this->Form->input("location[]" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter location *','label' => false, 'title'=>'Enter E-mail', "value" => "", "default" => "",  "required" => true));?>
                        </div>
                     </div>
                  </div>
                  <button id="add_more_doctor_btn" type="button" class="btn btn-primary m-t-15 waves-effect">Add More Location</button>
                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add Location</button>
               </div>
               <!-- /.box-body -->
               <?php echo $this->Form->end()?>
            </div>
         </div>
      </div>
   </div>
   <!-- #END# Basic Examples -->
</section>



<script type="text/javascript">

$( document ).ready(function() { 
  var i = 2; 
  $( "#add_more_doctor_btn" ).click(function() {

   
     var clone_elem = $('.repeatable_section:last').clone( true );
     $(clone_elem).find('.added_selectdiv').remove(); 



     $(clone_elem).insertAfter('.repeatable_section:last');    
      $('.repeatable_section:last').find('label').each(function() {
          if($( this ).hasClass( "error" )) 
            $(this).remove();
      });
     $('.repeatable_section:last').find('input').each(function() {
                            $( this ).parents('.form-line').removeClass('error focused');
                            $( this ).attr('id', 'field_id'+i ) ; 
                                                        $( this ).val( "" );
                                                        i++ ; 
                                                      });  


       $("#add_location").validate({
         ignore: [] ,
        rules: {            
            "location[]": "required",            
        },
        messages:{

          "location[]":{

            'minlength': 'Password should be minimum 8 characters long',
          }
        }
    });   
  });


    $("#add_location").validate({
       ignore: [] ,
        rules: {           
            "location[]": "required",            
        },
        messages:{

          "location[]":{

            'minlength': 'Password should be minimum 8 characters long',
          }
        }
    });
});


</script>


