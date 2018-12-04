
//Function to delete a button 
function removeButton(idButton) {
    button = document.getElementById(idButton);
    if (!button) {
        alert("El elemento selecionado no existe");
    } else {
        hh = button.parentNode;
        hh.removeChild(button);
        var nestedDiv = document.getElementById('user').innerHTML = "Tú";
    }
}



function valueData() {

   
	
    document.getElementById('gaps').value = JSON.stringify(dataArray);
}