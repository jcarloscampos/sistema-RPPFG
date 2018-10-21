var listaAreasSubareas = document.getElementById('listaAreasSubareas'); /* finds the input */

function changeLabelText() {
    var listaAreasSubareasValue = listaAreasSubareas.value; /* gets the filepath and filename from the input */
    var fileNameStart = listaAreasSubareasValue.lastIndexOf('\\'); /* finds the end of the filepath */
    listaAreasSubareasValue = listaAreasSubareasValue.substr(fileNameStart + 1); /* isolates the filename */
    var listaAreasSubareasLabelText = document.querySelector('label[for="listaAreasSubareas"]').childNodes[2]; /* finds the label text */
    if (listaAreasSubareasValue !== '') {
        listaAreasSubareasLabelText.textContent = listaAreasSubareasValue; /* changes the label text */
    }
}

listaAreasSubareas.addEventListener('change',changeLabelText,false); /* runs the function whenever the filename in the input is changed */