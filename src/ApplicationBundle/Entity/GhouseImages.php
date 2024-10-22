<?php

namespace ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * GhouseImages
 *
 * @ORM\Table(name="ghouse_images")
 * @ORM\Entity(repositoryClass="ApplicationBundle\Repository\GhouseImagesRepository")
 */
class GhouseImages implements UserInterface, \Serializable
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="Ghouse", inversedBy="gh_images")
     * @ORM\JoinColumn(name="ghouse_id", referencedColumnName="id")
     */
    private $ghouseId;


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
     * Set Path
     *
     * @param string $ghimageSrc
     *
     * @return GhouseImages
     */
    public function setPath($ghimageSrc)
    {
        $this->path= $ghimageSrc;

        return $this;
    }

    /**
     * Get Path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Set ghouseId
     *
     * @param integer $ghouseId
     *
     * @return GhouseImages
     */
    public function setGhouseId($ghouseId)
    {
        $this->ghouseId = $ghouseId;

        return $this;
    }

    /**
     * Get ghouseId
     *
     * @return int
     */
    public function getGhouseId()
    {
        return $this->ghouseId;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_GHADMIN');
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->id;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return array(
            "id" =>
            $this->id,
            "path" =>
            $this->path,
            "ghouseId" =>
            $this->ghouseId,
        );
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->path,
            $this->ghouseId,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->id;
    }

    var $image;

    public function getGhImage()
    {
        return $this->image;
    }

    public function setGhImage(GhouseImages $gh_images)
    {
        $this->image = $gh_images;
        return $this;
    }
}

