<?php

declare(strict_types=1);

namespace App\Entity;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File
{
    /**
     * @var UploadedFile
     * @Assert\File()
     * @AppAssert\Antivirus()
     */
    public UploadedFile $file;
}