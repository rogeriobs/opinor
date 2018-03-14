<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DominusPerfisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DominusPerfisTable Test Case
 */
class DominusPerfisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DominusPerfisTable
     */
    public $DominusPerfis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dominus_perfis'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DominusPerfis') ? [] : ['className' => 'App\Model\Table\DominusPerfisTable'];
        $this->DominusPerfis = TableRegistry::get('DominusPerfis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DominusPerfis);

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
