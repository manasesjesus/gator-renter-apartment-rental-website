<?php

class Apartment extends Controller {

    public function index() {
        header('Content-Type: application/json;charset=UTR-8');
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->handleHTTPGet();
                break;
            case 'POST':
                $this->handleHTTPPost();
                break;
            case 'DELETE':
                $this->handleHTTPDelete();
                break;
            default:
                http_response_code(400);
                print json_encode(['error' => 'Unsupported HTTP Method']);
        }
    }

    function handleHTTPGet() {
        $getting_one = isset($_GET['id']) && is_numeric($_GET['id']);
        $getting_owner = isset($_GET['owner_id']) && is_numeric($_GET['owner_id']);
        if($getting_one) {
            $apts = $this->model->getApartment($_GET['id']);
        } elseif($getting_owner) {
            $apts = $this->model->getOwnersApartments($_GET['owner_id']);
        } else {
            $apts = $this->model->getAllApartments();
        }
        foreach($apts as $key => $apt) {
            $apts[$key]->id             = (Int)$apts[$key]->id;
            $apts[$key]->owner_id       = (Int)$apts[$key]->owner_id;
            $apts[$key]->active         = (Boolean)$apts[$key]->active;
            $apts[$key]->sq_feet        = (Double)$apts[$key]->sq_feet;
            $apts[$key]->nr_bedrooms    = (Int)$apts[$key]->nr_bedrooms;
            $apts[$key]->nr_bathrooms   = (Int)$apts[$key]->nr_bathrooms;
            $apts[$key]->nr_roommates   = (Int)$apts[$key]->nr_roommates;
            $apts[$key]->floor          = (Int)$apts[$key]->floor;
            $apts[$key]->private_room   = $apts[$key]->private_room === '1';
            $apts[$key]->private_bath   = $apts[$key]->private_bath === '1';
            $apts[$key]->kitchen_in_apartment = $apts[$key]->kitchen_in_apartment === '1';
            $apts[$key]->has_security_deposit = $apts[$key]->has_security_deposit === '1';
            $apts[$key]->credit_score_check = $apts[$key]->credit_score_check === '1';
            $apts[$key]->monthly_rent   = (Double)$apts[$key]->monthly_rent;
            $apts[$key]->security_deposit = (Double)$apts[$key]->security_deposit;
            $apts[$key]->flagged        = $apts[$key]->flagged === '1';
            $pics = $this->model->getPictures($apts[$key]->id);
            $apts[$key]->pictures = $pics;
        }
        print json_encode($getting_one ? $apts[0] : $apts);
    }

    function handleHTTPPost() {
        $data = json_decode(file_get_contents('php://input'), true);
        $pics = null;
        if(isset($data['pictures'])) {
            $pics = $data['pictures'];
            unset($data['pictures']);
        }
        $error_array = [];
        $fields = ['active', 'created_at', 'updated_at', 'flagged'];
        $values = [1, date('Y-m-d'), date('Y-m-d'), 0];
        $validations = [
            'address_line_1'        => ['required' => true, 'regex' => '/.{5,}/i'],
            'address_line_2'        => ['required' => false, 'regex' => '/.{4,}/i'],
            'city'                  => ['required' => true, 'regex' => '/.{2,}/i'],
            /*'state'                 => ['required' => false, 'regex' => '/[A-Z]{2}/'],*/
            'zip'                   => ['required' => true, 'regex' => '/[0-9]{5}/'],
            'title'                 => ['required' => true, 'regex' => '/.{5,}/i'],
            'description'           => ['required' => true, 'regex' => '/.{20,}/i'],
            'sq_feet'               => ['required' => false, 'regex' => '/[0-9]{1,6}/'],
            'nr_bedrooms'           => ['required' => true, 'regex' => '/[0-9]/'],
            'nr_bathrooms'          => ['required' => true, 'regex' => '/[0-9]/'],
            'nr_roommates'          => ['required' => true, 'regex' => '/[0-9]{1,2}/'],
            'floor'                 => ['required' => false, 'regex' => '/[0-9]{1,3}/'],
            'private_room'          => ['required' => true, 'regex' => '/[0|1]/'],
            'private_bath'          => ['required' => true, 'regex' => '/[0|1]/'],
            'kitchen_in_apartment'  => ['required' => false, 'regex' => '/[0|1]/'],
            'has_security_deposit'  => ['required' => false, 'regex' => '/[0|1]/'],
            'credit_score_check'    => ['required' => false, 'regex' => '/[0|1]/'],
            'monthly_rent'          => ['required' => true, 'regex' => '/[0-9]{1,5}/'],
            'security_deposit'      => ['required' => false, 'regex' => '/[0-9]{1,5}/'],
            'available_since'       => ['required' => false, 'regex' => '/[0-9]{4}-[0-9]{2}-[0-9]{2}/'],
            'lease_end_date'        => ['required' => false, 'regex' => '/[0-9]{4}-[0-9]{2}-[0-9]{2}/'],
            'owner_id'              => ['required' => true, 'regex' => '/\d*/']
        ];
        foreach($validations as $key => $value) {
            if($value['required']) {
                if(!isset($data[$key])) {
                    array_push($error_array, $key);
                } else {
                    if(!preg_match($value['regex'], $data[$key])) {
                        array_push($error_array, $key);
                    } else {
                        array_push($fields, $key);
                        array_push($values, $data[$key]);
                    }
                }
            } elseif(isset($data[$key])) {
                if(!preg_match($value['regex'], $data[$key])) {
                    array_push($error_array, $key);
                } else {
                    array_push($fields, $key);
                    array_push($values, $data[$key]);
                }
            }
        }
        if(sizeof($error_array) == 0) {
            $latlong = $this->getLatitudeLongitude($data);
            array_push($fields, 'latitude');
            array_push($fields, 'longitude');
            array_push($values, $latlong['latitude']);
            array_push($values, $latlong['longitude']);
            print json_encode($this->model->createApartment($fields, $values, $pics));
        } else {
            http_response_code(400);
            print json_encode(['error' => $error_array]);
        }
    }

    function handleHTTPDelete() {
        if(isset($_GET['id']) && is_numeric($_GET['id'])) {
            $apts = $this->model->deleteApartment($_GET['id']);
        } else {
            http_response_code(400);
            print json_encode(['error' => 'Bad request']);
        }
    }

    function getLatitudeLongitude($data) {
        //$address = join(' ', array($data['address_line_1'], $data['city'], $data['state']));
        $address = join(' ', array($data['address_line_1'], $data['city']));
        $prepAddr = str_replace(' ', '+', $address);
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
        $output = json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
        return array('latitude' => $latitude, 'longitude' => $longitude);
    }
    
    /*
     * Search apartments across a combination of different paramters
     */
    public function searchApartment()
    {
        try
        {
            $apartmentCollection = $this->model->searchApartment($this->requestData);
            AbstractAPI::_response($apartmentCollection);
        }
        catch (Exception $ex)
        {
            AbstractApi::_response("Something unexpected happened", 500);
        }        
    }

}
