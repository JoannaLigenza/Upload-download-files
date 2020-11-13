<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    function fileExtensions() {
        $extensions = 'jpg|jpeg|png|gif|tif|tiff|bmp|eps|psd|raw|heic|heif|webp|exif';
        return $extensions;
    }

    define("uploads", "/uploads/");
    define("readFiles", "/read-files/");
    // scandir()    <- List files and directories inside the specified path
    // dirname() 	<- Returns a parent directory's path
    // getcwd()     <- Gets the current working directory (in this case: ./up)

    function validateFileName($fileName) {
        $result = false;
        $fileExtensions = fileExtensions();
        for ($i=0; $i < count($fileName); $i++) {
            if ( preg_match('/^[a-z0-9-ąćęłńóśżź_\s]{1,}[.]{1}('.$fileExtensions.')$/i', $fileName[$i]) ) {
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
	foreach($showAllFiles as $file){
	    if(is_file($dirPath.'/'.$file))  unlink($dirPath.'/'.$file);
	}
        rmdir($dirPath);
    }

    // Count files in directory
    function countFiles($path) {
	if (!(is_dir($path))) return 0;
	$showAllFiles = scandir($path);
        $countFiles = count($showAllFiles);
	return ($countFiles - 2) ;
    }
   
    // Download files
    function getFiles() {
        // basename() <- Zwraca końcową nazwę komponentu ścieżki
        $fileName = basename($_GET['file']);
        $dirPath = "..".uploads.$fileName;

	if (!(is_dir($dirPath))) return 0;        
        $showAllFiles = scandir($dirPath);
        $countFiles = count($showAllFiles);
        $zipname = $fileName.'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        //$zip->addFile("./uploads/2019-07-25_15-10-05/test3.txt", "test3.txt");
        //$zip->addFile("./uploads/".$fileName."/test3.txt", "tes2.txt");
        //for ($i=2; $i < $countFiles; $i++) {
	foreach($showAllFiles as $file){
            if(is_file($dirPath.'/'.$file)) {
            $path = $dirPath.'/'.$file;
            $zip->addFile($path, $file);
            }
        }
        $zip->close();
        //foreach ($files as $file) 
        
        
        
            // header('Content-Disposition: " "); <- must be set
        header('Content-Description: File Transfer');
        //header('Content-Disposition: Downloaded file filename=$fileName ');
        header('Content-Disposition: attachment; filename="'.basename($zipname).'"');
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
