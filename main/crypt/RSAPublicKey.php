<?php namespace palex\crypt;

/**
 * RSA Public Key
 * 
 */
final class RsaPublicKey {
    private $key;

    /**
     * 
     * @param mixed $raw:
     */
    public function __construct($raw) {
        $this->key = openssl_pkey_get_public($raw);
    }

    /**
     * encrypt by key.
     * 
     * @param string... $data: encrypt data reference.
     */
    public function encrypt(&...$data) {
        foreach ($data as &$target) {
            openssl_public_encrypt($target, $crypted, $this->key);
            $target = base64_encode($crypted);
        }
    }

    /**
     * encrypt by key.
     * 
     * @param string... $data: decrypt data reference.
     */
    public function decrypt(&...$data) {
        foreach ($data as &$target) {
            $raw = base64_decode($target);
            openssl_public_decrypt($raw, $target, $this->key);
        }
    }
}