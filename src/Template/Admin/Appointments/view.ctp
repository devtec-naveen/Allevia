<?php
use Cake\Utility\Security;
//pr($user_detail);die;
?>

<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View Appointment
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'appointments'  ?>">Appointments</a></li>
                                <li class="active">View</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped results">
                              <tbody>
                                    <tr>
                                      <td><strong>Patient Name</strong> </td>
                                      <td><?php echo  !empty($user_detail->user->first_name) ? h($this->CryptoSecurity->decrypt(base64_decode($user_detail->user->first_name), SEC_KEY)) : '' ?>
                                        <?php echo  !empty($user_detail->user->last_name) ? ' '.h($this->CryptoSecurity->decrypt(base64_decode($user_detail->user->last_name), SEC_KEY)) : '' ?>

                                      </td>
                                    </tr>
                                    <tr>
                                      <td><strong>Clinic</strong> </td>
                           <td><?= $user_detail->organization->organization_name ?>  </td>
                                    </tr>
                                    <tr>
                                      <td><strong>Doctor</strong> </td>
                           <td><?= $user_detail->doctor->doctor_name  ?> </td>
                                    </tr>
                                    <tr>
                                      <td><strong>Specialization</strong> </td>
                           <td><?=  $user_detail->specialization->name ?> </td>
                                    </tr>

<?php
if(!empty($user_detail->chief_compliant_userdetail)){
        if(!empty($user_detail->chief_compliant_userdetail->current_step_id)) {
      ?>
<tr>
    <td><strong>Reason for visit </strong> </td> <td><?= ucfirst(h($user_detail->chief_compliant_userdetail->current_step_id->step_name))  ?></td>
</tr>
  <?php } ?>

  <!-- Hospital ER Follow Up -->
  <?php
if(!empty($user_detail->chief_compliant_userdetail->hospital_er_detail)) {
 ?>
<tr>
  <td><strong>Hospital/ER Follow Up</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->hospital_er_detail as $key => $value) {

                if(!isset($value['question'])) continue ;
              ?>

              <b>Question</b> : <?=  $value['question'] ?> <br>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
            <?php }

             ?>
        </td>
      </tr>
<?php
}
?>
  <!-- End Hospital ER -->




  <?php

if(!empty($user_detail->chief_compliant_userdetail->random_chief_compliant))
$user_detail->chief_compliant_userdetail->random_chief_compliant = Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->random_chief_compliant) , SEC_KEY);
$chief_compliant_userdata_name="";

if($user_detail->chief_compliant_userdetail->current_step_id->id != 19){

    if(!empty($user_detail->chief_compliant_userdetail->chief_compliant_id)) {
$chief_compliant_userdata_name = ucfirst(h($user_detail->chief_compliant_userdetail->chief_compliant_id->name).(!empty($user_detail->chief_compliant_userdetail->random_chief_compliant) ? ', '.h($user_detail->chief_compliant_userdetail->random_chief_compliant) : ''));

            ?>
<tr>
   <td><strong>Chief Complaint </strong> </td>   <td><?=  $chief_compliant_userdata_name  ?></td>
</tr>
  <?php } else if(!empty($user_detail->chief_compliant_userdetail->chief_compliant_id)) {

$chief_compliant_userdata_name = ucfirst(h($user_detail->chief_compliant_userdetail->random_chief_compliant)) ;
   ?>

<tr>
   <td><strong>Chief Complaint </strong> </td>   <td><?= $chief_compliant_userdata_name  ?></td>
</tr>

    <?php
  }
}?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->cancer_cc_detail)) {
 ?>
<tr>
  <td><strong>Cheif Complaint Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->cancer_cc_detail as $key => $value) {

                if(!isset($value['question'])) continue ;
              ?>

              <b>Question</b> : <?=  $value['question'] ?> <br>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
            <?php }

             ?>
        </td>
      </tr>
