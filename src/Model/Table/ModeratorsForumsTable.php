<?php
namespace App\Model\Table;

use App\Model\Entity\ModeratorsForum;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * ModeratorsForums Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Moderators
 * @property \Cake\ORM\Association\BelongsTo $Forums
 */
class ModeratorsForumsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('moderators_forums');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Moderators', [
            'foreignKey' => 'moderator_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Forums', [
            'foreignKey' => 'forum_id',
            'joinType' => 'INNER'
        ]);
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['moderator_id'], 'Moderators'));
        $rules->add($rules->existsIn(['forum_id'], 'Forums'));
        return $rules;
    }

    /**
     * After delete hook method
     * 
     * Deletes the moderator if they have no rows in ModeratorsForums left
     * @return void
     */
    public function afterDelete($event, $entity, $options)
    {
        $moderatorsTable = TableRegistry::get('moderators');

        $moderator = $moderatorsTable->get($entity->moderator_id, [
            'contain' => ['ModeratorsForums']
        ]);

        if (empty($moderator->moderators_forums))  {
            $moderatorsTable->delete($moderator);
        }
    }
}
