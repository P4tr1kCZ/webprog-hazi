<?php
class Client
{
    public function __construct()
    {
        $params = array(
            'location' => 'http://localhost/soap/server.php',
            'uri' => 'urn://soap/server.php',
            'trace' => 1
        );
        $this->instance = new SoapClient(NULL, $params);
    }

    public function getName($id)
    {
        return $this->instance->__soapCall("getUserName", $id);
    }
}

$client = new Client();
