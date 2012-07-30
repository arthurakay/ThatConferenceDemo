<?php
// load the API Client library
include "../Eventbrite.php"; 

// Initialize the API client
//  Eventbrite API / Application key (REQUIRED)
//   http://www.eventbrite.com/api/key/
$api_key = 'YOUR_API_KEY';
//  Eventbrite user_key (OPTIONAL, only needed for reading/writing private user data)
//   http://www.eventbrite.com/userkeyapi
$user_key = 'YOUR_USER_KEY';

//see http://developer.eventbrite.com/doc/events/event_update/ for a
// description of the available event_update parameters:
$event_new_params = array(
    'title' => 'NEW EVENT TITLE',
    'start_date' => date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60)), // "YYYY-MM-DD HH:MM:SS"
    'end_date' => date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60) + (2 * 60 * 60) ), // "YYYY-MM-DD HH:MM:SS"
    'privacy' => 1,  // zero for private (not available in search), 1 for public (available in search)
    'timezone' => 'GMT-8'
);

// initialize the API client
$eb_client = new Eventbrite(array('app_key'  => $api_key,
                                  'user_key' => $user_key));

// Create your event:
try{
    // For more information about the API calls that are available
    // on Eventbrite API clients, see http://developer.eventbrite.com/doc/
    $response = $eb_client->event_new($event_new_params)->event;
}catch( Exception $e ){
    // application-specific error handling goes here:
    $response = $e->error;
}
print var_dump($response);
?>
