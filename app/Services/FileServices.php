<?php

namespace App\Services;

use Intervention\Image\Image;

class FileServices
{
    public function updateFile($model, $request, $type)
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
        // Check if the type parameter is equal to 'user'
        if ($type === 'user') {
            // Resize the uploaded file to 400x400 pixels
            $file = (new Image)->make($request->file('file'))->resize(400, 400);
        } else {
            // Resize the uploaded file to 720x720 pixels
            $file = (new Image)->make($request->file('file'))->resize(720, 720);
        }

        // Get the file extension of the uploaded file
        $ext = $request->file('file');
        $extention = $ext->getClientOriginalExtension();
        // Generate a new filename using the current time and file extension
        $name = \time() . $extention;
        // Save the file to the public path under the postImage directory with the generated filename
        $file = save(\public_path() . '/files/postImage' . $name);
        // Update the model's file property with the new filename
        $model = $file . $name;

        // Return the updated model object
        return $model;
    }
}
