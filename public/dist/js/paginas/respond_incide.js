var table = '';

$(document).ready(function () {
    cargar_respuestas();
});

function abrir_modal() {
    limpiar();
    $('#lbltitulo').text('Nueva Respuesta');
    $('#btnregistrar').removeClass('d-none');
    $('#btneditar').addClass('d-none');
    $('#mdlresponder').modal('show');
}

function abrir_modal_reporte() {
    $('#mdlreporte').modal('show');
}

function limpiar() {
    $('#txtid').val('');
    $('#txtreclamo').val('');
    $('#txtencargado').val('');
    $('#txtempresa').val('');
    $('#txtrespuesta').val('');
    $('#txtfecharespuesta').val('');
    $('#cmbestado').val('ACTIVO');
}

function cargar_respuestas() {
    const url = URL_PY + 'datatables/dtrespuestas';    
    table = $('#tblrespuestas').DataTable({
        "destroy": true,
        "language": Español,
        "autoWidth": true,
        "responsive": true,
        "ajax": {
            'method': 'GET',
            'url': url,
            'dataSrc': function (json) {
                return json.data; 
            }
        },
        "columns": [
            {"data": "idrespuestas", "visible": false},
            {"data": "idreclamos"},
            {"data": "idpersonal"},
            {"data": "idempresa"},
            {"data": "respuesta"},
            {"data": "fecha_respuesta"},
            {"data": "estado"},
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    return `<button class="btn btn-2 btn-warning btn-pill w-80" onclick="mostrarDatos(${data.idrespuestas})">
                                <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;EDITAR 
                            </button>`;
                }
            }
        ]
    });  
}

function mostrarDatos(cod) {
    var parametros = 'cod=' + cod;
    const url = URL_PY + 'devdat/respuestas';  
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            $('#txtid').val(cod);
            $('#txtreclamo').val(response[0].idreclamos);
            $('#txtencargado').val(response[0].idpersonal);
            $('#txtempresa').val(response[0].idempresa);
            $('#txtrespuesta').val(response[0].respuesta);
            $('#txtfecharespuesta').val(response[0].fecha_respuesta);
            $('#cmbestado').val(response[0].estado);
            $('#btnregistrar').addClass('d-none');
            $('#btneditar').removeClass('d-none');
            $('#lbltitulo').text('Editar Respuesta');
            $('#mdlresponder').modal('show');
        }
    });
}

function registrar() {
    var parametros = 'idreclamos=' + $('#txtreclamo').val() +
                    '&idpersonal=' + $('#txtencargado').val() +
                    '&idempresa=' + $('#txtempresa').val() +
                    '&respuesta=' + $('#txtrespuesta').val() +
                    '&fecha_respuesta=' + $('#txtfecharespuesta').val() +
                    '&estado=' + $('#cmbestado').val();
    
    $.ajax({
        type: "POST",
        url: URL_PY + 'respuestas/registrar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'REGISTRO DE RESPUESTA',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTRO DE RESPUESTA',
                    text: response.message,            
                }).then(function() {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlresponder').modal('hide');
                });     
            }
        }
    });
}

function editar() {
    var parametros = 'idreclamos=' + $('#txtreclamo').val() +
                    '&idpersonal=' + $('#txtencargado').val() +
                    '&idempresa=' + $('#txtempresa').val() +
                    '&respuesta=' + $('#txtrespuesta').val() +
                    '&fecha_respuesta=' + $('#txtfecharespuesta').val() +
                    '&estado=' + $('#cmbestado').val() +
                    '&cod=' + $('#txtid').val();
    
    $.ajax({
        type: "POST",
        url: URL_PY + 'respuestas/editar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'EDICIÓN DE RESPUESTA',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'EDICIÓN DE RESPUESTA',
                    text: response.message,            
                }).then(function() {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlresponder').modal('hide');
                });     
            }
        }
    });
}

function ver_reportes_por_fecha() {
    var fini = $('#dtpfechainicio').val();
    var ffin = $('#dtpfin').val();
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = URL_PY + 'report/rptrespuestas';
    form.target = '_blank';

    const inputInicio = document.createElement('input');
    inputInicio.type = 'hidden';
    inputInicio.name = 'i';
    inputInicio.value = fini;
    form.appendChild(inputInicio);

    const inputFin = document.createElement('input');
    inputFin.type = 'hidden';
    inputFin.name = 'f';
    inputFin.value = ffin;
    form.appendChild(inputFin);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}