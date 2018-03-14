<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PollTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PollTable Test Case
 */
class PollTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PollTable
     */
    public $Poll;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.poll',
        'app.newsortopic',
        'app.poll_options',
        'app.poll_options_votes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Poll') ? [] : ['className' => 'App\Model\Table\PollTable'];
        $this->Poll = TableRegistry::get('Poll', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Poll);

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
}
