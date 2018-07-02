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
     * @param string|array $data: encrypt data reference.
     */
    public function encrypt($data) {
        if (is_array($data)) return array_map([$this, __FUNCTION__], $data);
        openssl_public_encrypt($data, $result, $this->key);
        return base64_encode($result);
    }

    /**
     * encrypt by key.
     * 
     * @param string|array $data: decrypt data reference.
     */
    public function decrypt($data) {
        if (is_array($data)) return array_map([$this, __FUNCTION__], $data);
        $raw = base64_decode($data);
        openssl_public_decrypt($raw, $result, $this->key);
        return $result;
    }
}