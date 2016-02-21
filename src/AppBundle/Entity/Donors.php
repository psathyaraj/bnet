<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donors
 *
 * @ORM\Table(name="donors")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DonorsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Donors
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Requests")
     * @ORM\JoinColumn(name="request_id", referencedColumnName="id")
     */
    protected $request;
    
    /**
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Donors
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Donors
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Donors
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set request
     *
     * @param \AppBundle\Entity\Requests $request
     *
     * @return Donors
     */
    public function setRequest(\AppBundle\Entity\Requests $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return \AppBundle\Entity\Requests
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Users $user
     *
     * @return Donors
     */
    public function setUser(\AppBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
    	$this->setUpdatedAt(new \DateTime('now'));
    
    	if ($this->getCreatedAt() == null) {
    		$this->setCreatedAt(new \DateTime('now'));
    	}
    }
}
