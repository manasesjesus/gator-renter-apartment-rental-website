<?php

require_once APP . 'controller/api/AbstractApi.php';
/**
 * Created by Anil Manzoor.
 * This class will strictly be used for Message specific CRUD
 * Date: 02/12/2016
 * Time: 15:47
 */
class Message extends AbstractAPI  {


    public function index() {

        AbstractAPI::processRequest($_REQUEST);

        switch($this->method) {
            case 'POST':
                $this->addNewMessage();
                break;
            case 'PUT':
                $this->updateMessage();
                break;
            case 'GET':
                $this->getMessageDetail();
                break;
            case 'DELETE':
                $this->deleteMessage();
                break;
            default:
                _response("No Endpoint: $this->endpoint", 404);
        }
    }

    /**
     * METHOD : POST
     */
    public function addNewMessage() {
        $requestPayload = $this->requestData;
        
        $response = $this->model->saveNewMessage($requestPayload);
        
        if(Helper::saveSuccessful($response)) {
            AbstractApi::_response($response);
        } else {
            AbstractApi::_response("Something unexpected happened", 500);
        }

    }

    /**
     * METHOD : PUT
     */
    public function updateMessage() {
    }

    /**
     * METHOD : GET
     */
    public function getMessageDetail() {
    }

    /**
     * METHOD : DELETE
     */
    public function deleteMessage() {
    }
}