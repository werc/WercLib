<?php
namespace WercLib\View\Helper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use WercLib\View\Helper\FlashMessages;

class FlashMessagesFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $helpers)
    {
        $controllerPlugins = $helpers->getServiceLocator()->get('ControllerPluginManager');
        
        $helper = new FlashMessages();
        return $helper->setFlashMessenger($controllerPlugins->get('flashmessenger'));
    }
}
