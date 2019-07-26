<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    define("uploads", "/uploads/");
    // Wyswietla wszystkie pliki - uzyte jest w html przy tabeli 
    // scandir()    <- List files and directories inside the specified path
    // dirname() 	<- Returns a parent directory's path
    // getcwd()     <- Gets the current working directory (in this case: ./up)
    define("dirCount", count(scandir(dirname(getcwd()).uploads)));


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

    if (!empty($_GET['delete'])) {
        deleteDir();
        header("Location: ./");
    }

    // Pobierz pliki
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
    
    if (!empty($_GET['file'])) {
        getFiles();
    }

?>