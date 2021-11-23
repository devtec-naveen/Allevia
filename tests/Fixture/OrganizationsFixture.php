<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;
use Cake\Datasource\ConnectionInterface;

class OrganizationsFixture extends TestFixture
{
    //public $import = ['table' => 'Organizations'];
    public $import = ['model' => 'Organizations'];
    public function init()
    {
        $this->records = [
            [
                'organization_name' => 'sdfsfss',
                'access_code' => '123456',
                'location' => 'sefsdffs',
                "clinic_logo" => "test",
                "clinic_data_dump" => "ddsg",
                "specialization_ids" => 'xxc',
                "api_key" => "hc",
                "api_secret" => 'fdgdfg',
                'api_system_id' =>'',
                "status" =>'1',
                "heading_color" =>'',
                "background_color" => '',
                "dashboard_background_color" =>'',
                "text_color" =>"",
                "button_gradient_color1" =>'',
                "button_gradient_color2" => '',
                "button_gradient_color3" => '',
                "active_button_color" => "",
                "hover_state_color" =>'',
                "active_state_color" => "",
                "link_color" => "",
                "link_hover_color" => "",
                "appoint_box_bg_color" =>"",
                "appoint_box_text_color" => "",
                "progress_bar_graphic" => '',
                "is_shown" => "1",
                "make_test_clinic" =>"1",
                "standard_openemr_output" =>'test',
                "destination_url_for_json" =>'',
                "org_url" =>'',
                "treatment_consent_docs" =>'',
                "privacy_policy_docs" =>'',
                "is_show_ancillary_docs" =>'1',
                "cl_group_id" =>'',
                "client_id" =>'',
                "client_secret" =>'',
                "show_credential" =>'1',
                "access_token" =>'',
                "user_id" =>'4384',
                "is_show_secret_key" =>'1',
                "is_request_accept" =>'1',
                "is_generate_new_key" =>'1',
                "clinic_logo_status" =>'0',
                "appoint_box_button_color" =>'',
                "allow_redirect_uri" =>'', 
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];
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

