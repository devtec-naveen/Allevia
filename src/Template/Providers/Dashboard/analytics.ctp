<?php use Cake\Utility\Security; ?>
<style type="text/css">
   .new_appoint_checkbox_quest{
   display: -webkit-box;display: -ms-flexbox;display: flex;
   -webkit-box-orient: horizontal;-webkit-box-direction: normal;-ms-flex-flow: row wrap;flex-flow: row wrap;
   max-width: 100%;  
   }
   .custom-control-label { 
   padding-right: 12px;
   font-size: 16px;
   color: #404b60; }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="inner-wraper provider_dashboard">
<div class="row">
   <div class="col-md-12">
      <div class="msgsuccess alert alert-success" style="display: none;">
      </div>
      <div class="msgerror alert alert-danger" style="display: none;">
         <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h3>Error!</h3>
         <div class="error-body"></div>
      </div>
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-md-6 d-flex">
                  <h4 class="header-title mt-2 mr-3">Analytic Dashboard</h4>
               </div>
               <div class="col-md-6 d-flex">
                  <p class="mt-2 mr-3">
                  <h6 class="mt-2 mr-3">Start Date:</h6>
                  </p>
                  <input name="min" id="min" style="width:280px !important;height: 40px !important" type="text" class="form-control">                   
                  <p class="mt-2 mr-3">
                  <h6 class="mt-2 mr-3">End Date:</h6>
                  </p>
                  <input name="max" id="max" style="width:280px !important;height: 40px !important" type="text" class="form-control">
               </div>
            </div>
         </div>
         <div class="card-header">
            <div class="col-md-12">
               <div class="check_box_bg new_appoint_checkbox_quest">
                  <div class="custom-control custom-checkbox" >
                     <?php echo $this->Form->checkbox('firstname', ['id' => 'firstname', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "0",'checked']); ?>
                     <label for="firstname" class="custom-control-label">First Name </label>
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('lastname', ['id' => 'lastname', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "1",'checked']); ?>
                     <label for="lastname" class="custom-control-label">Last Name </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Dob', ['id' => 'Dob', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "2",'checked']); ?>
                     <label for="Dob" class="custom-control-label">Dob </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Gender', ['id' => 'Gender', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "3",'checked']); ?>
                     <label for="Gender" class="custom-control-label">Gender </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Age', ['id' => 'Age', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "4",'checked']); ?>
                     <label for="Age" class="custom-control-label">Age </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Email', ['id' => 'Email', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "5",'checked']); ?>
                     <label for="Email" class="custom-control-label">Email </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Phone', ['id' => 'Phone', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "6",'checked']); ?>
                     <label for="Phone" class="custom-control-label">Phone </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Uremia symptoms', ['id' => 'Uremia symptoms', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "7",'checked']); ?>
                     <label for="Uremia symptoms" class="custom-control-label">Uremia symptoms </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Volume overload', ['id' => 'Volume overload', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "8",'checked']); ?>
                     <label for="Volume overload" class="custom-control-label">Volume overload </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Absolute Indication', ['id' => 'Absolute Indication', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "9",'checked']); ?>
                     <label for="Absolute Indication" class="custom-control-label">Absolute Indication </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Uremic pericarditis', ['id' => 'Uremic pericarditis', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "10",'checked']); ?>
                     <label for="Uremic pericarditis" class="custom-control-label">Uremic pericarditis </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Uremic neuropathy', ['id' => 'Uremic neuropathy', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "11",'checked']); ?>
                     <label for="Uremic neuropathy" class="custom-control-label">Uremic neuropathy </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Uremic platlet dysfunction', ['id' => 'Uremic platlet dysfunction', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "12",'checked']); ?>
                     <label for="Uremic platlet dysfunction" class="custom-control-label">Uremic platlet dysfunction </label> 
                  </div>
                  <div class="custom-control custom-checkbox flex">                     
                     <?php echo $this->Form->checkbox('Date', ['id' => 'Date', 'class' => 'custom-control-input check_had_shot toggle-vis','hiddenField' => false, "data-column" => "13",'checked']); ?>
                     <label for="Date" class="custom-control-label">Date </label> 
                  </div>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="table-box mt-4">
               <table id="example" class="table table-striped table-hover" class="display" style="width:100%">
                  <thead>
                     <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Uremia symptoms</th>
                        <th>Volume overload</th>
                        <th>Absolute Indication</th>
                        <th>Uremic pericarditis</th>
                        <th>Uremic neuropathy</th>
                        <th>Uremic platlet dysfunction</th>
                        <th>Date</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($schedule_data as $key => $value){ 
                        $gender = array(0 => 'Female',1=>'Male', 2=>'Other' );
                        $bday = !empty($value['dob'])?new DateTime($this->CryptoSecurity->decrypt(base64_decode($value['dob']),SEC_KEY)):new DateTime('11.4.1987'); // Your date of birth
                         $today = new Datetime(date('m.d.y'));
                         $diff = $today->diff($bday);
                        ?>                    
                     <tr>
                        <td><?= !empty($value['first_name']) ? $this->CryptoSecurity->decrypt(base64_decode($value['first_name']),SEC_KEY) : "" ?></td>
                        <td><?= !empty($value['last_name']) ? $this->CryptoSecurity->decrypt(base64_decode($value['last_name']),SEC_KEY) : "" ?></td>
                        <td><?= !empty($value['dob']) ? $this->CryptoSecurity->decrypt(base64_decode($value['dob']),SEC_KEY) : "" ?></td>
                        <td><?= !empty($value['Users']['gender']) ? $gender[Security::decrypt(base64_decode($value['Users']['gender']),SEC_KEY)] : "" ?></td>
                        <td><?php echo $diff->y ?></td>
                        <td><?= !empty($value['email']) ? $this->CryptoSecurity->decrypt(base64_decode($value['email']),SEC_KEY) : "" ?></td>
                        <td><?= !empty($value['phone']) ? $this->CryptoSecurity->decrypt(base64_decode($value['phone']),SEC_KEY) : "" ?></td>
                        <td><?php echo $value['uremiaSymtoms']?></td>
                        <td><?php echo $value['volumeoverload']?></td>
                        <td><?php echo $value['absoluteIndication']?></td>
                        <td><?php echo $value['uremicpericarditis']?></td>
                        <td><?php echo $value['uremicneuropathy']?></td>
                        <td><?php echo $value['uremicPlatlet']?></td>
                        <td><?php echo date('Y/m/d',strtotime($value['chief_compliant_userdetail']['modified']))?></td>
                     </tr>
                     <?php }?>                    
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   $(document).ready(function(){
      $.fn.dataTable.ext.search.push(
      function (settings, data, dataIndex) {
          var min = $('#min').datepicker("getDate");           
          var max = $('#max').datepicker("getDate");
          var startDate = new Date(data[13]);
          if (min == null && max == null) { return true; }
          if (min == null && startDate <= max) { return true;}
          if(max == null && startDate >= min) {return true;}
          if (startDate <= max && startDate >= min) { return true; }
          return false;
      }
      );
          $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
          $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
           var table = $('#example').DataTable(); 
           $('input.toggle-vis').on( 'click', function (e) {
               //e.preventDefault();
        
               // Get the column API object
               var column = table.column( $(this).attr('data-column') );
        
               // Toggle the visibility
               column.visible( ! column.visible() );
           } );         
         
      });
</script>

