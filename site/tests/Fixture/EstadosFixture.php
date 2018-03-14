<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstadosFixture
 *
 */
class EstadosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'nome' => ['type' => 'string', 'length' => 100, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'uf' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null],
        'uf_ibge' => ['type' => 'integer', 'length' => 5, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'uf_sl' => ['type' => 'integer', 'length' => 5, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'uf_ddd' => ['type' => 'string', 'length' => 60, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'regiao' => ['type' => 'string', 'length' => 60, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
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
            'nome' => 'Lorem ipsum dolor sit amet',
            'uf' => '',
            'uf_ibge' => 1,
            'uf_sl' => 1,
            'uf_ddd' => 'Lorem ipsum dolor sit amet',
            'regiao' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
