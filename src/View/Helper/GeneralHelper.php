<?php
/**
 * General Helper
 *
 *
 * @category Helper
 */
//App::uses('Helper', 'View');

namespace App\View\Helper;
use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Controller\Controller;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Email;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use ReflectionClass;
use ReflectionMethod;



class GeneralHelper extends Helper {


    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    var $helpers = array('Html', 'Session',"Form",'CryptoSecurity');




	/**
	 *@countUsers
	 * count Users by role id
	*/


  public function authuser($userid = null)
  {
    $users = TableRegistry::get('users');
    $userdetail = $users->find('all')->where(['id' => $userid])->first();
      if($userdetail)
      {
         return $userdetail;
      }
     else
     {
      return '';
     }
  }

  public function getControllers() {
        $files = scandir('../src/Controller/');
        $results = [];
        $ignoreList = [
            '.',
            '..',
            'Component',
            'AppController.php',

        ];
        foreach($files as $file){
            if(!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }
        }
        return $results;
    }

    public function getActions($controllerName) {
        $className = 'App\\Controller\\'.$controllerName.'Controller';
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [$controllerName => []];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
        foreach($actions as $action){
            if($action->class == $className && !in_array($action->name, $ignoreList)){
                array_push($results[$controllerName], $action->name);
            }
        }
        return $results;
    }


