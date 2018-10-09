function removeDiv(idElement) {
    kfooter = document.getElementsByClassName(idElement);

    for (var i = 0; i < kfooter.length; i++) {
        padre = kfooter[i].parentNode;
        padre.removeChild(kfooter[i]);
    }
}


function removeInputs(idInput) {
    input = document.getElementById(idInput);
    if (!input) {
        alert("El elemento selecionado no existe");
    } else {
        hh = input.parentNode;
        hh.removeChild(input);

    }
}


function addTable(idContainer) {

    var table = document.createElement("table");
    table.id = "idTable";
    table.className = "table text-center";
    document.getElementById(idContainer).appendChild(table);

    var thead = document.createElement("thead");
    thead.id = "thead";
    document.getElementById(table.id).appendChild(thead);

    var tr = document.createElement("tr");
    tr.id = "tr";
    document.getElementById(thead.id).appendChild(tr);

    var th = document.createElement("th");
    th.scope = "col";
    document.getElementById(tr.id).appendChild(th);

    var th1 = document.createElement("th");
    th1.scope = "col";
    th1.appendChild(document.createTextNode('Hora Inicio'));
    document.getElementById(tr.id).appendChild(th1);

    var th2 = document.createElement("th");
    th2.scope = "col";
    th2.appendChild(document.createTextNode('Hora Fin'));
    document.getElementById(tr.id).appendChild(th2);

    var tbody = document.createElement("tbody");
    tbody.id = "tbody";
    document.getElementById(table.id).appendChild(tbody);


    var boton = document.createElement("button");
    boton.type = "button";
    boton.className = "btn btn-dark";
    boton.value = "Guardar";
    boton.appendChild(document.createTextNode("Guardar"));
    document.getElementById(idContainer).appendChild(boton);





}

function fillTable(newElement, idElement, fatherElement) {
    var newTr = document.createElement(newElement);
    newTr.id = idElement;
    var tbodyFather = document.getElementById(fatherElement);
    tbodyFather.appendChild(newTr);
    var tdElement;
    var inputTable;

    for (var i = 0; i < 3; i++) {
        if (i == 0) {
            tdElement = document.createElement("td");
            newTr.appendChild(tdElement);
            tdElement.innerHTML = idElement;
    } else {
        tdElement = document.createElement("td");
        newTr.appendChild(tdElement);
        inputTable = document.createElement("input");
        inputTable.type = "time";
        tdElement.appendChild(inputTable);
    } 
}
    tdElement=document.createElement("td");
    newTr.appendChild(tdElement);
    var boton = document.createElement("button");
    boton.type = "button";
    boton.className = "btn btn-success";
    boton.value = "-";
    boton.onclick = function () { addRow() };
    boton.appendChild(document.createTextNode("+"));
    tdElement.appendChild(boton);


    var newTr2 = document.createElement(newElement);
    newTr2.id = idElement;
    newTr.appendChild(newTr2);

    tdElement = document.createElement("td");

    tdElement2 = document.createElement("td");
    newTr2.appendChild(tdElement2);
    inputTable = document.createElement("input");
    inputTable.id= "timeStart";

    
    tdElement3 = document.createElement("td");
    newTr2.appendChild(tdElement3);
    inputTable2 = document.createElement("input");
    inputTable2.id= "timeEnd";



}


function addFatherDiv(newElement, idElement, oldElement) {
    var inputDiv = document.createElement(newElement);
    inputDiv.id = idElement;

    /*
        var divCalendar = document.getElementById(oldElement);
        parentDiv = divCalendar.parentNode;
        parentDiv.insertBefore(inputDiv, divCalendar);
        */

    var div = document.getElementsByClassName("demo-section k-content");

    for ($i = 0; i < div.length; $i++) {
        div[i].id.appendChild(inputDiv);
    }


}


function addFatherDiv2(newElement, idElement) {
    var inputDiv = document.createElement(newElement);
    inputDiv.id = idElement;

    var div = document.getElementsByClassName("demo-section k-content");

    for (var i = 0; i < div.length; i++) {
        div[i].appendChild(inputDiv);
    }


}


function addSonDiv(newElement, idElement, oldElement) {
    var inputDiv = document.createElement(newElement);
    inputDiv.id = idElement;
    document.getElementById(oldElement).appendChild(inputDiv);

}


$(document).ready(function () {
    //  kendo.culture("es-ES");
    // create Calendar from div HTML element
    $("#calendar").kendoCalendar({
        selectable: "multiple"
    });


    addFatherDiv2("div", "timeContainer");
    addTable("timeContainer");

    $("#calendar").on("mousedown", "td", function (e) {

        // get item if the user clicked on an item template
        var clickedItem = $(e.target).closest("td[role='gridcell']");

        // prevent click event for item elements
        clickedItem.on("click", function (e) {
            e.stopPropagation();
            e.preventDefault();
        });


        if (clickedItem.length > 0) {
            var calendar = $("#calendar").getKendoCalendar();
            var clickedDateString = clickedItem.children("a")[0].title;
            var clickedDate = new Date(clickedDateString);

            var selectedDates = calendar.selectDates();


            if (clickedItem.hasClass("k-state-selected")) {
                // if date is already selected - remove it from collection
                selectedDates = $.grep(selectedDates, function (item, index) {
                    return clickedDate.getTime() !== item.getTime();
                });

                // removeInputs(clickedDate.toLocaleDateString());
                //removeInputs(clickedDate.toLocaleDateString());
                removeInputs(clickedDate.toLocaleDateString());

            } else {
                selectedDates.push(clickedDate);





                ////////DESDE AQUI PARA RELLENAR LA TABLA

                /*addSonDiv("div", clickedDate.toLocaleDateString(), "timeContainer");*/

                fillTable("tr", clickedDate.toLocaleDateString(), "tbody");

                /*
                var startTime = document.createElement("input");
                startTime.type = "time";
                startTime.id = clickedDate.toLocaleDateString();
                document.getElementById(clickedDate.toLocaleDateString()).appendChild(startTime);

                var endTime = document.createElement("input");
                endTime.type = "time";
                endTime.id = clickedDate.toLocaleDateString();
                document.getElementById(clickedDate.toLocaleDateString()).appendChild(endTime);*/

            }
            calendar.selectDates(selectedDates);
        }
    });
    removeDiv('k-footer');
});