# OmniSmtp

###### Framework agnostic SMTP processing library for PHP

# Usage

```php
<?php

$sendinblue = \OmniSmtp\OmniSmtp::create(\OmniSmtp\SendInBlue::class, 'test-api-key');

$sendinblue->setSubject('The Mail Subject')
           ->setFrom('john.doe@example.com')
           ->setRecipients('jane.doe@example.com', 'test@email.com')
           ->setContent('<p>Hello From SendInBlue OmniSmtp</p>')
           ->send();
```  
---
### Drivers
All mail providers must implement `\OmniSmtp\Common\ProviderInterface`, and will usually extend `\OmniSmtp\Common\AbstractProvider` for basic functionality.  

---
The following drivers are available:  

Driver | 3.x | Composer Package | Maintainer | Installation
--- | --- | --- | --- | ---
[sendinblue](https://github.com/crazymeeks/omnismtp-sendinblue) | ✓ | omnismtp/sendinblue | [Jeff Claud](https://github.com/crazymeeks) | `composer require omnismtp/sendinblue`  
[sendgrid](https://github.com/napoleon101392/omnismpt-sendgrind) | ✓ | napoleon/omnismtp-sendgrid | [Napoleon Cariño](https://github.com/napoleon101392) | `composer require napoleon/omnismtp-sendgrid`  
---  
### Driver method  
The main method implemented by drivers are:  
- `getAuthorizationHeaderName()` - smtp provider authorization header name. Usually `Authorization`.  
- `getSmtpEndpoint()` - web api endpoint of smtp providers.  

Optional setter methods you may want to implement:  
- `setFrom(string $email)` - Email of the sender.  
- `setRecipients(...$recipients)` - List of recipients email.  
- `setContent(string $html)` - Email html content.  

Note: When implementing these setter methods in your own, you may call `setData($key, $value)` to set your data. Ex.  
```php
<?php
public function setFrom(string $email)
{
     return $this->setData(self::FROM, $email);
}
```

---
