<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Mime\MimeTypes;

trait FileUploadTrait
{
    private function saveUpload(
        UploadedFile $file,
        string $directory,
        SluggerInterface $slugger
    ): string {
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

    private function deleteSavedUpload(
        string $filename,
        string $directory
    ): bool {
        return unlink(
            rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $filename
        );
    }

    private function streamSavedUpload(
        string $filename,
        string $directory,
        bool $download = true
    ): Response {


        $response = new StreamedResponse(function () use ($filename, $directory) {
            $output = fopen('php://output', 'wb');
            $file = fopen(
                rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $filename,
                'r'
            );
            stream_copy_to_stream($file, $output);
            // $this->streamSavedUpload($filename, $directory);
        });

        if($download)
        {
            /* Tell the client this is a download */
            $disposition  = HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_ATTACHMENT,
                $filename
            );
            $response->headers->set('Content-Disposition', $disposition);
        }else{
            /**
             * Get mime types from extension for files that have been vetoed on
             * the way in( Otherwise use guessMimeType() to inspect the file ).
            */
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $mimeTypes = new MimeTypes();
            $response->headers->set(
                'Content-Type', $mimeTypes->getMimeTypes($extension)
            );
        }
        return $response;
    }
}