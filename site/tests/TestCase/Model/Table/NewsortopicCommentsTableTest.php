<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NewsortopicCommentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NewsortopicCommentsTable Test Case
 */
class NewsortopicCommentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NewsortopicCommentsTable
     */
    public $NewsortopicComments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.newsortopic_comments',
        'app.newsortopic',
        'app.poll',
        'app.poll_options',
        'app.dominus',
        'app.newsortopic_imagens',
        'app.newsortopic_tags',
        'app.ipsum',
        'app.cidades',
        'app.estados',
        'app.ipsum_activity_log',
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
        $config = TableRegistry::exists('NewsortopicComments') ? [] : ['className' => 'App\Model\Table\NewsortopicCommentsTable'];
        $this->NewsortopicComments = TableRegistry::get('NewsortopicComments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NewsortopicComments);

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
