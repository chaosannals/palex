<?php namespace palex\crypt;

/**
 * RSA Private Key
 * 
 */
final class RsaPrivateKey {
    private $key;
    private $configuration;

    /**
     * 
     * @param mixed $raw:
     */
    public function __construct($raw) {
        if (is_string($raw)) {
            if (is_file($raw)) $raw = file_get_contents($raw);
            $this->key = openssl_pkey_get_private($raw);
        } else {
            $this->configuration = [
                'private_key_bits' => is_int($raw) ? $raw : 4096,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ];
            if (false !== stripos(PHP_OS, 'WIN')) {
                $this->configuration['config'] = dirname(PHP_BINARY).'\extras\ssl\openssl.cnf';
            }
            $this->key = openssl_pkey_new($this->configuration);
        }
    }

    /**
     * 
     * @param string[option] $path: save path.
     * @return string: private key.
     */
    public function export($path=null) {
        openssl_pkey_export($this->key, $result, null, $this->configuration);
        if (isset($path)) openssl_pkey_export_to_file($this->key, $path, null, $configuration);
        return $result;
    }

    /**
     * 
     * @return object: RsaPublicKey.
     */
    public function getPublicKey() {
        $details = openssl_pkey_get_details($this->key);
        return new RsaPublicKey($details['key']);
    }

    /**
     * encrypt by key.
     * 
     * @param string|array $data: encrypt data reference.
     */
    public function encrypt($data) {
        if (is_array($data)) return array_map([$this, __FUNCTION__], $data);
        openssl_private_encrypt($data, $result, $this->key);
        return base64_encode($result);
    }

    /**
     * decrypt by key.
     * 
     * @param string|array $data: decrypt data reference.
     */
    public function decrypt($data) {
        if (is_array($data)) return array_map([$this, __FUNCTION__], $data);
        $raw = base64_decode($data);
        openssl_private_decrypt($raw, $result, $this->key);
        return $result;
    }
}