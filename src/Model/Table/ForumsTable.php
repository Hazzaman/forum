<?php
namespace App\Model\Table;

use App\Model\Entity\Forum;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Forums Model
 *
 * @property \Cake\ORM\Association\HasMany $Threads
 */
class ForumsTable extends Table
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

        $this->table('forums');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('Threads', [
            'foreignKey' => 'forum_id'
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

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        return $validator;
    }
}
