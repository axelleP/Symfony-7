<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Exception\FileUploadException;

class FileUploader
{
    private $translator;

    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
        TranslatorInterface $translator
    ) {
        $this->translator = $translator;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            throw new FileUploadException($this->translator->trans('errorUpload', [], 'errors'));
        }

        return $fileName;
    }

    public function remove($fileName): string
    {
        try {
            $filesystem = new Filesystem();
            $filesystem->remove([$this->getTargetDirectory() . '/' . $fileName]);
        } catch (FileException $e) {
            throw new FileException($this->translator->trans('error', [], 'errors'));
        }

        return 'success';
    }
}