    public function getResources(){
        $controllers = $this->getControllers();
        $resources = [];
        foreach($controllers as $controller){
            $actions = $this->getActions($controller);
            array_push($resources, $actions);
        }
        return $resources;
    }



// prepare question in layman summary

public function prepare_question_layman($user_detail = null,$gender = null){


//pr($user_detail);die;
// this array used for case 42 for image related question

$img_backpain_detial_q_arr =  array(
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

/*$img_chest_female_pain_detial_q_arr = array(
  //Right Chest
  'left1' => 'left1',
  'left2' => 'left2',

  //Left Chest
  'right1' => 'right1',
  'right2' => 'right2',

  //Right Breast
  'left3' => 'left3',
  'left4' => 'left4',
  'left5' => 'left5',
  'left6' => 'left6',
  'left7' => 'left7',
  'left8' => 'left8',
  'left9' => 'left9',

  //Left Breast
  'right3' => 'right3',
  'right4' => 'right4',
  'right5' => 'right5',
  'right6' => 'right6',
  'right7' => 'right7',
  'right8' => 'right8',
  'right9' => 'right9',

  //Breastbone
  'mid1' => 'mid1',
  'mid2' => 'mid2',
  'mid3' => 'mid3'

);*/

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




/*  // these array are not used now according to new design

// following array will be used in case 42 for image realted quesitons
$img_backpain_loc = array('topleft' => 'Shoulder pain (left)', 'topmid' => 'Cervical', 'topright' => 'Shoulder pain(right)', 'mid' => 'Upper back pain', 'midbottom' => 'Low back pain', 'bottomleft' => 'Buttockpain(left)',  'bottomright' => 'Buttockpain(right)');

$img_backpain_detail = array('topleft' => array('Suprascapular (left)', 'Posterior deltoid (left)'), 'topmid' => array('Cervical'), 'topright' => array('Posterior deltoid (right)', 'Suprascapular (right)'), 'mid' => array('Interscapular (left)', 'Scapular (left)', 'Scapular (right)', 'Interscapular (right)', 'Thoracic'), 'midbottom' => array('Infrascapular (left)', 'Sacral', 'Lumbar', 'Infrascapular (right)'), 'bottomleft' => array(), 'bottomright' => array() );
*/
// start

// pr($user_detail); die;
// Hi John, I compiled a summary for you
// I see that you want to see your doctor for a cough.
// The cough started 7 days ago.
$all_cc_name = '' ;
$layman_summar = '' ;
$cur_cc_name = '';
//die('sadsdd');
// $all_cc_name = $user_detail->chief_compliant_id->name ;
 // pr($user_detail->hospital_er_detail);
 // Show Summary of Hospital/ ER detail:
 if(!empty($user_detail->hospital_er_detail))
 {
    $hospital_er_detail = unserialize(Security::decrypt(base64_decode($user_detail->hospital_er_detail) , SEC_KEY));
    //pr($hospital_er_detail[516]); die;
    if(!empty($hospital_er_detail) && is_array($hospital_er_detail))
    {
      if($hospital_er_detail[516] == "Hospital stay (inpatient)")
      {
        foreach ($hospital_er_detail as $key => $value) {
          switch ($key) {
          case '516':
              $layman_summar .= "<br />You provided these details for  <strong>".$hospital_er_detail[516].'</strong>:' ;
            break;
            case '517':
              $layman_summar .= "<br />You were stay at <strong>".$hospital_er_detail[517].'</strong> hospital. ' ;
            break;
            case '518':
              $layman_summar .= "<br />You were admitted into the hospital at <strong>".$hospital_er_detail[518].'</strong>. ' ;
            break;
            case '519':
              $layman_summar .= "<br />You were discharged from the hospital at <strong>".$hospital_er_detail[519].'</strong>. ' ;
            break;
            case '520':
              $layman_summar .= "<br />You were admitted into the hospital for <strong>".$hospital_er_detail[520].'</strong>. ' ;
            break;
            case '521':
                      switch ($hospital_er_detail[521]) {
                        case 'Yes':
  
                          $layman_summar .= "<br /><strong>Yes, </strong>".$hospital_er_detail[522]." Procedures were performed according to the patient.<br />";
                          break;
                        case 'No':
                          $layman_summar .= "<br />No Procedures were performed according to the patient.<br />";
                          break;
                        default:
                          $layman_summar .= "<br />I don't know Procedures were performed according to the patient.<br />";
                          break;
                      }
            break;          
          default:
            # code...
            break;
        }
        }
        
      }
      else if($hospital_er_detail[516] == "Emergency room visit only")
      {
        foreach ($hospital_er_detail as $key => $value) {
          switch ($key) {
          case '516':
              $layman_summar .= "<br />You provided these details for  <strong>".$hospital_er_detail[516].'</strong>:' ;
            break;
          case '523 ':
              $layman_summar .= "<br />You were visited at <strong>".$hospital_er_detail[523].'</strong> emergency room.' ;
            break;
            case '524':
              $layman_summar .= "<br />The ER visited at <strong>".$hospital_er_detail[524].'</strong>. ' ;
            break;
            case '525':
              $layman_summar .= "<br />You went to the ER for <strong>".$hospital_er_detail[525].'</strong>. ' ;
            break;
            case '526':
              switch ($hospital_er_detail[526]) {
                        case 'Yes':
  
                          $layman_summar .= "<br /><strong>Yes, </strong> Lab tests done.";
                          break;
                        case 'No':
                          $layman_summar .= "<br />Lab tests done.";
                          break;
                        default:
                          $layman_summar .= "<br />Lab tests done.";
                          break;
                      }
            break;
            case '527':
              switch ($hospital_er_detail[526]) {
                        case 'Yes':
  
                          $layman_summar .= "<br /><strong>Yes, </strong> Procedures or imaging studies done.</br>";
                          break;
                        case 'No':
                          $layman_summar .= "<br />Procedures or imaging studies done.</br>";
                          break;
                        default:
                          $layman_summar .= "<br />Procedures or imaging studies done.</br>";
                          break;
                      }
            break;
            case '526':
              $layman_summar .= "<br />You were discharged from the hospital at <strong>".$hospital_er_detail[519].'</strong>. ' ;
            break;
            case '520':
              $layman_summar .= "<br />You were admitted into the hospital for <strong>".$hospital_er_detail[520].'</strong>. ' ;
            break;         
          default:
            # code...
            break;
        }
        }
      }
    }
 }
 // End Summary of Hospital /ER

if(!empty($user_detail->chief_compliant_details) && is_array($user_detail->chief_compliant_details)){

  /*$gender = $user_detail->user['gender'];

if(!empty($user_detail->user['gender'])){
  $gender = Security::decrypt(base64_decode($user_detail->user['gender']) , SEC_KEY);
}*/
//die('dsads');

//pr($gender);die;
// pr($gender);die;
// You didn't try medication.
// Since then, it has improved.
// These things made it better: test.
// These things made it worse: testing.
// It occurred most often during the noon.


  foreach ($user_detail->chief_compliant_details as $key => $value) {
// pr($key) ;
     //pr($value); die;

    foreach ($value as $k => $singlelevel) {
// pr($k); pr($singlelevel); die;
      // pr($k);
      // pr($singlelevel);
      if(is_string($k) && $k == 'cc_data'){

        $all_cc_name .=  $singlelevel->name.', ';
        $cur_cc_name = $singlelevel->name;
        // collect all cc
        // pr($all_cc_name); die;
  $layman_summar .= "<br />You provided these details for  <strong>".$singlelevel->name.':</strong><br />' ;
      } else {

// switch case start


    switch ($singlelevel['question_id']) {
        case 1:
         $layman_summar .= "The pain is felt in the <strong>".$singlelevel['answer'].'.</strong><br />' ;
            break;
        case 2:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;
        case 4:
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
        $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong> makes it better.<br />';

            break;

        case 5:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';

      $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>  makes it worse.<br />';

            break;
        case 6:
        	if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

        		$layman_summar .= "It occurs <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
        	}
        	else{

        		$layman_summar .= "It occurs during the <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
        	}

            break;
        case 7:
          $layman_summar .= "Pain lasts for <strong>".$singlelevel['answer']." minutes .</strong><br />";
            break;
        case 8:
          $layman_summar .= "It occurs <strong>".$singlelevel['answer']." times a day.</strong> <br />";
            break;
        case 9:
           $layman_summar .= "It is worse in the <strong>".$singlelevel['answer'].".</strong><br />" ;
            break;
        case 10:
            $ques_ans_10 = $singlelevel['answer'];

                    if(!empty($ques_ans_11)){
                       // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
          $layman_summar .= "Out of 10, the pain is a <strong>".$ques_ans_10."</strong> at its best, and a <strong>".$ques_ans_11."</strong> at its worst.<br />";
                       $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                    }

                      break;
                  case 11:
            $ques_ans_11 = $singlelevel['answer'];

                    if(!empty($ques_ans_10)){
                       // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
          $layman_summar .= "Out of 10, the pain is a <strong>".$ques_ans_10."</strong> at its best, and a <strong>".$ques_ans_11."</strong> at its worst.<br />";
                       $ques_ans_10 = '' ; $ques_ans_11 = '' ;
                    }

            break;
        case 12:
            $layman_summar .=  "(For head) it feels <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).".</strong><br />" ;
            break;
        case 13:
            $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "You tried medication"  : "You didn’t try any medication for the <strong>".$cur_cc_name."</strong>.<br/>" ;
            break;
        case 14:

        	if(isset($value[$k-1]) && $value[$k-1]['answer'] == 'Yes'){
           		$layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>, and since then the pain has improved.</strong> <br />"  : "<strong>, and since then the pain hasn't improved.</strong> <br/>" ;
           	}

            break;


        case 15:
           $layman_summar .=  "You have been in pain for <strong>".$singlelevel['answer']."</strong><br/>" ;
           break;
        case 16:

           $layman_summar .=  "You feel pain in ".($singlelevel['answer']== 'Both' ? '' : 'the ')."<strong>".$singlelevel['answer'].($singlelevel['answer']== 'Both' ? ' hands' : ' hand')."</strong>".($singlelevel['answer']== 'Both' ? '' : '.<br/>');
           break;
        case 17:
           $layman_summar .=  " And among both hands you feel  <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 18:
       // we used here $user_detail->more_options[$key][18] because 18 no question has additional  options
           $layman_summar .=  "You feels pain in <strong>".$singlelevel['answer'].(stripos($singlelevel['answer'], 'both') !== false  ? ' sides' : ' side').(isset($user_detail->more_options[$key][18]) ? (' and '.$user_detail->more_options[$key][18].(stripos($user_detail->more_options[$key][18], 'both') !== false  ? ' sides' : '')) : '')."</strong><br/>" ;
           // o/p - You feel pain in: Palm side and Small finger side
           break;
        case 19:

          $ques_ans_19 = strtolower(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
           $layman_summar .=  $ques_ans_19 == 'not on the fingers' ? "<strong>You does not feel pain on the fingers</strong>.<br/>" : "You feel pain in the <strong>".$ques_ans_19." </strong> finger(s).<br/>" ;
           break;
           /* // commented as qeustion no 20 now replaced with 34 and 35
        case 20:
           $layman_summar .=  "Part of hand in which you feel pain: <strong>".$singlelevel['answer']."</strong><br/>" ;
           break;
           */
        case 21:
           $layman_summar .=  "You have stiffness in <strong>".$singlelevel['answer'].(stripos($singlelevel['answer'], 'both') !== false  ? ' hands' : ' hand')."</strong><br/>" ;
           break;
        case 22:
           $layman_summar .=  "You have stiffness in <strong>".$singlelevel['answer'].(stripos($singlelevel['answer'], 'both') !== false  ? ' wrists' : ' wrist')."</strong><br/>" ;
           break;
        case 23:
           $ques_ans_23 = strtolower(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
           $layman_summar .=  $ques_ans_23 == 'not on the fingers' ? "<strong>You does not feel pain on the fingers</strong>.<br/>" : "You feel pain in the <strong>".$ques_ans_23." </strong> finger(s).<br/>" ;

           //$layman_summar .=  "You feel it in the <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong> finger(s).<br/>" ;
           break;
        case 24:
           $layman_summar .=  "You feel it in <strong>".$singlelevel['answer']."</strong> side of the hand.<br/>" ;
           break;
        case 25:
           $layman_summar .=  "You feel it in <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;

        case 26:

          $trauma_accident = $singlelevel['answer'] == "Yes" ? true : false;

           // $layman_summar .=  $singlelevel['answer'] == "Yes" ? "<strong>Unfortunately, you met with a trauma or accident.</strong><br/>" : "<strong>No trauma or accident you experienced.</strong><br/>" ;
           break;

        case 27:
          if(!empty($trauma_accident))
           $layman_summar .=  "You had the following trauma or accident: <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 28:
           $layman_summar .=  "The pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 29:
           $layman_summar .=  "The pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 30:

           $layman_summar .=  "The pain is the worst in <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br/>" ;
           break;
        case 31:
           $layman_summar .=  "The pain happened: <strong>".$singlelevel['answer']."</strong>.<br/>" ;

           break;

        case 34:
           $layman_summar .=  "You feel pain in the <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 35:
           $layman_summar .=  "You feel in the <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;

        case 36:

        if(is_array($singlelevel['answer'])){
          $temp_36_ar = array();
          foreach ($singlelevel['answer'] as $k36 => $v36) {
              $t36 = explode('-', $v36);
             // $temp_36_ar[] = !empty($t36[1]) ? $t36[0].' ('.(stripos($t36[1], 'both') !== false ? 'bilateral' : $t36[1] ).')' : $t36[0] ;
             $temp_36_ar[] = !empty($t36[1]) ? ucwords(stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
          }
          $singlelevel['answer'] = $temp_36_ar ;
        }

           $layman_summar .=  "You feel numbness in the: <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 37:

         if(is_array($singlelevel['answer'])){
          $temp_36_ar = array();
          foreach ($singlelevel['answer'] as $k36 => $v36) {
              $t36 = explode('-', $v36);
             // $temp_36_ar[] = !empty($t36[1]) ? $t36[0].' ('.(stripos($t36[1], 'both') !== false ? 'bilateral' : $t36[1] ).')' : $t36[0] ;
             $temp_36_ar[] = !empty($t36[1]) ? ucwords(stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
          }
          $singlelevel['answer'] = $temp_36_ar ;
        }

           $layman_summar .=  "You feels tingling in the: <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 38:

         if(is_array($singlelevel['answer'])){
          $temp_36_ar = array();
          foreach ($singlelevel['answer'] as $k36 => $v36) {
              $t36 = explode('-', $v36);
             // $temp_36_ar[] = !empty($t36[1]) ? $t36[0].' ('.(stripos($t36[1], 'both') !== false ? 'bilateral' : $t36[1] ).')' : $t36[0] ;
             $temp_36_ar[] = !empty($t36[1]) ? ucwords(stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
          }
          $singlelevel['answer'] = $temp_36_ar ;
        }

           $layman_summar .=  "You feels weakness in the: <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 39:
           // $layman_summar .=  "You described the pain as: <strong>".$singlelevel['answer']."</strong><br/>" ;
             $layman_summar .=  "The pain is described as <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;

           break;
        case 40:
           // $layman_summar .=  "You described the pain as: <strong>".$singlelevel['answer']."</strong><br/>" ;
        if(!empty($singlelevel['answer']))
             $layman_summar .=  "The pain radiates to the <strong>". $singlelevel['answer']."</strong><br/>" ;

           break;

        case 41:
            $singlelevel['answer'] =  stripos($singlelevel['answer'], 'comes') !== false ? $singlelevel['answer'] : 'is '.$singlelevel['answer'] ;
           $layman_summar .=  "The pain is described as <strong>".strtolower($singlelevel['answer'])."</strong><br/>" ;
           break;
        case 42:
           $layman_summar .=  "The pain is the worst in <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 44:


             $layman_summar .=  "You go to bed around <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong> each night.<br/>" ;
           break;

        case 45:

             $layman_summar .=  "You take about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes</strong> to fall asleep.<br/>" ;
           break;
        case 46:

             $layman_summar .=  "You get about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours</strong> of sleep each night.<br/>" ;

  /*$gender = $user_detail->user['gender'];

if(!empty($user_detail->user['gender'])){
  $gender = Security::decrypt(base64_decode($user_detail->user['gender']) , SEC_KEY);
}*/
//die('dsads');

//pr($gender);die;
// pr($gender);die;
// You didn't try medication.
// Since then, it has improved.
// These things made it better: test.
// These things made it worse: testing.
// It occurred most often during the noon.

  foreach ($user_detail->chief_compliant_details as $key => $value) {
// pr($key) ;
     //pr($value); die;

    foreach ($value as $k => $singlelevel) {
// pr($k); pr($singlelevel); die;
      // pr($k);
      // pr($singlelevel);
      if(is_string($k) && $k == 'cc_data'){

        $all_cc_name .=  $singlelevel->name.', ';
        $cur_cc_name = $singlelevel->name;
        // collect all cc
        // pr($all_cc_name); die;
  $layman_summar .= "<br />You provided these details for  ".$singlelevel->name.':<br />' ;
      } else {

// switch case start


    switch ($singlelevel['question_id']) {
        case 1:
         $layman_summar .= "The pain is felt in the <strong>".$singlelevel['answer'].'.</strong><br />' ;
            break;
        case 2:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;
        case 4:
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
        $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong> makes it better.<br />';

            break;

        case 5:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';

      $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>  makes it worse.<br />';

            break;
        case 6:
          if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

            $layman_summar .= "It occurs <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
          }
          else{

            $layman_summar .= "It occurs during the <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
          }

            break;
        case 7:
          $layman_summar .= "Pain lasts for <strong>".$singlelevel['answer']." minutes .</strong><br />";
            break;
        case 8:
          $layman_summar .= "It occurs <strong>".$singlelevel['answer']." times a day.</strong> <br />";
            break;
        case 9:
           $layman_summar .= "It is worse in the <strong>".$singlelevel['answer'].".</strong><br />" ;
            break;
        case 10:
  $ques_ans_10 = $singlelevel['answer'];

          if(!empty($ques_ans_11)){
             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
$layman_summar .= "Out of 10, the pain is a <strong>".$ques_ans_10."</strong> at its best, and a <strong>".$ques_ans_11."</strong> at its worst.<br />";
             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
          }

            break;
        case 11:
  $ques_ans_11 = $singlelevel['answer'];

          if(!empty($ques_ans_10)){
             // $layman_summar .= $ques_ans_10.'. '.$ques_ans_11.'. ';
$layman_summar .= "Out of 10, the pain is a <strong>".$ques_ans_10."</strong> at its best, and a <strong>".$ques_ans_11."</strong> at its worst.<br />";
             $ques_ans_10 = '' ; $ques_ans_11 = '' ;
          }

            break;
        case 12:
            $layman_summar .=  "(For head) it feels <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer'])).".</strong><br />" ;
            break;
        case 13:
            $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>You tried medication</strong>"  : "<strong>You didn’t try any medication for the ".$cur_cc_name."</strong>.<br/>" ;
            break;
        case 14:

          if(isset($value[$k-1]) && $value[$k-1]['answer'] == 'Yes'){
              $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>, and since then the pain has improved.</strong> <br />"  : "<strong>, and since then the pain hasn't improved.</strong> <br/>" ;
            }

            break;


        case 15:
           $layman_summar .=  "You have been in pain for <strong>".$singlelevel['answer']."</strong><br/>" ;
           break;
        case 16:

           $layman_summar .=  "You feel pain in ".($singlelevel['answer']== 'Both' ? '' : 'the ')."<strong>".$singlelevel['answer'].($singlelevel['answer']== 'Both' ? ' hands' : ' hand')."</strong>".($singlelevel['answer']== 'Both' ? '' : '.<br/>');
           break;
        case 17:
           $layman_summar .=  " And among both hands you feel  <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 18:
       // we used here $user_detail->more_options[$key][18] because 18 no question has additional  options
           $layman_summar .=  "You feels pain in <strong>".$singlelevel['answer'].(stripos($singlelevel['answer'], 'both') !== false  ? ' sides' : ' side').(isset($user_detail->more_options[$key][18]) ? (' and '.$user_detail->more_options[$key][18].(stripos($user_detail->more_options[$key][18], 'both') !== false  ? ' sides' : '')) : '')."</strong><br/>" ;
           // o/p - You feel pain in: Palm side and Small finger side
           break;
        case 19:

          $ques_ans_19 = strtolower(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
           $layman_summar .=  $ques_ans_19 == 'not on the fingers' ? "<strong>You does not feel pain on the fingers</strong>.<br/>" : "You feel pain in the <strong>".$ques_ans_19." </strong> finger(s).<br/>" ;
           break;
           /* // commented as qeustion no 20 now replaced with 34 and 35
        case 20:
           $layman_summar .=  "Part of hand in which you feel pain: <strong>".$singlelevel['answer']."</strong><br/>" ;
           break;
           */
        case 21:
           $layman_summar .=  "You have stiffness in <strong>".$singlelevel['answer'].(stripos($singlelevel['answer'], 'both') !== false  ? ' hands' : ' hand')."</strong><br/>" ;
           break;
        case 22:
           $layman_summar .=  "You have stiffness in <strong>".$singlelevel['answer'].(stripos($singlelevel['answer'], 'both') !== false  ? ' wrists' : ' wrist')."</strong><br/>" ;
           break;
        case 23:
           $ques_ans_23 = strtolower(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']);
           $layman_summar .=  $ques_ans_23 == 'not on the fingers' ? "<strong>You does not feel pain on the fingers</strong>.<br/>" : "You feel pain in the <strong>".$ques_ans_23." </strong> finger(s).<br/>" ;

           //$layman_summar .=  "You feel it in the <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong> finger(s).<br/>" ;
           break;
        case 24:
           $layman_summar .=  "You feel it in <strong>".$singlelevel['answer']."</strong> side of the hand.<br/>" ;
           break;
        case 25:
           $layman_summar .=  "You feel it in <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;

        case 26:

          $trauma_accident = $singlelevel['answer'] == "Yes" ? true : false;

           // $layman_summar .=  $singlelevel['answer'] == "Yes" ? "<strong>Unfortunately, you met with a trauma or accident.</strong><br/>" : "<strong>No trauma or accident you experienced.</strong><br/>" ;
           break;

        case 27:
          if(!empty($trauma_accident))
           $layman_summar .=  "You had the following trauma or accident: <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 28:
           $layman_summar .=  "The pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 29:
           $layman_summar .=  "The pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 30:

           $layman_summar .=  "The pain is the worst in <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br/>" ;
           break;
        case 31:
           $layman_summar .=  "The pain happened: <strong>".$singlelevel['answer']."</strong>.<br/>" ;

           break;

        case 34:
           $layman_summar .=  "You feel pain in the <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;
        case 35:
           $layman_summar .=  "You feel in the <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;

        case 36:

        if(is_array($singlelevel['answer'])){
          $temp_36_ar = array();
          foreach ($singlelevel['answer'] as $k36 => $v36) {
              $t36 = explode('-', $v36);
             // $temp_36_ar[] = !empty($t36[1]) ? $t36[0].' ('.(stripos($t36[1], 'both') !== false ? 'bilateral' : $t36[1] ).')' : $t36[0] ;
             $temp_36_ar[] = !empty($t36[1]) ? ucwords(stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
          }
          $singlelevel['answer'] = $temp_36_ar ;
        }

           $layman_summar .=  "You feel numbness in the: <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 37:

         if(is_array($singlelevel['answer'])){
          $temp_36_ar = array();
          foreach ($singlelevel['answer'] as $k36 => $v36) {
              $t36 = explode('-', $v36);
             // $temp_36_ar[] = !empty($t36[1]) ? $t36[0].' ('.(stripos($t36[1], 'both') !== false ? 'bilateral' : $t36[1] ).')' : $t36[0] ;
             $temp_36_ar[] = !empty($t36[1]) ? ucwords(stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
          }
          $singlelevel['answer'] = $temp_36_ar ;
        }

           $layman_summar .=  "You feels tingling in the: <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 38:

         if(is_array($singlelevel['answer'])){
          $temp_36_ar = array();
          foreach ($singlelevel['answer'] as $k36 => $v36) {
              $t36 = explode('-', $v36);
             // $temp_36_ar[] = !empty($t36[1]) ? $t36[0].' ('.(stripos($t36[1], 'both') !== false ? 'bilateral' : $t36[1] ).')' : $t36[0] ;
             $temp_36_ar[] = !empty($t36[1]) ? ucwords(stripos($t36[1], 'both') !== false ? 'bilateral '. $t36[0] : $t36[1].' '.str_ireplace('feet', 'foot', rtrim($t36[0],'s')) ) : $t36[0] ;
          }
          $singlelevel['answer'] = $temp_36_ar ;
        }

           $layman_summar .=  "You feels weakness in the: <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 39:
           // $layman_summar .=  "You described the pain as: <strong>".$singlelevel['answer']."</strong><br/>" ;
             $layman_summar .=  "The pain is described as <strong>".implode(', ', $singlelevel['answer'])."</strong><br/>" ;

           break;
        case 40:
           // $layman_summar .=  "You described the pain as: <strong>".$singlelevel['answer']."</strong><br/>" ;
        if(!empty($singlelevel['answer']))
             $layman_summar .=  "The pain radiates to the <strong>". $singlelevel['answer']."</strong><br/>" ;

           break;

        case 41:
            $singlelevel['answer'] =  stripos($singlelevel['answer'], 'comes') !== false ? $singlelevel['answer'] : 'is '.$singlelevel['answer'] ;
           $layman_summar .=  "The pain is described as <strong>".strtolower($singlelevel['answer'])."</strong><br/>" ;
           break;
        case 42:
           $layman_summar .=  "The pain is the worst in <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong><br/>" ;
           break;
        case 44:


             $layman_summar .=  "You go to bed around <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong> each night.<br/>" ;
           break;

        case 45:

             $layman_summar .=  "You take about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." minutes</strong> to fall asleep.<br/>" ;
           break;
        case 46:

             $layman_summar .=  "You get about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours</strong> of sleep each night.<br/>" ;
           break;
        case 47:


             $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>You leave the TV on or use your phone while in bed</strong>.<br/>" : "<strong>You do not leave the TV on or use your phone while in bed</strong>.<br/>";
           break;
        case 48:

             $layman_summar .=  "You take about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trip(s)</strong> in the middle of the night.<br/>" ;
           break;
        case 49:

             $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>You feel rested when you wake up in the morning</strong>.<br/>" : "<strong>You do not feel rested when you wake up in the morning</strong>.<br/>";
           break;
        case 50:


             $layman_summar .= $singlelevel['answer'] == 'Yes' ? "You take <strong>".(isset($value[$k+1]['answer']) ? $value[$k+1]['answer'] : '')." naps</strong> during the day.<br/>" :"<strong>You do not take naps during the day</strong>.<br/>" ;
           break;
        /*case 51:

             $layman_summar .=  "About <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong> naps, I am take per day.<br/>" ;
           break;*/
        case 52:

             $layman_summar .=  "You work about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours</strong> a week.<br/>" ;
           break;

        case 53:

              $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
             $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>You exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "")."</strong>.<br/>" : "You do not exercise.<br/>";
           break;
       /* case 54:

          if(isset($value[$k-1]['answer']) && $value[$k-1]['answer'] == 'Yes'){

              $layman_summar .=  "You exercise in the <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br/>" ;
          }
           break;*/
        case 55:
             $layman_summar .=  "Pain is described as <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(', ', $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br/>" ;
           break;
        case 56:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;
        case 57:

            //pr($k);die('fdfdf');
              if($singlelevel['answer'] == 'Yes'){

                if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 58){
                    $layman_summar .=  "Abdominal pain travels to <strong>".(is_array($value[$k+1]['answer']) ? strtolower(implode(', ', $value[$k+1]['answer'])) :strtolower($value[$k+1]['answer']))."</strong>.<br/>" ;
                  }
                  else{

                    $layman_summar .=  "<strong>The abdominal pain travel to another body part</strong>.<br/>" ;

                  }
              }
              else{

                $layman_summar .=  "<strong>The abdominal pain does not travel to another body part</strong>.<br/>" ;

                }

           break;
        case 59:

              $arr = array(

                '' => 'How many times',
                '1' => 'Per hour',
                '2' => 'Per day',
                '3' => 'Per week',
                '4' => 'Per month'


                );

            $layman_summar .= '<strong>'.ucfirst($arr[$singlelevel['answer']]).'</strong> feel '.$value['cc_data']['name'].'.<br />';

            break;
         case 60:

              $arr = array(

                '' => 'How long each episode',
                '1' => 'Seconds',
                '2' => 'Minutes',
                '3' => 'Hours',
                '4' => 'days'
                );
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
            $layman_summar .= 'Each episode lasts about <strong>'.$arr[$singlelevel['answer']].'</strong> long.<br />';

            break;
        case 61:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';

          $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>  makes it worse.<br />';

            break;
        case 62:
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
            $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong> makes it better.<br />';

            break;
        case 63:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';

          if(!empty($singlelevel['answer']) && $singlelevel['answer'] == 'No'){

            $layman_summar .= 'You haven’t been to the ER or hospital for '.$value['cc_data']['name'].'.<br />';

          }else{

            $ans_64 = "";
            $ans_65 = "";
            $ans_66 = "";
            $ans_67 = "";

            $question_66 = array(
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

            if(isset($value[$k+1]) && $value[$k+1]['question_id'] == 64){

              $ans_64 = !empty($value[$k+1]['answer']) ? $value[$k+1]['answer']:"";

            }

            if(isset($value[$k+2]) && $value[$k+2]['question_id'] == 65){

              $ans_65 = !empty($value[$k+2]['answer']) ? $value[$k+2]['answer']:"";

            }


            if(isset($value[$k+3]) && $value[$k+3]['question_id'] == 66){

              $ans_66 = (!empty($value[$k+3]['answer']) && $question_66[$value[$k+3]['answer']]) ? $question_66[$value[$k+3]['answer']]:"";

            }

            if(isset($value[$k+4]) && $value[$k+4]['question_id'] == 67){

              $ans_67 = !empty($value[$k+4]['answer']) ? $value[$k+4]['answer']:"";

            }

            $layman_summar .= 'You went to the ER or hospital <strong>'.$ans_64.' times</strong>.<br /> Your last visit was <strong>'.$ans_65.'</strong> at <strong>'.$ans_67.'</strong> where you stayed <strong>'.$ans_66.'</strong>.<br />';

          }

            break;
       /* case 64:

          if(!empty($singlelevel['answer'])){
            $layman_summar .= '<strong>'.$singlelevel['answer'].'</strong>  times go to the ER or stayed in the hospital for '.$value['cc_data']['name'].'.<br />';
          }
          break;
        case 65:

          if(!empty($singlelevel['answer'])){
            $layman_summar .= 'I have go at <strong>'.$singlelevel['answer'].'</strong> to the ER or stayed in the hospital for '.$value['cc_data']['name'].'.<br />';
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
          if(!empty($singlelevel['answer'])){
            $layman_summar .= '<strong>'.$arr[$singlelevel['answer']].'</strong> stay in the hospital for '.$value['cc_data']['name'].'.<br />';
          }

            break;*/

        case 67:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';
          /*if(!empty($singlelevel['answer'])){
            $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong> hospital or ER for '.$value['cc_data']['name'].'.<br />';
          }*/

            break;

        case 68:

            if(!empty($singlelevel['answer'])){

              if($singlelevel['answer'] == 'No'){


                $layman_summar .='<strong>You have not done procedures like a heart catherization, stent placement, or open heart bypass surgery</strong>.<br />';
              }
              elseif($singlelevel['answer'] == 'Yes'){

                $layman_summar .= '<strong>You have done procedures like a heart catherization, stent placement, or open heart bypass surgery</strong>.<br />';
              }
              else{

                $layman_summar .= "<strong>You don't know</strong> if you have done procedures like a heart catherization, stent placement, or open heart bypass surgery.<br />";
              }
             }

            break;

         case 69:


            $layman_summar .= 'You report being able to climb <strong>'.$singlelevel['answer'].'</strong> flights of stairs without stopping.<br />';

            break;

        case 70:

            $layman_summar .= 'You notice the symptom <strong>'.ucfirst($singlelevel['answer']).' times</strong> each day.<br />';

            break;

        case 71:
           // print_r($singlelevel['answer']);die;
            $layman_summar .= 'You noticed symptoms starting after eating <strong>'.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).'</strong>.<br />';

            break;
        case 72:
          $layman_summar .= "It has occurred <strong>".$singlelevel['answer']." time(s).</strong> <br />";
          break;

         case 73:

          $question_73 = $singlelevel['answer'];
          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You are having trouble drinking liquids or swallowing solid food</strong>.<br />" : "<strong>You are not having trouble drinking liquids or swallowing solid food</strong>.<br />";
          break;

         case 74:

          if(isset($question_73) && $question_73 == 'Yes'){

            if($singlelevel['answer'] == 'Liquids only'){

              $layman_summar .= "You are having trouble swallowing <strong>".(is_array($value[2]['answer'])? strtolower(implode(', ',$value[2]['answer'])): strtolower($value[2]['answer']))."</strong>.<br />";

            }else{

               $layman_summar .= "You are having trouble swallowing <strong>".strtolower($singlelevel['answer'])."</strong>.<br />";
            }
          }

          break;

        case 76:

          $arr = array(

            0 => '',
            1 => 'Every day',
            2 => 'Every other day',
            3 => 'per week'

          );
          $layman_summar .= " You go for a number two <strong>".$singlelevel['answer']." times ".strtolower($arr[$value[$k+1]['answer']])."</strong>.<br />";
          break;

        case 78:


          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You recently traveled out of the country</strong>.<br />" : "<strong>You have not recently traveled out of the country</strong>.<br />";
          break;

        case 79:


          $layman_summar .= "You traveled to <strong>".strtolower($singlelevel['answer'])."</strong>.<br />";
          break;

        case 80:

          $layman_summar .= "You recently started <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

        case 81:

          $layman_summar .= "You eat <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

        case 82:


          $layman_summar .= "You drink <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))." glasses</strong> of water in a day.<br />";
          break;

        case 83:


          $layman_summar .= "You recently started <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

        case 84:
          $layman_summar .= "You notice blood in stool <strong>".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." times per week</strong>.<br />";
          break;

        case 85:


          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have noticed bright red streaks of blood on the toilet paper</strong>.<br />" :"<strong>You have not noticed bright red streaks of blood on the toilet paper</strong>.<br />";
          break;

        case 86:


          $layman_summar .= "The color of stool is <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

         case 87:

          $layman_summar .= "You recently started <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";

          //$layman_summar .= "<strong>".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))."</strong> medications recently started.<br />";
          break;

        case 88:

          $ans_88 = $singlelevel['answer'];
          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You did eat at a restaurant within 24 hours of symptoms</strong>.<br />" : "<strong>You did not eat at a restaurant within 24 hours of symptoms</strong>.<br />";
          break;

        case 89:

          if(isset($ans_88) && $ans_88 == 'Yes'){

            $ques_ans_90 = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);
            $layman_summar .= "You ate <strong>".($ques_ans_90 != 'no' ? $ques_ans_90 : '')."</strong> at <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br />";
          }
          break;

         case 91:

          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have been in contact with any sick children within 24 hours of symptoms starting</strong>.<br />" : "<strong>You have not been in contact with any sick children within 24 hours of symptoms starting</strong>.<br />";
          break;

        case 92:

          if($singlelevel['answer'] == 'Yes'){

            $layman_summar .= "<strong>You are pregnant</strong>.<br />";
          }
          elseif($singlelevel['answer'] == 'No'){

            $layman_summar .= "<strong>You are not pregnant</strong>.<br />";
          }
          else{

            $layman_summar .= "<strong>You are not sure, you are pregnant</strong>.<br />";
          }
          //$layman_summar .= "<strong>".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))."</strong> pregnant.<br />";
          break;

        case 93:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;

        case 94:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "<strong>".ucfirst(implode(", ", $singlelevel['answer'])).'</strong> radiating.<br />';
            break;

        case 95:

          $ans_95  = is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']);
          if($ans_95 == 'no'){

            $layman_summar .= "<strong>The pain does not travel.</strong><br />";
          }
          else{

            $layman_summar .= "The pain travels to: <strong>".$ans_95.'</strong>.<br />';
          }
            break;
        case 96:

          $ans_96 = is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'];
          if($ans_96 == 'Only after meals' || $ans_96 == 'Same all day'){

            $layman_summar .= "It occurs <strong>".strtolower($ans_96).'.</strong><br />';
          }
          else{

            $layman_summar .= "It occurs during the <strong>".strtolower($ans_96).'.</strong><br />';
          }
           //$layman_summar .= "It occurs <strong>".implode(", ", $singlelevel['answer']).'.</strong><br />';
            break;
        case 97:

              $arr = array(

                '' => '',
                '1' => 'per hour',
                '2' => 'per day',
                '3' => 'per week',
                '4' => 'per month'


                );

            $layman_summar .= 'You feel the '.$value['cc_data']['name'].' about <strong>'.$singlelevel['answer'].' times '.$arr[$value[$k+1]['answer']].'</strong>.<br />';

            break;
         case 99:

              $arr = array(

                '' => '',
                '1' => 'seconds',
                '2' => 'minutes',
                '3' => 'hours',
                '4' => 'days'


                );
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
            $layman_summar .= 'Episodes last <strong>'.$singlelevel['answer'].' '.$arr[$value[$k+1]['answer']].'</strong> long.<br />';

            break;
          case 101:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;

          case 102:

          $temp_str_102 = '';

          if(!empty($singlelevel['answer'])){
          $singlelevel['answer'] = explode(',', $singlelevel['answer']) ;

          $ruq_s = 'Right upper quadrant (RUQ(';
          $rlq_s = 'Right lower quadrant (RLQ(';
          $luq_s = 'Left upper quadrant (LUQ(';
          $llq_s = 'Left lower quadrant (LLQ(';

          if($gender == 1){

            $ruq = array('l-top1','mid2','l-top2','mid4','mid6');
            $luq = array('mid3','r-top1','mid5','r-top2','mid7');
            $rlq = array('mid9','l-top3','l-top3','mid8','l-bottom','mid12');
            $llq = array('mid10','r-top3','mid11','mid13','r-bottom');

            foreach ($singlelevel['answer'] as $k102 => $v102) {

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
          if($gender == 0){

            $ruq = array('l1','mid2','l2','mid4','mid6');
            $luq = array('mid3','r1','mid5','r2','mid7');
            $rlq = array('l3','l4','mid8','mid10','mid12');
            $llq = array('mid11','mid9','r3','mid13','r4');

            foreach ($singlelevel['answer'] as $k102 => $v102) {

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



          //$temp_str_102 = rtrim($temp_str_102, ', ');

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
          //echo $ruq_s.'<br>'.$rlq_s.'<br>'.$llq_s.'<br>'.$luq_s.'<br>';

           $layman_summar .=  "You feel pain in the: <strong>".$temp_str_102."</strong><br/>" ;
        }

        break;

    case 103:

      $temp_str_103 = '';

      if(!empty($singlelevel['answer'])){

        $singlelevel['answer'] = explode(',', $singlelevel['answer']) ;

        if(in_array('left-bottom-left',$singlelevel['answer'])){

                $key = array_search('left-bottom-left', $singlelevel['answer']);
                $singlelevel['answer'][$key] = 'left-bottom-right';
            }

            if(in_array('right-bottom-left',$singlelevel['answer'])){

                $key = array_search('right-bottom-left', $singlelevel['answer']);
                $singlelevel['answer'][$key] = 'right-bottom-right';
            }

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

            $layman_summar .=  "You feel pain in the: <strong>".$temp_str_103."</strong><br/>" ;
      }

      break;

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

                $layman_summar .= "You have been in pain for <strong>".ucfirst($question_104[$singlelevel['answer']])."</strong> and the pain started on <strong>".$value[$k+1]['answer']."</strong>.<br/>";

              }else{

                $layman_summar .= "You have been in pain for <strong>".ucfirst($question_104[$singlelevel['answer']])."</strong>.<br/>";
              }

              break;
          case 106:

                $question_106 = array(

                  'Left' => 'left',
                  'Right' => 'right',
                  'Both' => 'bilateral'
                 );

                $question_107 = array(

                  'Right more than left' => 'R>L',
                  'Left more than right' => 'L>R',
                  'About the same' => 'L=R'
                 );

               if($singlelevel['answer'] == 'Both'){

                  if($value[$k+1]['question_id'] == 107 && !empty($value[$k+1]['answer'])){

                    $layman_summar .= "You have pain in the <strong>".$question_106[$singlelevel['answer']]." foot (".$question_107[$value[$k+1]['answer']].")</strong>.<br />";

                  }else{

                    $layman_summar .= "You have pain in the <strong>".$question_106[$singlelevel['answer']]."</strong> foot.<br />";

                  }
                }else{

                    $layman_summar .= "You have pain in the <strong>".$question_106[$singlelevel['answer']]."</strong> foot.<br />";

                  }

              break;
          case 108:

              $question_108 = array(


                'Bottom of foot' => 'plantar of foot',
                'Back of foot' => 'back of foot',
                'Both top and bottom' => 'all over foot',
                'Front of foot' => 'anterior foot',
                'Heel of foot' => 'posterior foot',
                'Both front and back foot' => 'both front and back foot'

              );

              $ans = '';

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                  $ans .= $question_108[$qval].', ';
                }
              }else{

                $ans = $singlelevel['answer'];
              }

              $layman_summar .= "Your foot hurts on the <strong>".rtrim($ans,', ')."</strong>.<br/>";

              break;
          case 109:

              $question_109 = array(

                'Side of big toe' => 'medial sided',
                'Small toe side' => 'lateral sided',
                'Both sides of foot' => 'both sides of foot'
              );

               $ans = '';

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                  $ans .= $question_109[$qval].', ';
                }
              }else{

                $ans = $singlelevel['answer'];
              }

              $layman_summar .= "Your foot hurts on the <strong>".rtrim($ans,', ')."</strong>.<br/>";

              break;

          case 110:

              $ans = "";

              if($singlelevel['answer'] == 'Suddenly'){

                $ans_111 = $value[$k+1]['answer'];

                if(in_array('fall', $ans_111)){

                  $ans_112 = $value[$k+2]['answer'];
                  $ans_112 = is_array($ans_112) ? implode(", ", $ans_112) : $ans_112;
                  //pr($ans_112);die;

                  $layman_summar .= "The pain started <strong>".strtolower($singlelevel['answer'])."</strong> due to <strong>".(is_array($ans_111) ? implode(", ", $ans_111) : $ans_111)."</strong> and you fell due to <strong>".$ans_112."</strong>.<br/>";

                }else{

                    $ans_111 = is_array($ans_111) ? implode(", ", $ans_111) : $ans_111;

                  $layman_summar .= "The pain started <strong>".strtolower($singlelevel['answer'])."</strong> due to <strong>".($ans_111 == "I don't know" ? 'unknown reasons' : $ans_111)."</strong>.<br/>";
                }
              }else{

                $layman_summar .= "The pain started <strong>".strtolower($singlelevel['answer'])."</strong>.<br/>";
              }

              break;

          case 113:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The injury happened at work</strong>.<br/>":"<strong>The injury did not happen at work</strong>.<br/>";

            break;

          case 114:

              $layman_summar .= "You described the pain as <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br/>";

            break;

          case 115:

             //$layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The current pain is worse than the original pain</strong>.<br/>" : "<strong>The current pain is not worse than the original pain</strong>.<br/>";
            $ques_ans_115 = strtolower($singlelevel['answer']);
            $translate_115 = array(

              'worse' => 'worsened',
              'better' => 'improved',
              'same' => 'remained stable'
            );
            $layman_summar .= "Current pain level has <strong>".$translate_115[$ques_ans_115].'</strong> since initial presentation.<br />';

            break;

        case 116:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The ".str_replace(" pain", "", $cur_cc_name)." feels warm to touch</strong>.<br/>" : "<strong>The ".str_replace(" pain", "", $cur_cc_name)." does not feel warm to touch</strong>.<br/>";

            break;

        case 117:

              if($singlelevel['answer'] == 'Yes'){

                $layman_summar .= "You have stiffness/pain in <strong>".(is_array($value[$k+1]['answer']) ? implode(", ",$value[$k+1]['answer']) : $value[$k+1]['answer'])."</strong> joints.<br/>";

              }else{

                $layman_summar .= "<strong>You do not have stiffness/pain in other joints</strong>.<br/>";

              }

            break;

         case 119:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have abnormal hair/nail growth or sweating</strong>.<br/>" : "<strong>You do not have abnormal hair/nail growth or sweating</strong>.<br/>" ;

            break;

         case 120:

               $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>Your feet are swollen</strong>.<br/>" : "<strong>Your feet are not swollen</strong>.<br/>" ;
            break;

        case 121:

            if($singlelevel['answer'] == 'comes and goes'){

              $layman_summar .= "Your foot pain is described as <strong>intermittent</strong>.<br/>";

            }
            else{

               $layman_summar .= "Your foot pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>";

            }

            break;

          case 122:

              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "The foot pain is the worst in the <strong>".$singlelevel['answer']."</strong> .<br /><strong>".($value[$k+1]['answer'] == 'Yes' ? 'The pain lasts for more than one hour' : 'The pain does not last for more than one hour')."</strong>.<br/>";

              }else{

                $layman_summar .= "The foot pain is the worst <strong>".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer'])."</strong>.<br/>";
              }

              /*if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your foot pain the worst. <strong>".$value[$k+1]['answer']."</strong>, the pain last for more than one hour or less.<br/>";

              }else{

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your foot pain the worst.<br/>";
              }*/

            break;

          case 124:

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> causes your pain to get better.<br/>";

            break;

          case 125:

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> causes your pain to get worse.<br/>";

            break;

          case 126:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have muscle spasms</strong>.<br/>" : "<strong>You do not have muscle spasms</strong>.<br/>";

            break;

          case 127:

                $question_127 = array(

                  'Left' => 'left',
                  'Right' => 'right',
                  'Both' => 'bilateral'
                 );

                $question_128 = array(

                  'Right more than left' => 'R>L',
                  'Left more than right' => 'L>R',
                  'About the same' => 'L=R'
                 );

               if($singlelevel['answer'] == 'Both'){

                  if($value[$k+1]['question_id'] == 128 && !empty($value[$k+1]['answer'])){

                    $layman_summar .= "You have pain in the <strong>".$question_127[$singlelevel['answer']]." ankle (".$question_128[$value[$k+1]['answer']].")</strong>.<br />";

                  }else{

                    $layman_summar .= "You have pain in the <strong>".$question_127[$singlelevel['answer']]."</strong> ankle.<br />";

                  }
                }else{

                    $layman_summar .= "You have pain in the <strong>".$question_127[$singlelevel['answer']]."</strong> ankle.<br />";

                  }

              break;

            case 129:

            //pr($singlelevel);

              $question_129 = array(


                'front of ankle' => 'anterior ankle',
                'back of ankle' => 'posterior ankle',
                'both front and back of ankle' => 'both front and back of ankle'

              );

              $ans = null;

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                  $ans[]= $question_129[$qval];
                }
                 $ans = implode(", ", $ans);
              }else{

                $ans = $singlelevel['answer'];
              }


              //pr($ans);

              //$ans = rtrim(", ",$ans);

              $layman_summar .= "Your ankle hurts on the <strong>".$ans."</strong>.<br/>";

              break;

           case 130:

           //pr($singlelevel);

              $question_130 = array(

                "side of big toe" => 'medial sided',
                "small toe side" => 'lateral sided',
                "both sides of ankle" => 'both sides of ankle'
              );

               $ans = null;

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                 // pr($qval);

                  $que = trim($qval);

                  $ans[] = $question_130[$que];
                }

                $ans = implode(", ",$ans);
              }else{

                $ans = $singlelevel['answer'];
              }

              //pr($ans);

              $layman_summar .= "Your ankle hurts on the <strong>".$ans."</strong>.<br/>";

              break;

          case 131:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The ankle is swollen</strong>.<br/>" : "<strong>The ankle is not swollen</strong>.<br/>" ;

            break;

          case 132:

            if($singlelevel['answer'] == 'comes and goes'){

              $layman_summar .= "Your ankle pain is described as <strong>intermittent</strong>.<br/>";

            }
            else{

               $layman_summar .= "Your ankle pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>";

            }

            break;

        case 133:

              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "The ankle pain is the worst in the <strong>".$singlelevel['answer']."</strong> .<br /><strong>".($value[$k+1]['answer'] == 'Yes' ? 'The pain lasts for more than one hour' : 'The pain does not last for more than one hour')."</strong>.<br/>";

              }else{

                $layman_summar .= "The ankle pain is the worst <strong>".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer'])."</strong>.<br/>";
              }

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

                    $layman_summar .= "You have pain in the <strong>".$question_135[$singlelevel['answer']]." hip (".$question_136[$value[$k+1]['answer']].")</strong><br />";

                  }else{

                    $layman_summar .= "You have pain in the <strong>".$question_135[$singlelevel['answer']]."</strong> hip.<br />";

                  }
                }else{

                    $layman_summar .= "You have pain in the <strong>".$question_135[$singlelevel['answer']]."</strong> hip.<br />";

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

              $layman_summar .= "Location of hip pain : <strong>".rtrim($ans,', ')."</strong>.<br/>";

              break;

           case 138:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have hip pain when you stand or put weight on the side of pain</strong>.<br/>" : "<strong>You do not have hip pain when you stand or put weight on the side of pain</strong>.<br/>";

            break;

          case 139:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have pain with direct pressure on pain site</strong>.<br/>" : "<strong>You do not have pain with direct pressure on pain site</strong>.<br/>";

            break;

         case 140:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>Your hip is swollen</strong>.<br/>" : "<strong>Your hip is not swollen</strong>.<br/>" ;
               //$layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The hip is swollen</strong>.<br/>" : "<strong>The hip is not swollen</strong>.<br/>" ;

            break;

        case 141:

            if($singlelevel['answer'] == 'comes and goes'){

              $layman_summar .= "Your hip pain is described as <strong>intermittent</strong>.<br/>";

            }
            else{

               $layman_summar .= "Your hip pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>";

            }

            break;


         case 142:

              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "The hip pain is the worst in the <strong>".$singlelevel['answer']."</strong> . <strong><br />".($value[$k+1]['answer'] == 'Yes' ? 'The pain lasts for more than one hour' : 'The pain does not last for more than one hour')."</strong>.<br/>";

              }else{

                $layman_summar .= "The hip pain is the worst <strong>".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer'])."</strong>.<br/>";
              }


/*
              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your hip pain the worst. <strong>".$value[$k+1]['answer']."</strong>, the pain last for more than one hour or less.<br/>";

              }else{

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your hip pain the worst.<br/>";
              }*/

            break;

        case 144:

          if(!empty($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 145){

             //Out of 10, the pain is a [X] at its best, and a [Y] at its worst.
             $layman_summar .= "Out of 10, the pain is a <strong>".$singlelevel['answer']."</strong> at its best, and a <strong>".$value[$k+1]['answer']."</strong> at its worst.<br/>";
          }

          break;

        case 146 :

              $question_146 = array(

                'worse' => 'aggravate',
                'better' => 'alleviate',
                'about the same' => 'same'

              );
              $layman_summar .= "Overall, you feels <strong>".$question_146[$singlelevel['answer']]."</strong> since your last visit.<br/>";
              break;
        case 147 :

              if(!empty($singlelevel['answer'])){
                  $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> makes aggravate.<br/>";
              }
              break;

        case 148 :

              if(!empty($singlelevel['answer'])){

                  $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> makes alleviate.<br/>";
                }
              break;
        case 149 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You have been vomiting.<br>";
              break;

        case 150 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])." times</strong> You vomited since your last visit. <br>";
              break;
        case 151 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You have seen bright red blood.<br>";
              break;
        case 152 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You have seen stuff that looks like coffee grounds.<br>";
              break;

        case 153 :

              $layman_summar .= "The headache is on the <strong>".(strtolower($singlelevel['answer']) == 'both sides' ? strtolower($singlelevel['answer']).'</strong>' : strtolower($singlelevel['answer']).'</strong> side')." of your head.<br>";
              break;

        case 154 :

             //$layman_summar .= "It occurs <strong>".$singlelevel['answer'].'.</strong><br />';
          if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

            $layman_summar .= "It occurs <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
          }
          else{

            $layman_summar .= "It occurs during the <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
          }
             break;

        case 155 :

            $ques_ans_155 = strtolower(is_array($singlelevel['answer']) ? implode(", ",$singlelevel['answer']): $singlelevel['answer']);

              $layman_summar .= "Headache is typically located ".($ques_ans_155 == 'all over' ? '<strong>'.$ques_ans_155 : 'at the <strong>'.$ques_ans_155)."</strong>.<br>";
              break;

        case 156:

          $ques_ans_156 = 'You state that the '.$cur_cc_name.' is better with '.strtolower($singlelevel['answer']);
            if(!empty($ques_ans_157)){
              $layman_summar .= $ques_ans_156.''.$ques_ans_157.'.<br>';
              $ques_ans_156 = ''; $ques_ans_157 = '';
            }
            break;

        case 157:

          $ques_ans_157 = ' and worse with '.strtolower($singlelevel['answer']);


            if(!empty($ques_ans_156)){
              $layman_summar .= $ques_ans_156.''.$ques_ans_157.'.<br>';
              $ques_ans_156 = ''; $ques_ans_157 = '';
            }

            break;

        case 158:

          $layman_summar .= "The chest pain began <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ",$singlelevel['answer'])): strtolower($singlelevel['answer']))."</strong>.<br>";

            break;

        case 159:

          $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You noticed locking, catching, or feeling like the joint gives out.': "You did not notice locking, catching, or feeling like the joint gives out.<br>";

            break;

        case 172:
           $layman_summar .=  "The symptom start <strong>".$singlelevel['answer']."</strong>.<br/>" ;

           break;

        case 182:
           if(strtolower($singlelevel['answer']) == 'Yes'){

                    if(isset($value[$k+1]) && $value[$k+1]['question_id'] == 183 && !empty($value[$k+1]['answer'])){

                      $layman_summar .= "You had <strong>" .$value[$k+1]['answer']. " </strong> sexual partners in the last 2 months</strong>.<br />" ;
                    }
                    else{

                      $layman_summar .= '<strong>You had sexual partners in the last 2 months</strong>.<br />';
                    }
                  }
                  else{

                    $layman_summar .= "You haven't been sexually active in the last 2 months.<br />";
                  }
           break;

       

        case 184:
           $layman_summar .=  $singlelevel['answer'] == 'Yes' ? 'You and your partner(s) use condemns during intercourse.': "You and your partner(s) do not use condemns during intercourse.<br>";
           break;

        case 185:
           $layman_summar .=  "You and your partner(s) use condemns <strong>".$singlelevel['answer']."</strong>.<br/>" ;
           break;   

        case 43:

        // pr($singlelevel['answer']); die;
        $temp_str_43 = '' ;
        if(!empty($singlelevel['answer'])){
          $singlelevel['answer'] = explode(',', $singlelevel['answer']) ;

          foreach ($singlelevel['answer'] as $k43 => $v43) {
            $temp_str_43 .= isset($img_backpain_detial_q_arr[$v43]) ? $img_backpain_detial_q_arr[$v43].', ' : "" ;
          }

          $temp_str_43 = rtrim($temp_str_43, ', ');
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
// pr($ttemp); die;
     $ttemp = rtrim($ttemp, ', ');
     // $temp_summar .= $ttemp.'), ';
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
      // $temp_summar .= ' (Thoracic(';
      $ttemp = array();
      if(stripos($temp_str_43, 't1') !== false ) $ttemp[] = 'T1';if(stripos($temp_str_43, 't2') !== false ) $ttemp[] = 'T2';if(stripos($temp_str_43, 't3') !== false ) $ttemp[] = 'T3';if(stripos($temp_str_43, 't4') !== false ) $ttemp[] = 'T4';if(stripos($temp_str_43, 't5') !== false ) $ttemp[] = 'T5';if(stripos($temp_str_43, 't6') !== false ) $ttemp[] = 'T6';if(stripos($temp_str_43, 't7') !== false ) $ttemp[] = 'T7';if(stripos($temp_str_43, 't8') !== false ) $ttemp[] = 'T8';if(stripos($temp_str_43, 't9') !== false ) $ttemp[] = 'T9';if(stripos($temp_str_43, 't10') !== false ) $ttemp[] = 'T10';if(stripos($temp_str_43, 't11') !== false ) $ttemp[] = 'T11';if(stripos($temp_str_43, 't12') !== false ) $ttemp[] = 'T12';

$tttemp = array();
foreach ($ttemp as $kt1 => $vt1) {
  $tttemp[] = (int) filter_var($vt1, FILTER_SANITIZE_NUMBER_INT);
}
sort($tttemp);
$ftemp = 'T';
// pr($tttemp); die;
// $tttemp= array('1','3','5','7','8','9','11','12');

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
    }elseif((empty($start_vt2) && !empty($prev_vt2)) && (strpos($ftemp, '-') !== false)){ // if range after first element
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
// echo 'hi';
// pr($ftemp); die;
$ttemp = strtoupper($ftemp) ; // $ftemp;
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
// $ttemp = array('L4','L2','L5');
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

// pr($ttemp); die;

     if(!empty($ttemp)){
      $ttemp = rtrim($ttemp, ', ');
       // $temp_summar .= $ttemp.'), ';
      $temp_summar .= $ttemp.', ';
       $ttemp = ''; }

  }

  if(stripos($temp_str_43, 'Sacral') !== false ){
     // $temp_summar .= '(Sacral (' ;
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
// pr($ttemp); die;
     if(!empty($ttemp)){
      $ttemp = rtrim($ttemp, ', ');
      // $temp_summar .= $ttemp.')), ';
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

  // if(stripos($temp_str_43, 'Shoulder pain (Interscapular (left))') !== false ){ $temp_summar .= 'Interscapular (left), ' ; }  // we commented this because we think  Interscapular (left)  is in Upper back pain



  $temp_summar = rtrim($temp_summar, ', ');

  $temp_summar .= '), ';

}
 // pr($temp_str_43); die;
// echo 'hello';
// pr($temp_summar); die;
// ************************* Human body option remove redundancy END *********************

  $temp_summar = rtrim($temp_summar, ', ');
$temp_str_43 = $temp_summar; //  strtolower($temp_summar);
 // pr($temp_str_43); die;
// echo 'hello';
// pr($temp_summar); die;
// ************************* Human body option remove redundancy END *********************


        /* code commented as not used now
          if(is_array($singlelevel['answer'])){
            // pr($singlelevel['answer']); die;

            foreach ($singlelevel['answer'] as $k43 => $v43) {
              $singlelevel['answer'][$k43] = isset($img_backpain_loc[$v43]) ? $img_backpain_loc[$v43] : '' ;
            }

          }
          */
          // pr($singlelevel['answer']); die;
           $layman_summar .=  "You feel pain in the: <strong>".$temp_str_43."</strong><br/>" ;
           break;




    }

// switch case end


      }
      // pr($k);
      // pr($singlelevel); die;
    }



  }
  


           break;
        case 47:


             $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>You leave the TV on or use your phone while in bed</strong>.<br/>" : "<strong>You do not leave the TV on or use your phone while in bed</strong>.<br/>";
           break;
        case 48:

             $layman_summar .=  "You take about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." trip(s)</strong> in the middle of the night.<br/>" ;
           break;
        case 49:

             $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>You feel rested when you wake up in the morning</strong>.<br/>" : "<strong>You do not feel rested when you wake up in the morning</strong>.<br/>";
           break;
        case 50:


             $layman_summar .= $singlelevel['answer'] == 'Yes' ? "You take <strong>".(isset($value[$k+1]['answer']) ? $value[$k+1]['answer'] : '')." naps</strong> during the day.<br/>" :"<strong>You do not take naps during the day</strong>.<br/>" ;
           break;
        /*case 51:

             $layman_summar .=  "About <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong> naps, I am take per day.<br/>" ;
           break;*/
        case 52:

             $layman_summar .=  "You work about <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])." hours</strong> a week.<br/>" ;
           break;

        case 53:

              $ans_54 = isset($value[$k+1]['answer']) ?(is_array($value[$k+1]['answer']) ? implode(', ', $value[$k+1]['answer']) : $value[$k+1]['answer'])  : "";
             $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>You exercise".(!empty($ans_54) ? ' in the '.$ans_54 : "")."</strong>.<br/>" : "<strong>You do not exercise</strong>.<br/>";
           break;
       /* case 54:

        	if(isset($value[$k-1]['answer']) && $value[$k-1]['answer'] == 'Yes'){

             	$layman_summar .=  "You exercise in the <strong>".(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br/>" ;
        	}
           break;*/
        case 55:
             $layman_summar .=  "Pain is described as <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(', ', $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br/>" ;
           break;
        case 56:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;
        case 57:

        		//pr($k);die('fdfdf');
              if($singlelevel['answer'] == 'Yes'){

                if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 58){
                    $layman_summar .=  "Abdominal pain travels to <strong>".(is_array($value[$k+1]['answer']) ? strtolower(implode(', ', $value[$k+1]['answer'])) :strtolower($value[$k+1]['answer']))."</strong>.<br/>" ;
                  }
                  else{

                    $layman_summar .=  "<strong>The abdominal pain travel to another body part</strong>.<br/>" ;

                  }
              }
              else{

                $layman_summar .=  "<strong>The abdominal pain does not travel to another body part</strong>.<br/>" ;

                }

           break;
        case 59:

              $arr = array(

                '' => 'How many times',
                '1' => 'Per hour',
                '2' => 'Per day',
                '3' => 'Per week',
                '4' => 'Per month'


                );

            $layman_summar .= '<strong>'.ucfirst($arr[$singlelevel['answer']]).'</strong> feel '.$value['cc_data']['name'].'.<br />';

            break;
         case 60:

              $arr = array(

                '' => 'How long each episode',
                '1' => 'Seconds',
                '2' => 'Minutes',
                '3' => 'Hours',
                '4' => 'days'
                );
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
            $layman_summar .= 'Each episode lasts about <strong>'.$arr[$singlelevel['answer']].'</strong> long.<br />';

            break;
        case 61:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';

          $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>  makes it worse.<br />';

            break;
        case 62:
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
            $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong> makes it better.<br />';

            break;
        case 63:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';

          if(!empty($singlelevel['answer']) && $singlelevel['answer'] == 'No'){

            $layman_summar .= 'You haven’t been to the ER or hospital for '.$value['cc_data']['name'].'.<br />';

          }else{

            $ans_64 = "";
            $ans_65 = "";
            $ans_66 = "";
            $ans_67 = "";

            $question_66 = array(
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

            if(isset($value[$k+1]) && $value[$k+1]['question_id'] == 64){

              $ans_64 = !empty($value[$k+1]['answer']) ? $value[$k+1]['answer']:"";

            }

            if(isset($value[$k+2]) && $value[$k+2]['question_id'] == 65){

              $ans_65 = !empty($value[$k+2]['answer']) ? $value[$k+2]['answer']:"";

            }


            if(isset($value[$k+3]) && $value[$k+3]['question_id'] == 66){

              $ans_66 = (!empty($value[$k+3]['answer']) && $question_66[$value[$k+3]['answer']]) ? $question_66[$value[$k+3]['answer']]:"";

            }

            if(isset($value[$k+4]) && $value[$k+4]['question_id'] == 67){

              $ans_67 = !empty($value[$k+4]['answer']) ? $value[$k+4]['answer']:"";

            }

            $layman_summar .= 'You went to the ER or hospital <strong>'.$ans_64.' times</strong>.<br /> Your last visit was <strong>'.$ans_65.'</strong> at <strong>'.$ans_67.'</strong> where you stayed <strong>'.$ans_66.'</strong>.<br />';

          }

            break;
       /* case 64:

          if(!empty($singlelevel['answer'])){
            $layman_summar .= '<strong>'.$singlelevel['answer'].'</strong>  times go to the ER or stayed in the hospital for '.$value['cc_data']['name'].'.<br />';
          }
          break;
        case 65:

          if(!empty($singlelevel['answer'])){
            $layman_summar .= 'I have go at <strong>'.$singlelevel['answer'].'</strong> to the ER or stayed in the hospital for '.$value['cc_data']['name'].'.<br />';
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
          if(!empty($singlelevel['answer'])){
            $layman_summar .= '<strong>'.$arr[$singlelevel['answer']].'</strong> stay in the hospital for '.$value['cc_data']['name'].'.<br />';
          }

            break;*/

        case 67:
            // $layman_summar .= "These things made it worse: <strong>".$singlelevel['answer'].'.</strong><br />';
          /*if(!empty($singlelevel['answer'])){
            $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong> hospital or ER for '.$value['cc_data']['name'].'.<br />';
          }*/

            break;

        case 68:

            if(!empty($singlelevel['answer'])){

              if($singlelevel['answer'] == 'No'){


                $layman_summar .='<strong>You have not done procedures like a heart catherization, stent placement, or open heart bypass surgery</strong>.<br />';
              }
              elseif($singlelevel['answer'] == 'Yes'){

                $layman_summar .= '<strong>You have done procedures like a heart catherization, stent placement, or open heart bypass surgery</strong>.<br />';
              }
              else{

                $layman_summar .= "<strong>You don't know</strong> if you have done procedures like a heart catherization, stent placement, or open heart bypass surgery.<br />";
              }
             }

            break;

         case 69:


            $layman_summar .= 'You report being able to climb <strong>'.$singlelevel['answer'].'</strong> flights of stairs without stopping.<br />';

            break;

        case 70:

            $layman_summar .= 'You notice the symptom <strong>'.ucfirst($singlelevel['answer']).' times</strong> each day.<br />';

            break;

        case 71:
           // print_r($singlelevel['answer']);die;
            $layman_summar .= 'You noticed symptoms starting after eating <strong>'.(is_array($singlelevel['answer']) ? implode(', ', $singlelevel['answer']) : $singlelevel['answer']).'</strong>.<br />';

            break;
        case 72:
          $layman_summar .= "It has occurred <strong>".$singlelevel['answer']." time(s).</strong> <br />";
          break;

         case 73:

          $question_73 = $singlelevel['answer'];
          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You are having trouble drinking liquids or swallowing solid food</strong>.<br />" : "<strong>You are not having trouble drinking liquids or swallowing solid food</strong>.<br />";
          break;

         case 74:

          if(isset($question_73) && $question_73 == 'Yes'){

            if($singlelevel['answer'] == 'Liquids only'){

              $layman_summar .= "You are having trouble swallowing <strong>".(is_array($value[2]['answer'])? strtolower(implode(', ',$value[2]['answer'])): strtolower($value[2]['answer']))."</strong>.<br />";

            }else{

               $layman_summar .= "You are having trouble swallowing <strong>".strtolower($singlelevel['answer'])."</strong>.<br />";
            }
          }

          break;

        case 76:

          $arr = array(

            0 => '',
            1 => 'Every day',
            2 => 'Every other day',
            3 => 'per week'

          );
          $layman_summar .= " You go for a number two <strong>".$singlelevel['answer']." times ".strtolower($arr[$value[$k+1]['answer']])."</strong>.<br />";
          break;

        case 78:


          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You recently traveled out of the country</strong>.<br />" : "<strong>You have not recently traveled out of the country</strong>.<br />";
          break;

        case 79:


          $layman_summar .= "You traveled to <strong>".strtolower($singlelevel['answer'])."</strong>.<br />";
          break;

        case 80:

          $layman_summar .= "You recently started <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

        case 81:

          $layman_summar .= "You eat <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

        case 82:


          $layman_summar .= "You drink <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))." glasses</strong> of water in a day.<br />";
          break;

        case 83:


          $layman_summar .= "You recently started <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

        case 84:
          $layman_summar .= "You notice blood in stool <strong>".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))." times per week</strong>.<br />";
          break;

        case 85:


          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have noticed bright red streaks of blood on the toilet paper</strong>.<br />" :"<strong>You have not noticed bright red streaks of blood on the toilet paper</strong>.<br />";
          break;

        case 86:


          $layman_summar .= "The color of stool is <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";
          break;

         case 87:

          $layman_summar .= "You recently started <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br />";

          //$layman_summar .= "<strong>".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))."</strong> medications recently started.<br />";
          break;

        case 88:

          $ans_88 = $singlelevel['answer'];
          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You did eat at a restaurant within 24 hours of symptoms</strong>.<br />" : "<strong>You did not eat at a restaurant within 24 hours of symptoms</strong>.<br />";
          break;

        case 89:

          if(isset($ans_88) && $ans_88 == 'Yes'){

            $ques_ans_90 = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);
            $layman_summar .= "You ate <strong>".($ques_ans_90 != 'no' ? $ques_ans_90 : '')."</strong> at <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br />";
          }
          break;

         case 91:

          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have been in contact with any sick children within 24 hours of symptoms starting</strong>.<br />" : "<strong>You have not been in contact with any sick children within 24 hours of symptoms starting</strong>.<br />";
          break;

        case 92:

          if($singlelevel['answer'] == 'Yes'){

            $layman_summar .= "<strong>You are pregnant</strong>.<br />";
          }
          elseif($singlelevel['answer'] == 'No'){

            $layman_summar .= "<strong>You are not pregnant</strong>.<br />";
          }
          else{

            $layman_summar .= "<strong>You are not sure, you are pregnant</strong>.<br />";
          }
          //$layman_summar .= "<strong>".(is_array($singlelevel['answer']) ? ucfirst(implode(", ", $singlelevel['answer'])) : ucfirst($singlelevel['answer']))."</strong> pregnant.<br />";
          break;

        case 93:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;

        case 94:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "<strong>".ucfirst(implode(", ", $singlelevel['answer'])).'</strong> radiating.<br />';
            break;

        case 95:

        	$ans_95  = is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']);
        	if($ans_95 == 'no'){

        		$layman_summar .= "<strong>The pain does not travel.</strong><br />";
        	}
        	else{

        		$layman_summar .= "The pain travels to: <strong>".$ans_95.'</strong>.<br />';
        	}
            break;
        case 96:

        	$ans_96 = is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'];
        	if($ans_96 == 'Only after meals' || $ans_96 == 'Same all day'){

        		$layman_summar .= "It occurs <strong>".strtolower($ans_96).'.</strong><br />';
        	}
        	else{

        		$layman_summar .= "It occurs during the <strong>".strtolower($ans_96).'.</strong><br />';
        	}
           //$layman_summar .= "It occurs <strong>".implode(", ", $singlelevel['answer']).'.</strong><br />';
            break;
        case 97:

              $arr = array(

                '' => '',
                '1' => 'per hour',
                '2' => 'per day',
                '3' => 'per week',
                '4' => 'per month'


                );

            $layman_summar .= 'You feel the '.$value['cc_data']['name'].' about <strong>'.$singlelevel['answer'].' times '.$arr[$value[$k+1]['answer']].'</strong>.<br />';

            break;
         case 99:

              $arr = array(

                '' => '',
                '1' => 'seconds',
                '2' => 'minutes',
                '3' => 'hours',
                '4' => 'days'


                );
            // $layman_summar .= "These things made it better: <strong>".$singlelevel['answer'].'.</strong><br />';
            $layman_summar .= 'Episodes last <strong>'.$singlelevel['answer'].' '.$arr[$value[$k+1]['answer']].'</strong> long.<br />';

            break;
          case 101:
            // echo '<pre>';
            // print_r($singlelevel['answer']);die;
             $layman_summar .= "It feels <strong>".strtolower(implode(", ", $singlelevel['answer'])).'.</strong><br />';
            break;

          case 102:

          $temp_str_102 = '';

          if(!empty($singlelevel['answer'])){
          $singlelevel['answer'] = explode(',', $singlelevel['answer']) ;

          $ruq_s = 'Right upper quadrant (RUQ(';
          $rlq_s = 'Right lower quadrant (RLQ(';
          $luq_s = 'Left upper quadrant (LUQ(';
          $llq_s = 'Left lower quadrant (LLQ(';

          if($gender == 1){

            $ruq = array('l-top1','mid2','l-top2','mid4','mid6');
            $luq = array('mid3','r-top1','mid5','r-top2','mid7');
            $rlq = array('mid9','l-top3','l-top3','mid8','l-bottom','mid12');
            $llq = array('mid10','r-top3','mid11','mid13','r-bottom');

            foreach ($singlelevel['answer'] as $k102 => $v102) {

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
          if($gender == 0){

            $ruq = array('l1','mid2','l2','mid4','mid6');
            $luq = array('mid3','r1','mid5','r2','mid7');
            $rlq = array('l3','l4','mid8','mid10','mid12');
            $llq = array('mid11','mid9','r3','mid13','r4');

            foreach ($singlelevel['answer'] as $k102 => $v102) {

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



          //$temp_str_102 = rtrim($temp_str_102, ', ');

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
          //echo $ruq_s.'<br>'.$rlq_s.'<br>'.$llq_s.'<br>'.$luq_s.'<br>';

           $layman_summar .=  "You feel pain in the: <strong>".$temp_str_102."</strong><br/>" ;
        }

        break;

		case 103:

			$temp_str_103 = '';

			if(!empty($singlelevel['answer'])){

				$singlelevel['answer'] = explode(',', $singlelevel['answer']) ;

				if(in_array('left-bottom-left',$singlelevel['answer'])){

		          	$key = array_search('left-bottom-left', $singlelevel['answer']);
		          	$singlelevel['answer'][$key] = 'left-bottom-right';
		        }

		        if(in_array('right-bottom-left',$singlelevel['answer'])){

		          	$key = array_search('right-bottom-left', $singlelevel['answer']);
		          	$singlelevel['answer'][$key] = 'right-bottom-right';
		        }

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

		        $layman_summar .=  "You feel pain in the: <strong>".$temp_str_103."</strong><br/>" ;
			}

			break;

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

                $layman_summar .= "You have been in pain for <strong>".ucfirst($question_104[$singlelevel['answer']])."</strong> and the pain started on <strong>".$value[$k+1]['answer']."</strong>.<br/>";

              }else{

                $layman_summar .= "You have been in pain for <strong>".ucfirst($question_104[$singlelevel['answer']])."</strong>.<br/>";
              }

              break;
          case 106:

                $question_106 = array(

                  'Left' => 'left',
                  'Right' => 'right',
                  'Both' => 'bilateral'
                 );

                $question_107 = array(

                  'Right more than left' => 'R>L',
                  'Left more than right' => 'L>R',
                  'About the same' => 'L=R'
                 );

               if($singlelevel['answer'] == 'Both'){

                  if($value[$k+1]['question_id'] == 107 && !empty($value[$k+1]['answer'])){

                    $layman_summar .= "You have pain in the <strong>".$question_106[$singlelevel['answer']]." foot (".$question_107[$value[$k+1]['answer']].")</strong>.<br />";

                  }else{

                    $layman_summar .= "You have pain in the <strong>".$question_106[$singlelevel['answer']]."</strong> foot.<br />";

                  }
                }else{

                    $layman_summar .= "You have pain in the <strong>".$question_106[$singlelevel['answer']]."</strong> foot.<br />";

                  }

              break;
          case 108:

              $question_108 = array(


                'Bottom of foot' => 'plantar of foot',
                'Back of foot' => 'back of foot',
                'Both top and bottom' => 'all over foot',
                'Front of foot' => 'anterior foot',
                'Heel of foot' => 'posterior foot',
                'Both front and back foot' => 'both front and back foot'

              );

              $ans = '';

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                  $ans .= $question_108[$qval].', ';
                }
              }else{

                $ans = $singlelevel['answer'];
              }

              $layman_summar .= "Your foot hurts on the <strong>".rtrim($ans,', ')."</strong>.<br/>";

              break;
          case 109:

              $question_109 = array(

                'Side of big toe' => 'medial sided',
                'Small toe side' => 'lateral sided',
                'Both sides of foot' => 'both sides of foot'
              );

               $ans = '';

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                  $ans .= $question_109[$qval].', ';
                }
              }else{

                $ans = $singlelevel['answer'];
              }

              $layman_summar .= "Your foot hurts on the <strong>".rtrim($ans,', ')."</strong>.<br/>";

              break;

          case 110:

              $ans = "";

              if($singlelevel['answer'] == 'Suddenly'){

                $ans_111 = $value[$k+1]['answer'];

                if(in_array('fall', $ans_111)){

                  $ans_112 = $value[$k+2]['answer'];
                  $ans_112 = is_array($ans_112) ? implode(", ", $ans_112) : $ans_112;
                  //pr($ans_112);die;

                  $layman_summar .= "The pain started <strong>".strtolower($singlelevel['answer'])."</strong> due to <strong>".(is_array($ans_111) ? implode(", ", $ans_111) : $ans_111)."</strong> and you fell due to <strong>".$ans_112."</strong>.<br/>";

                }else{

                    $ans_111 = is_array($ans_111) ? implode(", ", $ans_111) : $ans_111;

                  $layman_summar .= "The pain started <strong>".strtolower($singlelevel['answer'])."</strong> due to <strong>".($ans_111 == "I don't know" ? 'unknown reasons' : $ans_111)."</strong>.<br/>";
                }
              }else{

                $layman_summar .= "The pain started <strong>".strtolower($singlelevel['answer'])."</strong>.<br/>";
              }

              break;

          case 113:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The injury happened at work</strong>.<br/>":"<strong>The injury did not happen at work</strong>.<br/>";

            break;

          case 114:

              $layman_summar .= "You described the pain as <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ", $singlelevel['answer'])) : strtolower($singlelevel['answer']))."</strong>.<br/>";

            break;

          case 115:

             //$layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The current pain is worse than the original pain</strong>.<br/>" : "<strong>The current pain is not worse than the original pain</strong>.<br/>";
            $ques_ans_115 = strtolower($singlelevel['answer']);
            $translate_115 = array(

              'worse' => 'worsened',
              'better' => 'improved',
              'same' => 'remained stable'
            );
            $layman_summar .= "Current pain level has <strong>".$translate_115[$ques_ans_115].'</strong> since initial presentation.<br />';

            break;

        case 116:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The ".str_replace(" pain", "", $cur_cc_name)." feels warm to touch</strong>.<br/>" : "<strong>The ".str_replace(" pain", "", $cur_cc_name)." does not feel warm to touch</strong>.<br/>";

            break;

        case 117:

              if($singlelevel['answer'] == 'Yes'){

                $layman_summar .= "You have stiffness/pain in <strong>".(is_array($value[$k+1]['answer']) ? implode(", ",$value[$k+1]['answer']) : $value[$k+1]['answer'])."</strong> joints.<br/>";

              }else{

                $layman_summar .= "<strong>You do not have stiffness/pain in other joints</strong>.<br/>";

              }

            break;

         case 119:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have abnormal hair/nail growth or sweating</strong>.<br/>" : "<strong>You do not have abnormal hair/nail growth or sweating</strong>.<br/>" ;

            break;

         case 120:

               $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>Your feet are swollen</strong>.<br/>" : "<strong>Your feet are not swollen</strong>.<br/>" ;
            break;

        case 121:

            if($singlelevel['answer'] == 'comes and goes'){

              $layman_summar .= "Your foot pain is described as <strong>intermittent</strong>.<br/>";

            }
            else{

               $layman_summar .= "Your foot pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>";

            }

            break;

          case 122:

              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "The foot pain is the worst in the <strong>".$singlelevel['answer']."</strong> .<br /><strong>".($value[$k+1]['answer'] == 'Yes' ? 'The pain lasts for more than one hour' : 'The pain does not last for more than one hour')."</strong>.<br/>";

              }else{

                $layman_summar .= "The foot pain is the worst <strong>".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer'])."</strong>.<br/>";
              }

              /*if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your foot pain the worst. <strong>".$value[$k+1]['answer']."</strong>, the pain last for more than one hour or less.<br/>";

              }else{

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your foot pain the worst.<br/>";
              }*/

            break;

          case 124:

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> causes your pain to get better.<br/>";

            break;

          case 125:

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> causes your pain to get worse.<br/>";

            break;

          case 126:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have muscle spasms</strong>.<br/>" : "<strong>You do not have muscle spasms</strong>.<br/>";

            break;

          case 127:

                $question_127 = array(

                  'Left' => 'left',
                  'Right' => 'right',
                  'Both' => 'bilateral'
                 );

                $question_128 = array(

                  'Right more than left' => 'R>L',
                  'Left more than right' => 'L>R',
                  'About the same' => 'L=R'
                 );

               if($singlelevel['answer'] == 'Both'){

                  if($value[$k+1]['question_id'] == 128 && !empty($value[$k+1]['answer'])){

                    $layman_summar .= "You have pain in the <strong>".$question_127[$singlelevel['answer']]." ankle (".$question_128[$value[$k+1]['answer']].")</strong>.<br />";

                  }else{

                    $layman_summar .= "You have pain in the <strong>".$question_127[$singlelevel['answer']]."</strong> ankle.<br />";

                  }
                }else{

                    $layman_summar .= "You have pain in the <strong>".$question_127[$singlelevel['answer']]."</strong> ankle.<br />";

                  }

              break;

            case 129:

            //pr($singlelevel);

              $question_129 = array(


                'front of ankle' => 'anterior ankle',
                'back of ankle' => 'posterior ankle',
                'both front and back of ankle' => 'both front and back of ankle'

              );

              $ans = null;

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                  $ans[]= $question_129[$qval];
                }
                 $ans = implode(", ", $ans);
              }else{

                $ans = $singlelevel['answer'];
              }


              //pr($ans);

              //$ans = rtrim(", ",$ans);

              $layman_summar .= "Your ankle hurts on the <strong>".$ans."</strong>.<br/>";

              break;

           case 130:

           //pr($singlelevel);

              $question_130 = array(

                "side of big toe" => 'medial sided',
                "small toe side" => 'lateral sided',
                "both sides of ankle" => 'both sides of ankle'
              );

               $ans = null;

              if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                foreach ($singlelevel['answer'] as $qk => $qval) {

                 // pr($qval);

                  $que = trim($qval);

                  $ans[] = $question_130[$que];
                }

                $ans = implode(", ",$ans);
              }else{

                $ans = $singlelevel['answer'];
              }

              //pr($ans);

              $layman_summar .= "Your ankle hurts on the <strong>".$ans."</strong>.<br/>";

              break;

          case 131:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The ankle is swollen</strong>.<br/>" : "<strong>The ankle is not swollen</strong>.<br/>" ;

            break;

          case 132:

            if($singlelevel['answer'] == 'comes and goes'){

              $layman_summar .= "Your ankle pain is described as <strong>intermittent</strong>.<br/>";

            }
            else{

               $layman_summar .= "Your ankle pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>";

            }

            break;

        case 133:

              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "The ankle pain is the worst in the <strong>".$singlelevel['answer']."</strong> .<br /><strong>".($value[$k+1]['answer'] == 'Yes' ? 'The pain lasts for more than one hour' : 'The pain does not last for more than one hour')."</strong>.<br/>";

              }else{

                $layman_summar .= "The ankle pain is the worst <strong>".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer'])."</strong>.<br/>";
              }

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

                    $layman_summar .= "You have pain in the <strong>".$question_135[$singlelevel['answer']]." hip (".$question_136[$value[$k+1]['answer']].")</strong><br />";

                  }else{

                    $layman_summar .= "You have pain in the <strong>".$question_135[$singlelevel['answer']]."</strong> hip.<br />";

                  }
                }else{

                    $layman_summar .= "You have pain in the <strong>".$question_135[$singlelevel['answer']]."</strong> hip.<br />";

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

              $layman_summar .= "Location of hip pain : <strong>".rtrim($ans,', ')."</strong>.<br/>";

              break;

           case 138:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have hip pain when you stand or put weight on the side of pain</strong>.<br/>" : "<strong>You do not have hip pain when you stand or put weight on the side of pain</strong>.<br/>";

            break;

          case 139:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have pain with direct pressure on pain site</strong>.<br/>" : "<strong>You do not have pain with direct pressure on pain site</strong>.<br/>";

            break;

         case 140:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>Your hip is swollen</strong>.<br/>" : "<strong>Your hip is not swollen</strong>.<br/>" ;
               //$layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>The hip is swollen</strong>.<br/>" : "<strong>The hip is not swollen</strong>.<br/>" ;

            break;

        case 141:

            if($singlelevel['answer'] == 'comes and goes'){

              $layman_summar .= "Your hip pain is described as <strong>intermittent</strong>.<br/>";

            }
            else{

               $layman_summar .= "Your hip pain is described as <strong>".$singlelevel['answer']."</strong>.<br/>";

            }

            break;


         case 142:

              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "The hip pain is the worst in the <strong>".$singlelevel['answer']."</strong> . <strong><br />".($value[$k+1]['answer'] == 'Yes' ? 'The pain lasts for more than one hour' : 'The pain does not last for more than one hour')."</strong>.<br/>";

              }else{

                $layman_summar .= "The hip pain is the worst <strong>".($singlelevel['answer'] == 'about the same all day' ? $singlelevel['answer'] : 'in the '.$singlelevel['answer'])."</strong>.<br/>";
              }


