<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3><?php echo $aboutus_data->title ?></h3>
    <div class="seprator"></div>
       <?= $this->Flash->render() ?>
   </div> 
   
      <?php echo $this->Form->create(null , array(   'autocomplete' => 'off', 
                    
              'inputDefaults' => array(
              'label' => false,
              'div' => false,
                      
              ),'enctype' => 'multipart/form-data', 'id' => 'contact_form')); ?>     
   <div class="form_fild_content row">
 

    <div class="col-md-6">
     <div class="form-group form_fild_row"> 
      <!-- <input type="text" class="form-control" placeholder="Name"/>  -->

  <?php echo  $this->Form->control('name', ['type' => 'text', 'class' => 'form-control', 'placeholder' => 'Name', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>

     </div>
     
     <div class="form-group form_fild_row"> 
      <!-- <input type="text" class="form-control" placeholder="Name"/>  -->

  <?php 

  $options = ['Provider' => 'Provider', 'Payor' => 'Payor', 'Patient' => 'Patient', 'Other' => 'Other']; 
  echo  $this->Form->control('contatus_with_role', ['type' => 'select', 'options' => $options , 'empty' => 'Enter your role', 'class' => 'form-control', 'placeholder' => 'Name', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>

     </div>     


     <div class="form-group form_fild_row"> 
      <!-- <input type="text" class="form-control" placeholder="Email id"/>  -->
     <?php echo  $this->Form->control('email', ['type' => 'email', 'class' => 'form-control', 'placeholder' => 'Email id', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>      
     </div>
     
     <div class="form-group form_fild_row"> 
      <!-- <input type="text" class="form-control" placeholder="Subject"/>  -->
        <?php echo  $this->Form->control('subject', ['type' => 'text', 'class' => 'form-control', 'placeholder' => 'Subject', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>      
     </div>
     
     <div class="form-group form_fild_row"> 
      <!-- <textarea class="form-control" placeholder="Message"></textarea> -->
<?php echo $this->Form->textarea('message', ['class' => 'form-control', 'placeholder' => 'Message', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>      
     </div>
       
     <div class="form_submit_button">
      <button type="submit" class="btn">Send</button>
     </div>
      </div> 
  
    <div class="col-md-6 ger_box">
     <div class="form_ger">
      <img src="<?= WEBROOT ?>img/<?php echo $aboutus_data->image ?>"/>
     </div>
    </div>
   </div>
     <?php echo $this->Form->end(); ?>   
  </div> 
   </div> 
  </div> 
 </div>
</div>
<script type="text/javascript">
  

  $().ready(function() {
    // validate the comment form when it is submitted
    $("#contact_form").validate();

  }); 

</script>