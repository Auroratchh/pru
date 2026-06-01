$(document).ready(function(){

    $(".btnDelete").on("click",function(){
        let form = $( this ).parent("form");

        bootbox.confirm({
            message: "Se eliminará el Gasto, ¿Desea continuar?",
            locale: 'es',
            callback: function (result) {
                if(result)
                {
                    show_loading();
                    form.submit();
                }
            }
        });

    });



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

});
