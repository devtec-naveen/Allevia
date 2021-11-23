<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;



/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class DashboardController extends AppController
{

    public function initialize()
    {
    parent::initialize();
      $this->loadComponent('Paginator');
      $this->loadComponent('CryptoSecurity');
    }

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');


        $this->loadModel("Users");
        $this->loadModel("Doctors");
        $this->loadModel("Organizations");
        $this->loadModel("Appointments");
        

// get start date and end date of the last consecutive 12 months 
        $monthname = [1 => 'JAN' , 2 => 'FEB' , 3 => 'MAR' , 4 => 'APR' , 5 => 'MAY' , 6 => 'JUN' , 7 => 'JUL' , 8 => 'AUG' , 9 => 'SEP' , 10 => 'OCT' ,  11 => 'NOV' ,  12 => 'DEC' ];
        $curdate = date('m/d/Y h:i:s a', time()) ; 
        $datearr = array(); 
        $startdate = date('m/d/Y h:i:s a', time()); 

        $j=0; 
  $tot_user_count = $this->Users->find('all')->where(['role_id' => 2, 'is_shown' => 1])->count();
  $tot_doc_count = $this->Doctors->find('all')->where(['is_shown' => 1])->count();
  $tot_org_count = $this->Organizations->find('all')->where(['is_shown' => 1])->count();
  $tot_app_count = $this->Appointments->find('all')->where(['is_shown' => 1])->count();  

        for($i = 1 ; $i <=12 ; $i++){

            $startdate = date('Y-m-01', strtotime($startdate));
            $enddate = date('Y-m-t', strtotime($startdate)) ; 
            $d = date_parse_from_format("Y-m-d", $startdate);
            $month =  $d["month"]; 
            $datearr[$j]['startdate']=$startdate ; 
            $datearr[$j]['enddate']=$enddate ; 
            $datearr[$j]['month']=$month ; 

// get count of each user type between date 

 $Query = $this->Users->find('all');
  $Querydr = $this->Doctors->find('all');
  $Queryorg = $this->Organizations->find('all');

            $reslt = $Query->select([ 
                          'count' => $Query->func()->count('*')
                        ])
                 ->where(['created >=' => $startdate , 'created <=' => $enddate, 'role_id' => 2 , 'is_shown' => 1])
                 ->first(); 


            $resltdr = $Querydr->select([ 
                          'count' => $Querydr->func()->count('*')
                        ])
                 ->where(['created >=' => $startdate , 'created <=' => $enddate, 'is_shown' => 1])->first();

            $resltorg = $Queryorg->select([ 
                          'count' => $Queryorg->func()->count('*')
                        ])
                 ->where(['created >=' => $startdate , 'created <=' => $enddate, 'is_shown' => 1])->first();                 
       // pr($reslt);
       // pr($resltdr); 
       // pr($resltorg); 
                 $datearr[$j]['usrcnt'] = '';
                 // doctor - 1, patient - 2, organization - 3
                 $datearr[$j]['usrcnt'][1] = $resltdr->count;                   
                 $datearr[$j]['usrcnt'][2] = $reslt->count;
                 $datearr[$j]['usrcnt'][3] = $resltorg->count;

           
// get count of each user type between date            

            $startdate = date('Y-m-d', strtotime('-15 day', strtotime($startdate)));             

            $j++;
        }




       $this->set(compact('datearr','monthname','tot_user_count', 'tot_doc_count', 'tot_org_count', 'tot_app_count'));



       
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */  
}
