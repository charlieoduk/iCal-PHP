<?php

namespace App\Http\Controllers;
use App\TechEvents;

class ICalController extends Controller
{
    
    /**
     * Gets the events data from the database
     * and populates the iCal object.
     * 
     * @return void
     */
    public function getEventsICalObject()
    {
        $events = TechEvents::all();
        define('ICAL_FORMAT', 'Ymd\THis\Z');

        $icalObject = "BEGIN:VCALENDAR
        VERSION:2.0
        METHOD:PUBLISH
        PRODID:-//Charles Oduk//Tech Events//EN\n";
        
        // loop over events
        foreach ($events as $event) {
            $icalObject .=
            "BEGIN:VEVENT
            DTSTART:" . date(ICAL_FORMAT, strtotime($event->starts)) . "
            DTEND:" . date(ICAL_FORMAT, strtotime($event->ends)) . "
            DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
            SUMMARY:$event->summary
            UID:$event->uid
            STATUS:" . strtoupper($event->status) . "
            LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
            LOCATION:$event->location
            END:VEVENT\n";
        }

        // close calendar
        $icalObject .= "END:VCALENDAR";

        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');
        
        $icalObject = str_replace(' ', '', $icalObject);
    
        echo $icalObject;
    }
}
