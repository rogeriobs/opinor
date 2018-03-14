<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NewsortopicTagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NewsortopicTagsTable Test Case
 */
class NewsortopicTagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NewsortopicTagsTable
     */
    public $NewsortopicTags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.newsortopic_tags',
        'app.newsortopic',
        'app.poll',
        'app.poll_options',
        'app.poll_options_votes',
        'app.ipsum',
        'app.cidades',
        'app.ipsum_activate',
        'app.ipsum_activity_log',
        'app.newsortopic_comments',
        'app.newsortopic_comments_rating',
        'app.dominus',
        'app.newsortopic_imagens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NewsortopicTags') ? [] : ['className' => 'App\Model\Table\NewsortopicTagsTable'];
        $this->NewsortopicTags = TableRegistry::get('NewsortopicTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NewsortopicTags);

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
