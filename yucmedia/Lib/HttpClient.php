<?php

/* Version 0.9, 6th April 2003 - Simon Willison ( http://simon.incutio.com/ )
  Manual: http://scripts.incutio.com/httpclient/
 */

class HttpClient {

    // Request protecteds
    protected $host;
    protected $port;
    protected $path;
    protected $method;
    protected $postdata = '';
    protected $cookies = array();
    protected $referer;
    protected $accept = 'text/xml,application/xml,application/xhtml+xml,text/html,text/plain,image/png,image/jpeg,image/gif,*/*';
    protected $accept_encoding = 'gzip';
    protected $accept_language = 'en-us';
    protected $user_agent = 'Incutio HttpClient v0.9';
    // Options
    protected $timeout = 10;
    protected $use_gzip = TRUE;
    protected $persist_cookies = TRUE;  // If true, received cookies are placed in the $this->cookies array ready for the next request
    // Note: This currently ignores the cookie path (and time) completely. Time is not important,
    // but path could possibly lead to security problems.
    protected $persist_referers = TRUE; // For each request, sends path of last request as referer
    protected $handle_redirects = TRUE; // Auaomtically redirect if Location or URI header is found
    protected $max_redirects = 5;
    protected $headers_only = FALSE;    // If true, stops receiving once headers have been read.
    // Basic authorization protectediables
    protected $username;
    protected $password;
    // Response protecteds
    protected $status;
    protected $headers = array();
    protected $content = '';
    protected $errormsg;
    // Tracker protectediables
    protected $redirect_count = 0;
    protected $cookie_host = '';

    /**
     *
     * @param type $host
     * @param int|\type $port
     */
    public function __construct($host, $port = 80) {
        $this->host = $host;
        $this->port = $port;
    }

    public function get($path, $data = FALSE) {
        $this->path = $path;
        $this->method = 'GET';
        if ($data) {
            $this->path .= '?' . $this->buildQueryString($data);
        }
        return $this->doRequest();
    }

    /**
     *  POST 请求
     * @param type $path
     * @param type $data
     * @return type
     */
    public function post($path, $data) {
        $this->path = $path;
        $this->method = 'POST';
        $this->postdata = $this->buildQueryString($data);
        return $this->doRequest();
    }

