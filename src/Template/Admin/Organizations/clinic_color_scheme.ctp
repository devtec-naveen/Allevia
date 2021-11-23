<script src="<?php echo WEBROOT ?>js/jscolor.js"></script>
<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               Color Scheme
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
                                      <label class="form-label">Heading color</label>
<?php 
  // if(!empty($organizations->heading_color)) echo '<span style="background:'.$organizations->heading_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("heading_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter heading color'));?>
                                 
                                  </div>
                                  </div>
                                  <!-- Add text and title color field -->
                                  <div class="form-group form-float">
                                      <label class="form-label">General title color</label>
<?php 
  // if(!empty($organizations->heading_color)) echo '<span style="background:'.$organizations->heading_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("general_title_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter general title color'));?>
                                 
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                      <label class="form-label">General text color</label>
<?php 
  // if(!empty($organizations->heading_color)) echo '<span style="background:'.$organizations->heading_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("general_text_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter general text color'));?>
                                 
                                  </div>
                                  </div>
                                  <!-- End text and title color field-->
                                  <div class="form-group form-float">
                                      <label class="form-label">Background color</label>
<?php 
  // if(!empty($organizations->background_color)) echo '<span style="background:'.$organizations->background_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                      
                                    <div class="form-line">
                                     <?php echo $this->Form->input("background_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Background color'));?>
                                 
                                  </div>
                                  </div>

<div class="form-group form-float">
                                      <label class="form-label">Dashboard background color</label>
<?php 
  // if(!empty($organizations->background_color)) echo '<span style="background:'.$organizations->background_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                      
                                    <div class="form-line">
                                     <?php echo $this->Form->input("dashboard_background_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter dashboard background color'));?>
                                 
                                  </div>
                                  </div>                                  
                                  <div class="form-group form-float">
                                      <label class="form-label">Text color</label>
<?php 
  // if(!empty($organizations->text_color)) echo '<span style="background:'.$organizations->text_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                        
                                    <div class="form-line">
                                     <?php echo $this->Form->input("text_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Text color'));?>
                                 
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                      <label class="form-label">Button Gradient color 1</label>
<?php 
  // if(!empty($organizations->button_gradient_color1)) echo '<span style="background:'.$organizations->button_gradient_color1.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                            
                                    <div class="form-line">
                                     <?php echo $this->Form->input("button_gradient_color1" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Button gradient color 1'));?>
                                 
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                      <label class="form-label">Button Gradient color 2</label>
<?php 
  // if(!empty($organizations->button_gradient_color2)) echo '<span style="background:'.$organizations->button_gradient_color2.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                                                       
                                    <div class="form-line">
                                     <?php echo $this->Form->input("button_gradient_color2" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Button gradient color 2'));?>
                                 
                                  </div>
                                  </div>
                                  <div class="form-group form-float">
                                      <label class="form-label">Button gradient color 3</label>
<?php 
  // if(!empty($organizations->button_gradient_color3)) echo '<span style="background:'.$organizations->button_gradient_color3.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("button_gradient_color3" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Button gradient color 3'));?>
                                 
                                  </div>
                                  </div>


<div class="form-group form-float">
                                      <label class="form-label">Active button color</label>
<?php 
  // if(!empty($organizations->active_button_color)) echo '<span style="background:'.$organizations->active_button_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("active_button_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Button gradient color 3'));?>
                                 
                                  </div>
                                  </div>                                  

<div class="form-group form-float">
                                      <label class="form-label">Hover state color</label>
<?php 
  // if(!empty($organizations->hover_state_color)) echo '<span style="background:'.$organizations->hover_state_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("hover_state_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Hover state color'));?>
                                 
                                  </div>
                                  </div>
<div class="form-group form-float">
                                      <label class="form-label">Active state color</label>
<?php 
  // if(!empty($organizations->active_state_color)) echo '<span style="background:'.$organizations->active_state_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("active_state_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Active state color'));?>
                                 
                                  </div>
                                  </div>   
<div class="form-group form-float">   
                                      <label class="form-label">Link color</label>
<?php 
  // if(!empty($organizations->link_color)) echo '<span style="background:'.$organizations->link_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("link_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Link color'));?>
                                 
                                  </div>
                                  </div>
<div class="form-group form-float">
                                      <label class="form-label">Link hover color</label>
<?php 
  // if(!empty($organizations->link_hover_color)) echo '<span style="background:'.$organizations->link_hover_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("link_hover_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Link hover color'));?>
                                 
                                  </div>
                                  </div> 

                                     
<div class="form-group form-float">
                                      <label class="form-label">Appointment box background color</label>
<?php 
  // if(!empty($organizations->appoint_box_bg_color)) echo '<span style="background:'.$organizations->appoint_box_bg_color.';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'; 
?>                                               
                                    <div class="form-line">
                                     <?php echo $this->Form->input("appoint_box_bg_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Appointment box background color'));?>
                                 
                                  </div>
                                  </div>     
                                  <div class="form-group form-float">
                                    <label class="form-label">Appointment box button color</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("appoint_box_button_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Appointment box button color'));?>
                                 
                                  </div>
                                  </div>  

                                   <div class="form-group form-float">
                                    <label class="form-label">Appointment box text color</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("appoint_box_text_color" , array("type" => "text","class" => "form-control jscolor  {required:false}",'label' => false, 'title'=>'Enter Appointment box text color'));?>
                                 
                                  </div>
                                  </div>  


                                  <div class="form-group form-float">
                                    <label class="form-label">Progress bar graphic</label>
                                    <div class="form-line">
                                      <?php $all_organizations = ['step_number_active' => "Default", 'dark_green' => "Dark Green"]; ?>
                                     <?php echo $this->Form->Input("progress_bar_graphic",array('label' => false, "class" => "form-control","type"=>"select","options" => $all_organizations,'data-msg-required'=>'Select Progress Bar Graphic ',"required"=>true,'id' => 'progress_bar_graphic'));?>
                                  
                                    </div>
                                  </div>                                                                                              

                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update clinic color scheme</button>
                               
                                
                                </div>
                                <!-- /.box-body -->

                             <?php echo $this->Form->end()?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
      
    </section>

