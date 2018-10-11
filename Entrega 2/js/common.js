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

    // var date = document.createElement("input");
    // date.type = "text";
    // date.id = "date-es";
    // document.getElementById('inputDate').appendChild(date);


    var divGrandFatherTimeStart = document.createElement("div");
    divGrandFatherTimeStart.id= "inputTime";
    document.getElementById("inputTime").appendChild(divGrandFatherTimeStart);

    var divFatherTimeStart = document.createElement("div");
    divFatherTimeStart.className= "inputWithIconLogin inputIconBg";
    document.getElementById( divGrandFatherTimeStart.id).appendChild(divFatherTimeStart);

    var timeStart = document.createElement("input");
    timeStart.type = "text";
    timeStart.id = "timeStart";
    document.getElementById('inputTime').appendChild(timeStart);

    var tag = document.createElement("i");
    tag.className = "fa fa-clock-o fa-lg fa-fw";
    document.getElementById(timeStart.id).appendChild(tag);


    

    var timeEnd = document.createElement("input");
    timeEnd.type = "text";
    timeEnd.id = "timeEnd";
    document.getElementById('inputTime').appendChild(timeEnd);




    var table = document.getElementById('dataTable');
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell = row.insertCell(0);
    cell.appendChild(boton);
    var cell1 = row.insertCell(1);
    //cell1.appendChild(date);
    var cell2 = row.insertCell(2);
    cell2.appendChild(divGrandFatherTimeStart);
    var cell3 = row.insertCell(3);
    cell3.appendChild(timeEnd);

}



function removeCheckboxSuccess() {
    var filaSuccess = document.getElementsByClassName("table-success"); //Array with a one element (tr's id)
    var filaWarning = document.getElementsByClassName("table-warning"); //Array with a one element (tr's id)

    for (var i = 0; i < filaSuccess.length; i++) {
        document.getElementById(filaSuccess[i].id).setAttribute("class", ""); //Set tr deleting the class (table-success)
    }
}


function removeCheckboxWarning() {
    var filaWarning = document.getElementsByClassName("table-warning"); //Array with a one element (tr's id)

    for (var i = 0; i < filaWarning.length; i++) {
        document.getElementById(filaWarning[i].id).setAttribute("class", ""); //Set tr deleting the class (table-success)
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
    var numInputsForRow = (inputElems.length - 2) / rowCount; //Number of inputs for Row (-1 for not counting the link poll input)
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
            count = 0;
        }
    }

    if (trSelected != -1 && max != -1) {
        removeCheckboxWarning();
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
        removeCheckboxSuccess();
        removeCheckboxWarning();
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



