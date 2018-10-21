<?php namespace palex\http;

/**
 * 
 */
class Request {
    private $headers;

    /**
     * 
     */
    public function __construct() {
        $this->headers = [
            'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)',
        ];
    }

    /**
     * 
     */
    public function get($url) {
        $handle = curl_init();
        if (false !== $handle) try {
            curl_setopt($handle, CURLOPT_URL, $url);
            foreach ($this->headers as $header) {
                curl_setopt($handle, CURLOPT_HEADER, $header);
            }
            return curl_exec($handle);
        }
        finally {
            curl_close($handle);
        }
    }
}