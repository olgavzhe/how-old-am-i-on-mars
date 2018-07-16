<?php

namespace SillyDevelopment\HowOldAmIOnMars\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

/**
 * Class Facebook
 * @package SillyDevelopment\HowOldAmIOnMars\Service
 */
class Facebook
{
    /**
     * @var \Facebook\Facebook
     */
    protected $_facebookClient;

    protected $_configAppId;
    protected $_configAppSecret;
    protected $_configDefaultGraphVersion;

    /**
     * Facebook constructor.
     */
    function __construct()
    {
        $this->_configAppId               = env('FACEBOOK_APP_ID');
        $this->_configAppSecret           = env('FACEBOOK_APP_SECRET');
        $this->_configDefaultGraphVersion = env('FACEBOOK_GRAPH_VERSION');
    }

    /**
     * Get app id
     * @return string
     */
    protected function getAppId()
    {
        return $this->_configAppId;
    }

    /**
     * Get app secret
     * @return string
     */
    protected function getAppSecret()
    {
        return $this->_configAppSecret;
    }

    /**
     * Get default graph version
     * @return string
     */
    protected function getDefaultGraphVersion()
    {
        return $this->_configDefaultGraphVersion;
    }

    /**
     * @return \Facebook\Facebook
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getFacebookClient()
    {
        if (empty($this->_facebookClient) == true) {
            $this->_facebookClient = new \Facebook\Facebook([
                'app_id'                => $this->getAppId(),
                'app_secret'            => $this->getAppSecret(),
                'default_graph_version' => $this->getDefaultGraphVersion(),
            ]);
        }

        return $this->_facebookClient;
    }

    /**
     * Gets user's token
     * Returns an array with error in cases of errors
     * [
     *      'code'  => Response::HTTP_BAD_REQUEST,
     *      'error' => 'error message'
     * ]
     * @return array|\Facebook\Authentication\AccessToken
     */
    public function getFacebookAccessToken()
    {
        $result = [
            'code'  => Response::HTTP_BAD_REQUEST,
            'error' => 'Something went wrong'
        ];

        try {
            $facebookClient = $this->getFacebookClient();
            $helper         = $facebookClient->getRedirectLoginHelper();

            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $exception) {
            $error = 'Graph returned an error: ' . $exception->getMessage();
            Log::error($error);
            $result = [
                'code'  => Response::HTTP_BAD_REQUEST,
                'error' => $error
            ];

            return $result;
        } catch (\Facebook\Exceptions\FacebookSDKException $exception) {
            $error = 'Facebook SDK returned an error: ' . $exception->getMessage();
            Log::error($error);
            $result = [
                'code'  => Response::HTTP_BAD_REQUEST,
                'error' => $error
            ];

            return $result;
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            Log::error($error);
            $result = [
                'code'  => Response::HTTP_BAD_REQUEST,
                'error' => $error
            ];

            return $result;
        }

        if (empty($accessToken) == true) {
            if ($helper->getError()) {
                $result = [
                    'code'  => Response::HTTP_UNAUTHORIZED,
                    'error' => $helper->getErrorReason() . ' ' . $helper->getErrorDescription()
                ];
            } else {
                $result = [
                    'code'  => Response::HTTP_UNAUTHORIZED,
                    'error' => 'Bad request'
                ];
            }
            return $result;
        }

        /** @var \Facebook\Authentication\OAuth2Client $oAuth2Client */
        $oAuth2Client = $facebookClient->getOAuth2Client();

        if (!$accessToken->isLongLived()) {
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (\Facebook\Exceptions\FacebookSDKException $exception) {
                $error = 'Error getting long-lived access token: ' . $exception->getMessage();
                Log::error($error);
                $result = [
                    'code'  => Response::HTTP_BAD_REQUEST,
                    'error' => $error
                ];

                return $result;
            }
        };

        $result = $accessToken;

        return $result;
    }
}