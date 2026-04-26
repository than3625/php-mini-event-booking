<?php

namespace App\Controllers;
use App\Support\Response;

class RegistrationController
{
    public function store(array $events, array $config):void
    {
        $headers = function_exists('getallheaders')?getallheaders():[];
        $contentType=$headers['Content-Type']??$headers['content-type']??($_SERVER['CONTENT_TYPE']??'');

        if(!str_contains(strtolower($contentType), 'application/json')){
            Response::json(415, ['error'=>'Unsupported Media Type', 'message'=>'Content-type must be application/json']);
        }
        
        $raw = file_get_contents('php://input');
        $payload=json_decode($raw, true);

        if (!is_array($payload)){
            Response::json(400,['error'=>'Bad Request', 'message'=>'Invalid JSON body']);
        }

        $eventId = $payload['event_id']?? null;
        $registerName = trim($payload['register_name']??'');
        $email = trim($payload['email']??'');
        $phoneNumber= trim($payload['phone_number']??'');
        $quantity = (int) ($payload['quantity']??0);

        if(!$eventId||$registerName===''||$email===''||$phoneNumber===''||$quantity<=0){
            Response::json(422,['error'=>'Unprocessable Content','message'=>'event_id, register_name, email, phone_number, quantity are required and must be valid']);
        }
        if(strlen($phoneNumber)!=10||!is_numeric($phoneNumber)){
            Response::json(422,['error'=>'Unprocessable Content','message'=>'Phone number must be exactly 10 digits and numeric']);
        }

        if($quantity>$config['app']['max_registrations_per_request']){
            Response::json(422,['error'=>'Unprocessable Content','message'=>'Quantity exceeds allowed registration limit per request']);
        }

        $selectedEvent=null;
        foreach($events as $event){
            if($event['id']===(int) $eventId){
                $selectedEvent=$event;
                break;
            }
        }

        if(!$selectedEvent){
            Response::json(422,['error'=>'Unprocessable Content','message'=>'Selected event does not exist']);
        }

        if($selectedEvent['available']<$quantity){
            Response::json(422,['error'=>'Unprocessable Content','message'=>'Not enough seats available']);
        }

        $registrationId = time();

        Response::json(201,[
            'message'=>'Registration created successfully',
            'data'=>[
                'registration_id'=>$registrationId,
                'register_name'=>$registerName,
                'email'=>$email,
                'phone_number'=>$phoneNumber,
                'event_id'=>$eventId,
                'quantity'=>$quantity
            ]
        ],
        [
            'Location'=>'/registrations/'.$registrationId
        ]);
    }

    public function options():void{
        http_response_code(204);
        header('Allow: POST, OPTIONS');
        exit;
    }
}