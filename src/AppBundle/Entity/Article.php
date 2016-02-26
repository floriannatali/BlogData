<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @Serializer\ExclusionPolicy("all")
 *
 * @ORM\Table("article")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ArticleRepository")
 */
class Article
{

    /**
     * Article ID
     *
     * @var int
     * @Serializer\Expose
     * @Serializer\Groups(groups={"Article"})
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     *
     */
    private $id;
    /**
     * The title (not null)
     *
     * @var string
     * @Serializer\Expose
     * @Serializer\Groups(groups={"Article"})
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     *
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="50")
     */
    private $title;
    /**
     * The content (not null)
     *
     * @var string
     * @Serializer\Expose
     * @Serializer\Groups(groups={"Article"})
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\NotBlank
     * @Assert\Length(min="10", max="500")
     */
    private $content;
    /**
     * The author (not null)
     *
     * @var string
     * @Serializer\Expose
     * @Serializer\Groups(groups={"Article"})
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\NotBlank
     * @Assert\Length(min="2", max="50")
     */
    private $author;
    /**
     * (not null) The date of creation. Api DateTime format: 'Y-m-d H:i:s'
     *
     * @var \DateTime
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     * @Serializer\Expose
     * @Serializer\Groups(groups={"Article"})
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Assert\DateTime
     * @Assert\NotBlank
     *
     */
    private $dateCreation;
    /**
     * (nullable) Publish date if published article. Api DateTime format: 'Y-m-d H:i:s'
     *
     * @var \DateTime
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Expose
     * @Serializer\Groups(groups={"Article"})
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     */
    private $datePublished;
    /**
     * (nullable) Delete date if disabled article. Api DateTime format: 'Y-m-d H:i:s'
     *
     * @var \DateTime
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Expose
     * @Serializer\Groups(groups={"Article"})
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDelete;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return \DateTime
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param \DateTime $datePublished
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
    }

    /**
     * @return \DateTime
     */
    public function getDateDelete()
    {
        return $this->dateDelete;
    }

    /**
     * @param \DateTime $dateDelete
     */
    public function setDateDelete($dateDelete)
    {
        $this->dateDelete = $dateDelete;
    }
}