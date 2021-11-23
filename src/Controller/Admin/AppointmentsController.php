<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\Utility\Security;

class AppointmentsController extends AppController
{

    public function initialize()
    {
    	parent::initialize();
      	$this->loadComponent('Paginator');
    }


    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $organizations = $this->Appointments->find('all')->contain(['Doctors', 'Organizations', 'Specializations', 'Users'])->where(['Appointments.is_shown' => 1,'Doctors.is_shown' =>1,'Organizations.is_shown' =>1,'Users.is_shown' =>1])->order(['Appointments.id' => 'DESC']);

        if($this->request->is(['post', 'put'])){

            $start_date = $this->request->getData('start_date');
            $end_date =  $this->request->getData('end_date');

            $apt_cond = array();

            if(!empty($start_date)){

	            $filter_start_date = Time::createFromFormat(
	                'm-d-Y', // 'd-m-Y'
	                $start_date
	            );
            	$apt_cond[] = array(' Appointments.created >=' => $filter_start_date);
            }
           if(!empty($end_date)){

	            $filter_end_date = Time::createFromFormat(
	                'm-d-Y', // 'd-m-Y'
	                $end_date
	            );
               $apt_cond[] = array(' Appointments.created <=' => $filter_end_date);
            }

            $apt_cond[] = array('Appointments.is_shown' => 1);
  			$organizations = $this->Appointments->find('all')->contain(['Doctors', 'Organizations', 'Specializations', 'Users'])->where($apt_cond);
        }
        $this->set(compact('organizations', 'filter_start_date', 'filter_end_date'));
    }


    public function view($id = null){

        $this->viewBuilder()->setLayout('admin');
        $user_detail = $this->Appointments->find('all')->contain(['Doctors', 'Organizations', 'Specializations', 'Users', 'ChiefCompliantUserdetails'])->where(['Appointments.is_shown' => 1, 'Appointments.id' => $id])->first();

        $this->loadModel('StepDetails');
        $this->loadModel('ChiefCompliants');
        $this->loadModel('ChiefCompliantQuestionnaire');
        $this->loadModel('ChiefCompliantDetails');
        $this->loadModel('ChiefCompliantMedication');
        $this->loadModel('ChiefCompliantOtherDetails');
        $this->loadModel('PainFollowupQuestionnaires');
        $this->loadModel('CommonQuestions');
        $this->loadModel('CommonConditions');
        $this->loadModel('Diseases');
        $this->loadModel('Symptoms');

        if(!empty($user_detail->chief_compliant_userdetail)){

            if(isset($user_detail->chief_compliant_userdetail->current_step_id) && !empty($user_detail->chief_compliant_userdetail->current_step_id)){

                $user_detail->chief_compliant_userdetail->current_step_id = $this->StepDetails->find('all')->where(['id' => $user_detail->chief_compliant_userdetail->current_step_id])->first();

            }

            if(isset($user_detail->chief_compliant_userdetail->chief_compliant_id) && !empty($user_detail->chief_compliant_userdetail->chief_compliant_id))

            {
                $user_detail->chief_compliant_userdetail->chief_compliant_id = Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->chief_compliant_id), SEC_KEY);
            }

            if(isset($user_detail->chief_compliant_userdetail->chief_compliant_id) && !empty($user_detail->chief_compliant_userdetail->chief_compliant_id))
            {

                $user_detail->chief_compliant_userdetail->chief_compliant_id = $this->ChiefCompliants->find('all')->where(['id' => $user_detail->chief_compliant_userdetail->chief_compliant_id])->first();
            }

            if(isset($user_detail->chief_compliant_userdetail->compliant_symptom_ids) && !empty($user_detail->chief_compliant_userdetail->compliant_symptom_ids))
            {
                $user_detail->chief_compliant_userdetail->compliant_symptom_ids = explode(',', $user_detail->chief_compliant_userdetail->compliant_symptom_ids);

                $user_detail->chief_compliant_userdetail->compliant_symptom_ids =  $this->ChiefCompliants->find('all')->where(['id IN' => $user_detail->chief_compliant_userdetail->compliant_symptom_ids])->all();
            }

            if(isset($user_detail->chief_compliant_userdetail->compliant_length) && !empty($user_detail->chief_compliant_userdetail->compliant_length))
            {
                $user_detail->chief_compliant_userdetail->compliant_length = $user_detail->chief_compliant_userdetail->compliant_length;
            }

            if(isset($user_detail->chief_compliant_userdetail->compliant_medication_detail) && !empty($user_detail->chief_compliant_userdetail->compliant_medication_detail))
            {

                $user_detail->chief_compliant_userdetail->compliant_medication_detail = unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->compliant_medication_detail), SEC_KEY)) ;
            }

            if(isset($user_detail->chief_compliant_userdetail->chief_compliant_symptoms) && !empty($user_detail->chief_compliant_userdetail->chief_compliant_symptoms))
            {

                $user_detail->chief_compliant_userdetail->chief_compliant_symptoms = unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->chief_compliant_symptoms), SEC_KEY)) ;

                foreach($user_detail->chief_compliant_userdetail->chief_compliant_symptoms as $key => $value)
                {

                    foreach($value as $k =>$v)
                    {
                        $user_detail->chief_compliant_userdetail->chief_compliant_symptoms[$key][$k] = $this->ChiefCompliants->find('all')->where(['id' => $v])->first();
                    }

                }
            }

            if(isset($user_detail->chief_compliant_userdetail->questionnaire_detail) && !empty($user_detail->chief_compliant_userdetail->questionnaire_detail))
            {

                $user_detail->chief_compliant_userdetail->questionnaire_detail = unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->questionnaire_detail), SEC_KEY)) ;

                foreach($user_detail->chief_compliant_userdetail->questionnaire_detail as $key => $value)
                {

                    foreach($value as $k =>$v)
                    {
                        $user_detail->chief_compliant_userdetail->questionnaire_detail[$key][$k] = $this->ChiefCompliantQuestionnaire->find('all')->where(['id' => $v])->first();
                    }

                }

            }

            if(isset($user_detail->chief_compliant_userdetail->chief_compliant_details) && !empty($user_detail->chief_compliant_userdetail->chief_compliant_details))
            {

                $user_detail->chief_compliant_userdetail->chief_compliant_details = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->chief_compliant_details), SEC_KEY))) ;
                $tempar = array();
                $more_options  = array();
                foreach ($user_detail->chief_compliant_userdetail->chief_compliant_details as $key => $value)
                {
                    $i = 0 ;
                    foreach ($value as $k => $v)
                    {
                        if(!is_numeric($k) && $k == 'more_option'){
                            $more_options[$key] = $v ;
                            unset($value['more_option']);
                            continue;
                        }
                        $temp = $this->ChiefCompliantDetails->find('all')->where(['id'=> $k ])->first();
                        $tempcc = $this->ChiefCompliants->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['cc_data'] = $tempcc ;
                        $tempar[$key][$i]['question_id'] = $temp->id ;
                        $tempar[$key][$i]['question'] = $temp->question ;
                        $tempar[$key][$i]['answer'] = $v ;
                        $i++;
                    }

                }

                $user_detail->chief_compliant_userdetail->more_options = $more_options ;
                $user_detail->chief_compliant_userdetail->chief_compliant_details = $tempar ;
            }

            if(isset($user_detail->chief_compliant_userdetail->chief_compliant_other_details) && !empty($user_detail->chief_compliant_userdetail->chief_compliant_other_details))
            {

                $user_detail->chief_compliant_userdetail->chief_compliant_other_details = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->chief_compliant_other_details), SEC_KEY))) ;

                $tempar = array();
                $i = 0;
                foreach ($user_detail->chief_compliant_userdetail->chief_compliant_other_details as $key => $value)
                {
                  $temp = $this->ChiefCompliantOtherDetails->find('all')->where(['id'=> $key ])->first();
                  $tempar[$i]['question_id'] = $temp->id ;
                  $tempar[$i]['question'] = $temp->question ;
                  $tempar[$i]['answer'] = $value ;
                  $i++;
                }
                $user_detail->chief_compliant_userdetail->chief_compliant_other_details = $tempar;

            }

            if(isset($user_detail->chief_compliant_userdetail->other_questions_treatment_detail) && !empty($user_detail->chief_compliant_userdetail->other_questions_treatment_detail))
            {
                $user_detail->chief_compliant_userdetail->other_questions_treatment_detail =@unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->other_questions_treatment_detail) , SEC_KEY));
            }

            if(isset($user_detail->chief_compliant_userdetail->pain_update_question) && !empty($user_detail->chief_compliant_userdetail->pain_update_question))
            {

                $user_detail->chief_compliant_userdetail->pain_update_question = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->pain_update_question), SEC_KEY))) ;
                $tempar = array();
                $i = 0;
                foreach ($user_detail->chief_compliant_userdetail->pain_update_question as $key => $value)
                {
                  $temp = $this->PainFollowupQuestionnaires->find('all')->where(['id'=> $key ])->first();
                  $tempar[$i]['question_id'] = $temp->id ;
                  $tempar[$i]['question'] = $temp->question ;
                  $tempar[$i]['answer'] = $value ;
                  $i++;
                }
                $user_detail->chief_compliant_userdetail->pain_update_question = $tempar;

            }

            if(isset($user_detail->chief_compliant_userdetail->general_update_question) && !empty($user_detail->chief_compliant_userdetail->general_update_question))
            {

                $user_detail->chief_compliant_userdetail->general_update_question = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->general_update_question), SEC_KEY))) ;
                $tempar = array();
                $i = 0;
                foreach ($user_detail->chief_compliant_userdetail->general_update_question as $key => $value)
                {

                  $temp = $this->PainFollowupQuestionnaires->find('all')->where(['id'=> $key ])->first();
                  $tempar[$i]['question_id'] = $temp->id ;
                  $tempar[$i]['question'] = $temp->question ;
                  $tempar[$i]['answer'] = $value ;
                  $i++;
                }
                $user_detail->chief_compliant_userdetail->general_update_question = $tempar;

            }

            if(isset($user_detail->chief_compliant_userdetail->post_checkup_question_detail) && !empty($user_detail->chief_compliant_userdetail->post_checkup_question_detail))
            {

               $user_detail->chief_compliant_userdetail->post_checkup_question_detail = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->post_checkup_question_detail), SEC_KEY)));
               if(!empty($user_detail->chief_compliant_userdetail->post_checkup_question_detail)){

                    $i = 0;
                  foreach($user_detail->chief_compliant_userdetail->post_checkup_question_detail as $key => $val){


                      $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                      $tempar[$i]['question_id'] = $temp->id ;
                      $tempar[$i]['question'] = $temp->question ;
                      $tempar[$i]['answer'] = $val;
                      $i++;

                  }
                  $user_detail->chief_compliant_userdetail->post_checkup_question_detail = $tempar;
               }
            }


            if(isset($user_detail->chief_compliant_userdetail->screening_questions_detail) && !empty($user_detail->chief_compliant_userdetail->screening_questions_detail))
            {

                $user_detail->chief_compliant_userdetail->screening_questions_detail = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->screening_questions_detail), SEC_KEY)));

               if(!empty($user_detail->chief_compliant_userdetail->screening_questions_detail)){

                  $i = 0;
                  foreach($user_detail->chief_compliant_userdetail->screening_questions_detail as $key => $val){


                      $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                      $tempar[$i]['question_id'] = $temp->id ;
                      $tempar[$i]['question'] = $temp->question ;
                      $tempar[$i]['answer'] = $val;
                      $i++;

                  }

                 $user_detail->chief_compliant_userdetail->screening_questions_detail = $tempar;
               }
            }

            if(isset($user_detail->chief_compliant_userdetail->pre_op_procedure_detail) && !empty($user_detail->chief_compliant_userdetail->pre_op_procedure_detail))
            {

                $user_detail->chief_compliant_userdetail->pre_op_procedure_detail = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->pre_op_procedure_detail), SEC_KEY)));
               if(!empty($user_detail->chief_compliant_userdetail->pre_op_procedure_detail)){

                  $i = 0;
                  foreach($user_detail->chief_compliant_userdetail->pre_op_procedure_detail as $key => $val){


                      $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                      $tempar[$i]['question_id'] = $temp->id ;
                      $tempar[$i]['question'] = $temp->question ;
                      $tempar[$i]['answer'] = $val;
                      $i++;

                  }

                 $user_detail->chief_compliant_userdetail->pre_op_procedure_detail = $tempar;
               }
            }


            if(isset($user_detail->chief_compliant_userdetail->pre_op_medications_question_detail) && !empty($user_detail->chief_compliant_userdetail->pre_op_medications_question_detail))
            {

                $user_detail->chief_compliant_userdetail->pre_op_medications_question_detail = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->pre_op_medications_question_detail), SEC_KEY)));
               if(!empty($user_detail->chief_compliant_userdetail->pre_op_medications_question_detail)){

                  $i = 0;
                  foreach($user_detail->chief_compliant_userdetail->pre_op_medications_question_detail as $key => $val){


                      $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                      $tempar[$i]['question_id'] = $temp->id ;
                      $tempar[$i]['question'] = $temp->question ;
                      $tempar[$i]['answer'] = $val;
                      $i++;

                  }

                 $user_detail->chief_compliant_userdetail->pre_op_medications_question_detail = $tempar;
               }
            }



             if(isset($user_detail->chief_compliant_userdetail->pre_op_allergies_detail) && !empty($user_detail->chief_compliant_userdetail->pre_op_allergies_detail))
            {

              $user_detail->chief_compliant_userdetail->pre_op_allergies_detail = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->pre_op_allergies_detail), SEC_KEY))) ;
              $tempar = array();
              $i = 0;
              foreach ($user_detail->chief_compliant_userdetail->pre_op_allergies_detail as $key => $value)
              {


                $temp = $this->CommonConditions->find('all')->where(['id'=> $key ])->first();
                $tempar[$i]['condition_id'] = $temp->id ;
                $tempar[$i]['condition_name'] = $temp->name ;
                $tempar[$i]['medical_name'] = $temp->medical_name ;
                $tempar[$i]['answer'] = $value['name'] ;
                $tempar[$i]['reaction'] = $value['reaction'] ;
                $i++;
              }
              $user_detail->chief_compliant_userdetail->pre_op_allergies_detail = $tempar;

            }


            if(isset($user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail) && !empty($user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail))
            {

              $user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail), SEC_KEY))) ;
              $tempar = array();
              $i = 0;
              foreach ($user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail as $key => $value)
              {


                $temp = $this->CommonConditions->find('all')->where(['id'=> $key ])->first();
                $tempar[$i]['condition_id'] = $temp->id ;
                $tempar[$i]['condition_name'] = $temp->name ;
                $tempar[$i]['medical_name'] = $temp->medical_name ;
                $tempar[$i]['answer'] = $value['name'] ;
                $tempar[$i]['year'] = $value['year'] ;
                $i++;
              }
              $user_detail->chief_compliant_userdetail->pre_op_medical_condition_detail = $tempar;

            }

            if(isset($user_detail->chief_compliant_userdetail->general_update_provider_info) && !empty($user_detail->chief_compliant_userdetail->general_update_provider_info))
            {

                $user_detail->chief_compliant_userdetail->general_update_provider_info =  unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->general_update_provider_info), SEC_KEY))) ;
            }

            if(isset($user_detail->chief_compliant_userdetail->general_update_procedure_detail) && !empty($user_detail->chief_compliant_userdetail->general_update_procedure_detail))
            {

                $user_detail->chief_compliant_userdetail->general_update_procedure_detail =  unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->general_update_procedure_detail), SEC_KEY))) ;
            }

            if(isset($user_detail->chief_compliant_userdetail->disease_name) && !empty($user_detail->chief_compliant_userdetail->disease_name))
            {

                $user_detail->chief_compliant_userdetail->disease_name = explode(",",  Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->disease_name), SEC_KEY));

                if(!empty($user_detail->chief_compliant_userdetail->disease_name)){

                    foreach ($user_detail->chief_compliant_userdetail->disease_name as $key => $value) {

                        $disease = $this->Diseases->find('all')->where(['id'=> $value])->first();

                        if(!empty($disease)){

                          $user_detail->chief_compliant_userdetail->disease_name[$key] = $disease->name;
                        }else{

                          $user_detail->chief_compliant_userdetail->disease_name[$key] = "";
                        }
                    }

                    $user_detail->chief_compliant_userdetail->disease_name = array_filter($user_detail->chief_compliant_userdetail->disease_name);

                    $user_detail->chief_compliant_userdetail->disease_name =  implode(", ", $user_detail->chief_compliant_userdetail->disease_name);
                }

            }


            if(isset($user_detail->chief_compliant_userdetail->disease_questions_detail) && !empty($user_detail->chief_compliant_userdetail->disease_questions_detail)){

              $user_detail->chief_compliant_userdetail->disease_questions_detail =  unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->disease_questions_detail), SEC_KEY))) ;

              if(!empty($user_detail->chief_compliant_userdetail->disease_questions_detail)){

                $temparr = array();

                foreach ($user_detail->chief_compliant_userdetail->disease_questions_detail as $key => $value) {

                  $disease = $this->Diseases->find('all')->where(['id'=> $key])->first();
                  if(!empty($disease)){


                   $user_detail->chief_compliant_userdetail->disease_questions_detail[$key]['disease'] =  $disease;
                  }

                  //set question details
                  if(!empty($value['disease_detail_question'])){

                    $temparr = array();
                    $i = 0;
                    foreach ($value['disease_detail_question'] as $q_key => $que) {

                      $question = $this->CommonQuestions->find('all')->where(['id' => $q_key])->first();

                      if(!empty($question)){

                        $temparr[$i]['question_id'] = $question->id ;
                        $temparr[$i]['question'] = $question->question ;
                        $temparr[$i]['answer'] = $que ;
                        $i++;
                      }

                    }

                    $user_detail->chief_compliant_userdetail->disease_questions_detail[$key]['disease_detail_question'] = $temparr;
                  }

                  //set detail of alarm sysmptoms
                  if(!empty($value['alarm_sysmptom'])){

                    $temparr = array();
                    $i = 0;

                    foreach ($value['alarm_sysmptom'] as $asysmpt_key => $asysmpt_value) {

                      $alarm_sysmptom = $this->Symptoms->find('all')->where(['id'=> $asysmpt_key])->first();

                      if(!empty($alarm_sysmptom)){

                        $temparr[$i]['id'] = $alarm_sysmptom->id;
                        $temparr[$i]['name'] = $alarm_sysmptom->symptom;
                        $temparr[$i]['medical_name'] = $alarm_sysmptom->medical_name;
                        $temparr[$i]['answer'] = $asysmpt_value['answer'];
                        $i++;

                      }
                    }

                      $user_detail->chief_compliant_userdetail->disease_questions_detail[$key]['alarm_sysmptom'] = $temparr;
                  }

                  //set detail of base line sysmptoms
                  if(!empty($value['baseline_sysmptom'])){

                    $temparr = array();
                    $i = 0;

                    foreach ($value['baseline_sysmptom'] as $bsysmpt_key => $bsysmpt_value) {

                      $baseline_sysmptom = $this->Symptoms->find('all')->where(['id'=> $bsysmpt_key])->first();

                      if(!empty($baseline_sysmptom)){

                        $temparr[$i]['id'] = $baseline_sysmptom->id;
                        $temparr[$i]['name'] = $baseline_sysmptom->symptom;
                        $temparr[$i]['medical_name'] = $baseline_sysmptom->medical_name;
                        $temparr[$i]['answer'] = $bsysmpt_value['answer'];
                        $temparr[$i]['scale'] = $bsysmpt_value['scale'];
                        $i++;

                      }
                    }

                      $user_detail->chief_compliant_userdetail->disease_questions_detail[$key]['baseline_sysmptom'] = $temparr;
                  }
                }
              }
            }

            if(!empty($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details))
            {
              $user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details), SEC_KEY)));

              if(isset($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['soapp']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['soapp'])){
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['soapp'] as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ;
                        $tempar[$key]['question'] = $temp->question ;
                        $tempar[$key]['answer'] = $val;
                       // $i++;
                    }

                    $user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['soapp'] = $tempar;
                 }

                 if(isset($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['comm']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['comm'])){
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['comm'] as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ;
                        $tempar[$key]['question'] = $temp->question ;
                        $tempar[$key]['answer'] = $val;
                       // $i++;

                    }

                    $user_detail->chief_compliant_userdetail->medication_refill_comm_soapp_details['comm'] = $tempar;
                 }
            }

            if(!empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details))
            {

                 $user_detail->chief_compliant_userdetail->medication_refill_extra_details = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->medication_refill_extra_details), SEC_KEY)));

                 if(isset($user_detail->chief_compliant_userdetail->medication_refill_extra_details['soapp']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details['soapp'])){
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->medication_refill_extra_details['soapp'] as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ;
                        $tempar[$key]['question'] = $temp->question ;
                        $tempar[$key]['answer'] = $val;
                       // $i++;
                    }

                    $user_detail->chief_compliant_userdetail->medication_refill_extra_details['soapp'] = $tempar;
                 }

                 if(isset($user_detail->chief_compliant_userdetail->medication_refill_extra_details['comm']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details['comm'])){
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->medication_refill_extra_details['comm'] as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ;
                        $tempar[$key]['question'] = $temp->question ;
                        $tempar[$key]['answer'] = $val;
                       // $i++;

                    }

                    $user_detail->chief_compliant_userdetail->medication_refill_extra_details['comm'] = $tempar;
                 }

                 if(isset($user_detail->chief_compliant_userdetail->medication_refill_extra_details['dast']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details['dast'])){
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->medication_refill_extra_details['dast'] as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ;
                        $tempar[$key]['question'] = $temp->question ;
                        $tempar[$key]['answer'] = $val;
                       // $i++;

                    }
                    $user_detail->chief_compliant_userdetail->medication_refill_extra_details['dast'] = $tempar;
                 }

                 if(isset($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt']) && !empty($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt'])){
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt'] as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ;
                        $tempar[$key]['question'] = $temp->question ;
                        $tempar[$key]['answer'] = $val;
                       // $i++;
                    }

                    $user_detail->chief_compliant_userdetail->medication_refill_extra_details['padt'] = $tempar;
                 }
               }
               // Pain Management
               if(isset($user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb) && !empty($user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb)){

                  $user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb), SEC_KEY)));
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ; 
                        $tempar[$key]['question'] = $temp->question ; 
                        $tempar[$key]['answer'] = $val;
                       // $i++;                      
                    }
                    $user_detail->chief_compliant_userdetail->chronic_pain_assessment_tmb = $tempar;                    
                 }

                 if(isset($user_detail->chief_compliant_userdetail->chronic_pain_assessment_pmh) && !empty($user_detail->chief_compliant_userdetail->chronic_pain_assessment_pmh))
                  {
                    $user_detail->chief_compliant_userdetail->chronic_pain_assessment_pmh = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->chronic_pain_assessment_pmh), SEC_KEY))) ;

                    $tempar = array();
                    $i = 0;                   
                    foreach ($user_detail->chief_compliant_userdetail->chronic_pain_assessment_pmh as $key => $value)
                    {
                      $temp = $this->CommonConditions->find('all')->where(['id'=> $key ])->first();            
                      $tempar[$i]['condition_id'] = $temp->id ;
                      $tempar[$i]['condition_name'] = $temp->name ;
                      $tempar[$i]['medical_name'] = $temp->medical_name ;
                      $tempar[$i]['date'] = $value;            
                      $i++;
                    }                    
                    $user_detail->chief_compliant_userdetail->chronic_pain_assessment_pmh = $tempar;
                  }


                  if(!empty($user_detail->chief_compliant_userdetail->chronic_pain_treatment_history)){

                      $user_detail->chief_compliant_userdetail->chronic_pain_treatment_history = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->chronic_pain_treatment_history), SEC_KEY));            
                       $tempar = array();
                      foreach($user_detail->chief_compliant_userdetail->chronic_pain_treatment_history as $key => $value){

                          if(!empty($value)){

                            $temp = $this->CommonQuestions->find('all')->where(['id'=> $key])->first();
                            $tempar[$key]['question_id'] = $temp->id ;
                            $tempar[$key]['question'] = $temp->question ;
                            $tempar[$key]['answer'] = $value;
                          }
                        }
                        $user_detail->chief_compliant_userdetail->chronic_pain_treatment_history = $tempar;            
                  }


                  if(!empty($user_detail->chronic_pain_curr_treat_history)){

                    $user_detail->chronic_pain_curr_treat_history = unserialize(Security::decrypt( base64_decode($user_detail->chronic_pain_curr_treat_history), SEC_KEY));            
                     $tempar = array();
                    foreach($user_detail->chronic_pain_curr_treat_history as $key => $value){

                        if(!empty($value)){

                          $temp = $this->ChiefCompliantMedication->find('all')->where(['id'=> $key])->first();                  
                          $tempar[$key]['layman_name'] = $temp->layman_name ;                  
                          $tempar[$key]['answer'] = $value;
                        }
                      }
                      $user_detail->chronic_pain_curr_treat_history = $tempar;            
                }


                if(!empty($user_detail->chronic_pain_past_treat_history)){

                    $user_detail->chronic_pain_past_treat_history = unserialize(Security::decrypt( base64_decode($user_detail->chronic_pain_past_treat_history), SEC_KEY));            
                     $tempar = array();
                    foreach($user_detail->chronic_pain_past_treat_history as $key => $value){

                        if(!empty($value)){

                          $temp = $this->ChiefCompliantMedication->find('all')->where(['id'=> $key])->first();                  
                          $tempar[$key]['layman_name'] = $temp->layman_name ;                  
                          $tempar[$key]['answer'] = $value;
                        }
                      }
                      $user_detail->chronic_pain_past_treat_history = $tempar;            
                }


                 if(isset($user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk) && !empty($user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk)){

                  $user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk), SEC_KEY)));
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ; 
                        $tempar[$key]['question'] = $temp->question ; 
                        $tempar[$key]['answer'] = $val;
                       // $i++;                      
                    }
                    $user_detail->chief_compliant_userdetail->chronic_pain_opioid_overdose_risk = $tempar;                    
                 }

                if(isset($user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort) && !empty($user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort)){

                  $user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort), SEC_KEY)));
                    $tempar = array();
                    foreach($user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort as $key => $val)
                    {
                        $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                        $tempar[$key]['question_id'] = $temp->id ; 
                        $tempar[$key]['question'] = $temp->question ; 
                        $tempar[$key]['answer'] = $val;
                       // $i++;                      
                    }
                    $user_detail->chief_compliant_userdetail->chronic_pain_assessment_ort = $tempar;                    
                 }

               // End Pain Management

              if(!empty($user_detail->chief_compliant_userdetail->cancer_cc_detail)){
                $user_detail->chief_compliant_userdetail->cancer_cc_detail = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->cancer_cc_detail), SEC_KEY));
                $tempar = array();
                foreach($user_detail->chief_compliant_userdetail->cancer_cc_detail as $key => $value){
                    if(!empty($value)){

                      $temp = $this->CommonQuestions->find('all')->where(['id'=> $key])->first();
                      $tempar[$key]['question_id'] = $temp->id ;
                      $tempar[$key]['question'] = $temp->question ;
                      $tempar[$key]['answer'] = $value;
                    }
                  }
                  $user_detail->chief_compliant_userdetail->cancer_cc_detail = $tempar;
              }

            if(!empty($user_detail->chief_compliant_userdetail->cancer_history_detail))
            {
              $user_detail->chief_compliant_userdetail->cancer_history_detail = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->cancer_history_detail), SEC_KEY))  ;

              $tempar = array();
              foreach($user_detail->chief_compliant_userdetail->cancer_history_detail as $key => $value){

                  if(!empty($value) && is_array($value)){

                    $i = 0;
                    foreach ($value as $k => $v) {
                      $temp = $this->CommonQuestions->find('all')->where(['id'=> $k])->first();
                      $tempar[$key][$i]['question_id'] = $temp->id ;
                      $tempar[$key][$i]['question'] = $temp->question ;
                      $tempar[$key][$i]['answer'] = $v;
                      $i++;
                    }
                  }
                }
                $user_detail->chief_compliant_userdetail->cancer_history_detail = $tempar;
            }

            if(!empty($user_detail->chief_compliant_userdetail->cancer_family_members))
            {
              $user_detail->chief_compliant_userdetail->cancer_family_members = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->cancer_family_members), SEC_KEY))  ;
            }

            if(!empty($user_detail->chief_compliant_userdetail->family_members_cancer_disease_detail))
            {
              $user_detail->chief_compliant_userdetail->family_members_cancer_disease_detail = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->family_members_cancer_disease_detail), SEC_KEY))  ;
            }

            if(!empty($user_detail->chief_compliant_userdetail->cancer_medical_detail))
            {
              $i = 0;
              $user_detail->chief_compliant_userdetail->cancer_medical_detail = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->cancer_medical_detail), SEC_KEY))  ;

              $tempar = array();
               $i = 0;
              foreach($user_detail->chief_compliant_userdetail->cancer_medical_detail as $key => $value){

                  if(!empty($value)){

                    $temp = $this->CommonQuestions->find('all')->where(['id'=> $key])->first();
                    $tempar[$i]['question_id'] = $temp->id ;
                    $tempar[$i]['question'] = $temp->question ;
                    $tempar[$i]['answer'] = $value;
                    $i++;
                  }
                }
                $user_detail->chief_compliant_userdetail->cancer_medical_detail = $tempar;
            }


            if(!empty($user_detail->chief_compliant_userdetail->cancer_assessments))
            {
             $user_detail->chief_compliant_userdetail->cancer_assessments = unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->cancer_assessments), SEC_KEY))  ;
              //pr($user_detail->chief_compliant_userdetail->cancer_assessments);die;
              $assessment_history = array();
              $life_assessment = array();
              $chemo_assessment = array();

              if(!empty($user_detail->chief_compliant_userdetail->cancer_assessments['assessment_history']))
              {
                $i = 0;
              foreach($user_detail->chief_compliant_userdetail->cancer_assessments['assessment_history'] as $key => $value){

                  if(!empty($value)){

                    $temp = $this->CommonConditions->find('all')->where(['id'=> $key])->first();
                    $assessment_history[$i]['symtoms_id'] = $temp->id ;
                    $assessment_history[$i]['name'] = $temp->name ;
                    $assessment_history[$i]['answer'] = $value;
                    $i++;
                  }
                }
              }

              if(!empty($user_detail->chief_compliant_userdetail->cancer_assessments['life_assessment']))
              {
                $j = 0;
              foreach($user_detail->chief_compliant_userdetail->cancer_assessments['life_assessment'] as $key => $value){

                  if(!empty($value)){

                    $temp = $this->CommonConditions->find('all')->where(['id'=> $key])->first();
                    $life_assessment[$j]['symtoms_id'] = $temp->id ;
                    $life_assessment[$j]['name'] = $temp->name ;
                    $life_assessment[$j]['answer'] = $value;
                    $j++;
                  }
                }
               }

              if(!empty($user_detail->chief_compliant_userdetail->cancer_assessments['chemo_assessment']))
              {
                $j = 0;
              foreach($user_detail->chief_compliant_userdetail->cancer_assessments['chemo_assessment'] as $key => $value){

                  if(!empty($value)){

                    $temp = $this->CommonConditions->find('all')->where(['id'=> $key])->first();
                    $chemo_assessment[$j]['symtoms_id'] = $temp->id ;
                    $chemo_assessment[$j]['name'] = $temp->name ;
                    $chemo_assessment[$j]['answer'] = $value;
                    $j++;
                  }
                }
               }

               $cancer_assessments = array('assessment_history' => $assessment_history,'life_assessment' => $life_assessment,'chemo_assessment' => $chemo_assessment);

              // pr($cancer_assessments);die;
                  if(!empty($cancer_assessments))
                  {
                    $user_detail->chief_compliant_userdetail->cancer_assessments = $cancer_assessments;
                  }
            }

            if(!empty($user_detail->chief_compliant_userdetail->cancer_followup_general_detail))
            {
              $user_detail->chief_compliant_userdetail->cancer_followup_general_detail = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->cancer_followup_general_detail), SEC_KEY))  ;

              $tempar = array();
               $i = 0;
              foreach($user_detail->chief_compliant_userdetail->cancer_followup_general_detail as $key => $value){

                  if(!empty($value)){
                    $temp = $this->CommonQuestions->find('all')->where(['id'=> $key])->first();
                    $tempar[$i]['question_id'] = $temp->id ;
                    $tempar[$i]['question'] = $temp->question ;
                    $tempar[$i]['answer'] = $value;
                    $i++;
                  }
                }
                $user_detail->chief_compliant_userdetail->cancer_followup_general_detail = $tempar;
            }


            if(!empty($user_detail->chief_compliant_userdetail->followup_medical_history_detail ))
            {
              $user_detail->chief_compliant_userdetail->followup_medical_history_detail  = unserialize(Security::decrypt( base64_decode($user_detail->chief_compliant_userdetail->followup_medical_history_detail), SEC_KEY));

              $tempar = array();
              $i = 0;
              foreach($user_detail->chief_compliant_userdetail->followup_medical_history_detail['followup_medical_history_detail'] as $key => $value){

                  if(!empty($value)){
                    $temp = $this->CommonQuestions->find('all')->where(['id'=> $key])->first();
                    $tempar[$i]['question_id'] = $temp->id ;
                    $tempar[$i]['question'] = $temp->question ;
                    $tempar[$i]['answer'] = $value;
                    $i++;
                  }
                }


                if(!empty($tempar))
                {
                  $tempar['followup_medical_history_detail'] = $tempar;
                }
                if(!empty($user_detail->chief_compliant_userdetail->followup_medical_history_detail['medical_history']))
                {
                  $tempar['medical_history'] = $user_detail->chief_compliant_userdetail->followup_medical_history_detail['medical_history'];
                }
                if(!empty($user_detail->chief_compliant_userdetail->followup_medical_history_detail['surgical_history']))
                {
                  $tempar['surgical_history'] = $user_detail->chief_compliant_userdetail->followup_medical_history_detail['surgical_history'];
                }
                if(!empty($user_detail->chief_compliant_userdetail->followup_medical_history_detail['allergy_history']))
                {
                  $tempar['allergy_history'] = $user_detail->chief_compliant_userdetail->followup_medical_history_detail['allergy_history'];
                }

                $user_detail->chief_compliant_userdetail->followup_medical_history_detail = $tempar;
            }


            if(!empty($user_detail->chief_compliant_userdetail->followup_assessment))
            {
             $user_detail->chief_compliant_userdetail->followup_assessment = unserialize(Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->followup_assessment), SEC_KEY))  ;
              //pr($user_detail->chief_compliant_userdetail->cancer_assessments);die;
              $assessment_history = array();
              $life_assessment = array();
              $chemo_assessment = array();

              if(!empty($user_detail->chief_compliant_userdetail->followup_assessment['assessment_history']))
              {
                $i = 0;
              foreach($user_detail->chief_compliant_userdetail->followup_assessment['assessment_history'] as $key => $value){

                  if(!empty($value)){

                    $temp = $this->CommonConditions->find('all')->where(['id'=> $key])->first();
                    $assessment_history[$i]['symtoms_id'] = $temp->id ;
                    $assessment_history[$i]['name'] = $temp->name ;
                    $assessment_history[$i]['answer'] = $value;
                    $i++;
                  }
                }
              }

              if(!empty($user_detail->chief_compliant_userdetail->followup_assessment['life_assessment']))
              {
                $j = 0;
              foreach($user_detail->chief_compliant_userdetail->followup_assessment['life_assessment'] as $key => $value){

                  if(!empty($value)){

                    $temp = $this->CommonConditions->find('all')->where(['id'=> $key])->first();
                    $life_assessment[$j]['symtoms_id'] = $temp->id ;
                    $life_assessment[$j]['name'] = $temp->name ;
                    $life_assessment[$j]['answer'] = $value;
                    $j++;
                  }
                }
               }

              if(!empty($user_detail->chief_compliant_userdetail->followup_assessment['chemo_assessment']))
              {
                $j = 0;
              foreach($user_detail->chief_compliant_userdetail->followup_assessment['chemo_assessment'] as $key => $value){

                  if(!empty($value)){

                    $temp = $this->CommonConditions->find('all')->where(['id'=> $key])->first();
                    $chemo_assessment[$j]['symtoms_id'] = $temp->id ;
                    $chemo_assessment[$j]['name'] = $temp->name ;
                    $chemo_assessment[$j]['answer'] = $value;
                    $j++;
                  }
                }
               }

               $followup_assessment = array('assessment_history' => $assessment_history,'life_assessment' => $life_assessment,'chemo_assessment' => $chemo_assessment);

              // pr($cancer_assessments);die;
                  if(!empty($followup_assessment))
                  {
                    $user_detail->chief_compliant_userdetail->followup_assessment = $followup_assessment;
                  }
            }

            // Hospital Er Question And Answer
            if(isset($user_detail->chief_compliant_userdetail->hospital_er_detail) && !empty($user_detail->chief_compliant_userdetail->hospital_er_detail))
            {

               $user_detail->chief_compliant_userdetail->hospital_er_detail = unserialize((Security::decrypt(base64_decode($user_detail->chief_compliant_userdetail->hospital_er_detail), SEC_KEY)));
               if(!empty($user_detail->chief_compliant_userdetail->hospital_er_detail)){

                    $i = 0;
                  foreach($user_detail->chief_compliant_userdetail->hospital_er_detail as $key => $val){


                      $temp = $this->CommonQuestions->find('all')->where(['id'=> $key ])->first();
                      $tempar[$i]['question_id'] = $temp->id ;
                      $tempar[$i]['question'] = $temp->question ;
                      $tempar[$i]['answer'] = $val;
                      $i++;

                  }
                  $user_detail->chief_compliant_userdetail->hospital_er_detail = $tempar;
               }
            }
            // End 



        }
        // pr($user_detail->chief_compliant_userdetail->cancer_family_members);
        //pr($user_detail->chief_compliant_userdetail->family_members_cancer_disease_detail);die;

        $length_arr =  '{"1x a day": "qd", "2x a day": "BID", "3x a day": "TID", "every 4 hours": "q4h", "every 6 hours": "q6h", "every 8 hours": "q8h", "every 12 hours": "q12h", "1x a week": "qwk", "2x a week": "2/wk", "3x a week": "3/wk", "at bedtime": "qhs", "in the morning": "qam", "as needed": "PRN"}' ;

        $length_arr = json_decode($length_arr, true);
        $length_arr = array_flip($length_arr);

        $this->set(compact('user_detail', 'length_arr'));
    }

}
