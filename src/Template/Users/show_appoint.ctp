
<?php
use Cake\Utility\Security;
?>

<div class="body">
    <div class="table-responsive">

      <?php

      // preparing layman summary start  ***********
        if(isset($user_detail->chief_compliant_userdetail->all_cc_detail_name)){

            $all_cc_name = $user_detail->chief_compliant_userdetail->all_cc_detail_name;
        }
        else{

          $all_cc_name = '';
        }

        $layman_summar = '' ;
        $layman_summar = '' ;
        $prev_visit_layman_summar = '' ;
        $pain_update_question_layman = "";
        $general_update_question_layman = '';
        $pre_visit_other_detail_question_layman = '';
        $organization_name = "";
        $doctor_name = "";
        $screening_question_detail_layman = "";
        $post_checkup_detail_layman = "";
        $prev_visit_screening_question_detail = "";
        $prev_visit_post_checkup_detail_layman = "";
        $pre_op_procedure_detail_question_layman = "";
        $pre_op_medical_conditions_layman = "";
        $pre_op_alleries_conditions_layman  = '';
        $pre_op_not_affected_medical_conditions_layman = "";
        $pre_op_not_affected_alleries_conditions_layman = "";
        $pre_op_medication_detail_question_layman = "";
        $cronic_disease_layman = "";
        $follow_up_sx_detail = '';
        $phq_9_detail_layman = '';
        $cancer_cc_detail = '';
        $cancer_history_detail = '';
        $cancer_assessments = '';
        $cancer_medical_detail = '';
        $pre_op_post_op_layman = '';
        $general_follow_up_detail_layman = '';
        $followup_medical_history_detail_detail_layman = '';

        $gender = $user_detail->user['gender'];

        if(!empty($user_detail->user['gender'])){
          $gender = Security::decrypt(base64_decode($user_detail->user['gender']) , SEC_KEY);
        }

        $medication_refill_extra_detail_score = $this->General->prepare_medication_refill_extra_details_layman($user_detail->chief_compliant_userdetail->medication_refill_extra_details, $user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details);

        $focused_history_detail_layman_detail = $this->General->focuses_history_layman($user_detail->chief_compliant_userdetail->focused_history_detail);
        $focused_history_detail_layman = $focused_history_detail_layman_detail['layman_summar'];

        $covid_detail_layman_detail = $this->General->covid_detail_layman($user_detail->chief_compliant_userdetail->covid_detail);
        $covid_detail_layman = $covid_detail_layman_detail['layman_summar'];

        $phq_9_detail_layman_detail = $this->General->phq_9_detail_layman($user_detail->chief_compliant_userdetail->phq_9_detail);
        //$phq_9_detail_layman = $phq_9_detail_layman_detail['layman_summar'];
        if(!empty($phq_9_detail_layman_detail['layman_summar'])){

          if($user_detail->chief_compliant_userdetail->current_step_id->id == 1){

            $phq_9_detail_layman .= "<br /><strong>You have been bothered by the following over the past 2 weeks:</strong><br />".$phq_9_detail_layman_detail['layman_summar'];
          }
          else{

            $phq_9_detail_layman .= "<br /><strong>You provided these details for PHQ-9:</strong><br />".$phq_9_detail_layman_detail['layman_summar'];
          }
        }

        $cancer_assessments_layman_detail = $this->General->prepare_cancer_assessments_layman($user_detail->chief_compliant_userdetail->cancer_assessments);
        $cancer_assessments_layman = $cancer_assessments_layman_detail['layman_summar'];

        if($user_detail->chief_compliant_userdetail->current_step_id->id == 19){
          $cancer_cc_layman_detail = $this->General->prepare_cancer_cc_layman($user_detail->chief_compliant_userdetail->cancer_cc_detail);
          $cancer_cc_detail = $cancer_cc_layman_detail['layman_summar'];

          $cancer_history_layman_detail = $this->General->prepare_cancer_history_layman($user_detail->chief_compliant_userdetail->cancer_history_detail,$gender);
          $cancer_history_detail = $cancer_history_layman_detail['layman_summar'];

          $cancer_medical_layman_detail = $this->General->prepare_cancer_medical_layman($user_detail->chief_compliant_userdetail->cancer_medical_detail,$user_detail->chief_compliant_userdetail->cancer_family_members,$user_detail->chief_compliant_userdetail->family_members_cancer_disease_detail);
          $cancer_medical_detail = $cancer_medical_layman_detail['layman_summar'];
        }


         

        if(!empty($user_detail->chief_compliant_userdetail->appointment_id) && isset($user_detail->chief_compliant_userdetail->appointment_id->doctor_id) && !empty($user_detail->chief_compliant_userdetail->appointment_id->doctor_id) && isset($user_detail->chief_compliant_userdetail->appointment_id->doctor_id->doctor_name))
        {

            $doctor_name = $user_detail->chief_compliant_userdetail->appointment_id->doctor_id->doctor_name;
        }

        if(!empty($user_detail->chief_compliant_userdetail->appointment_id) && isset($user_detail->chief_compliant_userdetail->appointment_id->organization_id) && !empty($user_detail->chief_compliant_userdetail->appointment_id->organization_id) && isset($user_detail->chief_compliant_userdetail->appointment_id->organization_id->organization_name))
        {

          $organization_name = $user_detail->chief_compliant_userdetail->appointment_id->organization_id->organization_name;
        }


        if(isset($prev_visit_user_detail) && !empty($prev_visit_user_detail) && $user_detail->chief_compliant_userdetail->current_step_id->id != 16)
        {
            $prev_visit_tmpx = $this->General->prepare_question_layman($prev_visit_user_detail);
             // function in General Helper prepare questoin answer in layman format
            $prev_visit_layman_summar =  '<br /><strong style="background: #ccc;"> In your previous visit you provided these details : </strong>'.$prev_visit_tmpx['layman_summar'].'<br />';
            $prev_visit_other_question_temp = $this->General->prepare_other_question_layman($prev_visit_user_detail);

            if(!empty($prev_visit_other_question_temp['layman_summar'])){

              $pre_visit_other_detail_question_layman = '<br /><strong> In your previous visit you provided these other details: </strong>'.$prev_visit_other_question_temp['layman_summar'].'<br />';
            }

            $prev_visit_screening_question_detail = $this->General->prepare_screening_question_layman($prev_visit_user_detail);

            if(!empty($prev_visit_screening_question_detail) && isset($prev_visit_screening_question_detail['layman_summar'])){

              $prev_visit_screening_question_detail = $prev_visit_screening_question_detail['layman_summar'].'<br />';
            }

            $prev_visit_post_checkup_detail_layman = $this->General->prepare_post_checkup_question_layman($prev_visit_user_detail);

            if(!empty($prev_visit_post_checkup_detail_layman) && isset($prev_visit_post_checkup_detail_layman['layman_summar'])){

              $prev_visit_post_checkup_detail_layman = $prev_visit_post_checkup_detail_layman['layman_summar'];
            }

        }

       // pr($user_detail);die;
       // pr($user_detail);die;


        $tmpx = $this->General->prepare_question_layman($user_detail->chief_compliant_userdetail,$gender);
        // function in General Helper prepare questoin answer in layman format

        $other_detail_question_layman = $this->General->prepare_other_question_layman($user_detail->chief_compliant_userdetail);
       // $all_cc_name = $tmpx['all_cc_name'];
        $layman_summar = $tmpx['layman_summar'];
        $first_layman_summar = '';

        $first_layman_summar = "<h2>Hi ".(!empty($user_detail->user->first_name) ? $this->CryptoSecurity->decrypt(base64_decode($user_detail->user->first_name) , SEC_KEY) : "user").", here is your appointment summary: </h2><br />";

        $coming_in_for = strtolower(trim($user_detail->chief_compliant_userdetail->current_step_id->step_name)) ;

        if($user_detail->chief_compliant_userdetail->current_step_id->id == 18){

          $first_layman_summar .= "<h4>You're coming in for ".$coming_in_for.".</h4> ";
          if(!empty($user_detail->chief_compliant_userdetail->chronic_condition)){

            $first_layman_summar .= "You’re visiting Dr. <strong>".$doctor_name."</strong> at <strong>".$organization_name."</strong> for <strong>".(str_replace(['dmii','cad','copd','htn','chf'],['diabetes','coronary artery disease','chronic obstructive pulmonary disease','hypertension','congestive heart failure'],is_array($user_detail->chief_compliant_userdetail->chronic_condition) ? implode(", ", $user_detail->chief_compliant_userdetail->chronic_condition) : $user_detail->chief_compliant_userdetail->chronic_condition))."</strong>. <br />";
          }
        }
        else{

          $first_layman_summar .= "<h4>You're coming in for ".(($coming_in_for[0] == 'a' ? ' an ' : ($coming_in_for[0] == 's' ? ' ' : ' a ') ).$coming_in_for).".</h4> ";
        }


        if(!empty($user_detail->chief_compliant_userdetail->random_chief_compliant))
          $user_detail->chief_compliant_userdetail->random_chief_compliant = Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->random_chief_compliant) , SEC_KEY);

        if(!empty($all_cc_name))
        {
          // if user chooses the chief compliant from list
          $all_cc_name = rtrim($all_cc_name, ', ') ;

          $first_layman_summar .= "You’re visiting Dr. <strong>".$doctor_name."</strong> at <strong>".$organization_name."</strong> for <strong>".$all_cc_name."</strong>. <br />";

          if($user_detail->chief_compliant_userdetail->current_step_id->id != 6)
            $first_layman_summar .= "The ".$all_cc_name." started <strong>".$user_detail->chief_compliant_userdetail->compliant_length." ago.</strong><br /><br />" ;

        }
        elseif(!empty($user_detail->chief_compliant_userdetail->random_chief_compliant))
        {

          // if user not chooses chief compliant from list and enter cc text manually

          $first_layman_summar .= "You’re visiting Dr. <strong>".$doctor_name."</strong> at <strong>".$organization_name."</strong> for <strong>".(!empty($user_detail->random_chief_compliant) ? $user_detail->random_chief_compliant : '')."</strong>. <br />";

          if($user_detail->chief_compliant_userdetail->current_step_id->id != 6)
            $first_layman_summar .= "The ".(!empty($user_detail->chief_compliant_userdetail->random_chief_compliant) ? $user_detail->chief_compliant_userdetail->random_chief_compliant : '')." started <strong>".$user_detail->chief_compliant_userdetail->compliant_length." ago.</strong><br /><br />" ;

        }

        if($user_detail->chief_compliant_userdetail->current_step_id->id == 8){

          $pain_update_question_layman = $this->General->prepare_pain_update_question_layman($user_detail->chief_compliant_userdetail,$cur_cc_name);
          $pain_update_question_layman = $pain_update_question_layman['layman_summar'];

          $general_update_question_layman = $this->General->prepare_general_update_question_layman($user_detail->chief_compliant_userdetail);
          $general_update_question_layman = $general_update_question_layman['layman_summar'];

        }

        $screening_question_detail_layman = $this->General->prepare_screening_question_layman($user_detail->chief_compliant_userdetail);

        if(!empty($screening_question_detail_layman) && isset($screening_question_detail_layman['layman_summar'])){

          $screening_question_detail_layman = $screening_question_detail_layman['layman_summar'];
        }

        $post_checkup_detail_layman = $this->General->prepare_post_checkup_question_layman($user_detail->chief_compliant_userdetail);
        if(!empty($post_checkup_detail_layman) && isset($post_checkup_detail_layman['layman_summar'])){

          $post_checkup_detail_layman = $post_checkup_detail_layman['layman_summar'];
        }

        $pre_op_procedure_detail_question_layman = $this->General->prepare_pre_op_procedure_detail_question_layman($user_detail->chief_compliant_userdetail);

        if(!empty($pre_op_procedure_detail_question_layman) && isset($pre_op_procedure_detail_question_layman['layman_summar'])){

          $pre_op_procedure_detail_question_layman = $pre_op_procedure_detail_question_layman['layman_summar'];
        }

        $pre_op_medication_detail_question_layman = $this->General->prepare_pre_op_medication_detail_question_layman($user_detail->chief_compliant_userdetail);

        if(!empty($pre_op_medication_detail_question_layman) && isset($pre_op_medication_detail_question_layman['layman_summar'])){

          $pre_op_medication_detail_question_layman = $pre_op_medication_detail_question_layman['layman_summar'];
        }

        $pre_op_medical_conditions_layman = $this->General->prepare_pre_op_medical_conditions_layman($user_detail->chief_compliant_userdetail);

        if(!empty($pre_op_medical_conditions_layman)){

          if(isset($pre_op_medical_conditions_layman['not_affected']) && !empty($pre_op_medical_conditions_layman['not_affected'])){

            $pre_op_not_affected_medical_conditions_layman = "<br>You had never diagnosed with these health conditions: ";
            $pre_op_not_affected_medical_conditions_layman .= $pre_op_medical_conditions_layman['not_affected'];
            $pre_op_not_affected_medical_conditions_layman .= "<br>";
          }

          if(isset($pre_op_medical_conditions_layman['layman_summar'])){
            $pre_op_medical_conditions_layman = $pre_op_medical_conditions_layman['layman_summar'];
          }
        }

        $pre_op_alleries_conditions_layman = $this->General->prepare_pre_op_allergies_conditions_layman($user_detail->chief_compliant_userdetail);

        if(!empty($pre_op_alleries_conditions_layman)){

          if(isset($pre_op_alleries_conditions_layman['not_affected']) && !empty($pre_op_alleries_conditions_layman['not_affected'])){

            $pre_op_not_affected_alleries_conditions_layman = "<br>You are not allergic to these conditions: ";
            $pre_op_not_affected_alleries_conditions_layman .= $pre_op_alleries_conditions_layman['not_affected'];
            $pre_op_not_affected_alleries_conditions_layman .= "<br>";
          }

          if(isset($pre_op_alleries_conditions_layman['layman_summar'])){

            $pre_op_alleries_conditions_layman = $pre_op_alleries_conditions_layman['layman_summar'];
          }
        }

        $cronic_disease_layman = $this->General->prepare_chronic_illnesses_layman($user_detail->chief_compliant_userdetail);

        if(!empty($cronic_disease_layman) && isset($cronic_disease_layman['layman_summar'])){

          $cronic_disease_layman = $cronic_disease_layman['layman_summar'];
        }

        if($user_detail->chief_compliant_userdetail->current_step_id->id == 16 && isset($prev_visit_user_detail)){

              $follow_up_sx_detail_data = $this->General->prepare_follow_up_sx_layman($user_detail->chief_compliant_userdetail, $prev_visit_user_detail);
              $follow_up_sx_detail = $follow_up_sx_detail_data['layman_summar'];
          }

        $chronic_cad_layman_detail = $this->General->chronic_cad_layman($user_detail->chief_compliant_userdetail->chronic_cad_detail, $user_detail->chief_compliant_userdetail->chronic_cad_medication);
        $chronic_cad_layman = $chronic_cad_layman_detail['layman_summar'];

        $chronic_chf_layman_detail = $this->General->chronic_chf_layman($user_detail->chief_compliant_userdetail->chronic_chf_detail, $user_detail->chief_compliant_userdetail->chronic_chf_medication);
        $chronic_chf_layman = $chronic_chf_layman_detail['layman_summar'];

        $chronic_copd_layman_detail = $this->General->chronic_copd_layman($user_detail->chief_compliant_userdetail->chronic_copd_detail);
        $chronic_copd_layman = $chronic_copd_layman_detail['layman_summar'];

        $chronic_dmii_layman_detail = $this->General->chronic_dmii_layman($user_detail->chief_compliant_userdetail->chronic_dmii_detail , $user_detail->chief_compliant_userdetail->glucose_reading_detail, $user_detail->chief_compliant_userdetail->chronic_dmii_medication);
        $chronic_dmii_layman = $chronic_dmii_layman_detail['layman_summar'];


        $chronic_htn_layman_detail = $this->General->chronic_htn_layman($user_detail->chief_compliant_userdetail->chronic_htn_detail, $user_detail->chief_compliant_userdetail->bp_reading_detail, $user_detail->chief_compliant_userdetail->chronic_htn_medication);
        $chronic_htn_layman = $chronic_htn_layman_detail['layman_summar'];

        $chronic_general_detail_layman = $this->General->chronic_general_detail_layman($user_detail->chief_compliant_userdetail->chronic_general_detail);
        $chronic_general_layman = $chronic_general_detail_layman['layman_summar'];

        $chronic_asthma_layman_detail = $this->General->chronic_asthma_layman($user_detail->chief_compliant_userdetail->chronic_asthma_detail, $user_detail->chief_compliant_userdetail->peak_flow_reading_detail);
        $chronic_asthma_layman = $chronic_asthma_layman_detail['layman_summar'];

        $pre_op_post_op_detail = $this->General->pre_op_post_op_layman($user_detail->chief_compliant_userdetail->pre_op_post_op);
        $pre_op_post_op_layman = $pre_op_post_op_detail['layman_summar'];

        $general_follow_up_detail = $this->General->general_follow_up_layman($user_detail->chief_compliant_userdetail->cancer_followup_general_detail);
        $general_follow_up_detail_layman = $general_follow_up_detail['layman_summar'];


        $followup_medical_history_detail_detail = $this->General->followup_medical_history_detail_layman($user_detail->chief_compliant_userdetail->followup_medical_history_detail);
        $followup_medical_history_detail_detail_layman = $followup_medical_history_detail_detail['layman_summar'];

        $layman_summar = $first_layman_summar.''.$layman_summar.''.$other_detail_question_layman['layman_summar'].''.$general_update_question_layman.''.$pain_update_question_layman.''.$screening_question_detail_layman.''.$post_checkup_detail_layman.''.$pre_op_procedure_detail_question_layman.''.$pre_op_medication_detail_question_layman.''.$pre_op_medical_conditions_layman.''.$pre_op_alleries_conditions_layman.''.$prev_visit_layman_summar.''.$pre_visit_other_detail_question_layman.''.$prev_visit_screening_question_detail.''.$prev_visit_post_checkup_detail_layman.''.$cronic_disease_layman.''.$pre_op_not_affected_medical_conditions_layman."".$pre_op_not_affected_alleries_conditions_layman."".$follow_up_sx_detail.''.$focused_history_detail_layman.''.$covid_detail_layman.''.$phq_9_detail_layman.''.$chronic_cad_layman.''.$chronic_chf_layman.''.$chronic_copd_layman.''.$chronic_dmii_layman.''.$chronic_htn_layman.''.$chronic_asthma_layman.''.$chronic_general_layman.''.$cancer_cc_detail.''.$cancer_history_detail.''.$cancer_assessments_layman.''.$cancer_medical_detail.''.$pre_op_post_op_layman.''.$general_follow_up_detail_layman.''.$followup_medical_history_detail_detail_layman; // because $first_layman_summar  will come first when rendering

        if($user_detail->chief_compliant_userdetail->current_step_id->id == 4 && !empty($user_detail->chief_compliant_userdetail->compliant_medication_detail)){

          $length_arr =  '{"1x a day": "qd", "2x a day": "BID", "3x a day": "TID", "every 4 hours": "q4h", "every 6 hours": "q6h", "every 8 hours": "q8h", "every 12 hours": "q12h", "1x a week": "qwk", "2x a week": "2/wk", "3x a week": "3/wk", "at bedtime": "qhs", "in the morning": "qam", "as needed": "PRN"}' ;

          $length_arr = json_decode($length_arr, true);
          $length_arr = array_flip($length_arr);

            $layman_summar.= "<strong>Medication Details:- </strong></br>";
            foreach ($user_detail->chief_compliant_userdetail->compliant_medication_detail as $key => $value) {

                $layman_summar.= "Medication Name: <strong>".(isset($value['medication_name_name']) ? $value['medication_name_name'] : "")."</strong><br>";
                $layman_summar.= "Medication Dose: <strong>".(isset($value['medication_dose']) ? $value['medication_dose'] : "")."</strong><br>";
                $layman_summar.= "How Often: <strong>".(isset($value['medication_how_often']) && isset($length_arr[$value['medication_how_often']]) ? $length_arr[$value['medication_how_often']] : "")."</strong><br>";
                $layman_summar.= "How is it taken: <strong>".(isset($value['medication_how_taken']) ? $value['medication_how_taken'] : "")."</strong><br><br>";
            }
        }

        if($user_detail->chief_compliant_userdetail->current_step_id->id == 4 && !empty($user_detail->chief_compliant_userdetail->medication_side_effects)){

            $layman_summar.= "<strong>Medication side effect:- ".$user_detail->chief_compliant_userdetail->medication_side_effects."</strong></br><br>";
        }

        if($user_detail->chief_compliant_userdetail->current_step_id->id == 4 && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details) && !empty($medication_refill_extra_detail_score)){

            //$layman_summar .= "You have performed <strong>SOAPP-R, COMM, DAST-10</strong>.<br><br>";
          if(!empty($medication_refill_extra_detail_score['soapp_description'])){

              $layman_summar .= "<strong>SOAPP-R Details:- </strong><br>".$medication_refill_extra_detail_score['soapp_description'].'<br>';
          }

          if(!empty($medication_refill_extra_detail_score['comm_description'])){

              $layman_summar .= "<strong>COMM Details:- </strong><br>".$medication_refill_extra_detail_score['comm_description'].'<br>';
          }

          if(!empty($medication_refill_extra_detail_score['dast_description'])){

            $layman_summar .= "<strong>DAST-10 Details:- </strong><br>".$medication_refill_extra_detail_score['dast_description'].'<br>';
          }

          if(!empty($medication_refill_extra_detail_score['padt_description'])){

            $layman_summar .= "<strong>PADT Details:- </strong><br>".$medication_refill_extra_detail_score['padt_description'].'<br>';
          }

          }






         // pr($user_detail->chief_compliant_userdetail);die;

        if(!empty($user_detail->chief_compliant_userdetail->python_file_option_3rd_tab))
        {
          // $python_file_option_3rd_tab = unserialize(base64_decode($user_detail->chief_compliant_userdetail->python_file_option_3rd_tab));
          $python_file_option_3rd_tab = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->python_file_option_3rd_tab), SEC_KEY) ));

          $positive_symptom = "";
          $negative_symptom = "";


          if(!empty($user_detail->chief_compliant_userdetail->compliant_symptom_ids)){

            foreach ($user_detail->chief_compliant_userdetail->compliant_symptom_ids as $key => $value) {

              $positive_symptom .= $value->name;

            }
          }
          $positive_symptom = !empty($positive_symptom)? $positive_symptom.', ' : '' ;


          if(!empty($user_detail->chief_compliant_userdetail->symptom_from_tab1)){
            // $tsym  = unserialize(base64_decode($user_detail->chief_compliant_userdetail->symptom_from_tab1));
            $tsym  = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->symptom_from_tab1), SEC_KEY)));

            $tsym = implode(', ', $tsym) ;
            $positive_symptom .=  $tsym ;
          }

          $positive_symptom = !empty($positive_symptom)? $positive_symptom.', ' : '' ;



            if( isset($python_file_option_3rd_tab[1]) && is_array($python_file_option_3rd_tab[1])){
              foreach ($python_file_option_3rd_tab[1] as $key => $value) {
                $positive_symptom .= $value['layman'].', ';
              }

            }

            if(!empty($positive_symptom)){
                  $positive_symptom = rtrim($positive_symptom, ', ') ;
              $layman_summar .= "<br />You also have other symptoms including <strong>".$positive_symptom.".</strong><br />";
            }



            if( isset($python_file_option_3rd_tab[0]) && is_array($python_file_option_3rd_tab[0])){
              foreach ($python_file_option_3rd_tab[0] as $key => $value) {
                $negative_symptom .= $value['layman'].', ';
              }
              $negative_symptom = rtrim($negative_symptom, ', ') ;
              $layman_summar .= "<br />You do not have <strong>".$negative_symptom.".</strong><br />" ;
            }
          }

          $positive_symptom = "";
          $questionnaire_symptom = "";
          if( isset($user_detail->chief_compliant_userdetail->questionnaire_detail[1]) && is_array($user_detail->chief_compliant_userdetail->questionnaire_detail[1]))
          {

            foreach ($user_detail->chief_compliant_userdetail->questionnaire_detail[1] as $key => $value) {
              $positive_symptom .= $value->questionnaire_text.', ';
            }
            $positive_symptom = rtrim($positive_symptom, ', ') ;
            $questionnaire_symptom = "<br />In your general health questionnaire, you also noticed <strong>".$positive_symptom."</strong><br />";
            $layman_summar .= $questionnaire_symptom;
          }

        //Your medical history was last updated on 10/19/2018 03:54
        $layman_summar .= "<br />Your <strong>medical history</strong> was last updated on ".(!is_null($user_detail->user->medical_history_update_date) ? $user_detail->user->medical_history_update_date->i18nFormat('MM/dd/yyyy') : '').".<br />";

        echo "<div style='font-size: 18px; '>".$layman_summar."</div>" ;


        // preparing layman summary end **************

      ?>
    </div>
</div>
