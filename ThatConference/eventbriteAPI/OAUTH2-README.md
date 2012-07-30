# PHP Eventbrite API Client Library - OAuth2.0 examples  
---------------------------------------------------------
## Requirements: ##
### API key ###
Eventbrite API keys are available here: http://www.eventbrite.com/api/key/
### Client Secret ###
Your API_Key's Client secret is available on the same page.  Keep it secret.  Be careful not to expose it to your users or check it in to publicly available source code.
### Configure your key's redirect_uri ###
You must set your API_key's redirect_uri on http://www.eventbrite.com/api/key/, pointing it to the URL on your site where you expect a user to complete their OAuth2 authorization.  Or, point it to any URL on your site where our loginWidget is available.

## Simple implementation example: ##
Get OAuth2.0 done in three easy steps.  Check below for a more advanced implementation example that shows how to integrate with your existing storage and templating systems.

### 1. Download and install Eventbrite's PHP API client ###
Grab Eventbrite's latest PHP API client and add it to your app's source code: https://raw.github.com/ryanjarvinen/eventbrite.php/master/Eventbrite.php

### 2. Load the API Client library ###

    require_once 'Eventbrite.php';

### 2a. Using PHP's built-in $_SESSION storage (optional):  ###
See our advanced implementation example for notes on how to use other data-stores.
If you do not already have support for session storage enabled, then you may need to turn it on:

    session_start();

### 3. Generate the Eventbrite LoginWidget HTML ###
Add your authentication tokens to make this widget example work:

    <?= Eventbrite::loginWidget(array('app_key'=>'YOUR_API_KEY', 
                                'client_secret'=>'YOUR_CLIENT_SECRET')); ?>

A simple OAuth2 example script is also bundled with our API Client library:
https://github.com/ryanjarvinen/eventbrite.php/blob/master/examples/oauth2-login-example.php

## Advanced implementation example: ##
Interested in integrating with your application's existing authentication, storage, and templating systems?  This example goes into additional detail, demonstrating how to set that up.

### 1. Download and install Eventbrite's PHP API client ###
Grab Eventbrite's latest PHP API client and add it to your app's source code: https://raw.github.com/ryanjarvinen/eventbrite.php/master/Eventbrite.php

### 2. Load the API Client library ###

    require_once 'Eventbrite.php';

### 3. Define data management callbacks ###
If you do not already have support for session storage enabled, then you may need to turn it on:

    session_start();

Define a callback for looking up access_tokens:

    $get_access_token = function(){
        if(isset($_SESSION['EB_OAUTH_ACCESS_TOKEN'])){
            return $_SESSION['EB_OAUTH_ACCESS_TOKEN'];
        }else{
            return null;
        }   
    }

Define a callback for saving access_tokens for later:

    $save_access_token = function( $access_token ){
        $_SESSION['EB_OAUTH_ACCESS_TOKEN'] = $access_token;
    }

Define a callback for removing access_tokens when needed:

    $delete_access_token = function( $access_token=null ){
        unset($_SESSION['EB_OAUTH_ACCESS_TOKEN']);
    }

### 4. Integrate with your existing authentication logout url (optional) ###
Add the following to your logout() code to clear the existing access_token:

    Eventbrite::deleteAccessToken();

Or, use your own $delete_access_token callback when appropriate:

    $delete_access_token();

### 5. Generate the Eventbrite LoginWidget strings ###
Add your authentication tokens and logout url to make this example work:

    $strings = Eventbrite::loginWidget(array('app_key'=>'YOUR_API_KEY', 
                                             'client_secret'=>'YOUR_CLIENT_SECRET',
                                             'logout_link'=>'YOUR_LOGOUT_URL' ),
                                       $get_access_token,
                                       $save_access_token,
                                       $delete_access_token,
                                       "disabled"); // leave this parameter out for an HTML response.

### 6. Render your template or view: ###
If you would like to use the HTML template from our example, you can remove the "disabled" flag from the loginWidget call, or pass the resulting strings to our `Eventbrite::widgetHTML()` function, like this:

    $widget_html = Eventbrite::widgetHTML($strings);

You can also supply your own templating callback function to `Eventbrite::loginWidget`, or simply pass the returned strings directly into your own templating system.

