<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Threads Controller
 *
 * @property \App\Model\Table\ThreadsTable $Threads
 */
class ThreadsController extends AppController
{

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
