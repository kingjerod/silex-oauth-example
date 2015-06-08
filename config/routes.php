<?php
/**
 * This file assumes $app has been created as a Silex instance
 */

/**
 * Here are the two routes for a Facebook and Google OAuth endpoint
 */
$app->get('/oauth/facebook', "oauth.controller:facebookAction");
$app->get('/oauth/google', "oauth.controller:googleAction");
