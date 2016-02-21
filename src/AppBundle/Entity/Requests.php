<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requests
 *
 * @ORM\Table(name="requests")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RequestsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Requests
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
     * @ORM\Column(name="type", type="integer")
     */
    private $type;
    
    /**
     * @var int
     *
     * @ORM\Column(name="blood_group", type="integer")
     */
    private $bloodGroup;

    /**
     * @var int
     *
     * @ORM\Column(name="qty", type="smallint")
     */
    private $qty;

    /**
     * @var string
     *
     * @ORM\Column(name="patient_name", type="string", length=128)
     */
    private $patientName;

    /**
     * @var int
     *
     * @ORM\Column(name="within_hours", type="smallint")
     */
    private $withinHours;
    
    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
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
     * @ORM\ManyToOne(targetEntity="Hospitals")
     * @ORM\JoinColumn(name="hospital_id", referencedColumnName="id")
     */
    protected $hospital;


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
     * Set type
     *
     * @param integer $type
     *
     * @return Requests
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Requests
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set patientName
     *
     * @param string $patientName
     *
     * @return Requests
     */
    public function setPatientName($patientName)
    {
        $this->patientName = $patientName;

        return $this;
    }

    /**
     * Get patientName
     *
     * @return string
     */
    public function getPatientName()
    {
        return $this->patientName;
    }

    /**
     * Set withinHours
     *
     * @param integer $withinHours
     *
     * @return Requests
     */
    public function setWithinHours($withinHours)
    {
        $this->withinHours = $withinHours;

        return $this;
    }

    /**
     * Get withinHours
     *
     * @return int
     */
    public function getWithinHours()
    {
        return $this->withinHours;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Requests
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
     * @return Requests
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
     * Set hospital
     *
     * @param \AppBundle\Entity\Hospitals $hospital
     *
     * @return Requests
     */
    public function setHospital(\AppBundle\Entity\Hospitals $hospital = null)
    {
        $this->hospital = $hospital;

        return $this;
    }

    /**
     * Get hospital
     *
     * @return \AppBundle\Entity\Hospitals
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Requests
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
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

    /**
     * Set bloodGroup
     *
     * @param integer $bloodGroup
     *
     * @return Requests
     */
    public function setBloodGroup($bloodGroup)
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    /**
     * Get bloodGroup
     *
     * @return integer
     */
    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }
}
