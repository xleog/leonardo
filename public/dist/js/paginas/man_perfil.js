var table = '';

$(document).ready(function () {
    cargar_perfil();
});

function abrir_modal() {
    limpiar();
    $('#lbltitulo').text('Nuevo Perfil');
    $('#btnregistrar').removeClass('d-none');
    $('#btneditar').addClass('d-none');
    $('#mdlperfil').modal('show');
}



function limpiar() {
    $('#txtid').val('');
    $('#txtdescripcion').val('');
    $('#cmbestado').val('ACTIVO');
}

function cargar_perfil() {
    const url = URL_PY + 'datatables/dtperfil';    
    table = $('#tblperfil').DataTable({
        "destroy": true,
        "language": Español,
        "autoWidth": true,
        "responsive": true,
        "ajax": {
            'method': 'GET',
            'url': url,
            'dataSrc': function (json) {
                //console.log(json);
                return json.data; 
            }
        },
        "columns": [
           
            {"data": "idperfil", "visible": false},
            {"data": "descripcion"},
            {"data": "estado"},
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    return `<button class="btn btn-2 btn-warning btn-pill w-80" onclick="mostrarDatos(${data.idperfil})">
                                <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;EDITAR 
                            </button>`;
                }
            }
        ]
    });  
}

function mostrarDatos(cod) {
    var parametros = 'cod=' + cod;
    const url = URL_PY + 'devdat/perfiles';  
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            $('#txtid').val(cod);
            $('#txtdescripcion').val(response[0].descripcion);
            $('#cmbestado').val(response[0].estado);
            $('#btnregistrar').addClass('d-none');
            $('#btneditar').removeClass('d-none');
            
        }
    });
    $('#lbltitulo').text('Editar Perfil');
    $('#mdlperfil').modal('show');
}

function registrar() {
    var parametros = 'descripcion=' + $('#txtdescripcion').val() +
                    '&estado=' + $('#cmbestado').val();
    
    $.ajax({
        type: "POST",
        url: URL_PY + 'perfil/registrar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'REGISTRO DE PERFIL',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTRO DE PERFIL',
                    text: response.message,            
                }).then(function() {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlperfil').modal('hide');
                });     
            }
        }
    });
}

function editar() {
    var parametros = 'descripcion=' + $('#txtdescripcion').val() +
                    '&estado=' + $('#cmbestado').val() +
                    '&cod=' + $('#txtid').val();
    
    $.ajax({
        type: "POST",
        url: URL_PY + 'perfil/editar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'EDICIÓN DE PERFIL',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'EDICIÓN DE PERFIL',
                    text: response.message,            
                }).then(function() {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlperfil').modal('hide');
                });     
            }
        }
    });
}