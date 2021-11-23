 <?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Cake\ORM\TableRegistry;
use App\Middleware\ApiCommonMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */



Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {

    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));

$request_url = explode("/", trim($_SERVER['REQUEST_URI']));
//pr($request_url);die;
if(count($request_url) == 7 && $request_url[3] == 'dashboard' && $request_url[4] == 'fill-appointment-link'){

    $orgTlb = TableRegistry::get('Organizations');
    $org_detail = $orgTlb->find('all')->where(['org_url' => $request_url[2]])->first();
    if(!empty($org_detail)){
        
            $routes->redirect(
                '/:prefix/:controller/:action/:id/:sid',
                ['prefix' => 'providers','controller' => 'Dashboard', 'action' => 'fillAppointmentLink','pass'=> [$request_url[5],$request_url[6]]],
                ['persist' => true]
                // Or ['persist'=>['id']] for default routing where the
                // view action expects $id as an argument.
            );
    }
    else{

        $routes->redirect('/', ['controller' => 'Pages', 'action' => 'pageNotFound', 'home']);

    }
}

if(isset($request_url[2]) && isset($request_url[5]) && (isset($request_url[4]) && ($request_url[4] == 'register-front-user' || $request_url[4] == 'new-appointment'))){

    $orgTlb = TableRegistry::get('Organizations');
    $org_detail = $orgTlb->find('all')->where(['org_url' => $request_url[2]])->first();
    if(!empty($org_detail)){

        if($request_url[4] == 'new-appointment'){

            $routes->redirect(
                '/:prefix/:controller/:action/:id',
                ['prefix' => false,'controller' => 'Users', 'action' => 'newAppointment','pass'=> [$request_url[5]]],
                ['persist' => true]
                // Or ['persist'=>['id']] for default routing where the
                // view action expects $id as an argument.
            );
        }
        else{

            //die('dfdf');
            $routes->redirect(
                    '/:prefix/:controller/:action/:id',
                    ['prefix' => false,'controller' => 'Users', 'action' => 'registerFrontUser','pass'=> [$request_url[5]]],
                    ['persist' => true]
                    // Or ['persist'=>['id']] for default routing where the
                    // view action expects $id as an argument.
                );
        }
    }
    else{

        $routes->redirect('/', ['controller' => 'Pages', 'action' => 'pageNotFound', 'home']);

    }
}
// below route used to redirect /dashboard to new appointment page according to client requirement
    $routes->redirect(
        '/users/dashboard/*',
        ['controller' => 'Users', 'action' => 'scheduledAppointments','prefix' => false],
        ['persist' => false]
        // Or ['persist'=>['id']] for default routing where the
        // view action expects $id as an argument.
    );

    $routes->redirect(
        '/users',
        ['controller' => 'Users', 'action' => 'scheduledAppointments','prefix' => false],
        ['persist' => false]
        // Or ['persist'=>['id']] for default routing where the
        // view action expects $id as an argument.
    );


    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */


    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home', 'home']);
    //$routes->connect('/pages/chief-complaint-detail', ['controller' => 'Pages', 'action' => 'chiefComplaintDetail', '']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */

     $routes->connect('/admin/', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login']);
     $routes->connect('/admin/login', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login']);

    $routes->connect('/providers/', ['prefix' => 'providers', 'controller' => 'Users', 'action' => 'login']);
    $routes->connect('/organizations/', ['prefix' => 'organizations', 'controller' => 'Users', 'action' => 'login']);
    $routes->connect('/organizations/reset-password/:id', ['prefix' => 'organizations', 'controller' => 'Users', 'action' => 'resetPassword']);
    $routes->connect('/providers/login', ['prefix' => 'providers', 'controller' => 'Users', 'action' => 'login']);
    $routes->connect('/api/micro/v1', ['prefix' => 'api/micro', 'controller' => 'V1', 'action' => 'index']);
     $routes->connect('/api/micro/v1/details', ['prefix' => 'api/micro', 'controller' => 'V1', 'action' => 'details']);
     $routes->connect('/api/micro/v1/update', ['prefix' => 'api/micro', 'controller' => 'V1', 'action' => 'update']);
     $routes->connect('/api/micro/v1/note', ['prefix' => 'api/micro', 'controller' => 'V1', 'action' => 'note']);
     $routes->connect('/api/micro/v1/auth', ['prefix' => 'api/micro', 'controller' => 'V1', 'action' => 'auth']);
    $routes->fallbacks(DashedRoute::class);
});

 Router::scope('/services/', function (RouteBuilder $builder) {
    $builder->connect('/', ['controller' => 'Pages', 'action' => 'home', 'home', 'prefix' => false]);

    $builder->connect(
        '/users/dashboard/*',
        ['controller' => 'Users', 'action' => 'scheduledAppointments','prefix' => false],
        ['persist' => true]
        // Or ['persist'=>['id']] for default routing where the
        // view action expects $id as an argument.
    );

    $builder->connect(
        '/users',
        ['controller' => 'Users', 'action' => 'scheduledAppointments','prefix' => false],
        ['persist' => true]
        // Or ['persist'=>['id']] for default routing where the
        // view action expects $id as an argument.
    );
    $builder->fallbacks();
});

 //apply api common middleware to handle common problens of api
