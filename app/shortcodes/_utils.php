<?php

/**
 * ====================================
 * Shortcode for event date's
 * 
 * ====================================
 */

if (! function_exists('event_date')) {
    function event_date()
    {

        // retrieving values
        $event_end_date = (function_exists('get_field') && $value = get_field('event_end_date')) ? $value : '';
        $event_start_date = (function_exists('get_field') && $value = get_field('event_start_date')) ? $value : '';

        // initialize empty array to hold values
        $date = [];

        // initialize empty output
        $content = '';

        if ($event_start_date) {

            if ($event_end_date) {
                $date[] = DateTime::createFromFormat('M d', $event_start_date);
            } else {
                $date[] = $event_start_date;
            }
        }

        if ($event_end_date) {
            $date[] = $event_end_date;
        }

        $content .= join(' - ', $date);


        return $content;
    }
    add_shortcode('eventDate', 'event_date');
}


/**
 * ====================================
 * Shortcode for event's time
 * ====================================
 */

if (! function_exists('event_time')) {
    function event_time()
    {

        // retrieving values
        $event_time = (function_exists('get_field') && $value = get_field('event_time')) ? $value : '';

        // initialize empty output
        $content = '';

        // initialize empty array to hold values
        $time = [];

        if ($event_time) {

            // Create a DateTime object for the input time in PDT
            $datetimePDT = new DateTime($event_time, new DateTimeZone('America/Los_Angeles'));

            //push value to array
            $time[] = $datetimePDT->format('g:i a T');

            // Convert the time to EDT
            $datetimePDT->setTimezone(new DateTimeZone('America/New_York'));

            //push value to array
            $time[] = $datetimePDT->format('g:i a T');

            // separate values with a dash
            $content .= join(' / ', $time);

        }

        // output of shortcode
        return $content;
    }
    add_shortcode('eventTime', 'event_time');
}