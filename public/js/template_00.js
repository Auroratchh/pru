
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


$(document).ready(function (){
    $('#preloader').fadeOut('normall', function() {});
});


function show_loading(){
    $("#preloader").fadeIn('slow');

}

function hide_loading(){
    $("#preloader").fadeOut('slow');
}