/*
              if($singlelevel['answer'] == 'morning'){

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your hip pain the worst. <strong>".$value[$k+1]['answer']."</strong>, the pain last for more than one hour or less.<br/>";

              }else{

                $layman_summar .= "In <strong>".$singlelevel['answer']."</strong> your hip pain the worst.<br/>";
              }*/

            break;

        case 144:

          if(!empty($value[$k+1]) && isset($value[$k+1]['question_id']) && $value[$k+1]['question_id'] == 145){

             //Out of 10, the pain is a [X] at its best, and a [Y] at its worst.
             $layman_summar .= "Out of 10, the pain is a <strong>".$singlelevel['answer']."</strong> at its best, and a <strong>".$value[$k+1]['answer']."</strong> at its worst.<br/>";
          }

          break;

        case 146 :

              $question_146 = array(

                'worse' => 'aggravate',
                'better' => 'alleviate',
                'about the same' => 'same'

              );
              $layman_summar .= "Overall, you feels <strong>".$question_146[$singlelevel['answer']]."</strong> since your last visit.<br/>";
              break;
        case 147 :

              if(!empty($singlelevel['answer'])){
                  $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> makes aggravate.<br/>";
              }
              break;

        case 148 :

              if(!empty($singlelevel['answer'])){

                  $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> makes alleviate.<br/>";
                }
              break;
        case 149 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You have been vomiting.<br>";
              break;

        case 150 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])." times</strong> You vomited since your last visit. <br>";
              break;
        case 151 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You have seen bright red blood.<br>";
              break;
        case 152 :

              $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You have seen stuff that looks like coffee grounds.<br>";
              break;

        case 153 :

              $layman_summar .= "The headache is on the <strong>".(strtolower($singlelevel['answer']) == 'both sides' ? strtolower($singlelevel['answer']).'</strong>' : strtolower($singlelevel['answer']).'</strong> side')." of your head.<br>";
              break;

        case 154 :

             //$layman_summar .= "It occurs <strong>".$singlelevel['answer'].'.</strong><br />';
        	if($singlelevel['answer'] == 'Only after meals' || $singlelevel['answer'] == 'Same all day'){

        		$layman_summar .= "It occurs <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
        	}
        	else{

        		$layman_summar .= "It occurs during the <strong>".strtolower($singlelevel['answer']).'.</strong><br />';
        	}
             break;

        case 155 :

            $ques_ans_155 = strtolower(is_array($singlelevel['answer']) ? implode(", ",$singlelevel['answer']): $singlelevel['answer']);

              $layman_summar .= "Headache is typically located ".($ques_ans_155 == 'all over' ? '<strong>'.$ques_ans_155 : 'at the <strong>'.$ques_ans_155)."</strong>.<br>";
              break;

        case 156:

          $ques_ans_156 = 'You state that the '.$cur_cc_name.' is better with '.strtolower($singlelevel['answer']);
            if(!empty($ques_ans_157)){
              $layman_summar .= $ques_ans_156.''.$ques_ans_157.'.<br>';
              $ques_ans_156 = ''; $ques_ans_157 = '';
            }
            break;

        case 157:

          $ques_ans_157 = ' and worse with '.strtolower($singlelevel['answer']);


            if(!empty($ques_ans_156)){
              $layman_summar .= $ques_ans_156.''.$ques_ans_157.'.<br>';
              $ques_ans_156 = ''; $ques_ans_157 = '';
            }

            break;

        case 158:

          $layman_summar .= "The chest pain began <strong>".(is_array($singlelevel['answer']) ? strtolower(implode(", ",$singlelevel['answer'])): strtolower($singlelevel['answer']))."</strong>.<br>";

            break;

        case 159:

          $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You noticed locking, catching, or feeling like the joint gives out.': "You did not notice locking, catching, or feeling like the joint gives out.<br>";

            break;

        case 172:
           $layman_summar .=  "The symptom start <strong>".$singlelevel['answer']."</strong>.<br/>" ;

           break;

        case 182:

           if(strtolower($singlelevel['answer']) == 'yes'){

                    if(isset($value[$k+1]) && $value[$k+1]['question_id'] == 183 && !empty($value[$k+1]['answer'])){
                      $layman_summar .= "You have been sexually active in the last 2 months.<br />";
                      $layman_summar .= "You had <strong>" .$value[$k+1]['answer']. " </strong> sexual partners in the last 2 months</strong>.<br />" ;
                    }
                    else{

                      $layman_summar .= '<strong>You had sexual partners in the last 2 months</strong>.<br />';
                    }
                  }
                  else{

                    $layman_summar .= "You haven't been sexually active in the last 2 months.<br />";
                  }
           break;

       

        case 184:
           // $layman_summar .=  $singlelevel['answer'] == 'yes' ? 'You and your partner(s) use condemns during intercourse.': "You and your partner(s) do not use condemns during intercourse.<br>";

            if(strtolower($singlelevel['answer']) == 'yes'){

                    if(isset($value[$k+1]) && $value[$k+1]['question_id'] == 185 && !empty($value[$k+1]['answer'])){

                      $layman_summar .= "You and your partner(s) used condemns during intercourse.<br />";
                      $layman_summar .= "You and your partner(s) used condemns <strong>" .$value[$k+1]['answer']. " </strong>.<br />" ;
                    }
                    else{

                      $layman_summar .= '<strong>You and your partner(s) do not use condemns during intercourse</strong>.<br />';
                    }
                  }
                  else{

                    $layman_summar .= "You and your partner(s) do not use condemns during intercourse.<br />";
                  }
           break;

        // case 185:
        //    $layman_summar .=  "You and your partner(s) use condemns <strong>".$singlelevel['answer']."</strong>.<br/>" ;
        //    break; 

        case 43:

        // pr($singlelevel['answer']); die;
        $temp_str_43 = '' ;
        if(!empty($singlelevel['answer'])){
          $singlelevel['answer'] = explode(',', $singlelevel['answer']) ;

          foreach ($singlelevel['answer'] as $k43 => $v43) {
            $temp_str_43 .= isset($img_backpain_detial_q_arr[$v43]) ? $img_backpain_detial_q_arr[$v43].', ' : "" ;
          }

          $temp_str_43 = rtrim($temp_str_43, ', ');
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
// pr($ttemp); die;
     $ttemp = rtrim($ttemp, ', ');
     // $temp_summar .= $ttemp.'), ';
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
      // $temp_summar .= ' (Thoracic(';
      $ttemp = array();
      if(stripos($temp_str_43, 't1') !== false ) $ttemp[] = 'T1';if(stripos($temp_str_43, 't2') !== false ) $ttemp[] = 'T2';if(stripos($temp_str_43, 't3') !== false ) $ttemp[] = 'T3';if(stripos($temp_str_43, 't4') !== false ) $ttemp[] = 'T4';if(stripos($temp_str_43, 't5') !== false ) $ttemp[] = 'T5';if(stripos($temp_str_43, 't6') !== false ) $ttemp[] = 'T6';if(stripos($temp_str_43, 't7') !== false ) $ttemp[] = 'T7';if(stripos($temp_str_43, 't8') !== false ) $ttemp[] = 'T8';if(stripos($temp_str_43, 't9') !== false ) $ttemp[] = 'T9';if(stripos($temp_str_43, 't10') !== false ) $ttemp[] = 'T10';if(stripos($temp_str_43, 't11') !== false ) $ttemp[] = 'T11';if(stripos($temp_str_43, 't12') !== false ) $ttemp[] = 'T12';

$tttemp = array();
foreach ($ttemp as $kt1 => $vt1) {
  $tttemp[] = (int) filter_var($vt1, FILTER_SANITIZE_NUMBER_INT);
}
sort($tttemp);
$ftemp = 'T';
// pr($tttemp); die;
// $tttemp= array('1','3','5','7','8','9','11','12');

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
    }elseif((empty($start_vt2) && !empty($prev_vt2)) && (strpos($ftemp, '-') !== false)){ // if range after first element
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
// echo 'hi';
// pr($ftemp); die;
$ttemp = strtoupper($ftemp) ; // $ftemp;
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
// $ttemp = array('L4','L2','L5');
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

// pr($ttemp); die;

     if(!empty($ttemp)){
      $ttemp = rtrim($ttemp, ', ');
       // $temp_summar .= $ttemp.'), ';
      $temp_summar .= $ttemp.', ';
       $ttemp = ''; }

  }

  if(stripos($temp_str_43, 'Sacral') !== false ){
     // $temp_summar .= '(Sacral (' ;
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
// pr($ttemp); die;
     if(!empty($ttemp)){
      $ttemp = rtrim($ttemp, ', ');
      // $temp_summar .= $ttemp.')), ';
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

  // if(stripos($temp_str_43, 'Shoulder pain (Interscapular (left))') !== false ){ $temp_summar .= 'Interscapular (left), ' ; }  // we commented this because we think  Interscapular (left)  is in Upper back pain



  $temp_summar = rtrim($temp_summar, ', ');

  $temp_summar .= '), ';

}
 // pr($temp_str_43); die;
// echo 'hello';
// pr($temp_summar); die;
// ************************* Human body option remove redundancy END *********************

  $temp_summar = rtrim($temp_summar, ', ');
$temp_str_43 = $temp_summar; //  strtolower($temp_summar);
 // pr($temp_str_43); die;
// echo 'hello';
// pr($temp_summar); die;
// ************************* Human body option remove redundancy END *********************


        /* code commented as not used now
          if(is_array($singlelevel['answer'])){
            // pr($singlelevel['answer']); die;

            foreach ($singlelevel['answer'] as $k43 => $v43) {
              $singlelevel['answer'][$k43] = isset($img_backpain_loc[$v43]) ? $img_backpain_loc[$v43] : '' ;
            }

          }
          */
          // pr($singlelevel['answer']); die;
           $layman_summar .=  "You feel pain in the: <strong>".$temp_str_43."</strong><br/>" ;
           break;




    }

// switch case end


      }
      // pr($k);
      // pr($singlelevel); die;
    }



  }
  //pr($user_detail); die;


}

return array('layman_summar' => $layman_summar, 'all_cc_name' => $all_cc_name) ;

// end




}


public function get_schedule($schedule_id){

  //echo $schedule_id;die;
  //die('cvcxv');
  $schedule = TableRegistry::get('Schedule');
  $schedule_data = $schedule->find('all')->where(['Schedule.id'=> $schedule_id])->contain(['Organizations'])->first();
  //pr($schedule_data);die;
  return $schedule_data;
}

public function get_organization_data($org_id){

  //echo $schedule_id;die;
  //die('cvcxv');
  $orgTbl = TableRegistry::get('Organizations');
  $org_data= $orgTbl->find('all')->where(['id'=> $org_id])->first();
  //pr($schedule_data);die;
  return $org_data;
}

public function get_schedule_by_user_id($user_id){

  $user = TableRegistry::get('Users');
  $schedule = TableRegistry::get('Schedule');
  $user_data = $user->find('all')->where(['id'=> $user_id])->first();
  if(!empty($user_data)){

    $schedule_data = $schedule->find('all')->where(['id'=> $user_data['schedule_id']])->first();
    return $schedule_data;

  }

  return 0;

}


public function is_access_pre_appointment_link($schedule_id){


  $schedule = TableRegistry::get('Schedule');
  $schedule_data = $schedule->find('all')->where(['id'=> $schedule_id,'Date(created)' => date('Y-m-d')])->first();
    //pr($schedule_data);die;

  if(!empty($schedule_data) && ($schedule_data['status'] == 1 || $schedule_data['status'] == 2)){

    return true;
  }

  return false;
}



/*public function is_access_pre_appointment_link($user_id){

  $user = TableRegistry::get('Users');
  $schedule = TableRegistry::get('Schedule');
  $user_data = $user->find('all')->where(['id'=> $user_id])->first();
  if(!empty($user_data)){

    $schedule_data = $schedule->find('all')->where(['id'=> $user_data['schedule_id'],'organization_id' => $user_data['organization_id'],'Date(created)' => date('Y-m-d')])->first();

    //pr($schedule_data);die;

        if(!empty($schedule_data) && ($schedule_data['status'] == 1 || $schedule_data['status'] == 2)){

          return true;
        }

  }

  //die('test');

  return false;
}
*/


// prepare question in layman summary

public function prepare_other_question_layman($user_detail = null ){

//pr($user_detail);die;
  if(!empty($user_detail->other_questions_treatment_detail))
  {
    $user_detail->other_questions_treatment_detail =@unserialize(Security::decrypt(base64_decode($user_detail->other_questions_treatment_detail) , SEC_KEY));
  }

  if(!empty($user_detail->taken_before_medicine_info))
  {
    $user_detail->taken_before_medicine_info =@unserialize(Security::decrypt(base64_decode($user_detail->taken_before_medicine_info) , SEC_KEY));
  }
  $layman_summar = '' ;




  if(!empty($user_detail->chief_compliant_other_details) && is_array($user_detail->chief_compliant_other_details)){

      $layman_summar .= '<br />You provided these other details:<br />' ;



      //set layman for medicine that taken before

      if(!empty($user_detail->taken_before_medicine_info) && is_array($user_detail->taken_before_medicine_info)){

        $layman_summar .= '<b>Medicine details taken before:</b><br />';

        $stop_reason = array(

          1 => "didn't work",
          2 => 'finished taking',
          3 => 'told to stop by doctor'
        );

        foreach ($user_detail->taken_before_medicine_info as $m_key => $m_value) {

          $layman_summar .= 'Medicine: <strong>'.$m_value['medicine_name'].'</strong>, Dose: <strong>'.$m_value['medicine_dose'].'</strong>, stopped due to : <strong>'.$stop_reason[$m_value['medicine_stop_reason']].'</strong><br/>';
        }
      }


      foreach ($user_detail->chief_compliant_other_details as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 1 2 3 are related to each other
            case 1:

              if($singlelevel['answer'] == 'Yes'){

                $ans2 = $user_detail->chief_compliant_other_details[$k+1]['answer'];
                if(is_array($ans2) && in_array('other',$ans2)){

                  $ans2 = $user_detail->chief_compliant_other_details[$k+2]['answer'];
                }

                $layman_summar .= "You have a hard time sleeping due to <strong>".(is_array($ans2) ? implode(', ',$ans2) : $ans2).'</strong>.<br />' ;

              }else{

                $layman_summar .= "<strong>You do not have a hard time sleeping</strong>.<br />" ;
              }

                break;

            case 4:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You wake up and feel tired</strong>.<br />' : '<strong>You wake up and do not feel tired</strong>.<br />';
                break;

            case 5:

                $layman_summar .= 'You do <strong>'.strtolower($singlelevel['answer']).'</strong> for fun.<br />';
                break;

            case 6:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You always feel tired</strong>.<br />" : "<strong>You do not always feel tired</strong>.<br />";
                break;

            case 7:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ?  "<strong>You feel depressed or have thoughts about hurting yourself</strong>.<br />" : "<strong>You never feel depressed or have thoughts about hurting yourself</strong>.<br />";
                break;

            case 8:

                $layman_summar .= "The pain interferes you <strong>".strtolower($singlelevel['answer'])."%</strong> from interacting with others.<br />";
                break;

            case 9:

                $layman_summar .= "The pain interferes you <strong>".strtolower($singlelevel['answer'])."%</strong> with your daily activities.<br />" ;
                break;

            case 11:

                $ans_11 = $singlelevel['answer'];
                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You have a family history of pain syndromes/arthritis</strong>.<br />" : "<strong>You do not have a family history of any pain syndrome or arthritis</strong>.<br />";
                break;
            case 12:

              if(isset($ans_11) && $ans_11 == 'Yes'){
                if(!empty($user_detail->other_questions_treatment_detail)){

                  $layman_summar .= "<strong>In the past you had taken:</strong><br />";

                  foreach ($user_detail->other_questions_treatment_detail as $key => $value) {

                    $layman_summar .= "<strong>".ucfirst($value['treatment_type'])."</strong> at <strong>".$value['treatment_date']."</strong>.<br/>";

                  }

                }else{

                  $layman_summar .= "<strong>You had not taken any injections, physical therapy, or chiropractic care in the past</strong>.<br />";
                }
              break;
            }
          }
        }

        $layman_summar .= '<br />';
  }
  //die;
  return array('layman_summar' => $layman_summar);
}

// prepare question in layman summary

public function prepare_screening_question_layman($user_detail = null ){

//pr($user_detail);die;
  $layman_summar = '';

  if(!empty($user_detail->screening_questions_detail) && is_array($user_detail->screening_questions_detail)){

      $layman_summar .= '<br />You provided these GI health checkup screening details:<br />' ;

      foreach ($user_detail->screening_questions_detail as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 1 2 3 are related to each other
            case 1:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer']).'</strong>, you have a family history of colon cancer in your immediate family.<br />' ;
              //  pr($user_detail->screening_questions_detail[$k+1]['question_id']);
                if($singlelevel['answer'] == 'Yes' && (isset($user_detail->screening_questions_detail[$k+1]['question_id']) && $user_detail->screening_questions_detail[$k+1]['question_id'] == 2)){
                 // die('cc');

                  $question_2 = array(

                    1 => '<50 years',
                    2 => '50-60 years',
                    3 => '>60 years'
                  );

                  $temp_ans2 = "";

                  foreach($user_detail->screening_questions_detail[$k+1]['answer'] as $que2_key => $que2_val){

                    $temp_ans2 .= $question_2[$que2_val].", ";

                  }
                  rtrim($temp_ans2,", ");
                  $layman_summar .= "<strong>".ucfirst($temp_ans2).'</strong> age were your relative diagnosed with colon cancer.<br />' ;

                }
                break;
            case 3:

                 $layman_summar .= "The last time you were screened for blood in your stools <strong>".$singlelevel['answer'].'</strong>.<br />';
                break;
            case 4:

                $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You have a history of anemia or require iron.<br />';
                break;

            case 5:

                $layman_summar .= 'Your last colonoscopy : <strong>'.ucfirst($singlelevel['answer']).'</strong>.<br />';
                break;

            case 6:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer']).'</strong>, You had a previous colonoscopy.<br />';
                break;

            case 7:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You have a history of polyps.<br />";
                break;
          }
        }

        $layman_summar .= '<br />';
  }
  //die;
  return array('layman_summar' => $layman_summar);
}


public function prepare_post_checkup_question_layman($user_detail = null ){

//pr($user_detail);die;
  $layman_summar = '';

  if(!empty($user_detail->post_checkup_question_detail) && is_array($user_detail->post_checkup_question_detail)){

      $layman_summar .= '<br />You provided these Post-procedure Checkup details:<br />' ;

      foreach ($user_detail->post_checkup_question_detail as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 1 2 3 are related to each other
            case 13:

                if($singlelevel['answer'] == 'endoscopy (EGD)'){

                  $ans_13 = "EGD";

                }elseif($singlelevel['answer'] == 'other'){

                  $ans_13 = "";
                  if(isset($user_detail->post_checkup_question_detail[$k+1]['question_id']) && $user_detail->post_checkup_question_detail[$k+1]['question_id'] == 14){

                    $ans_13 = $user_detail->post_checkup_question_detail[$k+1]['answer'];
                  }
                }else{

                  $ans_13 = $singlelevel['answer'];
                }

                $layman_summar .= "You have done <strong>".$ans_13.'</strong> procedure.<br />' ;
                break;
            case 15:

                 $layman_summar .= "Your procedure was at <strong>".$singlelevel['answer'].'</strong>.<br />';
                break;
            case 16:

                if($singlelevel['answer'] == 'Yes'){

                   $layman_summar .= 'You take <strong>Anticoagulant therapy</strong> blood thinners.<br />';
                }else{

                   $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You does not take any blood thinners.<br />';
                }


                break;

            case 17:

                if($singlelevel['answer'] == 'Yes' && isset($user_detail->post_checkup_question_detail[$k+1]['question_id']) && $user_detail->post_checkup_question_detail[$k+1]['question_id'] == 18 && !empty($user_detail->post_checkup_question_detail[$k+1]['answer'])){

                    $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You restart your blood thinners since your procedure at <strong>'.$user_detail->post_checkup_question_detail[$k+1]['answer'].'</strong>.<br />';
                }else{

                  $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You restart your blood thinners since your procedure.<br />';
                }
                break;

            case 19:

                $question_19 = array(

                  'regular diet' => 'regular diet',
                  'soft foods only' => 'soft diet',
                  'clear liquids only' => 'liquid diet'
                );

                $layman_summar .= "<strong>".ucfirst($question_19[$singlelevel['answer']]).'</strong> foods are you currently eating since your procedure.<br />';
                break;

            case 20:

                $question_20 = array(

                  'well' => 'tolerating',
                  'not well' => 'not tolerating'
                );

                $layman_summar .= "You <strong>".$question_20[$singlelevel['answer']]."</strong>, the food above.<br />";
                break;

            case 21:

                 $layman_summar .= "You all apply : <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']).'</strong>.<br />';
                break;
            case 22:

                   $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).' times</strong> you have vomited.<br />';

                break;

            case 23:

              if($singlelevel['answer'] == 'Yes'){

                  $layman_summar .= '<strong>Hematemesis</strong>, There was blood or coffee ground-looking stuff in the vomit.<br />';
              }else{

                $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>,  There was blood or coffee ground-looking stuff in the vomit.<br />';
              }

                break;

            case 24:

                $question_24 = array(

                  '1' => 'very well',
                  '2' => 'well',
                  '3' => 'unwell'
                );

                $layman_summar .= "You feels <strong>".ucfirst($question_24[$singlelevel['answer']]).'</strong> right now.<br />';
                break;
          }
        }

        $layman_summar .= '<br />';
  }
  //die;
  return array('layman_summar' => $layman_summar);
}

//pain update tab of pain medicine mudule under follow up category
public function prepare_pain_update_question_layman($user_detail = null, $cur_cc_names = null){

  //pr($user_detail);die;

  $layman_summar = '' ;

  if(!empty($user_detail->pain_update_question) && is_array($user_detail->pain_update_question)){

      $layman_summar .= '<br />You provided these pain update details:<br />' ;

      foreach ($user_detail->pain_update_question as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 1 2 are related to each other
            case 1:

              if($singlelevel['answer'] == 'Yes'){


                $layman_summar .= "Last time you reported ".$cur_cc_names.". You have <strong>".$user_detail->pain_update_question[$k+1]['answer'].'</strong> new pain.<br />' ;

              }else{

                $layman_summar .= "Last time you reported ".$cur_cc_names.". <strong>".$singlelevel['answer'].'</strong>, You have any new pain.<br />' ;
              }

                break;

            case 3:

                 $layman_summar .= "Now, the pain <strong>".$singlelevel['answer']."</strong> compared to when it first started.<br />";
                break;

            case 4:

                $layman_summar .= 'You rate your current pain level <strong>'.$singlelevel['answer'].'</strong> out of 10 .<br />';
                break;

            case 5:

                $layman_summar .= 'In the last 30 days, You rate your worst pain <strong>'.$singlelevel['answer'].'</strong> out of 10.<br />';
                break;

            case 6:

                $layman_summar .= "You rate your pain AFTER taking medication <strong>".$singlelevel['answer'].'</strong> out of 10.<br />';
                break;

            case 7:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."%</strong> pain affect your daily activities.<br />";
                break;

            case 8:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."%</strong> pain affect social interactions with others.<br />";
                break;

            case 9:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You needed more pain medication than prescribed.<br />" ;
                break;

            case 10:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> makes your pain better.<br />";
                break;
            case 11:

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong> makes your pain worse.<br />";

              break;

            case 12:

                $layman_summar .= "You check all those which apply: <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br />";

              break;
          }
        }

        $layman_summar .= '<br />';
  }

  //echo $layman_summar;die;
  //die;
  return array('layman_summar' => $layman_summar);
}



//general update tab of pain medicine mudule under follow up category
public function prepare_general_update_question_layman($user_detail = null ){

  //pr($user_detail);die;

  $layman_summar = '' ;

  if(!empty($user_detail->general_update_question) && is_array($user_detail->general_update_question)){

      $layman_summar .= '<br />You provided these general update details:<br />';

      foreach ($user_detail->general_update_question as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 1 2 3 are related to each other
            case 13:

              if($singlelevel['answer'] == 'Yes'){


               $layman_summar .= "You been diagnosed with <strong>".$user_detail->general_update_question[$k+1]['answer'].'</strong> new medical conditions since your last visit.<br />' ;

              }else{

                $layman_summar .= "<strong>".ucfirst($singlelevel['answer']).'</strong>, You been diagnosed with any new medical conditions since your last visit.<br />' ;
              }

              break;


            case 15:

                 if($singlelevel['answer'] == 'Yes'){

                  if(!empty($user_detail->general_update_provider_info)){

                    $layman_summar .= 'Since your last visit, You seen <strong>'.(isset($user_detail->general_update_provider_info['provider_name']) ? $user_detail->general_update_provider_info['provider_name'] : "").'</strong> healthcare provider for <strong>'.(isset($user_detail->general_update_provider_info['speciality']) ? $user_detail->general_update_provider_info['speciality'] : "").'</strong> in <strong>'.(isset($user_detail->general_update_provider_info['address']) ? $user_detail->general_update_provider_info['address'] : "").'</strong>, provider phone number is <strong>'.(isset($user_detail->general_update_provider_info['phone']) ? $user_detail->general_update_provider_info['phone'] : "").'</strong>.<br />';

                  }else{

                    $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You seen any other healthcare providers since your last visit.<br />';
                  }

                 }else{

                  $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You seen any other healthcare providers since your last visit.<br />';
                 }

                break;

            case 16:

                if($singlelevel['answer'] == 'Yes'){

                  if(isset($user_detail->general_update_question[$k+1])){

                    $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You had any recent falls and fall due to : <strong>'.(isset($user_detail->general_update_question[$k+1]['answer']) ? implode(", ", $user_detail->general_update_question[$k+1]['answer']) : $user_detail->general_update_question[$k+1]['answer']).'</strong><br />';

                  }else{

                     $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You had any recent falls.<br />';

                  }

                }else{

                  $layman_summar .= '<strong>'.ucfirst($singlelevel['answer']).'</strong>, You had any recent falls.<br />';

                }


                break;

            case 18:

                if(!empty($user_detail->general_update_procedure_detail)){

                  $layman_summar .="You had taken recent surgeries or procedures: <br />";

                  foreach ($user_detail->general_update_procedure_detail as $key => $value) {

                    $layman_summar .= "<strong>".ucfirst($value['procedure_type'])."</strong> at <strong>".$value['procedure_date']."</strong>.<br/>";
                  }

                }else{

                  $layman_summar .= "<strong>".ucfirst($singlelevel['answer'])."</strong>, You had taken any recent surgeries or procedures.<br />";
                }
              break;
          }
        }

        $layman_summar .= '<br />';
  }

  // echo $layman_summar;die;
  // die;
  return array('layman_summar' => $layman_summar);
}


public function prepare_pre_op_procedure_detail_question_layman($user_detail = null ){

//pr($user_detail);die;
  $layman_summar = '';

  if(!empty($user_detail->pre_op_procedure_detail) && is_array($user_detail->pre_op_procedure_detail)){

      $layman_summar .= '<br />You provided these procedure details:<br />' ;

      foreach ($user_detail->pre_op_procedure_detail as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 1 2 3 are related to each other
            case 13:

                if($singlelevel['answer'] == 'endoscopy (EGD)'){

                  $ans_13 = "EGD";

                }elseif($singlelevel['answer'] == 'other'){

                  $ans_13 = "";
                  if(isset($user_detail->pre_op_procedure_detail[$k+1]['question_id']) && $user_detail->pre_op_procedure_detail[$k+1]['question_id'] == 14){

                    $ans_13 = $user_detail->pre_op_procedure_detail[$k+1]['answer'];
                  }
                }else{

                  $ans_13 = $singlelevel['answer'];
                }

                $layman_summar .= "You have done <strong>".$ans_13.'</strong> procedure.<br />' ;
                break;
            case 25:

                  if($singlelevel['answer'] == 'No'){

                      $layman_summar .= "<strong>".ucfirst($singlelevel['answer']).'</strong>, You have not scheduled date for the procedure.<br />';
                  }else{


                    if(isset($user_detail->pre_op_procedure_detail[$k+1]['question_id']) && $user_detail->pre_op_procedure_detail[$k+1]['question_id'] == 26){

                      $layman_summar .= "You have scheduled procedure on <strong>".$user_detail->pre_op_procedure_detail[$k+1]['answer'].'</strong>.<br />';
                    }else{

                      $layman_summar .= "<strong>".ucfirst($singlelevel['answer']).'</strong>, You have scheduled date for the procedure.<br />';
                    }
                  }

                break;
            /*case 26:

                   $layman_summar .= 'Your procedure scheduled <strong>'.$singlelevel['answer'].'</strong>.<br />';

                break;*/
          }
        }

        $layman_summar .= '<br />';
  }
  //die;
  return array('layman_summar' => $layman_summar);
}


public function prepare_pre_op_medical_conditions_layman($user_detail = null ){

//pr($user_detail);die;
  $layman_summar = '';
  $not_affected = "";
  //die('fgsgg');

  if(!empty($user_detail->pre_op_medical_condition_detail) && is_array($user_detail->pre_op_medical_condition_detail)){

      //$layman_summar .= '<br /><strong>You had been diagnosed with following health conditions:</strong><br />' ;

      foreach ($user_detail->pre_op_medical_condition_detail as $k => $condition) {

       // pr($condition);die;

          if(isset($condition['answer']) && $condition['answer'] == 1){

            $layman_summar  .= '<strong>'.$condition['condition_name'].(!empty($condition['medical_name']) ? "(".$condition['medical_name'].")" : "").'</strong>'.' in '.'<strong>'.$condition['year']."</strong>.<br>";

          }else{

            $not_affected .= '<strong>'.$condition['condition_name'].(!empty($condition['medical_name']) ? "(".$condition['medical_name'].")" : "").'</strong>, ';
          }
        }

        if(!empty($layman_summar)){

          $layman_summar .= '<br /><strong>You had been diagnosed with following health conditions:</strong><br />'.$layman_summar ;
          $layman_summar .= '<br />';
        }
  }

  $not_affected = rtrim($not_affected,", ");
  //echo $not_affected;die;
  //echo $layman_summar;die;
  //die;
  return array('layman_summar' => $layman_summar,'not_affected' => $not_affected);
}

