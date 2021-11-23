<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Send Email
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'email-templates'  ?>">Email Templates</a></li>
                                <li class="active">Send Mail</li>
                            </ol>
                        </div>
                        <div class="body">
                                 <?php echo $this->Form->create(null, array('id'=>'edit_cms','enctype'=>'multipart/form-data')); ?>
      

                                  <div class="form-group form-float margin_top_label_error">
                                      <label class="form-label">Select Users</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->Input("user_id",array("empty"=>"",'label' => false, "class" => "form-control","type"=>"select","options" => $users,'data-msg-required'=>'Select User ',"required"=>true, "multiple" => true, 'placeholder' => 'Select User'));?>
                                     
                                  </div>
                                  </div>  

<?php /*                                                                
                                  <div class="form-group form-float">
                                      <label class="form-label">Subject</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->Input("subject",array("empty"=>"Enter subject",'label' => false, "class" => "form-control","type"=>"text",'data-msg-required'=>'Enter subject ',"required"=>true, "multiple" => true, 'placeholder' => 'Enter subject'));?>
                                     
                                  </div>
                                  </div>
*/ ?>
                            <div class="form-group ">
                                    <label class="form-label">Message</label>
                                    <div class="form-line">
                                    <?php echo $this->Form->input("message" , array("id" => "message", "type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Bottom Content *','label' => false, "required" => true));?>

<!-- <textarea name="message" class="required ckeditor" id="message" required="required"></textarea> -->

  
                                  </div>
                                  </div>

                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Send Email</button>
                               
                                
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
$(document).ready(function() {

// CKEDITOR.replace('message');

// CKEDITOR.instances.message.on('change', function() {  
//     if(CKEDITOR.instances.message.getData().length >  0) {
//      $('label[for="message"]').hide();
//     }
// });


CKEDITOR.on('instanceReady', function () {
    $.each(CKEDITOR.instances, function (instance) {
        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
        CKEDITOR.instances[instance].document.on("change", CK_jQ);
    });
});

function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}



  $('#edit_cms').validate({
        ignore : [],
        // onkeyup: function(element) {$(element).valid()}, 
        rules: {
            // user_id: {
            //   required:true
            // }, 
            message:{    
                required:true,

             // required: function() 
             //    {
             //     CKEDITOR.instances.message.updateElement();
             //    }


            }
        },

                messages:
                    {

                   // user_id:{
                   //      required:"Please choose one or more users."


                   //  },

                    message:{
                        required:"Please enter your message.",
                        // minlength:"Please enter 10 characters"


                    }
                },

          // errorPlacement: function(error, element) 
          //       {
          //           if (element.attr("name") == "message") 
          //          {
          //           error.insertBefore("textarea#message");
          //           } else {
          //           error.insertBefore(element);
          //           }
          //       }               

            }); 
  }); 
</script>

<style type="text/css">
  .margin_top_label_error label.error{

    padding-top: 31px;
}
</style>
