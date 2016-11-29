<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16
 * Time: 21:48
 */
class Authentic extends Controller
{
    public function index()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        echo json_encode($_SESSION);
    }
}