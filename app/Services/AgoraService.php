<?php
namespace App\Services;

use Carbon\Carbon;
use Codiant\Agora\RtcTokenBuilder;
use GuzzleHttp\Client;

class AgoraService
{
    protected $tokenBuilder;
    
    /**
     * Method __construct
     *
     * @param RtcTokenBuilder $tokenBuilder 
     * 
     * @return void
     */
    public function __construct(
        RtcTokenBuilder $tokenBuilder
    ) {
        $this->tokenBuilder = $tokenBuilder;
    }
    
    /**
     * Method generateToken
     *
     * @param string $channelName 
     * @param int    $uid 
     * @param string $role      
     * 
     * @return void
     */
    public function generateToken(
        string $channelName,
        int $uid = 0,
        string $role = RtcTokenBuilder::ROLE_ATTENDEE
    ):string {
        $appId = config('agora.app_id');
        $appcertificate = config('agora.app_certificate');
        $expireTimeInSeconds = config('agora.expiry_time');
        $currentTimestamp = Carbon::now()->timestamp;
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        
        return $this->tokenBuilder->buildTokenWithUid(
            $appId,
            $appcertificate,
            $channelName,
            $uid,
            $role,
            $privilegeExpiredTs
        );
    }
    
    /**
     * Method generateWhiteBoardToken
     *
     * @param string $role [explicite description]
     *
     * @return string
     */
    public function generateWhiteBoardToken(string $role = 'admin'):?string
    {
        $accessKey = config('agora.access_key');
        $secretAccessKey = config('agora.secret_access_key');
        $client = new Client();
        $response = $client->request(
            'post',
            "https://api.netless.link/v5/tokens/teams",
            [
                "headers" => [
                    'region' => 'in-mum',
                    'Content-Type' => 'application/json'
                ],
                "json" => [
                    'accessKey' => $accessKey,
                    'secretAccessKey' => $secretAccessKey,
                    'lifespan' => Carbon::now()->addHours(10)->timestamp,
                    'role' => $role
                ], 
            ]
        );
        
        if ($response->getStatusCode() === 201) {
            return json_decode($response->getBody());
        }
        return null;
    }

    /**
     * Method generateRoomToken
     *
     * @return string
     */
    public function generateWhiteboardRoom($class)
    {
        $whiteBoardToken = $this->generateWhiteBoardToken();
        $lifeSpan = Carbon::parse($class->end_time)->addHours(10)->timestamp;
        $client = new Client();
        $response = $client->request(
            'post',
            "https://api.netless.link/v5/rooms",
            [
                "headers" => [
                    "token" => $whiteBoardToken,
                    "Content-Type" => "application/json",
                    "region" => config('agora.app_region')
                ],
                "json" => [
                    'isRecord' => false
                ], 
            ]
        );
        $roomData = json_decode($response->getBody());
        $roomToken = $this->generateRoomToken($roomData->uuid, $whiteBoardToken, $lifeSpan);
        $data['uuid'] = $roomData->uuid;
        $data['room_token'] = $roomToken;       
        return $data;
    }
    /**
     * Method generateRoomToken
     *
     * @param string $roomId [explicite description]
     *
     * @return string
     */
    public function generateRoomToken(string $roomId, string $whiteBoardToken, $lifeSpan):?string
    {
        $client = new Client();
        $response = $client->request(
            'post',
            "https://api.netless.link/v5/tokens/rooms/".$roomId,
            [
                "headers" => [
                    "token" => $whiteBoardToken,
                    "Content-Type" => "application/json",
                    "region" => config('agora.app_region')
                ],
                "json" => [
                    'lifespan' => $lifeSpan,
                    'role' => 'admin'
                ], 
            ]
        );
        $tokenData = json_decode($response->getBody());
        return $tokenData;
    }
}
