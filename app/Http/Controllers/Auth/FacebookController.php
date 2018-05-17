<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Library\Service\Facebook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\LoginHistory;

/**
 * Class FacebookController
 * @package App\Http\Controllers\Auth
 */
class FacebookController extends Controller
{
    use AuthenticatesUsers;

    private $_secret;

    /**
     * @var \Illuminate\Routing\UrlGenerator
     */
    protected $_urlGenerator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UrlGenerator $urlGenerator)
    {
        if (!session_id()) {
            session_start();
        }

        $this->_urlGenerator = $urlGenerator;

        $this->middleware('guest')->except('logout');
    }

    /**
     * @param \App\Library\Service\Facebook $facebookService
     * @return mixed
     */
    public function redirectToFacebook(Facebook $facebookService)
    {
        try {
            $facebookClient = $facebookService->getFacebookClient();

            $permissions = ['email', 'user_birthday'];
            $callbackURL = $this->_urlGenerator->to('/auth/facebook/callback');

            $helper   = $facebookClient->getRedirectLoginHelper();
            $loginUrl = $helper->getLoginUrl($callbackURL, $permissions);
        } catch (\Exception $exception) {
            Log::error($exception);
            return Redirect::to('/home');
        }

        return Redirect::to($loginUrl);
    }

    /**
     * @param \App\Library\Service\Facebook $facebookService
     * @return \Illuminate\Http\Response
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function facebookCallback(Facebook $facebookService)
    {
        $result = Redirect::to('/how-old-am-i-on-mars');

        $facebookClient    = $facebookService->getFacebookClient();
        $accessTokenResult = $facebookService->getFacebookAccessToken();

        if (is_array($accessTokenResult) === true) {
            $result = response()->view('auth.error',
                ['error' => $accessTokenResult['error']],
                $accessTokenResult['code']);

            return $result;
        }

        try {
            /** @var \Facebook\FacebookResponse $response */
            $response = $facebookClient->get('/me?fields=id,name,email,birthday', $accessTokenResult);
        } catch (\Facebook\Exceptions\FacebookSDKException $exception) {
            $result = response()->view('auth.error',
                ['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST);

            return $result;
        }
        /** @var \Facebook\GraphNodes\GraphUser $facebookUser */
        $facebookUser = $response->getGraphUser();

        $authUser = $this->findOrCreateUser(
            $facebookUser->getId(),
            $facebookUser->getName(),
            $facebookUser->getEmail(),
            $facebookUser->getBirthday(),
            (string)$accessTokenResult
        );

        Auth::login($authUser, true);
        $this->createLoginHistory($authUser->id);

        return $result;
    }

    /**
     * Create a login history
     *
     * @param int $userId
     */
    private function createLoginHistory($userId)
    {
        LoginHistory::create([
            'user_id'  => $userId
        ]);
    }

    /**
     * Get or create an user
     *
     * @param string $userFacebookId
     * @param string $userName
     * @param string $userEmail
     * @param string $userBirthday
     * @param string $accessToken
     * @return \App\User
     */
    public function findOrCreateUser($userFacebookId, $userName, $userEmail, $userBirthday, $accessToken)
    {
        $authUser = User::where('facebook_id', $userFacebookId)->first();
        if ($authUser) {
            return $authUser;
        }

        Log::debug("Access token from Facebook: [" . $accessToken . "]");

        return User::create([
            'name'              => $userName,
            'email'             => $userEmail,
            'password'          => Hash::make($userFacebookId . $this->getPasswordSecret()),
            'facebook_id'       => $userFacebookId,
            'facebook_token'    => $accessToken,
            'facebook_birthday' => $userBirthday
        ]);
    }

    /**
     * Get a secret for a password
     *
     * @return string
     */
    private function getPasswordSecret()
    {
        if (empty($this->_secret) === true) {
            $this->_secret = env('USER_PASSWORD_SECRET');
        }

        return $this->_secret;
    }
}
