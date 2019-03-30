<?php
namespace application\core;

use application\core\View;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        // Add routes to route
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val){
            $this->add($key,$val); // Перебирает массив и записывает в функцию add (route,params)
        }


        // элементы массива стали выржаниеями '#^'.."$#'
        //debug($this->routes);
    }


    // проходит через регулярные проверки
    // добавляет маршрут
    public function add($route, $params){

        //$params = [controller => account , action => login]
        //$route = account/login , account/register

        // сделаем полноценное выражение для preg match
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;


        /*echo '<p>'.$route.'</p>';
        var_dump($params);
        */
    }


    // проверяет есть ли такой маршрут
    public function match(){

        // $url = /account/login
        $url = trim($_SERVER['REQUEST_URI'], '/'); // вырезаем /, так как на первом месте он не нужен

        foreach ($this->routes as $route => $params){
            if(preg_match($route,$url,$matches))
            {
                $this->params = $params; // $this->params we will use in function run()
                //var_dump($matches);

                return true;

            }
        }
        return false;

        //debug($_SERVER);
    }

    public function run(){
        if($this->match()){

            // create full path application\controllers\MainController
            // ucfirst Upper Case First symbol
            // example of $path: application\controllers\AccountController
            $path = 'application\controllers\\'.ucfirst($this->params['controller'].'Controller');
            if(class_exists($path)){

                // we add prefix 'Action' that use function hide(). This is specific function, user cant use it!!!!
                $action = $this->params['action'].'Action'; // example of $action: loginAction


                if(method_exists($path,$action)){ // if in class $path exist $action method do...

                    // example of $this->params: { ["controller"]=> string(7) "account" ["action"]=> string(5) "login" }
                    $controller = new $path($this->params); // create class object (example: AccountController)
                    // example of $controller:
                    //object(application\controllers\AccountController)#3 (2) {
                    //  ["route"]=>
                    //  array(2) {
                    //    ["controller"]=>
                    //    string(7) "account"
                    //    ["action"]=>
                    //    string(5) "login"
                    //  }
                    //  ["view"]=>
                    //  object(application\core\View)#4 (3) {
                    //    ["path"]=>
                    //    string(13) "account/login"
                    //    ["route"]=>
                    //    array(2) {
                    //      ["controller"]=>
                    //      string(7) "account"
                    //      ["action"]=>
                    //      string(5) "login"
                    //    }
                    //    ["layout"]=>
                    //    string(7) "default"
                    //  }
                    //}
                    $controller->$action(); // AccountController -> loginController
                }else{
                    View::errorCode(404); // call errorCode($code) of class View
                }
                //echo "class controller exist: " . $path;
            }else{
                View::errorCode(404);
            }

        }else{
            View::errorCode(500);
        }
    }

}