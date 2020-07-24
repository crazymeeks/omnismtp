# OmniSmtp

###### Framework agnostic SMTP processing library for PHP

# Usage

```php
<?php

$sendinblue = OmniSmtp::create(\OmniSmtp\SendInBlue::class, 'test-api-key');

$sendinblue->setSubject('The Mail Subject')
           ->setFrom('john.doe@example.com')
           ->setRecipients('jane.doe@example.com', 'test@email.com')
           ->setContent('<p>Hello From SendInBlue OmniSmtp</p>')
           ->send();
```

The following drivers are available:  

Driver | 3.x | Composer Package | Maintainer | Installation
--- | --- | --- | --- | ---
[sendinblue](https://github.com/crazymeeks/omnismtp-sendinblue) | ✓ | omnismtp/sendinblue | [Jeff Claud](https://github.com/crazymeeks) | composer require omnismtp/sendinblue
