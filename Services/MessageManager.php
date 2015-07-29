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

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    \Symfony\Component\DependencyInjection\ContainerInterface,
    Ecentria\Libraries\EcentriaRestBundle\Model\Message,
    Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Ecentria\Libraries\EcentriaRestBundle\Event\MessageEvent;

/**
 * Message Manager Service
 *
 * Responsibility: Manages creation, sending, and receiving interfaces, and aggregation of domain messages.
 * - triggers symfony event from message
 * - produces list of all routing keys this api should listen on, meant to publish to bindings using adapter
 *
 * @author Justin Shanks <justin.shanks@opticsplanet.com>
 */
class MessageManager implements ContainerAwareInterface {

    /**
     * DI Container object
     *
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * Symfony Event Dispatcher
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     *
     */
    private $dispatcher = null;

    /**
     * AMQP Adapter
     *
     * @var mixed
     *
     */
    private $adapter = null;

    /**
     * Constructor
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param mixed $adapter
     *
     */
    public function __construct(EventDispatcherInterface $dispatcher, $adapter = null)
    {
        $this->dispatcher = $dispatcher;
        $this->adapter = $adapter;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Creates a message object based on a domain message
     *
     * @param array $data the input data
     *
     * @return \Ecentria\Libraries\EcentriaRestBundle\Model\Message
     */
    public function createMessageFromData($data)
    {
        $message = $this->getMessageObject();
        foreach ($data as $key => $val) {
            $setMethod = 'set'.$key;
            if (method_exists($message,$setMethod))
            {
                $message->$setMethod($val);
            }
            else
            {
                // @todo check config value option to either ignore invalid properties or throw an exception
            }
        }
        return $message;
    }

    /**
     * Converts a message to a MessageEvent and dispatches it
     *
     * @param \Ecentria\Libraries\EcentriaRestBundle\Model\Message $message the input data
     *
     */
    public function dispatchMessage(Message $message)
    {
        $event = $this->getMessageEventObject();
        $event->setMessage($message);
        $this->dispatcher->dispatch($this->getMessagePrefix().$message->getSource(),$event);

    }

    /**
     * returns the message object to use, overload to alter this. @todo setup interface for this
     *
     * @return \Ecentria\Libraries\EcentriaRestBundle\Model\Message
     *
     */
    public function getMessageObject()
    {
        return new Message();
    }

    /**
     * returns the message event object to use, overload to alter this. @todo setup interface for this
     *
     * @return  \Ecentria\Libraries\EcentriaRestBundle\Event\MessageEvent
     *
     */
    public function getMessageEventObject()
    {
        return new MessageEvent();
    }

    /**
     * returns all the listeners in the app that are listening to domain messages
     *
     * @return array returns array of listener details (name and callback reference) by event key
     *
     */
    public function getInternalEventListeners() {
        $all_listeners = $this->dispatcher->getListeners();


        $domain_listeners = array();
        $prefix = $this->getMessagePrefix();
        $prefix_length = strlen($prefix);
        foreach ($all_listeners as $event_name => $listener_by_event) {

            // if this event key is a domain message
            if (substr($event_name,0,$prefix_length) === $prefix) {
                $domain_listeners[$event_name] = $listener_by_event;
            }

        }
        return $domain_listeners;
    }

    /**
     * returns the list of domain events keys that this app is listening too
     *
     * @return array returns array of event keys that start with the configured prefix
     *
     */
    public function getListenerDomainKeys()
    {
        $domain_listeners = $this->getInternalEventListeners();
        $keys = array();

        $prefix = $this->getMessagePrefix();
        $prefix_length = strlen($prefix);

        foreach ($domain_listeners as $key => $listener)
        {
            $keys[] = substr($key,($prefix_length));
        }
        return $keys;
    }

    /**
     * returns the injected dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     *
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * returns the configured prefix for domain messages (which should include the trailing dot "."
     *
     * @return string
     *
     */
    public function getMessagePrefix()
    {
        $config = $this->container->getParameter('ecentria_rest.config');
        return $config['domain_message_prefix'];
    }

} 