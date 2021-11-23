<?php
namespace App\Controller\Component;
use Cake\Core\App;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\Controller\Controller;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use ReflectionClass;
use ReflectionMethod;

class ControllerListComponent extends Component{

   
  public function getControllers() {
       $controllerClasses = App::path('Controller');
        $path = App::path('Controller');
        $dir = new Folder($path[0]);
        $files = $dir->findRecursive('.*Controller\.php');
        $results = [];
        foreach ($files as $file) {
            $controller = str_replace(App::path('Controller'), '', $file);
            $controller = explode('.', $controller)[0];
            $controller = str_replace('Controller', '', $controller);
            $controller = str_replace(DS, '\\', $controller);
            array_push($results, $controller);
        }
        return $results;
    }

     private function getActions($controllerName)
    {
        $className = 'App\\Controller\\' . $controllerName . 'Controller';
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $controllerName = str_replace("\\", "/", $controllerName);
        $results = [$controllerName => []];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize', 'beforeRender'];
        foreach ($actions as $action) {
            if ($action->class == $className
                && !in_array($action->name, $ignoreList)
            ) {
                array_push($results[$controllerName], $action->name);
            }
        }
        return $results;
    }

    public function getResources()
    {
        $controllers = $this->getControllers();

        $resources = [];
        foreach ($controllers as $controller) {
            $actions = $this->getActions($controller);
            array_push($resources, $actions);
        }
        return $resources;
    }

          
}