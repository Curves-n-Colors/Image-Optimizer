<?php

namespace App\Helpers;

class ImageHelper
{

    public $image;
    public $extention;
    public $path;

    public function __construct($image)
    {
        $this->image = new \Imagick($image);
        $this->extention = $this->image->getImageFormat();
        $this->path = $image;
        //SIZE OF IMAHE IN KB.
    }

    public function compress($quality = 50)
    {
        switch (strtolower($this->extention)) {
            case 'png':
            case 'x-png':
            case 'image/png':
            case 'image/x-png':
                $compress = $this->compress_png();
                break;

            case 'jpg':
            case 'jpeg':
            case 'pjpeg':
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $quality = $this->get_quality();
                $compress = $this->compress_jpg($quality);
                break;

            default:
                dd(123);
        }
        return $compress;
    }

    public function compress_jpg($quality)
    {
        $this->image->stripImage();
        $this->image->setImageCompression(\Imagick::COMPRESSION_LOSSLESSJPEG);
        $this->image->setImageCompressionQuality($quality);
        $this->image->setImageColorspace(\Imagick::COLORSPACE_RGB);
        $this->image->gaussianBlurImage(0.25, 1);
        $this->image->setInterlaceScheme(\Imagick::INTERLACE_PLANE);
        $this->image->writeImage($this->path);
        return true;
    }

    public function compress_png()
    {
        $this->image->stripImage();
        $this->image->setCompression(\Imagick::COMPRESSION_ZIP);
        $this->image->setImageCompression(\Imagick::COMPRESSION_ZIP);
        $this->image->gaussianBlurImage(0.25, 1);
        $this->image->setImageType(\Imagick::IMGTYPE_PALETTE);
        $this->image->setImageBackgroundColor(new \ImagickPixel('transparent'));
        $image = $this->image->mergeImageLayers(\Imagick::LAYERMETHOD_MERGE);
        $image->setImageColorspace(\Imagick::COLORSPACE_RGB);
        $image->setImageDepth(5);
        $image->writeImage($this->path);
        return true;
    }

    public function convert_to_webp()
    {
        $quality = $this->get_quality();
        $this->image->stripImage();
        $this->image->setImageBackgroundColor(new \ImagickPixel('transparent'));
        $image = $this->image->mergeImageLayers(\Imagick::LAYERMETHOD_MERGE);
        $image->setImageFormat('webp');
        $image->setCompression(\Imagick::COMPRESSION_LOSSLESSJPEG);
        $image->setImageCompression(\Imagick::COMPRESSION_LOSSLESSJPEG);
        $image->setImageColorspace(\Imagick::COLORSPACE_RGB);
        $image->gaussianBlurImage(0.25, 1);
        $image->setImageCompressionQuality($quality);
        $image->writeImage("new-comp.webp");

        return true;
    }

    public function get_quality()
    {
        $image_size = ($this->image->getImageLength()) / 1024; //IMAGE SIZE IN KB.

        if ($image_size > 5000) {
            return 43;
        }
        if ($image_size > 4000) {
            return 45;
        }
        if ($image_size > 3000) {
            return 47;
        }
        if ($image_size > 500) {
            return 50;
        }

        return 60;
    }
}
