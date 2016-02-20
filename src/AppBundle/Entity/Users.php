<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("phno")
 */
class Users
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date")
     */
    private $dob;
    
    /**
     * @var int
     *
     * @ORM\Column(name="gender", type="boolean")
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="phno", type="string", length=10, unique=true)
     */
    private $phno;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, unique=true)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="device_token", type="string", length=128)
     */
    private $device_token;

    /**
     * @var int
     *
     * @ORM\Column(name="blood_group", type="integer")
     */
    private $bloodGroup;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;
    
    /**
     * @ORM\OneToMany(targetEntity="Locations", mappedBy="user")
     */
    protected $locations;
    
    /**
     * @ORM\OneToMany(targetEntity="LastDonations", mappedBy="user")
     */
    protected $last_donations;
    
    public function __construct()
    {
    	$this->locations = new ArrayCollection();
    	$this->last_donations =  new ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Users
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set phno
     *
     * @param string $phno
     *
     * @return Users
     */
    public function setPhno($phno)
    {
        $this->phno = $phno;

        return $this;
    }

    /**
     * Get phno
     *
     * @return string
     */
    public function getPhno()
    {
        return $this->phno;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set bloodGroup
     *
     * @param integer $bloodGroup
     *
     * @return Users
     */
    public function setBloodGroup($bloodGroup)
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    /**
     * Get bloodGroup
     *
     * @return int
     */
    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Users
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
     * Set deviceToken
     *
     * @param string $deviceToken
     *
     * @return Users
     */
    public function setDeviceToken($deviceToken)
    {
        $this->device_token = $deviceToken;

        return $this;
    }

    /**
     * Get deviceToken
     *
     * @return string
     */
    public function getDeviceToken()
    {
        return $this->device_token;
    }

    /**
     * Add location
     *
     * @param \AppBundle\Entity\Locations $location
     *
     * @return Users
     */
    public function addLocation(\AppBundle\Entity\Locations $location)
    {
        $this->locations[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \AppBundle\Entity\Locations $location
     */
    public function removeLocation(\AppBundle\Entity\Locations $location)
    {
        $this->locations->removeElement($location);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Add lastDonation
     *
     * @param \AppBundle\Entity\LastDonations $lastDonation
     *
     * @return Users
     */
    public function addLastDonation(\AppBundle\Entity\LastDonations $lastDonation)
    {
        $this->last_donations[] = $lastDonation;

        return $this;
    }

    /**
     * Remove lastDonation
     *
     * @param \AppBundle\Entity\LastDonations $lastDonation
     */
    public function removeLastDonation(\AppBundle\Entity\LastDonations $lastDonation)
    {
        $this->last_donations->removeElement($lastDonation);
    }

    /**
     * Get lastDonations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLastDonations()
    {
        return $this->last_donations;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     *
     * @return Users
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }
}
