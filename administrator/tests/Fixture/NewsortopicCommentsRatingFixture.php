<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NewsortopicCommentsRatingFixture
 *
 */
class NewsortopicCommentsRatingFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'newsortopic_comments_rating';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ipsum_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'newsortopic_comments_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'type' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'default' => null, 'null' => false, 'collate' => null, 'comment' => '1 = like, 2 = notlike, 3 = maybe', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['ipsum_id', 'newsortopic_comments_id'], 'length' => []],
            'fk_ipsumid_neortocoraid' => ['type' => 'foreign', 'columns' => ['ipsum_id'], 'references' => ['ipsum', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_neortocoid_notcrid' => ['type' => 'foreign', 'columns' => ['newsortopic_comments_id'], 'references' => ['newsortopic_comments', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'newsortopic_comments_id' => 1,
            'type' => 'Lorem ipsum dolor sit ame'
        ],
    ];
}