public function prepare_pre_op_allergies_conditions_layman($user_detail = null ){

//pr($user_detail);die;
  $layman_summar = '';
  $not_affected = "";

  if(!empty($user_detail->pre_op_allergies_detail) && is_array($user_detail->pre_op_allergies_detail)){

     // $layman_summar .= '<br /><strong>You are allergic to the following:</strong><br />' ;

      foreach ($user_detail->pre_op_allergies_detail as $k => $condition) {

       // pr($condition);die;

          if(isset($condition['answer']) && $condition['answer'] == 1){

            $layman_summar  .= '<strong>'.$condition['condition_name'].(!empty($condition['medical_name']) ? "(".$condition['medical_name'].")" : "").'</strong>'.' reaction '.'<strong>'.$condition['reaction']."</strong>.<br>";

          }else{

            $not_affected .= '<strong>'.$condition['condition_name'].(!empty($condition['medical_name']) ? "(".$condition['medical_name'].")" : "").'</strong>, ';
          }
        }

        if(!empty($layman_summar)){

           $layman_summar .= '<br /><strong>You are allergic to the following:</strong><br />'.$layman_summar;
           $layman_summar .= '<br />';
        }

  }

  $not_affected = rtrim($not_affected,", ");

  //echo $layman_summar;die;
  //die;
  return array('layman_summar' => $layman_summar,'not_affected' => $not_affected);
}

public function prepare_pre_op_medication_detail_question_layman
($user_detail = null ){

//pr($user_detail);die;
  $layman_summar = '';

  if(!empty($user_detail->pre_op_medications_question_detail) && is_array($user_detail->pre_op_medications_question_detail)){

      if($user_detail->current_step_id->id == 15){

        $layman_summar .= '<br />You provided these hospital/ER follow up details: <br />' ;

      }else{

        $layman_summar .= '<br />You provided these pre operation medications details: <br />' ;
      }


      foreach ($user_detail->pre_op_medications_question_detail as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 27,28,29 are related to each other
            case 27:

                if($singlelevel['answer'] == 'Yes'){


                    if(isset($user_detail->pre_op_medications_question_detail[$k+1]['question_id']) && $user_detail->pre_op_medications_question_detail[$k+1]['question_id'] == 28){


                        $ans_28 = (is_array($user_detail->pre_op_medications_question_detail[$k+1]['answer']) ? implode(", ", $user_detail->pre_op_medications_question_detail[$k+1]['answer']) : $user_detail->pre_op_medications_question_detail[$k+1]['answer']);

                        if(isset($user_detail->pre_op_medications_question_detail[$k+2]['question_id']) && $user_detail->pre_op_medications_question_detail[$k+2]['question_id'] == 29){


                            $ans_28 = str_replace("Other", $user_detail->pre_op_medications_question_detail[$k+2]['answer'], $ans_28);
                        }


                        $layman_summar .= "Currently You take <strong>".$ans_28."</strong> blood thinner medications like warfarin, heparin, Coumadin, Xarelto, or Lovenox.<br>" ;

                    }else{

                         $layman_summar .= "<strong>Yes</strong>, Currently You take blood thinner medications like warfarin, heparin, Coumadin, Xarelto, or Lovenox.<br>" ;
                    }
                }else{

                    $layman_summar .= "<strong>No</strong>, Currently You does not take any blood thinner medications like warfarin, heparin, Coumadin, Xarelto, or Lovenox.<br>" ;
                }


                break;
            case 30:

                  if($singlelevel['answer'] == 'No'){

                      $layman_summar .= '<strong>No</strong>, You do not take aspirin or baby aspirin regularly.<br>';
                  }else{

                    $layman_summar .= '<strong>Yes</strong>, You take aspirin or baby aspirin regularly.<br>';

                  }

                break;

             case 31:

                  if($singlelevel['answer'] == 'No'){

                      $layman_summar .= '<strong>No</strong>, You have not taken any NSAID pain medications like ibuprofen, Advil, Motrin, Alleve in the past week.<br>';
                  }else{

                      $layman_summar .= '<strong>Yes</strong>, You have taken any NSAID pain medications like ibuprofen, Advil, Motrin, Alleve in the past week.<br>';

                  }

                break;

            case 32:

                if($singlelevel['answer'] == 'Yes'){


                    if(isset($user_detail->pre_op_medications_question_detail[$k+1]['question_id']) && $user_detail->pre_op_medications_question_detail[$k+1]['question_id'] == 33){


                        $ans_33 = (is_array($user_detail->pre_op_medications_question_detail[$k+1]['answer']) ? implode(", ", $user_detail->pre_op_medications_question_detail[$k+1]['answer']) : $user_detail->pre_op_medications_question_detail[$k+1]['answer']);

                        if(isset($user_detail->pre_op_medications_question_detail[$k+2]['question_id']) && $user_detail->pre_op_medications_question_detail[$k+2]['question_id'] == 34){


                            $ans_33 = str_replace("other", $user_detail->pre_op_medications_question_detail[$k+2]['answer'], $ans_33);
                        }


                        $layman_summar .= "Currently You taking <strong>".$ans_33."</strong> herbal supplements such as garlic, ginko, ginseng.<br>";

                    }else{

                         $layman_summar .= "<strong>Yes</strong>, Currently You taking herbal supplements such as garlic, ginko, ginseng.<br>" ;
                    }
                }else{

                    $layman_summar .= "<strong>No</strong>, Currently You does not taking any herbal supplements such as garlic, ginko, ginseng.<br>" ;
                }


                break;

            case 46:

              $layman_summar .= "You are following up with your doctor because of <strong>".$singlelevel['answer'].'</strong>.<br>';
              break;

            case 47:

              $layman_summar .= "You were stay in the hospital <strong>".$singlelevel['answer'].'</strong>';
              break;

            case 48 :

              $layman_summar .= " from <strong>".$singlelevel['answer']."</strong>";
              break;

            case 49:

              $layman_summar .= " to <strong>".$singlelevel['answer']."</strong>.<br>";
              break;

            case 50:

               $layman_summar .= "You were admitted to the hospital for <strong>".$singlelevel['answer']."</strong>.<br>";
               break;

            case 51:

              if($singlelevel['answer'] == 'No'){

                $layman_summar .= "No surgeries or procedures were done.<br>";

              }
              else{

               if(isset($user_detail->pre_op_medications_question_detail[$k+1]['question_id']) && $user_detail->pre_op_medications_question_detail[$k+1]['question_id'] == 52){


                    $layman_summar .= "You were done <strong>".$user_detail->pre_op_medications_question_detail[$k+1]['answer']."</strong> surgeries or procedures.<br>";

                }else{

                   $layman_summar .= "<strong>You were done surgeries or procedures</strong>.<br>";
                }
              }
              break;

           case 53:

               $layman_summar .= "You visit <strong>".$singlelevel['answer']."</strong> emergency room.<br>";
               break;

            case 54:

                $ans_54 = $singlelevel['answer'];
                break;

            case 55:

              $layman_summar .= "You went to the ER for <strong>".$singlelevel['answer']."</strong>";

              if(isset($ans_54) && !empty($ans_54)){

                $layman_summar .= " at <strong>".$ans_54."</strong>.<br>";
              }

              break;

          case 56:

              if($singlelevel['answer'] == 'No'){

                $layman_summar .= "<strong>You were not done any lab tests.</strong><br>";

              }
              else{

               if(isset($user_detail->pre_op_medications_question_detail[$k+1]['question_id']) && $user_detail->pre_op_medications_question_detail[$k+1]['question_id'] == 57){


                    $layman_summar .= "You were done <strong>".$user_detail->pre_op_medications_question_detail[$k+1]['answer']."</strong> lab tests.<br>";

                }else{

                   $layman_summar .= "<strong>You were done lab tests.</strong><br>";
                }
              }
              break;

           case 58:

              if($singlelevel['answer'] == 'No'){

                $layman_summar .= "<strong>You were not done any procedures or imaging studies.</strong><br>";

              }
              else{

               if(isset($user_detail->pre_op_medications_question_detail[$k+1]['question_id']) && $user_detail->pre_op_medications_question_detail[$k+1]['question_id'] == 59){


                    $layman_summar .= "You were done <strong>".$user_detail->pre_op_medications_question_detail[$k+1]['answer']."</strong> procedures or imaging studies.<br>";

                }else{

                   $layman_summar .= "<strong>You were done procedures or imaging studies.</strong><br>";
                }
              }

              break;
          }
        }

        $layman_summar .= ' ';
  }
  //die;
  return array('layman_summar' => $layman_summar);
}

//prepare layman for cronic illness module
public function prepare_chronic_illnesses_layman($user_detail = null ){

  $layman_summar = '';

  //pr($user_detail);die;

  if(!empty($user_detail->disease_questions_detail) && is_array($user_detail->disease_questions_detail)){

      foreach ($user_detail->disease_questions_detail as $disease_key => $disease_value) {

          $disease_layman_summar = '';
          $alarm_symptom_layman = "";
          $baseline_symptom_layman = "";
          //disease name layman
          if(isset($disease_value['disease']) && !empty($disease_value['disease'])){

              $disease_layman_summar .= '<br /><strong>You provided these '.$disease_value['disease']['name'].' details: </strong><br />' ;
          }
          else{

            continue;
          }

          //disease detail alarm symptom detail
           if(isset($disease_value['alarm_sysmptom']) && !empty($disease_value['alarm_sysmptom'])){

                foreach ($disease_value['alarm_sysmptom'] as $alrmsymptn_key => $alrmsymptn_val) {

                  if($alrmsymptn_val['answer'] == 1){

                    $alarm_symptom_layman .= (!empty($alrmsymptn_val['medical_name']) ? $alrmsymptn_val['medical_name'] : $alrmsymptn_val['name']).', ';

                  }

                }
                $alarm_symptom_layman = rtrim($alarm_symptom_layman,', ');
          }

          //disease detail baseline symptom detail
           if(isset($disease_value['baseline_sysmptom']) && !empty($disease_value['baseline_sysmptom'])){

                foreach ($disease_value['baseline_sysmptom'] as $baslinesysmptn_key => $baslinesysmptn_val) {

                  if($baslinesysmptn_val['answer'] == 1){

                    $baseline_symptom_layman .= (!empty($baslinesysmptn_val['medical_name']) ? $baslinesysmptn_val['medical_name'] : $baslinesysmptn_val['name']).' feels '.($baslinesysmptn_val['scale']== 'about the same' ? 'same' : $baslinesysmptn_val['scale']).', ';
                  }

                }
                $baseline_symptom_layman = rtrim($baseline_symptom_layman,', ');
          }

          //question detail layman

          if(isset($disease_value['multivitamin_detail'])){

            $detail_qestion_layman = $this->prepare_cronic_disease_question_layman($disease_value['disease_detail_question'],$disease_value['multivitamin_detail']);
          }
          else{

            $detail_qestion_layman = $this->prepare_cronic_disease_question_layman($disease_value['disease_detail_question']);
          }


          $layman_summar .= $disease_layman_summar;

          if(!empty($detail_qestion_layman['layman_summar'])){

              $layman_summar .= $detail_qestion_layman['layman_summar'];
          }

          if(!empty($baseline_symptom_layman)){

             $layman_summar .= 'You noticed the baseline symptoms of <strong>'.$baseline_symptom_layman.'</strong></br>';
          }

          if(!empty($alarm_symptom_layman)){

             $layman_summar .= 'You noticed the alarm symptoms of <strong>'.$alarm_symptom_layman.'</strong></br>' ;
          }
      }
    }

    $layman_summar .= ' ';
  return array('layman_summar' => $layman_summar);
  }



public function prepare_cronic_disease_question_layman($question_detail = null, $multivitamin_detail = null){

  $layman_summar = '';

  if(!empty($question_detail) && is_array($question_detail)){

      foreach ($question_detail as $k => $singlelevel) {

          switch ($singlelevel['question_id'])
          {
            //quetion 27,28,29 are related to each other
            case 35:

                if($singlelevel['answer'] == 'Yes'){


                    if(isset($question_detail[$k+1]['question_id']) && $question_detail[$k+1]['question_id'] == 36){

                         $layman_summar .= "You had your last colonoscopy on <strong>".$question_detail[$k+1]['answer']."</strong> in the last 10 years.<br>" ;

                    }else{

                         $layman_summar .= "<strong>Yes</strong>You had a colonoscopy in the last 10 years.<br>" ;
                    }
                }else{

                    $layman_summar .= "<strong>No</strong>, You had not a colonoscopy in the last 10 years.<br>" ;
                }


                break;
            case 37:

                  if($singlelevel['answer'] == 'Yes'){


                    if(isset($question_detail[$k+1]['question_id']) && $question_detail[$k+1]['question_id'] == 38){


                         $layman_summar .= "You have received genetic counseling on <strong>".$question_detail[$k+1]['answer']."</strong> in the past.<br>" ;

                    }else{

                         $layman_summar .= "<strong>Yes</strong>, You have received genetic counseling in the past.<br>" ;
                    }
                }else{

                    $layman_summar .= "<strong>No</strong>, You have not received genetic counseling in the past.<br>" ;
                }

                break;

             case 39:


                  if($singlelevel['answer'] == 'Yes'){


                      if(isset($question_detail[$k+1]['question_id']) && $question_detail[$k+1]['question_id'] == 40){


                           $layman_summar .= "You had genetic tests on <strong>".$question_detail[$k+1]['answer']."</strong> for colon cancer.<br>" ;

                      }else{

                           $layman_summar .= "<strong>Yes</strong>, You have done genetic tests for colon cancer.<br>" ;
                      }
                  }else{

                      $layman_summar .= "<strong>No</strong>, You have not done any genetic tests for colon cancer.<br>" ;
                  }

                break;

            case 41:

                if($singlelevel['answer'] == 'Yes'){


                  if(isset($question_detail[$k+1]['question_id']) && $question_detail[$k+1]['question_id'] == 42){


                           $layman_summar .= "You have ever had a flexible sigmoidoscopy done on <strong>".$question_detail[$k+1]['answer']."</strong>.<br>" ;

                      }else{

                           $layman_summar .= "<strong>Yes</strong>, You have ever had a flexible sigmoidoscopy done.<br>" ;
                      }
                  }else{

                      $layman_summar .= "<strong>No</strong>, You have not ever had a flexible sigmoidoscopy done.<br>";
                  }

                break;

            case 43:

                  if($singlelevel['answer'] == 'Yes'){

                    if(!empty($multivitamin_detail) && isset($multivitamin_detail['name']) && !empty($multivitamin_detail['name'])){

                            $vitamin_detail = $multivitamin_detail['name'];

                            if(isset($multivitamin_detail['dose'])){

                                $vitamin_detail .=  ' '.$multivitamin_detail['dose'];
                            }

                            if(isset($multivitamin_detail['how_often'])){

                                $vitamin_detail .=  ' '.$multivitamin_detail['how_often'];
                            }

                            if(isset($multivitamin_detail['how_taken'])){

                                $vitamin_detail .=  ' '.$multivitamin_detail['how_taken'];
                            }

                      $layman_summar .= "You are taking supplements <strong>".$vitamin_detail."</strong>.<br>";

                    }
                    else{

                      $layman_summar .= "<strong>Yes</strong>, You are taking supplements like a multivitamin, iron, or B12.<br>";
                    }

                  }
                  else{

                      $layman_summar .= "<strong>No</strong>, You are not taking any supplements like a multivitamin, iron, or B12.<br>";
                  }
                  break;

            case 44;


                if($singlelevel['answer'] == 'Yes'){

                  $layman_summar .= "<strong>Yes</strong>, You have noticed side effects when taking your medications.<br>";

                }else{

                  $layman_summar .= "<strong>No</strong>, You have not noticed any side effects when taking your medications.<br>";

                }
                break;

            case 45:

              $question_45 = array(

                'Much better' => 'significant improvement',
                'A little better' => 'mildly improved',
                'About the same' => 'stable',
                'A little worse' => 'mild worsening',
                'Much worse' => 'significantly worse'
              );

              $layman_summar .= "Overall you feels <strong>".$question_45[$singlelevel['answer']]."</strong> since your last visit.<br>";

                break;
          }
        }

        $layman_summar .= ' ';
  }
  //die;
  return array('layman_summar' => $layman_summar);
}

public function is_registered($schedule){

    $userTlb = TableRegistry::get('Users');
    $phone = '';
    if(!empty($schedule['phone'])){
      $phone = $this->CryptoSecurity->decrypt(base64_decode($schedule['phone']),SEC_KEY);
      $phone = trim(str_replace("-", "",$phone));
      $phone = base64_encode($this->CryptoSecurity->encrypt($phone,SEC_KEY));
    }
    $user_detail = null;

    //check patient is registered or not on allevia platform
    if((isset($schedule['email']) && !empty($schedule['email'])) || (isset($phone) && !empty($phone)) ){

      $filter = array();
      if(!empty($schedule['email'])){

         $filter['email'] = $schedule['email'];
      }

      if(!empty($phone)){

         $filter['phone'] = $phone;
      }
      $user_detail_all = $userTlb->find('all')->where(['OR'=> $filter])->toArray();
      if(!empty($user_detail_all))
      {
        foreach($user_detail_all as $all_user_key => $all_user_value){

            if(($schedule['email'] != '' && $all_user_value['email'] == $schedule['email'] && $phone != '' && $all_user_value['phone'] == $phone) || ($schedule['email'] == '' && $phone != '' && $all_user_value['phone'] == $phone) || ($schedule['email'] != '' && $all_user_value['email'] == $schedule['email'] && $phone == '')){

                $user_detail = $all_user_value;
                break;
            }
        }
        if(empty($user_detail))
        {
          $user_detail = $userTlb->find('all')->where(['OR'=> $filter])->first();
        }
      }
    }
    elseif(empty($schedule['email']) && empty($phone) && (!empty($schedule['first_name']) && !empty($schedule['last_name']) && !empty($schedule['dob'])))
    {

      $filter = ['AND'=>
                  ['first_name'=> $schedule['first_name'],
                  'last_name' => $schedule['last_name'],
                  "dob" => $schedule['dob'],
                  ["OR"=>[
                    'email'=>"",
                    'email IS NULL']
                  ],
                  ["OR"=>[
                    'phone'=>"",
                    'phone IS NULL']
                  ]
                ]];
      $user_detail = $userTlb->find('all')->where($filter)->first();
    }
    if(!empty($user_detail)){

      return $user_detail;
    }

    return 0;
 }

 /*public function prepare_medication_refill_extra_details_layman($question_detail = null){
  //pr($question_detail);die;
  $dast_score = 0;
  $comm_score = 0;
  $comm_nagative = 0;
  $soapp_score = 0;
  $soapp_nagative = 0;

  if(!empty($question_detail) && is_array($question_detail)){

    if(isset($question_detail['soapp']) && !empty($question_detail['soapp'])){

        foreach ($question_detail['soapp'] as $key => $singlelevel) {

            if(isset($singlelevel['answer'])){

              switch ($singlelevel['answer']) {
                case 'Seldom':

                  $soapp_score = $soapp_score + 1;
                  break;

                case 'Sometimes':

                  $soapp_score = $soapp_score + 2;
                  break;

                case 'Often':

                  $soapp_score = $soapp_score + 3;
                  break;

                case 'Very often':

                  $soapp_score = $soapp_score + 4;
                  break;

                case 'Never':

                  $soapp_nagative = $soapp_nagative + 1;
                  break;
              }
            }
        }
    }

    if(isset($question_detail['dast']) && !empty($question_detail['dast'])){

        foreach ($question_detail['dast'] as $key => $singlelevel) {

            if(isset($singlelevel['answer'])){

              switch ($singlelevel['answer']) {
                case 'Yes':

                  if($key != 79){
                    $dast_score = $dast_score + 1;
                  }
                  break;
              }
            }
        }
    }

    if(isset($question_detail['comm']) && !empty($question_detail['comm'])){

        foreach ($question_detail['comm'] as $key => $singlelevel) {

            if(isset($singlelevel['answer'])){

              switch ($singlelevel['answer']) {
                case 'Seldom':

                  $comm_score = $comm_score + 1;
                  break;

                case 'Sometimes':

                  $comm_score = $comm_score + 2;
                  break;

                case 'Often':

                  $comm_score = $comm_score + 3;
                  break;

                case 'Very often':

                  $comm_score = $comm_score + 4;
                  break;

                case 'Never':

                  $comm_nagative = $comm_nagative + 1;
                  break;
              }
            }
        }
    }
  }
  //die;
  return array('soapp_score' => $soapp_score,'soapp_nagative' => $soapp_nagative,'comm_score' => $comm_score,'comm_nagative' => $comm_nagative,'dast_score' => $dast_score);
}*/

public function prepare_medication_refill_extra_details_layman($question_detail = null,$soapp_comm_question_detail = null){

  $soapp_description = '';
  $comm_description = '';
  $dast_description = '';
  $padt_description = '';
  $ort_description = '';
  $m3_description = '';
  $ad8_dementia_screen = '';
  // pr($question_detail['ort']); die;
  $arr_124 = array(

              'Better' => 'has <strong>improved</strong>',
              'Worse' => 'has <strong>worsened</strong>',
              'Same' => 'is <strong>stable</strong>'
            );

  if(!empty($soapp_comm_question_detail) && is_array($soapp_comm_question_detail)){

      if(isset($soapp_comm_question_detail['soapp']) && !empty($soapp_comm_question_detail['soapp'])){

        foreach ($soapp_comm_question_detail['soapp'] as $key => $singlelevel) {
          $singlelevel['answer'] = strtolower($singlelevel['answer']);
           // pr($singlelevel);
            switch ($singlelevel['question_id']) {


                case 87:

                    $soapp_description .= 'You <strong>'.$singlelevel['answer'].'</strong> have mood swings.<br>';
                    break;
                case 88:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer'].'</strong> felt a need for higher dose of medication to treat your pain.<br>';
                    break;
                case 89:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer'].'</strong> felt impatient with your doctors.<br>';
                    break;
                case 90:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> felt that things are just too overwhelming that you can't handle them.<br>";
                    break;
                case 91:

                    $soapp_description .= "There is <strong>".$singlelevel['answer']."</strong> tension in the home.<br>";
                    break;
                case 92:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> counted pain pills to see how many are remaining.<br>";

                    break;
                case 93:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> been concerned that people will judge you for taking pain medication.<br>";
                    break;
                case 94:

                    $soapp_description .= 'You <strong>'.$singlelevel['answer']."</strong> feel bored.<br>";
                    break;
                case 95:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> taken more pain medication than you were supposed to.<br>";
                    break;
                case 96:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> worried about being left alone.<br>";
                    break;
                case 97:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> felt a craving for medication.<br>";

                    break;
                case 98:

                    $soapp_description .= "Others <strong>".$singlelevel['answer']."</strong> expressed concern over your use of medication.<br>";
                    break;
                case 99:

                    $soapp_description .= "Any of your close friends <strong>".$singlelevel['answer']."</strong> had a problem with alcohol or drugs.<br>";

                    break;
                case 100:

                    $soapp_description .= "<strong>".ucfirst($singlelevel['answer'])."</strong> others told you had a bad temper.<br>";
                    break;
                case 101:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> felt consumed by the need to get pain medication.<br>";
                    break;
                case 102:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> run out of pain medication early.<br>";
                    break;
                case 103:

                    $soapp_description .= "Others <strong>".$singlelevel['answer']."</strong> kept you from getting what you deserve.<br>";
                    break;
                case 104:

                    $soapp_description .= 'You <strong>'.$singlelevel['answer']."</strong> had legal problems or been arrested in your lifetime.<br>";
                    break;
                case 105:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> attended an AA or NA meeting.<br>";
                    break;
                case 106:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> been in an argument that was so out of control that someone got hurt.<br>";
                    break;
                case 107:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> been sexually abused.<br>";
                    break;

                case 108:

                    $soapp_description .= "Others <strong>".$singlelevel['answer']."</strong> suggested that you have a drug or alcohol problem.<br>";
                    break;

                case 109:

                    $soapp_description .= 'You had <strong>'.$singlelevel['answer']."</strong> to borrow pain medication from your family or friends.<br>";
                    break;

                case 110:

                    $soapp_description .= 'You have <strong>'.$singlelevel['answer']."</strong> been treated for an alcohol or drug problem.<br>";
                    break;
            }

        }

    }

    if(isset($soapp_comm_question_detail['comm']) && !empty($soapp_comm_question_detail['comm'])){

        foreach ($soapp_comm_question_detail['comm'] as $key => $singlelevel) {

            $singlelevel['answer'] = strtolower($singlelevel['answer']);
            switch ($singlelevel['question_id']) {
                case 60:

                    $comm_description .= 'In the past 30 days you <strong>'.$singlelevel['answer'].'</strong> had trouble with thinking clearly or had memory problems.<br>';

                    break;
                case 61:

                    $comm_description .= 'In the past 30 days people <strong>'.$singlelevel['answer'].'</strong> complain that you are not completing necessary tasks (ie: Doing things that need to be done, such as going to class work or appointments).<br>';

                    break;
                case 62:


                    $comm_description .= 'In the past 30 days you <strong>'.$singlelevel['answer'].'</strong> have to go to someone other than your prescribing physician to get sufficient pain relief from medications (ie: another doctor, the emergency room, friends, street sources).<br>';

                    break;
                case 63:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer'].'</strong> taken your medications differently from how they are prescribed.<br>';

                    break;
                case 64:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer'].'</strong> seriously thought about hurting yourself.<br>';

                    break;
                case 65:

                    $comm_description .= 'In the past 30 days your time was <strong>'.$singlelevel['answer'].'</strong> spent thinking about opioid medications (having enough, taking them, dosing schedule, etc.).<br>';
                    break;
                case 66:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer'].'</strong> been in an argument.<br>';
                    break;
                case 67:

                    $comm_description .= 'In the past 30 days you <strong>'.$singlelevel['answer'].'</strong> had trouble controlling your anger (ex: road rage, screaming, etc.).<br>';

                    break;
                case 68:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer'].'</strong> needed to take pain medications belonging to someone else.<br>';
                    break;
                case 69:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer']."</strong> been worried about how you're handling your medication.<br>";
                    break;
                case 70:

                    $comm_description .= 'In the past 30 days <strong>'.$singlelevel['answer']."</strong> others been worried about how you're handling your medications.<br>";

                    break;
                case 71:

                    $comm_description .= 'In the past 30 days you <strong>'.$singlelevel['answer']."</strong> had to make an emergency phone call or show up at the clinic without an appointment.<br>";
                    break;
                case 72:

                    $comm_description .= 'In the past 30 days you <strong>'.$singlelevel['answer']."</strong> had gotten angry with people.<br>";
                    break;
                case 73:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer']."</strong> take more of your medication than prescribed.<br>";
                    break;
                case 74:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer']."</strong> borrowed pain medication from someone else.<br>";
                    break;
                case 75:

                    $comm_description .= 'In the past 30 days you have <strong>'.$singlelevel['answer']."</strong> used your pain medicine for symptoms other than for pain (ex: to help you sleep, improve your mood or relieve stress).<br>";
                    break;
                case 76:

                    $comm_description .= 'In the past 30 days you had <strong>'.$singlelevel['answer']."</strong> visit the emergency room (ER).<br>";

                    break;

            }
        }

    }
  }

  if(!empty($question_detail) && is_array($question_detail)){

    if(isset($question_detail['dast']) && !empty($question_detail['dast'])){

        foreach ($question_detail['dast'] as $key => $singlelevel) {

            switch ($singlelevel['question_id']) {

                case 77 :

                        if($singlelevel['answer'] == 'Yes'){

                           $dast_description .= 'In the past 12 months, you have used drugs other than those required for medical reasons.<br>';
                        }
                        else{

                           $dast_description .= 'In the past 12 months, you have not used drugs other than those required for medical reasons.<br>';
                        }


                        break;
                case 78 :

                        if($singlelevel['answer'] == 'Yes'){

                            $dast_description .= 'In the past 12 months, you did abused more than one drug at a time.<br>';
                        }
                        else{

                            $dast_description .= 'In the past 12 months, you did not abused more than one drug at a time.<br>';
                        }

                        break;
                case 79 :

                        if($singlelevel['answer'] == 'Yes'){


                            $dast_description .= 'In the past 12 months, you were unable to stop abusing drugs when you want to.<br>';
                        }
                        else{


                            $dast_description .= 'In the past 12 months, you were able to stop abusing drugs when you want to.<br>';
                        }

                        break;
                case 80 :

                        if($singlelevel['answer'] == 'Yes'){


                           $dast_description .= 'In the past 12 months, you had blackouts or flashbacks as a result of drug use.<br>';
                        }
                        else{


                            $dast_description .= 'In the past 12 months, you had not blackouts or flashbacks as a result of drug use.<br>';
                        }

                        break;
                case 81 :

                        if($singlelevel['answer'] == 'Yes'){


                            $dast_description .= 'In the past 12 months, you did feel bad or guilty about your drug use.<br>';
                        }
                        else{


                            $dast_description .= 'In the past 12 months, you did not feel bad or guilty about your drug use.<br>';
                        }

                        break;
                case 82 :

                        if($singlelevel['answer'] == 'Yes'){


                            $dast_description .= 'In the past 12 months, your spouse or family members were complains about your involvement with drugs.<br>';
                        }
                        else{


                            $dast_description .= 'In the past 12 months, your spouse or family members were not complains about your involvement with drugs.<br>';

                        }

                        break;
                case 83 :

                        if($singlelevel['answer'] == 'Yes'){


                            $dast_description .= 'In the past 12 months, you have neglected your family because of your use of drugs.<br>';
                        }
                        else{


                            $dast_description .= 'In the past 12 months, you have not neglected your family because of your use of drugs.<br>';
                        }

                        break;
                case 84 :

                        if($singlelevel['answer'] == 'Yes'){


                            $dast_description .= 'In the past 12 months, you have engaged in illegal activities in order to obtain drugs.<br>';
                        }
                        else{


                            $dast_description .= 'In the past 12 months, you have not engaged in illegal activities in order to obtain drugs.<br>';
                        }


                        break;
                case 85 :

                        if($singlelevel['answer'] == 'Yes'){


                            $dast_description .= 'In the past 12 months, you have experienced withdrawal symptoms (felt sick) when you stopped taking drugs.<br>';
                        }
                        else{


                            $dast_description .= 'In the past 12 months, you have not experienced withdrawal symptoms (felt sick) when you stopped taking drugs.<br>';
                        }
                        break;
                case 86 :

                        if($singlelevel['answer'] == 'Yes'){

                            $dast_description .= 'In the past 12 months, you had medical problems as a result of your drug use (ex: memory loss, hepatitis, convulsions, bleeding).<br>';
                        }
                        else{

                            $dast_description .= 'In the past 12 months, you had medical problems as a result of your drug use (ex: memory loss, hepatitis, convulsions, bleeding).<br>';
                        }
                        break;
            }


        }
    }



    if(isset($question_detail['padt']) && !empty($question_detail['padt'])){

      $padt_severe = '';
      $padt_moderate = '';
      $padt_mild = '';
      $padt_none = '';
      foreach ($question_detail['padt'] as $key => $singlelevel) {

        if($singlelevel['question_id'] >= 111 && $singlelevel['question_id'] <= 119){

            if($singlelevel['question_id'] == 119 && isset($question_detail['padt_other_question_119']) && !empty($question_detail['padt_other_question_119'])){

              $singlelevel['question'] = $question_detail['padt_other_question_119'];
            }
            $singlelevel['question'] = ucfirst($singlelevel['question']);

            switch ($singlelevel['answer']) {

                case 'Severe':

                  $padt_severe .= $singlelevel['question'].', ';
                  break;
                case 'Moderate':

                  $padt_moderate .= $singlelevel['question'].', ';
                  break;
                case 'Mild':

                  $padt_mild .= $singlelevel['question'].', ';
                  break;

                case 'None':

                  $padt_none .= $singlelevel['question'].', ';
                  break;

            }
          continue;
        }

        switch($singlelevel['question_id']){

            case 120 :

              $padt_description .= 'The pain level during the last week is <strong>'.$singlelevel['answer'].'</strong> on average ';
              break;

            case 121 :

              $padt_description .= 'and <strong>'.$singlelevel['answer'].'</strong> at worst.<br>';
              break;

            case 122:

              if($singlelevel['answer'] == 0){

                  $padt_description .= 'The pain during past week is <strong>no relief.</strong><br>';
              }
              elseif($singlelevel['answer'] == 100){

                $padt_description .= 'The pain during past week is <strong>completely relieved.</strong><br>';
              }
              else{

                $padt_description .= 'The pain during past week is <strong>'.$singlelevel['answer'].'% relieved.</strong><br>';
              }
              break;
            case 123 :

                $padt_description .= $singlelevel['answer'] == 'Yes' ? '<strong>Current pain relievers provide significant relief to the patient.</strong><br>' : '<strong>You reported current pain relievers do not provide significant relief.</strong><br>';
                break;

            case 124:

              $padt_description .= 'Your physical functioning '.$arr_124[$singlelevel['answer']].'.<br>';
              break;

            case 125:

              $padt_description .= 'Your family relationships '.$arr_124[$singlelevel['answer']].'.<br>';
              break;

            case 126:

              $padt_description .= 'Your social relationships '.$arr_124[$singlelevel['answer']].'.<br>';
              break;

            case 127:

              $padt_description .= 'Your mood '.$arr_124[$singlelevel['answer']].'.<br>';
              break;

            case 128:

              $padt_description .= 'Your sleep pattern '.$arr_124[$singlelevel['answer']].'.<br>';
              break;

            case 129:

              $padt_description .= 'Your overall functioning '.$arr_124[$singlelevel['answer']].'.<br>';
              break;
        }
      }
      $temp_padt_desc = '';
      $padt_severe = rtrim($padt_severe,', ');
      $padt_moderate = rtrim($padt_moderate,', ');
      $padt_mild = rtrim($padt_mild,', ');
      $padt_none = rtrim($padt_none,', ');

      if(!empty($padt_none)){

          $temp_padt_desc .= 'You denied side effects of <strong>'.$padt_none.'</strong>.<br>';
      }

      if(!empty($padt_mild)){

          $temp_padt_desc .= 'Mild side effects of <strong>'.$padt_mild.'</strong>.<br>';
      }

      if(!empty($padt_moderate)){

          $temp_padt_desc .= 'Moderate side effects of <strong>'.$padt_moderate.'</strong>.<br>';
      }

      if(!empty($padt_severe)){

          $temp_padt_desc .= 'Severe side effects of <strong>'.$padt_severe.'</strong>.<br>';
      }

      $temp_padt_desc .= $padt_description;
      $padt_description = $temp_padt_desc;
    }
    if(isset($question_detail['ort']) && !empty($question_detail['ort'])){

        foreach ($question_detail['ort'] as $key => $singlelevel) {
            switch ($singlelevel['question_id']) {
                case 196:

                    $ort_description .= 'You have a family history of <strong>'.strtolower(implode(', ',$singlelevel['answer'])).'</strong>.<br>';

                    break;
                case 197:

                    $ort_description .= 'You have a personal history of <strong>'.strtolower(implode(', ',$singlelevel['answer'])).'</strong>.<br>';

                    break;
                case 198:
                    if($singlelevel['answer'] == 'Yes')
                    {
                      $ort_description .= 'You have ever been a victim of sexual abuse before your teenage years.<br>';
                    }
                    else{
                        $ort_description .= "You haven't ever been a victim of sexual abuse before your teenage years.<br>";
                    }                    

                    break;
                case 199:
                    if($singlelevel['answer'] == 'Yes')
                    {
                      $ort_description .= 'You have ever been diagnosed with attention-deficit disorder (Add), obsessive-compulsive disorder (OCD), bipolar disorder, or schizophrenia.<br>';
                    }
                    else{
                        $ort_description .= "You haven't ever been diagnosed with attention-deficit disorder (Add), obsessive-compulsive disorder (OCD), bipolar disorder, or schizophrenia.<br>";
                    }

                    break;
                case 200:
                    if($singlelevel['answer'] == 'Yes')
                    {
                      $ort_description .= 'You have ever been diagnosed with depression.<br>';
                    }
                    else{
                        $ort_description .= "You haven't ever been diagnosed with depression.<br>";
                    }

                    break;

            }
        }

    }
    if(isset($question_detail['m3']) && !empty($question_detail['m3'])){

        foreach ($question_detail['m3'] as $key => $singlelevel) {

            $singlelevel['answer'] = strtolower($singlelevel['answer']);
            switch ($singlelevel['question_id']) {
                case 640:

                    $m3_description .= 'I feel <strong>'.$singlelevel['answer'].'</strong> sad, down in the dumps or unhappy.<br>';

                    break;
                case 641:

                    $m3_description .= "I can't <strong>".$singlelevel['answer'].'</strong> concentrate or focus.<br>';

                    break;
                case 642:

                    $m3_description .= "Nothing seems to give me much pleasure <strong>".$singlelevel['answer'].'</strong>.<br>';

                    break;
                case 643:

                    $m3_description .= 'I feel <strong>'.$singlelevel['answer'].'</strong> tired, have no energy.<br>';

                    break;
                case 644:


                    $m3_description .= 'I have had thoughts of suicide <strong>'.$singlelevel['answer'].'</strong> .<br>';

                    break;
                case 645:

                    $m3_description .= 'Changes in sleeping patterns [M3] <strong>'.$singlelevel['answer'].'</strong>.<br>';

                    break;
                case 646:

                    $m3_description .= 'I have <strong>'.$singlelevel['answer'].'</strong> difficulty sleeping.<br>';

                    break;
                case 647:

                    $m3_description .= 'I have been <strong>'.$singlelevel['answer'].'</strong> sleeping too much.<br>';
                    break;
                case 648:

                    $m3_description .= 'Changes in appetite [M3] <strong>'.$singlelevel['answer'].'</strong>.<br>';
                    break;
                case 649:

                    $m3_description .= 'I have <strong>'.$singlelevel['answer'].'</strong> lost some appetite.<br>';

                    break;
                case 650:

                    $m3_description .= 'I have been <strong>'.$singlelevel['answer'].'</strong> eating more.<br>';
                    break;
                case 651:

                    $m3_description .= 'I feel <strong>'.$singlelevel['answer']."</strong> tense, anxious or can't sit still.<br>";
                    break;
                case 652:

                    $m3_description .= 'I feel <strong>'.$singlelevel['answer']."</strong> worried or fearful.<br>";

                    break;
                case 653:

                    $m3_description .= 'I have <strong>'.$singlelevel['answer']."</strong> attacks of anxiety or panic.<br>";
                    break;
                case 654:

                    $m3_description .= 'I worry about dying or losing control <strong>'.$singlelevel['answer']."</strong>.<br>";
                    break;
                case 655:

                    $m3_description .= 'I am <strong>'.$singlelevel['answer']."</strong> nervous or shaky in social situations.<br>";
                    break;
                case 656:

                    $m3_description .= 'I have <strong>'.$singlelevel['answer']."</strong> nightmares or flashbacks.<br>";
                    break;
                case 657:

                    $m3_description .= 'I am <strong>'.$singlelevel['answer']."</strong> jumpy or feel started.<br>";
                    break;
                case 658:

                    $m3_description .= 'I avoid <strong>'.$singlelevel['answer']."</strong> places that strongly remind me of a bad experience.<br>";

                    break;
                case 659:

                    $m3_description .= 'I feel <strong>'.$singlelevel['answer']."</strong> dull, numb or detached.<br>";
                    break;
                case 660:

                    $m3_description .= "I can't <strong>".$singlelevel['answer']."</strong> get certain things out of my mind.<br>";
                    break;
                case 661:

                    $m3_description .= 'I feel <strong>'.$singlelevel['answer']."</strong> I must repeat certain acts or rituals.<br>";
                    break;
                case 662:

                    $m3_description .= 'I feel <strong>'.$singlelevel['answer']."</strong> the need to check or recheck things.<br>";
                    break;
                case 663:

                    $m3_description .= 'Had more energy than usual <strong>'.$singlelevel['answer']."</strong> .<br>";
                    break;
                case 664:

                    $m3_description .= 'Felt unusually irritable or angry <strong>'.$singlelevel['answer']."</strong>.<br>";

                    break;
                case 665:

                    $m3_description .= 'Felt unusually excited, revved up or high <strong>'.$singlelevel['answer']."</strong>.<br>";
                    break;
                case 666:

                    $m3_description .= 'Needed less sleep than usual <strong>'.$singlelevel['answer']."</strong>.<br>";
                    break;
                case 667:

                    $m3_description .= 'Interfaces with work or school <strong>'.$singlelevel['answer']."</strong>.<br>";
                    break;
                case 668:

                    $m3_description .= 'Affects my relationships with friends or family <strong>'.$singlelevel['answer']."</strong>.<br>";
                    break;
                case 669:

                    $m3_description .= 'Has led to my using alcohol to get by <strong>'.$singlelevel['answer']."</strong>.<br>";
                    break;
                case 670:

                    $m3_description .= 'Has led to my using drugs <strong>'.$singlelevel['answer']."</strong>.<br>";

                    break;
                case 671:
                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '.'problems with judgment' : 'problems with judgment';
                    }                    

                    break;
                case 672:

                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '.'less interest in hobbies/activities' : 'less interest in hobbies/activities';
                    }
                    break;
                case 673:

                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '.'repete the same things over and over' : 'repete the same things over and over';
                    }
                    break;
                case 674:

                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '.'trouble learning operating tools or appliances' : 'trouble learning operating tools or appliances';
                    }
                    break;
                case 675:

                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '.'forgets correct month or year' : 'forgets correct month or year';
                    }
                    break;
                case 676:

                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '.'trouble handling complicated financial affairs' : 'trouble handling complicated financial affairs';
                    }
                    break;
                case 677:

                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '.'trouble remembering appointments' : 'trouble remembering appointments';
                    }

                    break;
                case 678:

                    if($singlelevel['answer'] == "yes, a change")
                    {
                      $ad8_dementia_screen .= $ad8_dementia_screen ? ', '."daily problems with thinking and/or memory" : "daily problems with thinking and/or memory";
                    }

                    break;

            }
            
        }
        if(!empty($ad8_dementia_screen))
            {
              $m3_description .= 'AD8 Dementia Screening have <strong>'.$ad8_dementia_screen."</strong>.<br>";
            }

    }
  }
    

  return array('soapp_description' => $soapp_description,'comm_description' => $comm_description,'dast_description' => $dast_description,'padt_description' => $padt_description,'ort_description'=>$ort_description,'m3_description' =>$m3_description);
}


