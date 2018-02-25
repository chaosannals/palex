<?php namespace test;

use PHPUnit\Framework\TestCase;
use palex\crypt\AesKey;

/**
 * 
 */
final class AesKeyTest extends TestCase {
    /**
     * 
     * @dataProvider provideKeys
     */
    public function testEncryptAndDecrypt($key, $data) {
        $encryption = $key->encrypt($data);
        $this->assertNotEquals($data, $encryption);
        $decryption = $key->decrypt($encryption);
        $this->assertEquals($data, $decryption);
    }

    /**
     * 
     */
    public function provideKeys() {
        return [
            'one' => [
                new AesKey,
                'adsfdasfadsf',
            ],
            'two' => [
                new AesKey('ttt'),
                'ggggdddddddsa31432432',
            ],
        ];
    }
}