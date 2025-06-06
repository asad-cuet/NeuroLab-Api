<?php

namespace App\Classes\SelfCoder;

use File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class FileManager
{
    /**
     * SaveFile
     *
     * @param  mixed $file
     * @param  mixed $file_name
     * @param  mixed $directory
     * @return string
     */
    public static function saveFile(
        $file,
        $file_path,
        $allowed_extension=[
            'jpg', 'jpeg', 'png', 'gif', 
            'pdf', 'doc', 'docx', 'txt','csv','xlsx',
            'mp4', 'avi', 'mkv', 'mov', 
            'mp3', 'wav', 'ogg', 
            'zip', 'rar', 
            'sql'
        ],
        $filename=''
    )
    {
        $extention=strtolower($file->getClientOriginalExtension());  


        if(in_array($extention,$allowed_extension))
        {
            $filename=$filename? $filename.'.'.$extention : uniqid().'.'.$extention;

            if($file->move($file_path,$filename))
            {
                $filename=$file_path.'/'.$filename;

                return [
                    'result'=>true,
                    'message'=>"File Uploaded",
                    'filename'=>$filename,
                ];
            }
            else
            {
                return [
                    'result'=>false,
                    'message'=>"File Uploading Failed",
                    'filename'=>''

                ];
            }
        }
        else
        {
            return [
                'result'=>false,
                'message'=>"Uploaded file extension .".$extention." is not allowed",
                'filename'=>'',
            ];
        }
    }

    /**
     * ResizeImage
     *
     * @param  mixed $file
     * @param  mixed $path
     * @param  mixed $width
     * @param  mixed $height
     * @return string
     */
    public static function ResizeImage($file, $path, $width, $height): string
    {
        $img = Image::make($file);
        $img->resize($width, $height);
        $img->save($path);
        return $path;
    }

    /**
     * DeleteFile
     *
     * @param  mixed $path
     * @return string
     */
    public static function deleteFile($path)
    {
        if ($path && File::exists($path)) {

            File::delete($path);
        }
        return $path;
    }
}
