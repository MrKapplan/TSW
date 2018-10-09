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

    var timeStart = document.createElement("input");
    timeStart.type = "time";
    timeStart.name = "timeStart";
    document.getElementById('tbody').appendChild(timeStart);

    var timeEnd = document.createElement("input");
    timeEnd.type = "time";
    timeEnd.name = "timeEnd";
    document.getElementById('tbody').appendChild(timeEnd);

    var table = document.getElementById('idTable');
    var rowCount = table.rows.length-1;
    var row = table.insertRow(rowCount+1);


    var cell = row.insertCell(0);
    cell.appendChild(boton);
    var cell1 = row.insertCell(1);
    cell1.appendChild(timeStart);
    var cell2 = row.insertCell(2);
    cell2.appendChild(timeEnd);

}

function removeCheckbox(tableId) {
    var fila = document.getElementsByClassName("table-success"); //Array with a one element (tr's id)

    for (var i = 0; i < fila.length; i++) {
        document.getElementById(fila[i].id).setAttribute("class", ""); //Set tr deleting the class (table-success)
    }
}


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

function createCell(cell, text, style) {

    var label = document.createElement('label');
    label.className = "checkbox";
    document.getElementById('addCol').appendChild(label);

    var checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.checked;
    checkbox.onclick = "return false;";
    label.appendChild(checkbox);

    var span = document.createElement('span');
    span.className = "success";
    label.appendChild(span);

    cell.appendChild(label);

}

function appendColumn(dataTable, idButton) {
    var table = document.getElementById(dataTable),
        i;

    for (i = 1; i < table.rows.length; i++) {
        createCell(table.rows[i].insertCell(table.rows[i].cells.length), i, 'col');
    }
    removeButton(idButton);
}


function checkboxes(tableId) {

    var table = document.getElementById(tableId);
    var rowCount = table.rows.length - 1;                     //Number of row (-1 for not counting the table titles)
    var inputElems = document.getElementsByTagName("input");  //Array one dimensional with the inputs (input link poll included)
    var numInputsForRow = (inputElems.length - 1) / rowCount; //Number of inputs for Row (-1 for not counting the link poll input)
    var count = 0, max = 0, maxAbs = 0, trSelected = -1, trSelectedArray = new Array(); 


    for (var j = 1; j < inputElems.length; j++) {
        if (inputElems[j].type === "checkbox" && inputElems[j].checked) {
            count++;
        }
        if (j % numInputsForRow == 0) {  //Separate the elements of each row
            if (count > maxAbs) {
                max = count;
                maxAbs = count;
                trSelected = inputElems[j].parentNode.parentNode.parentNode.id; //trSelected is the id of the row that has the maximum number of checkbox checked
            } else if (count == max) {
                max = -1;
            }
           // console.log("HOLA" + count);
            count = 0;
        }
    }

   
    if (trSelected != -1 && max != -1) {
        document.getElementById(trSelected).setAttribute("class", "table-success"); //Modified the class of div
    }
    



   //Iterate the inputs elements again and check if there is more than one row withe the maximum number of checkbox
    for (var j = 1; j < inputElems.length; j++) { 
        if (inputElems[j].type === "checkbox" && inputElems[j].checked) {
            count++;
        }
        if (j % numInputsForRow == 0) {  
            if (count == maxAbs) { //if count (of row) is equal to the maximux push this row id in a array.
                trSelectedArray.push(inputElems[j].parentNode.parentNode.parentNode.id);
            } 
            count = 0;
        }
    }

    if(trSelectedArray.length > 1){ //if the array with de row's id have more than 1 element, remove the old modification (table-success) and insert table-warning in this rows.
        removeCheckbox(tableId);
        for(var y=0; y<trSelectedArray.length; y++){
            document.getElementById(trSelectedArray[y]).setAttribute("class", "table-warning"); //Modified the class of div when several options are tied 
        }
    } 
}

function validateCheckboxes() {

    var checkboxChecked = [];
    var checkbox = document.getElementsByName('assignation');

    for (var i = 0; i < checkbox.length; i++) {
        if (checkbox[i].checked) {
            checkboxChecked.push(checkbox[i].value);
        }
    }

    //var arv = checkboxChecked.toString();
    //alert(arv);
    document.getElementById("hidden").value = checkboxChecked;

}