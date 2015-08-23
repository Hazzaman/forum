<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
require_once(APP . 'Model' . DS . 'Constants' . DS . 'Roles.php');
use Constants\Roles;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        
        //DEBUG
        /*$mods = TableRegistry::get('Moderators');
        debug($mods->find('all', ['contain' => ['ModeratorsForums']])->toArray());
        
        $forums = TableRegistry::get('Forums');
        debug($forums->find('all', ['contain' => ['ModeratorsForums']])->toArray());*/
        
        $this->loadComponent('Flash');
        
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'unauthorizedRedirect' => ['action' => 'index']
        ]);
        
        // Anyone can access 'view' and 'index'
        $this->Auth->allow(['view', 'index']);
        
        $this->updateUserRoles();
        if (!is_null($this->Auth->user(Roles\ADMINISTRATOR))) {
            $this->set('is_administrator', true);
        }
        else {
            $this->set('is_administrator', false);
        }

    }

    /**
    * Update role status method
    *
    * Updates the user's roles in $this->Auth->user()
    * @return boolean indicating success
    */
    public function updateUserRoles()
    {
        //debug($this->Auth->user());
        if (!is_null($this->Auth->user())) {
            $user_array = $this->Auth->user();
            $users = TableRegistry::get('users');
            $roles = $users->getRoles($user_array['id']); 

            $user_array = $roles + $user_array;

            $this->Auth->setUser($user_array);
            //debug($this->Auth->user());
            return true;
        }
        return false;
    }
    
    /**
     * Authorization method
     * 
     * @return boolean if user is authorized for the requested action
     */
    public function isAuthorized($user = null) 
    {
        return false;
    }
    
    /**
     * 
     * 
     */
    public function authCheck($role_data, $executable, $valid_actions, $action = null)
    {
        if (is_null($action)) {
            $action = $this->request->action;
        }
        
        if ($executable($role_data)) {
            return in_array($action, $valid_actions);
        }
    }
    
    /** TODO
    * Set is_moderator method
    *
    *
    *
    * @param int $forum_id Forum id
    * @return void
    */
    public function setIsModerator($forum_id)
    {
        $user = $this->Auth->user();
        if (isset($user[Roles\MODERATOR]) && $user[Roles\MODERATOR]->isModeratingForum($forum_id)) {
            $this->set('is_moderator', true);
        }
        else {
            $this->set('is_moderator', false);
        }
    }

    /**
     * Before Rendering hook method.
     *
     * Gives the logged in user to the view.
     *
     * @return void
     */
    public function beforeRender(Event $event) 
    {
        $this->set('userData', $this->Auth->user());
    }
}
