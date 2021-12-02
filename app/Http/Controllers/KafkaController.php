<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class KafkaController extends Controller
{
    public function handle()
    {
        $message = new Message(
            headers: ['header-key' => 'header-value'],
            body: [
                'corpo da mensagem' => 'Mensagem desde o laravel'
            ],
            key: 'kafka key here'
        );
        
        try {
            $kafka = Kafka::publishOn(topic:'topico-2')
                ->withMessage($message);
    
            $kafka->send();
            echo 'Message has been published!'; echo '<br>';
            print_r($message->getBody());
    
        } catch(Exception $e) {
            dd($e);
        }
    }
}
