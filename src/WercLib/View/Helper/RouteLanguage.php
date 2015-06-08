<?php
namespace WercLib\View\Helper;

use Zend\View\Helper\AbstractHelper;

class RouteLanguage extends AbstractHelper
{

    protected $language;

    public function __invoke()
    {
    	return $this->language;
    }

    public function append($language)
    {
        $this->language = $language;
    }
}
