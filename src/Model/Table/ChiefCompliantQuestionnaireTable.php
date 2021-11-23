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
class ChiefCompliantQuestionnaireTable extends Table
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

        $this->table('chief_compliant_questionnaire');
        $this->addBehavior('Timestamp');

        $this->belongsTo('QuestionnaireType',[
              'className' => 'QuestionnaireType',
              'foreignKey' => 'questionnaire_type_id',
        ]);

    }



}
