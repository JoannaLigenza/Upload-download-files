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
            <div id="uploaded-files-text"> <?php if (file_exists("uploaded-files-text.txt")) { echo readfile("uploaded-files-text.txt");} ?>
            </div>   
        </fieldset>
        
    </form>
        <!-- getcwd() <- get current working directory // scandir() <- List files and directories inside the specified path -->
    
    <table border="1">
        <!-- <caption>Table Title</caption> -->
        <thead class="green-color">
            <tr> 
                <th class="desktop-visible"> Num:</th> 
                <th> Directory name:</th> 
                <th class="files-in-dir"> Files in directory:</th> 
                <th class='toggle-col'> Download:</th> 
                <th class='toggle-col'> Delete:</th> 
            </tr>
        </thead>
        <tbody>
            <!-- $i=0 => . // $i=1 => .. -->
            <?php 
            for ($i=2; $i<dirCount; $i++) {  
                    //  <tr> <td> <?php echo $i-1 </td> <td>  </td> </tr> 
                    $name = scandir(getcwd()."/uploads")[$i];
                    echo "<tr class='toggle-row-click'> <td class='desktop-visible'>" . ($i-1) . "</td> <td class='dir-name'> " . $name . "</td> <td> " . (count(scandir(getcwd()."/uploads/".$name)) -2 ). "</td> <td class='toggle-col'> <a href='./?file=$name'> <img src='img/download.svg' alt='heart-icon' title='Download file'></a>" . "" . "</td> <td class='toggle-col'><a href='./?delete=$name'> <img src='img/delete.svg' alt='heart-icon' title='Delete file' name='delete-button'></a></td> </tr>";
                    echo "<tr class='toggle-row hidden'>  <td class='blue-color'> <a href='./?file=$name'> <img src='img/download.svg' alt='download-icon' title='Download file'></a> </td>    <td class='red-color'> <a href='./?delete=$name'> <img src='img/delete.svg' alt='delete-icon' title='Delete file' name='delete-button'></a>    </td> </tr>";
            } ?>
        </tbody>
    </table>
    
<script src="script.js"></script>
</body>
</html>

