<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hospitals
 *
 * @ORM\Table(name="hospitals")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HospitalsRepository")
 */
class Hospitals
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
}
