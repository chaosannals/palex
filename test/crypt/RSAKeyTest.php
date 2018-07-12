<?php namespace test\crypt;

use PHPUnit\Framework\TestCase;
use palex\crypt\RsaPublicKey;
use palex\crypt\RsaPrivateKey;

/**
 * test RsaPrivateKey and RsaPublicKey.
 * 
 */
final class RsaKeyTest extends TestCase {
    /**
     * 
     * @dataProvider provideKeys
     */
    public function testPrivateEncryptAndPublicDecrypt($privateKey, $publicKey, $data) {
        $encrypted = $privateKey->encrypt($data);
        $this->assertNotEquals($encrypted, $data);
        $decrypted = $publicKey->decrypt($encrypted);
        $this->assertEquals($decrypted, $data);
    }

    /**
     * 
     * @dataProvider provideKeys
     */
    public function testPublicEncryptAndPrivateDecrypt($privateKey, $publicKey, $data) {
        $encrypted = $publicKey->encrypt($data);
        $this->assertNotEquals($encrypted, $data);
        $decrypted = $privateKey->decrypt($encrypted);
        $this->assertEquals($decrypted, $data);
    }

    /**
     * 
     * @dataProvider provideKeys
     */
    public function testExport($privateKey, $publicKey, $data) {
        $key = $privateKey->export();
        $this->assertNotNull($key);
    }

    /**
     * 
     */
    public function provideKeys() {
        $one = new RsaPrivateKey(['private_key_bits' => 2048]);
        $two = new RsaPrivateKey(2048);
        return [
            'new key one' => [
                $one,
                $one->getPublicKey(),
                'AABBCCDDEEFFGGHHII'
            ],
            'new key two' => [
                $two,
                $two->getPublicKey(),
                'ADSFASDGgegwgdsag2134'
            ],
        ];
    }
}