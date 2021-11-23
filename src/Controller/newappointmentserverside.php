
<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use App\Controller\AppController;
use App\Controller\ConnectionManager;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\View\Helper\SessionHelper;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\Utility\Hash;
use Cake\ORM\Table;
use Cake\Utility\Security;
use Cake\View\Helper;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Date;
use Cake\Collection\Collection;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {
    public function newAppointmentstep2($apt_id = null, $next_steps = null, $step_id = null) {
        $cur_next_steps = array();
        if (empty($next_steps)) {
            $next_steps = $this->request->getData('next_steps');
            $next_steps = base64_decode($next_steps);
            $cur_next_steps = explode(',', $next_steps);
        } else {
            $next_steps = base64_decode($next_steps);
            $cur_next_steps = explode(',', $next_steps);
        }
        $session = $this->getRequest()->getSession(); // $this->request->session();
        $USER = $session->read('Auth.User');
        $login_user = $USER;
        // $v = serialize(array(1 => 'AM hours', 2 => 'PM hours' , 3 => 'About the same'  )) ;
        // echo $v;
        // pr(unserialize($v));
        // die;
        // pr($this->request->data); die;
        $this->viewBuilder()->setLayout('front');
        if (!empty($apt_id)) {
            $apt_id = base64_decode($apt_id);
            if (empty($apt_id)) {
                $this->Flash->error(__('Sorry, Appointment id is not valid!.'));
                return $this->redirect(array('action' => 'dashboard'));
            } else {
                $this->loadModel('Appointments');
                $apt_id_data = $this->Appointments->find('all')->where(['id' => $apt_id])->first();
                // pr($apt_id_data) ;die;
                if (empty($apt_id_data)) {
                    $this->Flash->error(__('Please book your appointment here.'));
                    return $this->redirect(array('action' => 'newAppointment'));
                }
            }
        } else {
            $this->Flash->error(__('Please book an appointment here.'));
            return $this->redirect(array('action' => 'newAppointment'));
        }
        $this->loadModel('ChiefCompliants');
        $this->loadModel('ChiefCompliantMedication');
        $this->loadModel('ChiefCompliantUserdetails');
        $this->loadModel('ChiefCompliantDetails');
        $this->loadModel('ChiefCompliantQuestionnaire');
        $this->loadModel('StepDetails');
        $chief_compliant = $this->ChiefCompliants->find('all')->order(['name' => 'ASC']);
        $chief_compliant_medication = $this->ChiefCompliantMedication->find('all')->order(['layman_name' => 'ASC']);
        $detail_question_id = '';
        $default_symptoms_id = '';
        $compliant_questin = '';
        $tab_3_load_2_time = ''; // this variable is used for loading tab 3 two times as client requirement
        $how_it_taken_arr = ["mouth", "nasal spray", "subcutaneously", "muscle injection", "ear", "eye", "under the skin", "under tongue"];
        $protection_methods = ["condom", "birth control pill", "IUD", "vasectomy", "sterilization", "spermicide", "diaphragm", "female condom", "birth control vaginal ring", "birth control sponge", "birth control shot", "birth control patch", "birth control implant"];
        // taken from allevia doc
        $length_arr = '{"1x a day": "qd", "2x a day": "bid", "3x a day": "tid", "every 4 hours": "q4h", "every 6 hours": "q6h", "every 8 hours": "q8h", "every 12 hours": "q12h", "1x a week": "qwk", "2x a week": "2/wk", "3x a week": "3/wk", "at bedtime": "qhs", "in the morning": "qam", "as needed": "prn"}';
        $length_arr = json_decode($length_arr, true);
        $length_arr = array_flip($length_arr);
        $user_detail = $this->ChiefCompliantUserdetails->find('all')->where(['appointment_id' => $apt_id])->first();
        if (!empty($user_detail) && !empty($user_detail->current_tab_number)) {
            $tab_number = $user_detail->current_tab_number;
            $chief_compliant_id = $user_detail->chief_compliant_id;
            $chief_compliant_userdata = $this->ChiefCompliants->find('all')->where(['id' => $chief_compliant_id])->first();
        } else $tab_number = 1;
        if ($tab_number == 2 || 2 == $cur_next_steps[0]) {
            if (!empty($chief_compliant_userdata->default_compliant_detail_ids)) {
                $detail_question_id = $chief_compliant_userdata->default_compliant_detail_ids;
                $detail_question_id = explode(',', $detail_question_id);
                $detail_question_id = $this->ChiefCompliantDetails->find('all')->where(['id IN' => $detail_question_id]);
            } else {
                // redirecting to next step if no detals realted question found
                $this->ChiefCompliantUserdetails->query()->update()->set(['current_tab_number' => 3])->where(['appointment_id' => $apt_id])->execute();
                $this->redirect($this->referer());
            }
        }
        if ($tab_number == 3 || 3 == $cur_next_steps[0]) {
            if (!empty($chief_compliant_userdata->default_symptoms_id)) {
                $default_symptoms_id = $chief_compliant_userdata->default_symptoms_id;
                $default_symptoms_id = explode(',', $default_symptoms_id);
                // get the symptom id of previously filled symptoms and then will remove them from the final result
                if (!empty($user_detail)) {
                    $temp_chief = $user_detail->chief_compliant_id;
                    $temp_chief_symp = $user_detail->compliant_symptom_ids;
                    if (!empty($temp_chief_symp)) $temp_chief_symp = explode(',', $temp_chief_symp);
                    $temp_chief_symp[] = $temp_chief;
                }
                // $default_symptoms_id =     $this->ChiefCompliants->find('all')->where(['id IN' => $default_symptoms_id, 'id NOT IN' => $temp_chief_symp]);
                $default_symptoms_id = $this->ChiefCompliants->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['id IN' => $default_symptoms_id, 'id NOT IN' => $temp_chief_symp]);
                $default_symptoms_id = $default_symptoms_id->toArray();
                // arrange the data in serial no as  client requirement
                $serial_no_symp_id = array(7, 12, 22, 34, 19, 2, 17, 35, 29);
                $temp_symp_id = array();
                foreach ($serial_no_symp_id as $key => $value) {
                    if (isset($default_symptoms_id[$value])) $temp_symp_id[$value] = $default_symptoms_id[$value];
                }
                $default_symptoms_id = $temp_symp_id;
                // pr($default_symptoms_id); die;
                // pr($default_symptoms_id->all()); die;
                
            } else {
                // redirecting to next step if no detals realted question found
                $this->ChiefCompliantUserdetails->query()->update()->set(['current_tab_number' => 4])->where(['appointment_id' => $apt_id])->execute();
                $this->redirect($this->referer());
            }
        }
        if ($tab_number == 4 || ($tab_number <= 4 && 4 == $cur_next_steps[0])) { // for 4th tab different condition is used because some steps start with 4th tab
            $compliant_questin = $this->ChiefCompliantQuestionnaire->find('all');
            $chief_compliant_symptom_arr = array();
            if (!empty($user_detail)) {
                // pr($user_detail); die;
                $chief_compliant_symptoms = $user_detail->chief_compliant_symptoms;
                // pr($chief_compliant_symptoms);
                // pr(unserialize($chief_compliant_symptoms));
                // pr($compliant_questin->all()); die;
                if (!empty($chief_compliant_symptoms)) {
                    $chief_compliant_symptom_arr = unserialize($chief_compliant_symptoms);
                    $t = array();
                    foreach ($chief_compliant_symptom_arr as $key => $value) {
                        foreach ($value as $k => $v) {
                            $t[] = $v;
                        }
                    }
                    $t[] = $user_detail->chief_compliant_id; // include chief compliant id  also (now chief compliant will be removed from the questionnaire list)
                    $temp_chief_symp = $user_detail->compliant_symptom_ids;
                    if (!empty($temp_chief_symp)) {
                        $temp_chief_symp = explode(',', $temp_chief_symp);
                        $t = array_merge($t, $temp_chief_symp);
                    }
                    $chief_compliant_symptom_arr = $t;
                    $query = $this->ChiefCompliants->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['id IN' => $chief_compliant_symptom_arr]);
                    $chief_compliant_symptom_arr = $query->toArray();
                    // pr($chief_compliant_symptom_arr); die;
                    
                }
            }
            // pr($chief_compliant_symptom_arr);
            $qustion_res = $compliant_questin->toArray();
            $questionnaire_grp_arr = array();
            foreach ($qustion_res as $key => $value) {
                $questionnaire_grp_arr[$value->questionnaire_type_id][] = $value;
            }
            foreach ($questionnaire_grp_arr as $key => $value) {
                // pr($key) ; pr($value); die;
                // remove the option if this symptom asked before
                foreach ($value as $k => $v) {
                    $questionnaire_text = strtolower(trim($v->questionnaire_text));
                    if (in_array($questionnaire_text, $chief_compliant_symptom_arr)) unset($questionnaire_grp_arr[$key][$k]);
                }
                // pr($compliant_questin) ;die;
                
            }
            // pr($step_id); $apt_id_data->specialization_id
            // pr($questionnaire_grp_arr); die;
            $temp_questionnaire = array();
            foreach ($questionnaire_grp_arr as $key => $value) {
                if ($key != 10) {
                    $i = 1;
                    foreach ($value as $vl) {
                        $temp_questionnaire[] = $vl;
                        if ($i == 3) {
                            break;
                        }
                        $i++;
                    }
                }
                if ($apt_id_data->specialization_id == 2 && $key == 10) { // for ob-gyn case extra woman related question will be asked (questionare type id 10)
                    foreach ($value as $vl) {
                        $temp_questionnaire[] = $vl;
                    }
                }
            }
            // pr($questionnaire_grp_arr);
            // pr($temp_questionnaire);  die;
            $compliant_questin = $temp_questionnaire;
        }
        if ($tab_number == 5 || 5 == $cur_next_steps[0]) {
            //$user_detail
            if (!empty($user_detail->current_step_id)) {
                $user_detail->current_step_id = $this->StepDetails->find('all')->where(['id' => $user_detail->current_step_id])->first();
            }
            $user_detail->chief_compliant_id = $this->ChiefCompliants->find('all')->where(['id' => $user_detail->chief_compliant_id])->first();
            if (!empty($user_detail->compliant_symptom_ids)) {
                $user_detail->compliant_symptom_ids = explode(',', $user_detail->compliant_symptom_ids);
                $user_detail->compliant_symptom_ids = $this->ChiefCompliants->find('all')->where(['id IN' => $user_detail->compliant_symptom_ids])->all();
            }
            $user_detail->compliant_length = $user_detail->compliant_length;
            if (!empty($user_detail->compliant_medication_detail)) {
                $user_detail->compliant_medication_detail = unserialize($user_detail->compliant_medication_detail);
                // pr($user_detail->compliant_medication_detail);
                foreach ($user_detail->compliant_medication_detail as $key => $value) {
                    $user_detail->compliant_medication_detail[$key]['medication_name_id'] = $this->ChiefCompliantMedication->find('all')->where(['id' => $value['medication_name_id']])->first();
                }
            }
            if (!empty($user_detail->chief_compliant_symptoms)) {
                $user_detail->chief_compliant_symptoms = unserialize($user_detail->chief_compliant_symptoms);
                foreach ($user_detail->chief_compliant_symptoms as $key => $value) {
                    foreach ($value as $k => $v) {
                        $user_detail->chief_compliant_symptoms[$key][$k] = $this->ChiefCompliants->find('all')->where(['id' => $v])->first();
                    }
                }
            }
            if (!empty($user_detail->questionnaire_detail)) {
                // pr($user_detail->questionnaire_detail); die;
                $user_detail->questionnaire_detail = unserialize($user_detail->questionnaire_detail);
                // pr($user_detail->questionnaire_detail) ; die;
                foreach ($user_detail->questionnaire_detail as $key => $value) {
                    foreach ($value as $k => $v) {
                        $user_detail->questionnaire_detail[$key][$k] = $this->ChiefCompliantQuestionnaire->find('all')->where(['id' => $v])->first();
                    }
                }
                // pr($user_detail->questionnaire_detail); die;
                
            }
            if (!empty($user_detail->chief_compliant_details)) {
                $user_detail->chief_compliant_details = unserialize(base64_decode($user_detail->chief_compliant_details)); //  unserialize($user_detail->chief_compliant_details) ;
                $tempar = array();
                $i = 0;
                foreach ($user_detail->chief_compliant_details as $key => $value) {
                    $temp = $this->ChiefCompliantDetails->find('all')->where(['id' => $key])->first();
                    $tempar[$i]['question'] = $temp->question;
                    $tempar[$i]['answer'] = $value;
                    $i++;
                }
                $user_detail->chief_compliant_details = $tempar;
                // pr($user_detail->chief_compliant_details); die;
                
            }
            // echo 'hello' ;
            $this->set(compact('user_detail'));
        }
        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data); die;
            $tab_number = $this->request->getData('tab_number');
            // pr($this->request->data); die;
            if ($tab_number == 1) {
                $chief_compliant_id = $this->request->getData('chief_compliant_id');
                $chief_compliant_length = $this->request->getData('chief_compliant_length');
                $compliant_symptom_ids = '';
                if (!empty($chief_compliant_id) && is_array($chief_compliant_id)) {
                    // pr($chief_compliant_id);
                    $chief_compliant_id = array_filter($chief_compliant_id);
                    $chief_compliant_id = array_unique($chief_compliant_id);
                    $temp_id = array_shift($chief_compliant_id);
                    if (is_array($chief_compliant_id)) {
                        $compliant_symptom_ids = implode(',', $chief_compliant_id);
                    }
                    $chief_compliant_id = $temp_id;
                }
                $medication_name_id = $this->request->getData('medication_name_id');
                $medication_data = array();
                if (!empty($medication_name_id) && is_array($medication_name_id)) {
                    // pr($medication_name_id);
                    $medication_name_id = array_filter($medication_name_id);
                    $medication_name_id = array_unique($medication_name_id);
                    $medication_dose = $this->request->getData('medication_dose');
                    $medication_how_often = $this->request->getData('medication_how_often');
                    $medication_how_taken = $this->request->getData('medication_how_taken');
                    $i = 0;
                    foreach ($medication_name_id as $key => $value) {
                        $medication_data[$i]['medication_name_id'] = $value;
                        $medication_data[$i]['medication_dose'] = $medication_dose[$key];
                        $medication_data[$i]['medication_how_often'] = $medication_how_often[$key];
                        $medication_data[$i]['medication_how_taken'] = $medication_how_taken[$key];
                        $i++;
                    }
                }
                $user_detail = $this->ChiefCompliantUserdetails->newEntity();
                // woman specific field start
                if ($login_user['gender'] == 0) {
                    $last_period_date = $this->request->getData('last_period_date');
                    $last_period_info = $this->request->getData('last_period_info');
                    $if_more_recent_papsmear = $this->request->getData('if_more_recent_papsmear');
                    $last_pap_smear_date = $this->request->getData('last_pap_smear_date');
                    $last_pap_smear_info = $this->request->getData('last_pap_smear_info');
                    if (empty($if_more_recent_papsmear)) {
                        $user_detail->last_pap_smear_date = '';
                        $user_detail->last_pap_smear_info = '';
                    } else {
                        if (!empty($last_pap_smear_date)) {
                            $last_pap_smear_date = Time::createFromFormat('m-d-Y', // 'd-m-Y'
                            $last_pap_smear_date);
                            $user_detail->last_pap_smear_date = $last_pap_smear_date;
                        }
                        if (!empty($last_pap_smear_info)) $user_detail->last_pap_smear_info = serialize($last_pap_smear_info);
                    }
                    if (!empty($last_period_date)) {
                        $last_period_date = Time::createFromFormat('m-d-Y', // 'd-m-Y'
                        $last_period_date);
                        $user_detail->last_period_date = $last_period_date;
                    }
                    if (!empty($last_period_info)) $user_detail->last_period_info = serialize($last_period_info);
                }
                // woman specific field end
                // sexual info related field start
                $sexual_info = $this->request->getData('sexual_info');
                if (!empty($sexual_info) && is_array($sexual_info)) {
                    $user_detail->sexual_info = base64_encode(serialize($sexual_info));
                }
                // sexual info related field end
                $user_detail->current_step_id = $step_id;
                $user_detail->appointment_id = $apt_id;
                if (!empty($chief_compliant_id)) $user_detail->chief_compliant_id = $chief_compliant_id;
                if (!empty($chief_compliant_length)) $user_detail->compliant_length = $chief_compliant_length;
                $user_detail->compliant_symptom_ids = $compliant_symptom_ids;
                $user_detail->compliant_medication_detail = serialize($medication_data);
                // pr($cur_next_steps); die;
                // if step 2 is not in the current step path
                if (in_array(2, $cur_next_steps)) {
                    $user_detail->current_tab_number = 2;
                } else {
                    $user_detail->current_tab_number = 4;
                }
                if ($this->ChiefCompliantUserdetails->save($user_detail)) {
                    if (in_array(2, $cur_next_steps)) $tab_number = 2;
                    else $tab_number = 4;
                    $this->Flash->success(__('Successfully saved provided detail, Please proceed.'));
                    return $this->redirect($this->referer());
                } else {
                    $tab_number = 1;
                    $this->Flash->error(__('Data could not be saved, Please try again.'));
                }
            }
            if ($tab_number == 2) {
                // storing user details question in d/b
                $details_question = $this->request->getData('details_question');
                if (!empty($details_question && is_array($details_question))) {
                    $details_question = base64_encode(serialize($details_question)); //  serialize($details_question);
                    if (!empty($user_detail)) {
                        $this->ChiefCompliantUserdetails->query()->update()->set(['chief_compliant_details' => $details_question, 'current_tab_number' => 3])->where(['appointment_id' => $apt_id])->execute();
                    } else {
                        $tempuser = $this->ChiefCompliantUserdetails->newEntity();
                        $tempuser->appointment_id = $apt_id;
                        $tempuser->chief_compliant_details = $details_question;
                        $tempuser->current_tab_number = 3;
                        $tempuser->current_step_id = $step_id;
                        $this->ChiefCompliantUserdetails->save($tempuser);
                    }
                    $this->Flash->success(__('Successfully saved provided detail, Please proceed.'));
                    return $this->redirect($this->referer());
                } else {
                    $this->Flash->error(__('Data could not be saved, Please try again.'));
                }
            }
            if ($tab_number == 3) {
                // storing symptoms response in d/b
                $associated_symptom = $this->request->getData('associated_symptom');
                if (!empty($associated_symptom) && is_array($associated_symptom)) {
                    $tempar = array();
                    foreach ($associated_symptom as $key => $value) {
                        $tempar[$value][] = $key;
                    }
                    ksort($tempar);
                    $associated_symptom = $tempar;
                    // $associated_symptom = serialize($tempar) ;
                    // tab_3_load_2_time
                    // we are loading tab 3  , 2 times according to client requirement (first time 5 and rest symptom 2nd time)
                    $tab_3_load_2_time = $this->request->getData('tab_3_load_2_time');
                    if ($tab_3_load_2_time == 2) {
                        $temp_u_dtils = $this->ChiefCompliantUserdetails->find('all')->where(['appointment_id' => $apt_id])->first();
                        $temp_u_dtils = $temp_u_dtils->chief_compliant_symptoms;
                        if (!empty($temp_u_dtils)) {
                            $temp_u_dtils = unserialize($temp_u_dtils);
                            // this for loop recursively merges the 2 array (1- saved in db from step 1 , 2 - array received in this step)
                            foreach ($temp_u_dtils as $key => $value) {
                                if (empty($associated_symptom[$key])) {
                                    $associated_symptom[$key] = $value;
                                } else {
                                    $associated_symptom[$key] = array_merge($associated_symptom[$key], $value);
                                }
                            }
                            // $associated_symptom = array_merge_recursive($associated_symptom,$temp_u_dtils ) ;
                            
                        }
                        $associated_symptom = serialize($associated_symptom);
                        if (!empty($user_detail)) {
                            $this->ChiefCompliantUserdetails->query()->update()->set(['chief_compliant_symptoms' => $associated_symptom, 'current_tab_number' => 4])->where(['appointment_id' => $apt_id])->execute();
                        } else {
                            $tempuser = $this->ChiefCompliantUserdetails->newEntity();
                            $tempuser->appointment_id = $apt_id;
                            $tempuser->chief_compliant_symptoms = $associated_symptom;
                            $tempuser->current_tab_number = 4;
                            $tempuser->current_step_id = $step_id;
                            $this->ChiefCompliantUserdetails->save($tempuser);
                        }
                        $this->Flash->success(__('Successfully saved provided detail, Please proceed.'));
                        return $this->redirect($this->referer());
                    } else {
                        $associated_symptom = serialize($associated_symptom);
                        if (!empty($user_detail)) {
                            $this->ChiefCompliantUserdetails->query()->update()->set(['chief_compliant_symptoms' => $associated_symptom])->where(['appointment_id' => $apt_id])->execute();
                        }
                        $tab_3_load_2_time = 2; // set to 2
                        $this->Flash->success(__('Successfully saved provided detail, Please proceed.'));
                    }
                } else {
                    $this->Flash->error(__('Data could not be saved, Please try again.'));
                }
            }
            if ($tab_number == 4) {
                // pr($this->request->data); die;
                $medication_name_id = $this->request->getData('medication_name_id');
                $medication_data = array();
                if (!empty($medication_name_id) && is_array($medication_name_id)) {
                    // pr($medication_name_id);
                    $medication_name_id = array_filter($medication_name_id);
                    $medication_name_id = array_unique($medication_name_id);
                    $medication_dose = $this->request->getData('medication_dose');
                    $medication_how_often = $this->request->getData('medication_how_often');
                    $medication_how_taken = $this->request->getData('medication_how_taken');
                    $i = 0;
                    foreach ($medication_name_id as $key => $value) {
                        $medication_data[$i]['medication_name_id'] = $value;
                        $medication_data[$i]['medication_dose'] = $medication_dose[$key];
                        $medication_data[$i]['medication_how_often'] = $medication_how_often[$key];
                        $medication_data[$i]['medication_how_taken'] = $medication_how_taken[$key];
                        $i++;
                    }
                }
                $medication_side_effects = $this->request->getData('medication_side_effects');
                /* code commented because in request data string comes instead of array as client requirement
                if(!empty($medication_side_effects) && is_array($medication_side_effects)){
                
                $medication_side_effects = implode(',', $medication_side_effects) ;
                
                }
                */
                $question_symptom = $this->request->getData('question_symptom');
                if (!empty($question_symptom) && is_array($question_symptom)) {
                    $tempar = array();
                    foreach ($question_symptom as $key => $value) {
                        $tempar[$value][] = $key;
                    }
                    ksort($tempar);
                    $question_symptom = serialize($tempar);
                    if (!empty($user_detail)) {
                        $this->ChiefCompliantUserdetails->query()->update()->set(['questionnaire_detail' => $question_symptom, 'current_tab_number' => 5])->where(['appointment_id' => $apt_id])->execute();
                    } else {
                        $tempuser = $this->ChiefCompliantUserdetails->newEntity();
                        $tempuser->appointment_id = $apt_id;
                        $tempuser->questionnaire_detail = $question_symptom;
                        $tempuser->current_tab_number = 5;
                        $tempuser->current_step_id = $step_id;
                        if ($step_id == 4 && !empty($medication_data)) {
                            $tempuser->compliant_medication_detail = serialize($medication_data);
                            $tempuser->medication_side_effects = $medication_side_effects;
                        }
                        $this->ChiefCompliantUserdetails->save($tempuser);
                    }
                    $this->Flash->success(__('Successfully saved provided detail, Please proceed.'));
                    return $this->redirect($this->referer());
                } else {
                    $this->Flash->error(__('Data could not be saved, Please try again.'));
                }
            }
        }
        $default_med_chiefcom = $this->ChiefCompliants->find('list', ['keyField' => 'id', 'valueField' => 'default_medication_ids'])->where(['default_medication_ids  IS NOT' => null, 'default_medication_ids  IS NOT' => '']);
        $default_med_chiefcom = $default_med_chiefcom->toArray();
        $commonTable = TableRegistry::get('common_conditions');
        $allergy_reaction_cond = $commonTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['cond_type' => 5])->toArray();
        $medication_side_effects = $allergy_reaction_cond;
        // pr($default_symptoms_id->all()); die;
        $womantable = TableRegistry::get('women_specific');
        $womandata = $womantable->find()->where(['user_id' => $login_user['id']])->first();
        $this->set(compact('chief_compliant', 'chief_compliant_medication', 'length_arr', 'tab_number', 'apt_id', 'how_it_taken_arr', 'protection_methods', 'detail_question_id', 'default_symptoms_id', 'compliant_questin', 'next_steps', 'default_med_chiefcom', 'login_user', 'step_id', 'medication_side_effects', 'apt_id_data', 'womandata', 'tab_3_load_2_time'));
    }
}
