<?php
    session_set_cookie_params(0, "/", "", true, true);
    session_name('PHPSESSID_FEEDME');
    session_start();
?>
<?
    require 'session_checks.php';
    $response = array('error' => NULL);

    echo "This is cool";

    //if (empty($_SERVER['HTTPS'])) {
      //  $response['error'] = 'request not https';
    //} else {
        //if (authenticatedSession()) {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
               // if (empty($_GET['information']) || empty($_GET['restaurant_id'])) {
                //   $response['error'] = 'missing information or restaurant_id parameter';
                //}

            } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            } else {
                $response['error'] = 'invalid request method';
            }
        //} else {
            //$response['error'] = 'user not authenticated';
       // }
    //}
?>