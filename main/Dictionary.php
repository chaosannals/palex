<?php namespace palex;

/**
 * Dictionary
 * 
 */
final class Dictionary {
    private $all;

    /**
     * initialize.
     * 
     * @param array $data: data.
     */
    public function __construct($data=null) {
        $this->all = $data ?? [];
    }

    /**
     * if contains return true.
     * 
     * @param string $path: key.
     * @return bool: has value.
     */
    public function has($path) {
        $target = &$this->all;
        foreach (explode('.', $path) as $key) {
            if (array_key_exists($key, $target)) {
                $target = &$target[$key];
            } else return false;
        }
        return true;
    }

    /**
     * 
     * @param string $path: key.
     * @param mixed $default: default value.
     * @return mixed: value.
     */
    public function get($path, $default=null) {
        $target = &$this->all;
        foreach (explode('.', $path) as $key) {
            if (array_key_exists($key, $target)) {
                $target = &$target[$key];
            } else return $default;
        }
        return $target;
    }

    /**
     * 
     * @param string $path: key.
     * @param mixed $value: value.
     */
    public function set($path, $value) {
        $target = &$this->all;
        foreach (explode('.', $path) as $key) {
            if (!array_key_exists($key, $target)) {
                $target[$key] = [];
            }
            $target = &$target[$key];
        }
        $target = $value;
    }
}