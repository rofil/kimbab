<?php 
/**
 * This file used as service for upload file
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploaderService 
{
    private $targetDir;

    
    public function setUploadDir($dir) 
    {
        $this->targetDir = $dir;
    }

    public function upload(UploadedFile $file)
    {
        $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
        try {
            $file->move($this->getTargetDirectory(), $filename);


        } catch (FileException $e) {

            throw $e;
            die("May be errors has happens");
        }

        return $filename;
    }

    public function getTargetDirectory()
    {
        // die($this->targetDir);
        return $this->targetDir;
    }
}