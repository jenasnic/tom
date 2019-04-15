<?php

namespace App\Service\Slider;

use App\Entity\Slider\Picture;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class PictureDirectoryNamer implements DirectoryNamerInterface
{
    /**
     * {@inheritDoc}
     */
    public function directoryName($object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);

        if (!$object instanceof Picture) {
            return $file->getClientOriginalName();
        }

        return sprintf('%s/slider_%03d', $mapping->getUploadDir($object), $object->getSlider()->getId());
    }
}
