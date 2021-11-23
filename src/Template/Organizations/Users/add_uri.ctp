<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
         <?= $this->Flash->render() ?>
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Redirect Uri</h4>
          </div>
          <div class="card-body">
          <?php echo $this->Form->create($organizationData, array('id'=>'add_uri')); ?>           
             
               <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Allow redirect uri</label>
                                         <?php echo $this->Form->input("allow_redirect_uri" , array("type" => "text", "class" => "form-control",'title'=>'redirect uri','data-msg-required'=>'Redirect uri *','label' => false,'placeholder' =>'https://www.google.com;https://www.bing.com; ... '));?>
                                        
                                    </div>
              </div>                            
              <div class="btns">               
               <button class="btn btn-blue" type="submit">Update</button>                   
             </div>
            <?php echo $this->Form->end()?>
          </div>
         </div>
      </div>
     </div>
   </div>  