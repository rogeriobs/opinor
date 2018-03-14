<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NewsortopicImagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NewsortopicImagensTable Test Case
 */
class NewsortopicImagensTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NewsortopicImagensTable
     */
    public $NewsortopicImagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.newsortopic_imagens',
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
        $config = TableRegistry::exists('NewsortopicImagens') ? [] : ['className' => 'App\Model\Table\NewsortopicImagensTable'];
        $this->NewsortopicImagens = TableRegistry::get('NewsortopicImagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NewsortopicImagens);

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
