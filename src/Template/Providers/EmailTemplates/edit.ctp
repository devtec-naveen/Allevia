<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Edit Email and Text Template</h4>
          </div>
          <div class="card-body">
              <ul> 
              <li>                             
                Please don't change keywords '{username}' and '{link}'.
              </li>
              </ul>
              <hr> 
             <?php echo $this->Form->create($emailtemplates, array('id'=>'edit_email_template')); ?>
             <!-- <div class="form-group">
               <textarea class="form-control" placeholder="dummy"></textarea>
             </div> -->
             
              <div class="form-group">
              <label class="form-label">Email Template Name</label>
              <?php echo $this->Form->input("name" , array("type" => "text","class" => "form-control",'label' => false, "title"=>"Please Enter E-mail Template Name", "required" => "required"));?>             
              </div>

              <div class="form-group"> 
              <label class="form-label">Email Template Subject</label>               
              <?php echo $this->Form->input("subject" , array("type" => "text","class" => "form-control",'label' => false, "title"=>"Please Enter E-mail Template Subject", "required" => "required"));?>                        
             </div>

             <div class="form-group">
              <label class="form-label">Email Template Description</label>
              <div class="form-line">
             <?php echo $this->Form->input("description" , array("type" => "textarea","class" => "form-control ckeditor",'label' => false, "title"=>"Please Enter E-mail Template Description", "required" => "required"));?>
            </div>
            </div>

            <div class="form-group">
              <label class="form-label">Text Message Description</label>
              <div class="form-line">
             <?php echo $this->Form->input("text_message" , array("type" => "textarea","class" => "form-control ckeditor",'label' => false, "title"=>"Please Enter Text Message Description", "required" => 'required'));?>
            </div>
            </div>             
             <div class="btns">
               <!-- <button class="btn btn-blue">Button</button> -->
               <button class="btn btn-blue" type="submit">Update Email Template</button>    
               <!-- <button class="btn btn-blue-border">Button</button> -->
             </div>
            <?php echo $this->Form->end()?>
          </div>
         </div>
      </div>
     </div>
   </div>
   <style type="text/css">ul{list-style:square;}</style>
