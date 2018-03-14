<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminMenuItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminMenuItensTable Test Case
 */
class AdminMenuItensTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminMenuItensTable
     */
    public $AdminMenuItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.admin_menu_itens',
        'app.admin_menu',
        'app.controllers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AdminMenuItens') ? [] : ['className' => 'App\Model\Table\AdminMenuItensTable'];
        $this->AdminMenuItens = TableRegistry::get('AdminMenuItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminMenuItens);

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
