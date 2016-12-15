<?php

class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    /**
     * @var null Model
     */
    public $model = null;

    /** @var null The method (of the above controller), often also named "action" */
    protected $url_action = '';

    /** @var array URL parameters */
    protected $url_params = '';

    /** @var subfolder */
    protected $subfolder = '';
    
    /**
     * Whenever controller is created, open a database connection too and load "the model".
     */
    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    /**
     * Loads the "model".
     * @return object model
     */
    public function loadModel()
    {
        require APP . 'model/model.php';
        // create new "model" (and pass the database connection)
        $this->model = new Model($this->db);
    }
    
        /*
     * Interface to provide consumer the extracted action
     */
    public function getAction()
    {
        return $this->url_action;
    }
    
    public function setAction($action)
    {
        $this->url_action = $action;
    }
    
    /*
     * Interface to provide consumer the extracted paramters
     */
    public function getParameters()
    {
        return $this->url_params;
    }
    
    public function setParameters($parameters)
    {
        $this->url_params = $parameters;
    }
    
    /*
     * Interface to provide consumer the extracted subfolder
     */
    public function getSubfolder()
    {
        return $this->subfolder;
    }
    
    public function setSubfolder($subfolder)
    {
        $this->subfolder = $subfolder;
    }
    
    /* 
     * Session authentication 
     */ 
    public function validateSession() 
    { 
        session_start(); 
        
        
        if(isset($_SESSION['authentic_user']) and $_SESSION['authentic_user'] != '') 
        { 
            $user_info = $this->model->getUserInfo($_SESSION['user_name']); 
                        
            if ($user_info == false) {
                session_unset();

                session_destroy();

                print "UNAUTHORIZED";
            } 
             
            if (!hash_equals($user_info->password, $_SESSION['password']) ) {
                session_unset();

                session_destroy();

                print "UNAUTHORIZED";
            } 
        } 
         
        session_write_close(); 
    } 
}
