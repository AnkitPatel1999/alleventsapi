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
include_once("../../models/Event.php");

// connct with db

$database = new Database;
$db = $database->connect();

$event = new Event($db);

$data = $event->getEvents();

// if events in db

if($data->rowCount()) 
{
    $events = [];

    while($row = $data->fetch(PDO::FETCH_OBJ)) {

        $events[]=[
           'eventId' => $row->eventId,
           'userId' => $row->userId,
           'eventName' => $row->eventName,
           'description' => $row->description,
           'eventDate' => $row->eventDate,
           'startTime' => $row->startTime,
           'endTime' => $row->endTime,
           'location' => $row->location,
           'category' => $row->category,
           'bannerPicture' => $row->bannerPicture,
           'created_at' => $row->created_at
        ];

    }
    echo json_encode($events,JSON_INVALID_UTF8_IGNORE);



} else {
    echo json_encode(['message'=>'no events founds']);
}