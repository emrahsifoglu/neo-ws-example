<?php
namespace AppBundle\Document\Neo;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;

/**
 *
 * @MongoDB\Document
 * @MongoDB\UniqueIndex(keys={"reference"="asc", "date"="asc"})
 * @MongoDB\Document(repositoryClass="NeoRepository")
 *
 * @codeCoverageIgnore
 */
class Neo
{
    /**
     * @MongoDB\Id
     * @Exclude
     *
     * @return string
     */
    private $id;

    /**
     * @MongoDB\Field(type="date")
     * @Type("DateTime<'Y-m-d'>")
     *
     * @var \DateTime
     */
    private $date;

    /**
     * @MongoDB\Field(type="string")
     * @Type("string")
     *
     * @var string
     */
    private $reference;

    /**
     * @MongoDB\Field(type="string")
     * @Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     * @Type("string")
     *
     * @var string
     */
    private $speed;

    /**
     * @MongoDB\Field(type="boolean")
     * @Type("boolean")
     *
     * @var bool
     */
    private $isHazardous;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return $this
     */
    public function setDate(DateTime $date) {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference() {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference($reference) {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpeed() {
        return $this->speed;
    }

    /**
     * @param string $speed
     * @return $this
     */
    public function setSpeed($speed) {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHazardous() {
        return $this->isHazardous;
    }

    /**
     * @param bool $isHazardous
     * @return $this
     */
    public function setIsHazardous($isHazardous) {
        $this->isHazardous = $isHazardous;
        return $this;
    }

}