<?php
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->disease_name)) {
?>

  <tr>
   <td><strong>Cronic Diseases </strong> </td>   <td><?=  $user_detail->chief_compliant_userdetail->disease_name  ?></td>
</tr>
<?php } ?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->compliant_symptom_ids)) {
  ?>
<tr>
  <td><strong>Complaint symptoms</strong> </td><td> <?php
                  $temp = '';
                  foreach($user_detail->chief_compliant_userdetail->compliant_symptom_ids as $k => $v)
                  {
                    $temp .= ucfirst($v->name) .', ' ;
                  }
                $temp = rtrim($temp, ', ');
                  echo $temp ;

             ?></td>
</tr>
<?php } ?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->compliant_length)) {
?>
<tr>
  <td><strong>Chief Complaint Length</strong> </td> <td><?= h($user_detail->chief_compliant_userdetail->compliant_length) ?></td>
</tr>
<?php } ?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->compliant_medication_detail)) {

?>
<tr>
    <td><strong>Complaint Medication Details</strong> </td> <td>
             <?php

             foreach ($user_detail->chief_compliant_userdetail->compliant_medication_detail as $key => $value) {
              ?>
       <b>Meidication Name</b> :  <?= isset($value['medication_name_name']) ? h($value['medication_name_name']) : "" ?><br>
       <b>Medication Dose</b> : <?= isset($value['medication_dose']) ? h($value['medication_dose']) : "" ?><br>
       <b>How Often</b>  : <?= (isset($value['medication_how_often']) && isset($length_arr[$value['medication_how_often']])) ? h($length_arr[$value['medication_how_often']]) : "" ?><br>
       <b>How is it taken</b> : <?= isset($value['medication_how_taken']) ? h($value['medication_how_taken']) : "" ?><br><hr>
              <?php
             }
             ?>
        </td>
</tr>
 <?php
       }
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->disease_questions_detail)) {

    foreach ($user_detail->chief_compliant_userdetail->disease_questions_detail as $key => $value) {

        if(isset($value['smoking_detail']) && !empty($value['smoking_detail'])){ ?>

            <tr>
              <td><strong>Smoking Details</strong> </td> <td>

                <?php if(isset($value['smoking_detail']['current']) && !empty($value['smoking_detail']['current'])){  ?>

                   <b>Current smoking</b> :  <?= $value['smoking_detail']['current']['currentlysmoking'] ==  1 ? 'Yes': 'No' ?><br>
                   <b>Current smoke pack</b> : <?= isset($value['smoking_detail']['current']['current_smoke_pack']) ? $value['smoking_detail']['current']['current_smoke_pack'] : 0 ?><br>
                   <b>Current smoke year</b>  : <?= isset($value['smoking_detail']['current']['current_smoke_year']) ? $value['smoking_detail']['current']['current_smoke_year'] : 0 ?><br>

                <?php } ?>

                <?php if(isset($value['smoking_detail']['past']) && !empty($value['smoking_detail']['current'])){  ?>

                   <b>Past smoking</b> :  <?= $value['smoking_detail']['past']['pastsmoking'] ==  1 ? 'Yes': 'No' ?><br>
                   <b>Past smoke pack</b> : <?= isset($value['smoking_detail']['past']['past_smoke_pack']) ? $value['smoking_detail']['past']['past_smoke_pack'] : 0 ?><br>
                   <b>Past smoke year</b>  : <?= isset($value['smoking_detail']['past']['past_smoke_year']) ? $value['smoking_detail']['past']['past_smoke_year'] : 0 ?><br>

                <?php } ?>
                     <hr>
                  </td>
              </tr>
      <?php  }

      if(isset($value['alcohol_detail']) && !empty($value['alcohol_detail'])){

      ?>


      <tr>
              <td><strong>Alcohol Details</strong> </td> <td>

                <?php if(isset($value['alcohol_detail']['current']) && !empty($value['alcohol_detail']['current'])){  ?>

                   <b>Current drinking</b> :  <?= $value['alcohol_detail']['current']['currentlydrinking'] ==  1 ? 'Yes': 'No' ?><br>
                   <b>Current drink pack</b> : <?= isset($value['alcohol_detail']['current']['current_drink_pack']) ? $value['alcohol_detail']['current']['current_drink_pack'] : 0 ?><br>
                   <b>Current drink year</b>  : <?= isset($value['alcohol_detail']['current']['current_drink_year']) ? $value['alcohol_detail']['current']['current_drink_year'] : 0 ?><br>

                <?php } ?>

                <?php if(isset($value['alcohol_detail']['past']) && !empty($value['alcohol_detail']['past'])){  ?>

                   <b>Past drinking</b> :  <?= $value['alcohol_detail']['past']['pastdrinking'] ==  1 ? 'Yes': 'No' ?><br>
                   <b>Past drink pack</b> : <?= isset($value['alcohol_detail']['past']['past_drink_pack']) ? $value['alcohol_detail']['past']['past_drink_pack'] : 0 ?><br>
                   <b>Past drink year</b>  : <?= isset($value['alcohol_detail']['past']['past_drink_year']) ? $value['alcohol_detail']['past']['past_drink_year'] : 0 ?><br>

                <?php } ?>
                     <hr>
                  </td>
              </tr>
  <?php }

    }

?>

 <?php
       }
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->medication_side_effects)) {

// $user_detail->medication_side_effects = explode(',', $user_detail->medication_side_effects) ;

?>
<tr>
    <td><strong>Medication Side Effects</strong> </td>
    <td>
             <?php


             echo h($user_detail->chief_compliant_userdetail->medication_side_effects) ;
             ?></td>
</tr>
<?php } ?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->sexual_info)) {

?>
<tr>
  <td><strong>Sexual status</strong> </td>
  <td>
<?php

// $user_detail->chief_compliant_userdetail->sexual_info = unserialize(base64_decode($user_detail->chief_compliant_userdetail->sexual_info)) ;
// if(!empty($user_detail->chief_compliant_userdetail->sexual_info))
$user_detail->chief_compliant_userdetail->sexual_info = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->sexual_info), SEC_KEY))) ;




$sexual_info_label = array('sexual_active_or_not' => 'Are you sexually active?', 'no_of_partner' => 'Number of sexual partner', 'protection_used_or_not' => 'Do you use protection?', 'protection_method' => 'Protection method(s)' );

