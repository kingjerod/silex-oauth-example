# silex-oauth-example

An example of implementing OAuth2 with the Silex PHP micro-framework. 

Uses the [thephpleague/oauth2-client](https://github.com/thephpleague/oauth2-client) with [Silex](http://silex.sensiolabs.org/) to create an app that can authenticate users via Google or Facebook OAuth2. It uses the code example seen on the oauth2-client Github page, but is altered to use the features of sessions and the request object from Silex. This example does not work out of the box, you must provide the OAuth 2 configuration from whatever service you're trying to use.

### File breakdown:

+ public/index.php - This is the public PHP file that all requests are routed to. It includes the bootstrap.php file that is outside the doc root.
+ bootstrap.php - Creates the Silex app, includes the config files for services and routes, and then starts the app.
+ config/services.php - Defines the services and controllers, register the Session and Controller providers that Silex uses.
+ config/routes.php - Defines the two route endpoints for Facebook and Google OAuth. These are the routes your "Sign in with Google" buttons would link to.
+ src/OAuthController.php - This is the class that does all the heavy lifting. The two public methods for Facebook and Google are the ones called in the routes.php file. The controller is hooked into the app inside the services.php file.
