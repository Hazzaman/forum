<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Constants\Roles;
/**
 * Threads Controller
 *
 * @property \App\Model\Table\ThreadsTable $Threads
 */
class ThreadsController extends AppController
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
        
        $this->Auth->config('unauthorizedRedirect', [
            'controller' => 'forums', 'action' => 'index'
        ]);
    }
    
    /**
     * Authorization method
     * 
     * Will set is_moderator or is_administrator to true if the user is one of those
     * @return boolean if user is authorized for the requested action
     */
    public function isAuthorized($user = null) 
    {
        $user = $this->Auth->user();
        
        if (!is_null($user[Roles\ADMINISTRATOR])) {
            switch($this->request->action) {
                case 'add':
                case 'view':
                case 'index':
                case 'edit':
                case 'delete':
                    return true;
                default:
                    return false;
            }
        }
        
        if ((!is_null($user[Roles\MODERATOR]))) {
            switch($this->request->action) {
                case 'add':
                case 'view':
                    return true;
                case 'edit':
                    $thread_id = intval($this->request->params['pass'][0]);
                    $forum_id = $this->Threads->get($thread_id)->forum_id;
                    return $user[Roles\MODERATOR]->isModeratingForum($forum_id);
                default:
                    return false;
            }
        }
        
        // Normal user authorized actions
        switch($this->request->action) {
            case 'add':
            case 'view':
                return true;
            default:
                return false;
        }
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Forums']
        ];
        $this->set('threads', $this->paginate($this->Threads));
        $this->set('_serialize', ['threads']);
    }

    /**
     * View method
     *
     * @param string|null $id Thread id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $thread = $this->Threads->get($id, [
            'contain' => ['Forums', 'Comments']
        ]);
        $this->set('thread', $thread);
        
        // TODO make into function in a helper
        $query = $this->Threads->Comments->Users->find();
        $userdata = $query->select(['id', 'username'])->toArray();
        
        for ($i = count($userdata) - 1; $i >= 0; $i--) {
            $new_key = $userdata[$i]->id;
            $userdata[$new_key] = $userdata[$i];
            unset($userdata[$i]);
        }
        $user = $this->Auth->user();
        if (isset($user[Roles\MODERATOR]) && $user[Roles\MODERATOR]->isModeratingForum($thread->forum_id)) {
            $this->set('is_moderator', true);
        }
        else {
            $this->set('is_moderator', false);
        }
        
        $this->set('userdata', $userdata);
        
        $this->set('_serialize', ['thread']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $thread = $this->Threads->newEntity();
        if ($this->request->is('post')) {
            $thread = $this->Threads->patchEntity($thread, $this->request->data);
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The thread could not be saved. Please, try again.'));
            }
        }
        $forums = $this->Threads->Forums->find('list', ['limit' => 200]);
        $this->set(compact('thread', 'forums'));
        $this->set('_serialize', ['thread']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Thread id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $thread = $this->Threads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $thread = $this->Threads->patchEntity($thread, $this->request->data);
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been saved.'));
                return $this->redirect(['action' => 'index']); //TODO fix redirect
            } else {
                $this->Flash->error(__('The thread could not be saved. Please, try again.'));
            }
        }
        $forums = $this->Threads->Forums->find('list', ['limit' => 200]);
        $this->set(compact('thread', 'forums'));
        $this->set('_serialize', ['thread']);
    }

    /** TODO make delete work and change to 'close' for threads
     * Delete method
     *
     * @param string|null $id Thread id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $thread = $this->Threads->get($id);
        if ($this->Threads->delete($thread)) {
            $this->Flash->success(__('The thread has been deleted.'));
        } else {
            $this->Flash->error(__('The thread could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
