<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminMenuTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminMenuTable Test Case
 */
class AdminMenuTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminMenuTable
     */
    public $AdminMenu;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.admin_menu',
        'app.admin_menu_itens',
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
        $config = TableRegistry::exists('AdminMenu') ? [] : ['className' => 'App\Model\Table\AdminMenuTable'];
        $this->AdminMenu = TableRegistry::get('AdminMenu', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminMenu);

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
