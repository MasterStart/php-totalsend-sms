# php-totalsend-sms

An API client for sending SMSs via the [TotalSend](https://www.totalsend.co.za) API

[![Author](http://img.shields.io/badge/author-@masterstartsa-blue.svg?style=flat-square)](https://twitter.com/masterstartsa)
[![Build Status](https://img.shields.io/travis/MasterStart/php-totalsend-sms/master.svg?style=flat-square)](https://travis-ci.org/MasterStart/php-totalsend-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/masterstart/php-totalsend-sms.svg?style=flat-square)](https://packagist.org/packages/masterstart/php-totalsend-sms)
[![Total Downloads](https://img.shields.io/packagist/dt/masterstart/php-totalsend-sms.svg?style=flat-square)](https://packagist.org/packages/masterstart/php-totalsend-sms)

## Installation

```bash
composer require masterstart/php-totalsend-sms
```

## Usage

```php
$username = 'your_username';
$password = 'your_password'; // or api token

$guzzleClient = new \GuzzleHttp\Client();

$client = new \MasterStart\TotalSendSMS\TotalSendSMSClient($guzzleClient, $username, $password);
s
$response = $client->sendMessage('+27000000000', 'This is a test message.');
var_dump($response);
```
