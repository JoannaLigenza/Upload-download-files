document.addEventListener('DOMContentLoaded', function() {

    // Shows and hides rows and cells of the table - depends on screen size
    function showHideTableParts() {
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
    }
    
    showHideTableParts();

});


