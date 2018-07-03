<?php namespace test;

use PHPUnit\Framework\TestCase;
use palex\Filesystem;

/**
 * 
 */
final class FilesystemTest extends TestCase {
    /**
     * @dataProvider provide
     */
    public function testAt($filesystem, $name) {
        $path = $filesystem->at('@here', $name);
        $this->assertEquals($path, __DIR__.Filesystem::DS.$name);
    }

    /**
     * 
     */
    public function provide() {
        return [
            'one' => [
                new Filesystem([
                    '@here' => __DIR__,
                ]),
                'one.txt',
            ],
            'two' => [
                new Filesystem([
                    '@here' => __DIR__,
                ]),
                'two.txt',
            ]
        ];
    }
}