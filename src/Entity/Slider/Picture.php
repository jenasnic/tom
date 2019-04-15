<?php

namespace App\Entity\Slider;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="slider_picture")
 * @ORM\Entity(repositoryClass="App\Repository\Slider\PictureRepository")
 * @Vich\Uploadable
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="rank", type="integer")
     *
     * @var int
     */
    private $rank;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Slider\Slider", inversedBy="pictures")
     * @ORM\JoinColumn(name="slider_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var Slider
     */
    private $slider;

    /**
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="sliders", fileNameProperty="picture")
     *
     * @var File
     */
    private $pictureFile;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     *
     * @var \DateTimeInterface
     */
    private $updatedAt;

    public function __construct()
    {
        $this->rank = 0;
        $this->updatedAt = new \DateTime();
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
     * @return Picture
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRank(): ?int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     *
     * @return Picture
     */
    public function setRank(int $rank): self
    {
        $this->rank = $rank;

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
     * @return Picture
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Slider|null
     */
    public function getSlider(): ?Slider
    {
        return $this->slider;
    }

    /**
     * @param Slider $slider
     *
     * @return Picture
     */
    public function setSlider(Slider $slider): self
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string|null $picture
     *
     * @return Picture
     */
    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * @param File|null $pictureFile
     *
     * return Picture
     */
    public function setPictureFile(?File $pictureFile): self
    {
        $this->pictureFile = $pictureFile;

        if ($pictureFile) {
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     *
     * @return Picture
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
