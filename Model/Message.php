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

/**
 * Message Model
 *
 * Responsibility: defines a valid message object, used with the MessageManger service
 *
 * @author Justin Shanks <justin.shanks@opticsplanet.com>
 */
class Message
{
    /**
     * Message id
     *
     * Primary identifier
     * @var string|int
     */
    private $id;

    /**
     * Message sourceType
     *
     * Identifies the source type of the message.
     * - Data-source means that this message provides details about
     *     a change in the underlying data source of a service.  Date source messages should
     *     only be consumer by the service that is considered the master data manager for that data.
     * - Service-resource means that a related service resource has changed.
     *
     * Possible Values: data-source|service-resource
     * @var string
     */
    private $sourceType;

    /**
     * Message source
     *
     * A period separated path that identifies where the change originated. Example MyAppDb.customerTable.columnName
     * @var string
     */
    private $source;

    /**
     * Message operation
     *
     * create|update|delete
     * @var string
     */
    private $operation;

    /**
     * Message value
     *
     * content of the message (null if delete, new value if update or create). this value is stored as a string and can be anything from an int to serialized data
     * @var string|null
     */
    private $value;

    /**
     * Message operation
     *
     * if delete or or update, this property is expected to have the old value
     * this value is stored as a string and can be anything from an int to serialized data
     * @var string|null
     */
    private $previoueValue;

    /**
     * Message operation datetime
     *
     * the datetime that the operation happened on the source system
     * @var datetime
     */
    private $operationDatetime;

    /**
     * Message datetime
     *
     * the datetime that the message was generated
     * @var datetime
     */
    private $messageDatetime;

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return datetime
     */
    public function getMessageDatetime()
    {
        return $this->messageDatetime;
    }

    /**
     * @param datetime $messageDatetime
     */
    public function setMessageDatetime($messageDatetime)
    {
        $this->messageDatetime = $messageDatetime;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * @return datetime
     */
    public function getOperationDatetime()
    {
        return $this->operationDatetime;
    }

    /**
     * @param datetime $operationDatetime
     */
    public function setOperationDatetime($operationDatetime)
    {
        $this->operationDatetime = $operationDatetime;
    }

    /**
     * @return null|string
     */
    public function getPrevioueValue()
    {
        return $this->previoueValue;
    }

    /**
     * @param null|string $previoueValue
     */
    public function setPrevioueValue($previoueValue)
    {
        $this->previoueValue = $previoueValue;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     */
    public function setSourceType($sourceType)
    {
        $this->sourceType = $sourceType;
    }

    /**
     * @return null|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null|string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}