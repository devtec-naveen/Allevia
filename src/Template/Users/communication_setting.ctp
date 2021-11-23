
<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>Communications</h3>
    <div class="seprator"></div>
       <?= $this->Flash->render() ?>
   </div> 
   
      <?php echo $this->Form->create( null , array(   'autocomplete' => 'off', 
                    
              'inputDefaults' => array(
              'label' => false,
              'div' => false,
                      
              ),'enctype' => 'multipart/form-data', 'id' => 'contact_form')); ?>     
   <div class="form_fild_content row">
 

    <div class="col-md-6" style="margin: auto; ">
    

<div class="form-group form_fild_row"> 

<div class="custom-control custom-checkbox">
         <?php echo $this->Form->checkbox('text_msg', ['hiddenField' => true, 'class' => 'custom-control-input', 'id' => 'text_msg', 'checked' => ($curuser->text_msg == 1 ? true : false) ,   'required' => false]); ?>
         <label class="custom-control-label" for="text_msg">Do you accept text message communications?</label>
          
        </div>


     </div>
<div class="form-group form_fild_row"> 
<div class="custom-control custom-checkbox">
         <?php echo $this->Form->checkbox('email_msg', ['hiddenField' => true, 'class' => 'custom-control-input', 'id' => 'email_msg', 'checked' => ($curuser->email_msg == 1 ? true : false) ,  'required' => false]); ?>
         <label class="custom-control-label" for="email_msg">Do you accept email message communications?</label>
          
        </div>

     </div>     



     
     
       
     <div class="form_submit_button">
      <button type="submit" class="btn">Submit</button>
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
    // $("#contact_form").validate();
  }); 

</script>