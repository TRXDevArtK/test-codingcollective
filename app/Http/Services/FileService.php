<?php

namespace App\Http\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadResumeAndGetPath($data){
        $file = $data['resume_link'];

        if ($file->isValid()) {
            $fileName = $file->getClientOriginalName();

            // Save the file to the default storage (usually 'storage/app/public' directory)
            $filePath = $file->storeAs('public', $fileName);

            // Get the file path
            $getFileName = $file->getClientOriginalName();

            return $getFileName;
        }

        return 'null';
    }

    public function deleteFileLocalPath($data){
        $filePath = $data['link'];
        // Check if the file exists
        if (Storage::exists("public/".$filePath)) {
            // Delete the file
            Storage::disk('public')->delete($filePath);

            return 'null';
        }

        return 'null';
    }
}
