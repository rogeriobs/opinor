<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NewsortopicTag Entity
 *
 * @property int $newsortopic_id
 * @property string $tag
 *
 * @property \App\Model\Entity\Newsortopic $newsortopic
 */
class NewsortopicTag extends Entity
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
        'newsortopic_id' => false,
        'tag' => false
    ];
}
