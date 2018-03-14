<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PollOptionsVote Entity
 *
 * @property int $ipsum_id
 * @property int $poll_options_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $poll_id
 * @property string $ip
 *
 * @property \App\Model\Entity\Ipsum $ipsum
 * @property \App\Model\Entity\PollOption $poll_option
 * @property \App\Model\Entity\Poll $poll
 */
class PollOptionsVote extends Entity
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
        'ipsum_id' => false,
        'poll_options_id' => false
    ];
}
