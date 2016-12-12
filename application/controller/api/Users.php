<?php

require_once APP . 'controller/api/AbstractApi.php';
/**
 * Created by Intesar Haider.
 * This class will strictly be used for USER specific CRUD
 * Date: 11/20/2016
 * Time: 2:57 AM
 * Modified by: Manasés Galindo
 */
class Users extends AbstractAPI  {


    public function index() {

        AbstractAPI::processRequest($_REQUEST);

        switch($this->method) {
            case 'POST':
                $this->addNewUser();
                break;
            case 'PUT':
                $this->updateUser();
                break;
            case 'GET':
                $this->getUserDetail();
                break;
            case 'DELETE':
                //$this->deleteUser();
                $this->toggleUser();
                break;
            default:
                _response("No Endpoint: $this->endpoint", 404);
        }
    }

    /**
     * METHOD : POST
     */
    public function addNewUser() {

        $requestPayload = $this->requestData;

        $userInfo = $this->model->getUserInfo($requestPayload['email']);
        if (isset($userInfo) && $userInfo != false) {
            AbstractApi::_response('User with same email already exist', 500);
        }

        // password encryption logic
        $requestPayload['password'] = Helper::encryptPassword($requestPayload['password']);
        $response = $this->model->saveNewUser($requestPayload);

        if(Helper::saveSuccessful($response)) {
            AbstractApi::_response($response);
        } else {
            AbstractApi::_response("Something unexpected happened", 500);
        }
    }

    /**
     * METHOD : PUT
     */
    public function updateUser() {

        $requestPayload = $this->requestData;
        
        $status = $this->model->updateUser($requestPayload);
        
        if($status==true) {
            AbstractApi::_response($requestPayload);
        } else {
            AbstractApi::_response("Something unexpected happened", 500);
        }
    }

    /**
     * METHOD : GET
     */
    public function getUserDetail() {
        if(is_null($this->requestData)) { //get all the users
            $apts = $this->model->getUserInfoById(null);
        } else { // get user by user id
            $apts = $this->model->getUserInfoById($this->requestData);
        }
        echo json_encode($apts);
    }

    /**
     * METHOD : DELETE
     */
    public function deleteUser() {

        //if user id, that's need to be deleted is missing, show error
        if(is_null($this->requestData)) $this->_response('Invalid Request! User ID to delete is missing', 400);

        //finding user with the ID
        $userInfo = $this->model->getUserInfoById($this->requestData);
        if (!isset($userInfo) || $userInfo == false) {
            AbstractApi::_response("User with ID [$this->requestData] does not exist", 500);
            return;
        }

        $status = $this->model->deleteUser($this->requestData);

        if($status==true) {
            AbstractApi::_response("User with ID = $this->requestData successfully deleted!");
        }
    }

    /**
     * METHOD : DELETE
     * Toggle the active status of a user
     */
    public function toggleUser() {

        //if user id, that's need to be deleted is missing, show error
        if(is_null($this->requestData)) $this->_response('Invalid Request! User ID to delete is missing', 400);

        $data = array("uid" => $_GET['uid'], "status" => $_GET['status']);
        $status = $this->model->toggleUser($data);

        if($status==true) {
            AbstractApi::_response("User successfully toggled!");
        }
    }
}