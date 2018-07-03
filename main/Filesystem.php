<?php namespace palex;

/**
 * Filesystem extension.
 * 
 */
final class Filesystem {
    public const DS = DIRECTORY_SEPARATOR;

    private $marks;

    /**
     * initialize.
     * 
     * @param array $marks: marks of path.
     */
    public function __construct($marks=null) {
        $this->marks = $marks ?? [];
    }

    /**
     * get the path.
     * 
     * @param string $head: a path or mark.
     * @param string ...$tail: path tail.
     * @return string: path.
     */
    public function at($head, ...$tail) {
        if ('@' == $head[0]) $head = $this->marks[$head];
        return $head.self::DS.join(self::DS, $tail);
    }

    /**
     * uniform separator and get the path.
     * 
     * @param string $path: raw path.
     * @return string: path.
     */
    public function as($path) {
        $location = preg_split('/[\/\\]+/', $path);
        return $this->at(...$location);
    }

    /**
     * mark path.
     * 
     * @param string $mark: mark must start '@'
     * @param string $path: path.
     */
    public function mark($mark, $path) {
        $this->marks[$mark] = $path;
    }

    /**
     * copy file or directory.
     * 
     * @param string $source: source path.
     * @param string $target: target path.
     * @return bool: completed return true.
     */
    public function copy($source, $target) {
        // using mark.
        if ('@' == $source[0]) $source = $this->as($source);
        if ('@' == $target[0]) $target = $this->as($target);

        // copy file.
        if (is_file($source)) return copy($source, $target);

        // copy directory.
        $handle = opendir($source);
        while (false !== ($name = readdir($handle))) {
            if ('.' == $name or '..' == $name) continue;
            $subsource = $source.self::DS.$name;
            $subtarget = $target.self::DS.$name;
            if (!$this->copy($subsource, $subtarget)) return false;
        }
        closedir($handle);
        return true;
    }

    /**
     * remove file or directory.
     * 
     * @param string $path: path.
     * @return bool: completed return true.
     */
    public function remove($path) {
        // using mark.
        if ('@' == $path[0]) $path = $this->as($path);
        
        // remove file.
        if (is_file($path)) return unlink($path);

        // remove directory.
        $handle = opendir($path);
        while (false !== ($name = readdir($handle))) {
            if ('.' == $name or '..' == $name) continue;
            if (!$this->remove($path.self::DS.$name)) return false;
        }
        closedir($handle);
        return rmdir($path);
    }
}