foreach ($user_detail->chief_compliant_userdetail->sexual_info as $key => $value) {

?>
 <b><?php echo  $sexual_info_label[$key] ?></b> :  <?php echo   $key == 'sexual_active_or_not' || $key == 'protection_used_or_not'   ? ( $value == 1  ? 'Yes' : 'No' )   : h($value)   ?>  <br>
<?php
}
?>
</td>
</tr>
<?php
 }
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->chief_compliant_details)) {
 ?>
<tr>
  <td><strong>Chief Complaint Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->chief_compliant_details as $key => $value) {
                foreach ($value as $ky => $val) {
                  if(!isset($val['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $val['question']) ?> <br>
              <b>Answer</b> : <?php echo is_numeric($val['answer']) && $val['answer'] == 0 ? '--' : (is_array($val['answer']) ? implode(', ', $val['answer'] ) : h($val['answer'])  )  ?>  <br>
              <?php
                 }
             }

             ?>
        </td>
      </tr>
<?php
}
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->chief_compliant_other_details)) {
 ?>
<tr>
  <td><strong>Chief Complaint Other Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->chief_compliant_other_details as $key => $value) {
               // foreach ($value as $ky => $val) {
                  if(!isset($value['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php

              echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  );

              if($value['question_id'] == 12 && $value['answer'] == 'Yes' && !empty($user_detail->chief_compliant_userdetail->other_questions_treatment_detail)){

                echo '<br><b>You had taken : </b><br>';
                foreach ($user_detail->chief_compliant_userdetail->other_questions_treatment_detail as $tkey => $tvalue) {

                  echo $tvalue['treatment_type'].' at '.$tvalue['treatment_date'].'<br>';
                }
              }


              ?>  <br>
              <?php
                // }
             }

             ?>
        </td>
      </tr>
<?php
}
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->general_update_question)) {
 ?>
<tr>
  <td><strong>General Update Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->general_update_question as $key => $value) {
               // foreach ($value as $ky => $val) {
                  if(!isset($value['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php


              echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  ) ;

                if($value['question_id'] == 15 && $value['answer'] == 'Yes' && !empty($user_detail->chief_compliant_userdetail->general_update_provider_info)){

                  echo '<br>';

                  if(isset($user_detail->chief_compliant_userdetail->general_update_provider_info['provider_name'])){

                    echo '<b>Provider Name : </b>'.$user_detail->chief_compliant_userdetail->general_update_provider_info['provider_name'].'<br>';
                  }

                  if(isset($user_detail->chief_compliant_userdetail->general_update_provider_info['speciality'])){

                    echo '<b>Speciality : </b>'.$user_detail->chief_compliant_userdetail->general_update_provider_info['speciality'].'<br>';
                  }

                  if(isset($user_detail->chief_compliant_userdetail->general_update_provider_info['address'])){

                    echo '<b>Address : </b>'.$user_detail->chief_compliant_userdetail->general_update_provider_info['address'].'<br>';
                  }

                  if(isset($user_detail->chief_compliant_userdetail->general_update_provider_info['phone'])){

                    echo '<b>Phone : </b>'.$user_detail->chief_compliant_userdetail->general_update_provider_info['phone'];
                  }
                }

                if($value['question_id'] == 18 && $value['answer'] == 'Yes' && !empty($user_detail->chief_compliant_userdetail->general_update_procedure_detail)){

                  echo '<br><b>Recent surgeries or procedures details : </b><br>';

                  foreach ($user_detail->chief_compliant_userdetail->general_update_procedure_detail as $pkey => $pvalue) {

                    if(isset($pvalue['procedure_type']) && !empty($pvalue['procedure_type']) && isset($pvalue['procedure_date']) && !empty($pvalue['procedure_date'])){

                      echo $pvalue['procedure_type']." at ".$pvalue['procedure_date'].'<br>';
                    }
                  }
                }
               ?>  <br>
              <?php
                // }
             }

             ?>
        </td>
      </tr>
<?php
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->pain_update_question)) {
 ?>
<tr>
  <td><strong>Pain Update Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->pain_update_question as $key => $value) {
               // foreach ($value as $ky => $val) {
                  if(!isset($value['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
              <?php
                // }
             }

             ?>
        </td>
      </tr>
<?php
}
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->post_checkup_question_detail)) {
 ?>
<tr>
  <td><strong>Post-procedure Checkup Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->post_checkup_question_detail as $key => $value) {
               // foreach ($value as $ky => $val) {
                  if(!isset($value['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
              <?php
                // }
             }

             ?>
        </td>
      </tr>
<?php
}
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->pre_op_procedure_detail)) {
 ?>
<tr>
  <td><strong>Pre-Operation Procedure Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->pre_op_procedure_detail as $key => $value) {
               // foreach ($value as $ky => $val) {
                  if(!isset($value['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
              <?php
                // }
             }

             ?>
        </td>
      </tr>
<?php
}
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->pre_op_medications_question_detail)) {
 ?>
<tr>
  <td><strong>Pre-Operation Medications Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->pre_op_medications_question_detail as $key => $value) {
               // foreach ($value as $ky => $val) {
                  if(!isset($value['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
              <?php
                // }
             }

             ?>
        </td>
      </tr>
<?php
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->pre_op_allergies_detail)) {

?>
<tr>
    <td><strong>Pre-Operation Allergies Details</strong> </td> <td>
             <?php

             foreach ($user_detail->chief_compliant_userdetail->pre_op_allergies_detail as $key => $value) {
              ?>
       <b>Allergy Name</b> :  <?= isset($value['condition_name']) ? h($value['condition_name']) : "" ?><br>
       <b>Allergy Status</b> : <?= isset($value['answer']) ? ($value['answer'] == 1 ? 'Yes' : 'No') : "" ?><br>

        <?php if($value['answer'] == 1 && isset($value['reaction'])){ ?>

            <b>Allergy Reaction</b>  : <?= h($value['reaction']) ?><br>
        <?php } ?>
       <hr>
              <?php
             }
             ?>
        </td>
</tr>
 <?php
       }
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail)) {

?>
<tr>
    <td><strong>Pre-Operation Medical Condition Details</strong> </td> <td>
             <?php

             foreach ($user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail as $key => $value) {
              ?>
       <b>Medical Condition Name</b> :  <?= isset($value['condition_name']) ? h($value['condition_name']) : "" ?><br>
       <b>Medical Condition Status</b> : <?= isset($value['answer']) ? ($value['answer'] == 1 ? 'Yes' : 'No') : "" ?><br>

        <?php if($value['answer'] == 1 && isset($value['year'])){ ?>

            <b>Diagnosed Year</b>  : <?= h($value['year']) ?><br>
        <?php } ?>
       <hr>
              <?php
             }
             ?>
        </td>
</tr>
 <?php
       }
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->screening_questions_detail)) {
 ?>
<tr>
  <td><strong>Screening Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->screening_questions_detail as $key => $value) {
               // foreach ($value as $ky => $val) {
                  if(!isset($value['question'])) continue ;
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php

                $screening_answer = is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  );
                if($value['question_id'] == 2){

                  $screening_answer = str_replace('1','<50 years',$screening_answer);
                  $screening_answer = str_replace('2','50-60 years',$screening_answer);
                  $screening_answer = str_replace('3','>60 years',$screening_answer);

                }

                  echo $screening_answer;
               ?>  <br>
              <?php
                // }
             }

             ?>
        </td>
      </tr>
