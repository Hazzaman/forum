<?php
namespace App\Model\Listeners;

use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Event\Event;
use App\Model\Table\ArrayObject;
use App\Model\Entity\Comment;
use Cake\I18n\Time;

/**
 * ModifiedCheck Listener
 * 
 * 
 */
class ModifiedCheck implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'Model.beforeSave' => 'updateModifiedField'
        ];
    }
    
    public function updateModifiedField(Event $event, Comment $entity) 
    {
        if ($entity->dirty('text') && !$entity->isNew()) {
            $entity->modified = new Time();
        }
    }
}