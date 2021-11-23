<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\Utility\Security;



/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class OrganizationsController extends AppController
{

    public function initialize()
    {
      parent::initialize();
      $this->loadComponent('Paginator');
      $this->loadComponent('CryptoSecurity');
      $this->loadComponent('General');
      $this->loadComponent('MailSend');
    }

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('Specializations');
        $organizations = $this->Organizations->find('all')->contain('Locations')->where(['is_shown' => 1])->order(['id' => 'DESC']);
        foreach ($organizations as $key => $value)
        {
            if(!empty($value->specialization_ids)){
                $value->specialization_ids = explode(',', $value->specialization_ids);
              $temp_space =  $this->Specializations->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'name'
                                    ])->where(['id IN' => $value->specialization_ids]);
            $specializations = $temp_space->toArray();
            $value->specialization_ids = implode(',', $specializations) ;
            // pr($value->specialization_ids); die;

            }
            //set the location
            $org_location = '';
            if(!empty($value->locations)){

                foreach ($value->locations as $lkey => $lvalue) {

                    $org_location .= !empty($lvalue->location) ? $lvalue->location.', ': '';
                }
            }
            $org_location = rtrim($org_location,', ');
            $value->org_location = $org_location;
        }
        $this->set(compact('organizations'));
    }

    public function add()
    {

        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $organizations = $this->Organizations->newEntity();
        $Users = $this->loadModel('Users');
        $this->loadModel('Specializations') ;
        $specializations = array();
        $temp_space =  $this->Specializations->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'name'
                                    ]);
        $specializations = $temp_space->toArray();

        if($this->request->is('post'))
        {

            $email = $this->request->data('email');
            if($email != '')
            {
                $checkUser = $Users->find('all')->where(['email' =>base64_encode($this->CryptoSecurity->encrypt($email,SEC_KEY))])->first();

                if(!empty($checkUser))
                {
                    $this->set(compact('specializations'));
                    return $this->Flash->adminerror(__('Clinic email already exists. Please, try again.'));
                }
            }



            if (!empty($this->request->data['clinic_logo']['name']))
            {
                $file = $this->request->data['clinic_logo'];
                $setNewFileName = time() . "_" . $file['name'];
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
                $this->request->data['clinic_logo'] = $setNewFileName;
            }
            else
            {
                unset($this->request->data['clinic_logo']);
            }

            if(!empty($this->request->data['clinic_data_dump']['name']))
            {
                $file = $this->request->data['clinic_data_dump'];
                $setNewFileName = time() . "_" . $file['name'];
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'clinic_data_dump/' . $setNewFileName);
                $this->request->data['clinic_data_dump'] = $setNewFileName;
            }
            else
            {
                unset($this->request->data['clinic_data_dump']);
            }

            if(!empty($this->request->data['specialization_ids']) && is_array($this->request->data['specialization_ids'])){

                $this->request->data['specialization_ids'] = implode(',', $this->request->data['specialization_ids']) ;
            }

            $org_slug = $this->General->slugify($this->request->data['org_url']);
            $this->request->data['org_url'] = $org_slug;
            $this->request->data['client_id'] = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
            $this->request->data['client_secret'] = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
            if($this->request->data['cl_group_id'] != '')
            {
                $this->request->data['cl_group_id'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['cl_group_id'],SEC_KEY));
            }
            $this->request->data['is_show_insurance'] = isset($this->request->data['is_show_insurance'])?1:0;
            $this->request->data['is_show_user_info'] = isset($this->request->data['is_show_user_info'])?1:0;
            $this->request->data['is_show_payment'] = isset($this->request->data['is_show_payment'])?1:0;
            $organizations = $this->Organizations->patchEntity($organizations, $this->request->getData());
            //pr($organizations->errors());die;
            if(!$organizations->errors()){

               $savedData =  $this->Organizations->save($organizations);
                if ($savedData) {

                    $newEntity = $Users->newEntity();
                    $newEntity->email = base64_encode($this->CryptoSecurity->encrypt($email,SEC_KEY));
                    $newEntity->role_id = 4;
                    $newEntity->organization_id = $savedData->id;
                    $saveOrg = $Users->save($newEntity);
                    if($saveOrg)
                    {
                         $savedData['user_id'] = $saveOrg['id'];
                         $this->Organizations->save($savedData);
                         $hashCode = sha1($saveOrg['id'] . rand(0, 100));
                         $activationLink = Router::url(['prefix' => 'organizations','controller' => 'Users','action' => 'reset_password',$hashCode], true);
                         $link = $activationLink;
                         $saveOrg->activation_link = $hashCode;
                         $this->Users->save($saveOrg);
                         $mailData = array();
                         $mailData['slug'] = 'Organization_reset_password'; // 'forgot_password';
                         $mailData['email'] = $email;
                         $mailData['replaceString'] = array('{username}','{activation_link}');
                         $mailData['replaceData'] = array($email,$link);
                         $this->MailSend->send( $mailData );
                         $this->Flash->adminsuccess(__('An activation link has been sent to Organizations e-mail,please check to reset organizations password.'));
                    }
                    else{
                        $this->Flash->error(__('Not Found!'));
                    }

                    $location = $this->request->data('location');
                    if(!empty($location) && is_array($location))
                    {
                        $locationTbl = TableRegistry::get('locations');
                        $location = array_filter($location);

                        $i  = 0;
                        foreach ($location as $key => $loc) {

                            $save_data[$i]['organization_id'] = $savedData['id'];
                            $save_data[$i]['location'] = $loc;
                            $i++;
                        }

                        $entities = $locationTbl->newEntities($save_data);
                        $data = $locationTbl->patchEntities($entities, $save_data);
                        $result =  $locationTbl->saveMany($entities);
                    }
                    $this->Flash->adminsuccess(__('Clinic has saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->adminerror(__('Clinic could not be saved. Please, try again.'));
            }
            else
            {
                $this->set('errors', $organizations->errors());
            }
        }
        


        $this->set(compact('organizations', 'specializations'));

    }


    public function downloadFile($filename=null) {
        $filePath = WWW_ROOT .'clinic_data_dump'. DS . $filename;
        // pr($filePath); die;
        $this->response->file($filePath ,
            array('download'=> true, 'name'=> $filename));
        return $this->response ;
    }


    public function edit($id = null)
    {
         $this->viewBuilder()->setLayout('admin');
         $this->Locations = TableRegistry::get('locations');
         $location = $this->Locations->find('all')->where(['organization_id' =>$id])->toArray();
        $organizations = $this->Organizations->get($id);
        $this->loadModel('Specializations') ;
        $this->loadModel('Users');

        $temp_space =  $this->Specializations->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'name'
                                    ]);
        $specializations = $temp_space->toArray();

        if(!empty($organizations) && $organizations['user_id'] != '')
        {
            $userData = $this->loadModel('Users')->find('all')->where(['id' =>$organizations['user_id']])->first();
        }
        if ($this->request->is(['patch', 'post', 'put'])) {

            $email = $this->request->data('email');

            if($email != '')
            {
                $checkUser = $this->Users->find('all')->where(['email' =>base64_encode($this->CryptoSecurity->encrypt($email,SEC_KEY))])->first();
                if(!empty($checkUser))
                {
                   $this->set(compact('specializations','organizations'));
                   return $this->Flash->adminerror(__('Clinic email already exists. Please, try again.'));
                }
            }


         if (!empty($this->request->data['clinic_logo']['name'])) {
            $file = $this->request->data['clinic_logo'];
            $setNewFileName = time() . "_" . $file['name'];
            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $setNewFileName);
            $this->request->data['clinic_logo'] = $setNewFileName;
        } else {
            unset($this->request->data['clinic_logo']);
        }


         if (!empty($this->request->data['clinic_data_dump']['name'])) {
            $file = $this->request->data['clinic_data_dump'];

             $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
             $setNewFileName =  time()."_file.".$ext ;
            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'clinic_data_dump/' . $setNewFileName);
            $this->request->data['clinic_data_dump'] = $setNewFileName;

            if(!empty($organizations->clinic_data_dump) &&  file_exists(WWW_ROOT . 'clinic_data_dump/'.$organizations->clinic_data_dump))
                 unlink(WWW_ROOT . 'clinic_data_dump/'.$organizations->clinic_data_dump);

        } else {
            unset($this->request->data['clinic_data_dump']);
        }


        if(!empty($this->request->data['specialization_ids']) && is_array($this->request->data['specialization_ids'])){

            $this->request->data['specialization_ids'] = implode(',', $this->request->data['specialization_ids']);

        }


            $org_slug = $this->General->slugify($this->request->data['org_url'],$id);

            $this->request->data['org_url'] = $org_slug;

            if($this->request->data['cl_group_id'] == ''){

                $this->Users->updateAll(['is_telehealth_provider' => 0, 'enable_telehealth' => 0],['organization_id' => $id]);
            }
            else{

                $this->request->data['cl_group_id'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['cl_group_id'],SEC_KEY));
            }
            //pr($this->request->data['is_show_insurance']); die;
            // Show insurance or not            
            $this->request->data['is_show_insurance'] = isset($this->request->data['is_show_insurance'])?1:0;
            $this->request->data['is_show_user_info'] = isset($this->request->data['is_show_user_info'])?1:0;
            $this->request->data['is_show_payment'] = isset($this->request->data['is_show_payment'])?1:0;

            $organizations = $this->Organizations->patchEntity($organizations, $this->request->getData());

            if(!$organizations->errors()){ 
                $savedData =  $this->Organizations->save($organizations);
                if ($savedData) {

                    if($email != ''){

                        $newEntity = $this->Users->newEntity();
                        $newEntity->email = base64_encode($this->CryptoSecurity->encrypt($email,SEC_KEY));
                        $newEntity->role_id = 4;
                        $newEntity->organization_id = $id;
                        $saveOrg = $this->Users->save($newEntity);
                        if($saveOrg)
                        {
                             $savedData['user_id'] = $saveOrg['id'];
                             $this->Organizations->save($savedData);
                             $hashCode = sha1($saveOrg['id'] . rand(0, 100));
                             $activationLink = Router::url(['prefix' => 'organizations','controller' => 'Users','action' => 'reset_password',$hashCode], true);
                             $link = $activationLink;
                             $saveOrg->activation_link = $hashCode;
                             $this->Users->save($saveOrg);
                             $mailData = array();
                             $mailData['slug'] = 'Organization_reset_password'; // 'forgot_password';
                             $mailData['email'] = $email;
                             $mailData['replaceString'] = array('{username}','{activation_link}');
                             $mailData['replaceData'] = array($email,$link);
                             $this->MailSend->send( $mailData );
                             $this->Flash->adminsuccess(__('An activation link has been sent to Organizations e-mail,please check to reset organizations password.'));
                        }
                        else{
                            $this->Flash->error(__('Not Found!'));
                        }
                    }
                    // $location = $this->request->data('location');

                    // if(!empty($location) && is_array($location))
                    // {
                    //     $locationTbl = TableRegistry::get('locations');

                    //     $locationTbl->deleteAll(array('organization_id' => $id));
                    //     $location = array_filter($location);

                    //     $i  = 0;

                    //     foreach ($location as $key => $loc) {

                    //         $save_data[$i]['organization_id'] = $id;
                    //         $save_data[$i]['location'] = $loc;
                    //         $i++;
                    //     }
                    //     $entities = $locationTbl->newEntities($save_data);
                    //     $data = $locationTbl->patchEntities($entities, $save_data);
                    //     $result =  $locationTbl->saveMany($entities);
                    // }

                    $this->Flash->adminsuccess(__('Clinic Updated.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->adminerror(__('Clinic could not be saved. Please, try again.'));
            }
        }

       
        if(!empty($organizations)){
            $organizations->specialization_ids = explode(',', $organizations->specialization_ids);

        }

        if(!empty($organizations) && !empty($organizations->cl_group_id)){

            $organizations->cl_group_id = $this->CryptoSecurity->decrypt(base64_decode($organizations->cl_group_id),SEC_KEY);
        }
        $this->set(compact('organizations', 'specializations','location','userData'));


    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('Specializations') ;
        $organizations = $this->Organizations->find('all')->contain(['Locations'])->where(['Organizations.id'=>$id])->first();
        if(!empty($organizations->specialization_ids)){
            $organizations->specialization_ids = explode(',', $organizations->specialization_ids);
          $temp_space =  $this->Specializations->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'name'
                                ])->where(['id IN' => $organizations->specialization_ids]);
        $specializations = $temp_space->toArray();

        $organizations->specialization_ids = implode(',', $specializations) ;
        // pr($organizations->specialization_ids); die;

        }

        $this->set('organizations', $organizations);
    }

    public function doctors()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $this->Doctors = TableRegistry::get('Doctors');
        $this->loadModel('Specializations');
       /* $doctors = $this->paginate($this->Doctors->find('all')->contain(['Organizations','Specializations'])
            ->where(['Doctors.is_shown' => 1])
            ->order(['Doctors.id' => 'DESC']));*/
            $doctors = $this->Doctors->find('all')->contain(['Organizations','Specializations'])
            ->where(['Doctors.is_shown' => 1])
            ->order(['Doctors.id' => 'DESC']);
         //pr($doctors->toArray()); die; //specialization_id
        foreach ($doctors as $k1 => $v1) {
            $temp1 = '';
        if(!empty(trim($v1->specialization_id))){

            $v1->specialization_id = explode(',', $v1->specialization_id);

           $temp =  $this->Specializations->find('all')->where(['id IN' => $v1->specialization_id ]);
           $v1->specialization_id = '';
           foreach ($temp as $key => $value) {
               $temp1 .= $value->name.', ';
           }


        }

        $v1->specialization_id = rtrim( $temp1, ', ');

        }


        $this->set(compact('doctors'));

    }

    public function addDoctor()
    {

        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $this->Doctors = TableRegistry::get('Doctors');
        $this->UserLocations = $this->loadModel('UserLocations');

        $this->Specializations = TableRegistry::get('Specializations');
        $this->Locations = TableRegistry::get('Locations');
        $all_organizations = $this->Organizations->find('list', ['keyField' => 'id','valueField' => 'organization_name'])->where(['is_shown' => 1])->toArray();

        $location = array();
        $specializations = array();
        //$location = $this->Locations->find('list', ['keyField' => 'id','valueField' => 'location'])->toArray();

        // $doctors = $this->Doctors->newEntity();
        if ($this->request->is('post')) {

            //pr($this->request->data());die;
            $input = $this->request->data();
            $organization_id = $this->request->getData('organization_id');
            $specialization_id = $this->request->getData('specialization_id');
            // pr($specialization_id); die;
            // $specialization_id = is_array($specialization_id) ? implode(',', $specialization_id) : $specialization_id;

            $doctor_name = $this->request->getData('doctor_name');

            $email = $this->request->getData('email');
            $credentials = $this->request->getData('credentials');


            $save_data = array();

            if(!empty($doctor_name) && is_array($doctor_name)){
                $i = 0;
                $doctor_name = array_unique($doctor_name);
                foreach ($doctor_name as $key => $value) {


                    $getSameDoctorInOrg = $this->Doctors->find('all')->where(['doctor_name' =>$value,'organization_id' =>$organization_id,'is_shown' =>1])->first();
                    if(!empty($getSameDoctorInOrg))
                    {
                        continue;
                    }
                    $save_data[$i]['organization_id'] = $organization_id ;
                    $save_data[$i]['specialization_id'] =  $specialization_id[$key] ;
                    $save_data[$i]['visit_reason_ids'] = isset($input['visit_reason_ids'][$key]) && $input['visit_reason_ids'][$key] != '' ? base64_encode($this->CryptoSecurity->encrypt(implode(',',$input['visit_reason_ids'][$key]),SEC_KEY)) : '';
                    $save_data[$i]['doctor_name'] = $value ;
                    $save_data[$i]['email'] = $email[$key];
                    $save_data[$i]['credentials'] = $credentials[$key];
                    $i++;
                }
            }

            if(!empty($save_data))
            {

            $entities = $this->Doctors->newEntities($save_data);
            $this->Doctors->patchEntities($entities, $save_data);


            if ($result =  $this->Doctors->saveMany($entities)) {
                //pr($result);die;

                $location = $this->request->data('location');


                if(!empty($location))
                {
                    if(!empty(array_filter($location)))
                    {
                        foreach($result as $key => $doctor)
                        {
                            if(isset($location[$key])){

                                if(!empty($location[$key]) && is_array($location[$key])){

                                    $location[$key] = array_filter($location[$key]);

                                    foreach ($location[$key] as $keys => $value) {

                                       $loc =  $this->UserLocations->newEntity();
                                       $loc->user_id = $doctor['id'];
                                       $loc->location_id = $value;
                                       $loc->user_type = 1;
                                       $saveData = $this->UserLocations->save($loc);
                                    }
                                }
                            }
                        }
                    }
                }

                $this->Flash->adminsuccess(__('Doctors have been saved.'));

                return $this->redirect(['action' => 'doctors']);
            }
            else
            {
            $this->Flash->adminerror(__('Could not saved, please try again.'));
            }
        }
        else
        {
            $this->Flash->adminerror(__('Doctor already exist, please try again.'));
        }

        }
        $this->set(compact( 'all_organizations', 'specializations','location'));

    }


    public function editDoctor($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $this->Doctors = TableRegistry::get('Doctors');
        $this->loadModel('Specializations');
        $this->loadModel('Locations');
        $this->loadModel('UserLocations');
        $this->StepDetails=TableRegistry::get('step_details');
        $all_organizations = $this->Organizations->find('list', ['keyField' => 'id','valueField' => 'organization_name'])->where(['is_shown' =>1])->toArray();
        $doctors = $this->Doctors->find('all')->contain(['UserLocations'])->where(['Doctors.id' =>$id,'is_shown' =>1])->first();
        $org_location = array();
        $doctor_location = array();
        $visit_reason_data = array();
        if(!empty($doctors))
        {
            $org_location = $this->Locations->find('list', ['keyField' => 'id','valueField' => 'location'])->where(['organization_id' =>$doctors['organization_id']])->toArray();
            $doctor_location = $this->UserLocations->find('list', ['keyField' => 'id','valueField' => 'location_id'])->where(['user_id' =>$id,'user_type' => 1])->toArray();
        }

        // List of visit reason on the basi of specialization
        if(!empty($doctors->specialization_id)){
     
        $specialization = $this->Specializations->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'intermediate_steps'
                                    ])->where(['id' => $doctors->specialization_id])->first();
        $step_ids = array();
        // pr($specialization);die;
        if(!empty($specialization))
        {
                $step_ids = explode(',', $specialization);
        }
        $visit_reason_data = array();
        $this->StepDetails = TableRegistry::get('step_details');
        $temp_visit_reasons =  $this->StepDetails->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'step_name'
                                    ])->where(['id IN' =>$step_ids]);
        $visit_reason_data = $temp_visit_reasons->toArray();
       }


       $temp_visit_reasons_ids = array();
        $temp_visit_reasons_ids = $doctors->visit_reason_ids ? $this->CryptoSecurity->decrypt(base64_decode($doctors->visit_reason_ids),SEC_KEY) : '';
        //pr($temp_visit_reasons_ids);die;
        $doctor_step_ids = array();
        if(!empty($temp_visit_reasons_ids))
        {
         $doctor_step_ids = explode(',', $temp_visit_reasons_ids);   
        }
       $doctorVisitReasons = array();
        $temp_doctor_visit_reasons = array();
        if(!empty($doctor_step_ids))
        {
            $temp_doctor_visit_reasons =  $this->StepDetails->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'step_name'
                                    ])->where(['id IN' =>$doctor_step_ids]);
            //pr($temp_provider_visit_reasons); die;
            if(!empty($temp_doctor_visit_reasons))
            {
                $doctorVisitReasons = array_flip($temp_doctor_visit_reasons->toArray());
            } 
        } 
        // end

        if ($this->request->is(['patch', 'post', 'put'])) {

        $input = $this->request->data();
        $this->request->data['specialization_id'] = !empty($this->request->data['specialization_id']) && is_array($this->request->data['specialization_id']) ? implode(',', $this->request->data['specialization_id']) : $this->request->data['specialization_id'] ;

        $this->request->data['visit_reason_ids'] = !empty($input['visit_reason_ids']) ? base64_encode($this->CryptoSecurity->encrypt(implode(',',$input['visit_reason_ids']),SEC_KEY)) : '';

           $doctor_name = $this->request->data['doctor_name'];
           $organization_id = $this->request->data['organization_id'];
           $getSameDoctorInOrg = $this->Doctors->find('all')->where(['doctor_name' =>$doctor_name,'organization_id' =>$organization_id,'is_shown' =>1,'id <>' => $id])->first();
            if(!empty($getSameDoctorInOrg))
            {
                $this->Flash->adminerror(__('Doctor already exists. Please, try again.'));
            }
            else
            {
            $doctors = $this->Doctors->patchEntity($doctors, $this->request->getData());
                if ($this->Doctors->save($doctors)) {
                    $this->UserLocations->deleteAll(array('user_id' => $id));
                    $location = $this->request->data('location');
                    if(is_array($location)){
                        $location = array_filter($location);
                    }
                    if(!empty($location))
                    {

                        foreach ($location as $key => $value) {
                            $loc =  $this->UserLocations->newEntity();
                            $loc->user_id = $id;
                            $loc->location_id = $value;
                            $loc->user_type = 1;
                            $saveData = $this->UserLocations->save($loc);
                        }
                    }
                    $this->Flash->adminsuccess(__('Doctor page has  Updated.'));
                    return $this->redirect(['action' => 'doctors']);
                }
                else
                {
                    $this->Flash->adminerror(__('Doctor could not be saved. Please, try again.'));
                }
           }


        }

        $all_org_specialization = $this->Organizations->find('all')->where(['id' => $doctors['organization_id'],'is_shown' =>1])->first();
        $org_speilization = explode(',',$all_org_specialization['specialization_ids']);

        $specializations = $this->Specializations->find('list', ['keyField' => 'id','valueField' => 'name'])->where(['id IN' => $org_speilization])->toArray();
        //pr($specializations);die;

        $this->set(compact('doctors','all_organizations', 'specializations','all_org_specialization','org_location','doctor_location','visit_reason_data','doctorVisitReasons'));

    }

     public function viewDoctor($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $this->Doctors = TableRegistry::get('Doctors');
        $this->loadModel('Specializations');
        $this->StepDetails = TableRegistry::get('step_details');
       $doctors = $this->Doctors->find('all')->contain(['Organizations','Specializations','UserLocations','UserLocations.Locations'])->where(['Doctors.id'=>$id,'Doctors.is_shown' => 1])->first();

       //pr($doctors);die;


       $v1 = $doctors ;

            $temp1 = '';
        if(!empty(trim($v1->specialization_id))){

            $v1->specialization_id = explode(',', $v1->specialization_id);

           $temp =  $this->Specializations->find('all')->where(['id IN' => $v1->specialization_id ]);
           $v1->specialization_id = '';
           foreach ($temp as $key => $value) {
               $temp1 .= $value->name.', ';
           }
           // pr($temp1); die;
           $v1->specialization_id = rtrim( $temp1, ', ');
           // pr($v1); die;
        }



       $doctors = $v1 ;

       $temp_visit_reasons_ids = array();
        $temp_visit_reasons_ids = $doctors->visit_reason_ids ? $this->CryptoSecurity->decrypt(base64_decode($doctors->visit_reason_ids),SEC_KEY) : '';
        // pr($temp_visit_reasons_ids);die;
        $doctor_step_ids = array();
        if(!empty($temp_visit_reasons_ids))
        {
         $doctor_step_ids = explode(',', $temp_visit_reasons_ids);   
        }
       $doctorVisitReasons = array();
        $temp_doctor_visit_reasons = array();
        if(!empty($doctor_step_ids))
        {
            $temp_doctor_visit_reasons =  $this->StepDetails->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'step_name'
                                    ])->where(['id IN' =>$doctor_step_ids]);
        // pr($temp_doctor_visit_reasons->toArray()); die;
            // if(!empty($temp_doctor_visit_reasons))
            // {
            //     $doctorVisitReasons = array_flip($temp_doctor_visit_reasons->toArray());
            // } 
        }
        // pr($doctorVisitReasons);die;

        // $doctors = $this->Doctors->find('all')->where(['id'=>$id])->first();
        $this->set('doctor', $doctors);
        $this->set('temp_doctor_visit_reasons', $temp_doctor_visit_reasons);
    }




    public function delete($id=null)
    {

        $this->Users = TableRegistry::get('Users');
        $organizationsObj = TableRegistry::get('Organizations');
        $this->Doctors = TableRegistry::get('Doctors');
        $location = TableRegistry::get('locations');
        $organization = $organizationsObj->get($id);
        $organization->is_shown = 0;
        $organizationsObj->save($organization);

        if(!empty($organization))
        {
            $location->deleteAll(['organization_id' => $id]);
            $this->Users->updateAll(['is_shown' =>0],['organization_id' => $id]);
            $this->Doctors->updateAll(['is_shown' =>0],['organization_id' => $id]);
        }

        $this->Flash->adminsuccess(__('The Clinic has been deleted.'));
        return $this->redirect(['action'=>'index']);
    }




    public function standardOpenemrOutput($id=null, $status = 0)
    {

        $Cms_pages = TableRegistry::get('Organizations');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->standard_openemr_output = $status;
        $Cms_pages->save($cms_pages);
        if($status == 1){
              $this->Flash->adminsuccess(__('OPEN-EMR output format enabled successfully.'));
        }else{
              $this->Flash->adminsuccess(__('Standard output format enabled successfully.'));
        }

        return $this->redirect(['action'=>'index']);

    }

    public function maketestclinic($id=null, $status = 0)
    {

        $Cms_pages = TableRegistry::get('Organizations');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->make_test_clinic = $status;
        $Cms_pages->save($cms_pages);
        if($status == 1){
              $this->Flash->adminsuccess(__('This clinic becomes test clinic.'));
        }else{
                $this->Flash->adminsuccess(__('Test clinic status removed.'));
        }

        return $this->redirect(['action'=>'index']);

    }


    public function deleteDoctor($id=null)
    {

        $doctorObj = TableRegistry::get('Doctors');
        $userLocationsObj = TableRegistry::get('user_locations');
        $doctor = $doctorObj->get($id);
        $doctor->is_shown = 0;
        $doctorObj->save($doctor);
        if(!empty($doctor))
        {
             $userLocationsObj->deleteAll(['user_id' => $id]);
        }
        $this->Flash->adminsuccess(__('The doctor has been deleted.'));
        return $this->redirect($this->referer());
        //return $this->redirect(['action'=>'doctors']);

    }

    public function active($id=null)
    {
        $Cms_pages = TableRegistry::get('Organizations');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 1;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Organization has been activated.'));
        return $this->redirect(['action'=>'index']);
    }

    public function deactive($id=null)
    {
        $Cms_pages = TableRegistry::get('Organizations');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Organization has been deactivated.'));
        return $this->redirect(['action'=>'index']);
    }

    public function activeDoctor($id=null)
    {
        $Cms_pages = TableRegistry::get('Doctors');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 1;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Doctor has been activated.'));
        return $this->redirect($this->referer());
        //return $this->redirect(['action'=>'doctors']);
    }

    public function deactiveDoctor($id=null)
    {
        $Cms_pages = TableRegistry::get('Doctors');
        $cms_pages = $Cms_pages->get($id);
        $cms_pages->status = 0;
        $Cms_pages->save($cms_pages);
        $this->Flash->success(__('The Doctor has been deactivated.'));
        return $this->redirect($this->referer());
       // return $this->redirect(['action'=>'doctors']);
    }


    public function clinicColorScheme($id = null){

          $this->viewBuilder()->setLayout('admin');

          $organizations = TableRegistry::get('Organizations');
        $organizations = $organizations->get($id);

        if($this->request->is(['post', 'put'])){
// pr($this->request->data); die;
            $this->Organizations->patchEntity($organizations, $this->request->data);

            if($this->Organizations->save($organizations)){
                 $this->Flash->adminsuccess(__('Color scheme saved successfully.'));
            }else {
                $this->Flash->adminerror(__('Could not save.'));
            }

        }

        $this->set(compact('organizations'));

    }


    public function addProviders($org_id = null){


        $this->viewBuilder()->setLayout('admin');
        $this->Locations = $this->loadModel('Locations');
        $this->UserLocations = $this->loadModel('UserLocations');

        $organization = $this->Organizations->find('all')->where(['id'=>$org_id])->first();

        $location =  $this->Locations->find('list', ['keyField' => 'id','valueField' => 'location'])->where(['organization_id' =>$org_id])->toArray();

        if ($this->request->is('post')) {

            $input = $this->request->data();

            if(isset($input['organization_id']) && !empty($input['organization_id'])){

                $provider                       = TableRegistry::get('Users');
                $FieldSettingTbl                = TableRegistry::get('ScheduleFieldSettings');
                $ColumnSettingTbl               = TableRegistry::get('ProviderDisplayColumns');
                $ProviderEmailTemplatesTlb      = TableRegistry::get('ProviderEmailTemplates');
                $EmailTemplateTlb               = TableRegistry::get('EmailTemplates');
                $ProviderGlobalSettingsTlb      = TableRegistry::get('ProviderGlobalSettings');

                //pr($EmailTemplateTlb);die;

                $emailTemplates = $EmailTemplateTlb->find('all')->where(['slug IN' => ['pre_appointment_reminder','pre_appointment_form_link','telehealth_reminder','telehealth_reminder_before_x_time','api_notification']])->toArray();
                $save_data = array();
                $provider_emails = array_filter(array_unique($input['email']));
                $unique_cl_provider_id = array_filter(array_unique($input['cl_provider_id']));
                // pr($unique_cl_provider_id);
                // pr($provider_emails);die;


                if(!empty($provider_emails)){

                    $i  = 0;

                    foreach ($provider_emails as $key => $mail) {

                        /*if(!isset($unique_cl_provider_id[$key])){

                            continue;
                        }*/

                        $save_data[$i]['organization_id'] = $input['organization_id'];
                        $save_data[$i]['email'] = base64_encode($this->CryptoSecurity->encrypt($mail,SEC_KEY));
                        $save_data[$i]['password'] =$input['password'][$key];
                        $save_data[$i]['confirm_password'] = $input['confirm_password'][$key];
                        $save_data[$i]['role_id'] = 3;
                        $save_data[$i]['note_formating'] = 'abbr';
                        $save_data[$i]['cl_provider_id'] = isset($input['cl_provider_id'][$key]) && $input['cl_provider_id'][$key] != '' ? base64_encode($this->CryptoSecurity->encrypt($input['cl_provider_id'][$key],SEC_KEY)) : '';
                        $save_data[$i]['provider_secret'] =  base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
                        $i++;
                    }

                   // pr($save_data);die;

                    $entities = $provider->newEntities($save_data);
                    //pr($entities);die;
                    $data = $provider->patchEntities($entities, $save_data);

                    $errors = "";
                    foreach ($data as $data_key => $data_value) {

                       if($data_value->errors()){

                        foreach ($data_value->errors() as $err_key => $err_value) {

                            foreach ($err_value as $err_k => $err_v) {
                               $errors .= $err_v.", ";
                            }
                        }

                        $errors = rtrim($errors,', ');
                        $this->Flash->adminerror($errors);
                        return $this->redirect($this->referer());
                       }
                    }

                    if ($result =  $provider->saveMany($entities)) {


                            $location = $this->request->data('location');

                            if(!empty($location))
                            {
                                    if(!empty(array_filter($location)))
                                    {
                                        foreach($result as $key => $provider)
                                        {
                                            if(isset($location[$key])){

                                                if(!empty($location[$key]) && is_array($location[$key])){

                                                    $location[$key] = array_filter($location[$key]);
                                                    foreach ($location[$key] as $keys => $value) {

                                                       $loc =  $this->UserLocations->newEntity();
                                                       $loc->user_id = $provider['id'];
                                                       $loc->location_id = $value;
                                                       $loc->user_type = 2;
                                                       $saveData = $this->UserLocations->save($loc);
                                                    }
                                                }
                                            }
                                        }
                                    }
                        }
                        $provider_schedule_fields = array();
                        $i  = 0;

                        foreach($result as $added_provider){

                            $provider_schedule_fields = array(

                                0 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'File Type',
                                    'field_name' => 'file_type',
                                    'field_index' => 'csv'
                                ),

                                1 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Excel/CSV Read By',
                                    'field_name' => 'read_by',
                                    'field_index' => 2
                                ),
                                2 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Appointment Reason',
                                    'field_name' => 'appointment_reason',
                                    'field_index' => 12
                                ),

                                3 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Reading Column Index',
                                    'field_name' => 'single_column_index',
                                    'field_index' => 4
                                ),

                                4 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'First Name',
                                    'field_name' => 'first_name',
                                    'field_index' => 1
                                ),

                                5 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Last Name',
                                    'field_name' => 'last_name',
                                    'field_index' => 2
                                ),
                                6 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Gender',
                                    'field_name' => 'gender',
                                    'field_index' => 8
                                ),

                                7 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Email',
                                    'field_name' => 'email',
                                    'field_index' => 3
                                ),

                                8 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Mrn Number',
                                    'field_name' => 'mrn',
                                    'field_index' => 4
                                ),

                                9 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Doctor Name',
                                    'field_name' => 'doctor_name',
                                    'field_index' => 5
                                ),

                                10 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Phone',
                                    'field_name' => 'phone',
                                    'field_index' => 6
                                ),

                                11 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Dob',
                                    'field_name' => 'dob',
                                    'field_index' => 7
                                ),

                                12 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Starting Row Number of Patient Data (inclusive)',
                                    'field_name' => 'starting_row',
                                    'field_index' => 1
                                ),

                                13 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Ending Row Number of Patient Data (inclusive)',
                                    'field_name' => 'ending_row',
                                    'field_index' => -1
                                ),
                                

                            );

                            $entities1 = $FieldSettingTbl->newEntities($provider_schedule_fields);
                            //pr($entities);die;
                            $data1 = $FieldSettingTbl->patchEntities($entities1, $provider_schedule_fields);
                            $FieldSettingTbl->saveMany($entities1);


                            //save provider table display columns settings

                            $provider_display_columns = array(

                                0 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'First Name',
                                    'field_name' => 'first_name',
                                    'is_show' => 1
                                ),

                                1 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Last Name',
                                    'field_name' => 'last_name',
                                    'is_show' => 1
                                ),

                                2 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Email',
                                    'field_name' => 'email',
                                    'is_show' => 1
                                ),

                                3 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Mrn Number',
                                    'field_name' => 'mrn',
                                    'is_show' => 1
                                ),

                                4 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Doctor Name',
                                    'field_name' => 'doctor_name',
                                    'is_show' => 1
                                ),

                                5 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Phone',
                                    'field_name' => 'phone',
                                    'is_show' => 1
                                ),

                                6 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Dob',
                                    'field_name' => 'dob',
                                    'is_show' => 1
                                ),

                                7 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Appointment Date',
                                    'field_name' => 'appointment_date',
                                    'is_show' => 1
                                ),

                                8 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Appointment Time',
                                    'field_name' => 'appointment_time',
                                    'is_show' => 1
                                ),

                                9 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Appointment Reason',
                                    'field_name' => 'appointment_reason',
                                    'is_show' => 1
                                ),
                                10 => array(

                                    'provider_id' => $added_provider->id,
                                    'title' => 'Gender',
                                    'field_name' => 'gender',
                                    'is_show' => 1
                                )

                            );

                            $entities1 = $ColumnSettingTbl->newEntities($provider_display_columns);
                            $data1 = $ColumnSettingTbl->patchEntities($entities1, $provider_display_columns);
                            $ColumnSettingTbl->saveMany($entities1);

                            //save provider email templates

                            if(count($emailTemplates)){

                                $email_template_data = array();

                                foreach ($emailTemplates as $email_key => $email_value) {

                                    $email_template_data[] = array(

                                        'provider_id' => $added_provider->id,
                                        'name' => $email_value->name,
                                        'slug' => $email_value->slug,
                                        'subject' => $email_value->subject,
                                        'description' => $email_value->description,
                                        'text_message' => $email_value->text_message
                                    );
                                }

                                $entities1 = $ProviderEmailTemplatesTlb->newEntities($email_template_data);
                                $data1 = $ProviderEmailTemplatesTlb->patchEntities($entities1, $email_template_data);
                                $ProviderEmailTemplatesTlb->saveMany($entities1);
                            }

                            //set the default provider global setting

                            $global_setting = $ProviderGlobalSettingsTlb->newEntity();
                            $global_setting->provider_id = $added_provider->id;
                            $global_setting->patient_intake_before_appointment_reminder_time = 45;
                            $global_setting->telehealth_appointment_reminder_time = 10;
                            $ProviderGlobalSettingsTlb->save($global_setting);

                        }

                        //pr($result);die;

                        $this->Flash->adminsuccess(__('Providers have been saved.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    else {

                        $this->Flash->adminerror(__('Could not saved, please try again.'));
                    }


                }
            }

        }
        $this->set(compact( 'organization','location'));
    }


    public function providers(){


        $this->viewBuilder()->setLayout('admin');
        $this->Users = TableRegistry::get('Users');
        //$users = $this->paginate($this->Users->find('all')->contain(['Organizations'])->where(['Users.role_id' => 3])->order(['Users.id' => 'DESC']));
        $users =$this->Users->find('all')->contain(['Organizations','UserLocations.Locations'])->where(['Users.role_id' => 3,'Users.is_shown' =>1])->order(['Users.id' => 'DESC'])->toArray();


        $this->set(compact('users'));
    }

    public function deleteProvider($id=null)
    {

        $usersTlb                       = TableRegistry::get('Users');
        $FieldSettingTbl                = TableRegistry::get('ScheduleFieldSettings');
        $ColumnSettingTbl               = TableRegistry::get('ProviderDisplayColumns');
        $ProviderEmailTemplatesTlb      = TableRegistry::get('ProviderEmailTemplates');
        $ProviderGlobalConfigTlb      = TableRegistry::get('ProviderGlobalSettings');
        $userLocationsObj = TableRegistry::get('user_locations');

        $user = $usersTlb->get($id);
        if(!empty($user->privacy_policy_docs) && file_exists(WWW_ROOT.'uploads/ancillary_docs/'.$user->privacy_policy_docs)){

            @unlink(WWW_ROOT.'uploads/ancillary_docs/'.$user->privacy_policy_docs);
        }

        if(!empty($user->treatment_consent_docs) && file_exists(WWW_ROOT.'uploads/ancillary_docs/'.$user->treatment_consent_docs)){

            @unlink(WWW_ROOT.'uploads/ancillary_docs/'.$user->treatment_consent_docs);
        }

        if($usersTlb->delete($user)){
            $FieldSettingTbl->deleteAll(['provider_id' => $id]);
            $ColumnSettingTbl->deleteAll(['provider_id' => $id]);
            $ProviderEmailTemplatesTlb->deleteAll(['provider_id' => $id]);
            $ProviderGlobalConfigTlb->deleteAll(['provider_id' => $id]);
            $userLocationsObj->deleteAll(['user_id' => $id]);
            $this->Flash->adminsuccess(__('The Provider has been deleted.'));

        }else{

            $this->Flash->adminerror(__('Something went wrong, Please try again.'));
        }

        //return $this->redirect(['action'=>'providers']);
        return $this->redirect($this->referer());

    }


    public function editProvider($id = null)
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $this->Users = TableRegistry::get('Users');
        $this->Locations = $this->loadModel('Locations');
        $this->UserLocations = $this->loadModel('UserLocations');

        $all_organizations = $this->Organizations->find('list', ['keyField' => 'id','valueField' => 'organization_name'])->where(['is_shown' =>1])->toArray();


        $user = $this->Users->get($id);

        $org_location = $this->Locations->find('list', ['keyField' => 'id','valueField' => 'location'])->where(['organization_id' =>$user['organization_id']])->toArray();

        $provider_location = $this->UserLocations->find('list', ['keyField' => 'id','valueField' => 'location_id'])->where(['user_id' =>$id,'user_type' => 2])->toArray();



        if ($this->request->is(['patch', 'post', 'put'])) {

            $input = $this->request->data();
            if(!empty($this->request->data['email'])){
                $this->request->data['email'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['email'],SEC_KEY));
            }
            if(empty($input['password'])){

               unset($this->request->data['password']);
               unset($this->request->data['confirm_password']);
            }
            if($this->request->data['cl_provider_id'] == ''){

               $this->request->data['is_telehealth_provider'] = 0;
               $this->request->data['enable_telehealth'] = 0 ;
            }
            else{

                $this->request->data['cl_provider_id'] = base64_encode($this->CryptoSecurity->encrypt($this->request->data['cl_provider_id'],SEC_KEY));
            }
            $this->request->data['is_allow_analytics'] = isset($this->request->data['is_allow_analytics'])?1:0;
            $this->request->data['is_hide_summary'] = isset($this->request->data['is_hide_summary'])?1:0;

            $user = $this->Users->patchEntity($user, $this->request->getData());
            //pr($user);die;
            if (!$user->errors())
            {
                $this->Users->save($user);
                $location = $this->request->data('location');
                if(is_array($location)){
                    $location = array_filter($location);
                }
                if(!empty($location))
                {
                    $this->UserLocations->deleteAll(array('user_id' => $id));

                    foreach ($location as $key => $value) {
                        $loc =  $this->UserLocations->newEntity();
                        $loc->user_id = $id;
                        $loc->location_id = $value;
                        $loc->user_type = 2;
                        $saveData = $this->UserLocations->save($loc);
                    }
                }
                $this->Flash->adminsuccess(__('Provider has  Updated.'));
                return $this->redirect(['action' => 'providers']);
            }
            //$this->Flash->adminerror(__('Provider could not be saved. Please, try again.'));
        }

        $this->set(compact('user','all_organizations','org_location','provider_location'));
    }


    public function getspecialization(){

        $this->autoRender = false;

        $clinic_id = $this->request->query('clinic_id');
       if(!empty($clinic_id)){

        $all_org_specialization = $this->Organizations->find('all')->where(['id'=> $clinic_id])->first();
        $specializations = explode(',', $all_org_specialization['specialization_ids']);

        $this->loadModel('Specializations');
        $specializations_data = $this->Specializations->find('list', ['keyField' => 'id','valueField' => 'name'])->where(['id IN' => $specializations])->toArray();

         $response = array('success' => true,'specializations_data' => $specializations_data);
          echo json_encode($response);
          die;

       }

        $response = array('success' => false,'msg' => 'clinic id is required');
        echo json_encode($response);
        die;
    }

    public function getSpecializationLocation(){

        $this->autoRender = false;

        $clinic_id = $this->request->query('clinic_id');
       if(!empty($clinic_id)){

        $all_org_specialization = $this->Organizations->find('all')->where(['id'=> $clinic_id])->first();
        $specializations = explode(',', $all_org_specialization['specialization_ids']);

        $this->loadModel('Specializations');
        $specializations_data = $this->Specializations->find('list', ['keyField' => 'id','valueField' => 'name'])->where(['id IN' => $specializations])->toArray();
        if(!empty($specializations_data)) 
        {
            $step_ids = array();
            //$specialization_id = array_key_first($specializations_data);
            $specialization_id = !empty($specializations_data)? array_keys($specializations_data)[0]:1;
            $this->loadModel('Specializations');       
            $specialization = $this->Specializations->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'intermediate_steps'
                                    ])->where(['id' => $specialization_id])->first();
            if(!empty($specialization))
            {
                    $step_ids = explode(',', $specialization);
            }
            $visit_reason_data = array();
            $this->StepDetails = TableRegistry::get('step_details');
            $temp_visit_reasons =  $this->StepDetails->find('list', [
                                            'keyField' => 'id',
                                            'valueField' => 'step_name'
                                        ])->where(['id IN' =>$step_ids]);
            $visit_reason_data = $temp_visit_reasons->toArray();  
        }      

        //get the organization location
        $this->loadModel('Locations');
        $location_data = $this->Locations->find('list', ['keyField' => 'id','valueField' => 'location'])->where(['organization_id' => $clinic_id])->toArray();

        $response = array('success' => true,'specializations_data' => $specializations_data,'location_data' => $location_data,'visit_reason_data'=>$visit_reason_data);
          echo json_encode($response);
          die;

       }

        //$response = array('success' => false,'msg' => 'clinic id is required');
        $response = array('success' => false,'specializations_data' => [],'location_data' => [],'msg' => 'clinic id is required');
        echo json_encode($response);
        die;
    }
    public function getVisitReasons(){



        $this->autoRender = false;

        $specialization_id = $this->request->query('specialization_id');
        // Find all list of step_dtail as per organization
        if(!empty($specialization_id)){

        $this->loadModel('Specializations');       
        $specialization = $this->Specializations->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'intermediate_steps'
                                    ])->where(['id' => $specialization_id])->first();
        $step_ids = array();
        if(!empty($specialization))
        {
                $step_ids = explode(',', $specialization);
        }
        $visit_reason_data = array();
        $this->StepDetails = TableRegistry::get('step_details');
        $temp_visit_reasons =  $this->StepDetails->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'step_name'
                                    ])->where(['id IN' =>$step_ids]);
        $visit_reason_data = $temp_visit_reasons->toArray();
        //pr($visit_reason_data);die;

         $response = array('success' => true,'visit_reason_data' => $visit_reason_data);
         echo json_encode($response);
         die;
       }

        $response = array('success' => false,'msg' => 'specialization id is required');
        echo json_encode($response);
        die;
    }

     public function getlocation(){



        $this->autoRender = false;

        $clinic_id = $this->request->query('clinic_id');
        if(!empty($clinic_id)){

        $locationTbl = TableRegistry::get('locations');

       // $location = $locationTbl->find('all')->where(['organization_id'=> $clinic_id])->first();

       // $locations = explode(',', $location['id']);

        //$this->loadModel('Specializations');
        $locations_data = $locationTbl->find('list', ['keyField' => 'id','valueField' => 'location'])->where(['organization_id' => $clinic_id])->toArray();
        //pr($locations_data);die;

         $response = array('success' => true,'locations_data' => $locations_data);
         echo json_encode($response);
         die;
       }

        $response = array('success' => false,'msg' => 'clinic id is required');
        echo json_encode($response);
        die;
    }


    public function outputFormat($org_id = null){
        $this->viewBuilder()->setLayout('admin');
         $org_data = $this->Organizations->find('all')->where(['id'=> base64_decode($org_id)])->first();

         $org_format = 0;

         if(!empty($org_data)){

           if($org_data['standard_openemr_output'] == 0){

                $org_format = 1;
           }
           elseif($org_data['standard_openemr_output'] == 1){

                $org_format = 2;
           }
           if($org_data['standard_openemr_output'] == 2){

                $org_format = 3;
           }
         }

         if($this->request->is(['post', 'put'])) {

           // pr($this->request->data);

           $output_format = $this->request->data['format']-1;

           $org_data->standard_openemr_output = $output_format;

           if($this->Organizations->save($org_data)){
                $this->Flash->adminsuccess(__('Output format updated.'));
                return $this->redirect(['action' => 'index']);
           }
           $this->Flash->adminsuccess(__('Output format not updated, Please try again.'));
            return $this->referer();
         }
        // pr($org_data);die;
         $this->set(compact('org_format','org_data'));
    }

    public function enabletelehealth($id=null, $status = 0)
    {

        $Users = TableRegistry::get('Users');
        $Organizations = TableRegistry::get('Organizations');
        $user_detail = $Users->get($id);
        if(!empty($user_detail)){

            if(empty($user_detail->cl_provider_id)){

                $this->Flash->adminerror(__('Please add callidus provider id.'));
                return $this->redirect(['action'=>'providers']);
            }
            $organizations_detail = $Organizations->find('all')->where(['id' => $user_detail->organization_id])->first();
            if(!empty($organizations_detail)){

                if(empty($organizations_detail->cl_group_id)){

                    $this->Flash->adminerror(__('Please add callidus group id.'));
                    return $this->redirect(['action'=>'providers']);
                }
            }
            else{

                $this->Flash->adminerror(__('Clinic not found.'));
                return $this->redirect(['action'=>'providers']);
            }

            $user_detail->enable_telehealth = $status;
            if($status != 1){

                $user_detail->is_telehealth_provider = 0;
            }
            $Users->save($user_detail);
            if($status == 1){
                  $this->Flash->adminsuccess(__('Telehealth enabled successfully.'));
            }else{
                    $this->Flash->adminsuccess(__('Telehealth disabled successfully.'));
            }

        }
        else{

            $this->Flash->adminerror(__('Provider not found.'));
        }

        //return $this->redirect(['action'=>'providers']);
        return $this->redirect($this->referer());

    }

    public function clinicDoctorList($clinicid=null)
    {
        $this->viewBuilder()->setLayout('admin');
        $clinicid = base64_decode($clinicid);
        $doctor = TableRegistry::get('Doctors');
        $organizations = $this->Organizations->get($clinicid);
        $doctorList = $doctor->find('all')->contain(['Specializations'])->where(['organization_id' => $clinicid,'Doctors.is_shown' => 1])->toArray();
        $this->set(compact('doctorList','organizations'));
    }

    public function clinicProviderList($clinicid=null)
    {
        $this->viewBuilder()->setLayout('admin');
        $clinicid = base64_decode($clinicid);
        $provider  = TableRegistry::get('Users');
        $organizations = $this->Organizations->get($clinicid);
        $providerList = $provider->find('all')->where(['organization_id' => $clinicid,'role_id' => 3])->toArray();
        $this->set(compact('providerList','organizations'));

    }

    public function generateOrganizationSecret()
    {
         $this->autoRender = false;
         if($this->request->is(['ajax'])){
         $organizationId = $this->request->data['organizationsId'];
         $credentials = $this->Organizations->find('all')->where(['id' =>$organizationId])->first();
         $this->Organizations->updateAll(['show_credential' =>1],['id' => $organizationId]);

         $credentials->client_id = $this->CryptoSecurity->decrypt(base64_decode($credentials->client_id),SEC_KEY);
         $credentials->client_secret = $this->CryptoSecurity->decrypt(base64_decode($credentials->client_secret),SEC_KEY);

         $response = array('success' => true,'show_credential' => 1,'client_id' =>$credentials->client_id,'client_secret' =>$credentials->client_secret);
         echo json_encode($response);
         }
         die;
    }

    public function showProSecret()
    {
         $this->autoRender = false;
         $providerId = $this->request->data['providerId'];

         $this->Users = TableRegistry::get('Users');
         $credentials = $this->Users->find('all')->where(['id' =>$providerId])->first();
         $this->Users->updateAll(['show_credential' =>1],['id' => $providerId]);
         $response = array('success' => true,'provider_secret' => $this->CryptoSecurity->decrypt(base64_decode($credentials->provider_secret),SEC_KEY));
         echo json_encode($response);
         die;
    }

    public function generateProviderSecret($id)
    {
        $userid = base64_decode($id);
        $provider  = TableRegistry::get('Users');
        $provider_secret = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
        $provider->updateAll(['provider_secret' =>$provider_secret,'show_credential' =>0],['id' => $userid]);
        $this->Flash->adminsuccess(__('Credentials generated successfully'));
        return $this->redirect($this->referer());
    }

    public function generateorgsecret($id)
    {
        $organizationId = base64_decode($id);
        $clientId = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
        $client_secret = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
        $this->Organizations->updateAll(['client_id' =>$clientId,'client_secret' => $client_secret,'show_credential' => 0],['id' => $organizationId]);
        $this->Flash->adminsuccess(__('Credentials generated successfully.'));
        return $this->redirect($this->referer());
    }

    // public function acceptRequest($id)
    // {
    //        $login_user = $this->Auth->user();
    //        $organizationId = base64_decode($id);
    //        $this->loadModel('Organizations');
    //        $organizationData = $this->Organizations->find('all')->where(['id' =>$organizationId])->first();
    //        $users  = TableRegistry::get('Users');
    //        $UsrData = $users->find('all')->where(['id' =>$organizationData['user_id']])->first();
    //        $this->Organizations->updateAll(['is_request_accept' => 2,'is_show_secret_key' =>0],['id' => $organizationId]);
    //        $userEmail = $this->CryptoSecurity->decrypt(base64_decode($UsrData['email']),SEC_KEY);
    //        $mailData = array();
    //        $mailData['slug'] = 'accept_request_organization';
    //        $mailData['email'] = $userEmail;
    //        $mailData['replaceString'] = array('{clinic}','{action}');
    //        $mailData['replaceData'] = array($organizationData['organization_name'],'accepted');
    //        $this->MailSend->send( $mailData );
    //        $this->Flash->providersuccess(__('Request accepted successfully.'));
    //        return $this->redirect($this->referer());
    // }

    // public function rejectrequest($id)
    // {
    //        $login_user = $this->Auth->user();
    //        $organizationId = base64_decode($id);
    //        $this->loadModel('Organizations');
    //        $organizationData = $this->Organizations->find('all')->where(['id' =>$organizationId])->first();
    //        $users  = TableRegistry::get('Users');
    //        $UsrData = $users->find('all')->where(['id' =>$organizationData['user_id']])->first();
    //        $this->Organizations->updateAll(['is_request_accept' => 0,'is_show_secret_key' =>2],['id' => $organizationId]);
    //        $userEmail = $this->CryptoSecurity->decrypt(base64_decode($UsrData['email']),SEC_KEY);
    //        $mailData = array();
    //        $mailData['slug'] = 'accept_request_organization';
    //        $mailData['email'] = $userEmail;
    //        $mailData['replaceString'] = array('{clinic}','{action}');
    //        $mailData['replaceData'] = array($organizationData['organization_name'],'rejected');
    //        $this->MailSend->send( $mailData );
    //        $this->Flash->providersuccess(__('Request rejected successfully.'));
    //        return $this->redirect($this->referer());
    // }

    // public function sendAcknowledgement($id)
    // {
    //        $login_user = $this->Auth->user();
    //        $organizationId = base64_decode($id);
    //        $this->loadModel('Organizations');
    //        $organizationData = $this->Organizations->find('all')->where(['id' =>$organizationId])->first();
    //        $users  = TableRegistry::get('Users');
    //        $UsrData = $users->find('all')->where(['id' =>$organizationData['user_id']])->first();
    //        $this->Organizations->updateAll(['is_generate_new_key' => 0],['id' => $organizationId]);
    //        $userEmail = $this->CryptoSecurity->decrypt(base64_decode($UsrData['email']),SEC_KEY);
    //        $mailData = array();
    //        $mailData['slug'] = 'generate_new_key_acknowledgement';
    //        $mailData['email'] = $userEmail;
    //        $mailData['replaceString'] = array('{clinic}');
    //        $mailData['replaceData'] = array($organizationData['organization_name']);

    // }

    public function secretkeyaction($id,$action)
    {
           $login_user = $this->Auth->user();
           $organizationId = base64_decode($id);
           $this->loadModel('Organizations');
           $organizationData = $this->Organizations->find('all')->where(['id' =>$organizationId])->first();
           $users  = TableRegistry::get('Users');
           $UsrData = $users->find('all')->where(['id' =>$organizationData['user_id']])->first();
           if(isset($action) && $action != '')
           {
                   if($action == 3)
                   {
                        //get and update the secret of all providers of organization
                        $providers_list = $users->find('all')->where(['organization_id' => $organizationId])->toArray();
                        if(!empty($providers_list)){

                            foreach ($providers_list as $key => $value) {

                               $provider_secret = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
                               $value->provider_secret = $provider_secret;
                               $users->save($value);
                            }
                        }
                        //generate new org keys and update

                        $clientId = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
                        $client_secret = base64_encode($this->CryptoSecurity->encrypt($this->General->generateClientSecret(),SEC_KEY));
                       $this->Organizations->updateAll(['is_generate_new_key' => 0,'client_id' => $clientId, 'client_secret' => $client_secret],['id' => $organizationId]);
                       $userEmail = $this->CryptoSecurity->decrypt(base64_decode($UsrData['email']),SEC_KEY);
                       $mailData = array();
                       $mailData['slug'] = 'generate_new_key_acknowledgement';
                       $mailData['email'] = $userEmail;
                       $mailData['replaceString'] = array('{clinic}');
                       $mailData['replaceData'] = array($organizationData['organization_name']);
                       $message = 'Mail sent successfully to organizations for generated new key';
                   }
                   else if($action == 2)
                   {
                       $this->Organizations->updateAll(['is_request_accept' => 0,'is_show_secret_key' =>2],['id' => $organizationId]);
                       $userEmail = $this->CryptoSecurity->decrypt(base64_decode($UsrData['email']),SEC_KEY);
                       $mailData = array();
                       $mailData['slug'] = 'accept_request_organization';
                       $mailData['email'] = $userEmail;
                       $mailData['replaceString'] = array('{clinic}','{action}');
                       $mailData['replaceData'] = array($organizationData['organization_name'],'rejected');
                       $message = 'Request rejected successfully for view secret key again';

                   }
                   else if($action == 1)
                   {
                       $this->Organizations->updateAll(['is_request_accept' => 2,'is_show_secret_key' =>0],['id' => $organizationId]);
                       $userEmail = $this->CryptoSecurity->decrypt(base64_decode($UsrData['email']),SEC_KEY);
                       $mailData = array();
                       $mailData['slug'] = 'accept_request_organization';
                       $mailData['email'] = $userEmail;
                       $mailData['replaceString'] = array('{clinic}','{action}');
                       $mailData['replaceData'] = array($organizationData['organization_name'],'accepted');
                       $message = 'Request accepted successfully for view secret key again';
                   }
                   $this->MailSend->send( $mailData );
                   $this->Flash->providersuccess(__($message));
                   return $this->redirect($this->referer());
           }
           else
           {
                   $this->Flash->providererror(__('Something went wrong.'));
                   return $this->redirect($this->referer());
           }

    }

    public function resetLink($id)
    {
         $this->loadModel('Organizations');
         $Users = $this->loadModel('Users');
         $organizationId = base64_decode($id);

         $organizationsData = $this->Organizations->find('all')->where(['id' =>$organizationId])->first();
         if(!empty($organizationsData))
         {
                $userData =  $Users->find('all')->where(['id' =>$organizationsData['user_id']])->first();

                if(!empty($userData))
                {
                    $email = $this->CryptoSecurity->decrypt(base64_decode($userData['email']),SEC_KEY);
                    $hashCode = sha1($userData['id'] . rand(0, 100));
                    $activationLink = Router::url(['prefix' => 'organizations','controller' => 'Users','action' => 'reset_password',$hashCode], true);
                     $link = $activationLink;
                     $userData->activation_link = $hashCode;
                     $this->Users->save($userData);
                     $mailData = array();
                     $mailData['slug'] = 'Organization_reset_password'; // 'forgot_password';
                     $mailData['email'] = $email;
                     $mailData['replaceString'] = array('{username}','{activation_link}');
                     $mailData['replaceData'] = array($email,$link);
                     $this->MailSend->send( $mailData );
                     $this->Flash->adminsuccess(__('An activation link has been sent to Organizations e-mail,please check to reset organizations password.'));
                     return $this->redirect($this->referer());
                }
                else
                {
                     return  $this->Flash->adminerror(__('Something went wrong, Please try again.'));
                }
         }
    }


    public function clinicrequest()
    {
        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('Organizations');
       // $organizations = $this->Organizations->find('all')->where(['is_request_accept' =>1,'status' =>1])->toArray();

        $organizations = $this->Organizations->find('all', array(
                'conditions' => array(
                    'status' =>1,
                    'OR' => array(
                            'is_request_accept' => '1',
                            'is_generate_new_key' => '1'
                    )
                )
            ));
        if(!empty($organizations))
        {
          $this->set(compact('organizations'));
        }
    }

    public function managelocation()
    {
        $this->viewBuilder()->setLayout('admin');
        $locationTbl = TableRegistry::get('locations');
        $allLocation  = $locationTbl->find('all')->contain(['Organizations'])->where(['Organizations.is_shown' =>1])->order(['locations.id' =>'DESC'])->toArray();
        $this->set(compact('allLocation'));
    }

    public function locations($org_id)
    {
        $this->viewBuilder()->setLayout('admin');
        $org_id = base64_decode($org_id);
        $locationTbl = TableRegistry::get('locations');
        $organizations = $this->Organizations->get($org_id);
        $allLocation  = $locationTbl->find('all')->contain(['Organizations'])->where(['Organizations.is_shown' =>1,'locations.organization_id' => $org_id])->order(['locations.id' =>'DESC'])->toArray();
        $this->set(compact('allLocation','organizations'));
    }

    public function editLocation($id)
    {
         $this->viewBuilder()->setLayout('admin');
         $locationId = base64_decode($id);
         $locationTbl = TableRegistry::get('locations');
         $location = $locationTbl->find('all')->contain(['Organizations'])->where(['locations.id' =>$locationId])->first();
         if($this->request->is(['post','put']))
         {
           $location->location = $this->request->data('location');
           if($locationTbl->save($location))
           {
             $this->Flash->providersuccess(__('Location updated successfully'));
             return $this->redirect(['action' => 'managelocation']);
           }
         }
         $this->set(compact('location'));
    }

    public function deleteLocation($id)
    {
        $locationTbl = TableRegistry::get('locations');
        $location = $locationTbl->get($id);

        if(!empty($locationTbl->delete($location)))
        {
            $this->Flash->adminsuccess(__('The location has been deleted.'));
            return $this->redirect($this->referer());
        }
    }

     public function addLocation($org_id = null){

        $this->viewBuilder()->setLayout('admin');
        $all_organizations = $this->Organizations->find('list', ['keyField' => 'id','valueField' => 'organization_name'])->where(['is_shown' => 1])->toArray();

          if ($this->request->is('post')) {

            //pr($this->request->data());die;
            $locationTbl = TableRegistry::get('locations');

            $input =$this->request->data();
            $location = $input['location'];


              if(!empty($location)){
                    $i  = 0;
                    $location = array_filter($location);
                    foreach ($location as $key => $loc) {
                        $save_data[$i]['organization_id'] = $input['organization_id'];
                        $save_data[$i]['location'] = $loc;
                        $i++;
                    }

                    $entities = $locationTbl->newEntities($save_data);

                    $data = $locationTbl->patchEntities($entities, $save_data);

                    $errors = "";
                    foreach ($data as $data_key => $data_value) {

                       if($data_value->errors()){

                        foreach ($data_value->errors() as $err_key => $err_value) {

                            foreach ($err_value as $err_k => $err_v) {
                               $errors .= $err_v.", ";
                            }
                        }

                        $errors = rtrim($errors,', ');
                        $this->Flash->adminerror($errors);
                        return $this->redirect($this->referer());
                       }
                    }

                    if ($result =  $locationTbl->saveMany($entities)) {

                        $this->Flash->adminsuccess(__('Location have been saved.'));
                        return $this->redirect(['action' => 'managelocation']);
                    }
                }
         }
         $this->set(compact('all_organizations'));

    }

    public function viewNote($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $user_table = TableRegistry::get('Users');
        $id = base64_decode($id);
        $user = $user_table->find('all')->where(['id' =>$id])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $input =$this->request->data();
            $endpoint = $input['end_point'];
            //$time_interval = $input['time_interval'];
            $is_allow_note = !empty($input['is_allow_note']) ? $input['is_allow_note'] : '';
            $sending_method = $input['sending_method'];
            $save_data['end_point'] = !empty($endpoint) ? base64_encode(Security::encrypt($endpoint, SEC_KEY)) : '';
            // $save_data['time_interval'] = !empty($time_interval) ? base64_encode(Security::encrypt($time_interval, SEC_KEY)) : '';
            $save_data['is_allow_note'] = !empty($is_allow_note) ? 1 : 0;
            $save_data['sending_method'] = !empty($sending_method) ? base64_encode(Security::encrypt($sending_method, SEC_KEY)) : $sending_method;
            $save_data['sftp_username'] = !empty($input['sftp_username']) ? base64_encode(Security::encrypt($input['sftp_username'], SEC_KEY)) : '';
            $save_data['sftp_password'] = !empty($input['sftp_password']) ? base64_encode(Security::encrypt($input['sftp_password'], SEC_KEY)) : '';
            $save_data['api_key'] = !empty($input['api_key']) ? base64_encode(Security::encrypt($input['api_key'], SEC_KEY)) : '';
            $save_data['port'] = !empty($input['port']) ? base64_encode(Security::encrypt($input['port'], SEC_KEY)) : '';
            $save_data['note_format'] = !empty($input['note_format']) ? base64_encode(Security::encrypt($input['note_format'], SEC_KEY)) : '';
            $save_data['post_option'] = !empty($input['post_option']) ? base64_encode(Security::encrypt($input['post_option'], SEC_KEY)) : '';

            

            $data = $user_table->patchEntity($user, $save_data);
            if($user_table->save($data)){
                $this->Flash->success(__('Saved successfully.'));
            }
            else{
              $this->Flash->error(__('Could not be saved. Please try again.'));
            }
        }
        $this->set(compact('user'));
    }

    // public function activeInsurance($id=null)
    // {
    //     $Cms_pages = TableRegistry::get('Organizations');
    //     $cms_pages = $Cms_pages->get($id);
    //     $cms_pages->is_show_insurance = 1;
    //     $Cms_pages->save($cms_pages);
    //     $this->Flash->success(__('The Organization Insurance has been activated.'));
    //     return $this->redirect(['action'=>'index']);
    // }

    // public function deactiveInsurance($id=null)
    // {
    //     $Cms_pages = TableRegistry::get('Organizations');
    //     $cms_pages = $Cms_pages->get($id);
    //     $cms_pages->is_show_insurance = 0;
    //     $Cms_pages->save($cms_pages);
    //     $this->Flash->success(__('The Organization Insurance has been deactivated.'));
    //     return $this->redirect(['action'=>'index']);
    // }
}
