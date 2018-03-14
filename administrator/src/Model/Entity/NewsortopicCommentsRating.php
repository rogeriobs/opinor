<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NewsortopicCommentsRating Entity
 *
 * @property int $ipsum_id
 * @property int $newsortopic_comments_id
 * @property string $type
 *
 * @property \App\Model\Entity\Ipsum $ipsum
 * @property \App\Model\Entity\NewsortopicComment $newsortopic_comment
 */
class NewsortopicCommentsRating extends Entity
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
        'newsortopic_comments_id' => false
    ];
}
