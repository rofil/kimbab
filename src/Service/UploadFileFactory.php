<?php


namespace App\Service;


class UploadFileFactory
{
    public function createUploadFileService()
    {
        $uploader = new FileUploaderService();

        return $uploader;
    }
}