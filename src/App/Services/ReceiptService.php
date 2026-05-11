<?php

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\Config\Paths;

class ReceiptService
{
    public function __construct(private Database $db)
    {
    }

    public function validateFile(?array $file)
    {
        if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException([
                'receipt' => ['Failed to upload file']
            ]);
        }
        $maxFileSizeMB = 5 * 1024 * 1024;

        if ($file['size'] > $maxFileSizeMB) {
            throw new ValidationException([
                'receipt' => ['File size exceeds the maximum size']
            ]);
        }

        $originalFileName = $file['name'];

        if (!preg_match('/^[A-Za-z0-9\s._-]+$/', $originalFileName)) {
            throw new ValidationException([
                'receipt' => ['Invalid original file name']
            ]);
        }

        $clientMimeType = $file['type'];
        $allowedMimeTypes = ['image/png', 'image/jpeg', 'application/pdf'];

        if (!in_array($clientMimeType, $allowedMimeTypes)) {
            throw new ValidationException([
                'receipt' => ['Invalid file type']
            ]);
        }

    }

    public function upload(array $file)
    {
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;

        $uploadPath = Paths::STORAGE_UPLOADS . '/' . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new ValidationException([
                'receipt' => ['Failed to upload file']
            ]);
        }

    }
}