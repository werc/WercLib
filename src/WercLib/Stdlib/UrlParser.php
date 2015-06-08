<?php
namespace WercLib\Stdlib;

/**
 * Rozklada url a vraci potrebne casti
 */
use Zend\Http\PhpEnvironment\Request;
use WercLib\Stdlib\UrlParserInterface;

class UrlParser implements UrlParserInterface
{

    public $request = null;

    /**
     * Nazev stranky v url rodice.
     *
     * @var string
     */
    public $parentUrl = 'uvod';

    /**
     * Nazev stranky v url, podle ktereho se bude hledat
     * v databazi.
     *
     * @var string
     */
    public $targetPageUrl = 'uvod';

    /**
     * Url bez cisla stranky
     *
     * @var string
     */
    public $filteredUrl = '';

    /**
     * Jazykova verze url
     *
     * @var string
     */
    protected $lang = '';

    /**
     * Obsahuje hodnotu url jazykove verze, u vychozi je prazdny.
     */
    public $langUrl = '';

    /**
     * Obsahuje casti url
     */
    private $urlParts = array();

    /**
     * Pole configu
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
        $httpRequest = $request->getUri();
        
        $this->parsePath($httpRequest->getPath());
    }

    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Vraci url rodice, jinak empty
     */
    public function getParentUrl()
    {
        return $this->parentUrl;
    }

    /**
     * Vraci celou url http requestu bez id stranky
     * /page/page/2 => /page/page
     */
    public function getFilteredUrl()
    {
        return $this->filteredUrl;
    }

    /**
     * Vraci url cilove stranky pro vyhledani v db
     */
    public function getTargetPageUrl()
    {
        return $this->targetPageUrl;
    }

    private function filterHost($httpHost)
    {}

    /**
     * Rozcupuje url k dalsimu zpracovani
     *
     * @param string $httpUrl            
     */
    private function parsePath($httpUrl)
    {
        $url = '';
        $parsedUrl = parse_url($httpUrl);
        $this->urlParts = explode('/', trim($parsedUrl['path'], '/'));
        
        // zjisteni jazykove verze
        $this->setLang();
        
        // neni uvodni strana bez jazyku
        if (strlen($parsedUrl['path']) > 1) {
            
            $pocetCastiUrl = count($this->urlParts);
            $lastUrlPart = end($this->urlParts);
            $keyPozice = 0;
            if ($this->isLangInUrl($this->lang)) {
                $keyPozice = 1;
            }
            
            // ma cislo stranky na konci
            if (is_numeric($lastUrlPart)) {
                $pocetCastiUrl --;
                if (isset($this->urlParts[($pocetCastiUrl - 1)])) {
                    if ($pocetCastiUrl == 1 && $keyPozice == 1) { // napr. /en/1
                        $this->targetPageUrl = 404;
                    } else {
                        $this->targetPageUrl = $this->urlParts[($pocetCastiUrl - 1)];
                    }
                } else {
                    // osetreni zada napr. home.cz/12
                    $this->targetPageUrl = 404;
                }
            } else {
                // neni to jazyk
                if ($pocetCastiUrl == 1 && $keyPozice == 0) {
                    $this->targetPageUrl = $lastUrlPart;
                    // je to jazyk, uvod patricne jazykove verze
                } elseif ($pocetCastiUrl == 1 && $keyPozice == 1) {
                    $this->targetPageUrl = 'uvod';
                } else {
                    $this->targetPageUrl = $lastUrlPart;
                }
            }
            
            $sep = '/';
            for ($i = 1; $i <= $pocetCastiUrl; $i ++) {
                $url .= $sep . $this->urlParts[$i - 1];
            }
            
            // pocet casti ma pocet ne od 0
            if (isset($this->urlParts[($pocetCastiUrl - 1) - 1])) {
                $this->parentUrl = $this->urlParts[($pocetCastiUrl - 1) - 1];
                if ($this->parentUrl == $this->lang) {
                    $this->parentUrl = 'uvod';
                }
            }
        }
        
        $this->filteredUrl = $url;
    }

    /**
     * Zjistuje zda je v url nejaky z jazyku
     *
     * @param string $lang            
     * @return boolean
     */
    protected function isLangInUrl($lang)
    {
        if (! empty($this->urlParts[0]) && ($this->urlParts[0] == $lang)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Zjistuje platnou jazykovou verzi z url.
     * Zapise do langUrl a session.
     */
    protected function setLang()
    {
        $this->lang = '';
        foreach ($this->config['languages'] as $key => $lang) {
            if ($this->isLangInUrl($lang)) {
                $this->lang = $lang;
            }
        }
        if (empty($this->lang)) {
            $this->lang = $this->config['languages'][0];
        }
    }
}
