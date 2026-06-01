
$(document).ready(function(){

    form_sumit();

});


/********************************************************************************************************
 ********************************************** GENERALES ***********************************************
 ********************************************************************************************************/




function form_sumit(){

    $("#FormUpdatePassword").validate({
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
            bootbox.confirm("Estas a punto de cambiar la contraseña, ¿Deseas continuar?", function (result) {
                    if(result)
                    {
                        show_loading();
                        form.submit();
                    }
                });
        },
        rules: {
            password:                       { required: true, maxlength: 12, minlength: 6 },
            password_confirmation:          { equalTo: "#password"}
        },
        messages: {
            password:                       { required: "Requerido", maxlength: "Máximo 12 caracteres", minlength: "Minimo 6 caracteres"},
            password_confirmation:          { equalTo: "Password y Repetir Password deben coincidir."}
        }

    });
}
