<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bio
 *
 * @ORM\Table(name="bio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BioRepository")
 */
class Bio
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
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * @var AppBundle\Entity\BioImage
     * @ORM\OneToOne(targetEntity=\AppBundle\Entity\BioImage::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="bioimage_id", referencedColumnName="id", nullable=false)
     */
    private $Image;

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
     * Set title.
     *
     * @param string $title
     *
     * @return Bio
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Bio
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
     *
     * @param AppBundle\Entity\BioImage $Image
     */
    public function setImage($Image)
    {
        $this->Image = $Image;

        return $this;
    }

    /**
     * 
     * @return AppBundle\Entity\BioImage
     */
    public function getImage()
    {
        return $this->Image;
    }


    public function __toString()
    {
        $format = "%s, %s, %s";
        return sprintf($format, $this->Title, $this->Description, $this->Image);
    }
}
