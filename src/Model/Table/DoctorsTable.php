<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class DoctorsTable extends Table
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

        $this->table('doctors');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Organizations');
        $this->belongsTo('Specializations');
         //$this->hasMany('UserLocations');

        $this->hasMany('UserLocations', [
                'className' => 'UserLocations'
            ])
            ->setForeignKey('user_id');


       
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {



        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('organization_id', 'create')
            ->notEmpty('organization_id');      

        $validator
        ->requirePresence('doctor_name', 'create')
        ->notEmpty('doctor_name');  

         $validator
        ->requirePresence('specialization_id', 'create')
        ->notEmpty('specialization_id');    

        //  $validator
        // ->requirePresence('email', 'create')
        // ->notEmpty('email'); 

        // $validator
        // // ->email('email', false, 'Please enter valid email. ', null)
        // ->add(
        //         'email', 
        //         ['unique' => [
        //             'rule' => 'validateUnique', 
        //             'provider' => 'table', 
        //             'message' => 'Email id already exists. ']
        //         ]
        //     );


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
   
}
