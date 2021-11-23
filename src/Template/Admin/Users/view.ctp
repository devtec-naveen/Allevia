<?php 
use Cake\Utility\Security;
?>
<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View User
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'users/index'  ?>">Users</a></li>
                                <li class="active">View User</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped results">
                              <tbody>
                                  <?php //pr($login_user);die; ?>
                                    <tr>
                                      <td><strong>First Name</strong> </td>
                                      <td><?php echo  h($login_user->first_name); ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Last Name</strong> </td>
                                      <td><?php echo   h($login_user->last_name);  ?></td>
                                    </tr>
                                                                      
                                    <tr>
                                      <td><strong>Eamil Id</strong> </td>
                                      <td><?php echo   $login_user->email;  ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Status</strong> </td>
                                      <td><?php echo $login_user->status == 1 ? 'Active' : 'Inactive' ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Phone No.</strong> </td>
                                      <td><?php  echo   $login_user->phone;  ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Created at</strong> </td>
                                      <td><?php echo isset($login_user->created) ? h($login_user->created->i18nFormat('MM/dd/yyyy')) : '--';  ?></td>
                                    </tr>                                    
                                    <tr>
                                      <td><strong>D.O.B.</strong> </td>
                                      <td><?php  echo isset($login_user->dob) ? h(date('m-d-Y',strtotime($login_user->dob))) : '--';   ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Gender</strong> </td>
                                      <td><?php  echo   $login_user->gender == 1 ? 'Male' : 'Female';   ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Occupation</strong> </td>
                                      <td><?php  echo !empty($login_user->occupation) ?  h($login_user->occupation) : '--';   ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Marital Status</strong> </td>
                                      <td><?php

                                      $mar_s = array(0 => 'Unmarried', 1 => 'Married', 2 => 'Divorced');
                                       echo  isset($mar_s[$login_user->marital_status]) ?  $mar_s[$login_user->marital_status] : '--' ;  ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Sexual Orientation</strong> </td>
                                      <td><?php

                                      $s_ori = array(0 => 'Heterosexual', 1 => 'Homosexual', 2 => 'Bisexual', 9 => 'Prefer not to say');
                                       echo  isset($s_ori[$login_user->sexual_orientation]) ? $s_ori[$login_user->sexual_orientation] : '--' ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Ethnicity</strong> </td>
                                      <td><?php
                                      $ethini = array(0 => 'Asian', 1 => 'Caucasian', 2 => 'Hispanic', 3 => 'Pacific', 4 => 'Native American', 5 => 'African American', 9 => 'Prefer not to say');
                                      echo isset($ethini[$login_user->ethinicity]) ? $ethini[$login_user->ethinicity] : '--' ; 
                                        ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Height</strong> </td>
                                      <td><?php  echo  !empty($login_user->height) ? h($login_user->height) : '--';   ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Weight</strong> </td>
                                      <td><?php  echo  !empty($login_user->weight) ? h($login_user->weight) : '--';   ?></td>
                                    </tr>

                                    <tr>
                                      <td><strong>Social History</strong> </td>
                                      <td><?php 
  echo  '<strong>Currently Smoking (packs per week) : </strong>'.($login_user->current_smoke_pack == 'morethan10' ? 'More than 10' : (!empty($login_user->current_smoke_pack) ? h($login_user->current_smoke_pack) : '--') ).'<br>';
  echo  '<strong>Currently Smoking (No. of years) : </strong>'.(!empty($login_user->current_smoke_year) ? h($login_user->current_smoke_year) : '--').'<br>';
  echo  '<strong>Past Smoking (packs per week) : </strong>'.($login_user->past_smoke_pack == 'morethan10' ? 'More than 10' :  (!empty($login_user->past_smoke_pack) ? h($login_user->past_smoke_pack) : '--')).'<br>';
  echo  '<strong>Past Smoking (No. of years) : </strong>'.(!empty($login_user->past_smoke_year) ? h($login_user->past_smoke_year) : '--').'<br>';
  echo  '<strong>Currently Drinking (packs per week) : </strong>'.($login_user->current_drink_pack == 'morethan10' ? 'More than 14' : (!empty($login_user->current_drink_pack) ? h($login_user->current_drink_pack) : '--')).'<br>';
  echo  '<strong>Currently Drinking (No. of years) : </strong>'.(!empty($login_user->current_drink_year) ? h($login_user->current_drink_year) : '--').'<br>';
  echo  '<strong>Past Drinking (packs per week) : </strong>'.($login_user->past_drink_pack == 'morethan10' ? 'More than 14' : (!empty($login_user->past_drink_pack) ? h($login_user->past_drink_pack) : '--')).'<br>';
  echo  '<strong>Past Drinking (No. of years) : </strong>'.(!empty($login_user->past_drink_year) ? h($login_user->past_drink_year) : '--').'<br>';
  echo '<hr>' ; 
  echo  '<strong>Other Drug History</strong> :- ' ; 
  $other_drug_history = $login_user->other_drug_history ; 
  if(!empty($other_drug_history)){
    echo '<br />' ; 
    // $other_drug_history = unserialize($other_drug_history) ; 
    $other_drug_history = unserialize(Security::decrypt(base64_decode($other_drug_history), SEC_KEY)) ; 
    
    foreach ($other_drug_history as $key => $value) {
      echo '<strong>Drug Name : </strong>'.h($value['name']).'<br>' ; 
      // echo '<strong>Quantity : </strong>'.($value['quantity'] == 'morethan10' ? 'More than 10' : h($value['quantity'] )).'<br>' ; 
      echo '<strong>No. of years : </strong>'.h($value['year']).'<br>' ; 
     
    }

  } else {
    echo '--' ; 
  }
 echo '<hr>' ; 
  echo  '<strong>Other Drug History (Past)</strong> :- ' ; 
  $other_drug_history = $login_user->other_drug_history_past ; 
  if(!empty($other_drug_history)){
    echo '<br />' ; 
    // $other_drug_history = unserialize($other_drug_history) ; 
    $other_drug_history = unserialize(Security::decrypt(base64_decode($other_drug_history), SEC_KEY)) ; 

    
    foreach ($other_drug_history as $key => $value) {
      echo '<strong>Drug Name : </strong>'.h($value['name']).'<br>' ; 
      // echo '<strong>Quantity : </strong>'.($value['quantity'] == 'morethan10' ? 'More than 10' : h($value['quantity'] )).'<br>' ; 
      echo '<strong>No. of years : </strong>'.h($value['year']).'<br>' ; 
      // echo '<hr>' ; 
    }

  } else {
    echo '--' ; 
  }



                                         ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Medical History</strong> </td>
                                      <td><?php 
                                      if(!empty($login_user->medical_history)){
// $medical_history = unserialize(base64_decode($login_user->medical_history));
$medical_history = unserialize((Security::decrypt(base64_decode($login_user->medical_history), SEC_KEY)));


  foreach ($medical_history as $key => $value) {
         echo '<strong>Disease Name : </strong>'.h($value['name']).'<br>' ; 
      echo '<strong>Year :</strong> '.h($value['year']).'<br>' ; 
      echo '<hr>' ; 
  }

                                      } else{
                                        echo '--' ; 
                                      } 
                                        ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Surgical History</strong> </td>
                                      <td><?php  
                                      if(!empty($login_user->surgical_history)){
// $surgical_history = unserialize(base64_decode($login_user->surgical_history));
$surgical_history = unserialize(( Security::decrypt(base64_decode($login_user->surgical_history), SEC_KEY) )); 

                                     

  foreach ($surgical_history as $key => $value) {
         echo '<strong>Surgery Name :</strong> '.h($value['name']).'<br>' ; 
      echo '<strong>Year :</strong> '.h($value['year']).'<br>' ; 
      echo '<hr>' ; 
  }

                                      }  else{
                                        echo '--' ; 
                                      } 
                                        ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Allergy History</strong> </td>
                                      <td><?php   
                                      if(!empty($login_user->allergy_history)){
// $allergy_history = unserialize(base64_decode($login_user->allergy_history));
$allergy_history = unserialize((Security::decrypt(base64_decode($login_user->allergy_history), SEC_KEY) ));  
                                     

  foreach ($allergy_history as $key => $value) {
         echo '<strong>Name : </strong>'.h($value['name']).'<br>' ; 
      echo '<strong>Reaction :</strong> '.h($value['reaction']).'<br>' ; 
      echo '<hr>' ; 
  }

                                      } else{
                                        echo '--' ; 
                                      } 

                                       ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Shots History</strong> </td>
                                      <td><?php  
                                     if(!empty($login_user->shots_history)){
// $shots_history = unserialize(base64_decode($login_user->shots_history));
$shots_history = unserialize((Security::decrypt(base64_decode($login_user->shots_history), SEC_KEY)));                                      



  foreach ($shots_history as $key => $value) {
         echo '<strong>Name : </strong>'.$common_medical_cond[$key].'<br>' ; 
      echo '<strong>Year : </strong>'.$value.'<br>' ; 
      echo '<hr>' ; 
  }

                                      } else{
                                        echo '--' ; 
                                      } 


                                        ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Family History</strong> </td>
                                      <td><?php  
                                     if(!empty($login_user->family_history)){
// $family_history = unserialize(base64_decode($login_user->family_history));
$family_history = unserialize((Security::decrypt(base64_decode($login_user->family_history), SEC_KEY) ));
                                     
 $family_relation = [1=>'Father', 2=>'Mother', 3=>'Paternal Grandmother', 4=>'Paternal Grandfather', 5=>'Maternal Grandmother', 6=>'Maternal Grandfather', 7=>'Brother', 8=>'Sister', 9=>'Son', 10=>'Daughter']; 
  foreach ($family_history as $key => $value) {
         echo '<strong>Family Member :  </strong>'.h($family_relation[$value['name']]).'<br>' ; 
      echo '<strong>Previously Diagnosed Condition :  </strong>'.h($value['disease']).'<br>' ; 
      echo '<strong>Alive Status :  </strong>'.($value['alive_status'] == 1 ? "Alive" : "Deseased").'<br>' ; 

      if($value['alive_status'] == 0 ){
          echo '<strong>Age (of death) :  </strong>'.($value['decease_year'] == 999 ? 'Childhood' : ( $value['decease_year'] == 911 ? 'Don\'t know' :  h($value['decease_year'] ))).'<br>' ; 
          echo '<strong>Cause of death :  </strong>'.h($value['cause_of_death']).'<br>' ; 
      }
echo '<hr>' ; 

  }

                                      } else{
                                        echo '--' ; 
                                      } 




                                        ?></td>
                                    </tr>
