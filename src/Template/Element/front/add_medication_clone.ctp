<div class="row clone_purpose_medication_field_display_none">
   <div class="col-md-4">
      <div class="form-group form_fild_row">
         <div class="custom-drop">
            <input type="text" class="form-control med_suggestion" name="medication_name_name[]" placeholder="Enter Medication"/>
            <ul class="med_suggestion_listul custom-drop-li">
            </ul>
         </div>
      </div>
   </div>
   <div class="col-md-2">
      <div class="form-group form_fild_row">
         <input name="medication_dose[]" type="text" class="form-control ignore_fld" placeholder="Dose"/>
      </div>
   </div>
   <div class="col-md-2">
      <div class="form-group form_fild_row">
         <!-- <input type="text" name="medication_how_often[]" class="form-control" placeholder="How often?"/>  -->
         <select class="form-control" name="medication_how_often[]">
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
            <input type="text" name="medication_how_taken[]" class="form-control how_taken_suggestion" placeholder="How is it taken?"/>
            <ul class="how_taken_suggestion_listul custom-drop-li">
            </ul>
         </div>
      </div>
   </div>
   <div class="col-md-1">
      <div class="row">
         <div class=" currentmedicationfldtimes">
            <div class="crose_year">
               <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
            </div>
         </div>
      </div>
   </div>
</div>
