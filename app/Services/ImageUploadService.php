<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Exceptions\ImageUpload\ImageUploadException;

/**
 * Service class for handling image uploads.
 */
class ImageUploadService
{
    /**
     * Handle image upload based on the provided parameters.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $img
     * @param string $filePath
     * @param string $destinationPath
     * @param string $prefix
     * @throws \App\Exceptions\ImageUploadException
     */
    public function handleImageUpload($request, string $img, string $filePath, string $destinationPath, string $prefix = '')
    {
        if ($request->file($img)) {
            try {
                // Delete the previous photo
                $this->delete($filePath);

                // Upload the new photo
                $this->upload($request->file($img), $destinationPath, $prefix);
            } catch (\Exception $e) {
                // Catch and rethrow as the custom ImageUploadException
                throw new ImageUploadException('Error uploading the file. Please try again later.');
            }
        }
    }

    /**
     * Upload a file to the specified destination path with an optional prefix.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destinationPath
     * @param string $prefix
     * @throws \App\Exceptions\ImageUploadException
     */
    public function upload(UploadedFile $file, string $destinationPath, string $prefix = '')
    {
        try {
            $filename = $prefix . date('Y-m-d_H:i:s') . '_' . $file->getClientOriginalName();

            // Move the file to the destination path
            $file->move(public_path($destinationPath), $filename);

            return $filename;
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            // Log::error($e);
            // Throw a new exception
            throw new ImageUploadException('Error uploading the file. Please try again later.');
        }
    }

    /**
     * Delete a file at the specified file path.
     *
     * @param string $filePath
     */
    protected function delete(string $filePath)
    {
        @unlink(public_path($filePath));
    }
}
