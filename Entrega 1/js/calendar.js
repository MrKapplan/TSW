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


$(document).ready(function () {
    //  kendo.culture("es-ES");
    // create Calendar from div HTML element
    $("#calendar").kendoCalendar({
        selectable: "multiple"
    });

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

                removeInputs(clickedDate.toLocaleDateString());
                removeInputs(clickedDate.toLocaleDateString());

            } else {
                selectedDates.push(clickedDate);

                var startTime = document.createElement("input");
                startTime.type = "time";
                startTime.id = clickedDate.toLocaleDateString();
                document.getElementById('inputsFECHA').appendChild(startTime);

                var endTime = document.createElement("input");
                endTime.type = "time";
                endTime.id = clickedDate.toLocaleDateString();
                document.getElementById('inputsFECHA').appendChild(endTime);
            }
            calendar.selectDates(selectedDates);
        }
    });
    removeDiv('k-footer');
});


