<?php

namespace App\Service;

// use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class DevLog
{
    // private static $instance = null;

    // private function __construct()
    // {
    // }

    // public static function get()
    // {
    //     if(self::$instance === null)
    //     {
    //         self::$instance = new DevLog();
    //     }

    //     return self::$instance;
    // }
    /**
     * @var array <string, mixed>[] [$field_name => $value]
     */
    private static $data;
    private static $cloner;
    private static $dumper;

    public function __construct() //(RouterInterface $router) //(string $name, $variable) //, VarCloner $cloner)
    {
        // self::$data = array_merge(self::$data, $data);
        if (self::$cloner === null) {
            self::$cloner = new VarCloner();
        }
        if (self::$dumper === null) {
            self::$dumper = new HtmlDumper();
        }

        // if(!isset(self::$data)){
        //     self::$data[] = '';
        // }
        // if (self::$router === null) {
        //     self::$router = $router;
        //     // dd(self::$router->getRouteCollection()->all());
        // }
        // self::$data[$name] = self::$cloner->cloneVar($variable);
        // self::$data[$name] = $variable;
    }

    /**
     * Return property value.
     */
    public function __get($property)
    {
        return self::$data[$property];
    }

    public function log(string $name, $variable)
    {
        // if (self::$cloner === null) {
        //     self::$cloner = new VarCloner();
        // }
        // self::$data[$name] = $variable;
        // self::$data[$name] = self::$cloner->cloneVar($variable);
        self::$data[$name] = self::$dumper->dump(
            self::$cloner->cloneVar($variable), true
        );
        // dump(self::$data);
    }

    public function getData()
    {
        return self::$data;
    }
    // public function getRoutes()
    // {
    //     /**
    //      * Do NOT use getRouteCollection() in prod, it regenerates Routing cache
    //      * on each request.
    //      */
    //     return self::$router->getRouteCollection()->all();
    // }

    // public function getParameterLessRoutes(): array
    // {
    //     /**
    //      * Do NOT use getRouteCollection() in prod, it regenerates Routing cache
    //      * on each request.
    //      */
    //     $routes = self::$router->getRouteCollection()->all();


    //     $parameterLessRoutes = [];
    //     foreach ($routes as $name => $route) {
    //         if (!strpos($route->getPath(), '{')) {
    //             $parameterLessRoutes[] = $name;
    //         }
    //     }
    //     return $parameterLessRoutes;
    // }
}
