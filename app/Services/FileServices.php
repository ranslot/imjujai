<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

class FileServices
{
    public function updateFile($model, $request, $type): string
    {   // Check if the model has a non-empty file property

        if (!empty($model->file)) {
            // Get the current file path
            $currentFile = \public_path() . $model->file;

            // Check if the current file exists and is not the default user placeholder image
            if (\file_exists($currentFile) && $currentFile !== \public_path() . '/files/user-placeholder.png') {
                // Delete the current file
                \unlink($currentFile);
            }
        }

        $file = null;
        $image = new ImageManager;
        // Check if the type parameter is equal to 'user'
        if ($type === 'user') {
            // Resize the uploaded file to 400x400 pixels
            $file = $image->make($request->file('file'))->resize(400, 400);
        } else {
            $file = $image->make($request->file('file'));
            $file->crop(
                $request->width,
                $request->height,
                $request->left,
                $request->top
            )->resize(720, 720);
        }


        // Get the file extension of the uploaded file
        $ext = $request->file('file');
        $extention = $ext->getClientOriginalExtension();
        // Generate a new filename using the current time and file extension
        $name = \time() . ".$extention";
        // Save the file to the public path under the postImage directory with the generated filename
        $file->save(\public_path() . "/files/postImage/$name");

        return "/files/postImage/$name";
    }
}
