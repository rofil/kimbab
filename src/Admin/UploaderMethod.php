<?php


namespace App\Admin;


use App\Service\FileUploaderService;

trait UploaderMethod
{
    protected $uploader;

    public function setUploaderService(FileUploaderService $uploader, $dir)
    {
        $uploader->setUploadDir($dir);
        $this->uploader = $uploader;
    }

    public function getUploader():FileUploaderService
    {
        return $this->uploader;
    }
}