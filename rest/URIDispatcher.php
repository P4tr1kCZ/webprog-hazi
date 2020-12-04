<?php

class URIDispatcher
{
    private static $uri_dispatcher = NULL;
    private $mappings = array();
    private $cors;
    private $allowedOrigin;
    private $allowedRequestHeaders;

    public static function getInstance()
    {
        if (self::$uri_dispatcher == NULL) {
            self::$uri_dispatcher = new URIDispatcher();
        }

        return self::$uri_dispatcher;
    }

    public function __construct()
    {
        $this->cors = false;
    }

    public function map($http_method, $url_pattern, $callback, $parse_json_input = true)
    {
        array_push($this->mappings, array(
            "http_method" => $http_method,
            "url_pattern" => $url_pattern,
            "callback" => $callback,
            "parse_json_input" => $parse_json_input
        ));
        return $this;
    }

    public function dispatchRequest()
    {
        $dispatchAsCORS = false;
        $allowedMethods = array();
        foreach ($this->mappings as $mapping) {
            $parameters = array();
            if ($this->match_request(
                $mapping["http_method"],
                $mapping["url_pattern"],
                $parameters
            )) {

                if ($this->cors == true && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                    $dispatchAsCORS = true;
                    array_push($allowedMethods, strtoupper($mapping["http_method"]));
                } else {
                    if (
                        $mapping["parse_json_input"] &&
                        isset($_SERVER['CONTENT_TYPE']) &&
                        strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false
                    ) {

                        array_push($parameters, json_decode(file_get_contents("php://input")));
                    }

                    if ($this->cors == true) {
                        header('Access-Control-Allow-Origin: ' . $this->allowedOrigin);
                    }
                    call_user_func_array($mapping["callback"], $parameters);
                    return true;
                }
            }
        }

        if ($dispatchAsCORS) {
            header('Access-Control-Allow-Origin: ' . $this->allowedOrigin);
            header('Access-Control-Allow-Headers:' . $this->allowedRequestHeaders);
            header('Access-Control-Allow-Methods: ' . implode(',', $allowedMethods) . ',OPTIONS');
            return true;
        }

        return false;
    }

    public function enableCORS($allowedOrigin, $allowedRequestHeaders)
    {
        $this->cors = true;
        $this->allowedOrigin = $allowedOrigin;
        $this->allowedRequestHeaders = $allowedRequestHeaders;
    }

    private function match_request($http_method, $url_pattern, &$matched_parameters = array())
    {
        $path = substr(
            $_SERVER['REQUEST_URI'],
            strlen($_SERVER['PHP_SELF']) - strlen(basename($_SERVER['PHP_SELF'])) - 1
        );
        $path = parse_url($path)['path'];
        if (
            $_SERVER['REQUEST_METHOD'] != strtoupper($http_method) &&
            ($this->cors == false || $_SERVER['REQUEST_METHOD'] != 'OPTIONS')
        ) {
            return false;
        }
        $pathTokens = explode("/", $path);
        $patternTokens = explode("/", $url_pattern);

        if (sizeof($pathTokens) != sizeof($patternTokens)) {
            return false;
        }

        $i = 0;
        $matched_parameters = array();
        for ($i = 0; $i < sizeof($pathTokens); $i++) {
            if ($pathTokens[$i] != $patternTokens[$i]) {
                if (preg_match('/\$([0-9]+?)/', $patternTokens[$i], $matches) == 1) {
                    $matched_parameters[$matches[1]] = $pathTokens[$i];
                } else {
                    return false;
                }
            }
        }

        if (sizeof($matched_parameters) > 0) {
            ksort($matched_parameters);
        }
        return true;
    }
}
