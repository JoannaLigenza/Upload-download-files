<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    define("uploads", "/uploads/");
    define("readFiles", "/read-files/");
    // Wyswietla wszystkie pliki - uzyte jest w html przy tabeli 
    // scandir()    <- List files and directories inside the specified path
    // dirname() 	<- Returns a parent directory's path
    // getcwd()     <- Gets the current working directory (in this case: ./up)

    function validateFileName($fileName) {
        $result = false;
        for ($i=0; $i < count($fileName); $i++) {
            if ( preg_match('/^[a-z0-9-ąćęłńóśżź_\s]{1,}[.]{1}(txt|jpg|png)$/i', $fileName[$i]) ) {
                $result = true;
            } else {
                return false;
            }
        }
        return $result;
    }
    

    // Make directory and upload files to it
    function makeDir() {
        $dirName = date("Y-m-d_H-i-s");
        if (!file_exists($dirName)) {
            mkdir(".".uploads.$dirName);
        }
        return $dirName;
    }

    // Return message after uploading files
    function uploadFiles($fileName) {
        
        if (strlen($fileName[0] ) !== 0) {
            $dirName = makeDir();
        } else {
            return;
        }
        
        $countFiles = count($fileName);      // <- for multiply files

        for ($i=0; $i < $countFiles; $i++) {
            $path = ".".uploads.$dirName."/". $fileName[$i];
            if (move_uploaded_file($_FILES["file-name"]['tmp_name'][$i], $path) ) {
                //echo "Files uploaded successfully";
            } else {
                return "There was an error during updating, please try again";
            };
        }
        return "Files uploaded successfully";
    }

    // Delete directory
    function deleteDir() {
        $fileName = basename($_GET['delete']);
        $dirPath = "..".uploads.$fileName;
        $showAllFiles = scandir($dirPath);
        $countFiles = count($showAllFiles);
        for ($i=2; $i < $countFiles; $i++) {
            $path = $dirPath.'/'.$showAllFiles[$i];
            unlink($path);
        }
        rmdir($dirPath);
    }



    // Download files
    function getFiles() {
        // basename() <- Zwraca końcową nazwę komponentu ścieżki
        $fileName = basename($_GET['file']);
        $dirPath = "..".uploads.$fileName;
        
        $showAllFiles = scandir($dirPath);
        $countFiles = count($showAllFiles);
        $zipname = $fileName.'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        //$zip->addFile("./uploads/2019-07-25_15-10-05/test3.txt", "test3.txt");
        //$zip->addFile("./uploads/".$fileName."/test3.txt", "tes2.txt");
        for ($i=2; $i < $countFiles; $i++) {
            $path = $dirPath.'/'.$showAllFiles[$i];
            $zip->addFile($path, $showAllFiles[$i]);
        }
        $zip->close();
        //foreach ($files as $file) 
        
        
        
            // header('Content-Disposition: " "); <- must be set
        header('Content-Description: File Transfer');
        header('Content-Disposition: Downloaded file filename=$fileName ');
        header('Cache-control: must-revalidate');           // public, private
        header('Content-Type: application/zip');            // -> watch other MIME types
        header('Content-Length: ' . filesize($zipname));        
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Transfer-Encoding: Binary");
        
        readfile($zipname);     // czyta plik - sciaga go na dysk
        unlink($zipname);       // usuwa utworzonego zipa
        exit;
    }


    

?>