<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\Controller\Controller;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class CcDetailComponent extends Component{

    public $components = array('CryptoSecurity','General');

    public function prepare_question_layman($user_detail = null, $gender = null)
    {


        // this array used for case 43 for image related question
        $this->ChiefCompliantUserdetails = TableRegistry::get('ChiefCompliantUserdetails');

        // for follow up detail question will be compared with previous visit details of the patient
        if(isset($user_detail->current_step_id->id) && ($user_detail->current_step_id->id == 6) ||($user_detail->current_step_id->id == 12 && isset($user_detail->follow_up_step_id) && $user_detail->follow_up_step_id == 1))
        {
            $prev_visit_user_detail =  $this->ChiefCompliantUserdetails->find('all')->where(['id' => $user_detail->followup_parent_id])->first();
            $prev_visit_user_detail = $this->General->prepare_user_detial_data_for_render($prev_visit_user_detail);
            $followup_compare_result = $this->General->compare_prev_recent_cc_detial_for_followup($user_detail, $prev_visit_user_detail);
            return $followup_compare_result;
        }


        $more_options = $user_detail->more_options ;
        $all_cc_name = '' ;
        $orginal_cc_name = '';
        $layman_summar = '' ;
        $cc_header = '';
        $cur_cc_name  = "";
        if(!empty($gender) && !in_array($gender,array(0,1,2)))
        {

            $gender = Security::decrypt(base64_decode($gender),SEC_KEY);
        }

$chief_compliant_details_data = array();
if(!empty($user_detail->chief_compliant_details) && is_array($user_detail->chief_compliant_details)){

    //arrange the question order for generate the answer in client's requiremnet.
    foreach ($user_detail->chief_compliant_details as $arrang_key => $arrang_val) {
        $temp_array = array();
        foreach ($arrang_val as $akey => $avalue) {

            if(is_string($akey) && $akey == 'cc_data'){

                $temp_array['cc_data'] = $avalue;
                $temp_array['order_sequesnce'] = $avalue->question_order_sequesnce;
                // $order_sequesnce = $value['cc_data']->question_sequence_order;
            }
            else{

                $temp_array['data'][$avalue['question_id']] = $avalue;
            }
        }

        $chief_compliant_details_data[$arrang_key] = $temp_array;
    }

    $temp_cc_data = array();
    foreach ($chief_compliant_details_data as $key => $value) {

        $order_sequesnce = $value['order_sequesnce'];

        $temparr = array();
        if(isset($value['cc_data'])){

           $temparr['cc_data'] = $value['cc_data'];
        }
        if(!empty($order_sequesnce)){

            $order_sequesnce = explode(',', $order_sequesnce);
            foreach ($order_sequesnce as $ok => $oval) {

                if(isset($value['data'][$oval])){

                    $temparr[] = $value['data'][$oval];
                }
            }
        }
        else{

            foreach ($value['data'] as $k => $v) {

                $temparr[] = $v;
            }
        }
        $temp_cc_data[$key] = $temparr;

    }

    $duration_arr = array('3 months','4 months','5 months','6 months','7 months','8 months','9 months','10 months','11 months','1 year','2 years','3 years','4 years','5 years','6 years','7 years','8 years','9 years','10 years','10+ years');
   // pr($chief_compliant_details_data);
 //pr($temp_cc_data);die;
foreach ($temp_cc_data as $key => $value) {

        $case_15_how_many_days = (isset($user_detail->compliant_length) && !empty($user_detail->compliant_length)) ? $user_detail->compliant_length :"" ;

        //set the cheif complaint layman header
        // According to client requirement below if code will run only if the current chief compliant is not the main chief complaint
        $temp_cc_header = '';
        $cheif_complaint_ans = '';
        $temp_cc_name = '';
        $header_cc_name = '';
        $negative_ans =  '';
        $positive_ans = '';

        if(in_array($value['cc_data']->name, ['chest pain','pain in chest','chest pressure'])){


            if(isset($chief_compliant_details_data[$key]['data'][158]) && !empty($chief_compliant_details_data[$key]['data'][158])){

                $cheif_complaint_ans = strtolower($chief_compliant_details_data[$key]['data'][158]['answer']);
                if($cheif_complaint_ans == 'suddenly'){

                    $cheif_complaint_ans = 'sudden onset ';
                }
                elseif($cheif_complaint_ans == 'gradually'){

                    $cheif_complaint_ans = 'gradual onset ';
                }
                else{

                    $cheif_complaint_ans = $chief_compliant_details_data[$key]['data'][158]['answer'].' onset ';
                }
            }

        }
        elseif(in_array($value['cc_data']->name, ['headache'])){

             if(isset($chief_compliant_details_data[$key]['data'][153]) && !empty($chief_compliant_details_data[$key]['data'][153])){

                $cheif_complaint_ans = strtolower($chief_compliant_details_data[$key]['data'][153]['answer']);
                if($cheif_complaint_ans == 'both sides'){

                    $cheif_complaint_ans = 'bilateral ';
                }
                else{

                    $cheif_complaint_ans = 'unilateral ';
                }
             }
        }
        elseif(in_array($value['cc_data']->name, ['hand pain'])){

             if(isset($chief_compliant_details_data[$key]['data'][16]) && !empty($chief_compliant_details_data[$key]['data'][16])){

                $cheif_complaint_ans = trim(strtolower($chief_compliant_details_data[$key]['data'][16]['answer']));
                if($cheif_complaint_ans == 'both'){

                    $cheif_complaint_ans = 'bilateral ';
                    $temp_cc_name = $cheif_complaint_ans;
                    $ques_ans_17 = trim(strtolower($chief_compliant_details_data[$key]['data'][17]['answer']));
                    if(stripos($ques_ans_17, 'left') !== FALSE) $cheif_complaint_ans .=  '(L>R) ';
                    if(stripos($ques_ans_17, 'right') !== FALSE) $cheif_complaint_ans .=  '(R>L) ';
                    if(stripos($ques_ans_17, 'about') !== FALSE) $cheif_complaint_ans .=  '(L=R) ';


                }
                else{

                    $cheif_complaint_ans = $cheif_complaint_ans.' ';
                    $temp_cc_name = $cheif_complaint_ans;
                }
             }
        }
        elseif(in_array($value['cc_data']->name, ['finger pain']))
        {
            $ques_16 = trim(strtolower($chief_compliant_details_data[$key]['data'][16]['answer']));
            if($ques_16 == 'both'){

                $cheif_complaint_ans = 'bilateral ';
                $temp_cc_name = $cheif_complaint_ans;

                $ques_17 = trim(strtolower($chief_compliant_details_data[$key]['data'][17]['answer']));
                if(stripos($ques_17, 'left') !== FALSE) $cheif_complaint_ans .=  '(L>R) ';
                if(stripos($ques_17, 'right') !== FALSE) $cheif_complaint_ans .=  '(R>L) ';
                if(stripos($ques_17, 'about') !== FALSE) $cheif_complaint_ans .=  '(L=R) ';
            }
            else{

                $cheif_complaint_ans = $ques_16.' ';
                $temp_cc_name = $cheif_complaint_ans;
            }

            $ques_19 = strtolower(implode(", ", $chief_compliant_details_data[$key]['data'][19]['answer']));
            if($ques_19 != 'not on the fingers'){

                $cheif_complaint_ans .= $ques_19.' ';
            }

        }
        elseif(in_array($value['cc_data']->name, ['hand weakness','weak grip']))
        {
            if(isset($chief_compliant_details_data[$key]['data'][31]) && !empty($chief_compliant_details_data[$key]['data'][31]))
            {
                $cheif_complaint_ans = strtolower($chief_compliant_details_data[$key]['data'][31]['answer']).' onset ';
            }

            $ques_16 = trim(strtolower($chief_compliant_details_data[$key]['data'][16]['answer']));
            if($ques_16 == 'both'){

                $temp_cc_name = 'bilateral ';
                $cheif_complaint_ans .= $temp_cc_name;


                $ques_17 = trim(strtolower($chief_compliant_details_data[$key]['data'][17]['answer']));
                if(stripos($ques_17, 'left') !== FALSE) $cheif_complaint_ans .=  '(L>R) ';
                if(stripos($ques_17, 'right') !== FALSE) $cheif_complaint_ans .=  '(R>L) ';
                if(stripos($ques_17, 'about') !== FALSE) $cheif_complaint_ans .=  '(L=R) ';
            }
            else{

                $cheif_complaint_ans .= $ques_16.' ';
                $temp_cc_name = $ques_16.' ';
            }

        }
        elseif(in_array($value['cc_data']->name, ['stiffness']))
        {
            $cheif_complaint_ans = '';
            $ques_21 = '';
            $ques_22 = '';

            if(isset($chief_compliant_details_data[$key]['data'][21]['answer'])){

                $ques_21 = trim(strtolower($chief_compliant_details_data[$key]['data'][21]['answer']));
            }

            if(isset($chief_compliant_details_data[$key]['data'][22]['answer'])){

                $ques_22 = trim(strtolower($chief_compliant_details_data[$key]['data'][22]['answer']));
            }

            if($ques_21 == 'neither' && $ques_22 == 'neither'){

                $cheif_complaint_ans = 'neither hand nor wrist ';
            }
            else{

                if(!empty($ques_21)){

                    $ques_21 = ($ques_21 == 'both' ? 'bilateral hand ': $ques_21." hand ");
                }

                if(!empty($ques_22)){

                    $ques_22 = ($ques_22 == 'both' ? ' bilateral wrist ': $ques_22." wrist ");
                }

               $cheif_complaint_ans .= $ques_21.'and '.$ques_22;
            }
        }
        elseif(in_array($value['cc_data']->name, ['ankle pain'])){


            if(isset($chief_compliant_details_data[$key]['data'][110]) && !empty($chief_compliant_details_data[$key]['data'][110])){

                $ques_ans_110 = trim(strtolower($chief_compliant_details_data[$key]['data'][110]['answer']));
                if($ques_ans_110 == 'suddenly'){

                    $cheif_complaint_ans = 'sudden onset ';
                }
                else{

                    $cheif_complaint_ans = 'gradual onset ';
                }
            }

            if(isset($chief_compliant_details_data[$key]['data'][127]) && !empty($chief_compliant_details_data[$key]['data'][127])){

                $ques_ans_127 = trim(strtolower($chief_compliant_details_data[$key]['data'][127]['answer']));
                if($ques_ans_127 == 'both'){

                    $temp_cc_name =  'bilateral ';
                    $cheif_complaint_ans .= $temp_cc_name;

                    $ques_ans_128 = trim(strtolower($chief_compliant_details_data[$key]['data'][128]['answer']));

                    if($ques_ans_128 == 'left more than right') $cheif_complaint_ans .=  '(L>R) ';
                    if($ques_ans_128 == 'right more than left') $cheif_complaint_ans .=  '(R>L) ';
                    if($ques_ans_128 == 'about the same') $cheif_complaint_ans .=  '(L=R) ';
                }
                else{

                    $cheif_complaint_ans .= $ques_ans_127.' ';
                    $temp_cc_name = $ques_ans_127.' ';
                }
             }
        }
        elseif(in_array($value['cc_data']->name, ['foot pain'])){


            if(isset($chief_compliant_details_data[$key]['data'][110]) && !empty($chief_compliant_details_data[$key]['data'][110])){

                $ques_ans_110 = trim(strtolower($chief_compliant_details_data[$key]['data'][110]['answer']));
                if($ques_ans_110 == 'suddenly'){

                    $cheif_complaint_ans = 'sudden onset ';
                }
                else{

                    $cheif_complaint_ans = 'gradual onset ';
                }
            }

            if(isset($chief_compliant_details_data[$key]['data'][106]) && !empty($chief_compliant_details_data[$key]['data'][106])){

                $ques_ans_106 = trim(strtolower($chief_compliant_details_data[$key]['data'][106]['answer']));
                if($ques_ans_106 == 'both'){

                    $temp_cc_name =  'bilateral ';
                    $cheif_complaint_ans .= $temp_cc_name;

                    if(isset($chief_compliant_details_data[$key]['data'][107])){

                        $ques_ans_107 = trim(strtolower($chief_compliant_details_data[$key]['data'][107]['answer']));

                        if($ques_ans_107 == 'left more than right') $cheif_complaint_ans .=  '(L>R) ';
                        if($ques_ans_107 == 'right more than left') $cheif_complaint_ans .=  '(R>L) ';
                        if($ques_ans_107 == 'about the same') $cheif_complaint_ans .=  '(L=R) ';
                    }

                }
                else{

                    $cheif_complaint_ans .= $ques_ans_106.' ';
                    $temp_cc_name = $ques_ans_106.' ';
                }
             }
        }
        elseif(in_array($value['cc_data']->name, ['numbness'])){

             if(isset($chief_compliant_details_data[$key]['data'][16]) && !empty($chief_compliant_details_data[$key]['data'][16])){

                $cheif_complaint_ans = trim(strtolower($chief_compliant_details_data[$key]['data'][16]['answer']));
                if($cheif_complaint_ans == 'both'){

                    $cheif_complaint_ans = 'bilateral ';
                    $temp_cc_name = $cheif_complaint_ans.'hand ';
                    $ques_ans_17 = trim(strtolower($chief_compliant_details_data[$key]['data'][17]['answer']));
                    if(stripos($ques_ans_17, 'left') !== FALSE) $cheif_complaint_ans .=  '(L>R) hand ';
                    if(stripos($ques_ans_17, 'right') !== FALSE) $cheif_complaint_ans .=  '(R>L) hand ';
                    if(stripos($ques_ans_17, 'about') !== FALSE) $cheif_complaint_ans .=  '(L=R) hand ';


                }
                else{

                    $cheif_complaint_ans = $cheif_complaint_ans.' hand ';
                    $temp_cc_name = $cheif_complaint_ans;
                }
             }
        }
        elseif(in_array($value['cc_data']->name, ['tingling'])){

             if(isset($chief_compliant_details_data[$key]['data'][16]) && !empty($chief_compliant_details_data[$key]['data'][16])){

                $cheif_complaint_ans = trim(strtolower($chief_compliant_details_data[$key]['data'][16]['answer']));
                if($cheif_complaint_ans == 'both'){

                    $cheif_complaint_ans = 'bilateral ';
                    //$temp_cc_name = $cheif_complaint_ans;
                    $ques_ans_17 = trim(strtolower($chief_compliant_details_data[$key]['data'][17]['answer']));
                    if(stripos($ques_ans_17, 'left') !== FALSE) $cheif_complaint_ans .=  '(L>R) hand ';
                    if(stripos($ques_ans_17, 'right') !== FALSE) $cheif_complaint_ans .=  '(R>L) hand ';
                    if(stripos($ques_ans_17, 'about') !== FALSE) $cheif_complaint_ans .=  '(L=R) hand ';


                }
                else{

                    $cheif_complaint_ans = $cheif_complaint_ans.' ';
                }
             }
        }
        elseif(in_array($value['cc_data']->name, ['hip pain'])){


            if(isset($chief_compliant_details_data[$key]['data'][110]) && !empty($chief_compliant_details_data[$key]['data'][110])){

                $ques_ans_110 = trim(strtolower($chief_compliant_details_data[$key]['data'][110]['answer']));
                if($ques_ans_110 == 'suddenly'){

                    $cheif_complaint_ans = 'sudden onset ';
                }
                else{

                    $cheif_complaint_ans = 'gradual onset ';
                }
            }
            if(isset($chief_compliant_details_data[$key]['data'][135]) && !empty($chief_compliant_details_data[$key]['data'][135])){

                $ques_ans_135 = trim(strtolower($chief_compliant_details_data[$key]['data'][135]['answer']));
                if($ques_ans_135 == 'both'){

                    $temp_cc_name =  'bilateral ';
                    $cheif_complaint_ans .= $temp_cc_name;

                    $ques_ans_136 = trim(strtolower($chief_compliant_details_data[$key]['data'][136]['answer']));

                    if($ques_ans_136 == 'left more than right') $cheif_complaint_ans .=  '(L>R) ';
                    if($ques_ans_136 == 'right more than left') $cheif_complaint_ans .=  '(R>L) ';
                    if($ques_ans_136 == 'about the same') $cheif_complaint_ans .=  '(L=R) ';

                }
                else{

                    $cheif_complaint_ans .= $ques_ans_135.' ';
                    $temp_cc_name = $ques_ans_135.' ';
                }
             }
            if(isset($chief_compliant_details_data[$key]['data'][137]) && !empty($chief_compliant_details_data[$key]['data'][137])){

                $ques_ans_137 = array();
                $translate_137 = array(

                                "groin" => 'groin/anterior medial',
                                "hip" => 'lateral',
                                "buttock" => 'posterior hip/gluteal'
                              );
                foreach ($chief_compliant_details_data[$key]['data'][137]['answer'] as $qk => $qval) {

                    $que = trim($qval);
                    $ques_ans_137[] = $translate_137[$que];
                }
                $cheif_complaint_ans .= implode(", ",$ques_ans_137).' ';
            }

        }
         elseif(in_array($value['cc_data']->name, ['joint pain'])){


            if(isset($chief_compliant_details_data[$key]['data'][171]) && !empty($chief_compliant_details_data[$key]['data'][171])){

                $ques_ans_171 = trim(strtolower($chief_compliant_details_data[$key]['data'][171]['answer']));
                if($ques_ans_171 == 'yes'){

                    $cheif_complaint_ans = 'polyarticular ';
                }
                else{

                    $cheif_complaint_ans = 'monoarticular ';
                }
            }
        }

    //set the current cheif complaint name
    if(isset($value['cc_data']) && !empty($value['cc_data']))
    {
        //if doctor specific name is not empty then show doctor specific name otherwise show name
        $doctor_cc_name = !empty($value['cc_data']->doctor_specific_name) ? $value['cc_data']->doctor_specific_name : $value['cc_data']->name;
    	if(strrpos($value['cc_data']->name, 'pain') !== false && in_array($case_15_how_many_days, $duration_arr)){

    		$all_cc_name .=  $temp_cc_name.'chronic '.$doctor_cc_name.', '; // collect all cc
            $cur_cc_name = 'chronic '.$doctor_cc_name;
            $orginal_cc_name  .= !empty($value['cc_data']->name) ? 'chronic '.$value['cc_data']->name.', ' : '';
            $header_orginal_cc_name = strtolower($cheif_complaint_ans.'chronic '.$value['cc_data']->name);
            $header_cc_name = strtolower($cheif_complaint_ans.'chronic '.$doctor_cc_name);
    	}
    	else{

    		$all_cc_name .=  $temp_cc_name.$doctor_cc_name.', '; // collect all cc
            $cur_cc_name = $doctor_cc_name;
            $orginal_cc_name  .= !empty($value['cc_data']->name) ? $value['cc_data']->name.', ' : '';
            $header_orginal_cc_name = strtolower($cheif_complaint_ans.$value['cc_data']->name);
            $header_cc_name = strtolower($cheif_complaint_ans.$doctor_cc_name);
    	}

        $temp_cc_header = ' presenting with '.$header_orginal_cc_name.' for '.$case_15_how_many_days.". " ;
        //$temp_cc_header = str_replace("hip hip", 'hip', $temp_cc_header);

        if(isset($user_detail->chief_compliant_id->id) && $user_detail->chief_compliant_id->id == $key){

            $cc_header = $temp_cc_header;
        }

        if(isset($user_detail->chief_compliant_id->id) && $user_detail->chief_compliant_id->id != $key){

            $layman_summar .= 'The patient is also'.$temp_cc_header;
        }
        else
        {
            $layman_summar .= ' ';
        }

    }

    switch ($key) {
        case 1:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                        case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;

                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 6:

                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals'){

                                $ques_ans_6 =  ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(!empty($ques_ans_8)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                            break;

                        case 8:

                            $ques_ans_8 = "The pain is experienced approximately ".$singlelevel['answer']." times/day";
                            if(!empty($ques_ans_6)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                            break;
                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 55:
                            $question_ans_55 = is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'];
                            break;

                        case 56:
                            $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer']));
                            if(isset($question_ans_55) && !empty($question_ans_55)){

                                $layman_summar .= " that ".(strtolower($question_ans_55) == 'Constant' ? 'is '.$question_ans_55 : $question_ans_55).". ";
                            }else{

                              $layman_summar .= ". ";
                            }
                            break;

                        case 57:

                            $ans_57 = '';
                            if($singlelevel['answer'] == 'Yes'){

                                if(isset($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 58){

                                    $ans_57 = 'with radiation to the '.(is_array($value[$k+1]['answer']) ? strtolower(implode(', ', $value[$k+1]['answer'])) :strtolower($value[$k+1]['answer']));
                                }
                                else{

                                    $ans_57 = 'with radiation';
                                }
                            }
                            else
                            {
                                $ans_57 = 'without radiation';
                            }

                            if(isset($ans_102) && !empty($ans_102)){
                                $layman_summar .= $ans_102.' '.$ans_57.'. ';
                                $ans_102 = ''; $ans_57 = '';
                            }
                           break;

                        case 102:

                            $temp_str_102 = $this->cheif_complaint_question_102($singlelevel['answer'],$gender);
                            $ans_102 =  "Patient localizes the ".$cur_cc_name." to the ".$temp_str_102 ;

                            if(isset($ans_57) && !empty($ans_57)){
                                $layman_summar .= $ans_102.' '.$ans_57.'. ';
                                $ans_102 = ''; $ans_57 = '';
                            }
                            break;
                    }
                }
                break;
            }
            case 5:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 6:

                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals'){

                                $ques_ans_6 .= ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_6 .= ", occurring most often at ".strtolower($singlelevel['answer']);
                            }
                            if(!empty($ques_ans_99) && !empty($ques_ans_97)){

                                $layman_summar .= $ques_ans_99.$ques_ans_97.$ques_ans_6.'. ';
                                $ques_ans_99 = ''; $ques_ans_97 = ''; $ques_ans_6 = '';
                            }

                            break;

                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 13:
                            $layman_summar .=   $singlelevel['answer'] == 'Yes' ? "Patient tried medication"  : "Patient didn't try medication. " ;

                            break;

                        case 14:

                            $layman_summar .=  $singlelevel['answer'] == 'Yes' ? ", and since then the pain has improved."  : ", and since then the pain hasn't improved." ;

                            break;

                        case 61:

                            $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));


                            if(!empty($ques_ans_62)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                            }

                            break;
                        case 62:

                             $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);

                            if(!empty($ques_ans_61)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                            }

                            break;
                        case 63:

                            $question_63 = $singlelevel['answer'];

                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;

                            break;

                        case 64:

                            if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                                $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                            }
                            else{
                                $layman_summar .= '. ';
                            }

                            break;
                        case 65:

                            $question_65 = '';
                            if(!empty($singlelevel['answer'])){
                                $question_65 = $singlelevel['answer'];
                            }

                            break;
                        case 66:

                            $arr = array(
                                  '' => 'How long stay',
                                  "1" => '<24 hours',
                                  "2" => '1 day',
                                  "3" => '2 days',
                                  "4" => '3 days',
                                  "5" => '4 days',
                                  "6" => '5 days',
                                  "7" => '6 days',
                                  "8" => '1 week',
                                  "9" => '2 weeks',
                                  "10" => '3 weeks'
                                  );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                                $question_66 .= $arr[$singlelevel['answer']];
                            }

                            break;

                        case 67:

                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }

                            $layman_summar .= '. ';
                            break;

                        case 68:

                            if(!empty($singlelevel['answer'])){

                              if($singlelevel['answer'] == 'No'){


                                $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              elseif($singlelevel['answer'] == 'Yes'){

                                $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              else{

                                $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                              }
                             }

                            break;

                        case 69:

                            //according to client requirement this question has not shown in note.

                            break;
                        case 94:

                            $layman_summar .= "Radiating: ".implode(", ", $singlelevel['answer']).'. ';
                            break;

                        case 95:


                            $ques_ans_95 = is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']);

                            if($ques_ans_95 == 'no'){

                               $ques_ans_95 = 'without radiation';
                            }
                            else{

                               $ques_ans_95 = 'with radiation to the '.$ques_ans_95;
                            }

                            if(!empty($ques_ans_103)){

                                $layman_summar .= $ques_ans_103.' '.$ques_ans_95.'. ';
                                $ques_ans_103 = ''; $ques_ans_95 = '';
                            }
                            break;
                        case 97:

                            $arr = array(

                                '' => '',
                                '1' => 'hour',
                                '2' => 'day',
                                '3' => 'week',
                                '4' => 'month'
                                );

                            $ques_ans_97 = ', approximately '.$singlelevel['answer'].' times/'. $arr[$value[$k+1]['answer']];

                            if(!empty($ques_ans_99) && !empty($ques_ans_6)){

                                $layman_summar .= $ques_ans_99.$ques_ans_97.$ques_ans_6.'. ';
                                $ques_ans_99 = ''; $ques_ans_97 = ''; $ques_ans_6 = '';
                            }

                            break;


                        case 99:

                            $arr = array(

                                '' => '',
                                '1' => 'seconds',
                                '2' => 'mins',
                                '3' => 'hours',
                                '4' => 'days'
                                );

                            $ques_ans_99 = 'The pain is experienced episodically at '.$singlelevel['answer'].' '.$arr[$value[$k+1]['answer']].'/episode';
                            if(!empty($ques_ans_97) && !empty($ques_ans_6)){

                                $layman_summar .= $ques_ans_99.$ques_ans_97.$ques_ans_6.'. ';
                                $ques_ans_99 = ''; $ques_ans_97 = ''; $ques_ans_6 = '';
                            }
                           // $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '..' long. ';
                            break;

                         case 101:

                            $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer'])).'. ';
                            break;

                        case 103:

                            $temp_str_103 = $this->cheif_complaint_question_103($singlelevel['answer'],$gender);
                            $ques_ans_103 =  "Patient localizes the ".$cur_cc_name." to the ".$temp_str_103;
                            if(!empty($ques_ans_95)){

                                $layman_summar .= $ques_ans_103.' '.$ques_ans_95.'. ';
                                $ques_ans_103 = ''; $ques_ans_95 = '';
                            }

                            break;
                    }
                }
                break;
            }

            case 7:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                        case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                            if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;

                        case 5:

                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;
                            if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;

                        case 6:

                            if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

                                $layman_summar .= "The ".$cur_cc_name." is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }

                            elseif($singlelevel['answer'] == 'Night'){

                                $layman_summar .= "The ".$cur_cc_name." is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                            }
                            else
                            {
                            	$layman_summar .= "The ".$cur_cc_name." is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                            }
                            break;

                        case 13:
                            $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Patient tried medication"  : "Patient didn't try medication. " ;

                            break;
                        case 14:

                            $layman_summar .=  $singlelevel['answer'] == 'Yes' ? ", and since then the pain has improved."  : ", and since then the pain hasn't improved." ;

                            break;
                    }
                }
                break;
            }

            case 13:
            {

                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 1:

                            $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                            break;

                        case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 5:

                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;


                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 7:

                             $ques_ans_7 = "The pain is experienced episodically at ".$singlelevel['answer']." mins/episode";
                             if(!empty($ques_ans_8) && !empty($ques_ans_154)){

                             	$layman_summar .= $ques_ans_7.$ques_ans_8.$ques_ans_154.'. ';
                             	$ques_ans_8 ='';$ques_ans_7 = '';$ques_ans_154 = '';
                             }

                            break;
                        case 8:
                            $ques_ans_8 = ", approximately ".$singlelevel['answer']." times/day";

                            if(!empty($ques_ans_7) && !empty($ques_ans_154)){

                             	$layman_summar .= $ques_ans_7.$ques_ans_8.$ques_ans_154.'. ';
                             	$ques_ans_8 ='';$ques_ans_7 = '';$ques_ans_154 = '';
                             }
                            break;

                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:

                              $ques_ans_11 = $singlelevel['answer'];
                              if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                 // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                                 $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                              }
                            break;
                        case 12:
                            $layman_summar .=  "The pain is described as ".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).". " ;
                            break;
                        case 13:
                            $layman_summar .=   $singlelevel['answer'] == 'Yes' ? "Patient tried medication"  : "Patient didn't try medication. " ;

                            break;
                        case 14:

                              $layman_summar .=  $singlelevel['answer'] == 'Yes' ? ", and since then the pain has improved."  : ", and since then the pain hasn't improved." ;

                            break;

                        case 154 :

                        	$ques_ans_154 = '';
                            if($singlelevel['answer'] == 'Only after meals'){

                                $ques_ans_154 = ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_154 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(!empty($ques_ans_7) && !empty($ques_ans_8)){

                             	$layman_summar .= $ques_ans_7.$ques_ans_8.$ques_ans_154.'. ';
                             	$ques_ans_8 ='';$ques_ans_7 = '';$ques_ans_154 = '';
                             }
                            break;

                        case 155 :

                            $ques_ans_155 = is_array($singlelevel['answer']) ? implode(", ",$singlelevel['answer']): $singlelevel['answer'];
                            $ques_ans_155 = strtolower($ques_ans_155);
                            $layman_summar .= "The ".$cur_cc_name." is typically located ".($ques_ans_155  == 'all over' ? $ques_ans_155 : "at the ".$ques_ans_155).". ";
                            break;
                    }
                }
                break;
            }

            case 15:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                        case 111:

                            $ans = "";

                            if(is_array($singlelevel['answer']) && !in_array("I don't know",$singlelevel['answer'])){

                                if(is_array($singlelevel['answer']) && in_array('fall',$singlelevel['answer']))
                                {

                                    $ans_112 = $value[$k+1]['answer'];
                                    $ans_112 = is_array($ans_112) ? implode(", ", $ans_112) : $ans_112;
                                    $layman_summar .= "The pain started due to ".implode(", ", $singlelevel['answer'])." and the patient fell due to ".$ans_112.". ";

                                }
                                else
                                {

                                    $ans_111 = is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'];
                                    $layman_summar .= "The pain started due to ".($ans_111 == "I don't know" ? "unknown reasons" : $ans_111).". ";
                                }
                            }


                            break;

                        case 113:

                            $ques_ans_113 = $singlelevel['answer'] == 'Yes' ? ", happened at work":"";
                            if(!empty($ques_ans_114) && !empty($ques_ans_141) && !empty($ques_ans_142)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_141.$ques_ans_113.' '.$ques_ans_142.'. ';
                                $ques_ans_114 = ''; $ques_ans_141 = ''; $ques_ans_142 = ''; $ques_ans_113 = '';
                            }

                            break;

                        case 114:

                            $ques_ans_114 = 'The patient describes the pain as '.(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']));
                            if(!empty($ques_ans_114) && !empty($ques_ans_141) && !empty($ques_ans_142)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_141.$ques_ans_113.' '.$ques_ans_142.'. ';
                                $ques_ans_114 = ''; $ques_ans_141 = ''; $ques_ans_142 = ''; $ques_ans_113 = '';
                            }

                            break;

                        case 115:

                            $ques_ans_115 = strtolower($singlelevel['answer']);
                            $translate_115 = array(

                              'worse' => 'worsened',
                              'better' => 'improved',
                              'same' => 'remained stable'
                            );
                            $layman_summar .= "Current pain level has ".$translate_115[$ques_ans_115].' since initial presentation. ';

                            break;

                        case 116:

                            $ques_ans_116 = 'warmth to touch';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_116.', ' : $negative_ans .= $ques_ans_116.', ';

                            break;

                        case 117:

                            if($singlelevel['answer'] == 'Yes'){

                                $positive_ans .= "stiffness/pain in ".(is_array($value[$k+1]['answer']) ? implode(", ",$value[$k+1]['answer']) : $value[$k+1]['answer'])." joints, ";

                            }
                            else
                            {

                                $negative_ans .= "stiffness in other joints, pain in other joints, ";

                            }
                            break;

                        case 119:

                            $ques_ans_119 = 'abnormal hair/nail growth, sweating';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_119.', ' : $negative_ans .= $ques_ans_119.', ';
                            break;

                        case 138:

                            $ques_ans_138 = $singlelevel['answer'] == 'Yes' ? "worse when standing or putting weight on the side of pain" : "";

                            break;

                        case 139:

                            $ques_ans_139 = $singlelevel['answer'] == 'Yes' ? "worse with direct pressure on pain site" : "";

                            break;

                        case 140:

                            $ques_ans_140 = 'hip swelling';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_140.', ' : $negative_ans .= $ques_ans_140.', ';
                            break;

                        case 141:

                            $ques_ans_141 = $singlelevel['answer'];

                            if(isset($ques_ans_113) && !empty($ques_ans_114) && !empty($ques_ans_142)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_141.$ques_ans_113.' '.$ques_ans_142.'. ';
                                $ques_ans_114 = ''; $ques_ans_141 = ''; $ques_ans_142 = ''; $ques_ans_113 = '';
                            }
                            break;


                        case 142:

                            $ques_ans_142 = '';
                            $ques_ans_142 = "and is worse ".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer']);

                            if(strtolower($singlelevel['answer']) == 'morning' && isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 143 && $value[$k+1]['answer'] == 'Yes'){

                                $ques_ans_142 .= !empty($ques_ans_142) ? ', where the pain lasts for more than one hour': "";
                            }

                            if(isset($ques_ans_113) && !empty($ques_ans_114) && !empty($ques_ans_141)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_141.$ques_ans_113.' '.$ques_ans_142.'. ';
                                $ques_ans_114 = ''; $ques_ans_141 = ''; $ques_ans_142 = ''; $ques_ans_113 = '';
                            }
                            break;

                        case 124:
                            $ques_ans_124 = "The patient states that the pain is better with ".strtolower($singlelevel['answer']);
                            if(!empty($ques_ans_125)){

                                $layman_summar .= $ques_ans_124.$ques_ans_125.'. ';
                                $ques_ans_124 = ''; $ques_ans_125 = '';
                            }
                            //$layman_summar .= "The patient states that the pain is better with ".strtolower($singlelevel['answer']).", ";
                            break;

                        case 125:

                                $ques_ans_125 = ' and worse with '.str_replace("movement/excessive use", "movement, excessive use",$singlelevel['answer']);
                                $ques_ans_125 = trim($ques_ans_125,',');
                                if(isset($ques_ans_138) && !empty($ques_ans_138)){

                                    $ques_ans_125 .= ", ".$ques_ans_138;
                                }

                                if(isset($ques_ans_139) && !empty($ques_ans_139)){

                                    $ques_ans_125 .= ", ".$ques_ans_139;
                                }


                            if(!empty($ques_ans_124)){

                                $layman_summar .= $ques_ans_124.$ques_ans_125.'. ';
                                $ques_ans_124 = ''; $ques_ans_125 = '';
                            }
                            break;

                        case 126:

                            $ques_ans_126 = 'muscle spasms';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_126.', ' : $negative_ans .= $ques_ans_126.', ';
                            break;

                        case 144:

                            if(!empty($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 145)
                            {
                                $layman_summar .= "The pain is rated a ".$singlelevel['answer']."/10 at its best and a ".$value[$k+1]['answer']."/10 at its worst. ";
                            }
                            break;
                    }
                }
                break;
            }

            case 17:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                        case 1:
                            $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                            break;
                        case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;
                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;


                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;
                        case 6:
                            $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                            break;

                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:

                              $ques_ans_11 = $singlelevel['answer'];
                              if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                 // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                                 $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                              }
                            break;

                        case 159:

                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient noticed locking, catching, or feeling like the joint gives out.': "Denies instability symptoms of locking, catching, or feeling like the joint give out. ";
                            break;
                    }
                }
                break;
            }
            case 20:
            {

                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 6:
                            if($singlelevel['answer'] == 'Only after meals')
                            {

                                $ques_ans_6= ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(!empty($ques_ans_6) && !empty($ques_ans_72)){

                                $layman_summar .= $ques_ans_72.$ques_ans_6.'. ';
                                $ques_ans_72 ='';$ques_ans_6 = '';
                            }
                            break;

                        case 72:
                            $ques_ans_72 = "The symptoms have been experienced approximately ".$singlelevel['answer']." times total";
                            if(!empty($ques_ans_6) && !empty($ques_ans_72)){

                             	    $layman_summar .= $ques_ans_72.$ques_ans_6.'. ';
                             		$ques_ans_72 ='';$ques_ans_6 = '';
                             		}
                            break;

                        case 87:

                            $layman_summar .= "Recent history is significant for initiation of ".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).". ";
                            break;

                        case 88:

                            $ans_88 = $singlelevel['answer'];
                            $ques_ans_88 = $singlelevel['answer'] == 'Yes' ? "Positive for eating at a restaurant within 24 hours of symptoms" : "Denies eating at restaurants within 24 hours of symptoms. ";

                            if(!empty($ques_ans_91) && isset($ques_ans_89)){

                            	$layman_summar .= $ques_ans_91.$ques_ans_88.$ques_ans_89.'. ';
                            	$ques_ans_91 = '';
                            	$ques_ans_88 = '';
                            	$ques_ans_89 = '';
                            }
                            break;
                        case 89:

            				$ques_ans_89 = '';
                            if(isset($ans_88) && $ans_88 == 'Yes'){

                                $ques_ans_89 = ", and ate ".(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer'])." at ".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                            }

                            if(!empty($ques_ans_91) && !empty($ques_ans_88)){

                            	$layman_summar .= $ques_ans_91.$ques_ans_88.$ques_ans_89.'. ';
                            	$ques_ans_91 = '';
                            	$ques_ans_88 = '';
                            	$ques_ans_89 = '';
                            }

                            break;

                        case 91:

                            //$he = $gender == 0 ? "she":"he";

                            $ques_ans_91 = $singlelevel['answer'] == 'Yes' ? "Positive for contact with sick children within 24 hours of symptoms. " :"Denies being in contact with any sick children within 24 hours of symptoms starting. ";

                            if(!empty($ques_ans_88) && isset($ques_ans_89)){

                            	$layman_summar .= $ques_ans_91.$ques_ans_88.$ques_ans_89.'. ';
                            	$ques_ans_91 = '';
                            	$ques_ans_88 = '';
                            	$ques_ans_89 = '';
                            }
                            break;

                        case 92:

                            if($singlelevel['answer'] == 'Yes'){

                                $layman_summar .= "The patient is pregnant. ";
                              }
                              elseif($singlelevel['answer'] == 'No'){

                                $layman_summar .= "The patient is not pregnant. ";
                              }
                              else{

                                $layman_summar .= "The patient is not sure, she is pregnant. ";
                              }
                            break;
                    }
                }
                break;
            }
            case 22:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 156:

                            $ques_ans_156 = 'The patient states that the '.$cur_cc_name.' is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_157)){
                                $layman_summar .= $ques_ans_156.''.$ques_ans_157.'. ';
                                $ques_ans_156 = ''; $ques_ans_157 = '';
                              }
                            break;

                        case 157:

                            $ques_ans_157 = ' and worse with '.strtolower($singlelevel['answer']);


                            if(!empty($ques_ans_156)){
                                $layman_summar .= $ques_ans_156.''.$ques_ans_157.'. ';
                                $ques_ans_156 = ''; $ques_ans_157 = '';
                            }
                            break;
                    }
                }
                break;
            }

            case 23:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                        case 61:

                              $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                              if(!empty($ques_ans_62)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                              }
                            break;
                        case 62:

                            $ques_ans_62 = 'The patient states that the ' .strtolower($cur_cc_name).' is better with '.strtolower($singlelevel['answer']);

                              if(!empty($ques_ans_61)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                              }
                            break;
                        case 63:

                            $question_63 = $singlelevel['answer'];
                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.strtolower($cur_cc_name):'The patient has not been to the ER or admitted to the hospital for '.strtolower($cur_cc_name);
                            break;
                        case 64:

                              if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                                $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                              }
                              else{
                                $layman_summar .= '. ';
                              }

                            break;
                        case 65:
                            $question_65 = '';
                              if(!empty($singlelevel['answer'])){
                                $question_65 = $singlelevel['answer'];
                              }
                            break;
                        case 66:

                              $arr = array(
                                  '' => 'How long stay',
                                  "1" => '<24 hours',
                                  "2" => '1 day',
                                  "3" => '2 days',
                                  "4" => '3 days',
                                  "5" => '4 days',
                                  "6" => '5 days',
                                  "7" => '6 days',
                                  "8" => '1 week',
                                  "9" => '2 weeks',
                                  "10" => '3 weeks'
                                  );
                              $question_66 = '';
                              if(!empty($singlelevel['answer'])){

                                $question_66 .= $arr[$singlelevel['answer']];
                              }
                            break;

                        case 67:

                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                            $layman_summar .= '. ';
                            break;

                        case 68:

                            if(!empty($singlelevel['answer'])){

                              if($singlelevel['answer'] == 'No'){


                                $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              elseif($singlelevel['answer'] == 'Yes'){

                                $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              else{

                                $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                              }
                             }
                            break;

                        case 97:

                            $arr = array(

                                '' => '',
                                '1' => '/hour',
                                '2' => '/day',
                                '3' => '/week',
                                '4' => '/month'
                            );
                              $ques_ans_97 = ', approximately '.$singlelevel['answer'].' times'.$arr[$value[$k+1]['answer']];
                            if(isset($ques_ans_99) && !empty($ques_ans_99))
                            {
                            	$layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                            	$ques_ans_99 = '';
                            	$ques_ans_97 = '';
                            }

                            break;
                        case 99:
                            $arr = array(

                                '' => '',
                                '1' => 'Seconds',
                                '2' => 'mins',
                                '3' => 'Hours',
                                '4' => 'days'
                                );

                            $ques_ans_99 = 'The symptoms are experienced episodically at '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].'/episode';
                            if(isset($ques_ans_97) && !empty($ques_ans_97))
                            {
                            	$layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                            	$ques_ans_99 = '';
                            	$ques_ans_97 = '';
                            }
                            break;
                    }
                }
                break;
            }
            case 29:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                       case 44:

                            $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                            break;

                        case 45:

                            $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                            break;
                        case 46:

                            $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                            break;
                        case 47:

                            $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                            break;
                        case 48:

                            $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                            break;
                        case 49:

                            $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                            break;
                        case 50:

                            $ans_50 = $singlelevel['answer'];

                            $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                            break;
                        case 51:

                            if(isset($ans_50) && $ans_50 == 'Yes'){

                                $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                            }
                           break;
                        case 52:

                            $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                           break;
                        case 53:

                            $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                            $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                           break;
                    }
                }
                break;
            }
            case 33:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11))
                            {

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                        case 156:

                            $ques_ans_156 = 'The patient states that the '.$cur_cc_name.' is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_157)){
                                $layman_summar .= $ques_ans_156.''.$ques_ans_157.'. ';
                                $ques_ans_156 = ''; $ques_ans_157 = '';
                              }
                            break;

                        case 157:

                            $ques_ans_157 = ' and worse with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_156)){
                                $layman_summar .= $ques_ans_156.''.$ques_ans_157.'. ';
                                $ques_ans_156 = ''; $ques_ans_157 = '';
                              }

                            break;
                    }
                }
                break;
            }

            case 35:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 15:
                            $case_15_how_many_days = $singlelevel['answer'];
                            break;
                        case 18:

                            $translate_case18 = array("palm"=>"palmar", "back"=>"dorsal", "thumb side" => "radial aspect", "small finger side"=> "ulnar aspect") ;

                            $first_case18 = (stripos($singlelevel['answer'], 'both') !== FALSE ? 'palmar and dorsal' : (!empty($translate_case18[strtolower($singlelevel['answer'])]) ? $translate_case18[strtolower($singlelevel['answer'])] : $singlelevel['answer'] ));


                            $second_case18 =(!empty($more_options[$key][18])  ? (stripos($more_options[$key][18], 'both') !== FALSE  ? 'diffuse' : (!empty($translate_case18[strtolower($more_options[$key][18])]) ? $translate_case18[strtolower($more_options[$key][18])] : $more_options[$key][18] ) ) : '');
                            $layman_summar .=  "The ".$cur_cc_name." is localized to the ".$first_case18.' '.$second_case18.' of the hand. ' ;
                            break;

                        case 27:
                            $he = $gender == 0 ? "she":"he";
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;
                        case 28:

                            $ques_ans_28 = "The pain is described as ".$singlelevel['answer'].", " ;
                            if(!empty($ques_ans_29) && !empty($ques_ans_30))
                            {
                                $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            }
                            break;

                        case 29:

                            $ques_ans_29 = $singlelevel['answer'];
                            if(!empty($ques_ans_28) && !empty($ques_ans_30)){
                                $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            }
                            break;

                        case 30:

                            $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                            $singlelevel['answer'] = str_replace('Night', 'at Night', $singlelevel['answer']);
                            if($singlelevel['answer'] != 'at Night')
                            {
                                $ques_ans_30 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worse in the ". $singlelevel['answer']) ;
                            }
                            else
                            {
                          	     $ques_ans_30 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worse ". $singlelevel['answer']) ;
                            }
                            if(!empty($ques_ans_28) && !empty($ques_ans_29)){
                                $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            }
                            break;

                        case 10:

                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                        case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                            if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;

                        case 5:

                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;
                            if(!empty($ques_ans_4))
                            {
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;
                    }
                }
                break;
            }

            case 36:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 15:
                        $case_15_how_many_days = $singlelevel['answer'] ;
                        break;
                        case 16:
                        $ques_ans_16 = "Patient feels pain in ".(stripos($singlelevel['answer'], 'both') !== FALSE ? 'bilateral' : $singlelevel['answer'].'hand') ;
                        if(!empty($ques_ans_17)){
                        $layman_summar .= $ques_ans_16.', '.$ques_ans_17.'. ';
                        $ques_ans_16 = ''; $ques_ans_17 = '';
                        }
                        break;
                        case 17:
                        if(stripos($singlelevel['answer'], 'left') !== FALSE) $ques_ans_17 =  '(L>R)';
                        if(stripos($singlelevel['answer'], 'right') !== FALSE) $ques_ans_17 =  '(R>L)';
                        if(stripos($singlelevel['answer'], 'about') !== FALSE) $ques_ans_17 =  '(L=R)';
                        if(!empty($ques_ans_16)){
                        $layman_summar .= $ques_ans_16.' '.$ques_ans_17.'. ';
                        $ques_ans_16 = ''; $ques_ans_17 = '';
                        }
                        break;
                        case 18:
                        $translate_case18 = array("palm"=>"palmar", "back"=>"dorsal", "thumb side" => "radial aspect", "small finger side"=> "ulnar aspect") ;
                        $first_case18 = (stripos($singlelevel['answer'], 'both') !== FALSE ? 'palmar and dorsal' : (!empty($translate_case18[strtolower($singlelevel['answer'])]) ? $translate_case18[strtolower($singlelevel['answer'])] : $singlelevel['answer'] ));
                        $second_case18 =(!empty($more_options[$key][18])  ? (stripos($more_options[$key][18], 'both') !== FALSE  ? 'diffuse' : (!empty($translate_case18[strtolower($more_options[$key][18])]) ? $translate_case18[strtolower($more_options[$key][18])] : $more_options[$key][18] ) ) : '');
                        $layman_summar .=  "The ".$cur_cc_name." is localized to the ".$first_case18.' '.$second_case18.' of the hand. ' ;
                        break;
                        case 27:

                        $he  = $gender == 0 ? 'She': 'He';
                        $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                        break;
                        case 28:
                        $ques_ans_28 = "The pain is described as ".$singlelevel['answer'].", " ;
                        if(!empty($ques_ans_29) && !empty($ques_ans_30)){
                        $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                        $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                        }
                        break;
                        case 29:
                        $ques_ans_29 = $singlelevel['answer'] ;
                        if(!empty($ques_ans_28) && !empty($ques_ans_30)){
                        $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                        $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                        }
                        break;
                        case 30:
                        $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                        $ques_ans_30 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". $singlelevel['answer']) ;
                        if(!empty($ques_ans_28) && !empty($ques_ans_29)){
                        $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                        $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                        }
                        break;
                        case 10:
                        $ques_ans_10 = $singlelevel['answer'];
                        if(!empty($ques_ans_11)){
                        $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                        $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                        }
                        break;
                        case 11:
                        $ques_ans_11 = $singlelevel['answer'];
                        if(!empty($ques_ans_10)){
                        $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                        $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                        }
                        break;
                        case 4:
                        $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                        if(!empty($ques_ans_5)){
                        $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                        $ques_ans_4 = ''; $ques_ans_5 = '';
                        }
                        break;
                        case 5:
                        $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;
                        if(!empty($ques_ans_4)){
                        $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                        $ques_ans_4 = ''; $ques_ans_5 = '';
                        }
                        break;
                    }
                }
                break;
            }

            case 37:
            {
                //pr($value);die;
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                          case 15:

                            $case_15_how_many_days = $singlelevel['answer'] ;
                            break;
                          case 19:

                            $translate_case19 = array("thumb"=> "first digit", "index"=> "second digit", "middle"=> "third digit", "ring"=> "fourth digit", "little"=> "fifth digit");
                            if(is_array($singlelevel['answer']))
                            {
                                foreach ($singlelevel['answer'] as $k19 => $v19)
                                {
                                    $singlelevel['answer'][$k19] = !empty($translate_case19[strtolower($v19)]) ? $translate_case19[strtolower($v19)] : $v19 ;
                                }
                            }
                            $ques_ans_19 =  (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);

                            if(!empty($ques_ans_34))
                            {
                                $layman_summar .= ' The '.$cur_cc_name.' is located on the '.(stripos($ques_ans_34, 'joint') !== FALSE ? $ques_ans_34.' (***) in the ' : (stripos($ques_ans_34, 'front') !== FALSE ? 'anterior surface of the ' : $ques_ans_34)).$ques_ans_19.'. ';
                                $ques_ans_34 = '';  $ques_ans_19 = '' ;
                            }
                          break;

                          case 34:

                            $ques_ans_34 = $singlelevel['answer'] ;
                            if( !empty($ques_ans_19))
                            {
                                $layman_summar .= ' The '.$cur_cc_name.' is located on the '.(stripos($ques_ans_34, 'joint') !== FALSE ? $ques_ans_34.' (***) in the ' : (stripos($ques_ans_34, 'front') !== FALSE ? 'anterior surface of the ' : $ques_ans_34)).$ques_ans_19.'. ';
                                $ques_ans_34 = '';  $ques_ans_19 = '' ;
                            }
                            break;

                          case 35:

                                $ques_ans_35 =  $singlelevel['answer'] ;
                                $layman_summar = str_replace('***', $ques_ans_35, $layman_summar);
                          break;
                          case 27:

                            $he = $gender == 0 ? 'She' : 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;

                          case 28:

                              $ques_ans_28 = "The pain is described as ".$singlelevel['answer'].", " ;
                              if(!empty($ques_ans_29) && !empty($ques_ans_30))
                              {
                                  $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                  $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                              }
                              break;

                          case 29:
                                $ques_ans_29 = $singlelevel['answer'] ;
                                if(!empty($ques_ans_28) && !empty($ques_ans_30))
                                {
                                    $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                    $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                                }
                                break;
                          case 30:
                                $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                                $ques_ans_30 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". $singlelevel['answer']) ;
                                if(!empty($ques_ans_28) && !empty($ques_ans_29))
                                {
                                    $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                    $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                                }
                                break;

                          case 10:

                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11))
                            {
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                          case 11:
                                $ques_ans_11 = $singlelevel['answer'];
                                if(!empty($ques_ans_10)){
                                    $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                    $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                                }
                                break;
                          case 4:
                          $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                          if(!empty($ques_ans_5)){
                          $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                          $ques_ans_4 = ''; $ques_ans_5 = '';
                          }
                          break;
                          case 5:
                          $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;
                          if(!empty($ques_ans_4)){
                          $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                          $ques_ans_4 = ''; $ques_ans_5 = '';
                          }
                          break;
                    }
                }
                break;
            }
            case 38:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 15:
                      $case_15_how_many_days = $singlelevel['answer'] ;
                      break;
                      /*case 21:
                      $ques_ans_21 =  "Patient has ".$cur_cc_name." in " .(stripos($singlelevel['answer'], 'both') !== FALSE ? 'bilateral' : strtolower($singlelevel['answer']). " hand");
                      if(!empty($ques_ans_22)){
                      $layman_summar .= $ques_ans_21.''.$ques_ans_22.'. ';
                      $ques_ans_21 = ''; $ques_ans_22 = '';
                      }
                      break;
                      case 22:
                      $ques_ans_22 =  " and ".strtolower($singlelevel['answer'])." ".(stripos($singlelevel['answer'], 'both') !== FALSE ? 'wrists' : 'wrist') ;
                      if(!empty($ques_ans_21)){
                      $layman_summar .= $ques_ans_21.''.$ques_ans_22.'. ';
                      $ques_ans_21 = ''; $ques_ans_22 = '';
                      }
                      break; */
                    }
                }
                break;
            }
            case 39:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 15:
                              $case_15_how_many_days = $singlelevel['answer'] ;
                              break;

                        case 16:
                            $ques_ans_16 = "Patient feels pain in ".(stripos($singlelevel['answer'], 'both') !== FALSE ? 'bilateral' : $singlelevel['answer'].'hand') ;
                            if(!empty($ques_ans_17))
                            {
                                $layman_summar .= $ques_ans_16.', '.$ques_ans_17.'. ';
                                $ques_ans_16 = ''; $ques_ans_17 = '';
                            }

                            break;
                        case 17:

                            if(stripos($singlelevel['answer'], 'left') !== FALSE) $ques_ans_17 =  '(L>R)';
                            if(stripos($singlelevel['answer'], 'right') !== FALSE) $ques_ans_17 =  '(R>L)';
                            if(stripos($singlelevel['answer'], 'about') !== FALSE) $ques_ans_17 =  '(L=R)';
                            if(!empty($ques_ans_16))
                            {
                                $layman_summar .= $ques_ans_16.' '.$ques_ans_17.'. ';
                                $ques_ans_16 = ''; $ques_ans_17 = '';
                            }
                            break;

                        case 23:

                            $translate_case23 = array("thumb"=> "first digit", "index"=> "second digit", "middle"=> "third digit", "ring"=> "fourth digit", "little"=> "fifth digit");
                            if(is_array($singlelevel['answer']))
                            {
                                foreach ($singlelevel['answer'] as $k19 => $v19)
                                {
                                    $singlelevel['answer'][$k19] = !empty($translate_case23[strtolower($v19)]) ? $translate_case23[strtolower($v19)] : $v19 ;
                                }
                                $singlelevel['answer'] = implode(', ', $singlelevel['answer']) ;
                            }

                            $ques_ans_23 = '';
                            if($singlelevel['answer'] != 'Not on the fingers'){

                                $ques_ans_23 = stripos($singlelevel['answer'], ',') !== false ? $singlelevel['answer']." fingers" : (stripos($singlelevel['answer'], 'not') !== false ? strtolower($singlelevel['answer']).' ' :  strtolower($singlelevel['answer'])." finger"  );
                                $ques_ans_23 .= ', ';
                            }

                           /* if((isset($ques_ans_23) &&  !empty($ques_ans_23)) || (isset($ques_ans_24) && !empty($ques_ans_24)) || (isset($ques_ans_25) && !empty($ques_ans_25)))
                            {
                                $layman_summar .= "The numbness is located on the ".$ques_ans_24.''.$ques_ans_23.''.$ques_ans_25.'. ';
                                $ques_ans_24 = ''; $ques_ans_23 = ''; $ques_ans_25 = '';
                            } */
                            break;

                        case 24:

                            $translate_case24 = array("palm"=>"palmar surface", "back"=>"dorsal surface") ;
                            $ques_ans_24 = '';
                            if($singlelevel['answer'] != 'Not on the hand'){

                                $first_case24 = (stripos($singlelevel['answer'], 'both') !== FALSE ? 'palmar and dorsal surface' : (!empty($translate_case24[strtolower($singlelevel['answer'])]) ? $translate_case24[strtolower($singlelevel['answer'])] : $singlelevel['answer'] ));
                                $first_case24 = (stripos($first_case24, 'not') !== FALSE ? strtolower($first_case24) : strtolower($first_case24)) ;
                                $ques_ans_24 = $first_case24.', ';

                            }

                          /* if((isset($ques_ans_23) &&  !empty($ques_ans_23)) || (isset($ques_ans_24) && !empty($ques_ans_24)) || (isset($ques_ans_25) && !empty($ques_ans_25)))
                            {
                                $layman_summar .= "The numbness is located on the ".$ques_ans_24.''.$ques_ans_23.''.$ques_ans_25.'. ';
                                $ques_ans_24 = ''; $ques_ans_23 = ''; $ques_ans_25 = '';
                            }  */
                            break;

                        case 25:

                            $ques_ans_25 = '';
                            if($singlelevel['answer'] != 'Not on the forearm'){

                                $ques_ans_25 = strtolower($singlelevel['answer']) ;
                            }

                            if((isset($ques_ans_23) &&  !empty($ques_ans_23)) || (isset($ques_ans_24) && !empty($ques_ans_24)) || (isset($ques_ans_25) && !empty($ques_ans_25)))
                            {
                                $layman_summar .= "The numbness is located on the ".$ques_ans_24.''.$ques_ans_23.''.$ques_ans_25.'. ';
                                $ques_ans_24 = ''; $ques_ans_23 = ''; $ques_ans_25 = '';
                            }
                            break;

                        case 27:

                            $he = $gender == 0 ? 'She' : 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;
                    }
                }
                break;
            }
            case 40:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 15:

                            $case_15_how_many_days = $singlelevel['answer'] ;
                            break;
                        case 16:
                            $ques_ans_16 = "Patient feels pain in ".(stripos($singlelevel['answer'], 'both') !== FALSE ? 'bilateral' : $singlelevel['answer'].'hand') ;
                            if(!empty($ques_ans_17))
                            {
                                $layman_summar .= $ques_ans_16.', '.$ques_ans_17.'. ';
                                $ques_ans_16 = ''; $ques_ans_17 = '';
                            }
                            break;
                        case 17:
                            if(stripos($singlelevel['answer'], 'left') !== FALSE) $ques_ans_17 =  '(L>R)';
                            if(stripos($singlelevel['answer'], 'right') !== FALSE) $ques_ans_17 =  '(R>L)';
                            if(stripos($singlelevel['answer'], 'about') !== FALSE) $ques_ans_17 =  '(L=R)';
                            if(!empty($ques_ans_16))
                            {
                                $layman_summar .= $ques_ans_16.' '.$ques_ans_17.'. ';
                                $ques_ans_16 = ''; $ques_ans_17 = '';
                            }
                            break;

                        case 23:
                            $translate_case23 = array("thumb"=> "first digit", "index"=> "second digit", "middle"=> "third digit", "ring"=> "fourth digit", "little"=> "fifth digit");
                            if(is_array($singlelevel['answer']))
                            {
                                foreach ($singlelevel['answer'] as $k19 => $v19)
                                {
                                    $singlelevel['answer'][$k19] = !empty($translate_case23[strtolower($v19)]) ? $translate_case23[strtolower($v19)] : $v19 ;
                                }
                                $singlelevel['answer'] = implode(', ', $singlelevel['answer']) ;
                            }
                            $ques_ans_23 = stripos($singlelevel['answer'], ',') !== false ? " and on the ".$singlelevel['answer']." fingers " : (stripos($singlelevel['answer'], 'not') !== false ?  " and ".strtolower($singlelevel['answer']).' ' :  " and on the ".strtolower($singlelevel['answer'])." finger "  );
                            if(!empty($ques_ans_24) && !empty($ques_ans_25))
                            {
                                $layman_summar .= $ques_ans_24.''.$ques_ans_23.''.$ques_ans_25.'. ';
                                $ques_ans_24 = ''; $ques_ans_23 = ''; $ques_ans_25 = '';
                            }
                            break;

                        case 24:

                            $translate_case24 = array("palm"=>"palmar surface", "back"=>"dorsal surface") ;
                            $first_case24 = (stripos($singlelevel['answer'], 'both') !== FALSE ? 'palmar and dorsal surface' : (!empty($translate_case24[strtolower($singlelevel['answer'])]) ? $translate_case24[strtolower($singlelevel['answer'])] : $singlelevel['answer'] ));

                            $first_case24 = (stripos($first_case24, 'not') !== FALSE ? "The feeling is  ".strtolower($first_case24) : "The feeling is typically on the ".strtolower($first_case24)) ;
                            $ques_ans_24 = $first_case24  ;
                            if(!empty($ques_ans_23) && !empty($ques_ans_25))
                            {
                                $layman_summar .= $ques_ans_24.''.$ques_ans_23.''.$ques_ans_25.'. ';
                                $ques_ans_24 = ''; $ques_ans_23 = ''; $ques_ans_25 = '';
                            }
                            break;
                        case 25:
                            $ques_ans_25 = "and ".strtolower($singlelevel['answer']) ;
                            if(!empty($ques_ans_23) && !empty($ques_ans_24))
                            {
                                $layman_summar .= $ques_ans_24.''.$ques_ans_23.''.$ques_ans_25.'. ';
                                $ques_ans_24 = ''; $ques_ans_23 = ''; $ques_ans_25 = '';
                            }
                            break;
                    }
                }
                break;
            }

            case 41:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 15:
                            $case_15_how_many_days = $singlelevel['answer'] ;
                            break;

                        case 27:

                            $he = $gender == 0? 'She': 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;
                    }
                }
                break;
            }
            case 42:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 42:
                            $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                            $ques_ans_42 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". strtolower($singlelevel['answer']) ) ;
                            if(!empty($ques_ans_39) && !empty($ques_ans_41))
                            {
                                if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);
                                $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                                $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                            break;

                        case 15:
                            $case_15_how_many_days = $singlelevel['answer'] ;
                            break;

                        case 27:

                            $he = $gender == 0? 'She': 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;


                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11))
                            {
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                        case 11:
                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10))
                            {
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                        case 39:

                            $ques_ans_39 = "The pain is described as ".strtolower(implode(', ', $singlelevel['answer'])).", " ;
                            $ques_ans_39 = stripos($ques_ans_39, 'none') ? "The pain is described as " : $ques_ans_39 ; // In case of "none of the above", we remove the option

                            if(!empty($ques_ans_41) && !empty($ques_ans_42))
                            {
                                if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39) ;
                                $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                                $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                            break;

                          case 40:
                          $ques_ans_40 = $singlelevel['answer'] ;  // in case of radiating this will not be empty
                          break;
                          case 41:
                          $ques_ans_41 = strtolower($singlelevel['answer'])  ;
                          if(!empty($ques_ans_39) && !empty($ques_ans_42)){
                          if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);
                          $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                          $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                          }
                          break;
                          case 42:
                          // now input type is checkbox
                          $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                          $ques_ans_42 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". strtolower($singlelevel['answer']) ) ;
                          if(!empty($ques_ans_39) && !empty($ques_ans_41)){
                          if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);
                          $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                          $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                          }
                          break;
                          case 43:
                          $temp_str_43 = $this->cheif_complaint_question_43($singlelevel['answer']);
                          $layman_summar .=  "The pain is localized to the ".$temp_str_43.". " ;
                          break;
                          case 4:
                          $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                          if(!empty($ques_ans_5)){
                          $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                          $ques_ans_4 = ''; $ques_ans_5 = '';
                          }
                          break;
                          case 5:
                          $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;
                          if(!empty($ques_ans_4)){
                          $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                          $ques_ans_4 = ''; $ques_ans_5 = '';
                          }
                          break;
                    }
                }
                break;
            }
            case 43:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 15:
                      $case_15_how_many_days = $singlelevel['answer'] ;
                      break;
                      case 27:
                          $he = $gender == 0? 'She': 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;
                      case 10:
                      $ques_ans_10 = $singlelevel['answer'];
                      if(!empty($ques_ans_11)){
                      $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                      $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                      }
                      break;
                      case 11:
                      $ques_ans_11 = $singlelevel['answer'];
                      if(!empty($ques_ans_10)){
                      $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                      $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                      }
                      break;
                      case 39:
                      $ques_ans_39 = "The pain is described as ".strtolower(implode(', ', $singlelevel['answer'])).", " ;

                      $ques_ans_39 = stripos($ques_ans_39, 'none') ? "The pain is described as " : $ques_ans_39 ; // In case of "none of the above", we remove the option

                      if(!empty($ques_ans_41) && !empty($ques_ans_42)){
                      if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39) ;
                      $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                      $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                      }
                      break;
                      case 40:
                      $ques_ans_40 = $singlelevel['answer'] ;  // in case of radiating this will not be empty
                      break;
                      case 41:
                      $ques_ans_41 = strtolower($singlelevel['answer'])  ;
                      if(!empty($ques_ans_39) && !empty($ques_ans_42)){
                      if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);
                      $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                      $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                      }
                      break;
                      case 42:
                      // now input type is checkbox
                      $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                      $ques_ans_42 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". strtolower($singlelevel['answer']) ) ;
                      if(!empty($ques_ans_39) && !empty($ques_ans_41)){
                      if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);
                      $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                      $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                      }
                      break;
                      case 4:
                        $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                        if(!empty($ques_ans_5)){
                        $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                        $ques_ans_4 = ''; $ques_ans_5 = '';
                        }
                      break;
                      case 5:
                        $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;
                        if(!empty($ques_ans_4)){
                        $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                        $ques_ans_4 = ''; $ques_ans_5 = '';
                      }
                      break;
                    }
                }
                break;
            }
            case 44:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 15:
                        $case_15_how_many_days = $singlelevel['answer'] ;
                        break;
                        case 36:
                                if(is_array($singlelevel['answer'])){
                                  $temp_36_ar = array();
                                  foreach ($singlelevel['answer'] as $k36 => $v36) {
                                      $t36 = explode('-', $v36);
                                     $temp_36_ar[] = !empty($t36[1]) ? (stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
                                  }
                                  $singlelevel['answer'] = $temp_36_ar ;
                                }
                              $layman_summar .=  "The patient feels ".$cur_cc_name." in the ".strtolower(implode(', ', $singlelevel['answer'])).'. ' ;
                        break;
                        case 27:
                            $he = $gender == 0? 'She': 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;
                    }
                }
                break;
            }
            case 45:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 15:
                      $case_15_how_many_days = $singlelevel['answer'] ;
                      break;
                      case 37:
                      if(is_array($singlelevel['answer'])){
                        $temp_36_ar = array();
                        foreach ($singlelevel['answer'] as $k36 => $v36) {
                            $t36 = explode('-', $v36);

                           $temp_36_ar[] = !empty($t36[1]) ? (stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
                        }
                        $singlelevel['answer'] = $temp_36_ar ;
                      }
                        $layman_summar .=  "The patient feels ".$cur_cc_name." in the ".strtolower(implode(', ', $singlelevel['answer'])).'. ' ;
                         break;

                    }
                }
                break;
            }

            case 46:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 15:
                      $case_15_how_many_days = $singlelevel['answer'] ;
                      break;
                      case 38:
                        if(is_array($singlelevel['answer'])){
                        $temp_36_ar = array();
                        foreach ($singlelevel['answer'] as $k36 => $v36) {
                          $t36 = explode('-', $v36);
                         // $temp_36_ar[] = !empty($t36[1]) ? $t36[0].' ('.(stripos($t36[1], 'both') !== false ? 'bilateral' : $t36[1] ).')' : $t36[0] ;
                         $temp_36_ar[] = !empty($t36[1]) ? (stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
                        }
                        $singlelevel['answer'] = $temp_36_ar ;
                        }

                        $layman_summar .=  "The patient feels weakness in the ".strtolower(implode(', ', $singlelevel['answer'])).'. ' ;
                        break;

                    }
                }
                break;
            }

            case 47:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 15:
                             $case_15_how_many_days = $singlelevel['answer'] ;
                      break;
                      case 27:
                          $he = $gender == 0? 'She': 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;
                      case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                      case 11:
                          $ques_ans_11 = $singlelevel['answer'];
                          if(!empty($ques_ans_10)){
                              $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                              $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                          }
                         break;
                      case 39:
                            $ques_ans_39 = "The pain is described as ".strtolower(implode(', ', $singlelevel['answer'])).", " ;

                            $ques_ans_39 = stripos($ques_ans_39, 'none') ? "The pain is described as " : $ques_ans_39 ; // In case of "none of the above", we remove the option

                            if(!empty($ques_ans_41) && !empty($ques_ans_42)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39) ;
                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                      break;
                      case 40:
                             $ques_ans_40 = $singlelevel['answer'] ;  // in case of radiating this will not be empty
                      break;
                      case 41:
                            $ques_ans_41 = strtolower($singlelevel['answer'])  ;
                            if(!empty($ques_ans_39) && !empty($ques_ans_42)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);
                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                      break;
                      case 42:
                            $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                            $ques_ans_42 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". strtolower($singlelevel['answer']) ) ;
                            if(!empty($ques_ans_39) && !empty($ques_ans_41)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);
                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                      break;
                      case 43:
                          $temp_str_43 = $this->cheif_complaint_question_43($singlelevel['answer']);
                          $layman_summar .=  "The pain is localized to the ".$temp_str_43.". " ;

                          break;
                          case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                          break;
                          case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;

                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                          break;

                    }
                }
                break;
            }
            case 50:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                       case 1:
                         $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                       break;
                       case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                       break;
                       case 5:
                          $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;

                            if(!empty($ques_ans_4)){
                              $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                              $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                       break;
                      case 6:
                          $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                      break;
                      case 10:
                          $ques_ans_10 = $singlelevel['answer'];
                          if(!empty($ques_ans_11)){

                              $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                              $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                          }
                        break;
                      case 11:
                          $ques_ans_11 = $singlelevel['answer'];
                          if(!empty($ques_ans_10)){
                              $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                              $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                          }
                      break;
                      case 159:
                      $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient noticed locking, catching, or feeling like the joint gives out. ': "Denies instability symptoms of locking, catching, or feeling like the joint give out. ";
                      break;

                    }
                }
                break;
            }
            case 52:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 44:

                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";

                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }

            case 53:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 44:
                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }

            case 54:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 44:
                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }
            case 55:
            {
                foreach ($value as $k => $singlelevel) {

                    switch($singlelevel['question_id'])
                    {
                        case 44:
                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }

            case 56:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 44:
                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }

            case 57:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 44:
                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }

            case 58:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                        case 44:
                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }

            case 59:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 44:
                           $layman_summar .=  ($gender == 0 ? 'She' : 'He')." goes to bed around ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." each night. ";
                         break;
                        case 45:
                           $layman_summar .=  "Sleep onset occurs in approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes. " ;
                         break;
                        case 46:
                           $layman_summar .=  "Patient sleeps for approximately ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours each night. " ;
                         break;
                        case 47:
                           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Accepts leaving TV on or using phone while in bed. " : "Denies leaving TV on or using phone. " ;
                         break;
                        case 48:
                           $layman_summar .=  "Patient takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trips to the bathroom in the middle of the night. " ;
                         break;
                        case 49:
                           $layman_summar .= $singlelevel['answer'] == 'Yes'? "Patient feels rested in the morning. " : "Patient does not feel rested in the morning. " ;
                         break;
                        case 50:
                          $ans_50 = $singlelevel['answer'];
                           $layman_summar .=  $ans_50 == 'Yes' ? ($gender == '0' ? 'She' : "He")." take naps during the day. " : "Denies taking naps during the day. ";
                         break;
                        case 51:
                          if(isset($ans_50) && $ans_50 == 'Yes'){
                              $layman_summar .=  "Takes ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." nap/day. " ;
                          }
                         break;
                        case 52:
                           $layman_summar .=  "Works ".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours/wk. " ;
                         break;
                        case 53:
                          $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
                          $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "Currently does exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "").". " : "Currently does not exercise. ";
                         break;

                    }
                }
                break;
            }

            case 60:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                      case 61:

                          $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);

                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:

                            $arr = array(

                                '' => '',
                                '1' => '/hour',
                                '2' => '/day',
                                '3' => '/week',
                                '4' => '/month'
                            );
                              $ques_ans_97 = ', approximately '.$singlelevel['answer'].' times'.$arr[$value[$k+1]['answer']];
                            if(isset($ques_ans_99) && !empty($ques_ans_99))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }

                            break;
                        case 99:
                            $arr = array(

                                '' => '',
                                '1' => 'Seconds',
                                '2' => 'mins',
                                '3' => 'Hours',
                                '4' => 'days'
                                );

                            $ques_ans_99 = 'The symptoms are experienced episodically at '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].'/episode';
                            if(isset($ques_ans_97) && !empty($ques_ans_97))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }
                            break;

                    }
                }
                break;
            }

             case 61:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 61:
                          $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);

                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:

                            $arr = array(

                                '' => '',
                                '1' => '/hour',
                                '2' => '/day',
                                '3' => '/week',
                                '4' => '/month'
                            );
                              $ques_ans_97 = ', approximately '.$singlelevel['answer'].' times'.$arr[$value[$k+1]['answer']];
                            if(isset($ques_ans_99) && !empty($ques_ans_99))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }

                            break;
                        case 99:
                            $arr = array(

                                '' => '',
                                '1' => 'Seconds',
                                '2' => 'mins',
                                '3' => 'Hours',
                                '4' => 'days'
                                );

                            $ques_ans_99 = 'The symptoms are experienced episodically at '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].'/episode';
                            if(isset($ques_ans_97) && !empty($ques_ans_97))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }
                            break;

                    }
                }
                break;
            }

            case 63:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 61:
                           $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);

                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:

                            $arr = array(

                                '' => '',
                                '1' => '/hour',
                                '2' => '/day',
                                '3' => '/week',
                                '4' => '/month'
                            );
                              $ques_ans_97 = ', approximately '.$singlelevel['answer'].' times'.$arr[$value[$k+1]['answer']];
                            if(isset($ques_ans_99) && !empty($ques_ans_99))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }

                            break;
                        case 99:
                            $arr = array(

                                '' => '',
                                '1' => 'Seconds',
                                '2' => 'mins',
                                '3' => 'Hours',
                                '4' => 'days'
                                );

                            $ques_ans_99 = 'The symptoms are experienced episodically at '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].'/episode';
                            if(isset($ques_ans_97) && !empty($ques_ans_97))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }
                            break;

                    }
                }
                break;
            }

             case 64:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 61:
                          $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);

                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:
                            $arr = array(
                            '' => '',
                            '1' => 'Per hour',
                            '2' => 'Per day',
                            '3' => 'Per week',
                            '4' => 'Per month'
                            );
                            $layman_summar .= 'It occurs about '.$singlelevel['answer'].' times '. $arr[$value[$k+1]['answer']];
                            if(isset($question_ans_96) && !empty($question_ans_96)){
                            $layman_summar .= ', most often '.$question_ans_96.". ";
                            }
                            else{
                            $layman_summar .= ". ";
                            }
                        break;
                        case 99:
                        $arr = array(
                        '' => '',
                        '1' => 'Seconds',
                        '2' => 'Minutes',
                        '3' => 'Hours',
                        '4' => 'days'
                        );
                        $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].' long. ';
                        break;

                    }
                }
                break;
            }

             case 65:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 61:
                          $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);


                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name : 'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:
                            $arr = array(
                            '' => '',
                            '1' => 'Per hour',
                            '2' => 'Per day',
                            '3' => 'Per week',
                            '4' => 'Per month'
                            );
                            $layman_summar .= 'It occurs about '.$singlelevel['answer'].' times '. $arr[$value[$k+1]['answer']];
                            if(isset($question_ans_96) && !empty($question_ans_96)){
                            $layman_summar .= ', most often '.$question_ans_96.". ";
                            }
                            else{
                            $layman_summar .= ". ";
                            }
                        break;
                        case 99:
                        $arr = array(
                        '' => '',
                        '1' => 'Seconds',
                        '2' => 'Minutes',
                        '3' => 'Hours',
                        '4' => 'days'
                        );
                        $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].' long. ';
                        break;

                    }
                }
                break;
            }

            case 66:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 61:
                          $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);


                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:
                            $arr = array(
                            '' => '',
                            '1' => 'Per hour',
                            '2' => 'Per day',
                            '3' => 'Per week',
                            '4' => 'Per month'
                            );
                            $layman_summar .= 'It occurs about '.$singlelevel['answer'].' times '. $arr[$value[$k+1]['answer']];
                            if(isset($question_ans_96) && !empty($question_ans_96)){
                            $layman_summar .= ', most often '.$question_ans_96.". ";
                            }
                            else{
                            $layman_summar .= ". ";
                            }
                        break;
                        case 99:
                        $arr = array(
                        '' => '',
                        '1' => 'Seconds',
                        '2' => 'Minutes',
                        '3' => 'Hours',
                        '4' => 'days'
                        );
                        $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].' long. ';
                        break;

                    }
                }
                break;
            }

            case 67:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 61:

                            $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);


                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:
                            $arr = array(
                            '' => '',
                            '1' => 'Per hour',
                            '2' => 'Per day',
                            '3' => 'Per week',
                            '4' => 'Per month'
                            );
                            $layman_summar .= 'It occurs about '.$singlelevel['answer'].' times '. $arr[$value[$k+1]['answer']];
                            if(isset($question_ans_96) && !empty($question_ans_96)){
                            $layman_summar .= ', most often '.$question_ans_96.". ";
                            }
                            else{
                            $layman_summar .= ". ";
                            }
                        break;
                        case 99:
                        $arr = array(
                        '' => '',
                        '1' => 'Seconds',
                        '2' => 'Minutes',
                        '3' => 'Hours',
                        '4' => 'days'
                        );
                        $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].' long. ';
                        break;

                    }
                }
                break;
            }

            case 68:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 61:
                           $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);


                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 63:
                        $question_63 = $singlelevel['answer'];
                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;
                        break;
                      case 64:
                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }
                        break;
                      case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }
                        break;
                      case 66:
                            $arr = array(
                            '' => 'How long stay',
                            "1" => '<24 hours',
                            "2" => '1 day',
                            "3" => '2 days',
                            "4" => '3 days',
                            "5" => '4 days',
                            "6" => '5 days',
                            "7" => '6 days',
                            "8" => '1 week',
                            "9" => '2 weeks',
                            "10" => '3 weeks'
                            );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                            }
                        break;
                      case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }
                        $layman_summar .= '. ';
                        break;
                       case 68:
                        if(!empty($singlelevel['answer'])){
                          if($singlelevel['answer'] == 'No'){
                            $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          elseif($singlelevel['answer'] == 'Yes'){
                            $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                          }
                          else{
                            $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                          }
                         }
                        break;
                        case 97:
                            $arr = array(
                            '' => '',
                            '1' => 'Per hour',
                            '2' => 'Per day',
                            '3' => 'Per week',
                            '4' => 'Per month'
                            );
                            $layman_summar .= 'It occurs about '.$singlelevel['answer'].' times '. $arr[$value[$k+1]['answer']];
                            if(isset($question_ans_96) && !empty($question_ans_96)){
                            $layman_summar .= ', most often '.$question_ans_96.". ";
                            }
                            else{
                            $layman_summar .= ". ";
                            }
                        break;
                        case 99:
                        $arr = array(
                        '' => '',
                        '1' => 'Seconds',
                        '2' => 'Minutes',
                        '3' => 'Hours',
                        '4' => 'days'
                        );
                        $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].' long. ';
                        break;

                    }
                }
                break;
            }

            case 69:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                      case 70:
                          $ques_ans_70 = 'The symptoms are experienced approximately '.$singlelevel['answer']." times/day";
                          if(!empty($ques_ans_96)){
                            $layman_summar .= $ques_ans_70.''.$ques_ans_96.'. ';
                            $ques_ans_70 = ''; $ques_ans_96 = '';
                          }
                      break;
                      case 61:
                           $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                          if(!empty($ques_ans_62)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                      case 62:

                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);


                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }
                        break;
                        case 96:
                        $question_96 = is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])): strtolower($singlelevel['answer']);
                        $ques_ans_96 = " and is ";
                        if($question_96 == 'same all day'){

                            $ques_ans_96 .= "the ".$question_96;
                        }
                        else if($question_96 == 'only after meals'){

                            $ques_ans_96 .= "the worst ".$question_96;
                        }
                        elseif($question_96 == 'same all day'){

                            $ques_ans_96 .= $question_96;
                        }
                        else{

                            $ques_ans_96 .= 'the worst in the '.$question_96;
                        }
                        if(!empty($ques_ans_70)){
                            $layman_summar .= $ques_ans_70.''.$ques_ans_96.'. ';
                            $ques_ans_70 = ''; $ques_ans_96 = '';
                        }

                        break;

                    }
                }
                break;
            }

            case 70:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                          case 6:
                          $ques_ans_6 = '';
                          if($singlelevel['answer'] == 'Only after meals'){
                          $ques_ans_6 =  ", occurring most often ".strtolower($singlelevel['answer']);
                          }
                          elseif($singlelevel['answer'] == 'Same all day')
                          {

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }

                          else{
                          $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                          }
                          if(!empty($ques_ans_8)){
                          $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                          $ques_ans_8 = ''; $ques_ans_6 = '';
                          }
                          break;
                          case 10:
                              $ques_ans_10 = $singlelevel['answer'];
                              if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                              }
                          break;
                          case 11:
                              $ques_ans_11 = $singlelevel['answer'];
                              if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                              }
                          break;
                          case 13:
                              $layman_summar .=   $singlelevel['answer'] == 'Yes' ? "Patient tried medication"  : "Patient didn't try medication. " ;

                          break;
                          case 14:
                                $layman_summar .=  $singlelevel['answer'] == 'Yes' ? ", and since then the pain has improved."  : ", and since then the pain hasn't improved." ;

                          break;
                          case 61:

                            $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                            if(!empty($ques_ans_62)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                            }

                            break;
                          case 62:
                            $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);

                            if(!empty($ques_ans_61)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                            }

                            break;
                          case 63:

                            $question_63 = $singlelevel['answer'];

                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;

                            break;

                          case 64:

                            if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                                $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                            }
                            else{
                                $layman_summar .= '. ';
                            }

                            break;
                          case 65:

                            $question_65 = '';
                            if(!empty($singlelevel['answer'])){
                                $question_65 = $singlelevel['answer'];
                            }

                            break;
                          case 66:

                            $arr = array(
                                  '' => 'How long stay',
                                  "1" => '<24 hours',
                                  "2" => '1 day',
                                  "3" => '2 days',
                                  "4" => '3 days',
                                  "5" => '4 days',
                                  "6" => '5 days',
                                  "7" => '6 days',
                                  "8" => '1 week',
                                  "9" => '2 weeks',
                                  "10" => '3 weeks'
                                  );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                                $question_66 .= $arr[$singlelevel['answer']];
                            }

                            break;

                          case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }

                            $layman_summar .= '. ';
                            break;
                          case 68:
                            if(!empty($singlelevel['answer'])){

                              if($singlelevel['answer'] == 'No'){


                                $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              elseif($singlelevel['answer'] == 'Yes'){

                                $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              else{

                                $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                              }
                             }
                            break;
                          case 69:
                            /*if($cur_cc_name != 'chest pain' && $cur_cc_name != 'chest pressure' && $cur_cc_name != 'pain in chest'){
                                $layman_summar .= 'The patient can climb '.$singlelevel['answer'].' flights of stairs without stopping. ';
                            }*/
                            break;
                          case 101:
                                 $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer'])).'. ';
                          break;
                          case 94:
                          $layman_summar .= "Radiating: ".implode(", ", $singlelevel['answer']).'. ';
                          break;
                          case 95:
                          $ans_95  = is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']);
                          if($ans_95 == 'no'){
                          $layman_summar .= "The pain does not travel. ";
                          }
                          else{
                          $layman_summar .= "The pain travels to: ".$ans_95.'. ';
                          }
                          break;
                          case 97:
                            $arr = array(
                              '' => '',
                              '1' => 'Per hour',
                              '2' => 'Per day',
                              '3' => 'Per week',
                              '4' => 'Per month'
                              );
                            $layman_summar .= 'It occurs about '.$singlelevel['answer'].' times '. $arr[$value[$k+1]['answer']];
                            if(isset($question_ans_96) && !empty($question_ans_96)){
                              $layman_summar .= ', most often '.$question_ans_96.". ";
                            }
                            else{
                              $layman_summar .= ". ";
                            }
                          break;
                         case 99:
                           $arr = array(
                              '' => '',
                              '1' => 'Seconds',
                              '2' => 'Minutes',
                              '3' => 'Hours',
                              '4' => 'days'
                              );
                          $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].' long. ';
                          break;
                          case 103:
                            $temp_str_103 = '';

                            if(!empty($singlelevel['answer'])){

                              $singlelevel['answer'] = array_filter(explode(',', $singlelevel['answer'])) ;
                              //pr($singlelevel['answer']);die;

                              if(in_array('left-bottom-left',$singlelevel['answer'])){

                                $key = array_search('left-bottom-left', $singlelevel['answer']);
                                $singlelevel['answer'][$key] = 'left-bottom-right';
                              }

                              if(in_array('right-bottom-left',$singlelevel['answer'])){

                                $key = array_search('right-bottom-left', $singlelevel['answer']);
                                $singlelevel['answer'][$key] = 'right-bottom-right';
                              }

                              //pr($gender);die;

                              $right_chest_s = 'Right chest(';
                              $left_chest_s = 'Left chest(';
                              $breastbone_s = 'Breastbone(';
                              $right_breast_s = 'Right breast(';
                              $left_breast_s = 'Left breast(';

                              $right_chest_len = strlen($right_chest_s);
                              $left_chest_len = strlen($left_chest_s);

                              $breastbone_len = strlen($breastbone_s);
                              $right_breast_len = strlen($right_breast_s);
                              $left_breast_len = strlen($left_breast_s);

                              if($gender == 1){

                                $breastbone = array('mid-bottom','mid-mid','mid-top');
                                $left_chest = array('right-bottom-left','right-bottom-right','right-chest','right-top','right-nipple');
                                $right_chest = array('right-top1','left-chest','left-bottom-left','left-bottom-right','left-nipple');

                                $answer = array_unique($singlelevel['answer']);

                                foreach ($answer as $key => $ans) {

                                  $temp_val = isset($img_chest_man_pain_detial_q_arr[$ans]) ? $img_chest_man_pain_detial_q_arr[$ans] : "" ;

                                    if(in_array($ans, $breastbone) && !empty($temp_val)){

                                        $breastbone_s .= $temp_val.', ';

                                     }
                                     elseif(in_array($ans, $left_chest) && !empty($temp_val)){

                                        $left_chest_s .= $temp_val.', ';
                                     }
                                    elseif (in_array($ans, $right_chest) && !empty($temp_val)) {

                                        $right_chest_s .= $temp_val.', ';
                                       // echo $luq_s.'<br>';
                                    }
                                }
                              }

                              if($gender == 0){

                                $right_chest = array('left1','left2');
                                $left_chest = array('right1','right2');

                                $right_breast = array('left9','left3','left4','left6','left5','left7','left8');
                                $left_breast = array('right3','right4','right5','right6','right8','right7','right9');

                                $breastbone = array('mid1','mid2','mid3');

                                  $answer = array_unique($singlelevel['answer']);

                                  foreach ($answer as $key => $ans) {

                                    $temp_val = isset($img_chest_female_pain_detial_q_arr[$ans]) ? $img_chest_female_pain_detial_q_arr[$ans] : "" ;

                                      if(in_array($ans, $breastbone) && !empty($temp_val)){

                                          $breastbone_s .= $temp_val.', ';

                                       }
                                       elseif(in_array($ans, $left_chest) && !empty($temp_val)){

                                          $left_chest_s .= $temp_val.', ';
                                       }
                                      elseif (in_array($ans, $right_chest) && !empty($temp_val)) {

                                          $right_chest_s .= $temp_val.', ';
                                         // echo $luq_s.'<br>';
                                      }
                                      elseif(in_array($ans, $right_breast) && !empty($temp_val)){

                                          $right_breast_s .= $temp_val.', ';
                                       }
                                      elseif (in_array($ans, $left_breast) && !empty($temp_val)) {

                                          $left_breast_s .= $temp_val.', ';
                                         // echo $luq_s.'<br>';
                                      }
                                  }
                                }

                              if(strlen($right_chest_s) > $right_chest_len){

                                  $right_chest_s = rtrim($right_chest_s,', ');
                                  $temp_str_103 .= $right_chest_s.'), ';
                              }

                              if(strlen($left_chest_s) > $left_chest_len){

                                  $left_chest_s = rtrim($left_chest_s,', ');
                                  $temp_str_103 .= $left_chest_s.'), ';
                              }

                              if(strlen($breastbone_s) > $breastbone_len){

                                $breastbone_s = rtrim($breastbone_s,', ');
                                $temp_str_103 .= $breastbone_s.'), ';
                              }

                              if(strlen($right_breast_s) > $right_breast_len){

                                  $right_breast_s = rtrim($right_breast_s,', ');
                                  $temp_str_103 .= $right_breast_s.'), ';
                              }

                              if(strlen($left_breast_s) > $left_breast_len){

                                  $left_breast_s = rtrim($left_breast_s,', ');
                                  $temp_str_103 .= $left_breast_s.'), ';
                              }

                              $temp_str_103 = rtrim($temp_str_103, ', ');
                                //echo $ruq_s.'<br>'.$rlq_s.'<br>'.$llq_s.'<br>'.$luq_s.'<br>';

                              $layman_summar .=  "Patient localizes the pain to the ".$temp_str_103.". " ;
                            }
                            break;
                            case 158:
                            $layman_summar .= "The chest pain began ".(is_array($singlelevel['answer']) ? strtolower(implode(", ",$singlelevel['answer'])): strtolower($singlelevel['answer'])).". ";
                            break;

                    }
                }
                break;
            }

            case 71:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                          case 6:
                          $ques_ans_6 = '';
                          if($singlelevel['answer'] == 'Only after meals'){
                          $ques_ans_6 =  ", occurring most often ".strtolower($singlelevel['answer']);
                          }
                          elseif($singlelevel['answer'] == 'Same all day')
                          {

                            $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                          }
                          else{
                          $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                          }
                          if(!empty($ques_ans_8)){
                          $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                          $ques_ans_8 = ''; $ques_ans_6 = '';
                          }
                          break;
                          case 10:
                              $ques_ans_10 = $singlelevel['answer'];
                              if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                              }
                          break;
                          case 11:
                              $ques_ans_11 = $singlelevel['answer'];
                              if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                              }
                          break;
                          case 13:
                              $layman_summar .=   $singlelevel['answer'] == 'Yes' ? "Patient tried medication"  : "Patient didn't try medication. " ;

                          break;
                          case 14:
                                $layman_summar .= $singlelevel['answer'] == 'Yes' ? ", and since then the pain has improved."  : ", and since then the pain hasn't improved." ;

                          break;
                          case 61:

                            $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));

                            if(!empty($ques_ans_62)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                            }

                            break;
                          case 62:

                            $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);

                            if(!empty($ques_ans_61)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                            }

                            break;
                          case 63:

                            $question_63 = $singlelevel['answer'];

                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;

                            break;

                          case 64:

                            if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                                $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                            }
                            else{
                                $layman_summar .= '. ';
                            }

                            break;
                          case 65:

                            $question_65 = '';
                            if(!empty($singlelevel['answer'])){
                                $question_65 = $singlelevel['answer'];
                            }

                            break;
                          case 66:

                            $arr = array(
                                  '' => 'How long stay',
                                  "1" => '<24 hours',
                                  "2" => '1 day',
                                  "3" => '2 days',
                                  "4" => '3 days',
                                  "5" => '4 days',
                                  "6" => '5 days',
                                  "7" => '6 days',
                                  "8" => '1 week',
                                  "9" => '2 weeks',
                                  "10" => '3 weeks'
                                  );
                            $question_66 = '';
                            if(!empty($singlelevel['answer'])){

                                $question_66 .= $arr[$singlelevel['answer']];
                            }

                            break;

                          case 67:
                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }

                            $layman_summar .= '. ';
                            break;
                          case 68:
                            if(!empty($singlelevel['answer'])){

                              if($singlelevel['answer'] == 'No'){


                                $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              elseif($singlelevel['answer'] == 'Yes'){

                                $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              else{

                                $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                              }
                             }
                            break;
                          case 69:
                            /*if($cur_cc_name != 'chest pain' && $cur_cc_name != 'chest pressure' && $cur_cc_name != 'pain in chest'){
                                $layman_summar .= 'The patient can climb '.$singlelevel['answer'].' flights of stairs without stopping. ';
                            }*/
                            break;
                          case 101:
                                 $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer'])).'. ';
                          break;
                          case 94:
                          $layman_summar .= "Radiating: ".implode(", ", $singlelevel['answer']).'. ';
                          break;
                          case 95:
                          $ans_95  = is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']);
                          if($ans_95 == 'no'){
                          $layman_summar .= "The pain does not travel. ";
                          }
                          else{
                          $layman_summar .= "The pain travels to: ".$ans_95.'. ';
                          }
                          break;
                          case 97:
                            $arr = array(
                              '' => '',
                              '1' => 'Per hour',
                              '2' => 'Per day',
                              '3' => 'Per week',
                              '4' => 'Per month'
                              );
                            $layman_summar .= 'It occurs about '.$singlelevel['answer'].' times '. $arr[$value[$k+1]['answer']];
                            if(isset($question_ans_96) && !empty($question_ans_96)){
                              $layman_summar .= ', most often '.$question_ans_96.". ";
                            }
                            else{
                              $layman_summar .= ". ";
                            }
                          break;
                         case 99:
                           $arr = array(
                              '' => '',
                              '1' => 'Seconds',
                              '2' => 'Minutes',
                              '3' => 'Hours',
                              '4' => 'days'
                              );
                          $layman_summar .= 'Episodes last '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].' long. ';
                          break;
                          case 103:
                            $temp_str_103 = '';

                            if(!empty($singlelevel['answer'])){

                              $singlelevel['answer'] = array_filter(explode(',', $singlelevel['answer'])) ;
                              //pr($singlelevel['answer']);die;

                              if(in_array('left-bottom-left',$singlelevel['answer'])){

                                $key = array_search('left-bottom-left', $singlelevel['answer']);
                                $singlelevel['answer'][$key] = 'left-bottom-right';
                              }

                              if(in_array('right-bottom-left',$singlelevel['answer'])){

                                $key = array_search('right-bottom-left', $singlelevel['answer']);
                                $singlelevel['answer'][$key] = 'right-bottom-right';
                              }

                              //pr($gender);die;

                              $right_chest_s = 'Right chest(';
                              $left_chest_s = 'Left chest(';
                              $breastbone_s = 'Breastbone(';
                              $right_breast_s = 'Right breast(';
                              $left_breast_s = 'Left breast(';

                              $right_chest_len = strlen($right_chest_s);
                              $left_chest_len = strlen($left_chest_s);

                              $breastbone_len = strlen($breastbone_s);
                              $right_breast_len = strlen($right_breast_s);
                              $left_breast_len = strlen($left_breast_s);

                              if($gender == 1){

                                $breastbone = array('mid-bottom','mid-mid','mid-top');
                                $left_chest = array('right-bottom-left','right-bottom-right','right-chest','right-top','right-nipple');
                                $right_chest = array('right-top1','left-chest','left-bottom-left','left-bottom-right','left-nipple');

                                $answer = array_unique($singlelevel['answer']);

                                foreach ($answer as $key => $ans) {

                                  $temp_val = isset($img_chest_man_pain_detial_q_arr[$ans]) ? $img_chest_man_pain_detial_q_arr[$ans] : "" ;

                                    if(in_array($ans, $breastbone) && !empty($temp_val)){

                                        $breastbone_s .= $temp_val.', ';

                                     }
                                     elseif(in_array($ans, $left_chest) && !empty($temp_val)){

                                        $left_chest_s .= $temp_val.', ';
                                     }
                                    elseif (in_array($ans, $right_chest) && !empty($temp_val)) {

                                        $right_chest_s .= $temp_val.', ';
                                       // echo $luq_s.'<br>';
                                    }
                                }
                              }

                              if($gender == 0){

                                $right_chest = array('left1','left2');
                                $left_chest = array('right1','right2');

                                $right_breast = array('left9','left3','left4','left6','left5','left7','left8');
                                $left_breast = array('right3','right4','right5','right6','right8','right7','right9');

                                $breastbone = array('mid1','mid2','mid3');

                                  $answer = array_unique($singlelevel['answer']);

                                  foreach ($answer as $key => $ans) {

                                    $temp_val = isset($img_chest_female_pain_detial_q_arr[$ans]) ? $img_chest_female_pain_detial_q_arr[$ans] : "" ;

                                      if(in_array($ans, $breastbone) && !empty($temp_val)){

                                          $breastbone_s .= $temp_val.', ';

                                       }
                                       elseif(in_array($ans, $left_chest) && !empty($temp_val)){

                                          $left_chest_s .= $temp_val.', ';
                                       }
                                      elseif (in_array($ans, $right_chest) && !empty($temp_val)) {

                                          $right_chest_s .= $temp_val.', ';
                                         // echo $luq_s.'<br>';
                                      }
                                      elseif(in_array($ans, $right_breast) && !empty($temp_val)){

                                          $right_breast_s .= $temp_val.', ';
                                       }
                                      elseif (in_array($ans, $left_breast) && !empty($temp_val)) {

                                          $left_breast_s .= $temp_val.', ';
                                         // echo $luq_s.'<br>';
                                      }
                                  }
                                }

                              if(strlen($right_chest_s) > $right_chest_len){

                                  $right_chest_s = rtrim($right_chest_s,', ');
                                  $temp_str_103 .= $right_chest_s.'), ';
                              }

                              if(strlen($left_chest_s) > $left_chest_len){

                                  $left_chest_s = rtrim($left_chest_s,', ');
                                  $temp_str_103 .= $left_chest_s.'), ';
                              }

                              if(strlen($breastbone_s) > $breastbone_len){

                                $breastbone_s = rtrim($breastbone_s,', ');
                                $temp_str_103 .= $breastbone_s.'), ';
                              }

                              if(strlen($right_breast_s) > $right_breast_len){

                                  $right_breast_s = rtrim($right_breast_s,', ');
                                  $temp_str_103 .= $right_breast_s.'), ';
                              }

                              if(strlen($left_breast_s) > $left_breast_len){

                                  $left_breast_s = rtrim($left_breast_s,', ');
                                  $temp_str_103 .= $left_breast_s.'), ';
                              }

                              $temp_str_103 = rtrim($temp_str_103, ', ');
                                //echo $ruq_s.'<br>'.$rlq_s.'<br>'.$llq_s.'<br>'.$luq_s.'<br>';

                              $layman_summar .=  "Patient localizes the pain to the ".$temp_str_103.". " ;
                            }
                            break;
                            case 158:
                            $layman_summar .= "The chest pain began ".(is_array($singlelevel['answer']) ? strtolower(implode(", ",$singlelevel['answer'])): strtolower($singlelevel['answer'])).". ";
                            break;

                    }
                }
                break;
            }

            case 72:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                      case 71:
                           $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                      break;
                      case 6:
                            $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                            	if($singlelevel['answer'] != "night")
                            	{
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                            	}
                            	else
                            	{
                            		$layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                            	}
                            }
                      break;
                      case 146 :
                              $question_146 = array(
                                'worse' => 'aggravate',
                                'better' => 'alleviate',
                                'about the same' => 'same'
                              );
                              $layman_summar .= "Overall, you feels ".$question_146[$singlelevel['answer']]." since your last visit. ";
                      break;
                      case 147 :
                              if(!empty($singlelevel['answer'])){
                              $layman_summar .= ucfirst($singlelevel['answer'])." makes aggravate. ";
                              }
                      break;
                      case 148 :
                              if(!empty($singlelevel['answer'])){

                              $layman_summar .= ucfirst($singlelevel['answer'])." makes alleviate. ";
                              }
                      break;
                    }
                }
                break;
            }

            case 73:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 71:
                           $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                      break;
                      case 6:
                            $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                      break;

                    }
                }
                break;
            }

            case 74:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 71:
                           $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                      break;
                      case 6:
                            $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                      break;

                    }
                }
                break;
            }

            case 75:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 71:
                           $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                      break;
                      case 6:
                            $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                      break;

                    }
                }
                break;
            }

            case 76:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 71:
                           $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                      break;
                      case 6:
                            $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                      break;

                    }
                }
                break;
            }

            case 77:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                      case 71:
                           $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                      break;
                      case 6:
                            $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                      break;

                    }
                }
                break;
            }

            case 78:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                      case 71:
                           $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                      break;
                      case 6:
                            if($singlelevel['answer'] == 'Only after meals'){
                                $ques_ans_6 = ", occurring most often ".strtolower($singlelevel['answer']).'. ';

                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{
                            	if($singlelevel['answer'] != "Night")
                            	{
                                $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']).'. ';
                            	}
                            	else
                            	{
                            		$ques_ans_6 = ", occurring most often at ".strtolower($singlelevel['answer']).'. ';
                            	}

                            }
                            if(isset($ques_ans_72) && !empty($ques_ans_72))
                            {
                                $layman_summar .=$ques_ans_72.''.$ques_ans_6;
                                $ques_ans_72 = '';
                                $ques_ans_6 = '';
                            }
                      break;
                      case 72:
                            $ques_ans_72 = "The symptoms have been experienced approximately ".$singlelevel['answer']." times total";
                            if(isset($ques_ans_6) && !empty($ques_ans_6))
                            {
                            	$layman_summar .=$ques_ans_72.''.$ques_ans_6;
                            	$ques_ans_72 = '';
                            	$ques_ans_6 = '';
                            }
                      break;
                      case 146 :
                              $question_146 = array(
                                'worse' => 'aggravate',
                                'better' => 'alleviate',
                                'about the same' => 'same'
                              );
                              $layman_summar .= "Overall, you feels ".$question_146[$singlelevel['answer']]." since your last visit. ";
                      break;
                      case 147 :
                              if(!empty($singlelevel['answer'])){
                              $layman_summar .= ucfirst($singlelevel['answer'])." makes aggravate. ";
                              }
                      break;
                      case 148 :
                              if(!empty($singlelevel['answer'])){

                              $layman_summar .= ucfirst($singlelevel['answer'])." makes alleviate. ";
                              }
                      break;

                    }
                }
                break;
            }

            case 79:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 71:
                             $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                        break;
                        case 6:
                              $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                        break;
                        case 72:
                              $layman_summar .= "It has occurred ".$singlelevel['answer']." time(s). ";
                        break;

                    }
                }
                break;
            }

            case 80:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                        case 71:
                             $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                        break;
                        case 6:
                              $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                        break;
                        case 72:
                              $layman_summar .= "It has occurred ".$singlelevel['answer']." time(s). ";
                        break;

                    }
                }
                break;
            }

            case 81:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                        case 71:
                             $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                        break;
                        case 6:
                              $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                        break;
                        case 72:
                              $layman_summar .= "It has occurred ".$singlelevel['answer']." time(s). ";
                        break;

                    }
                }
                break;
            }

            case 82:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                        case 71:
                             $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                        break;
                        case 6:
                              $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                        break;
                        case 72:
                              $layman_summar .= "It has occurred ".$singlelevel['answer']." time(s). ";
                        break;

                    }
                }
                break;
            }

            case 83:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 71:
                             $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                        break;
                        case 6:
                              $singlelevel['answer'] = strtolower($singlelevel['answer']);
                            if($singlelevel['answer'] == 'only after meals' || $singlelevel['answer'] == 'same all day'){
                                $layman_summar .= "The pain is experienced most often ".strtolower($singlelevel['answer']).'. ';
                            }
                            else{
                                if($singlelevel['answer'] != "night")
                                {
                                $layman_summar .= "The pain is experienced most often in the ".strtolower($singlelevel['answer']).'. ';
                                }
                                else
                                {
                                    $layman_summar .= "The pain is experienced most often at ".strtolower($singlelevel['answer']).'. ';
                                }
                            }
                        break;
                        case 72:
                              $layman_summar .= "It has occurred ".$singlelevel['answer']." time(s). ";
                        break;

                    }
                }
                break;
            }

            case 84:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                         case 71:
                            $layman_summar .= 'The patient noticed symptoms starting after eating '.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).' foods. ';
                            break;

                        case 76:
                            $arr = array(
                                0 => '',
                                1 => 'per day',
                                2 => 'every other day',
                                3 => 'per week'
                              );
                            $he = $gender == 0 ? "she" : "he";
                            $layman_summar .= $he." has ".$singlelevel['answer']." bowl movements ".ucfirst($arr[$value[$k+1]['answer']]).". ";
                            break;

                        case 78:


                            $he = $gender == 0 ? "she" : "he";
                            $ques_ans_78 = $singlelevel['answer'];
                            if($ques_ans_78 == 'No'){

                               $layman_summar .= 'Denies recently traveling out of the country. ';
                            }
                            else{

                                if(isset($value[$k+1])){

                                    $layman_summar .= $he.' traveled out of the country to '.$value[$k+1]['answer'].'. ';
                                }
                                else{

                                    $layman_summar .= 'The patient recently traveling out of the country. ';
                                }
                            }

                            break;

                        /*case 79:

                            $layman_summar .= ucfirst($singlelevel['answer'])." country recently traveled. ";
                            break;*/

                        case 80:

                            $layman_summar .= "The patient recently started ".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).". ";
                            break;

                        case 146 :

                            $question_146 = array(
                                'worse' => 'aggravate',
                                'better' => 'alleviate',
                                'about the same' => 'same'
                            );
                            $layman_summar .= "Overall, you feels ".$question_146[$singlelevel['answer']]." since your last visit. ";
                            break;

                        case 147 :

                            if(!empty($singlelevel['answer'])){

                                $layman_summar .= ucfirst($singlelevel['answer'])." makes aggravate. ";
                            }
                            break;

                        case 148 :

                            if(!empty($singlelevel['answer'])){

                                $layman_summar .= ucfirst($singlelevel['answer'])." makes alleviate. ";
                            }
                            break;

                    }
                }
                break;
            }

            case 85:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                      case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                    case 74:

                           if(isset($question_73) && $question_73 == 'Yes'){

                                if($singlelevel['answer'] == 'Liquids only'){

                                    $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                  $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;

                    /*case 75:
                           if(isset($question_74) && $question_74 == 'liquids only'){
                                $layman_summar.= !empty($singlelevel['answer']) ? '('.(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).')' : "";
                            }
                        break;*/

                    }
                }
                break;
            }

            case 86:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                          case 76:
                              $arr = array(
                                0 => '',
                                1 => 'per day',
                                2 => 'every other day',
                                3 => 'per week'
                              );
                              $he = $gender == 0 ? "she" : "he";
                              $layman_summar .= $he." has ".$singlelevel['answer']." bowl movements ".ucfirst($arr[$value[$k+1]['answer']]).". ";
                          break;
                          case 81:
                              $layman_summar .= "The patient eats ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']));
                            break;
                          case 82:
                              $layman_summar .= " and drinks ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." glasses of water/day. ";
                            break;
                          case 83:
                              $layman_summar .= "The patient recently started ".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).". ";
                            break;
                          case 146 :
                              $question_146 = array(
                                'worse' => 'aggravate',
                                'better' => 'alleviate',
                                'about the same' => 'same'
                              );
                              $layman_summar .= "Overall, you feels ".$question_146[$singlelevel['answer']]." since your last visit. ";
                          break;
                          case 147 :
                                  if(!empty($singlelevel['answer'])){
                                  $layman_summar .= ucfirst($singlelevel['answer'])." makes aggravate. ";
                                  }
                          break;
                          case 148 :
                                  if(!empty($singlelevel['answer'])){

                                  $layman_summar .= ucfirst($singlelevel['answer'])." makes alleviate. ";
                                  }
                          break;

                            }
                }
                break;
            }


            case 87:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                          case 76:
                              $arr = array(
                                0 => '',
                                1 => 'per day',
                                2 => 'every other day',
                                3 => 'per week'
                              );
                              $he = $gender == 0 ? "she" : "he";
                              $ques_ans_76 = $he." has ".$singlelevel['answer']." bowl movements ".ucfirst($arr[$value[$k+1]['answer']]);
                              if(!empty($ques_ans_84) && !empty($ques_ans_86))
                              {
                              	$layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                              	$ques_ans_76 = '';
                              	$ques_ans_86 = '';
                              	$ques_ans_84 = '';
                              }
                          break;
                          case 84:
                                $ques_ans_84 = "and notices blood in stool ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." times/week. ";
                               if(!empty($ques_ans_76) && !empty($ques_ans_86))
                              {
                              	$layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                              	$ques_ans_76 = '';
                              	$ques_ans_86 = '';
                              	$ques_ans_84 = '';
                              }
                                break;
                          case 85:
                               $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient noticed bright red streaks of blood on the toilet paper. " : "The patient has not noticed bright red streaks of blood on the toilet paper. ";
                          break;
                          case 86:
                              $ques_ans_86 = " with ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." stool ";
                              if(!empty($ques_ans_84) && !empty($ques_ans_76))
                              {
                              	$layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                              	$ques_ans_76 = '';
                              	$ques_ans_86 = '';
                              	$ques_ans_84 = '';
                              }
                          break;
                    }
                }
                break;
            }

            case 88:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                          case 76:
                              $arr = array(
                                0 => '',
                                1 => 'per day',
                                2 => 'every other day',
                                3 => 'per week'
                              );
                             $he = $gender == 0 ? "she" : "he";
                              $ques_ans_76 = $he." has ".$singlelevel['answer']." bowl movements ".ucfirst($arr[$value[$k+1]['answer']]);
                              if(!empty($ques_ans_84) && !empty($ques_ans_86))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                          break;
                          case 84:
                                $ques_ans_84 = "and notices blood in stool ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." times/week. ";
                               if(!empty($ques_ans_76) && !empty($ques_ans_86))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                                break;
                          case 85:
                               $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient noticed bright red streaks of blood on the toilet paper. " : "The patient has not noticed bright red streaks of blood on the toilet paper. ";
                          break;
                           $ques_ans_86 = " with ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." stool ";
                              if(!empty($ques_ans_84) && !empty($ques_ans_76))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                          break;
                    }
                }
                break;
            }

            case 89:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                          case 76:
                              $arr = array(
                                0 => '',
                                1 => 'per day',
                                2 => 'every other day',
                                3 => 'per week'
                              );
                              $he = $gender == 0 ? "she" : "he";
                              $ques_ans_76 = $he." has ".$singlelevel['answer']." bowl movements ".ucfirst($arr[$value[$k+1]['answer']]);
                              if(!empty($ques_ans_84) && !empty($ques_ans_86))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                          break;
                          case 84:
                                $ques_ans_84 = "and notices blood in stool ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." times/week. ";
                               if(!empty($ques_ans_76) && !empty($ques_ans_86))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                                break;
                          case 85:
                               $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient noticed bright red streaks of blood on the toilet paper. " : "The patient has not noticed bright red streaks of blood on the toilet paper. ";
                          break;
                          case 86:
                              $ques_ans_86 = " with ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." stool ";
                              if(!empty($ques_ans_84) && !empty($ques_ans_76))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                          break;
                    }
                }
                break;
            }

            case 90:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                          case 76:
                              $arr = array(
                                0 => '',
                                1 => 'per day',
                                2 => 'every other day',
                                3 => 'per week'
                              );
                              $he = $gender == 0 ? "she" : "he";
                              $ques_ans_76 = $he." has ".$singlelevel['answer']." bowl movements ".ucfirst($arr[$value[$k+1]['answer']]);
                              if(!empty($ques_ans_84) && !empty($ques_ans_86))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                          break;
                          case 84:
                                $ques_ans_84 = "and notices blood in stool ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." times/week. ";
                               if(!empty($ques_ans_76) && !empty($ques_ans_86))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                                break;
                          case 85:
                               $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient noticed bright red streaks of blood on the toilet paper. " : "The patient has not noticed bright red streaks of blood on the toilet paper. ";
                          break;
                          case 86:
                               $ques_ans_86 = " with ".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." stool ";
                              if(!empty($ques_ans_84) && !empty($ques_ans_76))
                              {
                                $layman_summar .= $ques_ans_76.''.$ques_ans_86.''.$ques_ans_84;
                                $ques_ans_76 = '';
                                $ques_ans_86 = '';
                                $ques_ans_84 = '';
                              }
                          break;
                    }
                }
                break;
            }

            case 91:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                        case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                       case 74:

                           if(isset($question_73) && $question_73 == 'Yes'){


                                if($singlelevel['answer'] == 'Liquids only'){

                                  //$layman_summar .= "The patient has difficulty drinking liquid food only. Denies difficulty swallowing solids. ";

                                  $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                  $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;
                    }
                }
                break;
            }

            case 92:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                        case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                       case 74:


                           if(isset($question_73) && $question_73 == 'Yes'){


                                if($singlelevel['answer'] == 'Liquids only'){

                                 // $layman_summar .= "The patient has difficulty drinking liquid food only. Denies difficulty swallowing solids. ";
                                 $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                  $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;

                    }
                }
                break;
            }

            case 93:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                      case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                       case 74:


                           if(isset($question_73) && $question_73 == 'Yes'){


                                if($singlelevel['answer'] == 'Liquids only'){

                                 // $layman_summar .= "The patient has difficulty drinking liquid food only. Denies difficulty swallowing solids. ";
                                 $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                  $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;

                    }
                }
                break;
            }

            case 94:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                      case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                       case 74:


                           if(isset($question_73) && $question_73 == 'Yes'){


                                if($singlelevel['answer'] == 'Liquids only'){

                                  //$layman_summar .= "The patient has difficulty drinking liquid food only. Denies difficulty swallowing solids. ";
                                  $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                  $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;
                    }
                }
                break;
            }

            case 95:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                      case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                       case 74:

                           if(isset($question_73) && $question_73 == 'Yes'){


                                if($singlelevel['answer'] == 'Liquids only'){

                                  //$layman_summar .= "The patient has difficulty drinking liquid food only. Denies difficulty swallowing solids. ";

                                  $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                  $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;

                    }
                }
                break;
            }


            case 96:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                      case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                       case 74:


                           if(isset($question_73) && $question_73 == 'Yes'){


                                if($singlelevel['answer'] == 'Liquids only'){

                                //  $layman_summar .= "The patient has difficulty drinking liquid food only. Denies difficulty swallowing solids. ";
                                    $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                    $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;
                    }
                }
                break;
            }

            case 97:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                      case 73:
                          $question_73 = $singlelevel['answer'];
                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" : "The patient does not have trouble drinking liquids or swallowing solid food. ";
                        break;
                       case 74:


                           if(isset($question_73) && $question_73 == 'Yes'){


                                if($singlelevel['answer'] == 'Liquids only'){

                                  //$layman_summar .= "The patient has difficulty drinking liquid food only. Denies difficulty swallowing solids. ";
                                  $ques_ans_75 = isset($value[$k+1]) && isset($value[$k+1]['answer']) ? '('.(is_array($value[$k+1]['answer']) ? strtolower(implode(", ", $value[$k+1]['answer'])) : strtolower($value[$k+1]['answer'])).')' : "";

                                  $layman_summar .= "The patient has difficulty drinking liquid food only".$ques_ans_75.". Denies difficulty swallowing solids. ";

                                }
                                elseif($singlelevel['answer'] == 'Solids only'){

                                   $layman_summar .= 'The patient has difficulty swallowing solid food only. Denies difficulty drinking liquids. ';
                                }
                                else{

                                   $layman_summar .= "The patient has difficulty drinking liquids and swallowing solid food. ";
                                }
                            }
                        break;

                    }
                }
                break;
            }

            case 98:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                          case 87:
                               $layman_summar .= "The patient recently started ".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).". ";
                          break;
                          case 88:
                                $ans_88 = $singlelevel['answer'];
                                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "Positive for eating at a restaurant within 24 hours of symptoms" : "Denies eating at restaurants within 24 hours of symptoms";
                          break;
                          case 89:
                              if(isset($ans_88) && $ans_88 == 'Yes'){
                              $layman_summar .= ", and ate ".(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer'])." at ".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']).". ";
                              }
                              else{
                              $layman_summar .= '. ';
                              }
                          break;
                          case 91:
                              $he = $gender == 0 ? "she":"he";
                              $layman_summar .= $singlelevel['answer'] == 'Yes' ? $he." has been in contact with any sick children within 24 hours of symptoms starting. " :"Denies being in contact with any sick children within 24 hours of symptoms starting. ";
                          break;
                          case 6:
                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals'){

                                $ques_ans_6 =  ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(!empty($ques_ans_8)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                          break;
                          case 72:
                                 $layman_summar .= "It has occurred ".$singlelevel['answer']." time(s). ";
                          break;
                          case 92:
                                  if($singlelevel['answer'] == 'Yes'){

                                  $layman_summar .= "The patient is pregnant. ";
                                  }
                                  elseif($singlelevel['answer'] == 'No'){

                                  $layman_summar .= "The patient is not pregnant. ";
                                  }
                                  else{

                                  $layman_summar .= "The patient is not sure, she is pregnant. ";
                                  }
                          break;
                          case 146 :
                              $question_146 = array(
                                'worse' => 'aggravate',
                                'better' => 'alleviate',
                                'about the same' => 'same'
                              );
                              $layman_summar .= "Overall, you feels ".$question_146[$singlelevel['answer']]." since your last visit. ";
                              break;
                          case 147 :
                                if(!empty($singlelevel['answer'])){
                                    $layman_summar .= ucfirst($singlelevel['answer'])." makes aggravate. ";
                                }
                                break;
                          case 148 :
                                if(!empty($singlelevel['answer'])){

                                    $layman_summar .= ucfirst($singlelevel['answer'])." makes alleviate. ";
                                  }
                                break;
                          case 149 :
                                $layman_summar .= $singlelevel['answer'].", You have been vomiting. ";
                                break;
                          case 150 :
                                $layman_summar .= ucfirst($singlelevel['answer'])." times You vomited since your last visit. ";
                                break;
                          case 151 :
                                $layman_summar .= ucfirst($singlelevel['answer']).", You have seen bright red blood. ";
                                break;
                          case 152 :
                                $layman_summar .= ucfirst($singlelevel['answer']).", You have seen stuff that looks like coffee grounds. ";
                                break;
                    }
                }
                break;
            }

            case 99:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 1:
                             $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                        break;
                        case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                                break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;

                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;
                        case 6:
                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

                                $ques_ans_6 =  ", occurring ".strtolower($singlelevel['answer']);
                            }
                            else{
                            	if($singlelevel['answer'] != "Night")
                            	{
                                $ques_ans_6 = ", occurring in the ".strtolower($singlelevel['answer']);
                            	}
                            	else
                            	{
                            		$ques_ans_6 = ", occurring at ".strtolower($singlelevel['answer']);
                            	}
                            }

                            if(!empty($ques_ans_8)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                            break;
                        case 8:
                            $ques_ans_8 = "The pain is experienced approximately ".$singlelevel['answer']." times/day";
                            if(!empty($ques_ans_6)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                        break;
                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:
                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 55:
                            $question_ans_55 = is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'];
                        break;
                        case 56:
                            $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer']));
                            if(isset($question_ans_55) && !empty($question_ans_55)){

                                $layman_summar .= " that ".($question_ans_55 == 'Constant'? 'is '.$question_ans_55 : $question_ans_55).". ";
                            }else{

                              $layman_summar .= ". ";
                            }
                        break;
                    }
                }
                break;
            }

            case 100:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 1:
                             $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                        break;
                        case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                                break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;

                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;
                        case 6:
                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals'){

                                $ques_ans_6 =  ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(!empty($ques_ans_8)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                            break;
                        case 8:
                            $ques_ans_8 = "The pain is experienced approximately ".$singlelevel['answer']." times/day";
                            if(!empty($ques_ans_6)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                        break;
                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:
                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 55:
                            $question_ans_55 = is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'];
                        break;
                        case 56:
                            $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer']));
                            if(isset($question_ans_55) && !empty($question_ans_55)){

                                $layman_summar .= " that ".($question_ans_55 == 'Constant' ? 'is '.$question_ans_55 : $question_ans_55).". ";
                            }else{

                              $layman_summar .= ". ";
                            }
                        break;
                        case 57:

                            $ans_57 = '';
                            if($singlelevel['answer'] == 'Yes'){

                                if(isset($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 58){

                                    $ans_57 = 'with radiation to the'.(is_array($value[$k+1]['answer']) ? strtolower(implode(', ', $value[$k+1]['answer'])) :strtolower($value[$k+1]['answer']));
                                }
                                else{

                                    $ans_57 = 'with radiation';
                                }
                            }
                            else
                            {
                                $ans_57 = 'without radiation';
                            }

                            if(isset($ans_102) && !empty($ans_102)){
                                $layman_summar .= $ans_102.' '.$ans_57.'. ';
                                $ans_102 = ''; $ans_57 = '';
                            }
                           break;
                    }
                }
                break;
            }

            case 101:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                        case 1:
                             $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                        break;
                        case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                                break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;

                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;
                        case 6:
                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals'){

                                $ques_ans_6 =  ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_6 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(!empty($ques_ans_8)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                            break;
                        case 8:
                            $ques_ans_8 = "The pain is experienced approximately ".$singlelevel['answer']." times/day";
                            if(!empty($ques_ans_6)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                        break;
                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:
                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 55:
                            $question_ans_55 = is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'];
                        break;
                        case 56:
                            $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer']));
                            if(isset($question_ans_55) && !empty($question_ans_55)){

                                $layman_summar .= " that ".($question_ans_55 == 'Constant'? 'is '.$question_ans_55 : $question_ans_55).". ";
                            }else{

                              $layman_summar .= ". ";
                            }
                        break;
                        case 57:

                            $ans_57 = '';
                            if($singlelevel['answer'] == 'Yes'){

                                if(isset($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 58){

                                    $ans_57 = 'with radiation to the'.(is_array($value[$k+1]['answer']) ? strtolower(implode(', ', $value[$k+1]['answer'])) :strtolower($value[$k+1]['answer']));
                                }
                                else{

                                    $ans_57 = 'with radiation';
                                }
                            }
                            else
                            {
                                $ans_57 = 'without radiation';
                            }

                            if(isset($ans_102) && !empty($ans_102)){
                                $layman_summar .= $ans_102.' '.$ans_57.'. ';
                                $ans_102 = ''; $ans_57 = '';
                            }
                           break;
                    }
                }
                break;
            }

            case 102:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                        case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;


                            if(!empty($ques_ans_4)){
                            $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                            $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;

                        case 10:

                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";

                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }

                            break;
                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                         case 15:
                           // $layman_summar .=  "The symptom has lasted for: ".$singlelevel['answer'].". " ;
                            $case_15_how_many_days = $singlelevel['answer'] ;
                           break;

                        case 27:
                            // "There was no trauma/accident"/"There was trauma/accident and this happened: "
                            $he = $gender == 0 ? 'She' : 'He';
                           $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                           // $layman_summar .=  "Patient the following trauma or accident : <strong>".$singlelevel['answer']."</strong><br/>" ;
                           break;

                        case 39:

                            $ques_ans_39 = "The pain is described as ".strtolower(implode(', ', $singlelevel['answer'])).", " ;

                            $ques_ans_39 = stripos($ques_ans_39, 'none') ? "The pain is described as " : $ques_ans_39 ; // In case of "none of the above", we remove the option

                            if(!empty($ques_ans_41) && !empty($ques_ans_42)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39) ;

                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;


                            }
                            break;

                        case 40:

                            $ques_ans_40 = $singlelevel['answer'] ;

                            break;


                        case 41:

                            $ques_ans_41 = strtolower($singlelevel['answer'])  ;

                            if(!empty($ques_ans_39) && !empty($ques_ans_42)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);

                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                            break;

                        case 42:

                            // now input type is checkbox
                            $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);

                            $ques_ans_42 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". strtolower($singlelevel['answer']) ) ;
                            if(!empty($ques_ans_39) && !empty($ques_ans_41)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);

                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                            break;
                        case 43:
                          $temp_str_43 = $this->cheif_complaint_question_43($singlelevel['answer']);
                          $layman_summar .=  "The pain is localized to the ".$temp_str_43.". " ;
                          break;


                    }
                }
                break;
            }

            case 103:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                        case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;


                            if(!empty($ques_ans_4)){
                            $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                            $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;

                        case 10:

                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";

                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }

                            break;
                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                         case 15:
                           // $layman_summar .=  "The symptom has lasted for: ".$singlelevel['answer'].". " ;
                            $case_15_how_many_days = $singlelevel['answer'] ;
                           break;

                        case 27:
                            // "There was no trauma/accident"/"There was trauma/accident and this happened: "
                            $he = $gender == 0? 'She': 'He';
                           $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                           // $layman_summar .=  "Patient the following trauma or accident : <strong>".$singlelevel['answer']."</strong><br/>" ;
                           break;

                        case 39:

                            $ques_ans_39 = "The pain is described as ".strtolower(implode(', ', $singlelevel['answer'])).", " ;

                            $ques_ans_39 = stripos($ques_ans_39, 'none') ? "The pain is described as " : $ques_ans_39 ; // In case of "none of the above", we remove the option

                            if(!empty($ques_ans_41) && !empty($ques_ans_42)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39) ;

                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;


                            }
                            break;

                        case 40:

                            $ques_ans_40 = $singlelevel['answer'] ;

                            break;


                        case 41:

                            $ques_ans_41 = strtolower($singlelevel['answer'])  ;

                            if(!empty($ques_ans_39) && !empty($ques_ans_42)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);

                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                            break;

                        case 42:

                            // now input type is checkbox
                            $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);

                            $ques_ans_42 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". strtolower($singlelevel['answer']) ) ;
                            if(!empty($ques_ans_39) && !empty($ques_ans_41)){
                            if(!empty($ques_ans_40)) $ques_ans_39 = str_ireplace("radiating","radiating (".$ques_ans_40.")",$ques_ans_39);

                            $layman_summar .= $ques_ans_39.''.$ques_ans_41.''.$ques_ans_42.'. ';
                            $ques_ans_39 = '' ; $ques_ans_41 = '' ; $ques_ans_42 = '' ;
                            }
                            break;
                    }
                }
                break;
            }

            case 104:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                         case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;


                            if(!empty($ques_ans_4)){
                            $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                            $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;

                        case 10:

                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";

                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }

                            break;
                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                         case 15:
                           // $layman_summar .=  "The symptom has lasted for: ".$singlelevel['answer'].". " ;
                            $case_15_how_many_days = $singlelevel['answer'] ;
                           break;

                        case 18:

                            $translate_case18 = array("palm"=>"palmar", "back"=>"dorsal", "thumb side" => "radial aspect", "small finger side"=> "ulnar aspect") ;

                            $first_case18 = (stripos($singlelevel['answer'], 'both') !== FALSE ? 'palmar and dorsal' : (!empty($translate_case18[strtolower($singlelevel['answer'])]) ? $translate_case18[strtolower($singlelevel['answer'])] : $singlelevel['answer'] ));


                            $second_case18 =(!empty($more_options[$key][18])  ? (stripos($more_options[$key][18], 'both') !== FALSE  ? 'diffuse' : (!empty($translate_case18[strtolower($more_options[$key][18])]) ? $translate_case18[strtolower($more_options[$key][18])] : $more_options[$key][18] ) ) : '');


                            $layman_summar .=  "The ".$cur_cc_name." is localized to the ".$first_case18.' '.$second_case18.' of the hand. ' ;
                            break;

                        case 27:
                            // "There was no trauma/accident"/"There was trauma/accident and this happened: "
                            $he = $gender == 0 ? 'She' : 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            // $layman_summar .=  "Patient the following trauma or accident : <strong>".$singlelevel['answer']."</strong><br/>" ;
                            break;
                        case 28:
                            $ques_ans_28 = "The pain is described as ".$singlelevel['answer'].", " ;

                            if(!empty($ques_ans_29) && !empty($ques_ans_30)){
                            $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            }
                            break;
                        case 29:

                            $ques_ans_29 = $singlelevel['answer'] ;

                            if(!empty($ques_ans_28) && !empty($ques_ans_30)){
                            $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            // $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            }
                            break;
                        case 30:

                            $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);

                            $ques_ans_30 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worse in the ". $singlelevel['answer']) ;

                            if(!empty($ques_ans_28) && !empty($ques_ans_29)){
                            // $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            }
                            break;
                    }
                }
                break;
            }

             case 105:
            {
                //pr($value);die;
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                          case 15:

                            $case_15_how_many_days = $singlelevel['answer'] ;
                            break;


                          case 19:

                            $translate_case19 = array("thumb"=> "first digit", "index"=> "second digit", "middle"=> "third digit", "ring"=> "fourth digit", "little"=> "fifth digit");
                            if(is_array($singlelevel['answer']))
                            {
                                foreach ($singlelevel['answer'] as $k19 => $v19)
                                {
                                    $singlelevel['answer'][$k19] = !empty($translate_case19[strtolower($v19)]) ? $translate_case19[strtolower($v19)] : $v19 ;
                                }
                            }
                            $ques_ans_19 =  (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);

                            if(!empty($ques_ans_34))
                            {
                                $layman_summar .= ' The '.$cur_cc_name.' is located on the '.(stripos($ques_ans_34, 'joint') !== FALSE ? $ques_ans_34.' (***) in the ' : (stripos($ques_ans_34, 'front') !== FALSE ? 'anterior surface of the ' : $ques_ans_34)).$ques_ans_19.'. ';
                                $ques_ans_34 = '';  $ques_ans_19 = '' ;
                            }
                          break;

                          case 34:

                            $ques_ans_34 = $singlelevel['answer'] ;
                            if( !empty($ques_ans_19))
                            {
                                $layman_summar .= ' The '.$cur_cc_name.' is located on the '.(stripos($ques_ans_34, 'joint') !== FALSE ? $ques_ans_34.' (***) in the ' : (stripos($ques_ans_34, 'front') !== FALSE ? 'anterior surface of the ' : $ques_ans_34)).$ques_ans_19.'. ';
                                $ques_ans_34 = '';  $ques_ans_19 = '' ;
                            }
                            break;

                          case 35:

                                $ques_ans_35 =  $singlelevel['answer'] ;
                                $layman_summar = str_replace('***', $ques_ans_35, $layman_summar);
                          break;
                          case 27:

                            $he = $gender == 0 ? 'She' : 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;

                          case 28:

                              $ques_ans_28 = "The pain is described as ".$singlelevel['answer'].", " ;
                              if(!empty($ques_ans_29) && !empty($ques_ans_30))
                              {
                                  $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                  $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                              }
                              break;

                          case 29:
                                $ques_ans_29 = $singlelevel['answer'] ;
                                if(!empty($ques_ans_28) && !empty($ques_ans_30))
                                {
                                    $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                    $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                                }
                                break;
                          case 30:
                                $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
                                $ques_ans_30 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". $singlelevel['answer']) ;
                                if(!empty($ques_ans_28) && !empty($ques_ans_29))
                                {
                                    $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                                    $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                                }
                                break;

                          case 10:

                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11))
                            {
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                          case 11:
                                $ques_ans_11 = $singlelevel['answer'];
                                if(!empty($ques_ans_10)){
                                    $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                    $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                                }
                                break;
                          case 4:
                          $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                          if(!empty($ques_ans_5)){
                          $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                          $ques_ans_4 = ''; $ques_ans_5 = '';
                          }
                          break;
                          case 5:
                          $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;
                          if(!empty($ques_ans_4)){
                          $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                          $ques_ans_4 = ''; $ques_ans_5 = '';
                          }
                          break;
                    }
                }
                break;
            }

            case 106:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                         case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;


                            if(!empty($ques_ans_4)){
                            $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                            $ques_ans_4 = ''; $ques_ans_5 = '';
                            }
                            break;

                        case 10:

                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";

                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }

                            break;
                        case 11:

                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                            $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;

                         case 15:
                           // $layman_summar .=  "The symptom has lasted for: ".$singlelevel['answer'].". " ;
                            $case_15_how_many_days = $singlelevel['answer'] ;
                           break;

                        case 16:
                           $ques_ans_16 = "Patient feels pain in ".(stripos($singlelevel['answer'], 'both') !== FALSE ? 'bilateral' : $singlelevel['answer'].'hand') ;
                           if(!empty($ques_ans_17)){
                              $layman_summar .= $ques_ans_16.', '.$ques_ans_17.'. ';
                              $ques_ans_16 = ''; $ques_ans_17 = '';
                           }
                           break;

                        case 17:

                            if(stripos($singlelevel['answer'], 'left') !== FALSE) $ques_ans_17 =  '(L>R)';
                            if(stripos($singlelevel['answer'], 'right') !== FALSE) $ques_ans_17 =  '(R>L)';
                            if(stripos($singlelevel['answer'], 'about') !== FALSE) $ques_ans_17 =  '(L=R)';
                            if(!empty($ques_ans_16)){
                              $layman_summar .= $ques_ans_16.' '.$ques_ans_17.'. ';
                              $ques_ans_16 = ''; $ques_ans_17 = '';
                            }
                            // $layman_summar .=  " And among both hand Patient feel :  <strong>".$singlelevel['answer']."</strong><br/>" ;
                            break;

                        case 18:
                            $translate_case18 = array("palm"=>"palmar", "back"=>"dorsal", "thumb side" => "radial aspect", "small finger side"=> "ulnar aspect") ;

                            $first_case18 = (stripos($singlelevel['answer'], 'both') !== FALSE ? 'palmar and dorsal' : (!empty($translate_case18[strtolower($singlelevel['answer'])]) ? $translate_case18[strtolower($singlelevel['answer'])] : $singlelevel['answer'] ));


                            $second_case18 =(!empty($more_options[$key][18])  ? (stripos($more_options[$key][18], 'both') !== FALSE  ? 'diffuse' : (!empty($translate_case18[strtolower($more_options[$key][18])]) ? $translate_case18[strtolower($more_options[$key][18])] : $more_options[$key][18] ) ) : '');


                            $layman_summar .=  "The ".$cur_cc_name." is localized to the ".$first_case18.' '.$second_case18.' of the hand. ' ;
                            break;

                        case 27:
                            // "There was no trauma/accident"/"There was trauma/accident and this happened: "
                            $he = $gender == 0 ? 'She': 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            // $layman_summar .=  "Patient the following trauma or accident : <strong>".$singlelevel['answer']."</strong><br/>" ;
                            break;
                        case 28:
                            $ques_ans_28 = "The pain is described as ".$singlelevel['answer'].", " ;

                            if(!empty($ques_ans_29) && !empty($ques_ans_30)){
                            $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            }
                            break;
                        case 29:

                            $ques_ans_29 = $singlelevel['answer'] ;

                            if(!empty($ques_ans_28) && !empty($ques_ans_30)){
                            $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            // $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            }
                            break;
                        case 30:

                            $singlelevel['answer'] = (is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);

                            $ques_ans_30 = (stripos($singlelevel['answer'], 'about') !== FALSE ? ' and is about the same all day' : " and is worst in the ". $singlelevel['answer']) ;

                            if(!empty($ques_ans_28) && !empty($ques_ans_29)){
                            // $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $layman_summar .= $ques_ans_28.''.$ques_ans_29.''.$ques_ans_30.'. ';
                            $ques_ans_28 = '' ; $ques_ans_29 = '' ; $ques_ans_30 = '' ;
                            }
                            break;

                    }
                }
                break;
            }

            case 107:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                      case 108:
                          $question_108 = array(


                            'Bottom of foot' => 'plantar of foot',
                            'Back of foot' => 'back of foot',
                            'Both top and bottom' => 'all over foot',
                            'Front of foot' => 'anterior foot',
                            'Heel of foot' => 'posterior foot',
                            'Both front and back foot' => 'both front and back foot'

                          );

                          $ans_108 = '';
                          $ques_ans_108 = '';

                          if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                            foreach ($singlelevel['answer'] as $qk => $qval) {

                              $ans_108 .= $question_108[$qval].', ';
                            }
                          }else{

                            $ans_108 = $singlelevel['answer'];
                          }

                          $ques_ans_108 .= "The pain is on the ".rtrim($ans_108,', ');
                          if(!empty($ques_ans_109)){

                            $layman_summar .= $ques_ans_108.''.$ques_ans_109.'. ';
                            $ques_ans_108 = ''; $ques_ans_109 = '';
                          }

                          break;
                      case 109:

                          $question_109 = array(

                            'Side of big toe' => 'medial sided',
                            'Small toe side' => 'lateral sided',
                            'Both sides of foot' => 'both sides of foot'
                          );

                           $ans_109 = '';
                           $ques_ans_109 = '';

                          if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                            foreach ($singlelevel['answer'] as $qk => $qval) {

                              $ans_109 .= $question_109[$qval].', ';
                            }
                          }else{

                            $ans_109 = $singlelevel['answer'];
                          }

                          $ques_ans_109 = rtrim($ans_109,', ');
                          if(!empty($ques_ans_108)){

                            $layman_summar .= $ques_ans_108.', '.$ques_ans_109.'. ';
                            $ques_ans_108 = ''; $ques_ans_109 = '';
                          }


                          break;

                      case 110:

                          $ans = "";
                          if($singlelevel['answer'] == 'Suddenly'){

                            $ans_111 = $value[$k+1]['answer'];

                            if(in_array('fall', $ans_111)){

                              $ans_112 = $value[$k+2]['answer'];
                              $ans_112 = is_array($ans_112) ? implode(", ", $ans_112) : $ans_112;

                              $layman_summar .= "The pain started ".$singlelevel['answer']." due to ".(is_array($ans_111) ? implode(", ", $ans_111) : $ans_111)." and the patient fell due to ".$ans_112.". ";

                            }else{

                                $ans_111 = is_array($ans_111) ? implode(", ", $ans_111) : $ans_111;
                                $layman_summar .= "The pain started ".$singlelevel['answer']." due to ".($ans_111 == "I don't know" ? "unknown reasons" : $ans_111).". ";
                            }
                          }

                          break;

                      case 113:

                            $ques_ans_113 = $singlelevel['answer'] == 'Yes' ? ", happened at work":"";
                            if(!empty($ques_ans_114) && !empty($ques_ans_121) && !empty($ques_ans_122)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_121.$ques_ans_113.' '.$ques_ans_122.'. ';
                                $ques_ans_114 = ''; $ques_ans_121 = ''; $ques_ans_122 = ''; $ques_ans_113 = '';
                            }

                        break;

                      case 114:

                           $ques_ans_114 = 'The patient describes the pain as '.(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']));
                            if(!empty($ques_ans_114) && !empty($ques_ans_121) && !empty($ques_ans_122)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_121.$ques_ans_113.' '.$ques_ans_122.'. ';
                                $ques_ans_114 = ''; $ques_ans_121 = ''; $ques_ans_122 = ''; $ques_ans_113 = '';
                            }

                        break;

                      case 115:

                            $ques_ans_115 = strtolower($singlelevel['answer']);
                            $translate_115 = array(

                              'worse' => 'worsened',
                              'better' => 'improved',
                              'same' => 'remained stable'
                            );
                            $layman_summar .= "Current pain level has ".$translate_115[$ques_ans_115].' since initial presentation. ';

                        break;

                    case 116:

                        $ques_ans_116 = 'warmth to touch, ';
                        $singlelevel['answer'] == 'Yes' ? $positive_ans.= $ques_ans_116 : $negative_ans .= $ques_ans_116;

                        break;

                    case 117:

                          if($singlelevel['answer'] == 'Yes'){

                            $positive_ans .= "stiffness/pain in ".(is_array($value[$k+1]['answer']) ? implode(", ",$value[$k+1]['answer']) : $value[$k+1]['answer'])." joints, ";

                          }else{

                            $negative_ans .= "stiffness in other joints, pain in other joints, ";

                          }

                        break;

                     case 119:

                        $ques_ans_119 = 'abnormal hair/nail growth, sweating, ';
                        $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_119 : $negative_ans .= $ques_ans_119;

                        break;

                     case 120:

                        $ques_ans_120 = 'feet swelling, ';
                        $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_120 : $negative_ans .= $ques_ans_120;

                        break;

                    case 121:

                        $ques_ans_121 = $singlelevel['answer'];
                        if(!empty($ques_ans_114) && !empty($ques_ans_121) && !empty($ques_ans_122)){

                            $layman_summar .= $ques_ans_114.', '.$ques_ans_121.$ques_ans_113.' '.$ques_ans_122.'. ';
                            $ques_ans_114 = ''; $ques_ans_121 = ''; $ques_ans_122 = ''; $ques_ans_113 = '';
                        }

                        break;

                      case 122:

                            $ques_ans_122 = '';
                            $ques_ans_122 = "and is worse ".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer']);

                            if(strtolower($singlelevel['answer']) == 'morning' && isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 123 && $value[$k+1]['answer'] == 'Yes'){

                                $ques_ans_122 .= !empty($ques_ans_122) ? ', where the pain lasts for more than one hour': "";
                            }
                            if(!empty($ques_ans_114) && !empty($ques_ans_121) && !empty($ques_ans_122)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_121.$ques_ans_113.' '.$ques_ans_122.'. ';
                                $ques_ans_114 = ''; $ques_ans_121 = ''; $ques_ans_122 = ''; $ques_ans_113 = '';
                            }
                            break;

                      case 124:
                        $ans_124 = $singlelevel['answer'];
                          $layman_summar .= "The patient states that the pain is better with ".strtolower($singlelevel['answer']).". ";

                        break;

                      case 125:

                         if(isset($ans_124) && !empty($ans_124)){
                            $layman_summar = rtrim($layman_summar,'. ');
                            $layman_summar .= ' and worse with '.strtolower($singlelevel['answer']).". ";

                         }
                         else{

                            $layman_summar .= 'The patient states that the pain is worse with '.ucfirst($singlelevel['answer']).". ";
                         }


                        break;

                      case 126:

                            $ques_ans_126 = 'muscle spasms, ';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_126 : $negative_ans .= $ques_ans_126;

                        break;

                    case 144:

                          if(!empty($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 145){

                               // The pain is rated a 1/10 at its best and a 4/10 at its
                             //Out of 10, the pain is a [X] at its best, and a [Y] at its worst.
                             $layman_summar .= "The pain is rated a ".$singlelevel['answer']."/10 at its best and a ".$value[$k+1]['answer']."/10 at its worst. ";
                          }

                          break;
                    }
                }
                break;
            }

            case 108:
            {
                //pr($value);die;
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                      case 110:

                          $ans = "";
                          if($singlelevel['answer'] == 'Suddenly'){

                            $ans_111 = $value[$k+1]['answer'];

                            if($ans_111 != "I don't know"){

                                if(in_array('fall', $ans_111)){

                                  $ans_112 = $value[$k+2]['answer'];
                                  $ans_112 = is_array($ans_112) ? implode(", ", $ans_112) : $ans_112;

                                  $layman_summar .= "The pain started ".$singlelevel['answer']." due to ".(is_array($ans_111) ? implode(", ", $ans_111) : $ans_111)." and the patient fell due to ".$ans_112.". ";

                                }else{

                                    $ans_111 = is_array($ans_111) ? implode(", ", $ans_111) : $ans_111;
                                    $layman_summar .= "The pain started ".$singlelevel['answer']." due to ".($ans_111 == "I don't know" ? "unknown reasons" : $ans_111).". ";
                                }
                              }
                          }
                          break;

                      case 113:

                            $ques_ans_113 = $singlelevel['answer'] == 'Yes' ? ", happened at work":"";
                            if(!empty($ques_ans_114) && !empty($ques_ans_132) && !empty($ques_ans_133)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_132.$ques_ans_113.' '.$ques_ans_133.'. ';
                                $ques_ans_114 = ''; $ques_ans_132 = ''; $ques_ans_133 = ''; $ques_ans_113 = '';
                            }

                        break;

                      case 114:

                          $ques_ans_114 = 'The patient describes the pain as '.(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']));
                            if(!empty($ques_ans_114) && !empty($ques_ans_132) && !empty($ques_ans_133)){

                                $layman_summar .= $ques_ans_114.', '.$ques_ans_132.$ques_ans_113.' '.$ques_ans_133.'. ';
                                $ques_ans_114 = ''; $ques_ans_132 = ''; $ques_ans_133 = ''; $ques_ans_113 = '';
                            }

                        break;

                      case 115:

                            $ques_ans_115 = strtolower($singlelevel['answer']);
                            $translate_115 = array(

                              'worse' => 'worsened',
                              'better' => 'improved',
                              'same' => 'remained stable'
                            );
                            $layman_summar .= "Current pain level has ".$translate_115[$ques_ans_115].' since initial presentation. ';

                        break;

                    case 116:

                        $ques_ans_116 = 'warmth to touch, ';
                        $singlelevel['answer'] == 'Yes' ? $positive_ans .= $ques_ans_116 : $negative_ans .= $ques_ans_116;

                        break;

                    case 117:

                          if($singlelevel['answer'] == 'Yes'){

                            $positive_ans .= "stiffness/pain in ".(is_array($value[$k+1]['answer']) ? implode(", ",$value[$k+1]['answer']) : $value[$k+1]['answer'])." joints, ";

                          }else{

                            $negative_ans .= "stiffness in other joints, pain in other joints, ";

                          }

                        break;

                     case 119:

                            $ques_ans_119 = 'abnormal hair/nail growth, sweating, ';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_119 : $negative_ans .= $ques_ans_119;
                            //$layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient has abnormal hair/nail growth or sweating. " : "The patient does not have abnormal hair/nail growth or sweating. ";

                            break;

                      case 124:
                        $ans_124 = $singlelevel['answer'];
                        $layman_summar .= "The patient states that the pain is better with ".strtolower($singlelevel['answer']).". ";

                        break;

                      case 125:

                         if(isset($ans_124) && !empty($ans_124)){
                            $layman_summar = rtrim($layman_summar,'. ');
                            $layman_summar .= ' and worse with '.strtolower($singlelevel['answer']).". ";

                         }
                         else{

                            $layman_summar .= 'The patient states that the pain is worse with '.ucfirst($singlelevel['answer']).". ";
                         }


                        break;

                      case 126:

                            $ques_ans_126 = 'muscle spasms';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_126.', ' : $negative_ans .= $ques_ans_126.', ';

                            break;

                        case 129:

                            $ques_ans_129 = '';

                          $question_129 = array(


                            'front of ankle' => 'anterior ankle',
                            'back of ankle' => 'posterior ankle',
                            'both front and back of ankle' => 'both front and back of ankle'

                          );

                          $ans_129 = null;

                          if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                            foreach ($singlelevel['answer'] as $qk => $qval) {

                              $ans_129[]= $question_129[$qval];
                            }
                             $ans_129 = implode(", ", $ans_129);
                          }else{

                            $ans_129 = $singlelevel['answer'];
                          }

                          $ques_ans_129 .= "The location of the pain is the ".rtrim($ans_129,', ');
                          if(!empty($ques_ans_130)){

                            $layman_summar .= $ques_ans_129.$ques_ans_130.'. ';
                            $ques_ans_129 = '';
                            $ques_ans_130 = '';
                        }

                          break;

                       case 130:

                       //pr($singlelevel);
                            $ques_ans_130 = '';
                          $question_130 = array(

                            "side of big toe" => 'medial sided',
                            "small toe side" => 'lateral sided',
                            "both sides of ankle" => 'both sides of ankle'
                          );

                           $ans_130 = null;

                          if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                            foreach ($singlelevel['answer'] as $qk => $qval) {

                             // pr($qval);

                              $que = trim($qval);

                              $ans_130[] = $question_130[$que];
                            }

                            $ans_130 = implode(", ",$ans_130);
                          }else{

                            $ans_130 = $singlelevel['answer'];
                          }

                          if(isset($ans_129) && !empty($ans_129)){

                            $layman_summar = rtrim($layman_summar,'. ');
                            $layman_summar .= ", ".rtrim($ans_130,', ').". ";
                          }
                          else{

                            $ques_ans_130 .= ", ".rtrim($ans_130,', ');
                          }

                        if(!empty($ques_ans_129)){

                            $layman_summar .= $ques_ans_129.$ques_ans_130.'. ';
                            $ques_ans_129 = '';
                            $ques_ans_130 = '';
                        }

                          break;

                      case 131:

                            $ques_ans_131 = 'swelling';
                            $singlelevel['answer'] == 'Yes'? $positive_ans .= $ques_ans_131.', ' : $negative_ans .= $ques_ans_131.', ';

                        break;

                      case 132:

                        $ques_ans_132 = $singlelevel['answer'];

                        if(isset($ques_ans_113) && !empty($ques_ans_114) && !empty($ques_ans_133)){

                            $layman_summar .= $ques_ans_114.', '.$ques_ans_132.$ques_ans_113.' '.$ques_ans_133.'. ';
                            $ques_ans_114 = ''; $ques_ans_132 = ''; $ques_ans_133 = ''; $ques_ans_113 = '';
                        }

                        break;

                    case 133:

                        $ques_ans_133 = '';
                        $ques_ans_133 = "and is worse ".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer']);
                        //$que_133 = $singlelevel['answer'];

                        if(strtolower($singlelevel['answer']) == 'morning' && isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 134 && $value[$k+1]['answer'] == 'Yes'){

                            $ques_ans_133 .= !empty($ques_ans_133) ? ', where the pain lasts for more than one hour': "";
                        }

                        if(isset($ques_ans_113) && !empty($ques_ans_114) && !empty($ques_ans_132)){

                            $layman_summar .= $ques_ans_114.', '.$ques_ans_132.$ques_ans_113.' '.$ques_ans_133.'. ';
                            $ques_ans_114 = ''; $ques_ans_132 = ''; $ques_ans_133 = ''; $ques_ans_113 = '';
                        }

                        break;

                    /*case 134:

                        if($que_133 == 'morning'){

                            $layman_summar.= ($singlelevel['answer'] == 'Yes' ? 'The pain lasts for more than one hour' : 'The pain does not last for more than one hour').". ";
                        }

                        break;*/

                    case 144:

                          if(!empty($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 145){

                               // The pain is rated a 1/10 at its best and a 4/10 at its
                             //Out of 10, the pain is a [X] at its best, and a [Y] at its worst.
                             $layman_summar .= "The pain is rated a ".$singlelevel['answer']."/10 at its best and a ".$value[$k+1]['answer']."/10 at its worst. ";
                          }

                          break;
                    }
                }
                break;
            }

            case 109:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                           case 104:

                          $question_104 = array(
                              "" => "",
                              "1" => '1 day',
                              "2" => '2 days',
                              "3" => '3 days',
                              "4" => '4 days',
                              "5" => '5 days',
                              "6" => '6 days',
                              "7" => '7 days',
                              "8" => '8 days',
                              "9" => '9 days',
                              "10" => '10 days',
                              "11" => '11 days',
                              "12" => '12 days',
                              "13" => '13 days',
                              "14" => '2 weeks',
                              "15" => '3 weeks',
                              "16" => '4 weeks',
                              "17" => '5 weeks',
                              "18" => '6 weeks',
                              "19" => '2 months',
                              "20" => '3 months',
                              "21" => '4 months',
                              "22" => '5 months',
                              "23" => '6 months',
                              "24" => '7 months',
                              "25" => '8 months',
                              "26" => '9 months',
                              "27" => '10 months',
                              "28" => '11 months',
                              "29" => '1 year',
                              "30" => '2 years',
                              "31" => '3 years',
                              "32" => '4 years',
                              "33" => '5 years',
                              "34" => '6 years',
                              "35" => '7 years',
                              "36" => '8 years',
                              "38" => '9 years',
                              "39" => '10 years',
                              "40" => '10+ years',
                             );
                          if(!empty($value[$k+1]['answer'])){

                            $layman_summar .= 'The patient has been in pain for '. strtolower($question_104[$singlelevel['answer']])." and the pain started on ".$value[$k+1]['answer'].". ";

                          }else{

                            $layman_summar .= 'The patient has been in pain for '. strtolower($question_104[$singlelevel['answer']]).". ";
                          }

                          break;

                      case 110:

                          $ans = "";
                          if($singlelevel['answer'] == 'Suddenly'){

                            $ans_111 = $value[$k+1]['answer'];

                            if(in_array('fall', $ans_111)){

                              $ans_112 = $value[$k+2]['answer'];
                              $ans_112 = is_array($ans_112) ? implode(", ", $ans_112) : $ans_112;

                              $layman_summar .= "The pain started ".$singlelevel['answer']." due to ".(is_array($ans_111) ? implode(", ", $ans_111) : $ans_111)." and the patient fell due to ".$ans_112.". ";

                            }else{

                                $ans_111 = is_array($ans_111) ? implode(", ", $ans_111) : $ans_111;
                                $layman_summar .= "The pain started ".$singlelevel['answer']." due to ".($ans_111 == "I don't know" ? "unknown reasons" : $ans_111).". ";
                            }
                          }else{

                            $layman_summar .= "The pain started ".$singlelevel['answer'].". ";
                          }

                          break;

                      case 113:

                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The injury happened at work. ":"The injury did not happen at work. ";
                          //$layman_summar .= ucfirst($singlelevel['answer'])." injury happen at work. ";

                        break;

                      case 114:

                          $layman_summar .= 'The patient describes the pain as '.(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer'])).". ";

                        break;

                      case 115:

                          $ques_ans_115 = strtolower($singlelevel['answer']);
                            $translate_115 = array(

                              'worse' => 'worsened',
                              'better' => 'improved',
                              'same' => 'remained stable'
                            );
                            $layman_summar .= "Current pain level has ".$translate_115[$ques_ans_115].' since initial presentation. ';

                        break;

                    case 116:

                        $layman_summar .= $singlelevel['answer'] == 'Yes' ? "It feels warm to touch. " : "It does not feel warm to touch. ";

                        break;

                    case 117:

                          if($singlelevel['answer'] == 'Yes'){

                            $layman_summar .= "The patient has stiffness/pain in ".(is_array($value[$k+1]['answer']) ? implode(", ",$value[$k+1]['answer']) : $value[$k+1]['answer'])." joints. ";

                          }else{

                            $layman_summar .= "The patient does not have stiffness/pain in other joints. ";

                          }

                        break;

                     case 119:

                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient has abnormal hair/nail growth or sweating. " : "The patient does not have abnormal hair/nail growth or sweating. ";

                        break;

                      case 124:
                        $ans_124 = $singlelevel['answer'];
                          $layman_summar .= "The patient states that the pain is better with ".strtolower($singlelevel['answer']).". ";

                        break;

                      case 125:

                         if(isset($ans_124) && !empty($ans_124)){
                            $layman_summar = rtrim($layman_summar,'. ');
                            $layman_summar .= ' and worse with '.strtolower($singlelevel['answer']).". ";

                         }
                         else{

                            $layman_summar .= 'The patient states that the pain is worse with '.ucfirst($singlelevel['answer']).". ";
                         }


                        break;

                      case 126:

                          $layman_summar .= $singlelevel['answer'] == 'Yes'? "The patient has muscle spasms. ":"The patient does not have muscle spasms. ";

                        break;



                    case 135:

                                $question_135 = array(

                                  'Left' => 'left',
                                  'Right' => 'right',
                                  'Both' => 'bilateral'
                                 );

                                $question_136 = array(

                                  'Right more than left' => 'R>L',
                                  'Left more than right' => 'L>R',
                                  'About the same' => 'L=R'
                                 );

                               if($singlelevel['answer'] == 'Both'){

                                  if($value[$k+1]['question_id'] == 136 && !empty($value[$k+1]['answer'])){

                                    $layman_summar .= "The pain is in the ".$question_135[$singlelevel['answer']]." hip (".$question_136[$value[$k+1]['answer']]."). ";

                                  }else{

                                    $layman_summar .= "The pain is in the ".$question_135[$singlelevel['answer']]." hip. ";

                                  }
                                }else{

                                    $layman_summar .= "The pain is in the ".$question_135[$singlelevel['answer']]." hip. ";

                                  }

                              break;

                          case 137:

                           //pr($singlelevel);

                              $question_136 = array(

                                "groin" => 'groin/anterior medial hip',
                                "hip" => 'lateral hip',
                                "buttock" => 'posterior hip/gluteal'
                              );

                               $ans = null;

                              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                                foreach ($singlelevel['answer'] as $qk => $qval) {

                                 // pr($qval);

                                  $que = trim($qval);

                                  $ans[] = $question_136[$que];
                                }

                                $ans = implode(", ",$ans);
                              }else{

                                $ans = $singlelevel['answer'];
                              }

                              //pr($ans);

                              $layman_summar .= "Your hip hurts : ".rtrim($ans,', ').". ";

                              break;

                           case 138:

                                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient has ".$cur_cc_name." when you stand or put weight on the side of pain. " : "The patient has not ".$cur_cc_name." when you stand or put weight on the side of pain. ";
                              //$layman_summar .= ucfirst($singlelevel['answer']).", You have hip pain when you stand or put weight on the side of pain. ";

                            break;

                          case 139:

                                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "The patient has pain with direct pressure on pain site. " : "The patient has not pain with direct pressure on pain site. ";

                              //$layman_summar .= ucfirst($singlelevel['answer']).", You have pain with direct pressure on pain site. ";

                            break;

                         case 140:

                              $layman_summar .= ucfirst($singlelevel['answer']).", You have swollen hip. ";

                            break;

                        case 141:

                            if($singlelevel['answer'] == 'comes and goes'){

                              $layman_summar .= "Your ".$cur_cc_name." is described as intermittent. ";

                            }
                            else{

                               $layman_summar .= "Your ".$cur_cc_name." is described as ".$singlelevel['answer'].". ";

                            }

                            break;


                         case 142:

                              if($singlelevel['answer'] == 'morning'){

                                $layman_summar .= "The ".$cur_cc_name." is worst in the ".$singlelevel['answer'].($value[$k+1]['answer'] == 'Yes' ? ', where the pain lasts for more than one hour' : '').". ";

                              }else{

                                $layman_summar .= "The ".$cur_cc_name." is worst in the ".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer']).". ";
                              }

                            break;

                         case 144:

                          if(!empty($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 145){

                               // The pain is rated a 1/10 at its best and a 4/10 at its
                             //Out of 10, the pain is a [X] at its best, and a [Y] at its worst.
                             $layman_summar .= "The pain is rated a ".$singlelevel['answer']."/10 at its best and a ".$value[$k+1]['answer']."/10 at its worst. ";
                          }

                          break;
                    }
                }
                break;
            }
            case 110:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {
                        case 6:

                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

                                $ques_ans_6 = "occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Night'){

                                $ques_ans_6 = "occurring most often at ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_6 = "occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(isset($ques_ans_72) && !empty($ques_ans_72)){

                                $layman_summar .= $ques_ans_72.', '.$ques_ans_6.'. ';
                                $ques_ans_6 = ''; $ques_ans_72 = '';
                              }

                           //$layman_summar .= "It occurred most often: ".strtolower($singlelevel['answer']).'. ';
                            break;

                        case 72:
                              $ques_ans_72 = "The ".$cur_cc_name." has occurred approximately ".$singlelevel['answer']." time(s) total";

                              if(!empty($ques_ans_6)){

                                $layman_summar .= $ques_ans_72.', '.$ques_ans_6.'. ';
                                $ques_ans_6 = ''; $ques_ans_72 = '';
                              }
                              break;

                        case 87:

                            $layman_summar .= "The patient recently started ".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).". ";

                          //$layman_summar .= (is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." medications recently started. ";
                          break;

                        case 88:

                            $ans_88 = $singlelevel['answer'];

                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? "Positive for eating at a restaurant within 24 hours of symptoms" : "Denies eating at restaurants within 24 hours of symptoms";

                          //$layman_summar .= (is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer'])).", I was eat at restaurants within 24 hours of symptoms. ";
                          break;

                        case 89:

                            if(isset($ans_88) && $ans_88 == 'Yes'){

                                $layman_summar .= ", and ate ".(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer'])." at ".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']).". ";
                            }
                            else{

                                $layman_summar .= '. ';
                            }

                          break;

                         case 91:

                            $he = $gender == 0 ? "she":"he";
                            $layman_summar .= $singlelevel['answer'] == 'Yes' ? $he." has been in contact with any sick children within 24 hours of symptoms starting. " :"Denies being in contact with any sick children within 24 hours of symptoms starting. ";

                          //$layman_summar .= (is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer'])).", I Have been in contact with any sick children within 24 hours of symptoms starting. ";
                          break;

                        case 92:

                            if($singlelevel['answer'] == 'Yes'){

                                $layman_summar .= "The patient is pregnant. ";
                              }
                              elseif($singlelevel['answer'] == 'No'){

                                $layman_summar .= "The patient is not pregnant. ";
                              }
                              else{

                                $layman_summar .= "The patient is not sure, she is pregnant. ";
                              }

                              //$layman_summar .= (is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." pregnant. ";
                              break;
                        case 146 :

                              $question_146 = array(

                                'worse' => 'aggravate',
                                'better' => 'alleviate',
                                'about the same' => 'same'

                              );
                              $layman_summar .= "Overall, you feels ".$question_146[$singlelevel['answer']]." since your last visit. ";
                              break;

                        case 147 :

                              if(!empty($singlelevel['answer'])){
                                  $layman_summar .= ucfirst($singlelevel['answer'])." makes aggravate. ";
                              }
                              break;

                        case 148 :

                              if(!empty($singlelevel['answer'])){

                                  $layman_summar .= ucfirst($singlelevel['answer'])." makes alleviate. ";
                                }
                              break;

                        case 149 :

                              $layman_summar .= $singlelevel['answer'].", You have been ".$cur_cc_name.". ";
                              break;

                        case 150 :

                              $layman_summar .= ucfirst($singlelevel['answer'])." times You vomited since your last visit. ";
                              break;
                        case 151 :

                              $layman_summar .= ucfirst($singlelevel['answer']).", You have seen bright red blood. ";
                              break;
                        case 152 :

                              $layman_summar .= ucfirst($singlelevel['answer']).", You have seen stuff that looks like coffee grounds. ";
                              break;
                    }
                }
                break;
            }
            case 111:
            {
                foreach ($value as $k => $singlelevel) {


                    switch ($singlelevel['question_id'])
                    {

                        case 61:

                          //   $ans_61 = $singlelevel['answer'];
                          // $layman_summar .= ucfirst($singlelevel['answer']).' makes it worse. ';
                        $ques_ans_61 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer']));


                              if(!empty($ques_ans_62)){
                                $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                                $ques_ans_61 = ''; $ques_ans_62 = '';
                              }



                            break;
                        case 62:

                            //$layman_summar .= ucfirst($singlelevel['answer']).' makes it better. ';
                        $ques_ans_62 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                          if(!empty($ques_ans_61)){
                            $layman_summar .= $ques_ans_62.''.$ques_ans_61.'. ';
                            $ques_ans_61 = ''; $ques_ans_62 = '';
                          }



                            break;
                        case 63:

                            $question_63 = $singlelevel['answer'];

                          $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'The patient has been to the ER or admitted to the hospital for '.$cur_cc_name:'The patient has not been to the ER or admitted to the hospital for '.$cur_cc_name;

                            break;
                        case 64:

                          if(!empty($singlelevel['answer']) && isset($question_63) && $question_63 == 'Yes'){

                            $layman_summar .= ' '.ucfirst($singlelevel['answer']).' times since his last office visit. ';
                          }
                          else{
                            $layman_summar .= '. ';
                          }

                          //pr($layman_summar);die;

                            break;
                        case 65:
                            $question_65 = '';
                          if(!empty($singlelevel['answer'])){
                            $question_65 = $singlelevel['answer'];
                          }

                            break;
                        case 66:

                          $arr = array(
                              '' => 'How long stay',
                              "1" => '<24 hours',
                              "2" => '1 day',
                              "3" => '2 days',
                              "4" => '3 days',
                              "5" => '4 days',
                              "6" => '5 days',
                              "7" => '6 days',
                              "8" => '1 week',
                              "9" => '2 weeks',
                              "10" => '3 weeks'
                              );
                          $question_66 = '';
                          if(!empty($singlelevel['answer'])){

                            $question_66 .= $arr[$singlelevel['answer']];
                          }

                            break;

                        case 67:

                            if(!empty($singlelevel['answer'])){
                              $layman_summar .= "Patient initially went to ".ucfirst($singlelevel['answer']).' ER or hospital';
                            }

                            if(isset($question_65) && !empty($question_65)){

                               $layman_summar .= ' on '.$question_65;
                            }

                            if(isset($question_66) && !empty($question_66)){

                                $layman_summar .= ' and stayed for '.$question_66;
                            }

                           // if((isset($question_66) && !empty($question_66)) || (isset($question_65) && !empty($question_65))){

                                $layman_summar .= '. ';
                          // }


                            break;

                        case 68:

                            if(!empty($singlelevel['answer'])){

                              if($singlelevel['answer'] == 'No'){


                                $layman_summar .= 'The patient has not done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              elseif($singlelevel['answer'] == 'Yes'){

                                $layman_summar .= 'The patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ';
                              }
                              else{

                                $layman_summar .= "The patient don't know if patient has done procedures like a heart catherization, stent placement, or open heart bypass surgery. ";
                              }
                             }

                            break;

                        case 97:

                            $arr = array(

                                '' => '',
                                '1' => '/hour',
                                '2' => '/day',
                                '3' => '/week',
                                '4' => '/month'
                            );
                              $ques_ans_97 = ', approximately '.$singlelevel['answer'].' times'.$arr[$value[$k+1]['answer']];
                            if(isset($ques_ans_99) && !empty($ques_ans_99))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }

                            break;
                        case 99:
                            $arr = array(

                                '' => '',
                                '1' => 'Seconds',
                                '2' => 'mins',
                                '3' => 'Hours',
                                '4' => 'days'
                                );

                            $ques_ans_99 = 'The symptoms are experienced episodically at '.ucfirst($singlelevel['answer']).' '.$arr[$value[$k+1]['answer']].'/episode';
                            if(isset($ques_ans_97) && !empty($ques_ans_97))
                            {
                                $layman_summar .= $ques_ans_99.$ques_ans_97.". ";
                                $ques_ans_99 = '';
                                $ques_ans_97 = '';
                            }
                            break;

                    }
                }
                break;
            }

            case 112:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {

                        case 27:

                            $he = $gender == 0? 'She': 'He';
                            $layman_summar .=  (!empty($singlelevel['answer']) ? "The patient experienced trauma/accident associated with ".$singlelevel['answer'] : $he." denies any history of trauma, accidents, or inciting events").'. ' ;
                            break;
                    }
                }
                break;
            }
            case 113:
            {
               // pr($value);die;
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 1:

                            $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                            break;

                        case 4:

                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 5:

                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;


                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;

                        case 7:

                             $ques_ans_7 = "The pain is experienced episodically at ".$singlelevel['answer']." mins/episode";
                             if(!empty($ques_ans_8) && !empty($ques_ans_154)){

                                $layman_summar .= $ques_ans_7.$ques_ans_8.$ques_ans_154.'. ';
                                $ques_ans_8 ='';$ques_ans_7 = '';$ques_ans_154 = '';
                             }

                            break;
                        case 8:
                            $ques_ans_8 = ", approximately ".$singlelevel['answer']." times/day";

                            if(!empty($ques_ans_7) && !empty($ques_ans_154)){

                                $layman_summar .= $ques_ans_7.$ques_ans_8.$ques_ans_154.'. ';
                                $ques_ans_8 ='';$ques_ans_7 = '';$ques_ans_154 = '';
                             }
                            break;

                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:

                              $ques_ans_11 = $singlelevel['answer'];
                              if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                 // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
                                 $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                              }
                            break;
                        case 12:
                            $layman_summar .=  "The pain is described as ".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).". " ;
                            break;
                        case 13:
                            $layman_summar .=   $singlelevel['answer'] == 'Yes' ? "Patient tried medication"  : "Patient didn't try medication. " ;

                            break;
                        case 14:

                              $layman_summar .=  $singlelevel['answer'] == 'Yes' ? ", and since then the pain has improved."  : ", and since then the pain hasn't improved." ;

                            break;

                            //question 153 added in cc header
                        /*case 153 :

                            $layman_summar .= "The ".$cur_cc_name." is on the ".(strtolower($singlelevel['answer']) == 'both sides' ? strtolower($singlelevel['answer']) : strtolower($singlelevel['answer']).' side')." of the patient's head. ";

                            break;*/

                        case 154 :

                            $ques_ans_154 = '';
                            if($singlelevel['answer'] == 'Only after meals'){

                                $ques_ans_154 = ", occurring most often ".strtolower($singlelevel['answer']);
                            }
                            elseif($singlelevel['answer'] == 'Same all day'){

                               $ques_ans_6 =  ", occurring the ".strtolower($singlelevel['answer']);
                            }
                            else{

                                $ques_ans_154 = ", occurring most often in the ".strtolower($singlelevel['answer']);
                            }

                            if(!empty($ques_ans_7) && !empty($ques_ans_8)){

                                $layman_summar .= $ques_ans_7.$ques_ans_8.$ques_ans_154.'. ';
                                $ques_ans_8 ='';$ques_ans_7 = '';$ques_ans_154 = '';
                             }
                            break;

                        case 155 :

                            $ques_ans_155 = is_array($singlelevel['answer']) ? implode(", ",$singlelevel['answer']): $singlelevel['answer'];
                            $ques_ans_155 = strtolower($ques_ans_155);
                            $layman_summar .= "The ".$cur_cc_name." is typically located ".($ques_ans_155  == 'all over' ? $ques_ans_155 : "at the ".$ques_ans_155).". ";
                            break;
                    }
                }
                break;
            }

            case 114:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 156:

                            $ques_ans_156 = 'The patient states that the '.$cur_cc_name.' is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_157)){
                                $layman_summar .= $ques_ans_156.''.$ques_ans_157.'. ';
                                $ques_ans_156 = ''; $ques_ans_157 = '';
                              }
                            break;

                        case 157:

                            $ques_ans_157 = ' and worse with '.strtolower($singlelevel['answer']);


                            if(!empty($ques_ans_156)){
                                $layman_summar .= $ques_ans_156.''.$ques_ans_157.'. ';
                                $ques_ans_156 = ''; $ques_ans_157 = '';
                            }
                            break;
                    }
                }
                break;
            }

            case 115:
            {
                foreach ($value as $k => $singlelevel) {

                    switch ($singlelevel['question_id'])
                    {
                        case 1:
                             $layman_summar .= "Patient localizes the pain to the ".strtolower($singlelevel['answer']).'. ' ;
                        break;
                        case 4:
                            $ques_ans_4 = 'The patient states that the pain is better with '.strtolower($singlelevel['answer']);
                              if(!empty($ques_ans_5)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                                break;

                        case 5:
                            $ques_ans_5 = ' and worse '.(strtolower($singlelevel['answer']) == 'big meals' ? 'after '.strtolower($singlelevel['answer']) : 'with '.strtolower($singlelevel['answer'])) ;

                              if(!empty($ques_ans_4)){
                                $layman_summar .= $ques_ans_4.''.$ques_ans_5.'. ';
                                $ques_ans_4 = ''; $ques_ans_5 = '';
                              }
                            break;
                        case 6:
                            $ques_ans_6 = '';
                            if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

                                $ques_ans_6 =  ", occurring ".strtolower($singlelevel['answer']);
                            }
                            else{
                                if($singlelevel['answer'] != "Night")
                                {
                                $ques_ans_6 = ", occurring in the ".strtolower($singlelevel['answer']);
                                }
                                else
                                {
                                    $ques_ans_6 = ", occurring at ".strtolower($singlelevel['answer']);
                                }
                            }

                            if(!empty($ques_ans_8)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                            break;
                        case 8:
                            $ques_ans_8 = "The pain is experienced approximately ".$singlelevel['answer']." times/day";
                            if(!empty($ques_ans_6)){
                                $layman_summar .= $ques_ans_8.''.$ques_ans_6.'. ';
                                $ques_ans_8 = ''; $ques_ans_6 = '';
                              }
                        break;
                        case 10:
                            $ques_ans_10 = $singlelevel['answer'];
                            if(!empty($ques_ans_11)){

                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 11:
                            $ques_ans_11 = $singlelevel['answer'];
                            if(!empty($ques_ans_10)){
                                $layman_summar .= "The pain is rated a ".$ques_ans_10."/10 at its best and a ".$ques_ans_11."/10 at its worst. ";
                                $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                            }
                            break;
                        case 55:
                            $question_ans_55 = is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'];
                        break;
                        case 56:
                            $layman_summar .= "The pain is described as ".strtolower(implode(", ", $singlelevel['answer']));
                            if(isset($question_ans_55) && !empty($question_ans_55)){

                                $layman_summar .= " that ".($question_ans_55 == 'Constant'? 'is '.$question_ans_55 : $question_ans_55).". ";
                            }else{

                              $layman_summar .= ". ";
                            }
                        break;
                    }
                }
                break;
            }

    }

    $positive_ans = rtrim($positive_ans,', ');
    $negative_ans = rtrim($negative_ans,', ');
    if(!empty($positive_ans)){

        $layman_summar .= 'Associated symptoms include '.$positive_ans.'. ';
    }

    if(!empty($negative_ans)){

        $layman_summar .= 'Denies '.$negative_ans.'. ';
    }
/*$case_19_34_35 = str_replace('***', '', $case_19_34_35) ;  // if case 35 is empty then remove ***
    $layman_summar = $case_19_34_35.''.$layman_summar;  // for case 19, 34,35 , we concatenate outside loop because case 35 is optional
    $case_19_34_35 = ''; */

// $case_15_how_many_days
$layman_summar = str_replace('*case_15_how_many_days*', $case_15_how_many_days, $layman_summar) ;
$case_15_how_many_days = '';
  }

}