Router::scope('/services/', function (RouteBuilder $builder) {
   // Register scoped middleware for in scopes.
      $builder->registerMiddleware('apicommon', new ApiCommonMiddleware([
      'httpOnly' => true,
   ]));
   $builder->applyMiddleware('apicommon');
   $builder->connect('/oauth2/token', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'token']);
   $builder->connect('/api/schedule-appointments', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'scheduleAppointments']);
    $builder->connect('/api/all-appointments', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'allAppointments']);
    $builder->connect('/api/delete-appointments', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'deleteAppointment']);

    $builder->connect('/api/preappointment-questionnaires', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'accessPreAppointmentquestionnaire']);

    $builder->connect('/api/view-note', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'viewNote']);

    $builder->connect('/api/view-recent-notes', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'viewRecentNotes']);

    $builder->connect('/api/latest-note', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'latestNote']);

    $builder->connect('/api/schedule-appointment-mrn', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'scheduleAppointmentMrn']);

    $builder->connect('/api/all-notes-mrn', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'allNotesMrn']);

    $builder->connect('/api/all-appointment-mrn', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'allAppointmentsByMrn']);
    

    $builder->connect('/api/send-reminder',['prefix' =>'services','controller' =>'Webservice','action' =>'sendReminder']);

    $builder->connect('/api/get-questionnaire',['prefix' =>'services','controller' =>'Webservice','action' =>'getQuestionnaire']);    

    $builder->connect('/api/register-patients', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'registerPatients']);

    $builder->connect('/api/view-medical-history', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'viewMedicalHistory']);

    $builder->connect('/api/edit-medical-history', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'editMedicalHistory']);

    $builder->connect('/api/save-edit-medical-history', ['prefix' => 'services', 'controller' => 'Webservice', 'action' => 'saveEditMedicalHistory']);


    $builder->connect('/api/pre-appointment', ['prefix' => 'services', 'controller' => 'Patientservice', 'action' => 'preAppointment']);

    $builder->connect('/api/medical-history', ['prefix' => 'services', 'controller' => 'Patientservice', 'action' => 'medicalHistory']);
    $builder->fallbacks();
});

/*Plugin::routes();*/
Router::prefix('admin', function ($routes) {
    $routes->fallbacks('DashedRoute');
});

/*Router::prefix('fch', function ($routes) {
    $routes->fallbacks('DashedRoute');
});*/

Router::prefix('organizations', function ($routes) {
    $routes->fallbacks('DashedRoute');
});

Router::prefix('providers', function ($routes) {
    $routes->fallbacks('DashedRoute');
});

Router::prefix('services', function ($routes) {
    $routes->fallbacks('DashedRoute');
});


