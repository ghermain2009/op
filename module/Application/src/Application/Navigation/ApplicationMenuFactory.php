<?php
/**
 * Description of DashboardMenuFactory
 *
 * @author fragote
 */

namespace Application\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApplicationMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $menu = new ApplicationMenu();
        return $menu->createService($serviceLocator);
    }
}