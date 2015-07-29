<?php
/*
 * This file is part of the ecentria group, inc. software.
 *
 * (c) 2015, ecentria group, inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecentria\Libraries\EcentriaRestBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Collection Response
 *
 * @author Sergey Chernecov <sergey.chernecov@intexsys.lv>
 */
class Configuration
{
    /**
     * Routes
     *
     * @var ArrayCollection
     */
    private $routes;

    /**
     * MessageListenerKeys
     *
     * @var ArrayCollection
     */
    private $messageListenerKeys;

    /**
     * Routes setter
     *
     * @param ArrayCollection $routes
     *
     * @return Configuration
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
        return $this;
    }

    /**
     * Routes getter
     *
     * @return ArrayCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * MessageListenerKeys setter
     *
     * @param ArrayCollection $keys
     *
     * @return Configuration
     */
    public function setMessageListenerKeys($keys)
    {
        $this->messageListenerKeys = $keys;
        return $this;
    }

    /**
     * MessageListenerKeys getter
     *
     * @return ArrayCollection
     */
    public function getMessageListenerKeys()
    {
        return $this->messageListenerKeys;
    }


}
