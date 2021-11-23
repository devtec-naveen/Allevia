<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;
use Cake\Datasource\ConnectionInterface;


class DoctorsFixture extends TestFixture
{    
    public $import = array('model' => 'Doctors', 'records' => true, 'connection' => 'default');    
    public function init()
    {       
        parent::init();
    }


     public function truncate(ConnectionInterface $db){

        return null;
    }

    // do not drop movie_stars table between tests
    public function drop(ConnectionInterface $db){

        return null;
    }
}

?>