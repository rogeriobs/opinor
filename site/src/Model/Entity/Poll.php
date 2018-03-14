<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Poll Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string $texto_resumo
 * @property bool $shutoff
 * @property \Cake\I18n\Time $expiration_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Newsortopic[] $newsortopic
 * @property \App\Model\Entity\PollOption[] $poll_options
 */
class Poll extends Entity
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
        'id' => false
    ];
}
