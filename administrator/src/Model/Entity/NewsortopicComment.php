<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NewsortopicComment Entity
 *
 * @property int $id
 * @property int $newsortopic_id
 * @property int $ipsum_id
 * @property string $comentario
 * @property \Cake\I18n\Time $data_e_hora
 * @property string $status
 *
 * @property \App\Model\Entity\Newsortopic $newsortopic
 * @property \App\Model\Entity\Ipsum $ipsum
 */
class NewsortopicComment extends Entity
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
