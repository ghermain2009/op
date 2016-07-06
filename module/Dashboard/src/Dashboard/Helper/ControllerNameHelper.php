<?php
/**
 * Description of routesHelper
 *
 * @author fragote
 */

namespace Dashboard\Helper;

use Zend\View\Helper\AbstractHelper;

class ControllerNameHelper extends AbstractHelper
{

protected $routeMatch;

    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function __invoke()
    {
        if ($this->routeMatch) {
            $controller = $this->routeMatch->getParam('controller', 'index');
            return $controller;
        }
    }
}