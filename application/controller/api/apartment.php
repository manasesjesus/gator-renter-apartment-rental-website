<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/22
 * Time: 20:33
 */
class Apartment extends Controller
{
    /*
     * Page index
     * This method handles what happens when you move to http://yourproject/apartment/index*/

    public function index()
    {
        $apts = $this->model->getAllApartments();
        header('Content-Type: application/json;charset=UTR-8');
        foreach($apts as $key => $apt) {
            $apts[$key]->id             = (Int)$apts[$key]->id;
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
        }
        print json_encode($apts);
    }
}
