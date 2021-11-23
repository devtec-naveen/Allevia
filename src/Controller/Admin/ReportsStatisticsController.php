<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class ReportsStatisticsController extends AppController
{

    public function initialize()
    {
    parent::initialize();
      $this->loadComponent('Paginator');
    }

    public function index($chart_type = null)
    {
       if(empty($chart_type)) $chart_type = 1 ;  // daily = 1 , weekly = 2, monthly = 3 , yearly = 4
       // pr($chart_type); die; 
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');

        $this->loadModel('Users');
        $this->loadModel('Appointments');


        if($this->request->is(['post', 'put'])){
            $start_date = $this->request->getData('start_date'); 
            $end_date =  $this->request->getData('end_date'); 

            if(!empty($start_date)){
            $filter_start_date = FrozenTime::createFromFormat(
                'm-d-Y', // 'd-m-Y'
                $start_date
            );
            }
           if(!empty($end_date)){
            $filter_end_date = FrozenTime::createFromFormat(
                'm-d-Y', // 'd-m-Y'
                $end_date
            );
            }
// pr( $filter_start_date); pr($filter_end_date); die; 
        }

// for user registration start
$query = $this->Users->find();
        $user = $query
            ->select(['max_date' => $query->func()->max('Users.created'), 'min_date' => $query->func()->min('Users.created')])->first();

$max_date = $user->max_date ; 

$min_date = $user->min_date ; 

 $max_date = (new Time($max_date))->setTime(23,59);
 // pr($max_date->setTime(0,0)); 
 // pr($max_date->setTime(23,59));
  $min_date = (new FrozenTime($min_date))->setTime(0,0);
// pr( $filter_start_date); pr($filter_end_date); die; 

if(!empty($filter_start_date) && !empty($filter_end_date)){
     $min_date = $filter_start_date->setTime(0,0);
      $max_date = $filter_end_date->setTime(23,59);
       $chart_type = 1 ;

}


 $temp_arr = array(); 
  $temp_arr[] = 0 ; 
$user_start_date = $min_date ; 
while($min_date < $max_date ){


    if($chart_type == 1){
   $next_min_date = $min_date->addDay(1) ; 
    }else if($chart_type == 2){
   $next_min_date = $min_date->addWeek(1) ; 
      // for($i = 0 ; $i < 7 ; $i++) $temp_arr[] = 0 ; 
   // $temp_arr[] = 0 ; 
    }else if($chart_type == 3){
   $next_min_date = $min_date->addMonth(1) ; 
        // for($i = 0 ; $i < 30 ; $i++) $temp_arr[] = 0 ; 
    // $temp_arr[] = 0 ; 
    }else if($chart_type == 4){
   $next_min_date = $min_date->addYear(1) ; 
        // for($i = 0 ; $i < 365 ; $i++) $temp_arr[] = 0 ; 
   // $temp_arr[] = 0 ; 
    }



 $query = $this->Users->find();
   $temp = $query->select(['count' => $query->func()->count('*')])->where(['created >=' => $min_date , 'created <=' => $next_min_date ])->first(); 
 $min_date = $next_min_date ; 
 $temp_arr[] =  $temp->count; 



    
}
 $max_date = $min_date ; // now $min_date becomes greater so comes out from loop
// for user registration end

 // for appointment creation ( same process followd as for user) start


$query = $this->Appointments->find();
        $apt = $query
            ->select(['max_date' => $query->func()->max('Appointments.created'), 'min_date' => $query->func()->min('Appointments.created')])->first();

$apt_max_date = $apt->max_date ; 
$apt_min_date = $apt->min_date ; 

 $apt_max_date = (new Time($apt_max_date))->setTime(23,59);
  // $apt_min_date = (new FrozenTime($apt_min_date))->setTime(0,0);
  $apt_min_date =  $user_start_date;  // as appointment made after user creation
  // pr($user_start_date); die;

if(!empty($filter_start_date) && !empty($filter_end_date)){
     $apt_min_date = $filter_start_date->setTime(0,0);
      $apt_max_date = $filter_end_date->setTime(23,59);
       $chart_type = 1 ;

}

 $apt_temp_arr = array(); 
 $apt_temp_arr[] = 0 ; 
 $apt_start_date = $apt_min_date ; 

while($apt_min_date < $apt_max_date ){
    if($chart_type == 1){
   $next_min_date = $apt_min_date->addDay(1) ; 
    }else if($chart_type == 2){
   $next_min_date = $apt_min_date->addWeek(1) ; 
         // for($i = 0 ; $i < 7 ; $i++) $apt_temp_arr[] = 0 ; 
     // $apt_temp_arr[] = 0 ; 

    }else if($chart_type == 3){
   $next_min_date = $apt_min_date->addMonth(1) ; 
          // for($i = 0 ; $i < 30 ; $i++) $apt_temp_arr[] = 0 ; 
        // $apt_temp_arr[] = 0 ; 
    }else if($chart_type == 4){
   $next_min_date = $apt_min_date->addYear(1) ; 
        // for($i = 0 ; $i < 365 ; $i++) $apt_temp_arr[] = 0 ; 
    // $apt_temp_arr[] = 0 ; 
    }

 $query = $this->Appointments->find();
   $temp = $query->select(['count' => $query->func()->count('*')])->where(['created >=' => $apt_min_date , 'created <=' => $next_min_date ])->first(); 


        $apt_temp_arr[] =  $temp->count; 

 $apt_min_date = $next_min_date ; 
  
}
// die; 
$apt_max_date = $apt_min_date ; // now $apt_min_date value becomes greater so comes out from loop

// pr($apt_temp_arr); 
// die; 

// for appointment creation ( same process followd as for user) end

$user_count = $temp_arr ; //  array_reverse($temp_arr) ;
$apt_count = $apt_temp_arr ; // array_reverse($apt_temp_arr) ;


 

$start_date = $user_start_date < $apt_start_date ? $user_start_date  :  $apt_start_date  ; 
  
$max_date = $apt_max_date > $max_date ? $apt_max_date  :  $max_date  ; 
// pr($start_date); pr($max_date); pr($user_count) ; pr($apt_count); die; 
// pr( $filter_start_date); pr($filter_end_date); die; 
$this->set(compact('user_count', 'start_date', 'max_date', 'chart_type', 'apt_count', 'filter_start_date', 'filter_end_date')) ; 
        // echo 'hi' ; die; 
       
    }
   
}
