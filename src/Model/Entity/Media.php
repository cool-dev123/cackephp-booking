<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\Translate\TranslateTrait;

/**
 * Media Entity
 *
 * @property int $id
 * @property string $name_key
 * @property string $title_ete
 * @property string $title_hiver
 * @property string $lien_ete
 * @property string $lien_hiver
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\I18n[] $i18n
 */
class Media extends Entity
{
    use TranslateTrait;
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name_key' => true,
        'title_ete' => true,
        'title_hiver' => true,
        'lien_ete' => true,
        'lien_hiver' => true,
        'created' => true,
        'modified' => true,
        'i18n' => true
    ];
}
