let _SERVERPATH;

$(document).ready(function(){

    let path = window.location.pathname;
    _SERVERPATH = "";
    if(path.indexOf("/admin/reportes/corte_caja") > -1) {
        let idx = path.indexOf("admin/reportes/corte_caja");
        _SERVERPATH = path.substring(0, idx) + "";
    }


    $("#datetimepicker1").datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        viewMode: 'years',
        useCurrent: false,
        ignoreReadonly:true
    });

    $("#datetimepicker2").datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        viewMode: 'years',
        useCurrent: false,
        ignoreReadonly:true
    });


    $("#btnExportExcel").click(function(){
        exportExcel();
    });

});


function exportExcel(){

    let fechaIni        = $("#fechaIni").val();
    let fechaFin        = $("#fechaFin").val();

    window.open(_SERVERPATH+'admin/reportes/corte_caja/export?fechaIni='+fechaIni+'&fechaFin='+fechaFin,'_blank');
}

