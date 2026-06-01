
$(document).ready(function(){


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
            bootbox.confirm("Estas a punto de actualizar el perfil, ¿Deseas continuar?", function (result) {
                    if(result)
                    {
                        show_loading();
                        form.submit();
                    }
                });
        },
        rules: {
            nombre:                         { required: true, maxlength:255},
            apellidoPaterno:                { required: true, maxlength:255},
            apellidoMaterno:                { required: false, maxlength:255},

            fechaNacimiento:                { required: true},
            celular:                        { required: false},
            idSexo:                         { required: true},
            email:                          { required:true,  email: true }
        },
        messages: {
            nombre:                         { required: "Requerido", maxlength:"Máximo 255 caracteres."},
            apellidoPaterno:                { required: "Requerido", maxlength:"Máximo 255 caracteres."},
            apellidoMaterno:                { required: "Requerido", maxlength:"Máximo 255 caracteres."},

            fechaNacimiento:                { required: "Requerido"},
            celular:                        { required: "Requerido"},
            idSexo:                         { required: "Requerido"},
            email:                          { required: "Requerido", email:"Formato no válido"}
        }

    });
}
