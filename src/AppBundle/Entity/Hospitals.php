<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Hospitals
 *
 * @ORM\Table(name="hospitals")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HospitalsRepository")
 * @UniqueEntity("phno")
 */
class Hospitals implements UserInterface
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
     * @var string
     *
     * @ORM\Column(name="phno", type="string", length=10)
     */
    private $phno;

    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="decimal", precision=15, scale=6)
     */
    private $latitude;

   /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="decimal", precision=15, scale=6)
     */
    private $longitude;


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
     * @return Hospitals
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
     * Set phno
     *
     * @param string $phno
     *
     * @return Hospitals
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
     * Set latitude
     *
     * @param integer $latitude
     *
     * @return Hospitals
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return int
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param integer $longitude
     *
     * @return Hospitals
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return int
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
    	return $this->phno;
    }
    
    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
    	$this->salt = $salt;
    
    	return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function getSalt()
    {
    	return null;
    }
    
    /**
     * @inheritDoc
     */
    public function getPassword()
    {
    	return null;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
    	return array('ROLE_HOSPITAL');
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
}
