<?php

namespace App\Service\Slider;

use App\Entity\Slider\Picture;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\Polyfill\FileExtensionTrait;

class PictureNamer implements NamerInterface
{
    use FileExtensionTrait;

    /**
     * {@inheritDoc}
     */
    public function name($object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);

        if (!$object instanceof Picture) {
            return $file->getClientOriginalName();
        }

        return $this->getFileName(
            $mapping->getUploadDestination(),
            $object->getSlider()->getId(),
            $this->getExtension($file)
        );
    }

    /**
     * @param string $directory
     * @param int $sliderId
     * @param string $extension
     *
     * @return string
     */
    private function getFileName(string $directory, int $sliderId, string $extension): string
    {
        $i = 1;
        do {
            $fileName = sprintf('slider_%03d_picture_%03d.%s', $sliderId, $i++, $extension);
        }
        while (file_exists($directory.DIRECTORY_SEPARATOR.$fileName));

        return $fileName;
    }
}
