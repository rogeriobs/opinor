<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NewsortopicCommentsFixture
 *
 */
class NewsortopicCommentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'newsortopic_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ipsum_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'comentario' => ['type' => 'string', 'length' => 400, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'data_e_hora' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'status' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'default' => null, 'null' => false, 'collate' => null, 'comment' => 'status do cometario: 0 = inativo; 1 = ativo; 2 = bloqueado', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_ipsumid_comments' => ['type' => 'foreign', 'columns' => ['ipsum_id'], 'references' => ['ipsum', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_newsortopicid_comments' => ['type' => 'foreign', 'columns' => ['newsortopic_id'], 'references' => ['newsortopic', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'newsortopic_id' => 1,
            'ipsum_id' => 1,
            'comentario' => 'Lorem ipsum dolor sit amet',
            'data_e_hora' => 1494303259,
            'status' => 'Lorem ipsum dolor sit ame'
        ],
    ];
}
