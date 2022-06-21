<?php
session_start();


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
include_once("../../models/Event.php");

// connct with db

$database = new Database;
$db = $database->connect();

$event = new Event($db);
$data = json_decode(file_get_contents("php://input"));

if(count($_POST)){
    
    $params = [
        'userEmail'=> "555",
        'eventName'=> $_POST['eventName'],
        'description'=> $_POST['description'],
        'eventDate'=> $_POST['eventDate'],
        'startTime'=> $_POST['startTime'],
        'endTime'=> $_POST['endTime'],
        'location'=> $_POST['location'],
        'category'=> $_POST['category'],
        'bannerPicture'=> $_POST['image'],
    ];

    print_r($_POST);

    if($event->createEvent($params)){
        echo json_encode(['message'=>"Event added successfully"]);
    }
} 
else if(isset($data)){

    $params = [
        'userEmail'=>  "ankitpatelas90@gmail.com",
        'eventName'=>  $data->eventName,
        'description'=>  $data->description,
        'eventDate'=>  $data->eventDate,
        'startTime'=>  $data->startTime,
        'endTime'=>  $data->endTime,
        'location'=>  $data->location,
        'category'=>  $data->category,
        'bannerPicture'=>  $data->image,
    ];

    
    if($event->createEvent($params))
    {
        echo json_encode(array('message' => 'Events created'));
    }
}


