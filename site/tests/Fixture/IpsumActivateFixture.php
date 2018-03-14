<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IpsumActivateFixture
 *
 */
class IpsumActivateFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ipsum_activate';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ipsum_id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'token' => ['type' => 'string', 'length' => 200, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'expiration_date' => ['type' => 'date', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['ipsum_id'], 'length' => []],
            'ipsum_activate_token_key' => ['type' => 'unique', 'columns' => ['token'], 'length' => []],
            'fk_ipsumid_activateid' => ['type' => 'foreign', 'columns' => ['ipsum_id'], 'references' => ['ipsum', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'ipsum_id' => 1,
            'token' => 'Lorem ipsum dolor sit amet',
            'expiration_date' => '2017-04-01',
            'created' => 1491079154,
            'modified' => 1491079154
        ],
    ];
}
