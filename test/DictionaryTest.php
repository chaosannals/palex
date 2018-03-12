<?php namespace test;

use PHPUnit\Framework\TestCase;
use palex\Dictionary;

/**
 * 
 */
final class DictionaryTest extends TestCase {
    /**
     * @dataProvider provide
     */
    public function testSetAndGet($dictionary, $key, $value) {
        $dictionary->set($key, $value);
        $result = $dictionary->get($key);
        $this->assertEquals($result, $value);
    }

    /**
     * @dataProvider provide
     */
    public function testSetAndHas($dictionary, $key, $value) {
        $this->assertEquals($dictionary->has($key), false);
        $dictionary->set($key, $value);
        $this->assertEquals($dictionary->has($key), true);
    }

    /**
     * 
     */
    public function provide() {
        return [
            'one' => [
                new Dictionary,
                'one',
                'value',
            ],
            'two' => [
                new Dictionary,
                'one.two',
                'value',
            ]
        ];
    }
}