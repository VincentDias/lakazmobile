<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plat
 *
 * @ORM\Table(name="plat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlatRepository")
 */
class Plat
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * 
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=\AppBundle\Entity\Category::class)
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    protected $categoryName;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;



    /**
     *
     * @var AppBundle\Entity\Image
     * @ORM\OneToOne(targetEntity=\AppBundle\Entity\Image::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     * 
     */
    protected $image;



    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @var \DateTime
     * 
     */
    private $date;

    public function __construct()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime", options={"default":"2019-01-01"})
     */
    protected $created;

    /**
     * @var datetime $updated
     * 
     * @ORM\Column(type="datetime", nullable = true, options={"default":"2019-01-01"})
     */
    protected $updated;

        /**
     * Gets triggered only on insert

     * @ORM\PrePersist 
     * 
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Plat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Plat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set categoryName.
     *
     * @param int $categoryName
     *
     * @return Plat
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName.
     *
     * @return int
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Plat
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }



    /**
     * @param AppBundle\Entity\Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
    /**
     * @return AppBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }


    

    /**
     * Set available.
     *
     * @param bool $available
     *
     * @return Plat
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available.
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    public function __toString()
    {
        $format = "%s, %s, %s, %s, %s, %$";
        return sprintf($format, $this->name, $this->description, $this->categoryName, $this->price, $this->image, $this->available);
    }
}
