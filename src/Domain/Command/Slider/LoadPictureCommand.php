<?php

namespace App\Domain\Command\Slider;

use App\Entity\Slider\Slider;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Command to load picture for a slider.
 */
class LoadPictureCommand
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var Slider
     */
    protected $slider;

    /**
     * @param UploadedFile $file
     * @param Slider $slider
     */
    public function __construct(UploadedFile $file, Slider $slider)
    {
        $this->file = $file;
        $this->slider = $slider;
    }
    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * @return Slider
     */
    public function getSlider(): Slider
    {
        return $this->slider;
    }
}
