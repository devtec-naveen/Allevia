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
class AppointmentsTable extends Table
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

        $this->table('appointments');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Doctors')
            ->setForeignKey('doctor_id')
            ->setJoinType('LEFT');
        $this->belongsTo('Users')
            ->setForeignKey('user_id')
            ->setJoinType('LEFT');            
        $this->belongsTo('Organizations') 
            ->setForeignKey('organization_id')
            ->setJoinType('LEFT');

        $this->hasOne('ChiefCompliantUserdetails') 
            ->setForeignKey('appointment_id')
            ->setJoinType('LEFT');            

        $this->belongsTo('Specializations') 
            ->setForeignKey('specialization_id')
            ->setJoinType('LEFT');  

        $this->belongsTo('MedicalIssues') 
            ->setForeignKey('medical_issue_id')
            ->setJoinType('LEFT');  

        $this->belongsTo('Schedule')
            ->setForeignKey('schedule_id');
           // ->setJoinType('LEFT');             
                      
       
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        
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
