var table = '';
let terminoActual = "";
let filaSeleccionada = null; 
let pagina = 1;

$(document).ready(function () {
    cargar_incidencias();
    $("#buscador").keyup(function() {
        terminoActual = $(this).val();
        pagina = 1; // Reiniciar la paginación
        buscarClientes(true);
    });

    $("#cargarMas").click(function() {
        pagina++; // Aumentar la página
        buscarClientes(false);
    });
});

function abrir_modal() {
    limpiar();
    $('#lbltitulo').text('Nueva Incidencia');
    $('#btnregistrar').removeClass('d-none');
    $('#btneditar').addClass('d-none');
    $('#mdlincidencias').modal('show');

}

function abrir_modal_reporte() {
    $('#mdlreporte').modal('show');
}

function limpiar() {
    $('#txtid').val('');
    $('#txtidcli').val('');
    $('#txtnomcliente').val('');
    $('#txtdescripcion').val('');
    $('#txtfecha').val('');
    $('#cmbestado').val('PENDIENTE');
}

function cargar_incidencias() {
    const url = URL_PY + 'datatables/dtincideconsul';
    table = $('#tblincidencias').DataTable({
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
            { "data": "idreclamos", "visible": false },
            { "data": "nombre_cliente" },
            { "data": "descripcion" },
            { "data": "fecha_reclamo" },
            { "data": "estado" },
            {
                "data": null,
                "orderable": false,
                "render": function (data, type, row) {
                    return `<button class="btn btn-2 btn-warning btn-pill w-80" onclick="mostrarDatos(${data.idreclamos})">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-2 btn-info btn-pill w-80" onclick="generarReporteIndividual(${data.idreclamos})">
                                <i class="fas fa-file-pdf"></i>
                            </button>`;
                }
            }
        ]
    });
}

function mostrarDatos(cod) {
    var parametros = 'cod=' + cod;
    const url = URL_PY + 'devdat/incideconsul';
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) { 
            $('#txtid').val(cod);
            $('#btnregistrar').addClass('d-none');
            $('#btneditar').removeClass('d-none');
            $('#txtidcli').val(response[0].idclientes);
            $('#txtnomcliente').val(response[0].documento + '-' + response[0].nombre);
            $('#txtdescripcion').val(response[0].descripcion);
            $('#txtfecha').val(response[0].fecha_reclamo);
            $('#cmbestado').val(response[0].estado);
        } 
    });
    $('#lbltitulo').text('Editar Incidencia');
    $('#mdlincidencias').modal('show');
}

function registrar() {
    var parametros = 'idclientes=' + $('#txtidcli').val() +
        '&descripcion=' + $('#txtdescripcion').val() +
        '&fecha_reclamo=' + $('#txtfecha').val() +
        '&estado=' + $('#cmbestado').val();

    $.ajax({
        type: "POST",
        url: URL_PY + 'incidencias/registrar',
        data: parametros,
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'REGISTRO DE INCIDENCIA',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTRO DE INCIDENCIA',
                    text: response.message,
                }).then(function () {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlincidencias').modal('hide');
                });
            }
        }
    });
}

function editar() {
    var parametros = 'idclientes=' + $('#txtidcli').val() +
        '&descripcion=' + $('#txtdescripcion').val() +
        '&fecha_reclamo=' + $('#txtfecha').val() +
        '&estado=' + $('#cmbestado').val() +
        '&cod=' + $('#txtid').val();

    $.ajax({
        type: "POST",
        url: URL_PY + 'incidencias/editar',
        data: parametros,
        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: 'EDICIÓN DE INCIDENCIA',
                    text: response.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'EDICIÓN DE INCIDENCIA',
                    text: response.message,
                }).then(function () {
                    table.ajax.reload();
                    limpiar();
                    $('#mdlincidencias').modal('hide');
                });
            }
        }
    });
}

function ver_reportes_por_fecha() {
    // Crear un formulario temporal
    var fini = $('#dtpfechainicio').val();
    var ffin = $('#dtpfin').val();
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = URL_PY + 'report/rtpincide';
    form.target = '_blank'; // Abrir en una nueva ventana

    // Crear campos de formulario para los datos
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

    // Agregar el formulario al documento y enviarlo
    document.body.appendChild(form);
    form.submit();

    // Eliminar el formulario después de enviarlo
    document.body.removeChild(form);
}

function generarReporteIndividual(cod) {
    // Crear un formulario temporal
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = URL_PY + 'report/rtpincideindividual';
    form.target = '_blank'; // Abrir en una nueva ventana

    // Crear campo para el código
    const inputCod = document.createElement('input');
    inputCod.type = 'hidden';
    inputCod.name = 'cod';
    inputCod.value = cod;
    form.appendChild(inputCod);

    // Agregar el formulario al documento y enviarlo
    document.body.appendChild(form);
    form.submit();

    // Eliminar el formulario después de enviarlo
    document.body.removeChild(form);
}

function elegir_cliente() {
    filaSeleccionada = $(this).closest("tr");
    $('#buscador').val('');
    $('#resultados').html('');
    let totalPaginas=0;
    $("#cargarMas").toggle(pagina < totalPaginas);
    $('#mdlelcliente').modal('show');
}

function buscarClientes(limpiar) {
    if (terminoActual.length >= 1) {
        $.ajax({
            url: URL_PY + "incidencias/busc_clientes",
            method: "GET",
            data: { q: terminoActual, page: pagina },
            dataType: "json",
            success: function(data) {
                if (limpiar) $("#resultados").html(""); // Limpiar resultados si es una nueva búsqueda
                
                $.each(data.clientes, function(index, clientes) {
                    $("#resultados").append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>${clientes.nombre}</strong> <br> <small class="text-muted">DOCUMENTO: ${clientes.documento}</small></span>
                            <button class="btn btn-6 btn-success active btn-pill w-10 elegir-clientes" 
                                data-id="${clientes.idclientes}" 
                                data-documento="${clientes.documento}"
                                data-nombre="${clientes.nombre}">
                                <i class="fas fa-check"></i>&nbsp;ELEGIR
                            </button>
                        </li>
                    `);
                });

                let totalPaginas = Math.ceil(data.total / data.limite);
                $("#cargarMas").toggle(pagina < totalPaginas);
            },
            error: function(xhr, status, error) {
                console.error("Error en la búsqueda:", error);
                console.log("Status:", status);
                console.log("Response:", xhr.responseText);
            }
        });
    }
}

$(document).on("click", ".elegir-clientes", function() {
    let idclientes = $(this).data("id");
    let nombreClientes = $(this).data("nombre"); 
    let documentoClientes = $(this).data("documento"); 
    $("#txtidcli").val(idclientes);
    $("#txtnomcliente").val(documentoClientes+'-'+nombreClientes);
    $("#mdlelcliente").modal('hide');   
});