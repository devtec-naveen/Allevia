<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;
use Cake\Datasource\ConnectionInterface;


class UserInfoFixture extends TestFixture
{    
    public $import = array('model' => 'UserInfo', 'records' => true, 'connection' => 'default');    
    public function init()
    {
        // $this->records = [
        //     [
        //         'title' => 'First Article',
        //         'menu_display_title' => 'First Article Body',
        //         'menu_type' => '1',
        //         "slug" => "test",
        //         "content" => "ddsg",
        //         "image" => 'xxc',
        //         "video_url" => "hc",
        //         "bottom_content" => 'fdgdfg',
        //         'created' => date('Y-m-d H:i:s'),
        //         'modified' => date('Y-m-d H:i:s'),
        //     ],
        // ];
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