<?php
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->chief_compliant_symptoms)) {
?>

<tr>
  <td><strong>Associated Symptoms Details </strong> </td>
  <td>
             <?php
             $res_ar = array(0 => 'NO', 1 => 'YES' , 2 => "I DON'T KNOW");
             foreach ($user_detail->chief_compliant_userdetail->chief_compliant_symptoms as $key => $value) {
              foreach($value as $k =>$v) {
              ?>
              <b><?= ucfirst($v->name)  ?></b> : <?= $res_ar[$key] ?> <br>

             <?php
            }
             }

             ?>
           </td>
    </tr>
<?php }

?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->disease_questions_detail)) {
 ?>
<tr>
  <td><strong>Disease Details</strong> </td>
  <td>
             <?php
              $i = 1;
             foreach ($user_detail->chief_compliant_userdetail->disease_questions_detail as $key => $value) {

                  if(isset($value['disease']) && !empty($value['disease'])){
              ?>


                    <b><?php echo $i.'. '.$value['disease']->name.' Detail:- <br><br>'; ?></b>


                      <?php if(isset($value['disease_detail_question']) && !empty($value['disease_detail_question'])){

                          foreach ($value['disease_detail_question'] as $disease_key => $disease_que) {

                                if(!isset($disease_que['question'])) continue ;
                            ?>

                              <b>Question</b> : <?=  $disease_que['question'] ?> <br>
                              <b>Answer</b> : <?php echo is_numeric($disease_que['answer']) && $disease_que['answer'] == 0 ? '--' : (is_array($disease_que['answer']) ? implode(', ', $disease_que['answer'] ) : h($disease_que['answer'])  )  ?>  <br>

                          <?php }


                            }
                          ?>


                          <?php if(isset($value['alarm_sysmptom']) && !empty($value['alarm_sysmptom'])){ ?>

                              <b><br>Alarm Symptoms Deatil:- <br></b>

                              <?php foreach($value['alarm_sysmptom'] as $alarmsym_key => $alarmsym_val){



                                  echo '<b>'.$alarmsym_val['name'].'</b>: '.($alarmsym_val['answer'] == 0 ? 'No' : 'Yes').'<br>';
                                ?>



                          <?php }

                            }
                           ?>

                           <?php if(isset($value['baseline_sysmptom']) && !empty($value['alarm_sysmptom'])){ ?>

                              <b><br>Baseline Symptoms Deatil:- <br></b>

                              <?php foreach($value['baseline_sysmptom'] as $alarmsym_key => $alarmsym_val){



                                  echo '<b>'.$alarmsym_val['name'].'</b>: '.($alarmsym_val['answer'] == 0 ? 'No' : 'Yes ('.$alarmsym_val['scale'].')').'<br>';
                                ?>



                          <?php }

                            }
                           ?>

                   <?php
                      $i++;
                    }
                     echo '<br><br>';
                 }



              ?>
        </td>
      </tr>
<?php
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details)) {

    if(isset($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['soapp']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['soapp'])){
 ?>

 <tr>
  <td><strong>SOAPP Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['soapp'] as $key => $val) {

                  if(!isset($val['question'])) continue ;
              ?>
              <b>Question</b> : <?= $val['question'] ?> <br>
              <b>Answer</b> : <?php echo is_numeric($val['answer']) && $val['answer'] == 0 ? '--' : (is_array($val['answer']) ? implode(', ', $val['answer'] ) : h($val['answer'])  )  ?>  <br>
              <?php

             }

             ?>
        </td>
      </tr>
<?php }

