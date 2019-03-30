<?php

namespace application\core;

use application\core\View;

abstract class Controller{


    public $route;
    public $view; //property

    public function __construct($route){
        $this->route = $route;
        $this->view = new View($route); //run View class with $this->view property
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name){
        $path = 'application\models\\'.ucfirst($name);
        if(class_exists($path)){
            return new $path;
        }
    }
}