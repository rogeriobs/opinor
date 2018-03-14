<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdminMenuIten Entity
 *
 * @property int $id
 * @property int $admin_menu_id
 * @property string $descricao
 * @property int $ordem
 * @property string $action_perm
 * @property string $params
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $controller_go
 * @property string $action_go
 *
 * @property \App\Model\Entity\AdminMenu $admin_menu
 * @property \App\Model\Entity\Controller $controller
 */
class AdminMenuIten extends Entity
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
