<?php namespace Acme\Ad;

use Acme\Core\BaseImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService extends BaseImageService {

    protected $thumbnailImageWidth = '450';

    protected $thumbnailImageHeight = '125';

    public function store(UploadedFile $image) {

       return $this->process($image,['thumbnail']);

    }

} 