$all_cc_name = rtrim($all_cc_name,', ');
$orginal_cc_name = rtrim($orginal_cc_name,', ');

// all_cc_name is cc name and orginal_cc_name is cc doctor specific name
return array('layman_summar' => $layman_summar, 'all_cc_name' => $orginal_cc_name,'cc_header' => $cc_header) ;

}


public function cheif_complaint_question_102($answer, $gender){

    // this array used for question 102 for man
$img_abdominal_man_pain_detial_q_arr =  array(
  'mid1' => 'Epigastrium',

  'l-top1' => 'Right upper quadrant(RUQ) Hypochondria(Right)',
  'mid2' => 'Right upper quadrant(RUQ) Epigastrium',
  'l-top2' => 'Right upper quadrant(RUQ) Lumbar (right)',
  'mid4' => 'Right upper quadrant(RUQ) Umbilical',
  'mid6' => 'Right upper quadrant(RUQ) Periumbilical',


  'mid3' => 'Left upper quadrant (LUQ) Epigastrium',
  'r-top1' => 'Left upper quadrant (LUQ) Hypochondria (left)',
  'mid5' => 'Left upper quadrant (LUQ) Umbilical',
  'r-top2' => 'Left upper quadrant (LUQ) Lumbar (left)',
  'mid7' => 'Left upper quadrant (LUQ) Periumbilical',

  'mid9' => 'Right lower quadrant (RLQ) Periumbilical',
  'l-top3' => 'Right lower quadrant (RLQ) Lumbar (right)',
  'l-top3' => 'Right lower quadrant (RLQ) Lumbar (right)',
  'mid8' => 'Right lower quadrant (RLQ) Umbilical',
  'l-bottom' =>'Right lower quadrant (RLQ) Iliac (right)',
   'mid12' => 'Right lower quadrant (RLQ) Hypogastrium',

  'mid10' => 'Left lower quadrant (LLQ) Periumbilical',
  'r-top3' => 'Left lower quadrant (LLQ) Lumbar (left)',
  'mid11' => 'Left lower quadrant (LLQ) Umbilical',
  'mid13' => 'Left lower quadrant (LLQ) Hypogastrium',
  'r-bottom' => 'Left lower quadrant (LLQ) Iliac (left)'
);


//this array used for question 102 for female
$img_abdominal_female_pain_detial_q_arr =  array(
  'mid1' => 'Epigastrium',

  'l1' => 'Right upper quadrant(RUQ) Hypochondria (right)',
  'mid2' => 'Right upper quadrant(RUQ) Epigastrium',
  'l2' => 'Right upper quadrant(RUQ) Lumbar (right)',
  'mid4' => 'Right upper quadrant(RUQ) Umbilical',
  'mid6' => 'Right upper quadrant(RUQ) Periumbilical',


  'mid3' => 'Left upper quadrant (LUQ) Epigastrium',
  'r1' => 'Left upper quadrant (LUQ) Hypochondria (left)',
  'mid5' => 'Left upper quadrant (LUQ) Umbilical',
  'r2' => 'Left upper quadrant (LUQ) Lumbar (left)',
  'mid7' => 'Left upper quadrant (LUQ) Periumbilical',

  'l3' => 'Right lower quadrant (RLQ) Lumbar (right)',
  'l4' => 'Right lower quadrant (RLQ) Iliac (right)',
  'mid8' => 'Right lower quadrant (RLQ) Umbilical',
  'mid10' => 'Right lower quadrant (RLQ) Periumbilical',
  //'l-bottom' =>'Right lower quadrant (RLQ) Iliac (right)',
   'mid12' => 'Right lower quadrant (RLQ) Hypogastrium',

  'mid11' => 'Left lower quadrant (LLQ) Periumbilical',
  'mid9' => 'Left lower quadrant (LLQ) Umbilical',
  'r3' => 'Left lower quadrant (LLQ) Lumbar (left)',
  'mid13' => 'Left lower quadrant (LLQ) Hypogastrium',
  'r4' => 'Left lower quadrant (LLQ) Iliac (left)'
);

    $temp_str_102 = '';
   // $ans_102 = '';

    if(!empty($answer)){
        $answer = explode(',', $answer) ;

        $ruq_s = 'Right upper quadrant (RUQ(';
        $rlq_s = 'Right lower quadrant (RLQ(';
        $luq_s = 'Left upper quadrant (LUQ(';
        $llq_s = 'Left lower quadrant (LLQ(';

        if($gender == 1)
        {

            $ruq = array('l-top1','mid2','l-top2','mid4','mid6');
            $luq = array('mid3','r-top1','mid5','r-top2','mid7');
            $rlq = array('mid9','l-top3','l-top3','mid8','l-bottom','mid12');
            $llq = array('mid10','r-top3','mid11','mid13','r-bottom');

            foreach ($answer as $k102 => $v102)
            {

                $temp_val = isset($img_abdominal_man_pain_detial_q_arr[$v102]) ? $img_abdominal_man_pain_detial_q_arr[$v102] : "" ;

                if(in_array($v102, $ruq)){

                    $ruq_s .= substr($temp_val,strpos($temp_val,'(RUQ)')+6).', ';

                }
                elseif(in_array($v102, $rlq)){

                    $rlq_s .= substr($temp_val,strpos($temp_val,'(RLQ)')+6).', ';
                }
                elseif (in_array($v102, $luq)) {

                    $luq_s .= substr($temp_val,strpos($temp_val,'(LUQ)')+6).', ';
                   // echo $luq_s.'<br>';
                }
                elseif (in_array($v102, $llq)) {

                    $llq_s .= substr($temp_val,strpos($temp_val,'(LLQ)')+6).', ';

                }else{

                    $temp_str_102 .= isset($img_abdominal_man_pain_detial_q_arr[$v102]) ? $img_abdominal_man_pain_detial_q_arr[$v102].', ' : "" ;
                }
            }
        }
        if($gender == 0)
        {

            $ruq = array('l1','mid2','l2','mid4','mid6');
            $luq = array('mid3','r1','mid5','r2','mid7');
            $rlq = array('l3','l4','mid8','mid10','mid12');
            $llq = array('mid11','mid9','r3','mid13','r4');

            foreach ($answer as $k102 => $v102) {

              $temp_val = isset($img_abdominal_female_pain_detial_q_arr[$v102]) ? $img_abdominal_female_pain_detial_q_arr[$v102] : "" ;

              if(in_array($v102, $ruq)){

                $ruq_s .= substr($temp_val,strpos($temp_val,'(RUQ)')+6).', ';

              }
              elseif(in_array($v102, $rlq)){

                $rlq_s .= substr($temp_val,strpos($temp_val,'(RLQ)')+6).', ';
              }
              elseif (in_array($v102, $luq)) {

                $luq_s .= substr($temp_val,strpos($temp_val,'(LUQ)')+6).', ';
               // echo $luq_s.'<br>';
              }
              elseif (in_array($v102, $llq)) {

                $llq_s .= substr($temp_val,strpos($temp_val,'(LLQ)')+6).', ';

              }else{

                $temp_str_102 .= isset($img_abdominal_female_pain_detial_q_arr[$v102]) ? $img_abdominal_female_pain_detial_q_arr[$v102].', ' : "" ;

              }

            }
        }

        if(strlen($ruq_s) > 26){

            $ruq_s = rtrim($ruq_s,', ');
            $temp_str_102 .= $ruq_s.')), ';
        }

        if(strlen($rlq_s) > 26){

            $rlq_s = rtrim($rlq_s,', ');
            $temp_str_102 .= $rlq_s.')), ';
        }

        if(strlen($llq_s) > 25){

            $llq_s = rtrim($llq_s,', ');
            $temp_str_102 .= $llq_s.')), ';
        }

        if(strlen($luq_s) > 25){

            $luq_s = rtrim($luq_s,', ');
            $temp_str_102 .= $luq_s.')), ';
        }
        $temp_str_102 = rtrim($temp_str_102, ', ');
        //$ans_102 .=  "Patient localizes the abdominal pain to the ".$temp_str_102 ;
    }

    return $temp_str_102;
}


