<div class="inner-wraper">
 <div class="row">
  <div class="col-md-12">
    <?= $this->Flash->render() ?>
    <div class="card">
      <div class="card-header d-flex">
        <h4 class="header-title mt-2 mr-5">Input Schedule Settings</h4>
      </div>
      <div class="card-body">

        <ul>
          <li>
           The number in the fields represents the column of the field in the uploaded file.
         </li>
          <li>
           Put -1 for Starting Row Number of Patient Data (inclusive) if it is start of the file.
         </li>

         <li>
          Put -1 for Ending Row Number of Patient Data (inclusive) if it is till the end of the file.
        </li>

        <li>
          Put -1 for fields which are not present in the imported file. All other field numbers must be unique.
        </li>
        <!-- <li>
          Other Fields first name, last name, email, doctor name, mrn, dob values must be unique.
        </li> -->

        <li class="readcsv">
           CSV Read By EHR Method and Reading Column Index fields are used only for CSV file.
        </li>


        <li class="readingcol">
          Reading column index by default value is 4.
        </li>


        <li class="iPatientcare">
          When Read csv as iPatientCare doctor name found in column number 9 by default.
        </li>

        <li class="iPatientcare">
          When Read csv as iPatientCare appointment time found in column number 5 by default.
        </li>
        <li class="iPatientcare">
          When Read csv as iPatientCare appointment reason found in column number 11 by default.
        </li>

        <hr>
      </ul>

      <?php echo $this->Form->create($fields, array('id'=>'edit_profile','type' => 'file')); ?>
      <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getParam('_csrfToken'); ?>">


      <div class="form-group form-float">
        <label class="form-label">File Type:</label>
        <div class="form-line">
          <select name="file_type" class = "form-control" required="true" id="file_type">

            <option value="csv" <?php echo $file_type == 'csv' ? 'selected':""; ?> >CSV</option>
            <option value="excel" <?php echo $file_type == 'excel' ? 'selected':""; ?> >Excel</option>

          </select>
        </div>
      </div>


      <div class="form-group form-float read_by">
        <label class="form-label">CSV Read By EHR Method:</label>
        <div class="form-line">
          <select name="read_by" class = "form-control" required="true" id="excel_read_by">
            <option value="">Select EHR Method</option>
            <option value="2" <?php echo $read_by == 2 ? 'selected':""; ?>>Default</option>
            <option value="1" <?php echo $read_by == 1 ? 'selected':""; ?>>iPatientCare</option>
          </select>
        </div>
      </div>



      <?php if(!empty($fields) && count($fields) > 0){ ?>

       <?php foreach($fields as $field){ ?>
        <div class="form-group form-float <?php echo $field['field_name']; ?>">
          <label class="form-label"><?php echo $field['title']; ?></label>
          <div class="form-line">
           <?php echo $this->Form->input($field['field_name'] , array("type" => "number", "class" => "form-control",'title'=>$field['title'],'data-msg-required'=>'Enter '.$field['title'].' *','label' => false,'required' => $field['field_name'] == 'single_column_index' ? false : true,'value' => $field['field_index']));?>

         </div>
       </div>
     <?php } ?>
   <?php } ?>

   <div class="btns">
     <button class="btn btn-blue" type="submit">Update</button>
   </div>

   <?php echo $this->Form->end()?>
 </div>
</div>
</div>
</div>
</div>
<style type="text/css">ul{list-style:square;}</style>