// prepare question in layman summary

public function prepare_follow_up_sx_layman($user_detail, $previous_appoitment_data){

 //pr($previous_appoitment_data);die;

  $all_cc_name = '' ;
  $layman_summar = '' ;
  $cur_cc_name = '';


  if(!empty($user_detail->follow_up_sx_detail) && is_array($user_detail->follow_up_sx_detail)){

   // pr($user_detail->follow_up_sx_detail);die;
    foreach ($user_detail->follow_up_sx_detail as $key => $value) {


      foreach ($value as $k => $singlelevel) {

        if(is_string($k) && $k == 'cc_data')
        {


            //set the previous appointment values
            $previous_follow_up_symptom_detail = array();
            if(!empty($previous_appoitment_data->chief_compliant_details) && isset($previous_appoitment_data->chief_compliant_details[$singlelevel->id]) && !empty($previous_appoitment_data->chief_compliant_details[$singlelevel->id])){


              foreach ($previous_appoitment_data->chief_compliant_details[$singlelevel->id] as $pkey => $pvalue) {

                  if(is_string($pkey) && $pkey == 'cc_data'){

                    continue;
                  }

                  //pr($pvalue);die;
                  /*//check pain scale best is exist or not
                  if(in_array($pvalue['question_id'], [10,144])){

                     $previous_follow_up_symptom_detail['pain_best_scale'] = $pvalue['answer'];
                     continue;
                  }

                  //check pain scale worst is exist or not
                  if(in_array($pvalue['question_id'], [11,145])){

                     $previous_follow_up_symptom_detail['pain_worst_scale'] = $pvalue['answer'];
                     continue;
                  }

                  //check temporal is exist or not
                  if(in_array($pvalue['question_id'], [6,154,96])){

                     $previous_follow_up_symptom_detail['temporal'] = $pvalue['answer'];
                     continue;
                  }*/

                  //check pain scale best is exist or not
                  if(trim($pvalue['hpi_element']) == 'pain scale best'){

                      $previous_follow_up_symptom_detail['pain_best_scale'] = $pvalue['answer'];
                      //continue;
                  }

                  //check pain scale worst is exist or not
                  if(trim($pvalue['hpi_element']) == 'pain scale worst'){

                      $previous_follow_up_symptom_detail['pain_worst_scale'] = $pvalue['answer'];
                      //continue;
                  }
                  //check temporal is exist or not
                  if(trim($pvalue['hpi_element']) == 'temporal'){

                      $previous_follow_up_symptom_detail['temporal'][] = is_array($pvalue['answer']) ? implode(", ", $pvalue['answer']) : $pvalue['answer'];
                      //continue;
                  }

                  if(trim($pvalue['hpi_element']) == 'location'){

                      $previous_follow_up_symptom_detail['location'][] = is_array($pvalue['answer']) ? implode(", ", $pvalue['answer']) : $pvalue['answer'];
                      //continue;
                  }

              }
            }
            elseif(!empty($previous_appoitment_data->follow_up_sx_detail) && isset($previous_appoitment_data->follow_up_sx_detail[$singlelevel->id]) && !empty($previous_appoitment_data->follow_up_sx_detail[$singlelevel->id])){

                foreach ($previous_appoitment_data->follow_up_sx_detail[$singlelevel->id] as $pkey => $pvalue) {

                  //check pain scale best is exist or not
                  if($pvalue['question_id'] == 134){

                     $previous_follow_up_symptom_detail['pain_best_scale'] = $pvalue['answer'];
                     continue;
                  }

                  //check pain scale worst is exist or not
                  if($pvalue['question_id'] == 135){

                     $previous_follow_up_symptom_detail['pain_worst_scale'] = $pvalue['answer'];
                     continue;
                  }

                  //check temporal is exist or not
                  if($pvalue['question_id'] == 136){

                     $previous_follow_up_symptom_detail['temporal'] = $pvalue['answer'];
                     continue;
                  }

                  //check temporal is exist or not
                  if($pvalue['question_id'] == 133){

                     $previous_follow_up_symptom_detail['location'] = $pvalue['answer'];
                     continue;
                  }

              }
            }

            if(!empty($previous_follow_up_symptom_detail)){

              $previous_follow_up_symptom_detail = array_filter($previous_follow_up_symptom_detail);
              foreach ($previous_follow_up_symptom_detail as $pre_key => $pre_value) {

                 $previous_follow_up_symptom_detail[$pre_key] = strtolower(is_array($pre_value) ? implode(", ", $pre_value) : $pre_value);
              }
            }
           // pr($previous_follow_up_symptom_detail);die;

            $all_cc_name .=  $singlelevel->name.', ';
            $cur_cc_name = $singlelevel->name;
            $layman_summar .= "<br /><strong>You provided these follow up details for  ".$singlelevel->name.':</strong><br />' ;
        }
        else {

            $pain_best_scale = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['pain_best_scale']) ? $previous_follow_up_symptom_detail['pain_best_scale'] : '');

            $pain_worst_scale = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['pain_worst_scale']) ? $previous_follow_up_symptom_detail['pain_worst_scale'] : '');

            $temporal = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['temporal']) ? $previous_follow_up_symptom_detail['temporal'] : '');

            if(!empty($temporal)){

              $temporal = trim($temporal);

              if($temporal == 'afternoon' || $temporal == 'morning'){

                  $temporal = ' in the '.$temporal;
              }
              elseif($temporal == 'night'){

                  $temporal = ' at '.$temporal;
              }
              elseif($temporal == 'only after meals' || $temporal == 'same all day'){

                  $temporal = ' '.$temporal;
              }
              else{

                $temporal = ' in the '.$temporal;
              }
            }

            $location = strtolower(!empty($previous_follow_up_symptom_detail) && isset($previous_follow_up_symptom_detail['location']) ? $previous_follow_up_symptom_detail['location'] : '');

            //pr($previous_follow_up_symptom_detail);die;

            switch ($singlelevel['question_id'])
            {
              //quetion 1 2 3 are related to each other
              case 130:


                $arr_130 = array(
                  'Completely gone' => 'resolved',
                  'Better' => 'improved',
                  'About the same' => 'remained stable',
                  'worst' => 'worsened'
                );
                  $layman_summar .= "You described the ".$cur_cc_name.' is <strong>'.(isset($arr_130[$singlelevel['answer']]) ? $arr_130[$singlelevel['answer']] :"").'</strong>.<br />' ;


                  break;


              case 131:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You still feel the <strong>'.$cur_cc_name.'</strong> in your <strong>'.$location.'</strong>.<br>' : 'You do not feel the <strong>'.$cur_cc_name.'</strong> in your <strong>'.$location.'</strong>.<br>';

                  break;

              case 132:

                $ans_133 = '';
                if(isset($value[$k+1]) && $value[$k+1]['question_id'] == 133){

                  $ans_133 = $value[$k+1]['answer'];
                }

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You feel the '.$cur_cc_name.' in new location <strong>'.$ans_133.'</strong>.<br>' : '<strong>You do not feel the '.$cur_cc_name.' in any new location</strong>.<br>';
                  break;

              case 134:

                $layman_summar .= 'Last visit you said your pain was a <strong>'.$pain_best_scale.'</strong> at its best. Today, you rate your pain <strong>'.$singlelevel['answer'].'</strong> at its best.<br />';
                break;

              case 135:

                $layman_summar .= 'Last visit you said your pain was a <strong>'.$pain_worst_scale.'</strong> at its worst. Today, you rate your pain <strong>'.$singlelevel['answer'].'</strong> at its worst.<br />';
                break;

              case 136:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>Your symptoms still occur most ".$temporal.'.</strong><br />' : "<strong>Your symptoms are not occur ".$temporal.'.</strong><br />';
                  break;

              case 137:

                  $ques_ans_137 = strtolower($singlelevel['answer']);
                  if(!empty($ques_ans_137)){

                    if($ques_ans_137 == 'afternoon' || $ques_ans_137 == 'morning'){

                        $ques_ans_137 = 'in the '.$ques_ans_137;
                    }
                    elseif($ques_ans_137 == 'night'){

                        $ques_ans_137 = 'at '.$ques_ans_137;
                    }
                    elseif($ques_ans_137 == 'only after meals' || $ques_ans_137 == 'same all day'){

                        $ques_ans_137 = $ques_ans_137;
                    }
                    else{

                      $ques_ans_137 = 'in the '.$ques_ans_137;
                    }
                  }
                  $layman_summar .= "Symptoms occurs <strong>".$ques_ans_137.'.</strong><br />';
                  break;

               case 138:

                $ans_139 = '';
                if(isset($value[$k+1]) && $value[$k+1]['question_id'] == 139){

                  $ans_139 = $value[$k+1]['answer'];
                }

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have noticed new symptoms <strong>'.$ans_139.'</strong> since your last visit.<br>' : '<strong>You have not noticed any new symptoms since your last visit</strong>.<br>';
                  break;

              case 140:

                  $ques_ans_140 = $singlelevel['answer'];
                  $well_resp = '';
                  $minimal_resp = '';
                  $no_resp = '';
                  if(isset($ques_ans_140['med_type']) && !empty($ques_ans_140['med_type'])){

                      foreach ($ques_ans_140['med_type'] as $med_key => $med_value) {

                         if(isset($ques_ans_140[$med_key])){

                              $med_value = strtolower($med_value);

                              if($med_value == 'a little'){

                                  $minimal_resp .= $ques_ans_140[$med_key].', ';
                              }
                              elseif($med_value == 'a lot'){

                                  $well_resp .= $ques_ans_140[$med_key].', ';
                              }
                              elseif($med_value == 'not at all'){

                                  $no_resp .= $ques_ans_140[$med_key].', ';
                              }

                         }

                      }
                  }

                  $well_resp = rtrim($well_resp,', ');
                  $minimal_resp = rtrim($minimal_resp,', ');
                  $no_resp = rtrim($no_resp,', ');
                  $layman_summar .= (!empty($well_resp) ? "Responded well to <strong>".strtolower($well_resp).'</strong>.<br />': "");
                  $layman_summar .= (!empty($minimal_resp) ? "Minimal response to <strong>".strtolower($minimal_resp).'</strong>.<br />': "");
                  $layman_summar .= (!empty($no_resp) ? "No response to <strong>".strtolower($no_resp).'</strong>.<br />': "");
                  break;
            }
          }
        }
      }

      $layman_summar .= '<br />';
  }

  //echo $layman_summar;die;
  //die;
  return array('layman_summar' => $layman_summar);
}

public function prepare_cancer_cc_layman($cancer_cc_detail)
{
  $layman_summar = '';
 //pr($cancer_cc_detail);//die;

  if(!empty($cancer_cc_detail) && is_array($cancer_cc_detail)){

    foreach ($cancer_cc_detail as $k => $singlelevel) {

      switch ($singlelevel['question_id'])
      {
        case 332:

          $layman_summar .= "You're here for <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']))."</strong>.<br />";
          $layman_summar = str_replace("i have a new cancer diagnosis", "new cancer diagnosis", $layman_summar);
          break;

        case 321:

          $layman_summar .= "You have a new diagnosis of <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']))."</strong>.</br>";
          break;

        case 322:

          $layman_summar = str_replace("other", $singlelevel['answer'], $layman_summar);
          break;

        case 323:

          $ques_ans_323 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
          $layman_summar .= $ques_ans_323 != 'not sure' ? "You have the following test(s): <strong>".$ques_ans_323."</strong>.</br>" : '';
          break;

        case 324:

          $layman_summar = str_replace("other", $singlelevel['answer'], $layman_summar);
          break;

        case 325:

          $layman_summar .= "You looking to get a second opinion on <strong>".strtolower(is_array($cancer_cc_detail[$k]['answer']) ? implode(", ", $cancer_cc_detail[$k]['answer']) : $cancer_cc_detail[$k]['answer']).'</strong>.<br />';
          break;

        case 326:

          $layman_summar = str_replace("something else", $singlelevel['answer'], $layman_summar);
          break;

        case 327:

        if($singlelevel['answer'] == 'Yes'){

          if(isset($cancer_cc_detail[$k+1]) && !empty($cancer_cc_detail[$k+1]) && $cancer_cc_detail[$k+1]['question_id'] == 328){

            $layman_summar .= "Your <strong>".strtolower(is_array($cancer_cc_detail[$k+1]['answer']) ? implode(", ", $cancer_cc_detail[$k+1]['answer']) : $cancer_cc_detail[$k+1]['answer'])."</strong> are accompanying you to today's visit.<br />";
          }
          else{

            $layman_summar .= "<strong>Someone else are accompanying you to today's visit</strong>.<br />";
          }
        }
        else{
          $layman_summar .= "<strong>No one else is accompanying you to today's visit</strong>.<br />";
        }
        break;


        case 329:

          if(strtolower($singlelevel['answer']) == 'yes'){

            if(isset($cancer_cc_detail[$k+1]) && !empty($cancer_cc_detail[$k+1]) && $cancer_cc_detail[$k+1]['question_id'] == 330){

              if(strpos(strtolower($cancer_cc_detail[$k+1]['answer']), "dr") === false){
                  $cancer_cc_detail[$k+1]['answer'] = "Dr. ".$cancer_cc_detail[$k+1]['answer'];
              }
              $layman_summar .= "You were referred to us by <strong>".$cancer_cc_detail[$k+1]['answer']."</strong>.<br />" ;

              //$layman_summar .= "You were referred to us by Dr. <strong>".$cancer_cc_detail[$k+1]['answer']."</strong>.<br />" ;
            }
          }
          else{

            $layman_summar .= "<strong>You were not referred to us by another doctor </strong>.<br />";
          }
          break;

        case 333:

          $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>It looks like you're here for [call:ADT/SIU]</strong>.<br>" : "<strong>It looks like you're not here for [call:ADT/SIU]</strong>.<br>";
          break;

      }
    }

    $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}


public function prepare_cancer_history_layman($cancer_history_detail,$gender)
{
  $layman_summar = '' ;
  //pr($cancer_history_detail);die;
  if(!empty($cancer_history_detail) && is_array($cancer_history_detail)){
    $layman_summar .= "<br /><strong>You provided the following cancer history details:</strong><br />";

    foreach ($cancer_history_detail as $key => $value) {

      if(!empty($value)){
        // && in_array($key, ['breast cancer','esophageal cancer','brain cancer',"stomach cancer","kidney cancer",'colon cancer','cervical cancer','ovarian cancer','prostate cancer'])
      	$temp_first_symptoms = '';
      	$temp_treatment = '';
      	$temp_how_long = '';

      	$layman_summar .= "<br /><strong>".ucfirst(strtolower($key)).":</strong><br />";

        switch ($key) {

            case "breast cancer" :
            {
              //set the array as question_id
              $temp_breast_arr = [];
              foreach ($value as $bk => $bv) {
                
                $temp_breast_arr[$bv['question_id']] = $bv;
              }

              $value = $temp_breast_arr;

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 334:

                      $temp_first_symptoms = "";
                      $temp_discharge_color = "";
                      if(!empty($singlelevel['answer']) && is_array($singlelevel['answer'])){

                        foreach ($singlelevel['answer'] as $k334 => $v334) {

                            $v334 = strtolower($v334);
                            if($v334 == "none of these"){

                              //$temp_first_symptoms .= "You first noticed symptoms that led you to get checked.<br>";
                              break;
                            }
                            
                            
                            if($v334 != 'other'){
                                $temp_first_symptoms .= $v334;
                            }

                            if($v334 == 'nipple discharge'){

                              if(isset($value[505]) && !empty($value[505])){

                                $temp_first_symptoms .= " (".$value[505]['answer'].")";
                              }

                              if(isset($value[506]) && !empty($value[506])){

                                $ans_ques_506 = strtolower(is_array($value[506]['answer']) ? implode(", ", $value[506]['answer']) : $value[506]['answer']);
                                if($ans_ques_506 != 'not sure'){

                                  $temp_discharge_color .= "Nipple discharge color is <strong>".$ans_ques_506."</strong>.<br>";
                                }
                                
                              }
                            }

                            if($v334 == 'breast pain'){

                              if(isset($value[507]) && !empty($value[507])){

                                $temp_first_symptoms .= " (".$value[507]['answer'].")";
                              }
                            }

                            if($v334 == 'breast grew in size'){

                              if(isset($value[508]) && !empty($value[508])){

                                $temp_first_symptoms .= " (".$value[508]['answer'].")";
                              }
                            }

                            if($v334 == 'lump or swelling in armpit'){

                              if(isset($value[509]) && !empty($value[509])){

                                $temp_first_symptoms .= " (".$value[509]['answer'].")";
                              }
                            }

                            if($v334 == 'arm swelling'){

                              if(isset($value[510]) && !empty($value[510])){

                                $temp_first_symptoms .= " (".$value[510]['answer'].")";
                              }
                            }

                            if($v334 == 'nipple changes'){

                              if(isset($value[511]) && !empty($value[511])){

                                $temp_first_symptoms .= " (".$value[511]['answer'].")";
                              }
                            }

                            if($v334 == 'nipple cratering (inversion)'){

                              if(isset($value[513]) && !empty($value[513])){

                                $temp_first_symptoms .= " (".$value[513]['answer'].")";
                              }
                            }

                            if($v334 == 'dimpling or puckering of breast skin'){

                              if(isset($value[514]) && !empty($value[514])){

                                $temp_first_symptoms .= " (".$value[514]['answer'].")";
                              }
                            }

                            if($v334 == 'other'){

                              if(isset($value[372]) && !empty($value[372])){

                                $temp_first_symptoms .= strtolower($value[372]['answer']);
                              }

                              if(isset($value[515]) && !empty($value[515])){

                                $temp_first_symptoms .= " (".$value[515]['answer'].")";
                              }
                            }

                            $temp_first_symptoms .= ", ";
                        }
                      }

                      if(empty($temp_first_symptoms)){

                        $temp_first_symptoms = "You first noticed symptoms that led you to get checked.<br>";
                      }
                      else{

                        $temp_first_symptoms = "You first noticed <strong>".trim($temp_first_symptoms,", ")."</strong> that led you to get checked.<br>";
                      }
                      //$ques_and_334 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      //$temp_first_symptoms = $ques_and_334 == 'none of these' ? '' : "You first noticed <strong>".$ques_and_334."</strong> that led you to get checked.<br>";

                      $layman_summar .= $temp_first_symptoms.(!empty($temp_discharge_color) ? $temp_discharge_color : "");

                      /*if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }*/

                      break;

                    case 372:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    /*case 335:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;*/

                    case 336:

                      if($singlelevel['answer'] == 'Yes'){

                        $layman_summar .= 'You found the first breast lump';

                        if(isset($value[337]) && !empty($value[337])){

                          $layman_summar .= ' <strong>'.strtolower($value[337]['answer']).' ago</strong>';
                        }

                        if(isset($value[338]) && !empty($value[338])){

                          $layman_summar .= ' in a <strong>'.strtolower($value[338]['answer']).'</strong>';
                        }

                        $layman_summar .= '.<br>';
                      }
                      else{

                        $layman_summar .= "<strong>You haven't found breast lumps</strong>.<br />";
                      }

                       break;

                    case 339:

                      $layman_summar .= $singlelevel['answer'] == 'Yes' ? "You have experienced breast swelling or breast redness.<br />" : "You haven't experienced breast swelling or or breast redness.<br />" ;

                       break;

                    case 340:

                      $que_ans_340 = strtolower($singlelevel['answer']);
                      $layman_summar .= $que_ans_340 == 'neither' ? "<strong>You haven't noticed symptoms or lump</strong>.<br/>" : 'You have noticed symptoms or lump in <strong>'.$que_ans_340.'</strong>.<br/>';
                       break;

                    case 341:
                      $que_ans_341 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_341 == 'dont know' ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed when <strong>'.$que_ans_341.'</strong>.<br>';
                       break;

                     case 342:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[343]) && !empty($value[343])){

                            $temp_treatment = strtolower(is_array($value[343]['answer']) ? implode(", ", $value[343]['answer']) : $value[343]['answer']);

                            if($temp_treatment == "not sure"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;

                      case 551:
                      $que_ans_551 = $singlelevel['answer'];
                      $layman_summar .= "The name of the hospital or surgical center your surgery was performed is <strong> ".$que_ans_551."</strong>.<br>";
                       break;

                      case 552:
                      $que_ans_552 = $singlelevel['answer'];
                      $layman_summar .= "Your procedure date is <strong> ".$que_ans_552."</strong>.<br>";
                       break;

                      case 553:
                      $que_ans_553 = $singlelevel['answer'];
                      $layman_summar .= "The physician name is <strong> ".$que_ans_553."</strong> who performed your surgery.<br>";
                      break;

                      case 554:
                      $que_ans_554 = $singlelevel['answer'];
                      $layman_summar .= "Doctor's clinical specialty is <strong> ".$que_ans_554."</strong> who performed your surgery.<br>";
                      break;

                      case 555:
                      $que_ans_555 = $singlelevel['answer'];
                      $layman_summar .= "The phone number of physician's office  is <strong> ".$que_ans_555."</strong> who performed your surgery.<br>";
                      break;
                      
                       

                  }
              }
            }
            break;

          case "esophageal cancer" :
          {
              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 393:

                      $ques_and_393 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_393 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_393."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 394:

                      $layman_summar .= "You have trouble swallowing in <strong>".strtolower($singlelevel['answer'])."</strong>.<br />";
                      break;

                    case 395:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 397:
                      $que_ans_397 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_397 == "don't know" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_397.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

           	case "brain cancer" :
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 400:

                      $ques_and_400 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_400 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_400."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 401:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 402:
                      $que_ans_402 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_402 == "dont know" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_402.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 404){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "dont know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "colon cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 414:

                      $ques_and_414 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_414 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_414."</strong>";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 415:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 416:
                      $que_ans_416 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_416 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_416.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "vulvar cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 423:

                      $ques_and_423 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_423 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_423."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 424:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 425:
                      $que_ans_425 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_425 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_425.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "uterine cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 420:

                      $ques_and_420 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_420 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_420."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 421:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 422:
                      $que_ans_422 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_422 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_422.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "kidney cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 411:

                      $ques_and_411 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_411 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_411."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 412:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 413:
                      $que_ans_413 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_413 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_413.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "lung cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 405:

                      $ques_and_405 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_405 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_405."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 406:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 407:
                      $que_ans_407 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_407 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_407.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "prostate cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 417:

                      $ques_and_417 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_417 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_417."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 418:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 419:
                      $que_ans_419 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_419 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_419.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "ovarian cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 429:

                      $ques_and_429 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_429 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_429."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 430:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 431:
                      $que_ans_431 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_431 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_431.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 432){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "not sure"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "stomach cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 408:

                      $ques_and_408 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_408 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_408."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 409:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 410:
                      $que_ans_410 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_410 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_410.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "cervical cancer":
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 426:

                      $ques_and_426 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_426 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_426."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 427:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 428:
                      $que_ans_428 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_428 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_428.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "leukemia":
            {

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 440:

                      $ques_and_440 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_440 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_440."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 441:

                      $layman_summar.= $this->abdominal_pain_location_layman($singlelevel['answer'],$gender);
                      break;

                    case 442:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 443:
                      $que_ans_443 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_443 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_443.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 444){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "not sure"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "vaginal cancer":
            {

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 445:

                      $ques_and_445 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_445 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_445."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 446:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 447:
                      $que_ans_447 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_447 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_447.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 448){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "not sure"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "thyroid cancer":
            {

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 453:

                      $ques_and_453 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_453 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_453."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 454:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 455:
                      $que_ans_455 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_455 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_455.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "liver cancer":
            {

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 449:

                      $ques_and_449 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_449 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_449."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 450:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 451:
                      $que_ans_451 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_451 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_451.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 452){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "not sure"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "pancreatic cancer":
            {

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 433:

                      $ques_and_433 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $temp_first_symptoms = $ques_and_433 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_433."</strong> symptoms";

                      if(isset($temp_how_long) && !empty($temp_how_long)){

                        $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                      }

                      break;

                    case 434:

                      $layman_summar.= $this->abdominal_pain_location_layman($singlelevel['answer'],$gender);

                      break;

                    case 435:

                      $layman_summar .= 'Abdominal pain radiation is <strong>'.$singlelevel['answer']."</strong>.<br>";

                      break;

                    case 436:

                      $layman_summar .= 'Back pain radiation is <strong>'.$singlelevel['answer']."</strong>.<br>";

                      break;

                    case 437:

                      if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                        $temp_first_symptoms = str_replace("other", strtolower($singlelevel['answer']), $temp_first_symptoms);
                      }

                      break;

                    case 396:

                        $temp_how_long = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($temp_first_symptoms) && !empty($temp_first_symptoms)){

                          $layman_summar .= $temp_first_symptoms.' '.$temp_how_long;
                        }

                        break;

                    case 438:
                      $que_ans_438 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_438 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed with <strong>'.$que_ans_438.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 439){

                            $temp_treatment = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($temp_treatment == "dont know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$temp_treatment.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;
        }

        $layman_summar .= '<br />';
      }
    }
  }
  return array('layman_summar' => $layman_summar);
}


public function prepare_cancer_history_layman_29_oct($cancer_history_detail)
{
  $layman_summar = '' ;
  //pr($cancer_history_detail); //die();
  if(!empty($cancer_history_detail) && is_array($cancer_history_detail)){
    $layman_summar .= "<br /><strong>You provided the following cancer history details:</strong><br />";

    foreach ($cancer_history_detail as $key => $value) {

      if(!empty($value)){

      	$layman_summar .= "<br /><strong>".$key.":</strong><br />";

        switch ($key) {

            case "breast cancer" :
            {

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 334:

                      $ques_and_334 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $ans_334 = $ques_and_334 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_334."</strong>";

                      if(isset($ans_335) && !empty($ans_335)){

                        $layman_summar .= $ans_334.' '.$ans_335;
                      }

                      break;

                    case 372:

                      if(isset($ans_334) && !empty($ans_334)){

                        $ans_334 = str_replace("other", strtolower($singlelevel['answer']), $ans_334);
                      }

                      break;

                    case 335:

                        $ans_335 = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($ans_334) && !empty($ans_334)){

                          $layman_summar .= $ans_334.' '.$ans_335;
                        }

                        break;

                    case 336:

                      if($singlelevel['answer'] == 'Yes'){

                        $layman_summar .= 'You found the first breast lump';

                        if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 337){

                          $layman_summar .= ' <strong>'.strtolower($value[$k+1]['answer']).' ago</strong>';
                        }

                        if(isset($value[$k+2]) && !empty($value[$k+2]) && $value[$k+2]['question_id'] == 338){

                          $layman_summar .= ' in a <strong>'.strtolower($value[$k+2]['answer']).'</strong>';
                        }

                        $layman_summar .= '.<br>';
                      }
                      else{

                        $layman_summar .= "<strong>You haven't found breast lumps</strong>.<br />";
                      }

                       break;

                    case 339:

                      $layman_summar .= $singlelevel['answer'] == 'Yes' ? "You have experienced breast swelling or dimpling, also known as peau d'orange.<br />" : "You haven't experienced breast swelling or dimpling, also known as peau d'orange.<br />" ;

                       break;

                    case 340:

                      $que_ans_340 = strtolower($singlelevel['answer']);
                      $layman_summar .= $que_ans_340 == 'neither' ? "<strong>You haven't noticed symptoms or lump</strong>.<br/>" : 'You have noticed symptoms or lump in <strong>'.$que_ans_340.'</strong>.<br/>';
                       break;

                    case 341:
                      $que_ans_341 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_341 == 'dont know' ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed when <strong>'.$que_ans_341.'</strong>.<br>';
                       break;

                     case 342:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 343){

                            $ques_ans_343 = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($ques_ans_343 == "not sure"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$ques_ans_343.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;

                        // case 551:

                       //  $que_ans_551 = strtolower($singlelevel['answer']);
                       //  $layman_summar .= $que_ans_551. "<strong>where your surgery was performed</strong>.<br/>"'</strong>.<br/>';
                       //  break;
                  }
              }
            }
            break;

          case "esophageal cancer" :
          {
              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 393:

                      $ques_and_393 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $ans_393 = $ques_and_393 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_393."</strong> symptoms";

                      if(isset($ans_396) && !empty($ans_396)){

                        $layman_summar .= $ans_393.' '.$ans_396;
                      }

                      break;

                    case 394:

                      $layman_summar .= "You have trouble swallowing in <strong>".strtolower($singlelevel['answer'])."</strong>.<br />";
                      break;

                    case 395:

                      if(isset($ans_393) && !empty($ans_393)){

                        $ans_393 = str_replace("other", strtolower($singlelevel['answer']), $ans_393);
                      }

                      break;

                    case 396:

                        $ans_396 = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($ans_393) && !empty($ans_393)){

                          $layman_summar .= $ans_393.' '.$ans_396;
                        }

                        break;

                    case 397:
                      $que_ans_397 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_397 == "don't know" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed when <strong>'.$que_ans_397.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $ques_ans_399 = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($ques_ans_399 == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$ques_ans_399.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

           	case "brain cancer" :
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 400:

                      $ques_and_400 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $ans_400 = $ques_and_400 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_400."</strong> symptoms";

                      if(isset($ans_396) && !empty($ans_396)){

                        $layman_summar .= $ans_400.' '.$ans_396;
                      }

                      break;

                    case 401:

                      if(isset($ans_400) && !empty($ans_400)){

                        $ans_400 = str_replace("other", strtolower($singlelevel['answer']), $ans_400);
                      }

                      break;

                    case 396:

                        $ans_396 = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($ans_400) && !empty($ans_400)){

                          $layman_summar .= $ans_400.' '.$ans_396;
                        }

                        break;

                    case 402:
                      $que_ans_402 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_402 == "dont know" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed when <strong>'.$que_ans_402.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 404){

                            $ques_ans_404 = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($ques_ans_404 == "dont know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$ques_ans_404.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;

            case "colon cancer" :
          	{

              foreach ($value as $k => $singlelevel) {

                switch ($singlelevel['question_id'])
                {

                  case 414:

                      $ques_and_414 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                      $ans_414 = $ques_and_414 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_414."</strong>";

                      if(isset($ans_396) && !empty($ans_396)){

                        $layman_summar .= $ans_414.' '.$ans_396;
                      }

                      break;

                    case 415:

                      if(isset($ans_414) && !empty($ans_414)){

                        $ans_414 = str_replace("other", strtolower($singlelevel['answer']), $ans_414);
                      }

                      break;

                    case 396:

                        $ans_396 = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                        if(isset($ans_414) && !empty($ans_414)){

                          $layman_summar .= $ans_414.' '.$ans_396;
                        }

                        break;

                    case 416:
                      $que_ans_416 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                      $layman_summar .= $que_ans_416 == "not sure" ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed when <strong>'.$que_ans_416.'</strong>.<br>';
                       break;

                     case 398:

                       if($singlelevel['answer'] == 'Yes'){

                          if(isset($value[$k+1]) && !empty($value[$k+1]) && $value[$k+1]['question_id'] == 399){

                            $ques_ans_399 = strtolower(is_array($value[$k+1]['answer']) ? implode(", ", $value[$k+1]['answer']) : $value[$k+1]['answer']);

                            if($ques_ans_399 == "don't know"){

                                $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                            }
                            else{

                              $layman_summar .= 'You have started <strong>'.$ques_ans_399.'</strong> treatments. <br>';
                            }
                          }
                          else{

                            $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                          }
                       }
                       else{

                          $layman_summar .= "<strong>You haven't started any treatments like surgery, chemo or radiation</strong>.<br />" ;

                       }
                       break;
                  }
              }
            }
            break;
        }

        $layman_summar .= '<br />';
      }
    }
  }
  return array('layman_summar' => $layman_summar);
}


public function prepare_cancer_history_layman1($cancer_history_detail)
{
  $layman_summar = '' ;
  //pr($cancer_history_detail); die();
  if(!empty($cancer_history_detail) && is_array($cancer_history_detail)){

     $layman_summar .= "<br /><strong>You provided the following breast cancer history details:</strong><br />";

      foreach ($cancer_history_detail as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 334:

                  $ques_and_334 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                  $ans_334 = $ques_and_334 == 'none of these' ? ' You have first symptoms' : "You first noticed <strong>".$ques_and_334."</strong>";

                  if(isset($ans_335) && !empty($ans_335)){

                    $layman_summar .= $ans_334.' '.$ans_335;
                  }

                  break;

                case 372:

                  if(isset($ans_334) && !empty($ans_334)){

                    $ans_334 = str_replace("other", strtolower($singlelevel['answer']), $ans_334);
                  }

                  break;

              case 335:

                  $ans_335 = "<strong>".strtolower($singlelevel['answer'])."</strong> ago that led you to get checked.<br />";
                  if(isset($ans_334) && !empty($ans_334)){

                    $layman_summar .= $ans_334.' '.$ans_335;
                  }

                  break;

              case 336:

                if($singlelevel['answer'] == 'Yes'){

                  $layman_summar .= 'You found the first breast lump';

                  if(isset($cancer_history_detail[$k+1]) && !empty($cancer_history_detail[$k+1]) && $cancer_history_detail[$k+1]['question_id'] == 337){

                    $layman_summar .= ' <strong>'.strtolower($cancer_history_detail[$k+1]['answer']).' ago</strong>';
                  }

                  if(isset($cancer_history_detail[$k+2]) && !empty($cancer_history_detail[$k+2]) && $cancer_history_detail[$k+2]['question_id'] == 338){

                    $layman_summar .= ' in a <strong>'.strtolower($cancer_history_detail[$k+2]['answer']).'</strong>';
                  }

                  $layman_summar .= '.<br>';
                }
                else{

                  $layman_summar .= "<strong>You haven't found breast lumps</strong>.<br />";
                }

                 break;

              case 339:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? "You have experienced breast swelling or dimpling, also known as peau d'orange.<br />" : "You haven't experienced breast swelling or dimpling, also known as peau d'orange.<br />" ;

                 break;

              case 340:

                $que_ans_340 = strtolower($singlelevel['answer']);
                $layman_summar .= $que_ans_340 == 'neither' ? "<strong>You haven't noticed symptoms or lump</strong>.<br/>" : 'You have noticed symptoms or lump in <strong>'.$que_ans_340.'</strong>.<br/>';
                 break;

              case 341:
                $que_ans_341 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                $layman_summar .= $que_ans_341 == 'dont know' ? "<strong>You didn't know about how your cancer was diagnosed</strong>.<br>" : 'Your cancer was officially diagnosed when <strong>'.$que_ans_341.'</strong>.<br>';
                 break;

               case 342:

                 if($singlelevel['answer'] == 'Yes'){

                    if(isset($cancer_history_detail[$k+1]) && !empty($cancer_history_detail[$k+1]) && $cancer_history_detail[$k+1]['question_id'] == 343){

                      $ques_ans_343 = strtolower(is_array($cancer_history_detail[$k+1]['answer']) ? implode(", ", $cancer_history_detail[$k+1]['answer']) : $cancer_history_detail[$k+1]['answer']);

                      if($ques_ans_343 == "not sure"){

                          $layman_summar .= 'You have started treatments like surgery, chemo or radiation but not sure which treatment you have started. <br>';
                      }
                      else{

                        $layman_summar .= 'You have started <strong>'.$ques_ans_343.'</strong> treatments. <br>';
                      }
                    }
                    else{

                      $layman_summar .= 'You have started treatments like surgery, chemo or radiation.<br>';
                    }
                 }
                 else{

                    $layman_summar .= "You haven't started any treatments like surgery, chemo or radiation.<br />" ;

                 }
                 break;
            }
        }

      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}


public function prepare_cancer_medical_layman($cancer_medical_detail,$cancer_family_members, $cancer_family_members_disease_detail,$step_id)
{
  //pr($cancer_family_members_disease_detail); die;
  $layman_summar = '' ;
  $negative_symptom = '';
  $positive_symptoms = '';
  $estrogen_treatments = '';
  $positive_pmh_oncology_question = '';
  $negative_pmh_oncology_question = '';
  $negative_pmh_internal_question = '';
  $negative_pmh_psychiatry_question = '';
  $internal_medicine_question = '';
  $family_members_trans = array(

    'mother' => 'Mother',
    'father' => 'Father',
    'sister' =>'Sister',
    'brother' => 'Brother',
    'maternal cousin' => "Cousin(mom's side)",
    'paternal cousin' => "Cousin(dad's side)",
    'maternal GM' => "Grandmother(mom's side)",
    'paternal GM' => "Grandmother(dad's side)",
    'maternal GF' => "Grandfather(mom's side)",
    'paternal GF' => "Grandfather(dad's side)",
    'maternal aunt' => "Aunt(mom's side)",
    'paternal aunt' => "Aunt(dad's side)",
    'maternal uncle' => "Uncle(mom's side)",
    'paternal uncle' => "Uncle(dad's side)",

  );
  // pr($cancer_medical_detail);
  // pr($cancer_family_members);
  // die;
  if(!empty($cancer_medical_detail) && is_array($cancer_medical_detail)){
    //pr($cancer_medical_detail);

     $layman_summar .= "<br /><strong>You provided following medical details:</strong><br />";      
      foreach ($cancer_medical_detail as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
              case 344:

                if($singlelevel['answer'] == 'Yes'){

                  $layman_summar .= 'You had removed';

                  if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 345){

                    $layman_summar .= ' your <strong>'.strtolower($cancer_medical_detail[$k+1]['answer']).'</strong>';
                  }
                  else{

                    $layman_summar .= ' your ovaries';
                  }

                  if(isset($cancer_medical_detail[$k+2]) && !empty($cancer_medical_detail[$k+2]) && $cancer_medical_detail[$k+2]['question_id'] == 346){

                    $layman_summar .= ' in <strong>'.strtolower($cancer_medical_detail[$k+2]['answer']).'</strong>';
                  }

                  $layman_summar .= '.<br>';
                }else if($singlelevel['answer'] == 'No'){
                  $layman_summar .= "You have not removed your ovaries (oopherectomy).<br />" ;
                }else{
                  $layman_summar .= "You had not remember when your ovaries removed (oopherectomy).<br />" ;
                }
                 break;
             case 347:

                  if($singlelevel['answer'] == 'Yes'){

                    $layman_summar .= 'You have not removed your uterus (hysterectomy)';

                    if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 348){

                      $layman_summar .= ' in <strong>'.strtolower($cancer_medical_detail[$k+1]['answer']).'</strong>';
                    }

                    $layman_summar .= '.<br />';
                  }
                  else{

                    $layman_summar .= "You have not removed your uterus (hysterectomy).<br />" ;
                  }

                 break;

              case 349:

                if($singlelevel['answer'] == 'Yes'){

                  $layman_summar .= 'Currently you are smoking';
                  if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 350){

                      $layman_summar .= ' <strong>'.($cancer_medical_detail[$k+1]['answer'] == 'morethan10' ? 'more than 10' : $cancer_medical_detail[$k+1]['answer']).' packs</strong> per week';
                  }

                    $layman_summar .= '.<br />';
                }
                else{

                  $layman_summar .= "You do not smoke.<br />";
                }

                 break;

              case 351:


                if($singlelevel['answer'] == 'Yes'){

                  $layman_summar .= 'Currently you are drinking';
                  if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 352){

                      $layman_summar .= ' <strong>'.($cancer_medical_detail[$k+1]['answer'] == 'morethan10' ? 'more than 14' : $cancer_medical_detail[$k+1]['answer']).' drinks</strong> per week';
                  }

                    $layman_summar .= '.<br />';
                }
                else{

                  $layman_summar .= "You do not drink alcohol.<br />";
                }
                 break;

               case 353:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have traveled domestically in the last 30 days.<br />' : "You haven't traveled domestically in the last 30 days.<br />" ;
                 break;

               case 354:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have traveled internationally in the last 30 days.<br />' : "You haven't traveled internationally in the last 30 days.<br />" ;
                 break;

               case 355:

                if($singlelevel['answer'] == 'Yes'){
                    $members_name = '';
                    if(isset($cancer_family_members[$singlelevel['question_id']]) && is_array($cancer_family_members[$singlelevel['question_id']]) ){

                        foreach ($cancer_family_members[$singlelevel['question_id']] as $fkey => $fvalue) {

                            $members_name = (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue);

                            if(!empty($cancer_family_members_disease_detail) && isset($cancer_family_members_disease_detail[$fvalue]) && isset($cancer_family_members_disease_detail[$fvalue]['disease']) && !empty($cancer_family_members_disease_detail[$fvalue]['disease'])){

                                $cancer_names = strtolower(is_array($cancer_family_members_disease_detail[$fvalue]['disease']) ? implode(", ", $cancer_family_members_disease_detail[$fvalue]['disease']) : $cancer_family_members_disease_detail[$fvalue]['disease']);

                                if(isset($cancer_family_members_disease_detail[$fvalue]['other']) && !empty($cancer_family_members_disease_detail[$fvalue]['other'])){

                                  $cancer_names = str_replace("other", strtolower($cancer_family_members_disease_detail[$fvalue]['other']), $cancer_names);
                                }

                                $positive_symptoms .= ucfirst(strtolower($members_name)).(isset($cancer_family_members_disease_detail[$fvalue]['age']) && !empty($cancer_family_members_disease_detail[$fvalue]['age']) ? " (".$cancer_family_members_disease_detail[$fvalue]['age'].") ": "")." have <strong>".$cancer_names."</strong>.<br/>";
                            }
                        }
                    }


                }
                else{

                  $negative_symptom .= strtolower($singlelevel['question']).', ';
                }
                break;

              case 356:

                $ques_ans_356 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']);
                $positive_symptoms = str_replace("cancer", $ques_ans_356, $positive_symptoms);
                break;

              case 357:

                $ques_ans_357 = strtolower($singlelevel['answer']);
                $positive_symptoms = str_replace("other", $ques_ans_357, $positive_symptoms);
                break;

              case 358:

                /*if($singlelevel['answer'] != ''){
                  $layman_summar .= 'They old were <strong>'.$singlelevel['answer'].'</strong> when they were diagnosed<br/>';
                }*/

                break;

                case 359:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 360:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 361:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;


                case 362:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 363:
                $str = "";
                foreach($singlelevel['answer'] as $k => $v){
                  $str .= $k.'('.strtolower($v).'), ';
                }
                $positive_symptoms = rtrim(trim($str),',')." <b>have diabetes.</b></br>";

                break;

                case 364:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 365:

                  if($singlelevel['answer'] == 'Yes'){

                   $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 366:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 367:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 368:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 369:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 370:

                  if($singlelevel['answer'] == 'Yes'){

                    $members_name = '';
                    if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                        foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                            $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                        }
                    }

                    $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                  }else{

                    $negative_symptom .= strtolower($singlelevel['question']).', ';
                  }
                break;

                case 371:

                  $replace_str = trim(strtolower($singlelevel['answer'])).' genetic disorder';
                  $positive_symptoms = str_replace("any genetic disorder", $replace_str, $positive_symptoms);
                  break;

                case 389;
                  $ques_ans_389 = strtolower($singlelevel['answer']);
                  $ans_389 = "You haven't experienced menopause";
                  if($ques_ans_389 == 'yes'){

                      $layman_summar .= "You have experienced menopause";
                      if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 390){

                          $layman_summar .= ' at age <strong>'.$cancer_medical_detail[$k+1]['answer'].'</strong>';
                      }

                      $layman_summar .= '.<br />';
                  }
                  break;

                case 391;

                  if(isset($ques_ans_389) && $ques_ans_389 == 'no'){

                    $layman_summar .= $ans_389 .' '."and <strong>".strtolower($singlelevel['answer'])."</strong> is the main reason for no longer having periods.<br>";
                  }
                  break;

                case 392:

                  $layman_summar .= str_replace("other", strtolower($singlelevel['answer']), $layman_summar);
                  break;

                case 373;
                  $ques_ans_373 = strtolower($singlelevel['answer']);

                  $layman_summar .= $ques_ans_373 == 'no' ? "<strong>You have not taken any estrogen-containing medications</strong>.<br>" : '';
                  break;

                case 375:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;
                case 376:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' for '.$singlelevel['answer']." years<br>";
                  break;

                case 377:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;
                case 378:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;
                case 379:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;
                case 380:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;
                case 381:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;

                case 504:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;

                case 382:
                  $estrogen_treatments .= strtolower($singlelevel['answer']);
                  if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 383){

                      $estrogen_treatments .= ' '.$cancer_medical_detail[$k+1]['answer']." years";
                  }
                  $estrogen_treatments .= '<br>';
                  break;

                case 500:

                  $estrogen_treatments .= strtolower($singlelevel['question']).' '.$singlelevel['answer']." years<br>";
                  break;

                case 501:
                  $estrogen_treatments .= strtolower($singlelevel['answer']);
                  if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 502){

                      $estrogen_treatments .= ' '.$cancer_medical_detail[$k+1]['answer']." years";
                  }
                  $estrogen_treatments .= '<br>';
                  break;

                case 385:

                  $layman_summar .= 'Your last period started on <strong>'.$singlelevel['answer']."</strong>.<br>";
                  break;
                case 386:

                  $layman_summar .= 'Your period flow duration is <strong>'.$singlelevel['answer']." days</strong>.<br>";
                  break;
                case 387:

                  $layman_summar .= 'Your period cycle length is <strong>'.$singlelevel['answer']." days</strong>.<br>";
                  break;

                case 388:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Your period cycles is regular.<br>' : 'Your period cycles is not regular.<br>';
                  break;

                case 456:

                  $singlelevel['answer'] = strtolower($singlelevel['answer']);
                  if($singlelevel['answer'] == 'yes'){

                    $layman_summar .= 'Your family member(s) has been diagnosed with Multiple Endocrine Neoplasia type 2 (MEN2).<br>';
                  }
                  elseif($singlelevel['answer'] == 'no'){

                    $layman_summar .= 'No one in your family member(s) has been diagnosed with Multiple Endocrine Neoplasia type 2 (MEN2).<br>';
                  }
                  elseif($singlelevel['answer'] == 'not sure'){

                    $layman_summar .= 'You are not sure that anyone in your family member(s) has been diagnosed with Multiple Endocrine Neoplasia type 2 (MEN2).<br>';
                  }

                  break;

                case 457:

                  $singlelevel['answer'] = strtolower($singlelevel['answer']);
                  if($singlelevel['answer'] == 'yes'){

                    $layman_summar .= 'Your family member(s) has been diagnosed with medullary thyroid cancer.<br>';
                  }
                  elseif($singlelevel['answer'] == 'no'){

                    $layman_summar .= 'No one in your family member(s) has been diagnosed with medullary thyroid cancer.<br>';
                  }
                  elseif($singlelevel['answer'] == 'not sure'){

                    $layman_summar .= 'You are not sure that anyone in your family member(s) has been diagnosed with medullary thyroid cancer.<br>';
                  }
                  break;

                case 458:
                  $layman_summar .= 'You have been diagnosed with <strong>'.(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])).'</strong>.<br>';
                  break;


                  case 538:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have traveled to any different states (domestic) the last 30 days.<br />' : "You haven't traveled to any different states (domestic) the last 30 days.<br />" ;
                 break;

                 case 539:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have traveled out of the country  (international) the last 30 days.<br />' : "You haven't traveled out of the country  (international) the last 30 days.<br />" ;
                 break;

                 case 540:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You visited a country where Zika is widespread.<br />' : "You didn't visit a country where Zika is widespread.<br />" ;
                 break;

                 case 541:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You visited a country where Ebola is widespread.<br />' : "You didn't visit a country where Ebola is widespread.<br />" ;
                 break;

                 case 542:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You had contact with anyone with confirmed Ebola Virus Disease in the past 30 days.<br />' : "You had not contact with anyone with confirmed Ebola Virus Disease in the past 30 days.<br />" ;
                 break;

                 case 543:

                 $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You had any sexual activity with international travelers in the past 6 months.<br />' : "You have not any sexual activity with international travelers in the past 6 months.<br />" ;
                 break;
                  // PMH Oncology summary
                  case 528:
                  // pr($singlelevel['answer']); die;
                  if($singlelevel['answer'] == 'Yes'){
                    $positive_pmh_oncology_question .= "";
                    
                  }
                  else{

                    $negative_pmh_oncology_question .= "diabetes";
                  }
                  break;
                  case 548:
                        switch ($singlelevel['answer']) {
                          case 'Type 1':
                              $positive_pmh_oncology_question .= "diabetes (type 1)";
                            break;
                            case 'Type 2':
                              $positive_pmh_oncology_question .= "diabetes(type 2)";
                            break;
                          
                          default:
                              $positive_pmh_oncology_question .= "diabetes";
                            break;
                        }
                  break;
                  case 529:
                  switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                              $negative_pmh_internal_question .= ($negative_pmh_internal_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                      case 530:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                              $negative_pmh_internal_question .= ($negative_pmh_internal_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 531:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                              $negative_pmh_internal_question .= ($negative_pmh_internal_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 532:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 533:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 534:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 535:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 536:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 537:
                          switch ($singlelevel['answer']) {
                          case 'Yes':
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                            case 'No':
                              $negative_pmh_oncology_question .= ($negative_pmh_oncology_question ? ", " :'').lcfirst($singlelevel['question']);
                            break;
                          
                          default:
                              
                            break;
                        }
                        break;
                        case 562:
                            $internal_medicine_question .= "You drink about ".$singlelevel['answer']." cups of water each day.</br>";
                        break;
                        case 563:
                            $drink_item = '';
                            //pr($singlelevel['answer']['time']);die;
                            if(!empty($singlelevel['answer']['time']))
                            { 
                              $count_item = count($singlelevel['answer']['time']);
                              $i = 1;
                              foreach($singlelevel['answer']['time'] as $k => $v)
                              {
                                $drink_item .= " ".$k." ".$v;
                                if($i < $count_item)
                                $drink_item .= ", ";
                                $i++;
                              }
                              $internal_medicine_question .= "You drink ".$drink_item.".</br>";
                            }                            
                        break;
                        case 564:
                            $internal_medicine_question .= $singlelevel['answer'] == "No" ? "Denied current smoking.</br>" :'';
                        break;
                        case 565:
                            $internal_medicine_question .= "Current smoking <strong>".strtolower(implode(", ",$singlelevel['answer'])).'.</strong></br>';  
                        case 566:
                          $internal_medicine_question .= $singlelevel['answer'] == "No" ? "Denied past smoking.</br>" :'You have smoked in past.</br>';                          
                        break;
                        case 567:
                            $internal_medicine_question .= "Past smoking <strong>".strtolower(implode(", ",$singlelevel['answer'])).'.</strong></br>';                            
                        break;
                        case 616:
                        if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'You have ';                         
                        }
                        else{

                          $layman_summar .= "You have not stayed at psychiatric hospital.<br />";
                        }
                        break;
                        case 617:
                          $layman_summar .= $singlelevel['answer']." times stayed at psychiatric hospital" ;                        

                            $layman_summar .= '.<br />';
                        break;
                        case 618:
                        if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'Currently you are smoking.';                         

                            $layman_summar .= '<br />';
                        }
                        else{

                          $layman_summar .= "You do not currently smoking.<br />";
                        }
                        break;
                        case 619:
                        if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'Currently you are stopped smoking.';                         

                            $layman_summar .= '.<br />';
                        }
                        else{

                          $layman_summar .= "You do not currently stopped smoking.<br />";
                        }
                        break;
                        case 681:
                        if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'Currently you are drink alcohol.';                         

                            $layman_summar .= '.<br />';
                        }
                        else{

                          $layman_summar .= "You do not currently drink alcohol.<br />";
                        }
                        break;
                        case 682:
                        if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'You are drink alcohol in the past.';                         

                            $layman_summar .= '<br />';
                        }
                        else{

                          $layman_summar .= "You do not drink alcohol in the past.<br />";
                        }
                        break;
                        case 620:
                        if(!in_array('None',$singlelevel['answer']))
                        {
                          $singlelevel_ans = array();
                          $singlelevel_ans = $singlelevel['answer'];
                          if(in_array('Other',$singlelevel['answer']))
                          {
                            $singlelevel_ans = array_diff($singlelevel_ans,['Other']);
                          }
                          $layman_summar .= 'You have use the following street drugs in the past 30 days '.strtolower(implode(", ",$singlelevel_ans));                         
                            if(!in_array('Other',$singlelevel['answer']))
                            {
                              $layman_summar .= '.<br />';
                            }
                            
                        }else
                        {
                          $layman_summar .= "You have not use any of the street drugs in the past 30 days.<br />";
                        }
                        break;
                        case 679:
                          $layman_summar .= ' and '.strtolower($singlelevel['answer']);                        

                            $layman_summar .= '.<br />';
                        break;
                        case 621:
                        if(!in_array('None',$singlelevel['answer']))
                        {
                          $singlelevel_ans = array();
                          $singlelevel_ans = $singlelevel['answer'];
                          if(in_array('Other',$singlelevel['answer']))
                          {
                            $singlelevel_ans = array_diff($singlelevel_ans,['Other']);
                          }
                          $layman_summar .= 'You have used these following before '.strtolower(implode(", ",$singlelevel_ans));                         
                            if(!in_array('Other',$singlelevel['answer']))
                            {
                              $layman_summar .= '.<br />';
                            }
                            
                        }else
                        {
                          $layman_summar .= "You have not used any of the before.<br />";
                        }
                        break;
                        case 680:
                          $layman_summar .= ' and '.strtolower($singlelevel['answer']);                        

                            $layman_summar .= '.<br />';
                        break;
                        case 622:
                          $layman_summar .= 'Your marital status is '.strtolower($singlelevel['answer']);                        

                            $layman_summar .= '.<br />';
                        break;
                        case 623:
                        if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'You have ';
                        }
                        else{

                          $layman_summar .= "You have not any children.<br />";
                        }
                        break;
                        case 624:
                          $layman_summar .= strtolower($singlelevel['answer'])." children";                        

                            $layman_summar .= '.<br />';
                        break;
                        case 625:
                          $layman_summar .= strtolower($singlelevel['answer'])." highest grade level you passed";                        

                            $layman_summar .= '.<br />';
                        break;
                        case 626:
                        $question_626 = array(
                          "1" => "Mostly A's",
                          "2" => "Mostly B's",
                          "3" => "Mostly C's",
                          "4" => "Mostly D's",
                          "5" => "Mostly F's",
                          );
                          $layman_summar .= "Your grades like is ".$question_626[$singlelevel['answer']];                     

                            $layman_summar .= '.<br />';
                        break;
                        case 627:
                        if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'You were in special education when you were in school.';                         

                            $layman_summar .= '<br />';
                        }
                        else{

                          $layman_summar .= "You were not in special education when you were in school.<br />";
                        }
                        break;
                        case 628:
                        if(!in_array('None',$singlelevel['answer']))
                        {
                          $layman_summar .= 'You have ever had or been to '.strtolower(implode(", ",$singlelevel['answer']));                         
                              $layman_summar .= '.<br />';
                            
                        }
                        break;
                        case 629:
                          $layman_summar .= 'You have been used DWI '.strtolower($singlelevel['answer']).' time';                       

                            $layman_summar .= '.<br />';
                        break;
                        case 631:
                          if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'You have ever been a victim of physical abuse.';                         

                            $layman_summar .= '<br />';
                        }
                        else{

                          $layman_summar .= "You have not ever been a victim of physical abuse .<br />";
                        }
                        break;
                        case 632:
                          if($singlelevel['answer'] == 'Yes'){

                          $layman_summar .= 'You have ever been a victim of sexual abuse.';                         

                            $layman_summar .= '<br />';
                        }
                        else{

                          $layman_summar .= "You have not ever been a victim of sexual abuse .<br />";
                        }
                        break;
                        case 639:
                        $question_639 = array(
                          "1" => "Honorable discharge",
                          "2" => "Bad conduct discharge",
                          "3" => "Dishonorable discharge",
                          "4" => "Separation (entry level medical)"
                          );
                          $layman_summar .= 'Your discharge status is '.strtolower($question_639[$singlelevel['answer']]);                       

                            $layman_summar .= '.<br />';
                        break;
                        case 683:
                              $positive_pmh_oncology_question .= ($positive_pmh_oncology_question ? ", " :'').strtolower(implode(", ",$singlelevel['answer']));
                               $CommonQuestions = TableRegistry::get('common_questions');
                              $quest_683 = $CommonQuestions->find('all')->where(['id' => 683])->first();
                              $array_diff_option = array_diff(unserialize($quest_683->options),$singlelevel['answer']);
                              $none_of_these_opt = array('Other','None of these');
                              $array_diff_option = array_diff($array_diff_option,$none_of_these_opt);
                              $negative_pmh_psychiatry_question .= strtolower(implode(", ",$array_diff_option));
                        break;
                        case 685:

                        if($singlelevel['answer'] == 'Yes'){

                          $members_name = '';
                          if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                              foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                                  $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                              }
                          }

                          $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                        }else{

                          $negative_symptom .= strtolower($singlelevel['question']).', ';
                        }
                        break;
                        case 686:

                        if($singlelevel['answer'] == 'Yes'){

                          $members_name = '';
                          if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                              foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                                  $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                              }
                          }

                          $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                        }else{

                          $negative_symptom .= strtolower($singlelevel['question']).', ';
                        }
                        break;
                        case 687:

                        if($singlelevel['answer'] == 'Yes'){

                          $members_name = '';
                          if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                              foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                                  $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                              }
                          }

                          $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                        }else{

                          $negative_symptom .= strtolower($singlelevel['question']).', ';
                        }
                        break;
                        case 688:

                        if($singlelevel['answer'] == 'Yes'){

                          $members_name = '';
                          if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                              foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                                  $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                              }
                          }

                          $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                        }else{

                          $negative_symptom .= strtolower($singlelevel['question']).', ';
                        }
                        break;
                        case 689:

                        if($singlelevel['answer'] == 'Yes'){

                          $members_name = '';
                          if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                              foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                                  $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                              }
                          }

                          $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                        }else{

                          $negative_symptom .= strtolower($singlelevel['question']).', ';
                        }
                        break;
                        case 690:

                        if($singlelevel['answer'] == 'Yes'){

                          $members_name = '';
                          if(isset($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) && is_array($cancer_family_members[$cancer_medical_detail[$k]['question_id']]) ){

                              foreach ($cancer_family_members[$cancer_medical_detail[$k]['question_id']] as $fkey => $fvalue) {

                                  $members_name .= (isset($family_members_trans[$fvalue]) ? $family_members_trans[$fvalue] : $fvalue).', ';
                              }
                          }

                          $positive_symptoms .= ucfirst(rtrim(strtolower($members_name),', '))." have <strong>".strtolower($singlelevel['question'])."</strong>.<br/>";

                        }else{

                          $negative_symptom .= strtolower($singlelevel['question']).', ';
                        }
                        break;

                  // End PMH Oncology
            }
        }
        $layman_summar .= '<br />';
        if(!empty($internal_medicine_question)){

          $layman_summar .= $internal_medicine_question;
        }
        if(!empty($positive_symptoms)){

          $layman_summar .= "<br /><strong>Your family members have the following diagnoses:</strong><br />";
          $layman_summar .= $positive_symptoms;
        }
        // Show PMH HIstory
        $layman_summar .= '<br />';
        if(!empty($positive_pmh_oncology_question)){

          // $layman_summar .= "<br /><strong>Your family members have the following diagnoses:</strong><br />";
          $layman_summar .= "Your personal history have diagnosed with <strong>".$positive_pmh_oncology_question.'</strong>.' ;
        }
        $layman_summar .= '<br />';
        if(!empty($negative_pmh_oncology_question) && $step_id != 25 && $step_id != 26 ){

          // $layman_summar .= "<br /><strong>Your family members have the following diagnoses:</strong><br />";
          $layman_summar .= "<br />You do not have the following in your personal history ".$negative_pmh_oncology_question.'.';
        }
        if(!empty($negative_pmh_internal_question) && $step_id == 25){
          
          // $layman_summar .= "<br /><strong>Your family members have the following diagnoses:</strong><br />";
          $layman_summar .= "<br />You do not have the following in your personal history ".$negative_pmh_internal_question.'.';
        }
        if(!empty($negative_pmh_psychiatry_question) && $step_id == 26){
          
          // $layman_summar .= "<br /><strong>Your family members have the following diagnoses:</strong><br />";
          $layman_summar .= "<br />You do not have the following in your personal history ".$negative_pmh_psychiatry_question.'.';
        }
        // End
        $layman_summar .= '<br />';
        /*$negative_symptom = rtrim($negative_symptom,', ');
        if(!empty($negative_symptom)){

          $layman_summar .= "Your family members haven't <strong>".$negative_symptom.'</strong>.<br>';
        }
        $layman_summar .= '<br />';     */
        if(!empty($estrogen_treatments)){

          $layman_summar .= "<br /><strong>You have taken the following estrogen treatments:</strong><br />";
          $layman_summar .= $estrogen_treatments;
        }

      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}
