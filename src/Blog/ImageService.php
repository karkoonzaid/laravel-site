<?php
namespace Acme\Blog;

use Acme\Core\BaseImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService extends BaseImageService {

    public function store(UploadedFile $image) {

       return $this->process($image,['thumbnail','large','medium']);

    }

} 