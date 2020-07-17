<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileUploadTrait 
{
    private function saveUpload(
        UploadedFile $file,
        string $directory,
        SluggerInterface $slugger): string
    {
        $client_filename = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $filename = $slugger->slug($client_filename)
            . '_'
            . bin2hex(random_bytes(12))
            . '.'
            . $file->guessExtension();
        try {
            $file->move(
                $directory,
                $filename
            );
        } catch (FileException $e) {
            $filename = $e;
        }
        return $filename;
    }
}