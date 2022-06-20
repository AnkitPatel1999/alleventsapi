<?php


error_reporting(E_ALL);
ini_set('diplay_error',1);

//headers

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');

// required files
include_once("../../config/Database.php");
include_once("../../models/User.php");
include_once '../../vendor/autoload.php';   

// connct with db

$database = new Database;
$db = $database->connect();

$user = new User($db);

    $token = json_decode(file_get_contents('php://input'), true);
    $gClient = new Google_Client();
    $gClient->setAccessToken($token['access_token']);
    $_SESSION['access_token'] = $token['access_token'];
    $google_service = new Google_Service_Oauth2($gClient);
    $data = $google_service->userinfo->get();

if(isset($data)){

    $params = [
        'clientId'=>  $data['id'],
        'name'=>  $data['name'],
        'email'=>  $data['email'],
        'profileImg'=>  $data['picture'],
    ];

    
    if($user->createUser($params))
    {
        echo json_encode(array('message' => 'Login successfully','name'=>$data['name'],'picture'=>$data['picture']));
    }

}
