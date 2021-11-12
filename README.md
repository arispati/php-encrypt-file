# PHP Encrypt File
PHP library for encrypt and decrypt file

## How to Install
- Install with composer
```bash
composer require arispati/php-encrypt-file
```

## How to Use
```php
use Arispati\PhpEncryptFile\Crypt;

// by default use 'AES-256-CBC' cipher
// you can change it on the second argument
$crypt = new Crypt('your-secret-key');

// to encrypt
$crypt->encrypt('./path/to/plainFile.ext', './path/to/encryptedFile.ext');
// to decrypt
$crypt->decrypt('./path/to/encryptedFile.ext', './path/to/decryptedFile.ext');
```

#### Credits
- Thanks to *Antoine Lamé* - [Medium](https://medium.com/@antoine.lame/how-to-encrypt-files-with-php-f4adead297de).