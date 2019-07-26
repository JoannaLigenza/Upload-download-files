document.addEventListener('DOMContentLoaded', function() {
    const toggleRow = document.getElementsByClassName("toggle-row-click");
    for (i=0; i< toggleRow.length; i++) {
        toggleRow[i].addEventListener("click", (e) => {
            // console.log(e.target.closest("tr"));
            const sibling = e.target.closest("tr").nextSibling;
            if (sibling.classList.contains("hidden")) {
                // console.log('pokaz')
                sibling.classList.remove("hidden");
                sibling.classList.add("visible");
                e.target.closest("tr").classList.add("gray-color");
            } else {
                // console.log('ukryj')
                sibling.classList.remove("visible");
                sibling.classList.add("hidden");
                e.target.closest("tr").classList.remove("gray-color");
            }
            
        })
    }

    document.getElementById("upload-file").onchange = function() {
        const showUploadedFiles = document.getElementById("uploaded-files-text");
        const filesNum = document.getElementById("upload-file").files;
        let fileText = "Selected " + filesNum.length + " files";
        if (filesNum.length === 1) {
            fileText = "Selected " + filesNum.length + " file";
        }
        showUploadedFiles.innerText = fileText;
        // for (let i=0; i< filesNum.length; i++) {
        //     showUploadedFiles.innerText += filesNum[i].name + ",  ";
        //     console.log(filesNum[i].name);
        // }
    }
    
    // document.getElementById('submit').addEventListener("click", () => {
    //     document.getElementById("uploaded-files-text").innerText = "" ;
    // });


});


