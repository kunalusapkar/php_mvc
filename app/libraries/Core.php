<?php

/*
*App core class
*Creates URL & loads core controller
*URL FORMAT - /controller/methods/params
*/

class Core{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        //print_r($this->getUrl());
        $url = $this->getUrl();    
         // look in controller for the value
        if(file_exists('../app/controllers/' . ucwords($url[0]. '.php'))){
            // if exists set as a controller
            $this->currentController = ucwords($url[0]);
            // unset 0 index
            unset($url[0]); 
        }
        // require the current class
        require_once '../app/controllers/'. $this->currentController . '.php'; 
        // instantiate the controller class
        $this->currentController = new $this->currentController;

        if(isset($url[1])){
            // check if method exists in controller
            if(method_exists($this->currentController,$url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]); 
            }
            
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params

        call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
    }

    public function getUrl(){
       if(isset($_GET['url'])){
           $url = rtrim($_GET['url'],'/');
           $url = filter_var($url, FILTER_SANITIZE_URL);
           $url = explode('/', $url);
           return $url;
       }
    }
}