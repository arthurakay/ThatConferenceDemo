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

//The event_id that you would like to copy and update:
$draft_event_id = 'YOUR_DRAFT_EVENT_ID';

//see http://developer.eventbrite.com/doc/events/event_update/ for a
// description of the available event_update parameters:
$event_update_params = array(
    'title' => 'NEW EVENT TITLE', // leave this out if you want to keep the same title
    'start_date' => date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60)), // "YYYY-MM-DD HH:MM:SS"
    'end_date' => date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60) + (2 * 60 * 60) ), // "YYYY-MM-DD HH:MM:SS"
    'privacy' => 1  // zero for private (not available in search), 1 for public (available in search)
);

// initialize the API client
$eb_client = new Eventbrite(array('app_key'  => $api_key,
                                  'user_key' => $user_key));

//Copy and Update your saved "Draft" event.  
//Keep the original around for additional copying in the future.
try{
    // For more information about the API calls that are available
    // on Eventbrite API clients, see http://developer.eventbrite.com/doc/
    $new_event = $eb_client->event_copy(array('event_id'=> $draft_event_id))->event;
    $new_event_params['event_id'] = $new_event['id'];
    $response = $eb_client->event_update($event_update_params)->event;
}catch( Exception $e ){
    // application-specific error handling goes here:
    $response = $e->error;
}
print var_dump($response);
?>
