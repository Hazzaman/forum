<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

use Constants\Roles;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Comments
 */
class UsersTable extends Table
{
    const ROLE_TABLES = ['Administrators', 'Moderators' => ['ModeratorsForums' => ['Forums']]];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('username');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('Comments', [
            'dependent' => true,
            'foreignKey' => 'user_id'
        ]);
        
        // Roles
        $this->hasOne('Administrators', [
            'dependent' => true,
            'foreignKey' => 'user_id'
        ]);
        
        $this->hasOne('Moderators', [
            'dependent' => true,
            'cascadeCallbacks' => true,
            'foreignKey' => 'user_id'
        ]);
    }
     
     /** TODO is this needed?
     * Get roles method
     *
     * @return array containing role objects and their permissions
     */
     public function getRoles($primaryKey)
     {
        $user = $this->get($primaryKey, ['contain' => $this::ROLE_TABLES]);
        // DONT DRY
        $user_roles = [Roles\ADMINISTRATOR => $user->administrator, Roles\MODERATOR => $user->moderator];
        #debug($user_roles);
        return $user_roles;
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
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
}
