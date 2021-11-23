<div class="row clone_purpose_medication_refill_medication_field_display_none">
      <div class="col-md-4">
     <div class="form-group form_fild_row"> 
      
<div class="custom-drop">
      <input type="text"    class="form-control  med_suggestion <?= !empty($cmd_old) ? 'ignore_fld' : '' ?>" name="medication_name_name[]" placeholder="Enter Medication"/> 
         <ul class="med_suggestion_listul custom-drop-li">
         </ul> 

      </div>

       </div>
    </div>


      <div class="col-md-2">
         <div class="form-group form_fild_row"> 
          <input name="medication_dose[]" type="text" class="ignore_fld form-control" placeholder="Dose"/> 
         </div>
        </div>
        
        <div class="col-md-2">
         <div class="form-group form_fild_row"> 
          <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->

        <select class="form-control  <?= !empty($cmd_old) ? 'ignore_fld' : '' ?>" name="medication_how_often[]"  required="true">
          <option value="">how often?</option>
        <?php   
            foreach ($length_arr as $key => $value) {
              

          echo "<option value=".$key.">".$value."</option>"; 

            }
          ?>
          </select>

         </div>
        </div>
          <div class="col-md-3">
         <div class="form-group form_fild_row"> 
         
<div class="custom-drop">

<input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion  <?= !empty($cmd_old) ? 'ignore_fld' : '' ?>" placeholder="How is it taken?"/> 
         <ul class="how_taken_suggestion_listul custom-drop-li">
         </ul> 

      </div>      

         </div>
        </div>

    
    <div class="col-md-1">
       <div class="row"> 

      <div class="currentmedicationfldtimes_med_refill">
       <div class="crose_year">
        <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
       </div>
      </div>
     </div>
    </div>
     </div>