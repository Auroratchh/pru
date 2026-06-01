
$(document).ready(function(){

    $("#datetimepicker1").datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        viewMode: 'years',
        useCurrent: false,
        ignoreReadonly:true,
        defaultDate:moment()
    });

    form_sumit();

});


/********************************************************************************************************
 ********************************************** GENERALES ***********************************************
 ********************************************************************************************************/




function form_sumit(){

    $("#FormEdit").validate({
        errorClass: "invalid-feedback",
        validClass: "has-success",
        errorElement: "span",
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length || element.parent('.custom-checkbox').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).closest('.form-control').addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            bootbox.confirm("Estas a punto de actualizar el gasto, ¿Deseas continuar?", function (result) {
                    if(result)
                    {
                        show_loading();
                        form.submit();
                    }
                });
        },
        rules: {
            idTipoGasto:            { required: true},
            gasto:                  { required: true},
            fechaGasto:             { required: true},
            monto:                  { required: true, number:true},
        },
        messages: {
            idTipoGasto:            { required: "Requerido" },
            gasto:                  { required: "Requerido"},
            fechaGasto:             { required: "Requerido" },
            monto:                  { required: "Requerido" , number: "Solo Números" },
        }

    });
}