public function cheif_complaint_question_103($answer, $gender){
    //this array is used for question 103 for man

$img_chest_man_pain_detial_q_arr = array(
  //Right chest
  'right-top1' => 'clavicular (right)',
  'left-chest' => 'Pectoral (right)',
  'left-bottom-left' => 'Inframammary (right)',
  'left-bottom-right' => 'Inframammary (right)',
  'left-nipple' => 'right nipple',
    //Left chest
  'right-bottom-left' => 'Inframammary (left)',
  'right-bottom-right' => 'Inframammary (left)',
  'right-chest' => 'Pectoral (left)',
  'right-top' => 'clavicular (left)',
  'right-nipple' => 'left nipple',
    //Breastbone
  'mid-bottom' => 'Xiphoid process',
  'mid-mid' => 'Substernal',
  'mid-top' => 'Manubrium of sternum'
);


//this array is used for question 103 for female

$img_chest_female_pain_detial_q_arr = array(
//right chest
'left1' => 'clavicular (right)',
'left2' => 'Pectoral (right)',

//left chest
'right1' => 'clavicular (left)',
'right2' => 'Pectoral (left)',

//breastbone
'mid1' => 'Manubrium (of sternum)',
'mid2' => 'substernal',
'mid3' => 'Xiphoid process',

//right breast
'left3' => 'Right upper quadrant',
'left4' => 'Left upper quadrant',
'left6' => 'Right lower quadrant',
'left5' => 'Left lower quadrant',
'left9' => 'Right inframammary region',
'left7' => 'Right nipple',
'left8' => 'Right aereola',

//left breast
'right4' => 'Left upper quadrant',
'right3' => 'Right upper quadrant',
'right6' => 'Left lower quadrant',
'right5' => 'Right lower quadrant',
'right9' => 'Left inframammary region',
'right8' => 'Left nipple',
'right7' => 'Left aereola',

);

    $temp_str_103 = '';
    if(!empty($answer)){

      $answer = array_filter(explode(',', $answer)) ;
      //pr($singlelevel['answer']);die;

      if(in_array('left-bottom-left',$answer)){

        $key = array_search('left-bottom-left', $answer);
        $answer[$key] = 'left-bottom-right';
      }

      if(in_array('right-bottom-left',$answer)){

        $key = array_search('right-bottom-left', $answer);
        $answer[$key] = 'right-bottom-right';
      }

      //pr($gender);die;

      $right_chest_s = 'Right chest(';
      $left_chest_s = 'Left chest(';
      $breastbone_s = 'Breastbone(';
      $right_breast_s = 'Right breast(';
      $left_breast_s = 'Left breast(';

      $right_chest_len = strlen($right_chest_s);
      $left_chest_len = strlen($left_chest_s);

      $breastbone_len = strlen($breastbone_s);
      $right_breast_len = strlen($right_breast_s);
      $left_breast_len = strlen($left_breast_s);

      if($gender == 1){

        $breastbone = array('mid-bottom','mid-mid','mid-top');
        $left_chest = array('right-bottom-left','right-bottom-right','right-chest','right-top','right-nipple');
        $right_chest = array('right-top1','left-chest','left-bottom-left','left-bottom-right','left-nipple');

        $answer = array_unique($answer);

        foreach ($answer as $key => $ans) {

          $temp_val = isset($img_chest_man_pain_detial_q_arr[$ans]) ? $img_chest_man_pain_detial_q_arr[$ans] : "" ;

            if(in_array($ans, $breastbone) && !empty($temp_val)){

                $breastbone_s .= $temp_val.', ';

             }
             elseif(in_array($ans, $left_chest) && !empty($temp_val)){

                $left_chest_s .= $temp_val.', ';
             }
            elseif (in_array($ans, $right_chest) && !empty($temp_val)) {

                $right_chest_s .= $temp_val.', ';
               // echo $luq_s.'<br>';
            }
        }
      }

      if($gender == 0){

        $right_chest = array('left1','left2');
        $left_chest = array('right1','right2');

        $right_breast = array('left9','left3','left4','left6','left5','left7','left8');
        $left_breast = array('right3','right4','right5','right6','right8','right7','right9');

        $breastbone = array('mid1','mid2','mid3');

          $answer = array_unique($answer);

          foreach ($answer as $key => $ans) {

            $temp_val = isset($img_chest_female_pain_detial_q_arr[$ans]) ? $img_chest_female_pain_detial_q_arr[$ans] : "" ;

              if(in_array($ans, $breastbone) && !empty($temp_val)){

                  $breastbone_s .= $temp_val.', ';

               }
               elseif(in_array($ans, $left_chest) && !empty($temp_val)){

                  $left_chest_s .= $temp_val.', ';
               }
              elseif (in_array($ans, $right_chest) && !empty($temp_val)) {

                  $right_chest_s .= $temp_val.', ';
                 // echo $luq_s.'<br>';
              }
              elseif(in_array($ans, $right_breast) && !empty($temp_val)){

                  $right_breast_s .= $temp_val.', ';
               }
              elseif (in_array($ans, $left_breast) && !empty($temp_val)) {

                  $left_breast_s .= $temp_val.', ';
                 // echo $luq_s.'<br>';
              }
          }
        }

      if(strlen($right_chest_s) > $right_chest_len){

          $right_chest_s = rtrim($right_chest_s,', ');
          $temp_str_103 .= $right_chest_s.'), ';
      }

      if(strlen($left_chest_s) > $left_chest_len){

          $left_chest_s = rtrim($left_chest_s,', ');
          $temp_str_103 .= $left_chest_s.'), ';
      }

      if(strlen($breastbone_s) > $breastbone_len){

        $breastbone_s = rtrim($breastbone_s,', ');
        $temp_str_103 .= $breastbone_s.'), ';
      }

      if(strlen($right_breast_s) > $right_breast_len){

          $right_breast_s = rtrim($right_breast_s,', ');
          $temp_str_103 .= $right_breast_s.'), ';
      }

      if(strlen($left_breast_s) > $left_breast_len){

          $left_breast_s = rtrim($left_breast_s,', ');
          $temp_str_103 .= $left_breast_s.'), ';
      }

      $temp_str_103 = rtrim($temp_str_103, ', ');
        //echo $ruq_s.'<br>'.$rlq_s.'<br>'.$llq_s.'<br>'.$luq_s.'<br>';

      //$layman_summar .=  "Patient localizes the pain to the ".$temp_str_103.". " ;
    }

    return $temp_str_103;
}


