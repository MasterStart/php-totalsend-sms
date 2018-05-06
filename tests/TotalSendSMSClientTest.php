<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use MasterStart\TotalSendSMS\TotalSendSMSClient;
use Mockery;
use PHPUnit\Framework\TestCase;

class TotalSendSMSClientTest extends TestCase
{
    public function testSetGetUri()
    {
        $guzzleClient = Mockery::mock(Client::class);
        $client = new TotalSendSMSClient($guzzleClient);
        $this->assertEquals('http://smsapi.totalsend.com', $client->getUri());
        $client->setUri('http://127.0.0.1');
        $this->assertEquals('http://127.0.0.1', $client->getUri());
    }

    public function testSetGetUsername()
    {
        $guzzleClient = Mockery::mock(Client::class);
        $client = new TotalSendSMSClient($guzzleClient, 'my_username');
        $this->assertEquals('my_username', $client->getUsername());
        $client->setUsername('my_new_username');
        $this->assertEquals('my_new_username', $client->getUsername());
    }

    public function testSetGetPassword()
    {
        $guzzleClient = Mockery::mock(Client::class);
        $client = new TotalSendSMSClient($guzzleClient, 'my_username', 'my_password');
        $this->assertEquals('my_password', $client->getPassword());
        $client->setPassword('my_new_password');
        $this->assertEquals('my_new_password', $client->getPassword());
    }

    public function testSetGetUserAgent()
    {
        $guzzleClient = Mockery::mock(Client::class);
        $client = new TotalSendSMSClient($guzzleClient);
        $this->assertEquals('masterstart/php-totalsend-sms', $client->getUserAgent());
        $client->setUserAgent('lorem-ipsum');
        $this->assertEquals('lorem-ipsum', $client->getUserAgent());
    }

    public function testMakeBaseUri()
    {
        $guzzleClient = Mockery::mock(Client::class);
        $client = new TotalSendSMSClient($guzzleClient);
        $client->setUri('http://smsapi.totalsend.com//');
        $uri = $client->makeBaseUri('json');
        $this->assertEquals('http://smsapi.totalsend.com/json', $uri);
    }

    public function testGetGlobalHeaders()
    {
        $guzzleClient = Mockery::mock(Client::class);
        $client = new TotalSendSMSClient($guzzleClient);
        $client->setUserAgent('My UserAgent String');
        $headers = $client->getGlobalHeaders();
        $this->assertArrayHasKey('User-Agent', $headers);
        $this->assertEquals('My UserAgent String', $headers['User-Agent']);
    }

    public function testGet()
    {
        $request = new Request(
            'GET',
            'http://smsapi.totalsend.com/json?action=message_send',
            ['User-Agent' => 'masterstart/php-totalsend-sms']
        );

        $guzzleClient = Mockery::mock(Client::class);
        $client = Mockery::mock(
            '\MasterStart\TotalSendSMS\TotalSendSMSClient[createRequest,sendRequest]',
            [$guzzleClient]
        );
        $client->shouldAllowMockingProtectedMethods();
        $client->shouldReceive('createRequest')
            ->withArgs([
                'GET',
                'json?action=message_send',
            ])
            ->once()
            ->andReturn($request);
        $client->shouldReceive('sendRequest')
            ->with($request)
            ->once();

        $client->get('message_send');
    }

    public function testGetWithQueryString()
    {
        $request = new Request(
            'GET',
            'http://smsapi.totalsend.com/json?action=message_send',
            ['User-Agent' => 'masterstart/php-totalsend-sms']
        );

        $guzzleClient = Mockery::mock(Client::class);
        $client = Mockery::mock(
            '\MasterStart\TotalSendSMS\TotalSendSMSClient[createRequest,sendRequest]',
            [$guzzleClient]
        );
        $client->shouldAllowMockingProtectedMethods();
        $client->shouldReceive('createRequest')
            ->withArgs([
                'GET',
                'json?hello=world&action=message_send',
            ])
            ->once()
            ->andReturn($request);
        $client->shouldReceive('sendRequest')
            ->with($request)
            ->once();

        $client->get('message_send', ['hello' => 'world']);
    }

    public function testSendMessage()
    {
        $guzzleClient = Mockery::mock(Client::class);
        $client = Mockery::mock('\MasterStart\TotalSendSMS\TotalSendSMSClient[get]', [$guzzleClient]);
        $client->shouldReceive('get')
            ->withArgs([
                'message_send',
                [
                    'to' => '+27000000000',
                    'text' => 'This is my message',
                    'from' => '+27111111111',
                    'report_mask' => 19,
                    'report_url' => null,
                    'charset' => null,
                    'data_coding' => null,
                    'message_class' => -1,
                    'auto_detect_encoding' => 0,
                ],
            ])
            ->once();
        $client->sendMessage('+27000000000', 'This is my message', '+27111111111');
    }
}
