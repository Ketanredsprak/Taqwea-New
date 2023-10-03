<?php
namespace App\Services;

use App\Models\UserSocialLogin;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\One\AbstractProvider As OneAbstractProvider;

class SocialMediaService
{
    
    /**
     * Method getUser
     *
     * @param string $provider [explicite description]
     * @param array  $post     [explicite description]
     *
     * @return array
     */
    public function getUser(string $provider, array $post = [])
    {
        $user = Socialite::driver($provider)->user();
        if ($user) {
            $post['social_type'] = $provider;
            $post = $this->_mapUserDataWithPost($user, $post);
        }
        return $post;
    }
    
    /**
     * Method getUserFromToken
     *
     * @param string $provider [explicite description]
     * @param string $token    [explicite description]
     * @param array  $post     [explicite description]
     *
     * @return array
     */
    public function getUserFromToken(
        string $provider,
        string $token,
        array $post = []
    ) {
        $post['social_type'] = $provider;
        if ($provider == UserSocialLogin::PROVIDER_GOOGLE) {
            $post = $this->getGoogleUserFromToken($token, $post);
        } elseif ($provider == UserSocialLogin::PROVIDER_TWITTER) {
            /**
             * SocialProvider
             * 
             * @var OneAbstractProvider $socialProvider
             */
            $socialProvider = Socialite::driver($provider);
            $user = $socialProvider->userFromTokenAndSecret(
                $token,
                $post['secret']
            );
            if ($user) {
                $post = $this->_mapUserDataWithPost($user, $post);
            }
        } else {
            /**
             * SocialProvider
             * 
             * @var AbstractProvider $socialProvider
             */
            $socialProvider = Socialite::driver($provider);
            $user = $socialProvider->userFromToken($token);
            if ($user) {
                $post = $this->_mapUserDataWithPost($user, $post);
            }
        }
        
        return $post;
    }
    
    /**
     * Method mapUserDataWithPost
     *
     * @param $user $user [explicite description]
     * @param array $post [explicite description]
     *
     * @return array
     */
    private function _mapUserDataWithPost($user, array $post):array
    {
        $post['social_id'] = $user->getId();
        $post['token'] = $user->token;
        $post['name'] = $post['name'] ?? $user->getName();
        $post['email'] = $post['email'] ?? $user->getEmail();
        $url = $user->getAvatar();
        $imageName = $user->getId().'.png';
        $profileImage = saveFacebookAvatar(
            $url,
            'profile_image',
            $imageName
        );
        $post['profile_image'] = $profileImage;
        return $post;
    }
        
    /**
     * Method getGoogleUserFromToken
     *
     * @param string $token [explicite description]
     * @param array  $post  [explicite description]
     *
     * @return array
     */
    public function getGoogleUserFromToken(string $token, array $post = [])
    {
        $client = new Client();
        $apiUrl = "https://oauth2.googleapis.com/tokeninfo?id_token=$token";
        $res = $client->request(
            'GET',
            $apiUrl
        );

        $response = json_decode($res->getBody());
        if ($response) {
            $post['social_id'] = $response->sub;
            $post['name'] = $post['name'] ?? $response->name;
            $post['email'] = $post['email'] ?? $response->email;
            $post['profile_image'] = $response->picture;
        }
        return $post;    
    }
}