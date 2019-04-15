<?php

namespace App\Entity\Slider;

use App\Entity\Book;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="App\Repository\Slider\SliderRepository")
 */
class Slider
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var Book
     */
    private $book;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Slider\Picture", mappedBy="slider", cascade={"persist", "remove" })
     * @ORM\OrderBy({"rank" = "ASC"})
     *
     * @var Picture[]|Collection
     */
    private $pictures;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Slider
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Slider
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Book|null
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * @param string $title
     *
     * @return Slider
     */
    public function setBook(Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    /**
     * @return Picture[]|Collection
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    /**
     * @param Picture $picture
     *
     * @return Slider
     */
    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
        }

        return $this;
    }

    /**
     * @param Picture $picture
     *
     * @return Slider
     */
    public function removePicture(Picture $picture): self
    {
        $this->pictures->removeElement($picture);

        return $this;
    }
}
