<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller { // extends for access to Controller variables and methods


    // that apply custom settings to all Actions in one time
    public function before(){
        $this->view->layout = 'custom';

        //to start this method add ($this->before();) to Controller __construct(...)
    }

    public function loginAction(){

        $this->view->render('Login');
    }

    public function registerAction(){


        //$this->view->path = "test/test"; dynamical path
        //$this->view->layout= "custom"; custom layout

        $this->view->render('Registration'); // title in html code


    }
}