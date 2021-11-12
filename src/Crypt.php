<?php

namespace Arispati\PhpEncryptFile;

class Crypt
{
    /**
     * File blocks length
     */
    private const FILE_ENCRYPTION_BLOCKS = 10000;

    /**
     * Encryption key
     *
     * @var string
     */
    private $key;

    /**
     * Encryption chiper
     *
     * @var string
     */
    private $cipher;

    /**
     * Class constructor
     *
     * @param string $key
     * @param string $cipher
     */
    public function __construct(string $key, string $cipher = 'AES-256-CBC')
    {
        $this->key = $key;
        $this->cipher = $cipher;
    }

    /**
     * Encrypt file
     *
     * @param string $source
     * @param string $destination
     * @return void
     */
    public function encrypt(string $source, string $destination)
    {
        $ivLenght = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivLenght);

        $sourceFile = fopen($source, 'rb');
        $destinationFile = fopen($destination, 'w');

        fwrite($destinationFile, $iv);

        while (! feof($sourceFile)) {
            $plaintext = fread($sourceFile, $ivLenght * static::FILE_ENCRYPTION_BLOCKS);
            $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
            $iv = substr($ciphertext, 0, $ivLenght);

            fwrite($destinationFile, $ciphertext);
        }

        fclose($sourceFile);
        fclose($destinationFile);
    }

    /**
     * Decrypt file
     *
     * @param string $source
     * @param string $destination
     * @return void
     */
    public function decrypt(string $source, string $destination)
    {
        $ivLenght = openssl_cipher_iv_length($this->cipher);

        $sourceFile = fopen($source, 'rb');
        $destinationFile = fopen($destination, 'w');

        $iv = fread($sourceFile, $ivLenght);

        while (! feof($sourceFile)) {
            $ciphertext = fread($sourceFile, $ivLenght * (static::FILE_ENCRYPTION_BLOCKS + 1));
            $plaintext = openssl_decrypt($ciphertext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
            $iv = substr($plaintext, 0, $ivLenght);

            fwrite($destinationFile, $plaintext);
        }

        fclose($sourceFile);
        fclose($destinationFile);
    }
}
