jQuery(document).ready(function($) {
// Voltar ao Topo
$(function() { $(window).scroll(function() {
    if($(this).scrollTop() > 50) {
        $('div#wp-content-editor-tools, div#mceu_28').addClass('efect');
} else {
  $('div#wp-content-editor-tools, div#mceu_28').removeClass('efect');
}
});

});


// FIM DA FUNÇÃO READY DOCUMENT
});