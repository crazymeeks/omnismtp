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

        $sendinblue = OmniSmtp::create(\OmniSmtp\Tests\SendInBlueTest::class, 'test-api-key');

        $response = $sendinblue->setSubject('The Mail Subject')
                   ->setFrom('john.doe@example.com')
                   ->setRecipients('jane.doe@example.com')
                   ->setContent('<p>Hello From OmniSmtp</p>')
                   ->send($this->_curl);
        
        $this->assertTrue($response);

    }

    public function testMailWithTemplate()
    {

        $sendinblue = OmniSmtp::create(\OmniSmtp\Tests\SendInBlueTest::class, 'test-api-key');

        $mail = $sendinblue->setSubject('The Mail Subject')
                   ->setFrom('jeffclaud17@gmail.com')
                   ->setRecipients('jefferson.claud@nuworks.ph')
                   ->setTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'views/template.php', ['name' => 'John']);

        $this->assertSame('<h1>John</h1>', $mail->getContent()['htmlContent']);

    }
}

class SendInBlueTest extends \OmniSmtp\Common\AbstractProvider
{

    /**
     * @inheritDoc
     */
    public function getAuthorizationHeaderName()
    {
        return $this->getData(self::AUTHORIZATION_NAME) ? $this->getData(self::AUTHORIZATION_NAME) : 'api-key';
    }

    /**
     * @inheritDoc
     */
    public function getSmtpEndpoint()
    {
        return 'https://api.sendinblue.com/v3/smtp/email';
    }

    /**
     * @inheritDoc
     */
    public function setFrom(string $from)
    {
        return $this->setData(self::FROM, ['sender' => ['email' => $from]]);
    }

    /**
     * @inheritDoc
     */
    public function setRecipients(...$recipients)
    {
        $emails = [];
        foreach($recipients as $recipient){
            $emails[] = [
                'email' => $recipient
            ];

            unset($recipient);
        }

        return $this->setData(self::RECIPIENTS, ['to' => $emails]);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $html)
    {
        return $this->setData(self::BODY, ['htmlContent' => $html]);
    }
}