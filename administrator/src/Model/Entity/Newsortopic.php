<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Newsortopic Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string $alias
 * @property \Cake\I18n\Time $data_de_publicacao
 * @property \Cake\I18n\Time $data_da_fonte
 * @property string $texto_resumo
 * @property string $texto_full
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property bool $shutoff
 * @property int $poll_id
 * @property string $format_article
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $dominus_id
 *
 * @property \App\Model\Entity\Poll $poll
 * @property \App\Model\Entity\Dominus $dominus
 * @property \App\Model\Entity\NewsortopicComment[] $newsortopic_comments
 * @property \App\Model\Entity\NewsortopicImagen[] $newsortopic_imagens
 * @property \App\Model\Entity\NewsortopicTag[] $newsortopic_tags
 */
class Newsortopic extends Entity
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
