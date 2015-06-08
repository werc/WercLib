<?php
namespace WercLib\Service\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\AdapterAwareInterface;

/**
 * Model ktery bude implementovat 
 * AdapterAwareInterface
 * bude mit incicalizovany adpater.
 * Nemusim delat pres factory.
 * 
 * @author Tomas
 *
 */
class Db implements InitializerInterface
{

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof AdapterAwareInterface) {
            $instance->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
        }
    }
}