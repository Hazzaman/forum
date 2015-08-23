<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Faker\Factory;
use Cake\Datasource\ConnectionManager;

use Constants\Roles;

/**
 * Generator Controller
 */
class GeneratorController extends AppController
{
    
    /**
     * Authorization method
     * 
     * @return boolean if user is authorized for the requested action
     */
    public function isAuthorized($user = null) 
    {
        $user = $this->Auth->user();
        if (!is_null($user[Roles\ADMINISTRATOR])) {
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * Generator New Records method
     *
     * @return void
     */
    public function newRecords()
    {
        $gen = Factory::create();
        $users = TableRegistry::get('Users');
        $forums = TableRegistry::get('Forums');
        $threads = TableRegistry::get('Threads');
        $comments = TableRegistry::get('Comments');
        
        
        $amount = 10;
        $user_ids = [];
        for ($i = 0; $i <= $amount; $i++) {
            $user = $users->newEntity([
                    'username' => $gen->userName(),
                    'password' => $gen->password(),
                    'email' => $gen->email()
                ]);
            $users->save($user);
            array_push($user_ids, $user->id);
        }
        for ($i = 0; $i <= 1; $i++) {
            
            $forum = $forums->newEntity([
                'title' => $gen->realText(30)
            ]);
            $forums->save($forum);
            
            for ($k = 0; $k <= $amount; $k++) {
                $thread = $threads->newEntity([
                    'title' => $gen->realText(85)
                ]);
                $thread->forum_id = $forum->id;
                $threads->save($thread);
                
                for ($j = 0; $j <= $amount; $j++) {
                    $comment = $comments->newEntity([
                        'text' => $gen->realText(255)
                    ]);
                    /*
                    
                    'thread_id' => $gen->numberBetween(1, sizeof($threads->find()->execute())),
                    'user_id' => $gen->numberBetween(1, sizeof($users->find()->execute())),
                        */
                    $comment->thread_id = $thread->id;
                    $comment->user_id = $user_ids[$j];
                    $comments->save($comment);
                }
            }
        }
        
        return $this->redirect(['controller' => 'Forums']);
    }
    
    /**
     * Delete method
     * 
     * 
     * Deletes all data in database and resets auto increment
     * @return void
     */
    public function delete()
    {
        $query = TableRegistry::get('ModeratorsForums');
        $query->deleteAll([]);
        $query = TableRegistry::get('Moderators');
        $query->deleteAll([]);
        $query = TableRegistry::get('Administrators');
        $query->deleteAll([]);
        $query = TableRegistry::get('Comments');
        $query->deleteAll([]);
        $query = TableRegistry::get('Threads');
        $query->deleteAll([]);
        $query = TableRegistry::get('Forums');
        $query->deleteAll([]);
        $query = TableRegistry::get('Users');
        $query->deleteAll([]);
        
        
        $connection = ConnectionManager::get('default');
        $connection->execute('ALTER TABLE Users auto_increment 1');
        $connection->execute('ALTER TABLE Forums auto_increment 1');
        $connection->execute('ALTER TABLE Threads auto_increment 1');
        $connection->execute('ALTER TABLE comments auto_increment 1');
        $this->redirect(['controller' => 'Users']);
    }
}
