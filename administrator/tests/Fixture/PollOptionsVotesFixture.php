<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PollOptionsVotesFixture
 *
 */
class PollOptionsVotesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ipsum_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'poll_options_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'poll_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ip' => ['type' => 'string', 'length' => 15, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['ipsum_id', 'poll_options_id'], 'length' => []],
            'punique_unicavotacaonaenquete' => ['type' => 'unique', 'columns' => ['ipsum_id', 'poll_id'], 'length' => []],
            'fk_enqueteid_votes_restricao' => ['type' => 'foreign', 'columns' => ['poll_id'], 'references' => ['poll', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'fk_ipsumid_votepollopt' => ['type' => 'foreign', 'columns' => ['ipsum_id'], 'references' => ['ipsum', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_polloptionsid_votes' => ['type' => 'foreign', 'columns' => ['poll_options_id'], 'references' => ['poll_options', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'poll_options_id' => 1,
            'created' => 1494112356,
            'modified' => 1494112356,
            'poll_id' => 1,
            'ip' => 'Lorem ipsum d'
        ],
    ];
}
