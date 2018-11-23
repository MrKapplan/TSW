function deleteRow(row) {
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById('dataTable').deleteRow(i);
}


function addRow() {


    var boton = document.createElement("button");
    boton.type = "button";
    boton.className = "btn btn-danger";
    boton.value = "-";
    boton.onclick = function () { deleteRow(this) };
    boton.appendChild(document.createTextNode("-"));


    var divDate = document.createElement("div");
    divDate.className = "inputDate";

    var divIcon = document.createElement("div");
    divIcon.className = "inputWithIconLogin inputIconBg";
    divDate.appendChild(divIcon);

    var inputDate = document.createElement("input");
    inputDate.type ="text";
    inputDate.id = "date-es";
    inputDate.className = "date";
    inputDate.required = true;
    divIcon.appendChild(inputDate);


    var iconDate = document.createElement("i");
    iconDate.className = "fa fa-calendar fa-lg fa-fw";
   divIcon.appendChild(iconDate);



    var divTimeStart = document.createElement("div");
    divTimeStart.className = "inputTime";

    var divIcon2 = document.createElement("div");
    divIcon2.className = "inputWithIconLogin inputIconBg";
    divTimeStart.appendChild(divIcon2);

    var inputTimeStart = document.createElement("input");
    inputTimeStart.type ="text";
    inputTimeStart.className = "timeStart";
    inputTimeStart.required = true;
    divIcon2.appendChild(inputTimeStart);


    var iconTimeStart = document.createElement("i");
    iconTimeStart.className = "fa fa-clock-o fa-lg fa-fw";
    divIcon2.appendChild(iconTimeStart);


    

    var divTimeEnd = document.createElement("div");
    divTimeEnd.className = "inputTime";

    var divIcon3 = document.createElement("div");
    divIcon3.className = "inputWithIconLogin inputIconBg";
    divTimeEnd.appendChild(divIcon3);

    var inputTimeEnd = document.createElement("input");
    inputTimeEnd.type ="text";
    inputTimeEnd.className = "timeEnd";
    inputTimeEnd.required = true;
    divIcon3.appendChild(inputTimeEnd);


    var iconTimeEnd = document.createElement("i");
    iconTimeEnd.className = "fa fa-clock-o fa-lg fa-fw";
    divIcon3.appendChild(iconTimeEnd);


    var table = document.getElementById('dataTable');
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell = row.insertCell(0);
    
    var cell1 = row.insertCell(1);
    cell1.appendChild(divDate);
    var cell2 = row.insertCell(2);
    cell2.appendChild(divTimeStart);
    var cell3 = row.insertCell(3);
    cell3.appendChild(divTimeEnd);
    var cell4 = row.insertCell(4);
    cell4.appendChild(boton);

}


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

    var dataArray = [];
    var inputsDate = document.getElementsByClassName('date');
    var inputsTimeStart = document.getElementsByClassName('timeStart');
    var inputsTimeEnd = document.getElementsByClassName('timeEnd');

    for (var i = 0; i < inputsDate.length; i++) {
        dataArray.push({"date":inputsDate[i].value, "start": inputsTimeStart[i].value.toString(), "end": inputsTimeEnd[i].value.toString()});
    }
	
    document.getElementById('gaps').value = JSON.stringify(dataArray);
}