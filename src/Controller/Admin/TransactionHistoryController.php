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
class TransactionHistoryController extends AppController
{

    public function initialize()
    {
    parent::initialize();
      $this->loadComponent('Paginator');
      $this->loadModel('TransactionHistory');
    }

    public function index()
    {
        // Set the layout.
        $this->viewBuilder()->setLayout('admin');
        $transactionHistory = $this->paginate($this->TransactionHistory->find('all',array('order' =>array('TransactionHistory.id' =>'desc')))->contain(['Schedules']));
        //pr($transactionHistory);die;
        $this->set(compact('transactionHistory'));
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */  
}