if(isset($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['comm']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['comm'])){ ?>

    <tr>
      <td><strong>COMM Details</strong> </td>
      <td>
                 <?php
                 // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
                 foreach ($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['comm'] as $key => $val) {

                      if(!isset($val['question'])) continue ;
                  ?>
                  <b>Question</b> : <?= $val['question'] ?> <br>
                  <b>Answer</b> : <?php echo is_numeric($val['answer']) && $val['answer'] == 0 ? '--' : (is_array($val['answer']) ? implode(', ', $val['answer'] ) : h($val['answer'])  )  ?>  <br>
                  <?php

                 }

                 ?>
            </td>
        </tr>

<?php }

} ?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details)) {

 ?>

    <?php

      if(isset($user_detail->chief_compliant_userdetail->medication_refill_extra_details['dast']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details['dast'])){
    ?>

    <tr>
      <td><strong>DAST-10 Details</strong> </td>
      <td>
                 <?php
                 // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
                 foreach ($user_detail->chief_compliant_userdetail->medication_refill_extra_details['dast'] as $key => $val) {

                      if(!isset($val['question'])) continue ;
                  ?>
                  <b>Question</b> : <?= $val['question'] ?> <br>
                  <b>Answer</b> : <?php echo is_numeric($val['answer']) && $val['answer'] == 0 ? '--' : (is_array($val['answer']) ? implode(', ', $val['answer'] ) : h($val['answer'])  )  ?>  <br>
                  <?php

                 }

                 ?>
            </td>
        </tr>
<?php
  }

if(isset($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt'])){
    ?>

    <tr>
      <td><strong>PADT Details</strong> </td>
      <td>Rate of severity of side effects:- <br>
                 <?php
                 // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
                 foreach ($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt'] as $key => $val) {

                      if(!isset($val['question'])) continue ;
                      if($val['question_id'] == 119 && isset($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt_other_question_119']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt_other_question_119'])){

                        $val['question'] = $user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt_other_question_119'];

                      }
                  ?>
                  <b>Question</b> : <?= $val['question'] ?> <br>
                  <b>Answer</b> : <?php echo is_numeric($val['answer']) && $val['answer'] == 0 ? '--' : (is_array($val['answer']) ? implode(', ', $val['answer'] ) : h($val['answer'])  )  ?>  <br>
                  <?php

                 }

                 ?>
            </td>
        </tr>
<?php
  }
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->cancer_history_detail)) {
 ?>
<tr>
  <td><strong>Cancer History Details</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->cancer_history_detail as $key => $value) {

                echo "<b>".ucfirst($key)."</b><br>";
                foreach ($value as $ky => $val) {
                  if(!isset($val['question'])) continue ;
              ?>
              <b>Question</b> : <?=  $val['question'] ?> <br>
              <b>Answer</b> : <?php echo is_numeric($val['answer']) && $val['answer'] == 0 ? '--' : (is_array($val['answer']) ? implode(', ', $val['answer'] ) : h($val['answer'])  )  ?>  <br>
              <?php
                 }
                echo "<br>";
             }

             ?>
        </td>
      </tr>
<?php
}
?>


<?php
if(!empty($user_detail->chief_compliant_userdetail->cancer_medical_detail)) {
 ?>
<tr>
  <td><strong>Medical History Details</strong> </td>
  <td>
             <?php
             foreach ($user_detail->chief_compliant_userdetail->cancer_medical_detail as $key => $value) {

                if(!isset($value['question'])) continue ;

                if(in_array($value['question_id'], [355,359,360,361,362,364,365,366,367,368,369,370]) && strtolower($value['answer']) == 'yes' && !empty($user_detail->chief_compliant_userdetail->cancer_family_members) && isset($user_detail->chief_compliant_userdetail->cancer_family_members[$value['question_id']])){ ?>

                    <b>Question</b> : <?= $value['question'] ?> <br>
                    <b>Answer</b> : <?php echo is_array($user_detail->chief_compliant_userdetail->cancer_family_members[$value['question_id']]) ? implode(", ", $user_detail->chief_compliant_userdetail->cancer_family_members[$value['question_id']]) : $user_detail->chief_compliant_userdetail->cancer_family_members[$value['question_id']];  ?>  <br>

                <?php
                    if($value['question_id'] == 355 && !empty($user_detail->chief_compliant_userdetail->family_members_cancer_disease_detail)){

                      echo '<b>Family members with cancer type detail</b><br>';

                        foreach ($user_detail->chief_compliant_userdetail->family_members_cancer_disease_detail as $fkey => $fvalue) {

                            if(!isset($fvalue['disease'])){

                              continue;
                            }

                            $temp_disease = strtolower(is_array($fvalue['disease']) ? implode(", ", $fvalue['disease']) : $fvalue['disease']);
                            $temp_disease = strtolower(isset($fvalue['other']) && !empty($fvalue['other']) ? str_replace("other",$fvalue['other'] , $temp_disease) : $temp_disease);

                            echo $fkey.(isset($fvalue['age']) && !empty($fvalue['age']) ? " (".$fvalue['age'].")": "")." : ".$temp_disease."<br>";
                        }
                    }
                  }
                  else{
              ?>
              <b>Question</b> : <?= $value['question'] ?> <br>
              <?php if(in_array($value['question_id'], [563])){
              $drink_item = '';
                            //pr($singlelevel['answer']['time']);die;
                            if(!empty($value['answer']['time']))
                            { 
                              $count_item = count($value['answer']['time']);
                              $i = 1;
                              foreach($value['answer']['time'] as $k => $v)
                              {
                                $drink_item .= " ".$k." ".$v;
                                if($i < $count_item)
                                $drink_item .= ", ";
                                $i++;
                              }

                            }
                            $value['answer'] = $drink_item ? $$drink_item : "None";
                        }
               ?>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
            <?php }
            }

             ?>
        </td>
      </tr>
<?php
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->cancer_assessments)) {

  //pr($user_detail->chief_compliant_userdetail->cancer_assessments);
 ?>
<tr>
  <td><strong>Cancer Assessments</strong> </td>
  <td>
             <?php
             // pr($user_detail->chief_compliant_userdetail->chief_compliant_details); die ;
             foreach ($user_detail->chief_compliant_userdetail->cancer_assessments as $key => $value) {


                if($key == 'assessment_history'){

                  echo "<b>Assessments</b><br>";
                }
                elseif($key == 'life_assessment'){

                  echo "<b>Life quality assessments</b><br>";
                }
                elseif($key == 'chemo_assessment'){

                  echo "<b>Chemo therapy assessments</b><br>";
                }
                foreach ($value as $ky => $val) {
                  if(!isset($val['name'])) continue ;
              ?>
              <?= ucfirst($val['name']) ?> : <b><?= ucfirst($val['answer']) ?></b> <br>
              <?php
                 }
                echo "<br>";
             }

             ?>
        </td>
      </tr>
<?php
}
?>

