<div class="inner-wraper">
     <div class="row">     
      <div class="col-md-12">
        <?= $this->Flash->render() ?>
        <div class="card">
          <div class="card-header d-flex">
            <h4 class="header-title mt-2 mr-5">Note Formatting</h4>
          </div>
          <div class="card-body">
           <?php echo $this->Form->Create(null, array('id'=>'add_organizations')); ?>         
             
               <div class="form-group">
                              <div>
                                <input type="radio" name="note_formating" value="abbr" id="column1" <?php echo $user_data->note_formating == 'abbr' ? "checked" : ""; ?>>                                
                                <label for="column1" class="form-label">
                                  <span><strong>Default Formatting:</strong> (MEDS | PSH | PMH | FH | SH | ALL | IMM | GEN | GI | GU | CV | NEURO | MSK | RESP | HEME | ENDO | PSYCH | SKIN | THROAT)</span>
                                </label>    
                              </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <input type="radio" name="note_formating" value="full" id="column2" <?php echo $user_data->note_formating == 'full' ? "checked" : ""; ?>>                                
                      <label for="column2" class="form-label">
                        <span><strong>iPatientCare Formatting:</strong> (Current Medications | Past Surgical Hx | Past Medical Hx | Family Hx | Social Hx | Allergies | Immunization Hx | Constitutional Symptoms | Gastrointestinal | Genitourinary | Cardiovascular | Neurological | Musculoskeletal | Respiratory | Hematologic | Endocrine | Psychiatric | Integumentary | THROAT)</span>
                      </label>    
                    </div>
                  </div> 

              <div class="btns">               
               <button class="btn btn-blue" type="submit">Update </button>                   
             </div>
            <?php echo $this->Form->end()?>
          </div>
         </div>
      </div>
     </div>
</div>  