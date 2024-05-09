<?php


namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

trait  ImageProcessing
{
    function upload_image($file, $folder_uplaod)
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $path = $file->storeAs($folder_uplaod, $name, 'images');
        return $path;
    }

    /****************************************************************/
    public function get_mime_old($mime)
    {
        if ($mime == 'image/jpeg')
            $extension = '.jpg';
        elseif ($mime == 'image/png')
            $extension = '.png';
        elseif ($mime == 'file/pdf')
            $extension = '.pdf';
        elseif ($mime == 'image/gif')
            $extension = '.gif';
        elseif ($mime == 'image/svg+xml')
            $extension = '.svg';
        elseif ($mime == 'image/tiff')
            $extension = '.tiff';
        elseif ($mime == 'image/webp')
            $extension = '.webp';
        return $extension;

    }
    /****************************************************************/
    public function get_mime($mime)
    {
        $extension = '';

        if (str_starts_with($mime, 'image/')) {
            // Image MIME types
            if ($mime == 'image/jpeg') {
                $extension = '.jpg';
            } elseif ($mime == 'image/png') {
                $extension = '.png';
            } elseif ($mime == 'image/gif') {
                $extension = '.gif';
            } elseif ($mime == 'image/svg+xml') {
                $extension = '.svg';
            } elseif ($mime == 'image/tiff') {
                $extension = '.tiff';
            } elseif ($mime == 'image/webp') {
                $extension = '.webp';
            }
        } elseif ($mime == 'application/pdf') {
            // PDF MIME type
            $extension = '.pdf';
        } elseif (str_starts_with($mime, 'application/msword') || str_starts_with($mime, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
            // Word document MIME types
            $extension = '.docx';
        }

        return $extension;
    }

    /****************************************************************/
    function checkFolder($folderPath)
    {
        if (!File::isDirectory($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
        return true;
    }

   /****************************************************************/
    public function saveFile($file, $folder = null)
    {
        $extension = $this->get_mime($file->getMimeType());
        $str_random = Str::random(8);
        $filename = $str_random . time() . $extension;

        if (!empty($folder)) {
            // If folder is provided, include it in the file path
            $filePath = $folder . '/' . $filename;
        } else {
            $filePath = $filename;
        }

        // Use the 'files' disk as the first parameter to storeAs
        Storage::disk('images')->put($filePath, file_get_contents($file->getRealPath()));

        // Use Storage::url() to get the full URL of the stored file
       // $fileUrl = Storage::disk('files')->url($filePath);

        //dd($filePath);
        return $filePath;
    }


    /****************************************************************/
    public function saveImage($image, $folder = null)
    {
        $img = Image::make($image);
        $extension = $this->get_mime($img->mime());
        $str_random = Str::random(8);
        $imgpath = $str_random . time() . $extension;
        if (!empty($folder)) {
            $upload_path = storage_path('app/images') . '/' . $folder;
        } else {
            $upload_path = storage_path('app/images');
        }
        $this->checkFolder($upload_path);
        $img->save($upload_path . '/' . $imgpath);
        $imgpath = $folder . '/' . $imgpath;

        return $imgpath;
    }
    /****************************************************************/
    public function aspect4resize($image, $width, $height, $folder)
    {
        $img = Image::make($image);
        $extension = $this->get_mime($img->mime());
        $str_random = Str::random(8);

        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imgpath = $str_random . time() . $extension;
        /*        $img->save(storage_path('app/images') . '/' .$folder. '/' . $imgpath);*/
        $imgfullpath = 'app/images/' . $imgpath;

        $upload_path = storage_path('app/images') . '/' . $folder;
        $this->checkFolder($upload_path);
        $img->save($upload_path . '/' . $imgpath);
        $imgpath = $folder . '/' . $imgpath;

        return $imgpath;

    }
    /****************************************************************/
    public function aspect4height($image, $width, $height, $folder)
    {
        $img = Image::make($image);
        $extension = $this->get_mime($img->mime());
        $str_random = Str::random(8);
        $img->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($img->width() < $width) {
            $img->resize($width, null);
        } else if ($img->width() > $width) {
            $img->crop($width, $heigh, 0, 0);
        }

        $imgpath = $str_random . time() . $extension;
        /*        $img->save(storage_path('app/images') . '/' . $folder . '/' . $imgpath);*/
        $upload_path = storage_path('app/images') . '/' . $folder;
        $this->checkFolder($upload_path);
        $img->save($upload_path . '/' . $imgpath);
        $imgpath = $folder . '/' . $imgpath;

        return $imgpath;

    }

    public function saveImageAndThumbnail($Thefile, $folder, $thumb = false)
    {
        $dataX = array();

        $dataX['image'] = $this->saveImage($Thefile, $folder);

        if ($thumb) {

            $dataX['thumbnailsm'] = $this->aspect4resize($Thefile, 256, 144, $folder);
            $dataX['thumbnailmd'] = $this->aspect4resize($Thefile, 426, 240, $folder);
            $dataX['thumbnailxl'] = $this->aspect4resize($Thefile, 640, 360, $folder);
        }

        return $dataX;
    }

    public function deleteImage($filePath)
    {
        if ($filePath) {
            if (is_file(Storage::disk('images')->path($filePath))) {
                if (file_exists(Storage::disk('images')->path($filePath))) {
                    unlink(Storage::disk('images')->path($filePath));
                }
            }
        }
    }

    public function deleteFolder($folderPath)
    {
        if (Storage::disk('images')->exists($folderPath)) {
            Storage::disk('images')->deleteDirectory($folderPath);
        }
    }
}
