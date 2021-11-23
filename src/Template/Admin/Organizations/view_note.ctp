<section class="content">
        <div class="container-fluid">
      <?php 
        use Cake\Utility\Security;
        ?>
                 <!-- Basic Examples -->
                
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    	<?php //echo $this->Flash->render(); ?>
                        <div class="header">
                            <h2>
                                Send Note
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'organizations/providers/' ?>">Providers</a></li>
                                <li class="active">Setting</li>
                            </ol>

                        </div>

                        <div class="body">
                                 <?php echo $this->Form->create($user, array('id'=>'edit_provider')); ?>

                             <!--   <div class="form-group form-float">
                                    <label class="form-label">Time Interval</label>
                                    <div class="form-line">
                                     <?php $all_time_interval = array(1 =>"Immediate",5=>"5",10=>"10",15=>"15",20 => "20", 25=>"25");?>
                                     <?php echo $this->Form->Input("time_interval",array("empty"=>"Select Time Interval",'label' => false, "class" => "form-control","type"=>"select","options" => $all_time_interval,'data-msg-required'=>'Select Time Interval ',"required"=>true,'value' => !empty($user->time_interval) ? Security::decrypt(base64_decode($user->time_interval),SEC_KEY): ""));?>                                  
                                  </div>
                                </div> -->
                                <div class="form-group form-float">
                                    <label class="form-label">Sending Method</label>
                                    <div class="form-line">
                                     <?php $sending_method = array(1 =>"SFTP",2=>"POST");?>
                                     <?php echo $this->Form->Input("sending_method",array("empty"=>"Select Sending Method",'label' => false, "class" => "form-control","type"=>"select","options" => $sending_method ,'data-msg-required'=>'Select Sending Method',"required"=>true,'value' => !empty($user->sending_method) ? Security::decrypt(base64_decode($user->sending_method),SEC_KEY): ""));?>                                 
                                  </div>
                                </div>


                                <div class="form-group form-float">
                                    <label class="form-label">Note format</label>
                                    <div class="form-line">
                                     <?php $note_format = array(1 =>"readable",2=>"FHIR");?>
                                     <?php echo $this->Form->Input("note_format",array('label' => false, "class" => "form-control","type"=>"select","options" => $note_format ,'value' => !empty($user->note_format) ? Security::decrypt(base64_decode($user->note_format),SEC_KEY): ""));?>
                                  </div>
                                </div>

                                <div class="form-group form-float" id="postoption" style="display: none;">
                                    <label class="form-label">Post option</label>
                                    <div class="form-line">
                                     <?php $post_option = array(1 =>"Plain",2=>"x-api-key");?>
                                     <?php echo $this->Form->Input("post_option",array("empty"=>"Select Post Option",'label' => false, "class" => "form-control","type"=>"select","options" => $post_option ,'data-msg-required'=>'Select Post Option',"required"=>true,'value' => !empty($user->post_option) ? Security::decrypt(base64_decode($user->post_option),SEC_KEY): ""));?>
                                  </div>
                                </div>

                                <div class="form-group form-float" id="username" style="display: none;">
                                    <label class="form-label">Username</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("sftp_username" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter username*','label' => false, 'title'=>'Enter End Point', "required" => true,'value' => !empty($user->sftp_username) ? Security::decrypt(base64_decode($user->sftp_username),SEC_KEY): ""));?>
                                 
                                    </div>
                                </div> 

                                <div class="form-group form-float" id="password" style="display: none;">
                                    <label class="form-label">Password</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("sftp_password" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter password*','label' => false, 'title'=>'Enter End Point','value' => !empty($user->sftp_password) ?Security::decrypt(base64_decode($user->sftp_password),SEC_KEY): ""));?>                                 
                                    </div>
                                </div>

                                <div class="form-group form-float" id="port_number" style="display: none;">
                                    <label class="form-label">Port</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("port" , array("type" => "number","class" => "form-control",'data-msg-required'=>'Enter port*','label' => false, 'title'=>'Enter port','value' => !empty($user->port) ? Security::decrypt(base64_decode($user->port),SEC_KEY): ""));?>                                 
                                    </div>
                                </div>

                                <div class="form-group form-float" id="api_key" style="display: none;">
                                    <label class="form-label">Api key</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("api_key" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter api key*','label' => false, 'title'=>'Enter End Point','value' => !empty($user->api_key) ? Security::decrypt(base64_decode($user->api_key),SEC_KEY): ""));?>
                                    </div>
                                </div>

                                <div class="form-group form-float" id="clinic_box">
                                    <label class="form-label">Endpoint</label>
                                    <div class="form-line">
                                     <?php echo $this->Form->input("end_point" , array("type" => "text","class" => "form-control",'data-msg-required'=>'Enter End Point*','label' => false, 'title'=>'Enter End Point',"required"=>true,'value' => !empty($user->end_point) ? Security::decrypt(base64_decode($user->end_point),SEC_KEY): ""));?>                                 
                                    </div>
                                  </div>                         
                                        
                                  <div class="form-line">
                                      <?php echo $this->Form->checkbox('is_allow_note', ['hiddenField' => false,'id' =>'is_allow_analytics',!empty($user->is_allow_note) && $user->is_allow_note == 1 ? 'checked' : '','value' =>1]); ?>
                                        <label for="is_allow_analytics" class="form-label"><b>Activate</b></label>
                                  </div>           
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect"> Save</button>
                               
                                
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

           var method = '<?php echo !empty($user->sending_method) ? Security::decrypt(base64_decode($user->sending_method),SEC_KEY): ""; ?>';
           if(method == 1)
            {
                $("#username").show();
                $("#password").show();
                $("#port_number").show();
                $("#api_key").hide();
                $("#postoption").hide();

                $("#sftp-username").prop('required',true);
                $("#sftp-password").prop('required',true);
                $("#port").prop('required',true);
                $("#api-key").prop('required',false);
                $("#post-option").prop('required',false);
            }  
            else if(method == 2 )
            {
              $("#api_key").show();
              $("#username").hide();
              $("#password").hide();
              $("#port_number").hide();
              $("#postoption").show();

              $("#sftp-username").prop('required',false);
              $("#sftp-password").prop('required',false);
              $("#port").prop('required',false);
              $("#api-key").prop('required',true);
              $("#post-option").prop('required',true);
            }  


            var post_option = '<?php echo !empty($user->post_option) ? Security::decrypt(base64_decode($user->post_option),SEC_KEY): ""; ?>';

            if(post_option == 1)
            {
                $("#api_key").hide();
                $("#api-key").prop('required',false);
            }
            else if(post_option == 2)
            {
                $("#api_key").show();
                $("#api-key").prop('required',true);
            }
      })



      $("#sending-method").on('change',function(){

          var method =  $(this).val();
          if(method == 1)
          {
              $("#username").show();
              $("#password").show();
              $("#port_number").show();
              $("#api_key").hide();
              $("#postoption").hide();

              $("#sftp-username").prop('required',true);
              $("#sftp-password").prop('required',true);
              $("#port").prop('required',true);
              $("#api-key").prop('required',false);
              $("#post-option").prop('required',false);

          }  
          else if(method == 2 )
          {
          //  $("#api_key").show();
            $("#username").hide();
            $("#password").hide();
            $("#port_number").hide();
            $("#postoption").show();

            $("#sftp-username").prop('required',false);
            $("#sftp-password").prop('required',false);
            $("#port").prop('required',false);
            $("#post-option").prop('required',true);
            //$("#api-key").prop('required',true);
          }  
      })



      $("#post-option").on('change', function(){

        var option = $(this).val();
        if(option == 2)
        {
            $("#api_key").show();
            $("#api-key").prop('required',true);
        }
        else if(option == 1)
        {
            $("#api_key").hide();
            $("#api-key").prop('required',false);
        } 
      })





    </script>

