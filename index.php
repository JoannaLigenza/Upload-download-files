<?php 
    include "functions.php"; 

    $message = "";

    if (isset($_POST["get-button"])) {
        $fileName = $_FILES['file-name']['name'];
        $countFiles = count($fileName);
        if ( ! empty( $fileName[0] ) ) {
            if ( validateFileName($fileName) ) {
                $message = uploadFiles($fileName);
            } else {
                $message = 'Change file name before uploading it. <br> File name can only contain letters, digits, space, dash and underscore characters.';
            }
        } else {
            $message = 'Choose file to upload first';
        }
    }

?>
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
    <form action="index.php" method="post" enctype="multipart/form-data" id="form">
        <!-- name of input must have [] in name if you want to upload multiply files  -->
        <fieldset>
            <label for="upload-file" class="button-input"> <img src="img/file.svg" alt="file-icon" title="Download file"> Select Files</label>
            <input type="file" multiple name="file-name[]" id="upload-file"/>    
            <label for="submit" class="button-input"> <img src="img/upload.svg" alt="upload-icon" title="Download file"> Upload Files</label>
            <input type="submit" name="get-button" id="submit">
            
            <div id="uploaded-files-text">
<?php
    echo $message;
?>
            </div>
            <div id="progress-bar" class="hidden">   
                <label for="progress" class="progress-label"> File progress: </label>
                <div id="progress" value="10" max="100">
                    <div id="progress-value">
                    </div>
                    <p id="progress-text">0%</p>
                </div>
            </div>
            <h3 id="status"></h3>
            <p id="loaded_n_total"></p>
        </fieldset>
    </form>
<script src="script.js"></script>
</body>
</html>

