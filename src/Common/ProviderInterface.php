<?php

namespace OmniSmtp\Common;

interface ProviderInterface
{

    const FROM = 'from';

    const APIKEY = 'apikey';

    const SUBJECT = 'subject';

    const BODY = 'body';

    const AUTHORIZATION_NAME = 'authorization_name';

    const RECIPIENTS = 'recipients';


    /**
     * Set authorization header name
     *
     * @param string $bearer
     * 
     * @return $this
     */
    public function setAuthorizationHearerName(string $bearer = 'Authorization');

    /**
     * Get authorization  header name
     *
     * @return string
     */
    public function getAuthorizationHeaderName();

    /**
     * Set mail subject
     *
     * @param string $subject
     * 
     * @return $this
     */
    public function setSubject(string $subject);

    /**
     * Get mail subject
     *
     * @return void
     */
    public function getSubject();


    /**
     * Set mail content. This is an html content
     *
     * @param string $html
     * 
     * @return $this
     */
    public function setContent(string $html);

    /**
     * Get email html content
     *
     * @return $this
     */
    public function getContent();

    /**
     * Set smtp sender
     * 
     * Needs to be override by smtp providers
     * 
     * @param string $from
     * 
     * @return $this
     */
    public function setFrom(string $from);


    /**
     * Get sender
     *
     * @return mixed
     */
    public function getFrom();

    /**
     * Set smtp recipients
     * 
     * @param array $recipients
     * 
     * @return $this
     */
    public function setRecipients(...$recipients);

    /**
     * Get recipients
     *
     * @return array
     */
    public function getRecipients();


    /**
     * Set SMTP apikey
     *
     * @param string $apikey
     * 
     * @return $this
     */
    public function setApiKey(string $apikey);

    /**
     * Get SMTP api key
     *
     * @return string|null
     */
    public function getApikey();
}