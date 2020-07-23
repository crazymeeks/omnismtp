# OmniSmtp

###### An SMTP processing library for PHP

# Usage

```php
<?php

$sendinblue = OmniSmtp::create(\OmniSmtp\SendInBlue::class, 'test-api-key');

$sendinblue->setSubject('The Mail Subject')
           ->setFrom([
                        'name' => 'John Doe',
                        'email' => 'john.doe@example.com'
           ])
           ->setRecipients([
                 [
                     'name' => 'Jane Doe',
                     'email' => 'jane.doe@example.com'
                 ]
            ])
            ->setContent('<p>Hello From SendInBlue OmniMail</p>')
            ->send();
```

The following drivers are available:  

Driver | 3.x | Composer Package | Maintainer
--- | --- | --- | ---
[sendinblue](https://github.com/crazymeeks/omnismtp-sendinblue) | ✓ | omnismtp/sendinblue | [Jeff Claud](https://github.com/crazymeeks)
