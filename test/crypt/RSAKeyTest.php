<?php namespace test\crypt;

use PHPUnit\Framework\TestCase;
use palex\crypt\RSAPublicKey;
use palex\crypt\RSAPrivateKey;

/**
 * test RSAPrivateKey and RSAPublicKey.
 * 
 */
final class RSAKeyTest extends TestCase {
    /**
     * 
     * @dataProvider provideKeys
     */
    public function testPrivateEncryptAndPublicDecrypt($privateKey, $publicKey, $data) {
        $origin = $data;
        $privateKey->encrypt($data);
        $this->assertNotEquals($origin, $data);
        $publicKey->decrypt($data);
        $this->assertEquals($origin, $data);
    }

    /**
     * 
     * @dataProvider provideKeys
     */
    public function testPublicEncryptAndPrivateDecrypt($privateKey, $publicKey, $data) {
        $origin = $data;
        $publicKey->encrypt($data);
        $this->assertNotEquals($origin, $data);
        $privateKey->decrypt($data);
        $this->assertEquals($origin, $data);
    }

    /**
     * 
     */
    public function provideKeys() {
        $one = new RSAPrivateKey(['private_key_bits' => 2048]);
        $two = new RSAPrivateKey(2048);
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