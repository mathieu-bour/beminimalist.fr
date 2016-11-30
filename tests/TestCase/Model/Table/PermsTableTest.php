<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PermsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PermsTable Test Case
 */
class PermsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PermsTable
     */
    public $Perms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.perms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Perms') ? [] : ['className' => 'App\Model\Table\PermsTable'];
        $this->Perms = TableRegistry::get('Perms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Perms);

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
