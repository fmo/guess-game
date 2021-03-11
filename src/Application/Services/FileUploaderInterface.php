<?php

namespace Guess\Application\Services;

interface FileUploaderInterface
{
    public function upload(string $bucketName, string $objectName, string $imageUrl);
    public function getImageUrl();
}
