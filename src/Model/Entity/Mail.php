<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mail Entity.
 *
 * @property int $id
 * @property string $from
 * @property string $from_email
 * @property string $subject
 * @property string $content
 * @property string $read_confirmation_code
 * @property int $last_sent_subscription_id
 * @property \App\Model\Entity\LastSentSubscription $last_sent_subscription
 * @property int $sent
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Group[] $groups
 */
class Mail extends Entity
{

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
        '*' => true,
        'id' => false,
    ];
}
