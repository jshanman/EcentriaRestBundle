<?php
/*
 * This file is part of the ecentria group, inc. software.
 *
 * (c) 2015, ecentria group, inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecentria\Libraries\EcentriaRestBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Ecentria\Libraries\EcentriaRestBundle\Model\Configuration;

use Symfony\Component\Routing\Route,
    Symfony\Component\Routing\Router;

use Ecentria\Libraries\EcentriaRestBundle\Services\MessageManager;

/**
 * Configuration manager
 *
 * @author Sergey Chernecov <sergey.chernecov@intexsys.lv>
 */
class ConfigurationManager
{
    /**
     * Router
     *
     * @var Router
     */
    private $router;

    /**
     * Message Manager
     *
     * @var MessageManager
     */
    private $messageManager;

    /**
     * Constructor
     *
     * @param Router $router
     * @param MessageManager $messageManager
     */
    public function __construct(Router $router, MessageManager $messageManager)
    {
        $this->router = $router;
        $this->messageManager = $messageManager;
    }

    /**
     * Get configuration
     *
     * @return Configuration
     */
    public function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setRoutes($this->getRoutes());
        $configuration->setMessageListenerKeys($this->getMessageListenerKeys());
        return $configuration;
    }

    /**
     * Getting routes
     *
     * @return ArrayCollection
     */
    private function getRoutes()
    {
        $routeCollection = $this->router->getRouteCollection();
        $routes = new ArrayCollection();
        foreach ($routeCollection as $name => $route) {
            if ($route instanceof Route) {
                $options = $route->getOptions();
                if (isset($options['expose']) && $options['expose'] === true) {
                    $methods = $route->getMethods();
                    $routes->set(
                        $name,
                        array(
                            'method'  => reset($methods),
                            'pattern' => $route->getPath(),
                        )
                    );
                }
            }
        }
        return $routes;
    }

    /**
     * Getting message listener keys
     *
     * @return ArrayCollection
     */
    private function getMessageListenerKeys()
    {
        return $this->messageManager->getListenerDomainKeys();

    }
}
