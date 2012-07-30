<?php
// load the API Client library
include "../Eventbrite.php"; 

// Initialize the API client
//  Eventbrite API / Application key (REQUIRED)
//   http://www.eventbrite.com/api/key/
//  Eventbrite user_key (OPTIONAL, only needed for reading/writing private user data)
//   http://www.eventbrite.com/userkeyapi
$authentication_tokens = array('app_key'  => 'YOUR_APP_KEY',
                               'user_key' => 'YOUR_USER_KEY');
$eb_client = new Eventbrite( $authentication_tokens );

// For more information about the features that are available through the Eventbrite API, see http://developer.eventbrite.com/doc/

// event_get example - http://developer.eventbrite.com/doc/events/event_get/
$resp = $eb_client->event_get( array('id'=>'1848891083') );
print( Eventbrite::ticketWidget($resp->event) );

// event_search example - http://developer.eventbrite.com/doc/events/event_search/
$search_params = array(
  'max' => 2,
  'city' => 'San Francisco',
  'region' => 'CA',
  'country' => 'US'
);
$resp = $eb_client->event_search($search_params);

// user_list_events example
$user_resp = $eb_client->user_list_events();

//mark-up the list of events that were requested 
// render in html - ?>

<h1>Search Results:</h1>
<?= Eventbrite::eventList( $resp, 'eventListRow'); ?>

<br/> <hr/> <br/>

<h1>Ticket Widgets:</h1>
<?= Eventbrite::eventList( $resp, 'ticketWidget');?>

<br/> <hr/> <br/>

<h1>My Event List:</h1>
<?= Eventbrite::eventList( $user_resp, 'buttonWidget' ) ;?> 
