<?php

namespace App\Services\Image;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

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
    public function uploadImage($file, $destinationPath, string $prefix = '')
    {   
        if (!$file->isValid()) {
            $notification = [
                'message' => 'Error Uploading Image File',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }
        $filename = $prefix . date('Y-m-d_H:i:s') . '_' . $file->getClientOriginalName();
        $file->move(public_path($destinationPath), $filename);
        return $filename;
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
    public function uploadImageWithReplacement($filePath, $destinationPath, $data, $colName)
    {   
        $file = new SymfonyUploadedFile($filePath, pathinfo($filePath, PATHINFO_BASENAME));

        if (! $file->isValid())  {
            $notification = [
                'message' => 'Error Updating Image File',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }
        Storage::disk('public')->delete($destinationPath . $data->{$colName});
        $filename = date('Y-m-d_H:i:s') . $file->getClientOriginalName();
        $file->move(public_path($destinationPath), $filename);
        $data->{$colName} = $filename;
        return $filename;
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
