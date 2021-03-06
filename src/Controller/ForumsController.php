<?php
namespace App\Controller;

use App\Controller\AppController;
use Constants\Roles;
use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception;
use Cake\Datasource\ConnectionManager;
/**
 * Forums Controller
 *
 * @property \App\Model\Table\ForumsTable $Forums
 */
class ForumsController extends AppController
{

    public $paginate = [
        'sort' => 'id',
        'direction' => 'desc',
    ];

    /**
     * Initialization hook method.
     * 
     * @return void
     */

    public function initialize()
    {
        parent::initialize();
         

    }

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
            'contain' => ['Threads', 'ModeratorsForums' => ['Moderators' => ['Users']]]
        ]);
        
        //TODO isn't this a function?
        $user = $this->Auth->user();
        if (isset($user[Roles\MODERATOR]) && $user[Roles\MODERATOR]->isModeratingForum($forum->id)) {
            $this->set('is_moderator', true);
        }
        else {
            $this->set('is_moderator', false);
        }

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
            // TODO DRY this code and needs separation of concerns
            if (!is_null($this->Auth->user(Roles\MODERATOR))) {
                $moderator = $this->Auth->user(Roles\MODERATOR);
            }
            else {
                $connection = ConnectionManager::get('default');
                $connection->insert('moderators', ['user_id' => $this->Auth->user('id')]);


                $this->updateUserRoles();
                $moderator = $this->Auth->user(Roles\MODERATOR);

            }   


            if ($this->Forums->save($forum)) {
                if ($this->Forums->ModeratorsForums->Moderators->addForum($moderator->moderator_id, $forum->id)) {
                    $this->Flash->success(__('The forum has been saved and you have been made a moderator.'));
                    return $this->redirect(['action' => 'index']);
                }
                else {
                    $this->Flash->error(__('Could not make you a moderator. Please contact an admin.'));
                }
            } else {
                $this->Flash->error(__('An error has occurred. Please try again.'));
            }
        }
        $this->set(compact('forum'));
        $this->set('_serialize', ['forum']);
    }

    // DEBUG remove
    public function revokeModerator()
    {
        $connection = ConnectionManager::get('default');
        $connection->delete('moderators', ['user_id' => $this->Auth->user('id')]);
        return $this->redirect(['controller' => 'forums']);
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