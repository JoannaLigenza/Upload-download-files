document.addEventListener('DOMContentLoaded', function() {

        // Shows message with quantity of uploaded files
    function showMessage() {
        const fileInput = document.getElementById("upload-file");
        fileInput.onchange = function() {
            const showUploadedFiles = document.getElementById("uploaded-files-text");
            const filesNum = document.getElementById("upload-file").files;
            let fileText = "Selected " + filesNum.length + " files";
            if (filesNum.length === 1) {
                fileText = "Selected " + filesNum.length + " file";
            }
            showUploadedFiles.innerText = fileText;
        }
    }

    showMessage();

    
    // Shows progress bar
    function showProgressBar() {
        document.getElementById("form").addEventListener("submit", function() {
            const filesNum = document.getElementById("upload-file").files;
            if ( filesNum.length > 0 ) {
                showProgress();
            }
        });
    }

    function showProgress() {
        const form = document.getElementById("form");
        const progressValue = document.getElementById("progress-value");
        const progressText= document.getElementById("progress-text");
        const progressBar = document.getElementById("progress-bar");

        // Makes progress bar visible
        progressBar.classList.remove("hidden");
        
        // Shows progress on progress bar 
        const xhr = new XMLHttpRequest;
        xhr.open("POST", "functions.php");
        xhr.upload.addEventListener("progress", function(e) {
            //console.log(e);
            const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;

            progressValue.style.width = percent.toFixed(2) + "%";
            progressText.textContent = parseInt(percent) + "%";
        });
        xhr.setRequestHeader("Content-Type", "multipart/form-data");
        xhr.send(new FormData(form));
    }

    showProgressBar();
    
    //console.log(window.location.pathname);
});


