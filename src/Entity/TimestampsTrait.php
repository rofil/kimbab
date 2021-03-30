<?php 
namespace App\Entity;

trait TimestampsTrait {

    /**
     * @ORM\PreFlush
     */
    public function onFlush()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PrePersist
     */
    public function onPersist()
    {
        $this->setCreatedAt(new \DateTime());
    }
}