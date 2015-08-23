<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * Moderator Entity.
 */
class Moderator extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'user_id' => false,
    ];
    
    /**
     * Is Moderating Forum method
     *
     * @return boolean indicating if a moderator is moderating a given forum ($id)
     */
    public function isModeratingForum($id)
    {
        foreach ($this->moderators_forums as $forum_rel) {
            if ($forum_rel->forum_id === $id) {
                return true;
            }
        }
        return false;
    }
}
