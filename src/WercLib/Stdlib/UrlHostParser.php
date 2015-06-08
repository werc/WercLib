<?php
namespace WercLib\Stdlib;

use Zend\Http\PhpEnvironment\Request;
use WercLib\Stdlib\UrlParserInterface;

class UrlHostParser implements UrlParserInterface
{

    /**
     * jazykova verze
     *
     * @var string
     */
    protected $lang = '';

    /**
     * config
     */
    private $config;

    public function getLang()
    {
        return $this->lang;
    }

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
        $httpRequest = $request->getUri();
        
        $this->parseHost($httpRequest->getHost());
    }

    /**
     * @param string $host, na serveru je tvaru www.werc.cz
     * @throws \Exception
     */
    private function parseHost($host)
    {
        if (array_key_exists('hostlanguages', $this->config)) {
            $hosts = $this->config['hostlanguages'];
            if (isset($hosts[$host])) {
                $this->lang = $hosts[$host];
            } else {
                $this->lang = $this->config['languages'][0];
            }
        } else {
            throw new \Exception('The hostlanguages key not found in config.');
        }
    }
}
