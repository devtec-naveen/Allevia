<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Home Page
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
<!--                                 <li><a href="<?= ADMIN_SITE_URL.'cms'  ?>">CMS</a></li> -->
                                <li class="active">Edit Home Page</li>
                            </ol>
                        </div>
                        <div class="body">
                           <?= $this->Flash->render() ?>
                                 <?php echo $this->Form->create($homepagedata, array('id'=>'edit_home_page','enctype'=>'multipart/form-data')); ?>
                       

 
                                <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec1_main_title" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 1 title','label' => false, 'title'=>'Enter Section 1 title', "required" => true));?>
                                     <label class="form-label">Enter Section 1 title</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">

                                    <label class="form-label">Home page section 1 Image</label>

                                    <div class="form-line">
                                  <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img1; ?>">                                      
                                     <?php echo $this->Form->input("homepage_sec1_img1" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Enter ','label' => false, 'title'=>'Please choose png/jpg/jpeg/gif/svg image.', "required" => false));?>
                                     
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec1_subtitle1" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 1 Subtitle 1 ','label' => false, 'title'=>'Enter Section 1 Subtitle 1', "required" => true));?>
                                     <label class="form-label">Enter Section 1 Subtitle 1</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <label class="form-label">Enter Section 1 Content 1</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec1_content1" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Section 1 Content 1','label' => false,  "required" => true));?>
                                     
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                        <label class="form-label">Enter Section 1 Image 2</label>                                    
                                    <div class="form-line">

                                  <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img2; ?>">

                                     <?php echo $this->Form->input("homepage_sec1_img2" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Enter Section 1 Image 2','label' => false, 'title'=>'Enter Section 1 Image 2', "required" => false));?>
                                     
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec1_subtitle2" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 1 Subtitle 2','label' => false, 'title'=>'Enter Section 1 Subtitle 2', "required" => true));?>
                                     <label class="form-label">Enter Section 1 Subtitle 2</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <label class="form-label">Enter Section 1 Content 2</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec1_content2" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Section 1 Content 2','label' => false,  "required" => true));?>
                                     
                                  </div>
                                  </div>



                                  <div class="form-group form-float">
                  <label class="form-label">Enter Section 1 Image 3</label>                                    
                                    <div class="form-line">
                                 <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec1_img3; ?>">

                                     <?php echo $this->Form->input("homepage_sec1_img3" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Enter Section 1 Image 3','label' => false, 'title'=>'Enter Section 1 Image 3', "required" => false));?>
                                     
                                  </div>
                                  </div>

                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec1_subtitle3" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 1 Subtitle 3','label' => false, 'title'=>'Enter Section 1 Subtitle 3', "required" => true));?>
                                     <label class="form-label">Enter Section 1 Subtitle 3</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <label class="form-label">Enter Section 1 Content 3</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec1_content3" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Section 1 Content 3','label' => false,  "required" => true));?>
                                     
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec2_maintitle" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 2 Main Title','label' => false, 'title'=>'Enter Section 2 Main Title', "required" => true));?>
                                     <label class="form-label">Enter Section 2 Main Title</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                <label class="form-label">Enter Section 2 Image</label>                                    
                                    <div class="form-line">
                                 <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec2_img; ?>">                                      
                                     <?php echo $this->Form->input("homepage_sec2_img" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Enter Section 2 Image','label' => false, 'title'=>'Enter Section 2 Image', "required" => false));?>
                                     
                                  </div>
                                  </div>
       
 

                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec2_subtitle" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 2 Subtitle','label' => false, 'title'=>'Enter Section 2 Subtitle', "required" => true));?>
                                     <label class="form-label">Enter Section 2 Subtitle</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <label class="form-label">Enter Section 2 Content</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec2_content" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Section 2 Content','label' => false,  "required" => true));?>
                                     
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_embed_video_url" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Embed Video Url','label' => false, 'title'=>'Enter Embed Video Url', "required" => true));?>
                                     <label class="form-label">Enter Embed Video Url</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec3_maintitle" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 3 Main Title','label' => false, 'title'=>'Enter Section 3 Main Title', "required" => true));?>
                                     <label class="form-label">Enter Section 3 Main Title</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                      <label class="form-label">Enter Section 3 Image</label>                                    
                                    <div class="form-line">
                                 <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$homepagedata->homepage_sec3_image; ?>">

                                     <?php echo $this->Form->input("homepage_sec3_image" , array("type" => "file","class" => "form-control",'data-msg-required'=>'Enter Section 3 Image','label' => false, 'title'=>'Enter Section 3 Image', "required" => false));?>
                                     
                                  </div>
                                  </div>

                                  <div class="form-group form-float">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec4_maintitle" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter Section 4 Main Title','label' => false, 'title'=>'Enter Section 4 Main Title', "required" => true));?>
                                     <label class="form-label">Enter Section 4 Main Title</label>
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                     <label class="form-label">Enter Section 4 Content</label>

                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec4_content" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Section 4 Content','label' => false,  "required" => true));?>
                                  </div>
                                  </div>  

                            <?php 

                          if(!empty($homepagedata->homepage_sec4_tabletext)){
                            $homepage_sec4_tabletext = explode('###', $homepagedata->homepage_sec4_tabletext) ; 

                            $homepage_sec4_tabletext = array_filter($homepage_sec4_tabletext);
                            foreach ($homepage_sec4_tabletext as $key => $value) {
                        
                         
                            ?>
                              <div class="form-group form-float repeatable_section">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec4_tabletext[]" , array("type" => "text","value" => $value  ,"class" => "form-control",'data-msg-required'=>'Enter Section 4 Table Text','label' => false, 'title'=>'Enter Section 4 Table Text', "required" => true));?>
                                     <label class="form-label">Enter Section 4 Table Text</label>

                                  </div>


                                  </div>


                            <?php 
                            }
                          }   
                            ?>


                                  <div class="form-group form-float repeatable_section">
                                    <div class="form-line">
                                     <?php echo $this->Form->input("homepage_sec4_tabletext[]" , array("type" => "text","value" => "", "class" => "form-control",'data-msg-required'=>'Enter Section 4 Table Text','label' => false, 'title'=>'Enter Section 4 Table Text', "required" => true));?>
                                     <label class="form-label">Enter Section 4 Table Text</label>

                                  </div>


                                  </div> 
             <button type="button" id="add_more_doctor_btn" class="btn btn-primary m-t-15 waves-effect">Add more Table text</button>                                                                 




                                   <!-- <div class="form-group ">
                                    <label class="form-label">Description</label>
                                    <div class="form-line">
                                    <?php // echo $this->Form->input("content" , array("type" => "textarea","class" => "form-control ckeditor",'data-msg-required'=>'Enter Page Description *','label' => false, "required" => true));?>
                                    
                                  </div>
                                  </div> -->















                                 
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update HOME Page</button>
                               
                                
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
  var i = 2; 
  $( "#add_more_doctor_btn" ).click(function() {

   
     var clone_elem = $('.repeatable_section:last').clone( true );

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

  });


  $('#edit_home_page').validate({
        rules: {
            homepage_sec1_img1: {
                extension: "png|jpg|jpeg|gif|svg",
            },
            homepage_sec1_img2: {
                extension: "png|jpg|jpeg|gif|svg",
            },
            homepage_sec1_img3: {
                extension: "png|jpg|jpeg|gif|svg",
            },
            homepage_sec2_img: {
                extension: "png|jpg|jpeg|gif|svg",
            },
            homepage_sec3_image: {
                extension: "png|jpg|jpeg|gif|svg",
            },

        },
    });


});

</script>