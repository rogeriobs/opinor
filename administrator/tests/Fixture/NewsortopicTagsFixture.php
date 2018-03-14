<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NewsortopicTagsFixture
 *
 */
class NewsortopicTagsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'newsortopic_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'tag' => ['type' => 'string', 'length' => 70, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['newsortopic_id', 'tag'], 'length' => []],
            'fk_newsortopicid_tags' => ['type' => 'foreign', 'columns' => ['newsortopic_id'], 'references' => ['newsortopic', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'newsortopic_id' => 1,
            'tag' => '6caec8f9-0e41-4fbf-b2f7-6ebcc909d985'
        ],
    ];
}
