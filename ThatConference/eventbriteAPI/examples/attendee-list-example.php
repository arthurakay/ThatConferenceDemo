<?php
// load the API Client library
include "../Eventbrite.php"; 

$app_key = 'ZJAGJQ3M3QZ65VOSVY';
$user_key = '129771021911177517255';
$event_id = 'http://thatconference2012.eventbrite.com/';

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

function attendee_to_html( $attendee ){
    if($attendee->first_name){ 
        return "<div class='eb_attendee_list_item'>".$attendee->first_name.' '.$attendee->last_name."</div>\n";
    }else{
        return '';
    }
}

function sort_attendees_by_created_date( $x, $y ){
    if($x->attendee->created == $y->attendee->created ){
        return 0;
    }
    return ( $x->attendee->created > $y->attendee->created ) ? -1 : 1;
}

function attendee_list_to_html( $attendees ){
    $attendee_list_html = "<div class='eb_attendee_list'>\n";
    if( isset($attendees->attendees) ){ 
        //sort the attendee list?
        usort( $attendees->attendees, "sort_attendees_by_created_date");
        //render the attendee as HTML
        foreach( $attendees->attendees as $attendee ){
            $attendee_list_html .= attendee_to_html( $attendee->attendee );
        }
    }else{
        $attendee_list_html .= '<div class="eb_attendee_list_item">You can be the first to register for this event!</div>';
    }   
    return $attendee_list_html . "</div>\n";
}

//mark-up your attendee list
// render in html - ?>
<style type="text/css">
.eb_attendee_list_item{
  padding-bottom: 8px;
}
.eb_attendee_list{
  margin-left: 20px;
}
</style>

<h1>Event Attendee List:</h1>
<?= attendee_list_to_html( $attendees ); ?>
