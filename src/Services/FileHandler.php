<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * <<<<<<< HEAD
 * Date: 12/10/18
 * Time: 10:23
 * =======
 * Date: 17/10/18
 * Time: 10:04
 * >>>>>>> sprint3
 */

namespace Services;

class FileHandler
{

    public static function upload(array $files)
    {
        $uploaded = array();
        $failed = array();
        $allowed = array('png', 'jpg', 'gif','jpeg');

        foreach ($files['name'] as $position => $file_name) {
            $file_tmp = $files['tmp_name'][$position];
            $file_size = $files['size'][$position];
            $file_error = $files['error'][$position];
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));
            if (in_array($file_ext, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= 2048576) {
                        $file_name_new = uniqid('image', true) . '.' . $file_ext;
                        $file_destination = APP_UPLOAD_FOLDER . $file_name_new;
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            $uploaded[$position] = $file_name_new;
                        } else {
                            throw new \Exception("[{$file_name}] failed to upload.");
                        }
                    } else {
                        throw new \Exception("[{$file_name}] is too large.");
                    }
                } else {
                    throw new \Exception("[{$file_name}] errored with code {$file_error}");
                }
            } else {
                throw new \Exception("[{$file_name}] file extension '{file_ext}' is not allowed");
            }
        }
        return $uploaded;
    }
}
