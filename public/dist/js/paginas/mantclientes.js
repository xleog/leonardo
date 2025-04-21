var table = "";

$(document).ready(function () {
    cargar_clientes();

    // Evento para cuando cambia el departamento
    $('#cmbdepartamento').change(function() {
        traer_provincias();
    });

    // Evento para cuando cambia la provincia
    $('#cmbprovincia').change(function() {
        traer_distritos();
    });

    // Evento para cuando cambia el distrito
    $('#cmbdistrito').change(function() {
        traer_ubigeo();
    });

    // Cargar datos iniciales
    traer_provincias();
});
function abrir_modal() {
    limpiar();
    $('#lbltitulo').html('Nuevo Cliente');
    $('#btnregistrar').removeClass('d-none');
    $('#btneditar').addClass('d-none');
    $('#mdl_clientes').modal('show');
    $('#tblemailclientes').closest('.col-lg-12').show();
}

function limpiar() {
    $('#txtdocumento').val('');
    $('#txtnombre').val('');
    $('#cmbestado').val('ACTIVO');
    $('#dtpfecha').val('');
    $('#cmbnacionalidad').val('PERUANA');
    $('#txtdireccion').val('');
    $('#txtemail_cliente').val();
}

function cargar_clientes() 
{
    const url = URL_PY + 'datatables/dtclientes';    
    table = $('#tblclientes').DataTable({
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
            {"data": "idclientes", "visible": false},
            {"data": "documento"},           
            {"data": "nombre"},
            {"data": "direccion"},
            {"data": "fecha_nac"},
            {"data": "nacionalidad"},
            {"data": "estado"},

           
            {
                "data": null,
                "orderable": false, // Deshabilitar el ordenamiento en esta columna
                "render": function(data, type, row) {
                    return `<button class="btn btn-2 btn-warning btn-pill w-80" onclick="mostrarDatos(${data.idclientes})">
                                <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;EDITAR 
                            </button>`;
                }
            }
        ]
    });  
}

function mostrarDatos(cod) {
    var parametros='cod='+cod;
    const url = URL_PY + 'devdat/clientes';  
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            $('#txtid').val(cod);
            $('#btnregistrar').addClass('d-none');
            $('#btneditar').removeClass('d-none');
            $('#txtdocumento').val(response[0].documento);
            $('#txtnombre').val(response[0].nombre);
            $('#cmbestado').val(response[0].estado);
            $('#dtpfecha').val(response[0].fecha_nac);
            $('#cmbnacionalidad').val(response[0].nacionalidad);
            $('#txtdireccion').val(response[0].direccion);
            $('#tblemailclientes').closest('.col-lg-12').hide();
        }
    });
    $('#lbltitulo').html('Editar Cliente');
    $('#mdl_clientes').modal('show');
}

/*function registrar() {
    var parametros='nombre='+$('#txtnombre').val()+
            '&documento='+$('#txtdocumento').val()+
            '&direccion='+$('#txtdireccion').val()+
            '&fecha_nac='+$('#dtpfecha').val()+
            '&nacionalidad='+$('#cmbnacionalidad').val()+
            '&tipo_cliente='+$('#cmbtipocliente').val()+
            '&estado='+$('#cmbestado').val();
    $.ajax({
        type: "POST",
        url: URL_PY + 'clientes/registrar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                      icon: "error",
                      title: 'REGISTRO DE CLIENTES',
                      text: response.error
                });
               
            }
            else
            {
                Swal.fire({
                    icon: 'success',
                    title: 'REGISTRO DE CLIENTES',
                    text: response.message,            
                    }).then(function() {
                      var paginaActual = table.page.info().page;
                      table.ajax.reload();
                      setTimeout(function () {
                          table.page(paginaActual).draw('page');
                      }, 800);                          
                     limpiar();
                     $('#mdl_clientes').modal('hide');
            });     
            }
        }
    });
}*/

