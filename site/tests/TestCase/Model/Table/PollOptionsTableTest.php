<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PollOptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PollOptionsTable Test Case
 */
class PollOptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PollOptionsTable
     */
    public $PollOptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.poll_options',
        'app.poll',
        'app.newsortopic',
        'app.dominus',
        'app.newsortopic_comments',
        'app.newsortopic_imagens',
        'app.newsortopic_tags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PollOptions') ? [] : ['className' => 'App\Model\Table\PollOptionsTable'];
        $this->PollOptions = TableRegistry::get('PollOptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PollOptions);

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
