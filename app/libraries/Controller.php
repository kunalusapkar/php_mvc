<?php 
/*
* Base controller
* Loads the model and views
*/

class Controller{
    public function model($model){
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    // Load view

    public function view($view,$data = []){
        // check for view file
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            die('View doesnot exists');
        }
    }
}