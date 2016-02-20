<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LastDontations
 *
 * @ORM\Table(name="last_donations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LastDonationsRepository")
 */
class LastDonations
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
     * @var \DateTime
     *
     * @ORM\Column(name="donation_date", type="datetime")
     */
    private $donationDate;
    
    /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="last_donations")
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
     * Set type
     *
     * @param integer $type
     *
     * @return LastDontations
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
     * Set donationDate
     *
     * @param \DateTime $donationDate
     *
     * @return LastDontations
     */
    public function setDonationDate($donationDate)
    {
        $this->donationDate = $donationDate;

        return $this;
    }

    /**
     * Get donationDate
     *
     * @return \DateTime
     */
    public function getDonationDate()
    {
        return $this->donationDate;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Users $user
     *
     * @return LastDontations
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
}
