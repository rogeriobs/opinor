<?php
namespace App\Test\TestCase\Controller;

use App\Controller\IpsumController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\IpsumController Test Case
 */
class IpsumControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ipsum',
        'app.cidades',
        'app.estados',
        'app.ipsum_activity_log',
        'app.newsortopic_comments',
        'app.newsortopic',
        'app.poll',
        'app.poll_options',
        'app.dominus',
        'app.newsortopic_imagens',
        'app.newsortopic_tags',
        'app.newsortopic_comments_rating',
        'app.poll_options_votes'
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
