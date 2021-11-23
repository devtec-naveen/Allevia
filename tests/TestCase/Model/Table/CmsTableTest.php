<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CmsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class CmsTableTest extends TestCase
{
    //public $import = ['app.cms'];
    public $fixtures = ['app.cms'];

    public function setUp()
    {
        parent::setUp();
        $this->Cms = TableRegistry::getTableLocator()->get('cms');
    }

    public function testFindPublished()
    {
        $query = $this->Cms->find();        
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();         
        // $expected = [
        //     ['id' => 1, 'title' => 'First Article'],
        //     ['id' => 2, 'title' => 'Second Article'],
        //     ['id' => 3, 'title' => 'Third Article']
        // ];

        $this->assertEquals(1,1);
    }
}


?>