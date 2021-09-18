<?php
/**
 * Created by PhpStorm.
 * User: BemitechLLC
 * Date: 16/09/2021
 * Time: 01:16
 */

namespace DonwelSystems\Clickatell\Services;


abstract class Clickatell
{
    public abstract function send(string $to, $message);

}