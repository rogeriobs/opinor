<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PollOptionsVotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PollOptionsVotesTable Test Case
 */
class PollOptionsVotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PollOptionsVotesTable
     */
    public $PollOptionsVotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.poll_options_votes',
        'app.ipsum',
        'app.poll_options',
        'app.poll',
        'app.newsortopic'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PollOptionsVotes') ? [] : ['className' => 'App\Model\Table\PollOptionsVotesTable'];
        $this->PollOptionsVotes = TableRegistry::get('PollOptionsVotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PollOptionsVotes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
