<?php
namespace App\Controller;

use App\Controller\AppController;
use Constants\Roles;

/**
 * Moderators Controller
 *
 * @property \App\Model\Table\ModeratorsTable $Moderators
 */
class ModeratorsController extends AppController
{
        /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        
        // Deny public access
        $this->Auth->deny('index');
        $this->Auth->deny('view');

        $this->Auth->config('unauthorizedRedirect', [
            'controller' => 'forums', 'action' => 'index'
        ]);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('moderators', $this->paginate($this->Moderators));
        $this->set('_serialize', ['moderators']);
    }

    /** TODO dry up auth method more
     * Authorization method
     * 
     * @return boolean if user is authorized for the requested action
     */
    public function isAuthorized($user = null) 
    {
        $user = $this->Auth->user();
        
        if (!is_null($user[Roles\ADMINISTRATOR])) {
            switch($this->request->action) {
                case 'index':
                case 'add':
                case 'view':
                case 'delete':
                    return true;
                default:
                    return false;
            }
        }

        /*if ((!is_null($user[Roles\MODERATOR]))) {
            switch($this->request->action) {
                default:
                    return false;
            }
        }
        
        // Normal user authorized actions
        switch($this->request->action) {
            default:
                return false;
        }*/

        return false;
    }

    /**
     * View method
     *
     * @param string|null $id Moderator id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $moderator = $this->Moderators->get($id, [
            'contain' => ['Users', 'ModeratorsForums']
        ]);
        $this->set('moderator', $moderator);
        $this->set('_serialize', ['moderator']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $moderator = $this->Moderators->newEntity();
        if ($this->request->is('post')) {
            $moderator = $this->Moderators->patchEntity($moderator, $this->request->data);
            if ($this->Moderators->save($moderator)) {
                $this->Flash->success(__('The moderator has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The moderator could not be saved. Please, try again.'));
            }
        }
        $users = $this->Moderators->Users->find('list', ['limit' => 200]);
        $this->set(compact('moderator', 'users'));
        $this->set('_serialize', ['moderator']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Moderator id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $moderator = $this->Moderators->get($id);
        if ($this->Moderators->delete($moderator)) {
            $this->Flash->success(__('The moderator has been deleted.'));
        } else {
            $this->Flash->error(__('The moderator could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}