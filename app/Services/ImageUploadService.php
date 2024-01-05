<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ImageUpload\ImageUploadException;

/**
 * Service class for handling image uploads.
 */
class ImageUploadService
{
    /**
     * Upload a file to the specified destination path with an optional prefix.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destinationPath
     * @param string $prefix
     * @return string
     * @throws \App\Exceptions\ImageUploadException
     */
    public function upload(UploadedFile $file, string $destinationPath, string $prefix = '')
    {
        if (! empty($file)) {
            try {
                $filename = $prefix . date('Y-m-d_H:i:s') . '_' . $file->getClientOriginalName();
                $file->move(public_path($destinationPath), $filename);
                return $filename;
            } catch (\Exception $e) {
                throw new ImageUploadException('Error uploading the file.');
            }
        }
    }

    /**
     * Upload a file to the specified destination path with replacement logic.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destinationPath
     * @param string $prefix
     * @param string|null $oldFilename
     * @return string
     * @throws \App\Exceptions\ImageUploadException
     */
    public function uploadWithReplacement(UploadedFile $file, string $destinationPath, string $prefix = '', ?string $oldFilename = null)
    {
        // If an old filename is provided, delete the old image
        if ($oldFilename) {
            $this->delete($destinationPath, $oldFilename);
        }

        // Upload the new image
        return $this->upload($file, $destinationPath, $prefix);
    }

    /**
     * Delete a file using the provided filename.
     *
     * @param string $destinationPath
     * @param string $filename
     */
    public function delete(string $destinationPath, string $filename)
    {   
        $filePath = public_path($destinationPath . $filename);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
