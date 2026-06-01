
$(document).ready(function(){

    form_sumit();

});


/********************************************************************************************************
 ********************************************** GENERALES ***********************************************
 ********************************************************************************************************/




function form_sumit(){

    $("#FormCreatePago").validate({
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
            bootbox.confirm("Estas a punto de registrar un pago, ¿Deseas continuar?", function (result) {
                    if(result)
                    {
                        show_loading();
                        form.submit();
                    }
                });
        },
        rules: {
            idMembresia:           { required: true},
            idFormaPago:           { required: true},
            fechaPago:             { required: true},
            fechaVigencia:         { required: true},
            monto:                 { required: true, number:true},
        },
        messages: {
            idMembresia:           { required: "Requerido"},
            idFormaPago:           { required: "Requerido" },
            fechaPago:             { required: "Requerido" },
            fechaVigencia:         { required: "Requerido" },
            monto:                 { required: "Requerido" , number: "Solo Números" },
        }

    });
}
