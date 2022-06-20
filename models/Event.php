<?php


error_reporting(E_ALL);
ini_set('diplay_error',1);

class Event{

    // event property
    public $eventId;
    public $userId;
    public $eventName;
    public $description;
    public $eventDate;
    public $startTime;
    public $endTime;
    public $location;
    public $category;
    public $bannerPicture;
    public $created_at;

    //db data

    private $connection;
    private $table = 'events';

    public function __construct($db){
        $this->connection = $db;
    }

    //function for read all events

    public function getEvents(){

        $query ='SELECT 
        users.name as users,
        events.eventId,
        events.userId,
        events.eventName,
        events.description,
        events.eventDate,
        events.startTime,
        events.endTime,
        events.location,
        events.category,
        events.bannerPicture,
        events.created_at
        FROM '.$this->table.' events LEFT JOIN 
        users ON events.userId = users.id
        ORDER BY 
        events.created_at ASC
         ';

        $event = $this->connection->prepare($query);
        $event->execute();
        // print_r("event",$event);
        return $event;
    }


    public function createEvent($params){
        try {
            
            $this->userId = $params['userId'];
            $this->eventName = $params['eventName'];
            $this->description = $params['description'];
            $this->eventDate = $params['eventDate'];
            $this->startTime = $params['startTime'];
            $this->endTime = $params['endTime'];
            $this->location = $params['location'];
            $this->category = $params['category'];
            $this->bannerPicture = $params['bannerPicture'];
            $this->created_at = date('Y-m-d H:i:s');

            $query = 'INSERT INTO '.$this->table.' 
                    SET 
                    userId = :userId,
                    eventName = :eventName,
                    eventDate = :eventDate,
                    description = :description,
                    startTime = :startTime,
                    endTime = :endTime,
                    location = :location,
                    category = :category,
                    bannerPicture = :bannerPicture,
                    created_at = :created_at';
                    
            // $query2 = 'INSERT INTO events (eventId, userId, eventName, eventDate,startTime,endTime,category,created_at  ) 
            // VALUES (:eventId, :userId, :eventName, :eventDate,:startTime ,:endTime ,:category ,:created_at)';

            $event = $this->connection->prepare($query);
            $event->bindValue('userId',$this->userId);
            $event->bindValue('eventName',$this->eventName);
            $event->bindValue('description',$this->description);
            $event->bindValue('eventDate',$this->eventDate);
            $event->bindValue('startTime',$this->startTime);
            $event->bindValue('endTime',$this->endTime);
            $event->bindValue('location',$this->location);
            $event->bindValue('category',$this->category);
            $event->bindValue('bannerPicture',$this->bannerPicture);
            $event->bindValue('created_at',$this->created_at);

            if($event->execute())
            {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


}

