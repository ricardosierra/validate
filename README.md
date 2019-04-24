Validate Fields in PHP
=============

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ricardosierra/validate/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ricardosierra/validate/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/ricardosierra/validate/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ricardosierra/validate/?branch=master)

[![Latest Stable Version](https://poser.pugx.org/ricardosierra/validate/v/stable.png)](https://packagist.org/packages/ricardosierra/validate)
[![Total Downloads](https://poser.pugx.org/ricardosierra/validate/downloads.png)](https://packagist.org/packages/ricardosierra/validate)
[![Latest Unstable Version](https://poser.pugx.org/ricardosierra/validate/v/unstable.png)](https://packagist.org/packages/ricardosierra/validate)
[![License](https://poser.pugx.org/ricardosierra/validate/license.png)](https://packagist.org/packages/ricardosierra/validate)

This package provides a pure PHP validator for field in differents formats


## Requirements:

 * PHP 7.0+
 * Composer

## Installation

 You can install this library via Composer: `composer require ricardosierra/validate` 
  
## Examples 

### Validate Email
```php
<?php

use Validate\Email;

// Initialize library class
$mail = new Email();

// Set the timeout value on stream
$mail->setStreamTimeoutWait(20);

// Set debug output mode
$mail->Debug= TRUE; 
$mail->Debugoutput= 'html'; 

// Set email address for SMTP request
$mail->setEmailFrom('from@email.com');

// Email to check
$email = 'email@example.com'; 

// Check if email is valid and exist
if($mail->check($email)){ 
    echo 'Email &lt;'.$email.'&gt; is exist!'; 
}elseif(Email::validate($email)){ 
    echo 'Email &lt;'.$email.'&gt; is valid, but not exist!'; 
}else{ 
    echo 'Email &lt;'.$email.'&gt; is not valid and not exist!'; 
} 

?>
```



## Contributing

For contributing guidelines, please see [CONTRIBUTING.md](CONTRIBUTING.md)

## Credits