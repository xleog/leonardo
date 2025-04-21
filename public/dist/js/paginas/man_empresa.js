var table = '';

$(document).ready(function () {
    cargar_empresa();
});

function abrir_modal() {
    limpiar();
    $('#lbltitulo').text('Nueva Empresa');
    $('#btnregistrar').removeClass('d-none');
    $('#btneditar').addClass('d-none');
    $('#mdlempresa').modal('show');
}

function limpiar() {
    $('#txtid').val('');
    $('#txtdescripcion').val('');
    $('#txtdireccion').val('');
    $('#txtruc').val('');
    $('#cmbestado').val('ACTIVO');
}

function cargar_empresa() {
    const url = URL_PY + 'datatables/dtempresa';    
    table = $('#tblempresa').DataTable({
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
            {"data": "idempresa", "visible": false},
            {"data": "ruc"},
            {"data": "estado"},
            {"data": "direccion"},
            {"data": "descripcion"},
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    return `<button class="btn btn-2 btn-warning btn-pill w-80" onclick="mostrarDatos(${data.idempresa})">
                                <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;EDITAR 
                            </button>`;
                }
            }
        ]
    });  
}

function mostrarDatos(cod) {
    var parametros = 'cod=' + cod;
    const url = URL_PY + 'devdat/empresas';  
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            $('#txtid').val(cod);
            $('#txtdescripcion').val(response[0].descripcion);
            $('#txtdireccion').val(response[0].direccion);
            $('#txtruc').val(response[0].ruc);
            $('#cmbestado').val(response[0].estado);
            $('#btnregistrar').addClass('d-none');
            $('#btneditar').removeClass('d-none');

        }
    });
    $('#lbltitulo').text('Editar Empresa');
    $('#mdlempresa').modal('show');
}

function registrar() {
    var parametros = 'descripcion=' + $('#txtdescripcion').val() +
                    '&direccion=' + $('#txtdireccion').val() +
                    '&ruc=' + $('#txtruc').val() +
                    '&estado=' + $('#cmbestado').val();
    
    $.ajax({
        type: "POST",
        url: URL_PY + 'empresa/registrar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'REGISTRO DE EMPRESA',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTRO DE EMPRESA',
                    text: response.message,            
                }).then(function() {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlempresa').modal('hide');
                });     
            }
        }
    });
}

function editar() {
    var parametros = 'descripcion=' + $('#txtdescripcion').val() +
                    '&direccion=' + $('#txtdireccion').val() +
                    '&ruc=' + $('#txtruc').val() +
                    '&estado=' + $('#cmbestado').val() +
                    '&cod=' + $('#txtid').val();
    
    $.ajax({
        type: "POST",
        url: URL_PY + 'empresa/editar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'EDICIÓN DE EMPRESA',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'EDICIÓN DE EMPRESA',
                    text: response.message,            
                }).then(function() {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlempresa').modal('hide');
                });     
            }
        }
    });
}

function sunat(){
    $.ajaxblock();
    var parametros='ruc='+$('#txtruc').val();
   $.ajax({
    type: "GET",
    url:  URL_PY + 'empresa/sunat',
    data:parametros,
    success: function (response) {
        //console.log(response);
        $.ajaxunblock();
        $('#txtdescripcion').val(response.nombre_o_razon_social);
        $('#txtdireccion').val(response.direccion_completa);

    }
   });
}