<?php

if(!empty($user_detail->chief_compliant_userdetail->cancer_followup_general_detail)) {
 ?>
<tr>
  <td><strong>Cancer followup general details</strong></td>
  <td>
             <?php
             foreach ($user_detail->chief_compliant_userdetail->cancer_followup_general_detail as $key => $value) {
              ?>
              <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
              <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
              <?php
             }
             ?>
        </td>
      </tr>
<?php
}
?>


<?php

//pr($user_detail->chief_compliant_userdetail->followup_medical_history_detail);
//pr($user_detail->chief_compliant_userdetail->followup_medical_history_detail['followup_medical_history_detail']);
if(!empty($user_detail->chief_compliant_userdetail->followup_medical_history_detail)) {
 ?>
<tr>
  <td><strong>Cancer followup medical history</strong></td>
  <td>
             <?php

             foreach ($user_detail->chief_compliant_userdetail->followup_medical_history_detail['followup_medical_history_detail'] as $key => $value) {
               if($value['question_id'] == 476 && $value['answer'] == 'Yes')
               {
                 $medicalissue = array();
                 foreach($user_detail->chief_compliant_userdetail->followup_medical_history_detail['medical_history'] as $key1 => $value1)
                 {
                    $medicalissue[] .= $value1['name'].'('.$value1['year'] .')';
                 }
                 ?>
                 <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
                 <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
                 <b>Medical Issue are </b> : <?php echo !empty($medicalissue)?implode(',', $medicalissue):''?><br>
                 <?php
               }
              else if($value['question_id'] == 477 && $value['answer'] == 'Yes')
               {
                 $surgery = array();
                 foreach($user_detail->chief_compliant_userdetail->followup_medical_history_detail['surgical_history'] as $key1 => $value1)
                 {
                    $surgery[] .= $value1['name'].'('.$value1['year'] .')';
                 }
                 ?>
                 <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
                 <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
                 <b>New surgery argument </b> : <?php echo !empty($surgery)?implode(',', $surgery):''?><br>
                 <?php
               }
               else if($value['question_id'] == 497 && $value['answer'] == 'Yes'){
                 $allergiesissue = array();
                 foreach($user_detail->chief_compliant_userdetail->followup_medical_history_detail['allergy_history'] as $key1 => $value1)
                 {
                    $allergiesissue[] .= '<strong>'.$value1['name'].'('.$value1['reaction'] .') '.'</strong>';
                 }
                 ?>
                 <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
                 <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
                 <b>New alergies are </b> : <?php echo !empty($allergiesissue)?implode(', ', $allergiesissue):''?><br>
                 <?php
              }
               else {
                 ?>
                 <b>Question</b> : <?=  str_replace('****', $chief_compliant_userdata_name , $value['question']) ?> <br>
                 <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>

                 <?php
               }

              ?>

              <?php
             }
             ?>
        </td>
      </tr>
<?php
}
?>

