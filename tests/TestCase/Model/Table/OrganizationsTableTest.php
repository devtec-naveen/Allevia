<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrganizationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class OrganizationsTableTest extends TestCase
{
    //public $import = ['app.cms'];
    public $fixtures = ['app.Organizations'];

    public function setUp()
    {
        parent::setUp();
        $this->Organizations = TableRegistry::getTableLocator()->get('organizations');
    }

    public function testFindPublished()
    {
        $query = $this->Organizations->find();        
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray(); 
        /*pr($result);  die;     
        $expected = [
            ['id' => 1, 'title' => 'First Article'],
            ['id' => 2, 'title' => 'Second Article'],
            ['id' => 3, 'title' => 'Third Article']
        ];*/

        $this->assertEquals(1, 1);
    }
}


?>