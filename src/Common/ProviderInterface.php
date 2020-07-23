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