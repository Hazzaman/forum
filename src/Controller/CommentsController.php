<?php
namespace App\Controller;

use App\Controller\AppController;
use Constants\Roles;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 */
class CommentsController extends AppController
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
                case 'edit': // If comment is in moderators forum return true
                    $comment_id = intval($this->request->params['pass'][0]);
                    $comment = $this->Comments->get($comment_id, ['contain' => ['Threads' => ['Forums']]]);
                    $forum_id = $comment->thread->forum->id;
                    
                    if ($user[Roles\MODERATOR]->isModeratingForum($forum_id)) {
                        return true;
                    }
                    else {
                        // user is not a moderator of this forum but may still have a comment here
                        if ($this->Auth->user('id') === $comment->user_id) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    }
                case 'delete': // TODO DRY this is copied from the user permissions below
                    $comment_id = intval($this->request->params['pass'][0]);
                    $comment = $this->Comments->get($comment_id);
                    if ($this->Auth->user('id') === $comment->user_id) {
                        return true;
                    }
                    else {
                        return false;
                    }
                default:
                    return false;
            }
        }
        
        // Normal user authorized actions
        switch($this->request->action) {
            case 'add':
            case 'view':
                return true;
            case 'edit':
            case 'delete':
                $comment_id = intval($this->request->params['pass'][0]);
                $comment = $this->Comments->get($comment_id);
                if ($this->Auth->user('id') === $comment->user_id) {
                    return true;
                }
                else {
                    return false;
                }
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
            'contain' => ['Threads', 'Users']
        ];
        $this->set('comments', $this->paginate($this->Comments));
        $this->set('_serialize', ['comments']);
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => ['Threads', 'Users']
        ]);
        $this->set('comment', $comment);
        $this->set('_serialize', ['comment']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function add($thread_id = null)
    {
        $comment = $this->Comments->newEntity();
        $thread = $this->Comments->Threads->get($thread_id);
        $comment->thread_id = $thread_id;
        
        if ($this->request->is('post')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->data);
            
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));
                return $this->redirect(['controller' => 'threads', 'action' => 'view', $comment->thread_id]);
            } else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }
        $threads = $this->Comments->Threads->find('list', ['limit' => 200]);
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'threads', 'users'));
        $this->set('_serialize', ['comment']);
    }

    /** TODO update this so users can edit their own comment
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->data);
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));
                return $this->redirect(['controller' => 'threads', 'action' => 'view', $comment->thread_id]);
            } else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }
        $threads = $this->Comments->Threads->find('list', ['limit' => 200]);
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'threads', 'users'));
        $this->set('_serialize', ['comment']);
    }

    /** TODO update so user can delete only their own comment
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
        } else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
