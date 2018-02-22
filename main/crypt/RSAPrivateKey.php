<?php namespace palex\crypt;

/**
 * 
 */
final class RSAPrivateKey {
    private $key;

    /**
     * 
     */
    public function __construct($raw) {
        if (is_string($raw)) {
            if (is_file($raw)) $raw = file_get_contents($raw);
            $this->key = openssl_pkey_get_private($raw);
        } else {
            if (is_int($raw)) $raw = ['private_key_bits' => $raw];
            $this->key = openssl_pkey_new($raw);
        }
    }

    /**
     * 
     */
    public function export($path=null) {
        openssl_pkey_export($this->key, $result);
        if (isset($path)) openssl_pkey_export_to_file($this->key, $path);
        return $result;
    }

    /**
     * 
     */
    public function getPublicKey() {
        $details = openssl_pkey_get_details($this->key);
        return new RSAPublicKey($details['key']);
    }

    /**
     * 
     */
    public function encrypt(&...$data) {
        foreach ($data as &$target) {
            openssl_private_encrypt($target, $crypted, $this->key);
            $target = base64_encode($crypted);
        }
    }

    /**
     * 
     */
    public function decrypt(&...$data) {
        foreach ($data as &$target) {
            $raw = base64_decode($target);
            openssl_private_decrypt($raw, $target, $this->key);
        }
    }
}