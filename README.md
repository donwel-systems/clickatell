#  Laravel package to send sms via the Clickatell Sms Gateway
PhP Package for sennding sms via Clickatell on both the old Communicator Central (http://api.clickatell.com) and the new Clickatell Platorm (https://platform.clickatell.com)
using the https(s) protocol
The Rest API for the new Clickatell Platform is not supported in this Package
#Usage
1. Run composer require donwel-systems/clickatell
2. Run php artisan vendor:publish 
3. Choose the DonwelSystems\Clickatell\ClickatellServiceProvider and hit enter.
4. Edit the config/clickatell.php file accordingly
5. Edit confit/app.php and add the 'ClickatellFacade' class to the aliases array
``` php
'aliases' => [
    ...
    'Clickatell' => DonwelSystems\Clickatell\Facades\ClickatellFacade::class,
```
6. In your code, to send an Sms use
```php
Clickatell::send($to,$message)
```
The Clickatell::send method returns an associative array 
i) If the message is successfully sent, the array 
```php
 ["result"=>'success', "code"=>'$code'];
```
is returned; where $code contains the unqiue message ID from clickatell

ii) If the message is no successfully sent, or an error occurs, the array 
```php
 ["result"=>'error', "code"=>'$code'];
```
is returned; where $code contains the error message.