<?php
/*
 * This file is part of the ecentria group, inc. software.
 *
 * (c) 2015, ecentria group, inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecentria\Libraries\EcentriaRestBundle\Event;

use Symfony\Component\EventDispatcher\Event,
    Ecentria\Libraries\EcentriaRestBundle\Model\Message;

/**
 * Message Model
 *
 * Responsibility: defines a symfony event that contains a message object, used with the MessageManger service
 *
 * @author Justin Shanks <justin.shanks@opticsplanet.com>
 */
class MessageEvent extends Event {

    /**
     * Message
     *
     * @var Message
     */
    private $message;

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

} 