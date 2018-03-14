<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NewsortopicCommentsRatingTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NewsortopicCommentsRatingTable Test Case
 */
class NewsortopicCommentsRatingTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NewsortopicCommentsRatingTable
     */
    public $NewsortopicCommentsRating;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.newsortopic_comments_rating',
        'app.ipsum',
        'app.cidades',
        'app.ipsum_activate',
        'app.ipsum_activity_log',
        'app.newsortopic_comments',
        'app.newsortopic',
        'app.poll',
        'app.poll_options',
        'app.poll_options_votes',
        'app.dominus',
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
        $config = TableRegistry::exists('NewsortopicCommentsRating') ? [] : ['className' => 'App\Model\Table\NewsortopicCommentsRatingTable'];
        $this->NewsortopicCommentsRating = TableRegistry::get('NewsortopicCommentsRating', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NewsortopicCommentsRating);

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
