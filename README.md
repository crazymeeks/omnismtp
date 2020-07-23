# omnismtp

# Usage

```php
<?php

$sendinblue = OmniSmtp::create(\OmniSmtp\SendInBlue::class);

$sendinblue->setApiKey('test-api-key')
           ->setAuthorizationHearerName('api-key')
           ->setSubject('The Mail Subject')
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

Attempt | #1 | #2 | #3 | #4 | #5 | #6 | #7 | #8 | #9 | #10 | #11
--- | --- | --- | --- |--- |--- |--- |--- |--- |--- |--- |---
Seconds | 301 | 283 | 290 | 286 | 289 | 285 | 287 | 287 | 272 | 276 | 269

Driver | 3.x | Composer Package | Maintainer  
--- | --- | --- | --- | ---  
[sendinblue](https://github.com/crazymeeks/omnismtp-sendinblue) | ✓ | omnismtp/sendinblue | [Jeff Claud](https://github.com/crazymeeks)
