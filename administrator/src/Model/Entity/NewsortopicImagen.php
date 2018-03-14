<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NewsortopicImagen Entity
 *
 * @property int $id
 * @property string $filename
 * @property bool $head
 * @property string $legenda
 * @property string $real_width
 * @property string $real_height
 * @property string $use_width
 * @property string $use_height
 * @property int $newsortopic_id
 *
 * @property \App\Model\Entity\Newsortopic $newsortopic
 */
class NewsortopicImagen extends Entity
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
