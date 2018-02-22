<?php namespace palex\crypt;

/**
 * 
 */
final class RSAPublicKey {
    private $key;

    /**
     * 
     */
    public function __construct($raw) {
        $this->key = openssl_pkey_get_public($raw);
    }

    /**
     * 
     */
    public function encrypt(&...$data) {
        foreach ($data as &$target) {
            openssl_public_encrypt($target, $crypted, $this->key);
            $target = base64_encode($crypted);
        }
    }

    /**
     * 
     */
    public function decrypt(&...$data) {
        foreach ($data as &$target) {
            $raw = base64_decode($target);
            openssl_public_decrypt($raw, $target, $this->key);
        }
    }
}