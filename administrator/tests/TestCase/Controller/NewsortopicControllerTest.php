<?php
namespace App\Test\TestCase\Controller;

use App\Controller\NewsortopicController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\NewsortopicController Test Case
 */
class NewsortopicControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.newsortopic_imagens',
        'app.newsortopic_tags'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
