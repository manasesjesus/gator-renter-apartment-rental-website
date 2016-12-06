<?php

class Application
{
    /** @var null The controller */
    private $url_controller = null;
    
    private $url_controllerName = null; 

    /** @var null The method (of the above controller), often also named "action" */
    private $url_action = null;

    /** @var array URL parameters */
    private $url_params = array();

    /** @var subfolder */
    private $subfolder = '';

    /* @var sessionActionFilters file */ 
    private $sessionActionFiltersFile = ''; 
    
    /**
     * "Start" the application:
     * Analyze the URL elements and calls the according controller/method or the fallback
     */
    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();

        $controller_file = APP . 'controller/' . $this->subfolder . $this->url_controller . '.php';

        $sessionActionFiltersFile = APP . 'controller/' . 'sessionActionFilters' .'.php'; 
         
        if (file_exists($sessionActionFiltersFile) ) 
        { 
            require $sessionActionFiltersFile; 
        } 
        
        // check for controller: no controller given ? then load start-page
        if (!$this->url_controller) {
            
            require APP . 'controller/home.php';
            $page = new Home();
            $page->index();

        } elseif (file_exists($controller_file)) {
            // here we did check for controller: does such a controller exist ?

            // if so, then load this file and create this controller
            // example: if controller would be "car", then this line would translate into: $this->car = new car();
            require $controller_file;
            
            $this->url_controller = new $this->url_controller();
            
                            
            //provide action to the controller, if interface exists
            if(method_exists($this->url_controller, "setAction"))
            {
                call_user_func(array($this->url_controller, "setAction"), $this->url_action);
            }
            
            //provide parameters to the controller, if interface exists
            if(method_exists($this->url_controller, "setParameters"))
            {
                call_user_func(array($this->url_controller, "setParameters"), $this->url_params);
            }
            
            //provide parameters to the controller, if interface exists
            if(method_exists($this->url_controller, "setSubfolder"))
            {
                call_user_func(array($this->url_controller, "setSubfolder"), $this->subfolder);
            }
            
            if(method_exists($this->url_controller, "processRequest"))
            {
                call_user_func(array($this->url_controller, "processRequest"));
            }

            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action)) {

                if (isset($sessionActionFilters[$this->url_controllerName])  
                        AND $sessionActionFilters[$this->url_controllerName] == $this->url_action) { 
                    //call the session verification method in the controller base 
                    $this->url_controller->validateSession(); 
                }
                
                if (!empty($this->url_params)) {
                    // Call the method and pass arguments to it
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                } else {
                    // If no parameters are given, just call the method without parameters, like $this->home->method();
                    $this->url_controller->{$this->url_action}();
                }

            } else {
                if (strlen($this->url_action) == 0) {
                    
                    if (isset($sessionActionFilters[$this->url_controllerName])  
                            AND $sessionActionFilters[$this->url_controllerName] == 'index') { 
                        //call the session verification method in the controller base 
                        $this->url_controller->validateSession(); 
                    }
                    // no action defined: call the default index() method of a selected controller
                    $this->url_controller->index();
                }
                else {
                    header('location: ' . URL . 'problem');
                }
            }
        } else {
            header('location: ' . URL . 'problem');
        }
    }

    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (isset($_GET['url'])) {

            // split URL
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Put URL parts into according properties
            // By the way, the syntax here is just a short form of if/else, called "Ternary Operators"
            // @see http://davidwalsh.name/php-shorthand-if-else-ternary-operators
            $offset = 0;
            if(isset($url[0]) && $url[0] === 'api') {
                $offset = 1;
                $this->subfolder = 'api/';
            }
            $this->url_controller = isset($url[0 + $offset]) ? $url[0 + $offset] : null;
            $this->url_controllerName = $this->url_controller;
            $this->url_action = isset($url[1 + $offset]) ? $url[1 + $offset] : null;
            
            // Remove controller and action from the split URL
            if($this->subfolder == 'api/')
                unset($url[0], $url[0 + $offset], $url[1 + $offset]);
            else
                unset($url[0 + $offset], $url[1 + $offset]);
            
            
            // Rebase array keys and store the URL params
            $this->url_params = array_values($url);
            
            $this->arrangeKeyValuePairForParamaters();

            // for debugging. uncomment this if you have problems with the URL
            //echo 'Controller: ' . $this->url_controller . '<br>';
            //echo 'Action: ' . $this->url_action . '<br>';
            //echo 'Parameters: ' . print_r($this->url_params, true) . '<br>';
            //echo 'Subfolder: ' . print_r($this->subfolder, true) . '<br>';
        }
    }
    
    /*
     * Arrange parameters extracted as key value pairs
     */
    private function arrangeKeyValuePairForParamaters()
    {
        $parametersCount = count($this->url_params);
        $parameters;
        
        if ($parametersCount % 2 != 0) {
            throw Exception("Invalid parameter set provided, expecting a key "
                    . "value pair for each parameter!");
        }
        
        $parameters = array();

        for($i = 0; $i < $parametersCount; $i++ )
        {
            $parameters[$this->url_params[$i]] = $this->url_params[$i + 1];
            $i++;
        }
        
        $this->url_params = $parameters;
    }

}
