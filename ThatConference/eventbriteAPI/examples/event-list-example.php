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
$events = $eb_client->user_list_events();

//mark-up the list of events that were requested 
// render in html - ?>
<style type="text/css">
.eb_event_list_item{
  padding-top: 20px;
}
.eb_event_list_title{
  position: absolute;
  left: 220px;
  width: 300px;
  overflow: hidden;
}
.eb_event_list_date{
  padding-left: 20px;
}
.eb_event_list_time{
  position: absolute;
  left: 150px;
}
.eb_event_list_location{
  position: absolute;
  left: 520px;
}
</style>

<h1>My Event List:</h1>
<?= Eventbrite::eventList( $events, 'eventListRow'); ?>
