<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;



/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class FormsManagementController extends AppController
{

    public function initialize()
    {
    parent::initialize();
      $this->loadComponent('Paginator');
    }

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
       
    }


   
}
