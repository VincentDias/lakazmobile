<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="category_name", type="string", length=255)
     * @ORM\OneToMany(targetEntity=\AppBundle\Entity\Plat::class, mappedBy="category", cascade={"persist"})
     * 
     */
    private $categoryName;

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
     * Set categoryName.
     *
     * @param string $categoryName
     *
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName.
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }


    public function __toString()
    {
        $format = "%s";
        return sprintf($format, $this->categoryName);
    }
}
