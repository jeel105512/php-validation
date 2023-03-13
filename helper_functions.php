<?php

    // sanitize a date YYYY-MM-DD
    function sanitize_date($date){
        $date = strtotime($date); // returns number of seconds that have passed since January 1st 1970 till not
        
        if(!$date) return null;

        return date("Y-m-d", $date); // formatting the date into YYYY-MM-DD formate if the strtotime($date) returns true
    }

    // sanitize time HH-MM (not required in this particular example/code)
    function sanitize_time($time){
        $time = strtotime($time);

        if(!$time) return null;

        return date("H:i", $time);
    }

    // sanitize name (eg. Bob Doe)
    function sanitize_name($name) {
        // Remove any HTML and PHP tags from the name input
        $name = strip_tags($name);
    
        // Remove any non-letter characters from the name input
        $name = preg_replace('/[^a-zA-Z]/', '', $name);
    
        // Capitalize the first letter of each word in the name input
        $name = ucwords(strtolower($name));
    
        // Return the sanitized name
        return $name;
    }

    // validate date
    function validate_date ($date) {
        return filter_var($date, FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^\d{4}-\d{2}-\d{2}$/"
                // "regexp" => "/^\d{4}-(0?[1-9]|1[0-2])-(0?[1-9]|[12]\d|3[01])$/"
            ]
        ]);
    }
    
    // validate time (not required in this particular example/code)
    function validate_time ($time) {
        return filter_var($time, FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^\d{2}:\d{2}$/"
                // "regexp" => "/^(0?\d|1\d|2[0-3]):([0-5]\d):([0-5]\d)$/"
            ]
        ]);
    }

    // validate name (at least 2 characters and no numbers)
    function validate_name($name){
        return filter_var($name, FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^(?!\d)(.{2,})$/"
            ]
        ]);
    }
    // or
    // function validate_name($name) {
    //     // Ensure the name input is between 2 and 50 characters long
    //     if (strlen($name) < 2 || strlen($name) > 50) {
    //         return false;
    //     }
    //     return true;
    // }

?>