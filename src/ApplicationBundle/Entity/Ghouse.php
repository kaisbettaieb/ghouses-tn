<?php

namespace ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ghouse
 *
 * @ORM\Table(name="ghouse")
 * @ORM\Entity(repositoryClass="ApplicationBundle\Repository\GhouseRepository")
 */
class Ghouse
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="nomPrenomProp", type="string", length=255)
     */
    private $nomPrenomProp;

    /**
     * @var int
     *
     * @ORM\Column(name="mobileNum", type="integer")
     */
    private $mobileNum;

    /**
     * @var int
     *
     * @ORM\Column(name="homeNum", type="integer")
     */
    private $homeNum;

    /**
     * @var string
     *
     * @ORM\Column(name="aPropos", type="text")
     */
    private $aPropos;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="text")
     */
    private $options;

    /**
     * @var float
     *
     * @ORM\Column(name="maplng", type="float")
     */
    private $mapLng;

    /**
     * @var float
     *
     * @ORM\Column(name="maplnt", type="float")
     */
    private $mapLat;

    /**
     * @var int
     *
     * @ORM\Column(name="ghadmin_id", type="integer")
     */
    private $ghadmin_id;

    /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="text")
     */
    private $conditions;

    /**
     * @var float
     *
     * @ORM\Column(name="prixNuit", type="float")
     */
    private $prixNuit;

    /**
     * @var string
     *
     * @ORM\Column(name="mots_cles", type="string")
     */
    private $mots_cles;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Ghouse
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Ghouse
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set nomPrenomProp
     *
     * @param string $nomPrenomProp
     *
     * @return Ghouse
     */
    public function setNomPrenomProp($nomPrenomProp)
    {
        $this->nomPrenomProp = $nomPrenomProp;

        return $this;
    }

    /**
     * Get nomPrenomProp
     *
     * @return string
     */
    public function getNomPrenomProp()
    {
        return $this->nomPrenomProp;
    }

    /**
     * Set mobileNum
     *
     * @param integer $mobileNum
     *
     * @return Ghouse
     */
    public function setMobileNum($mobileNum)
    {
        $this->mobileNum = $mobileNum;

        return $this;
    }

    /**
     * Get mobileNum
     *
     * @return int
     */
    public function getMobileNum()
    {
        return $this->mobileNum;
    }

    /**
     * Set homeNum
     *
     * @param integer $homeNum
     *
     * @return Ghouse
     */
    public function setHomeNum($homeNum)
    {
        $this->homeNum = $homeNum;

        return $this;
    }

    /**
     * Get homeNum
     *
     * @return int
     */
    public function getHomeNum()
    {
        return $this->homeNum;
    }

    /**
     * Set aPropos
     *
     * @param string $aPropos
     *
     * @return Ghouse
     */
    public function setAPropos($aPropos)
    {
        $this->aPropos = $aPropos;

        return $this;
    }

    /**
     * Get aPropos
     *
     * @return string
     */
    public function getAPropos()
    {
        return $this->aPropos;
    }

    /**
     * Set options
     *
     * @param string $options
     *
     * @return Ghouse
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return Ghouse
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set mapLng
     *
     * @param string $mapLng
     *
     * @return Ghouse
     */
    public function setMapLng($mapLng)
    {
        $this->mapLng = $mapLng;

        return $this;
    }

    /**
     * Get mapLng
     *
     * @return float
     */
    public function getMapLng()
    {
        return $this->mapLng;
    }

    /**
     * Set mapLat
     *
     * @param string $mapLat
     *
     * @return Ghouse
     */
    public function setMapLat($mapLat)
    {
        $this->mapLat = $mapLat;

        return $this;
    }

    /**
     * Get mapLat
     *
     * @return float
     */
    public function getMapLat()
    {
        return $this->mapLat;
    }

    /**
     * Set prixNuit
     *
     * @param float $prixNuit
     *
     * @return Ghouse
     */
    public function setPrixNuit($prixNuit)
    {
        $this->prixNuit = $prixNuit;

        return $this;
    }

    /**
     * Get prixNuit
     *
     * @return float
     */
    public function getPrixNuit()
    {
        return $this->prixNuit;
    }

    /**
     * Set GhouseAdmin
     *
     * @param float $GhouseAdmin
     *
     * @return Ghouse
     */
    public function setGhouseAdmin($GhouseAdmin)
    {
        $this->ghadmin_id = $GhouseAdmin;

        return $this;
    }

    /**
     * Get GhouseAdmin
     *
     * @return int
     */
    public function getGhouseAdmin()
    {
        return $this->ghadmin_id;
    }

    /**
     * Set MotsCles
     *
     * @param string $MotsCles
     *
     * @return Ghouse
     */
    public function setMotsCles($MotsCles)
    {
        $this->mots_cles = $MotsCles;

        return $this;
    }

    /**
     * Get MotsCles
     *
     * @return string
     */
    public function getMotsCles()
    {
        return $this->mots_cles;
    }

    public function getRoles()
    {
        return array('ROLE_GHOUSE');
    }
}

