jQuery(document).ready(function($) {
// O arquivo reconhecido pelo tema é o minificado agatha-script.min.js

// Voltar ao Topo
$(function() { $(window).scroll(function() {
	if($(this).scrollTop() != 80) { $('#toTop').fadeIn();
} else {
  $('#toTop').fadeOut();
} });
$('#toTop').click(function() { $('body,html').animate({scrollTop:0},800); });
});


// FIM DA FUNÇÃO READY DOCUMENT
});