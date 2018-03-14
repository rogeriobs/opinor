<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IpsumActivateTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IpsumActivateTable Test Case
 */
class IpsumActivateTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\IpsumActivateTable
     */
    public $IpsumActivate;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ipsum_activate',
        'app.ipsum',
        'app.cidades',
        'app.estados',
        'app.ipsum_activity_log',
        'app.newsortopic_comments',
        'app.newsortopic_comments_rating',
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
        $config = TableRegistry::exists('IpsumActivate') ? [] : ['className' => 'App\Model\Table\IpsumActivateTable'];
        $this->IpsumActivate = TableRegistry::get('IpsumActivate', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IpsumActivate);

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
