<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>My Profile</h3>
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
        <label>Password</label>
        <?php echo  $this->Form->control('password', ['type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'label' => false, 'autocomplete' => 'off', 'required' => true]); ?>  

     </div>   



     <?php /*        
     <div class="form-group form_fild_row"> 
      <!-- <input type="text" class="form-control" placeholder="Email id"/>  -->
     <?php echo  $this->Form->control('email', ['type' => 'email', 'class' => 'form-control', 'placeholder' => 'Email id', 'label' => false, 'autocomplete' => 'off', 'required' => 'required']); ?>      
     </div>
     */ ?>
     
     
     
       
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
    $("#contact_form").validate({
            rules : {
                password : {
                    minlength : 6
                }
            }          
        });
  }); 

</script>