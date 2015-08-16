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
 * @property \Cake\ORM\Association\BelongsToMany $Forums
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
        $this->displayField('user_id');
        $this->primaryKey('user_id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        // TODO when a moderator's forums are retreived they get a lot of extra data from the forum
        $this->belongsToMany('Forums', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'forum_id',
            'joinTable' => 'moderators_forums'
        ]);
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
        $rules->add($rules->existsIn(['forum_id'], 'Forums'));
        return $rules;
    }
}
