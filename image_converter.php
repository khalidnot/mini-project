<?php

class Image_converter
{
    
    public $target_dir = 'uploads/';

    //image upload handler
    public function upload_image($files, $input_name)
    {

        $target_dir = "$this->target_dir/";

        //get the basename of the uploaded file
        $base_name = basename($files[$input_name]["name"]);

        //get the image type from the uploaded image
        $imageFileType = $this->get_image_type($base_name);


        //set dynamic name for the uploaded file
        $new_name = $this->get_dynamic_name($base_name, $imageFileType);


        //set the target file for uploading
        $target_file = $target_dir . $new_name;


        // Check uploaded is a valid image
        $validate = $this->validate_image($files[$input_name]["tmp_name"]);
        if (!$validate) {
            return "Doesn't seem like an image file :(";
        }

        // Check file size - restrict if greater than 1 MB
        $file_size = $this->check_file_size($files[$input_name]["size"], 1000000);
        if (!$file_size) {
            return "You cannot upload more than 1MB file";
        }

        // Allow certain file formats
        $file_type = $this->check_only_allowed_image_types($imageFileType);
        if (!$file_type) {
            return "You cannot upload other than JPG, JPEG and PNG";
        }

        if (move_uploaded_file($files[$input_name]["tmp_name"], $target_file)) {

            //return new image name and image file type;
            return array($new_name, $imageFileType);
        } else {
            return "Sorry, there was an error uploading your file.";
        }

    }

    //image converter
    function convert_image($convert_type, $image_name)
    {

        $image_quality = 100;
        
        $target_dir = "$this->target_dir/";

        $image = $target_dir . $image_name;

        //remove extension from image;
        $img_name = $this->remove_extension_from_image($image);

        //to png
        if ($convert_type == 'png') {

            $binary = imagecreatefromstring(file_get_contents($image));

            $image_quality = floor(10 - ($image_quality / 10));

            ImagePNG($binary, $target_dir . $img_name . '.' . $convert_type, $image_quality);

            return $img_name . '.' . $convert_type;
        }

        //to jpg
        if ($convert_type == 'jpg') {

            $binary = imagecreatefromstring(file_get_contents($image));

            imageJpeg($binary, $target_dir . $img_name . '.' . $convert_type, $image_quality);

            return $img_name . '.' . $convert_type;
        }

        return false;
    }

    protected function get_image_type($target_file)
    {
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        return $imageFileType;
    }

    protected function validate_image($file)
    {
        $check = getimagesize($file);

        if ($check !== false) {
            return true;
        }
        return false;
    }

    protected function check_file_size($file, $size_limit)
    {
        if ($file > $size_limit) {
            return false;
        }
        return true;
    }

    protected function check_only_allowed_image_types($imagetype)
    {
        if ($imagetype != "jpg" && $imagetype != "png" && $imagetype != "jpeg") {
            return false;
        }
        return true;
    }

    protected function get_dynamic_name($basename, $imagetype)
    {
        $only_name = basename($basename, '.' . $imagetype); // remove extension

        $combine_time = $only_name . '_' . time();

        $new_name = $combine_time . '.' . $imagetype;

        return $new_name;
    }

    protected function remove_extension_from_image($image)
    {
        $extension = $this->get_image_type($image); //get extension

        $only_name = basename($image, '.' . $extension); // remove extension

        return $only_name;
    }
}

?>