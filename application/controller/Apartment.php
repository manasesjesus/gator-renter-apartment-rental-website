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
        foreach ($apts as $apt) {
            $arr = Array('id' => $apt->id, 'artist' => $apt->artist, 'track'=>$apt->track);
            echo json_encode($arr);
            echo ",";
        }

//        echo "[";
//        $arr = Array('id' => '0', 'address_line' => '350 Octavia');
//        echo json_encode($arr);
//        $arr = Array('id' => '1', 'address_line' => '351 Octavia');
//        echo ",";
//        echo json_encode($arr);
//        echo "]";
    }
}