For more detail on our available OAuth2.0 integration functions - see the docs below, or [reach out to the Eventbrite team with questions](http://developer.eventbrite.com/contact-us/)

## API Client methods for working with OAuth2.0 ##
See Eventbrite's [API Docs](http://developer.eventbrite.com/doc) for more information about available API Client methods.

### Eventbrite::loginWidget() ###
The loginWidget method is the quickest way to acheive OAuth2.0 integration for Eventbrite. It includes a lot of great defaults, and the ability to customize when needed.  By default, PHP's $_SESSION store will be used to save your user's access_token.

#### Function overview: ####
> string <b>Eventbrite::loginWidget</b>( array $options [, callback $get_token, callback $save_token, callback $delete_token, callback $renderer ] )

#### Parameters: ####
* `options` - (Required) An array containing the following:
    * `app_key` - (Required) A string containing your API key - sign up here: http://www.eventbrite.com/api/key/
    * `client_secret` - (Required) A string containing this API key's client_secret (available on the same page as your API Key)
    * `access_code` - (Optional) A string containing the user's access_code. An OAuth2.0 access_code is an intermediary, temporary token that can be exchanged for an access_token.  If you know the access_code, you can supply it here.  By default, this widget will attempt to autodetect this information by checking the REQUEST for a "code" parameter. This should work fine as long as the widget is available at the same URL that your "redirect_uri" is pointed toward.
    * `logout_link` - (Optional) A string containing the URL that should trigger a "logout" or "deleteToken" action.  By default, the widget is configured to delete a user's access_token whenever the querystring contains "eb_logout=true".  This should work on any page where the widget is available.  See our "Advanced implementation" example for information on how to incorporate this into your existing authentication scheme.
    * `error_message` - (Optional) A string containing an OAuth2.0 error response from Eventbrite.  By default, the widget is configured to auto-detect this information by reading from $_REQUEST['error'].  If you wish to disable error_message auto-detection, set this value to "disabled".
* `get_token` - (Optional) A callback describing how to retrieve the current user's OAuth2.0 access_token from your site's data store.
* `save_token` - (Optional) A callback describing how to save the current user's OAuth2.0 access_token in your site's data store.
* `delete_token` - (Optional) A callback describing how to remove the current user's OAuth2.0 access_token from your site's data store.
* `renderer` - (Optional) A callback describing how to render the widget data as HTML.  If you have your own templating system that you would like to work with, you can pass the resulting HTML into your template as a string, or set this value to "disabled" to signal that you would like the response to include an array of strings instead of HTML.  For more information on how to write your own render callback, see the widgetHTML function below.  By default, the widgetHTML function will be used to generate HTML for you.

#### Response: ####
By default, this function returns the widget's HTML as a string. If you have set the "renderer" parameter to "disabled" then an array of strings will be returned instead.  See the input parameters for `Eventbrite::widgetHTML` for more information about this alternate response value.

### Eventbrite::widgetHTML() ###
This is the default function for rendering your OAuth2-related strings in HTML.  If you do not like the default HTML, you are welcome to implement your own renderer function based on this method signiture.  See the `renderer` parameter on `Eventbrite::loginWidget` for more information.

#### Function overview: ####
> string <b>Eventbrite::widgetHTML</b>( array $strings )

#### Parameters: ####
* `strings` - (Required) An array of strings to render:
    * `oauth_link` - (Required) A URL for kicking off the OAuth2.0 workflow. See `Eventbrite::oauthNextStep($api_key)` for more information about this value.
    * `logout_link` - (Required) A URL for deactivating the current user's access_token.
    * `user_name` - (Optional) A string indicating the current user's name.
    * `user_email` - (Optional) A string indicating the current user's email address.
    * `login_error` - (Optional) A string containing an OAuth2.0 error message.

#### Response: ####
This function returns the widget's HTML as a string.

### Eventbrite::OAuthLogin() ###
This function handles all of the logic around access_token retrieval, and it carries out related data-management tasks by taking advantage of the available callback functions.  If you want to use your own routing, storage, and templating tools, then this lower-level function is an alternative to our `loginWidget`.  It makes less assumptions about your system configuration.

#### Function overview: ####
> array <b>Eventbrite::OAuthLogin</b>( array $options, [, callback $get_token, callba    ck $save_token, callback $delete_token ]) 

#### Parameters: ####
* `options` - (Required) An array containing the following:
    * `app_key` - (Required) A string containing your API key - sign up here: http://www.eventbrite.com/api/key/
    * `client_secret` - (Required) A string containing this API key's client_secret (available on the same page as your API Key)
    * `access_token` - (Optional) A string containing the user's access_token can be supplied here.  We will attempt to automatically store this token for later use, by taking advantage of the supplied `save_token` callback.
    * `access_code` - (Optional) A string containing the user's access_code. An OAuth2.0 access_code is an intermediary, temporary token that can be exchanged for an access_token.  If you know the access_code, you can supply it here.
    * `error_message` - (Optional) A string containing an OAuth2.0-related error message.
* `get_token` - (Optional) A callback describing how to retrieve the current user's OAuth2.0 access_token from your site's data store.
* `save_token` - (Optional) A callback describing how to save the current user's OAuth2.0 access_token in your site's data store.
* `delete_token` - (Optional) A callback describing how to remove the current user's OAuth2.0 access_token from your site's data store.

#### Response: ####
This function returns an array of strings containing the following values:

* `access_token` - if available, this string will contain the current user's access_token
* `user_name` - if available, this string will contain the current user's name
* `user_email` - if available, this string will contain the current user's email address.
* `login_error` - if available, this string will contain a login_error from the API.

# Resources: #
* <a href="http://eventbrite.github.com/">Eventbrite on GitHub</a>
* <a href="http://developer.eventbrite.com/doc/">API Documentation</a>
* <a href="http://developer.eventbrite.com/doc/getting-started/">API Getting-Started Guide</a>
* <a href="http://developer.eventbrite.com/terms/">Eventbrite API terms and usage limitations</a>
* <a href="http://developer.eventbrite.com/news/branding/">Eventbrite Branding Guidelines</a>
