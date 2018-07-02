<?php namespace palex\crypt;

/**
 * AES Key
 * 
 */
final class AesKey {
    private $iv;
    private $key;
    private $method;

    /**
     * 
     * @param string $raw: cipher key.
     * @param string $method: cipher method.
     * @param string $iv: cipher iv.
     */
    public function __construct($raw=null, $method=null, $iv=null) {
        $this->key = $raw ?? hash('sha256', time().mt_rand(0,777));
        $this->method = $method ?? 'AES-128-CBC';
        $this->iv = $iv ?? self::makeIv($this->method);
    }

    /**
     * 
     * @return string: cipher key.
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * 
     * @return string: cipher method.
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * 
     * @return string: cipher iv.
     */
    public function getIv() {
        return $this->iv;
    }

    /**
     * @param string $data: encrypt data.
     * @return string: encrypt result.
     */
    public function encrypt($data) {
        if (is_array($data)) return array_map([$this, __FUNCTION__], $data);
        $raw = openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv);
        return base64_encode($raw);
    }

    /**
     * 
     * @param string $data: decrypt data.
     * @return string: decrypt result.
     */
    public function decrypt($data) {
        if (is_array($data)) return array_map([$this, __FUNCTION__], $data);
        $raw = base64_decode($data);
        return openssl_decrypt($raw, $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv);
    }

    /**
     * 
     * @param string $method: cipher method.
     * @return string: cipher iv.
     */
    public static function makeIv($method) {
        $length = openssl_cipher_iv_length($method);
        return openssl_random_pseudo_bytes($length);
    }
}