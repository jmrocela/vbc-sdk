<?php

namespace Vbc;

use Guzzlehttp;

class Client
{

    protected $baseUrl = 'https://{subdomain}.howlovely.co/{version}';

    protected $client;

    public function __construct($config = [])
    {
        $this->client = new GuzzleHttp\Client([
            'base_url' => [$baseUrl, ['subdomain' => 'api', 'version' => 'v1']],
            'defaults' => [
                'headers' => [
                    'X-App-Key' => $config['AppKey'],
                    'X-Secret-Key' => $config['SecretKey']
                ]
            ]
        ]);
    }

    public static function getInstance($config = [])
    {
        static $instance;
        if (get_class($instance) !== 'Client') {
            return new Client($config);
        }
        return $instance;
    }

    public function getConnection()
    {
        $this->client->isMobile = $this->isMobile($_SERVER["HTTP_USER_AGENT"]);
        return $this->client;
    }

    private function isMobile($ua) {
        preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $ua);
    }

}