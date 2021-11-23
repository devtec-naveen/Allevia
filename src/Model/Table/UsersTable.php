<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


use Cake\ORM\RulesChecker;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
       // parent::initialize($config);

        $this->table('users');
       // $this->displayField('id');
        //$this->primaryKey('id');

        $this->addBehavior('Timestamp');


        /*$this->belongsTo('Organizations')
            ->setForeignKey('organization_id')
            ->setJoinType('INNER');*/

            $this->belongsTo('Organizations',[
                    'className' => 'Organizations',
                    'foreignKey' => 'organization_id',
                ]);

        $this->hasMany('ScheduleFieldSettings', [
            'dependent' => true,
            'cascadeCallbacks' => true,
        ])
        ->setForeignKey('provider_id');


        $this->hasMany('UserLocations', [
            'className' => 'UserLocations',
            'foreignKey' => 'user_id',
        ]);


        $this->hasMany('Schedule', [
            'dependent' => true,
            'cascadeCallbacks' => true,
            'conditions' => array('status' => 3,'step_id IN' =>array('18','21','19','25')),
        ])
        ->setForeignKey('provider_id');
        

      
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {

        // $v = $this->find('all')->all(); 
        // pr($v); die; 
        // first_name  last_name  email  phone  password  confirm_password        
        // $validator
        //     ->integer('id')
        //     ->allowEmpty('id', 'create');
 
        // $validator
        //     ->email('email')
        //     ->requirePresence('email', 'create')
        //     ->notEmpty('email');

        // $validator
        //     ->requirePresence('g-recaptcha-response', 'create')
        //     ->notEmpty('g-recaptcha-response');          // validating google recaptcha  




        // $validator
        //     ->requirePresence('phone', 'create')
        //     ->notEmpty('phone');            

        // $validator
        //     ->requirePresence('password', 'create')
        //     ->notEmpty('password');

        // $validator
        //     ->requirePresence('first_name', 'create')
        //     ->notEmpty('first_name')
        //     ->add('first_name', 'minLength', ['rule' => ['minLength', 3]]);

        // $validator
        //     ->requirePresence('last_name', 'create')
        //     ->notEmpty('last_name');


// currentlysmoking
// pastsmoking
// currentlydrinking
// pastdrinking
// otherdrug
// otherdrugpast
// is_retired
// occupation
// height
// height_inches
// weight
// sexual_orientation
// marital_status
// ethinicity
// ->notEmpty('currentlysmoking', 'First name is required.')
// ->notEmpty('pastsmoking', 'First name is required.')
// ->notEmpty('currentlydrinking', 'First name is required.')
// ->notEmpty('pastdrinking', 'First name is required.')
// ->notEmpty('otherdrug', 'First name is required.')
// ->notEmpty('otherdrugpast', 'First name is required.')
// ->notEmpty('is_retired', 'First name is required.')
// ->notEmpty('occupation', 'First name is required.')
// ->notEmpty('height', 'First name is required.')
// ->notEmpty('height_inches', 'First name is required.')
// ->notEmpty('weight', 'First name is required.')
// ->notEmpty('sexual_orientation', 'First name is required.')
// ->notEmpty('marital_status', 'First name is required.')
// ->notEmpty('ethinicity', 'First name is required.')


        $validator
        ->notEmpty('first_name', 'First name is required.')
        ->notEmpty('last_name', 'Last name is required.')
        ->notEmpty('email', 'Email is required.')
        ->allowEmpty('phone')
        ->allowEmpty('email')
        ->notEmpty('password', 'Password is required.')
        // ->add('email', [
        //         /*'length' => [
        //             'rule' => 'email',
        //             'message' => 'Please enter valid email.',
        //         ],*/
        //         'unique'=>[
        //             'rule' => 'validateUnique',
        //             'message' => 'Email id already exists.',
        //             'provider' => 'table'

        //         ]
        //     ])

        // ->add(
        //         'phone', 
        //         ['unique' => [
        //             'rule' => 'validateUnique', 
        //             'provider' => 'table', 
        //             'message' => 'Phone Number already exists. ']
        //         ]
        //     )

          ->add(
                'provider_secret', 
                ['unique' => [
                    'rule' => 'validateUnique', 
                    'provider' => 'table', 
                    'message' => 'Provider secret should be unique']
                ]
            )
        
       // ->notEmpty('g-recaptcha-response', 'recaptcha is required.')
       // ->email('email', false, 'Please enter valid email. ', null)
       /* ->add(
                'email', 
                ['unique' => [
                    'rule' => 'validateUnique', 
                    'provider' => 'table', 
                    'message' => 'Email id already exists. ']
                ]
            )
        ->add(
                'phone', 
                ['unique' => [
                    'rule' => 'validateUnique', 
                    'provider' => 'table', 
                    'message' => 'Phone Number already exists. ']
                ]
            )*/

        ->add('org_access_code',[
                'myvalidfun'=>[
                'rule'=>'myvalidfun',
                'provider'=>'table',
                'message'=>'Access code does not match.'
                 ]
                ])        

        ->add('password', 'validFormat',[
                'rule' => array('custom', '/^\S*(?=\S{8,})\S*$/'),
                 'last' => true,                   // for the validation last to run for this field
                'message' => 'Password should have at least 8 character long. '
        ])         
        // password validation for combination of all characters 
        // ->add('password', 'validFormat',[
        //         'rule' => array('custom', '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\W])(?=\S*[\d])\S*$/'),
        //         'message' => 'password must contain lowercase, uppercase, number and special character and minimum 8 characters.'
        // ])   

        ->add('password', [
                'compare' => [
                    'rule' => ['compareWith', 'confirm_password'],
                    'message' => 'Password and Confirm Password not matched. '
                ]
            ])
        ; 

        /*$validator
                ->add('user_id', 'valid', ['rule' => 'numeric'])
                ->requirePresence('user_id', 'create')
                ->notEmpty('user_id');*/


           $validator
            ->allowEmpty('cl_provider_id')
            ->add('cl_provider_id', [
                /*'length' => [
                    'rule' => 'email',
                    'message' => 'Please enter valid email.',
                ],*/
                'unique'=>[
                    'rule' => 'validateUnique',
                    'message' => 'Callidus provider id already exists.',
                    'provider' => 'table'

                ]
            ]);

        return $validator;
    }



    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->isUnique(['email'],'This Email has already been used.'));
         $rules->add($rules->isUnique(['username'],'This Username has already been used.'));

        return $rules;
    }



    public function myvalidfun($value,$context){
        // pr($value); pr($context); die; 
      
            $org_table = TableRegistry::get('organizations');
      $org_data =   $org_table->find('all')->where(['id' => $context['data']['organization_id'] , 'access_code'=> $context['data']['org_access_code']])->first();

        if(empty($org_data)) {
            return false;
        } else {
            return true;
        }
    }


/*

  public function validationDefault(Validator $validator) {
        $validator->add('title',[
        'notEmptyCheck'=>[
        'rule'=>'notEmptyCheck',
        'provider'=>'table',
        'message'=>'Please enter the title'
         ]
        ]);
       return $validator;
    }

    public function notEmptyCheck($value,$context){
        if(empty($context['data']['title'])) {
            return false;
        } else {
            return true;
        }
*/


}
