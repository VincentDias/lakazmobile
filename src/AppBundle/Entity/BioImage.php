<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BioImage
 *
 * @ORM\Table(name="bio_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BioImageRepository")
 */
class BioImage
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
     * @ORM\Column(name="pathImage", type="string", length=255)
     * 
     * @Assert\NotBlank(message="Veuillez insérer le bon format de fichier")
     * @Assert\File(mimeTypes={"image/jpeg", "image/png"})
     */
    private $pathImage;

    /**
     * @var string
     *
     * @ORM\Column(name="Alt", type="string", length=255)
     */
    private $alt;


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
     * Set pathImage.
     *
     * @param string $pathImage
     *
     * @return BioImage
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

    /**
     * Set alt.
     *
     * @param string $alt
     *
     * @return BioImage
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

    public function __toString()
    {
        $format = "%s";
        return sprintf($format, $this->pathImage);
    }
}
