<?php


namespace Mabes\Core\CommonBehaviour;

/**
 * Class Timestampable
 * @package Mabes\Entity
 */
trait Timestampable
{
    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @PrePersist
     * @return void
     */
    public function timestampableCreateEvent()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    /**
     * @PreUpdate
     * @return void
     */
    public function timestampableUpdateEvent()
    {
        $this->updated_at = new \DateTime();
    }
}

// EOF
