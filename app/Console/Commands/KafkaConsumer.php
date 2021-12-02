<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;

class KafkaConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consumer';

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
        $consumer = Kafka::createConsumer()
            ->withHandler(function(\Junges\Kafka\Contracts\KafkaConsumerMessage $message) {
                // Handle your message here
                // echo 'Recebi essa bosta de mensagem kkkkk'; echo '<br>';
                // print_r($message->getBody());
                // exit;
                var_dump($message->getBody());
            })
            ->withConsumerGroupId('group-test')
            ->subscribe('topico-2')
            // ->withMaxMessages(100)
            // ->withMaxCommitRetries(10)
            ->withAutoCommit()
            ->build();
        // dd($consumer);
    
        $consumer->consume();
        // dd($consumer);
    }
}
