<?php

namespace application\core;

 class View{

    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route){
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($title,$vars = []){
        extract($vars); // Extract values from array($vars)
        // after that we can use it fe(index.php)< where fe = for example
        $path = 'application/views/'.$this->path.'.php';
        if(file_exists($path)){

            // Copy to buffer and assign to content
            //Копируем в буфер и присваеваем к контенту
            ob_start(); //start copy
            require $path;
            $content = ob_get_clean(); // end copy

            // include layout
            require 'application/views/layouts/'.$this->layout.'.php';
        }

    }

    // $this->view->redirect("/"); in some of comtroller
     public function redirect($url){
        header('location: '.$url);
        exit;
     }

    public static function errorCode($code){
        http_response_code($code); // send to the server code status
        $path = 'application/views/errors/'.$code.'.php';
        if(file_exists($path)){
            require $path;
            exit;
        }

    }


}