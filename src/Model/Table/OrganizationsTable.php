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
class OrganizationsTable extends Table
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

        $this->table('organizations');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasOne('Doctors');
        $this->hasMany('Locations');
       
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
            ->requirePresence('organization_name', 'create')
            ->notEmpty('organization_name');

        $validator
            ->requirePresence('org_url','create')
            ->notEmpty('org_url')
            ->add('org_url', [
                /*'length' => [
                    'rule' => 'email',
                    'message' => 'Please enter valid email.',
                ],*/
                'unique'=>[
                    'rule' => 'validateUnique',
                    'message' => 'Clinic slug already exists.',
                    'provider' => 'table'

                ]
            ]);   

        $validator
            ->requirePresence('email', 'create')
            ->notEmpty('email');  

        $validator
        ->requirePresence('access_code', 'create')
        ->notEmpty('access_code');  

         $validator
        ->requirePresence('location', 'create')
        ->notEmpty('location');

        $validator
            ->allowEmpty('cl_group_id')
            ->add('cl_group_id', [
                /*'length' => [
                    'rule' => 'email',
                    'message' => 'Please enter valid email.',
                ],*/
                'unique'=>[
                    'rule' => 'validateUnique',
                    'message' => 'Callidus group id already exists.',
                    'provider' => 'table'

                ]
            ]);    

        $validator
            ->allowEmpty('client_id')
            ->add('client_id', [                
                'unique'=>[
                    'rule' => 'validateUnique',
                    'message' => 'Client id should be unique.',
                    'provider' => 'table'

                ]
            ]); 

            $validator
            ->allowEmpty('client_secret')
            ->add('client_secret', [              
                'unique'=>[
                    'rule' => 'validateUnique',
                    'message' => 'Client secret should be unique.',
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
        $rules->add($rules->isUnique(['organization_name'],'Please Change Organization Name'));
        return $rules;
    }
}
