$(document).ready(function (){

    $(".btnDelete").on("click",function(){
        let form = $( this ).parent("form");

        bootbox.confirm({
            message: "Se eliminará el Pago, ¿Desea continuar?",
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


    $(".btn-send-password").click(function (){
        show_loading();
    });
});




