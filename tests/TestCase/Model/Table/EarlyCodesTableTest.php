<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EarlyCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EarlyCodesTable Test Case
 */
class EarlyCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EarlyCodesTable
     */
    public $EarlyCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.early_codes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EarlyCodes') ? [] : ['className' => 'App\Model\Table\EarlyCodesTable'];
        $this->EarlyCodes = TableRegistry::get('EarlyCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EarlyCodes);

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
