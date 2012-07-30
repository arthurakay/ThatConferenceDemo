<?php
// load the API Client library
include "Eventbrite.php";

$app_key = 'ZJAGJQ3M3QZ65VOSVY';
$user_key = '129771021911177517255';
$event_id = 'http://thatconference2012.eventbrite.com';

// Initialize the API client
//  Eventbrite API / Application key (REQUIRED)
//   http://www.eventbrite.com/api/key/
//  Eventbrite user_key (OPTIONAL, only needed for reading/writing private user data)
//   http://www.eventbrite.com/userkeyapi
$authentication_tokens = array('app_key'  => $app_key,
                               'user_key' => $user_key);
$eb_client = new Eventbrite( $authentication_tokens );

try{
// For more information about the functions that are available through the Eventbrite API, see http://developer.eventbrite.com/doc/
    $attendees = $eb_client->event_list_attendees( array('id'=>$event_id) );
} catch ( Exception $e ) {
    // Be sure to plan for potential error cases
    // so that your application can respond appropriately

    //var_dump($e);
    $attendees = array();
}

echo(json_encode($attendees));

?>