public function general_internal_medicine_assessment($general_assessment)
{
  //pr($general_assessment);
  $layman_summar = '';
  $layman_summar .= "<br /><strong>You provided following general assessment details:</strong><br />";   
      if(!empty($general_assessment))
      {   
        foreach ($general_assessment as $k => $singlelevel) {

              switch ($singlelevel['question_id'])
              {
                case 568:
                    $layman_summar .= 'You would rate your overall energy level as '.strtolower($singlelevel['answer']).".</br>";
                
                   break;
               case 569:
                    $layman_summar .= 'You feel '.$singlelevel['answer']." years older than you are.</br>";

                   break;
               case 570:
                    $layman_summar .= 'You feel '.$singlelevel['answer']." years younger than you are.</br>";

                  break;
               case 607:
                    $layman_summar .= $singlelevel['answer'] == "About my age" ? 'You feel about your age.</br>':'';

                   break;

                 }
               }
        }
        return (array('layman_summar' => $layman_summar));
}
public function taps1_internal_medicine_assessment($taps1_assessment)
{
  $layman_summar = '';
  $layman_summar .= "<br /><strong>You provided following TAPS1 assessment details in the PAST 12 MONTHS:</strong><br />";
  //pr($taps1_assessment);die;
  if(!empty($taps1_assessment))
      {   
        foreach ($taps1_assessment as $k => $singlelevel) {

              switch ($singlelevel['question_id'])
              {
                case 571:
                    $layman_summar .= 'You have used '.strtolower($singlelevel['answer']).' tobacco product (For example cigarettes, e-cigarettes, cigars, pipes or smokeless tobacco).</br>';
                
                   break;
               case 572:
                    $layman_summar .= 'You have '.strtolower($singlelevel['answer']).' had 5 or more drinks containing alcohol in one day.</br>';

                   break;
                 case 573:
                    $layman_summar .= 'You have '.strtolower($singlelevel['answer']).' had 4 or more drinks containing alcohol in one day.</br>';

                   break;
                 case 574:
                    $layman_summar .= 'You have used '.strtolower($singlelevel['answer']).'  any drugs including marijuana, cocaine, or crack, heroin, methamphetamine (crystal meth), hallucinogens, ecstasy/MDMA.</br>';

                   break;
                 case 575:
                    $layman_summar .= 'You have used '.strtolower($singlelevel['answer']).' any prescription medications just for the feeling, more than prescribed or that were not prescribed for you.</br>';

                   break;
                 }
               }
        }
  return (array('layman_summar' => $layman_summar));
}
public function taps2_internal_medicine_assessment($taps2_assessment)
{
  //pr($taps2_assessment);
  $layman_summar = '';
  $layman_summar .= "<br /><strong>You provided following TAPS2 assessment details in the PAST 3 MONTHS:</strong><br />";
  if(!empty($taps2_assessment))
      {   
        foreach ($taps2_assessment as $k => $singlelevel) {

              switch ($singlelevel['question_id'])
              {
                case 576:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? '' :"You didn't smoke a cigarette containing tobacco.</br>";
                
                   break;
               case 577:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You usually smoke more than 10 cigarettes containing tobacco each day.</br>' :"You didn't usually smoke more than 10 cigarettes containing tobacco each day.</br>";

                   break;
              case 578:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You usually smoke within 30 minutes after waking.</br>' :"You didn't usually smoke within 30 minutes after waking.</br>";

                  break;
              case 579:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You had drunk containing alcohol.</br>' :"You hadn't drunk containing alcohol.</br>";

                  break;
              case 580:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You had 4 or more drinks containing alcohol in a day.</br>' :"You hadn't 4 or more drinks containing alcohol in a day.</br>";

                  break;
              case 581:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You had 5 or more drinks containing alcohol in a day.</br>' :"You hadn't 5 or more drinks containing alcohol in a day.</br>";

                  break;
              case 582:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You had tried and failed to control, cut down or stop drinking.</br>' :"You hadn't tried and failed to control, cut down or stop drinking.</br>";

                  break;
              case 583:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Anyone has expressed concern about your drinking.</br>' :"Anyone hasn't expressed concern about your drinking.</br>";

                  break;
              case 584:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used marijuana (hash, weed).</br>' :"You didn't used marijuana (hash, weed).</br>";

                  break;
              case 585:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have had a strong desire or urge to use marijuana at least once a week or more often.</br>' :"You haven,t had a strong desire or urge to use marijuana at least once a week or more often.</br>";

                  break;
              case 586:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Anyone has expressed concern about your use of marijuana.</br>' :"Anyone hasn't expressed concern about your use of marijuana.</br>";

                  break;
              case 587:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used cocaine, crack, or methamphetamine (crystal meth).</br>' :"You didn't used cocaine, crack, or methamphetamine (crystal meth).</br>";

                  break;
              case 588:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used cocaine, crack, or methamphetamine (crystal meth) at least once a week or more often.</br>' :"You didn't used cocaine, crack, or methamphetamine (crystal meth) at least once a week or more often.</br>";

                  break;
              case 589:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Anyone has expressed concern about your use of cocaine, crack, or methamphetamine (crystal meth).</br>' :"Anyone hasn't expressed concern about your use of cocaine, crack, or methamphetamine (crystal meth).</br>";

                  break;
              case 590:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used heroin.</br>' :"You didn't used heroin.</br>";

                  break;
              case 591:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have tried and failed to control, cut down or stop using heroin.</br>' :"You haven't tried and failed to control, cut down or stop using heroin.</br>";

                  break;
              case 592:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Anyone has expressed concern about your use of heroin.</br>' :"Anyone hasn't expressed concern about your use of heroin.</br>";

                  break;
              case 593:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used a prescription opiate pain reliever (for example, Percocet, Vicodin) not as prescribed or that was not prescribed for you.</br>' :"You didn't used a prescription opiate pain reliever (for example, Percocet, Vicodin) not as prescribed or that was not prescribed for you.</br>";

                  break;
              case 594:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have tried and failed to control, cut down or stop using an opiate pain reliever.</br>' :"You haven't tried and failed to control, cut down or stop using an opiate pain reliever.</br>";

                  break;
              case 595:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Anyone has expressed concern about your use of an opiate pain reliever.</br>' :"Anyone hasn't expressed concern about your use of an opiate pain reliever.</br>";

                  break;
              case 596:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used a medications for anxiety or sleep (for example, Xanax, Ativan, Klonopin) not as prescribed or that was not prescribed for you.</br>' :"You didn't used a medications for anxiety or sleep (for example, Xanax, Ativan, Klonopin) not as prescribed or that was not prescribed for you.</br>";

                  break;
              case 597:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have had a strong desire or urge to use medications for anxiety or sleep at least once a week or more often.</br>' :"You haven't had a strong desire or urge to use medications for anxiety or sleep at least once a week or more often.</br>";

                  break;
              case 598:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Anyone has expressed concern about your use of medications for anxiety or sleep.</br>' :"Anyone hasn't expressed concern about your use of medications for anxiety or sleep.</br>";

                  break;
              case 599:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used a medication for ADHD (for example, Adderall or Ritalin) not as prescribed or that was not prescribed for you.</br>' :"You didn't used a medication for ADHD (for example, Adderall or Ritalin) not as prescribed or that was not prescribed for you.</br>";

                  break;
              case 600:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You used a medication for ADHD (for example, Adderall or Ritalin) at least once a week or more often.</br>' :"You didn't used a medication for ADHD (for example, Adderall or Ritalin) at least once a week or more often.</br>";

                  break;
              case 601:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'Anyone has expressed concern about your use of medications for ADHD (for example, Adderall or Ritalin).</br>' :"Anyone hasn't expressed concern about your use of medications for ADHD (for example, Adderall or Ritalin).</br>";

                  break;
              case 602:
                    $layman_summar .= $singlelevel['answer'] == 'Yes' ? "" :"You didn't used any other illegal or recreational drug (for eaxample ecstasy/molly, GHB, poppers, LSD, mushrooms, special K, bath salts, synthetic marijuana ('spice'), whip-its, etc.).</br>";

                  break;
              case 603:
                    $layman_summar .= "You were used the other drug(s) ".$singlelevel['answer'].".</br>";

                  break;
              }
            }
        }
  return (array('layman_summar' => $layman_summar));
}

public function prepare_cancer_assessments_layman($cancer_assessments)
{

  $layman_summar = '' ;
  if(!empty($cancer_assessments) && is_array($cancer_assessments)){

      if(isset($cancer_assessments['assessment_history']) && is_array($cancer_assessments['assessment_history']) && !empty($cancer_assessments['assessment_history'])){

          $layman_summar .= "<br /><strong>You had the following symptoms in the last 24 hours:</strong><br />";

          foreach ($cancer_assessments['assessment_history'] as $k => $singlelevel) {

              $layman_summar .= 'You rate your '.$singlelevel['name'].' <strong>'.$singlelevel['answer']."/10</strong>.<br>";

          }
          $layman_summar .= '<br />';
      }

      if(isset($cancer_assessments['assessment_history']) && is_array($cancer_assessments['life_assessment']) && !empty($cancer_assessments['life_assessment'])){

        $layman_summar .= "<br /><strong>You rated the following life activities:</strong><br />";

        foreach ($cancer_assessments['life_assessment'] as $k => $singlelevel) {

            $layman_summar .= ucfirst($singlelevel['name']).' rate is <strong>'.$singlelevel['answer'].'</strong>.<br/>';
        }
        $layman_summar .= '<br />';
      }

      if(isset($cancer_assessments['chemo_assessment']) && !empty($cancer_assessments['chemo_assessment']) && is_array($cancer_assessments['chemo_assessment'])){

        $layman_summar .= "<br /><strong>You provided following details for symptoms:</strong><br />";

        foreach ($cancer_assessments['chemo_assessment'] as $k => $singlelevel) {

            $layman_summar .= ucfirst($singlelevel['name']).' rate is <strong>'.$singlelevel['answer'].'</strong>.<br/>';
        }
        $layman_summar .= '<br />';
      }

      if(!empty($cancer_assessments['cancer_covid_question'])){
         $layman_summar .= "<br /><strong>Other medical history questions:</strong><br />";
      foreach ($cancer_assessments['cancer_covid_question'] as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
                 case 544:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You had any recent falls.<br />' : "You have not had any recent falls.<br />" ;

                  break;

                  case 545:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have a fever of 100.5F or have you been prescribed antibiotics in last 2 weeks.<br />' : "You have not had a fever of 100.5F or been prescribed antibiotics in last 2 weeks.<br />" ;

                  break;

                  case 546:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You current have any wounds or rashes.<br />' : "You currently haven't any wounds or rashes.<br />" ;

                  break;

                  case 547:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You currently have any surgical tubes, drains, or ostomy.<br />' : "You currently do not have any surgical tubes, drains, or ostomy.<br />" ;

                  break;

                  case 549:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have been in contact with someone with lab-confirmed COVID-19.<br />' : "You haven't been in contact with someone with lab-confirmed COVID-19.<br />" ;

                  break;
            }
      }
    }

      




      if(isset($cancer_assessments['cancer_covid_question']) && !empty($cancer_assessments['cancer_covid_question']) && is_array($cancer_assessments['cancer_covid_question'])){
        

      }


  }

  return array('layman_summar' => $layman_summar);
}

public function prepare_followup_assessments_layman($cancer_assessments)
{

  $layman_summar = '' ;
  if(!empty($cancer_assessments) && is_array($cancer_assessments)){

      if(isset($cancer_assessments['assessment_history']) && is_array($cancer_assessments['assessment_history'])){

          $layman_summar .= "<br /><strong>You had the following symptoms in the last 24 hours:</strong><br />";

          foreach ($cancer_assessments['assessment_history'] as $k => $singlelevel) {

              $layman_summar .= 'You rate your '.$singlelevel['name'].' <strong>'.$singlelevel['answer']."/10</strong>.<br>";

          }
          $layman_summar .= '<br />';
      }

      if(isset($cancer_assessments['assessment_history']) && is_array($cancer_assessments['life_assessment'])){

        $layman_summar .= "<br /><strong>You rated the following life activities:</strong><br />";

        foreach ($cancer_assessments['life_assessment'] as $k => $singlelevel) {

            $layman_summar .= ucfirst($singlelevel['name']).' rate is <strong>'.$singlelevel['answer'].'</strong>.<br/>';
        }
        $layman_summar .= '<br />';
      }

      if(!empty($cancer_assessments['chemo_assessment']) && is_array($cancer_assessments)){

        $layman_summar .= "<br /><strong>You provided following details for symptoms:</strong><br />";

        foreach ($cancer_assessments['chemo_assessment'] as $k => $singlelevel) {

            $layman_summar .= ucfirst($singlelevel['name']).' rate is <strong>'.$singlelevel['answer'].'</strong>.<br/>';
        }
        $layman_summar .= '<br />';
      }
  }

  return array('layman_summar' => $layman_summar);
}


function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}
public function chronic_pain_assessment_detail_layman($chronic_pain_assessment,$chronic_pain_assessment_pmh)
{      
    $layman_summar = '' ;

    if(!empty($chronic_pain_assessment) && is_array($chronic_pain_assessment)){

      $layman_summar .= "<br /><strong>You provided these details for Chronic pain Assessments:</strong><br />";

      foreach ($chronic_pain_assessment as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
             case 166:

                  $layman_summar .=  "You described the severity of your pain as a <strong>".strtolower($singlelevel['answer'])."</strong>.<br/>" ;
                  break;

             case 167:

                  $layman_summar .=  "Right now you have pain as a <strong>".strtolower($singlelevel['answer'])."</strong>.<br/>" ;
                  break;             
            }          
        }

        $layman_summar .= "<br /><strong>You've been diagnosed with following symptoms:</strong><br />";

        if(!empty($chronic_pain_assessment_pmh)){

            foreach ($chronic_pain_assessment_pmh as $k => $singlelevel) {

                  $layman_summar .= $singlelevel['condition_name']." diagnosed at " .$singlelevel['date']."</strong>.<br/>" ;      
             }
        }


      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}

