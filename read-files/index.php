<?php 
    include "../functions.php" ;
    $dirCount = countFiles(dirname(getcwd()).uploads); 


    if (!empty($_GET['delete'])) {
        deleteDir();
        header("Location: ./");
    }
    
    if (!empty($_GET['file'])) {
        getFiles();
    }

echo('
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Read files</title>
    <link rel="stylesheet" href="../style.css">
    
</head>
<body>

        <!-- getcwd() <- get current working directory // scandir() <- List files and directories inside the specified path -->
    <table border="1">
        <!-- <caption>Table Title</caption> -->
        <thead class="green-color">
            <tr> 
                <th class="desktop-visible"> Num:</th> 
                <th> Directory name:</th> 
                <th class="files-in-dir"> Files in directory:</th> 
                <th class="toggle-col"> Download:</th> 
                <th class="toggle-col"> Delete:</th> 
            </tr>
        </thead>
        <tbody>
');
            // $i=0 => . // $i=1 => ..
            for ($i=2; $i<$dirCount+2; $i++) {  
                    $name = scandir(dirname(getcwd()).uploads)[$i];
                    echo "<tr class='toggle-row-click'> <td class='desktop-visible'>" . ($i-1) . "</td> <td class='dir-name'> " . $name . "</td>";
                    echo " <td> " . (countFiles(dirname(getcwd()).uploads.$name)  ). "</td>";
                    echo "<td class='toggle-col'> <a href='./?file=$name'> <img src='../img/download.svg' alt='heart-icon' title='Download file'></a>" . "" . "</td>";
                    echo " <td class='toggle-col'><a href='./?delete=$name'> <img src='../img/delete.svg' alt='heart-icon' title='Delete file' name='delete-button'></a></td> </tr>";
                    echo "<tr class='toggle-row hidden'>  <td class='blue-color'> <a href='./?file=$name'>";
                    echo " <img src='../img/download.svg' alt='download-icon' title='Download file'></a> </td>";
                    echo " <td class='red-color'> <a href='./?delete=$name'> <img src='../img/delete.svg' alt='delete-icon' title='Delete file' name='delete-button'></a>    </td> </tr>";
            } 
echo (' 
        </tbody>
    </table>
    
<script src="script.js"></script>
</body>
</html>
')  
?>
