<?php
/**
 * This file assumes $app has been created as a Silex instance
*/

/**
 * This allows us to register controllers for endpoints
 */
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

/**
 * This registers the session provider so we can prevent CSRF attacks on our OAuth endpoint
 */
$app->register(new Silex\Provider\SessionServiceProvider());

/**
 * OAuth2 for Google
 */
$app['oauth.google'] = $app->share(function() {
    return new League\OAuth2\Client\Provider\Google([
        'clientId'      => 'clientIdGoesHere',
        'clientSecret'  => 'clientSecretGoesHere',
        'redirectUri'   => 'http://www.yourDomain.com/oauth/google',
        'scopes'        => ['email'],
    ]);
});

/**
 * OAuth2 for Facebook
 */
$app['oauth.facebook'] = $app->share(function() {
    return new League\OAuth2\Client\Provider\Facebook([
        'clientId'      => 'clientIdGoesHere',
        'clientSecret'  => 'clientSecretGoesHere',
        'redirectUri'   => 'http://www.yourDomain.com/oauth/facebook',
        'scopes'        => ['email'],
    ]);
});

/**
 * OAuth Controller
 */
$app['oauth.controller'] = $app->share(function() {
    return new kingjerod\Example\OAuthController();
});

