var table = '';
$(document).ready(function () {
    carga_usuarios();
});
function abrir_modal() {
    limpiar();
    $('#lbltitulo').text('Nuevo Usuario');  // Establecer el título correctamente
    $('#btnregistrar').removeClass('d-none');
    $('#btneditar').addClass('d-none');
    $('#mdlusuarios').modal('show'); // Asegurar que el modal se muestra
}

function limpiar() {
    $('#txtusuario').val('');
    $('#cmbestado').val('ACTIVO');
    $('#txtclave').val('');
    $('#txtperfil').val('');
    $('#txtid').val('');

}

function carga_usuarios() {
    const url = URL_PY + 'datatables/dtusuarios';
    table = $('#tblusuarios').DataTable({
        "destroy": true,
        "language": Español,
        "autoWidth": true,
        "responsive": true,
        "ajax": {
            'method': 'GET',
            'url': url,
            'dataSrc': function (json) {
                //console.log(json); // Verifica que los datos sean correctos
                return json.data;
            }
        },
        "columns": [
            { "data": "idusuarios" },
            { "data": "usuario" },
            { "data": "clave" },
            { "data": "estado" },
            { "data": "perfil" },
            { "data": "idpersonal" },
            {
                "data": null,
                "orderable": false, // Deshabilitar el ordenamiento en esta columna
                "render": function (data, type, row) {
                    return `<button class="btn btn-2 btn-warning btn-pill w-70" onclick="mostrarDatos(${data.idusuarios})">
                                <i class="fas fa-pencil-alt"></i> 
                            </button>`;
                }
            }
        ]
    });

}

function mostrarDatos(cod) {
    var parametros = 'cod=' + cod;
    const url = URL_PY + 'devdat/usuarios';
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            //console.log(response);
            $('#txtcod').val(cod);
            $('#btnregistrar').addClass('d-none');
            $('#btneditar').removeClass('d-none');
            $('#txtusuario').val(response.usuario);
            $('#cmbestado').val(response.estado);
            $('#txtclave').val(response.clave);
            $('#txtperfil').val(response.perfil);
            $('#txtid').val(response.idusuarios);
            $('#txtidpersonal').val(response.idpersonal);

        }
    });
    $('#lbltitulo').text('Editar Usuario');
    $('#mdlusuarios').modal('show');

}

function registrar() {
    var usuario = $('#txtusuario').val().trim();
    if (usuario === '') {
        Swal.fire({
            icon: "error",
            title: 'REGISTRO DE USUARIOS',
            text: 'El campo Usuario es obligatorio'
        });
        return;
    }

    var parametros = 'usuario=' + usuario +
        '&idusuarios=' + $('#txtid').val() +
        '&estado=' + $('#cmbestado').val() +
        '&clave=' + $('#txtclave').val() +
        '&perfil=' + $('#txtperfil').val();

    $.ajax({
        type: "POST",
        url: URL_PY + 'usuarios/registrar',
        data: parametros,
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'REGISTRO DE USUARIOS',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTRO DE USUARIOS',
                    text: response.message,
                }).then(function () {
                    var paginaActual = table.page.info().page;
                    table.ajax.reload();
                    setTimeout(function () {
                        table.page(paginaActual).draw('page');
                    }, 800);
                    limpiar();
                    $('#mdlusuarios').modal('hide');
                });
            }
        }
    });
}


function editar() {
    var parametros = 'usuario=' + $('#txtusuario').val() +
        '&estado=' + $('#cmbestado').val() +
        '&clave=' + $('#txtclave').val() +
        '&fecha_nac=' + $('#dtpfecha').val() +
        '&perfil=' + $('#txtperfil').val() +
        $.ajax({
            type: "POST",
            url: URL_PY + 'usuarios/editar',
            data: parametros,
            success: function (response) {
                if (response.error) {
                    Swal.fire({
                        icon: "error",
                        title: 'EDICIÓN DE USUARIOS',
                        text: response.error
                    });

                }
                else {
                    Swal.fire({
                        icon: 'success',
                        title: 'EDICIÓN DE USUARIOS',
                        text: response.message,
                    }).then(function () {
                        var paginaActual = table.page.info().page;
                        table.ajax.reload();
                        setTimeout(function () {
                            table.page(paginaActual).draw('page');
                        }, 800);
                        limpiar();
                        $('#mdlusuarios').modal('hide');
                    });
                }
            }
        });
}