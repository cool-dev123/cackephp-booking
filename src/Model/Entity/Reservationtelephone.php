<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Reservationtelephone extends Entity
{
    // Fields that can be mass assigned using newEntity() or patchEntity();
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

}