<script type="text/javascript">

  $(document).ready(function(){
    var read_by = <?php echo $read_by ?>;
    if(read_by == 1){

      $(".readcsv").show();
      $(".iPatientcare").show();
      $(".readingcol").show();
      $('#edit_profile .single_column_index').css('display','block');
      $('#edit_profile .appointment_reason').show();
      $('#edit_profile .first_name').hide();
      $('#edit_profile .last_name').hide();
      $('#edit_profile .email').hide();
      $('#edit_profile .mrn').hide();
      $('#edit_profile .phone').hide();
      $('#edit_profile .dob').hide();
      $('#edit_profile .gender').hide();


    }else{

      $(".readcsv").show();
      $(".iPatientcare").hide();
      $(".readingcol").hide();
      $('#edit_profile .single_column_index').css('display','none');
      $('#edit_profile .appointment_reason').hide();
      $('#edit_profile .first_name').show();
      $('#edit_profile .last_name').show();
      $('#edit_profile .email').show();
      $('#edit_profile .mrn').show();
      $('#edit_profile .phone').show();
      $('#edit_profile .dob').show();
      $('#edit_profile .gender').show();

    }

  });
  $(document).on('change','#excel_read_by',function(){

    var read_by = $(this).val();
    $(".readcsv").show();

    if(read_by == 1){
      $(".iPatientcare").show();
      $(".readingcol").show();

      $('#edit_profile .single_column_index').css('display','block');
      $('#edit_profile .appointment_reason').show();
      $('#edit_profile .first_name').hide();
      $('#edit_profile .last_name').hide();
      $('#edit_profile .email').hide();
      $('#edit_profile .mrn').hide();
      $('#edit_profile .phone').hide();
      $('#edit_profile .dob').hide();    
      $('#edit_profile .gender').hide();  

    }else{
      $(".iPatientcare").hide();
      $(".readingcol").hide();
      $('#edit_profile .single_column_index').css('display','none');
      $('#edit_profile .appointment_reason').hide();
      $('#edit_profile .first_name').show();
      $('#edit_profile .last_name').show();
      $('#edit_profile .email').show();
      $('#edit_profile .mrn').show();
      $('#edit_profile .phone').show();
      $('#edit_profile .dob').show();
      $('#edit_profile .gender').show();
    }
  });

  $(document).on('change','#file_type',function(){

    var file_type = $(this).val();
    if(file_type == 'excel'){

      $(".readcsv").hide();
      $(".readingcol").hide();
      $(".iPatientcare").hide();

      $('#edit_profile .read_by').hide();
      $('#edit_profile .single_column_index').hide();
      $('#edit_profile .appointment_reason').hide();
      $('#edit_profile .first_name').show();
      $('#edit_profile .last_name').show();
      $('#edit_profile .email').show();
      $('#edit_profile .mrn').show();
      $('#edit_profile .phone').show();
      $('#edit_profile .dob').show();
    }
    else{
      $(".readcsv").show();

      var read_by = $('#excel_read_by').val();
      if(read_by == 1){

        $(".readingcol").show();
        $(".iPatientcare").show();
        $('#edit_profile .read_by').show();
        $('#edit_profile .single_column_index').show();
        $('#edit_profile .appointment_reason').show();
        $('#edit_profile .first_name').hide();
        $('#edit_profile .last_name').hide();
        $('#edit_profile .email').hide();
        $('#edit_profile .mrn').hide();
        $('#edit_profile .phone').hide();
        $('#edit_profile .dob').hide();
        
      }
      else{

        $('#edit_profile .read_by').show();
        $('#edit_profile .first_name').show();
        $('#edit_profile .last_name').show();
        $('#edit_profile .email').show();
        $('#edit_profile .mrn').show();
        $('#edit_profile .phone').show();
        $('#edit_profile .dob').show();
        $('#edit_profile .single_column_index').hide();
        $('#edit_profile .appointment_reason').hide();
        $(".readingcol").hide();
        $(".iPatientcare").hide();

      }
    }
  });

  $(document).ready(function(){

    var file_type = $('#file_type').val();
    if(file_type == 'excel'){
        $(".readcsv").hide();
        $(".readingcol").hide();
        $(".iPatientcare").hide();

      $('#edit_profile .read_by').hide();
      $('#edit_profile .single_column_index').hide();
      $('#edit_profile .appointment_reason').hide();
      $('#edit_profile .first_name').show();
      $('#edit_profile .last_name').show();
      $('#edit_profile .email').show();
      $('#edit_profile .doctor_name').show();
      $('#edit_profile .mrn').show();
      $('#edit_profile .phone').show();
      $('#edit_profile .dob').show();
    }
    else{
      $(".readcsv").show();
      var read_by = $('#excel_read_by').val();

      if(read_by == 1){

        $(".readingcol").show();
        $(".iPatientcare").show();
        $('#edit_profile .read_by').show();
        $('#edit_profile .single_column_index').show();
        $('#edit_profile .appointment_reason').show();
        $('#edit_profile .doctor_name').show();

        $('#edit_profile .first_name').hide();
        $('#edit_profile .last_name').hide();
        $('#edit_profile .email').hide();
        $('#edit_profile .mrn').hide();
        $('#edit_profile .phone').hide();
        $('#edit_profile .dob').hide();
      }
      else{

        $(".readingcol").hide();
        $(".iPatientcare").hide();
        $('#edit_profile .read_by').show();
        $('#edit_profile .first_name').show();
        $('#edit_profile .last_name').show();
        $('#edit_profile .email').show();
        $('#edit_profile .doctor_name').show();
        $('#edit_profile .mrn').show();
        $('#edit_profile .phone').show();
        $('#edit_profile .dob').show();
        $('#edit_profile .single_column_index').hide();
        $('#edit_profile .appointment_reason').hide();
        

      }
    }
  });
</script>
