<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IpsumTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IpsumTable Test Case
 */
class IpsumTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\IpsumTable
     */
    public $Ipsum;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ipsum',
        'app.cidades',
        'app.ipsum_activate',
        'app.ipsum_activity_log',
        'app.newsortopic_comments',
        'app.newsortopic_comments_rating',
        'app.poll_options_votes',
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
        $config = TableRegistry::exists('Ipsum') ? [] : ['className' => 'App\Model\Table\IpsumTable'];
        $this->Ipsum = TableRegistry::get('Ipsum', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ipsum);

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
