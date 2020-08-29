<?php

class Core {
    protected $currentController = 'PagesController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        //print_r($this->getUrl());
        $url = $this->getUrl();

        //go to Controller
        if($url != null) {
            if (file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')) {

                $this->currentController = ucwords($url[0]) . 'Controller';

                unset($url[0]);
            }
        }

        //bring in Controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        //instantiate Controller
        $this->currentController = new $this->currentController;

        //check for method
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];

                unset($url[1]);
            }
        }

        //Get Params
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod],$this->params);
    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/',$url);
            return $url;
        }
    }
}

