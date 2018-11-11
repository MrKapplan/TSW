
$(document).ready(function()
{
    $('#date-es').bootstrapMaterialDatePicker
    ({
        format: 'DD/MM/YYYY',
        lang: 'es',
        time: false,
        weekStart: 1, 
        nowButton : true,
        switchOnClick : true,
        minDate : new Date()

    });

    $('#timeStart').bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: false,
        format: 'HH:mm'
    });


    $('#timeEnd').bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: false,
        format: 'HH:mm'
    });

    $.material.init()
});









function calendar(id){

    $('#date-es'+id).bootstrapMaterialDatePicker
    ({
        format: 'DD/MM/YYYY',
        lang: 'es',
        time: false,
        weekStart: 1, 
        nowButton : true,
        switchOnClick : true,
        minDate : new Date()

    });

    $('#timeStart'+id).bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: false,
        format: 'HH:mm'
    });


    $('#timeEnd'+id).bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: false,
        format: 'HH:mm'
    });

}