function editar() {
    var parametros='nombre='+$('#txtnombre').val()+
            '&documento='+$('#txtdocumento').val()+
            '&direccion='+$('#txtdireccion').val()+
            '&fecha_nac='+$('#dtpfecha').val()+
            '&nacionalidad='+$('#cmbnacionalidad').val()+
            '&tipo_cliente='+$('#cmbtipocliente').val()+
            '&estado='+$('#cmbestado').val()+
            '&cod='+$('#txtid').val();
    $.ajax({
        type: "POST",
        url: URL_PY + 'clientes/editar',
        data: parametros,        
        success: function (response) {
            if (response.error) {
                Swal.fire({
                      icon: "error",
                      title: 'EDICIÓN DE CLIENTES',
                      text: response.error
                });
               
            }
            else
            {
                Swal.fire({
                    icon: 'success',
                    title: 'EDICIÓN DE CLIENTES',
                    text: response.message,            
                    }).then(function() {
                      var paginaActual = table.page.info().page;
                      table.ajax.reload();
                      setTimeout(function () {
                          table.page(paginaActual).draw('page');
                      }, 800);                          
                     limpiar();
                     $('#mdl_clientes').modal('hide');
            });     
            }
        }
    });
}

function agregar_fila() {
    var fila='<tr>'+
    '<td>'+
        '<input type="text" class="form-control email_cliente" id="txtemail_cliente" name="txtemail_cliente" placeholder="Email">'+
    '</td>'+
    '<td>'+
        '<button class="btn btn-success" id="btnemailcliente" name="btnemailcliente" type="button" onclick="agregar_fila()">'+
            '<i class="fa-solid fa-plus"></i>'+
        '</button>'+
    '</td>'+
'</tr>';
$("#tblemailclientes").append(fila);
}

function registrar_emailclientes() {
    var filas=[];
    $("#tblemailclientes tbody tr").each(function(){
        var email=$(this).find('.emails').val();
        var fila={email};
        filas.push(fila);
    });
    var parametros='nombre='+$('#txtnombre').val()+
            '&documento='+$('#txtdocumento').val()+
            '&direccion='+$('#txtdireccion').val()+
            '&fecha_nac='+$('#dtpfecha').val()+
            '&nacionalidad='+$('#cmbnacionalidad').val()+
            '&tipo_cliente='+$('#cmbtipocliente').val()+
            '&estado='+$('#cmbestado').val()+
            '&email='+$('#txtemail_cliente').val()+
            '&cod='+$('#txtid').val();


    'emails='+JSON.stringify(filas);
    console.log(parametros);
}

function traer_provincias() {
    var departamento = $('#cmbdepartamento').val();
    var parametros = 'dep=' + departamento;
    const url = URL_PY + 'clientes/cmbprovincia';   
    
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            //console.log(response);
            var provincias = response[0];
            
            // Limpiar y actualizar provincias
            $('#cmbprovincia').empty();
            if (Array.isArray(provincias)) {
                provincias.forEach(function (provincia) {
                    $('#cmbprovincia').append('<option value="' + provincia.provincia + '">' + provincia.provincia + '</option>');
                });
                
                // Limpiar distritos y ubigeo al cambiar departamento
                $('#cmbdistrito').empty();
                $('#txtubigeo').val('');
                
                // Forzar la actualización de distritos si hay provincias
                if(provincias.length > 0) {
                    traer_distritos();
                }
            }
        }
    });
}

function traer_distritos(){
    var provincia = $('#cmbprovincia').val();
    
    if(!provincia) {
        $('#cmbdistrito').empty();
        $('#txtubigeo').val('');
        return;
    }
    
    var parametros = 'prov=' + provincia;
    const url = URL_PY + 'clientes/cmbdistrito';
    
    $.ajax({
        type: "GET",
        url: url,
        data: parametros,
        success: function (response) {
            //console.log(response);
            var distritos = response[0];
            
            // Limpiar y actualizar distritos
            $('#cmbdistrito').empty();
            if (Array.isArray(distritos)) {
                distritos.forEach(function (distrito) {
                    $('#cmbdistrito').append('<option value="' + distrito.codigo_ubigeo + '">' + distrito.distrito + '</option>');
                });
                
                // Actualizar ubigeo si hay distritos
                if(distritos.length > 0) {
                    traer_ubigeo();
                } else {
                    $('#txtubigeo').val('');
                }
            }
        }
    });
}

function traer_ubigeo() {
    var codigo = $('#cmbdistrito').val();
    $('#txtubigeo').val(codigo);
}

