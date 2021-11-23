<?php
use Cake\Utility\Security;
?>
<style>
.filter{
  width: 100%;
margin: 0px auto;
    margin-bottom: 0px;
text-align: center;
padding: 24px 0px;
border: 1px solid #ddd;
margin-bottom: 15px;
}
.tdfield{width: 250px;
text-align: center;
padding: 5px;}
.tdlabel{
width: 100px;
text-align: center;
padding: 5px;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Users Activity
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Users Activity</li>
                            </ol>
                        </div>

                        <div class="body">    
                                              
                          
                             <?php echo $this->Form->create('', array('id'=>'userActivity')); ?>
                              <table border="0"  align="center" width="20%">
                                 <tbody>
                                     <tr>
                                          
                                        <td style="padding:15px">                                          
                                            <select name="file_type" required="true" id="file_type" class="form-control">
                                               <option value="1" <?php echo $session->read('Searchfilter.file_type') == 1 ? "selected":''?>>Current day</option>
                                               <option value="2" <?php echo $session->read('Searchfilter.file_type') == 2 ?"selected":''?>>Last seven days</option>
                                               <option value="3" <?php echo $session->read('Searchfilter.file_type') == 3 ?"selected":''?>>Current month</option>
                                               <option value="4" <?php echo $session->read('Searchfilter.file_type') == 4 ?"selected":''?>>Last month</option>
                                               <option value="5" <?php echo $session->read('Searchfilter.file_type') == 5 ?"selected":''?>>Last three months</option>
                                            </select>                                          
                                        </td>
                                        <td><input type="submit" value="search" name="submit" class="form-control" style="background-color: #003394;color: white"></td>                                    
                                        
                                   </tr>                                   
                              </tbody>
                               </table>
                               <?php echo $this->Form->end()?>
                          <!--        <div class="table-responsive filter">
                              <table border="0" cellspacing="15" cellpadding="5" align="center">
                                 <tbody>
                                     <tr>
                                         <td class="tdlabel"><b>Start Date:</b></td>
                                         <td class="tdfield"><input name="min" id="min" type="text" class="form-control"></td>
                                     </tr>
                                     <tr>
                                         <td class="tdlabel"><b>End Date:</b></td>
                                         <td class="tdfield"><input name="max" id="max" type="text" class="form-control"></td>
                                     </tr>
                                 </tbody>
                               </table>
                            </div>  --> 
                            
                            
                            <div class="table-responsive">



                                <table id="example" class="table responsive table-bordered table-striped table-hover dataTable">

                                    <thead>
                                          <tr>
                                           <!-- <th scope="col"><input type="checkbox" id="checkAll" class="minimal"><label for="checkAll"></label></th> -->
                                           <th style="width: 200px;">Sr. No.</th>
                                           <th style="width: 200px;">First Name</th>
                                           <th style="width: 200px;">Last Name</th>
                                           <th style="width: 200px;">Username</th>
                                           <th style="width: 200px;">Time</th>
                                           <th style="width: 200px;">Action</th>
                                           <th>Ip</th>
                                           <th style="width: 200px;">Url</th>
                                           <th style="width: 200px;">Pdf</th>

                                         </tr>
                                    </thead>
                                     <tbody>

                                        <?php 
                                        if(isset($userActivityData) && !empty($userActivityData)){
                                        $i = 1;
                                        foreach ($userActivityData as $userActivity):
                                          if($userActivity->user_id == NULL)
                                          {
                                            continue;
                                          }
                                          ?>

                                        <tr>
                                        <td><?= $i ?></td>
                                        <td><?php
                                      if(!empty($userActivity['Users']['first_name']))
                                        echo h($this->CryptoSecurity->decrypt( base64_decode($userActivity['Users']['first_name']), SEC_KEY)); ?>
                                      </td>
                                        <td><?php
                                      if(!empty($userActivity['Users']['last_name']))
                                        echo h($this->CryptoSecurity->decrypt( base64_decode($userActivity['Users']['last_name']), SEC_KEY)); ?>

                                        </td>

                                        <td><?php
                                      if(!empty($userActivity['Users']['email']))
                                        echo h($this->CryptoSecurity->decrypt( base64_decode($userActivity['Users']['email']), SEC_KEY)); ?>

                                        </td>
                                        <?php $action = array('1' =>'Login','2' =>'Logout','3' =>'Unsuccessful logon attempts','4' =>'Generated pdf','5' =>'View screen');?>
                                        <td><?php echo  !empty($userActivity->timestamp)?date('Y/m/d',strtotime($userActivity->timestamp)):''; ?></td>
                                        <td><?php echo  !empty($action[$userActivity->action_performed])?$action[$userActivity->action_performed]:''; ?></td>
                                        <td><?php echo  !empty($userActivity->ip)?$userActivity->ip:''; ?></td>
                                        <td><?php echo  !empty($userActivity->url)?$userActivity->url:''; ?></td>
                                        <td><a href="<?php echo SITE_URL.'webroot/uploads/schedule_pdf/'.$userActivity->pdf?>" target="_blank"><?php echo  h($userActivity->pdf) ?></a></td>
                                     </tr>
                                     <?php  $i++; endforeach; ?>
                                   <?php } ?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>

    <script>
      //
      var endDatemin = '';
      var endDatemax = '';
      var statDatemin = '';
      var statDatemax = '';

    var filtertype = '<?php echo $session->check('Searchfilter.file_type')? $session->read('Searchfilter.file_type') :''  ?>';
    if(filtertype == 1)
    {
        endDatemin = 0;
        endDatemax = 0;  
        statDatemin = 0;      
        statDatemax = 0;
    }
    else if(filtertype == 2)  
    {
      endDatemin = 0;
      endDatemax = 0; 
      statDatemin = '-1w';      
      statDatemax = 0;
    }
    else if(filtertype == 3)  
    {
      var currentTime = new Date();
      endDatemin = 0;
      endDatemax = 0; 
      statDatemin = new Date(currentTime.getFullYear(),currentTime.getMonth(),1);   
      statDatemax = new Date(currentTime.getFullYear(),currentTime.getMonth() +1,0);
    }    
        
   $(document).ready(function(){
       // $.fn.dataTable.ext.search.push(
       // function (settings, data, dataIndex) {
       //     var min = $('#min').datepicker("getDate");
       //     var max = $('#max').datepicker("getDate");

       //     var startDate = new Date(data[4]);
       //     if (min == null && max == null) { return true; }
       //     if (min == null && startDate <= max) { return true;}
       //     if(max == null && startDate >= min) {return true;}
       //     if (startDate >= min && startDate <= max ) {  return true; }
       //     return false;
       // }
       // );

           // $("#min").datepicker({ minDate: statDatemin, maxDate: statDatemax, onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
           // $("#max").datepicker({ minDate: 0, maxDate: 0, onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
           var table = $('#example').DataTable();
              
                 
           // $('#min, #max').change(function () {
           //     table.draw();
           // });
       });  
    </script>