public function cheif_complaint_question_43($answer)
{

    $img_backpain_detial_q_arr = array(
'c4' => 'Neck pain (Cervical (c4-5))',
'c7' => 'Neck pain (Cervical (c7))',
'c6' => 'Neck pain (Cervical (c6))',
't1' => 'Upper back pain (Thoracic (t1))',
't2' => 'Upper back pain (Thoracic (t2))',
't3' => 'Upper back pain (Thoracic (t3))',
't4' => 'Upper back pain (Thoracic (t4))',
't5' => 'Upper back pain (Thoracic (t5))',
't6' => 'Upper back pain (Thoracic (t6))',
't7' => 'Upper back pain (Thoracic (t7))',
't8' => 'Upper back pain (Thoracic (t8))',
't9' => 'Upper back pain (Thoracic (t9))',
't10' => 'Upper back pain (Thoracic (t10))',
't11' => 'Upper back pain (Thoracic (t11))',
't12' => 'Upper back pain (Thoracic (t12))',
'l1' => 'Low back pain (Lumbar (l1))',
'l2' => 'Low back pain (Lumbar (l2))',
'l3' => 'Low back pain (Lumbar (l3))',
'l4' => 'Low back pain (Lumbar (l4))',
'l5' => 'Low back pain (Lumbar (l5))',
's1' => 'Low back pain (Sacral (s1))',
's2-3' =>  'Low back pain (Sacral (s2-3))',
'right1' =>  'Neck pain',
'right2' =>  'Neck pain',
'right3' => 'Upper back pain (Suprascapular (right))',
'right4' => 'Upper back pain (Interscapular (right))',
'right5' => 'Upper back pain (Scapular (right))',
'right6' => 'Upper back pain (Infrascapular (right))',
'right7' => 'Low back pain (Infrascapular (right))',
'right8' => 'Low back pain',
'right9' => 'Buttock pain (right)',
'right10' => 'Shoulder pain (Infrascapular (right))',
'right11' => 'Shoulder pain (Scapular (right))',
'right12' => 'Shoulder pain (Scapular (right))',
'right13' =>  'Shoulder pain',
'right14' =>  'Shoulder pain (Scapular (right))',
'right15' => 'Shoulder pain (Posterior deltoid (right))',
'right16' => 'Shoulder pain (Suprascapular (right))',
'left1' =>  'Neck pain',
'left2' => 'Neck pain (Suprascapular (left))',
'left3' => 'Upper back pain (Suprascapular (left))',
'left4' => 'Upper back pain (Interscapular (left))',
'left5' =>  'Upper back pain (Scapular (left))',
'left6' => 'Upper back pain (Infrascapular (left))',
'left7' => 'Low back pain (Infrascapular (left))',
'left8' => 'Low back pain',
'left9' => 'Buttock pain (left)',
'left10' => 'Shoulder pain (Infrascapular (left))',
'left11' => 'Shoulder pain (Interscapular (left))',
'left12' => 'Shoulder pain (Scapular (left))',
'left13' =>  'Shoulder pain (Scapular (left))',
'left14' => 'Shoulder pain (left)',
'left15' =>  'Shoulder pain (Posterior deltoid (left))',
'left16' =>  'Shoulder pain (Suprascapular (left))',
);



$sorted_body_field_array = array
(
    2 => 'c4',
    3 => 'c6',
    4 => 'c7',
    5 => 'l1',
    6 => 'l2',
    7 => 'l3',
    8 => 'l4',
    9 => 'l5',
    10 => 'left1',
    11 => 'left2',
    12 => 'left3',
    13 => 'left4',
    14 => 'left5',
    15 => 'left6',
    16 => 'left7',
    17 => 'left8',
    18 => 'left9',
    19 => 'left10',
    20 => 'left11',
    21 => 'left12',
    22 => 'left13',
    23 => 'left14',
    24 => 'left15',
    25 => 'left16',
    26 => 'right1',
    27 => 'right2',
    28 => 'right3',
    29 => 'right4',
    30 => 'right5',
    31 => 'right6',
    32 => 'right7',
    33 => 'right8',
    34 => 'right9',
    35 => 'right10',
    36 => 'right11',
    37 => 'right12',
    38 => 'right13',
    39 => 'right14',
    40 => 'right15',
    41 => 'right16',
    42 => 's1',
    43 => 's2-3',
    44 => 't1',
    45 => 't2',
    46 => 't3',
    47 => 't4',
    48 => 't5',
    49 => 't6',
    50 => 't7',
    51 => 't8',
    52 => 't9',
    53 => 't10',
    54 => 't11',
    55 => 't12',
);

  $temp_str_43 = '' ;
  if(!empty($answer)){
  $answer = explode(',',$answer) ;
  foreach ($answer as $k43 => $v43) {
  $temp_str_43 .= isset($img_backpain_detial_q_arr[$v43]) ? $img_backpain_detial_q_arr[$v43].', ' : "" ;
  }
  // ************************* Human body option remove redundancy START *********************
  $temp_summar = '';
  $ttemp = array();
  if(stripos($temp_str_43, 'Neck pain') !== false ){
  $temp_summar .= 'Neck pain (';
  if(stripos($temp_str_43, 'Cervical') !== false ){
  // $temp_summar .= ' (Cervical (' ;
  if(stripos($temp_str_43, 'c4-5') !== false ){ $ttemp[] = 'C4'; $ttemp[] = 'C5'; }
  if(stripos($temp_str_43, 'c7') !== false ){ $ttemp[] = 'C7'; }
  if(stripos($temp_str_43, 'c6') !== false ){ $ttemp[] = 'C6'; }

  sort($ttemp);

  if(count(array_intersect($ttemp, array('C4','C5','C6','C7'))) == 4){
  $ttemp = 'C4-7';
  }elseif(count(array_intersect($ttemp, array('C4','C5','C6'))) == 3){
  $remain_ar = array_diff($ttemp, array('C4','C5','C6'));
  $ttemp = empty($remain_ar) ? 'C4-6' : 'C4-6, '.implode(', ', $remain_ar);

  }elseif(count(array_intersect($ttemp, array('C4','C5'))) == 2){
  $remain_ar = array_diff($ttemp, array('C4','C5'));
  $ttemp = empty($remain_ar) ? 'C4-5' : 'C4-5, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('C5','C6','C7'))) == 3){
  $remain_ar = array_diff($ttemp, array('C5','C6','C7'));
  $ttemp = empty($remain_ar) ? 'C5-7' : 'C5-7, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('C5','C6'))) == 2){
  $remain_ar = array_diff($ttemp, array('C5','C6'));
  $ttemp = empty($remain_ar) ? 'C5-6' : 'C5-6, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('C6','C7'))) == 2){
  $remain_ar = array_diff($ttemp, array('C6','C7'));
  $ttemp = empty($remain_ar) ? 'C6-7' : 'C6-7, '.implode(', ', $remain_ar);
  }else{

  $ttemp = implode(', ', $ttemp);

  }

  $ttemp = rtrim($ttemp, ', ');
  $temp_summar .= $ttemp.', ';
  $ttemp = '';
  }

  if(stripos($temp_str_43, 'Neck pain (Suprascapular (left))') !== false ){ $temp_summar .= 'Suprascapular (left)' ; }
  $temp_summar = rtrim($temp_summar, ', ');
  $temp_summar .= '), ';
  }
  if(stripos($temp_str_43, 'Upper back pain') !== false ){
  $temp_summar .= 'Upper back pain (' ;
  if(stripos($temp_str_43, 'Thoracic') !== false ){
  $ttemp = array();
  if(stripos($temp_str_43, 't1') !== false ) $ttemp[] = 'T1';if(stripos($temp_str_43, 't2') !== false ) $ttemp[] = 'T2';if(stripos($temp_str_43, 't3') !== false ) $ttemp[] = 'T3';if(stripos($temp_str_43, 't4') !== false ) $ttemp[] = 'T4';if(stripos($temp_str_43, 't5') !== false ) $ttemp[] = 'T5';if(stripos($temp_str_43, 't6') !== false ) $ttemp[] = 'T6';if(stripos($temp_str_43, 't7') !== false ) $ttemp[] = 'T7';if(stripos($temp_str_43, 't8') !== false ) $ttemp[] = 'T8';if(stripos($temp_str_43, 't9') !== false ) $ttemp[] = 'T9';if(stripos($temp_str_43, 't10') !== false ) $ttemp[] = 'T10';if(stripos($temp_str_43, 't11') !== false ) $ttemp[] = 'T11';if(stripos($temp_str_43, 't12') !== false ) $ttemp[] = 'T12';

  $tttemp = array();
  foreach ($ttemp as $kt1 => $vt1) {
  $tttemp[] = (int) filter_var($vt1, FILTER_SANITIZE_NUMBER_INT);
  }
  sort($tttemp);
  $ftemp = 'T';
  foreach ($tttemp as $kt2 => $vt2) {
  if(!isset($prev_vt2)){  // for first element
  if(isset($tttemp[$kt2+1]) && ($tttemp[$kt2+1]-1 == $vt2)){ // if range after first element
  $ftemp .= $vt2.'-';
  }else{
  $ftemp .= $vt2.', ';
  }
  }elseif(($prev_vt2+1) != $vt2){  // if range completed

  if(!empty($start_vt2) && ($start_vt2 == $prev_vt2)){ // for alone element (not range)
  $ftemp .= 'T'.$prev_vt2.', ';

  }elseif(!empty($start_vt2)){  // for range
  $ftemp .=  substr($ftemp, -1) == 'T' ? '' : 'T';
  $ftemp .= $start_vt2.'-'.$prev_vt2.', ';
  }elseif((empty($start_vt2) && !empty($prev_vt2)) && (strpos($ftemp, '-') !== false)){ // if range
  $ftemp .= $prev_vt2.', ';
  }
  if(!isset($tttemp[$kt2+1]))   $ftemp .= 'T'.$vt2;

  $start_vt2 = $vt2 ;
  }else{  // if iterateing through range

  if(!isset($tttemp[$kt2+1])){  // for last element
  if(empty($start_vt2)){  // for subsequest element range from first to last
  $ftemp .= $vt2;
  }else{
  $ftemp .= 'T'.$start_vt2.'-'.$vt2;
  }

  }

  }
  $prev_vt2 = $vt2;
  }
  $ttemp = strtoupper($ftemp) ;
  if(!empty($ttemp)){
  $ttemp = rtrim($ttemp, ', ');
  // $temp_summar .= $ttemp.'), ';
  $temp_summar .= $ttemp.', ';
  $ttemp = '';
  }
  }

  if((stripos($temp_str_43, 'Upper back pain (Suprascapular (right))') !== false ) && (stripos($temp_str_43, 'Upper back pain (Suprascapular (left))') !== false )){
  $temp_summar .= 'Suprascapular (bilateral), ' ;
  }else {
  if(stripos($temp_str_43, 'Upper back pain (Suprascapular (right))') !== false ){ $temp_summar .= 'Suprascapular (right), ' ; }
  if(stripos($temp_str_43, 'Upper back pain (Suprascapular (left))') !== false ){ $temp_summar .= 'Suprascapular (left), ' ; }
  }


  if((stripos($temp_str_43, 'Upper back pain (Interscapular (right))') !== false ) && (stripos($temp_str_43, 'Upper back pain (Interscapular (left))') !== false )){
  $temp_summar .= 'Interscapular (bilateral), ' ;
  }else{
  if(stripos($temp_str_43, 'Upper back pain (Interscapular (right))') !== false ){ $temp_summar .= 'Interscapular (right), ' ; }
  if(stripos($temp_str_43, 'Upper back pain (Interscapular (left))') !== false ){ $temp_summar .= 'Interscapular (left), ' ; }
  }


  if((stripos($temp_str_43, 'Upper back pain (Scapular (right))') !== false )  && (stripos($temp_str_43, 'Upper back pain (Scapular (left))') !== false )){
  $temp_summar .= 'Scapular (bilateral), ' ;
  }else{
  if(stripos($temp_str_43, 'Upper back pain (Scapular (right))') !== false ){ $temp_summar .= 'Scapular (right), ' ; }
  if(stripos($temp_str_43, 'Upper back pain (Scapular (left))') !== false ){ $temp_summar .= 'Scapular (left), ' ; }
  }


  if((stripos($temp_str_43, 'Upper back pain (Infrascapular (right))') !== false ) && (stripos($temp_str_43, 'Upper back pain (Infrascapular (left))') !== false )){
  $temp_summar .= 'Infrascapular (bilateral), ' ;
  }else{

  if(stripos($temp_str_43, 'Upper back pain (Infrascapular (right))') !== false ){ $temp_summar .= 'Infrascapular (right), ' ; }
  if(stripos($temp_str_43, 'Upper back pain (Infrascapular (left))') !== false ){ $temp_summar .= 'Infrascapular (left), ' ; }

  }


  $temp_summar = rtrim($temp_summar, ', ');
  $temp_summar .= '), ';
  }


  if(stripos($temp_str_43, 'Low back pain') !== false ){

  $temp_summar .= 'Low back pain (' ;
  if(stripos($temp_str_43, 'Lumbar') !== false ){
  // $temp_summar .= ' (Lumbar (' ;
  $ttemp = array();
  if(stripos($temp_str_43, 'l1') !== false ) $ttemp[] = 'L1';if(stripos($temp_str_43, 'l2') !== false ) $ttemp[] = 'L2';if(stripos($temp_str_43, 'l3') !== false ) $ttemp[] = 'L3';if(stripos($temp_str_43, 'l4') !== false ) $ttemp[] = 'L4';if(stripos($temp_str_43, 'l5') !== false ) $ttemp[] = 'L5';

  sort($ttemp);
  if(count(array_intersect($ttemp, array('L1','L2','L3','L4','L5'))) == 5){
  $ttemp = 'L1-5';
  }elseif(count(array_intersect($ttemp, array('L1','L2','L3','L4'))) == 4){
  $remain_ar = array_diff($ttemp, array('L1','L2','L3','L4'));
  $ttemp = empty($remain_ar) ? 'L1-4' : 'L1-4, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L1','L2','L3'))) == 3){
  $remain_ar = array_diff($ttemp, array('L1','L2','L3'));
  $ttemp = empty($remain_ar) ? 'L1-3' : 'L1-3, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L1','L2'))) == 2){
  $remain_ar = array_diff($ttemp, array('L1','L2'));
  $ttemp = empty($remain_ar) ? 'L1-2' : 'L1-2, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L2','L3','L4','L5'))) == 4){
  $remain_ar = array_diff($ttemp, array('L2','L3','L4','L5'));
  $ttemp = empty($remain_ar) ? 'L2-5' : 'L2-5, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L2','L3','L4'))) == 3){
  $remain_ar = array_diff($ttemp, array('L2','L3','L4'));
  $ttemp = empty($remain_ar) ? 'L2-4' : 'L2-4, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L2','L3'))) == 2){
  $remain_ar = array_diff($ttemp, array('L2','L3'));
  $ttemp = empty($remain_ar) ? 'L2-3' : 'L2-3, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L3','L4','L5'))) == 3){
  $remain_ar = array_diff($ttemp, array('L3','L4','L5'));
  $ttemp = empty($remain_ar) ? 'L3-5' : 'L3-5, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L3','L4'))) == 2){
  $remain_ar = array_diff($ttemp, array('L3','L4'));
  $ttemp = empty($remain_ar) ? 'L3-4' : 'L3-4, '.implode(', ', $remain_ar);
  }elseif(count(array_intersect($ttemp, array('L4','L5'))) == 2){
  $remain_ar = array_diff($ttemp, array('L4','L5'));
  $ttemp = empty($remain_ar) ? 'L4-5' : 'L4-5, '.implode(', ', $remain_ar);
  }else{
  $ttemp = implode(', ', $ttemp);

  }

  if(!empty($ttemp)){
  $ttemp = rtrim($ttemp, ', ');
  $temp_summar .= $ttemp.', ';
  $ttemp = ''; }
  }

  if(stripos($temp_str_43, 'Sacral') !== false ){

  $ttemp = array();
  if(stripos($temp_str_43, 's1') !== false ) $ttemp[] = 'S1';if(stripos($temp_str_43, 's2-3') !== false ){  $ttemp[] = 'S2';  $ttemp[] = 'S3';}
  sort($ttemp);

  if(count(array_intersect($ttemp, array('S1','S2','S3'))) == 3){
  $ttemp = 'S1-3';
  }elseif(count(array_intersect($ttemp, array('S1','S2'))) == 2){
  $remain_ar = array_diff($ttemp, array('S1','S2'));
  $ttemp = empty($remain_ar) ? 'S1-2' : 'S1-2, '.implode(', ', $remain_ar);

  }elseif(count(array_intersect($ttemp, array('S2','S3'))) == 2){
  $remain_ar = array_diff($ttemp, array('S2','S3'));
  $ttemp = empty($remain_ar) ? 'S2-3' : 'S2-3, '.implode(', ', $remain_ar);

  }else{
  $ttemp = implode(', ', $ttemp);
  }

  if(!empty($ttemp)){
  $ttemp = rtrim($ttemp, ', ');

  $temp_summar .= $ttemp.', ';
  $ttemp = ''; }

  }
  if((stripos($temp_str_43, 'Low back pain (Infrascapular (right))') !== false ) && (stripos($temp_str_43, 'Low back pain (Infrascapular (left))') !== false )){
  $temp_summar .= 'Infrascapular (bilateral), ' ;
  }else{
  if(stripos($temp_str_43, 'Low back pain (Infrascapular (right))') !== false ){ $temp_summar .= 'Infrascapular (right), ' ; }
  if(stripos($temp_str_43, 'Low back pain (Infrascapular (left))') !== false ){ $temp_summar .= 'Infrascapular (left), ' ; }
  }
  $temp_summar = rtrim($temp_summar, ', ');
  $temp_summar .= '), ';
  }

  if((stripos($temp_str_43, 'Buttock pain (right)') !== false ) && (stripos($temp_str_43, 'Buttock pain (left)') !== false )){
  $temp_summar .= 'Buttock pain (bilateral), ' ;
  }else{
  if(stripos($temp_str_43, 'Buttock pain (right)') !== false ){ $temp_summar .= 'Buttock pain (right), ' ; }
  if(stripos($temp_str_43, 'Buttock pain (left)') !== false ){ $temp_summar .= 'Buttock pain (left), ' ; }
  }

  if(stripos($temp_str_43, 'Shoulder pain') !== false ){

  $temp_summar .= 'Shoulder pain (' ;

  if(stripos($temp_str_43, 'Shoulder pain (Infrascapular (right))') !== false  && stripos($temp_str_43, 'Shoulder pain (Infrascapular (left))') !== false ){
  $temp_summar .= 'Infrascapular (bilateral), ' ;
  }else{
  if(stripos($temp_str_43, 'Shoulder pain (Infrascapular (right))') !== false ){ $temp_summar .= 'Infrascapular (right), ' ; }

  if(stripos($temp_str_43, 'Shoulder pain (Infrascapular (left))') !== false ){ $temp_summar .= 'Infrascapular (left), ' ; }
  }

  if(stripos($temp_str_43, 'Shoulder pain (Scapular (right))') !== false  && stripos($temp_str_43, 'Shoulder pain (Scapular (left))') !== false ){
  $temp_summar .= 'Scapular (bilateral), ' ;
  }else{

  if(stripos($temp_str_43, 'Shoulder pain (Scapular (right))') !== false ){ $temp_summar .= 'Scapular (right), ' ; }
  if(stripos($temp_str_43, 'Shoulder pain (Scapular (left))') !== false ){ $temp_summar .= 'Scapular (left), ' ; }
  }

  if(stripos($temp_str_43, '(Posterior deltoid (right))') !== false && stripos($temp_str_43, 'Posterior deltoid (left)') !== false ){
  $temp_summar .= 'Posterior deltoid (bilateral), ' ;
  }else{
  if(stripos($temp_str_43, '(Posterior deltoid (right))') !== false ){ $temp_summar .= 'Posterior deltoid (right), ' ; }

  if(stripos($temp_str_43, 'Posterior deltoid (left)') !== false ){ $temp_summar .= 'Posterior deltoid (left), ' ; }
  }

  if(stripos($temp_str_43, 'Shoulder pain (Suprascapular (right))') !== false && stripos($temp_str_43, 'Shoulder pain (Suprascapular (left))') !== false ){
  $temp_summar .= 'Suprascapular (bilateral), ' ;
  }else{

  if(stripos($temp_str_43, 'Shoulder pain (Suprascapular (right))') !== false ){ $temp_summar .= 'Suprascapular (right), ' ; }

  if(stripos($temp_str_43, 'Shoulder pain (Suprascapular (left))') !== false ){ $temp_summar .= 'Suprascapular (left), ' ; }

  }
  $temp_summar = rtrim($temp_summar, ', ');
  $temp_summar .= '), ';
  }

  // ************************* Human body option remove redundancy END *********************
  $temp_str_43 = rtrim($temp_summar, ', ');

 // $layman_summar .=  "The pain is localized to the ".$temp_str_43.". " ;
  }

  return $temp_str_43;
}


}
