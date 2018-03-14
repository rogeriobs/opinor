<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cidade Entity
 *
 * @property int $id
 * @property string $nome
 * @property int $estado_id
 * @property int $codigo_ibge
 *
 * @property \App\Model\Entity\Estado $estado
 */
class Cidade extends Entity
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