<tr><td align="center" colspan="2"><strong>Woman Specific Details</strong></td></tr>

                <?php 
                    if($login_user['gender'] == 0 && !empty($women_field)){
                ?>
                <tr>
                  <td><strong>Is allergic to latex? </strong> </td>
                  <td><?php  echo   empty($login_user->is_latex_allergy) ? 'No' : 'Yes';   ?></td>
                </tr>
                <tr>
                  <td><strong>Uterus removal (hysterectomy)?</strong> </td>
                  <td><?php   echo   empty($login_user->is_uterus_removal) ? 'No' : 'Yes';    ?></td>
                </tr> 

                    <tr>
                      <td><strong>Age of First Period</strong> </td>
                      <td><?php echo h($women_field->age_of_first_priod);  ?></td>
                    </tr>
                    
                    <tr>
                      <td><strong>Number of Pregnancy</strong> </td>
                      <td><?php echo h($women_field->no_of_pregnency);  ?></td>
                    </tr>
                    <tr>
                      <td><strong>Number of live birth</strong> </td>
                      <td><?php echo h($women_field->no_of_live_birth);  ?></td>
                    </tr>
                    <tr>
                      <td><strong>Number of miscarriage</strong> </td>
                      <td><?php echo h($women_field->no_of_miscarriage);  ?></td>
                    </tr>
                    <tr>
                      <td><strong>Is regular pap smear?</strong> </td>
                      <td><?php echo $women_field->is_regular_papsmear == 1 ? 'Yes' : 'No';  ?></td>
                    </tr>                    
                    <tr>
                      <td><strong>Last pap smear</strong> </td>
                      <td><?php echo !empty($women_field->last_papsmear) ? $women_field->last_papsmear->i18nFormat('MM/dd/yyyy') : '';  ?></td>
                    </tr>
                    <?php 
                    if($women_field->is_regular_papsmear != 1){ 
                      ?>
                    <tr>
                      <td><strong>Pap smear Findings/Procedures</strong> </td>
                      <td><?php echo  h($women_field->papsmear_finding);  ?></td>
                    </tr>

                    <?php } ?>


                    <tr>
                      <td><strong>Is currently pregnant?</strong> </td>
                      <td><?php echo $women_field->is_curently_pregnant == 1 ? 'Yes' : 'No';  ?></td>
                    </tr>
                  <?php if($women_field->is_curently_pregnant == 1)  { ?>
                    <tr>
                      <td><strong>Current baby sex</strong> </td>
                      <td><?php echo $women_field->current_baby_sex == 1 ? 'Male' : 'Female';  ?></td>
                    </tr>

                    <tr>
                      <td><strong>Current pregnancy weeks</strong> </td>
                      <td><?php echo h($women_field->currently_pregnant_week);  ?></td>
                    </tr>
                    <tr>
                      <td><strong>Current pregnancy days</strong> </td>
                      <td><?php echo h($women_field->currently_pregnant_days);  ?></td>
                    </tr>
                    <tr>
                      <td><strong>Current pregnancy complication</strong> </td>
                      <td><?php echo h($women_field->currently_pregnant_complication);  ?></td>
                    </tr>

                  <?php } ?>
                    <tr>
                      <td><strong>Is previous birth?</strong> </td>
                      <td><?php echo $women_field->is_previous_birth == 1 ? 'Yes' : 'No' ;  ?></td>
                    </tr>
             <?php if($women_field->is_previous_birth ==1) { ?>       
                    <tr>
                      <td><strong>Previous birth details</strong> </td>
                      <td><?php 

        // $prev_birth_detail  = unserialize(base64_decode($women_field->prev_birth_detail)) ;
 $prev_birth_detail  = unserialize((Security::decrypt(base64_decode($women_field->prev_birth_detail), SEC_KEY) )) ;                      

        
$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']  ; 

        foreach ($prev_birth_detail['previous_birth_sex'] as $key => $value) {
          
echo '<strong>Previous Birth Sex :</strong> '.($prev_birth_detail['previous_birth_sex'][$key] == 1 ? 'Male' :($prev_birth_detail['previous_birth_sex'][$key] == 0 ? 'Female' : '' )) .'<br>' ; 

echo '<strong>Previous Birth Month :</strong> '.(isset($month_name[$prev_birth_detail['previous_birth_month'][$key]]) ? $month_name[$prev_birth_detail['previous_birth_month'][$key]] : '').'<br>' ;

echo '<strong>Previous Birth Year :</strong> '.$prev_birth_detail['previous_birth_year'][$key].'<br>' ;

echo '<strong>Previous Delivery Method :</strong> '.($prev_birth_detail['previous_delivery_method'][$key] == 0 ? 'Normal' : ($prev_birth_detail['previous_delivery_method'][$key] == 1 ? 'C-section' : '' )) .'<br>' ;

echo '<strong>Previous Pregnancy Duration :</strong> '.h($prev_birth_detail['previos_pregnancy_duration'][$key]).'<br>' ;

echo '<strong>Previous Complication :</strong> '.h($prev_birth_detail['previous_complication'][$key]).'<br>' ;

echo '<strong>Previous Hospital :</strong> '.h($prev_birth_detail['previous_hospital'][$key]).'<br>' ;
echo '<hr>'; 

        }

                       ?></td>
                    </tr>
                  <?php } ?>  
                    <tr>
                      <td><strong>Any previous abnormal breast lump?</strong> </td>
                      <td><?php echo $women_field->previous_abnormal_breast_lump == 1 ? 'Yes' : 'No' ;  ?></td>
                    </tr>
              <?php if($women_field->previous_abnormal_breast_lump == 1) { ?>                    
                    <tr>
                      <td><strong>Any Biopsy?</strong> </td>
                      <td><?php echo $women_field->any_biopsy == 1 ? 'Yes' : 'No'  ;  ?></td>
                    </tr>  
           <?php  if($women_field->any_biopsy == 1) {  
              /*
            ?>                     
                    <tr>
                      <td><strong>Breast Lump Biopsy Date</strong> </td>
                      <td><?php echo isset($women_field->breast_lump_biopsy_date) ? $women_field->breast_lump_biopsy_date->i18nFormat('MM/dd/yyyy') : '' ;  ?></td>
                    </tr>
                    */ ?>
                    <tr>
                      <td><strong>Breast Lump Biopsy Result</strong> </td>
                      <td><?php

                  // $women_field->breast_lump_biopsy_result = unserialize(base64_decode($women_field->breast_lump_biopsy_result))  ; 
$women_field->breast_lump_biopsy_result = unserialize((Security::decrypt(base64_decode($women_field->breast_lump_biopsy_result), SEC_KEY)))  ; 
                      
$month_name = ['January', 'February', 'March', 'April','May', 'June', 'July','August', 'September', 'October','Nobember', 'December']  ;  
                  // pr( $women_field->breast_lump_biopsy_result ); 
              if(is_array($women_field->breast_lump_biopsy_result['biopsy_result'])){
    foreach ($women_field->breast_lump_biopsy_result['biopsy_result'] as $key => $value) {
      echo '<strong> Month </strong> : '.( isset($women_field->breast_lump_biopsy_result['biopsy_month'][$key]) ? $month_name[$women_field->breast_lump_biopsy_result['biopsy_month'][$key]] : '').'<br>';
       echo '<strong> Year </strong> : '.(isset($women_field->breast_lump_biopsy_result['biopsy_year'][$key]) ? $women_field->breast_lump_biopsy_result['biopsy_year'][$key] : '').'<br>';
  echo '<strong> Result </strong> : '.h($value).'<br><hr>'    ;    
      
    }
              }

                        ?></td>
                    </tr>

                <?php } } ?>    
                    <tr>
                      <td><strong>Any STI/STD?</strong> </td>
                      <td><?php echo $women_field->is_sti_std == 1 ? 'Yes' : ( $women_field->is_sti_std == 0 ? 'No' : 'Prefer not to answer')  ;  ?></td>
                    </tr>
                    <tr>
                      <td><strong>STI/STD detail</strong> </td>
                      <td><?php
                      if(!empty($women_field->sti_std_detail)) {
                      // $women_field->sti_std_detail = unserialize(base64_decode($women_field->sti_std_detail)) ; 
  $women_field->sti_std_detail = unserialize((Security::decrypt(base64_decode($women_field->sti_std_detail), SEC_KEY))) ;                         



  $sti_std_disease = array("Human papillomavirus (HPV)", "Gonorrhea", "Chlamydia", "Genital herpes", "Syphilis", "Trichomoniasis", "HIV/AIDS", "OTHER"); 

                    foreach ($women_field->sti_std_detail as $key => $value) {
           if(is_numeric($key)){
            if($key != 7)
             echo '<strong>Name</strong> : '.$sti_std_disease[$key].'<br>'; 
             if($key == 7)  // because other sti std serial no is 7 in array
               echo '<strong>Other STI/STD detail</strong> : '.h($women_field->sti_std_detail['other']).'<br>'; 
             echo '<strong>Year</strong> : '.$value.'<br><hr>'; 
           }

                      
                    }
}
                      // pr($women_field->sti_std_detail); 
              ?></td>
                    </tr>
                    

                <?php
                    }
                ?>

                                                                  
                                     
                                     
                                 
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