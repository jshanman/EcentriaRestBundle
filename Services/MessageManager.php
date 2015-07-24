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

use Ecentria\Libraries\EcentriaRestBundle\Model\Message,
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
class MessageManager {

    const EVENT_PREFIX = 'domain.';

    private $dispatcher = null;
    private $adapter = null;


    public function __construct(EventDispatcherInterface $dispatcher, $adapter = null) {
        $this->dispatcher = $dispatcher;
        $this->adapter = $adapter;
    }

    public function dispatchMessage(Message $message) {
        $event = $this->getEventObject();
        $event->setMessage($message);
        $this->dispatcher->dispatch(self::EVENT_PREFIX.$message->getSource(),$event);
    }

    public function getMessageEventObject() {
        return new MessageEvent();
    }

    public function getListeners() {
        $all_listeners = $this->dispatcher->getListeners();

        foreach ($all_listeners as $listener_by_event) {
            foreach ($listener_by_event as $listener_details) {
                $event_name = $listener_details[1];
                ld($event_name);
            }
        }

    }

} 