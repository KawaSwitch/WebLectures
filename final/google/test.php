<?php
session_start();
require_once 'vendor/autoload.php';

$id_token = filter_input(INPUT_POST, 'id_token');
define('CLIENT_ID', '996090197467-8jope8j70juid4kuoesaaoupkleh73n0.apps.googleusercontent.com');

$client = new Google_Client(['client_id' => CLIENT_ID]); 
$client->addScope("email");
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub'];
}

//DBとのやりとりする

$_SESSION['login'] = true;
exit;