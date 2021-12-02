<?php

use App\Http\Controllers\KafkaController;
use Illuminate\Support\Facades\Route;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('kafka-send',[KafkaController::class, 'handle']);


Route::get('kafka-consumer', function() {

    // $consumer = Kafka::createConsumer(['test-3-1']);
    
    $consumer = Kafka::createConsumer()
        ->withHandler(function(\Junges\Kafka\Contracts\KafkaConsumerMessage $message) {
            print_r($message->getBody());
        })
        ->withConsumerGroupId('group-test')
        ->subscribe('topico-2')
        // ->withMaxMessages(100)
        // ->withMaxCommitRetries(10)
        ->withAutoCommit()
        ->build();
    
        $consumer->consume();
});
