<?php include "functions.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <!-- name of input must have [] in name if you want to upload multiply files  -->
        <fieldset>
            <label for="upload-file" class="button-input"> <img src='img/file.svg' alt='file-icon' title='Download file'> Select Files</label>
            <input type="file" multiple name="file-name[]" id="upload-file"/>    
            <label for="submit" class="button-input"> <img src='img/upload.svg' alt='upload-icon' title='Download file'> Upload Files</label>
            <input type="submit" name="get-button" id="submit">
            <div id="uploaded-files-text"> 
                <?php 
                    if (file_exists("uploaded-files-text.txt")) { 
                        //echo readfile("uploaded-files-text.txt");
                        $filename = "uploaded-files-text.txt";
                        $handle = fopen($filename, "r");
                        $contents = fread($handle, filesize($filename));
                        echo $contents;
                        fclose($handle);
                    } 
                ?>
            </div>   
        </fieldset>
        
    </form>
    
<script src="script.js"></script>
</body>
</html>

