<?php
/*
 * This file is part of the ecentria group, inc. software.
 *
 * (c) 2015, ecentria group, inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecentria\Libraries\EcentriaRestBundle\Consumer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use  Ecentria\Libraries\EcentriaRestBundle\Services\MessageManager;

/**
 * Message Consumer
 * Responsibility: Convert amqp message to symfony Message Event, and send it to the MessageManager to dispatch to
 * subscribed callbacks
 *
 * @copyright   2015 OpticsPlanet, Inc
 * @author      Eugene Boiarynov <ievgen.boiarynov@opticsplanet.com>
 */
class MessageConsumer implements ConsumerInterface
{
    /**
     * Message Manager
     *
     * @var MessageManager
     */
    private $messageManager;


    public function __construct(MessageManager $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    /**
     * Execute
     *
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        $rawMessage = json_decode($msg->body);
        $message = $this->messageManager->createMessageFromData($rawMessage);
        $this->messageManager->dispatchMessage($message);
        return true;
    }

}