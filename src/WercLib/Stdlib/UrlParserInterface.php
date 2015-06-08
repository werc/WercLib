<?php
namespace WercLib\Stdlib;

use Zend\Http\PhpEnvironment\Request;

interface UrlParserInterface
{

    /**
     *
     * @param Request $request            
     */
    public function setRequest(Request $request);

}

