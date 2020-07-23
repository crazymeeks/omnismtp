<?php

/**
 * Abstract mail provider.
 * 
 * (c) Jeff Claud
 */

namespace OmniSmtp\Common;

use Ixudra\Curl\CurlService;
use OmniSmtp\Common\ProviderInterface;
use OmniSmtp\Exceptions\OmniMailException;

abstract class AbstractProvider implements ProviderInterface
{

    /**
     * Data prefix key for specific mail provider.
     * 
     * For sendgrid they used 'personalizations' key. Intended to be override by class that extends
     * this abstract class
     *
     * @var string
     */
    protected $data_key = null;

    protected $container = [];

    public function getSmtpEndpoint()
    {
        throw new OmniMailException(get_class($this) . ' does not implement getSmtpEndpoint() method');
    }

    public function identifier()
    {
        throw OmniMailException::smtpIdentifierException();
    }

    /**
     * Set authorization header name
     *
     * @param string $bearer
     * 
     * @return $this
     */
    public function setAuthorizationHearerName(string $bearer = 'Authorization')
    {
        return $this->setData(self::AUTHORIZATION_NAME, $bearer);
    }

    /**
     * Get authorization  header name
     *
     * @return string
     */
    public function getAuthorizationHeaderName()
    {
        return $this->getData(self::AUTHORIZATION_NAME);
    }

    /**
     * Set mail subject
     *
     * @param string $subject
     * 
     * @return $this
     */
    public function setSubject(string $subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * Get mail subject
     *
     * @return void
     */
    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }


    /**
     * Set mail content. This is an html content
     *
     * @param string $html
     * 
     * @return $this
     */
    public function setContent(string $html)
    {
        return $this->setData(self::BODY, $html);
    }

    public function getContent()
    {
        return $this->getData(self::BODY);
    }

    /**
     * Set smtp sender
     * 
     * Needs to be override by smtp providers
     * 
     */
    public function setFrom(array $from)
    {
        return $this->setData(self::FROM, $from);
    }


    /**
     * Get sender
     *
     * @return mixed
     */
    public function getFrom()
    {
        return $this->getData(self::FROM);
    }

    /**
     * Set smtp recipients
     * 
     * @param array $recipients
     * 
     * @return $this
     */
    public function setRecipients(array $recipients)
    {
        return $this->setData(self::RECIPIENTS, $recipients);
    }

    /**
     * Get recipients
     *
     * @return array
     */
    public function getRecipients()
    {
        return $this->getData(self::RECIPIENTS);
    }


    /**
     * @inheritDoc
     */
    public function setApiKey(string $apikey)
    {
        return $this->setData(self::APIKEY, $apikey);
    }

    /**
     * @inheritDoc
     */
    public function getApikey()
    {
        return $this->getData(self::APIKEY);
    }

    /**
     * Send email
     *
     * @return true
     */
    public function send(CurlService $curl = null)
    {
        $curl = $curl ? $curl : new CurlService();

        $data = $this->formatDataBaseOnProvider();
        
        $response = $curl->to($this->getSmtpEndpoint())
                         ->asJson()
                         ->withHeader($this->getAuthorizationHeaderName() . ': ' . $this->getApikey())
                         ->withResponseHeaders()
                         ->returnResponseObject()
                         ->withData($data)
                         ->post();

        if (!in_array($response->status, [200, 201])) {
            throw OmniMailException::actualSendingEmailException(json_encode($response->content));
        }

        return true;
    }

    protected function formatDataBaseOnProvider()
    {
        $from = $this->getFrom();
        $recipients = $this->getRecipients();
        $content = $this->getContent();
        $subject = ['subject' => $this->getSubject()];

        $data = array_merge($from, $recipients, $subject, $content);

        if ($this->data_key) {
            $data = [
                $this->data_key => array_merge($from, $recipients, $subject, $content)
            ];
        }

        return $data;

    }

    /**
     * Data setter
     *
     * @param string $key
     * @param mixed $value
     * 
     * @return $this
     */
    public function setData(string $key, $value)
    {
        $this->container[$key] = $value;
        return $this;
    }

    /**
     * Getter
     *
     * @param string $key
     * 
     * @return mixed
     */
    public function getData(string $key)
    {
        if (isset($this->container[$key])) {
            return $this->container[$key];
        }

        return null;
    }
}