<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

use function example\read;

class KafkaProducer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:producer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = new Message(
            headers: ['header-key' => 'header-value'],
            body: ['message' => 'Hola, esta eh uma mensagem'],
            key: 'kafka key here'
        );

        $kafka = Kafka::publishOn(topic:'test-3-1')
            ->withMessage($message)
            ->send();

        
    }
}
