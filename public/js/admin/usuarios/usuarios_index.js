let _SERVERPATH;

$(document).ready(function(){

    let path = window.location.pathname;
    _SERVERPATH = "";
    if(path.indexOf("/admin/usuarios") > -1) {
        let idx = path.indexOf("admin/usuarios");
        _SERVERPATH = path.substring(0, idx) + "";
    }



    $("#btnExportExcel").click(function(){
        exportExcel();
    });

});

function exportExcel(){
    let idStatusUsuario        = $("#idStatus").val();
    let txtBuscar        = $("#txtBuscar").val();

    window.open(_SERVERPATH+'admin/usuarios/export?idStatusUsuario='+idStatusUsuario+'&txtBuscar='+txtBuscar,'_blank');
}
