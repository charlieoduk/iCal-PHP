<?php

namespace App\Clients;

use Twilio\Rest\Client as TwilioClient;
use App\Models\TechEvents;
use Carbon\Carbon;

class EventReminderClient
{
    /**
     * Create a new instance
     * 
     * @return void
     */
    public function __construct()
    {
        $twilioAccountSid   = getenv("TWILIO_SID");
        $twilioAuthToken    = getenv("TWILIO_TOKEN");

        $this->twilioClient = new TwilioClient($twilioAccountSid, $twilioAuthToken);
    }

    /**
     * Get's events that have subscribers and are due
     * in 2 days, then sends reminders.
     * 
     * @return string 
     */
    public function sendEventReminders()
    {
        $events = TechEvents::has('subscribers')->get();

        $eventsInTwoDays = $this->getEventsDueInTwoDays($events);
        if (empty($eventsInTwoDays)) {
            return "There are no events due in two days";
        }

        $subscribers = $this->getSubscribersInformation($eventsInTwoDays);

        return $this->sendTwilioSmsReminders($subscribers);
    }

    /**
     * Get events that are due in two days
     * 
     * @param object $events    - Events that have subscribers
     * 
     * @return array $eventsDue - Events due in 2 days
     */
    private function getEventsDueInTwoDays($events)
    {
        $today = Carbon::now()->toDateTimeString();

        $eventsDue = [];
    
        foreach ($events as $event) {
            $daysToEvent = round((strtotime($event->starts) - strtotime($today)) / 86400, 0);

            if ($daysToEvent === 2.0 ) {
                array_push($eventsDue, $event);
            }
        }

        return $eventsDue;
    }
    
    /**
     * Get the subscriber information and corresponding event name
     * 
     * @param  array $events      - Array of events due in 2 days
     * 
     * @return array $subscribers - Array of subscribers info and event name
     *
     */
    private function getSubscribersInformation($events)
    {
        $subscribers = [];

        foreach ($events as $event) {
            foreach ($event->subscribers as $subscriber) {
                $subscribers[] = [
                    $subscriber->phone_number,
                    $subscriber->first_name,
                    $event->name
                ];
            }
        }

        return $subscribers;

    }
    
    /**
     * Send messages using Twilio API client
     * 
     * @param array $subscribers - Subscribers info
     * 
     * @return void
     */
    public function sendTwilioSmsReminders($subscribers)
    {
        $myTwilioNumber = getenv("TWILIO_NUMBER");
        foreach( $subscribers as $subscriber) {
            $this->twilioClient->messages->create(
                // Where to send a text message
                $subscriber[0],
                array(
                    "from" => $myTwilioNumber,
                    "body" => "Hey! ". $subscriber[1] . ", the ".$subscriber[2] ." Tech event begins in 2 days!"
                )
            );
        }
        return "Successfully sent ". count($subscribers) . " reminder(s)";
    }
}
