<?php
/**
 * Created by PhpStorm.
 * User: Intesar Haider
 * Date: 12/10/2016
 * Time: 2:47 AM
 */
class logout extends Controller
{
    /*
     * for REST request on login
     * This method handles what happens when frontend issue REST request this function
     */

    public function index()
    {
        session_start();

        session_unset();

        session_destroy();

        print "SUCCESS_LOGOUT";

    }
}