    /**
     *
     * @param type $data
     * @return type
     */
    public function buildQueryString($data) {
        $querystring = '';
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $val2) {
                        $querystring .= urlencode($key) . '=' . urlencode($val2) . '&';
                    }
                } else {
                    $querystring .= urlencode($key) . '=' . urlencode($val) . '&';
                }
            }
            $querystring = substr($querystring, 0, -1); // Eliminate unnecessary &
        } else {
            $querystring = $data;
        }
        return $querystring;
    }

    public function doRequest() {
        // Performs the actual HTTP request, returning true or false depending on outcome
        if (!$fp = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout)) {
            // Set error message
            switch ($errno) {
                case -3:
                    $this->errormsg = 'Socket creation failed (-3)';
                case -4:
                    $this->errormsg = 'DNS lookup failure (-4)';
                case -5:
                    $this->errormsg = 'Connection refused or timed out (-5)';
                default:
                    $this->errormsg = 'Connection failed (' . $errno . ')';
                    $this->errormsg .= ' ' . $errstr;
            }
            return FALSE;
        }
        socket_set_timeout($fp, $this->timeout);
        $request = $this->buildRequest();
        fwrite($fp, $request);
        // Reset all the protectediables that should not persist between requests
        $this->headers = array();
        $this->content = '';
        $this->errormsg = '';
        // Set a couple of flags
        $inHeaders = TRUE;
        $atStart = TRUE;
        // Now start reading back the response
        while (!feof($fp)) {
            $line = fgets($fp, 4096);
            if ($atStart) {
                // Deal with first line of returned data
                $atStart = FALSE;
                if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
                    $this->errormsg = "Status code line invalid: " . htmlentities($line);
                    return FALSE;
                }
                $http_version = $m[1]; // not used
                $this->status = $m[2];
                $status_string = $m[3]; // not used
                continue;
            }
            if ($inHeaders) {
                if (trim($line) == '') {
                    $inHeaders = FALSE;
                    if ($this->headers_only) {
                        break; // Skip the rest of the input
                    }
                    continue;
                }
                if (!preg_match('/([^:]+):\\s*(.*)/', $line, $m)) {
                    // Skip to the next header
                    continue;
                }
                $key = strtolower(trim($m[1]));
                $val = trim($m[2]);
                // Deal with the possibility of multiple headers of same name
                if (isset($this->headers[$key])) {
                    if (is_array($this->headers[$key])) {
                        $this->headers[$key][] = $val;
                    } else {
                        $this->headers[$key] = array($this->headers[$key], $val);
                    }
                } else {
                    $this->headers[$key] = $val;
                }
                continue;
            }
            // We're not in the headers, so append the line to the contents
            $this->content .= $line;
        }
        fclose($fp);
        // If data is compressed, uncompress it
        if (isset($this->headers['content-encoding']) && $this->headers['content-encoding'] == 'gzip') {
            $this->content = substr($this->content, 10);
            $this->content = gzinflate($this->content);
        }
        // If $persist_cookies, deal with any cookies
        if ($this->persist_cookies && isset($this->headers['set-cookie']) && $this->host == $this->cookie_host) {
            $cookies = $this->headers['set-cookie'];
            if (!is_array($cookies)) {
                $cookies = array($cookies);
            }
            foreach ($cookies as $cookie) {
                if (preg_match('/([^=]+)=([^;]+);/', $cookie, $m)) {
                    $this->cookies[$m[1]] = $m[2];
                }
            }
            // Record domain of cookies for security reasons
            $this->cookie_host = $this->host;
        }
        // If $persist_referers, set the referer ready for the next request
        if ($this->persist_referers) {
            $this->referer = $this->getRequestURL();
        }
        // Finally, if handle_redirects and a redirect is sent, do that
        if ($this->handle_redirects) {
            if (++$this->redirect_count >= $this->max_redirects) {
                $this->errormsg = 'Number of redirects exceeded maximum (' . $this->max_redirects . ')';
                $this->redirect_count = 0;
                return FALSE;
            }
            $location = isset($this->headers['location']) ? $this->headers['location'] : '';
            $uri = isset($this->headers['uri']) ? $this->headers['uri'] : '';
            if ($location || $uri) {
                $url = parse_url($location . $uri);
                // This will FAIL if redirect is to a different site
                return $this->get($url['path']);
            }
        }
        return TRUE;
    }

    public function buildRequest() {
        $headers = array();
        $headers[] = "{$this->method} {$this->path} HTTP/1.0"; // Using 1.1 leads to all manner of problems, such as "chunked" encoding
        $headers[] = "Host: {$this->host}";
        $headers[] = "User-Agent: {$this->user_agent}";
        $headers[] = "Accept: {$this->accept}";
        if ($this->use_gzip) {
            $headers[] = "Accept-encoding: {$this->accept_encoding}";
        }
        $headers[] = "Accept-language: {$this->accept_language}";
        if ($this->referer) {
            $headers[] = "Referer: {$this->referer}";
        }
        // Cookies
        if ($this->cookies) {
            $cookie = 'Cookie: ';
            foreach ($this->cookies as $key => $value) {
                $cookie .= "$key=$value; ";
            }
            $headers[] = $cookie;
        }
        // Basic authentication
        if ($this->username && $this->password) {
            $headers[] = 'Authorization: BASIC ' . base64_encode($this->username . ':' . $this->password);
        }
        // If this is a POST, set the content type and length
        if ($this->postdata) {
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $headers[] = 'Content-Length: ' . strlen($this->postdata);
        }
        $request = implode("\r\n", $headers) . "\r\n\r\n" . $this->postdata;
        return $request;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getContent() {
        return $this->content;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getHeader($header) {
        $header = strtolower($header);
        if (isset($this->headers[$header])) {
            return $this->headers[$header];
        } else {
            return FALSE;
        }
    }

    public function getError() {
        return $this->errormsg;
    }

    public function getCookies() {
        return $this->cookies;
    }

    public function getRequestURL() {
        $url = 'http://' . $this->host;
        if ($this->port != 80) {
            $url .= ':' . $this->port;
        }
        $url .= $this->path;
        return $url;
    }

    // Setter methods
    public function setUserAgent($string) {
        $this->user_agent = $string;
    }

    public function setAuthorization($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function setCookies($array) {
        $this->cookies = $array;
    }

    // Option setting methods
    public function useGzip($boolean) {
        $this->use_gzip = $boolean;
    }

    public function setPersistCookies($boolean) {
        $this->persist_cookies = $boolean;
    }

    public function setPersistReferers($boolean) {
        $this->persist_referers = $boolean;
    }

    public function setHandleRedirects($boolean) {
        $this->handle_redirects = $boolean;
    }

    public function setMaxRedirects($num) {
        $this->max_redirects = $num;
    }

    public function setHeadersOnly($boolean) {
        $this->headers_only = $boolean;
    }

    public function setTimeout($timeout) {
        $this->timeout = $timeout;
    }

    // "Quick" static methods
    public function quickGet($url) {
        $bits = parse_url($url);
        $host = $bits['host'];
        $port = isset($bits['port']) ? $bits['port'] : 80;
        $path = isset($bits['path']) ? $bits['path'] : '/';
        if (isset($bits['query'])) {
            $path .= '?' . $bits['query'];
        }
        $client = new HttpClient($host, $port);
        if (!$client->get($path)) {
            return FALSE;
        } else {
            return $client->getContent();
        }
    }

    public function quickPost($url, $data) {
        $bits = parse_url($url);
        $host = $bits['host'];
        $port = isset($bits['port']) ? $bits['port'] : 80;
        $path = isset($bits['path']) ? $bits['path'] : '/';
        $client = new HttpClient($host, $port);
        if (!$client->post($path, $data)) {
            return FALSE;
        } else {
            return $client->getContent();
        }
    }

}

