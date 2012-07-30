<?php
# Getting Started with OAuth2.0 for Eventbrite in 5 easy steps #
## Requirements and prep-work: ##
// 1. You must have an API key - Eventbrite API keys are available here: http://www.eventbrite.com/api/key/
// 2. Have your Client_Secret ready - Your API_Key's Client secret is available on the same page.  Keep it secret!  Be careful not to expose it to your users or check it in to publicly available source code.
// 3. Update your API_Key's "redirect_uri" setting on http://eventbrite.com/api/key.  Point your redirect_uri to the URL on your site where you expect a user to complete their OAuth2.0 authorization.  Or, point it to any URL on your site where our loginWidget is available.
// 4. Developer terms - To comply with our developer terms, your user's "access_tokens" should be protected, and should not be exposed to other users.
// 5. Download Eventbrite's PHP API client and add it to your application's source code - https://raw.github.com/ryanjarvinen/eventbrite.php/master/Eventbrite.php

## Implementing OAuth for Eventbrite in two easy steps: ##
// 1. load the API Client library:
require_once "../Eventbrite.php"; 

// 1a. (optional) This example uses PHP's built-in $_SESSION storage:
// See the README file for information about integrating with other data-stores.
// This line may be needed to enable session support on your server:
session_start();

// 2. Create a login widget:
?>
<html>
  <?= Eventbrite::loginWidget(array( 'app_key' => 'YOUR_APP_KEY',
                               'client_secret' => 'YOUR_CLIENT_SECRET'));?>

  <?// -------------- Done! ------------- //
    // Optional debug output - Remove this in your app:
    if ( Eventbrite::getAccessToken()){
      print "<p><b>DEBUG:</b> This user's OAuth2.0 access_token is: " . Eventbrite::getAccessToken() . "</p>";
    } 
  ?>
</html>
