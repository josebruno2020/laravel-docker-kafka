<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;

class QueueController extends Controller
{
    public function handleEvent() 
    {
        TestJob::dispatch();
    }
}
