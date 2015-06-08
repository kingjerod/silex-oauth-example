<?php
namespace kingjerod\Example;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class OAuthController
{
    /**
     * @param Request $request
     * @param Application $app
     * @return The json response of user details upon success, a redirect to obtain authorization, or failure
     */
    public function googleAction(Request $request, Application $app)
    {
        $provider = $app['oauth.google'];
        return $this->handleOAuth($provider, $request, $app);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return The json response of user details upon success, a redirect to obtain authorization, or failure
     */
    public function facebookAction(Request $request, Application $app)
    {
        $provider = $app['oauth.facebook'];
        return $this->handleOAuth($provider, $request, $app);
    }

    private function handleOAuth($provider, Request $request, Application $app)
    {
        $code = $request->get('code');
        $state = $request->get('state');

        if (empty($code)) {
            // If we don't have an authorization code then get one by redirecting to the provider's URL
            $authUrl = $provider->getAuthorizationUrl();
            $app['session']->set('oauth2state', $provider->state);
            return $app->redirect($authUrl);
        } elseif (empty($state) || ($state !== $app['session']->get('oauth2state'))) {
            // Check given state against previously stored one to mitigate CSRF attack
            $app['session']->set('oauth2state', null);
            $app->abort(402, 'Bad!');
        } else {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', ['code' => $code]);

            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the user's details
                $userDetails = $provider->getUserDetails($token);
            } catch (Exception $e) {
                // Failed to get user details
                $app->abort(402, 'Failed: ' . $e->getMessage());
            }

            // Success, do what you want with it here, register them into the database
            return $app->json([
                'email' => $userDetails->email,
                'firstName' => $userDetails->firstName,
                'lastName' => $userDetails->lastName,
                'accessToken' => $token->accessToken,
                'refreshToken' => $token->refreshToken,
                'expires' => $token->expires
            ]);
        }
    }
}