<?php
if(!empty($user_detail->chief_compliant_userdetail->followup_assessment)) {

  //pr($user_detail->chief_compliant_userdetail->cancer_assessments);
 ?>
<tr>
  <td><strong>Follow up Assessments</strong> </td>
  <td>
             <?php
             foreach ($user_detail->chief_compliant_userdetail->followup_assessment as $key => $value) {
                if($key == 'assessment_history' && !empty($user_detail->chief_compliant_userdetail->followup_assessment['assessment_history'])){
                  echo "<b>Assessments</b><br>";
                }
                elseif($key == 'life_assessment' && !empty($user_detail->chief_compliant_userdetail->followup_assessment['life_assessment'])){
                  echo "<b>Life quality assessments</b><br>";
                }
                elseif($key == 'chemo_assessment' && !empty($user_detail->chief_compliant_userdetail->followup_assessment['chemo_assessment'])){
                  echo "<b>Chemo therapy assessments</b><br>";
                }
                foreach ($value as $ky => $val) {
                  if(!isset($val['name'])) continue ;
              ?>
              <?= ucfirst($val['name']) ?> : <b><?= ucfirst($val['answer']) ?></b> <br>
              <?php
                 }
                echo "<br>";
             }

             ?>
        </td>
      </tr>
<?php
}
?>


<?php

if(!empty($user_detail->chief_compliant_userdetail->questionnaire_detail)) {
 ?>

<tr>
  <td><strong>Health questionnaire details</strong> </td>
  <td>
             <?php
             $res_ar = array(0 => 'NO', 1 => 'YES' , 2 => "I DON'T KNOW");
             foreach ($user_detail->chief_compliant_userdetail->questionnaire_detail as $key => $value) {
              foreach($value as $k =>$v) {
              ?>
              <b><?= ucfirst($v->questionnaire_text) ?></b> : <?= $res_ar[$key] ?> <br>

   <?php
      }
   }
   ?>
</td>
</tr>
   <?php
}
// Pain Management 
if(!empty($user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb)) { 
 ?>
 <tr>
  <td><strong>Paint assessments</strong> </td>
  <td>
   <?php    
   foreach ($user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb as $key => $value) {    
      ?>
      <b>Question</b> : <?= $value['question'] ?> <br>
                  <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer'])  )  ?>  <br>
      <?php     
  }
  ?>
  <br>
  <b>Following symtoms details:</b> <br>

<!-- end Pain MAnagement -->
 <?
    foreach ($user_detail->chief_compliant_userdetail->chronic_pain_assessment_pmh as $key => $value) {    
      ?>
      <b>Medicine name</b> : <?= $value['medical_name'] ?> <br>
                  <b>Date</b> : <?php echo is_numeric($value['date']) && $value['date'] == 0 ? '--' : (is_array($value['date']) ? implode(', ', $value['date'] ) : h($value['date'])  )  ?>  <br>
      <?php     
  }
  ?>
</td>
</tr>
<?php
}

if(!empty($user_detail->chief_compliant_userdetail->chronic_pain_treatment_history)) { 
 ?>
 <tr>
  <td><strong>Paint Treatment History</strong> </td>
  <td>
   <?php  
   $medicineArray = array('0' => 'spinal injections', '1' => 'joint injections' , '2' => 'physical therapy', '3' => 'medication'); 
    $efficacy = array('1' =>'helped a lot', '2' =>'helped a little', '3' =>"didn't help at all"); 
    foreach ($user_detail->chief_compliant_userdetail->chronic_pain_treatment_history as $key => $value) {    
      ?>
        <b>Question</b> : <?= $value['question'] ?> <br>
        <b>Answer</b> :
        <?php

        if(is_array($value['answer']) && !empty($value['answer']))
        {
          $medicationArray = array_filter($value['answer']);
          foreach ($medicationArray as $key => $value) {

            echo $medicineArray[$key].' ('.$efficacy[$value].')'.', ';            
          }
          ?>
          <br>
          <?
        }
        else
        {
            echo $value['answer'].'<br>';
        } 

        ?>                 
      <?php     
  }
  ?>
</td>
</tr>
<?php
}

if(!empty($user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk)) { 
 ?>
 <tr>
  <td><strong>Opioid overdose risk</strong> </td>
  <td>
   <?php    
   foreach ($user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk as $key => $value) { 

     if($value['answer'] == '')
     continue;   
      ?>
      <b>Question</b> : <?= $value['question'] ?> <br>
                  <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer']))  ?><br>
      <?php     
  }
  ?>
</td>
</tr>
<?php
}

if(!empty($user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort)) { 
 ?>
 <tr>
  <td><strong>Opioid risk tool</strong> </td>
  <td>
   <?php    
   foreach ($user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort as $key => $value) {       
      ?>
      <b>Question</b> : <?= $value['question'] ?> <br>
                  <b>Answer</b> : <?php echo is_numeric($value['answer']) && $value['answer'] == 0 ? '--' : (is_array($value['answer']) ? implode(', ', $value['answer'] ) : h($value['answer']))  ?><br>
      <?php     
  }
  ?>
</td>
</tr>
<?php
}
// for female user 
if($user_detail->user->gender == 0 ){
?>
<tr>
  <td colspan="2" ><strong>Sex Specific Info</strong> </td>
</tr>
<?php
$period_specific_label = array('was_it_regular_or_not' => 'Was it regular or not ?', 'cycle_length_in_days' => 'Cycle length (In Days)', 'flow_duration_in_days' => 'Flow duration (In Days)' );

$papsmear_specific_label = array('was_it_regular_or_not' => 'Was it regular or not ?', 'any_findings_or_procedures' => 'Any Findings/Procedures?' );

// current pregnancy info start


if(!is_null($user_detail->chief_compliant_userdetail->is_curently_pregnant)){
?>


<tr>
  <td><strong>Is currently pregnant</strong> </td>
  <td><?php echo $user_detail->chief_compliant_userdetail->is_curently_pregnant == 1 ? 'Yes' : 'No' ;  ?></td>
</tr>

<?php
}

if(!is_null($user_detail->chief_compliant_userdetail->current_baby_sex)){
?>

<tr>
  <td><strong>Current baby sex</strong> </td>
  <td><?php echo  $user_detail->chief_compliant_userdetail->current_baby_sex == 1 ? 'Male' : 'Female' ;  ?></td>
</tr>



<?php
}

if(!empty($user_detail->chief_compliant_userdetail->currently_pregnant_week)){

$user_detail->chief_compliant_userdetail->currently_pregnant_week = Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->currently_pregnant_week) , SEC_KEY);

