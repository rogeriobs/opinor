<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DominusPerfisFixture
 *
 */
class DominusPerfisFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'descricao' => ['type' => 'string', 'length' => null, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'role' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'default' => 'U', 'null' => false, 'collate' => null, 'comment' => 'R = root; S = Super usuario, U = Usuario comum', 'precision' => null],
        'permissoes' => ['type' => 'json', 'length' => null, 'default' => '{}', 'null' => false, 'comment' => null, 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'descricao' => 'Lorem ipsum dolor sit amet',
            'role' => 'Lorem ipsum dolor sit ame',
            'permissoes' => '',
            'created' => 1492297791,
            'modified' => 1492297791
        ],
    ];
}
