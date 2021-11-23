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
                                Users Time Activity
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li class="active">Users time activity</li>
                            </ol>
                        </div>

                        <div class="body">
                          <div class="table-responsive filter">
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
                          </div>


                            <div class="table-responsive">



                                <table id="example" class="table responsive table-bordered table-striped table-hover dataTable">

                                    <thead>
                                          <tr>
                                           <!-- <th scope="col"><input type="checkbox" id="checkAll" class="minimal"><label for="checkAll"></label></th> -->
                                           <th style="width: 200px;">Sr. No.</th>
                                           <th style="width: 200px;">First Name</th>
                                           <th style="width: 200px;">Last Name</th>
                                           <th style="width: 200px;">Username</th>
                                           <th style="width: 200px;">Form</th>
                                           <th style="width: 200px;">Appointment Id</th>
                                           <th style="width: 200px;">Module Name</th>
                                           <th style="width: 200px;">Step</th>
                                           <th style="width: 200px;">Time</th>
                                           <th style="width: 200px;">Date</th>

                                         </tr>
                                    </thead>
                                     <tbody>

                                        <?php

                                        if(isset($userTimeData) && !empty($userTimeData)){
                                        $i = 1;

                                        foreach ($userTimeData as $userActivity):
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
                                        <td><?php echo  !empty($userActivity->form_type)?$userActivity->form_type:''; ?></td>
                                        <td><?php echo  !empty($userActivity->form_type)?$userActivity->appointment_id:''; ?></td>
                                        <td><?php echo  !empty($userActivity->step_id) ? $this->General->getModuleName($userActivity->step_id,$userActivity->tab_number):''; ?></td>
                                        <td><?php echo  !empty($userActivity->step_id) && !empty($userActivity->tab_number)? $this->General->getUserProgress($userActivity->step_id,$userActivity->tab_number):''; ?></td>
                                        <td><?php echo  !empty($userActivity->time)?$userActivity->time:''; ?></td>
                                        <td><?php echo  !empty($userActivity->created)?date('Y/m/d',strtotime($userActivity->created)):''; ?></td>

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
    $(document).ready(function(){
       $.fn.dataTable.ext.search.push(
       function (settings, data, dataIndex) {
           var min = $('#min').datepicker("getDate");
           var max = $('#max').datepicker("getDate");
           var startDate = new Date(data[9]);
           if (min == null && max == null) { return true; }
           if (min == null && startDate <= max) { return true;}
           if(max == null && startDate >= min) {return true;}
           if (startDate <= max && startDate >= min) { return true; }
           return false;
       }
       );

           $("#min").datepicker({  maxDate: 0,onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
           $("#max").datepicker({ maxDate: 0, onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
           var table = $('#example').DataTable();

           // Event listener to the two range filtering inputs to redraw on input
           $('#min, #max').change(function () {
               table.draw();
           });
       });
    </script>