public function chronic_opioid_overdose_risk_detail_layman($chronic_pain_opioid_overdose_risk)
{  
  $layman_summar = '' ;

    if(!empty($chronic_pain_opioid_overdose_risk) && is_array($chronic_pain_opioid_overdose_risk)){

      $layman_summar .= "<br /><strong>You provided these details for Chronic opioids overdose risk:</strong><br />";

      foreach ($chronic_pain_opioid_overdose_risk as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
               case 183:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You are being prescribed opioids from another healthcare provider.<br />' : "You are not being prescribed opioids from another healthcare provider.<br />" ;

                break; 

                case 184:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You currently switching from one opioid drug to a different opioid drug.<br />' : "You are not currently switching from one opioid drug to a different opioid drug.<br />" ;

                break;

                case 185:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You currently switching the route or the way you take an opioid drug.<br />' : "You are not currently switching the route or the way you take an opioid drug.<br />" ;

                break; 

                case 186:
                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You are using any non-prescribed opoioid medication or opioid-containing drugs (ex: heroin, fentanyl).<br />' : "You are not using any non-prescribed opoioid medication or opioid-containing drugs (ex: heroin, fentanyl).<br />" ;
                break;  

                case 187:
                $layman_summar .= "You are currently taking long-acting opioid as <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br />";
                  break;

               case 188:
                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have recently been released from incarceration with a history of past opioid use or abuse.<br />' : "You haven't recently been released from incarceration with a history of past opioid use or abuse.<br />" ;
                break; 
                

                case 189:
                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You are resumimg opioid therapy after an interruption of opioid treatment.<br />' : "You are not resumimg opioid therapy after an interruption of opioid treatment.<br />" ;
                break; 


                case 190:
                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have a history of substance abuse, dependence, or non-medical use of prescription or illicit opioids.<br />' : "You haven't a history of substance abuse, dependence, or non-medical use of prescription or illicit opioids.<br />" ;
                break;                           
            }          
        }
      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);

}


public function chronic_opioid_risk_tool_detail_layman($chronic_pain_assessment_ort)
{
  // $chronic_pain_assessment_ort = unserialize(Security::decrypt(base64_decode($chronic_pain_assessment_ort) , SEC_KEY));
  //   pr($chronic_pain_assessment_ort); die;
    $layman_summar = '' ;

    if(!empty($chronic_pain_assessment_ort) && is_array($chronic_pain_assessment_ort)){

      $layman_summar .= "<br /><strong>You provided these details for Chronic opioids risk tool:</strong><br />";

      foreach ($chronic_pain_assessment_ort as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
               case 196:

                $layman_summar .= "You have family history of <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br />";
                  break;

                break; 

                case 197:

                $layman_summar .= "You have a personal history of <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br />";
                  break;

                break; 

                case 198:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have ever been a victim of sexual abuse before your teenage years.<br />' : "You haven't ever been a victim of sexual abuse before your teenage years.<br />" ;

                break; 

               case 199:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have ever been diagnosed with attention-deficit disorder (Add), obsessive-compulsive disorder (OCD),
                  bipolar disorder, or schizophrenia.<br />' : "You haven't ever been diagnosed with attention-deficit disorder (Add), obsessive-compulsive disorder (OCD),
                  bipolar disorder, or schizophrenia.<br />" ;
                break; 
                

               case 200:
                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have ever been diagnosed with depression.<br />' : "You haven't ever been diagnosed with depression.<br />" ;
                break;                 

                                         
            }          
        }
      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);

}


public function covid_detail_layman($covid_detail){

  //pr($covid_detail);die;
  $layman_summar = '' ;

  if(!empty($covid_detail) && is_array($covid_detail)){

      $layman_summar .= "<br /><strong>You provided these details for COVID-19:</strong><br />";

      foreach ($covid_detail as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 141:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have traveled from China, Iran, Italy, Japan, or South Korea within 14 days of symptoms starting.<br />' : "You haven't  traveled from China, Iran, Italy, Japan, or South Korea within 14 days of symptoms starting.<br />" ;

                  break;


              case 142:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have had close contact with a laboratory-confirmed COVID-19 patient within 14 days of symptoms starting.<br />' : "You haven't had close contact with a laboratory-confirmed COVID-19 patient within 14 days of symptoms starting.<br />" ;

                  break;

              case 143:


                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have personally traveled to or from washington state, massachusetts, or new york in the last 14 days.<br />' : "You haven't personally traveled to or from washington state, massachusetts, or new york in the last 14 days.<br />" ;

                  break;

              case 145:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You did visit nursing facilities in kirkland, WA or standwood, WA.<br />' : "You didn't visit any nursing facilities in kirkland, WA or standwood, WA.<br />" ;
                  break;

              case 146:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You did visit new rochelle, NY.<br />' : "You didn't visit new rochelle, NY.<br />" ;
                  break;

              case 147:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You did attend the biogen business conference in boston.<br />' : "You didn't attend the biogen business conference in boston.<br />" ;
                  break;

              case 148:


                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have been in close contact with others who traveled to or from washington state, massachusetts, or new york in the last 14 days.<br />' : "You don't have been in close contact with others who traveled to or from washington state, massachusetts, or new york in the last 14 days.<br />" ;
                break;


              case 150:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'They did visit nursing facilities in kirkland, WA or standwood, WA.<br />' : "They didn't visit any nursing facilities in kirkland, WA or standwood, WA.<br />" ;
                  break;

              case 151:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'They did visit new rochelle, NY.<br />' : "They didn't visit new rochelle, NY.<br />" ;
                  break;

              case 152:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'They did attend the biogen business conference in boston.<br />' : "They didn't attend the biogen business conference in boston.<br />" ;
                  break;

              case 153:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have personally been on a grand princess or diamond princess cruise in the last 2 months.<br />' : "You don't have personally been on a grand princess or diamond princess cruise in the last 2 months.<br />" ;
                break;

              case 154:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have been in close contact with anyone who was on a grand princess or diamond princess cruise in the last 2 months.<br />' : "You haven't been in close contact with anyone who was on a grand princess or diamond princess cruise in the last 2 months.<br />" ;
                  break;

              case 155:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You currently smoke or have smoked in the past week.<br />' : "You don't currently smoke or haven't smoked in the past week.<br />" ;
                  break;

               case 156:

               $layman_summar .= "You've been diagnosed for <strong>".(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])."</strong>.<br />";
                  break;

              case 201:

                $temp_ans = '';
                if($singlelevel['answer'] == 'Yes'){

                  $ans_202 = '';
                  if(isset($covid_detail[$k+1]) && $covid_detail[$k+1]['question_id'] == 202){

                    $ans_202 = strtolower(is_array($covid_detail[$k+1]['answer']) ? implode(", ", $covid_detail[$k+1]['answer']) : $covid_detail[$k+1]['answer']);
                    $temp_ans = "You've recently traveled to <strong>".$ans_202.'</strong>.<br />';

                  }

                  if(isset($covid_detail[$k+2]) && $covid_detail[$k+2]['question_id'] == 203){

                      $temp_ans = str_replace("other",$covid_detail[$k+2]['answer'],$temp_ans);
                  }

                  if(empty($temp_ans)){

                    $layman_summar .= '<strong>You recently traveled outside of the United States<strong>.<br />';
                  }
                  else{

                    $layman_summar .= $temp_ans;
                  }
                }
                else{

                  $layman_summar .= "<strong>You haven't recently traveled outside of the United States</strong>.<br />";
                }
                break;

              case 204:

                $temp_ans = '';
                if($singlelevel['answer'] == 'Yes'){

                  $ans_205 = '';
                  if(isset($covid_detail[$k+1]) && $covid_detail[$k+1]['question_id'] == 205){

                    $ans_205 = strtolower(is_array($covid_detail[$k+1]['answer']) ? implode(", ", $covid_detail[$k+1]['answer']) : $covid_detail[$k+1]['answer']);
                    $temp_ans = "You've recently traveled to <strong>".$ans_205.'</strong>.<br />';

                  }

                  if(isset($covid_detail[$k+2]) && $covid_detail[$k+2]['question_id'] == 206){

                      $temp_ans = str_replace("other",$covid_detail[$k+2]['answer'],$temp_ans);
                  }

                  if(empty($temp_ans)){

                    $layman_summar .= '<strong>You recently traveled to states outside of the one you reside in<strong>.<br />';
                  }
                  else{

                    $layman_summar .= $temp_ans;
                  }
                }
                else{

                  $layman_summar .= "<strong>You haven't recently traveled state outside of the one you reside in</strong>.<br />";
                }

                  break;

              case 207:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You have been in contact with someone with lab-confirmed COVID-19</strong>.<br />' : "<strong>You haven't been in contact with someone with lab-confirmed COVID-19</strong>.<br />" ;
                  break;
              case 208:

                $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You are a health care provider or first responder</strong>.<br />' : "<strong>You are not a health care provider or first responder</strong>.<br />" ;
                  break;
              case 209:

                $layman_summar .= "You ".(strtolower($singlelevel['answer']) == 'long term care facility' ? 'live with ': '')."<strong>".strtolower($singlelevel['answer'])."</strong>.<br />";
                break;
            }
          //}
        }
     // }

      $layman_summar .= '<br />';
  }

  //echo $layman_summar;die;
  //die;
  return array('layman_summar' => $layman_summar);
}


public function focuses_history_layman($focusedhistory)
{
 // pr($focusedhistory);die;
  $layman_summar = '' ;

  if(!empty($focusedhistory) && is_array($focusedhistory)){

      $layman_summar .= "<br /><strong>You provided these details for Focused History:</strong><br />";

      foreach ($focusedhistory as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 218:
                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You are pregnant</strong>.<br />' : "<strong>You are not pregnant</strong>.<br />" ;
                  break;
              case 217:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You did vape in the past</strong>.<br />' : "<strong>You didn't vape in the past</strong>.<br />" ;

                  break;
             case 216:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You currently vape</strong>.<br />' : "<strong>You do not currently vape</strong>.<br />" ;

                  break;
             case 215:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You did smoke in the past</strong>.<br />' : "<strong>You didn't smoke in the past</strong>.<br />" ;

                  break;

            case 214:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>You have currently smoke</strong>.<br />' : "<strong>You do not currently smoke</strong>.<br />" ;

                  break;

             case 213:

                $layman_summar .= "You've been diagnosed with <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']))."</strong>.<br />";
                  break;

            case 212:

                $layman_summar .= "Your family members have been diagnosed with <strong>";

                if(is_array($singlelevel['answer']) && !empty($singlelevel['answer'])){

                    foreach ($singlelevel['answer'] as $key => $value) {

                      if($key != 'members'){

                          $layman_summar .= strtolower($value).(isset($singlelevel['answer']['members'][$key]) ? "( ".implode(", ",$singlelevel['answer']['members'][$key])." )" : "").", ";
                      }
                    }
                }
                $layman_summar = rtrim($layman_summar ,", ");
                $layman_summar .= "</strong>.<br />";
                break;

            }
        }
      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}

public function phq_9_detail_layman($phq_9_detail){

  //pr($phq_9_detail);die;
  $layman_summar = '' ;
  $phq_9_options = array(

    '0' => 'Not at all',
    '1' => 'Several days',
    '2' => 'More than half the days',
    '3' => 'Nearly every day'
  );

  if(!empty($phq_9_detail) && is_array($phq_9_detail)){

      foreach ($phq_9_detail as $k => $singlelevel) {

          $layman_summar .= $singlelevel['question'].' : <strong>'.$phq_9_options[$singlelevel['answer']].'</strong>.</br>';
      }
     // }

      $layman_summar .= '<br />';
  }

  //echo $layman_summar;die;
  //die;
  return array('layman_summar' => $layman_summar);
}

//this function is used to check all data is available for telehealth call or not
public function checkTelehealthAppointmentData($provider_id, $org_id, $schedule_data){

  //group_id,provider_id,patient_first_name,patient_last_name,patient_email,patient_contact all these data are required for telehealth appointment
  // pr($schedule_data);
  // die('sff');

  if(!empty($schedule_data) && !empty($schedule_data['last_name']) && !empty($schedule_data['first_name']) && (!empty($schedule_data['email']) || !empty($schedule_data['phone'])))
  {
    $userTlb = TableRegistry::get('Users');
    $orgTbl = TableRegistry::get('Organizations');
    $user_data = $userTlb->find('all')->where(['id' => $provider_id])->first();
    $org_data = $orgTbl->find('all')->where(['id' => $org_id])->first();
    if(!empty($org_data) && !empty($org_data['cl_group_id']) && !empty($user_data) && !empty($user_data['cl_provider_id']) && $user_data['is_telehealth_provider'] == 1){

        return 1;
    }
  }

  return 0;
}

public function chronic_cad_layman($chronic_cad, $medication_detail)
{

  $layman_summar = '' ;
  $last_new_line = '';

  if(!empty($chronic_cad) || !empty($medication_detail)){

    $layman_summar .= "<br /><strong>You provided these details for Chronic Coronary artery disease:</strong><br />";
    $last_new_line = '<br />';
  }

  if(!empty($chronic_cad) && is_array($chronic_cad)){



      foreach ($chronic_cad as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 234:

                  $layman_summar .=  "You described your condition as <strong>".strtolower($singlelevel['answer'])."</strong> since your last clinic visit.<br/>" ;
                  break;
            }
        }
  }

  if(!empty($medication_detail) && is_array($medication_detail)){

      $layman_summar .= '<strong>Medication Details:</strong></br>';

      foreach ($medication_detail as $med_key => $med_val) {

          $layman_summar .= $med_val['medication_name_name'].(!empty($med_val['medication_dose']) ? " | ".$med_val['medication_dose'].' dose' : "").(!empty($med_val['medication_how_often']) ? " | ".$med_val['medication_how_often'] : "").(!empty($med_val['medication_how_taken']) ? " | ".$med_val['medication_how_taken'] : "")."<br>";
      }
  }

  $layman_summar .= $last_new_line;
  return array('layman_summar' => $layman_summar);
}


public function chronic_chf_layman($chronic_chf, $medication_detail)
{

  $layman_summar = '' ;
  $last_new_line = '';

  if(!empty($chronic_chf) || !empty($medication_detail)){

    $layman_summar .= "<br /><strong>You provided these details for Chronic Congestive heart failure:</strong><br />";
    $last_new_line = '<br />';
  }

  if(!empty($chronic_chf) && is_array($chronic_chf)){

      foreach ($chronic_chf as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 234:

                  $layman_summar .=  "You described your condition as <strong>".strtolower($singlelevel['answer'])."</strong> since your last clinic visit.<br/>" ;
                  break;
            }
        }
  }

  if(!empty($medication_detail) && is_array($medication_detail)){

      $layman_summar .= '<strong>Medication Details:</strong></br>';

      foreach ($medication_detail as $med_key => $med_val) {

          $layman_summar .= $med_val['medication_name_name'].(!empty($med_val['medication_dose']) ? " | ".$med_val['medication_dose'].' dose' : "").(!empty($med_val['medication_how_often']) ? " | ".$med_val['medication_how_often'] : "").(!empty($med_val['medication_how_taken']) ? " | ".$med_val['medication_how_taken'] : "")."<br>";
      }
  }

  $layman_summar .= $last_new_line;
  return array('layman_summar' => $layman_summar);
}



public function chronic_copd_layman($chronic_copd)
{

  $layman_summar = '' ;
  $last_new_line = '';

  if(!empty($chronic_copd) && is_array($chronic_copd)){

      $layman_summar .= "<br /><strong>You provided these details for Chronic obstructive pulmonary disease:</strong><br />";
      $last_new_line = '<br />';

      foreach ($chronic_copd as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 234:
                  $layman_summar .=  "You described your condition as <strong>".strtolower($singlelevel['answer'])."</strong> since your last clinic visit.<br/>" ;
                  break;

              case 289:

                  $layman_summar .=  "You have managed your COPD condition with <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']))."</strong>.<br/>" ;
                  if(is_array($singlelevel['answer']) && in_array("Medication", $singlelevel['answer']) && isset($chronic_copd[$k+1]) && !empty($chronic_copd[$k+1]) && $chronic_copd[$k+1]['question_id'] == 290){

                    $ques_ans_290 = strtolower(is_array($chronic_copd[$k+1]['answer']) ? implode(", ", $chronic_copd[$k+1]['answer']) : $chronic_copd[$k+1]['answer']);
                    $layman_summar = str_replace("medication", $ques_ans_290, $layman_summar);
                  }
                  break;
              case 291:
                $layman_summar = str_replace("other", $singlelevel['answer'], $layman_summar);
                break;

              case 265:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'no' ? "You do not have any recorded oxygen reading (SpO2) to provide.<br/>" : '';
                  break;

              case 266:
                  $layman_summar .=  "Your oxygen reading (SpO2) is <strong>".$singlelevel['answer']."</strong>.<br/>";
                  break;

              case 267:
                  $layman_summar .=  "You describe your COPD symptoms as <strong>".strtolower($singlelevel['answer'])."</strong>.<br/>";
                  break;

              case 268:
                  $layman_summar .=  "You have been diagnosed with <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']))."</strong>.<br/>";
                  break;

              case 269:
                  $layman_summar .=  "Your family members have been diagnosed with <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']))."</strong>.<br/>";
                  break;

              case 270:

                  if(strtolower($singlelevel['answer']) == 'yes'){

                    if(isset($chronic_copd[$k+1]) && $chronic_copd[$k+1]['question_id'] == 271 && !empty($chronic_copd[$k+1]['answer'])){

                      $layman_summar .= "Currently you are smoking <strong>" .$chronic_copd[$k+1]['answer']. " packs</strong> per day.<br />" ;
                    }
                    else{

                      $layman_summar .= 'Currently you are smoking.<br />';
                    }
                  }
                  else{

                    $layman_summar .= "Currently you do not smoke.<br />";
                  }

                  break;

              case 272:
                  $layman_summar .=  "You have been smoking for <strong>".$singlelevel['answer']." years</strong>.<br/>";
                  break;

              case 273:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>You would like to talk to your doctor about quitting smoking</strong>.<br/>" : "<strong>You would not like to talk to your doctor about quitting smoking</strong>.<br/>" ;
                  break;

              case 277:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'none' ? "<strong>Your current symptoms do not affect your quality of life</strong>.<br/>" : "Your current symptoms affect your quality of life <strong>".strtolower($singlelevel['answer'])."</strong>.</br/>" ;
                  break;

              case 278:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "You had ".(isset($chronic_copd[$k+1]) ? "<strong>".$chronic_copd[$k+1]['answer'].' </strong>' : '')."COPD attacks (exacerbations) in the past 12 months.<br/>" : "<strong>You have not had any COPD attacks (exacerbations) in the past 12 months</strong>.<br/>";
                  break;

              case 280:

                $ques_ans_280 = strtolower($singlelevel['answer']);
                if($ques_ans_280 == 'yes' ){

                  $layman_summar .= "COPD attacks improve with your regular inhaler dose.<br/>" ;
                }
                elseif($ques_ans_280 == "i don't have an inhaler"){

                  $layman_summar .= "You have an inhaler for COPD attacks.<br/>";
                }
                else{

                   $layman_summar .= "COPD attacks does not improve with your regular inhaler dose.<br/>" ;
                }
                 // $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>COPD attacks improve with your regular inhaler dose</strong>.<br/>" : "<strong>COPD attacks does not improve with your regular inhaler dose</strong>.<br/>" ;
                  break;

              case 281:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "You have try using your inhaler(s) more than instructed.<br/>" : "You do not try using your inhaler(s) more than instructed.<br/>" ;
                  break;

              case 282:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "Your symptoms improve with the higher dose or extra uses of your inhaler.<br/>" : "Your symptoms does not improve with the higher dose or extra uses of your inhaler.<br/>" ;
                  break;

              case 283:

                $ques_ans_283 = strtolower($singlelevel['answer']);
                if($ques_ans_283 == 'yes' ){

                  $layman_summar .= "You were prescribed antibiotics for your COPD attacks.<br/>";
                }
                elseif($ques_ans_283 == "i don't know"){

                  $layman_summar .= "You have not sure you were prescribed antibiotics for your COPD attacks.<br/>";
                }
                else{

                   $layman_summar .= "You have not been prescribed antibiotics for your COPD attacks.<br/>";
                }
                  //$layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>You have prescribed antibiotics for your COPD attacks</strong>.<br/>" : "<strong>You have not prescribed antibiotics for your COPD attacks</strong>.<br/>" ;
                  break;

              case 284:

                $ques_ans_284 = strtolower($singlelevel['answer']);
                if($ques_ans_284 == 'yes' ){

                  $layman_summar .= "<strong>You were prescribed oral steroid tablets for your COPD attacks</strong>.<br/>";
                }
                elseif($ques_ans_284 == "i don't know"){

                  $layman_summar .= "You have not sure you were prescribed oral steroid tablets for your COPD attacks.<br/>";
                }
                else{

                   $layman_summar .= "You have not been prescribed oral steroid tablets for your COPD attacks.<br/>";
                }
                  //$layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>You have prescribed oral steroid tablets for your COPD attacks</strong>.<br/>" : "<strong>You have not prescribed oral steroid tablets for your COPD attacks</strong>.<br/>" ;
                  break;

              case 285:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "You have been to the ER ".(isset($chronic_copd[$k+1]) ? "<strong>".$chronic_copd[$k+1]['answer'].' times </strong>' : '')."for your COPD attack(s).<br/>" : "You have not been go to the ER for your COPD attack(s).<br/>";
                  break;

              case 287:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "You stayed ".(isset($chronic_copd[$k+1]) ? "<strong>".$chronic_copd[$k+1]['answer'].' </strong>' : '')."nights at the hospital.<br/>" : "<strong>You have not stayed at the hospital over night</strong>.<br/>";
                  break;

            }
        }
      $layman_summar .= $last_new_line;
  }
  return array('layman_summar' => $layman_summar);
}


public function chronic_asthma_layman($chronic_asthma,$peak_flow_reading_detail)
{
// pr($chronic_asthma);die;
  $layman_summar = '' ;
  $last_new_line = '';
  $family_relation = [1=>'Father', 2=>'Mother', 3=>'Grandmother (Dad-side)', 4=>'Grandfather (Dad-side)', 5=>'Grandmother (Mom-side)', 6=>'Grandfather (Mom-side)', 7=>'Brother', 8=>'Sister', 9=>'Son', 10=>'Daughter'];

  if(!empty($chronic_asthma) && is_array($chronic_asthma)){

      $layman_summar .= "<br /><strong>You provided these details for Chronic asthma:</strong><br />";
      $last_new_line = '<br />';

      foreach ($chronic_asthma as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 234:
                  $layman_summar .=  "You described your condition as <strong>".strtolower($singlelevel['answer'])."</strong> since your last clinic visit.<br/>" ;
                  break;

              case 293:

                  $layman_summar .=  "You have managed your asthma condition with <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']))."</strong>.<br/>" ;
                  break;

              case 294:

                  $layman_summar =  str_replace("other", $singlelevel['answer'], $layman_summar) ;
                  break;

              case 295:

                  $ques_ans_295 = strtolower($singlelevel['answer']);
                  if($ques_ans_295 == 'no'){

                    $layman_summar .= "<strong>You do not measure your peak flow with a spirometer at home</strong>.<br>";
                  }
                  else{

                    if(!empty($peak_flow_reading_detail)){

                      usort($peak_flow_reading_detail, function($a, $b) {
                          return strtotime(trim($a['reading_date'])) - strtotime(trim($b['reading_date']));
                      });

                        $layman_summar .= "<strong>Peak flow log:</strong></br>";
                        foreach ($peak_flow_reading_detail as $reading_key => $reading_value) {

                          $reading_timing_val = $reading_value['reading_timing'];
                          $layman_summar .= $reading_value['reading_date'].(!empty($reading_timing_val) ? " | ".$reading_timing_val : "").(!empty($reading_value['reading_val']) ? " | ".$reading_value['reading_val'] : "")." | self-reported<br>";
                        }
                    }

                  }

                  break;

              case 296:
                  $layman_summar .=  "Overall, you have experienced asthma symptoms <strong>".$singlelevel['answer']." times/week</strong>.<br/>";
                  break;

              case 297:
                  $layman_summar .=  "You have experienced asthma symptoms <strong>".$singlelevel['answer']."</strong>.<br/>";
                  break;

              case 298:
                  $layman_summar .=  "You wake up <strong>".$singlelevel['answer']." times</strong> from sleep becuase of coughing or wheezing.<br/>";
                  break;

              case 299:

                  $ques_ans_299 = strtolower($singlelevel['answer']);
                  if($ques_ans_299 == 'none'){

                    $layman_summar .= '<strong>No limitations on normal daily activities</strong>.<br/>';
                  }
                  elseif($ques_ans_299 == 'minor limits'){

                    $layman_summar .= '<strong>Minor limitations on normal daily activities</strong>.<br/>';
                  }
                  elseif($ques_ans_299 == 'some limits'){

                    $layman_summar .= '<strong>Some limitations on normal daily activities</strong>.<br/>';
                  }
                  elseif($ques_ans_299 == 'extremely limited'){

                    $layman_summar .= '<strong>Extremely limitations on normal daily activities</strong>.<br/>';
                  }
                  break;

              case 300:
                  $layman_summar .=  "You used your albuterol inhaler <strong>".$singlelevel['answer']." times</strong>.<br/>";
                  break;

              case 301:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "You took steroid tablets ".(isset($chronic_asthma[$k+1]) && !empty($chronic_asthma[$k+1]) && $chronic_asthma[$k+1]['question_id'] == '302' ? '<strong>'.$chronic_asthma[$k+1]['answer'].' times</strong> ': '')." to treat your symptoms in the past 12 months.<br/>" : "<strong>You didn't take steroid tablets to treat your symptoms in the past 12 months</strong>.<br/>" ;
                  break;

              case 303:

                  $ques_ans_303 = strtolower($singlelevel['answer']);
                  $layman_summar .=  $ques_ans_303 == 'no' ? '<strong>You have not had any asthma attack in the past 6 months</strong>.<br>': '';
                  break;

              case 304:
                  if(isset($ques_ans_303) && $ques_ans_303 == 'yes'){
                    $layman_summar .=  "<strong>".$singlelevel['answer']."</strong> asthma attacks in the past 6 months.<br/>";
                  }
                  break;

              case 305:
                  if(isset($ques_ans_303) && $ques_ans_303 == 'yes'){
                    $layman_summar .=  $singlelevel['answer'] == 'Yes' ? "<strong>Asthma attacks improve completely with your rescue inhaler</strong>.<br/>" : "<strong>Asthma attacks did not improve with your rescue inhaler</strong>.<br/>";
                  }
                  break;

              case 306:

                if(isset($ques_ans_303) && $ques_ans_303 == 'yes'){
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "You have been to the ER ".(isset($chronic_asthma[$k+1]) ? "<strong>".$chronic_asthma[$k+1]['answer'].' times </strong>' : '')."for your asthma attacks.<br/>" : "<strong>You have not been go to the ER for your asthma attacks</strong>.<br/>";
                }
                  break;

              case 308:
                  if(isset($ques_ans_303) && $ques_ans_303 == 'yes'){

                    $ques_ans_308 = strtolower($singlelevel['answer']);
                    if($ques_ans_308 == 'yes'){

                      $layman_summar .= '<strong>They have place a breathing tube (intubation)</strong>.<br/>';
                    }
                    elseif($ques_ans_308 == 'not sure'){

                      $layman_summar .= '<strong>You are not sure, they have place a breathing tube (intubation)</strong>.<br/>';
                    }
                    else{

                      $layman_summar .= "<strong>They did not place a breathing tube (intubation)</strong>.<br/>";
                    }

                  }
                  break;

              case 309:
                  $layman_summar .=  "You have been diagnosed with <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer']))."</strong>.<br/>";
                  break;

              case 310:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>You are currently smoking</strong>.<br/>" : "<strong>You do not currently smoke</strong>.<br/>" ;
                  break;

              case 311:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>You have exposed second hand smoking</strong>.<br/>" : "<strong>You are not exposed second hand smoking</strong>.<br/>" ;
                  break;

              case 312:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>You are vaping</strong>.<br/>" : "<strong>You do not vape</strong>.<br/>" ;
                  break;

              case 313:
                  $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "Your family members ".(isset($chronic_asthma[$k+1]) && !empty($chronic_asthma[$k+1]) && $chronic_asthma[$k+1]['question_id'] == '314' ? '<strong>'.(is_array($chronic_asthma[$k+1]['answer']) ? implode(", ", $chronic_asthma[$k+1]['answer']) : $chronic_asthma[$k+1]['answer']).'</strong> ': '')."have been diagnosed with asthma.<br/>" : "<strong>Your family members have not been diagnosed with asthma</strong>.<br/>" ;
                  break;

              case 315:

                  $ques_ans_315 = strtolower($singlelevel['answer']);
                  if($ques_ans_315 == 'yes' ){

                    $layman_summar .= "You had the pneumonia shot".(isset($chronic_asthma[$k+1]) ? ' in '.$chronic_asthma[$k+1]['answer'] : '').".<br/>";
                  }
                  elseif($ques_ans_315 == "not sure"){

                    $layman_summar .= "<strong>You have not sure you have had the pneumonia shot</strong>.<br/>";
                  }
                  else{

                     $layman_summar .= "<strong>You have not had the pneumonia shot</strong>.<br/>";
                  }
                  break;              

              case 317:

                  $ques_ans_317 = strtolower($singlelevel['answer']);
                  if($ques_ans_317 == 'yes' ){

                    $layman_summar .= "You have the flu vaccine".(isset($chronic_asthma[$k+1]) ? ' at '.$chronic_asthma[$k+1]['answer'] : '')." for current season.<br/>";
                  }
                  elseif($ques_ans_317 == "not sure"){

                    $layman_summar .= "<strong>You have not sure you have the flu vaccine for current season</strong>.<br/>";
                  }
                  else{

                     $layman_summar .= "<strong>You did not have the flu vaccine for current season</strong>.<br/>";
                  }
                  break;
              case 700:

                  $ques_ans_700 = strtolower($singlelevel['answer']);
                  if($ques_ans_700 == 'yes' ){

                    $layman_summar .= "You had the shingles".(isset($chronic_asthma[$k+1]) ? ' in '.$chronic_asthma[$k+1]['answer'] : '').".<br/>";
                  }
                  elseif($ques_ans_700 == "not sure"){

                    $layman_summar .= "<strong>You have not sure you have had the shingles</strong>.<br/>";
                  }
                  else{

                     $layman_summar .= "<strong>You have not had the shingles</strong>.<br/>";
                  }
                  break;
                  
              case 702:

                  $ques_ans_702 = strtolower($singlelevel['answer']);
                  if($ques_ans_702 == 'yes' ){

                    $layman_summar .= "You have the covid-19".(isset($chronic_asthma[$k+1]) ? ' in '.$chronic_asthma[$k+1]['answer'] : '')." .<br/>";
                  }
                  elseif($ques_ans_317 == "not sure"){

                    $layman_summar .= "<strong>You have not sure you have the covid-19</strong>.<br/>";
                  }
                  else{

                     $layman_summar .= "<strong>You did not have the covid-19</strong>.<br/>";
                  }
                  break;

            }
        }
      $layman_summar .= $last_new_line;
  }
  return array('layman_summar' => $layman_summar);
}

//glucode_reading_detail

public function chronic_dmii_layman($chronic_dmii, $glucose_reading_detail,$medication_detail,$is_chief_complaint_doctor){
  //pr($is_chief_complaint_doctor);die;
  $layman_summar = '' ;
  $last_new_line = '';
  $type = '';
  if(!empty($chronic_dmii) || !empty($medication_detail)){

    $type = !empty($is_chief_complaint_doctor) && in_array($is_chief_complaint_doctor[1]['answer'],['Type 1','Type 2']) ? ' ('.$is_chief_complaint_doctor[1]['answer'].')' :'';


    $layman_summar .= "<br /><strong>You provided these details for Chronic Diabetes".$type.":</strong><br />";
    $last_new_line = '<br />';
  }

  if(!empty($chronic_dmii) && is_array($chronic_dmii)){

      foreach ($chronic_dmii as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {


              case 234:

                   $layman_summar .=  "You described your condition as <strong>".strtolower($singlelevel['answer'])."</strong> since your last clinic visit.<br/>" ;
                  break;

              case 235:

                  $ques_ans_235 = strtolower($singlelevel['answer']);
                  if($ques_ans_235 == 'no'){

                    $layman_summar .= "<strong>You do not any recorded blood sugar (glucose) readings to provide</strong>.<br>";
                  }
                  else{

                    if(!empty($glucose_reading_detail)){

                      usort($glucose_reading_detail, function($a, $b) {
                          return strtotime(trim($a['reading_date'])) - strtotime(trim($b['reading_date']));
                      });

                        $glu_reading_timing_trans = array(

                                                    0 => "",
                                                    1 => 'before breakfast',
                                                    2 => 'before lunch',
                                                    3 => 'before dinner',
                                                    4 => "bedtime",
                                                    5 => 'after exercise',
                                                    6 => 'after a meal'
                                                );

                        $layman_summar .= "<strong>Glucose log:</strong></br>";
                        foreach ($glucose_reading_detail as $reading_key => $reading_value) {

                          $reading_timing_val = isset($glu_reading_timing_trans[$reading_value['reading_timing']]) ? $glu_reading_timing_trans[$reading_value['reading_timing']] : $reading_value['reading_timing'];

                          $layman_summar .= $reading_value['reading_date'].(!empty($reading_timing_val) ? " | ".$reading_timing_val : "").(!empty($reading_value['reading_val']) ? " | ".$reading_value['reading_val'] : "")." | self-reported<br>";
                        }
                    }

                  }

                  break;
            }
        }
  }

  if(!empty($medication_detail) && is_array($medication_detail)){

      $layman_summar .= '<strong>Medication Details:</strong></br>';

      foreach ($medication_detail as $med_key => $med_val) {

          $layman_summar .= $med_val['medication_name_name'].(!empty($med_val['medication_dose']) ? " | ".$med_val['medication_dose'].' dose' : "").(!empty($med_val['medication_how_often']) ? " | ".$med_val['medication_how_often'] : "").(!empty($med_val['medication_how_taken']) ? " | ".$med_val['medication_how_taken'] : "")."<br>";
      }
  }

  $layman_summar .= $last_new_line;

  return array('layman_summar' => $layman_summar);
}




public function chronic_htn_layman($chronic_htn, $bp_reading_detail, $medication_detail)
{
// pr($chronic_htn);die;
  $layman_summar = '' ;
  $last_new_line = '';

  if(!empty($chronic_htn) || !empty($medication_detail)){

    $layman_summar .= "<br /><strong>You provided these details for Chronic Hypertension:</strong><br />";
    $last_new_line = '<br />';
  }

  if(!empty($chronic_htn) && is_array($chronic_htn)){

      foreach ($chronic_htn as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 234:

                  $layman_summar .=  "You described your condition as <strong>".strtolower($singlelevel['answer'])."</strong> since your last clinic visit.<br/>" ;
                  break;


              case 243:

                  $ques_ans_243 = strtolower($singlelevel['answer']);
                  if($ques_ans_243 == 'no'){

                    $layman_summar .= "<strong>You do not measuring your blood pressure at home</strong>.<br>";
                  }
                  else{

                    if(!empty($bp_reading_detail)){

                      usort($bp_reading_detail, function($a, $b) {
                          return strtotime(trim($a['reading_date'])) - strtotime(trim($b['reading_date']));
                      });

                        $bp_reading_timing_trans = array(

                                                    0 => "",
                                                    1 => 'before breakfast',
                                                    2 => 'before lunch',
                                                    3 => 'before dinner',
                                                    4 => "bedtime",
                                                    5 => 'after exercise',
                                                    6 => 'after a meal'
                                                );

                        $layman_summar .= "<strong>BP Reading log:</strong></br>";
                        foreach ($bp_reading_detail as $reading_key => $reading_value) {

                          $reading_timing_val = isset($bp_reading_timing_trans[$reading_value['reading_timing']]) ? $bp_reading_timing_trans[$reading_value['reading_timing']] : $reading_value['reading_timing'];

                          $layman_summar .= $reading_value['reading_date'].(!empty($reading_timing_val) ? " | ".$reading_timing_val : "").(!empty($reading_value['top_number']) ? " | SBP ".$reading_value['top_number'] : "").(!empty($reading_value['bottom_number']) ? " | DBP ".$reading_value['bottom_number'] : "")." | self-reported<br>";
                        }
                    }

                  }

                  break;

            }
        }

  }
//pr($medication_detail);die;
  if(!empty($medication_detail) && is_array($medication_detail)){

      $layman_summar .= '<strong>Medication Details:</strong></br>';

      foreach ($medication_detail as $med_key => $med_val) {

          $layman_summar .= $med_val['medication_name_name'].(!empty($med_val['medication_dose']) ? " | ".$med_val['medication_dose'].' dose' : "").(!empty($med_val['medication_how_often']) ? " | ".$med_val['medication_how_often'] : "").(!empty($med_val['medication_how_taken']) ? " | ".$med_val['medication_how_taken'] : "")."<br>";
      }
  }

  $layman_summar .= $last_new_line;

  return array('layman_summar' => $layman_summar);
}


