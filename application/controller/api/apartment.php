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
        $numofApartments = $this->model->getAmountOfApartments();
        $trackofApts = 0;
        header('Content-Type: application/json;charset=UTR-8');
        echo "[";
        foreach ($apts as $apt) {
            $trackofApts++;
            $arr = Array('id' => $apt->id,
                'active' => $apt->active,
                'created_at' => $apt->created_at,
                'updated_at' => $apt->updated_at,
                'address_line_1' => $apt->address_line_1,
                'address_line_2' => $apt->address_line_2,
                'city' => $apt->city,
                'state' => $apt->state,
                'country' => $apt->country,
                'ZIP' => $apt->ZIP,
                'title' => $apt->title,
                'description' => $apt->description,
                'sq_feet' => $apt->sq_feet,
                'nr_bedrooms' => $apt->nr_bedrooms,
                'nr_bathrooms' => $apt->nr_bathrooms,
                'nr_roommates' => $apt->nr_roommates,
                'floor' => $apt->floor,
                'private_room' => $apt->private_room,
                'private_bath' => $apt->private_bath,
                'kitchen_in_apartment' => $apt->kitchen_in_apartment,
                'monthly_rent' => $apt->monthly_rent,
                'security_deposit' => $apt->security_deposit,
                'pictures' => $apt->pictures,
                'available_since' => $apt->available_since,
                'lease_end_date' => $apt->lease_end_date,
                'flagged' => $apt->flagged);
            echo json_encode($arr);
            if ($trackofApts < $numofApartments) {
                echo ",";
            }
        }
	echo "]";

//        echo "[";
//        $arr = Array('id' => '0', 'address_line' => '350 Octavia');
//        echo json_encode($arr);
//        $arr = Array('id' => '1', 'address_line' => '351 Octavia');
//        echo ",";
//        echo json_encode($arr);
//        echo "]";
    }
}
