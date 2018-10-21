<?php namespace test\http;

use PHPUnit\Framework\TestCase;
use palex\http\Request;

/**
 * 
 */
final class RequestTest extends TestCase {
    /**
     * 
     */
    public function testGet() {
        $request = new Request();
        $raw = $request->get('https::/buidu.com');
        $this->assertNotNull($raw);
    }
}