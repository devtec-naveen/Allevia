<?php
namespace App\Middleware;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
 
class ApiCommonMiddleware
{
    public function __invoke($request, $response, $next)
    {
    	$getMetods = array('pre-appointment');
        if(!$request->is('post')){

            //die('xzcxzc');
        }        
        return $next($request, $response);
    }
}