?>


<tr>
  <td><strong>Current pregnancy week</strong> </td>
  <td><?php echo $user_detail->chief_compliant_userdetail->currently_pregnant_week ;  ?> </td>
</tr>
<?php
}

if(!empty($user_detail->chief_compliant_userdetail->currently_pregnant_days)){

$user_detail->chief_compliant_userdetail->currently_pregnant_days = Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->currently_pregnant_days) , SEC_KEY);

?>

<tr>
  <td><strong>Current pregnancy days</strong> </td>
  <td> <?php echo $user_detail->chief_compliant_userdetail->currently_pregnant_days ;  ?> </td>
</tr>


<?php
}

if(!empty($user_detail->chief_compliant_userdetail->currently_pregnant_complication)){


$user_detail->chief_compliant_userdetail->currently_pregnant_complication = Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->currently_pregnant_complication) , SEC_KEY);

?>

<tr>
  <td><strong>Current pregnancy complication</strong> </td>
  <td> <?php echo $user_detail->chief_compliant_userdetail->currently_pregnant_complication ;  ?></td>
</tr>


<?php
}



// current pregnancy info end




if(!empty($user_detail->chief_compliant_userdetail->age_of_first_priod)){
?>

<tr>
  <td><strong>Age of first period</strong> </td>
  <td><?php echo $user_detail->chief_compliant_userdetail->age_of_first_priod ;  ?></td>
</tr>

<?php
}


if(!empty($user_detail->chief_compliant_userdetail->last_period_date)){
?>
<tr>
  <td><strong>Last Period Date</strong> </td>
  <td><?php echo $user_detail->chief_compliant_userdetail->last_period_date->i18nFormat('MM-dd-yyyy') ;  ?></td>
</tr>
<?php
}
?>


<?php

if(!empty($user_detail->chief_compliant_userdetail->last_period_info)){
  ?>
<tr>
   <td><strong>Last period info</strong> </td><td>
  <?php
  // $user_detail->chief_compliant_userdetail->last_period_info = unserialize($user_detail->chief_compliant_userdetail->last_period_info) ;
   $user_detail->chief_compliant_userdetail->last_period_info = unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->last_period_info), SEC_KEY)) ;


  $user_detail->chief_compliant_userdetail->last_period_info = array_filter($user_detail->chief_compliant_userdetail->last_period_info) ;

  foreach ($user_detail->chief_compliant_userdetail->last_period_info as $key => $value) {


?>
  <b><strong><?php echo $period_specific_label[$key] ?> :</strong> </b>
  <?php echo $key != 'was_it_regular_or_not' ? h($value) : ($value == 1 ? 'Yes' : 'No') ;  ?>
  <br>
<?php
   }
   ?>
   </td>
</tr>
   <?php
 }
 ?>


<?php
/*
if(!empty($user_detail->chief_compliant_userdetail->last_pap_smear_date)){
  ?>
<tr>
  <td><strong>Last pap smear date</strong> </td>
  <td><?php echo $user_detail->chief_compliant_userdetail->last_pap_smear_date->i18nFormat('MM-dd-yyyy') ;  ?> </td>
</tr>
<?php
}
*/
?>

<?php

if(!empty($user_detail->chief_compliant_userdetail->last_pap_smear_info)){

    $user_detail->chief_compliant_userdetail->last_pap_smear_info = unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->last_pap_smear_info), SEC_KEY)) ;

$ud_lspi  = $user_detail->chief_compliant_userdetail->last_pap_smear_info ;
?>
<tr>
    <td><strong>Last pap smear info</strong> </td>
    <td>

      <b>Last papsmear date</b> : <?php echo  (isset($ud_lspi['papsmear_month']) ? h($ud_lspi['papsmear_month']) : "--").'/'.(isset($ud_lspi['papsmear_year']) ? h($ud_lspi['papsmear_year']) : "--")  ?> <br />
      <b>Is regular last papsmear</b> :  <?php echo  (!isset($ud_lspi['was_it_regular_or_not'])  ? '--' : ($ud_lspi['was_it_regular_or_not'] == 0 ? 'No' : "Yes" ))  ?> <br />

      <b>Any Findings/Procedures?</b> : <?= (isset($ud_lspi['any_findings_or_procedures']) ? h($ud_lspi['any_findings_or_procedures']) : "--")  ?> <br />
<?php
 ?>
</td>
</tr>
 <?php
  }
 }
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
