<?php
/**
 * Created by PhpStorm.
 * User: BemitechLLC
 * Date: 13/09/2021
 * Time: 23:22
 */

namespace DonwelSystems\Clickatell\Services;
use GuzzleHttp\Client as Guzzle;
use DonwelSystems\ClickatellNexmoGateway\Exceptions\ClickatellException;
use Log;

class Central
{
    public function dump()
    {
        dd('dumping clickatell ');
    }

    public function send($to, $message){
      return $this->sendMessage(array(
              'username'    => config('clickatell.username'),
              'password'    => config('clickatell.password'),
              'api_key'     => config('clickatell.api_key'),
              'to'          => $to,
              'message'     => $message
          ));
    }

    public function sendMessage($config = [])
    {

        return $this->send_clickatell($config);
    }



    public function send_clickatell($config = [])
    {
        $url = "http://api.clickatell.com/http/sendmsg?user=".urlencode($config['username'])."&password=".urlencode($config['password'])."&api_id=".urlencode($config['api_key'])."&to=".urlencode($config['to'])."&text=".urlencode($config['message']);
        $result = $this->_do_api_call($url);
        if($result){
             if(str_contains($result[0], 'ERR')){
                 Log::error(sprintf("Error sending sms message %s to number %s via clickatell with error message %s",$config['message'],$config['to'],$result[0]));
                 return ["result"=>'error', "code"=>$result[0]];
             }
             return ["result"=>'success', "code"=>$result[0]];
        } else {
            Log::error(sprintf("Error sending sms message %s to number %s via clickatell",$config['message'],$config['to']));;
        }
        return ["result"=>'error', "code"=>"-1"];
    }
    private function _do_api_call($url)
    {
        $result = file($url);
        return $result;
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