public function chronic_general_detail_layman($chronic_general_detail){

  $layman_summar = '' ;
  $last_new_line = '';

  if(!empty($chronic_general_detail) && is_array($chronic_general_detail)){

      $layman_summar .= "<br /><strong>You provided these general details for Chronic conditions:</strong><br />";
      $last_new_line = '<br />';

      foreach ($chronic_general_detail as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {

              case 244:

                $ques_ans_223 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                $layman_summar .= $ques_ans_223 == 'no special diet' ? '<strong>You do not follow any special diet to manage your condition</strong>.</br>' : "You follow a <strong>".$ques_ans_223."</strong> diet to manage your condition.</br>";
                break;

              case 245:

                $layman_summar .= "You eat fast food <strong>".$singlelevel['answer']."</strong> times in a week.</br>";
                break;

              case 246:

                $ques_ans_246 = strtolower($singlelevel['answer']);
                $layman_summar .=  $ques_ans_246 == 'no' ? "You do not exercise.<br>" : "";
                break;

              case 247:

                if(isset($ques_ans_246) && $ques_ans_246 == 'yes'){

                  $ques_ans_247 = strtolower($singlelevel['answer']);
                  $layman_summar .= $ques_ans_247 == 'no' ? 'You do not exercise with weights on a weekly basis.<br />' : 'You are exercise with weights on a weekly basis.<br />';
                }
              break;

              case 248:

                if(isset($ques_ans_246) && $ques_ans_246 == 'yes'){

                  $ques_ans_248 = strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']);
                  $layman_summar .= $ques_ans_248  == 'none' ? "You do not exercise" : "You exercise with <strong>".$ques_ans_248."</strong>.<br />";
                }
                break;

              case 249:

                  $layman_summar = str_replace("other", strtolower($singlelevel['answer']), $layman_summar);
                break;

              case 250:

                if(isset($ques_ans_246) && $ques_ans_246 == 'yes'){

                  $layman_summar .= "You exercise <strong>" .$singlelevel['answer']. " times</strong> in a week.<br />";
                }
                break;

              case 251:

                if(isset($ques_ans_246) && $ques_ans_246 == 'yes'){

                  $layman_summar .= "You exercise for <strong>" .$singlelevel['answer']. " mins</strong> each time.<br />";
                }
                break;


              case 252:

                  if(strtolower($singlelevel['answer']) == 'yes'){

                    if(isset($chronic_general_detail[$k+1]) && $chronic_general_detail[$k+1]['question_id'] == 253 && !empty($chronic_general_detail[$k+1]['answer'])){

                      $layman_summar .= "Currently you are smoking <strong>" .$chronic_general_detail[$k+1]['answer']. " packs</strong> per day.<br />" ;
                    }
                    else{

                      $layman_summar .= 'Currently you are smoking.<br />';
                    }
                  }
                  else{

                    $layman_summar .= "Currently you do not smoke.<br />";
                  }

                  break;


              case 254:

                  if(strtolower($singlelevel['answer']) == 'yes'){

                    if(isset($chronic_general_detail[$k+1]) && $chronic_general_detail[$k+1]['question_id'] == 255 && !empty($chronic_general_detail[$k+1]['answer'])){

                      $layman_summar .= "Currently you are drinking <strong>" .$chronic_general_detail[$k+1]['answer']. " drinks</strong> per week</strong>.<br />" ;
                    }
                    else{

                      $layman_summar .= 'Currently you are drinking alcohol.<br />';
                    }
                  }
                  else{

                    $layman_summar .= "Currently you do not drink alcohol.<br />";
                  }

                  break;

               case 256:

                   $layman_summar .=  strtolower($singlelevel['answer']) == 'yes' ? "<strong>Currently you are vaping</strong>.<br/>" : "Currently you do not vaping.<br/>";
                  break;

              case 257:
                   $layman_summar .=  "You described your overall condition as <strong>".strtolower($singlelevel['answer'])."</strong> since your last clinic visit.<br/>" ;
                  break;

              case 258:

                $ques_ans_258 = strtolower($singlelevel['answer']);
                $layman_summar .= $ques_ans_258 == 'no' ? 'You do not drink caffeine (coffee, soda, energy drinks) on a daily basis.<br>' : '';
                break;

              case 259:
              //not included in summary due to client requirement
                /*if(isset($ques_ans_258) && $ques_ans_258 == 'yes'){

                  $layman_summar .= 'You are drinking <strong>'.(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer']) : $singlelevel['answer'])).'</strong> daily.<br>';
                }*/
                break;

              case 260:
                if(isset($ques_ans_258) && $ques_ans_258 == 'yes'){

                  $layman_summar .= 'You drink <strong>'.$singlelevel['answer'].' cups</strong> of coffee daily.<br>';
                }
                break;

              case 261:
                if(isset($ques_ans_258) && $ques_ans_258 == 'yes'){

                  $layman_summar .= 'You drink <strong>'.$singlelevel['answer'].' cans</strong> of energy drinks daily.<br>';
                }
                break;

              case 262:
                if(isset($ques_ans_258) && $ques_ans_258 == 'yes'){

                  $layman_summar .= 'You are drinking <strong>'.$singlelevel['answer'].' cups</strong> of green or black tea daily.<br>';
                }
                break;

              case 315:

                    $ques_ans_315 = strtolower($singlelevel['answer']);
                    if($ques_ans_315 == 'yes' ){

                      $layman_summar .= "You had the ".(is_array($chronic_general_detail[$k+1]['answer']) && !empty($chronic_general_detail[$k+1]['answer']) && $chronic_general_detail[$k+1]['answer'][0]!= "I'm not sure" ? strtolower(implode(', ',$chronic_general_detail[$k+1]['answer'])):"pneumonia ")." shot".(isset($chronic_general_detail[$k+2]) ? ' in '.$chronic_general_detail[$k+2]['answer'] : '').".<br/>";
                    }
                    elseif($ques_ans_315 == "not sure"){

                      $layman_summar .= "You have not sure you have had the pneumonia shot.<br/>";
                    }
                    else{

                       $layman_summar .= "You have not had the pneumonia shot.<br/>";
                    }
                    break;

              case 317:

                    $ques_ans_317 = strtolower($singlelevel['answer']);
                    if($ques_ans_317 == 'yes' ){

                      $layman_summar .= "You have the flu vaccine".(isset($chronic_general_detail[$k+1]) ? ' at '.$chronic_general_detail[$k+1]['answer'] : '')." for current season.<br/>";
                    }
                    elseif($ques_ans_317 == "not sure"){

                      $layman_summar .= "You have not sure you have the flu vaccine for current season.<br/>";
                    }
                    else{

                       $layman_summar .= "You did not have the flu vaccine for current season.<br/>";
                    }
                    break;
            }
        }

      $layman_summar .= $last_new_line;
  }
  return array('layman_summar' => $layman_summar);
}

public function is_chief_complaint_doctor($is_chief_complaint_doctor)
{
  $layman_summar = '' ;
  //pr($is_chief_complaint_doctor);
  foreach($is_chief_complaint_doctor as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
              case 556:

                  $layman_summar .= $singlelevel['answer'] == 'No' ? "You have not any symptom complaints you wouldn't like to talk to your doctor about today.<br />" : "" ;
                  break;

             case 558:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? '' : "You were not referred to us by another doctor.<br />" ;
                  break;
              case 605:

                  $layman_summar .= "You were referred to us by another doctor ".strtolower($singlelevel['answer']).".<br />" ;
                  break;
              case 559:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have filled out your advanced directives before.<br />' : "You haven't filled out your advanced directives before.<br />" ;
                  break;
              case 560:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You would like us to help you set up your advanced directives today.<br />' : "You wouldn't like us to help you set up your advanced directives today.<br />" ;
                  break;          



            }
        }
      $layman_summar .= '<br />';
      return array('layman_summar' => $layman_summar);

}
public function chief_complaint_psychiatry($chief_complaint_psychiatry)
{
  $layman_summar = '' ;
  $visit_with ='';
  // pr($chief_complaint_psychiatry);
  foreach($chief_complaint_psychiatry as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
              case 610:

                  $layman_summar .= "You have need medication(s) ".$singlelevel['answer'].".<br />";
                  break;

             case 611:

                  $layman_summar .= "Your last psychiatric name is Dr ".$singlelevel['answer'].".<br />";
                  break;
              case 612:
                  $ans_612 = array();
                  $ans_612 = $singlelevel['answer'];
                  if(in_array('Other', $singlelevel['answer']))
                  {
                    $ans_612 = array_diff($singlelevel['answer'],['Other']);
                  }
                  $layman_summar .= "You have ever been diagnosed with  ".strtolower(implode(', ',$ans_612));
                  if(!in_array('Other', $singlelevel['answer']))
                  {
                    $layman_summar .= ".<br />"; 
                  }                  
                  break;
              case 613:

                  $layman_summar .= " and ".$singlelevel['answer'].".<br />" ;
                  break;
              case 614:
                  $visit_with = ucfirst(strtolower($this->natural_word_join($singlelevel['answer'])));
                  if(!in_array('Other', $singlelevel['answer']))
                  {
                    $layman_summar .= $visit_with." is with you for today's visit.<br />"; 
                  }                  
                  break;
              case 615:

                  $layman_summar .= ($visit_with ? $visit_with." and ".$singlelevel['answer']:ucfirst($singlelevel['answer']))." is with you for today's visit.<br />" ;
                  break;    
              case 696:
                  $layman_summar .= $singlelevel['answer'] == "Yes" ? "YYou have had to stay at psych hospital since your last visit.<br>" :"You haven't had to stay at psych hospital since your last visit.<br>";     
                  break;
              case 697:
                  $layman_summar .= $singlelevel['answer'] == "Yes" ? "You have any thoughts about hurting yourself.<br>" :"You haven't any thoughts about hurting yourself.<br>";     
                  break;
              case 698:
                  $layman_summar .= $singlelevel['answer'] == "Yes" ? "You have any thoughts about hurting other people.<br>" :"You haven't any thoughts about hurting other people.<br>";     
                  break;
              case 699:
                  $layman_summar .= $singlelevel['answer'] == "Yes" ? "You have seen or hear things that other people can't.<br>" :"You haven't seen or hear things that other people can't.<br>";     
                  break;


            }
        }
      $layman_summar .= '<br />';
      return array('layman_summar' => $layman_summar);

}


public function pre_op_post_op_layman($pre_op_post_op)
{
  $layman_summar = '' ;

  if(!empty($pre_op_post_op) && is_array($pre_op_post_op)){

      $layman_summar .= "<br /><strong>You provided these pre post operation details:</strong><br />";

      foreach ($pre_op_post_op as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
              case 459:
                  $ques_ans_459 = "You have done <strong>".strtolower($singlelevel['answer']).'</strong> procedure' ;
                  if(isset($ques_ans_461) && !empty($ques_ans_461)){

                    $layman_summar .= $ques_ans_459." ".$ques_ans_461;
                  }
                  break;

              case 460:
                  $ques_ans_459 = str_replace("other", strtolower($singlelevel['answer']), $ques_ans_459);
                  break;

              case 461:

                  $ques_ans_461 =  "on <strong>".strtolower($singlelevel['answer'])."</strong>.<br/>" ;
                  if(isset($ques_ans_459) && !empty($ques_ans_459)){

                    $layman_summar .= $ques_ans_459." ".$ques_ans_461;
                  }
                  break;
             case 462:

                  $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'You have taken blood thinners.<br />' : "You haven't take any blood thinners.<br />" ;
                  break;
             case 463:

                if(strtolower($singlelevel['answer']) == 'yes'){

                   if(isset($pre_op_post_op[$k+1]) && $pre_op_post_op[$k+1]['question_id'] == 464 && !empty($pre_op_post_op[$k+1]['answer'])){

                     $layman_summar .= "You have restarted your blood thinners since your procedure on <strong>" .$pre_op_post_op[$k+1]['answer']. " </strong>.<br />" ;
                   }
                   else{

                     $layman_summar .= '<strong>You have restarted your blood thinners since your procedure</strong>.<br />';
                   }
                 }
                 else{

                   $layman_summar .= "<strong>You haven't restarted your blood thinners since your procedure</strong>.<br />";
                 }
                 break;

            case 465:

                $ques_ans_465 =  "You are currently eating <strong>".strtolower($singlelevel['answer'])." </strong> since your procedure" ;
                if(isset($ques_ans_466) && !empty($ques_ans_466)){

                  $layman_summar .= $ques_ans_465." ".$ques_ans_466;
                }
                break;

             case 466:

             $ques_ans_466 =  "and <strong>".(strtolower($singlelevel['answer']) == 'well' ? "tolerating" : "not tolerating")."</strong> food.<br/>" ;
              if(isset($ques_ans_465) && !empty($ques_ans_465)){

                $layman_summar .= $ques_ans_465." ".$ques_ans_466;
              }
             break;

            case 467:

              $layman_summar .= "Your associated symtoms are  <strong>".(strtolower(is_array($singlelevel['answer']) ? implode(", ", $singlelevel['answer'])   : $singlelevel['answer']))."</strong>.<br />";
              break;

            case 468:

              $layman_summar .=  "You have vomited <strong>".strtolower($singlelevel['answer'])." times per day</strong>.<br/>" ;
              break;

            case 469:

               $layman_summar .= $singlelevel['answer'] == 'Yes' ? 'There was blood or coffee ground-looking stuff in the vomit.<br />' : "There was not blood or coffee ground-looking stuff in the vomit.<br />" ;
               break;

            case 470:

             $layman_summar .=  "Overall, you feel right now as <strong>".strtolower($singlelevel['answer'])."</strong>.<br/>" ;
             break;



            }
        }
      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}

public function general_follow_up_layman($general_detail)
{
  $layman_summar = '' ;
  if(!empty($general_detail) && is_array($general_detail)){

      $layman_summar .= "<br /><strong>You provided these follow up general details:</strong><br />";

      foreach ($general_detail as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
              case 471:
                  if($singlelevel['answer'] == 'Yes'){

                    if(isset($general_detail[$k+1]) && !empty($general_detail[$k+1]) && $general_detail[$k+1]['question_id'] == 472){

                      $layman_summar .= "Your <strong>".strtolower(is_array($general_detail[$k+1]['answer']) ? implode(", ", $general_detail[$k+1]['answer']) : $general_detail[$k+1]['answer'])."</strong> are accompanying you to today's visit.<br />";
                    }
                    else{

                      $layman_summar .= "<strong>Someone else are accompanying you to today's visit</strong>.<br />";
                    }
                  }
                  else{
                    $layman_summar .= "<strong>No one else is accompanying you to today's visit</strong>.<br />";
                  }
                  break;

              case 473:
                    if($singlelevel['answer'] == 'Yes'){
                        if(isset($general_detail[$k+1]['question_id']) && $general_detail[$k+1]['question_id'] == 474){
                            $ans_474 = (is_array($general_detail[$k+1]['answer']) ? implode(", ", $general_detail[$k+1]['answer']) : $general_detail[$k+1]['answer']);
                            if(isset($general_detail['503']['question_id']) && $general_detail['503']['question_id'] == 503){
                                $ans_474 = str_replace("Other", $general_detail['503']['answer'], $ans_474);
                            }
                            $layman_summar .= "You are experiencing <strong>".$ans_474."</strong> symptoms you need to talk to your doctor about.<br>";

                        }else{
                             $layman_summar .= "<strong>Yes</strong>, you are experiencing symptoms you need to talk to your doctor about.<br>" ;
                        }
                    }else{
                        $layman_summar .= "You are not experiencing any symptoms you need to talk to your doctor about.<br>" ;
                    }

                  break;

              case 475:

                    $layman_summar .= "You describe your overall condition as <strong>".ucfirst($singlelevel['answer'])."</strong>. <br>";
                    break;

            }
        }
      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}

public function followup_medical_history_detail_layman($followup_medical_history_detail)
{
  //pr($followup_medical_history_detail);die;
  $layman_summar = '' ;
  $medicalissue = array();
  if(!empty($followup_medical_history_detail) && is_array($followup_medical_history_detail)){

      $layman_summar .= "<br /><strong>You provided these follow up medical details:</strong><br />";

      foreach ($followup_medical_history_detail as $k => $singlelevel) {

            if(!is_numeric($k))
            continue;

            switch ($singlelevel['question_id'])
            {
              case 476:
                  if($singlelevel['answer'] == 'Yes'){

                    if(isset($followup_medical_history_detail['medical_history']) && !empty($followup_medical_history_detail['medical_history'])){

                      $layman_summar .= "You have been diagnosed with ";
                      foreach($followup_medical_history_detail['medical_history'] as $key => $value)
                      {
                         $medicalissue[] .= '<strong>'.$value['name'].'('.$value['year'] .') '.'</strong>';
                      }
                      $layman_summar .= !empty($medicalissue)? implode(', ',$medicalissue):'';
                      $layman_summar .= "since your last visit.<br />";
                    }
                    else{
                      $layman_summar .= "You have not been diagnosed with since your last visit .<br />";
                    }
                  }
                  else{
                    $layman_summar .= " You have not been diagnosed with since your last visit .<br />";
                  }
                  break;

              case 477:
                  if($singlelevel['answer'] == 'Yes'){

                    if(isset($followup_medical_history_detail['surgical_history']) && !empty($followup_medical_history_detail['surgical_history'])){

                      $layman_summar .= "You had ";
                      $medicalissue = array();
                      foreach($followup_medical_history_detail['surgical_history'] as $key => $value)
                      {
                         $medicalissue[] .= '<strong>'.$value['name'].'('.$value['year'] .') '.'</strong>';
                      }
                      $layman_summar .= !empty($medicalissue)? implode(', ',$medicalissue):'';
                      $layman_summar .= "since your last visit.</br>";
                    }
                    else{
                      $layman_summar .= "You had not been any surgeries since your last visit.<br />";
                    }
                  }
                  else{
                    $layman_summar .= "You have not had any surgeries since your last visit.<br />";
                  }

                  break;

              case 478:

              if(!empty($singlelevel['answer']) && $singlelevel['answer'] == 'No'){

                $layman_summar .= 'You haven`t been to the ER or had to be hospitalized since your last visit .<br />';

              }else{

                $ans_479 = "";
                $ans_480 = "";
                $ans_481 = "";
                $ans_482 = "";
                $ans_483 = "";
                $ans_484 = "";


                $ans_486 = "";
                $ans_487 = "";
                $ans_488 = "";
                $ans_489 = "";
                $ans_490 = "";




                if(isset($followup_medical_history_detail[$k+1]) && $followup_medical_history_detail[$k+1]['question_id'] == 479 && $followup_medical_history_detail[$k+1]['answer'] == 'Hospital stay'){
                    $ans_479 = !empty($followup_medical_history_detail[$k+1]['answer']) ? $followup_medical_history_detail[$k+1]['answer']:"";


                if(isset($followup_medical_history_detail[$k+2]) && $followup_medical_history_detail[$k+2]['question_id'] == 480){

                  $ans_480 = !empty($followup_medical_history_detail[$k+2]['answer']) ? $followup_medical_history_detail[$k+2]['answer']:"";

                }


                if(isset($followup_medical_history_detail[$k+3]) && $followup_medical_history_detail[$k+3]['question_id'] == 481){

                  $ans_481 = (!empty($followup_medical_history_detail[$k+3]['answer']) && $followup_medical_history_detail[$k+3]['answer']) ? $followup_medical_history_detail[$k+3]['answer']:"";

                }

                if(isset($followup_medical_history_detail[$k+4]) && $followup_medical_history_detail[$k+4]['question_id'] == 482){

                  $ans_482 = !empty($followup_medical_history_detail[$k+4]['answer']) ? $followup_medical_history_detail[$k+4]['answer']:"";
                }

                if(isset($followup_medical_history_detail[$k+5]) && $followup_medical_history_detail[$k+5]['question_id'] == 483){

                  $ans_483 = !empty($followup_medical_history_detail[$k+5]['answer']) ? $followup_medical_history_detail[$k+5]['answer']:"";
                }

                if(isset($followup_medical_history_detail[$k+6]) && $followup_medical_history_detail[$k+6]['question_id'] == 484 && $followup_medical_history_detail[$k+6]['answer'] == 'Yes' ){

                  $ans_484 = !empty($followup_medical_history_detail[$k+7]['answer']) ? '<strong>'.ucfirst($followup_medical_history_detail[$k+7]['answer']).'</strong> surgeries or procedures were done':"";
                }
                else {
                  $ans_484 = 'Surgeries or procedures were not done';
                }
                $layman_summar .= 'You have been to ER or had to be hospitalized at <strong>'.$ans_480.'</strong> where you stayed from <strong>'.$ans_481.'</strong> to <strong>'.$ans_482.'</strong> due to <strong>'.$ans_483.'</strong>.<br />'.$ans_484.' .<br />';

              }
              else if(isset($followup_medical_history_detail[$k+1]) && $followup_medical_history_detail[$k+1]['question_id'] == 479 && $followup_medical_history_detail[$k+1]['answer'] == 'Emergency room visit only')
              {

                $ans_479 = !empty($followup_medical_history_detail[$k+1]['answer']) ? $followup_medical_history_detail[$k+1]['answer']:"";
                if(isset($followup_medical_history_detail['486']) && $followup_medical_history_detail['486']['question_id'] == 486){

                  $ans_486 = !empty($followup_medical_history_detail['486']['answer']) ? $followup_medical_history_detail['486']['answer']:"";

                }

                if(isset($followup_medical_history_detail['487']) && $followup_medical_history_detail['487']['question_id'] == 487){

                  $ans_487 = !empty($followup_medical_history_detail['487']['answer']) ? $followup_medical_history_detail['487']['answer']:"";

                }

                if(isset($followup_medical_history_detail['488']) && $followup_medical_history_detail['488']['question_id'] == 488){

                  $ans_488 = !empty($followup_medical_history_detail['488']['answer']) ? $followup_medical_history_detail['488']['answer']:"";

                }

                if(isset($followup_medical_history_detail['489']) && $followup_medical_history_detail['489']['question_id'] == 489 && $followup_medical_history_detail['489']['answer'] == 'Yes'){

                  $ans_489 = 'Lab tests were done';

                }
                else {
                  $ans_489 = 'Lab tests were not done';
                }

                if(isset($followup_medical_history_detail['490']) && $followup_medical_history_detail['490']['question_id'] == 490 && $followup_medical_history_detail['489']['answer'] == 'Yes'){

                  $ans_490 = 'Procedures or imaging were done';
                }
                else {
                  $ans_490 = 'Procedures or imaging were not done';
                }
                $layman_summar .= 'You have been to ER or had to be hospitalized at <strong>'.$ans_486.'</strong> where you visit at <strong>'.$ans_487.'</strong> due to <strong>'.$ans_488.'</strong>. '.$ans_489.'. '.$ans_490.'.<br />';

              }



              }

              break;

              case 491:

              if(strtolower($singlelevel['answer']) == 'yes'){

                if(isset($followup_medical_history_detail[$k+1]) && $followup_medical_history_detail[$k+1]['question_id'] == 492 && !empty($followup_medical_history_detail[$k+1]['answer'])){

                  $layman_summar .= "Currently you are smoking <strong>" .$followup_medical_history_detail[$k+1]['answer']. " packs</strong> per day.<br />" ;
                }
                else{

                  $layman_summar .= 'Currently you are smoking.<br />';
                }
              }
              else{

                $layman_summar .= "Currently you do not smoke.<br />";
              }

              break;

              case 493:

              if(strtolower($singlelevel['answer']) == 'yes'){

                if(isset($followup_medical_history_detail[$k+1]) && $followup_medical_history_detail[$k+1]['question_id'] == 494 && !empty($followup_medical_history_detail[$k+1]['answer'])){

                  $layman_summar .= "Currently you drink <strong>" .$followup_medical_history_detail[$k+1]['answer']. " drinks</strong> per week.<br />" ;
                }
                else{

                  $layman_summar .= 'Currently you drink .<br />';
                }
              }
              else{

                $layman_summar .= "Currently you do not drink.<br />";
              }

              break;

              case 495:

              $layman_summar .= $singlelevel['answer'] == 'yes' ? 'You have traveled domestically in the last 30 days':'You have not traveled domestically in the last 30 days.</br>';

              break;

              case 496:

              $layman_summar .= $singlelevel['answer'] == 'yes' ? 'You have traveled internationally in the last 30 days':'You have not traveled internationally in the last 30 days.</br>';

              break;

              case 497:

              if($singlelevel['answer'] == 'Yes'){

                if(isset($followup_medical_history_detail['allergy_history']) && !empty($followup_medical_history_detail['allergy_history'])){

                  $layman_summar .= "You have allergies ";
                  $allergiesissue = array();
                  foreach($followup_medical_history_detail['allergy_history'] as $key => $value)
                  {
                     $allergiesissue[] .= '<strong>'.$value['name'].'('.$value['reaction'] .') '.'</strong>';
                  }
                  if(!empty($allergiesissue)){
                  $layman_summar .= !empty($allergiesissue)? implode(', ',$allergiesissue):'';
                  $layman_summar .= '.';
                  }

                }
                else{
                  $layman_summar .= "You have new allergies.<br />";
                }
              }
              else{
                $layman_summar .= "You do not have new allergies.<br />";
              }
              break;

            case 504:

                $layman_summar .= $singlelevel['answer'] == "dont remember" ? "<strong>You don't remember your last mammogram</strong>.<br/>" : "<strong>Your last mammogram in ".$singlelevel['answer']."</strong>.<br/>";
                break;

            case 505:

                $layman_summar .= $singlelevel['answer'] == "dont remember" ? "<strong>You don't remember your last colonscopy</strong>.<br/>" : "<strong>Your last colonscopy in ".$singlelevel['answer']."</strong>.<br/>";
                break;

            case 506:

                $layman_summar .= $singlelevel['answer'] == "dont remember" ? "<strong>You don't remember your last bone density scan</strong>.<br/>" : "<strong>Your last bone density scan in ".$singlelevel['answer']."</strong>.<br/>";
                break;

            case 508:

              $layman_summar .= 'Your last period start on <strong>'.$singlelevel['answer']."</strong>.<br>";
              break;
            case 509:

              $layman_summar .= 'Your period flow duration is <strong>'.$singlelevel['answer']." days</strong>.<br>";
              break;
            case 510:

              $layman_summar .= 'Your period cycle length is <strong>'.$singlelevel['answer']." days</strong>.<br>";
              break;

            case 511:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? '<strong>Your period cycles is regular</strong>.<br>' : '<strong>Your period cycles is not regular</strong>.<br>';
              break;

            case 512:

              if($singlelevel['answer'] == 'Yes'){

                $layman_summar .= "<strong>You are pregnant</strong>.<br />";
              }
              elseif($singlelevel['answer'] == 'Not sure'){

                $layman_summar .= "<strong>Not sure, you are pregnant</strong>.<br />";
              }
              break;

            case 513:

              $layman_summar .= $singlelevel['answer'] == 'Yes' ? "<strong>You are try to become pregnant</strong>.<br>" : "<strong>You are not try to become pregnant</strong>.<br>";
              break;

            case 514;
              $ques_ans_514 = strtolower($singlelevel['answer']);
              $ans_514 = "You haven't experienced menopause";
              if($ques_ans_514 == 'yes'){

                  $layman_summar .= "You have experienced menopause";
                  if(isset($cancer_medical_detail[$k+1]) && !empty($cancer_medical_detail[$k+1]) && $cancer_medical_detail[$k+1]['question_id'] == 515){

                      $layman_summar .= ' at age <strong>'.$cancer_medical_detail[$k+1]['answer'].'</strong>';
                  }

                  $layman_summar .= '.<br />';
              }
              break;

            case 516;

              if(isset($ques_ans_514) && $ques_ans_514 == 'no'){

                $layman_summar .= $ans_514 .' '."and <strong>".strtolower($singlelevel['answer'])."</strong> is the main reason for no longer having periods.<br>";
              }
              break;

            case 517:

              $layman_summar .= str_replace("other", strtolower($singlelevel['answer']), $layman_summar);
              break;

            }
        }
      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}

public function is_telehealth_provider($provider_id){

  $userTlb = TableRegistry::get('Users');
  $user_data = $userTlb->find('all')->where(['id' => $provider_id])->first();

  if(!empty($user_data) && $user_data->is_telehealth_provider == 1){

    return 1;
  }

  return 0;
}

public function abdominal_pain_location_layman($answer, $gender){

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
  $layman_summar = '';
  if(!empty($answer))
  {
    $answer = explode(',', $answer) ;
    $ruq_s = 'Right upper quadrant (RUQ(';
    $rlq_s = 'Right lower quadrant (RLQ(';
    $luq_s = 'Left upper quadrant (LUQ(';
    $llq_s = 'Left lower quadrant (LLQ(';

    if($gender == 1 || $gender == 2)
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

      foreach ($answer as $k102 => $v102)
      {

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
    $layman_summar =  "You feel abdominal pain in the <strong>".$temp_str_102."</strong><br/>" ;
  }

  return $layman_summar;
}

public function getModuleName($step_id)
{
    $step_detail = TableRegistry::get('StepDetails');
    if(!empty($step_id)){

      $module_detail = $step_detail->find('all')->where(['id' => $step_id])->first();
      if(!empty($module_detail)){

        return $module_detail->step_name;
      }
    }

  return '';
}

public function getUserProgress($step_id, $tab_number){

  $progress = "";

  switch($step_id){

    case 1: {

          switch($tab_number){

            case 1 :

                  $progress = "At Step 1: Chief Complaint";
                  break;
            case 2 :

                  $progress = "At Step 2: CC Details";
                  break;

            case 18 :

                  $progress = "At Step 3: COVID-19 Screening";
                  break;

            case 19 :

                  $progress = "At Step 4: PHQ-9";
                  break;
            case 3 :

                  $progress = "At Step 5: Associated Symptoms";
                  break;
            case 4 :

                  $progress = "At Step 6: Review of Systems";
                  break;

            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 2: {


          switch($tab_number){

            case 1 :

                  $progress = "At Step 1: Chief Complaint";
                  break;

            case 19 :

                  $progress = "At Step 2: PHQ-9";
                  break;

            case 4 :

                  $progress = "At Step 3: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 3: {

          switch($tab_number){

            case 4 :

                  $progress = "At Step 1: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 4: {

          switch($tab_number){

            case 4 :

                  $progress = "At Step 1: Review of Systems";
                  break;
            case 16 :

                  $progress = "At Step 2: Extra Detail";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 5: {

          switch($tab_number){

            case 1 :

                  $progress = "At Step 1: Chief Complaint";
                  break;

            case 4 :

                  $progress = "At Step 2: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 6: {


          switch($tab_number){

            case 2 :

                  $progress = "At Step 1: CC Details";
                  break;
            case 4 :

                  $progress = "At Step 2: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 7: {

          switch($tab_number){

            case 1 :

                  $progress = "At Step 1: Chief Complaint";
                  break;
            case 2 :

                  $progress = "At Step 3: CC Details";
                  break;

            case 3 :

                  $progress = "At Step 4: Associated Symptoms";
                  break;
            case 4 :

                  $progress = "At Step 5: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;

            case 6 :

                  $progress = "At Step 2: CC Other Details";
                  break;
          }
    }
    break;

    case 8: {

        switch($tab_number){

            case 5 :

                  $progress = "Completed";
                  break;

            case 7 :

                  $progress = "At Step 1: General Updates";
                  break;
            case 8 :

                  $progress = "At Step 2: Pain Updates";
                  break;
          }
    }
    break;

    case 9: {

        switch($tab_number){

            case 5 :

                  $progress = "Completed";
                  break;

            case 9 :

                  $progress = "At Step 1: GI Health Checkup Screening";
                  break;

            case 4 :

                  $progress = "At Step 2: Review of Systems";
                  break;
          }
    }
    break;

    case 10: {

          switch($tab_number){

            case 1 :

                  $progress = "At Step 1: Chief Complaint";
                  break;
            case 4 :

                  $progress = "At Step 2: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 11: {

          switch($tab_number){

            case 10 :

                  $progress = "At Step 1: Post-procedure Checkup Detail";
                  break;
            case 4 :

                  $progress = "At Step 2: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 13: {

          switch($tab_number){

            case 11 :

                  $progress = "At Step 1: Pre-Operation Procedure Detail";
                  break;
            case 12 :

                  $progress = "At Step 2: Pre-Operation Medication";
                  break;

            case 13 :

                  $progress = "At Step 2: Pre-Operation Allergies";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 14: {

          switch($tab_number){

            case 14 :

                  $progress = "At Step 1: Disease Selection";
                  break;
            case 15 :

                  $progress = "At Step 2: Disease Detail";
                  break;

            case 4 :

                  $progress = "At Step 3: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 15: {

          switch($tab_number){

            case 1 :

                  $progress = "At Step 1: Chief Complaint";
                  break;
            case 12 :

                  $progress = "At Step 2: Hospital/ER Follow Up Details";
                  break;

            case 4 :

                  $progress = "At Step 3: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 16: {

          switch($tab_number){

            case 4 :

                  $progress = "At Step 1: Review of Systems";
                  break;

            case 17 :

                  $progress = "At Step 2: Follow Up Details";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 17: {

          switch($tab_number){

            case 1 :

                  $progress = "At Step 1: Chief Complaint";
                  break;

            case 2 :

                  $progress = "At Step 2: CC Details";
                  break;

            case 22 :

                  $progress = "At Step 3: Focused History Details";
                  break;

            case 18 :

                  $progress = "At Step 4: COVID-19 Screening";
                  break;

            case 3 :

                  $progress = "At Step 5: Associated Symptoms";
                  break;

            case 4 :

                  $progress = "At Step 6: Review of Systems";
                  break;

            case 5 :

                $progress = "Completed";
                break;

          }
    }
    break;

    case 18: {

          switch($tab_number){

            case 24 :

                  $progress = "At Step 1: Chronic Condition";
                  break;

            case 23 :

                  $progress = "At Step 2: Assessment";
                  break;

            case 3 :

                  $progress = "At Step 3: Associated Symptoms";
                  break;

            case 4 :

                  $progress = "At Step 4: Review of Systems";
                  break;

            case 5 :

                $progress = "Completed";
                break;
          }
    }
    break;

    case 19: {

          switch($tab_number){

            case 25 :

                  $progress = "At Step 1: Chief Complaint";
                  break;

            case 26 :

                  $progress = "At Step 2: Cancer History";
                  break;

            case 27 :

                  $progress = "At Step 3: Assessments";
                  break;
            case 28 :

                  $progress = "At Step 4: Medical History";
                  break;

            case 4 :

                  $progress = "At Step 5: Review of Systems";
                  break;
            case 5 :

                  $progress = "Completed";
                  break;
          }
    }
    break;

    case 22: {

        switch($tab_number){

            case 5 :

                  $progress = "Completed";
                  break;

            case 4 :

                  $progress = "At Step 2: Review of Systems";
                  break;
            case 33 :

                  $progress = "At Step 1: Hospital/Er Details";
                  break;
          }
    }
    break;
  }

  return $progress;
}

  public function getProviderTimezone($user_id){

      $ProviderGlobalSettingsTlb = TableRegistry::get('ProviderGlobalSettings');
      $provider_config_detail = $ProviderGlobalSettingsTlb->find('all')->where(['provider_id' => $user_id])->first();
      $timezone = !empty($provider_config_detail) ? $provider_config_detail['timezone'] : "CST";
      return $timezone;
  }

  public function chronic_pain_treatment_history_layman($chronic_pain_treatment_history,$chronic_pain_curr_treat_history,$chronic_pain_past_treat_history)
{

  //pr($chronic_pain_treatment_history);

  //pr($chronic_pain_curr_treat_history);

   $layman_summar = '' ;
   $tmpArray = array();
   $efficacy = array('1' =>'helped a lot', '2' =>'helped a little', '3' =>"didn't help at all");
   $tmpans170 = '';
   $tmpCurrMedicine = '';
   $tmpans174 = '';
   $tmpPastMedicine = '';

    if(!empty($chronic_pain_treatment_history) && is_array($chronic_pain_treatment_history)){

      $layman_summar .= "<br /><strong>You provided these details for Chronic pain Treatment History:</strong><br />";

      $medicineArray = array('0' => 'spinal injections', '1' => 'joint injections' , '2' => 'physical therapy', '3' => 'medication');

      foreach ($chronic_pain_treatment_history as $k => $singlelevel) {

            switch ($singlelevel['question_id'])
            {
             case 169:

                  if($singlelevel['answer'] == 'Yes'){

                    $ans170 = is_array($chronic_pain_treatment_history[$k+1]['answer'])?$chronic_pain_treatment_history[$k+1]['answer']:'';                                       
                    
                    if(!empty($ans170))
                    {
                      $ans170 = array_filter($ans170);
                      foreach ($ans170 as $key => $value) {
                                               
                        if(isset($key) && $key != 3)
                        {
                        $tmpans170 .= isset($medicineArray[$key])?$medicineArray[$key]:''.' which are '.isset($efficacy[$value])?$efficacy[$value]:''.', ';
                        }                        

                        if($value == 'medication')
                        {

                         if(!empty($chronic_pain_past_treat_history))
                         {                                                       
                            foreach ($chronic_pain_past_treat_history as $mkey => $mvalue) {

                              $tmpCurrMedicine .= $mvalue['layman_name'].' which are '.$efficacy[$mvalue['answer']];
                            }                           
                         } 
                        }                         
                      }
                    }                                  

                    $layman_summar .= "You are currently using <strong>".$tmpans170.$tmpCurrMedicine."</strong>  medications (over-the-counter or prescribed), getting injections, or physical therapy to treat pain  were sickle cell carrier but doesn't have the disease (Sickle Cell Trait).<br/>";

                  }else{
                    $layman_summar .= "<strong>You are not currently using medications (over-the-counter or prescribed), getting injections, or physical therapy to treat pain  were sickle cell carrier but doesn't have the disease (Sickle Cell Trait)</strong>.<br/>";
                  }
                  break;  

                  case 172:

                  if($singlelevel['answer'] == 'Yes'){

                    $ans173 = is_array($chronic_pain_treatment_history[$k+1]['answer'])?$chronic_pain_treatment_history[$k+1]['answer']:'';                                       
                    
                    if(!empty($ans173))
                    {
                      $ans173 = array_filter($ans173);
                      foreach ($ans173 as $key => $value) {
                                               
                        if($key != 3)
                        {
                        $tmpans174 .= $medicineArray[$key].' which are '.$efficacy[$value].', ';
                        }                        

                        if($value == 'medication')
                        {

                         if(!empty($chronic_pain_curr_treat_history))
                         {                                                       
                            foreach ($chronic_pain_curr_treat_history as $mkey => $mvalue) {

                              $tmpPastMedicine .= $mvalue['layman_name'].' which are '.$efficacy[$mvalue['answer']];
                            }                           
                         } 
                        }                         
                      }
                    }                                  

                    $layman_summar .= "In the past, you have tried <strong>".$tmpans174.$tmpPastMedicine."</strong>  medications (over-the-counter or prescribed), getting injections, or physical therapy to treat pain  were sickle cell carrier but doesn't have the disease (Sickle Cell Trait).<br/>";

                  }else{
                    $layman_summar .= "<strong>In the past, you haven't tried medications (over-the-counter or prescribed), getting injections, or physical therapy to treat pain  were sickle cell carrier but doesn't have the disease (Sickle Cell Trait)</strong>.<br/>";
                  }
                  break;  

                  case 175:

                  $layman_summar .=  "The pain affecting your overall activity level is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break;    

                  case 176:

                  $layman_summar .=  "The pain affecting your ability to work is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break;

                  case 177:

                  $layman_summar .=  "The pain affecting your ability to do daily activities like showering, putting on clothes, and brushing your teeth is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break; 

                  case 178:

                  $layman_summar .=  "The pain affecting your sleep is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break; 

                  case 179:

                  $layman_summar .=  "The pain affecting your relationship is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break;

                  case 180:

                  $layman_summar .=  "The pain affecting your mood is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break; 

                  case 181:

                  $layman_summar .=  "The pain affecting your appetite is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break;

                  case 182:

                  $layman_summar .=  "The pain affecting your stress level is <strong>".strtolower($singlelevel['answer'])."</strong> .<br/>" ;
                  break;            
            }          
        }

      $layman_summar .= '<br />';
  }
  return array('layman_summar' => $layman_summar);
}

public function is_show_summary($schedule_id)
{

  if(!empty($schedule_id))
  {
    $userTlb = TableRegistry::get('Users');
    $scheduleTbl = TableRegistry::get('Schedule');
    $sched_data = $scheduleTbl->find('all')->where(['id' => $schedule_id])->first();

    $provider_data = $userTlb->find('all')->where(['id' => $sched_data['provider_id']])->first();
    if(!empty($provider_data) && $provider_data['is_hide_summary'] == 1) {

        return 1;
    }
  }

  return 0;
}

public function natural_word_join($array)
    {   
        $str = '';
        // echo array_search('Other', $array);die;
        if(!in_array('Other', $array))
        {
          $str = count($array) > 1 ? array_pop($array):'';  
        }
        if(in_array('Other', $array))
        { 
          $array = array_diff($array,['Other']);
        }
        return implode(', ',$array).($str ? ' and '.$str:'');
    }

}

?>
