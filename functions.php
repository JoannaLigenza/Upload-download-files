<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    define("uploads", "/uploads/");

    // Make directory and upload files to it
    function makeDir() {
        $dirName = date("Y-m-d_H-i-s");
        if (!file_exists($dirName)) {
            mkdir(".".uploads.$dirName);
        }
        return $dirName;
    }

    function uploadFiles() {
        // $fileName = $_FILES["file-name"]["name"] ;      // <- for one file
        // echo $_FILES["file-name"]["name"] . "<br>";
        if (strlen($_FILES['file-name']['name'][0] ) !== 0) {
            $dirName = makeDir();
        } else {
            return;
        }
        //var_dump(strlen($_FILES['file-name']['name'][0] ) === 0) ;
        
        $countFiles = count($_FILES["file-name"]["name"]);      // <- for multiply files
        $noErrors = true;

        for ($i=0; $i < $countFiles; $i++) {
            $path = ".".uploads.$dirName."/". $_FILES["file-name"]["name"][$i];
            if (move_uploaded_file($_FILES["file-name"]['tmp_name'][$i], $path) ) {
                //echo "Files uploaded successfully";
            } else {
                echo "There was an error during updating, please try again";
                file_put_contents("uploaded-files-text.txt", "There was an error during updating, please try again");
                $noErrors = false;
            };
        }
        if ($noErrors) {
            echo "Files uploaded successfully";
            // Make file and write message to it, then read it in index file
            file_put_contents("uploaded-files-text.txt", "Files uploaded successfully");
        }
    }

    if (isset($_POST["get-button"])) {
        uploadFiles();
        header("Location: ./");
    }

?>