$(document).ready(function () {
    const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    $('.mostrar_dependencias').on( "click", function() {
        const data_id = $(this).attr('data_id');
        const data_url = $(this).attr('data_url');
        $.ajax({
            url: data_url,
            type: 'GET',
            success: function(respuesta) {
                var respuesta_html = "";
                respuesta_html+='<ol class="list-group list-group-numbered">';
                $.each(respuesta.dependencias, function(index, item) {
                    respuesta_html+='<li class="list-group-item">'+item.area+'</li>';
                });
                respuesta_html+='</ol>';
                $('.modal-body').html(respuesta_html);
            },
            error: function() {

            }
        });
        myModal.show();
      });
      $('.boton_cerrar_modal').on("click",function(){
        myModal.toggle();
      });
});
