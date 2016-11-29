<?php
/**
 * Created by Intesar
 * Date: 11/20/2016
 * Time: 3:36 AM
 */


abstract class AbstractAPI extends Controller
{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';

    /**
     * Property: file
     * Stores the input of the PUT request
     */
    protected $requestData = Null;

    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function processRequest($request) {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $args = explode('/', rtrim($request['url'], '/'));
        $this->endpoint = $args[1];

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) {
            case 'POST':
            case 'PUT':
                $this->requestData = json_decode(file_get_contents("php://input"), true);
                break;
            case 'GET':
            case 'DELETE':
                $this->requestData = isset($_GET['id']) ? $_GET['id'] : null;
                break;
            default:
                $this->_response('Invalid Method', 405);
                break;
        }

    }

    public function processAPI() {
        if (method_exists($this, $this->endpoint)) {
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);
    }

    protected function _response($data, $status = 200) {

        if($status == 200) { //if SUCCESS
            header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
            echo json_encode(array('success' => true, 'data' => $data));

        } else {
            header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
            echo json_encode(array('success' => false, 'reason' => $data));
        }

        //stop executing the program, so this function should always be called at the end of any function
        die();
    }

    private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code) {
        $status = array(
            200 => 'OK',
            400 => 'Bad Request',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }
}