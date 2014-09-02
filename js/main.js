//Animación Aside//
$("#open_close_aside").click(function(){
	$("aside").toggleClass("asede_close");
	$("article").toggleClass("article_full");
});
//Tabs jQuery UI//
$(function() {
	$( "#tabs" ).tabs();
});
//Click Upload Foto//
$('#open_upload_avatar').click(function(){
   $('#upload_avatar').trigger('click');
});
//Animación Avatar//
$('#open_upload_avatar').hover(function(){
   $('.icon_upload').toggleClass('icon_upload_on');
});
//Datepicker jQuery UI//
$( "#fechnac" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: '1920:2000',
    dateFormat: 'yy-mm-dd',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
});
//Fecha Actual Footer//
var ano = (new Date).getFullYear();
$(".ano_current").text( ano );
//API Goolge Maps//
var input = document.getElementById('searchTextField');
new google.maps.places.Autocomplete(input);