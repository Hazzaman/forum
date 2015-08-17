<?php
namespace App\Controller;

use App\Controller\AppController;
use Constants\Roles;

/**
 * Forums Controller
 *
 * @property \App\Model\Table\ForumsTable $Forums
 */
class ForumsController extends AppController
{

    /** TODO DRY authorization method if enough time
     * Authorization method
     * 
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
                case 'index':
                    return true;
                case 'edit':
                    $id = intval($this->request->params['pass'][0]);
                    return $user[Roles\MODERATOR]->isModeratingForum($id);
                default:
                    return false;
            }
        }
        
        
        // Normal user authorized actions
        switch($this->request->action) {
            case 'add':
            case 'view':
            case 'index':
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
        $this->set('forums', $this->paginate($this->Forums));
        $this->set('_serialize', ['forums']);
    }

    /**
     * View method
     *
     * @param string|null $id Forum id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $forum = $this->Forums->get($id, [
            'contain' => ['Threads', 'Moderators']
        ]);
        $this->set('forum', $forum);
        $this->set('_serialize', ['forum']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $forum = $this->Forums->newEntity();
        if ($this->request->is('post')) {
            $forum = $this->Forums->patchEntity($forum, $this->request->data);
            $moderator = $this->Forums->Moderators->newEntity([$this->Auth->user('id'), 7]);
            debug($moderator);
            if ($this->Forums->save($forum) && $this->Forums->Moderators->save($moderator)) {              
                $this->Flash->success(__('The forum has been saved and you have been made a moderator.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Forums->delete($forum);
                $this->Flash->error(__('An error has occurred. Please, try again.'));
            }
        }
        $this->set(compact('forum'));
        $this->set('_serialize', ['forum']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Forum id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $forum = $this->Forums->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $forum = $this->Forums->patchEntity($forum, $this->request->data);
            if ($this->Forums->save($forum)) {
                $this->Flash->success(__('The forum has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The forum could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('forum'));
        $this->set('_serialize', ['forum']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Forum id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $forum = $this->Forums->get($id);
        if ($this->Forums->delete($forum)) {
            $this->Flash->success(__('The forum has been deleted.'));
        } else {
            $this->Flash->error(__('The forum could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function test($id = null)
    {
    }
}
