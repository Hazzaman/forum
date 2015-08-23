<?php
namespace App\Model\Table;

use App\Model\Entity\Moderator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Moderators Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $ModeratorsForums
 */
class ModeratorsTable extends Table
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

        $this->table('moderators');
        $this->displayField('moderator_id');
        $this->primaryKey('moderator_id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('ModeratorsForums', [
            'dependent' => true,
            'foreignKey' => 'moderator_id'
        ]);
        

    }

    /**
     * Add forum method
     * 
     * @param int $moderator_id Moderator id
     * @param int $forum_id Forum id.
     * @return boolean indicating success
     */
    public function addForum($moderator_id, $forum_id)
    {
        $mod_forum_rel = $this->ModeratorsForums->newEntity([
            'moderator_id' => $moderator_id,
            'forum_id' => $forum_id
        ]);

        if ($this->ModeratorsForums->save($mod_forum_rel)) {
            return true;
        }
        else {
            return false;
        }
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
            ->add('moderator_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('moderator_id', 'create');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
