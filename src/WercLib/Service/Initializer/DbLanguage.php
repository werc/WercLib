<?php
namespace WercLib\Service\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WercLib\Db\LanguageInterface;
use Zend\Session;

class DbLanguage implements InitializerInterface
{

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof LanguageInterface) {
            
            $request = $serviceLocator->get('request');
            $uri = $request->getUri();            
            $path = $uri->getPath();
            $urlParts = explode('/', $path);
            
            //z jakeho kontaineru vezmu session language
            if(isset($urlParts[1]) && $urlParts[1] == 'racek') {
                $containerName = 'racek';
            } else {
                $containerName = 'api';
            }
            
            $session = new Session\Container($containerName);
            $language = $session->offsetGet('language');
            
            $instance->setLanguage($language);
        }
    }
}
