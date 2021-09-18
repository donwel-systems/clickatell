<?php
/**
 * Created by PhpStorm.
 * User: BemitechLLC
 * Date: 16/09/2021
 * Time: 01:17
 */

namespace DonwelSystems\Clickatell\Services;
use GuzzleHttp\Client as Guzzle;
use Log;


class Platform extends Clickatell
{
    protected $client;

    protected $endpoint = 'https://platform.clickatell.com/messages';

    public function __construct()
    {
        $this->client = new Guzzle($this->getHeaders());
    }

    public function send(string $to, $message)
    {
        return $this->send_clickatell(array(
            'api_key'     => config('clickatell.api_key'),
            'to'          => $to,
            'message'     => $message
        ));
    }



    protected function getHeaders()
    {
        return [
            'headers' => [
                'Authorization' => config('clickatell.api_key')
            ]
        ];
    }

    public function send_clickatell($config = [])
    {
        $url = "https://platform.clickatell.com/messages/http/send?apiKey=".urlencode($config['api_key'])."&to=".urlencode($config['to'])."&content=".urlencode($config['message']);
        $response = $this->client->request('GET',$url);
        if($response){
            $r =  json_decode($response->getBody());
            if(!str_contains($response->getBody(), 'apiMessageId')){
                Log::error(sprintf("Error sending sms message %s to number %s via clickatell with error message %s",$config['message'],$config['to'],$r->errorDescription));
                return ["result"=>'error', "code"=>$r->errorCode, "error"=>$r->error, "errorDescription"=>$r->errorDescription];
            }
            return ["result"=>'success', "code"=>$r->messages[0]->apiMessageId];
        } else {
            Log::error(sprintf("Error sending sms message %s to number %s via clickatell",$config['message'],$config['to']));;
        }
        return ["result"=>'error', "code"=>"-1"];
    }

    function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function template($config = null)
    {
        $newStr = $config['message'];
        foreach ($config as $key => $value) {
            $newStr = str_replace("%$key%", $value, $newStr);
        }
        return $newStr;
    }
}