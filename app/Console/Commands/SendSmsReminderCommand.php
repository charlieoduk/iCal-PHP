<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Clients\EventReminderClient;

class SendSmsReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "send:sms-reminder";
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This will send a reminder 2 days before the event";

    protected $eventReminderClient;

 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EventReminderClient $eventReminderClient)
    {
        parent::__construct();
        $this->eventReminderClient = $eventReminderClient;

    }
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->eventReminderClient->sendEventReminders());
    }
}
