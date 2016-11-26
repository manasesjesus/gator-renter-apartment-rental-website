<?php

class Upload extends Controller {

    public function index() {
        header('Content-Type: application/json;charset=UTR-8');
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->handleHTTPPost();
                break;
            default:
                http_response_code(400);
                print json_encode(['error' => 'Unsupported HTTP Method']);
        }
    }

    function handleHTTPPost() {
        $length = sizeof($_FILES['file']['name']);
        for($i = 0; $i < $length; $i++) {
            $filename = './upload/' . $_FILES['file']['name'][$i];
            move_uploaded_file($_FILES['file']['tmp_name'][$i], $filename);
        }
        print json_encode(['files' => $_FILES['file']['name']]);
    }

}
