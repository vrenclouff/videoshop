<?php

class File
{

    public function getFile(){

        print_r($_POST['add']);


        $target_dir = "covers/";
        @$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
//                echo "File is an image - " . $check["mime"] . ".<br />";
//                echo "<script type='text/javascript'>alert('File is an image -  $check['mime']');</script>";
                $uploadOk = 1;
            } else {
//                echo "File is not an image.<br />";
                echo "<script type='text/javascript'>alert('Vlozeny soubor neni obrazek');</script>";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
//            echo "Sorry, file already exists.<br />";
            echo "<script type='text/javascript'>alert('Soubor jiz existuje');</script>";
            $uploadOk = 0;
        }
        // Check file size
        if (@$_FILES["fileToUpload"]["size"] > 500000) {
//            echo "Sorry, your file is too large.<br />";
            echo "<script type='text/javascript'>alert('Soubor je prilis velky');</script>";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
//            echo "Sorry, only JPG, JPEG, PNG files are allowed.<br />";
            echo "<script type='text/javascript'>alert('Jsou povoleny pouze JPG, JPEG, PNG soubory');</script>";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br />";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br />";
            } else {
//                echo "Sorry, there was an error uploading your file <br />";
                echo "<script type='text/javascript'>alert('Chyba pri prenosu');</script>";

            }
        }

        return $_FILES["fileToUpload"]["name"];
    }

}

?>