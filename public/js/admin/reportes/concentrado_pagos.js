let _SERVERPATH;

$(document).ready(function(){

    let path = window.location.pathname;
    _SERVERPATH = "";
    if(path.indexOf("/admin/reportes/concentrado_pagos_por_mes") > -1) {
        let idx = path.indexOf("admin/reportes/concentrado_pagos_por_mes");
        _SERVERPATH = path.substring(0, idx) + "";
    }

    $("#btnExportExcel").click(function(){
        exportExcel();
    });

});


function exportExcel(){


    let idStatus        = $("#idStatus").val();
    let txtBuscar       = $("#txtBuscar").val();
    let yearIni         = $("#yearIni").val();

    window.open(_SERVERPATH+'admin/reportes/concentrado_pagos_por_mes/export?idStatus='+idStatus+'&txtBuscar='+txtBuscar+'&yearIni='+yearIni,'_blank');
}

