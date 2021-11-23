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
class ScheduleTable extends Table
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

        $this->table('schedules');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
       /* $this->belongsTo('Organizations',array(
            'className' => 'Organizations',
            'foreignKey' => 'organization_id'
        ));*/

        $this->belongsTo('Organizations',[
                        'className' => 'Organizations',
                        'foreignKey' => 'organization_id',
                        
                    ]);

        $this->belongsTo('Doctors',[
                        'className' => 'Doctors',
                        'foreignKey' => 'doctor_id',
                        
                    ]);

        $this->belongsTo('Users',[
                        'className' => 'Users',
                        'foreignKey' => 'user_id',
                        
                    ]);

         $this->belongsTo('ChiefCompliantUserdetails',[
                        'className' => 'ChiefCompliantUserdetails',
                        'foreignKey' => false,                       
                        'conditions' => array(' `ChiefCompliantUserdetails`.`appointment_id` = `Schedule`.`appointment_id`'),
                        'dependent'    => false
                        
                    ]);
       
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
   /* public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('email', 'create')
            ->notEmpty('email');  

        $validator
            ->requirePresence('organization_id', 'create')
            ->notEmpty('organization_id');        

        $validator
        ->requirePresence('password', 'create')
        ->notEmpty('password');      

        return $validator;
    }*/

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
  
}
