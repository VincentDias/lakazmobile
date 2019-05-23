<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="Name", type="string", length=255, nullable = false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     *
     * @var AppBundle\Entity\ArticleImage
     * @ORM\OneToOne(targetEntity=\AppBundle\Entity\ArticleImage::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="articleimage_id", referencedColumnName="id", nullable=false)
     * 
     */
    private $articleImage;

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
     * @return Article
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
     * @return Article
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
     * @param AppBundle\Entity\ArticleImage $articleImage
     */
    public function setArticleImage($articleImage)
    {
        $this->articleImage = $articleImage;

        return $this;
    }

    /**
     * @return AppBundle\Entity\ArticleImage 
     */
    public function getArticleImage()
    {
        return $this->articleImage;
    }

    public function __toString()
    {
        $format = "%s, %s, %s";
        return sprintf($format, $this->name, $this->description, $this->articleImage);
    }
}
