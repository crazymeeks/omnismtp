<?php

namespace OmniSmtp\Tests;

use OmniSmtp\OmniSmtp;
use Ixudra\Curl\CurlService;

class OmniSmtpTest extends \OmniSmtp\Tests\TestCase
{

    private $_curl;

    public function setUp()
    {
        parent::setUp();

        $this->_curl = \Mockery::mock(CurlService::class);

        $this->_curl->shouldReceive('to')
                   ->with(\Mockery::any())
                   ->andReturnSelf();
        $this->_curl->shouldReceive('asJson')
                    ->andReturnSelf();
        $this->_curl->shouldReceive('withHeader')
                    ->with(\Mockery::any())
                    ->andReturnSelf();
        $this->_curl->shouldReceive('withResponseHeaders')
                    ->andReturnSelf();
        $this->_curl->shouldReceive('returnResponseObject')
                    ->andReturnSelf();
        $this->_curl->shouldReceive('withData')
                    ->with(\Mockery::any())
                    ->andReturnSelf();
        $this->_curl->shouldReceive('post')
                    ->andReturn(json_decode(json_encode([
                        'status' => 200
                    ])));
    }

    public function testMailFactory()
    {

        $sendinblue = OmniSmtp::create(\OmniMail\Tests\SendInBlueTest::class);

        $response = $sendinblue->setApiKey('test-api-key')
                   ->setAuthorizationHearerName('api-key')
                   ->setSubject('The Mail Subject')
                   ->setFrom([
                        'name' => 'John Doe',
                        'email' => 'john.doe@example.com'
                   ])
                   ->setRecipients([
                        [
                            'name' => 'Jane Doe',
                            'email' => 'john.doe+1@example.com'
                        ]
                   ])
                   ->setContent('<p>Hello From OmniMail</p>')
                   ->send($this->_curl);
        
        $this->assertTrue($response);

    }
}

class SendInBlueTest extends \OmniSmtp\Common\AbstractProvider
{

    public function getSmtpEndpoint()
    {
        return 'https://api.sendinblue.com/v3/smtp/email';
    }

    /**
     * @inheritDoc
     */
    public function setFrom(array $from)
    {
        return $this->setData(self::FROM, ['sender' => $from]);
    }

    /**
     * @inheritDoc
     */
    public function setRecipients(array $recipients)
    {
        return $this->setData(self::RECIPIENTS, ['to' => $recipients]);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $html)
    {
        return $this->setData(self::BODY, ['htmlContent' => $html]);
    }
}