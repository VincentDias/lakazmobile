<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArticleImage
 *
 * @ORM\Table(name="article_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleImageRepository")
 */
class ArticleImage
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="pathImage", type="string", length=255)
     * 
     * @Assert\NotBlank(message="Veuillez insérer le bon format de fichier")
     * @Assert\File(mimeTypes={"image/jpeg", "image/png"})
     */
    private $pathImage;


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
     * @return ArticleImage
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
     * Set alt.
     *
     * @param string $alt
     *
     * @return ArticleImage
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set pathImage.
     *
     * @param string $pathImage
     *
     * @return ArticleImage
     */
    public function setPathImage($pathImage)
    {
        $this->pathImage = $pathImage;

        return $this;
    }

    /**
     * Get pathImage.
     *
     * @return string
     */
    public function getPathImage()
    {
        return $this->pathImage;
    }

    public function __toString()
    {
        $format = "%s";
        return sprintf($format, $this->pathImage);
    }
}
